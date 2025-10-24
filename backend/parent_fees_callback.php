<?php
include('db_connection.php');
include('components/fees_management.php'); // For recordStudentPayment
include('includes/config.php'); // Include the config file

// Ensure the constants are defined
if (!defined('FLUTTERWAVE_PUBLIC_KEY') || !defined('FLUTTERWAVE_SECRET_KEY')) {
    die("Flutterwave API keys are not defined in config.php");
}

$message = "";
$error = "";
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (isset($_GET['status']) && $_GET['status'] == 'successful') {
    $tx_ref = $_GET['tx_ref'];
    $transaction_id_fw = $_GET['transaction_id'];

    $payment_details_json = isset($_GET['payment_details']) ? base64_decode($_GET['payment_details']) : '';
    $payment_details = json_decode($payment_details_json, true);

    // Server-side verification of Flutterwave transaction
    $curl = curl_init();
    $url = "https://api.flutterwave.com/v3/transactions/{$transaction_id_fw}/verify";

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer " . FLUTTERWAVE_SECRET_KEY
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        $error = "cURL Error #:" . $err;
    } else {
        $flutterwave_response = json_decode($response, true);

        if ($flutterwave_response['status'] === 'success' && $flutterwave_response['data']['status'] === 'successful') {
            $verified_amount = $flutterwave_response['data']['amount'];
            $verified_currency = $flutterwave_response['data']['currency'];

            if ($payment_details && $payment_details['student_id'] == $student_id && $payment_details['tx_ref'] == $tx_ref && $verified_amount == $payment_details['amount'] && $verified_currency == "NGN" && $payment_details['type'] == 'fees') {
                $amount_paid = $payment_details['amount'];
                $payment_method = "Flutterwave";
                $recorded_by = "Parent"; // Recorded by parent
                $session_paid = $payment_details['session'];
                $term_paid = $payment_details['term'];

                // Get student details to find class and arm for fee_definition_id
                $student_stmt = $conn->prepare("SELECT class, arm FROM students WHERE id = ?");
                $student_stmt->bind_param("s", $student_id);
                $student_stmt->execute();
                $student_result = $student_stmt->get_result();
                $student_data = $student_result->fetch_assoc();
                $student_class = $student_data['class'];
                $student_arm = $student_data['arm'];

                // Dynamically find a fee_definition_id
                $general_fee_stmt = $conn->prepare("SELECT id FROM fee WHERE class = ? AND arm = ? AND term = ? AND session = ? LIMIT 1");
                $general_fee_stmt->bind_param("ssss", $student_class, $student_arm, $term_paid, $session_paid);
                $general_fee_stmt->execute();
                $general_fee_result = $general_fee_stmt->get_result();
                $general_fee_data = $general_fee_result->fetch_assoc();
                $fee_definition_id_to_save = $general_fee_data ? $general_fee_data['id'] : 'GENERAL-FEE';

                if (recordStudentPayment($conn, $student_id, $fee_definition_id_to_save, $amount_paid, $payment_method, $tx_ref, $recorded_by, $session_paid, $term_paid)) {
                    $message = "Payment of " . number_format($amount_paid, 2) . " recorded successfully! Transaction Ref: " . htmlspecialchars($tx_ref);
                    header("Location: parent_payment.php?status=successful&message=" . urlencode($message) . "&student_id=" . urlencode($student_id));
                    exit();
                } else {
                    $error = "Error saving payment details to database.";
                }
            } else {
                $error = "Fees payment verification failed: details mismatched or amount not matching.";
            }
        } else {
            $error = "Fees payment verification failed: Flutterwave status not successful.";
        }
    }
} elseif (isset($_GET['status']) && $_GET['status'] == 'cancelled') {
    $error = "Fees payment was cancelled by the user.";
} elseif (isset($_GET['status']) && $_GET['status'] == 'failed') {
    $error = "Fees payment failed. Please try again.";
}

// Redirect with error message if any
if ($error) {
    header("Location: parent_payment.php?status=failed&message=" . urlencode($error) . "&student_id=" . urlencode($student_id));
    exit();
}
?>
