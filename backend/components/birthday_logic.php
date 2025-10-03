<?php
// session_start();
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
// Get current month as a 2-digit string
$currentMonth = date('m');

// Fetch students whose birthdays fall in the current month
$sql = "SELECT * FROM students WHERE MONTH(STR_TO_DATE(dob, '%d/%m/%y')) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentMonth);
$stmt->execute();
$result = $stmt->get_result();
?>

