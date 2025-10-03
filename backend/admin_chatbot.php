<?php
/**
 * admin_chatbot.php
 *
 * This file implements a backend logic for an administrative chatbot that provides
 * academic performance analysis for students. It retrieves student scores from the
 * 'mastersheet' table for the current term and generates a personalized response
 * including overall average, suggestions for low-scoring subjects, and commendations
 * for high-scoring subjects.
 *
 * Key functionalities include:
 * - Database connection.
 * - Dynamic retrieval of the current academic term.
 * - Fetching student's subject-wise scores (CA1, CA2, Exam, Average).
 * - Calculating overall average score.
 * - Identifying subjects with low scores (<= 50) and high scores (>= 80).
 * - Generating a conversational response using predefined arrays of introductions,
 *   suggestions, and commendations, tailored to the student's performance.
 * - Error handling for database queries and missing student ID.
 */

// Include the database connection settings. This file should establish a connection
// to the MySQL database and make the $conn object available.
include('db_connection.php');

// Retrieve the student ID from the GET request.
// The trim() function removes whitespace from the beginning and end of the string.
// If 'student_id' is not set, it defaults to an empty string.
$student_id = isset($_GET['student_id']) ? trim($_GET['student_id']) : '';

// Array of random introduction paragraphs for the chatbot's response.
// These are used to start the performance summary in a varied and engaging way.
$intros = array(
    "I've analyzed the student's academic performance.",
    "Here's the student's performance summary.",
    "Analysis complete for the student's results.",
    "Reviewing the student's academic data yields the following.",
    "Great news! Here are the student's performance details.",
    "All set! Here's how the student performed.",
    "I've compiled the student's academic report.",
    "Here are the student's academic results.",
    "The student's performance overview is ready.",
    "I've just finished analyzing the student's results.",
    "Here's a quick look at the student's scores.",
    "I've calculated the student's performance metrics.",
    "Here's how the student did this term.",
    "A summary of the student's academic performance is here.",
    "Take a look at the student's results.",
    "Here's the breakdown of the student's scores.",
    "I've pulled up the student's results.",
    "Academic insights for the student are ready.",
    "Explore the student's academic performance.",
    "Here's the detailed academic report for the student.",
    "The student's academic record is now available.",
    "Here's the assessment summary for the student.",
    "The student's results have been reviewed.",
    "Academic analysis for the student is complete.",
    "Here's the evaluation of the student's performance.",
    "Insights into the student's performance are here.",
    "I've summarized the student's academic data.",
    "A performance review for the student is ready.",
    "I've assessed the student's scores.",
    "Here's the overview of the student's grades.",
    "I've processed the student's academic data.",
    "Summary of the student's grades is ready.",
    "I've inspected the student's academic performance.",
    "Here are the highlights of the student's scores.",
    "I've prepared the student's performance summary.",
    "Here is the concise report for the student.",
    "I've reviewed and summarized the student's results.",
    "Here is the quick summary of the student's performance.",
    "I've completed the grading overview for the student.",
    "Here's what the student scored.",
    "I’ve compiled a brief report on the student's performance.",
    "Results have been gathered for the student.",
    "I've finalized the student's performance data.",
    "Here are the findings for the student's performance.",
    "I've curated the student's academic report.",
    "Here's the performance insight for the student.",
    "I've done a performance check for the student.",
    "Here is the student's report.",
    "I've wrapped up the score analysis for the student.",
    "Here is the assessment breakdown for the student.",
    "I've collected the student's academic statistics.",
    "Here are the student's academic stats.",
    "I've aggregated the student's performance metrics.",
    "Here is the grading summary for the student.",
    "I've extracted the student's results.",
    "Here is the detailed breakdown for the student.",
    "I've generated the student's performance report.",
    "Here is the student's term performance.",
    "Review of the student's grades is complete.",
    "Analytics on the student's performance are here.",
    "Here are the performance analytics for the student.",
    "I've assessed the student's academic standing.",
    "An academic summary for the student is ready.",
    "I've prepped the student's score evaluation.",
    "Here is the academic feedback for the student.",
    "I've compiled the grade overview for the student.",
    "Here is the evaluation summary for the student.",
    "I've summarized the scoring details for the student.",
    "Here is the performance outline for the student.",
    "I've delivered the academic recap for the student.",
    "Here is the concise performance summary for the student.",
    "I've outlined the student's academic results.",
    "Here is the quick performance overview for the student.",
    "I've reported on the student's academic standing.",
    "Here is the sectional performance for the student.",
    "I've posted the student's academic data.",
    "Here is the performance snapshot for the student.",
    "I've checked the student's grades.",
    "Here is the grade summary for the student.",
    "I've done a quick grade check for the student.",
    "Here is the subject-wise report for the student.",
    "I've fetched the student's latest grades.",
);

// Array of random suggestion paragraphs for subjects where the student scored low (<= 50).
// The '%s' placeholder will be replaced with the subject name(s).
$suggestions = array(
    'Please encourage the student to deepen their understanding of %s. Stay curious and keep improving!',
    'The student deserves more attention in %s. Your guidance can inspire them to keep going.',
    'The student could benefit from additional practice in %s. Your support today shapes tomorrow’s success.',
    'Please prompt the student to revisit %s. Keep pushing them forward—they’re making progress every day.',
    'Advise the student to refine their approach to %s. Learning is a journey, and they’re on the right track.',
    'Encourage the student to zero in on %s. Each practice session brings them closer to mastery.',
    'The student could use some extra focus in %s. Step by step, they are achieving milestones.',
    'Suggest the student put more energy into %s. Great things take time—remind them to stay patient.',
    'Urge the student to sharpen their understanding of %s. Their efforts today will pay off.',
    'Recommend the student to strengthen their skills in %s. Your dedication as a teacher is crucial.',
    'Ask the student to concentrate on %s. Encourage persistence and positivity in your feedback.',
    'Highlight %s as an area for the student to excel. Your guidance can light their path.',
    'Encourage the student to practice more %s. Your support can help build their confidence.',
    'Remind the student that %s is key to their overall progress. Offer extra resources if possible.',
    'Suggest the student allocate time for %s. Your expertise can make a real difference.',
    'Recommend the student to break down %s into smaller tasks. Guide them with clear steps.',
    'Encourage the student to ask for help in %s when needed. Foster a growth mindset.',
    'Advise the student to review %s regularly. Consistency is the secret to improvement.',
    'Suggest the student set goals for %s. Help them track progress and celebrate wins.',
    'Encourage the student to engage more with %s. Interactive activities can boost understanding.',
    'Highlight the importance of mastering %s for the student’s future. Show real-world applications.',
    'Recommend targeted exercises for %s. Personalized practice can accelerate learning.',
    'Remind the student that practice in %s builds strong foundations. Encourage steady effort.',
    'Encourage the student to use additional study materials for %s. Recommend reliable resources.',
    'Ask the student to self-reflect on their challenges in %s. Guide them to actionable solutions.',
    'Suggest group activities centered on %s. Peer collaboration can enhance learning.',
    'Recommend the student track their performance in %s. Data-driven insights drive growth.',
    'Encourage the student to leverage visual aids for %s. Charts and diagrams can clarify concepts.',
    'Highlight key %s topics for the student to focus on. Prioritize based on their weak areas.',
    'Suggest the student practice %s under timed conditions. Time management is a valuable skill.',
    'Recommend peer tutoring sessions for %s. Explaining concepts to others reinforces learning.',
    'Advise the student to interleave %s practice with other subjects. Variety improves retention.',
    'Encourage the student to regularly revisit %s content. Spaced repetition aids mastery.',
    'Highlight that progress in %s builds confidence. Recognize and reward improvements.',
    'Ask the student to set SMART goals for %s. Specific targets lead to focused efforts.',
    'Recommend the use of flashcards for %s. Active recall boosts memory.',
    'Encourage the student to teach %s concepts back to you. Teaching is the best test of understanding.',
    'Suggest the student create summary notes for %s. Condensing information aids comprehension.',
    'Highlight how %s skills apply beyond the classroom. Connect learning to real life.',
    'Recommend supplementary videos for %s concepts. Multimedia resources can enhance clarity.',
    'Encourage the student to practice %s problems daily. Regular practice cements skills.',
    'Ask the student to seek feedback on %s assignments. Constructive critique fuels improvement.',
    'Suggest the student outline their thought process in %s. Reflection sharpens reasoning.',
    'Recommend conceptual mapping for %s topics. Visual organization helps retention.',
    'Encourage the student to collaborate on %s projects. Teamwork fosters deeper understanding.',
    'Highlight the significance of %s in the broader curriculum. Foster a big-picture view.',
    'Suggest targeted revision sessions for %s. Focused review accelerates progress.',
    'Recommend the student benchmarks their %s progress. Milestones motivate consistent effort.',
    'Encourage the student to explore advanced %s challenges. Stretch goals build resilience.',
    'Advise the student to maintain a study journal for %s. Tracking reflections informs strategy.',
    'Suggest the student record themselves explaining %s. Verbalizing knowledge tests comprehension.',
    'Recommend the use of practice exams for %s. Simulating test conditions builds confidence.',
    'Encourage the student to prioritize %s in their study plan. Balanced scheduling is key.',
    'Ask the student to identify common pitfalls in %s. Awareness prevents repeated errors.',
    'Suggest proactive question-asking about %s. Curiosity drives deeper learning.',
    'Recommend mixed problem sets for %s. Diverse practice reinforces adaptability.',
    'Encourage the student to reflect on their learning strategies in %s. Adapt methods as needed.',
    'Highlight the value of peer discussion for %s. Verbal debate refines understanding.',
    'Suggest the student create real-world examples for %s. Contextual relevance aids recall.',
    'Recommend concise concept checks for %s. Quick self-assessments guide focus areas.',
    'Encourage the student to pace themselves while practicing %s. Avoid burnout with balanced effort.',
    'Ask the student to compare different approaches to %s problems. Critical evaluation sharpens skills.',
    'Suggest incorporating technology tools for %s practice. Apps and software can diversify learning.',
    'Recommend setting aside dedicated %s workshop sessions. Focused time blocks increase efficiency.',
    'Encourage the student to review feedback on %s assignments. Iterative improvement is key.',
    'Highlight the importance of understanding fundamentals in %s. A strong base supports advanced topics.',
    'Suggest the student write reflective summaries after %s sessions. Reflection deepens retention.',
    'Recommend group brainstorming for %s topics. Collective creativity sparks new insights.',
    'Encourage the student to analyze past %s mistakes. Diagnosing errors prevents recurrence.',
    'Ask the student to synthesize %s concepts into concise cheat sheets. Quick references boost confidence.',
    'Suggest hands-on experiments or examples for %s. Practical application reinforces theory.',
    'Recommend regular check-ins on %s progress. Ongoing support fosters consistent growth.',
    'Encourage the student to mentor peers in %s. Teaching reinforces mastery.',
    'Highlight the benefits of diversified %s practice. Variety mitigates boredom and strengthens recall.',
    'Suggest the student gamify their %s practice. Interactive challenges can boost motivation.',
    'Recommend tailored feedback sessions for %s. Personalized guidance accelerates learning.',
    'Encourage the student to set stretch goals in %s. Pushing boundaries builds confidence.',
    'Ask the student to balance accuracy and speed in %s. Dual focus enhances exam readiness.',
    'Suggest the student relate %s topics to their interests. Personal relevance increases engagement.',
    'Recommend scaffolded assignments for %s. Gradual complexity builds confidence.',
    'Encourage the student to schedule micro-breaks during %s study. Short rests refresh focus.',
    'Highlight how %s competency underpins other subjects. Interdisciplinary links enrich learning.',
    'Suggest the student compile a question bank for %s. Curated resources aid review.',
    'Recommend the student create mind maps for %s. Visual layouts support memory.',
    'Encourage the student to adopt a growth mindset in %s. Embrace challenges as learning opportunities.',
    'Ask the student to document their %s progress in a portfolio. Visible achievements boost morale.',
);

// Array of random commendation paragraphs for subjects where the student scored high (> 80).
// The '%s' placeholder will be replaced with the subject name(s).
$commendations = array(
    'Please recognize the student’s excellent work in %s!',
    'Celebrate the student’s outstanding achievement in %s!',
    'Commend the student for their superb performance in %s!',
    'Applaud the student’s impressive score in %s!',
    'Acknowledge the student’s remarkable effort in %s!',
    'Praise the student for excelling in %s!',
    'Highlight the student’s fantastic results in %s!',
    'Share pride in the student’s success in %s!',
    'Congratulate the student on their brilliant work in %s!',
    'Honor the student’s dedication shown in %s!',
    'Cheer for the student’s great job in %s!',
    'Recognize the student’s strong performance in %s!',
    'Commend the student’s focused work in %s!',
    'Salute the student’s high achievement in %s!',
    'Applaud the student’s hardworking spirit in %s!',
    'Celebrate the student’s mastery of %s!',
    'Highlight the student’s top marks in %s!',
    'Praise the student’s consistent excellence in %s!',
    'Share enthusiasm for the student’s success in %s!',
    'Honor the student’s impressive understanding of %s!',
    'Congratulate the student on nailing %s!',
    'Recognize the student’s deep comprehension of %s!',
    'Salute the student’s focused study in %s!',
    'Applaud the student’s effective learning in %s!',
    'Celebrate the student’s hard-earned result in %s!',
    'Praise the student’s sustained effort in %s!',
    'Highlight the student’s exceptional work in %s!',
    'Honor the student’s dedication to %s!',
    'Commend the student’s passion for %s!',
    'Share admiration for the student’s performance in %s!',
    'Congratulate the student on their high score in %s!',
    'Recognize the student’s commitment in %s!',
    'Salute the student’s achievement in %s!',
    'Cheer the student’s success in %s!',
    'Celebrate the student’s bright work in %s!',
    'Highlight the student’s standout result in %s!',
    'Praise the student’s thorough understanding of %s!',
    'Applaud the student’s excellent grasp of %s!',
    'Commend the student’s brilliant insight in %s!',
    'Honor the student’s mastery shown in %s!',
    'Celebrate the student’s skill in %s!',
    'Recognize the student’s deep dive into %s!',
    'Salute the student’s keen analysis in %s!',
    'Congratulate the student on exceptional %s skills!',
    'Praise the student’s remarkable progress in %s!',
    'Highlight the student’s enthusiasm for %s!',
    'Applaud the student’s sharp performance in %s!',
    'Celebrate the student’s excellence in %s!',
    'Commend the student’s fantastic approach to %s!',
    'Honor the student’s hard work on %s!',
    'Recognize the student’s outstanding method in %s!',
    'Salute the student’s brilliant strategy in %s!',
    'Cheer the student’s success story in %s!',
    'Praise the student’s stellar work in %s!',
    'Highlight the student’s top-tier performance in %s!',
    'Celebrate the student’s high-quality work in %s!',
    'Recognize the student’s effective execution in %s!',
    'Honor the student’s precision in %s!',
    'Applaud the student’s strong command of %s!',
    'Celebrate the student’s in-depth knowledge of %s!',
    'Commend the student’s thorough preparation in %s!',
    'Praise the student’s exceptional insight in %s!',
    'Highlight the student’s outstanding technique in %s!',
    'Recognize the student’s strong analytical skills in %s!',
    'Salute the student’s fine performance in %s!',
    'Cheer the student’s excellent mastery of %s!',
    'Celebrate the student’s remarkable dedication to %s!',
    'Honor the student’s excellence shown in %s!',
    'Acknowledge the student’s significant achievement in %s!',
    'Praise the student’s noteworthy progress in %s!',
    'Commend the student’s superior work in %s!',
    'Celebrate the student’s high-level understanding of %s!',
    'Recognize the student’s exceptional effort in %s!',
    'Salute the student’s impressive focus on %s!',
    'Applaud the student’s successful work in %s!',
    'Highlight the student’s advanced performance in %s!',
    'Honor the student’s strong foundation in %s!',
    'Praise the student’s committed work in %s!',
    'Celebrate the student’s peak performance in %s!',
    'Commend the student’s top-notch work in %s!',
    'Recognize the student’s effective mastery of %s!',
    'Salute the student’s smart approach in %s!',
    'Cheer the student’s achievement in %s!',
    'Applaud the student’s diligent work in %s!',
    'Highlight the student’s best-in-class performance in %s!',
    'Honor the student’s keen understanding of %s!',
    'Celebrate the student’s excellence achieved in %s!',
    'Commend the student’s complete mastery of %s!',
    'Recognize the student’s high-level skill in %s!',
);


// Main chatbot logic: retrieves data from the 'mastersheet' table and analyzes performance.
// This block executes only if a valid student ID is provided.
if (!empty($student_id)) {
    // Get the current term dynamically from the 'currentterm' table.
    $term_sql = "SELECT cterm FROM currentterm LIMIT 1";
    $term_result = $conn->query($term_sql);

    // Check for errors during the term retrieval query.
    if (!$term_result) {
        die("Error fetching current term: " . $conn->error);
    }

    $current_term = '';
    // If a term is found, store it.
    if ($term_result->num_rows > 0) {
        $row = $term_result->fetch_assoc();
        // Escape the term to prevent SQL injection in subsequent queries.
        $current_term = $conn->real_escape_string($row['cterm']);
    } else {
        // If no current term is defined, terminate execution with an error message.
        die("No current term defined in currentterm table.");
    }

    // SQL query to fetch subject scores for the specified student and current term.
    // It retrieves subject name, Continuous Assessment (CA1, CA2), Exam score,
    // and the calculated average score, along with the student's name.
    $sql = "
        SELECT subject, ca1, ca2, exam, average, name
        FROM mastersheet
        WHERE term = '$current_term'
          AND id   = '" . $conn->real_escape_string($student_id) . "'
    ";
    $result = $conn->query($sql);

    // Check for errors during the main data retrieval query.
    if (!$result) {
        $response = "Error: " . mysqli_error($conn);
    } elseif ($result->num_rows > 0) {
        // Initialize arrays and variables to store and process student scores.
        $subject_scores = array();
        $total_scores = 0;
        $num_subjects = 0;
        $name = ''; // Student's name

        // Loop through each row (subject) in the query result.
        while ($row = $result->fetch_assoc()) {
            $subject = $row['subject'];
            $ca1     = (float) $row['ca1'];
            $ca2     = (float) $row['ca2'];
            $exam    = (float) $row['exam'];
            $total   = (float) $row['average']; // Use the 'average' column if available

            // If 'average' column is empty or zero, calculate it from CA1, CA2, and exam.
            if (empty($total)) {
                $total = $ca1 + $ca2 + $exam;
            }

            $subject_scores[$subject] = $total; // Store total score for each subject
            $total_scores += $total;             // Accumulate total scores for overall average
            $num_subjects++;                     // Count the number of subjects
            $name = htmlspecialchars($row['name']); // Get student's name (assuming it's consistent across rows)
        }

        // Calculate the overall average score for the student across all subjects.
        $overall_average = ($num_subjects > 0) ? round(($total_scores / $num_subjects), 2) : 0;

        // Identify subjects where the student scored low (<= 50) or high (>= 80).
        $low_scores  = array();
        $high_scores = array();
        foreach ($subject_scores as $subject => $score) {
            if ($score <= 50) {
                $low_scores[$subject] = $score;
            } elseif ($score >= 80) {
                $high_scores[$subject] = $score;
            }
        }

        // Construct the chatbot's response.
        // Start with a random introduction.
        $intro = $intros[array_rand($intros)];
        $response = $intro . " The overall average score is " . $overall_average . ". ";

        // Add suggestions for low-scoring subjects.
        if (!empty($low_scores)) {
            $subjects_low = implode(", ", array_keys($low_scores)); // Join subject names for the message
            $template = $suggestions[array_rand($suggestions)];     // Pick a random suggestion template
            $response .= sprintf($template, $subjects_low) . " ";   // Format the template with subject names
        } else {
            // If no low scores, provide a general positive reinforcement.
            $response .= "Outstanding work, " . $name . "! Let’s keep striving for even greater achievements together. ";
        }

        // Add commendations for high-scoring subjects.
        if (!empty($high_scores)) {
            $subjects_high = implode(", ", array_keys($high_scores)); // Join subject names for the message
            $comm_template = $commendations[array_rand($commendations)]; // Pick a random commendation template
            $response .= sprintf($comm_template, $subjects_high);       // Format the template with subject names
        }
    } else {
        // If no data is found for the given student ID, provide an informative message.
        $response = "I'm sorry, no data found for student ID: " . htmlspecialchars($student_id) . ".";
    }
} else {
    // If no student ID is provided in the GET request, prompt the user.
    $response = "Please provide a valid student ID.";
}

// Output the generated chatbot response.
echo $response;

// Close the database connection to free up resources.
$conn->close();
?>
