<?php
/**
 * approvepayments.php
 *
 * This file provides an administrative interface for bursary staff to approve student payments.
 * It displays a list of pending payment deposits, allows viewing student details associated
 * with a deposit, and facilitates the approval process which moves the payment from a
 * temporary 'prebursary' table to the 'payments' table.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - AJAX handling for fetching student details based on deposit date and approving payments.
 * - Displaying a list of unapproved payments.
 * - Form for viewing and confirming payment details.
 * - Dynamic display of student image (if available).
 * - Error handling and success messages for payment operations.
 * - Includes various UI components like head, navigation, header, footer, and scripts.
 */

// Enable error reporting for debugging purposes.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to maintain user state across requests.
session_start();

// Check if the user is logged in. If not, redirect them to the login page
// to enforce authentication for accessing this payment approval interface.
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

// --- Handle AJAX Requests ---
// This block processes AJAX requests for fetching student details, approving payments,
// and fetching updated table rows without a full page reload.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // Action: 'fetch' - Retrieve student details for a given deposit date.
    if ($_POST['action'] == 'fetch') {
        $student_date = $conn->real_escape_string($_POST['date']); // The 'date' here refers to the unique identifier for the prebursary entry.
        // Query to fetch details from the 'prebursary' table.
        $sql = "SELECT id, name, class, arm, term, gender, session, date, depositor, mobile, amount, narration
                  FROM prebursary
                 WHERE date = '$student_date'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // 1a) Look up the student’s internal ID from the 'students' table using their external ID ('id_no').
            $stmt = $conn->prepare("
                SELECT id
                  FROM students
                 WHERE id_no = ?
            ");
            $stmt->bind_param("s", $row['id']);     // $row['id'] is the student’s external ID (id_no).
            $stmt->execute();
            $stmt->bind_result($student_pk); // Bind the internal student ID (primary key).
            $stmt->fetch();
            $stmt->close();

            // 1b) Look up the 'ef_no' (enrollment/fee number) from 'student_ef_list' for the student.
            $ef_no = null;
            if ($student_pk) {
                $stmt2 = $conn->prepare("
                    SELECT ef_no
                      FROM student_ef_list
                     WHERE student_id = ?
                  ORDER BY date_created DESC
                     LIMIT 1
                ");
                $stmt2->bind_param("i", $student_pk); // Bind the internal student ID.
                $stmt2->execute();
                $stmt2->bind_result($ef_no); // Bind the ef_no.
                $stmt2->fetch();
                $stmt2->close();
            }

            // 1c) Include the 'ef_no' in the JSON payload response.
            $response = $row;
            $response['ef_no'] = $ef_no;
            echo json_encode($response);
        } else {
            echo json_encode(null); // Return null if no student found for the given date.
        }
        $conn->close(); // Close connection for AJAX response.
        exit; // Stop further PHP execution.
    }

    // Action: 'approve' - Process the approval of a payment.
    elseif ($_POST['action'] == 'approve') {
        // Read EF number from the form.
        $ef_no = trim($_POST['ef_no']);

        // 0) If there's no EF number, it means the student hasn't been properly registered for bursary.
        if (empty($ef_no)) {
            echo json_encode([
                "status"  => "error",
                "message" => "Sorry, this student hasn't been registered to use the bursary, Please register the student or contact Admin."
            ]);
            $conn->close();
            exit;
        }

        // 1) Mark the payment as approved in the 'prebursary' table by setting 'status' to 1.
        $student_date = $conn->real_escape_string($_POST['date']);
        $sql_update   = "UPDATE prebursary SET status = 1 WHERE date = '$student_date'";
        if ($conn->query($sql_update) !== TRUE) {
            echo json_encode([
                "status"  => "error",
                "message" => "Error updating record: " . $conn->error
            ]);
            $conn->close();
            exit;
        }

        // 2) Read amount and narration (remarks) from the form.
        $amount  = $conn->real_escape_string($_POST['amount']);
        $remarks = $conn->real_escape_string($_POST['narration']);

        // 3) Insert the approved payment into the 'payments' table.
        $sql_insert = "
            INSERT INTO payments (ef_id, amount, remarks, date_created)
            VALUES (
                '{$conn->real_escape_string($ef_no)}',
                '$amount',
                '$remarks',
                NOW()
            )
        ";
        if ($conn->query($sql_insert) === TRUE) {
            echo json_encode([
                "status"  => "success",
                "message" => "Transaction Approved!"
            ]);
        } else {
            echo json_encode([
                "status"  => "error",
                "message" => "Error inserting payment record: " . $conn->error
            ]);
        }
        $conn->close();
        exit;
    }

    // Action: 'fetch_table' - Fetch and return updated table rows for unapproved payments.
    elseif ($_POST['action'] == 'fetch_table') {
        $students = $conn->query("SELECT * FROM prebursary WHERE status = 0");
        $html     = ''; // Initialize an empty string to build HTML table rows.
        while ($row = $students->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['gender']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['class']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['arm']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['term']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['session']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['depositor']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['mobile']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['amount']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['narration']) . '</td>';
            $html .= '<td>';
            // Edit button: links to this page with the 'date' parameter to pre-fill the form.
            $html .= '<a href="?date=' . htmlspecialchars($row['date']) . '" class="btn btn-sm btn-warning">Edit</a> ';
            // Delete button: links to this page with 'delete_id' parameter.
            $html .= '<a href="?delete_id=' . htmlspecialchars($row['date']) . '" class="btn btn-sm btn-danger" '
                   . 'onclick="return confirm(\'Are you sure you want to delete this student?\')">Delete</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        echo $html; // Output the generated HTML.
        $conn->close(); // Close connection for AJAX response.
        exit; // Stop further PHP execution.
    }
}

// --- Page Load Logic (for initial page render) ---

// Fetch all unapproved payments for display in the table.
$students = $conn->query("SELECT * FROM prebursary WHERE status = 0");

// Get student details if an 'edit' request is made via GET parameter.
$student = null;
if (isset($_GET['date'])) {
  $id = $_GET['date'];
  $result = $conn->query("SELECT * FROM prebursary WHERE date='$id'");
  $student = $result->fetch_assoc(); // Fetch the student's details.
}

// Handle delete request if 'delete_id' is present in GET parameters.
if (isset($_GET['delete_id'])) {
  $id = $_GET['delete_id'];
  $conn->query("DELETE FROM prebursary WHERE date='$id'"); // Delete the record.
  header("Location: " . $_SERVER['PHP_SELF']); // Redirect to refresh the page.
  exit;
}

// Fetch the name of the logged-in staff member for display purposes.
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id); // Bind user ID as a string.
$stmt->execute();
$stmt->bind_result($staff_name); // Bind the result to $staff_name.
$stmt->fetch();
$stmt->close();

// Close the main database connection.
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php');?> <!-- Includes the head section of the HTML document (meta tags, title, CSS links) -->
<style>
     /* Styling for the image section to center content */
     #imageSection {
       display: flex;
       justify-content: center;
       align-items: center;
       min-height: 50vh; /* Full viewport height */
     }

     /* Styling for the student image */
     #studentImage {
       max-width: 300px;
       max-height: 300px;
       display: none; /* Hide by default; shown when a student is selected */
     }
     </style>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
     <?php include('adminnav.php');?> <!-- Includes the admin specific navigation sidebar -->
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <?php include('logo_header.php');?> <!-- Includes the logo and header content -->
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
         <?php include('navbar.php');?> <!-- Includes the main navigation bar -->
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Approve Payments</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Bursary</li>
                  <li class="breadcrumb-item active">Approve Payments</li>
              </ol>
              </div>

            </div>

            <!-- Payments Approval Section -->
            <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Payments</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                      <p>

                      <p>
                              <!-- Image Section: Displays student's image related to the deposit -->
                        <div id="imageSection" style="margin-left: 15%;">
                          <!-- The image will only be shown if a student is selected -->
                          <img id="studentImage" src="" alt="Student Image">
                        </div>
                      </p>
                          <!-- Registration Form: Used to display and approve payment details -->
                          <form method="post" class="row g-3" id="studentForm" onreset="setTimeout(() => {
                                    document.getElementById('date').value = '';
                                    document.getElementById('studentImage').style.display = 'none';
                                  }, 0);">

                          <div class="col-md-2">
                          <input class="form-control" type="text" id="id" name="id" required onkeyup="fetchStudentDetails(this.value)" placeholder="Student ID">
                          </div>

                          <div class="col-md-6">
                          <input class="form-control" type="text" id="name" name="name" readonly placeholder="Students Name">
                          </div>

                          <div class="col-md-2">
                          <input class="form-control" type="text" id="class" name="class" readonly placeholder="Class">
                          </div>

                          <div class="col-md-2">
                          <input class="form-control" type="text" id="arm" name="arm" readonly placeholder="Arm">
                          </div>

                          <div class="col-md-2">
                          <input class="form-control" type="text" id="term" name="term" readonly placeholder="Term">
                          </div>

                          <div class="col-md-4">
                          <input class="form-control" type="text" id="gender" name="gender" readonly placeholder="Gender">
                          </div>

                          <div class="col-md-4">
                          <input class="form-control" type="text" id="session" name="session" readonly placeholder="Academic Session">
                          </div>

                          <div class="col-md-8">
                          <input class="form-control" type="text" id="depositor" name="depositor" required readonly placeholder="Depositor's Name">
                          </div>

                          <div class="col-md-2">
                          <input class="form-control" type="text" id="mobile" name="mobile" required readonly placeholder="Mobile">
                          </div>

                          <div class="col-md-2">
                          <input class="form-control" type="text" id="amount" name="amount" required readonly placeholder="Amount">
                          </div>

                          <div class="col-md-2">
                          <input class="form-control" type="text" id="narration" name="narration" required readonly placeholder="Narration">
                          </div>

                          <div class="col-md-4">
  <input
    class="form-control" type="hidden" id="ef_no" name="ef_no" readonly placeholder="EF No">
</div>

                          <!-- Hidden input for the deposit date, used as a unique identifier for prebursary entries -->
                          <input class="form-control" type="hidden" id="date" name="date" value="<?= isset($student) ? htmlspecialchars($student['date']) : '' ?>" required onchange="fetchStudentDetails(this.value)"><br>

                          <!-- Hidden input to specify the AJAX action as 'approve' -->
                          <input class="form-control" type="hidden" name="action" value="approve">

                              <button type="submit" class="btn btn-success"> <span class="btn-label">
                              <i class="fa fa-check-circle"></i>Confirm Deposit</button>

                              <button type="reset" class="btn btn-dark"><span class="btn-label">
                              <i class="fa fa-undo"></i>Reset</button>
                          </form>
                    </p>

                   </div>
                 </div>
               </div>
             </div>


           </div>

           <!-- Deposits Table Section -->
           <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Deposits</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">
                    <div class="table-responsive">
                   <!-- Table to display unapproved deposits -->
                   <table
                        id="multi-filter-select"
                        class="display table table-striped table-hover">
                          <thead class="bg-primary text-white">
                              <tr>
                                  <th>Reg No</th>
                                  <th>Name</th>
                                  <th>Sex</th>
                                  <th>Class</th>
                                  <th>Arm</th>
                                  <th>Term</th>
                                  <th>Session</th>
                                  <th>Depositor</th>
                                  <th>Mobile</th>
                                  <th>Amount</th>
                                  <th>Narration</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php while ($row = $students->fetch_assoc()): ?>
                                  <tr>
                                      <td><?= htmlspecialchars($row['id']) ?></td>
                                      <td><?= htmlspecialchars($row['name']) ?></td>
                                      <td><?= htmlspecialchars($row['gender']) ?></td>
                                      <td><?= htmlspecialchars($row['class']) ?></td>
                                      <td><?= htmlspecialchars($row['arm']) ?></td>
                                      <td><?= htmlspecialchars($row['term']) ?></td>
                                      <td><?= htmlspecialchars($row['session']) ?></td>
                                      <td><?= htmlspecialchars($row['depositor']) ?></td>
                                      <td><?= htmlspecialchars($row['mobile']) ?></td>
                                      <td><?= htmlspecialchars($row['narration']) ?></td>
                                      <td><?= htmlspecialchars($row['amount']) ?></td>

                                      <td>
                                          <!-- Edit button: pre-fills the form above with this row's data -->
                                          <a href="?date=<?= htmlspecialchars($row['date']) ?>" class="btn btn-sm btn-warning"><span class="btn-label">
                                          <i class="fa fa-edit"></i></a>
                                          <!-- Delete button: deletes the record from prebursary table -->
                                          <a href="?delete_id=<?= htmlspecialchars($row['date']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')"><span class="btn-label">
                                          <i class="fa fa-trash"></i></a>
                                      </td>
                                  </tr>
                              <?php endwhile; ?>
                          </tbody>
                      </table>
                     </div>

                   </div>
                 </div>
               </div>
             </div>
           </div>


          </div>
        </div>

        <?php include('footer.php');?> <!-- Includes the footer section of the page -->
      </div>

      <!-- Custom template | don't include it in your project! -->
      <?php include('cust-color.php');?> <!-- Includes custom color settings or scripts -->
      <!-- End Custom template -->
    </div>
   <?php include('scripts.php');?> <!-- Includes general JavaScript scripts for the page -->


   <script>
  // JavaScript to handle image fullscreen on click.
  const studentImage = document.getElementById('studentImage');

  studentImage.addEventListener('click', () => {
    if (studentImage.requestFullscreen) {
      studentImage.requestFullscreen();
    } else if (studentImage.webkitRequestFullscreen) { /* Safari */
      studentImage.webkitRequestFullscreen();
    } else if (studentImage.msRequestFullscreen) { /* IE11 */
      studentImage.msRequestFullscreen();
    }
  });
</script>
<script>
  // Handle form submission via AJAX for payment approval.
  $("#studentForm").on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission (full page reload).

    $.ajax({
      type: "POST",
      url: "", // Submit to the same page.
      data: $(this).serialize(), // Serialize the form data, including the hidden 'action' field.
      success: function(response) {
        try {
          var data = JSON.parse(response); // Parse the JSON response from the server.
          if(data.status === "success") {
            alert(data.message); // Show success message.
            // Clear the form and hide the image after successful approval.
            $("#studentForm")[0].reset();
            $('#studentImage').hide();
            // Refresh the table to remove the approved record.
            refreshTable();
          } else {
            alert("Error: " + data.message); // Show error message.
          }
        } catch (e) {
          alert("An unexpected error occurred."); // Handle JSON parsing errors.
        }
      },
      error: function(xhr, status, error) {
        alert("AJAX error: " + error); // Handle AJAX communication errors.
      }
    });
  });

  // Function to refresh the table of unapproved payments via AJAX.
  function refreshTable() {
    $.ajax({
      type: "POST",
      url: "", // Request from the same page.
      data: { action: 'fetch_table' }, // Specify action to fetch updated table rows.
      success: function(response) {
        $("table tbody").html(response); // Replace the table body with new data.
      },
      error: function(xhr, status, error) {
        console.log("Error refreshing table: " + error); // Log errors during table refresh.
      }
    });
  }
</script>

  <script>
    /**
     * Fetches student details and populates the form fields based on a provided deposit date.
     * Also updates the student image display.
     * @param {string} studentId The unique deposit date (used as an ID in prebursary table).
     */
    function fetchStudentDetails(studentId) {
      if (studentId.length > 0) {
        $.ajax({
          type: 'POST',
          url: '', // Same page for AJAX handling.
          data: { date: studentId, action: 'fetch' }, // Send deposit date and fetch action.
          success: function(response) {
            var student = JSON.parse(response); // Parse the JSON response.
            if (student) {
              // Populate form fields with fetched student data.
              $('#id').val(student.id);
              $('#name').val(student.name);
              $('#class').val(student.class);
              $('#arm').val(student.arm);
              $('#term').val(student.term);
              $('#gender').val(student.gender);
              $('#session').val(student.session);
              $('#date').val(student.date);
              $('#depositor').val(student.depositor);
              $('#mobile').val(student.mobile);
              $('#amount').val(student.amount);
              $('#narration').val(student.narration);
              $('#ef_no').val(student.ef_no || ''); // Populate ef_no, default to empty if null.
              // Set student image source and display it.
              $('#studentImage').attr('src', 'bursary/' + student.date).show();
            } else {
              // Clear form fields and hide image if no student data is found.
              $('#id, #name, #class, #arm, #term, #gender, #session, #date, #depositor, #mobile, #amount, #narration').val('');
              $('#studentImage').hide();
            }
          }
        });
      } else {
        // Clear form fields and hide image if studentId is empty.
        $('#id, #name, #class, #arm, #term, #gender, #session, #date, #depositor, #mobile, #amount, #narration').val('');
        $('#studentImage').hide();
      }
    }

    // When the document is ready, check if a 'date' parameter is in the URL
    // (e.g., from an 'Edit' button click) and pre-fill the form.
    $(document).ready(function() {
      var date = $('#date').val();
      if (date) {
        fetchStudentDetails(date);
      }
    });
  </script>

  </body>
</html>
