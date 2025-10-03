<?php
include('db_connection.php'); // This file now directly establishes $conn and handles errors

// $conn should be available after db_connection.php is included

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (empty($student_id)) {
    header('Location: parent_payment.php?status=failed&message=' . urlencode("Student ID not provided for tuckshop callback."));
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

    if ($payment_details && $payment_details['student_id'] == $student_id && $payment_details['tx_ref'] == $tx_ref && $payment_details['type'] == 'tuckshop') {
        $amount_funded = (float)$payment_details['amount'];

        // Check if this transaction has already been processed to prevent double-crediting
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM fee_transactions WHERE transaction_ref = ?");
        $check_stmt->bind_param("s", $tx_ref);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result()->fetch_row()[0];

        if ($check_result > 0) {
            $message = "Tuckshop account already funded for this transaction reference.";
            $status_type = "failed";
        } else {
            // Update tuckshop balance in the 'tuck' table
            $update_stmt = $conn->prepare("UPDATE tuck SET vbalance = vbalance + ? WHERE regno = ?");
            $update_stmt->bind_param("ds", $amount_funded, $student_id);

            if ($update_stmt->execute()) {
                $fee_definition_id_to_save = 'PARENT-TUCKSHOP-FUND'; // Unique identifier for parent tuckshop funding

                // Get student name for recording
                $student_name_stmt = $conn->prepare("SELECT name FROM students WHERE id = ?");
                $student_name_stmt->bind_param("s", $student_id);
                $student_name_stmt->execute();
                $student_name_result = $student_name_stmt->get_result();
                $student_name_data = $student_name_result->fetch_assoc();
                $student_name = $student_name_data ? $student_name_data['name'] : 'Unknown Student';

                // Get current session and term for recording
                $current_session_data = $conn->query("SELECT csession FROM currentsession LIMIT 1")->fetch_assoc();
                $current_term_data = $conn->query("SELECT cterm FROM currentterm LIMIT 1")->fetch_assoc();
                $current_session = $current_session_data ? $current_session_data['csession'] : 'N/A';
                $current_term = $current_term_data ? $current_term_data['cterm'] : 'N/A';

                $insert_transaction_stmt = $conn->prepare("INSERT INTO fee_transactions (student_id, fee_definition_id, amount_paid, payment_method, transaction_ref, recorded_by, session, term) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $payment_method = "Flutterwave (Parent Tuckshop)";
                $recorded_by = "Parent (Tuckshop)";
                $insert_transaction_stmt->bind_param("ssdsssss", $student_id, $fee_definition_id_to_save, $amount_funded, $payment_method, $tx_ref, $recorded_by, $current_session, $current_term);
                $insert_transaction_stmt->execute();

                $message = "Tuckshop account funded successfully with " . number_format($amount_funded, 2) . ". Transaction Ref: " . htmlspecialchars($tx_ref);
                $status_type = "successful";
            } else {
                $message = "Error updating tuckshop balance: " . $conn->error;
                $status_type = "failed";
            }
        }
    } else {
        $message = "Tuckshop payment verification failed or details mismatched.";
        $status_type = "failed";
    }
} elseif (isset($_GET['status']) && $_GET['status'] == 'cancelled') {
    $message = "Tuckshop funding was cancelled by the parent.";
    $status_type = "failed";
} elseif (isset($_GET['status']) && $_GET['status'] == 'failed') {
    $message = "Tuckshop funding failed. Please try again.";
    $status_type = "failed";
} else {
    $message = "Invalid tuckshop payment status received.";
    $status_type = "failed";
}

header('Location: parent_payment.php?student_id=' . urlencode($student_id) . '&status=' . urlencode($status_type) . '&message=' . urlencode($message));
exit();
// CloseCon($conn); // Removed as CloseCon is no longer defined in db_connection.php
?>
