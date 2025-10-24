<?php
include('db_connection.php');
include('includes/config.php'); // Include the config file

// Ensure the constants are defined
if (!defined('FLUTTERWAVE_PUBLIC_KEY') || !defined('FLUTTERWAVE_SECRET_KEY')) {
    die("Flutterwave API keys are not defined in config.php");
}

$message = "";
$error = "";

if (isset($_GET['status']) && $_GET['status'] == 'successful') {
    $tx_ref = $_GET['tx_ref'];
    $transaction_id_fw = $_GET['transaction_id'];
    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

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

            if ($payment_details && $payment_details['student_id'] == $student_id && $payment_details['tx_ref'] == $tx_ref && $verified_amount == $payment_details['amount'] && $verified_currency == "NGN" && $payment_details['type'] == 'tuckshop') {
                $amount_funded = $payment_details['amount'];

                // Update tuckshop balance
                $update_tuck_stmt = $conn->prepare("UPDATE tuck SET vbalance = vbalance + ? WHERE regno = ?");
                $update_tuck_stmt->bind_param("ds", $amount_funded, $student_id);

                if ($update_tuck_stmt->execute()) {
                    // Record the transaction in tuckshop_transactions
                    $insert_transaction_stmt = $conn->prepare("INSERT INTO tuckshop_transactions (student_id, amount, transaction_type, transaction_ref, transaction_id_fw, date) VALUES (?, ?, 'fund', ?, ?, NOW())");
                    $insert_transaction_stmt->bind_param("sdss", $student_id, $amount_funded, $tx_ref, $transaction_id_fw);
                    $insert_transaction_stmt->execute();
                    $insert_transaction_stmt->close();

                    $message = "Tuckshop account funded with " . number_format($amount_funded, 2) . " successfully! Transaction Ref: " . htmlspecialchars($tx_ref);
                    header("Location: students.php?status=successful&message=" . urlencode($message));
                    exit();
                } else {
                    $error = "Error updating tuckshop balance.";
                }
                $update_tuck_stmt->close();
            } else {
                $error = "Tuckshop funding verification failed: details mismatched or amount not matching.";
            }
        } else {
            $error = "Tuckshop funding verification failed: Flutterwave status not successful.";
        }
    }
} elseif (isset($_GET['status']) && $_GET['status'] == 'cancelled') {
    $error = "Tuckshop funding was cancelled by the user.";
} elseif (isset($_GET['status']) && $_GET['status'] == 'failed') {
    $error = "Tuckshop funding failed. Please try again.";
}

// Redirect with error message if any
if ($error) {
    header("Location: students.php?status=failed&message=" . urlencode($error));
    exit();
}
?>
