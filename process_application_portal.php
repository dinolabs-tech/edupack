<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('backend/db_connection.php');
require_once('classes/OnlineApplicationPortalClass.php'); // Include the class file
require_once('classes/AdmissionSettingsClass.php'); // Include the AdmissionSettingsClass
require_once('includes/mail_sender.php'); // Include the new mail sender function

$appPortal = new OnlineApplicationPortal($conn);
$admissionSettings = new AdmissionSettings($conn);
$registration_cost = $admissionSettings->getSetting('registration_cost');
if ($registration_cost === null) {
    $registration_cost = 0.00; // Default to 0 if not set in settings
}
$flutterwave_secret_key = $admissionSettings->getSetting('flutterwave_secret_key');
if ($flutterwave_secret_key === null) {
    // If the secret key is not set, terminate with an error.
    // It's crucial that a live key is configured in the settings.
    $_SESSION['error_message'] = "Flutterwave secret key is not configured. Please contact administrator.";
    header("Location: online_application_portal.php?status=failed&message=" . urlencode($_SESSION['error_message']));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'submit_application') {
        // Generate a unique application ID
        $application_id = 'APP-' . uniqid();

        $flw_tx_ref = $_POST['flw_tx_ref'] ?? null;
        $flw_transaction_id = $_POST['flw_transaction_id'] ?? null;
        $flw_status = $_POST['flw_status'] ?? null;

        $payment_successful = false;
        if ($registration_cost > 0) {
            if ($flw_status === 'successful' && $flw_tx_ref && $flw_transaction_id) {
                // Verify payment with Flutterwave API
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/transactions/{$flw_transaction_id}/verify");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: Bearer {$flutterwave_secret_key}"
                ]);
                $response = curl_exec($ch);
                curl_close($ch);
                
                $res = json_decode($response);

                if ($res && $res->status === 'success' && $res->data->amount >= $registration_cost && $res->data->currency === 'NGN' && $res->data->tx_ref === $flw_tx_ref) {
                    $payment_successful = true;
                } else {
                    $_SESSION['error_message'] = "Payment verification failed. Please try again or contact support.";
                    header("Location: online_application_portal.php?status=failed&message=" . urlencode($_SESSION['error_message']));
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Payment details missing or payment not successful.";
                header("Location: online_application_portal.php?status=failed&message=" . urlencode($_SESSION['error_message']));
                exit();
            }
        } else {
            $payment_successful = true; // No payment required
        }

        if (!$payment_successful) {
            $_SESSION['error_message'] = "Payment required but not successful.";
            header("Location: online_application_portal.php?status=failed&message=" . urlencode($_SESSION['error_message']));
            exit();
        }

        $applicant_data = [
            'id' => $application_id,
            'name' => $_POST['name'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'dob' => $_POST['dob'] ?? null,
            'placeob' => $_POST['placeob'] ?? '',
            'address' => $_POST['address'] ?? '',
            'studentmobile' => $_POST['studentmobile'] ?? '',
            'email' => $_POST['email'] ?? '',
            'religion' => $_POST['religion'] ?? '',
            'state' => $_POST['state'] ?? '',
            'lga' => $_POST['lga'] ?? '',
            'class' => '', // Will be assigned by admin
            'arm' => '', // Will be assigned by admin
            'session' => $_POST['session'] ?? '',
            'term' => $_POST['term'] ?? '',
            'schoolname' => $_POST['schoolname'] ?? '',
            'schooladdress' => $_POST['schooladdress'] ?? '',
            'hobbies' => $_POST['hobbies'] ?? '',
            'lastclass' => $_POST['lastclass'] ?? '',
            'sickle' => $_POST['sickle'] ?? '',
            'challenge' => $_POST['challenge'] ?? '',
            'emergency' => $_POST['emergency'] ?? '',
            'familydoc' => $_POST['familydoc'] ?? '',
            'docaddress' => $_POST['docaddress'] ?? '',
            'docmobile' => $_POST['docmobile'] ?? '',
            'polio' => $_POST['polio'] ?? '',
            'tuberculosis' => $_POST['tuberculosis'] ?? '',
            'measles' => $_POST['measles'] ?? '',
            'tetanus' => $_POST['tetanus'] ?? '',
            'whooping' => $_POST['whooping'] ?? '',
            'gname' => $_POST['gname'] ?? '',
            'mobile' => $_POST['mobile'] ?? '',
            'goccupation' => $_POST['goccupation'] ?? '',
            'gaddress' => $_POST['gaddress'] ?? '',
            'grelationship' => $_POST['grelationship'] ?? '',
            'hostel' => '', // Will be assigned by admin
            'bloodtype' => $_POST['bloodtype'] ?? '',
            'bloodgroup' => $_POST['bloodgroup'] ?? '',
            'height' => $_POST['height'] ?? '',
            'weight' => $_POST['weight'] ?? '',
            'photo' => '', // Deprecated, using passport_path
            'status' => 0, // Default status for student_applications table
            'password' => password_hash(uniqid(), PASSWORD_DEFAULT), // Generate a temporary password
            'result' => 0, // Default result
            'admission_status' => 'pending', // New admission status
            'passport_path' => null,
            'transcript_path' => null,
            'entrance_exam_scheduled' => 0,
            'entrance_exam_date' => null,
            'entrance_exam_time' => null,
            'entrance_exam_location' => null,
        ];

        // Basic validation for required fields
        if (empty($applicant_data['name']) || empty($applicant_data['email']) || empty($applicant_data['dob']) || empty($applicant_data['gender']) || empty($applicant_data['placeob'])) {
            $_SESSION['error_message'] = "Please fill in all required personal information fields.";
            header("Location: online_application_portal.php");
            exit();
        }

        // Handle passport photo upload
        if (isset($_FILES['passport_path']) && $_FILES['passport_path']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/passports/'; // Changed to project root
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_ext = pathinfo($_FILES['passport_path']['name'], PATHINFO_EXTENSION);
            $passport_filename = $application_id . '_passport.' . $file_ext;
            $passport_target_file = $upload_dir . $passport_filename;

            if (move_uploaded_file($_FILES['passport_path']['tmp_name'], $passport_target_file)) {
                $applicant_data['passport_path'] = $passport_target_file;
            } else {
                $_SESSION['error_message'] = "Failed to upload passport photo.";
                header("Location: online_application_portal.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Passport photo is required.";
            header("Location: online_application_portal.php");
            exit();
        }

        // Handle transcript upload
        if (isset($_FILES['transcript_path']) && $_FILES['transcript_path']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/transcripts/'; // Changed to project root
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_ext = pathinfo($_FILES['transcript_path']['name'], PATHINFO_EXTENSION);
            $transcript_filename = $application_id . '_transcript.' . $file_ext;
            $transcript_target_file = $upload_dir . $transcript_filename;

            if (move_uploaded_file($_FILES['transcript_path']['tmp_name'], $transcript_target_file)) {
                $applicant_data['transcript_path'] = $transcript_target_file;
            } else {
                $_SESSION['error_message'] = "Failed to upload transcript.";
                header("Location: online_application_portal.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Transcripts are required.";
            header("Location: online_application_portal.php");
            exit();
        }

        // Create the application in the database
        if ($payment_successful && $appPortal->createApplication($applicant_data)) {
            $_SESSION['success_message'] = "Application submitted successfully with ID: " . $application_id;

            // Send confirmation email to applicant
            $applicant_email = $applicant_data['email'];
            $applicant_name = $applicant_data['name'];
            $subject = "Your Application to EduPack School Has Been Submitted!";
            $body = "
                <p>Dear {$applicant_name},</p>
                <p>Thank you for submitting your application to EduPack School. Your application ID is <strong>{$application_id}</strong>.</p>
                <p>Our admissions team will review your application and get back to you shortly.</p>
                <p>Best regards,<br>EduPack Admissions Team</p>
            ";
            sendEmail($applicant_email, $applicant_name, $subject, $body);

            // Optionally, send an email to the admin
            $admin_email = 'dinolabs.tech@gmail.com'; // Or a specific admissions email
            $admin_subject = "New Application Submitted: {$applicant_name}";
            $admin_body = "
                <p>A new application has been submitted by {$applicant_name} (Email: {$applicant_email}).</p>
                <p>Application ID: {$application_id}</p>
                <p>Please log in to the admissions portal to review the application.</p>
            ";
            sendEmail($admin_email, 'Admissions Admin', $admin_subject, $admin_body);

            // Record the transaction if payment was required and successful
            if ($registration_cost > 0) {
                $payment_method = 'Online Payment (Flutterwave)'; // Or extract from Flutterwave response if available
                $notes = "Flutterwave Transaction Ref: " . ($flw_tx_ref ?? 'N/A');
                $appPortal->recordAdmissionTransaction($application_id, $registration_cost, $payment_method, 'Completed', $notes);
            }

        } else {
            $_SESSION['error_message'] = "Failed to submit application. Please try again or contact support.";
        }

        header("Location: online_application_portal.php");
        exit();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'update_status' && isset($_GET['id']) && isset($_GET['status'])) {
        // Admin action to update application status
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Administrator' && $_SESSION['role'] !== 'Superuser')) {
            $_SESSION['error_message'] = "Unauthorized access.";
            header("Location: online_application_portal.php");
            exit();
        }

        $application_id = $_GET['id'];
        $new_status = $_GET['status'];

        // Validate status
        $valid_statuses = ['pending', 'exam_scheduled', 'approved', 'rejected'];
        if (!in_array($new_status, $valid_statuses)) {
            $_SESSION['error_message'] = "Invalid status provided.";
            header("Location: online_application_portal.php");
            exit();
        }

        if ($appPortal->updateApplicationStatus($application_id, $new_status)) {
            $_SESSION['success_message'] = "Application ID {$application_id} status updated to {$new_status}.";

            // Send email notification to applicant about status change
            $applicant_details = $appPortal->getStudentApplicationById($application_id);
            if ($applicant_details) {
                $applicant_email = $applicant_details['email'];
                $applicant_name = $applicant_details['name'];
                $subject = "Your Application Status Has Been Updated!";
                $body = "
                    <p>Dear {$applicant_name},</p>
                    <p>Your application (ID: <strong>{$application_id}</strong>) to EduPack School has been updated to: <strong>{$new_status}</strong>.</p>
                    <p>Please log in to the portal for more details.</p>
                    <p>Best regards,<br>EduPack Admissions Team</p>
                ";
                sendEmail($applicant_email, $applicant_name, $subject, $body);
            }

        } else {
            $_SESSION['error_message'] = "Failed to update application ID {$application_id} status.";
        }
        header("Location: online_application_portal.php");
        exit();
    }

    header("Location: online_application_portal.php");
    exit();
} else {
    // For GET requests, simply redirect to the portal
    header("Location: online_application_portal.php");
    exit();
}
?>
