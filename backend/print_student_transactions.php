<?php
include('db_connection.php');
include('components/fees_management.php');

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$session = isset($_GET['session']) ? $_GET['session'] : '';
$term = isset($_GET['term']) ? $_GET['term'] : '';

$student_name = "N/A";
$transactions = [];

if ($student_id) {
    // Get student name
    $student_stmt = $conn->prepare("SELECT name FROM students WHERE id = ?");
    $student_stmt->bind_param("s", $student_id);
    $student_stmt->execute();
    $student_result = $student_stmt->get_result();
    if ($student_data = $student_result->fetch_assoc()) {
        $student_name = $student_data['name'];
    }

    if ($start_date && $end_date) {
        // Fetch transactions by date range
        $transactions = getStudentPaymentHistoryByDateRange($conn, $student_id, $start_date, $end_date);
        $report_title = "Transaction History for " . htmlspecialchars($student_name) . " (" . htmlspecialchars($start_date) . " to " . htmlspecialchars($end_date) . ")";
    } else {
        // Fetch all transactions for the student
        $transactions = getStudentPaymentHistory($conn, $student_id);
        $report_title = "All Transactions for " . htmlspecialchars($student_name);
    }
} else {
    $report_title = "Invalid Student ID";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $report_title; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 100%; margin: 0 auto; }
        h2, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .no-print { display: none; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
            .container { width: auto; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>School Fees Payment System</h2>
        <h3><?php echo $report_title; ?></h3>

        <?php if ($student_id && !empty($transactions)): ?>
            <p><strong>Student Name:</strong> <?php echo htmlspecialchars($student_name); ?></p>
            <?php if ($session && $term && !$start_date && !$end_date): ?>
                <p><strong>Session:</strong> <?php echo htmlspecialchars($session); ?>, <strong>Term:</strong> <?php echo htmlspecialchars($term); ?></p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Fee Item</th>
                        <th>Class</th>
                        <th>Arm</th>
                        <th>Amount Paid</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Ref</th>
                        <th>Recorded By</th>
                        <th>Session</th>
                        <th>Term</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['transaction_id']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['service']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['class']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['arm']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($transaction['amount_paid'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($transaction['payment_date']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['transaction_ref'] ? $transaction['transaction_ref'] : 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($transaction['recorded_by']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['session']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['term']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p style="text-align: right; margin-top: 20px;">Printed on: <?php echo date('Y-m-d H:i:s'); ?></p>
        <?php else: ?>
            <p style="text-align: center;">No transactions found for this student or invalid request.</p>
        <?php endif; ?>

        <div class="no-print" style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" class="btn btn-primary">Print Report</button>
            <button onclick="window.close()" class="btn btn-secondary">Close</button>
        </div>
    </div>
</body>
</html>
