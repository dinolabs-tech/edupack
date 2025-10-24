<?php
include('components/parent_logic.php');
include('db_connection.php'); // This file now directly establishes $conn and handles errors
include('components/fees_management.php'); // Contains getStudentFeeStatus and getPreviousOutstandingBalances
include('includes/config.php'); // Include the config file

// Ensure the constants are defined
if (!defined('FLUTTERWAVE_PUBLIC_KEY') || !defined('FLUTTERWAVE_SECRET_KEY')) {
    die("Flutterwave API keys are not defined in config.php");
}

// $conn should be available after db_connection.php is included

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : ''; // Parent provides student ID

if (empty($student_id)) {
  die("Student ID not provided. Please provide the student ID to proceed.");
}

// Get student details
$student_stmt = $conn->prepare("SELECT name, email, class, arm, hostel FROM students WHERE id = ?");
$student_stmt->bind_param("s", $student_id);
$student_stmt->execute();
$student_result = $student_stmt->get_result();
$student_data = $student_result->fetch_assoc();

if (!$student_data) {
  die("Student not found with ID: " . htmlspecialchars($student_id));
}

$student_name = $student_data['name'];
$student_email = $student_data['email'];
$student_class = $student_data['class'];
$student_arm = $student_data['arm'];
$student_hostel = $student_data['hostel'];

// Current session/term
$current_session_data = $conn->query("SELECT csession FROM currentsession LIMIT 1")->fetch_assoc();
$current_term_data = $conn->query("SELECT cterm FROM currentterm LIMIT 1")->fetch_assoc();
$current_session = $current_session_data ? $current_session_data['csession'] : 'N/A';
$current_term = $current_term_data ? $current_term_data['cterm'] : 'N/A';

// Fee status
$fee_status = getStudentFeeStatus($conn, $student_id, $current_session, $current_term);
$total_fee_current_period = $fee_status ? (float)$fee_status['fee'] : 0;
$total_paid_current_period = $fee_status ? (float)$fee_status['paid'] : 0;
$outstanding_current_period = $total_fee_current_period - $total_paid_current_period;

// Previous balances
$previous_outstanding_balances = getPreviousOutstandingBalances($conn, $student_id, $current_session, $current_term);
$sum_previous_outstanding = array_sum(array_column($previous_outstanding_balances, 'outstanding'));
$total_outstanding_cumulative = $outstanding_current_period + $sum_previous_outstanding;

$message = "";
$error = "";

// Check if student is registered for tuckshop
$tuckshop_stmt = $conn->prepare("SELECT COUNT(*) FROM tuck WHERE regno = ?");
$tuckshop_stmt->bind_param("s", $student_id);
$tuckshop_stmt->execute();
$tuckshop_result = $tuckshop_stmt->get_result();
$is_tuckshop_registered = ($tuckshop_result->fetch_row()[0] > 0);
$tuckshop_stmt->close();

// Handle messages from callback pages
if (isset($_GET['status']) && isset($_GET['message'])) {
  if ($_GET['status'] == 'successful') {
    $message = htmlspecialchars($_GET['message']);
  } else {
    $error = htmlspecialchars($_GET['message']);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php

    include('parentnav.php');

    ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <?php include('logo_header.php'); ?>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <?php
        //  include('navbar.php'); 
        ?>
        <!-- End Navbar -->
      </div>

      <div class="container" id="content-container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">
                <h2>Payment Portal for <?php echo htmlspecialchars($student_name); ?> (ID: <?php echo htmlspecialchars($student_id); ?>)</h2>
              </h3>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="parent_dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Bursary</li>
                <li class="breadcrumb-item active">Payment Portal</li>
              </ol>
            </div>

          </div>



          <div class="row">

            <?php if ($message): ?>
              <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="col-md-6">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title"> School Fees Payment</div>

                  </div>
                  <div class="card-body pb-0">
                    <div class="mb-4 mt-2">
                      <div class="table-responsive">
                        <p>

                        <p>Cumulative Outstanding Balance: <strong><?php echo htmlspecialchars(number_format($total_outstanding_cumulative, 2)); ?></strong></p>

                        <?php if ($total_outstanding_cumulative <= 0): ?>
                          <div class="alert alert-success">This ward has no outstanding fees. Thank you!</div>
                        <?php else: ?>
                          <form id="feesPaymentForm">
                            <input type="hidden" id="fees_student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                            <input type="hidden" id="fees_student_name" value="<?php echo htmlspecialchars($student_name); ?>">
                            <input type="hidden" id="fees_student_email" value="<?php echo htmlspecialchars($student_email); ?>">
                            <input type="hidden" id="fees_current_session" value="<?php echo htmlspecialchars($current_session); ?>">
                            <input type="hidden" id="fees_current_term" value="<?php echo htmlspecialchars($current_term); ?>">
                            <input type="hidden" id="fees_outstanding_balance" value="<?php echo htmlspecialchars($total_outstanding_cumulative); ?>">

                            <div class="mb-3">
                              <label for="fees_amount" class="form-label">Amount to Pay for Fees</label>
                              <input type="number" class="form-control" id="fees_amount" name="amount" step="0.01"
                                min="1" max="<?php echo htmlspecialchars($total_outstanding_cumulative); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Proceed to Fees Payment</button>
                          </form>
                        <?php endif; ?>

                        </p>
                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </div>

            <div class="col-md-6">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Tuckshop Balance Recharge</div>

                  </div>
                  <div class="card-body pb-0">
                    <div class="mb-4 mt-2">
                      <div class="table-responsive">
                        <p>

                          <?php if (!$is_tuckshop_registered): ?>
                        <div class="alert alert-warning">
                          This ward is not registered for the tuckshop. Kindly contact the school to register.
                        </div>
                        <button type="button" class="btn btn-success" disabled>Proceed to Tuckshop Recharge</button>
                      <?php else: ?>
                        <p>Fund your ward's tuckshop account.</p>
                        <form id="tuckshopPaymentForm">
                          <input type="hidden" id="tuckshop_student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                          <input type="hidden" id="tuckshop_student_name" value="<?php echo htmlspecialchars($student_name); ?>">
                          <input type="hidden" id="tuckshop_student_email" value="<?php echo htmlspecialchars($student_email); ?>">

                          <div class="mb-3">
                            <label for="tuckshop_amount" class="form-label">Amount to Recharge Tuckshop</label>
                            <input type="number" class="form-control" id="tuckshop_amount" name="amount" step="0.01" min="1" required>
                          </div>
                          <button type="submit" class="btn btn-success">Proceed to Tuckshop Recharge</button>
                        </form>
                      <?php endif; ?>

                      </p>
                      </div>
                    </div>

                  </div>
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

    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
      document.getElementById('feesPaymentForm')?.addEventListener('submit', function(event) {
        event.preventDefault();

        var studentId = document.getElementById('fees_student_id').value;
        var studentName = document.getElementById('fees_student_name').value;
        var studentEmail = document.getElementById('fees_student_email').value;
        var amount = parseFloat(document.getElementById('fees_amount').value);
        var outstandingBalance = parseFloat(document.getElementById('fees_outstanding_balance').value);
        var currentSession = document.getElementById('fees_current_session').value;
        var currentTerm = document.getElementById('fees_current_term').value;

        if (amount <= 0 || isNaN(amount)) {
          alert('Please enter a valid amount for fees.');
          return;
        }
        if (amount > outstandingBalance) {
          alert('You cannot pay more than the outstanding balance of ' + outstandingBalance.toFixed(2) + ' for fees.');
          return;
        }

        var tx_ref = "PARENT-FEES-" + Math.floor(Math.random() * 1000000000) + "-" + Date.now();

        var paymentDetails = {
          student_id: studentId,
          amount: amount,
          tx_ref: tx_ref,
          session: currentSession,
          term: currentTerm,
          type: 'fees' // Indicate payment type
        };
        var encodedPaymentDetails = btoa(JSON.stringify(paymentDetails));

        FlutterwaveCheckout({
          public_key: "<?php echo FLUTTERWAVE_PUBLIC_KEY; ?>", // Use the public key from config
          tx_ref: tx_ref,
          amount: amount,
          currency: "NGN",
          country: "NG",
          payment_options: "card, mobilemoney,banktransfer, ussd",
          customer: {
            email: studentEmail,
            name: studentName
          },
          callback: function(data) {
            if (data.status === 'successful') {
              window.location.href = 'parent_fees_callback.php?status=successful&tx_ref=' + data.tx_ref +
                '&transaction_id=' + data.transaction_id + '&payment_details=' + encodedPaymentDetails +
                '&student_id=' + studentId;
            } else if (data.status === 'cancelled') {
              window.location.href = 'parent_payment.php?status=cancelled&message=' + encodeURIComponent('Fees payment was cancelled.') + '&student_id=' + studentId;
            } else {
              window.location.href = 'parent_payment.php?status=failed&message=' + encodeURIComponent('Fees payment failed. Please try again.') + '&student_id=' + studentId;
            }
          },
          customizations: {
            title: "School Fees Payment (Parent)",
            description: "School Fees Payment for " + studentName + " - " + currentSession + " " + currentTerm,
            logo: "https://your-school-logo.com/logo.png"
          }
        });
      });

      document.getElementById('tuckshopPaymentForm')?.addEventListener('submit', function(event) {
        event.preventDefault();

        var studentId = document.getElementById('tuckshop_student_id').value;
        var studentName = document.getElementById('tuckshop_student_name').value;
        var studentEmail = document.getElementById('tuckshop_student_email').value;
        var amount = parseFloat(document.getElementById('tuckshop_amount').value);

        if (amount <= 0 || isNaN(amount)) {
          alert('Please enter a valid amount for tuckshop recharge.');
          return;
        }

        var tx_ref = "PARENT-TUCKSHOP-" + Math.floor(Math.random() * 1000000000) + "-" + Date.now();

        var paymentDetails = {
          student_id: studentId,
          amount: amount,
          tx_ref: tx_ref,
          type: 'tuckshop' // Indicate payment type
        };
        var encodedPaymentDetails = btoa(JSON.stringify(paymentDetails));

        FlutterwaveCheckout({
          public_key: "<?php echo FLUTTERWAVE_PUBLIC_KEY; ?>", // Use the public key from config
          tx_ref: tx_ref,
          amount: amount,
          currency: "NGN",
          country: "NG",
          payment_options: "card, mobilemoney,banktransfer, ussd",
          customer: {
            email: studentEmail,
            name: studentName
          },
          callback: function(data) {
            if (data.status === 'successful') {
              window.location.href = 'parent_tuckshop_callback.php?status=successful&tx_ref=' + data.tx_ref +
                '&transaction_id=' + data.transaction_id + '&payment_details=' + encodedPaymentDetails +
                '&student_id=' + studentId;
            } else if (data.status === 'cancelled') {
              window.location.href = 'parent_payment.php?status=cancelled&message=' + encodeURIComponent('Tuckshop recharge was cancelled.') + '&student_id=' + studentId;
            } else {
              window.location.href = 'parent_payment.php?status=failed&message=' + encodeURIComponent('Tuckshop recharge failed. Please try again.') + '&student_id=' + studentId;
            }
          },
          customizations: {
            title: "Tuckshop Balance Recharge (Parent)",
            description: "Tuckshop Balance Recharge for " + studentName,
            logo: "https://your-school-logo.com/logo.png"
          }
        });
      });
    </script>

</body>

</html>
