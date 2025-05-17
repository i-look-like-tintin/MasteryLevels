<?php

session_start(); // Always start session at top

if (!isset($_SESSION['initialised']) || $_SESSION['initialised'] !== true) {
    header("Location: initialise.php");
    exit();
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

// Create the database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $database");
$conn->select_db($database);
if($_SESSION)  
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
