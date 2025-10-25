<?php


// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Database connection
include 'db_connection.php';

// Check connection to the database
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$user_id = $_SESSION['user_id'];
$display_name = $student_name;

$profile_image_path = 'assets/img/profile-img.jpg'; // Default profile picture

// Fetch user data based on role
if ($role === 'Student' || $role === 'Alumni') {
    $stmt = $conn->prepare("SELECT studentname, profile_picture FROM students WHERE studentid = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user_data = $result->fetch_assoc()) {
        $display_name = $user_data['studentname'];
        if (!empty($user_data['profile_picture'])) {
            $profile_image_path = $user_data['profile_picture'];
        }
    }
    $stmt->close();
} elseif ($role === 'Parent') {
    $stmt = $conn->prepare("SELECT parentname, profile_picture FROM parents WHERE parentid = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user_data = $result->fetch_assoc()) {
        $display_name = $user_data['parentname'];
        if (!empty($user_data['profile_picture'])) {
            $profile_image_path = $user_data['profile_picture'];
        }
    }
    $stmt->close();
} else { // Administrator, Superuser, Teacher, Bursary, Tuckshop, Admission
    $stmt = $conn->prepare("SELECT staffname, profile_picture FROM login WHERE username = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user_data = $result->fetch_assoc()) {
        $display_name = $user_data['staffname'];
        if (!empty($user_data['profile_picture'])) {
            $profile_image_path = $user_data['profile_picture'];
        }
    }
    $stmt->close();
}
//set the appropriate url based on the user role
if ($role === 'Student') {
  $backurl = 'studentprofile.php';
} elseif ($role === 'Administrator') {
  $backurl = 'adminprofile.php';
} elseif ($role === 'Superuser') {
  $backurl = 'adminprofile.php';
} elseif ($role === 'Teacher') {
  $backurl = 'adminprofile.php';
} elseif ($role === 'Bursary') {
  $backurl = 'adminprofile.php';
} elseif ($role === 'Tuckshop') {
  $backurl = 'adminprofile.php';
} elseif ($role === 'Admission') {
  $backurl = 'adminprofile.php';
} elseif ($role === 'Alumni') {
  $backurl = 'studentprofile.php';
} elseif ($role === 'Parent') {
  $backurl = 'parentprofile.php';
}


// Assume the logged in user's id is stored in the session variable 'user_id'
$userId = $_SESSION['user_id'];

// Query to count unread messages for the logged-in user
$sql = "SELECT COUNT(*) AS unread FROM mail WHERE to_user = '$userId' AND status = 0";
$result = $conn->query($sql);
$count = 0;
if ($result && $row = $result->fetch_assoc()) {
  $count = $row['unread'];
}
// $conn->close();
?>



<!-- Navbar Header -->
<nav
  class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
  <div class="container-fluid">
    <nav
      class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
      <!-- <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div> -->
    </nav>

    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

      <li class="nav-item topbar-icon dropdown hidden-caret">
        <a
          class="nav-link dropdown-toggle"
          href="inbox.php"

          role="button">
          <i class="fa fa-envelope"></i>
          <span class="notification"><?php echo $count; ?></span>
        </a>

      </li>

<!-- Quick Shortcuts -->
   <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <i class="fas fa-layer-group"></i>
                  </a>
                  <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                      <span class="title mb-1">Quick Actions</span>
                      <span class="subtitle op-7">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                      <div class="quick-actions-items">
                        <div class="row m-0">
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-danger rounded-circle">
                                <i class="far fa-calendar-alt"></i>
                              </div>
                              <span class="text">Calendar</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-warning rounded-circle"
                              >
                                <i class="fas fa-map"></i>
                              </div>
                              <span class="text">Maps</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-info rounded-circle">
                                <i class="fas fa-file-excel"></i>
                              </div>
                              <span class="text">Reports</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-success rounded-circle"
                              >
                                <i class="fas fa-envelope"></i>
                              </div>
                              <span class="text">Emails</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-primary rounded-circle"
                              >
                                <i class="fas fa-file-invoice-dollar"></i>
                              </div>
                              <span class="text">Invoice</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-secondary rounded-circle"
                              >
                                <i class="fas fa-credit-card"></i>
                              </div>
                              <span class="text">Payments</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                

      <li class="nav-item topbar-user dropdown hidden-caret">
        <a
          class="dropdown-toggle profile-pic"
          data-bs-toggle="dropdown"
          href="#"
          aria-expanded="false">
          <div class="avatar-sm">
            <img
              src="<?php echo htmlspecialchars($profile_image_path); ?>"
              alt="Profile Picture"
              class="avatar-img rounded-circle" />
          </div>
          <span class="profile-username">
            <span class="op-7">Welcome,</span>
            <span class="fw-bold"> <?php echo htmlspecialchars($display_name); ?></span>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-user animated fadeIn">
          <div class="dropdown-user-scroll scrollbar-outer">
            <li>
              <div class="user-box">
                <div class="avatar-lg" style="width: 50px; height: 50px;">
                  <img
                    src="<?php echo htmlspecialchars($profile_image_path); ?>"
                    alt="Profile Picture"
                    class="avatar-img rounded" />
                </div>
                <div class="u-text">
                  <h4> <?php echo htmlspecialchars($display_name); ?> </h4>
                  <!-- <p class="text-muted">hello@example.com</p> -->
                  <p><?php echo htmlspecialchars($role); ?></p>

                </div>
            </li>
            <li>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" onclick="window.location.href='<?php echo $backurl; ?>'">My Profile</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="create_message.php">Create Mail</a>
              <a class="dropdown-item" href="inbox.php">Inbox</a>
              <a class="dropdown-item" href="sent_message.php">Sent</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </li>
          </div>
        </ul>
      </li>
    </ul>
  </div>
</nav>
