<?php
session_start();
include('db_connection.php');
require_once('../classes/AdmissionSettingsClass.php'); // Include the class file


if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}


$module_name = "Admissions Module";
$page_title = $module_name . " - Admission Settings";

$admissionSettings = new AdmissionSettings($conn);

$registration_cost = $admissionSettings->getSetting('registration_cost');
$flutterwave_public_key = $admissionSettings->getSetting('flutterwave_public_key');
$flutterwave_secret_key = $admissionSettings->getSetting('flutterwave_secret_key');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_settings') {
  $new_registration_cost = $_POST['registration_cost'];
  $new_flutterwave_public_key = $_POST['flutterwave_public_key'];
  $new_flutterwave_secret_key = $_POST['flutterwave_secret_key'];

  $success = true;
  if (!$admissionSettings->saveSetting('registration_cost', $new_registration_cost)) {
    $success = false;
  }
  if (!$admissionSettings->saveSetting('flutterwave_public_key', $new_flutterwave_public_key)) {
    $success = false;
  }
  if (!$admissionSettings->saveSetting('flutterwave_secret_key', $new_flutterwave_secret_key)) {
    $success = false;
  }

  if ($success) {
    $_SESSION['success_message'] = "Settings updated successfully!";
  } else {
    $_SESSION['error_message'] = "Failed to update some settings.";
  }
  header("Location: admission_settings.php");
  exit();
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
            <h4 class="page-title">Admission Settings</h4>
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
                <a href="#">Bursary</a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="#">Admission Settings</a>
              </li>
            </ul>
          </div>
          <div class="page-category">

            <div class="row">
              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Registration Form Settings</h6>
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

                    <form action="admission_settings.php" method="POST">
                      <div class="form-group mb-3">
                        <label for="registration_cost">Registration Form Cost (e.g., NGN):</label>
                        <input type="number" step="0.01" class="form-control" id="registration_cost" name="registration_cost" value="<?php echo htmlspecialchars($registration_cost); ?>" required>
                      </div>
                      <div class="form-group mb-3">
                        <label for="flutterwave_public_key">Flutterwave Public Key:</label>
                        <input type="text" class="form-control" id="flutterwave_public_key" name="flutterwave_public_key" value="<?php echo htmlspecialchars($flutterwave_public_key); ?>">
                      </div>
                      <div class="form-group mb-3">
                        <label for="flutterwave_secret_key">Flutterwave Secret Key:</label>
                        <input type="text" class="form-control" id="flutterwave_secret_key" name="flutterwave_secret_key" value="<?php echo htmlspecialchars($flutterwave_secret_key); ?>">
                      </div>
                      <button type="submit" name="action" value="save_settings" class="btn btn-primary">Save Settings</button>
                    </form>
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