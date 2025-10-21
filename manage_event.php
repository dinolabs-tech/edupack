<?php
include 'backend/db_connection.php';

$event = [
  'id' => '',
  'event_date' => '',
  'category' => '',
  'title' => '',
  'details' => '',
  'start_time' => '',
  'end_time' => '',
  'location' => ''
];
$message = '';
$error = '';

// --- Category Management Logic ---
$category_message = '';
$category_error = '';
$event_categories = [];
$editing_category = ['id' => '', 'name' => ''];

// Fetch all event_categories
$result_categories = $conn->query("SELECT id, name FROM event_categories ORDER BY name ASC");
if ($result_categories) {
  while ($row = $result_categories->fetch_assoc()) {
    $event_categories[] = $row;
  }
} else {
  $category_error = "Error fetching event categories: " . $conn->error;
}

// Handle category form submission
if (isset($_POST['category_action'])) {
  $category_name = $_POST['category_name'];
  $category_id = $_POST['category_id'];

  if ($_POST['category_action'] == 'add') {
    $stmt = $conn->prepare("INSERT INTO event_categories (name) VALUES (?)");
    $stmt->bind_param("s", $category_name);
    if ($stmt->execute()) {
      $category_message = "Category added successfully!";
    } else {
      $category_error = "Error adding category: " . $stmt->error;
    }
    $stmt->close();
  } elseif ($_POST['category_action'] == 'edit') {
    $stmt = $conn->prepare("UPDATE event_categories SET name=? WHERE id=?");
    $stmt->bind_param("si", $category_name, $category_id);
    if ($stmt->execute()) {
      $category_message = "Category updated successfully!";
    } else {
      $category_error = "Error updating category: " . $stmt->error;
    }
    $stmt->close();
  }
  // Redirect to refresh the page and see updates
  header("Location: manage_event.php?category_message=" . urlencode($category_message) . "&category_error=" . urlencode($category_error));
  exit();
}

// Handle category delete request
if (isset($_GET['category_action']) && $_GET['category_action'] == 'delete' && isset($_GET['category_id'])) {
  $category_id = $_GET['category_id'];
  $stmt = $conn->prepare("DELETE FROM event_categories WHERE id = ?");
  $stmt->bind_param("i", $category_id);
  if ($stmt->execute()) {
    $category_message = "Category deleted successfully!";
  } else {
    $category_error = "Error deleting category: " . $stmt->error;
  }
  $stmt->close();
  header("Location: manage_event.php?category_message=" . urlencode($category_message) . "&category_error=" . urlencode($category_error));
  exit();
}

// Fetch category for editing if ID is provided in GET request
if (isset($_GET['edit_category_id'])) {
  $id = $_GET['edit_category_id'];
  $stmt = $conn->prepare("SELECT id, name FROM event_categories WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $editing_category = $result->fetch_assoc();
  } else {
    $category_error = "Category not found.";
  }
  $stmt->close();
}

// --- Event Management Logic ---
// Handle form submission for adding/editing events
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['category_action'])) {
  $event_date = $_POST['event_date'];
  $category = $_POST['category'];
  $title = $_POST['title'];
  $details = $_POST['details'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $location = $_POST['location'];
  $id = $_POST['id'];

  if ($id) {
    // Update existing event
    $stmt = $conn->prepare("UPDATE events SET event_date=?, category=?, title=?, details=?, start_time=?, end_time=?, location=? WHERE id=?");
    $stmt->bind_param("sssssssi", $event_date, $category, $title, $details, $start_time, $end_time, $location, $id);
    if ($stmt->execute()) {
      $message = "Event updated successfully!";
      header("Location: Location: events.php");
      exit();
    } else {
      $error = "Error updating event: " . $stmt->error;
      error_log("Event Update Error: " . $stmt->error); // Log error
    }
  } else {
    // Add new event
    $stmt = $conn->prepare("INSERT INTO events (event_date, category, title, details, start_time, end_time, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $event_date, $category, $title, $details, $start_time, $end_time, $location);
    if ($stmt->execute()) {
      $message = "Event added successfully!";
      header("Location: events.php");
      exit();
    } else {
      $error = "Error adding event: " . $stmt->error;
      error_log("Event Add Error: " . $stmt->error); // Log error
    }
  }
  $stmt->close();
}

// Fetch event for editing if ID is provided in GET request
if (isset($_GET['id']) && !isset($_GET['edit_category_id'])) {
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT id, event_date, category, title, details, start_time, end_time, location FROM events WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
  } else {
    $error = "Event not found.";
  }
  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="event-details-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Event Details</h1>

        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Event Details</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Event Section -->
    <section id="event" class="event section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8">

            <div class="card mb-3 shadow" data-aos="fade-left" data-aos-delay="400">
              <div class="card-body">
                <div class='card-header bg-white mb-3'>
                  <h4><?php echo $event['id'] ? 'Edit Event' : 'Add New Event'; ?></h4>
                </div>
                <?php if ($message): ?>
                  <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="manage_event.php" class="row g-3">
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($event['id']); ?>">
                  <div class="form-group col-md-4">
                    <input type="date" class="form-control" placeholder="date" id="event_date" name="event_date" value="<?php echo htmlspecialchars($event['event_date']); ?>" required>
                  </div>
                  <div class="form-group col-md-4">
                    <select class="form-control form-select" id="category" name="category" required>
                      <option value="">Select Category</option>
                      <?php foreach ($event_categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['name']); ?>" <?php echo ($event['category'] == $cat['name']) ? 'selected' : ''; ?>>
                          <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" placeholder="Event Title" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                  </div>
                  <div class="form-group col-md-12">
                    <textarea class="form-control" placeholder="Details" id="details" name="details" rows="3" required><?php echo htmlspecialchars($event['details']); ?></textarea>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="time" class="form-control" placeholder="Start time" id="start_time" name="start_time" value="<?php echo htmlspecialchars($event['start_time']); ?>" required>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="time" class="form-control" placeholder="End time" id="end_time" name="end_time" value="<?php echo htmlspecialchars($event['end_time']); ?>" required>
                  </div>
                  <div class="form-group col-md-4">
                    <input type="text" class="form-control" placeholder="Event Location" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
                  </div>
                  <div class="form-group col-md-12 text-center">
                    <div class="card-footer bg-white">
                      <button type="submit" class="btn btn-success rounded-5 shadow">
                        <i class="bi bi-save"></i>
                      </button>
                      <a href="manage_event.php" class="btn btn-secondary rounded-5 shadow">
                        <i class="bi bi-x-lg"></i>
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="card mt-5" data-aos="fade-left" data-aos-delay="200">
              <div class="card-body">
                <h3>Manage Categories</h3>
                <?php if (isset($_GET['category_message'])): ?>
                  <div class="alert alert-success"><?php echo htmlspecialchars($_GET['category_message']); ?></div>
                <?php endif; ?>
               

                <form method="POST" action="manage_event.php">
                  <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($editing_category['id']); ?>">
                  <div class="d-flex">
                    <div class="input-group mb-3">

                      <input type="text" placeholder="Category Name" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($editing_category['name']); ?>" required>
                      <button type="submit" name="category_action" value="<?php echo $editing_category['id'] ? 'edit' : 'add'; ?>" class="btn btn-primary ">
                        <?php echo $editing_category['id'] ? 'Update Category' : 'Add Category'; ?>
                      </button>
                    </div>

                  </div>
                  <?php if ($editing_category['id']): ?>
                    <a href="manage_event.php" class="btn btn-secondary">Cancel Edit</a>
                  <?php endif; ?>
                </form>
                <hr>
                <h4 class="mt-4">Existing Categories</h4>
                <?php if (empty($event_categories)): ?>
                  <p>No categories added yet.</p>
                <?php else: ?>
                  <div class="table-responsive">
                    <table class="table table-bordered mt-3 table-striped">
                      <thead>
                        <tr>
                          <th class="d-none">ID</th>
                          <th>Category Name</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($event_categories as $cat): ?>
                          <tr>
                            <td class="d-none"><?php echo htmlspecialchars($cat['id']); ?></td>
                            <td><?php echo htmlspecialchars($cat['name']); ?></td>
                            <td>
                              <a href="manage_event.php?edit_category_id=<?php echo $cat['id']; ?>" class="btn  btn-warning rounded-5">
                                <i class="bi bi-pencil"></i>
                              </a>
                              <a href="manage_event.php?category_action=delete&category_id=<?php echo $cat['id']; ?>" class="btn btn-danger rounded-5" onclick="return confirm('Are you sure you want to delete this category?');">
                                    <i class="bi bi-trash"></i>
                              </a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif; ?>
              </div>
            </div>


          </div>

          <div class="col-lg-4">
            <div class="event-sidebar">


              <div class="sidebar-widget organizer-info" data-aos="fade-left" data-aos-delay="300">
                <h3>Event Organizer</h3>
                <div class="organizer-details">
                  <div class="organizer-image">
                    <img src="assets/img/person/person-m-5.webp" class="img-fluid rounded" alt="Organizer">
                  </div>
                  <div class="organizer-content">
                    <h4>Prof. Michael Anderson</h4>
                    <p class="organizer-position">Head of Science Department</p>
                    <p>For queries related to the event, please contact:</p>
                    <div class="organizer-contact">
                      <p><i class="bi bi-envelope"></i> michael@example.com</p>
                      <p><i class="bi bi-telephone"></i> +1 (555) 123-4567</p>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>

      </div>

    </section><!-- /Event Section -->

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>