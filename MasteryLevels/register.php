<?php
session_start();

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

// Create the database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $database");
$conn->select_db($database);

// Modify the users table to add the 'role' column if it doesn't exist
$alterUsersTable = "
    ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('student', 'teacher') DEFAULT 'student';
";
$conn->query($alterUsersTable);

// Insert the default teacher account
$conn->query("INSERT INTO users (email, password, role) 
              VALUES ('teacher@teacher', '" . password_hash('password', PASSWORD_DEFAULT) . "', 'teacher')
              ON DUPLICATE KEY UPDATE email=email");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the insert statement
    $insertUser = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'student')");
    $insertUser->bind_param('ss', $email, $hashedPassword);

    if ($insertUser->execute()) {
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $insertUser->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Register</title>
</head>
<body>
<div class="login-container">
    <h1>Register</h1>
    <form action="register.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Log in</a></p>
</div>
</body>
</html>
