<?php
include('db_connection.php');
include('components/fees_management.php');

$transaction_id = isset($_GET['transaction_id']) ? (int)$_GET['transaction_id'] : 0;

$transaction_details = null;
if ($transaction_id > 0) {
    $transaction_details = getSingleTransaction($conn, $transaction_id);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - Transaction #<?php echo htmlspecialchars($transaction_id); ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .receipt-container {
            width: 80mm; /* Standard receipt width */
            margin: 0 auto;
            padding: 10mm;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .header, .footer { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 1.2em; }
        .details p { margin: 2px 0; font-size: 0.9em; }
        .item-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .item-table th, .item-table td { border: 1px solid #eee; padding: 5px; text-align: left; font-size: 0.85em; }
        .item-table th { background-color: #f9f9f9; }
        .total { text-align: right; margin-top: 10px; font-size: 1em; font-weight: bold; }
        .thank-you { margin-top: 20px; font-size: 0.9em; }
        .no-print { text-align: center; margin-top: 20px; }
        @media print {
            body { margin: 0; }
            .receipt-container {
                width: auto;
                border: none;
                box-shadow: none;
                padding: 0;
            }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h2>School Name / Logo</h2>
            <p>Address Line 1, City, Country</p>
            <p>Phone: XXX-XXX-XXXX | Email: info@school.com</p>
            <hr>
            <h3>Payment Receipt</h3>
        </div>

        <?php if ($transaction_details): ?>
            <div class="details">
                <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_details['transaction_id']); ?></p>
                <p><strong>Date:</strong> <?php echo date('Y-m-d H:i:s', strtotime($transaction_details['payment_date'])); ?></p>
                <p><strong>Student Name:</strong> <?php echo htmlspecialchars($transaction_details['student_name']); ?></p>
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($transaction_details['student_id']); ?></p>
                <p><strong>Class:</strong> <?php echo htmlspecialchars($transaction_details['class']); ?> <?php echo htmlspecialchars($transaction_details['arm']); ?></p>
                <hr>
            </div>

            <table class="item-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($transaction_details['service']); ?> (Session: <?php echo htmlspecialchars($transaction_details['session']); ?>, Term: <?php echo htmlspecialchars($transaction_details['term']); ?>)</td>
                        <td><?php echo htmlspecialchars(number_format($transaction_details['amount_paid'], 2)); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="total">
                <p>Total Paid: <?php echo htmlspecialchars(number_format($transaction_details['amount_paid'], 2)); ?></p>
            </div>

            <div class="details">
                <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($transaction_details['payment_method']); ?></p>
                <?php if ($transaction_details['transaction_ref']): ?>
                    <p><strong>Transaction Ref:</strong> <?php echo htmlspecialchars($transaction_details['transaction_ref']); ?></p>
                <?php endif; ?>
                <p><strong>Recorded By:</strong> <?php echo htmlspecialchars($transaction_details['recorded_by']); ?></p>
            </div>

            <div class="thank-you">
                <p>Thank you for your payment!</p>
            </div>

        <?php else: ?>
            <p style="text-align: center;">Transaction not found or invalid transaction ID.</p>
        <?php endif; ?>

        <div class="no-print">
            <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
            <button onclick="window.close()" class="btn btn-secondary">Close</button>
        </div>
    </div>
</body>
</html>
