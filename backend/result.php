<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginid = $_SESSION['user_id'];		

$check = $loginid;

// Prepare SQL for students with additional columns: class and arm
$stmt1 = $conn->prepare("SELECT id, password, class, arm FROM students WHERE id=? AND password=?");
$stmt1->bind_param("ss", $user, $pass);
$stmt1->execute();
$stmt1->store_result();
// Fetch current term and session
$current_term_result = $conn->query("SELECT cterm FROM currentterm WHERE id=1");
if (!$current_term_result) {
    die("Error fetching current term: " . $conn->error);
}
$current_term = $current_term_result->fetch_assoc()['cterm'];

$current_session_result = $conn->query("SELECT csession FROM currentsession WHERE id=1");
if (!$current_session_result) {
    die("Error fetching current session: " . $conn->error);
}
$current_session = $current_session_result->fetch_assoc()['csession'];

// First, check if the student has taken the exam
$timi = mysqli_query($conn, "SELECT * FROM mst_result WHERE login = '$loginid'");
$rowtimer = mysqli_fetch_assoc($timi);

// Check if no record was found or if the login value is not what we expect
if (!$rowtimer || $rowtimer['login'] == null || $rowtimer['login'] != $check) {
    echo '<script type="text/javascript">
            alert("You have not taken any Exam. No result for you Yet");
          </script>';
    // Optionally, you can uncomment the redirection if needed
    echo '<script type="text/javascript">window.location = "sublist.php";</script>';
    exit();

} else {	
    // Retrieve student registration details
    $sql = mysqli_query($conn, "SELECT * FROM students WHERE id='$loginid'");
    while ($appost = mysqli_fetch_assoc($sql)) {
        $id          = $appost['id'];  
        $name     = $appost['name'];
        $gender  = $appost['gender'];
        $class       = $appost['class'];
        $arm = $appost['arm'];
        
        //$pic         = "<img border='0' src='" . $appost['photo'] . "' width='85px' height='100px' alt='Your Name'>";
    }

    // Retrieve the sum of scores for the given loginid
    $sk = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM mst_result WHERE login='$loginid'");
    $appostk = mysqli_fetch_assoc($sk);

// Assuming this code block is executed after your score calculation:
if ($appostk && $appostk['total_score'] !== null) {
    $score = $appostk['total_score']; // Sum of all scores from mst_result

    // Get the subjects the user was tested on
    $subjects_query = mysqli_query($conn, "SELECT DISTINCT subject FROM mst_result WHERE login='$loginid'");
    $subjects = [];
    while ($row = mysqli_fetch_assoc($subjects_query)) {
        $subjects[] = "'" . mysqli_real_escape_string($conn, $row['subject']) . "'";
    }

    $total_questions = 0;
    if (!empty($subjects)) {
        $subject_list = implode(',', $subjects);

        // Get the total number of questions for those subjects for the student's class, arm, session, and term
        $total_questions_query = mysqli_query($conn, "SELECT COUNT(*) as total_questions FROM question WHERE subject IN ($subject_list) AND class='$class' AND arm='$arm' AND session='$current_session' AND term='$current_term'");
        $total_questions_row = mysqli_fetch_assoc($total_questions_query);
        $total_questions = $total_questions_row['total_questions'];
    }

    if ($total_questions > 0) {
        // Assuming each correct answer is worth 4 points.
        $max_possible_score = $total_questions * 4;
        if ($max_possible_score > 0) {
            $percentage = ($score / $max_possible_score) * 100;
        } else {
            $percentage = 0;
        }
    } else {
        $percentage = 0;
    }
} else {
    $score = 0;
    $percentage = 0;
}

// Optionally, round the result to a desired number of decimals.
$percentage = round($percentage, 2);


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $name; ?></title>
  <!-- Latest Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    @media print {
      .no-print { display: none; }
    }
  </style>
</head>
<body class="bg-light">
  <div class="container my-4">
   

    <!-- Second table (kept unchanged) -->
    <table border="0" width="100%">
      <tr>
        <td width="100">
          <img style="border-radius: 10px;" height="110" width="95" src="logo.jpg" alt="Logo" />
        </td>
        <td valign="top" style="padding:10px; font-size:14px; text-align:center">
          <b style="font-size:17px">DINOLABS TECH SERVICES</b><br>
          <address>School address goes here</address>
          <span style="font-size:15px;">(Computer Based Test)</span><br />
          <b style="font-family:'Times New Roman', Times, serif;">Result Slip</b><br />
          Class: <b><?php echo $class; ?></b> | Arm: <b><?php echo $arm; ?></b>
        </td>
        <td width="100">
         
        </td>
      </tr>
    </table>
    <hr />

     <!-- Name Details -->
     <div class="row my-3">
      <div class="col-md-12">
        <div style="text-align: center"><strong> <h3><?php echo $name; ?></h3></strong> </div>
      </div>
    </div>

    <!-- Student Registration Details -->
    <div class="row my-3">
      <div class="col-md-4">
        <div><strong>REG. NO.:</strong> <?php echo $id; ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>CLASS:</strong> <?php echo $class; ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>ARM:</strong> <?php echo $arm; ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>SESSION:</strong> <?php echo $current_session; ?></div>
      </div>
      <div class="col-md-4">
        <div><strong>TERM:</strong> <?php echo $current_term; ?></div>
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
                echo "<td>$subject</td>";
                echo "<td>$individual_score</td>";
                echo "</tr>";
            }
            ?>
            <tr class="table-secondary">
              <td><strong>TOTAL</strong></td>
              <td><strong><?php echo $score; ?></strong></td>
            </tr>
            <tr class="table-success">
              <td><strong>PERCENTAGE</strong></td>
              <td><strong><?php echo $percentage; ?>%</strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

   
    <hr />

    <!-- Action Buttons -->
    <div class="row my-3">
      <div class="col-md-6">
        <a href="javascript:window.print()" class="btn btn-primary no-print">Print Result</a>
      </div>
      <div class="col-md-6 text-end">
        <a href="students.php" class="btn btn-danger no-print">Close Window</a>
      </div>
    </div>
  </div>

  <!-- Latest Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
