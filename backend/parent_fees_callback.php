<?php
include('db_connection.php'); // This file now directly establishes $conn and handles errors
include('components/fees_management.php'); // Contains recordStudentPayment

// $conn should be available after db_connection.php is included

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (empty($student_id)) {
    header('Location: parent_payment.php?status=failed&message=' . urlencode("Student ID not provided for fees callback."));
    exit();
}

$message = "";
$status_type = "failed";

// Handle Flutterwave callback
if (isset($_GET['status']) && $_GET['status'] == 'successful') {
    $tx_ref = $_GET['tx_ref'];
    $transaction_id_fw = $_GET['transaction_id'];

    $payment_details_json = isset($_GET['payment_details']) ? base64_decode($_GET['payment_details']) : '';
    $payment_details = json_decode($payment_details_json, true);

    if ($payment_details && $payment_details['student_id'] == $student_id && $payment_details['tx_ref'] == $tx_ref && $payment_details['type'] == 'fees') {
        $amount_paid = $payment_details['amount'];
        $payment_method = "Flutterwave (Parent Fees)";
        $recorded_by = "Parent";
        $session_paid = $payment_details['session'];
        $term_paid = $payment_details['term'];

        // Dynamically find a fee_definition_id
        // Assuming student_class and student_arm are available or can be fetched
        // For simplicity, we'll fetch student details again here.
        $student_stmt = $conn->prepare("SELECT class, arm FROM students WHERE id = ?");
        $student_stmt->bind_param("s", $student_id);
        $student_stmt->execute();
        $student_result = $student_stmt->get_result();
        $student_data = $student_result->fetch_assoc();
        $student_class = $student_data ? $student_data['class'] : 'N/A';
        $student_arm = $student_data ? $student_data['arm'] : 'N/A';

        $general_fee_stmt = $conn->prepare("SELECT id FROM fee WHERE class = ? AND arm = ? AND term = ? AND session = ? LIMIT 1");
        $general_fee_stmt->bind_param("ssss", $student_class, $student_arm, $term_paid, $session_paid);
        $general_fee_stmt->execute();
        $general_fee_result = $general_fee_stmt->get_result();
        $general_fee_data = $general_fee_result->fetch_assoc();
        $fee_definition_id_to_save = $general_fee_data ? $general_fee_data['id'] : 'GENERAL-FEE';

        if (recordStudentPayment($conn, $student_id, $fee_definition_id_to_save, $amount_paid, $payment_method, $tx_ref, $recorded_by, $session_paid, $term_paid)) {
            $message = "Fees payment of " . number_format($amount_paid, 2) . " recorded successfully! Transaction Ref: " . htmlspecialchars($tx_ref);
            $status_type = "successful";
        } else {
            $message = "Error saving fees payment details to database.";
            $status_type = "failed";
        }
    } else {
        $message = "Fees payment verification failed or details mismatched.";
        $status_type = "failed";
    }
} elseif (isset($_GET['status']) && $_GET['status'] == 'cancelled') {
    $message = "Fees payment was cancelled by the parent.";
    $status_type = "failed";
} elseif (isset($_GET['status']) && $_GET['status'] == 'failed') {
    $message = "Fees payment failed. Please try again.";
    $status_type = "failed";
} else {
    $message = "Invalid fees payment status received.";
    $status_type = "failed";
}

header('Location: parent_payment.php?student_id=' . urlencode($student_id) . '&status=' . urlencode($status_type) . '&message=' . urlencode($message));
exit();
// CloseCon($conn); // Removed as CloseCon is no longer defined in db_connection.php
?>
