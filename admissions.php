<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    include('backend/db_connection.php');
    require_once('classes/OnlineApplicationPortalClass.php'); // Include the class file
    require_once('classes/AdmissionSettingsClass.php'); // Include the AdmissionSettingsClass

    $module_name = "Admissions Module";
    $page_title = $module_name . " - Online Application Portal";

    $appPortal = new OnlineApplicationPortal($conn);
    $applications = $appPortal->getAllApplications(); // Fetch all applications

    $admissionSettings = new AdmissionSettings($conn);
    $registration_cost = $admissionSettings->getSetting('registration_cost');
    if ($registration_cost === null) {
        $registration_cost = 0.00; // Default to 0 if not set in settings
    }
    $flutterwave_public_key = $admissionSettings->getSetting('flutterwave_public_key');
    if ($flutterwave_public_key === null) {
        $flutterwave_public_key = "FLWPUBK_TEST-352add210234da9f75c4cf8a2b79cd38-X"; // Default test key
    }
} catch (Throwable $e) {
    error_log("Fatal error in admissions.php: " . $e->getMessage() . " on line " . $e->getLine());
    // Optionally, display a user-friendly error message
    die("An unexpected error occurred. Please try again later. (Error ID: " . uniqid() . ")");
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="admissions-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Admissions</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Admissions</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Admissions Section -->
    <section id="admissions" class="admissions section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5 g-lg-5">
          <div class="col-lg-6">
            <div class="admissions-info" data-aos="fade-up">
              <h2>Begin Your Academic Journey Today</h2>
              <p>
                Choosing the right school is the first step toward a bright future. At EduPack, we believe that every learner deserves
                a place where curiosity is encouraged, creativity is celebrated, and excellence is achieved. Our admissions process
                is designed to be transparent, inclusive, and accessible for all students seeking quality education.
              </p>

              <div class="admissions-steps mt-5">
                <h3>How to Apply</h3>
                <div class="steps-wrapper mt-4">
                  <div class="step-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-number">1</div>
                    <div class="step-content">
                      <h4>Submit Application</h4>
                      <p>
                        Complete our online application form by providing accurate details and selecting your desired program or level.
                        You’ll receive a confirmation email once your submission is received.
                      </p>
                    </div>
                  </div>

                  <div class="step-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-number">2</div>
                    <div class="step-content">
                      <h4>Send Supporting Documents</h4>
                      <p>
                        Upload your passport and academic transcripts to verify your eligibility.
                        Our admissions office will review your file promptly.
                      </p>
                    </div>
                  </div>

                  <div class="step-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-number">3</div>
                    <div class="step-content">
                      <h4>Interview or Assessment</h4>
                      <p>
                        Shortlisted applicants may be invited for an interview or entrance assessment to better understand their
                        academic goals and learning interests.
                      </p>
                    </div>
                  </div>

                  <div class="step-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-number">4</div>
                    <div class="step-content">
                      <h4>Receive Admission Decision</h4>
                      <p>
                        Successful applicants will receive an official admission letter via email. You can then proceed to
                        confirm your enrollment and begin preparing for your studies.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-lg-6">
            <div class="admissions-requirements" data-aos="fade-up">
              <h3>Admission Requirements</h3>
              <div class="requirements-list mt-4">
                <div class="requirement-item" data-aos="fade-up" data-aos-delay="100">
                  <div class="icon-box">
                    <i class="bi bi-mortarboard-fill"></i>
                  </div>
                  <div>
                    <h4>Academic Records</h4>
                    <p>
                      Applicants must present certified copies of their previous academic results or transcripts.
                      Strong academic performance is a key factor in admission decisions.
                    </p>
                  </div>
                </div>


                <div class="requirement-item" data-aos="fade-up" data-aos-delay="400">
                  <div class="icon-box">
                    <i class="bi bi-graph-up"></i>
                  </div>
                  <div>
                    <h4>Entrance Examination (where applicable)</h4>
                    <p>
                      Some programs may require a short aptitude test to determine readiness
                      for the desired level or class.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="deadlines mt-5" data-aos="fade-up">
              <h3>Key Admission Deadlines</h3>
              <div class="deadline-grid mt-4">
                <div class="deadline-item">
                  <h4>First Term</h4>
                  <div class="date">March 15, 2025</div>
                </div>
                <div class="deadline-item">
                  <h4>Second Term</h4>
                  <div class="date">July 10, 2025</div>
                </div>
                <div class="deadline-item">
                  <h4>Third Term</h4>
                  <div class="date">November 30, 2025</div>
                </div>
                <div class="deadline-item">
                  <h4>Early Enrollment</h4>
                  <div class="date">January 10, 2025</div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section>

    <section id="admission_form" class="admission section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="request-info mt-5" data-aos="fade-up">
          <div class="card shadow" style="border-top:solid var(--bs-success) 3px;">
            <h3 class="card-header py-3">Manage Online Applications</h3>
            <div class="card-body">

              <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo $_SESSION['success_message'];
                  unset($_SESSION['success_message']); ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $_SESSION['error_message'];
                  unset($_SESSION['error_message']); ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <p>Welcome to the Online Application Portal. Please fill out the form below to apply.</p>

              <ul class="nav nav-tabs" id="applicationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="personal-tab" style="border-top: solid var(--bs-primary) 3px;" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">Personal Information</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="academic-tab" style="border-top: solid var(--bs-warning) 3px;" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab" aria-controls="academic" aria-selected="false">Academic Background</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="guardian-tab" style="border-top: solid var(--bs-danger) 3px;" data-bs-toggle="tab" data-bs-target="#guardian" type="button" role="tab" aria-controls="guardian" aria-selected="false">Guardian & Health</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="documents-tab" style="border-top: solid var(--bs-success) 3px;" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">Document Upload</button>
                </li>
              </ul>
              <form action="process_application_portal.php" method="POST" enctype="multipart/form-data">
                <div class="tab-content" id="applicationTabsContent">
                  <!-- Tab 1: Personal Information -->
                  <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="p-3 row">
                      <h6>Step 1: Personal Information</h6>
                      <div class="form-group mb-3 col-md-3">
                        <label for="name">Full Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="placeob">Place of Birth:</label>
                        <input type="text" class="form-control" id="placeob" name="placeob" required>
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="gender" name="gender" required>
                          <option value="">Select Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="studentmobile">Student Mobile:</label>
                        <input type="tel" class="form-control" id="studentmobile" name="studentmobile">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="address">Address:</label>
                        <textarea class="form-control" id="address" name="address"></textarea>
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="religion">Religion:</label>
                        <input type="text" class="form-control" id="religion" name="religion">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="state">State:</label>
                        <input type="text" class="form-control" id="state" name="state">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="lga">LGA:</label>
                        <input type="text" class="form-control" id="lga" name="lga">
                      </div>
                      <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-primary shadow" onclick="nextTab('academic-tab')">Next</button>
                      </div>
                    </div>
                  </div>

                  <!-- Tab 2: Academic Background -->
                  <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                    <div class="p-3 row">
                      <h6>Step 2: Academic Background</h6>
                      <div class="form-group mb-3 col-md-3">
                        <label for="schoolname">Last School Attended:</label>
                        <input type="text" class="form-control" id="schoolname" name="schoolname" required>
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="schooladdress">School Address:</label>
                        <input type="text" class="form-control" id="schooladdress" name="schooladdress">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="lastclass">Last Class Attended:</label>
                        <input type="text" class="form-control" id="lastclass" name="lastclass">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="session">Session:</label>
                        <input type="text" class="form-control" id="session" name="session">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="term">Term:</label>
                        <input type="text" class="form-control" id="term" name="term">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="hobbies">Hobbies:</label>
                        <input type="text" class="form-control" id="hobbies" name="hobbies">
                      </div>
                      <div class="col-md-12 d-flex">
                        <div class="col-md-6 text-start">
                          <button type="button" class="btn btn-secondary shadow" onclick="prevTab('personal-tab')">Previous</button>
                        </div>
                        <div class="col-md-6 text-end ms-auto">
                          <button type="button" class="btn btn-primary shadow" onclick="nextTab('guardian-tab')">Next</button>
                        </div>
                      </div>


                    </div>
                  </div>

                  <!-- Tab 3: Guardian & Health -->
                  <div class="tab-pane fade" id="guardian" role="tabpanel" aria-labelledby="guardian-tab">
                    <div class="p-3 row">
                      <h6>Step 3: Guardian & Health Information</h6>
                      <div class="form-group mb-3 col-md-3">
                        <label for="gname">Guardian Name:</label>
                        <input type="text" class="form-control" id="gname" name="gname">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="mobile">Guardian Mobile:</label>
                        <input type="text" class="form-control" id="mobile" name="mobile">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="goccupation">Guardian Occupation:</label>
                        <input type="text" class="form-control" id="goccupation" name="goccupation">
                      </div>
                      <div class="form-group mb-3 col-md-3">
                        <label for="grelationship">Guardian Relationship:</label>
                        <input type="text" class="form-control" id="grelationship" name="grelationship">
                      </div>
                      <div class="form-group mb-3 col-md-12">
                        <label for="gaddress">Guardian Address:</label>
                        <textarea name="gaddress" id="gaddress" class="form-control"></textarea>
                      </div>

                      <hr>
                      <h6>Health Information</h6>
                      <div class="form-group mb-3 col-md-2">
                        <label for="bloodtype">Blood Type:</label>
                        <input type="text" class="form-control" id="bloodtype" name="bloodtype">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="bloodgroup">Blood Group:</label>
                        <input type="text" class="form-control" id="bloodgroup" name="bloodgroup">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="height">Height (cm):</label>
                        <input type="text" class="form-control" id="height" name="height">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="weight">Weight (kg):</label>
                        <input type="text" class="form-control" id="weight" name="weight">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="sickle">Sickle Cell Status:</label>
                        <input type="text" class="form-control" id="sickle" name="sickle">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="challenge">Physical Challenge (if any):</label>
                        <input type="text" class="form-control" id="challenge" name="challenge">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="emergency">Emergency Contact Name:</label>
                        <input type="text" class="form-control" id="emergency" name="emergency">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="familydoc">Family Doctor Name:</label>
                        <input type="text" class="form-control" id="familydoc" name="familydoc">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="docaddress">Doctor's Address:</label>
                        <input type="text" class="form-control" id="docaddress" name="docaddress">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="docmobile">Doctor's Mobile:</label>
                        <input type="text" class="form-control" id="docmobile" name="docmobile">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="polio">Polio Vaccination:</label>
                        <input type="text" class="form-control" id="polio" name="polio">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="tuberculosis">Tuberculosis Vaccination:</label>
                        <input type="text" class="form-control" id="tuberculosis" name="tuberculosis">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="measles">Measles Vaccination:</label>
                        <input type="text" class="form-control" id="measles" name="measles">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="tetanus">Tetanus Vaccination:</label>
                        <input type="text" class="form-control" id="tetanus" name="tetanus">
                      </div>
                      <div class="form-group mb-3 col-md-2">
                        <label for="whooping">Whooping Cough Vaccination:</label>
                        <input type="text" class="form-control" id="whooping" name="whooping">
                      </div>

                      <div class="col-md-12 d-flex">
                        <div class="col-md-6 text-start">
                          <button type="button" class="btn btn-secondary shadow" onclick="prevTab('academic-tab')">Previous</button>
                        </div>
                        <div class="col-md-6 text-end ms-auto">
                          <button type="button" class="btn btn-primary shadow" onclick="nextTab('documents-tab')">Next</button>
                        </div>
                      </div>


                    </div>
                  </div>

                  <!-- Tab 4: Document Upload -->
                  <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                    <div class="p-3 row">
                      <h6>Step 4: Document Upload</h6>
                      <div class="d-lg-flex">
                        <div class="form-group mb-3 me-3 col-md-6">
                          <label for="passport_path">Upload Passport Photo:</label>
                          <input type="file" class="form-control" id="passport_path" name="passport_path" accept="image/*" required>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                          <label for="transcript_path">Upload Transcripts (PDF/Image):</label>
                          <input type="file" class="form-control " id="transcript_path" name="transcript_path" accept=".pdf,image/*" required>
                        </div>
                      </div>

                      <div class="col-md-12 d-flex">
                        <div class="col-md-6 text-start">
                          <button type="button" class="btn btn-secondary shadow" onclick="prevTab('guardian-tab')">Previous</button>
                        </div>
                        <div class="col-md-6 text-end ms-auto">
                          <?php if ($registration_cost > 0): ?>
                            <button type="button" id="payAndSubmitBtn" class="btn btn-success shadow">Pay NGN <?php echo htmlspecialchars(number_format($registration_cost, 2)); ?> & Submit Application</button>
                          <?php else: ?>
                            <button type="submit" name="action" value="submit_application" class="btn btn-success shadow">Submit Application</button>
                          <?php endif; ?>
                        </div>
                      </div>



                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

      <script>
        function nextTab(tabId) {
            var someTabTriggerEl = document.querySelector('#' + tabId)
            var tab = new bootstrap.Tab(someTabTriggerEl)
            tab.show()
        }

        function prevTab(tabId) {
            var someTabTriggerEl = document.querySelector('#' + tabId)
            var tab = new bootstrap.Tab(someTabTriggerEl)
            tab.show()
        }
    </script>

    <?php if ($registration_cost > 0): ?>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
        <script>
            document.getElementById('payAndSubmitBtn')?.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default form submission

                var form = document.querySelector('form');
                var formData = new FormData(form);

                // Basic validation for required fields before payment
                var name = formData.get('name');
                var email = formData.get('email');
                var dob = formData.get('dob');
                var placeob = formData.get('placeob');
                var gender = formData.get('gender');
                var schoolname = formData.get('schoolname');
                var passport_path = formData.get('passport_path');
                var transcript_path = formData.get('transcript_path');

                if (!name || !email || !dob || !placeob || !gender || !schoolname || !passport_path || !transcript_path) {
                    alert('Please fill in all required fields in all tabs before proceeding to payment.');
                    return;
                }

                var amount = parseFloat(<?php echo json_encode($registration_cost); ?>);
                var tx_ref = "ADM-TX-" + Math.floor(Math.random() * 1000000000) + "-" + Date.now();

                // Collect all form data to pass to the callback
                var applicationData = {};
                for (var pair of formData.entries()) {
                    if (pair[0] !== 'passport_path' && pair[0] !== 'transcript_path') { // Exclude files for direct JSON
                        applicationData[pair[0]] = pair[1];
                    }
                }
                applicationData['tx_ref'] = tx_ref;
                applicationData['amount'] = amount;
                applicationData['type'] = 'admission_form';

                var encodedApplicationData = btoa(JSON.stringify(applicationData));

                FlutterwaveCheckout({
                    public_key: <?php echo json_encode($flutterwave_public_key); ?>,
                    tx_ref: tx_ref,
                    amount: amount,
                    currency: "NGN",
                    country: "NG",
                    payment_options: "card, mobilemoney,banktransfer, ussd",
                    customer: {
                        email: email,
                        name: name
                    },
                    callback: function(data) {
                        if (data.status === 'successful') {
                            // Append payment details to form data and submit
                            var hiddenTxRef = document.createElement('input');
                            hiddenTxRef.type = 'hidden';
                            hiddenTxRef.name = 'flw_tx_ref';
                            hiddenTxRef.value = data.tx_ref;
                            form.appendChild(hiddenTxRef);

                            var hiddenTransactionId = document.createElement('input');
                            hiddenTransactionId.type = 'hidden';
                            hiddenTransactionId.name = 'flw_transaction_id';
                            hiddenTransactionId.value = data.transaction_id;
                            form.appendChild(hiddenTransactionId);

                            var hiddenPaymentStatus = document.createElement('input');
                            hiddenPaymentStatus.type = 'hidden';
                            hiddenPaymentStatus.name = 'flw_status';
                            hiddenPaymentStatus.value = data.status;
                            form.appendChild(hiddenPaymentStatus);

                            // Submit the form after successful payment
                            form.submit();

                        } else if (data.status === 'cancelled') {
                            alert('Payment cancelled. Please try again.');
                        } else {
                            alert('Payment failed. Please try again.');
                        }
                    },
                    onclose: function() {
                        // User closed the payment modal
                        console.log('Payment modal closed by user.');
                    },
                    customizations: {
                        title: "Admission Form Payment",
                        description: "Payment for " + name + "'s Admission Form",
                        logo: "https://your-school-logo.com/logo.png" // Replace with your school logo
                    }
                });
            });
        </script>
    <?php endif; ?>

    <script>
        // Handle messages from process_application_portal.php
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');

            if (status && message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${status === 'successful' ? 'success' : 'danger'} mt-3`;
                alertDiv.textContent = message;
                document.querySelector('.container-fluid').prepend(alertDiv);

                // Remove status and message from URL
                urlParams.delete('status');
                urlParams.delete('message');
                const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>

  <?php include 'components/scripts.php'; ?>

</body>

</html>
