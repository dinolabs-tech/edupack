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

// Debugging: Display user_id and fetched user_data
echo "<!-- Debugging Info: -->\n";
echo "<!-- User ID: " . htmlspecialchars($user_id) . " -->\n";
echo "<!-- User Data: " . htmlspecialchars(json_encode($user_data)) . " -->\n";
echo "<!-- End Debugging Info -->\n";

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

    $new_profile_picture_uploaded = false;
    $other_details_changed = false;

    // --- Start: Handle Profile Picture Upload ---
    if (isset($_FILES['profile_picture']) && is_array($_FILES['profile_picture']) &&
        isset($_FILES['profile_picture']['error']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK &&
        isset($_FILES['profile_picture']['name']) && isset($_FILES['profile_picture']['tmp_name']) &&
        !empty($_FILES['profile_picture']['name']) && is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {

        $target_dir = "staffimg/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $file_extension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
        $new_file_name = $user_id . "_profile." . $file_extension;
        $target_file = $target_dir . $new_file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $profile_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for profile picture.";
                $uploadOk = 0;
            }
        } else {
            $profile_message = "File is not an image.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            // Delete old profile picture if it exists and is not the default
            if (!empty($user_data['profile_picture']) && $user_data['profile_picture'] !== 'assets/img/profile-img.jpg' && file_exists($user_data['profile_picture'])) {
                unlink($user_data['profile_picture']);
            }

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture_path_to_save = $target_file;
                $new_profile_picture_uploaded = true;

                $stmt_pic = $conn->prepare("UPDATE login SET profile_picture=? WHERE id=?");
                $stmt_pic->bind_param("ss", $profile_picture_path_to_save, $user_id);
                if ($stmt_pic->execute()) {
                    if ($stmt_pic->affected_rows > 0) {
                        $profile_message = "Profile picture updated successfully! Path: " . htmlspecialchars($profile_picture_path_to_save);
                    } else {
                        $profile_message = "Profile picture update executed, but no rows were affected. Path: " . htmlspecialchars($profile_picture_path_to_save);
                    }
                } else {
                    $profile_message = "Error updating profile picture: " . $stmt_pic->error;
                }
                $stmt_pic->close();
            } else {
                $profile_message = "Sorry, there was an error uploading your profile picture.";
            }
        }
    }
    // --- End: Handle Profile Picture Upload ---

    // --- Start: Handle Other Profile Details Update ---
    $update_fields = [];
    $update_params = [];
    $param_types = "";

    // Check if each field is set in POST and if its value is different from current user_data
    if (isset($_POST['staffname']) && $_POST['staffname'] !== ($user_data['staffname'] ?? '')) {
        $update_fields[] = "staffname=?";
        $update_params[] = $_POST['staffname'];
        $param_types .= "s";
        $other_details_changed = true;
    }
    if (isset($_POST['mobile']) && $_POST['mobile'] !== ($user_data['mobile'] ?? '')) {
        $update_fields[] = "mobile=?";
        $update_params[] = $_POST['mobile'];
        $param_types .= "s";
        $other_details_changed = true;
    }
    if (isset($_POST['email']) && $_POST['email'] !== ($user_data['email'] ?? '')) {
        $update_fields[] = "email=?";
        $update_params[] = $_POST['email'];
        $param_types .= "s";
        $other_details_changed = true;
    }
    if (isset($_POST['address']) && $_POST['address'] !== ($user_data['address'] ?? '')) {
        $update_fields[] = "address=?";
        $update_params[] = $_POST['address'];
        $param_types .= "s";
        $other_details_changed = true;
    }
    if (isset($_POST['date_of_birth']) && $_POST['date_of_birth'] !== ($user_data['date_of_birth'] ?? '')) {
        $update_fields[] = "date_of_birth=?";
        $update_params[] = $_POST['date_of_birth'];
        $param_types .= "s";
        $other_details_changed = true;
    }
    if (isset($_POST['gender']) && $_POST['gender'] !== ($user_data['gender'] ?? '')) {
        $update_fields[] = "gender=?";
        $update_params[] = $_POST['gender'];
        $param_types .= "s";
        $other_details_changed = true;
    }

    if ($other_details_changed) {
        $update_query = "UPDATE login SET " . implode(", ", $update_fields) . " WHERE id=?";
        $update_params[] = $user_id;
        $param_types .= "s";

        $stmt = $conn->prepare($update_query);
        if ($stmt) {
            $stmt->bind_param($param_types, ...$update_params);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $profile_message .= (!empty($profile_message) ? " And " : "") . "Other profile details updated successfully!";
                } else {
                    $profile_message .= (!empty($profile_message) ? " And " : "") . "Other profile details update executed, but no rows were affected (data might be the same).";
                }
            } else {
                $profile_message .= (!empty($profile_message) ? " And " : "") . "Error updating other profile details: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $profile_message .= (!empty($profile_message) ? " And " : "") . "Error preparing statement for other profile details: " . $conn->error;
        }
    }
    // --- End: Handle Other Profile Details Update ---

    // Re-fetch user data if any update occurred to ensure the form displays the latest information
    if ($new_profile_picture_uploaded || $other_details_changed) {
        $stmt_fetch = $conn->prepare("SELECT staffname, username, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id = ?");
        $stmt_fetch->bind_param("s", $user_id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();
        $user_data = $result_fetch->fetch_assoc();
        $stmt_fetch->close();
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
