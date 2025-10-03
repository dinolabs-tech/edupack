<?php
/**
 * admincheckresult.php
 *
 * This file generates a student's comprehensive academic result report in PDF format
 * for administrative review. It includes student personal details, subject-wise scores,
 * overall average, class teacher comments, principal comments, attendance records,
 * and a skills assessment. The report is generated using the FPDF library.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Custom FPDF class for consistent header, footer, and text rotation.
 * - Dynamic retrieval of student photo or a default image.
 * - Fetching and displaying student's academic performance data (CA1, CA2, Exam, Total, Average, Grade, Position).
 * - Calculating and displaying overall average.
 * - Displaying class teacher and principal comments.
 * - Including a grading table and a skills assessment table.
 * - Attendance tracking (days present, absent, school open days).
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
    $suffixes = ['th','st','nd','rd','th','th','th','th','th','th'];
    $v = $n % 100; // Get the last two digits
    // Special case for 11, 12, 13 which always use 'th'
    if ($v >= 11 && $v <= 13) return $n . 'th';
    // Use the last digit to determine the suffix
    return $n . $suffixes[$n % 10];
}

// Get the student ID from the URL query parameter.
$student_id = $_GET['student_id'];
// Construct the photo filename by replacing '/' with '_' in the student ID.
$photo_filename = str_replace('/', '_', $student_id);
$photo_path = "studentimg/{$photo_filename}.jpg";
// Check if the student's photo exists. If not, use a default image.
if (!file_exists($photo_path)) $photo_path = "studentimg/default.jpg";

/**
 * Custom PDF class extending FPDF to include custom header, footer, and text rotation.
 */
class MyPDF extends FPDF {
    protected $angle = 0; // Property to store the current rotation angle for text.
    public $studentImage; // Public property to hold the path to the student's image.

    /**
     * Overrides the default FPDF Header method to create a custom header for the report.
     * Includes school logo, school name, address, contact information, and a horizontal line.
     * Also places the student's photo in the top-right corner if available.
     */
    function Header() {
        $this->SetFont('Arial','B',10);
        $this->Image('assets/img/logo.png',10,8,20); // School logo
        // Student photo in the top-right corner
        if (!empty($this->studentImage) && file_exists($this->studentImage)) {
            $x = $this->GetPageWidth() - 30; // Calculate X position for right alignment
            $this->Image($this->studentImage, $x, 8, 20);
        }
        $this->Ln(5); // Line break
        // School Name and Address
        $this->SetFont('Arial','B',18);
        $this->Cell(0,5,'DINOLABS ACADEMY',0,1,'C');
        $this->SetFont('Arial','B',11);
        $this->Cell(0,5,'5th floor, Wing-B TISCO Building,Alagbaka,',0,1,'C');
        $this->Cell(0,5,'Akure, Ondo State, Nigeria.',0,1,'C');
        $this->Cell(0,5,'enquiries@dinolabstech.com',0,1,'C');
        $this->Cell(0,5,'+234-813-772-6887, +234-704-324-7461',0,1,'C');
        $this->Ln(5); // Line break
        // Horizontal line separator
        $this->Line(10, $this->GetY(), $this->GetPageWidth() - 10, $this->GetY());
        $this->Ln(5); // Line break after the line
    }

    /**
     * Overrides the default FPDF Footer method to create a custom footer for the report.
     * Displays the current date and time at the bottom of each page.
     */
    function Footer() {
        $this->SetY(-15); // Position at 1.5 cm from bottom
        $this->SetFont('Arial','I',8); // Set font for footer
        $this->Cell(100,10,date('d/m/Y'),0,0,'L'); // Date on the left
        $this->Cell(0,10,date('H:i:s'),0,0,'R'); // Time on the right
    }

    /**
     * Sets the rotation angle for subsequent text.
     *
     * @param float $angle The rotation angle in degrees.
     * @param float $x The X coordinate of the rotation center.
     * @param float $y The Y coordinate of the rotation center.
     */
    function Rotate($angle, $x=-1, $y=-1) {
        if ($x==-1) $x = $this->x;
        if ($y==-1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q'); // Restore previous state if already rotated
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI/180; // Convert to radians
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            // Apply rotation matrix
            $this->_out(sprintf('q %.2F %.2F %.2F %.2F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c,$s,-$s,$c,$cx,$cy, -$cx,-$cy));
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
        $this->Rotate($angle, $x, $y); // Apply rotation
        $this->Text($x, $y, $txt);     // Print text
        $this->Rotate(0);              // Reset rotation
    }
}

// Instantiate the custom PDF class.
$pdf = new MyPDF();
// Set the student image path for the PDF header.
$pdf->studentImage = $photo_path;
// Add the first page to the PDF document.
$pdf->AddPage();

// --- Fetch Student & Session Data ---
// Fetch student details from the 'students' table.
$sd = $conn->query("SELECT * FROM students WHERE id='$student_id'")->fetch_assoc();
// Fetch current term from 'currentterm' table.
$term = $conn->query("SELECT cterm FROM currentterm WHERE id=1")->fetch_assoc()['cterm'];
// Fetch current session from 'currentsession' table.
$session = $conn->query("SELECT csession FROM currentsession WHERE id=1")->fetch_assoc()['csession'];

// --- Fetch Comments and Next Term ---
// Fetch class teacher comments. If no comment is found, an empty array is returned.
$cc = $conn->query("SELECT * FROM classcomments WHERE id='$student_id' AND term='$term' AND csession='$session'")->fetch_assoc() ?: [];
// Fetch principal's comment. If no comment is found, default to 'No comment'.
$pc = $conn->query("SELECT comment FROM principalcomments WHERE id='$student_id' AND term='$term' AND csession='$session'")->fetch_assoc()['comment'] ?? 'No comment';
// Fetch next term start date.
$next = $conn->query("SELECT Next FROM nextterm WHERE id=1")->fetch_assoc()['Next'];
// $promotec = $conn->query("SELECT comment FROM promote WHERE id='$student_id' AND term='$term' AND csession='$session'")->fetch_assoc()['comment'] ?? 'N/A'; // Commented out, likely unused.

// --- Attendance Data ---
// Calculate total days school was open for the student's class and arm.
$open = $conn->query("SELECT COUNT(DISTINCT date) AS op FROM attendance WHERE class='{$sd['class']}' AND arm='{$sd['arm']}' AND term_id='$term' AND session_id='$session'")->fetch_assoc()['op'];
// Calculate days present and absent for the student.
$att = $conn->query("SELECT SUM(status) AS pres, COUNT(DISTINCT date)-SUM(status) AS abs FROM attendance WHERE student_id='$student_id' AND term_id='$term' AND session_id='$session'")->fetch_assoc();
$pres = $att['pres'] ?: 0; // Days present, default to 0 if null.
$abs = $att['abs'] ?: 0;   // Days absent, default to 0 if null.

// --- Header Information on PDF ---
$pdf->SetFont('Arial','',10);
$pdf->Cell(95,7,"Name: {$sd['name']}", 'B',0);
$pdf->Cell(95,7,"SchlOpen: $open", 'B',1);
$pdf->Cell(95,7,"Class: {$sd['class']} {$sd['arm']}", 'B',0);
$pdf->Cell(95,7,"Days Absent: $abs", 'B',1);
$pdf->Cell(95,7,"Term: $term", 'B',0);
$pdf->Cell(95,7,"Days Present: $pres", 'B',1);
$pdf->Cell(95,7,"Session: $session", 'B',0);
$pdf->Cell(95,7,"Next Term: $next", 'B',1);
$pdf->Ln(5); // Line break

// --- Results Table Header ---
$pdf->SetFillColor(90,174,255); // Set background color for header cells.
$pdf->SetFont('Arial','B',9); // Set font for header.
$pdf->Cell(80,25,'SUBJECT',1,0,'C',true); // Subject column header.
$x0 = $pdf->GetX(); $y0 = $pdf->GetY(); // Store current X and Y for rotated text positioning.
// Define column headers for scores and other metrics.
$cols=['CA1','CA2','EXAM','LAST CUM','TOTAL','AVERAGE','GRADE','CLASS AVG.','POSITION'];
// Loop through columns to draw cells and rotated text.
foreach($cols as $i=>$h) {
    $pdf->Cell(8,25,'',1,0,'C',true); // Draw empty cell with border and background.
    $pdf->RotatedText($x0+$i*8+6, $y0+23, $h, 90); // Draw rotated text.
}
$pdf->Cell(40,25,'REMARK',1,1,'C',true); // Remark column header.

// --- Fetch & Render Results Data ---
$pdf->SetFont('Arial','',8); // Set font for result data.
// Fetch all subject results for the student, current term, and session from 'mastersheet'.
$res = $conn->query("SELECT * FROM mastersheet WHERE id='$student_id' AND term='$term' AND csession='$session'");
// Fetch class averages for each subject to display 'CLASS AVG.'.
$avg = $conn->query("SELECT subject,AVG(total) AS avg_score FROM mastersheet WHERE class='{$sd['class']}' AND term='$term' AND csession='$session' GROUP BY subject");
$avgC = [];
// Populate an associative array with subject names and their average scores.
while($r=$avg->fetch_assoc()) $avgC[$r['subject']] = ceil($r['avg_score']);
$sum=0; $cnt=0; // Initialize sum of averages and subject count for overall average calculation.
// Loop through each subject result and add it to the PDF table.
while($r=$res->fetch_assoc()) {
    $pdf->Cell(80,5,$r['subject'],1,0); // Subject name.
    // Output each score/grade column.
    foreach(['ca1','ca2','exam','lastcum','total','average','grade'] as $c) {
        $pdf->Cell(8,5,$r[$c],1,0,'C');
    }
    $pdf->Cell(8,5,$avgC[$r['subject']]?:'-',1,0,'C'); // Class average for the subject.
    $pdf->Cell(8,5,ordinal((int)$r['position']),1,0,'C'); // Student's position in class (ordinal).
    $pdf->Cell(40,5,$r['remark'],1,1,'C'); // Remark for the subject.
    $sum += $r['average']; $cnt++; // Accumulate average and count subjects.
}

// --- Overall Average ---
// Calculate the overall average if there are subjects, otherwise set to '0.00'.
$overall = $cnt?number_format($sum/$cnt,2):'0.00';
$pdf->Ln(5); // Line break
$pdf->SetFont('Arial','B',10); // Set font for overall average.
$pdf->Cell(190,7,"Overall Average: $overall",1,1,'C'); // Display overall average.

// --- Comments Section ---
$pdf->Ln(2); // Line break
$pdf->SetFont('Arial','I',10); // Set font for comments.
$pdf->Cell(0,5,$cc['comment']??'','B',1,'C'); // Display class teacher's comment.
$pdf->Cell(0,5,"Class Teacher's Comment",0,1,'C'); // Label for class teacher's comment.
$pdf->Ln(2); // Line break
$pdf->Cell(0,5,$pc,'B',1,'C'); // Display principal's comment.
$pdf->Cell(0,5,"Principal's Comment",0,1,'C'); // Label for principal's comment.

// --- Principal's Signature ---
$pdf->Ln(3); // Line break
$pdf->SetX(-40); // Position for signature image.
$pdf->Image('assets/img/signature.jpg',$pdf->GetX(),$pdf->GetY(),30); // Embed signature image.
$pdf->Ln(1); // Line break
$pdf->SetX(-30); // Position for signature label.
$pdf->Cell(10,-5,"Principal's Signature",0,1,'C'); // Label for principal's signature.

// --- Side-by-Side Tables (Grading and Skills Assessment) ---
$pdf->Ln(7); // Line break
$pdf->SetFont('Arial','B',10); // Set font for table titles.
$startX=$pdf->GetX(); $startY=$pdf->GetY(); // Store current X and Y for table positioning.
$pdf->SetXY($startX,$startY);
$pdf->Cell(60,7,'Grading Table',1,0,'C',true); // Grading table title.
$secondX=$startX+65; // Calculate X position for the second table.
$pdf->SetXY($secondX,$startY);
$pdf->Cell(90,7,'Skills Assessment',1,1,'C',true); // Skills assessment table title.

$pdf->SetFont('Arial','',10); // Set font for table data.
$startY+=7; // Adjust Y position for table content.
// Define grading scale data.
$grading=[['A','75-100','Excellent'],['B','65-74','Very Good'],['C','50-64','Good'],['D','45-49','Fair'],['E','40-44','Poor'],['F','0-39','Very Poor']];
// Define skills assessment data, retrieving values from class comments or defaulting to 'N/A'.
$skills=[
    ['Attentiveness',$cc['attentiveness']??'N/A','Relationship',$cc['relationship']??'N/A'],
    ['Neatness',$cc['neatness']??'N/A','Handwriting',$cc['handwriting']??'N/A'],
    ['Politeness',$cc['politeness']??'N/A','Music',$cc['music']??'N/A'],
    ['Self-Control',$cc['selfcontrol']??'N/A','Club/Society',$cc['club']??'N/A'],
    ['Punctuality',$cc['punctuality']??'N/A','Sport',$cc['sport']??'N/A']
];
$rows = max(count($grading), count($skills)); // Determine the maximum number of rows needed for both tables.
// Loop to draw rows for both tables side-by-side.
for($i=0;$i<$rows;$i++){
    $pdf->SetXY($startX,$startY); // Position for the grading table.
    if(isset($grading[$i])){
        $pdf->Cell(10,6,$grading[$i][0],1,0,'C');
        $pdf->Cell(20,6,$grading[$i][1],1,0,'C');
        $pdf->Cell(30,6,$grading[$i][2],1,0,'C');
    } else {
        // Draw empty cells if no more grading data to maintain table structure.
        $pdf->Cell(10,6,'',1,0);
        $pdf->Cell(20,6,'',1,0);
        $pdf->Cell(30,6,'',1,0);
    }
    if(isset($skills[$i])){
        $pdf->SetXY($secondX,$startY); // Position for the skills assessment table.
        $pdf->Cell(30,6,$skills[$i][0],1,0,'C');
        $pdf->Cell(15,6,$skills[$i][1],1,0,'C');
        $pdf->Cell(30,6,$skills[$i][2],1,0,'C');
        $pdf->Cell(15,6,$skills[$i][3],1,1,'C');
    } else {
        // If no more skills data, move to the next line to align with grading table.
        $pdf->Ln(6);
    }
    $startY+=6; // Increment Y position for the next row.
}

// $pdf->SetFont('Arial','B',10); // Commented out, likely for a promotional status.
// $pdf->Cell(95,7,"Promotional Status: {$promotec}", 'B',0, 'C'); // Commented out, likely for a promotional status.

// Output the generated PDF to the browser.
$pdf->Output();
// End output buffering and flush the output.
ob_end_flush();
?>
