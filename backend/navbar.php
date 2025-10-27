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
    $stmt = $conn->prepare("SELECT name, profile_picture FROM students WHERE studentid = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user_data = $result->fetch_assoc()) {
        $display_name = $user_data['name'];
        if (!empty($user_data['profile_picture'])) {
            $profile_image_path = $user_data['profile_picture'];
        }
    }
    $stmt->close();
} elseif ($role === 'Parent') {
    $stmt = $conn->prepare("SELECT name, profile_picture FROM parents WHERE parentid = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user_data = $result->fetch_assoc()) {
        $display_name = $user_data['name'];
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
    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
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
                    <?php
                    $role = $_SESSION['role'];
                    $quick_actions = [];

                    // Superuser Quick Actions
                    if ($role === 'Superuser') {
                        $quick_actions = [
                            ['link' => 'superdashboard.php', 'icon' => 'fas fa-home', 'text' => 'Dashboard', 'color' => 'bg-primary'],
                            ['link' => 'registerstudents.php', 'icon' => 'fas fa-user-plus', 'text' => 'Enroll Student', 'color' => 'bg-info'],
                            ['link' => 'manage_applications.php', 'icon' => 'fas fa-graduation-cap', 'text' => 'Manage Apps', 'color' => 'bg-success'],
                            ['link' => 'mark_attendance.php', 'icon' => 'fas fa-user-check', 'text' => 'Mark Attendance', 'color' => 'bg-warning'],
                            ['link' => 'uploadresults.php', 'icon' => 'fas fa-upload', 'text' => 'Upload Results', 'color' => 'bg-danger'],
                            ['link' => 'addquestion.php', 'icon' => 'fas fa-question-circle', 'text' => 'Add CBT Qs', 'color' => 'bg-secondary'],
                            ['link' => 'fees_dashboard.php', 'icon' => 'fas fa-money-bill-wave', 'text' => 'Manage Fees', 'color' => 'bg-dark'],
                            ['link' => 'usercontrol.php', 'icon' => 'fas fa-user-cog', 'text' => 'User Control', 'color' => 'bg-primary'],
                            ['link' => 'expiry.php', 'icon' => 'fas fa-money-bill-alt', 'text' => 'Extend License', 'color' => 'bg-info'],
                        ];
                    }
                    // Administrator Quick Actions
                    elseif ($role === 'Administrator') {
                        $quick_actions = [
                            ['link' => 'dashboard.php', 'icon' => 'fas fa-home', 'text' => 'Dashboard', 'color' => 'bg-primary'],
                            ['link' => 'registerstudents.php', 'icon' => 'fas fa-user-plus', 'text' => 'Enroll Student', 'color' => 'bg-info'],
                            ['link' => 'manage_applications.php', 'icon' => 'fas fa-graduation-cap', 'text' => 'Manage Apps', 'color' => 'bg-success'],
                            ['link' => 'mark_attendance.php', 'icon' => 'fas fa-user-check', 'text' => 'Mark Attendance', 'color' => 'bg-warning'],
                            ['link' => 'uploadresults.php', 'icon' => 'fas fa-upload', 'text' => 'Upload Results', 'color' => 'bg-danger'],
                            ['link' => 'fees_dashboard.php', 'icon' => 'fas fa-money-bill-wave', 'text' => 'Manage Fees', 'color' => 'bg-dark'],
                            ['link' => 'timetable.php', 'icon' => 'fas fa-th-list', 'text' => 'Class Schedule', 'color' => 'bg-secondary'],
                            ['link' => 'usercontrol.php', 'icon' => 'fas fa-user-cog', 'text' => 'User Control', 'color' => 'bg-primary'],
                            ['link' => 'send_notice.php', 'icon' => 'fas fa-envelope-open', 'text' => 'Send Notice', 'color' => 'bg-info'],
                        ];
                    }
                    // Admission Quick Actions
                    elseif ($role === 'Admission') {
                        $quick_actions = [
                            ['link' => 'dashboard.php', 'icon' => 'fas fa-home', 'text' => 'Dashboard', 'color' => 'bg-primary'],
                            ['link' => 'registerstudents.php', 'icon' => 'fas fa-user-plus', 'text' => 'Enroll Student', 'color' => 'bg-info'],
                            ['link' => 'modifystudents.php', 'icon' => 'fas fa-user-edit', 'text' => 'Modify Students', 'color' => 'bg-success'],
                            ['link' => 'viewstudents.php', 'icon' => 'fas fa-eye', 'text' => 'View Student Profile', 'color' => 'bg-warning'],
                            ['link' => 'filter_students.php', 'icon' => 'fas fa-filter', 'text' => 'Filter Students', 'color' => 'bg-danger'],
                            ['link' => 'manage_applications.php', 'icon' => 'fas fa-graduation-cap', 'text' => 'Manage Apps', 'color' => 'bg-secondary'],
                            ['link' => 'admission_settings.php', 'icon' => 'fas fa-cogs', 'text' => 'Admission Settings', 'color' => 'bg-dark'],
                            ['link' => 'admission_transactions.php', 'icon' => 'fas fa-exchange-alt', 'text' => 'Admission Trans.', 'color' => 'bg-primary'],
                            ['link' => 'register_parent.php', 'icon' => 'fas fa-user-friends', 'text' => 'Register Parents', 'color' => 'bg-info'],
                        ];
                    }
                    // Teacher Quick Actions
                    elseif ($role === 'Teacher') {
                        $quick_actions = [
                            ['link' => 'dashboard.php', 'icon' => 'fas fa-home', 'text' => 'Dashboard', 'color' => 'bg-primary'],
                            ['link' => 'mark_attendance.php', 'icon' => 'fas fa-user-check', 'text' => 'Mark Attendance', 'color' => 'bg-info'],
                            ['link' => 'uploadresults.php', 'icon' => 'fas fa-upload', 'text' => 'Upload Results', 'color' => 'bg-success'],
                            ['link' => 'classteachercomment.php', 'icon' => 'fas fa-comment-dots', 'text' => 'Teacher Comments', 'color' => 'bg-warning'],
                            ['link' => 'uploadassignments.php', 'icon' => 'fas fa-tasks', 'text' => 'Upload Assignments', 'color' => 'bg-danger'],
                            ['link' => 'uploadnotes.php', 'icon' => 'fas fa-pencil-alt', 'text' => 'Upload Notes', 'color' => 'bg-secondary'],
                            ['link' => 'uploadcurriculum.php', 'icon' => 'fas fa-book', 'text' => 'Upload Curriculum', 'color' => 'bg-dark'],
                            ['link' => 'addquestion.php', 'icon' => 'fas fa-question-circle', 'text' => 'Add CBT Qs', 'color' => 'bg-primary'],
                            ['link' => 'settime.php', 'icon' => 'fas fa-clock', 'text' => 'Set CBT Time', 'color' => 'bg-info'],
                        ];
                    }
                    // Tuckshop Quick Actions
                    elseif ($role === 'Tuckshop') {
                        $quick_actions = [
                            ['link' => 'tuckdashboard.php', 'icon' => 'fas fa-store', 'text' => 'Dashboard', 'color' => 'bg-primary'],
                            ['link' => 'regtuck.php', 'icon' => 'fas fa-cash-register', 'text' => 'Register Items', 'color' => 'bg-info'],
                            ['link' => 'sellingpoint.php', 'icon' => 'fas fa-cart-plus', 'text' => 'POS', 'color' => 'bg-success'],
                            ['link' => 'inventory.php', 'icon' => 'fas fa-boxes', 'text' => 'Inventory', 'color' => 'bg-warning'],
                            ['link' => 'supplier.php', 'icon' => 'fas fa-truck', 'text' => 'Suppliers', 'color' => 'bg-danger'],
                            ['link' => 'transactions.php', 'icon' => 'fas fa-exchange-alt', 'text' => 'Transactions', 'color' => 'bg-secondary'],
                            ['link' => 'admin_tuckshop_payment_history.php', 'icon' => 'fas fa-history', 'text' => 'Recharge History', 'color' => 'bg-dark'],
                            ['link' => '#', 'icon' => 'fas fa-users-cog', 'text' => 'Manage Users', 'color' => 'bg-primary'], // Placeholder
                            ['link' => '#', 'icon' => 'fas fa-chart-line', 'text' => 'View Reports', 'color' => 'bg-info'], // Placeholder
                        ];
                    }
                    // Bursary Quick Actions
                    elseif ($role === 'Bursary') {
                        $quick_actions = [
                            ['link' => 'bursary_dashboard.php', 'icon' => 'fas fa-hand-holding-usd', 'text' => 'Bursary Dashboard', 'color' => 'bg-primary'],
                            ['link' => 'fees_dashboard.php', 'icon' => 'fas fa-money-check-alt', 'text' => 'Fee Management', 'color' => 'bg-info'],
                            ['link' => 'admission_settings.php', 'icon' => 'fas fa-cogs', 'text' => 'Admission Settings', 'color' => 'bg-success'],
                            ['link' => 'admission_transactions.php', 'icon' => 'fas fa-exchange-alt', 'text' => 'Admission Trans.', 'color' => 'bg-warning'],
                            ['link' => 'student_payment.php', 'icon' => 'fas fa-cash-register', 'text' => 'Student Payment', 'color' => 'bg-danger'],
                            ['link' => 'transaction_history.php', 'icon' => 'fas fa-history', 'text' => 'Transaction History', 'color' => 'bg-secondary'],
                            ['link' => 'print_receipt.php', 'icon' => 'fas fa-print', 'text' => 'Print Receipt', 'color' => 'bg-dark'],
                            ['link' => 'approvepayments.php', 'icon' => 'fas fa-check-circle', 'text' => 'Approve Payments', 'color' => 'bg-primary'],
                            ['link' => 'print_student_transactions.php', 'icon' => 'fas fa-download', 'text' => 'Download Trans.', 'color' => 'bg-info'],
                        ];
                    }
                    // Student Quick Actions
                    elseif ($role === 'Student') {
                        $quick_actions = [
                            ['link' => 'students.php', 'icon' => 'fas fa-home', 'text' => 'Dashboard', 'color' => 'bg-primary'],
                            ['link' => '#', 'icon' => 'fas fa-chart-bar', 'text' => 'Check Result', 'color' => 'bg-info', 'onclick' => 'showPopup()'],
                            ['link' => 'viewassignment.php', 'icon' => 'fas fa-tasks', 'text' => 'View Assignments', 'color' => 'bg-success'],
                            ['link' => 'viewnotes.php', 'icon' => 'fas fa-pencil-alt', 'text' => 'View Notes', 'color' => 'bg-warning'],
                            ['link' => 'viewcurriculum.php', 'icon' => 'fas fa-book-reader', 'text' => 'View Curriculum', 'color' => 'bg-danger'],
                            ['link' => 'sublist.php', 'icon' => 'fas fa-laptop-code', 'text' => 'Take CBT Test', 'color' => 'bg-secondary'],
                            ['link' => 'result.php', 'icon' => 'fas fa-poll', 'text' => 'View CBT Result', 'color' => 'bg-dark'],
                            ['link' => 'student_fee_breakdown.php', 'icon' => 'fas fa-money-bill-wave', 'text' => 'Fee Breakdown', 'color' => 'bg-primary'],
                            ['link' => 'viewtimetable.php', 'icon' => 'fas fa-th-list', 'text' => 'Class Schedule', 'color' => 'bg-info'],
                        ];
                    }
                    // Parent Quick Actions
                    elseif ($role === 'Parent') {
                        $quick_actions = [
                            ['link' => 'parent_dashboard.php', 'icon' => 'fas fa-home', 'text' => 'Dashboard', 'color' => 'bg-primary'],
                            ['link' => 'read_notice.php', 'icon' => 'fas fa-bell', 'text' => 'Read Notices', 'color' => 'bg-info'],
                            ['link' => 'parent_transaction_history.php', 'icon' => 'fas fa-history', 'text' => 'Transaction History', 'color' => 'bg-success'],
                            ['link' => '../index.php', 'icon' => 'fas fa-globe', 'text' => 'Visit Site', 'color' => 'bg-warning'],
                            ['link' => 'logout.php', 'icon' => 'fas fa-sign-out-alt', 'text' => 'Logout', 'color' => 'bg-danger'],
                        ];
                    }

                    foreach ($quick_actions as $action) {
                        echo '<a class="col-6 col-md-4 p-0" href="' . htmlspecialchars($action['link']) . '"' . (isset($action['onclick']) ? ' onclick="' . htmlspecialchars($action['onclick']) . '; return false;"' : '') . '>';
                        echo '<div class="quick-actions-item">';
                        echo '<div class="avatar-item ' . htmlspecialchars($action['color']) . ' rounded-circle">';
                        echo '<i class="' . htmlspecialchars($action['icon']) . '"></i>';
                        echo '</div>';
                        echo '<span class="text">' . htmlspecialchars($action['text']) . '</span>';
                        echo '</div>';
                        echo '</a>';
                    }
                    ?>
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
