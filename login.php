<?php
session_start();

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_website";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select the database
$conn->select_db($dbname);

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
    
    


// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the provided password matches the hashed password
        if (password_verify($password, $user['password'])) {
            // Store user ID and email in session
            $_SESSION['id'] = $user['id'];
            $_SESSION['user'] = $user['email'];
            $_SESSION['role'] = $user['role'];  // Store the user role

            // Redirect based on role
            if ($user['role'] == 'teacher') {
                header("Location: teacher_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
<div class="login-container">
    <h1>MasteryLevels</h1>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (!empty($error)) echo "<p>$error</p>"; ?>
    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
</div>
</body>
</html>
