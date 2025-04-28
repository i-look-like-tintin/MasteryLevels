<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
//Check if user is logged in
if (!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}
$currentUserId = $_SESSION['id'];

//database connection
$host = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'exam_website';

$conn = new mysqli($host, $db_username, $db_password, $database); // Fixed undefined variables
if($conn->connect_error){
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

//Get subject from string
if (!isset($_GET['subject']) || empty($_GET['subject'])) {
    echo "<p>No subject specified.</p>";
}
$subject = $conn->real_escape_string($_GET['subject']);
//TODO: This shit aint working, but we closer lmao
if($subject == "Python Level 1"){


    $query = "SELECT 
    sr.student_id,
    sr.question_id,
    q.question,
    sr.selected_option,
    a.answer_character AS correct_option,
    a.answer AS correct_answer
    FROM 
    student_progress sr
    JOIN 
    Questions q ON sr.question_id = q.questionID
    JOIN 
    Answers a ON q.questionID = a.questionID
    WHERE 
    sr.student_id = ? -- Replace <student_id_list> with the list of student IDs
    AND sr.subject = ? -- Replace <question_id_list> with the list of question IDs
    AND a.correct = TRUE;";
    $stmt = $conn->prepare($query);
    if ($stmt == false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("is", $currentUserId, $subject);

    if (!$stmt->execute()) {
        die("Execute failed: " . htmlspecialchars($stmt->error)); // Added error handling
    }
}
else{
//fetch all questions and students answers
    $query = "SELECT q.id AS question_id, q.question, q.correct_option, sp.selected_option
        FROM quizzes q
        LEFT JOIN student_progress sp
        ON q.id = sp.question_id AND sp.student_id = ? AND sp.subject = ?
        WHERE q.subject = ?";

    $stmt = $conn->prepare($query);
    if ($stmt == false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }   
    $stmt->bind_param("iss", $currentUserId, $subject, $subject);
    if (!$stmt->execute()) {
        die("Execute failed: " . htmlspecialchars($stmt->error)); // Added error handling
    }
}
$result = $stmt->get_result();


$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row; // Fixed typo: $question[] -> $questions[]
}
if (empty($questions)) {
    echo "<p>No questions found for the selected subject.</p>"; // Added fallback message
}

if ($result->num_rows === 0) {
    die("No data returned. Check if questions exist for subject: " . htmlspecialchars($subject));
}
// Debugging output
// Uncomment the following line to inspect the fetched questions
//var_dump($questions);

$stmt->close();
$conn->close();
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Review - <?php echo htmlspecialchars($subject); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        .exam-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="exam-container">
        <h1>Exam Review</h1>
        <h2><?php echo htmlspecialchars($subject); ?><br></h2> <!-- Added <br> for a new line -->
        <table border="1" style="border-spacing: 1; padding: 20px; width: 100%;">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Your Answer</th>
                    <th>Correct Answer</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($question['question']); ?></td>
                        <td><?php echo htmlspecialchars(strtoupper($question['selected_option'] ?? 'Not Answered')); ?></td>
                        <td><?php echo htmlspecialchars(strtoupper($question['correct_option'])); ?></td>
                        <td>
                            <?php 
                            $selectedOption = trim((string) $question['selected_option'] ?? '');
                            $correctOption = trim((string) $question['correct_option']);
                            if (strcasecmp($selectedOption, $correctOption) === 0): ?> <!-- Case-insensitive comparison -->
                                <span style="color:green;">Correct</span>
                            <?php else: ?>
                                <span style="color:red;">Incorrect</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
