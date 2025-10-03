<?php include('components/students_logic.php');

include('components/fees_management.php');

// For demonstration purposes, assume a student ID is passed or retrieved from session
$student_id = $_SESSION['user_id']; // Example student ID

if (empty($student_id)) {
    die("Student ID not provided.");
}

// Get student's payment history
$payment_history = getStudentPaymentHistory($conn, $student_id);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('studentnav.php'); ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <?php include('logo_header.php'); ?>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <?php include('navbar.php'); ?>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                       <div>
                            <h3 class="fw-bold mb-3">Payment History</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Bursary</li>
                                <li class="breadcrumb-item active">Payment History</li>
                            </ol>
                        </div>

                    </div>

                  <div class="row">

                        <div class="col-md-12">
                            <div class="card card-round ">
                                <div class="card-header mb-3">
                                    <div class="card-head-row">
                                        <div class="card-title">
                                            <h3>Your Payment History</h3>
                                        </div>
                                    </div>
                                </div>


                                <?php if (!empty($payment_history)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="basic-datatables">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Transaction ID</th> -->
                                                    <th>Fee Item</th>
                                                    <th>Amount Paid</th>
                                                    <th>Payment Date</th>
                                                    <th>Method</th>
                                                    <th>Session</th>
                                                    <th>Term</th>
                                                    <th>Receipt</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($payment_history as $payment): ?>
                                                    <tr>
                                                        <!-- <td><?php echo htmlspecialchars($payment['transaction_id']); ?></td> -->
                                                        <td><?php echo htmlspecialchars($payment['service']); ?> (<?php echo htmlspecialchars($payment['class']); ?> <?php echo htmlspecialchars($payment['arm']); ?>)</td>
                                                        <td><?php echo number_format((float)$payment['amount_paid'], 2); ?></td>
                                                        <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                                                        <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                                                        <td><?php echo htmlspecialchars($payment['session']); ?></td>
                                                        <td><?php echo htmlspecialchars($payment['term']); ?></td>
                                                        <td><a href="print_receipt.php?transaction_id=<?php echo htmlspecialchars($payment['transaction_id']); ?>" target="_blank" class="btn btn-sm btn-info">View Receipt</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p>No payment history found.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            

            <?php include('footer.php'); ?>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <?php include('cust-color.php'); ?>
        <!-- End Custom template -->
    </div>
    <?php include('scripts.php'); ?>

</body>

</html>