<?php
/**
 * calendar.php
 *
 * This file provides an administrative interface for managing academic calendar events.
 * It allows administrators to add new events, update existing ones, and delete events.
 * Events include a date, title, and description.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Handling POST requests for inserting or updating calendar events.
 * - Handling GET requests for deleting calendar events.
 * - Fetching and displaying all existing calendar events in a table.
 * - Client-side JavaScript for editing and deleting events.
 * - Includes various UI components like head, navigation, header, footer, and scripts.
 */

// Enable error reporting for debugging purposes.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to maintain user state across requests.
session_start();

// Check if the user is logged in. If not, redirect them to the login page
// to enforce authentication for accessing this calendar management interface.
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

// --- Handle Form Submission for Insert or Update ---
// This block processes POST requests for adding new events or updating existing ones.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Format the date from 'YYYY-MM-DD' (HTML date input) to 'MM/dd/yyyy' for consistency.
  $date = date("m/d/Y", strtotime($_POST['date']));
  $title = $_POST['title'];
  $description = $_POST['description'];

  if (isset($_GET['edit_id'])) {
    // If 'edit_id' is present in GET, it means an existing event is being updated.
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("UPDATE calendar SET date = ?, title = ?, description = ? WHERE id = ?");
    // Bind parameters: date, title, description as strings, id as integer.
    $stmt->bind_param("sssi", $date, $title, $description, $edit_id);
  } else {
    // Otherwise, it's a new event being inserted.
    $stmt = $conn->prepare("INSERT INTO calendar (date, title, description) VALUES (?, ?, ?)");
    // Bind parameters: date, title, description as strings.
    $stmt->bind_param("sss", $date, $title, $description);
  }

  $stmt->execute(); // Execute the prepared statement.
  $stmt->close();   // Close the statement.

  // Redirect to avoid form resubmission on page refresh.
  header("Location: calendar.php");
  exit();
}

// --- Handle Delete Request ---
// This block processes GET requests for deleting an event.
if (isset($_GET['delete_id'])) {
  $id = $_GET['delete_id'];
  $stmt = $conn->prepare("DELETE FROM calendar WHERE id = ?");
  $stmt->bind_param("i", $id); // Bind id as an integer.
  $stmt->execute();
  $stmt->close();
  // Redirect to refresh the page after deletion.
  header("Location: calendar.php");
  exit();
}

// --- Fetch Events for Display ---
// Retrieve all calendar events from the 'calendar' table.
$sql = "SELECT id, date, title, description FROM calendar";
$result = $conn->query($sql);
$events = []; // Initialize an empty array to store event records.
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $events[] = $row; // Add each event record to the array.
  }
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
                <h3 class="fw-bold mb-3">Calendar</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Calendar</li>
              </ol>
              </div>

            </div>

            <!-- Add/Edit Event Section -->
            <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Academic Calendar</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                    <!-- Form for adding or editing a calendar event -->
                    <form method="POST" class="row g-2">
                      <div class="col-md-6">
                      <input class="form-control" type="date" id="date" name="date" required>
                      </div>
                      <div class="col-md-6">
                      <input class="form-control" type="text" id="title" name="title" placeholder="Title" required>
                      </div>
                      <div class="col-md-12">
                      <textarea class="form-control" id="description" name="description" rows="4" placeholder="Description..." required></textarea>
                      <br>
                      <button class="btn btn-success btn-icon btn-round ps-1" type="submit"><span class="btn-label">
                      <i class="fa fa-save"></i> </button> <!-- Button text changes to "Update Event" in edit mode -->
                    </form>

                   </div>
                 </div>
               </div>
             </div>
           </div>

           <!-- View Events Section -->
           <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Events List</div> <!-- Changed title for clarity -->
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                    <div class="table-responsive">
                      <!-- Table to display all calendar events -->
                      <table
                        id="multi-filter-select"
                        class="display table table-striped table-hover">

                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['date']); ?></td>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo htmlspecialchars($event['description']); ?></td>
                                <td class="actions">
                                    <!-- Edit button: calls JavaScript function to populate form for editing -->
                                    <button class="btn btn-warning mb-3 btn-icon btn-round ps-2" onclick="editEvent(<?php echo $event['id']; ?>, '<?php echo htmlspecialchars($event['date']); ?>', '<?php echo htmlspecialchars($event['title']); ?>', '<?php echo htmlspecialchars($event['description']); ?>')"><span class="btn-label">
                                    <i class="fa fa-edit"></i></button>
                                    <!-- Delete button: calls JavaScript function to confirm and delete event -->
                                    <button class="btn btn-danger mb-3 btn-icon btn-round ps-1" onclick="confirmDelete(<?php echo $event['id']; ?>)"><span class="btn-label">
                                    <i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
    /**
     * Populates the event form with existing event data for editing.
     * Changes the form's action to include the event ID for update.
     * @param {number} id The ID of the event to edit.
     * @param {string} date The date of the event (MM/dd/yyyy).
     * @param {string} title The title of the event.
     * @param {string} description The description of the event.
     */
    function editEvent(id, date, title, description) {
        // Convert date from MM/dd/yyyy to YYYY-MM-DD for HTML date input.
        const [month, day, year] = date.split('/');
        document.getElementById('date').value = `${year}-${month}-${day}`;
        document.getElementById('title').value = title;
        document.getElementById('description').value = description;

        const form = document.querySelector('form');
        form.action = `?edit_id=${id}`; // Set form action for update.
        form.querySelector('button[type="submit"]').textContent = 'Update Event'; // Change button text.
    }

    /**
     * Prompts the user for confirmation before deleting an event.
     * If confirmed, redirects to the same page with a delete_id parameter.
     * @param {number} id The ID of the event to delete.
     */
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this event?")) {
            window.location.href = `?delete_id=${id}`;
        }
    }
</script>

  </body>
</html>
