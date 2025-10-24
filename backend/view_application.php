<?php
session_start();
include('db_connection.php');
require_once('../classes/OnlineApplicationPortalClass.php');

$module_name = "Admissions Module";
$page_title = $module_name . " - View Application";



$appPortal = new OnlineApplicationPortal($conn);

$application_id = isset($_GET['id']) ? $_GET['id'] : ''; // Application ID is VARCHAR
if (empty($application_id)) {
  $_SESSION['error_message'] = "Invalid application ID.";
  header("Location: ../online_application_portal.php");
  exit();
}

$application_data = $appPortal->getStudentApplicationById($application_id);
if (!$application_data) {
  $_SESSION['error_message'] = "Application not found.";
  header("Location: ../online_application_portal.php");
  exit();
}

$exam_details = null;
if ($application_data['entrance_exam_scheduled']) {
  $exam_details = $appPortal->getEntranceExamDetails($application_id);
}


// Fetch the logged-in Staff name
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($student_name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include('adminnav.php'); ?>

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <?php include('logo_header.php'); ?>
        </div>
        <?php include('navbar.php'); ?>
      </div>

      <div class="container">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title">View Applications</h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="#">
                  <i class="icon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="#">Admission</a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
               <li class="nav-item">
                <a href="manage_applications.php">Manage Applications</a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="#">View Applications</a>
              </li>
            </ul>
          </div>
          <div class="page-category">

            <div class="row">
              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Application Details for #<?php echo htmlspecialchars($application_data['id']); ?></h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <h5>Personal Information</h5>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($application_data['name']); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($application_data['dob']); ?></p>
                        <p><strong>Place of Birth:</strong> <?php echo htmlspecialchars($application_data['placeob']); ?></p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($application_data['gender']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($application_data['email']); ?></p>
                        <p><strong>Student Mobile:</strong> <?php echo htmlspecialchars($application_data['studentmobile']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($application_data['address']); ?></p>
                        <p><strong>Religion:</strong> <?php echo htmlspecialchars($application_data['religion']); ?></p>
                        <p><strong>State:</strong> <?php echo htmlspecialchars($application_data['state']); ?></p>
                        <p><strong>LGA:</strong> <?php echo htmlspecialchars($application_data['lga']); ?></p>
                      </div>
                      <div class="col-md-6">
                        <h5>Academic Background</h5>
                        <p><strong>Last School Attended:</strong> <?php echo htmlspecialchars($application_data['schoolname']); ?></p>
                        <p><strong>School Address:</strong> <?php echo htmlspecialchars($application_data['schooladdress']); ?></p>
                        <p><strong>Last Class Attended:</strong> <?php echo htmlspecialchars($application_data['lastclass']); ?></p>
                        <p><strong>Session:</strong> <?php echo htmlspecialchars($application_data['session']); ?></p>
                        <p><strong>Term:</strong> <?php echo htmlspecialchars($application_data['term']); ?></p>
                        <p><strong>Hobbies:</strong> <?php echo htmlspecialchars($application_data['hobbies']); ?></p>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <h5>Guardian Information</h5>
                        <p><strong>Guardian Name:</strong> <?php echo htmlspecialchars($application_data['gname']); ?></p>
                        <p><strong>Guardian Mobile:</strong> <?php echo htmlspecialchars($application_data['mobile']); ?></p>
                        <p><strong>Guardian Occupation:</strong> <?php echo htmlspecialchars($application_data['goccupation']); ?></p>
                        <p><strong>Guardian Address:</strong> <?php echo htmlspecialchars($application_data['gaddress']); ?></p>
                        <p><strong>Guardian Relationship:</strong> <?php echo htmlspecialchars($application_data['grelationship']); ?></p>
                      </div>
                      <div class="col-md-6">
                        <h5>Health Information</h5>
                        <p><strong>Blood Type:</strong> <?php echo htmlspecialchars($application_data['bloodtype']); ?></p>
                        <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($application_data['bloodgroup']); ?></p>
                        <p><strong>Height:</strong> <?php echo htmlspecialchars($application_data['height']); ?></p>
                        <p><strong>Weight:</strong> <?php echo htmlspecialchars($application_data['weight']); ?></p>
                        <p><strong>Sickle Cell Status:</strong> <?php echo htmlspecialchars($application_data['sickle']); ?></p>
                        <p><strong>Physical Challenge:</strong> <?php echo htmlspecialchars($application_data['challenge']); ?></p>
                        <p><strong>Emergency Contact:</strong> <?php echo htmlspecialchars($application_data['emergency']); ?></p>
                        <p><strong>Family Doctor:</strong> <?php echo htmlspecialchars($application_data['familydoc']); ?></p>
                        <p><strong>Doctor's Address:</strong> <?php echo htmlspecialchars($application_data['docaddress']); ?></p>
                        <p><strong>Doctor's Mobile:</strong> <?php echo htmlspecialchars($application_data['docmobile']); ?></p>
                        <p><strong>Polio Vaccination:</strong> <?php echo htmlspecialchars($application_data['polio']); ?></p>
                        <p><strong>Tuberculosis Vaccination:</strong> <?php echo htmlspecialchars($application_data['tuberculosis']); ?></p>
                        <p><strong>Measles Vaccination:</strong> <?php echo htmlspecialchars($application_data['measles']); ?></p>
                        <p><strong>Tetanus Vaccination:</strong> <?php echo htmlspecialchars($application_data['tetanus']); ?></p>
                        <p><strong>Whooping Cough Vaccination:</strong> <?php echo htmlspecialchars($application_data['whooping']); ?></p>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <h5>Uploaded Documents</h5>
                        <?php if (!empty($application_data['passport_path'])): ?>
                          <p><strong>Passport Photo:</strong> <a href="<?php echo htmlspecialchars($application_data['passport_path']); ?>" target="_blank">View Passport</a></p>
                          <img src="../<?php echo htmlspecialchars($application_data['passport_path']); ?>" alt="Passport Photo" style="max-width: 150px; border: 1px solid #ddd; padding: 5px;">
                        <?php else: ?>
                          <p>No passport photo uploaded.</p>
                        <?php endif; ?>
                        <?php if (!empty($application_data['transcript_path'])): ?>
                          <p><strong>Transcripts:</strong> <a href="../<?php echo htmlspecialchars($application_data['transcript_path']); ?>" target="_blank">View Transcripts</a></p>
                        <?php else: ?>
                          <p>No transcripts uploaded.</p>
                        <?php endif; ?>
                      </div>
                      <div class="col-md-6">
                        <h5>Admission Status & Assigned Details</h5>
                        <p><strong>Current Admission Status:</strong> <span class="badge bg-info"><?php echo htmlspecialchars($application_data['admission_status']); ?></span></p>
                        <?php if ($application_data['admission_status'] === 'approved'): ?>
                          <p><strong>Assigned Student ID:</strong> <?php echo htmlspecialchars($application_data['assigned_student_id']); ?></p>
                          <p><strong>Assigned Class:</strong> <?php echo htmlspecialchars($application_data['assigned_class']); ?></p>
                          <p><strong>Assigned Arm:</strong> <?php echo htmlspecialchars($application_data['assigned_arm']); ?></p>
                          <p><strong>Assigned Hostel:</strong> <?php echo htmlspecialchars($application_data['assigned_hostel']); ?></p>
                          <p><strong>Assigned Password:</strong> ********</p>
                        <?php endif; ?>

                        <?php if ($application_data['entrance_exam_scheduled'] && $exam_details): ?>
                          <p><strong>Entrance Exam Scheduled:</strong> Yes</p>
                          <p><strong>Exam Date:</strong> <?php echo htmlspecialchars($exam_details['exam_date']); ?></p>
                          <p><strong>Exam Time:</strong> <?php echo htmlspecialchars($exam_details['exam_time']); ?></p>
                          <p><strong>Exam Location:</strong> <?php echo htmlspecialchars($exam_details['exam_location']); ?></p>
                          <p><strong>Exam Status:</strong> <?php echo htmlspecialchars($exam_details['status']); ?></p>
                          <?php if (!empty($exam_details['exam_result'])): ?>
                            <p><strong>Exam Result:</strong> <?php echo htmlspecialchars($exam_details['exam_result']); ?></p>
                          <?php endif; ?>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="mt-4">
                      <!-- <a href="online_application_portal.php" class="btn btn-secondary">Back to Applications</a> -->
                      <?php if ($application_data['admission_status'] === 'pending' || $application_data['admission_status'] === 'exam_scheduled'): ?>
                        <a href="assign_admin_details.php?id=<?php echo htmlspecialchars($application_id); ?>" class="btn btn-primary">Take Action</a>
                      <?php endif; ?>
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
  </div>
  <?php include('scripts.php'); ?>
</body>

</html>