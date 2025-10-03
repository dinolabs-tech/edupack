<?php
/**
 * checker.php
 *
 * This file generates a result slip for a student based on their CBT (Computer Based Test) scores.
 * It retrieves student details, their scores from the 'mst_result' table, and calculates
 * the overall percentage. The result slip includes student information, subject-wise scores,
 * and a print button.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Handling POST requests to check a student's result by ID.
 * - Retrieving student details and CBT scores.
 * - Calculating the overall percentage score.
 * - Displaying the result slip with student information and subject scores.
 * - Includes a print button for easy printing of the result slip.
 */

// Start or resume a session. This is crucial for checking user login status.
session_start();


// Check if the user is logged in. If not, redirect them to the login page
// to ensure only authenticated users can access this result checking interface.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file to establish a connection to the database.
include 'db_connection.php';

// Check if the database connection was successful. If not, terminate the script
// and display an error message.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Handle Form Submission for Checking Result ---
// This block processes the form submission to check a student's result.
if (isset($_POST['checksubmit'])) {
    // Sanitize and retrieve the student ID from the POST request.
    $check = $_POST['check'];

    // Prepare a SQL SELECT statement to retrieve student details from the 'students' table.
    $stmt = $conn->prepare("SELECT id, name, gender, class, arm FROM students WHERE id = ?");
    $stmt->bind_param("s", $check); // Bind the student ID as a string.
    $stmt->execute();
    $stmt->store_result(); // Store the result to check the number of rows.

    if ($stmt->num_rows === 0) {
        // If no student is found with the given ID, display an alert and redirect back to checkcbt.php.
        echo "<script>
                alert('The Registration Number does not exist. No such Registration Number in this DATABASE');
                window.location='checkcbt.php';
              </script>";
    } else {
        // If a student is found, bind the result and fetch the student's details.
        $stmt->bind_result($id, $name, $gender, $class, $arm);
        $stmt->fetch();

        // --- Fetch Current Session and Term ---
        // Prepare a SQL SELECT statement to retrieve the current session from the 'currentsession' table.
        $stmt = $conn->prepare("SELECT id, csession FROM currentsession WHERE id = 1");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($csession_id, $csession);
        $stmt->fetch();
        // Now you have $csession available

        // Prepare a SQL SELECT statement to retrieve the current term from the 'currentterm' table.
        $stmt = $conn->prepare("SELECT id, cterm FROM currentterm WHERE id = 1");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($term_id, $term);
        $stmt->fetch();
        // Now you have $term available

        // --- Retrieve CBT Scores ---
        // Retrieve the sum of scores for the given loginid (student ID) from the 'mst_result' table.
        $sk = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM mst_result WHERE login='$id'");
        $appostk = mysqli_fetch_assoc($sk);

        // Check if there are results.
        if ($appostk && $appostk['total_score'] !== null) {
          $score = $appostk['total_score']; // Sum of all scores from mst_result.
          $score1 = $score * 4;             // Multiply the total by 4 for screening score.
        } else {
          $score = 0;   // Default to 0 if no results.
          $score1 = 0;  // Corresponding multiplied value.
        }

        // Define the maximum possible screening score.
        // For example, if there are 25 questions each worth 4 points, the max is 100.
        $maxScreeningScore = 100;

        // Calculate the percentage. Make sure $maxScreeningScore is not zero.
        if ($maxScreeningScore > 0) {
          $percentage = ($score1 / $maxScreeningScore) * 100;
        } else {
          $percentage = 0;
        }

        // Optionally, round the result to a desired number of decimals.
        $percentage = round($percentage, 2);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($name); ?></title> <!-- Display student's name in the title -->
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Styles for the identity header (logo and student photo) */
    .identity-header img { max-height: 110px; }
    .identity-photo img { max-height: 110px; }
  </style>
  <style>
    /* Hide print button when printing */
    @media print {
      .no-print { display: none; }
    }
  </style>
</head>
<body class="bg-light">
  <div class="container my-4">

    <!-- Result Slip Header -->
    <table border="0" width="100%">
      <tr>
        <td width="100">
          <!-- School Logo -->
          <img style="border-radius: 10px;" height="110" width="95" src="logo.jpg" alt="Logo" />
        </td>
        <td valign="top" style="padding:10px; font-size:14px; text-align:center">
          <!-- School Information -->
          <b style="font-size:17px">DINOLABS TECH SERVICES</b><br>
          <address>School address goes here</address>
          <span style="font-size:15px;">(Computer Based Test)</span><br />
          <b style="font-family:'Times New Roman', Times, serif;">Result Slip</b><br />
          Class: <b><?php echo htmlspecialchars($class); ?></b> | Arm: <?php echo htmlspecialchars($arm); ?>
        </td>
        <td width="100">
          <!-- Intentionally left blank -->
        </td>
      </tr>
    </table>
    <hr />

        <!-- Name Details -->
        <div class="row my-3">
      <div class="col-md-12">
        <div style="text-align: center"><strong> <h3><?php echo htmlspecialchars($name); ?></h3></strong> </div>
      </div>
    </div>

    <!-- Student Registration Details -->
    <div class="row my-3">
      <div class="col-md-4">
        <div><strong>REG. NO.:</strong> <?php echo htmlspecialchars($id); ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>CLASS:</strong> <?php echo htmlspecialchars($class); ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>ARM:</strong> <?php echo htmlspecialchars($arm); ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>SESSION:</strong> <?php echo htmlspecialchars($csession); ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>TERM:</strong> <?php echo htmlspecialchars($term); ?></div>
      </div>
    </div>

    <!-- Subjects and Scores -->
    <div class="row my-3">
      <div class="col-12">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>SUBJECTS</th>
              <th>SCORES</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Retrieve and loop through all subject scores from mst_result
            $sql = mysqli_query($conn, "SELECT * FROM mst_result WHERE login='$id'");
            while ($appost = mysqli_fetch_assoc($sql)) {
                $subject = $appost['subject'];
                $individual_score = $appost['score'];
                echo "<tr>";
                echo "<td>".htmlspecialchars($subject)."</td>";
                echo "<td>".htmlspecialchars($individual_score)."</td>";
                echo "</tr>";
            }
            ?>
            <tr class="table-secondary">
              <td><strong>TOTAL</strong></td>
              <td><strong><?php echo htmlspecialchars($score); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <hr />

    <!-- Action Buttons -->
    <div class="row my-3">
      <div class="col-md-6">
        <!-- Print button: triggers the browser's print function -->
        <a href="javascript:window.print()" class="btn btn-primary no-print">Print Result</a>
      </div>
      <div class="col-md-6 text-end">
        <!-- Close button: redirects back to the checkcbt.php page -->
        <a href="checkcbt.php" class="btn btn-danger no-print">Close Window</a>
      </div>
    </div>
  </div>

  <!-- Latest Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
