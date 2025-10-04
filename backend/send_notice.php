<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $message = $_POST['message'];

    if ($id == 0) {
        // Insert new notice
        $sql = "INSERT INTO notices (title, message) VALUES ('$title', '$message')";
    } else {
        // Update existing notice
        $sql = "UPDATE notices SET title='$title', message='$message' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        $success_message = "Notice saved successfully";

        // Send email to parents
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'mail.dinolabstech.com'; // Replace with your SMTP host
            $mail->SMTPAuth   = true;
            $mail->Username   = 'enquiries@dinolabstech.com'; // Replace with your email
            $mail->Password   = 'Dinolabs@11';     // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('enquiries@dinolabstech.com', 'School Notice');
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body    = $message;

            // Fetch all parent emails
            $parent_emails = [];
            $email_sql = "SELECT email FROM parent WHERE email IS NOT NULL AND email != ''";
            $email_result = $conn->query($email_sql);

            if ($email_result->num_rows > 0) {
                while ($row = $email_result->fetch_assoc()) {
                    $parent_emails[] = $row['email'];
                }
            }

            foreach ($parent_emails as $parent_email) {
                $mail->addAddress($parent_email);
            }

            if (!empty($parent_emails)) {
                $mail->send();
                $success_message .= " and email sent to parents.";
            } else {
                $success_message .= " but no parent emails found to send notice to.";
            }
        } catch (Exception $e) {
            $error_message = "Notice saved, but email could not be sent to parents. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error_message = "Error saving notice: " . $conn->error;
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM notices WHERE id=$delete_id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Notice deleted successfully";
    } else {
        $error_message = "Error deleting notice: " . $conn->error;
    }
}

// Handle edit action
$title = "";
$message = "";
$id = 0;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT title, message FROM notices WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $message = $row['message'];
    } else {
        $error_message = "Notice not found.";
    }
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
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Notice</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Home</li>
                                <li class="breadcrumb-item active">Notice</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-body">
                                    <div class="card-head-row card-tools-still-right">
                                        <div class="card-title">Send Notice</div>
                                    </div>

                                    <?php if (!empty($success_message)): ?>
                                        <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
                                    <?php endif; ?>

                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Title" value="<?= htmlspecialchars($title) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control" id="message" name="message" rows="5"
                                                placeholder="Message"
                                                required><?= htmlspecialchars($message) ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send Notice</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-body">
                                    <div class="card-head-row card-tools-still-right">
                                        <div class="card-title">Existing Notices</div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Message</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT id, title, message, created_at FROM notices ORDER BY id DESC";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                                                        echo "<td>
                                <a href='?edit=" . $row["id"] . "' class='btn btn-sm btn-primary'>Edit</a>
                                <a href='?delete=" . $row["id"] . "' class='btn btn-sm btn-danger'>Delete</a>
                              </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>No notices found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('footer.php'); ?>
        </div>

        <?php include('cust-color.php'); ?>
    </div>

    <?php include('scripts.php'); ?>
</body>

</html>