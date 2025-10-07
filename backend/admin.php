<?php

/**
 * admin.php
 *
 * This file provides an administrative interface for managing academic settings
 * such as terms, sessions, classes, and arms. It also includes functionality
 * for promoting students to the next academic year.
 *
 * Key functionalities include:
 * - User authentication and session management.
 * - Database connection and error handling.
 * - Displaying and updating current academic term and session.
 * - Displaying and managing academic arms and classes (add/delete).
 * - Handling student promotion to the next academic year.
 * - Includes various UI components like navigation, header, and footer.
 */

// Enable error reporting for development purposes to display all PHP errors.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start or resume a session. This is essential for managing user login state.
session_start();

// Check if the user is logged in. If not, redirect them to the login page
// to enforce authentication for accessing this admin panel.
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

// Initialize an array to store administrative messages (e.g., success or error messages)
// that will be displayed to the user.
$admin_messages = [];

// --- Fetch Current Academic Settings ---

// Fetch the current academic term from the 'currentterm' table.
$current_term_result = $conn->query("SELECT cterm FROM currentterm WHERE id=1");
if (!$current_term_result) {
  die("Error fetching current term: " . $conn->error); // Terminate if query fails
}
$current_term = $current_term_result->fetch_assoc()['cterm']; // Extract the term value

// Fetch the current academic session from the 'currentsession' table.
$current_session_result = $conn->query("SELECT csession FROM currentsession WHERE id=1");
if (!$current_session_result) {
  die("Error fetching current session: " . $conn->error); // Terminate if query fails
}
$current_session = $current_session_result->fetch_assoc()['csession']; // Extract the session value

// Fetch the date for the next term's beginning from the 'nextterm' table.
$next_term_result = $conn->query("SELECT Next FROM nextterm WHERE id=1");
if (!$next_term_result) {
  die("Error fetching Next Term: " . $conn->error); // Terminate if query fails
}
$next_term = $next_term_result->fetch_assoc()['Next']; // Extract the next term date

// --- Fetch Existing Academic Structure Data ---

// Fetch all existing academic arms from the 'arm' table.
$arms = [];
$arm_result = $conn->query("SELECT * FROM arm");
while ($row = $arm_result->fetch_assoc()) {
  $arms[] = $row; // Store each arm record in the $arms array
}

// Fetch all existing academic classes from the 'class' table.
$classes = [];
$class_result = $conn->query("SELECT * FROM class");
while ($row = $class_result->fetch_assoc()) {
  $classes[] = $row; // Store each class record in the $classes array
}

// --- Handle Delete Requests for Arms and Classes ---

// Check if a delete request has been made via GET parameters.
if (isset($_GET['delete'])) {
  // Sanitize and retrieve the table name and ID from the GET request.
  $table = htmlspecialchars($_GET['table'], ENT_QUOTES, 'UTF-8');
  $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

  // Whitelist allowed tables to prevent SQL injection and unauthorized deletions.
  $allowed_tables = ['arm', 'class']; // Only 'arm' and 'class' tables are allowed for deletion here.
  if (in_array($table, $allowed_tables)) {
    // Prepare a SQL DELETE statement using a prepared statement to prevent SQL injection.
    $stmt = $conn->prepare("DELETE FROM $table WHERE id=?");
    $stmt->bind_param("i", $id); // Bind the ID parameter as an integer.
    if ($stmt->execute()) {
      // If deletion is successful, add a success message and redirect to refresh the page.
      $admin_messages[] = ucfirst($table) . " record deleted successfully!";
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    } else {
      // If deletion fails, add an error message.
      $admin_messages[] = "Error deleting record: " . $stmt->error;
    }
    $stmt->close(); // Close the prepared statement.
  } else {
    // If an invalid table is specified, add an error message.
    $admin_messages[] = "Invalid table specified for deletion.";
  }
}

// --- Handle Form Submissions for Adding Arms and Classes ---

// Check if the form for adding an academic arm has been submitted.
if (isset($_POST['arm_submit'])) {
  // Sanitize and retrieve the arm name from the POST request.
  $arm = htmlspecialchars($_POST['arm'], ENT_QUOTES, 'UTF-8');

  // Prepare an SQL INSERT statement for the 'arm' table.
  $stmt = $conn->prepare("INSERT INTO arm (arm) VALUES (?)");

  // Check if the statement preparation was successful.
  if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
  }

  $stmt->bind_param("s", $arm); // Bind the arm parameter as a string.

  // Execute the statement.
  if ($stmt->execute()) {
    // If insertion is successful, redirect to refresh the page.
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    // If insertion fails, display an error message.
    echo "Error inserting data: " . $stmt->error;
  }
  $stmt->close(); // Close the prepared statement.
}

// Check if the form for adding an academic class has been submitted.
if (isset($_POST['class_submit'])) {
  // Sanitize and retrieve the class name from the POST request.
  $class = htmlspecialchars($_POST['class'], ENT_QUOTES, 'UTF-8');

  // Prepare an SQL INSERT statement for the 'class' table.
  $stmt = $conn->prepare("INSERT INTO class (class) VALUES (?)");

  // Check if the statement preparation was successful.
  if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
  }

  $stmt->bind_param("s", $class); // Bind the class parameter as a string.

  // Execute the statement.
  if ($stmt->execute()) {
    // If insertion is successful, redirect to refresh the page.
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    // If insertion fails, display an error message.
    echo "Error inserting data: " . $stmt->error;
  }
  $stmt->close(); // Close the prepared statement.
}

// --- Handle Form Submissions for Updating Term and Session ---

// Check if the form for updating the current term has been submitted.
if (isset($_POST['term_submit'])) {
  // Sanitize and retrieve the new term from the POST request.
  $term = htmlspecialchars($_POST['cterm'], ENT_QUOTES, 'UTF-8');

  // Prepare an SQL UPDATE statement to set the current term.
  $stmt = $conn->prepare("UPDATE currentterm SET cterm = ? WHERE id = 1");

  // Check if the statement preparation was successful.
  if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
  }

  $stmt->bind_param("s", $term); // Bind the term parameter as a string.

  // Execute the statement to update 'currentterm'.
  if ($stmt->execute()) {
    $stmt->close(); // Close the first statement.

    // Now, update the 'term' for all active students (status = 0) in the 'students' table.
    $stmt2 = $conn->prepare("UPDATE students SET term = ? WHERE status = 0");
    if ($stmt2 === false) {
      die("Error preparing students update: " . $conn->error);
    }

    $stmt2->bind_param("s", $term); // Bind the term parameter for student update.
    if ($stmt2->execute()) {
      $stmt2->close(); // Close the second statement.
      // If both updates are successful, redirect to refresh the page.
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } else {
      // If student update fails, display an error.
      echo "Error updating students: " . $stmt2->error;
    }
  } else {
    // If current term update fails, display an error.
    echo "Error updating current term: " . $stmt->error;
  }
}

// Check if the form for updating the academic session has been submitted.
if (isset($_POST['currentsession_submit'])) {
  // Sanitize and retrieve the new session from the POST request.
  $csession = htmlspecialchars($_POST['csession'], ENT_QUOTES, 'UTF-8');

  // Prepare an SQL UPDATE statement to set the current session.
  $stmt = $conn->prepare("UPDATE currentsession SET csession = ? WHERE id = 1");

  // Check if the statement preparation was successful.
  if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
  }

  $stmt->bind_param("s", $csession); // Bind the session parameter as a string.

  // Execute the statement to update 'currentsession'.
  if ($stmt->execute()) {
    $stmt->close(); // Close the first statement.

    // Now, update the 'session' for all active students (status = 0) in the 'students' table.
    $stmt2 = $conn->prepare("UPDATE students SET session = ? WHERE status = 0");
    if ($stmt2 === false) {
      die("Error preparing students update: " . $conn->error);
    }

    $stmt2->bind_param("s", $csession); // Bind the session parameter for student update.
    if ($stmt2->execute()) {
      $stmt2->close(); // Close the second statement.
      // If both updates are successful, redirect to refresh the page.
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } else {
      // If student session update fails, display an error.
      echo "Error updating students session: " . $stmt2->error;
    }
  } else {
    // If current session update fails, display an error.
    echo "Error updating current session: " . $stmt->error;
  }
}

// Check if the form for updating the next term's start date has been submitted.
if (isset($_POST['nextterm_submit'])) {
  // Sanitize and retrieve the raw date string from the POST request.
  $nextterm_raw = htmlspecialchars($_POST['nextterm'], ENT_QUOTES, 'UTF-8');

  // Convert the date from 'YYYY-MM-DD' (HTML date input format) to 'DD/MM/YYYY' format.
  $dateObj = DateTime::createFromFormat('Y-m-d', $nextterm_raw);
  if ($dateObj !== false) {
    $nextterm = $dateObj->format('d/m/Y');
  } else {
    // If the date format is invalid, terminate with an error.
    die("Invalid date format.");
  }

  // Prepare an SQL UPDATE statement to set the next term's date.
  $stmt = $conn->prepare("UPDATE nextterm SET Next = ? WHERE id = 1");

  // Check if the statement preparation was successful.
  if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
  }

  $stmt->bind_param("s", $nextterm); // Bind the formatted date parameter as a string.

  // Execute the statement.
  if ($stmt->execute()) {
    // If update is successful, redirect to refresh the page.
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    // If update fails, display an error.
    echo "Error inserting data: " . $stmt->error;
  }
  $stmt->close(); // Close the prepared statement.
}

// --- Handle Student Promotion (AJAX Request) ---

// This block handles an AJAX POST request to start a new academic session and promote students.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['startNewSession']) && $_POST['startNewSession'] === 'true') {
  $errors = []; // Initialize an array to collect any errors during the promotion process.
  try {
    // Step 1: Update the status of students in the highest class ('YEAR 12') to '1' (e.g., graduated).
    $stmt = $conn->prepare("UPDATE students SET status = ? WHERE class = ?");
    $status = 1;
    $class = 'YEAR 12';
    $stmt->bind_param("is", $status, $class); // Bind status as integer, class as string.
    $stmt->execute();
    $stmt->close();

    // Step 2: Define the promotion mapping for classes.
    // Students from 'fromClass' will be promoted to 'toClass'.
    $promotionMapping = [
      'YEAR 11' => 'YEAR 12',
      'YEAR 10' => 'YEAR 11',
      'YEAR 9' => 'YEAR 10',
      'YEAR 8' => 'YEAR 9',
      'YEAR 7' => 'YEAR 8'
    ];

    // Iterate through the promotion mapping and update student classes.
    foreach ($promotionMapping as $fromClass => $toClass) {
      $stmt = $conn->prepare("UPDATE students SET class = ? WHERE class = ?");
      $stmt->bind_param("ss", $toClass, $fromClass); // Bind new class and old class as strings.
      $stmt->execute();
      // If no rows were affected, it means no students were found in the 'fromClass'.
      if ($stmt->affected_rows === 0) {
        $errors[] = "No students found in $fromClass to promote.";
      }
      $stmt->close();
    }

    $conn->close(); // Close the database connection after all operations.

    // Set the content type header to JSON for the AJAX response.
    header('Content-Type: application/json');
    if (empty($errors)) {
      // If no errors, send a success response.
      echo json_encode(['success' => true, 'message' => 'Students promoted successfully!']);
    } else {
      // If there are errors, send a failure response with the error messages.
      echo json_encode(['success' => false, 'message' => implode("<br>", $errors)]);
    }
  } catch (Exception $e) {
    // Catch any exceptions during the promotion process and send an error response.
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error during promotion process: ' . $e->getMessage()]);
  }
  exit(); // Terminate script execution after sending the JSON response.
}

// Fetch the name of the logged-in staff member for display purposes.
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id); // Bind user ID as a string.
$stmt->execute();
$stmt->bind_result($student_name); // Bind the result to $student_name (though it's a staff name here).
$stmt->fetch();
$stmt->close();

// Close the main database connection.
$conn->close();
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
              <h3 class="fw-bold mb-3">Admin</h3>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Admin</li>
              </ol>
            </div>

          </div>

          <!-- ================ ADMIN WIDGETS PANEL =================== -->
          <div class="row text-center">
            <div class="col-md-3">
              <div class="card card-stats card-success card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <div class="numbers">
                        <p class="card-category">Current Term</p>
                        <!-- Form to update the current academic term -->
                        <form action="" method="POST" class="text-center">
                          <select class="form-control form-select text-center" id="cterm" name="cterm" required>
                            <option value="1st Term" <?php echo ($current_term == '1st Term') ? 'selected' : ''; ?>>1st Term</option>
                            <option value="2nd Term" <?php echo ($current_term == '2nd Term') ? 'selected' : ''; ?>>2nd Term</option>
                            <option value="3rd Term" <?php echo ($current_term == '3rd Term') ? 'selected' : ''; ?>>3rd Term</option>
                          </select>
                          <br>
                          <button class="btn btn-warning btn-icon btn-round" type="submit" name="term_submit"><i class="fas fa-save"></i></button>
                        </form>
                        <br>
                        <h5 style="text-align:center;" class="text-dark">Current Term: <?php echo htmlspecialchars($current_term, ENT_QUOTES, 'UTF-8'); ?></h5>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card card-stats card-secondary card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <div class="numbers">
                        <p class="card-category">Current Session</p>
                        <!-- Form to update the current academic session -->
                        <form action="" method="POST">
                          <input class="form-control text-center" type="text" id="csession" name="csession" placeholder="Current Session (XXXX/XXXX)" value="<?php echo htmlspecialchars($current_session, ENT_QUOTES, 'UTF-8'); ?>" required>
                          <br>
                          <button class="btn btn-success btn-icon btn-round" type="submit" name="currentsession_submit"><i class="fas fa-save"></i></button>
                        </form>
                        <br />
                        <h5 style="text-align:center;">Current Session:<?php echo htmlspecialchars($current_session, ENT_QUOTES, 'UTF-8'); ?></h5>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-3">
              <div class="card card-stats card-danger card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <div class="numbers">
                        <p class="card-category">Next Term Begins</p>
                        <!-- Form to update the next term's start date -->
                        <form action="" method="POST">
                          <input class="form-control text-center" type="date" id="nextterm" name="nextterm" placeholder="Next Term Begins" value="<?php echo htmlspecialchars($next_term, ENT_QUOTES, 'UTF-8'); ?>" required>
                          <br>
                          <button class="btn btn-success btn-icon btn-round" type="submit" name="nextterm_submit"><i class="fas fa-save"></i></button>
                        </form>
                        <br />
                        <h5 style="text-align:center;">Next Term Begins: <?php echo htmlspecialchars($next_term, ENT_QUOTES, 'UTF-8'); ?></h5>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-3 test-center">
              <div class="card card-stats card-primary card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <div class="numbers">
                        <p class="card-category">Promote Students</p>
                        <br>
                        <!-- Button to trigger promotion action. This links to a separate promote.php page. -->
                        <a href="promote.php"><button type="button" class="btn btn-success btn-icon btn-round"><span class="btn-label">
                              <i class="fa fa-user-graduate"></i></button></a>

                        <!-- button to trigger auto promote -->
                        <!-- <button type="button" class="btn btn-success" onclick="startNewSessionAndPromote()"><span class="btn-label">
                              <i class="fa fa-user-graduate"></i> Promote Students</button> -->
                        <br>
                        <!-- Notification area for AJAX promotion results (currently hidden as promotion is via redirect) -->
                        <div id="notification" style="display: none;color:black;"></div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- ===================== ADMIN WIDGETS PANEL ENDS HERE ======================= -->


          <div class="row">
            <div class="col-md-6">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Academic Arm</div>
                  </div>
                </div>
                <div class="card-body">
                  <?php
                  // Display any administrative messages (e.g., success/error from delete operations).
                  foreach ($admin_messages as $adminmessage): ?>
                    <p class="message"><?php echo htmlspecialchars($adminmessage, ENT_QUOTES, 'UTF-8'); ?></p>
                  <?php endforeach; ?>

                  <!-- Form to add a new academic arm -->
                  <form action="" method="POST" class="d-flex">
                    <input class="form-control" type="text" id="arm" name="arm" placeholder="Enter Academic Arm" required><br>
                    <button class="btn btn-success btn-icon btn-round ms-3" type="submit" name="arm_submit"><i class="fas fa-save"></i></button>
                  </form>
                  <br />
                  <div class="table-responsive">
                    <!-- Table to display existing academic arms -->
                    <table
                      id="multi-filter-select"
                      class="display table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Arm</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($arms as $arm): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($arm['arm'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                              <!-- Delete button for each arm, linking to this page with delete parameters -->
                              <a href="?delete=true&table=arm&id=<?php echo htmlspecialchars($arm['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-icon btn-round ps-1"><span class="btn-label">
                                  <i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>


            <div class="col-md-6">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Academic Class</div>
                  </div>
                </div>
                <div class="card-body">
                  <!-- Form to add a new academic class -->
                  <form action="" method="POST" class="d-flex">
                    <input class="form-control" type="text" id="class" name="class" placeholder="Enter Academic Class" required><br>
                    <button class="btn btn-success btn-icon btn-round ms-3" type="submit" name="class_submit"><i class="fas fa-save"></i></button>
                  </form>
                  <br />
                  <div class="table-responsive">
                    <!-- Table to display existing academic classes -->
                    <table
                      id="multi-filter-select"
                      class="display table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Class</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($classes as $class): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($class['class'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                              <!-- Delete button for each class, linking to this page with delete parameters -->
                              <a href="?delete=true&table=class&id=<?php echo htmlspecialchars($class['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-icon btn-round ps-1"><span class="btn-label">
                                  <i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
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

  <!-- JavaScript for AJAX-based student promotion (currently commented out/unused as promotion is via redirect) -->
  <script>
    function startNewSessionAndPromote() {
      fetch("", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "startNewSession=true"
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          const notificationDiv = document.getElementById("notification");
          notificationDiv.style.display = "block";

          if (data.success) {
            notificationDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
          } else {
            notificationDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
          }
        })
        .catch(error => {
          console.error("Error:", error);
          const notificationDiv = document.getElementById("notification");
          notificationDiv.style.display = "block";
          notificationDiv.innerHTML = `<div class="alert alert-danger">An error occurred: ${error.message}</div>`;
        });
    }
  </script>
</body>

</html>
<?php include 'backup.php'; ?> <!-- Includes a backup script, likely for database backups -->