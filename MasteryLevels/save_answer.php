<?php
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response type to JSON
header('Content-Type: application/json');

session_start();

// Check if the request is a POST request with the expected parameter
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['save_answer'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or missing parameters.']);
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
    exit();
}

// Validate and sanitize input data
$required_fields = ['selected_option', 'subject', 'question_id', 'student_id'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => "Missing field: $field."]);
        exit();
    }
}

$selected_option = strtoupper(trim($_POST['selected_option']));
$subject = trim($_POST['subject']);
$question_id = intval($_POST['question_id']);
$student_id = intval($_POST['student_id']);

// Validate selected_option
$valid_options = ['A', 'B', 'C', 'D'];
if (!in_array($selected_option, $valid_options)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid selected option.']);
    exit();
}

// Database credentials
$host = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'exam_website';

// Connect to MySQL
$conn = new mysqli($host, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}

// Insert or Update the student's answer in student_progress
$insertOrUpdateQuery = "
    INSERT INTO student_progress (student_id, subject, question_id, selected_option, completed)
    VALUES (?, ?, ?, ?, 0)
    ON DUPLICATE KEY UPDATE selected_option = VALUES(selected_option)
";
$stmt = $conn->prepare($insertOrUpdateQuery);
if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
    exit();
}
$stmt->bind_param("isis", $student_id, $subject, $question_id, $selected_option);
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to save the answer.']);
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->close();

// Optional: Check if all questions are answered to mark completion
// Fetch total questions for the subject
$totalQuestionsQuery = "SELECT COUNT(*) AS total FROM quizzes WHERE subject = ?";
$stmt_total = $conn->prepare($totalQuestionsQuery);
if ($stmt_total === false) {
    // Not critical, proceed without marking completion
    echo json_encode(['status' => 'success', 'message' => 'Answer saved successfully.']);
    $conn->close();
    exit();
}
$stmt_total->bind_param("s", $subject);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$totalQuestionsRow = $result_total->fetch_assoc();
$totalQuestions = intval($totalQuestionsRow['total']);
$stmt_total->close();

// Fetch count of answered questions
$answeredQuestionsQuery = "SELECT COUNT(*) AS answered FROM student_progress WHERE student_id = ? AND subject = ? AND selected_option IS NOT NULL";
$stmt_answered = $conn->prepare($answeredQuestionsQuery);
if ($stmt_answered === false) {
    // Not critical, proceed without marking completion
    echo json_encode(['status' => 'success', 'message' => 'Answer saved successfully.']);
    $conn->close();
    exit();
}
$stmt_answered->bind_param("is", $student_id, $subject);
$stmt_answered->execute();
$result_answered = $stmt_answered->get_result();
$answeredQuestionsRow = $result_answered->fetch_assoc();
$answeredQuestions = intval($answeredQuestionsRow['answered']);
$stmt_answered->close();

// If all questions are answered, mark as completed
if ($answeredQuestions == $totalQuestions) {
    $markCompletedQuery = "UPDATE student_progress SET completed = 1 WHERE student_id = ? AND subject = ?";
    $stmt_complete = $conn->prepare($markCompletedQuery);
    if ($stmt_complete !== false) {
        $stmt_complete->bind_param("is", $student_id, $subject);
        $stmt_complete->execute();
        $stmt_complete->close();
    }
}

$conn->close();

// Respond with success
echo json_encode(['status' => 'success', 'message' => 'Answer saved successfully.']);
exit();
?>
