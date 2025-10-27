<?php
session_start();
include 'backend/db_connection.php';

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    header("Location: index.php?message=Event deleted successfully");
    exit();
  } else {
    $delete_error = "Error deleting event: " . $stmt->error;
  }
  $stmt->close();
}

// Fetch events
$sql = "SELECT id, event_date, category, title, details, start_time, end_time, location FROM events";
$where_clauses = [];
$params = [];
$param_types = "";

if (isset($_GET['month']) && $_GET['month'] != '') {
  $month_num = $_GET['month']; // Month number is already passed directly
  $where_clauses[] = "DATE_FORMAT(event_date, '%m') = ?"; // For MySQL
  $params[] = $month_num;
  $param_types .= "s";
}

if (isset($_GET['category']) && $_GET['category'] != '') {
  $where_clauses[] = "category = ?";
  $params[] = $_GET['category'];
  $param_types .= "s";
}

if (!empty($where_clauses)) {
  $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " ORDER BY event_date ASC";

// Pagination variables
$events_per_page = 6; // Number of events to display per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $events_per_page;

// Count total events with filters
$count_sql = "SELECT COUNT(id) AS total_events FROM events";
if (!empty($where_clauses)) {
  $count_sql .= " WHERE " . implode(" AND ", $where_clauses);
}
$count_stmt = $conn->prepare($count_sql);
if (!empty($params)) {
  $count_stmt->bind_param($param_types, ...$params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_events = $count_result->fetch_assoc()['total_events'];
$count_stmt->close();

$total_pages = ceil($total_events / $events_per_page);

// Modify event fetching query for pagination
$sql .= " LIMIT ? OFFSET ?";
$param_types .= "ii";
$params[] = $events_per_page;
$params[] = $offset;

$stmt = $conn->prepare($sql);
if (!empty($params)) {
  $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$events = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $events[] = $row;
  }
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="events-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Events</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Events</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Events 2 Section -->
    <section id="events-2" class="events-2 section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row mb-3">

          <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Superuser' || $_SESSION['role'] == 'Administrator')) { ?>
            <div class="col-12 d-flex justify-content-center">
              <a href="manage_event.php" class="btn btn-success">Add New Event</a>
            </div>
          <?php } ?>
        </div>

        <form method="GET" action="events.php">
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="month-sort">Sort by Month:</label>
              <select class="form-control form-select" id="month-sort" name="month" onchange="this.form.submit()">
                <option value="">All Months</option>
                <?php
                $months = [
                  '01' => 'January',
                  '02' => 'February',
                  '03' => 'March',
                  '04' => 'April',
                  '05' => 'May',
                  '06' => 'June',
                  '07' => 'July',
                  '08' => 'August',
                  '09' => 'September',
                  '10' => 'October',
                  '11' => 'November',
                  '12' => 'December'
                ];
                foreach ($months as $num => $name) {
                  $selected = (isset($_GET['month']) && $_GET['month'] == $num) ? 'selected' : '';
                  echo "<option value=\"$num\" $selected>$name</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="category-sort">Sort by Category:</label>
              <select class="form-control form-select" id="category-sort" name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php
                // Fetch categories from database
                $result_categories = $conn->query("SELECT name FROM event_categories ORDER BY name ASC");
                if ($result_categories) {
                  while ($cat_row = $result_categories->fetch_assoc()) {
                    $cat_name = $cat_row['name'];
                    $selected = (isset($_GET['category']) && $_GET['category'] == $cat_name) ? 'selected' : '';
                    echo "<option value=\"$cat_name\" $selected>$cat_name</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>
        </form>
        <div class="row g-4">

          <div class="col-lg-8">
            <?php foreach ($events as $event): ?>
              <div class="row">
                <div class="events-list">
                  <div class="event-item" data-aos="fade-up">
                    <div class="event-date">
                      <span class="day"><?php echo date('d', strtotime($event['event_date'])); ?></span>
                      <span class="month"><?php echo date('M', strtotime($event['event_date'])); ?></span>
                    </div>
                    <div class="event-content">
                      <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                      <div class="event-meta">
                        <p><i class="bi bi-clock"></i> <?php echo htmlspecialchars(date('h:i A', strtotime($event['start_time']))); ?> - <?php echo htmlspecialchars(date('h:i A', strtotime($event['end_time']))); ?></p>
                        <p><i class="bi bi-geo-alt"></i><?php echo htmlspecialchars($event['location']); ?></p>
                      </div>
                      <p><?php echo htmlspecialchars($event['details']); ?></p>

                      <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Administrator' || $_SESSION['role'] == 'Superuser')): ?>

                        <button class="btn btn-primary shadow rounded-5" data-bs-toggle="modal" data-bs-target="#eventModal"
                          data-event-title="<?php echo htmlspecialchars($event['title']); ?>"
                          data-event-details="<?php echo htmlspecialchars($event['details']); ?>"
                          data-event-start-time="<?php echo htmlspecialchars(date('h:i A', strtotime($event['start_time']))); ?>"
                          data-event-end-time="<?php echo htmlspecialchars(date('h:i A', strtotime($event['end_time']))); ?>"
                          data-event-location="<?php echo htmlspecialchars($event['location']); ?>"
                          data-event-category="<?php echo htmlspecialchars($event['category']); ?>">Read More</button>
                        <a href="manage_event.php?id=<?php echo $event['id']; ?>" class="btn btn-warning shadow rounded-5">Edit</a>
                        <a href="events.php?action=delete&id=<?php echo $event['id']; ?>" class="btn btn-danger shadow rounded-5" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>

                      <?php endif; ?>
                    </div>
                  </div><!-- End Event Item -->
                </div>
              </div>
            <?php endforeach; ?>
            <!-- Event Details Modal -->
            <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="eventModalBody">
                    <!-- Event details will be dynamically added here by JS reading data attributes -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>


            <!-- Pagination Links -->
            <div class="pagination-wrapper" data-aos="fade-up" data-aos-delay="400">
              <ul class="pagination justify-content-center">
                <?php if ($current_page > 1): ?>
                  <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&month=<?php echo htmlspecialchars($_GET['month'] ?? ''); ?>&category=<?php echo htmlspecialchars($_GET['category'] ?? ''); ?>"><i class="bi bi-chevron-left"></i></a>
                  </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&month=<?php echo htmlspecialchars($_GET['month'] ?? ''); ?>&category=<?php echo htmlspecialchars($_GET['category'] ?? ''); ?>"><?php echo $i; ?></a>
                  </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                  <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&month=<?php echo htmlspecialchars($_GET['month'] ?? ''); ?>&category=<?php echo htmlspecialchars($_GET['category'] ?? ''); ?>"><i class="bi bi-chevron-right"></i></a>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="sidebar">
              <!-- <div class="sidebar-item" data-aos="fade-up" data-aos-delay="100">
                <h3 class="sidebar-title">Upcoming Events</h3>
                <div class="event-calendar">
                  <div class="calendar-header">
                    <h4>June 2023</h4>
                  </div>
                  <div class="calendar-body">
                    <div class="weekdays">
                      <div>Su</div>
                      <div>Mo</div>
                      <div>Tu</div>
                      <div>We</div>
                      <div>Th</div>
                      <div>Fr</div>
                      <div>Sa</div>
                    </div>
                    <div class="days">
                      <div class="day other-month">28</div>
                      <div class="day other-month">29</div>
                      <div class="day other-month">30</div>
                      <div class="day other-month">31</div>
                      <div class="day">1</div>
                      <div class="day">2</div>
                      <div class="day">3</div>
                      <div class="day">4</div>
                      <div class="day">5</div>
                      <div class="day">6</div>
                      <div class="day">7</div>
                      <div class="day">8</div>
                      <div class="day">9</div>
                      <div class="day">10</div>
                      <div class="day">11</div>
                      <div class="day">12</div>
                      <div class="day">13</div>
                      <div class="day">14</div>
                      <div class="day has-event">15</div>
                      <div class="day">16</div>
                      <div class="day">17</div>
                      <div class="day">18</div>
                      <div class="day">19</div>
                      <div class="day">20</div>
                      <div class="day">21</div>
                      <div class="day has-event">22</div>
                      <div class="day">23</div>
                      <div class="day">24</div>
                      <div class="day">25</div>
                      <div class="day">26</div>
                      <div class="day">27</div>
                      <div class="day">28</div>
                      <div class="day">29</div>
                      <div class="day has-event">30</div>
                      <div class="day other-month">1</div>
                    </div>
                  </div>
                </div>
              </div> -->



              <div class="sidebar-item" data-aos="fade-up" data-aos-delay="300">
                <h3 class="sidebar-title">Event Categories</h3>
                <div class="categories">
                  <ul>
                    <?php
                    // Fetch events
                    $sql = "SELECT count(id) as cnt, category FROM events GROUP BY category ORDER BY event_date ASC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count = [];
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $count[] = $row;
                      }
                    }
                    $stmt->close();
                    ?>
                    <?php foreach ($count as $event): ?>
                      <li><a href="#"><?php echo htmlspecialchars($event['category']); ?><span><?= $event['cnt'] ?></span></a></li>
                      <!-- <li><a href="#">Sports <span>(8)</span></a></li>
                    <li><a href="#">Cultural <span>(6)</span></a></li>
                    <li><a href="#">Workshops <span>(4)</span></a></li>
                    <li><a href="#">Conferences <span>(3)</span></a></li> -->
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Events 2 Section -->

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script>
    // JavaScript for modal to display full event details from data attributes
    $('#eventModal').on('show.bs.modal', function(e) {
      const button = $(e.relatedTarget);
      const title = button.data('event-title');
      const details = button.data('event-details');
      const startTime = button.data('event-start-time');
      const endTime = button.data('event-end-time');
      const location = button.data('event-location');
      const category = button.data('event-category'); // Get category

      const modalBody = document.getElementById("eventModalBody");
      modalBody.innerHTML = `
                <h3>${title}</h3>
                <p><strong>Category:</strong> ${category}</p>
                <p>${details}</p>
                <p><strong>Time:</strong> ${startTime} - ${endTime}</p>
                <p><strong>Location:</strong> ${location}</p>
            `;
    });
  </script>

</body>

</html>