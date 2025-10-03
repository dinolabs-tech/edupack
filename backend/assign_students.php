<?php
/**
 * assign_students.php
 *
 * This file provides an administrative interface to assign multiple students to a single parent.
 * It allows administrators to select a parent and then choose which students are associated with that parent.
 * Existing assignments for the selected parent are first cleared, and then new assignments are created.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Handling POST requests to update parent-student relationships in the 'parent_student' table.
 * - Fetching lists of all registered parents and students for selection.
 * - Displaying success messages upon successful assignment.
 * - Includes various UI components like head, navigation, header, footer, and scripts.
 */

// Start or resume a session. This is crucial for checking user login status.
session_start();
// Check if the user is logged in. If not, redirect them to the login page
// to enforce authentication for accessing this page.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file to establish a connection to the database.
include('db_connection.php');

// Initialize a success message variable.
$success = "";

// Check if the form has been submitted with parent_id and student_ids.
if (isset($_POST['parent_id']) && isset($_POST['student_ids'])) {
    $parent_id = $_POST['parent_id'];
    $student_ids = $_POST['student_ids']; // This will be an array of selected student IDs.

    // Delete existing relationships for the parent using a prepared statement.
    // This ensures that only the newly selected students are associated with the parent.
    $stmt = $conn->prepare("DELETE FROM parent_student WHERE parent_id = ?");
    $stmt->bind_param("i", $parent_id); // Bind parent_id as an integer.
    $stmt->execute();
    $stmt->close();

    // Insert new relationships for each selected student.
    foreach ($student_ids as $student_id) {
       $stmt = $conn->prepare("INSERT INTO parent_student (parent_id, student_id) VALUES (?, ?)");
        $stmt->bind_param("is", $parent_id, $student_id); // Bind parent_id as integer, student_id as string.
        $stmt->execute();
        $stmt->close();
    }

    $success = "Students assigned successfully."; // Set success message.
}

// --- Data Retrieval for Form Dropdowns and Tables ---

// Fetch all registered parents from the 'parent' table.
$sql = "SELECT id, name FROM parent";
$parents = $conn->query($sql);

// Fetch all registered students from the 'students' table.
$sql = "SELECT id, name FROM students";
$students = $conn->query($sql);

// Fetch the name of the logged-in staff member for display purposes.
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id); // Bind user ID as a string.
$stmt->execute();
$stmt->bind_result($staff_name); // Bind the result to $staff_name.
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?> <!-- Includes the head section of the HTML document (meta tags, title, CSS links) -->

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('adminnav.php'); ?> <!-- Includes the admin specific navigation sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <?php include('logo_header.php'); ?> <!-- Includes the logo and header content -->
                </div>
                <?php include('navbar.php'); ?> <!-- Includes the main navigation bar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Assign Students</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Assign Students</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-body">
                                    <div class="card-head-row card-tools-still-right">
                                        <div class="card-title">Assign Students</div>
                                    </div>

                                    <?php if (!empty($success)): ?>
                                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                                    <?php endif; ?>

                                    <!-- Form for assigning students to a parent -->
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label for="parent_id" class="form-label">Select Parent:</label>
                                            <select name="parent_id" id="parent_id" class="form-select">
                                                <?php
                                                // Populate the parent dropdown with fetched parent records.
                                                if ($parents && $parents->num_rows > 0) {
                                                    while ($parent = $parents->fetch_assoc()) {
                                                        echo "<option value='" . htmlspecialchars($parent['id']) . "'>" . htmlspecialchars($parent['name']) . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No parents found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Select Students:</label>
                                            <?php if ($students && $students->num_rows > 0): ?>
                                                <div class="table-responsive">
                                                    <!-- Table to display all students with checkboxes for selection -->
                                                    <table id="basic-datatables" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Select</th>
                                                                <th>Student ID</th>
                                                                <th>Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($student = $students->fetch_assoc()): ?>
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="student_ids[]"
                                                                            value="<?= htmlspecialchars($student['id']) ?>">
                                                                    </td>
                                                                    <td><?= htmlspecialchars($student['id']) ?></td>
                                                                    <td><?= htmlspecialchars($student['name']) ?></td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php else: ?>
                                                <p>No students found.</p>
                                            <?php endif; ?>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Assign</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('footer.php'); ?> <!-- Includes the footer section of the page -->
        </div>

        <?php include('cust-color.php'); ?> <!-- Includes custom color settings or scripts -->
    </div>

    <?php include('scripts.php'); ?> <!-- Includes general JavaScript scripts for the page -->
</body>

</html>
