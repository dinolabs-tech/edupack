<?php
include('db_connection.php');
include('components/fees_management.php');

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'get_payment_history':
            if (isset($_GET['student_id'])) {
                $student_id = $_GET['student_id'];
                $payment_history = getStudentPaymentHistory($conn, $student_id);
                echo json_encode($payment_history);
            } else {
                echo json_encode(["error" => "Student ID is required."]);
            }
            break;
        case 'get_payment_history_by_date_range':
            if (isset($_GET['student_id']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
                $student_id = $_GET['student_id'];
                $start_date = $_GET['start_date'];
                $end_date = $_GET['end_date'];
                $payment_history = getStudentPaymentHistoryByDateRange($conn, $student_id, $start_date, $end_date);
                echo json_encode($payment_history);
            } else {
                echo json_encode(["error" => "Student ID, start date, and end date are required."]);
            }
            break;
        default:
            echo json_encode(["error" => "Invalid action."]);
            break;
    }
} else {
    echo json_encode(["error" => "No action specified."]);
}
?>
