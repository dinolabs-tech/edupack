<?php
/**
 * adminprofile.php
 *
 * This file provides an interface for administrators to change their password.
 * It includes form validation for new passwords and updates the password in the database.
 *
 * Key functionalities include:
 * - User authentication and session management (via admin_logic.php).
 * - Database connection.
 * - Handling POST requests for password change.
 * - Validating new password and confirmation.
 * - Updating the password in the 'login' table for the logged-in user.
 * - Displaying success or error messages to the user.
 * - Includes various UI components like navigation, header, and footer.
 */

// Include the administrative logic file, which likely handles session checks and other admin-specific functions.
include('components/admin_logic.php');

// Initialize a message variable to store feedback for the user (e.g., success or error messages).
$message = '';

// Check if the request method is POST, indicating a form submission for changing password.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve new password and confirmation from the POST request.
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate: Check if the new password and confirm password fields match.
    if ($new_password !== $confirm_password) {
        $message = "New passwords do not match.";
    } else {
        // If passwords match, proceed to update the password in the database.
        // Get the user ID from the session to identify the logged-in user.
        $user_id = $_SESSION['user_id'];
        // Prepare a SQL UPDATE statement to change the password for the specific user.
        // Using prepared statements to prevent SQL injection.
        $stmt = $conn->prepare("UPDATE login SET password=? WHERE username=?");
        // Bind the new password and user ID parameters as strings.
        $stmt->bind_param("ss", $new_password, $user_id);

        // Execute the update statement.
        if ($stmt->execute()) {
            $message = "Password changed successfully!";
        } else {
            // If execution fails, set an error message.
            $message = "Error changing password: " . $stmt->error;
        }

        $stmt->close(); // Close the prepared statement.
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
                <h3 class="fw-bold mb-3">Change Password</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active">Home</li>
                  <li class="breadcrumb-item active">My Profile</li>
                  <li class="breadcrumb-item active">Change Password</li>
              </ol>
              </div>

            </div>

            <!-- Change Password Form Section -->
            <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Change Password</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                   <!-- Form for changing password. Submits data via POST to this same page. -->
                   <form method="POST" action="">
                    <div class="form-group">
                    <input class="form-control" type="password" id="new_password" name="new_password" placeholder="Enter New Password" required>
                    </div>
                    <div class="form-group">
                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password"required>
                    </div>
                    <div class="form-group">
                    <button class="btn btn-success" type="submit"><span class="btn-label">
                    <i class="fa fa-save"></i> Change Password</button>
                    </div>
                    </form>
                    <div class="message">
                    <?php
                      // Display any success or error messages related to the password change.
                      if (!empty($message)) {
                          echo '<div class="alert alert-info">' . htmlspecialchars($message) . '</div>';
                      }
                      ?>
                    </div>

                                        <!-- End Change Password Form -->

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
