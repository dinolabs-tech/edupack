<?php
include('components/admin_logic.php');

$message = '';
$profile_message = '';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Unauthorized Access");
}

function safeValue($value) {
    return htmlspecialchars($value ?? '');
}

function getUser($conn, $user_id) {
    $stmt = $conn->prepare("SELECT staffname, username, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$user_data = getUser($conn, $user_id);

// ✅ Handle POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ✅ Password change
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $message = "New passwords do not match.";
        } else {
            $stmt = $conn->prepare("UPDATE login SET password=? WHERE id=?");
            $stmt->bind_param("ss", $_POST['new_password'], $user_id);

            if ($stmt->execute()) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error updating password.";
            }
            $stmt->close();
        }
    }

    // ✅ Profile picture
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "staffimg/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

        $file_extension = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));
        if (in_array($file_extension, ["jpg", "jpeg", "png", "gif"])) {
            $new_path = $target_dir . $user_id . "_profile." . $file_extension;

            if (!empty($user_data['profile_picture']) && file_exists($user_data['profile_picture'])) {
                unlink($user_data['profile_picture']);
            }

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $new_path)) {
                $stmt = $conn->prepare("UPDATE login SET profile_picture=? WHERE id=?");
                $stmt->bind_param("ss", $new_path, $user_id);
                $stmt->execute();
                $stmt->close();
                $profile_message = "Profile picture updated!";
            }
        } else {
            $profile_message = "Invalid image format.";
        }
    }

    // ✅ Profile data updates
    $fields = ["staffname", "mobile", "email", "address", "date_of_birth", "gender"];
    $update = [];
    $values = [];

    foreach ($fields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] !== ($user_data[$field] ?? '')) {
            $update[] = "$field=?";
            $values[] = $_POST[$field];
        }
    }

    if (!empty($update)) {
        $values[] = $user_id;
        $stmt = $conn->prepare("UPDATE login SET " . implode(", ", $update) . " WHERE id=?");
        $stmt->bind_param(str_repeat("s", count($values)), ...$values);
        $stmt->execute();
        $stmt->close();
        $profile_message .= " Profile updated!";
    }

    $user_data = getUser($conn, $user_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<div class="wrapper">
<?php include('adminnav.php'); ?>
<div class="main-panel">
<?php include('navbar.php'); ?>

<div class="container">
<div class="page-inner">
<h3 class="fw-bold mb-3">My Profile</h3>

<div class="row">
<!-- ✅ Profile Section -->
<div class="col-md-6">
<div class="card card-round">
<div class="card-header"><h5>Profile Information</h5></div>

<div class="card-body">
<form method="POST" enctype="multipart/form-data" class="row">

<div class="form-group text-center">
<img src="<?php echo safeValue($user_data['profile_picture'] ?? 'assets/img/profile-img.jpg'); ?>"
class="img-fluid rounded-circle mb-3"
style="width:150px;height:150px;object-fit:cover;">
<input type="file" class="form-control" name="profile_picture">
</div>

<input class="form-control mb-2" name="staffname" placeholder="Full Name"
value="<?php echo safeValue($user_data['staffname']); ?>" required>
<input class="form-control mb-2" name="mobile" placeholder="Mobile"
value="<?php echo safeValue($user_data['mobile']); ?>">
<input class="form-control mb-2" type="email" name="email" placeholder="Email"
value="<?php echo safeValue($user_data['email']); ?>">

<textarea class="form-control mb-2" name="address"
placeholder="Address"><?php echo safeValue($user_data['address']); ?></textarea>

<input class="form-control mb-2" type="date" name="date_of_birth"
value="<?php echo safeValue($user_data['date_of_birth']); ?>">

<select class="form-control mb-2" name="gender">
<option disabled>Select Gender</option>
<option value="Male" <?php if(($user_data['gender'] ?? '')=="Male") echo "selected"; ?>>Male</option>
<option value="Female" <?php if(($user_data['gender'] ?? '')=="Female") echo "selected"; ?>>Female</option>
<option value="Other" <?php if(($user_data['gender'] ?? '')=="Other") echo "selected"; ?>>Other</option>
</select>

<button class="btn btn-primary w-100">Save</button>

</form>

<?php if (!empty($profile_message)) : ?>
<div class="alert alert-info mt-3"><?php echo $profile_message; ?></div>
<?php endif; ?>

</div>
</div>
</div>

<!-- ✅ Password Section -->
<div class="col-md-6">
<div class="card card-round">
<div class="card-header"><h5>Change Password</h5></div>
<div class="card-body">
<form method="POST">

<input class="form-control mb-2" type="password" name="new_password"
placeholder="Enter New Password" required>
<input class="form-control mb-2" type="password" name="confirm_password"
placeholder="Confirm New Password" required>

<button class="btn btn-success w-100">Update Password</button>

</form>

<?php if (!empty($message)) : ?>
<div class="alert alert-info mt-3"><?php echo $message; ?></div>
<?php endif; ?>

</div>
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
