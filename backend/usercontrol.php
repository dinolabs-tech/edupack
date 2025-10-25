<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to maintain user state
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Database connection
include 'db_connection.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$edit_mode = false;
$edit_data = [];

if (isset($_GET['edit_id'])) {
  $edit_id = intval($_GET['edit_id']);
  $edit_mode = true;

  $stmt = $conn->prepare("SELECT staffname, username, password, role, type FROM login WHERE id = ?");
  $stmt->bind_param("i", $edit_id);
  $stmt->execute();
  $stmt->bind_result($edit_name, $edit_username, $edit_password, $edit_role, $edit_type);
  $stmt->fetch();
  $stmt->close();
}


$message = "";

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  // Check if the logged-in user is an Admin or Superuser
  if ($_SESSION['role'] === 'Administrator' || $_SESSION['role'] === 'Superuser') {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM login WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
      $message = "Record deleted successfully!";
    } else {
      $message = "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
  } else {
    $message = "You do not have permission to delete accounts.";
  }
}

// Handle account status change request (deactivate/activate)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id_status'], $_POST['new_status'])) {
  // Check if the logged-in user is an Admin or Superuser
  if ($_SESSION['role'] === 'Administrator' || $_SESSION['role'] === 'Superuser') {
    $user_id_status = intval($_POST['user_id_status']);
    $new_status = intval($_POST['new_status']); // 0 for deactivate, 1 for activate

    // Prevent Superuser from deactivating themselves or other Superusers
    $stmt_check_role = $conn->prepare("SELECT role FROM login WHERE id = ?");
    $stmt_check_role->bind_param("i", $user_id_status);
    $stmt_check_role->execute();
    $stmt_check_role->bind_result($target_user_role);
    $stmt_check_role->fetch();
    $stmt_check_role->close();

    if ($target_user_role === 'Superuser' && $_SESSION['role'] !== 'Superuser') {
      $message = "You do not have permission to change the status of a Superuser account.";
    } elseif ($user_id_status == $_SESSION['user_id'] && $new_status == 0) {
      $message = "You cannot deactivate your own account.";
    } else {
      $stmt = $conn->prepare("UPDATE login SET status = ? WHERE id = ?");
      $stmt->bind_param("ii", $new_status, $user_id_status);

      if ($stmt->execute()) {
        $message = "Account status updated successfully!";
      } else {
        $message = "Error updating account status: " . $stmt->error;
      }
      $stmt->close();
    }
  } else {
    $message = "You do not have permission to change account status.";
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['username'], $_POST['password'], $_POST['role'])) {
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $role = $_POST['role'];
  // Get the type from the form if available, otherwise default to 'staff'
  $type = isset($_POST['type']) ? $_POST['type'] : 'staff';

  // Basic validation (removed $type from compulsory check)
  if (empty($name) || empty($username) || empty($password) || empty($role)) {
    $message = "Please fill in all required fields.";
  } else {
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
      // Update existing user
      $edit_id = intval($_POST['edit_id']);
      // Type is not editable for existing users, so we don't include it in the UPDATE statement
      $stmt = $conn->prepare("UPDATE login SET staffname=?, username=?, password=?, role=? WHERE id=?");
      $stmt->bind_param("ssssi", $name, $username, $password, $role, $edit_id);

      if ($stmt->execute()) {
        $message = "Record updated successfully!";
      } else {
        $message = "Error updating record: " . $stmt->error;
      }

      $stmt->close();
    } else {
      // Insert new user
      // Check if username already exists
      $check_stmt = $conn->prepare("SELECT id FROM login WHERE username = ?");
      $check_stmt->bind_param("s", $username);
      $check_stmt->execute();
      $check_stmt->store_result();

      if ($check_stmt->num_rows > 0) {
        $message = "Username already exists. Please choose another.";
      } else {
        // Only Superuser can create 'test' accounts
        if ($type === 'test' && $_SESSION['role'] !== 'Superuser') {
            $message = "Only Superusers can create 'test' accounts.";
        } else {
            $stmt = $conn->prepare("INSERT INTO login (staffname, username, password, role, type) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $username, $password, $role, $type);

            if ($stmt->execute()) {
              $message = "Record saved successfully!";
            } else {
              $message = "<script>alert('Error saving record: " . addslashes($stmt->error) . "');</script>";
            }

            $stmt->close();
        }
      }

      $check_stmt->close();
    }
  }
}



// Fetch data from the login table
// Fetch data from the login table
$sql = "SELECT id, staffname, username, role, status, type FROM login";
$params = [];
$types_str = "";

if ($_SESSION['role'] === 'Superuser') {
  // Superuser sees all
} elseif (isset($_SESSION['type']) && $_SESSION['type'] === 'test') {
  // Test accounts only see other test accounts
  $sql .= " WHERE type = ?";
  $params[] = 'test';
  $types_str .= "s";
} else {
  // Other roles do not see Superusers
  $sql .= " WHERE role != 'Superuser'";
}

$stmt = $conn->prepare($sql);
if ($stmt === false) {
  customErrorHandler(E_ERROR, "Error preparing statement: " . $conn->error, __FILE__, __LINE__);
  $users = [];
} else {
  if (!empty($params)) {
    $stmt->bind_param($types_str, ...$params);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  // Convert result set into an array so it can be looped over safely later
  $users = []; // Renamed from $students to $users for clarity
  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $users[] = $row;
    }
  }
  $stmt->close();
}

// Fetch the logged-in Staff name
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($student_name);
$stmt->fetch();
$stmt->close();


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
              <nts class="fw-bold mb-3">User Control</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">User-Control</li>
                </ol>
            </div>

          </div>

          <!-- BULK UPLOAD ============================ -->
          <div class="row">

            <div class="col-md-12">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Register</div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <div class="mb-4 mt-2">

                    <?php if (!empty($message)): ?>
                      <div class="alert alert-info"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <form method="POST" class="row g-2">
                      <input type="hidden" name="edit_id" value="<?php echo $edit_mode ? htmlspecialchars($_GET['edit_id']) : ''; ?>">
                      <div class="col-md-3">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Staff Name"
                          value="<?php echo $edit_mode ? htmlspecialchars($edit_name) : ''; ?>">
                      </div>
                      <div class="col-md-3">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                          value="<?php echo $edit_mode ? htmlspecialchars($edit_username) : ''; ?>">
                      </div>
                      <div class="col-md-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                          value="<?php echo $edit_mode ? htmlspecialchars($edit_password) : ''; ?>">
                      </div>
                      <div class="col-md-2">
                        <select id="role" name="role" class="form-select">
                          <option value="" selected disabled>Select Role</option>
                          <?php
                          $roles = ['Administrator', 'Tuckshop', 'Teacher', 'Bursary', 'Store', 'Library', 'Admission'];
                          foreach ($roles as $r) {
                            $selected = ($edit_mode && $edit_role === $r) ? 'selected' : '';
                            echo "<option value=\"$r\" $selected>$r</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <?php if ($_SESSION['role'] === 'Superuser'): ?>
                        <div class="col-md-2">
                          <select id="type" name="type" class="form-select" <?php echo $edit_mode ? 'disabled' : ''; ?>>
                            <option value="" selected disabled>Select Type</option>
                            <?php
                            $types = ['staff', 'test'];
                            foreach ($types as $t) {
                              $selected = ($edit_mode && $edit_type === $t) ? 'selected' : '';
                              // Only Superuser can create 'test' accounts
                              if ($t === 'test' && $_SESSION['role'] !== 'Superuser' && !$edit_mode) {
                                  continue;
                              }
                              echo "<option value=\"$t\" $selected>$t</option>";
                            }
                            ?>
                          </select>
                        </div>
                      <?php endif; ?>
                      <div class="col-md-12 text-center">
                        <button type="submit" class="ms-3 me-2 ps-1 btn btn-success btn-icon btn-round"><span class="btn-label">
                            <i class="fa fa-save"></i></button>
                        <a href="usercontrol.php" class="ps-1 btn btn-secondary btn-icon btn-round"><span class="btn-label">
                            <i class="fa fa-undo"></i></a>
                      </div>
                    </form>


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
                    <div class="card-title">Users</div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <div class="mb-4 mt-2">

                    <div class="table-responsive">
                      <table id="multi-filter-select" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th style="display: none;">ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <?php if ($_SESSION['role'] === 'Superuser'): ?>
                              <th>Type</th>
                            <?php endif; ?>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                              <tr>
                                <td style="display: none;"><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['staffname']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <?php if ($_SESSION['role'] === 'Superuser'): ?>
                                  <td><?php echo htmlspecialchars($user['type']); ?></td>
                                <?php endif; ?>
                                <td>
                                  <?php
                                  $status_text = ($user['status'] == 1) ? 'Active' : 'Inactive';
                                  $status_class = ($user['status'] == 1) ? 'badge bg-success' : 'badge bg-danger';
                                  echo "<span class=\"$status_class\">$status_text</span>";
                                  ?>
                                </td>
                                <td>
                                  <a href="?edit_id=<?php echo htmlspecialchars($user['id']); ?>"
                                    class="btn btn-warning btn-icon btn-round ps-1">
                                    <i class="fa fa-edit"></i>
                                  </a>

                                  <?php if ($_SESSION['role'] === 'Administrator' || $_SESSION['role'] === 'Superuser'): ?>
                                    <?php if ($user['status'] == 1): ?>
                                      <form method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id_status" value="<?php echo htmlspecialchars($user['id']); ?>">
                                        <input type="hidden" name="new_status" value="0">
                                        <button type="submit" class="btn btn-danger btn-icon btn-round" title="Deactivate Account">
                                          <i class="fa fa-ban"></i>
                                        </button>
                                      </form>
                                    <?php else: ?>
                                      <form method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id_status" value="<?php echo htmlspecialchars($user['id']); ?>">
                                        <input type="hidden" name="new_status" value="1">
                                        <button type="submit" class="btn btn-success btn-icon btn-round" title="Activate Account">
                                          <i class="fa fa-check"></i>
                                        </button>
                                      </form>
                                    <?php endif; ?>
                                    <form method="POST" style="display:inline;">
                                      <input type="hidden" name="delete_id"
                                        value="<?php echo htmlspecialchars($user['id']); ?>">
                                      <button type="submit" class="btn btn-danger btn-icon btn-round ps-1" title="Delete Account"><span class="btn-label">
                                          <i class="fa fa-trash"></i></button>
                                    </form>
                                  <?php endif; ?>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="7" class="text-center">No records found</td>
                            </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>
      </div>

      </script>
      <?php include('footer.php'); ?>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <?php include('cust-color.php'); ?>
    <!-- End Custom template -->
  </div>
  <?php include('scripts.php'); ?>



</body>

</html>
