<?php
/**
 * adquest.php
 *
 * This file provides an administrative interface for modifying existing CBT (Computer Based Test) questions.
 * It allows filtering questions by class, arm, term, session, and subject, and then editing individual questions.
 *
 * Key functionalities include:
 * - User authentication and session management (via admin_logic.php).
 * - Database connection.
 * - Handling POST requests for updating question details.
 * - Retrieving distinct academic parameters (class, arm, term, session, subject) for filtering.
 * - Displaying a list of questions based on applied filters.
 * - Providing an edit form for selected questions, utilizing TinyMCE for rich text editing.
 * - Client-side JavaScript to populate the edit form and manage its visibility.
 */

// Include the administrative logic file, which likely handles session checks and other admin-specific functions.
include('components/admin_logic.php');

// Initialize a message variable to store feedback for the user (e.g., success or error messages).
$update_message = '';

// Process update form submission when the 'update_question' button is clicked.
if (isset($_POST['update_question'])) {
  // Sanitize and retrieve input values from the POST request.
  $que_id   = $conn->real_escape_string($_POST['question_id']);
  $que_desc = $conn->real_escape_string($_POST['que_desc']);
  $ans1     = $conn->real_escape_string($_POST['ans1']);
  $ans2     = $conn->real_escape_string($_POST['ans2']);
  $ans3     = $conn->real_escape_string($_POST['ans3']);
  $ans4     = $conn->real_escape_string($_POST['ans4']);
  $true_ans = $conn->real_escape_string($_POST['true_ans']); // This will be 'A', 'B', 'C', or 'D'

  // Convert the letter-based correct answer (A, B, C, D) to a numerical representation (1, 2, 3, 4)
  // for storage in the database. Default to 1 if an invalid option is provided.
  $true_ans_num = 0;
  switch (strtoupper($true_ans)) {
      case 'A': $true_ans_num = 1; break;
      case 'B': $true_ans_num = 2; break;
      case 'C': $true_ans_num = 3; break;
      case 'D': $true_ans_num = 4; break;
      default: $true_ans_num = 1; break; // Default to A if something unexpected is received
  }

  // SQL query to update the question details in the 'question' table.
  $update_query = "UPDATE question
                   SET que_desc='$que_desc', ans1='$ans1', ans2='$ans2', ans3='$ans3', ans4='$ans4', true_ans='$true_ans_num'
                   WHERE que_id='$que_id'";
  // Execute the update query and check for success.
  if ($conn->query($update_query) === TRUE) {
      $update_message = "Question updated successfully!";
  } else {
      // If the query fails, set an error message.
      $update_message = "Error updating question: " . $conn->error;
  }
}

// --- Data Retrieval for Filter Dropdowns ---
// Fetch distinct classes from the 'question' table for the filter dropdown.
$distinctClasses = [];
$result = $conn->query("SELECT DISTINCT class FROM question");
if ($result) {
  while ($row = $result->fetch_assoc()) {
      $distinctClasses[] = $row['class'];
  }
}

// Fetch distinct arms from the 'question' table for the filter dropdown.
$distinctArms = [];
$result = $conn->query("SELECT DISTINCT arm FROM question");
if ($result) {
  while ($row = $result->fetch_assoc()) {
      $distinctArms[] = $row['arm'];
  }
}

// Fetch distinct terms from the 'question' table for the filter dropdown.
$distinctTerms = [];
$result = $conn->query("SELECT DISTINCT term FROM question");
if ($result) {
  while ($row = $result->fetch_assoc()) {
      $distinctTerms[] = $row['term'];
  }
}

// Fetch distinct sessions from the 'question' table for the filter dropdown.
$distinctSessions = [];
$result = $conn->query("SELECT DISTINCT session FROM question");
if ($result) {
  while ($row = $result->fetch_assoc()) {
      $distinctSessions[] = $row['session'];
  }
}

// Fetch distinct subjects from the 'question' table for the filter dropdown.
$distinctSubject = [];
$result = $conn->query("SELECT DISTINCT subject FROM question");
if ($result) {
  while ($row = $result->fetch_assoc()) {
      $distinctSubject[] = $row['subject'];
  }
}

// --- Build Filter Conditions for Main Question Query ---
$where = []; // Initialize an array to hold WHERE clause conditions.
// Check GET parameters and add conditions if they are set and not empty.
if (isset($_GET['class']) && $_GET['class'] !== "") {
  $where[] = "class='" . $conn->real_escape_string($_GET['class']) . "'";
}
if (isset($_GET['arm']) && $_GET['arm'] !== "") {
  $where[] = "arm='" . $conn->real_escape_string($_GET['arm']) . "'";
}
if (isset($_GET['term']) && $_GET['term'] !== "") {
  $where[] = "term='" . $conn->real_escape_string($_GET['term']) . "'";
}
if (isset($_GET['session']) && $_GET['session'] !== "") {
  $where[] = "session='" . $conn->real_escape_string($_GET['session']) . "'";
}
if (isset($_GET['subject']) && $_GET['subject'] !== "") {
  $where[] = "subject='" . $conn->real_escape_string($_GET['subject']) . "'";
}

// Construct the main query to fetch questions, applying filters if any.
$query = "SELECT * FROM question";
if (count($where) > 0) {
  $query .= " WHERE " . implode(" AND ", $where); // Join conditions with 'AND'.
}

$sqdel = $conn->query($query); // Execute the query to get questions.

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php');?> <!-- Includes the head section of the HTML document -->

<!-- Load TinyMCE CDN for rich text editing capabilities -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

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
                <h3 class="fw-bold mb-3">Modify Question</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">CBT</li>
                  <li class="breadcrumb-item active">Modify Question</li>
              </ol>
              </div>

            </div>

            <!-- Filter Question Section -->
            <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Filter Question</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                   <!-- Form for filtering questions based on academic parameters -->
                   <form method="GET" action="">
                      <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select name="class" id="class" class="form-select">
                          <option value="">Select Class</option>
                          <?php foreach ($distinctClasses as $classOption): ?>
                            <option value="<?php echo htmlspecialchars($classOption); ?>" <?php if(isset($_GET['class']) && $_GET['class'] == $classOption) echo 'selected'; ?>>
                              <?php echo htmlspecialchars($classOption); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="arm" class="form-label">Arm</label>
                        <select name="arm" id="arm" class="form-select">
                          <option value="">Select Arm</option>
                          <?php foreach ($distinctArms as $armOption): ?>
                            <option value="<?php echo htmlspecialchars($armOption); ?>" <?php if(isset($_GET['arm']) && $_GET['arm'] == $armOption) echo 'selected'; ?>>
                              <?php echo htmlspecialchars($armOption); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="term" class="form-label">Term</label>
                        <select name="term" id="term" class="form-select">
                          <option value="">Select Term</option>
                          <?php foreach ($distinctTerms as $termOption): ?>
                            <option value="<?php echo htmlspecialchars($termOption); ?>" <?php if(isset($_GET['term']) && $_GET['term'] == $termOption) echo 'selected'; ?>>
                              <?php echo htmlspecialchars($termOption); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="session" class="form-label">Session</label>
                        <select name="session" id="session" class="form-select">
                          <option value="">Select Session</option>
                          <?php foreach ($distinctSessions as $sessionOption): ?>
                            <option value="<?php echo htmlspecialchars($sessionOption); ?>" <?php if(isset($_GET['session']) && $_GET['session'] == $sessionOption) echo 'selected'; ?>>
                              <?php echo htmlspecialchars($sessionOption); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <select name="subject" id="subject" class="form-select">
                          <option value="">Select Subject</option>
                          <?php foreach ($distinctSubject as $subjectOption): ?>
                            <option value="<?php echo htmlspecialchars($subjectOption); ?>" <?php if(isset($_GET['subject']) && $_GET['subject'] == $subjectOption) echo 'selected'; ?>>
                              <?php echo htmlspecialchars($subjectOption); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success"><span class="btn-label">
                        <i class="fa fa-filter"></i> Filter Questions</button>
                      </div>
                    </form>

                   </div>
                 </div>
               </div>
             </div>

           </div>

           <!-- Modify Question Section -->
           <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Modify Question</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                        <?php
                          // Display any update messages (success or error) to the user.
                          if(isset($update_message)) {
                            echo '<div class="alert alert-info">' . htmlspecialchars($update_message) . '</div>';
                          }
                        ?>
                        <div class="table-responsive">
                        <!-- Table to display filtered questions -->
                        <table  id="multi-filter-select" class="table table-bordered table-striped">
                          <thead class="table-dark">
                            <tr class="text-center">
                              <th rowspan="2">Questions</th>
                              <th colspan="5">Options</th>
                              <th width="50px">Setting</th>
                            </tr>
                            <tr class="text-center">
                              <th>A</th>
                              <th>B</th>
                              <th>C</th>
                              <th>D</th>
                              <th>Answer</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            // Loop through each question fetched from the database.
                            while ($rowdel = $sqdel->fetch_assoc()) {
                                $q_idt   = $rowdel['que_id'];
                                $qst     = $rowdel['que_desc']; // Question description (may contain HTML from WYSIWYG)
                                $ans1    = $rowdel['ans1'];
                                $ans2    = $rowdel['ans2'];
                                $ans3    = $rowdel['ans3'];
                                $ans4    = $rowdel['ans4'];
                                $ts      = $rowdel['true_ans']; // Numerical representation of true answer
                                $tr1     = ''; // Letter representation of true answer
                                // Convert numerical true answer to letter (1=A, 2=B, etc.)
                                switch ($ts) {
                                    case 1: $tr1 = 'A'; break;
                                    case 2: $tr1 = 'B'; break;
                                    case 3: $tr1 = 'C'; break;
                                    case 4: $tr1 = 'D'; break;
                                }

                                // Output table row for each question.
                                echo '<tr>
                                        <td>
                                          <!-- Display the formatted (WYSIWYG) content for question description -->
                                          <div class="wysiwyg-content">' . $qst . '</div>
                                        </td>
                                        <td>
                                        <div class="wysiwyg-content"> ' . $ans1 . '</div>
                                        </td>
                                        <td>
                                        <div class="wysiwyg-content"> ' . $ans2 . '</div>
                                        </td>
                                        <td>
                                        <div class="wysiwyg-content"> ' . $ans3 . '</div>
                                        </td>
                                        <td>
                                        <div class="wysiwyg-content"> ' . $ans4 . '</div>
                                        </td>
                                        <td class="text-center">' . $tr1 . '</td>
                                        <td class="text-center">
                                          <!-- Edit button: populates the edit form with question data -->
                                          <a class="btn btn-sm btn-warning edit-btn mb-3"
                                            data-id="' . $q_idt . '"
                                            data-que="' . htmlspecialchars($qst, ENT_QUOTES) . '"
                                            data-ans1="' . htmlspecialchars($ans1, ENT_QUOTES) . '"
                                            data-ans2="' . htmlspecialchars($ans2, ENT_QUOTES) . '"
                                            data-ans3="' . htmlspecialchars($ans3, ENT_QUOTES) . '"
                                            data-ans4="' . htmlspecialchars($ans4, ENT_QUOTES) . '"
                                            data-trueans="' . $tr1 . '">
                                            <span class="btn-label">
                        <i class="fa fa-edit"></i>
                                          </a>
                                          <!-- Delete button: links to quedel.php for deletion -->
                                          <a class="btn btn-sm btn-danger" href="quedel.php?delid=' . $q_idt . '"><span class="btn-label">
                        <i class="fa fa-trash"></i></a>
                                        </td>
                                      </tr>';
                            }
                                    ?>
                                  </tbody>
                                </table>

                                          </div>
                                          <!-- Edit Form Container (initially hidden, shown when an edit button is clicked) -->
                                          <div id="editFormContainer" class="card mt-4" style="display: none;">
                                            <div class="card-header">
                                              Edit Question
                                            </div>
                                            <div class="card-body">
                                              <form id="editForm" method="POST" action="">
                                                <input type="hidden" name="question_id" id="editQuestionId">
                                                <div class="mb-3">
                                                  <label for="editQueDesc" class="form-label">Question</label>
                                                  <textarea class="form-control" name="que_desc" id="editQueDesc" rows="3" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="editAns1" class="form-label">Option A</label>
                                                  <textarea class="form-control" name="ans1" id="editAns1" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="editAns2" class="form-label">Option B</label>
                                                  <textarea class="form-control" name="ans2" id="editAns2" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="editAns3" class="form-label">Option C</label>
                                                  <textarea class="form-control" name="ans3" id="editAns3" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="editAns4" class="form-label">Option D</label>
                                                  <textarea class="form-control" name="ans4" id="editAns4" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="editTrueAns" class="form-label">Correct Answer</label>
                                                  <select class="form-select" name="true_ans" id="editTrueAns" required>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                  </select>
                                                </div>
                                                <div class="d-flex gap-2">
                                                  <button type="submit" name="update_question" class="btn btn-success"><span class="btn-label">
                                                  <i class="fa fa-sync-alt"></i>Update Question</button>
                                                  <button type="button" id="cancelEdit" class="btn btn-secondary"> <span class="btn-label">
                                                  <i class="fa fa-undo"></i> Cancel</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                          <!-- End Edit Form Container -->


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
    document.addEventListener('DOMContentLoaded', function() {
      // Listen for clicks on all edit buttons
      const editButtons = document.querySelectorAll('.edit-btn');
      const editFormContainer = document.getElementById('editFormContainer');

      editButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
          // Retrieve data attributes from the clicked button
          const questionId = this.getAttribute('data-id');
          const queDesc    = this.getAttribute('data-que');
          const ans1       = this.getAttribute('data-ans1');
          const ans2       = this.getAttribute('data-ans2');
          const ans3       = this.getAttribute('data-ans3');
          const ans4       = this.getAttribute('data-ans4');
          const trueAns    = this.getAttribute('data-trueans');

          // Populate the form fields using TinyMCE's API for rich text fields
          document.getElementById('editQuestionId').value = questionId;
          // Check if TinyMCE is initialized for the textarea before setting content
          if (tinymce.get('editQueDesc')) {
            tinymce.get('editQueDesc').setContent(queDesc);
          } else {
            document.getElementById('editQueDesc').value = queDesc;
          }
          if (tinymce.get('editAns1')) {
            tinymce.get('editAns1').setContent(ans1);
          } else {
            document.getElementById('editAns1').value = ans1;
          }
          if (tinymce.get('editAns2')) {
            tinymce.get('editAns2').setContent(ans2);
          } else {
            document.getElementById('editAns2').value = ans2;
          }
          if (tinymce.get('editAns3')) {
            tinymce.get('editAns3').setContent(ans3);
          } else {
            document.getElementById('editAns3').value = ans3;
          }
          if (tinymce.get('editAns4')) {
            tinymce.get('editAns4').setContent(ans4);
          } else {
            document.getElementById('editAns4').value = ans4;
          }
          document.getElementById('editTrueAns').value = trueAns;

          // Show the edit form
          editFormContainer.style.display = 'block';
          editFormContainer.scrollIntoView({ behavior: 'smooth' });
        });
      });

      // Cancel button hides the edit form
      document.getElementById('cancelEdit').addEventListener('click', function() {
        document.getElementById('editFormContainer').style.display = 'none';
      });
    });
  </script>

    <script>
      // Initialize TinyMCE for the question and answer textareas in the edit form.
      tinymce.init({
        selector: '#editQueDesc, #editAns1, #editAns2, #editAns3, #editAns4',
        menubar: false, // Hide the menubar for a cleaner interface.
        toolbar: 'undo redo | formatselect | bold italic underline superscript subscript | alignleft aligncenter alignright | bullist numlist outdent indent | table', // Customize toolbar buttons.
        plugins: 'lists', // Enable list plugin.
        branding: false // Hide TinyMCE branding.
      });
    </script>


  </body>
</html>
