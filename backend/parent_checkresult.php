<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include FPDF library
require('includes/fpdf.php');
// Database connection
include 'db_connection.php';

/**
 * Convert an integer into its ordinal representation.
 * E.g. 1→"1st", 2→"2nd", 3→"3rd", 11→"11th", etc.
 */
function ordinal(int $n): string
{
    $suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    $v = $n % 100;
    if ($v >= 11 && $v <= 13) {
        return $n . 'th';
    }
    return $n . $suffixes[$n % 10];
}

// Get student ID from URL (e.g., WF/944/24)
$student_id = $_GET['student_id'];
$term = $_GET['term'];
$session = $_GET['session'];

// Construct the photo filename (e.g., WF_944_24.jpg)
$photo_filename = str_replace('/', '_', $student_id);
$photo_path = "studentimg/" . $photo_filename . ".jpg";

// Use default image if the student photo doesn’t exist
if (!file_exists($photo_path)) {
    $photo_path = "studentimg/default.jpg";
}

// Custom PDF class
class MyPDF extends FPDF
{
    protected $angle = 0;
    public $studentImage; // Match chckresult.php property name

    // Header
    function Header()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Image('assets/img/logo.png', 10, 8, 20);

        // Student photo in the top-right corner
        if (!empty($this->studentImage) && file_exists($this->studentImage)) {
            $x = $this->GetPageWidth() - 10 - 20; // Right margin (10mm) + image width (20mm)
            $this->Image($this->studentImage, $x, 8, 20);
        }

        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 5, 'DINOLABS ACADEMY', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, '5th Floor Wing-B, Tisco Building,', 0, 1, 'C');
        $this->Cell(0, 5, 'Akure, Ondo State, Nigeria.', 0, 1, 'C');
        $this->Cell(0, 5, 'enquiries@dinolabstech.com', 0, 1, 'C');
        $this->Cell(0, 5, '+234-704-324-7461', 0, 1, 'C');
        $this->Ln(5);

        $x1 = 10;
        $x2 = $this->GetPageWidth() - 10;
        $y = $this->GetY();
        $this->Line($x1, $y, $x2, $y);
        $this->Ln(5);
    }

    // Footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $date = date('d/m/Y');
        $time = date('H:i:s');
        $this->Cell(100, 10, $date, 0, 0, 'L');
        $this->Cell(0, 10, $time, 0, 0, 'R');
    }

    // Rotate function
    function Rotate($angle, $x = -1, $y = -1)
    {
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

    function RotatedText($x, $y, $txt, $angle)
    {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}

// Start output buffering
ob_start();

// Create PDF instance and set photo path
$pdf = new MyPDF();
$pdf->studentImage = $photo_path;
$pdf->AddPage();

// Fetch student details
$student_details_result = $conn->query("SELECT * FROM students WHERE id = '$student_id'");
$student_details = $student_details_result->fetch_assoc();

// Fetch current term and session
//$current_term_result = $conn->query("SELECT * FROM currentterm WHERE id = 1");
//$current_term = $current_term_result->fetch_assoc();
//$term = $current_term['cterm'];

//$current_session_result = $conn->query("SELECT * FROM currentsession WHERE id = 1");
//$current_session = $current_session_result->fetch_assoc();
//$curr_session = $current_session['csession'];

// Fetch class comments
$class_comments_result = $conn->query("SELECT * FROM classcomments WHERE id = '$student_id' AND term = '$term' AND csession = '$session'");
$class_comments = $class_comments_result->num_rows > 0 ? $class_comments_result->fetch_assoc() : [
    'schlopen' => 'N/A',
    'daysabsent' => 'N/A',
    'dayspresent' => 'N/A',
    'comment' => 'No comment available'
];

// Fetch principal comment
$principal_comments_result = $conn->query("SELECT comment FROM principalcomments WHERE id = '$student_id' AND term = '$term' AND csession = '$session'");
$principal_comment = $principal_comments_result->num_rows > 0 ? $principal_comments_result->fetch_assoc() : ['comment' => 'No comment available'];

// Fetch next term
$next_term_result = $conn->query("SELECT Next FROM nextterm WHERE id = 1");
$next_term = $next_term_result->fetch_assoc()['Next'];
// $promotec = $conn->query("SELECT comment FROM promote WHERE id='$student_id' AND term='$term' AND csession='$session'")->fetch_assoc()['comment'] ?? 'N/A';

// Add student info to PDF
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(95, 7, "Name: " . $student_details['name'], 'B', 0);
$pdf->Cell(95, 7, "SchlOpen: " . $class_comments['schlopen'], 'B', 1);
$pdf->Cell(95, 7, "Class: " . $student_details['class'] . " " . $student_details['arm'], 'B', 0);
$pdf->Cell(95, 7, "Days Absent: " . $class_comments['daysabsent'], 'B', 1);
$pdf->Cell(95, 7, "Term: " . $term, 'B', 0);
$pdf->Cell(95, 7, "Days Present: " . $class_comments['dayspresent'], 'B', 1);
$pdf->Cell(95, 7, "Session: " . $session, 'B', 0);
$pdf->Cell(95, 7, "Next Term: " . $next_term, 'B', 1);
$pdf->Ln(5);

// Results table header
$pdf->SetFillColor(90, 174, 255);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 25, 'SUBJECT', 1, 0, 'C', true);

$x_start = $pdf->GetX();
$y_start = $pdf->GetY();
$rotated_headers = ['CA1', 'CA2', 'EXAM', 'LAST CUM', 'TOTAL', 'AVERAGE', 'GRADE', 'CLASS AVG.', 'POSITION'];
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
$results_result = $conn->query("SELECT * FROM mastersheet WHERE id = '$student_id' AND term = '$term' AND csession = '$session'");

$subject_averages_result = $conn->query("
    SELECT subject, AVG(total) AS avg_score 
    FROM mastersheet 
    WHERE class = '{$student_details['class']}' AND term = '$term' AND csession = '$session'
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
    $pdf->Cell(80, 5, $subject, 1, 0);
    $pdf->Cell(8, 5, $row['ca1'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['ca2'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['exam'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['lastcum'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['total'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['average'], 1, 0, 'C');
    $pdf->Cell(8, 5, $row['grade'], 1, 0, 'C');
    $pdf->Cell(8, 5, $avg_score, 1, 0, 'C');
    $pdf->Cell(8, 5, ordinal((int)$row['position']), 1, 0, 'C');
    $pdf->Cell(40, 5, $row['remark'], 1, 1, 'C');
    $total_average += $row['average'];
    $num_subjects++;
}

// Calculate overall average
$overall_average = $num_subjects > 0 ? number_format($total_average / $num_subjects, 2) : '0.00';

// Output overall average
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 7, "Overall Average: $overall_average", 1, 1, 'C');

// Add comments
$pdf->Ln(2);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 5, $class_comments['comment'], 'B', 1, 'C');
$pdf->Cell(0, 5, "Class Teacher's Comment", 0, 1, 'C');

$pdf->Ln(2);
$pdf->Cell(0, 5, $principal_comment['comment'], 'B', 1, 'C');
$pdf->Cell(0, 5, "Principal's Comment: ", 0, 1, 'C');

// Add principal's signature
$pdf->Ln(3);
$pdf->SetX(-40);
$pdf->Image('assets/img/signature.jpg', $pdf->GetX(), $pdf->GetY(), 30);
$pdf->Ln(1);
$pdf->SetX(-30);
$pdf->Cell(10, -5, "Principal's Signature", 0, 1, 'C');

// Grading table
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
    $pdf->Cell(10, 6, $row[0], 1, 0, 'C');
    $pdf->Cell(20, 6, $row[1], 1, 0, 'C');
    $pdf->Cell(30, 6, $row[2], 1, 1, 'C');
}

// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(95,7,"Promotional Status: {$promotec}", 'B',0, 'C');

// Output the PDF
$pdf->Output();
ob_end_flush();
?>
