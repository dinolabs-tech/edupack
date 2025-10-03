<?php

include('components/students_logic.php');
include('components/birthday_logic.php');


include('components/fees_management.php');

// For demonstration purposes, assume a student ID is passed or retrieved from session
$student_id = $_SESSION['user_id']; // Example student ID

if (empty($student_id)) {
  die("Student ID not provided.");
}


// ======================================================
// Get student details
$student_stmt = $conn->prepare("SELECT name, class, arm, hostel, email FROM students WHERE id = ?");
$student_stmt->bind_param("s", $student_id);
$student_stmt->execute();
$student_result = $student_stmt->get_result();
$student_data = $student_result->fetch_assoc();

if (!$student_data) {
    die("Student not found.");
}

$student_name = $student_data['name'];
$student_class = $student_data['class'];
$student_arm = $student_data['arm'];
$student_hostel = $student_data['hostel'];
// 
$student_email = $student_data['email']; // Assuming email is also in students table, needed for Flutterwave
// $student_email = "olaoluwadaniel1091@gmail.com";


// Check tuckshop registration and balance
$is_tuckshop_registered = false;
$tuckshop_balance = 0.0;
$tuckshop_stmt = $conn->prepare("SELECT vbalance FROM tuck WHERE regno = ? AND studentname = ?");
$tuckshop_stmt->bind_param("ss", $student_id, $student_name);
$tuckshop_stmt->execute();
$tuckshop_result = $tuckshop_stmt->get_result();
if ($tuckshop_data = $tuckshop_result->fetch_assoc()) {
    $is_tuckshop_registered = true;
    $tuckshop_balance = (float)$tuckshop_data['vbalance'];
}


// Get current session and term
$current_session_data = $conn->query("SELECT csession FROM currentsession LIMIT 1")->fetch_assoc();
$current_term_data = $conn->query("SELECT cterm FROM currentterm LIMIT 1")->fetch_assoc();
$current_session = $current_session_data ? $current_session_data['csession'] : 'N/A';
$current_term = $current_term_data ? $current_term_data['cterm'] : 'N/A';

// Ensure bursary balance is up-to-date for the current period
updateBursaryBalance($conn, $student_id, $current_session, $current_term);

// Get fee status for the current session and term
$fee_status = getStudentFeeStatus($conn, $student_id, $current_session, $current_term);

$total_fee_current_period = $fee_status ? (float)$fee_status['fee'] : 0.0;
$total_paid_current_period = $fee_status ? (float)$fee_status['paid'] : 0.0;
$outstanding_current_period = $total_fee_current_period - $total_paid_current_period;

// Get previous outstanding balances
$previous_outstanding_balances = getPreviousOutstandingBalances($conn, $student_id, $current_session, $current_term);
$sum_previous_outstanding = array_sum(array_map(fn($row) => (float)$row['outstanding'], $previous_outstanding_balances));

// Total outstanding is current period's outstanding plus previous periods' outstanding
$total_outstanding_cumulative = $outstanding_current_period + $sum_previous_outstanding;
// ======================================================================================

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php

    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
    //set the appropriate url based on the user role
    if ($role === 'Student') {
      include('studentnav.php');
    } elseif ($role === 'Administrator') {
      include('adminnav.php');
    } elseif ($role === 'Alumni') {
      include('alumninav.php');
    }

    ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <?php include('logo_header.php'); ?>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <?php include('navbar.php'); ?>
        <!-- End Navbar -->
      </div>

      <!-- student Dashboard container -->
      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="students.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>

          </div>

       
          <!-- PERSONAL AI ============================ -->
          <div class="row">

            <div class="col-md-4">
              <div class="card card-primary card-round bubble-shadow">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Personal AI</div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <div class="mb-4 mt-2">
                    <p id="message" data-message="<?php echo htmlspecialchars($message); ?>"></p>
                  </div>

                </div>
              </div>

            </div>

            <div class="col-md-8">
              <div class="card card-success card-round">
                <div class="card-header">
                  <div class="card-head-row">
                    <div class="card-title">Profile Card</div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <div class="mb-4 mt-2">
                    <div class="table-responsive">
                      <table class="basic table">
                        <tr>
                          <th>ID</th>
                          <td><?php echo htmlspecialchars($student_details['id']); ?></td>
                        </tr>
                        <tr>
                          <th>Name</th>
                          <td><?php echo htmlspecialchars($student_details['name']); ?></td>
                        </tr>
                        <tr>
                          <th>Gender</th>
                          <td><?php echo htmlspecialchars($student_details['gender']); ?></td>
                        </tr>
                        <tr>
                          <th>Date of Birth</th>
                          <td><?php echo htmlspecialchars($student_details['dob']); ?></td>
                        </tr>
                        <tr>
                          <th>Address</th>
                          <td><?php echo htmlspecialchars($student_details['address']); ?></td>
                        </tr>
                        <tr>
                          <th>State</th>
                          <td><?php echo htmlspecialchars($student_details['state']); ?></td>
                        </tr>
                        <tr>
                          <th>Class</th>
                          <td><?php echo htmlspecialchars($student_details['class']); ?></td>
                        </tr>
                        <tr>
                          <th>Arm</th>
                          <td><?php echo htmlspecialchars($student_details['arm']); ?></td>
                        </tr>
                      </table>

                    </div>


                  </div>

                </div>
              </div>

            </div>

          </div>

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Class Schedule |
                  <?php echo htmlspecialchars($student_class); ?> <?php echo htmlspecialchars($student_arm); ?>
                </h4>
              </div>

              <div class="card-body curves-shadow">
                <div class="table-responsive table-hover table-sales">
                  <?php
                  $hasClasses = false; // Track if there are valid classes

                  if (!empty($timetable) && count($timetable) > 0) {
                  ?>
                    <div class="scroll-container">
                      <?php foreach ($timetable as $entry) {
                        if (!empty($entry['subject']) && !empty($entry['time'])) {
                          $hasClasses = true; // Set flag to true
                      ?>
                          <div class="timecard">
                            <div class="subject">
                              <?php echo htmlspecialchars($entry['subject'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="time">
                              <?php echo htmlspecialchars($entry['time'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                          </div>
                      <?php
                        }
                      }
                      ?>
                    </div>
                  <?php
                  }

                  // Show "No classes scheduled for today" only if no valid classes were found
                  if (!$hasClasses) {
                    echo "<div class='alert alert-danger'><p>No classes scheduled for today.</p></div>";
                  }
                  ?>

                </div>
              </div>
            </div>
          </div>




          <div class="row">
            <div class="col-sm-6 col-md-6">
              <div class="card card-stats card-primary card-round">
                <div class="card-body curves-shadow">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Tuck Shop Balance</p>

                        <h4 class="card-title">₦
                          <?php echo (isset($student_details['vbalance']) && is_numeric($student_details['vbalance']) ? number_format((float) $student_details['vbalance'], 2, '.', ',') : '0.00'); ?>
                        </h4>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-6">
              <div class="card card-stats card-success card-round">
                <div class="card-body bubble-shadow">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Outstanding Balance (Current Term)</p>
                        <h4 class="card-title">&#8358; <?= number_format($outstanding_current_period, 2); ?></h4>


                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




          </div>


          <div class="row">
            <div class="col-sm-6 col-md-4">
              <div class="card card-stats card-secondary card-round">
                <div class="card-body bubble-shadow">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-secondary bubble-shadow-small">
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Total Paid (Current Term)</p>
                        <h4 class="card-title">&#8358; <?= number_format($total_paid_current_period, 2); ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4">
              <div class="card card-stats card-warning card-round">
                <div class="card-body bubble-shadow">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-warning bubble-shadow-small">
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Total Fee | Current Term</p>
                        <h4 class="card-title">&#8358; <?= number_format($total_fee_current_period, 2); ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4">
              <div class="card card-stats card-danger card-round">
                <div class="card-body bubble-shadow">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-danger bubble-shadow-small">
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Cumulative Outstanding Balance</p>
                        <h4 class="card-title">&#8358; <?= number_format($total_outstanding_cumulative, 2); ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="text-center mt-4">
                <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#fundTuckshopModal">Fund Tuckshop Account</button>
              </div>
            </div>
            <div class="col-md-6">
              <div class="text-center mt-4">
                <a href="payment.php?student_id=<?php echo htmlspecialchars($student_id); ?>" class="btn btn-lg btn-success">Pay School Fees</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Fund Tuckshop Modal -->
    <div class="modal fade" id="fundTuckshopModal" tabindex="-1" aria-labelledby="fundTuckshopModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fundTuckshopModalLabel">Fund Tuckshop Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="fundTuckshopForm">
                        <input type="hidden" id="tuckshop_student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                        <input type="hidden" id="tuckshop_student_name" value="<?php echo htmlspecialchars($student_name); ?>">
                        <input type="hidden" id="tuckshop_student_email" value="<?php echo htmlspecialchars($student_email); ?>">
                        <input type="hidden" id="tuckshop_current_session" value="<?php echo htmlspecialchars($current_session); ?>">
                        <input type="hidden" id="tuckshop_current_term" value="<?php echo htmlspecialchars($current_term); ?>">
                        <div class="mb-3">
                            <label for="tuckshop_amount" class="form-label">Amount to Fund</label>
                            <input type="number" class="form-control" id="tuckshop_amount" name="tuckshop_amount" step="0.01" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Proceed to Fund</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
          <div class="col-md-8">
            <div class="card card-round">
              <div class="card-header">
                <div class="card-head-row">
                  <div class="card-title">Academic Performance</div>
                  <div class="card-tools">

                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-container" style="min-height: 375px">
                  <canvas id="adminChart"></canvas>
                </div>
                <div id="myChartLegend"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-primary card-round">
              <div class="card-header">
                <div class="card-head-row">
                  <div class="card-title">Academic CGPA</div>
                </div>
              </div>
              <div class="card-body pb-0">
                <div class="mb-4 mt-2">
                  <table class="display table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Term</th>
                        <th>GPA</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($cgpa_data as $data): ?>
                        <tr>
                          <td><?php echo htmlspecialchars($data['term']); ?></td>
                          <td><?php echo number_format($data['gpa'], 2); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>

          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-round">
              <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                  <h4 class="card-title">Academic Calendar</h4>
                </div>
                <p class="card-category">
                <div class="calendar-container">
                  <div class="header1">
                    <button id="prev-month" class="btn btn-warning"><span class="btn-label">
                        <i class="fa fa-fast-backward"></i> </button>
                    <h2 id="month-year"></h2>
                    <button id="next-month" class="btn btn-success"><span class="btn-label">
                        <i class="fa fa-fast-forward"></i> </button>
                  </div>
                  <div class="calendar calendar-body"></div>
                </div>

                <div id="event-modal">
                  <!-- remove single title/description elements -->
                  <div id="event-list"></div>
                  <button id="close-modal">Close</button>
                </div>
                </p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsive table-hover table-sales">
                      <script>
                        const calendarBody = document.querySelector('.calendar-body');
                        const monthYear = document.getElementById('month-year');
                        const prevMonthBtn = document.getElementById('prev-month');
                        const nextMonthBtn = document.getElementById('next-month');
                        const modal = document.getElementById('event-modal');
                        const modalTitle = document.getElementById('event-title');
                        const modalDescription = document.getElementById('event-description');
                        const closeModal = document.getElementById('close-modal');

                        let currentDate = new Date();

                        // Fetch events from PHP (embedded in the page as JSON)
                        const events = <?php echo json_encode($events); ?>;

                        function renderCalendar(date) {
                          const year = date.getFullYear();
                          const month = date.getMonth();
                          const firstDay = new Date(year, month, 1).getDay();
                          const lastDate = new Date(year, month + 1, 0).getDate();

                          // Set header
                          const monthNames = [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                          ];
                          monthYear.textContent = `${monthNames[month]} ${year}`;

                          // Clear previous calendar days
                          const days = calendarBody.querySelectorAll('.day');
                          days.forEach(day => calendarBody.removeChild(day));

                          // Fill blank days before the first day of the month
                          for (let i = 0; i < firstDay; i++) {
                            const blankDay = document.createElement('div');
                            blankDay.classList.add('day', 'inactive');
                            calendarBody.appendChild(blankDay);
                          }

                          // Fill days of the month
                          for (let i = 1; i <= lastDate; i++) {
                            const day = document.createElement('div');
                            day.classList.add('day');
                            day.textContent = i;

                            // Format the date as MM/dd/yyyy
                            const eventKey = `${String(month + 1).padStart(2, '0')}/${String(i).padStart(2, '0')}/${year}`;

                            // Check if there's an event on this day
                            if (events[eventKey]) {
                              day.classList.add('event');
                              day.addEventListener('click', () => showEvent(eventKey));
                            }

                            calendarBody.appendChild(day);
                          }
                        }

                        // function showEvent(date) {


                        closeModal.addEventListener('click', () => {
                          modal.style.display = 'none';
                        });

                        prevMonthBtn.addEventListener('click', () => {
                          currentDate.setMonth(currentDate.getMonth() - 1);
                          renderCalendar(currentDate);
                        });

                        nextMonthBtn.addEventListener('click', () => {
                          currentDate.setMonth(currentDate.getMonth() + 1);
                          renderCalendar(currentDate);
                        });

                        function showEvent(date) {

                          const eventListContainer = document.getElementById('event-list');
                          // clear previous content
                          eventListContainer.innerHTML = '';

                          // retrieve array of events for that date
                          const dayEvents = events[date] || [];

                          // for each event, create a little card/title+desc
                          dayEvents.forEach(ev => {
                            const wrapper = document.createElement('div');
                            wrapper.style.marginBottom = '1rem';

                            const h3 = document.createElement('h3');
                            h3.textContent = ev.title;
                            h3.style.margin = '0 0 0.25rem 0';

                            const p = document.createElement('p');
                            p.textContent = ev.description;
                            p.style.margin = 0;

                            wrapper.appendChild(h3);
                            wrapper.appendChild(p);
                            eventListContainer.appendChild(wrapper);
                          });

                          // show modal
                          modal.style.display = 'flex';
                        }

                        // Initial render
                        renderCalendar(currentDate);
                      </script>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card card-round">
              <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                  <div class="card-title">Class Peers</div>
                  <div class="card-tools">
                    <div class="dropdown">
                      <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <strong><?php echo htmlspecialchars($student_details['count(id)']); ?></strong>

                      </button>

                    </div>
                  </div>


                </div>
                <div class="card-list py-4">
                  <div class="card-body p-0">

                    <div class="table-responsive">
                      <!-- Projects table -->
                      <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                          <tr>

                            <th>Name</th>
                            <th>Gender</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($classpeer)): ?>
                            <?php foreach ($classpeer as $peer): ?>
                              <tr>

                                <td><?php echo htmlspecialchars($peer['name']); ?></td>
                                <td><?php echo htmlspecialchars($peer['gender']); ?></td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="2">No records found</td>
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

          <div class="col-md-6">
            <div class="card card-round">
              <div class="card-body">
                <div class="card-head-row card-tools-still-right">
                  <div class="card-title">Tuck Shop Transaction History</div>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <!-- Projects table -->
                  <table id="multi-filter-select" class="display table table-striped table-hover">
                    <thead>
                      <tr>

                        <th>Product</th>
                        <th>Units</th>
                        <th>Amount</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $transaction): ?>
                          <tr>

                            <td><?php echo htmlspecialchars($transaction['productname']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['units']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['transactiondate']); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="5">No records found</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>



        <?php
        // Birthday celebrants logic
        include 'db_connection.php';

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $currentMonth = date('m');
        $sql = "SELECT * FROM students WHERE MONTH(STR_TO_DATE(dob, '%d/%m/%y')) = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $currentMonth);
        $stmt->execute();
        $result = $stmt->get_result();

        $conn->close();
        ?>

        <!-- 🎂 Birthday Celebrants Section -->
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card card-round">
              <div class="card-header">
                <div class="card-head-row">
                  <h4 class="card-title text-danger">🎉🎂🎊 Happy Birthday to Our Stars in <?php echo date('F'); ?>!
                    🎊🎂🎉</h4>
                </div>
              </div>
              <div class="card-body">
                <div class="row justify-content-center g-4">
                  <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                      <?php
                      $dobObj = DateTime::createFromFormat('d/m/y', $row['dob']) ?: DateTime::createFromFormat('d/m/Y', $row['dob']);
                      $formattedDob = $dobObj ? $dobObj->format('d F') : $row['dob'];
                      ?>
                      <div class="col-md-4 col-sm-6">
                        <div class="card shadow border-3 border-warning text-center">
                          <div class="card-body">
                            <div class="fs-1 mb-2">🎉</div>
                            <h6 class="card-title text-primary"><?php echo htmlspecialchars($row['name']); ?></h6>
                            <p class="card-text text-muted">🎂 Born on: <?php echo $formattedDob; ?></p>
                            <p><?php echo htmlspecialchars($row['class']); ?> <?php echo htmlspecialchars($row['arm']); ?>
                            </p>
                          </div>
                        </div>
                      </div>
                    <?php endwhile; ?>
                  <?php else: ?>
                    <div class="col-12">
                      <div class="alert alert-secondary text-center fs-5 mt-4">
                        🥹 No birthday celebrants this month.<br>Stay tuned for next month's celebration!
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- birthday celebrants section ends here -->


      </div>
    </div>

    <?php include('footer.php'); ?>
  </div>

  <!-- Custom template | don't include it in your project! -->
  <?php include('cust-color.php'); ?>
  <!-- End Custom template -->
  </div>
  <?php include('scripts.php'); ?>



  <div class="chatbot-icon" onclick="toggleChatbot()">AI</div>


  <!-- Chatbot popup -->
  <div class="chatbot-popup" id="chatbotPopup">
    <div class="chatbot-header" id="chatbotHeader">
      Analyze Academic Performance
      <span class="close-button" onclick="closeChatbot()">X</span>
    </div>
    <div class="chatbot-body" id="chatbotBody">
      <!-- Chatbot messages will be displayed here -->
    </div>
    <div class="chatbot-input">
      <input type="hidden" id="studentIdInput" placeholder="Enter Student ID">
      <button onclick="getChatbotResponse()">Analyze My Academic Performance</button>
    </div>
  </div>

  <script>
    var phrases = [
      "Analyze Academic Performance",
      "Unlock Your Potential",
      "Get Personalized Insights",
      "Improve Your Grades",
      "Ace Your Exams"
    ];

    function getRandomPhrase() {
      return phrases[Math.floor(Math.random() * phrases.length)];
    }

    function setChatbotHeader() {
      document.getElementById("chatbotHeader").innerHTML = getRandomPhrase() + '<span class="close-button" onclick="closeChatbot()">X</span>';
    }

    function toggleChatbot() {
      var popup = document.getElementById("chatbotPopup");
      if (popup.style.display === "none") {
        popup.style.display = "flex";
      } else {
        popup.style.display = "none";
      }
    }

    function closeChatbot() {
      var popup = document.getElementById("chatbotPopup");
      popup.style.display = "none";
    }

    function getChatbotResponse() {
      var studentId = document.getElementById("studentIdInput").value;
      var chatbotBody = document.getElementById("chatbotBody");

      var xhr = new XMLHttpRequest();
      xhr.open("GET", "chatbot.php?student_id=" + encodeURIComponent(studentId), true);

      xhr.onload = function() {
        console.log("Status:", xhr.status);
        console.log("Response:", xhr.responseText);
        if (xhr.status >= 200 && xhr.status < 300) {
          chatbotBody.innerHTML = xhr.responseText;
        } else {
          chatbotBody.innerHTML = "Error: " + xhr.statusText;
        }
      };

      xhr.onerror = function() {
        console.error("Request failed");
        chatbotBody.innerHTML = "Error: Network error.";
      };

      xhr.send();
    }

    window.onload = setChatbotHeader;
  </script>

 <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        document.getElementById('fundTuckshopForm')?.addEventListener('submit', function(event) {
            event.preventDefault();

            var studentId = document.getElementById('tuckshop_student_id').value;
            var studentName = document.getElementById('tuckshop_student_name').value;
            var studentEmail = document.getElementById('tuckshop_student_email').value;
            var amount = parseFloat(document.getElementById('tuckshop_amount').value);
            var currentSession = document.getElementById('tuckshop_current_session').value;
            var currentTerm = document.getElementById('tuckshop_current_term').value;

            if (amount <= 0 || isNaN(amount)) {
                alert('Please enter a valid amount.');
                return;
            }

            var tx_ref = "TUCK-TX-" + Math.floor(Math.random() * 1000000000) + "-" + Date.now();

            var paymentDetails = {
                student_id: studentId,
                amount: amount,
                tx_ref: tx_ref,
                session: currentSession,
                term: currentTerm,
                type: 'tuckshop' // Indicate this is a tuckshop payment
            };
            var encodedPaymentDetails = btoa(JSON.stringify(paymentDetails));

            FlutterwaveCheckout({
                public_key: "FLWPUBK_TEST-352add210234da9f75c4cf8a2b79cd38-X", // Reusing the same public key
                tx_ref: tx_ref,
                amount: amount,
                currency: "NGN",
                country: "NG",
                payment_options: "card, mobilemoney,banktransfer, ussd",
                customer: {
                    email: studentEmail,
                    name: studentName
                },
                callback: function(data) {
                    if (data.status === 'successful') {
                        window.location.href = 'tuckshop_payment_callback.php?status=successful&tx_ref=' + data.tx_ref +
                            '&transaction_id=' + data.transaction_id + '&payment_details=' + encodedPaymentDetails +
                            '&student_id=' + studentId;
                    } else if (data.status === 'cancelled') {
                        window.location.href = 'students.php';
                    } else {
                        window.location.href = 'students.php';
                    }
                },
                customizations: {
                    title: "Tuckshop Account Funding",
                    description: "Funding for " + studentName + "'s Tuckshop Account",
                    logo: "https://your-school-logo.com/logo.png"
                }
            });
        });

        // Handle messages from tuckshop_payment_callback.php
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');

            if (status && message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${status === 'successful' ? 'success' : 'danger'} mt-3`;
                alertDiv.textContent = message;
                document.querySelector('.container').prepend(alertDiv);

                // Remove status and message from URL
                urlParams.delete('status');
                urlParams.delete('message');
                const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>

</body>

</html>