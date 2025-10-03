<?php include('components/students_logic.php');

include('components/fees_management.php');

// For demonstration purposes, assume a student ID is passed or retrieved from session
$student_id = $_SESSION['user_id']; // Example student ID

if (empty($student_id)) {
    die("Student ID not provided.");
}


// Function to get tuckshop recharge history
function getTuckshopRechargeHistory($conn, $student_id)
{
    $stmt = $conn->prepare("SELECT transaction_id, amount_paid, payment_date, payment_method, transaction_ref, session, term 
                            FROM fee_transactions 
                            WHERE student_id = ? AND fee_definition_id = 'TUCKSHOP-FUND' OR fee_definition_id = 'PARENT-TUCKSHOP-FUND'
                            ORDER BY payment_date DESC");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get tuckshop recharge history
$tuckshop_recharge_history = getTuckshopRechargeHistory($conn, $student_id);

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
                            <h3 class="fw-bold mb-3">Tuckshop Payment History</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active">Bursary</li>
                                <li class="breadcrumb-item active">Tuckshop Payment History</li>
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
                                            <h3>Tuckshop Recharge History</h3>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!empty($tuckshop_recharge_history)): ?>
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
                                                <?php foreach ($tuckshop_recharge_history as $recharge): ?>
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
                                    <p>No tuckshop recharge history found.</p>
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