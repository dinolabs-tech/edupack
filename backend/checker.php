<?php

/**
 * checker.php
 * 
 * Generates a CBT result slip for a student by joining `students` and `cbt_score` tables.
 */

session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

include 'db_connection.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// --- Handle Form Submission ---
if (isset($_POST['checksubmit'])) {
  $check = trim($_POST['check']); // student ID

  // 🔹 JOIN students and cbt_score
  $stmt = $conn->prepare("
        SELECT 
            s.id, 
            s.name, 
            s.gender, 
            c.class, 
            c.arm,
            c.subject,
            c.term,
            c.session,
            c.test_date,
            c.score
        FROM students s
        INNER JOIN cbt_score c ON s.id = c.login
        WHERE s.id = ?
    ");
  $stmt->bind_param("s", $check);
  $stmt->execute();
  $result = $stmt->get_result();

  // If no record found
  if ($result->num_rows === 0) {
    echo "<script>
                alert('The Registration Number does not exist. No such Registration Number in this DATABASE');
                window.location='checkcbt.php';
              </script>";
    exit();
  }

  // Fetch first row for student info
  $firstRow = $result->fetch_assoc();
  $id = $firstRow['id'];
  $name = $firstRow['name'];
  $gender = $firstRow['gender'];
  $class = $firstRow['class'];
  $arm = $firstRow['arm'];
  $cbt_term = $firstRow['term'];
  $cbt_session = $firstRow['session'];


  // Move pointer back to start (since we already fetched one row)
  $result->data_seek(0);

  // --- Current Session and Term ---
  $getSession = $conn->query("SELECT csession FROM currentsession WHERE id = 1");
  $csession = $getSession->fetch_assoc()['csession'] ?? '';

  $getTerm = $conn->query("SELECT cterm FROM currentterm WHERE id = 1");
  $term = $getTerm->fetch_assoc()['cterm'] ?? '';

  // --- Total Scores ---
  $sk = $conn->query("SELECT SUM(score) AS total_score FROM cbt_score WHERE login='$id'");
  $appostk = $sk->fetch_assoc();
  $score = $appostk['total_score'] ?? 0;
  $score1 = $score * 4;

  // Calculate percentage
   $maxScreeningScore = 100;
  $percentage = $maxScreeningScore > 0 ? round(($score1 / $maxScreeningScore) * 100, 2) : 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($name ?? 'Result Slip'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .identity-header img,
    .identity-photo img {
      max-height: 110px;
    }

    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body class="bg-light">
  <div class="container my-4">
    <!-- Header -->
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
          Class: <b><?php echo htmlspecialchars($class ?? ''); ?></b> | Arm: <?php echo htmlspecialchars($arm ?? ''); ?>
        </td>
        <td width="100"></td>
      </tr>
    </table>
    <hr />

    <!-- Name -->
    <div class="row my-3 text-center">
      <div class="col-md-12">
        <h3><strong><?php echo htmlspecialchars($name ?? ''); ?></strong></h3>
      </div>
    </div>

    <!-- Student Info -->
    <div class="row my-3">
      <div class="col-md-4"><strong>REG. NO.:</strong> <?php echo htmlspecialchars($id ?? ''); ?></div>
      <div class="col-md-4"><strong>CLASS:</strong> <?php echo htmlspecialchars($class ?? ''); ?></div>
      <div class="col-md-4"><strong>ARM:</strong> <?php echo htmlspecialchars($arm ?? ''); ?></div>
      <div class="col-md-4"><strong>SESSION:</strong> <?php echo htmlspecialchars($cbt_session ?? ''); ?></div>
      <div class="col-md-4"><strong>TERM:</strong> <?php echo htmlspecialchars($cbt_term ?? ''); ?></div>
      <div class="col-md-4"><strong>GENDER:</strong> <?php echo htmlspecialchars($gender ?? ''); ?></div>

    </div>

    <!-- Subject Scores -->
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
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo htmlspecialchars($row['score']); ?></td>
              </tr>
            <?php endwhile; ?>
            <tr class="table-secondary">
              <td><strong>TOTAL</strong></td>
              <td><strong><?php echo htmlspecialchars($score); ?></strong></td>
            </tr>
            <tr>
              <td><strong>PERCENTAGE</strong></td>
              <td><strong><?php echo htmlspecialchars($percentage); ?>%</strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <hr />

    <!-- Buttons -->
    <div class="row my-3">
      <div class="col-md-6">
        <a href="javascript:window.print()" class="btn btn-primary no-print">Print Result</a>
      </div>
      <div class="col-md-6 text-end">
        <a href="checkcbt.php" class="btn btn-danger no-print">Close Window</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>