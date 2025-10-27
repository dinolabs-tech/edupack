<?php
/**
 * adminprofile.php
 *
 * This file provides an interface for administrators to manage their profile,
 * including changing password, updating personal details, and uploading a profile picture.
 *
 * Key functionalities include:
 * - User authentication and session management (via admin_logic.php).
 * - Database connection.
 * - Handling POST requests for profile updates and password changes.
 * - Validating input fields.
 * - Uploading and managing profile pictures.
 * - Updating the 'login' table with new profile information.
 * - Displaying success or error messages to the user.
 * - Includes various UI components like navigation, header, and footer.
 */

// Include the administrative logic file, which likely handles session checks and other admin-specific functions.
include('components/admin_logic.php');

// Initialize message variables to store feedback for the user.
$message = '';
$profile_message = '';

// Fetch current user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname, username, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// Handle POST requests for profile updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle password change
    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            $message = "New passwords do not match.";
        } else {
            $stmt = $conn->prepare("UPDATE login SET password=? WHERE id=?");
            $stmt->bind_param("ss", $new_password, $user_id);
            if ($stmt->execute()) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error changing password: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    // Handle profile details update
    if (isset($_POST['staffname']) || isset($_POST['mobile']) || isset($_POST['email']) || isset($_POST['address']) || isset($_POST['date_of_birth']) || isset($_POST['gender']) || isset($_FILES['profile_picture'])) {
        $staffname = $_POST['staffname'] ?? $user_data['staffname'];
        $mobile = $_POST['mobile'] ?? $user_data['mobile'];
        $email = $_POST['email'] ?? $user_data['email'];
        $address = $_POST['address'] ?? $user_data['address'];
        $date_of_birth = $_POST['date_of_birth'] ?? $user_data['date_of_birth'];
        $gender = $_POST['gender'] ?? $user_data['gender'];
        $profile_picture = $user_data['profile_picture']; // Keep existing picture by default

        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "staffimg/";
            $file_extension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
            $new_file_name = $user_id . "_profile." . $file_extension;
            $target_file = $target_dir . $new_file_name;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
            if ($check !== false) {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $profile_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for profile picture.";
                    $uploadOk = 0;
                }
            } else {
                $profile_message = "File is not an image.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                // If everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                    $profile_picture = $target_file;
                } else {
                    $profile_message = "Sorry, there was an error uploading your profile picture.";
                }
            }
        }

        // Update profile details in the database
        $stmt = $conn->prepare("UPDATE login SET staffname=?, mobile=?, email=?, address=?, date_of_birth=?, gender=?, profile_picture=? WHERE id=?");
        $stmt->bind_param("ssssssss", $staffname, $mobile, $email, $address, $date_of_birth, $gender, $profile_picture, $user_id);

        if ($stmt->execute()) {
            $profile_message = "Profile updated successfully!";
            // Re-fetch user data to display updated information
            $stmt_fetch = $conn->prepare("SELECT staffname, username, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id = ?");
            $stmt_fetch->bind_param("s", $user_id);
            $stmt_fetch->execute();
            $result_fetch = $stmt_fetch->get_result();
            $user_data = $result_fetch->fetch_assoc();
            $stmt_fetch->close();
        } else {
            $profile_message = "Error updating profile: " . $stmt->error;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php');?> <!-- Includes the head section of the HTML document (meta tags, title, CSS links) -->
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
     <?php include('adminnav.php');?> <!-- Includes the admin specific navigation sidebar -->
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <?php include('logo_header.php');?> <!-- Includes the logo and header content -->
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
         <?php include('navbar.php');?> <!-- Includes the main navigation bar -->
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
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
                                        <input class="form-control" placeholder="Full Name" type="text" id="staffname" name="staffname" value="<?php echo htmlspecialchars($user_data['staffname'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control" placeholder="Mobile" type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user_data['mobile'] ?? ''); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control" placeholder="Email" type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control" id="address" name="address" placeholder="Address"><?php echo htmlspecialchars($user_data['address'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control" type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($user_data['date_of_birth'] ?? ''); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select class="form-control form-select" id="gender" name="gender">
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

        <?php include('footer.php');?> <!-- Includes the footer section of the page -->
      </div>

      <!-- Custom template | don't include it in your project! -->
      <?php include('cust-color.php');?> <!-- Includes custom color settings or scripts -->
      <!-- End Custom template -->
    </div>
   <?php include('scripts.php');?> <!-- Includes general JavaScript scripts for the page -->


  </body>
</html>
