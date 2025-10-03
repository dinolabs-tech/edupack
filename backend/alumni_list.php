<?php
/**
 * alumni_list.php
 *
 * This file displays a list of alumni students. Alumni are identified as students
 * with a 'status' of 1 in the 'students' table, typically indicating they have
 * graduated or completed their studies.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Fetching and displaying a list of alumni students with their name, gender, mobile, and email.
 * - Counting the total number of alumni for display.
 * - Fetching the name of the logged-in staff member (admin/superuser) for display in the navigation.
 * - Includes various UI components like navigation, header, and footer.
 */

// Start or resume a session. This is crucial for checking user login status.
session_start();
// Check if the user is logged in. If not, redirect them to the login page
// to ensure only authenticated users can access this list.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file to establish a connection to the database.
include('db_connection.php');

// Fetch alumni students: Select all students where their 'status' is 1.
$sql = "SELECT * FROM students WHERE status = 1";
$result = $conn->query($sql);
$alumni = []; // Initialize an empty array to store alumni records.

// Check if the query returned any rows.
if ($result->num_rows > 0) {
    // Loop through each row and add the student data to the $alumni array.
    while ($row = $result->fetch_assoc()) {
        $alumni[] = $row;
    }
}

// Count the number of alumni records fetched for display purposes.
$alumni_count = count($alumni);

// Fetch the name of the logged-in staff member.
// This is typically used for displaying the user's name in the header or sidebar.
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id); // Bind the user ID as a string.
$stmt->execute();
$stmt->bind_result($student_name); // Bind the result to $student_name (though it's a staff name here).
$stmt->fetch();
$stmt->close(); // Close the prepared statement.

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
                        <h3 class="fw-bold mb-3">Alumni</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="students.php">Home</a></li>
                            <li class="breadcrumb-item active">Alumni</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-round">
                            <div class="card-body">
                                <div class="card-head-row card-tools-still-right">
                                    <div class="card-title">Alumni List</div>
                                    <div class="card-tools">
                                        <span class="badge bg-primary text-white">
                                            Total: <?php echo $alumni_count; ?> <!-- Display the total count of alumni -->
                                        </span>
                                    </div>
                                </div>

                                <div class="table-responsive py-4">
                                    <!-- Table to display alumni records -->
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($alumni)): ?>
                                                <?php foreach ($alumni as $student): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['studentmobile']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">No alumni records found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

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
