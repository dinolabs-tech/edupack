<?php
/**
 * checkresult (without attendance feature).php
 *
 * This file generates a result slip for a student, displaying their academic performance
 * for a specific term and session. It retrieves student details, subject scores,
 * and comments from the database and presents them in a PDF format using the FPDF library.
 * This version excludes attendance information.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Retrieval of student details, scores, and comments.
 * - Dynamic generation of a PDF result slip with student information, subject scores,
 *   overall average, and comments.
 * - Custom PDF class for consistent header, footer, and text rotation.
 */

// Start or resume a session. This is crucial for checking user login status.
session_start();

// Check if the user is logged in. If not, redirect them to the login page
// to ensure only authenticated users can access this result generation.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if session and term are set in the GET request.
if (isset($_GET['session']) && isset($_GET['term'])) {
    $csession = $_GET['session']; // Academic session (e.g., 2024/2025).
    $currentterm = $_GET['term'];   // Academic term (e.g., 1st Term).
    $term = $currentterm;           // Set $term to the value of $currentterm for consistency.
} else {
    // If session or term are not set, redirect to the login page.
    header('Location: login.php');
    exit();
}

// Includes the FPDF library for PDF generation and the database connection file.
require('includes/fpdf.php');
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
    $v = $n % 100;
    // Special rule for 11,12,13
    if ($v >= 11 && $v <= 13) {
        return $n . 'th';
    }
    return $n . $suffixes[$n % 10];
}

// Get the user ID from the session to identify the student.
$user_id = $_SESSION['user_id'];

/**
 * Custom PDF class extending FPDF to include custom header, footer, and a property for the student image.
 */
class PDF extends FPDF {
    public $studentImage; // Path to the student's image.
    protected $angle = 0; // Initialize the angle property for text rotation.

    /**
     * Overrides the default FPDF Header method to create a custom header for the report.
     * Includes school logo, student image, school name, address, and contact information.
     */
    function Header() {
        // Set font for the header.
        $this->SetFont('Arial', 'B', 10);

        // Add school logo on the far left.
        $this->Image('assets/img/logo.png', 10, 8, 20);  // Adjust position and size as needed

        // Add student image on the top right if available.
        if (isset($this->studentImage)) {
            $x = $this->GetPageWidth() - 10 - 20; // right margin (10) + image width (20)
            $this->Image($this->studentImage, $x, 8, 20);
        }

        // School name (Centered).
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 5, 'HAPA COLLEGE', 0, 1, 'C');

        $this->SetFont('Arial', 'B', 11);
        // School address (Centered).
        $this->Cell(0, 5, 'KM 3, Akure Owo Express Road, Oba Ile,', 0, 1, 'C');
        $this->Cell(0, 5, 'Akure, Ondo State, Nigeria.', 0, 1, 'C');

        // School email (Centered).
        $this->Cell(0, 5, 'hapacollege2013@yahoo.com', 0, 1, 'C');

        // School mobile (Centered).
        $this->Cell(0, 5, '+234-803-504-2727, +234-803-883-8583', 0, 1, 'C');

        $this->Ln(5); // Space after header

        // Draw a horizontal line across the page.
        $x1 = 10;
        $x2 = $this->GetPageWidth() - 10;
        $y = $this->GetY();
        $this->Line($x1, $y, $x2, $y);

        $this->Ln(5);
    }

    /**
     * Overrides the default FPDF Footer method to create a custom footer for the report.
     * Displays the current date and time at the bottom of each page.
     */
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);

        // Current date and time
        $date = date('d/m/Y');
        $time = date('H:i:s');

        // Date on the left
        $this->Cell(100, 10, $date, 0, 0, 'L');
        // Time on the right
        $this->Cell(0, 10, $time, 0, 0, 'R');
    }

    /**
     * Sets the rotation angle for subsequent text.
     *
     * @param float $angle The rotation angle in degrees.
     * @param float $x The X coordinate of the rotation center.
     * @param float $y The Y coordinate of the rotation center.
     */
    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
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
    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}

// Start output buffering to prevent any premature output before PDF generation.
ob_start();

// Query to get the student details from mastersheet
$result = $conn->query("SELECT * FROM mastersheet WHERE id = '$user_id' and term = '$term' and csession = '$csession'");
$student_details = $result->fetch_assoc();

// Query to get student info from the students table
$result = $conn->query("SELECT * FROM students WHERE id = '$user_id'");
$student_photo = $result->fetch_assoc();

// Query for class comments and principal comments
$class_comments_result = $conn->query("SELECT * FROM classcomments WHERE id = '$user_id' and term = '$term' and csession = '$csession'");
$class_comments = $class_comments_result->fetch_assoc();

$principal_comments_result = $conn->query("SELECT comment FROM principalcomments WHERE id = '$user_id' and term = '$term' and csession = '$csession'");
$principal_comment = $principal_comments_result->fetch_assoc();

$next_term_result = $conn->query("SELECT Next FROM nextterm WHERE id = 1");
$next_term = $next_term_result->fetch_assoc()['Next'];

// Create the PDF
$pdf = new PDF();

// Get the student image using your filename method
$photo_filename = str_replace('/', '_', $student_photo['id']);  // e.g., wf_1000_24
$photo_path = "studentimg/" . $photo_filename . ".jpg";
if (!file_exists($photo_path)) {
    $photo_path = "studentimg/default.jpg"; // Fallback to default image
}
$pdf->studentImage = $photo_path;

$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// First row (Name / SchlOpen)
$pdf->Cell(95, 7, "Name:      " . htmlspecialchars($student_photo['name']), 'B', 0);
$pdf->Cell(10, 7, "", 0, 0);  // Add an empty cell to create extra space
$pdf->Cell(85, 7, "SchlOpen:      " . htmlspecialchars($class_comments['schlopen']), 'B', 1);

// Second row (Class / Days Absent)
$pdf->Cell(95, 7, "Class:      " . htmlspecialchars($student_photo['class']) . " " . htmlspecialchars($student_photo['arm']), 'B', 0);
$pdf->Cell(10, 7, "", 0, 0);
$pdf->Cell(85, 7, "Days Absent:  " . htmlspecialchars($class_comments['daysabsent']), 'B', 1);

// Third row (Term / Days Present)
$pdf->Cell(95, 7, "Term:      " . htmlspecialchars($term), 'B', 0);
$pdf->Cell(10, 7, "", 0, 0);
$pdf->Cell(85, 7, "Days Present: " . htmlspecialchars($class_comments['dayspresent']), 'B', 1);

// Fourth row (Session / Next Term)
$pdf->Cell(95, 7, "Session:  " . htmlspecialchars($csession), 'B', 0);
$pdf->Cell(10, 7, "", 0, 0);
$pdf->Cell(85, 7, "Next Term:      " . htmlspecialchars($next_term), 'B', 1);

$pdf->Ln(5);

// Set background color to gray for the results table header
$pdf->SetFillColor(90,174,255);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 25, 'SUBJECT', 1, 0, 'C', true);
// $pdf->Cell(10, 25, 'CA1', 1, 0, 'C', true);

// Rotated headers for remaining columns
$x_start = $pdf->GetX();
$y_start = $pdf->GetY();
$rotated_headers = ['CA1','CA2','EXAM', 'LAST CUM', 'TOTAL', 'AVERAGE', 'GRADE','CLASS AVG.', 'POSITION'];
$header_width = 8;

foreach ($rotated_headers as $index => $header) {
    $x_pos = $x_start + ($index * $header_width);
    $pdf->Cell($header_width, 25, '', 1, 0, 'C', true);
    $pdf->RotatedText($x_pos + 6, $y_start + 23, $header, 90);
}

$pdf->Cell(40, 25, 'REMARK', 1, 0, 'C', true);
$pdf->Ln();

// Add student results data
$pdf->SetFont('Arial', '', 8);
$results_result = $conn->query("SELECT * FROM mastersheet WHERE id = '$user_id' AND term = '$term' AND csession = '$csession'");

// Fetch class average scores for each subject
$subject_averages_result = $conn->query("
    SELECT subject, AVG(total) AS avg_score
    FROM mastersheet
    WHERE class = '{$student_details['class']}' AND term = '$term' AND csession = '$csession'
    GROUP BY subject
");

$subject_averages = [];
while ($avg_row = $subject_averages_result->fetch_assoc()) {
    $subject_averages[$avg_row['subject']] = ceil($avg_row['avg_score']);
}

$total_average = 0;
$num_subjects = 0;

while ($row = $results_result->fetch_assoc()) {
    $subject = $row['subject'];
    $avg_score = isset($subject_averages[$subject]) ? $subject_averages[$subject] : '-';

    $pdf->Cell(80, 5, htmlspecialchars($subject), 1, 0);
    $pdf->Cell(8, 5, htmlspecialchars($row['ca1']), 1, 0, 'C');
    $pdf->Cell(8, 5, htmlspecialchars($row['ca2']), 1, 0, 'C');
    $pdf->Cell(8, 5, htmlspecialchars($row['exam']), 1, 0, 'C');
    $pdf->Cell(8, 5, htmlspecialchars($row['lastcum']), 1, 0, 'C');
    $pdf->Cell(8, 5, htmlspecialchars($row['total']), 1, 0, 'C');
    $pdf->Cell(8, 5, htmlspecialchars($row['average']), 1, 0, 'C');
    $pdf->Cell(8, 5, htmlspecialchars($row['grade']), 1, 0, 'C');
    $pdf->Cell(8, 5, htmlspecialchars($avg_score), 1, 0, 'C');
    $pdf->Cell(8,5,ordinal((int)$row['position']),1,0,'C');
    $pdf->Cell(40, 5, htmlspecialchars($row['remark']), 1, 1, 'C');

    $total_average += $row['average'];
    $num_subjects++;
}

if ($num_subjects > 0) {
    $overall_average = number_format($total_average / $num_subjects, 2);
} else {
    $overall_average = '0.00';
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 7, "Overall Average: ".htmlspecialchars($overall_average), 1, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 5, htmlspecialchars($class_comments['comment']), 'B', 1, 'C');
$pdf->Cell(0, 5, "Class Teacher's Comment", 0, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 5, htmlspecialchars($principal_comment['comment']), 'B', 1, 'C');
$pdf->Cell(0, 5, "Principal's Comment: ", 0, 1, 'C');

$pdf->Ln(3);
$pdf->Cell(10, 2, '', 0, 0);
$pdf->SetX(-40);
$pdf->Image('assets/img/signature.jpg', $pdf->GetX(), $pdf->GetY(), 30);
$pdf->Ln(1);
$pdf->SetX(-30);
$pdf->Cell(10, -5, 'Principal`s Signature', 0, 1, 'C');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 7, 'Grading Table', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$grading_data = [
    ['A', '75 - 100', 'Excellent'],
    ['B', '65 - 74', 'Very Good'],
    ['C', '50 - 64', 'Good'],
    ['D', '45 - 49', 'Fair'],
    ['E', '40 - 44', 'Poor'],
    ['F', '0 - 39', 'Very Poor']
];

foreach ($grading_data as $row) {
    $pdf->Cell(10, 6, htmlspecialchars($row[0]), 1, 0, 'C');
    $pdf->Cell(20, 6, htmlspecialchars($row[1]), 1, 0, 'C');
    $pdf->Cell(30, 6, htmlspecialchars($row[2]), 1, 1, 'C');
}

$pdf->Output();
ob_end_flush();
?>
