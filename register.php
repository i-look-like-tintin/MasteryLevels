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

//TODO: Table instantiation because my predecessors forgor :skull:
    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('student', 'teacher') NOT NULL DEFAULT 'student'
    )";
    $conn->query($sql);

    // Modify the users table to add the 'role' column if it doesn't exist
    $alterUsersTable = "
        ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('student', 'teacher') DEFAULT 'student';
";
    $conn->query($alterUsersTable);
    
    // Insert the default teacher account
    $conn->query("INSERT INTO users (email, password, role) 
        VALUES ('teacher@teacher', '" . password_hash('password', PASSWORD_DEFAULT) . "', 'teacher')
                            ON DUPLICATE KEY UPDATE email=email");
    
    // *** CREATE Necessary Tables IF NOT EXISTS ***
    $createQuizzesTableQuery = "
    CREATE TABLE IF NOT EXISTS quizzes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(255) NOT NULL,
        level VARCHAR(50) NOT NULL,
        question TEXT NOT NULL,
        option_a VARCHAR(255) NOT NULL,
        option_b VARCHAR(255) NOT NULL,
        option_c VARCHAR(255) NOT NULL,
        option_d VARCHAR(255) NOT NULL,
        correct_option CHAR(1) NOT NULL
    )
";
    if ($conn->query($createQuizzesTableQuery) === FALSE) {
        die("Error creating quizzes table: " . htmlspecialchars($conn->error));
    }
    
    $createProgressTableQuery = "
    CREATE TABLE IF NOT EXISTS student_progress (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        question_id INT NOT NULL,
        selected_option CHAR(1),
        completed BOOLEAN DEFAULT 0,
        UNIQUE KEY unique_progress (student_id, subject, question_id)
    )
    ";
    if ($conn->query($createProgressTableQuery) === FALSE) {
    die("Error creating student_progress table: " . htmlspecialchars($conn->error));
    }
    
    $createResultsTableQuery = "
    CREATE TABLE IF NOT EXISTS results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        score INT NOT NULL,
        total_questions INT NOT NULL,
        exam_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_result (student_id, subject)
    )
    ";
    if ($conn->query($createResultsTableQuery) === FALSE) {
    die("Error creating results table: " . htmlspecialchars($conn->error));
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)){
        $error = "All fields are required.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email format.";
    }
    else{
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
    <?php if (isset($error)): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="register.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Log in</a></p>
</div>
</body>
</html>
