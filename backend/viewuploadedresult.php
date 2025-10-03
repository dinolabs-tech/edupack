<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Database connection
include 'db_connection.php';

// Check connection
if ($conn->connect_error) {
  customErrorHandler(E_ERROR, "Connection failed: " . $conn->connect_error, __FILE__, __LINE__);
}


if (isset($_GET['action']) && $_GET['action'] === 'get_subjects') {
  // Fetch subjects based on class and arm
  $class = $_GET['class'];
  $arm = $_GET['arm'];

  // Query to fetch subjects
  $sql = "SELECT subject FROM subject WHERE class = ? AND arm = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $class, $arm);
  $stmt->execute();
  $result = $stmt->get_result();

  $subjects = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $subjects[] = $row;
    }
  }
  $stmt->close();

  // Return the subjects as JSON
  echo json_encode($subjects);
  exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'get_records') {
  // Fetch records based on class, arm, term, and subject
  $class = $_GET['class'];
  $arm = $_GET['arm'];
  $term = $_GET['term'];
  $subject = $_GET['subject'];

  // Query to fetch records from the mastersheet table
  //$sql = "SELECT * FROM mastersheet WHERE class = '$class' AND arm = '$arm' AND term = '$term' AND subject = '$subject'";
  $sql = "SELECT * FROM mastersheet WHERE class = ? AND subject = ? AND arm = ? AND term = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $class, $subject, $arm, $term);
  $stmt->execute();
  $result = $stmt->get_result();

  $records = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $records[] = $row;
    }
  }
  $stmt->close();

  // Return the records as JSON
  echo json_encode($records);
  exit;
}


// Fetch the logged-in Staff name
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($student_name);
$stmt->fetch();
$stmt->close();


?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include('adminnav.php'); ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <?php include('logo_header.php');?>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <?php include('navbar.php');?>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Uploaded Results</h3>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Results</li>
                <li class="breadcrumb-item active">Uploaded Results</li>
              </ol>
            </div>

          </div>

          <!-- BULK UPLOAD ============================ -->
          <div class="row">

            <div class="col-md-12">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Uploaded Results</div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <div class="mb-4 mt-2">
                    <p>

                    <form onsubmit="loadRecords(event)">
                      <div class="form-group">
                        <select class="form-control form-select" id="class" name="class" onchange="loadSubjects()">
                          <option value="">Select Class</option>
                          <?php
                          // Query to fetch classes
                          $sql = "SELECT class FROM class";
                          $stmt = $conn->prepare($sql);
                          $stmt->execute();
                          $result = $stmt->get_result();
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              echo '<option value="' . $row['class'] . '">' . $row['class'] . '</option>';
                            }
                          }
                          $stmt->close();
                          ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <select class="form-control form-select" id="arm" name="arm" onchange="loadSubjects()">
                          <option value="">Select Arm</option>
                          <?php
                          // Query to fetch arms
                          $sql = "SELECT arm FROM arm";
                          $stmt = $conn->prepare($sql);
                          $stmt->execute();
                          $result = $stmt->get_result();
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              echo '<option value="' . $row['arm'] . '">' . $row['arm'] . '</option>';
                            }
                          }
                          $stmt->close();
                          ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <select class="form-control form-select" id="term" name="term">
                          <option value="">Select Term</option>
                          <option value="1st Term">1st Term</option>
                          <option value="2nd Term">2nd Term</option>
                          <option value="3rd Term">3rd Term</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <select class="form-control form-select" id="subject" name="subject">
                          <option value="">Select Subject</option>
                        </select>
                      </div>

                      <button type="submit" class="btn btn-success"><span class="btn-label">
                          <i class="fa fa-check-circle"></i>Submit</button>
                    </form>

                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">

            <div class="col-md-12">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Uploaded Results</div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <div class="mb-4 mt-2">
                    <p>

                    <div class="table-responsive">
                      <!-- Display subjects -->
                      <table
                        id="recordsTable"
                        class="display table table-striped table-hover">

                        <!-- Records will be loaded here -->
                      </table>
                    </div>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>

      </script>
      <?php include('footer.php'); ?>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <?php include('cust-color.php'); ?>
    <!-- End Custom template -->
  </div>
  <?php include('scripts.php'); ?>
  <script>
    // Function to fetch subjects based on selected class and arm
    function loadSubjects() {
      var classVal = document.getElementById('class').value;
      var armVal = document.getElementById('arm').value;

      if (classVal && armVal) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?action=get_subjects&class=' + classVal + '&arm=' + armVal, true);
        xhr.onload = function() {
          if (xhr.status === 200) {
            var subjects = JSON.parse(xhr.responseText);
            var subjectSelect = document.getElementById('subject');
            subjectSelect.innerHTML = '<option value="">Select Subject</option>'; // Reset subject dropdown

            // Populate subject dropdown
            subjects.forEach(function(subject) {
              var option = document.createElement('option');
              option.value = subject.subject;
              option.textContent = subject.subject;
              subjectSelect.appendChild(option);
            });
          }
        };
        xhr.send();
      }
    }

    // Function to load records based on selected class, arm, term, and subject
    function loadRecords(event) {
      event.preventDefault(); // Prevent form submission

      var classVal = document.getElementById('class').value;
      var armVal = document.getElementById('arm').value;
      var termVal = document.getElementById('term').value;
      var subjectVal = document.getElementById('subject').value;

      if (classVal && armVal && termVal && subjectVal) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?action=get_records&class=' + classVal + '&arm=' + armVal + '&term=' + termVal + '&subject=' + subjectVal, true);
        xhr.onload = function() {
          if (xhr.status === 200) {
            var records = JSON.parse(xhr.responseText);
            var recordsTable = document.getElementById('recordsTable');
            recordsTable.innerHTML = ''; // Reset the table

            // Add headers
            recordsTable.innerHTML = '<tr><th>ID</th><th>Name</th><th>Class</th><th>Arm</th><th>CA1</th><th>CA2</th><th>Exam</th><th>Total</th><th>Term</th><th>Subject</th></tr>';

            // Populate table with records
            records.forEach(function(record) {
              var row = document.createElement('tr');
              row.innerHTML =
                '<td>' + record.id + '</td>' +
                '<td>' + record.name + '</td>' +
                '<td>' + record.class + '</td>' +
                '<td>' + record.arm + '</td>' +
                '<td>' + record.ca1 + '</td>' +
                '<td>' + record.ca2 + '</td>' +
                '<td>' + record.exam + '</td>' +
                '<td>' + record.total + '</td>' +
                '<td>' + record.term + '</td>' +
                '<td>' + record.subject + '</td>';
              recordsTable.appendChild(row);
            });
          }
        };
        xhr.send();
      } else {
        alert('Please select all fields!');
      }
    }
  </script>
</body>

</html>
</file_content>
<task_progress>
- [x] SQL Injection Prevention: Identify database interactions
- [x] SQL Injection Prevention: Review and refactor queries to use prepared statements
- [x] Session Management: Locate login logic
- [x] Session Management: Implement session regeneration after successful login
- [ ] Input Validation: Identify user input points
- [ ] PHP Best Practices: Review and update code for modern practices and deprecated functions
- [ ] Caching: Identify cache candidates (static/frequently accessed data)
- [ ] Caching: Implement a caching mechanism
- [ ] Asset Optimization: Locate CSS and JavaScript files
</task_progress>
</write_to_file>
