<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}


// Database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'exam_website';

// Connect to MySQL
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->select_db($database);


// Assume the student is already logged in and student_id is stored in session
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'Unknown Subject';

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $user);
$stmt->execute();

// Get result
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $currentUserId = $row['id'];
    //echo "User ID: " . $user_id;
} else {
    echo "User not found.";
}


// Initialize counters
$correctAnswers = 0;
$totalQuestions = 0;

// Grade multiple-choice questions
foreach ($_POST as $key => $value) {
    if (strpos($key, 'question_') === 0) {
        $questionID = intval(str_replace('question_', '', $key));
        $selectedAnswerCharacter = $conn->real_escape_string($value);

        $stmt = $conn->prepare("
            SELECT correct
            FROM Answers
            WHERE questionID = ? AND answer_character = ?
            LIMIT 1
        ");
        $stmt->bind_param("is", $questionID, $selectedAnswerCharacter);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if ($row['correct'] == 1) {
                $correctAnswers++;
            }
        }
        $stmt->close();

        // Insert into student_progress
        $stmtProgress = $conn->prepare("
            INSERT INTO student_progress (student_id, subject, question_id, selected_option, completed)
            VALUES (?, ?, ?, ?, 1)
            ON DUPLICATE KEY UPDATE selected_option = VALUES(selected_option), completed = 1
        ");
        $stmtProgress->bind_param("isis", $currentUserId, $subject, $questionID, $selectedAnswerCharacter);
        $stmtProgress->execute();
        $stmtProgress->close();

        $totalQuestions++;
    }
}

// Handle submitted code
if (isset($_POST['code_answer']) && !empty(trim($_POST['code_answer'])) && isset($_POST['code_correct'])) {
    $codeAnswer = trim($_POST['code_answer']);
    $codeCorrect = $_POST['code_correct'];
    $codeQuestion = $_POST['code_question'];
    // If code correct, add 1
    if($codeCorrect) $correctAnswers++;
    $totalQuestions++;

    // Insert code into code_submissions table
    $stmtCode = $conn->prepare("
        INSERT INTO code_submissions (student_id, subject, code, question, correct)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmtCode->bind_param("isssi", $currentUserId, $subject, $codeAnswer, $codeQuestion, $codeCorrect);
    $stmtCode->execute();
    $stmtCode->close();
}

// Save overall result
$stmtResult = $conn->prepare("
    INSERT INTO results (student_id, subject, score, total_questions, exam_date)
    VALUES (?, ?, ?, ?, NOW())
    ON DUPLICATE KEY UPDATE 
        score = VALUES(score),
        total_questions = VALUES(total_questions),
        exam_date = NOW()
");
$stmtResult->bind_param("isii", $currentUserId, $subject, $correctAnswers, $totalQuestions);
$stmtResult->execute();
$stmtResult->close();

// Redirect to thank_you.php
header("Location: thank_you.php?score=$correctAnswers&total=$totalQuestions&subject=" . urlencode($subject));
exit();
?>