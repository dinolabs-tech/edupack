<?php
/**
 * addquestion.php
 *
 * This file allows administrators and teachers to add new questions for the CBT (Computer Based Test) system.
 * It handles the form submission for adding a question, including its description, options, correct answer,
 * and associated class, arm, subject, term, and session.
 *
 * Key functionalities include:
 * - Including necessary administrative logic and database connection.
 * - Processing POST requests to insert new question data into the 'question' table.
 * - Retrieving lists of classes, arms, and subjects from the database for form dropdowns.
 * - Displaying the current term and session automatically.
 * - Utilizing TinyMCE for rich text editing of question and answer options.
 * - Client-side JavaScript for filtering subjects based on selected class and arm.
 */

// Include the administrative logic file, which likely handles session checks and other admin-specific functions.
include('components/admin_logic.php');

// Initialize a message variable to store feedback for the user (e.g., success or error messages).
$insert_message = "";

// Check if the form for adding a question has been submitted.
if (isset($_POST['add_question'])) {
    // Debugging: Log the raw POST data to the error log for troubleshooting.
    error_log("POST Data: " . print_r($_POST, true));

    // Escape and retrieve input values from the POST request to prevent SQL injection.
    $que_desc  = $conn->real_escape_string($_POST['que_desc']);
    $ans1      = $conn->real_escape_string($_POST['ans1']);
    $ans2      = $conn->real_escape_string($_POST['ans2']);
    $ans3      = $conn->real_escape_string($_POST['ans3']);
    $ans4      = $conn->real_escape_string($_POST['ans4']);
    $true_ans  = $conn->real_escape_string($_POST['true_ans']); // This will be 'A', 'B', 'C', or 'D'
    $class     = $conn->real_escape_string($_POST['class']);
    $arm       = $conn->real_escape_string($_POST['arm']);
    $subject   = $conn->real_escape_string($_POST['subject']);
    $term      = $conn->real_escape_string($_POST['term']);
    $sessionq  = $conn->real_escape_string($_POST['session']); // Renamed from $session to $sessionq to avoid conflict with session_start()

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

    // SQL query to insert the new question details into the 'question' table.
    $insert_query = "INSERT INTO question
                    (que_desc, ans1, ans2, ans3, ans4, true_ans, class, arm, term, session, subject)
                    VALUES ('$que_desc', '$ans1', '$ans2', '$ans3', '$ans4', '$true_ans_num', '$class', '$arm', '$term', '$sessionq', '$subject')";

    // Execute the insert query and check for success.
    if ($conn->query($insert_query) === TRUE) {
        $insert_message = "Question added successfully!";
    } else {
        // If the query fails, set an error message and log the SQL error for debugging.
        $insert_message = "Error adding question: " . $conn->error;
        error_log("SQL Error: " . $conn->error);
    }
}

// --- Data Retrieval for Form Dropdowns ---

// Fetch all available classes from the 'class' table.
$classes = [];
$result = $conn->query("SELECT * FROM class");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}

// Fetch all available arms from the 'arm' table.
$arms = [];
$result = $conn->query("SELECT * FROM arm");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $arms[] = $row;
    }
}

// Fetch all available subjects from the 'subject' table.
$subjects = [];
$result = $conn->query("SELECT * FROM subject");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}

// Retrieve the current term from the 'currentterm' table.
$current_term = "";
$result = $conn->query("SELECT cterm FROM `currentterm` LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $current_term = $row['cterm'];
}

// Retrieve the current session from the 'currentsession' table.
$current_session = "";
$result = $conn->query("SELECT csession FROM currentsession LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $current_session = $row['csession'];
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php');?> <!-- Includes the head section of the HTML document -->

<!-- Load TinyMCE CDN for rich text editing capabilities -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

<body>
    <div class="wrapper">
        <?php include('adminnav.php');?> <!-- Includes the admin navigation bar -->
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <?php include('logo_header.php');?> <!-- Includes the logo and header section -->
                </div>
                <?php include('navbar.php');?> <!-- Includes the main navigation bar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Add Question</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">CBT</li>
                                <li class="breadcrumb-item active">Add Question</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Enter New Question</div>
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <?php
                                        // Display any insert messages (success or error) to the user.
                                        if (!empty($insert_message)) {
                                            echo '<div class="alert alert-info">' . htmlspecialchars($insert_message) . '</div>';
                                        }
                                        ?>
                                        <!-- Form for adding a new question. Submits data via POST to this same page. -->
                                        <form method="POST" action="">
                                            <div class="mb-3">
                                                <label for="que_desc" class="form-label">Question</label>
                                                <textarea class="form-control" name="que_desc" id="que_desc" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ans1" class="form-label">Option A</label>
                                                <textarea class="form-control" name="ans1" id="ans1" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ans2" class="form-label">Option B</label>
                                                <textarea class="form-control" name="ans2" id="ans2" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ans3" class="form-label">Option C</label>
                                                <textarea class="form-control" name="ans3" id="ans3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ans4" class="form-label">Option D</label>
                                                <textarea class="form-control" name="ans4" id="ans4" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="true_ans" class="form-label">Correct Answer (Enter A, B, C, or D)</label>
                                                <select class="form-select" name="true_ans" id="true_ans" required>
                                                    <option value="">Select Correct Answer</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-select" name="class" id="class" required>
                                                    <option value="">Select Class</option>
                                                    <?php foreach ($classes as $cls): ?>
                                                        <option value="<?php echo htmlspecialchars($cls['class']); ?>"><?php echo htmlspecialchars($cls['class']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-select" name="arm" id="arm" required>
                                                    <option value="">Select Arm</option>
                                                    <?php foreach ($arms as $a): ?>
                                                        <option value="<?php echo htmlspecialchars($a['arm']); ?>"><?php echo htmlspecialchars($a['arm']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-select" name="subject" id="subject" required>
                                                    <option value="">Select Subject</option>
                                                    <!-- Options will be dynamically loaded by JavaScript based on class and arm selection -->
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="term" id="term" value="<?php echo htmlspecialchars($current_term); ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="session" id="session" value="<?php echo htmlspecialchars($current_session); ?>" readonly>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <input type="submit" name="add_question" class="btn btn-success" value="Add Question">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.php');?> <!-- Includes the footer section -->
        </div>
        <?php include('cust-color.php');?> <!-- Includes custom color settings or scripts -->
    </div>
    <?php include('scripts.php');?> <!-- Includes general JavaScript scripts -->

    <!-- TinyMCE Initialization Script -->
   <script>
        tinymce.init({
            selector: '#que_desc, #ans1, #ans2, #ans3, #ans4', // Apply TinyMCE to question description and all answer options
            menubar: false, // Hide the menubar for a cleaner interface
            toolbar: 'undo redo | formatselect | bold italic underline superscript subscript | alignleft aligncenter alignright | bullist numlist outdent indent | table | tableprops tablecellprops tableinsertrowbefore tableinsertrowafter tabledeleterow tableinsertcolbefore tableinsertcolafter tabledeletecol', // Customize toolbar buttons
            plugins: 'lists table', // Enable list and table plugins
            branding: false, // Hide TinyMCE branding
            setup: function (editor) {
                // Save content to the textarea on change, ensuring form submission gets the latest content.
                editor.on('change', function () {
                    editor.save();
                });
            }
        });

        // Event listener for form submission to ensure TinyMCE content is saved before sending.
        document.querySelector('form').addEventListener('submit', function () {
            tinymce.triggerSave(); // Manually trigger save for all TinyMCE instances
            // Debugging: Log TinyMCE content to console for verification (can be removed in production)
            console.log("Question: ", tinymce.get('que_desc').getContent());
            console.log("Answer 1: ", tinymce.get('ans1').getContent());
            console.log("Answer 2: ", tinymce.get('ans2').getContent());
            console.log("Answer 3: ", tinymce.get('ans3').getContent());
            console.log("Answer 4: ", tinymce.get('ans4').getContent());
        });
    </script>

    <!-- Subject Filtering Script -->
    <script>
        // PHP-generated JSON array of subjects, accessible by JavaScript.
        const subjectsData = <?php echo json_encode($subjects); ?>;

        /**
         * Filters the subjects dropdown based on the selected class and arm.
         *
         * This function reads the selected values from the 'class' and 'arm' dropdowns,
         * then filters the `subjectsData` array to find subjects that match both.
         * The 'subject' dropdown is then repopulated with these filtered subjects.
         */
        function filterSubjects() {
            const selectedClass = document.getElementById('class').value;
            const selectedArm = document.getElementById('arm').value;
            const subjectSelect = document.getElementById('subject');

            // Clear existing options in the subject dropdown and add a default "Select Subject" option.
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';

            // Filter subjects based on the selected class and arm.
            const filtered = subjectsData.filter(item => {
                return item.class === selectedClass && item.arm === selectedArm;
            });

            // Add the filtered subjects as new options to the subject dropdown.
            filtered.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.subject;
                opt.textContent = item.subject;
                subjectSelect.appendChild(opt);
            });
        }

        // Attach the `filterSubjects` function to the 'change' event of the class and arm dropdowns.
        document.getElementById('class').addEventListener('change', filterSubjects);
        document.getElementById('arm').addEventListener('change', filterSubjects);

        // Call filterSubjects initially to populate the subject dropdown if class/arm are pre-selected (e.g., on page load with old input).
        // This is important if the form retains values after a failed submission.
        filterSubjects();
    </script>
</body>
</html>
