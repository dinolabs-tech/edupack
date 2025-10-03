<?php
include('db_connection.php');

// Assume student_id is always passed for context
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (empty($student_id)) {
    // If student_id is missing, redirect to dashboard with an error
    header('Location: students.php?status=failed&message=' . urlencode("Student ID not provided for callback."));
    exit();
}

$message = "";
$status_type = "failed"; // Default status type

// Handle Flutterwave callback
if (isset($_GET['status']) && $_GET['status'] == 'successful') {
    $tx_ref = $_GET['tx_ref'];
    $transaction_id_fw = $_GET['transaction_id'];

    $payment_details_json = isset($_GET['payment_details']) ? base64_decode($_GET['payment_details']) : '';
    $payment_details = json_decode($payment_details_json, true);

    // Basic validation: check if payment_details are valid and match student_id and tx_ref
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
                // Record the transaction in fee_transactions for history/auditing,
                // using a specific fee_definition_id for tuckshop funds.
                // You might want a dedicated 'tuckshop_transactions' table or a specific 'fee_definition_id'
                // to differentiate from regular school fees. For now, we'll use a generic one.
                $fee_definition_id_to_save = 'TUCKSHOP-FUND'; // A unique identifier for tuckshop funding

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
                $payment_method = "Flutterwave (Tuckshop)";
                $recorded_by = "Student (Tuckshop)";
                $insert_transaction_stmt->bind_param("ssdsssss", $student_id, $fee_definition_id_to_save, $amount_funded, $payment_method, $tx_ref, $recorded_by, $current_session, $current_term);
                $insert_transaction_stmt->execute();

                $success_message = "Tuckshop account funded successfully with " . number_format($amount_funded, 2) . ". Transaction Ref: " . htmlspecialchars($tx_ref);
                $status_type = "successful";
            } else {
                $success_message = "Error updating tuckshop balance: " . $conn->error;
                $status_type = "failed";
            }
        }
    } else {
        $success_message = "Payment verification failed or details mismatched for tuckshop funding.";
        $status_type = "failed";
    }
} elseif (isset($_GET['status']) && $_GET['status'] == 'cancelled') {
    $success_message = "Tuckshop funding was cancelled by the user.";
    $status_type = "failed";
} elseif (isset($_GET['status']) && $_GET['status'] == 'failed') {
    $success_message = "Tuckshop funding failed. Please try again.";
    $status_type = "failed";
} else {
    $success_message = "Invalid payment status received.";
    $status_type = "failed";
}

// Redirect back to the student dashboard with a message
header('Location: students.php');
exit();
?>
