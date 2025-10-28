<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to maintain user state
session_start();

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

$message = '';
$profile_message = '';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM login WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$student_name = $user_data['staffname'];
$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ✅ Change Password
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $stmt = $conn->prepare("UPDATE login SET password=? WHERE id=?");
            $stmt->bind_param("si", $_POST['new_password'], $user_id);
            $stmt->execute();
            $stmt->close();
            $message = "Password updated successfully!";
        } else {
            $message = "Passwords do not match.";
        }
    }

    // ✅ Update Profile Picture
    if (!empty($_FILES['profile_picture']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $target_dir = "staffimg/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

            $new_path = $target_dir . $user_id . "_profile." . $ext;

            // Remove old picture except default
            if (
                !empty($user_data['profile_picture']) &&
                $user_data['profile_picture'] !== 'assets/img/profile-img.jpg' &&
                file_exists($user_data['profile_picture'])
            ) {
                unlink($user_data['profile_picture']);
            }

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $new_path)) {
                $stmt = $conn->prepare("UPDATE login SET profile_picture=? WHERE id=?");
                $stmt->bind_param("si", $new_path, $user_id);
                $stmt->execute();
                $stmt->close();
                $profile_message = "Profile picture updated!";
            }
        } else {
            $profile_message = "Invalid image file.";
        }
    }

    // ✅ Update Other Profile Fields
    $fields = ['staffname', 'mobile', 'email', 'address', 'date_of_birth', 'gender'];
    $updates = [];
    $params = [];
    $types = '';

    foreach ($fields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] !== $user_data[$field]) {
            $updates[] = "$field=?";
            $params[] = $_POST[$field];
            $types .= 's';
        }
    }

    if (!empty($updates)) {
        $query = "UPDATE login SET " . implode(", ", $updates) . " WHERE id=?";
        $params[] = $user_id;
        $types .= "i";
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
        $profile_message .= (empty($profile_message) ? "" : " & ") . "Profile details updated!";
    }

    // ✅ Refresh Data for Display
    $stmt = $conn->prepare("SELECT * FROM login WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?> <!-- Includes the head section of the HTML document (meta tags, title, CSS links) -->

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('adminnav.php'); ?> <!-- Includes the admin specific navigation sidebar -->
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <?php include('logo_header.php'); ?> <!-- Includes the logo and header content -->
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <?php include('navbar.php'); ?> <!-- Includes the main navigation bar -->
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">My Profile</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Home</li>
                                <li class="breadcrumb-item active">My Profile</li>
                            </ol>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Profile Information</div>
                                    </div>
                                </div>

                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <form method="POST" action="" enctype="multipart/form-data" class="row">
                                            <div class="form-group text-center">
                                                <?php if (!empty($user_data['profile_picture'])): ?>
                                                    <img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>" alt="Profile Picture" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                                <?php else: ?>
                                                    <img src="assets/img/profile-img.jpg" alt="Default Profile Picture" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                                <?php endif; ?>
                                                <input type="file" class="form-control-file form-control" id="profile_picture" name="profile_picture">
                                                <small class="form-text text-muted">Upload a new profile picture (JPG, PNG, GIF)</small>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input class="form-control" placeholder="Full Name" type="text" name="staffname" value="<?php echo htmlspecialchars($user_data['staffname'] ?? ''); ?>" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input class="form-control" placeholder="Mobile" type="text" name="mobile" value="<?php echo htmlspecialchars($user_data['mobile'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input class="form-control" placeholder="Email" type="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" style="color: black !important;">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control" id="address" name="address" placeholder="Address"><?php echo htmlspecialchars($user_data['address'] ?? ''); ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input class="form-control" type="date" name="date_of_birth" value="<?php echo htmlspecialchars($user_data['date_of_birth'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <select class="form-control form-select" name="gender">
                                                    <option value="" selected disabled>Select Gender</option>
                                                    <option value="Male" <?php echo (isset($user_data['gender']) && $user_data['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                    <option value="Female" <?php echo (isset($user_data['gender']) && $user_data['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                    <option value="Other" <?php echo (isset($user_data['gender']) && $user_data['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12 text-center">
                                                <button class="btn btn-primary btn-icon btn-round ps-1" type="submit"><span class="btn-label"><i class="fa fa-save"></i></span></button>
                                            </div>
                                        </form>
                                        <div class="message mt-3">
                                            <?php
                                            if (!empty($profile_message)) {
                                                echo '<div class="alert alert-info">' . htmlspecialchars($profile_message) . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Change Password</div>
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <form method="POST" action="">
                                            <div class="form-group">
                                                <input class="form-control" type="password" id="new_password" name="new_password" placeholder="Enter New Password" required>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-success btn-icon btn-round ps-1" type="submit"><span class="btn-label"><i class="fa fa-save"></i></span></button>
                                            </div>
                                        </form>
                                        <div class="message mt-3">
                                            <?php
                                            if (!empty($message)) {
                                                echo '<div class="alert alert-info">' . htmlspecialchars($message) . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('footer.php'); ?> <!-- Includes the footer section of the page -->
        </div>

        <!-- Custom template | don't include it in your project! -->
        <?php include('cust-color.php'); ?> <!-- Includes custom color settings or scripts -->
        <!-- End Custom template -->
    </div>
    <?php include('scripts.php'); ?> <!-- Includes general JavaScript scripts for the page -->

</body>

</html>
