<?php
/**
 * admincheckresult (without attendance feature).php
 *
 * This file is responsible for generating a student's academic result report in PDF format.
 * It fetches student details, scores from the mastersheet, class teacher comments,
 * principal comments, and academic term/session information from the database.
 * The generated PDF includes student personal details, subject-wise scores, overall average,
 * and comments from the class teacher and principal. It uses the FPDF library for PDF generation.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Custom FPDF class for consistent header, footer, and text rotation.
 * - Dynamic retrieval of student photo or a default image.
 * - Fetching and displaying student's academic performance data.
 * - Calculating and displaying overall average.
 * - Displaying class teacher and principal comments.
 * - Including a grading table for reference.
 */

// Start or resume a session. This is crucial for checking user login status.
session_start();

// Check if the user is logged in. If not, redirect them to the login page
// to ensure only authenticated users can access this report.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the FPDF library, which is required for generating PDF documents.
require('includes/fpdf.php');
// Include the database connection file to establish a connection to the database.
include 'db_connection.php';

/**
 * Converts an integer into its ordinal representation (e.g., 1st, 2nd, 3rd, 4th).
 *
 * @param int $n The integer to convert.
 * @return string The ordinal string.
 */
function ordinal(int $n): string
{
    $suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    $v = $n % 100; // Get the last two digits
    // Special case for 11, 12, 13 which always use 'th'
    if ($v >= 11 && $v <= 13) {
        return $n . 'th';
    }
    // Use the last digit to determine the suffix
    return $n . $suffixes[$n % 10];
}

// Get the student ID from the URL query parameter.
// Example student_id format: WF/944/24
$student_id = $_GET['student_id'];

// Construct the photo filename by replacing '/' with '_' in the student ID.
// Example: WF_944_24.jpg
$photo_filename = str_replace('/', '_', $student_id);
$photo_path = "studentimg/" . $photo_filename . ".jpg";

// Check if the student's photo exists. If not, use a default image.
if (!file_exists($photo_path)) {
    $photo_path = "studentimg/default.jpg";
}

/**
 * Custom PDF class extending FPDF to include custom header, footer, and text rotation.
 */
class MyPDF extends FPDF
{
    protected $angle = 0; // Property to store the current rotation angle for text.
    public $studentImage; // Public property to hold the path to the student's image.

    /**
     * Overrides the default FPDF Header method to create a custom header for the report.
     * Includes school logo, school name, address, contact information, and a horizontal line.
     * Also places the student's photo in the top-right corner if available.
     */
    function Header()
    {
        $this->SetFont('Arial', 'B', 10);
        // School logo
        $this->Image('assets/img/logo.png', 10, 8, 20);

        // Student photo in the top-right corner
        if (!empty($this->studentImage) && file_exists($this->studentImage)) {
            // Calculate X position for right alignment: PageWidth - RightMargin - ImageWidth
            $x = $this->GetPageWidth() - 10 - 20;
            $this->Image($this->studentImage, $x, 8, 20);
        }

        // School Name
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 5, 'HAPA COLLEGE', 0, 1, 'C');
        // School Address and Contact Info
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, 'KM 3, Akure Owo Express Road, Oba Ile,', 0, 1, 'C');
        $this->Cell(0, 5, 'Akure, Ondo State, Nigeria.', 0, 1, 'C');
        $this->Cell(0, 5, 'hapacollege2013@yahoo.com', 0, 1, 'C');
        $this->Cell(0, 5, '+234-803-504-2727, +234-803-883-8583', 0, 1, 'C');
        $this->Ln(5); // Line break

        // Horizontal line separator
        $x1 = 10;
        $x2 = $this->GetPageWidth() - 10;
        $y = $this->GetY();
        $this->Line($x1, $y, $x2, $y);
        $this->Ln(5); // Line break after the line
    }

    /**
     * Overrides the default FPDF Footer method to create a custom footer for the report.
     * Displays the current date and time at the bottom of each page.
     */
    function Footer()
    {
        $this->SetY(-15); // Position at 1.5 cm from bottom
        $this->SetFont('Arial', 'I', 8); // Set font for footer
        $date = date('d/m/Y'); // Current date
        $time = date('H:i:s'); // Current time
        $this->Cell(100, 10, $date, 0, 0, 'L'); // Date on the left
        $this->Cell(0, 10, $time, 0, 0, 'R'); // Time on the right
    }

    /**
     * Sets the rotation angle for subsequent text.
     *
     * @param float $angle The rotation angle in degrees.
     * @param float $x The X coordinate of the rotation center.
     * @param float $y The Y coordinate of the rotation center.
     */
    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q'); // Restore previous state if already rotated
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180; // Convert to radians
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            // Apply rotation matrix
            $this->_out(sprintf('q %.2F %.2F %.2F %.2F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    /**
     * Prints text at a given position with a specified rotation angle.
     *
     * @param float $x The X coordinate.
     * @param float $y The Y coordinate.
     * @param string $txt The text to print.
     * @param float $angle The rotation angle in degrees.
     */
    function RotatedText($x, $y, $txt, $angle)
    {
        $this->Rotate($angle, $x, $y); // Apply rotation
        $this->Text($x, $y, $txt);     // Print text
        $this->Rotate(0);              // Reset rotation
    }
}

// Start output buffering to prevent any premature output before PDF generation.
ob_start();

// Create a new PDF instance using the custom MyPDF class.
$pdf = new MyPDF();
// Set the student image path for the PDF header.
$pdf->studentImage = $photo_path;
// Add the first page to the PDF document.
$pdf->AddPage();

// --- Fetch Student Details ---
// Retrieve all student details from the 'students' table using the provided student ID.
$student_details_result = $conn->query("SELECT * FROM students WHERE id = '$student_id'");
$student_details = $student_details_result->fetch_assoc();

// --- Fetch Current Term and Session ---
// Retrieve the current academic term from the 'currentterm' table.
$current_term_result = $conn->query("SELECT * FROM currentterm WHERE id = 1");
$current_term = $current_term_result->fetch_assoc();
$term = $current_term['cterm'];

// Retrieve the current academic session from the 'currentsession' table.
$current_session_result = $conn->query("SELECT * FROM currentsession WHERE id = 1");
$current_session = $current_session_result->fetch_assoc();
$curr_session = $current_session['csession'];

// --- Fetch Class Teacher Comments ---
// Retrieve class teacher comments for the specific student, term, and session.
$class_comments_result = $conn->query("SELECT * FROM classcomments WHERE id = '$student_id' AND term = '$term' AND csession = '$curr_session'");
// If comments exist, fetch them; otherwise, set default 'N/A' or 'No comment available'.
$class_comments = $class_comments_result->num_rows > 0 ? $class_comments_result->fetch_assoc() : [
    'schlopen' => 'N/A',
    'daysabsent' => 'N/A',
    'dayspresent' => 'N/A',
    'comment' => 'No comment available'
];

// --- Fetch Principal Comment ---
// Retrieve principal's comment for the specific student, term, and session.
$principal_comments_result = $conn->query("SELECT comment FROM principalcomments WHERE id = '$student_id' AND term = '$term' AND csession = '$curr_session'");
// If a comment exists, fetch it; otherwise, set a default 'No comment available'.
$principal_comment = $principal_comments_result->num_rows > 0 ? $principal_comments_result->fetch_assoc() : ['comment' => 'No comment available'];

// --- Fetch Next Term Start Date ---
// Retrieve the start date for the next academic term.
$next_term_result = $conn->query("SELECT Next FROM nextterm WHERE id = 1");
$next_term = $next_term_result->fetch_assoc()['Next'];

// --- Add Student Information to PDF ---
$pdf->SetFont('Arial', '', 10);
// Display student's name and school open days.
$pdf->Cell(95, 7, "Name: " . $student_details['name'], 'B', 0);
$pdf->Cell(95, 7, "SchlOpen: " . $class_comments['schlopen'], 'B', 1);
// Display student's class and arm, and days absent.
$pdf->Cell(95, 7, "Class: " . $student_details['class'] . " " . $student_details['arm'], 'B', 0);
$pdf->Cell(95, 7, "Days Absent: " . $class_comments['daysabsent'], 'B', 1);
// Display current term and days present.
$pdf->Cell(95, 7, "Term: " . $term, 'B', 0);
$pdf->Cell(95, 7, "Days Present: " . $class_comments['dayspresent'], 'B', 1);
// Display current session and next term start date.
$pdf->Cell(95, 7, "Session: " . $curr_session, 'B', 0);
$pdf->Cell(95, 7, "Next Term: " . $next_term, 'B', 1);
$pdf->Ln(5); // Line break

// --- Results Table Header ---
$pdf->SetFillColor(90, 174, 255); // Set background color for header cells.
$pdf->SetFont('Arial', 'B', 9); // Set font for header.
$pdf->Cell(80, 25, 'SUBJECT', 1, 0, 'C', true); // Subject column header.

// Define rotated headers for scores and other metrics.
$x_start = $pdf->GetX();
$y_start = $pdf->GetY();
$rotated_headers = ['CA1', 'CA2', 'EXAM', 'LAST CUM', 'TOTAL', 'AVERAGE', 'GRADE', 'CLASS AVG.', 'POSITION'];
$header_width = 8; // Width for each rotated header column.

// Loop through rotated headers to draw cells and rotated text.
foreach ($rotated_headers as $index => $header) {
    $x_pos = $x_start + ($index * $header_width);
    $pdf->Cell($header_width, 25, '', 1, 0, 'C', true); // Draw empty cell with border and background.
    $pdf->RotatedText($x_pos + 6, $y_start + 23, $header, 90); // Draw rotated text.
}

$pdf->Cell(40, 25, 'REMARK', 1, 0, 'C', true); // Remark column header.
$pdf->Ln(); // Move to the next line after header.

// --- Add Student Results Data ---
$pdf->SetFont('Arial', '', 8); // Set font for result data.
// Fetch all subject results for the student, current term, and session from 'mastersheet'.
$results_result = $conn->query("SELECT * FROM mastersheet WHERE id = '$student_id' AND term = '$term' AND csession = '$curr_session'");

// Fetch class averages for each subject to display 'CLASS AVG.'.
$subject_averages_result = $conn->query("
    SELECT subject, AVG(total) AS avg_score
    FROM mastersheet
    WHERE class = '{$student_details['class']}' AND term = '$term' AND csession = '$curr_session'
    GROUP BY subject
");

$subject_averages = [];
// Populate an associative array with subject names and their average scores.
while ($avg_row = $subject_averages_result->fetch_assoc()) {
    $subject_averages[$avg_row['subject']] = ceil($avg_row['avg_score']); // Round up class average.
}

$total_average = 0; // Initialize total average for overall calculation.
$num_subjects = 0;  // Initialize subject counter.

// Loop through each subject result and add it to the PDF table.
while ($row = $results_result->fetch_assoc()) {
    $subject = $row['subject'];
    // Get class average for the current subject, or '-' if not found.
    $avg_score = isset($subject_averages[$subject]) ? $subject_averages[$subject] : '-';

    // Output each cell with subject details and scores.
    $pdf->Cell(80, 5, $subject, 1, 0);
    $pdf->Cell(8, 5, $row['ca1'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['ca2'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['exam'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['lastcum'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['total'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['average'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['grade'], 1, 0, 'C');
    $pdf->Cell(8, 5, $avg_score, 1, 0, 'C');
    $pdf->Cell(8, 5, ordinal((int)$row['position']), 1, 0, 'C'); // Convert position to ordinal.
    $pdf->Cell(40, 5, $row['remark'], 1, 1, 'C');
    $total_average += $row['average']; // Add subject average to total.
    $num_subjects++;                   // Increment subject count.
}

// --- Calculate and Output Overall Average ---
// Calculate the overall average if there are subjects, otherwise set to '0.00'.
$overall_average = $num_subjects > 0 ? number_format($total_average / $num_subjects, 2) : '0.00';

$pdf->Ln(5); // Line break
$pdf->SetFont('Arial', 'B', 10); // Set font for overall average.
$pdf->Cell(190, 7, "Overall Average: $overall_average", 1, 1, 'C'); // Display overall average.

// --- Add Comments Section ---
$pdf->Ln(2); // Line break
$pdf->SetFont('Arial', 'I', 10); // Set font for comments.
$pdf->Cell(0, 5, $class_comments['comment'], 'B', 1, 'C'); // Display class teacher's comment.
$pdf->Cell(0, 5, "Class Teacher's Comment", 0, 1, 'C'); // Label for class teacher's comment.

$pdf->Ln(2); // Line break
$pdf->Cell(0, 5, $principal_comment['comment'], 'B', 1, 'C'); // Display principal's comment.
$pdf->Cell(0, 5, "Principal's Comment: ", 0, 1, 'C'); // Label for principal's comment.

// --- Add Principal's Signature ---
$pdf->Ln(3); // Line break
$pdf->SetX(-40); // Position for signature image.
$pdf->Image('assets/img/signature.jpg', $pdf->GetX(), $pdf->GetY(), 30); // Embed signature image.
$pdf->Ln(1); // Line break
$pdf->SetX(-30); // Position for signature label.
$pdf->Cell(10, -5, "Principal's Signature", 0, 1, 'C'); // Label for principal's signature.

// --- Grading Table ---
$pdf->Ln(7); // Line break
$pdf->SetFont('Arial', '', 11); // Set font for grading table title.
$pdf->Cell(60, 7, 'Grading Table', 1, 1, 'C', true); // Grading table title.
$pdf->SetFont('Arial', '', 10); // Set font for grading data.

// Define grading scale data.
$grading_data = [
    ['A', '75 - 100', 'Excellent'],
    ['B', '65 - 74', 'Very Good'],
    ['C', '50 - 64', 'Good'],
    ['D', '45 - 49', 'Fair'],
    ['E', '40 - 44', 'Poor'],
    ['F', '0 - 39', 'Very Poor']
];

// Loop through grading data and add rows to the PDF table.
foreach ($grading_data as $row) {
    $pdf->Cell(10, 6, $row[0], 1, 0, 'C'); // Grade letter.
    $pdf->Cell(20, 6, $row[1], 1, 0, 'C'); // Score range.
    $pdf->Cell(30, 6, $row[2], 1, 1, 'C'); // Remark.
}

// Output the generated PDF to the browser.
$pdf->Output();
// End output buffering and flush the output.
ob_end_flush();
?>
