<?php
session_start();
include('db_connection.php');
require_once('../classes/OnlineApplicationPortalClass.php');
require_once('../includes/mail_sender.php');

$module_name = "Admissions Module";
$page_title = $module_name . " - Review & Act on Application";

$appPortal = new OnlineApplicationPortal($conn);

// Fetch classes for dropdown
$classes = [];
$sql_classes = "SELECT DISTINCT class FROM class ORDER BY class";
$result_classes = $conn->query($sql_classes);
if ($result_classes && $result_classes->num_rows > 0) {
    while ($row = $result_classes->fetch_assoc()) {
        $classes[] = $row['class'];
    }
}

// Fetch arms for dropdown
$arms = [];
$sql_arms = "SELECT DISTINCT arm FROM arm ORDER BY arm";
$result_arms = $conn->query($sql_arms);
if ($result_arms && $result_arms->num_rows > 0) {
    while ($row = $result_arms->fetch_assoc()) {
        $arms[] = $row['arm'];
    }
}

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

// Handle POST requests for various actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'assign_and_approve') {
    $student_id = $_POST['student_id'] ?? '';
    $class = $_POST['class'] ?? '';
    $arm = $_POST['arm'] ?? '';
    $hostel = $_POST['hostel'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($student_id) || empty($class) || empty($arm) || empty($hostel) || empty($password)) {
      $_SESSION['error_message'] = "All assignment fields are required.";
    } else {
      // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $result = $appPortal->assignAdminDetailsAndApprove($application_id, $student_id, $class, $arm, $hostel, $password);

      if ($result) {
        $_SESSION['success_message'] = "Application ID " . htmlspecialchars($application_id) . " approved and student details assigned successfully.";

        // Send approval email
        $applicant_email = $application_data['email'];
        $applicant_name = $application_data['name'];
        $subject = "Congratulations! Your Application to EduPack School Has Been Approved!";
        $body = "
                    <p>Dear {$applicant_name},</p>
                    <p>We are thrilled to inform you that your application (ID: <strong>{$application_id}</strong>) to EduPack School has been approved!</p>
                    <p>Your assigned Student ID is: <strong>{$student_id}</strong></p>
                    <p>Your assigned Class: <strong>{$class} {$arm}</strong></p>
                    <p>Your assigned Hostel type: <strong>{$hostel}</strong></p>
                    <p>Your temporary password for the student portal is: <strong>{$password}</strong>. Please change this immediately upon first login.</p>
                    <p>Welcome to the EduPack family!</p>
                    <p>Best regards,<br>EduPack Admissions Team</p>
                ";
        sendEmail($applicant_email, $applicant_name, $subject, $body);

        header("Location: manage_applications.php");
        exit();
      } else {
        $_SESSION['error_message'] = "Failed to approve application and assign student details.";
      }
    }
  } elseif ($action === 'reject_application') {
    if ($appPortal->updateApplicationStatus($application_id, 'rejected')) {
      $_SESSION['success_message'] = "Application ID " . htmlspecialchars($application_id) . " rejected successfully.";

      // Send rejection email
      $applicant_email = $application_data['email'];
      $applicant_name = $application_data['name'];
      $subject = "Update on Your Application to EduPack School";
      $body = "
                <p>Dear {$applicant_name},</p>
                <p>Thank you for your interest in EduPack School. We regret to inform you that your application (ID: <strong>{$application_id}</strong>) has been rejected at this time.</p>
                <p>We wish you the best in your future endeavors.</p>
                <p>Best regards,<br>EduPack Admissions Team</p>
            ";
      sendEmail($applicant_email, $applicant_name, $subject, $body);

      header("Location: manage_applications.php");
      exit();
    } else {
      $_SESSION['error_message'] = "Failed to reject application.";
    }
  } elseif ($action === 'schedule_exam') {
    $exam_date = $_POST['exam_date'] ?? '';
    $exam_time = $_POST['exam_time'] ?? '';
    $exam_location = $_POST['exam_location'] ?? '';

    if (empty($exam_date) || empty($exam_time) || empty($exam_location)) {
      $_SESSION['error_message'] = "All exam scheduling fields are required.";
    } else {
      if ($appPortal->scheduleEntranceExam($application_id, $exam_date, $exam_time, $exam_location)) {
        $_SESSION['success_message'] = "Entrance exam scheduled for application ID " . htmlspecialchars($application_id) . ".";

        // Send exam scheduling email
        $applicant_email = $application_data['email'];
        $applicant_name = $application_data['name'];
        $subject = "Entrance Exam Scheduled for Your EduPack School Application";
        $body = "
                    <p>Dear {$applicant_name},</p>
                    <p>An entrance exam has been scheduled for your application (ID: <strong>{$application_id}</strong>) to EduPack School.</p>
                    <p><strong>Exam Date:</strong> " . htmlspecialchars($exam_date) . "</p>
                    <p><strong>Exam Time:</strong> " . htmlspecialchars($exam_time) . "</p>
                    <p><strong>Exam Location:</strong> " . htmlspecialchars($exam_location) . "</p>
                    <p>Please prepare accordingly. We wish you the best of luck!</p>
                    <p>Best regards,<br>EduPack Admissions Team</p>
                ";
        sendEmail($applicant_email, $applicant_name, $subject, $body);

        header("Location: manage_applications.php");
        exit();
      } else {
        $_SESSION['error_message'] = "Failed to schedule entrance exam.";
      }
    }
  } elseif ($action === 'approve_without_exam') {
    // Generate a temporary student ID and password for direct approval
    $temp_student_id = 'STU-' . uniqid();
    $temp_password = substr(md5(uniqid(mt_rand(), true)), 0, 8); // 8-character alphanumeric

    if ($appPortal->assignAdminDetailsAndApprove($application_id, $temp_student_id, 'N/A', 'N/A', 'N/A', password_hash($temp_password, PASSWORD_DEFAULT))) {
      $_SESSION['success_message'] = "Application ID " . htmlspecialchars($application_id) . " approved without exam and temporary details assigned.";

      // Send approval email
      $applicant_email = $application_data['email'];
      $applicant_name = $application_data['name'];
      $subject = "Congratulations! Your Application to EduPack School Has Been Approved!";
      $body = "
                <p>Dear {$applicant_name},</p>
                <p>We are thrilled to inform you that your application (ID: <strong>{$application_id}</strong>) to EduPack School has been approved without an entrance exam!</p>
                <p>Your assigned Student ID is: <strong>{$temp_student_id}</strong></p>
                <p>Your temporary password for the student portal is: <strong>{$temp_password}</strong>. Please change this immediately upon first login.</p>
                <p>Welcome to the EduPack family!</p>
                <p>Best regards,<br>EduPack Admissions Team</p>
            ";
      sendEmail($applicant_email, $applicant_name, $subject, $body);

      header("Location: manage_applications.php");
      exit();
    } else {
      $_SESSION['error_message'] = "Failed to approve application without exam.";
    }
  }
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
            <h4 class="page-title">Review Applications</h4>
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
                <a href="#">Review Applications</a>
              </li>
            </ul>
          </div>
          <div class="page-category">

            <div class="row">
              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Review Application ID: <?php echo htmlspecialchars($application_id); ?></h6>
                  </div>
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

                    <div class="row">
                      <div class="col-md-6">
                        <h5 class="fw-bold">Applicant Details
                          <hr>
                        </h5>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($application_data['name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($application_data['email']); ?></p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($application_data['gender']); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($application_data['dob']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($application_data['address']); ?></p>
                        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($application_data['studentmobile']); ?></p>
                        <p><strong>Current Admission Status:</strong> <span class="badge bg-info"><?php echo htmlspecialchars($application_data['admission_status']); ?></span></p>
                        <?php if ($application_data['entrance_exam_scheduled']):
                          $exam_details = $appPortal->getEntranceExamDetails($application_id);
                          if ($exam_details):
                        ?>
                            <p><strong>Entrance Exam Scheduled:</strong> Yes</p>
                            <p><strong>Exam Date:</strong> <?php echo htmlspecialchars($exam_details['exam_date']); ?></p>
                            <p><strong>Exam Time:</strong> <?php echo htmlspecialchars($exam_details['exam_time']); ?></p>
                            <p><strong>Exam Location:</strong> <?php echo htmlspecialchars($exam_details['exam_location']); ?></p>
                        <?php endif;
                        endif; ?>
                      </div>
                      <div class="col-md-6">
                        <h5 class="fw-bold">Uploaded Documents
                          <hr>
                        </h5>
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>



            <?php if ($application_data['admission_status'] === 'pending' || $application_data['admission_status'] === 'exam_scheduled'): ?>
              <h5 class="fw-bold text-center">Admin Actions</h5>


              <div class="row">
                <!-- Option 1: Assign Details and Approve -->
                <div class="col-md-12">
                  <div class="card shadow mb-3">
                    <div class="card-header fw-bold">Assign Details & Approve</div>
                    <div class="card-body">
                      <form action="assign_admin_details.php?id=<?php echo htmlspecialchars($application_id); ?>" method="POST" class="row">
                        <input type="hidden" name="action" value="assign_and_approve">
                        <div class="form-group mb-3 col-md-4">
                          <input type="text" placeholder="Student ID" class="form-control" id="student_id" name="student_id" required value="<?php echo htmlspecialchars($application_data['assigned_student_id'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3 col-md-4">
                          <select class="form-control form-select" id="class" name="class" required>
                            <option value="" selected disabled>Select Class</option>
                            <?php foreach ($classes as $class_option): ?>
                              <option value="<?php echo htmlspecialchars($class_option); ?>" <?php echo (isset($application_data['assigned_class']) && $application_data['assigned_class'] == $class_option) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class_option); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group mb-3 col-md-4">
                          <select class="form-control form-select" id="arm" name="arm" required>
                            <option value="" selected disabled>Select Arm</option>
                            <?php foreach ($arms as $arm_option): ?>
                              <option value="<?php echo htmlspecialchars($arm_option); ?>" <?php echo (isset($application_data['assigned_arm']) && $application_data['assigned_arm'] == $arm_option) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($arm_option); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group mb-3 col-md-4">
                          <select class="form-control form-select" id="hostel" name="hostel" required>
                            <option value="" selected disabled>Select Hostel (Day or Boarding)</option>
                            <option value="Day" <?php echo (isset($application_data['assigned_hostel']) && $application_data['assigned_hostel'] == 'Day') ? 'selected' : ''; ?>>Day</option>
                            <option value="Boarding" <?php echo (isset($application_data['assigned_hostel']) && $application_data['assigned_hostel'] == 'Boarding') ? 'selected' : ''; ?>>Boarding</option>
                          </select>
                        </div>
                        <div class="form-group mb-3 col-md-4">
                          <input type="text" class="form-control" id="password" name="password" required placeholder="Generate or enter a temporary password">
                        </div>
                        <div class="form-group mb-3 col-md-4">
                          <button type="submit" class="btn btn-success">Assign Details & Approve</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <!-- Option 2: Schedule Entrance Exam -->
                <?php if ($application_data['admission_status'] === 'pending'): ?>
                  <div class="col-md-4">
                    <div class="card shadow mb-3">
                      <div class="card-header">Schedule Entrance Exam</div>
                      <div class="card-body">
                        <form action="assign_admin_details.php?id=<?php echo htmlspecialchars($application_id); ?>" method="POST" class="row">
                          <input type="hidden" name="action" value="schedule_exam">
                          <div class="form-group mb-3 col-md-6">
                            <label for="exam_date">Exam Date:</label>
                            <input type="date" class="form-control" id="exam_date" name="exam_date" required>
                          </div>
                          <div class="form-group mb-3 col-md-6">
                            <label for="exam_time">Exam Time:</label>
                            <input type="time" class="form-control" id="exam_time" name="exam_time" required>
                          </div>
                          <div class="form-group mb-3">
                            <input type="text" placeholder="Exam Location" class="form-control" id="exam_location" name="exam_location" required>
                          </div>
                          <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-warning">Schedule Exam</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

                <!-- Option 3: Approve without Entrance Exam -->
                <?php if ($application_data['admission_status'] === 'pending'): ?>
                  <div class="col-md-4">
                    <div class="card shadow mb-3">
                      <div class="card-header">Approve Without Entrance Exam</div>
                      <div class="card-body">
                        <p>This will approve the application directly, assigning a temporary student ID and password.</p>
                        <form action="assign_admin_details.php?id=<?php echo htmlspecialchars($application_id); ?>" method="POST" onsubmit="return confirm('Are you sure you want to approve this application without an entrance exam?');">
                          <input type="hidden" name="action" value="approve_without_exam">
                          <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success">Approve Without Exam</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

                <!-- Option 4: Reject Application -->
                <div class="col-md-4 card shadow mb-3">
                  <div class="card-header">Reject Application</div>
                  <div class="card-body">
                    <p>This will permanently reject the application.</p>
                    <form action="assign_admin_details.php?id=<?php echo htmlspecialchars($application_id); ?>" method="POST" onsubmit="return confirm('Are you sure you want to reject this application? This action cannot be undone.');">
                      <input type="hidden" name="action" value="reject_application">

                      <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-danger">Reject Application</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            <?php else: ?>
              <div class="alert alert-info">
                This application has already been <?php echo htmlspecialchars($application_data['admission_status']); ?>. No further actions are available.
              </div>
            <?php endif; ?>




          </div>
        </div>
      </div>

      <?php include('footer.php'); ?>
    </div>
  </div>
  <?php include('scripts.php'); ?>
</body>

</html>
