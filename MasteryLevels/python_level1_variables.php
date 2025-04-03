<?php


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

// Select the exam database
$conn->select_db($database);



// Initialize selected level
$selected_level = 'Level 1';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python Lesson</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        .lesson-container {
            width: 90%;
            max-width: 900px;
            margin: 100px auto 40px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .lesson-header {
            margin-bottom: 1.5rem;
        }

        .lesson-header h2 {
            font-size: 2rem;
            color: #333;
        }

        .lesson-content p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #444;
        }

        .code-snippet {
            background: #f4f4f4;
            border-left: 4px solid #007BFF;
            padding: 1rem;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }

        .lesson-actions {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
        }

        .lesson-actions a {
            text-decoration: none;
        }
    </style>
</head>
<body class="dashboard">

    <div class="lesson-container">
        <div class="lesson-header">
            <h2>Introduction to Python Variables</h2>
        </div>
        <div class="lesson-content">
            <p>In Python, variables are used to store information that can be referenced and manipulated in a program. You do not need to declare the type of variable explicitly, Python figures it out for you. We can use the <i>equals sign (=)</i> to declare that a certain variable should hold the value assigned to it.</p>
            <p>Check out the example below, where the variables called <i>x</i>, <i>name</i>, and <i>pi</i> are assigned to hold the values <i>5</i>, <i>"Mackenzie"</i>, and <i>3.14</i> respectively.</p>
            <div class="code-snippet">
<pre>
x = 5
name = "Mackenzie"
pi = 3.14
</pre>
            </div>
            <p>Try modifying and printing these variables in your code editor.</p>
            <iframe src="https://trinket.io/embed/python/ce7a0369bfbf?runOption=run" width="100%" height="356" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
        </div>
        <div class="lesson-actions">
            <a href="python_level1_datatypes.php" class="btn">← Previous</a>
            <a href="python_level1_operations.php" class="btn">Next →</a>
        </div>
    </div>

</body>
</html>
