<?php include('components/students_logic.php');

include('components/fees_management.php');

// For demonstration purposes, assume a student ID is passed or retrieved from session
$student_id = $_SESSION['user_id']; // Example student ID

if (empty($student_id)) {
    die("Student ID not provided.");
}

// Get student details
$student_stmt = $conn->prepare("SELECT name, class, arm, hostel FROM students WHERE id = ?");
$student_stmt->bind_param("s", $student_id);
$student_stmt->execute();
$student_result = $student_stmt->get_result();
$student_data = $student_result->fetch_assoc();

if (!$student_data) {
    die("Student not found.");
}

$student_name = $student_data['name'];
$student_class = $student_data['class'];
$student_arm = $student_data['arm'];
$student_hostel = $student_data['hostel'];

// Get current session and term
$current_session_data = $conn->query("SELECT csession FROM currentsession LIMIT 1")->fetch_assoc();
$current_term_data = $conn->query("SELECT cterm FROM currentterm LIMIT 1")->fetch_assoc();
$current_session = $current_session_data ? $current_session_data['csession'] : 'N/A';
$current_term = $current_term_data ? $current_term_data['cterm'] : 'N/A';

// Ensure bursary balance is up-to-date for the current period
updateBursaryBalance($conn, $student_id, $current_session, $current_term);

// Get fee status for the current session and term
$fee_status = getStudentFeeStatus($conn, $student_id, $current_session, $current_term);

$total_fee_current_period = $fee_status ? (float)$fee_status['fee'] : 0.0;
$total_paid_current_period = $fee_status ? (float)$fee_status['paid'] : 0.0;
$outstanding_current_period = $total_fee_current_period - $total_paid_current_period;

// Get previous outstanding balances
$previous_outstanding_balances = getPreviousOutstandingBalances($conn, $student_id, $current_session, $current_term);
$sum_previous_outstanding = array_sum(array_map(fn($row) => (float)$row['outstanding'], $previous_outstanding_balances));

// Total outstanding is current period's outstanding plus previous periods' outstanding
$total_outstanding_cumulative = $outstanding_current_period + $sum_previous_outstanding;

// Get detailed fee breakdown
$fee_breakdown_stmt = $conn->prepare("SELECT service, price FROM fee 
    WHERE class = ? AND arm = ? AND term = ? AND session = ? AND (hostel = ? OR hostel = 'N/A') ORDER BY service ASC");
$fee_breakdown_stmt->bind_param("sssss", $student_class, $student_arm, $current_term, $current_session, $student_hostel);
$fee_breakdown_stmt->execute();
$fee_breakdown = $fee_breakdown_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
                            <h3 class="fw-bold mb-3">Fee Breakdown</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Bursary</li>
                                <li class="breadcrumb-item active">Fee Breakdown</li>
                            </ol>
                        </div>

                    </div>

                    <!-- BULK UPLOAD ============================ -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">
                                            <h3>Fee Breakdown (Current Term)</h3>
                                        </div>
                                    </div>


                                </div>
                                <div class="dashboard-section">

                                    <?php if (!empty($fee_breakdown)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Fee Item</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($fee_breakdown as $item): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($item['service']); ?></td>
                                                            <td><?php echo number_format((float)($item['price'] ?? 0), 2); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <p>No fee breakdown available for your current class, arm, term, and session.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">
                                            <h3>Previous Outstanding Balances</h3>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <p>

                                            <!-- the card content goes here-->
                                        <div class="dashboard-section">

                                            <?php if (!empty($previous_outstanding_balances)): ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Session</th>
                                                                <th>Term</th>
                                                                <th>Outstanding Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($previous_outstanding_balances as $prev_outstanding): ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($prev_outstanding['session']); ?></td>
                                                                    <td><?php echo htmlspecialchars($prev_outstanding['term']); ?></td>
                                                                    <td><?php echo number_format((float)$prev_outstanding['outstanding'], 2); ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <p class="text-end mt-3"><strong>Total Previous Outstanding: <?php echo number_format($sum_previous_outstanding, 2); ?></strong></p>
                                            <?php else: ?>
                                                <p>No outstanding balances from previous terms or sessions.</p>
                                            <?php endif; ?>
                                        </div>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>

            <!-- View Payments Modal -->
            <div class="modal fade" id="viewPaymentsModal" tabindex="-1" aria-labelledby="viewPaymentsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewPaymentsModalLabel">Payment History for <span id="modal_student_name"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="payment_history_table_body">
                                        <!-- Payment history will be loaded here via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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