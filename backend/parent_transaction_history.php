<?php include('components/parent_logic.php');

// include('components/fees_management.php');

// Function to get tuckshop recharge history

$stmt = $conn->prepare("SELECT ft.* FROM fee_transactions ft
                            INNER JOIN parent_student ps ON ft.student_id = ps.student_id
                            WHERE ft.payment_method = 'Flutterwave (Parent Tuckshop)' 
                            OR ft.payment_method = 'Flutterwave (Parent Fees)'
                            OR ft.recorded_by = 'Parent'
                            AND ft.student_id = ps.student_id
                            ORDER BY payment_date DESC");
$stmt->execute();
$result = $stmt->get_result();
// Get parent transaction history
$parent_transaction_history = $result->fetch_all(MYSQLI_ASSOC);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('parentnav.php'); ?>
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
                            <h3 class="fw-bold mb-3">Parent Transaction History</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="parent_dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Bursary</li>
                                <li class="breadcrumb-item active">Parent Transaction History</li>
                            </ol>
                        </div>

                    </div>

                    <!-- BULK UPLOAD ============================ -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header mb-3">
                                    <div class="card-head-row">
                                        <div class="card-title">
                                            <h3>Transaction History</h3>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!empty($parent_transaction_history)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="basic-datatables">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Transaction ID</th> -->
                                                    <th>Amount Recharged</th>
                                                    <th>Recharge Date</th>
                                                    <th>Method</th>
                                                    <th>Ref</th>
                                                    <th>Session</th>
                                                    <th>Term</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($parent_transaction_history as $recharge): ?>
                                                    <tr>
                                                        <!-- <td><?php echo htmlspecialchars($recharge['transaction_id']); ?></td> -->
                                                        <td><?php echo number_format((float)$recharge['amount_paid'], 2); ?></td>
                                                        <td><?php echo htmlspecialchars($recharge['payment_date']); ?></td>
                                                        <td><?php echo htmlspecialchars($recharge['payment_method']); ?></td>
                                                        <td><?php echo htmlspecialchars($recharge['transaction_ref'] ?: 'N/A'); ?></td>
                                                        <td><?php echo htmlspecialchars($recharge['session']); ?></td>
                                                        <td><?php echo htmlspecialchars($recharge['term']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p>No parent transaction history found.</p>
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