<?php
/**
 * create_message.php
 *
 * This file provides an interface for users to create and send messages to other users within the system.
 * It includes functionalities for searching recipients, composing the message with a subject,
 * and sending the message to the database. The message is stored in the 'mail' table.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Handling POST requests for sending new messages.
 * - Sanitizing input data to prevent SQL injection.
 * - Using AJAX to search for recipients.
 * - Utilizing TinyMCE for rich text editing of the message body.
 * - Includes various UI components like head, navigation, header, footer, and scripts.
 */

// Start or resume a session. This is crucial for managing user login state.
session_start();

// Check if the user is logged in. If not, redirect them to the login page
// to ensure only authenticated users can access this messaging interface.
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Include the database connection file. This file should establish a connection
// to the MySQL database and make the $conn object available.
include 'db_connection.php';

// Check if the database connection was successful. If not, terminate the script
// and display an error message.
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Assume the logged-in user’s ID is stored in the session under 'user_id'.
$loggedInUserId = $_SESSION['user_id'];

// --- Process Form Submission ---
// Check if the request method is POST, indicating a form submission.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize input data to prevent SQL injection.
  $subject = $conn->real_escape_string($_POST['subject']);
  // Get the message from TinyMCE (HTML content).
  $message = $conn->real_escape_string($_POST['message']);
  // Use the logged-in user ID for the sender (no need to post it from the form).
  $from_user = $loggedInUserId;

  // Retrieve the hidden field with recipient ID.
  $to_user = $conn->real_escape_string($_POST['to_user_id']);
  // Set default status (e.g., 0 for unread).
  $status = 0;

  // SQL query to insert the new message into the 'mail' table.
  $sql = "INSERT INTO mail (subject, message, from_user, to_user, status)
          VALUES ('$subject', '$message', '$from_user' ,'$to_user', '$status')";

  // Execute the query and check for success.
  if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Message sent successfully!");</script>';
  } else {
    // If the query fails, display an error message.
    echo "<p>Error: " . $conn->error . "</p>";
  }
}

// --- Fetch User Role and Name ---
// Determine the user's role from the session.
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
// Determine the author's name based on their role.
// This block fetches the appropriate name (student name or staff name) from the database
// depending on the user's assigned role.
if ($role === 'Student' || $role === 'Alumni') {
    // For students and alumni, fetch the name from the 'students' table.
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT name FROM students WHERE id=?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($student_name);
    $stmt->fetch();
    $stmt->close();
} elseif (in_array($role, ['Superuser', 'Administrator', 'Store', 'Library', 'Tuckshop', 'Teacher', 'Bursary', 'Admission'])) {
    // For staff roles, fetch the staff name from the 'login' table.
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($student_name);
    $stmt->fetch();
    $stmt->close();
}

// Close the database connection.
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?> <!-- Includes the head section of the HTML document (meta tags, title, CSS links) -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
  // jQuery function for AJAX-based student search
  $(document).ready(function () {
    $('#to_user').on('input', function () {
      var query = $(this).val();
      if (query.length > 1) {
        $.ajax({
          url: 'search_students.php',
          type: 'GET',
          data: { query: query },
          success: function (data) {
            $('#studentList').fadeIn();
            $('#studentList').html(data);
          }
        });
      } else {
        $('#studentList').fadeOut();
      }
    });

    // When a student name is clicked, set both the visible input and the hidden recipient id field
    $(document).on('click', '.student', function () {
      var username = $(this).text();
      var studentId = $(this).data('id');
      $('#to_user').val(username);
      $('#to_user_id').val(studentId);
      $('#studentList').fadeOut();
    });
  });
</script>
<style>
  /* Simple styling for the dropdown list */
  #studentList {
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    display: none;
    position: absolute;
    background: #fff;
    width: 90%;
    z-index: 1000;
  }

  .student {
    padding: 5px;
    cursor: pointer;
  }

  .student:hover {
    background-color: #f0f0f0;
  }
</style>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
    // Include the appropriate navigation sidebar based on the user's role.
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
    if ($role === 'Student') {
      include('studentnav.php');
    } elseif ($role === 'Administrator') {
      include('adminnav.php');
    } elseif ($role === 'Superuser') {
      include('adminnav.php');
    } elseif ($role === 'Teacher') {
      include('adminnav.php');
    } elseif ($role === 'Admission') {
      include('adminnav.php');
    } elseif ($role === 'Bursary') {
      include('adminnav.php');
    } elseif ($role === 'Store') {
      include('adminnav.php');
    } elseif ($role === 'Tuckshop') {
      include('adminnav.php');
    } elseif ($role === 'Library') {
      include('adminnav.php');
    } elseif ($role === 'Parent') {
      include('parentnav.php');
    } elseif ($role === 'Alumni') {
      include('alumninav.php');
    }
    ?>
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
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">New Mail</h3>
              <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Create Mail</li>
              </ol>
            </div>
          </div>

          <!-- Create New Message Section -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Create New Message</h4>
              </div>
              <div class="card-body">
                <!-- Form for creating and sending a new message -->
                <form method="post" action="">
                  <!-- From field is now hidden because it comes from the session -->
                  <input type="hidden" name="from_user" value="<?php echo htmlspecialchars($loggedInUserId); ?>">

                  <div class="form-group">
                    <label for="to_user">To:</label>
                    <!-- Input field for searching recipients -->
                    <input class="form-control" type="text" id="to_user" name="to_user" autocomplete="off" required>
                    <!-- Hidden field to store the recipient's ID -->
                    <input type="hidden" id="to_user_id" name="to_user_id">
                    <!-- Autocomplete list for student search -->
                    <div id="studentList"></div>
                  </div>
                  <br>

                  <div class="form-group">
                    <label for="subject">Subject:</label>
                    <!-- Input field for the message subject -->
                    <input class="form-control" type="text" id="subject" name="subject" required>
                  </div>
                  <br>

                  <div class="form-group">
                    <label for="message">Message:</label>
                    <!-- Textarea for composing the message body, using TinyMCE for rich text editing -->
                    <textarea class="form-control" id="message" name="message"></textarea>
                  </div>
                  <br>

                  <!-- Submit button to send the message -->
                  <!-- <input class="btn btn-success" type="submit" value="Send Message"> -->
                  <button class="btn btn-success btn-icon btn-round" type="submit"><i class="fab fa-telegram"></i></button>
                </form>
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

  <!-- Initialize TinyMCE for the message textarea -->
  <script>
    tinymce.init({
      selector: '#message',
      menubar: false, // Hide the menubar for a cleaner interface.
      toolbar: 'undo redo | formatselect | bold italic underline superscript subscript | alignleft aligncenter alignright | bullist numlist outdent indent | table', // Customize toolbar buttons.
      plugins: 'lists', // Enable list plugin.
      branding: false // Hide TinyMCE branding.
    });
  </script>

</body>

</html>
