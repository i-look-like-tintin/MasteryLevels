<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Check if the session ID is set
if (!isset($_SESSION['id'])) {
    die("Session ID not set. Please log in again.");
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

// Get the subject from the URL
$subject = $_GET['subject'];

// Mark the exam as completed for the current user
$currentUserId = $_SESSION['id'];
$updateProgressQuery = "UPDATE student_progress SET completed = 1 WHERE student_id = '$currentUserId' AND subject = '$subject'";
$conn->query($updateProgressQuery);

// Redirect to the exams page or a completion page
header("Location: exams.php");
$conn->close();
?>
