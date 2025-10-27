<?php
include('components/students_logic.php');
include('components/fees_management.php');
include('includes/config.php'); // Include the config file

// Ensure the constants are defined
if (!defined('FLUTTERWAVE_PUBLIC_KEY') || !defined('FLUTTERWAVE_SECRET_KEY')) {
    die("Flutterwave API keys are not defined in config.php");
}


$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (empty($student_id)) {
    die("Student ID not provided.");
}

// Get student details
$student_stmt = $conn->prepare("SELECT name, email, class, arm, hostel FROM students WHERE id = ?");
$student_stmt->bind_param("s", $student_id);
$student_stmt->execute();
$student_result = $student_stmt->get_result();
$student_data = $student_result->fetch_assoc();

if (!$student_data) {
    die("Student not found.");
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

// Handle Flutterwave callback
if (isset($_GET['status']) && $_GET['status'] == 'successful') {
    $tx_ref = $_GET['tx_ref'];
    $transaction_id_fw = $_GET['transaction_id'];

    $payment_details_json = isset($_GET['payment_details']) ? base64_decode($_GET['payment_details']) : '';
    $payment_details = json_decode($payment_details_json, true);

    // Server-side verification of Flutterwave transaction
    $curl = curl_init();
    $url = "https://api.flutterwave.com/v3/transactions/{$transaction_id_fw}/verify";

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer " . FLUTTERWAVE_SECRET_KEY
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        $error = "cURL Error #:" . $err;
    } else {
        $flutterwave_response = json_decode($response, true);

        if ($flutterwave_response['status'] === 'success' && $flutterwave_response['data']['status'] === 'successful') {
            $verified_amount = $flutterwave_response['data']['amount'];
            $verified_currency = $flutterwave_response['data']['currency'];

            if ($payment_details && $payment_details['student_id'] == $student_id && $payment_details['tx_ref'] == $tx_ref && $verified_amount == $payment_details['amount'] && $verified_currency == "NGN") {
                $amount_paid = $payment_details['amount'];
                $payment_method = "Flutterwave";
                $recorded_by = "Student";
                $session_paid = $payment_details['session'];
                $term_paid = $payment_details['term'];

                // Dynamically find a fee_definition_id
                $general_fee_stmt = $conn->prepare("SELECT id FROM fee WHERE class = ? AND arm = ? AND term = ? AND session = ? LIMIT 1");
                $general_fee_stmt->bind_param("ssss", $student_class, $student_arm, $current_term, $current_session);
                $general_fee_stmt->execute();
                $general_fee_result = $general_fee_stmt->get_result();
                $general_fee_data = $general_fee_result->fetch_assoc();
                $fee_definition_id_to_save = $general_fee_data ? $general_fee_data['id'] : 'GENERAL-FEE';

                if (recordStudentPayment($conn, $student_id, $fee_definition_id_to_save, $amount_paid, $payment_method, $tx_ref, $recorded_by, $session_paid, $term_paid)) {
                    $message = "Payment of " . number_format($amount_paid, 2) . " recorded successfully! Transaction Ref: " . htmlspecialchars($tx_ref);

                    // Refresh balances
                    $fee_status = getStudentFeeStatus($conn, $student_id, $current_session, $current_term);
                    $total_fee_current_period = $fee_status ? $fee_status['fee'] : 0;
                    $total_paid_current_period = $fee_status ? $fee_status['paid'] : 0;
                    $outstanding_current_period = $fee_status ? ($fee_status['fee'] - $fee_status['paid']) : 0;
                    $previous_outstanding_balances = getPreviousOutstandingBalances($conn, $student_id, $current_session, $current_term);
                    $sum_previous_outstanding = array_sum(array_column($previous_outstanding_balances, 'outstanding'));
                    $total_outstanding_cumulative = $outstanding_current_period + $sum_previous_outstanding;
                } else {
                    $error = "Error saving payment details to database.";
                }
            } else {
                $error = "Payment verification failed: details mismatched or amount not matching.";
            }
        } else {
            $error = "Payment verification failed: Flutterwave status not successful.";
        }
    }
} elseif (isset($_GET['status']) && $_GET['status'] == 'cancelled') {
    $error = "Payment was cancelled by the user.";
} elseif (isset($_GET['status']) && $_GET['status'] == 'failed') {
    $error = "Payment failed. Please try again.";
}

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
                            <h3 class="fw-bold mb-3">School Fees Payment</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item acive">Home</li>
                                <li class="breadcrumb-item active">Bursary</li>
                                <li class="breadcrumb-item active">School Fees Payment</li>
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
                                            <h3>Make Payment for <?php echo htmlspecialchars($student_name); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <?php if ($message): ?>
                                        <div class="alert alert-success"><?php echo $message; ?></div>
                                    <?php endif; ?>
                                    <?php if ($error): ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php endif; ?>

                                    <h4>Cumulative Outstanding Balance</h4>
                                    <p><strong><?php echo htmlspecialchars(number_format($total_outstanding_cumulative, 2)); ?></strong></p>

                                    <?php if ($total_outstanding_cumulative <= 0): ?>
                                        <div class="alert alert-success">You have no outstanding payments. Thank you!</div>
                                        <a href="student_fees_dashboard.php?student_id=<?php echo htmlspecialchars($student_id); ?>" class="btn btn-primary">Back to Dashboard</a>
                                    <?php else: ?>
                                        <form id="paymentForm">
                                            <input type="hidden" id="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                                            <input type="hidden" id="student_name" value="<?php echo htmlspecialchars($student_name); ?>">
                                            <input type="hidden" id="student_email" value="<?php echo htmlspecialchars($student_email); ?>">
                                            <input type="hidden" id="current_session" value="<?php echo htmlspecialchars($current_session); ?>">
                                            <input type="hidden" id="current_term" value="<?php echo htmlspecialchars($current_term); ?>">
                                            <input type="hidden" id="outstanding_balance" value="<?php echo htmlspecialchars($total_outstanding_cumulative); ?>">

                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Amount to Pay</label>
                                                <input type="number" class="form-control" id="amount" name="amount" step="0.01"
                                                    min="1" max="<?php echo htmlspecialchars($total_outstanding_cumulative); ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Proceed to Payment</button>


                                            <!-- <a href="students.php" class="btn btn-secondary">Cancel</a> -->
                                        </form>
                                    <?php endif; ?>
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
        document.getElementById('paymentForm')?.addEventListener('submit', function(event) {
            event.preventDefault();

            var studentId = document.getElementById('student_id').value;
            var studentName = document.getElementById('student_name').value;
            var studentEmail = document.getElementById('student_email').value;
            var amount = parseFloat(document.getElementById('amount').value);
            var outstandingBalance = parseFloat(document.getElementById('outstanding_balance').value);
            var currentSession = document.getElementById('current_session').value;
            var currentTerm = document.getElementById('current_term').value;

            if (amount <= 0 || isNaN(amount)) {
                alert('Please enter a valid amount.');
                return;
            }
            if (amount > outstandingBalance) {
                alert('You cannot pay more than your outstanding balance of ' + outstandingBalance.toFixed(2));
                return;
            }

            var tx_ref = "TX-" + Math.floor(Math.random() * 1000000000) + "-" + Date.now();

            var paymentDetails = {
                student_id: studentId,
                amount: amount,
                tx_ref: tx_ref,
                session: currentSession,
                term: currentTerm
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
                        window.location.href = 'payment.php?status=successful&tx_ref=' + data.tx_ref +
                            '&transaction_id=' + data.transaction_id + '&payment_details=' + encodedPaymentDetails +
                            '&student_id=' + studentId;
                    } else if (data.status === 'cancelled') {
                        window.location.href = 'payment.php?status=cancelled&student_id=' + studentId;
                    } else {
                        window.location.href = 'payment.php?status=failed&student_id=' + studentId;
                    }
                },
                customizations: {
                    title: "School Fees Payment",
                    description: "Payment for " + studentName + " - " + currentSession + " " + currentTerm,
                    logo: "../assets/img/logodark.ico"
                }
            });
        });
    </script>
</body>

</html>
