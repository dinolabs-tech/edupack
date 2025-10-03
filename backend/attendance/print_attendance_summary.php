<?php
require('fpdf/fpdf.php');
// Database connection
include 'db_connection.php';

// 1) Fetch current term
$current_term_id = null;
$sqlTerm = "SELECT cterm FROM currentterm LIMIT 1";
if ($res = $conn->query($sqlTerm)) {
    if ($row = $res->fetch_assoc()) {
        $current_term_id = $row['cterm'];
    }
    $res->free();
}
if ($current_term_id === null) {
    die("Error: Could not retrieve current term. Please configure it in the database.");
}

// 2) Fetch current session
$current_session_id = null;
$sqlSess = "SELECT csession FROM currentsession LIMIT 1";
if ($res = $conn->query($sqlSess)) {
    if ($row = $res->fetch_assoc()) {
        $current_session_id = $row['csession'];
    }
    $res->free();
}
if ($current_session_id === null) {
    die("Error: Could not retrieve current session. Please configure it in the database.");
}

// 3) Fetch classes and arms for filter dropdowns
$classes = [];
if ($res = $conn->query("SELECT class FROM class ORDER BY class")) {
    while ($r = $res->fetch_assoc()) {
        $classes[] = $r['class'];
    }
    $res->free();
}

$arms = [];
if ($res = $conn->query("SELECT arm FROM arm ORDER BY arm")) {
    while ($r = $res->fetch_assoc()) {
        $arms[] = $r['arm'];
    }
    $res->free();
}

// Get filters
$selected_class = $_GET['class'] ?? '';
$selected_arm   = $_GET['arm'] ?? '';

// Fetch attendance records
function getAttendanceRecords($conn, $class, $arm, $term_id, $session_id) {
    $sql = "SELECT s.name, a.date, a.status
            FROM students s
            LEFT JOIN attendance a ON s.name=a.name
                AND s.class=a.class AND s.arm=a.arm
                AND a.term_id='$term_id' AND a.session_id='$session_id'
            WHERE s.class='$class' AND s.arm='$arm'
            ORDER BY s.name, a.date";
    $res = $conn->query($sql);
    $records = [];
    while ($row = $res->fetch_assoc()) {
        $records[] = $row;
    }
    return $records;
}

$attendance_records = [];
if ($selected_class && $selected_arm) {
    $attendance_records = getAttendanceRecords(
        $conn, $selected_class, $selected_arm,
        $current_term_id, $current_session_id
    );
}

// Generate PDF showing only totals
function generateAttendancePDF($records, $class, $arm) {
    $pdf = new FPDF('L','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);

    // Title
    $pdf->Cell(0,10, "Attendance Summary for $class - $arm", 0,1,'C');

    // Calculate total school days from attendance records
    $school_days = [];
    foreach ($records as $r) {
        if ($r['date']) {
            $school_days[$r['date']] = 1; // Use date as key to ensure uniqueness
        }
    }
    $total_days = count($school_days);

    // Pre-calculate present counts per student
    $presentCounts = [];
    foreach ($records as $r) {
        $name = $r['name'];
        if ($r['status'] == 1) {
            if (!isset($presentCounts[$name])) {
                $presentCounts[$name] = 0;
            }
            $presentCounts[$name]++;
        }
    }

    // Column widths
    $name_w = 120;
    $stat_w = 40;
    $row_h  = 8;

    // Header row
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell($name_w, $row_h, 'Student Name', 1, 0, 'C');
    $pdf->Cell($stat_w, $row_h, 'Days School Opened', 1, 0, 'C');
    $pdf->Cell($stat_w, $row_h, 'Days Present', 1, 0, 'C');
    $pdf->Cell($stat_w, $row_h, 'Days Absent', 1, 1, 'C');

    // Data rows
    $pdf->SetFont('Arial','',10);
    $lastStudent = '';
    foreach ($records as $r) {
        $name = $r['name'];
        if ($name !== $lastStudent) {
            $lastStudent = $name;
            $present = $presentCounts[$name] ?? 0;
            $absent  = $total_days - $present;

            $pdf->Cell($name_w, $row_h, $name, 1);
            $pdf->Cell($stat_w, $row_h, $total_days, 1, 0, 'C');
            $pdf->Cell($stat_w, $row_h, $present, 1, 0, 'C');
            $pdf->Cell($stat_w, $row_h, $absent, 1, 1, 'C');
        }
    }

    // Output the PDF
    $pdf->Output('D', 'attendance_summary.pdf');
}

// Handle print
if (isset($_GET['print'])) {
    if ($selected_class && $selected_arm) {
        generateAttendancePDF(
            $attendance_records,
            $selected_class,
            $selected_arm
        );
        exit;
    } else {
        echo "<p>Please select both Class and Arm.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Attendance Records</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container mt-4">
  <form method="get" class="form-inline mb-3">
    <select name="class" class="form-control mr-2" onchange="this.form.submit()">
      <option value="">Class</option>
      <?php foreach($classes as $c): ?>
        <option value="<?= $c ?>" <?= $c==$selected_class?'selected':'' ?>><?= $c ?></option>
      <?php endforeach; ?>
    </select>
    <select name="arm" class="form-control mr-2" onchange="this.form.submit()">
      <option value="">Arm</option>
      <?php foreach($arms as $a): ?>
        <option value="<?= $a ?>" <?= $a==$selected_arm?'selected':'' ?>><?= $a ?></option>
      <?php endforeach; ?>
    </select>
    <button name="print" class="btn btn-primary">Print</button>
  </form>

  <?php if ($selected_class && $selected_arm && count($attendance_records)): ?>

<?php
  // Calculate total distinct school days
  $school_days = [];
  foreach ($attendance_records as $r) {
    if ($r['date']) {
      $school_days[$r['date']] = true;
    }
  }
  $total_days = count($school_days);

  // Count presents per student
  $presentCounts = [];
  foreach ($attendance_records as $r) {
    if ($r['status'] == 1) {
      $presentCounts[$r['name']] = ($presentCounts[$r['name']] ?? 0) + 1;
    }
  }

  // Build unique student list in order
  $students = [];
  foreach ($attendance_records as $r) {
    if (!isset($students[$r['name']])) {
      $students[$r['name']] = true;
    }
  }
?>

<h4>Attendance Summary for <?= htmlspecialchars($selected_class) ?> — <?= htmlspecialchars($selected_arm) ?></h4>
<table class="table table-bordered table-striped">
  <thead class="thead-dark">
    <tr>
      <th>Student Name</th>
      <th class="text-center">Days School Opened</th>
      <th class="text-center">Days Present</th>
      <th class="text-center">Days Absent</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach (array_keys($students) as $name): 
      $present = $presentCounts[$name] ?? 0;
      $absent  = $total_days - $present;
    ?>
      <tr>
        <td><?= htmlspecialchars($name) ?></td>
        <td class="text-center"><?= $total_days ?></td>
        <td class="text-center"><?= $present ?></td>
        <td class="text-center"><?= $absent ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php elseif ($selected_class && $selected_arm): ?>

<p class="alert alert-info">No attendance records found for <?= 
    htmlspecialchars("$selected_class — $selected_arm") ?>.</p>

<?php endif; ?>


</div>
</body>
</html>
