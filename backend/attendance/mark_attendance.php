<?php
// Database connection
include 'db_connection.php';

// Fetch classes from the database
$classes = array();
$sql_classes = "SELECT class FROM class";
$result_classes = $conn->query($sql_classes);
if ($result_classes->num_rows > 0) {
  while ($row = $result_classes->fetch_assoc()) {
    $classes[] = $row["class"];
  }
}

// Fetch arms from the database
$arms = array();
$sql_arms = "SELECT arm FROM arm";
$result_arms = $conn->query($sql_arms);
if ($result_arms->num_rows > 0) {
  while ($row = $result_arms->fetch_assoc()) {
    $arms[] = $row["arm"];
  }
}

// Get selected class and arm
$selected_class = isset($_GET['class']) ? $_GET['class'] : '';
$selected_arm = isset($_GET['arm']) ? $_GET['arm'] : '';
$selected_date = isset($_GET['attendance_date']) ? $_GET['attendance_date'] : date('Y-m-d');

// Fetch students based on selected class and arm
$students = array();
$sql_students = "SELECT id, name FROM students WHERE 1=1"; // Start with a neutral condition
if (!empty($selected_class)) {
  $sql_students .= " AND class = '$selected_class'";
}
if (!empty($selected_arm)) {
  $sql_students .= " AND arm = '$selected_arm'";
}
$result_students = $conn->query($sql_students);
if ($result_students->num_rows > 0) {
  while ($row = $result_students->fetch_assoc()) {
    $students[$row["id"]] = $row["name"];
  }
}

// Fetch attendance data for the selected date
$attendance_data = array();
$sql_attendance = "SELECT name, class, arm, status FROM attendance WHERE date = '$selected_date'";
$result_attendance = $conn->query($sql_attendance);
if ($result_attendance->num_rows > 0) {
  while ($row = $result_attendance->fetch_assoc()) {
    $attendance_data[$row["name"] . " " . $row["class"] . " " . $row["arm"]] = $row["status"];
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Mark Attendance</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $(function () {
    // Set default date from PHP
    var selectedDate = "<?php echo $selected_date; ?>";
    $("#datepicker").datepicker({
      dateFormat: 'yy-mm-dd',
      onSelect: function (dateText) {
        $("#attendance_date").val(dateText);
        $("#attendanceForm").submit();
      }
    });

    // Set the value of the datepicker input
    $("#datepicker").datepicker("setDate", selectedDate);
  });
</script>

</head>

<body>
  <?php include 'menu.php'; ?>
  <div class="container">
    <h2>Mark Attendance</h2>

    <form id="attendanceForm" method="get">
      <div class="form-group">
        <label for="class">Class:</label>
        <select class="form-control" id="class" name="class" onchange="this.form.submit()">
          <option value="">All Classes</option>
          <?php foreach ($classes as $class_name): ?>
            <option value="<?php echo $class_name; ?>" <?php if ($selected_class == $class_name)
                 echo "selected"; ?>>
              <?php echo $class_name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="arm">Arm:</label>
        <select class="form-control" id="arm" name="arm" onchange="this.form.submit()">
          <option value="">All Arms</option>
          <?php foreach ($arms as $arm_name): ?>
            <option value="<?php echo $arm_name; ?>" <?php if ($selected_arm == $arm_name)
                 echo "selected"; ?>>
              <?php echo $arm_name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="attendance_date">Date:</label>
        <input type="text" id="datepicker" class="form-control">
        <input type="hidden" name="attendance_date" id="attendance_date" value="<?php echo $selected_date; ?>">
      </div>
    </form>

    <form method="post" action="mark_attendance_process.php">
      <input type="hidden" name="attendance_date" value="<?php echo $selected_date; ?>">
      <input type="hidden" name="class" value="<?php echo $selected_class; ?>">
      <input type="hidden" name="arm" value="<?php echo $selected_arm; ?>">

      <?php if (empty($students)): ?>
        <p>No students found for the selected class and arm.</p>
      <?php else: ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Present</th>
              <th>Absent</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($students as $student_id => $student_name): ?>
              <?php
              $student_key = $student_name . " " . $selected_class . " " . $selected_arm;
              ?>
              <tr>
                <td><?php echo $student_name; ?></td>
                <td><input type="radio"
                    name="attendance[<?php echo $student_id; ?>][<?php echo $student_name; ?>][<?php echo $selected_class; ?>][<?php echo $selected_arm; ?>]"
                    value="1" <?php if (isset($attendance_data[$student_key]) && $attendance_data[$student_key] == 1)
                      echo "checked"; ?>></td>
                <td><input type="radio"
                    name="attendance[<?php echo $student_id; ?>][<?php echo $student_name; ?>][<?php echo $selected_class; ?>][<?php echo $selected_arm; ?>]"
                    value="0" <?php if (isset($attendance_data[$student_key]) && $attendance_data[$student_key] == 0)
                      echo "checked"; ?>></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" onclick="saveAttendance()">Save Attendance</button>
      <?php endif; ?>
    </form>

    <script>
      function saveAttendance() {
        var formData = new FormData(document.querySelector('form[action="mark_attendance_process.php"]'));

        fetch('mark_attendance_process.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            alert(data.message);
          })
      }
    </script>
  </div>
</body>

</html>