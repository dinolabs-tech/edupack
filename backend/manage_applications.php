<?php
session_start();
include('db_connection.php');
require_once('../classes/OnlineApplicationPortalClass.php'); // Include the class file
require_once('../classes/AdmissionSettingsClass.php'); // Include the AdmissionSettingsClass

$appPortal = new OnlineApplicationPortal($conn);
$applications = $appPortal->getAllApplications(); // Fetch all applications

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
            <h4 class="page-title">Manage Applications</h4>
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
                <a href="#">Manage Applications</a>
              </li>
            </ul>
          </div>
          <div class="page-category">

            <div class="row">
              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Manage Online Applications</h6>
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

                    <p>This page allows administrators to manage student applications, review submitted forms, and track application status.</p>

                    <!-- Admin View: Display and Manage Applications -->
                    <div class="mt-4">
                      <?php if (!empty($applications)): ?>
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped" id="basic-datatables">
                            <thead>
                              <tr>
                                <th>App ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($applications as $app): ?>
                                <tr>
                                  <td><?php echo htmlspecialchars($app['id']); ?></td>
                                  <td><?php echo htmlspecialchars($app['name']); ?></td>
                                  <td><?php echo htmlspecialchars($app['email']); ?></td>
                                  <td><?php echo htmlspecialchars($app['admission_status']); ?></td>
                                  <td>
                                    <a href="view_application.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-info">View</a>
                                    <?php if ($app['admission_status'] === 'pending' || $app['admission_status'] === 'exam_scheduled'): ?>
                                      <a href="assign_admin_details.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-success">Review & Act</a>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      <?php else: ?>
                        <p>No applications found.</p>
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