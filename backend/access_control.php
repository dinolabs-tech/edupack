<?php
/**
 * access_control.php
 *
 * This file implements a role-based access control (RBAC) system for the application.
 * It defines which user roles are allowed to access specific PHP pages.
 *
 * It starts a session if one is not already active and then checks the user's role
 * against a predefined set of access rules for the current page.
 * If the user does not have the necessary permissions, they are redirected to
 * either the login page (if not logged in) or an unauthorized access page.
 */

// Start a session if one is not already active.
// This is crucial for accessing user session data, such as the user's role.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Define page access rules.
 *
 * This associative array maps filenames (without their path) to an array of
 * allowed user roles.
 * - Key: The basename of the PHP file (e.g., 'dashboard.php').
 * - Value: An array of strings, where each string is an allowed role
 *          (e.g., 'Administrator', 'Teacher', 'Student').
 *
 * If a page is not listed here, it is considered public or not explicitly protected
 * by this access control mechanism. If an empty array is provided as a value,
 * it means the page is public and accessible to all (e.g., login, logout).
 */
$access_rules = [
    'superdashboard.php' => ['Superuser'],
    'dashboard.php' => ['Administrator', 'Teacher', 'Tuckshop', 'Admission', 'Bursary'],
    'students.php' => ['Student'],
    'alumni.php' => ['Alumni'],
    'parent_dashboard.php' => ['Parent'],
    'admin.php' => ['Administrator', 'Superuser'],
    'approvepayments.php' => ['Administrator', 'Bursary', 'Superuser'],
    'registerstudents.php' => ['Administrator', 'Admission', 'Superuser'],
    'uploadresults.php' => ['Administrator', 'Teacher', 'Superuser'],
    'modifyresult.php' => ['Administrator', 'Teacher', 'Superuser'],
    'viewstudents.php' => ['Administrator', 'Teacher', 'Admission', 'Superuser'],
    'usercontrol.php' => ['Superuser', 'Administrator'],
    'inventory.php' => ['Tuckshop', 'Administrator', 'Superuser'],
    'transactions.php' => ['Tuckshop', 'Bursary', 'Administrator', 'Superuser'],
    'add_post.php' => ['Administrator', 'Teacher', 'Superuser'],
    'edit_post.php' => [],
    'delete_post.php' => ['Administrator', 'Teacher', 'Superuser'],
    'create_thread.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser'],
    'edit_thread.php' => [],
    'delete_thread.php' => [],
    'view_thread.php' => [],
    'inbox.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'create_message.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'read_message.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'reply_message.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'sent_message.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'send_notice.php' => ['Administrator', 'Superuser'],
    'read_notice.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'mark_attendance.php' => ['Teacher', 'Administrator', 'Superuser'],
    'print_attendance.php' => ['Teacher', 'Administrator', 'Superuser'],
    'print_attendance_sheet.php' => ['Teacher', 'Administrator', 'Superuser'],
    'print_attendance_summary.php' => ['Teacher', 'Administrator', 'Superuser'],
    'timetable.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser'],
    'viewtimetable.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser'],
    'uploadassignments.php' => ['Teacher', 'Administrator', 'Superuser'],
    'viewassignment.php' => ['Teacher', 'Student', 'Parent', 'Alumni', 'Administrator', 'Superuser'],
    'uploadcurriculum.php' => ['Teacher', 'Administrator', 'Superuser'],
    'viewcurriculum.php' => ['Teacher', 'Student', 'Parent', 'Alumni', 'Administrator', 'Superuser'],
    'uploadnotes.php' => ['Teacher', 'Administrator', 'Superuser'],
    'viewnotes.php' => ['Teacher', 'Student', 'Parent', 'Alumni', 'Administrator', 'Superuser'],
    'quiz.php' => ['Student', 'Teacher', 'Administrator', 'Superuser'],
    'addquestion.php' => ['Teacher', 'Administrator', 'Superuser'],
    'questionadd.php' => ['Teacher', 'Administrator', 'Superuser'],
    'quedel.php' => ['Teacher', 'Administrator', 'Superuser'],
    'checkcbt.php' => ['Student', 'Teacher', 'Administrator', 'Superuser'],
    'downloadcbt.php' => ['Teacher', 'Administrator', 'Superuser'],
    'settime.php' => ['Teacher', 'Administrator', 'Superuser'],
    'timer.php' => ['Student'],
    'calendar.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'profile.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'adminprofile.php' => ['Administrator', 'Superuser'],
    'studentprofile.php' => ['Student'],
    'parentprofile.php' => ['Parent'],
    'alumniprofile.php' => ['Alumni'],
    'userprofile.php' => ['Administrator', 'Teacher', 'Tuckshop', 'Admission', 'Bursary', 'Superuser'],
    'checkresult.php' => ['Student', 'Parent', 'Administrator', 'Teacher', 'Superuser'],
    'parent_checkresult.php' => ['Parent'],
    'individualresult.php' => ['Administrator', 'Teacher', 'Superuser'],
    'mastersheet.php' => ['Administrator', 'Teacher', 'Superuser'],
    'result.php' => ['Student', 'Parent', 'Administrator', 'Teacher', 'Superuser'],
    'transcript.php' => ['Student', 'Parent', 'Administrator', 'Teacher', 'Superuser'],
    'download_transcript.php' => ['Administrator', 'Teacher', 'Superuser'],
    'promote.php' => ['Administrator', 'Superuser'],
    'assign_students.php' => ['Administrator', 'Superuser'],
    'unassign_students.php' => ['Administrator', 'Superuser'],
    'register_parent.php' => ['Administrator', 'Admission', 'Superuser'],
    'delete_parent.php' => ['Administrator', 'Superuser'],
    'modify_students.php' => ['Administrator', 'Admission', 'Superuser'],
    'search_students.php' => ['Administrator', 'Admission', 'Teacher', 'Superuser'],
    'subjects.php' => ['Administrator', 'Teacher', 'Superuser'],
    'load_subjects.php' => ['Administrator', 'Teacher', 'Superuser'],
    'fetch_subjects.php' => ['Administrator', 'Teacher', 'Superuser'],
    'sublist.php' => ['Administrator', 'Teacher', 'Superuser', 'Student'],
    'bpayment.php' => ['Bursary', 'Parent', 'Administrator', 'Superuser'],
    'parent_bpayment.php' => ['Parent'],
    'paymentstatus.php' => ['Bursary', 'Administrator', 'Superuser'],
    'parent_paymentstatus.php' => ['Parent'],
    'revoke.php' => ['Bursary', 'Administrator', 'Superuser'],
    'admin_chatbot.php' => ['Administrator', 'Superuser'],
    'chatbot.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],
    'maintenance.php' => ['Superuser','Administrator', 'Teacher'],
    'expiry.php' => ['Administrator', 'Superuser'],
    '404.php' => ['Administrator', 'Teacher', 'Student', 'Parent', 'Alumni', 'Superuser', 'Tuckshop', 'Admission', 'Bursary'],

    'admission_settings.php' => ['Administrator', 'Superuser', 'Bursary'],
    'manage_applications.php' => ['Administrator', 'Superuser', 'Admission'],
    'assign_admin_details.php' => ['Administrator', 'Superuser', 'Admission'],
    'admission_transactions.php' => ['Administrator', 'Superuser', 'Bursary'],
    'view_applications.php' => ['Administrator', 'Superuser', 'Admission'],

    'login.php' => [],
    'logout.php' => [],
    'index.php' => [],
    'sellingpoint.php' => [],
    'db_connection.php' => [],
    'database_schema.php' => [],
    'head.php' => [],
    'footer.php' => [],
    'navbar.php' => [],
    'sidebar.php' => [],
    'scripts.php' => [],
    'logo_header.php' => [],
    'cust-color.php' => [],
    'get_lgas.php' => [],
    'get_sessions.php' => [],
    'load_subjects.php' => [],
    'fetch_subjects.php' => [],
    'mark_attendance_process.php' => ['Teacher', 'Administrator', 'Superuser'],
    'upload_csv.php' => ['Administrator', 'Admission', 'Superuser'],
    'download_template.php' => ['Administrator', 'Admission', 'Teacher', 'Superuser'],
    'download_enroll_template.php' => ['Administrator', 'Admission', 'Superuser'],
    'download_result_template.php' => ['Administrator', 'Teacher', 'Superuser'],
    'download_subject_template.php' => ['Administrator', 'Teacher', 'Superuser'],
    'download_classteacher_template.php' => ['Administrator', 'Superuser'],
    'download_principal_template.php' => ['Administrator', 'Superuser'],
    'classteachercomment.php' => ['Teacher', 'Administrator', 'Superuser'],
    'principalcomment.php' => ['Administrator', 'Superuser'],
    'adminnav.php' => ['Administrator', 'Superuser'],
    'alumninav.php' => ['Alumni'],
    'parentnav.php' => ['Parent'],
    'studentnav.php' => ['Student'],
    'tuckdashboard.php' => ['Tuckshop', 'Superuser', 'Administrator'],
    'admincheckresult.php' => ['Administrator', 'Superuser'],
    'admincheckresult (without attendance feature).php' => ['Administrator', 'Superuser'],
    'admincheckresult copy.php' => ['Administrator', 'Superuser'],
    'checkresult (without attendance feature).php' => ['Student', 'Parent', 'Administrator', 'Teacher', 'Superuser'],
    'delete_result.php' => ['Administrator', 'Superuser', 'Teacher'],
    'viewuploadedresult.php' => ['Administrator', 'Teacher', 'Superuser'],
    'viewuploadassignments.php' => ['Teacher', 'Student', 'Parent', 'Alumni', 'Administrator', 'Superuser'],
    'viewuploadcurriculum.php' => ['Teacher', 'Student', 'Parent', 'Alumni', 'Administrator', 'Superuser'],
    'viewuploadnotes.php' => ['Teacher', 'Student', 'Parent', 'Alumni', 'Administrator', 'Superuser'],
    'createforumusers.php' => ['Administrator', 'Superuser'],
    'threads.php' => [],
    'test.php' => ['Superuser'],
    'dob.php' => ['Administrator', 'Superuser'],
    'idcard.php' => [],
    'idcard2.php' => [],
    'checker.php' => ['Administrator', 'Superuser'],
    'close.php' => [],
    'delete-git.php' => ['Superuser'],
    'error_log' => [], // This is a file, but typically not a PHP file to be commented.
    'LICENSE' => [], // Not a PHP file.
    'README.md' => [], // Not a PHP file.
    'README.txt' => [], // Not a PHP file.
    'backup.log' => [], // Not a PHP file.
    'backup.php' => ['Superuser'],
    'backup_dinolabs_portal.sql' => [], // Not a PHP file.
    'backup_portalv2.sql' => [], // Not a PHP file.
    'regtuck.php' => ['Tuckshop', 'Administrator', 'Superuser'],
    'supplier.php' => ['Tuckshop', 'Administrator', 'Superuser'],
    'alumni_list.php' => ['Administrator', 'Superuser'],
    'adquest.php' => ['Teacher', 'Administrator', 'Superuser'],
];

/**
 * Checks if the current user has access to the requested page based on their role.
 *
 * This function retrieves the current page's filename and the user's role from the session.
 * It then compares these against the global `$access_rules` array.
 *
 * Redirection Logic:
 * - If the page is not explicitly defined in `$access_rules`, access is granted (considered public).
 * - If the page is defined with an empty array of roles, access is granted (public page).
 * - If the user is not logged in (no role in session), they are redirected to `login.php`.
 * - If the user's role is not among the allowed roles for the page, they are redirected to `unauthorized.php`.
 *
 * @global array $access_rules An associative array defining page-to-role access mappings.
 * @return void This function redirects the user and exits if access is denied.
 */
function check_access() {
    global $access_rules;

    // Get the basename of the current PHP script (e.g., "dashboard.php").
    $current_page = basename($_SERVER['PHP_SELF']);
    // Get the user's role from the session, defaulting to null if not set.
    $user_role = $_SESSION['role'] ?? null;

    // If the current page is not found in the access rules, it means it's not
    // explicitly protected by this system, so access is implicitly granted.
    if (!array_key_exists($current_page, $access_rules)) {
        return;
    }

    // Retrieve the array of roles allowed to access the current page.
    $allowed_roles = $access_rules[$current_page];

    // If the allowed roles array is empty, it signifies a public page that
    // anyone can access, regardless of login status or role.
    if (empty($allowed_roles)) {
        return;
    }

    // If the user's role is null, it means they are not logged in.
    // Redirect them to the login page.
    if ($user_role === null) {
        header("Location: login.php");
        exit();
    }

    // Check if the user's current role is present in the list of allowed roles
    // for the current page. If not, access is denied.
    if (!in_array($user_role, $allowed_roles)) {
        header("Location: unauthorized.php");
        exit();
    }
}

// Prevent infinite redirection loops by not calling `check_access()` on
// the login or unauthorized pages themselves. These pages must be accessible
// to handle login and access denial scenarios.
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page !== 'login.php' && $current_page !== 'unauthorized.php') {
    check_access();
}
?>
