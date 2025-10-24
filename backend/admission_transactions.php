<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'db_connection.php';



// Handle transaction deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    try {
        $stmt = $conn->prepare("DELETE FROM admission_transactions WHERE transaction_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $delete_id);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Transaction deleted successfully!";
                header("Location: admission_transactions.php"); // Redirect to refresh the page
                exit();
            } else {
                $_SESSION['error_message'] = "Error deleting transaction: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error deleting transaction: " . $e->getMessage();
    }
}

// Fetch all admission transactions
try {
    $result = $conn->query("SELECT * FROM admission_transactions ORDER BY transaction_date DESC");
    $transactions = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        $result->free();
    } else {
        $_SESSION['error_message'] = "Error fetching transactions: " . $conn->error;
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = "Error fetching transactions: " . $e->getMessage();
    $transactions = [];
}

// Fetch the logged-in Staff name
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($student_name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('adminnav.php'); ?>

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <?php include('logo_header.php'); ?>
                </div>
                <?php include('navbar.php'); ?>
            </div>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h4 class="page-title">Admission Fee Transactions</h4>
              <ul class="breadcrumbs">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Bursary</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Admission Fee Transactions</a>
                </li>
              </ul>
            </div>
            <div class="page-category">
              
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
        <?php endif; ?>

        <!-- Transactions List -->
        <div class="card">
            <div class="card-header">
                All Transactions
            </div>
            <div class="card-body">
                <?php if (!empty($transactions)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="basic-datatables">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Application ID</th>
                                    <th>Student ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $transaction): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($transaction['transaction_id']); ?></td>
                                        <td><?php echo htmlspecialchars($transaction['application_id']); ?></td>
                                        <td><?php echo htmlspecialchars($transaction['student_id'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($transaction['amount'], 2)); ?></td>
                                        <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                                        <td><?php echo htmlspecialchars($transaction['payment_method']); ?></td>
                                        <td><?php echo htmlspecialchars($transaction['status']); ?></td>
                                        <td>
                                            <a href="admission_transactions.php?delete_id=<?php echo $transaction['transaction_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No admission transactions found.</p>
                <?php endif; ?>
            </div>
        </div>
            </div>
          </div>
        </div>

        <?php include('footer.php'); ?>
      </div>
    </div>
    <?php include('scripts.php'); ?>
  </body>
</html>
