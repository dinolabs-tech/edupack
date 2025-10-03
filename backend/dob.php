<?php
session_start();
include 'db_connection.php';

// Example: the logged-in student’s ID
$loggedInId = $_SESSION['user_id'];

// 1. Fetch this student’s record
$sqlUser = "SELECT name, dob FROM students WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $loggedInId);
$stmtUser->execute();
$userResult = $stmtUser->get_result();

$showBirthdayModal = false;
if ($userResult->num_rows === 1) {
  $user = $userResult->fetch_assoc();
  // Parse DOB into a DateTime
  $dobObj = DateTime::createFromFormat('d/m/y', $user['dob'])
    ?: DateTime::createFromFormat('d/m/Y', $user['dob']);
  if ($dobObj) {
    // Check if month+day match today’s month+day
    if ($dobObj->format('m-d') === date('m-d')) {
      $showBirthdayModal = true;
      $userName = htmlspecialchars($user['name']);
      $birthDayFormatted = $dobObj->format('j F');
    }
  }
}

// 2. Now fetch this month’s celebrants as before
$currentMonth = date('m');
$sql = "SELECT * FROM students WHERE MONTH(STR_TO_DATE(dob, '%d/%m/%y')) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentMonth);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>

<head>
  <title>🎉 Birthday Celebrants - <?php echo date('F'); ?> 🎂</title>
  <style>
    /* Page styles */
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff5e6;
      color: #333;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #ff6f61;
      margin-bottom: 30px;
    }

    .celebrants {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      background: #fff;
      border: 2px solid #ffd700;
      border-radius: 15px;
      padding: 20px;
      width: 250px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      position: relative;
    }

    .card:before {
      content: "🎉";
      font-size: 40px;
      position: absolute;
      top: -20px;
      left: -20px;
    }

    .card h2 {
      margin: 0;
      color: #ff6f00;
    }

    .dob {
      font-size: 14px;
      color: #555;
      margin-top: 10px;
    }

    .no-birthdays {
      text-align: center;
      font-size: 20px;
      color: #999;
      margin-top: 50px;
    }

    /* Modal overlay */
    #birthday-modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.6);
      align-items: center;
      justify-content: center;
    }

    #birthday-modal .modal-content {
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      width: 90%;
      max-width: 500px;
      text-align: center;
      position: relative;
      animation: popIn 0.5s ease-out;
    }

    #birthday-modal .modal-content:before {
      content: "🎂";
      font-size: 60px;
      position: absolute;
      top: -30px;
      left: calc(50% - 30px);
    }

    #birthday-modal h2 {
      margin-top: 30px;
      font-size: 2rem;
      color: #ff6f61;
    }

    #birthday-modal p {
      font-size: 1.1rem;
      color: #555;
      margin: 20px 0;
    }

    #birthday-modal button {
      background: #ff6f61;
      color: #fff;
      border: none;
      padding: 12px 30px;
      font-size: 1rem;
      border-radius: 30px;
      cursor: pointer;
      transition: background 0.3s;
    }

    #birthday-modal button:hover {
      background: #e65a50;
    }

    @keyframes popIn {
      from {
        transform: scale(0.5);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }
  </style>
</head>

<body>
  <h1>🎂 Happy Birthday to Our Stars in <?php echo date('F'); ?>! 🎊</h1>

  <div class="celebrants">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()):
        $d = DateTime::createFromFormat('d/m/y', $row['dob'])
          ?: DateTime::createFromFormat('d/m/Y', $row['dob']);
        $fmt = $d ? $d->format('j F') : $row['dob'];
        ?>
        <div class="card">
          <h2><?php echo htmlspecialchars($row['name']); ?></h2>
          <div class="dob">🎂 Born on: <?php echo $fmt; ?></div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="no-birthdays">
        🥹 No birthday celebrants this month.<br>Stay tuned for next month's celebration!
      </div>
    <?php endif; ?>
  </div>

  <?php if ($showBirthdayModal): ?>
    <!-- Birthday Modal -->
    <div id="birthday-modal">
      <div class="modal-content">
        <h2>Happy Birthday, <?php echo $userName; ?>!</h2>
        <p>Today, <?php echo $birthDayFormatted; ?>, we celebrate YOU! 🎉</p>
        <button onclick="closeModal()">Let’s Party! 🥳</button>
      </div>
    </div>
    <script>
      // When the page loads, show the modal
      window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('birthday-modal').style.display = 'flex';
      });
      function closeModal() {
        document.getElementById('birthday-modal').style.display = 'none';
      }
    </script>
  <?php endif; ?>

</body>

</html>

<?php
$conn->close();
?>