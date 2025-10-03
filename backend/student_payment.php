<?php include('components/admin_logic.php');

include('components/fees_management.php');

// Initialize variables for current session and term
$current_session_data = $conn->query("SELECT csession FROM currentsession LIMIT 1")->fetch_assoc();
$current_term_data = $conn->query("SELECT cterm FROM currentterm LIMIT 1")->fetch_assoc();
$current_session = $current_session_data ? $current_session_data['csession'] : 'N/A';
$current_term = $current_term_data ? $current_term_data['cterm'] : 'N/A';

$message = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_fee_definition':
                $class = $_POST['class'];
                $arm = $_POST['arm'];
                $term = $_POST['term'];
                $service = $_POST['service'];
                $price = $_POST['price'];
                $hostel = $_POST['hostel'];
                $session = $_POST['session'];
                if (addFeeDefinition($conn, $class, $arm, $term, $service, $price, $hostel, $session)) {
                    $message = "Fee definition added successfully!";
                } else {
                    $message = "Error adding fee definition: " . $conn->error;
                }
                break;

            case 'record_payment':
                $student_id = $_POST['student_id'];
                $fee_definition_id = $_POST['fee_definition_id'];
                $amount_paid = $_POST['amount_paid'];
                $payment_method = $_POST['payment_method'];
                $transaction_ref = $_POST['transaction_ref'];
                $recorded_by = "Admin"; // This should come from a session variable for the logged-in user
                $session = $_POST['payment_session'];
                $term = $_POST['payment_term'];

                if (recordStudentPayment($conn, $student_id, $fee_definition_id, $amount_paid, $payment_method, $transaction_ref, $recorded_by, $session, $term)) {
                    $message = "Payment recorded successfully!";
                } else {
                    $message = "Error recording payment: " . $conn->error;
                }
                break;

            case 'update_fee_definition':
                $id = $_POST['edit_fee_id'];
                $class = $_POST['edit_class'];
                $arm = $_POST['edit_arm'];
                $term = $_POST['edit_term'];
                $service = $_POST['edit_service'];
                $price = $_POST['edit_price'];
                $hostel = $_POST['edit_hostel'];
                $session = $_POST['edit_session'];
                if (updateFeeDefinition($conn, $id, $class, $arm, $term, $service, $price, $hostel, $session)) {
                    $message = "Fee definition updated successfully!";
                } else {
                    $message = "Error updating fee definition: " . $conn->error;
                }
                break;

            case 'delete_fee_definition':
                $fee_id = $_POST['delete_fee_id'];
                if (deleteFeeDefinition($conn, $fee_id)) {
                    $message = "Fee definition deleted successfully!";
                } else {
                    $message = "Error deleting fee definition: " . $conn->error;
                }
                break;
        }
    }
}

// Fetch data for dropdowns and tables
$classes = getClasses($conn);
$arms = getArms($conn);
$terms = getTerms($conn);
$sessions = getSessions($conn);
$hostels = getHostels($conn);
$students = getStudents($conn);
$fee_definitions = getFeeDefinitions($conn);

// Determine which session and term to display for student fee status
$display_session = isset($_GET['session']) ? $_GET['session'] : $current_session;
$display_term = isset($_GET['term']) ? $_GET['term'] : $current_term;
$students_fee_status = getAllStudentsFeeStatus($conn, $display_session, $display_term);


// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('adminnav.php'); ?>
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
                            <h3 class="fw-bold mb-3">Bursary Dashboard</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Students</li>
                                <li class="breadcrumb-item active">Bursary</li>
                            </ol>
                        </div>

                    </div>

                    <!-- BULK UPLOAD ============================ -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Record Student Payment</div>
                                    </div>


                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <p>

                                        <div class="form-section">

                                            <form method="POST">
                                                <input type="hidden" name="action" value="record_payment">
                                                <div class="row mb-3 g-3">
                                                    <div class="col-md-6">
                                                        <select name="student_id" id="student_id" class="form-select" required>
                                                            <option value="" selected disabled>Select Student</option>
                                                            <?php foreach ($students as $s): ?>
                                                                <option value="<?php echo htmlspecialchars($s['id']); ?>"><?php echo htmlspecialchars($s['name']) . ' (' . htmlspecialchars($s['class']) . ' ' . htmlspecialchars($s['arm']) . ')'; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="fee_definition_id" id="fee_definition_id" class="form-select" required>
                                                            <option value="" selected disabled>Select Fee Item</option>
                                                            <?php foreach ($fee_definitions as $fee): ?>
                                                                <option value="<?php echo htmlspecialchars($fee['id']); ?>">
                                                                    <?php echo htmlspecialchars($fee['service']) . ' - ' . htmlspecialchars($fee['class']) . ' ' . htmlspecialchars($fee['arm']) . ' (' . number_format((float)$fee['price'], 2) . ')'; ?>
                                                                </option>

                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 g-2">
                                                    <div class="col-md-4">
                                                        <input type="number" name="amount_paid" placeholder="Amount Paid" id="amount_paid" class="form-control" step="0.01" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="payment_method" placeholder="Payment Method" id="payment_method" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="transaction_ref" placeholder="Transaction Reference (Optional)" id="transaction_ref" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3 g-3">
                                                    <div class="col-md-6">
                                                        <select name="payment_session" id="payment_session" class="form-select" required>
                                                            <option value="" selected disabled>Select Session</option>
                                                            <?php foreach ($sessions as $s): ?>
                                                                <option value="<?php echo htmlspecialchars($s['csession']); ?>" <?php echo ($s['csession'] == $current_session) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s['csession']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="payment_term" id="payment_term" class="form-select" required>
                                                            <option value="" selected disabled>Select Term</option>
                                                            <?php foreach ($terms as $t): ?>
                                                                <option value="<?php echo htmlspecialchars($t['cterm']); ?>" <?php echo ($t['cterm'] == $current_term) ? 'selected' : ''; ?>><?php echo htmlspecialchars($t['cterm']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> </button>

                                            </form>
                                        </div>

                                        </p>
                                    </div>

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
                                            <h3>Student Fee Status Report (Session: <?php echo htmlspecialchars($display_session); ?>, Term: <?php echo htmlspecialchars($display_term); ?>)</h3>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <p>

                                            <!-- the card content goes here-->
                                        <div class="form-section">


                                            <div class="form-section">

                                                <form method="GET" class="row g-3 align-items-end mb-3">
                                                    <div class="col-md-4">
                                                        <label for="report_session" class="form-label">Select Session</label>
                                                        <select name="session" id="report_session" class="form-select">
                                                            <?php foreach ($sessions as $s): ?>
                                                                <option value="<?php echo htmlspecialchars($s['csession']); ?>" <?php echo ($s['csession'] == $display_session) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s['csession']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="report_term" class="form-label">Select Term</label>
                                                        <select name="term" id="report_term" class="form-select">
                                                            <?php foreach ($terms as $t): ?>
                                                                <option value="<?php echo htmlspecialchars($t['cterm']); ?>" <?php echo ($t['cterm'] == $display_term) ? 'selected' : ''; ?>><?php echo htmlspecialchars($t['cterm']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-info"> <i class="fas fa-eye"></i></button>
                                                    </div>
                                                </form>
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

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="basic-datatables">
                                                        <thead>
                                                            <tr>
                                                                <th>Student ID</th>
                                                                <th>Name</th>
                                                                <th>Class</th>
                                                                <th>Arm</th>
                                                                <th>Hostel</th>
                                                                <th>Total Fee</th>
                                                                <th>Total Paid</th>
                                                                <th>Outstanding Balance</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($students_fee_status)): ?>
                                                                <?php foreach ($students_fee_status as $student_status): ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($student_status['id']); ?></td>
                                                                        <td><?php echo htmlspecialchars($student_status['name']); ?></td>
                                                                        <td><?php echo htmlspecialchars($student_status['class']); ?></td>
                                                                        <td><?php echo htmlspecialchars($student_status['arm']); ?></td>
                                                                        <td><?php echo htmlspecialchars($student_status['hostel']); ?></td>
                                                                        <td><?php echo htmlspecialchars(number_format((float)$student_status['total_fee'], 2)); ?></td>
                                                                        <td><?php echo htmlspecialchars(number_format((float)$student_status['total_paid'], 2)); ?></td>
                                                                        <td><?php echo htmlspecialchars(number_format((float)$student_status['outstanding_balance'], 2)); ?></td>

                                                                        <td class=" d-flex">
                                                                            <button type="button" class="btn btn-sm btn-info view-payments-btn me-3"
                                                                                data-bs-toggle="modal" data-bs-target="#viewPaymentsModal"
                                                                                data-student-id="<?php echo htmlspecialchars($student_status['id']); ?>"
                                                                                data-student-name="<?php echo htmlspecialchars($student_status['name']); ?>">
                                                                                <i class="fas fa-eye"></i>
                                                                            </button>
                                                                            <a href="print_student_transactions.php?student_id=<?php echo htmlspecialchars($student_status['id']); ?>&session=<?php echo htmlspecialchars($display_session); ?>&term=<?php echo htmlspecialchars($display_term); ?>" target="_blank" class="btn btn-sm btn-secondary"> <i class="fas fa-print"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="9">No student fee status found for the selected session and term.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
    <script>
        $(document).ready(function() {
            // Populate Edit Fee Modal
            $('.edit-fee-btn').on('click', function() {
                var id = $(this).data('id');
                var class_name = $(this).data('class');
                var arm = $(this).data('arm');
                var term = $(this).data('term');
                var service = $(this).data('service');
                var price = $(this).data('price');
                var hostel = $(this).data('hostel');
                var session = $(this).data('session');

                $('#edit_fee_id').val(id);
                $('#edit_class').val(class_name);
                $('#edit_arm').val(arm);
                $('#edit_term').val(term);
                $('#edit_service').val(service);
                $('#edit_price').val(price);
                $('#edit_hostel').val(hostel);
                $('#edit_session').val(session);
            });

            // Load Payment History for View Payments Modal
            $('.view-payments-btn').on('click', function() {
                var studentId = $(this).data('student-id');
                var studentName = $(this).data('student-name');
                $('#modal_student_name').text(studentName);

                $.ajax({
                    url: 'fees_management_ajax.php', // A new AJAX endpoint to fetch payment history
                    type: 'GET',
                    data: {
                        student_id: studentId,
                        action: 'get_payment_history'
                    },
                    success: function(response) {
                        var payments = JSON.parse(response);
                        var tbody = $('#payment_history_table_body');
                        tbody.empty(); // Clear previous data

                        if (payments.length > 0) {
                            payments.forEach(function(payment) {
                                tbody.append(
                                    '<tr>' +
                                    '<td>' + payment.transaction_id + '</td>' +
                                    '<td>' + payment.service + '</td>' +
                                    '<td>' + payment.class + '</td>' +
                                    '<td>' + payment.arm + '</td>' +
                                    '<td>' + parseFloat(payment.amount_paid).toFixed(2) + '</td>' +
                                    '<td>' + payment.payment_date + '</td>' +
                                    '<td>' + payment.payment_method + '</td>' +
                                    '<td>' + (payment.transaction_ref ? payment.transaction_ref : 'N/A') + '</td>' +
                                    '<td>' + payment.recorded_by + '</td>' +
                                    '<td>' + payment.session + '</td>' +
                                    '<td>' + payment.term + '</td>' +
                                    '<td><a href="print_receipt.php?transaction_id=' + payment.transaction_id + '" target="_blank" class="btn btn-sm btn-secondary">Print Receipt</a></td>' +
                                    '</tr>'
                                );
                            });
                        } else {
                            tbody.append('<tr><td colspan="12">No payment history found for this student.</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching payment history:", error);
                        $('#payment_history_table_body').empty().append('<tr><td colspan="12">Error loading payment history.</td></tr>');
                    }
                });
            });

            // Handle View Report for Date Range
            $('#view_date_range_report_btn').on('click', function() {
                var studentId = $('#student_id_date_range').val();
                var studentName = $('#student_id_date_range option:selected').text();
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (!studentId || !startDate || !endDate) {
                    alert('Please select a student, start date, and end date.');
                    return;
                }

                $('#date_range_student_name').text(studentName);
                $('#report_start_date').text(startDate);
                $('#report_end_date').text(endDate);

                $.ajax({
                    url: 'fees_management_ajax.php',
                    type: 'GET',
                    data: {
                        action: 'get_payment_history_by_date_range',
                        student_id: studentId,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        var payments = JSON.parse(response);
                        var tbody = $('#date_range_report_table_body');
                        tbody.empty();

                        if (payments.length > 0) {
                            payments.forEach(function(payment) {
                                tbody.append(
                                    '<tr>' +
                                    '<td>' + payment.transaction_id + '</td>' +
                                    '<td>' + payment.service + '</td>' +
                                    '<td>' + payment.class + '</td>' +
                                    '<td>' + payment.arm + '</td>' +
                                    '<td>' + parseFloat(payment.amount_paid).toFixed(2) + '</td>' +
                                    '<td>' + payment.payment_date + '</td>' +
                                    '<td>' + payment.payment_method + '</td>' +
                                    '<td>' + (payment.transaction_ref ? payment.transaction_ref : 'N/A') + '</td>' +
                                    '<td>' + payment.recorded_by + '</td>' +
                                    '<td>' + payment.session + '</td>' +
                                    '<td>' + payment.term + '</td>' +
                                    '</tr>'
                                );
                            });
                        } else {
                            tbody.append('<tr><td colspan="11">No payment history found for this student in the selected date range.</td></tr>');
                        }
                        $('#date_range_report_table_container').show();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching date range payment history:", error);
                        $('#date_range_report_table_body').empty().append('<tr><td colspan="11">Error loading payment history.</td></tr>');
                        $('#date_range_report_table_container').show();
                    }
                });
            });

            // Handle Print Report for Date Range
            $('#print_date_range_report_btn').on('click', function() {
                var studentId = $('#student_id_date_range').val();
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (!studentId || !startDate || !endDate) {
                    alert('Please select a student, start date, and end date.');
                    return;
                }
                window.open('print_student_transactions.php?student_id=' + studentId + '&start_date=' + startDate + '&end_date=' + endDate, '_blank');
            });
        });
    </script>
</body>

</html>