<?php include('components/admin_logic.php');

include('components/fees_management.php');

// Initialize variables for current session and term
$current_session_data = $conn->query("SELECT csession FROM currentsession LIMIT 1")->fetch_assoc();
$current_term_data = $conn->query("SELECT cterm FROM currentterm LIMIT 1")->fetch_assoc();
$current_session = $current_session_data ? $current_session_data['csession'] : 'N/A';
$current_term = $current_term_data ? $current_term_data['cterm'] : 'N/A';


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
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Students</li>
                <li class="breadcrumb-item active">Bursary</li>
              </ol>
            </div>

          </div>

      
              

<div class="row">

            <div class="col-md-12">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title"> <h3>Transaction History by Date Range</h3> </div>
                  </div>
               

                </div>
                <div class="card-body pb-0">
                  <div class="mb-4 mt-2">
                    <p>

                  <!-- the card content goes here-->
<div class="form-section">
     <!-- Transaction History by Date Range Section -->
        <div class="form-section">
           
            <form method="GET" class="row g-3 align-items-end mb-3" id="date_range_form">
                <div class="col-md-4">
                    <label for="student_id_date_range" class="form-label">Select Student</label>
                    <select name="student_id_date_range" id="student_id_date_range" class="form-select" required>
                        <option value=""selected disabled>Select Student</option>
                        <?php foreach ($students as $s): ?>
                            <option value="<?php echo htmlspecialchars($s['id']); ?>"><?php echo htmlspecialchars($s['name']) . ' (' . htmlspecialchars($s['class']) . ' ' . htmlspecialchars($s['arm']) . ')'; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-info me-2" id="view_date_range_report_btn"> <i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-secondary" id="print_date_range_report_btn"><i class="fas fa-print"></i></button>
                </div>
            </form>

            <div class="table-responsive" id="date_range_report_table_container" style="display:none;">
                <h4>Report for <span id="date_range_student_name"></span> from <span id="report_start_date"></span> to <span id="report_end_date"></span></h4>
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
                        </tr>
                    </thead>
                    <tbody id="date_range_report_table_body">
                        <!-- Date range payment history will be loaded here via JavaScript -->
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

        <div class="modal fade" id="editFeeModal" tabindex="-1" aria-labelledby="editFeeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFeeModalLabel">Edit Fee Definition</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="update_fee_definition">
                            <input type="hidden" name="edit_fee_id" id="edit_fee_id">
                            <div class="mb-3">
                                <label for="edit_class" class="form-label">Class</label>
                                <select name="edit_class" id="edit_class" class="form-select" required>
                                    <?php foreach ($classes as $c): ?>
                                        <option value="<?php echo htmlspecialchars($c['class']); ?>"><?php echo htmlspecialchars($c['class']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_arm" class="form-label">Arm</label>
                                <select name="edit_arm" id="edit_arm" class="form-select" required>
                                    <?php foreach ($arms as $a): ?>
                                        <option value="<?php echo htmlspecialchars($a['arm']); ?>"><?php echo htmlspecialchars($a['arm']); ?></option>
                                    <?php endforeach; ?>
                                    <!-- <option value="N/A">N/A</option> -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_term" class="form-label">Term</label>
                                <select name="edit_term" id="edit_term" class="form-select" required>
                                    <?php foreach ($terms as $t): ?>
                                        <option value="<?php echo htmlspecialchars($t['cterm']); ?>"><?php echo htmlspecialchars($t['cterm']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_session" class="form-label">Session</label>
                                <select name="edit_session" id="edit_session" class="form-select" required>
                                    <?php foreach ($sessions as $s): ?>
                                        <option value="<?php echo htmlspecialchars($s['csession']); ?>"><?php echo htmlspecialchars($s['csession']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_service" class="form-label">Service/Fee Name</label>
                                <input type="text" name="edit_service" id="edit_service" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_price" class="form-label">Price</label>
                                <input type="number" name="edit_price" id="edit_price" class="form-control" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_hostel" class="form-label">Hostel (Optional)</label>
                                <select name="edit_hostel" id="edit_hostel" class="form-select">
                                    <!-- <option value="N/A">N/A</option> -->
                                    <?php foreach ($hostels as $h): ?>
                                        <option value="<?php echo htmlspecialchars($h['hostel']); ?>"><?php echo htmlspecialchars($h['hostel']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
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
