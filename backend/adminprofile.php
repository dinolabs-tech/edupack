<?php
include('components/admin_logic.php');

$user_id = $_SESSION['user_id'];
$message = $profile_message = "";

// Fetch existing user details
$stmt = $conn->prepare("SELECT staffname, username, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Update password
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_password'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass !== $confirm_pass) {
        $message = "New passwords do not match!";
    } else {
        $stmt = $conn->prepare("UPDATE login SET password=? WHERE id=?");
        $stmt->bind_param("si", $new_pass, $user_id);
        $message = $stmt->execute() ? "Password Updated Successfully!" : "Error: " . $stmt->error;
        $stmt->close();
    }
}

// Update profile & picture
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {

    // Upload new profile picture if any
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "staffimg/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ["jpg", "jpeg", "png", "gif"];

        if (in_array($ext, $allowed_ext)) {
            $new_path = $target_dir . $user_id . "_profile." . $ext;
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $new_path);

            $stmt = $conn->prepare("UPDATE login SET profile_picture=? WHERE id=?");
            $stmt->bind_param("si", $new_path, $user_id);
            $stmt->execute();
            $stmt->close();
            $profile_message .= "Profile Picture Updated. ";
        } else {
            $profile_message .= "Invalid file type. ";
        }
    }

    // Update text fields
    $fields = ['staffname', 'mobile', 'email', 'address', 'date_of_birth', 'gender'];
    $update_sql = [];
    $params = [];
    $types = "";

    foreach ($fields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] !== $user_data[$field]) {
            $update_sql[] = "$field=?";
            $params[] = $_POST[$field];
            $types .= "s";
        }
    }

    if ($update_sql) {
        $params[] = $user_id;
        $types .= "i";
        $sql = "UPDATE login SET " . implode(', ', $update_sql) . " WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
        $profile_message .= "Profile Updated Successfully!";
    }

    // Refresh updated data
    $stmt = $conn->prepare("SELECT staffname, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<div class="wrapper">

<?php include('adminnav.php'); ?>

<div class="main-panel">
    <?php include('logo_header.php'); ?>
    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="page-inner">
            <h3 class="fw-bold mb-3">My Profile</h3>

            <div class="row">
                <!-- Profile Details -->
                <div class="col-md-6">
                    <div class="card card-round">
                        <div class="card-header"><strong>Profile Information</strong></div>
                        <div class="card-body">

                            <form method="POST" enctype="multipart/form-data" class="row">
                                <div class="text-center">
                                    <img src="<?php echo $user_data['profile_picture'] ?: 'assets/img/profile-img.jpg'; ?>" class="rounded-circle mb-3"
                                        style="width:150px;height:150px;object-fit:cover;">
                                    <input type="file" name="profile_picture" class="form-control mb-3">
                                </div>

                                <input type="hidden" name="update_profile">
                                <input class="form-control mb-2" name="staffname" placeholder="Full Name" value="<?php echo htmlspecialchars($user_data['staffname']); ?>" required>
                                <input class="form-control mb-2" name="mobile" placeholder="Mobile" value="<?php echo htmlspecialchars($user_data['mobile']); ?>">
                                <input class="form-control mb-2" name="email" type="email" placeholder="Email" value="<?php echo htmlspecialchars($user_data['email']); ?>">

                                <textarea class="form-control mb-2" name="address" placeholder="Address"><?php echo htmlspecialchars($user_data['address']); ?></textarea>

                                <input class="form-control mb-2" type="date" name="date_of_birth" value="<?php echo htmlspecialchars($user_data['date_of_birth']); ?>">

                                <select class="form-control mb-2" name="gender">
                                    <option disabled>Select Gender</option>
                                    <option <?php if($user_data['gender']=="Male") echo "selected"; ?>>Male</option>
                                    <option <?php if($user_data['gender']=="Female") echo "selected"; ?>>Female</option>
                                    <option <?php if($user_data['gender']=="Other") echo "selected"; ?>>Other</option>
                                </select>

                                <div class="text-center">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>

                                <?php if ($profile_message): ?>
                                    <div class="alert alert-info mt-3"><?php echo $profile_message; ?></div>
                                <?php endif; ?>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="col-md-6">
                    <div class="card card-round">
                        <div class="card-header"><strong>Change Password</strong></div>
                        <div class="card-body">

                            <form method="POST">
                                <input type="hidden" name="change_password">
                                <input class="form-control mb-2" type="password" name="new_password" placeholder="New Password" required>
                                <input class="form-control mb-2" type="password" name="confirm_password" placeholder="Confirm Password" required>

                                <button class="btn btn-success"><i class="fa fa-save"></i> Change</button>

                                <?php if ($message): ?>
                                    <div class="alert alert-info mt-3"><?php echo $message; ?></div>
                                <?php endif; ?>
                            </form>

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
