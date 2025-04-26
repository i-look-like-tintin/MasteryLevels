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
            <p>In Python, the <i>print()</i> command is used to 'print' the value of whatever is inside the parentheses to the console. For example: </p>
            <div class="code-snippet">
<pre>
print(2+2)
</pre>
            </div>
            <p>Will result in <i>4</i> being printed into the console. You can change the value of whatever is inside the parentheses, to print something different.</p>
            <p>Give it a try in your code editor below, by clicking the Play button in the top left of the editor. The output of the print() statement will be shown in the console, to the left of the editor.</p>
        </div>
<pre>
<iframe src="https://trinket.io/embed/python/ce7a0369bfbf?runOption=run" width="100%" height="356" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
</pre>
        <div class="lesson-actions">
            <a href="python_level1_1.php" class="btn">← Previous</a>
            <a href="python_level1_3.php" class="btn">Next →</a>
        </div>
    </div>

</body>
</html>
