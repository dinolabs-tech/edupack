<?php include('database_schema.php');?>

<!DOCTYPE html>
<html>
<head>
  <title>Attendance Management System</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <?php include 'menu.php'; ?>
  <div class="container">
    <h2>Attendance Management System</h2>
    <ul class="list-group">
      <li class="list-group-item"><a href="mark_attendance.php">Mark Attendance</a></li>
      <li class="list-group-item"><a href="print_attendance.php">Print Attendance Records</a></li>
      <li class="list-group-item"><a href="print_attendance_summary.php">Print Attendance Summary</a></li>
    </ul>
  </div>
</body>
</html>
