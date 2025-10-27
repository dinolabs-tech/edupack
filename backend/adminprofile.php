<?php
// adminprofile.php
// Simplified & fixed: null-safe htmlspecialchars, single fetch, clean update logic.
// NOTE: You chose to keep plain text passwords — consider switching to password_hash later.

include('components/admin_logic.php'); // assumes this starts session and sets $conn and $_SESSION['user_id']

$user_id = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
if ($user_id <= 0) {
    // Not logged in or invalid session — redirect or stop
    header('Location: login.php');
    exit;
}

$message = $profile_message = "";

// default data shape to avoid undefined keys / nulls
$defaults = [
    'staffname' => '',
    'username' => '',
    'mobile' => '',
    'email' => '',
    'address' => '',
    'date_of_birth' => '',
    'gender' => '',
    'profile_picture' => 'assets/img/profile-img.jpg'
];

// fetch user data
$stmt = $conn->prepare("SELECT staffname, username, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$fetched = $stmt->get_result()->fetch_assoc();
$stmt->close();

$user_data = array_merge($defaults, $fetched ?? $defaults);

// POST handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ---------- Password change (plain text as requested) ----------
    if (isset($_POST['change_password'])) {
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($new_password === '' || $confirm_password === '') {
            $message = "Please fill both password fields.";
        } elseif ($new_password !== $confirm_password) {
            $message = "New passwords do not match.";
        } else {
            $stmt = $conn->prepare("UPDATE login SET password=? WHERE id=?");
            $stmt->bind_param("si", $new_password, $user_id);
            if ($stmt->execute()) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error changing password: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    // ---------- Profile update (text fields + optional picture) ----------
    if (isset($_POST['update_profile'])) {

        // Handle profile picture upload if a file was provided
        if (!empty($_FILES['profile_picture']['name'] ?? '')) {
            $file = $_FILES['profile_picture'];

            if ($file['error'] === UPLOAD_ERR_OK && is_uploaded_file($file['tmp_name'])) {
                $check = @getimagesize($file['tmp_name']);
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg','jpeg','png','gif'];

                if ($check === false) {
                    $profile_message .= "Uploaded file is not an image. ";
                } elseif (!in_array($ext, $allowed)) {
                    $profile_message .= "Allowed image types: jpg, jpeg, png, gif. ";
                } else {
                    $target_dir = __DIR__ . "/staffimg/";
                    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

                    $new_filename = $user_id . "_profile." . $ext;
                    $target_path = $target_dir . $new_filename;
                    $public_path = "staffimg/" . $new_filename; // path to store in DB and use in <img>

                    if (move_uploaded_file($file['tmp_name'], $target_path)) {
                        // Remove old custom picture if it's not the default and exists
                        if (!empty($user_data['profile_picture']) && $user_data['profile_picture'] !== $defaults['profile_picture']) {
                            $old = __DIR__ . '/' . $user_data['profile_picture'];
                            if (file_exists($old)) @unlink($old);
                        }

                        $stmt = $conn->prepare("UPDATE login SET profile_picture=? WHERE id=?");
                        $stmt->bind_param("si", $public_path, $user_id);
                        if ($stmt->execute()) {
                            $profile_message .= "Profile picture updated. ";
                            $user_data['profile_picture'] = $public_path; // reflect change immediately
                        } else {
                            $profile_message .= "Error saving picture path to DB: " . $stmt->error . " ";
                        }
                        $stmt->close();
                    } else {
                        $profile_message .= "Failed to move uploaded file. ";
                    }
                }
            } else {
                $profile_message .= "Error uploading file. ";
            }
        }

        // Collect text fields and update only changed ones
        $fields = ['staffname','mobile','email','address','date_of_birth','gender'];
        $update_cols = [];
        $params = [];
        $types = "";

        foreach ($fields as $f) {
            $val = isset($_POST[$f]) ? trim($_POST[$f]) : '';
            // compare with existing (string compare); update if different
            $existing = (string)($user_data[$f] ?? '');
            if ($val !== $existing) {
                $update_cols[] = "$f = ?";
                $params[] = $val;
                $types .= "s";
            }
        }

        if (!empty($update_cols)) {
            $sql = "UPDATE login SET " . implode(", ", $update_cols) . " WHERE id = ?";
            $params[] = $user_id;
            $types .= "i";

            $stmt = $conn->prepare($sql);
            // bind_param requires references; use ... operator only in PHP 5.6+,
            // but bind_param needs variables; we'll use a workaround:
            $bind_names[] = $types;
            for ($i=0; $i < count($params); $i++) {
                $bind_names[] = &$params[$i];
            }
            call_user_func_array([$stmt, 'bind_param'], $bind_names);

            if ($stmt->execute()) {
                $profile_message .= "Profile updated. ";
            } else {
                $profile_message .= "Error updating profile: " . $stmt->error . " ";
            }
            $stmt->close();

            // Refresh user_data after update
            $stmt2 = $conn->prepare("SELECT staffname, username, mobile, email, address, date_of_birth, gender, profile_picture FROM login WHERE id = ?");
            $stmt2->bind_param("i", $user_id);
            $stmt2->execute();
            $newrow = $stmt2->get_result()->fetch_assoc();
            $stmt2->close();
            $user_data = array_merge($defaults, $newrow ?? $user_data);
        }
    }
}

// Helper to echo safe HTML values
function esc($val) {
    return htmlspecialchars($val ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<div class="wrapper">

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
                        <h3 class="fw-bold mb-3">My Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Home</li>
                            <li class="breadcrumb-item active">My Profile</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <!-- Profile form -->
                    <div class="col-md-6">
                        <div class="card card-round">
                            <div class="card-header"><div class="card-title">Profile Information</div></div>
                            <div class="card-body pb-0">
                                <form method="post" enctype="multipart/form-data" class="row">
                                    <div class="form-group text-center col-12">
                                        <img src="<?= esc($user_data['profile_picture'] ?? $defaults['profile_picture']) ?>"
                                             alt="Profile" class="img-fluid rounded-circle mb-3"
                                             style="width:150px;height:150px;object-fit:cover;">
                                        <input type="file" name="profile_picture" class="form-control-file form-control">
                                        <small class="form-text text-muted">Upload profile picture (jpg, png, gif)</small>
                                    </div>

                                    <input type="hidden" name="update_profile" value="1">

                                    <div class="form-group col-md-12">
                                        <input class="form-control" placeholder="Full Name" type="text" name="staffname"
                                               value="<?= esc($user_data['staffname']) ?>" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input class="form-control" placeholder="Mobile" type="text" name="mobile"
                                               value="<?= esc($user_data['mobile']) ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input class="form-control" placeholder="Email" type="email" name="email"
                                               value="<?= esc($user_data['email']) ?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <textarea class="form-control" name="address" placeholder="Address"><?= esc($user_data['address']) ?></textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input class="form-control" type="date" name="date_of_birth"
                                               value="<?= esc($user_data['date_of_birth']) ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <select class="form-control" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male" <?= ($user_data['gender'] === "Male") ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?= ($user_data['gender'] === "Female") ? 'selected' : '' ?>>Female</option>
                                            <option value="Other" <?= ($user_data['gender'] === "Other") ? 'selected' : '' ?>>Other</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12 text-center">
                                        <button class="btn btn-primary btn-icon btn-round ps-1" type="submit">
                                            <span class="btn-label"><i class="fa fa-save"></i></span> Save
                                        </button>
                                    </div>

                                    <?php if (!empty($profile_message)): ?>
                                        <div class="col-12">
                                            <div class="alert alert-info"><?= esc($profile_message) ?></div>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Password change -->
                    <div class="col-md-6">
                        <div class="card card-round">
                            <div class="card-header"><div class="card-title">Change Password</div></div>
                            <div class="card-body pb-0">
                                <form method="post">
                                    <input type="hidden" name="change_password" value="1">
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="new_password" placeholder="Enter New Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="confirm_password" placeholder="Confirm New Password" required>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success btn-icon btn-round ps-1" type="submit">
                                            <span class="btn-label"><i class="fa fa-save"></i></span> Change Password
                                        </button>
                                    </div>

                                    <?php if (!empty($message)): ?>
                                        <div class="alert alert-info"><?= esc($message) ?></div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>

                </div> <!-- row -->
            </div> <!-- page-inner -->
        </div> <!-- container -->

        <?php include('footer.php'); ?>
    </div> <!-- main-panel -->

    <?php include('cust-color.php'); ?>

</div> <!-- wrapper -->

<?php include('scripts.php'); ?>
</body>
</html>
