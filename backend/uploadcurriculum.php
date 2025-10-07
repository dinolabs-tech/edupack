<?php

// Start the session to maintain user state across requests
session_start();

// Check if the user is logged in. If not, redirect them to the login page and terminate script execution.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file to establish a connection to the database.
include 'db_connection.php';

// Check if the database connection failed and terminate if it did.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Fetch Classes for Dropdown ---
// SQL query to select distinct class names from the 'class' table.
$class_sql = "SELECT DISTINCT Class FROM class"; // Adjust this query based on your class table structure
$class_stmt = $conn->prepare($class_sql); // Prepare the SQL statement to prevent SQL injection.
$class_stmt->execute(); // Execute the prepared statement.
$class_result = $class_stmt->get_result(); // Get the result set from the executed statement.

$classes = []; // Initialize an empty array to store class names.
// Check if any rows were returned.
if ($class_result->num_rows > 0) {
    // Loop through each row and add the 'Class' column value to the $classes array.
    while ($row = $class_result->fetch_assoc()) {
        $classes[] = $row['Class'];
    }
}
$class_stmt->close(); // Close the prepared statement.

// --- Fetch Subjects Based on Selected Class ---
$subjects = []; // Initialize an empty array to store subject names.
// Check if a 'Class' was selected and sent via POST request.
if (isset($_POST['Class'])) {
    $selected_class = $_POST['Class']; // Get the selected class name.
    // SQL query to select subjects from the 'subject' table where the 'Class' matches the selected class.
    $subject_sql = "SELECT subject FROM subject WHERE Class = ?"; // Adjust this query based on your subject table structure
    $subject_stmt = $conn->prepare($subject_sql); // Prepare the SQL statement.
    $subject_stmt->bind_param("s", $selected_class); // Bind the selected class as a string parameter.
    $subject_stmt->execute(); // Execute the prepared statement.
    $subject_result = $subject_stmt->get_result(); // Get the result set.

    // Check if any rows were returned.
    if ($subject_result->num_rows > 0) {
        // Loop through each row and add the 'subject' column value to the $subjects array.
        while ($row = $subject_result->fetch_assoc()) {
            $subjects[] = $row['subject'];
        }
    }
    $subject_stmt->close(); // Close the prepared statement.
}

// --- Handle Form Submission for Curriculum Upload ---
$message = ''; // Initialize an empty message variable for feedback to the user.
$target_dir = 'Curriculum/'; // Define the target directory where curriculum files will be stored.

// Check if the request method is POST and if the 'upload' button was clicked.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
    $subject_name = $_POST['subject']; // Get the subject name from the form.
    $class_name = $_POST['class'];     // Get the class name from the form.

    // Check if a document file was uploaded and if there were no upload errors.
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $document = $_FILES['document']; // Get the uploaded document details.
        $file_ext = pathinfo($document['name'], PATHINFO_EXTENSION); // Get the file extension.

        // Sanitize file name to avoid special characters and spaces, replacing them with underscores.
        $sanitized_subject = preg_replace('/[^a-zA-Z0-9_-]/', '_', $subject_name);
        $sanitized_class = preg_replace('/[^a-zA-Z0-9_-]/', '_', $class_name);
        // Construct the new file name using sanitized subject, class, and original extension.
        $file_name = $sanitized_subject . '_' . $sanitized_class . '.' . $file_ext;

        $target_file = $target_dir . $file_name; // Construct the full path to the target file.

        // Create the 'Curriculum' directory if it does not exist.
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0755, true)) { // Attempt to create the directory with read/write/execute permissions for owner, read/execute for group and others.
                echo "<script>alert('Failed to create target directory.');</script>"; // Alert if directory creation fails.
                exit; // Exit to prevent further execution if directory cannot be created.
            }
        }

        // Move the uploaded file from its temporary location to the target directory.
        if (move_uploaded_file($document['tmp_name'], $target_file)) {
            // If file move is successful, insert curriculum details into the database.
            $insert_sql = "INSERT INTO curriculum (subject_name, class_name, file_name) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql); // Prepare the SQL statement.
            $insert_stmt->bind_param("sss", $subject_name, $class_name, $file_name); // Bind parameters.
            if ($insert_stmt->execute()) {
                // Display success popup if record is saved.
                echo "<script>alert('File uploaded and record saved successfully!');</script>";
            } else {
                // Display error popup if record is not saved.
                echo "<script>alert('File uploaded but record not saved: " . $conn->error . "');</script>";
            }
            $insert_stmt->close(); // Close the prepared statement.
        } else {
            // Display error popup if file upload fails.
            echo "<script>alert('Error uploading file. Check file permissions and directory path.');</script>";
        }
    } else {
        // Display error popup if no valid file was selected.
        echo "<script>alert('Please select a valid file.');</script>";
    }
}

// --- Handle Form Submission for Curriculum Deletion ---
// Check if the request method is POST and if the 'delete' button was clicked.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $note_id = $_POST['note_id'];       // Get the ID of the curriculum entry to delete.
    $file_name = $_POST['file_name'];   // Get the file name associated with the curriculum entry.

    // Delete the actual file from the file system.
    $target_file = 'Curriculum/' . $file_name; // Construct the full path to the file.
    if (file_exists($target_file)) { // Check if the file exists.
        unlink($target_file); // Delete the file.
    }

    // Delete the record from the database.
    $delete_sql = "DELETE FROM curriculum WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql); // Prepare the SQL statement.
    $delete_stmt->bind_param("i", $note_id); // Bind the ID parameter.
    if ($delete_stmt->execute()) {
        $message = 'Curriculum deleted successfully!'; // Set success message.
    } else {
        $message = 'Error deleting Note: ' . $conn->error; // Set error message.
    }
    $delete_stmt->close(); // Close the prepared statement.
}

// --- Fetch All Uploaded Curriculums ---
// SQL query to select all records from the 'curriculum' table.
$notes_sql = "SELECT * FROM curriculum";
$notes_stmt = $conn->prepare($notes_sql); // Prepare the SQL statement.
$notes_stmt->execute(); // Execute the statement.
$notes_result = $notes_stmt->get_result(); // Get the result set.
$uploaded_notes = []; // Initialize an empty array to store uploaded curriculum details.
// Check if any rows were returned.
if ($notes_result->num_rows > 0) {
    // Loop through each row and add it to the $uploaded_notes array.
    while ($row = $notes_result->fetch_assoc()) {
        $uploaded_notes[] = $row;
    }
}
$notes_stmt->close(); // Close the prepared statement.

// --- Fetch Logged-in Staff Name ---
$user_id = $_SESSION['user_id']; // Get the user ID from the session.
// SQL query to fetch the staff name from the 'login' table based on user ID.
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id); // Bind the user ID parameter.
$stmt->execute(); // Execute the statement.
$stmt->bind_result($student_name); // Bind the result to the $student_name variable.
$stmt->fetch(); // Fetch the result.
$stmt->close(); // Close the prepared statement.

// Close the database connection.
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php');?> <!-- Includes the head section of the HTML document. -->
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
     <?php include('adminnav.php');?> <!-- Includes the admin navigation sidebar. -->
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <?php include('logo_header.php');?> <!-- Includes the logo header. -->
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
         <?php include('navbar.php');?> <!-- Includes the main navigation bar. -->
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <nts class="fw-bold mb-3">Curriculum</h3> <!-- Page title. -->
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">E-Learning Resources</li>
                  <li class="breadcrumb-item active">Curriculum</li>
                  <li class="breadcrumb-item active">Upload</li>
              </ol>
              </div>
           
            </div>

            <!-- BULK UPLOAD Section -->
            <div class="row">
             
             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Upload</div> <!-- Card title for the upload section. -->
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">
                    
                   <p>
                          <!-- Curriculum Upload Form -->
                          <form method="post" enctype="multipart/form-data">
                              <!-- Class Selection Dropdown -->
                              <select class="form-control form-select" id="class" name="class" onchange="fetchSubjects()" required>
                                  <option value="" selected disabled>Select Class</option>
                                  <?php foreach ($classes as $class): ?>
                                      <option value="<?php echo htmlspecialchars($class); ?>">
                                          <?php echo htmlspecialchars($class); ?>
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                                        <br>
                              <!-- Subject Selection Dropdown (dynamically loaded) -->
                              <div id="subject-container">
                                  <select class="form-control form-select" id="subject" name="subject" required>
                                      <option value="" selected disabled>Select Subject</option>
                                      <?php foreach ($subjects as $subject): ?>
                                          <option value="<?php echo htmlspecialchars($subject); ?>">
                                              <?php echo htmlspecialchars($subject); ?>
                                          </option>
                                      <?php endforeach; ?>
                                  </select>
                              </div>
                                        <br>
                              <!-- File Input for Document Upload -->
                              <input class="form-control" type="file" id="document" name="document" accept=".doc,.docx" required><br>
                              <!-- Submit Button -->
                              <button type="submit" name="upload" class="ps-1 btn btn-success btn-icon btn-round"><span class="btn-label">
                              <i class="fas fa-cloud-upload-alt"></i></button>
                          </form>
                          </p>
                          <?php if ($message): ?>
                              <p class="message"><?php echo htmlspecialchars($message); ?> <!-- Display any success or error messages. -->
                          <?php endif; ?>

                   </div>
                 </div>
               </div>
             </div>
           </div>

          

          </div>
        </div>

  </script>
        <?php include('footer.php');?> <!-- Includes the footer section. -->
      </div>

      <!-- Custom template | don't include it in your project! -->
      <?php include('cust-color.php');?> <!-- Includes custom color settings. -->
      <!-- End Custom template -->
    </div>
   <?php include('scripts.php');?> <!-- Includes JavaScript scripts. -->
  
   <!-- JavaScript for fetching subjects dynamically based on class selection -->
   <script>
        function fetchSubjects() {
            var classSelect = document.getElementById("class"); // Get the class dropdown element.
            var selectedClass = classSelect.value; // Get the selected class value.

            var xhr = new XMLHttpRequest(); // Create a new XMLHttpRequest object.
            xhr.open("POST", "fetch_subjects.php", true); // Open a POST request to 'fetch_subjects.php'.
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // Set the request header.
            xhr.onreadystatechange = function () {
                // Check if the request is complete and successful.
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Update the subject container with the response from the server.
                    document.getElementById("subject-container").innerHTML = xhr.responseText;
                }
            };
            xhr.send("class=" + selectedClass); // Send the selected class to the server.
        }
    </script>
  </body>
</html>
