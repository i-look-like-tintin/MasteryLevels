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
            <h2>Introduction to Python Data Types</h2>
        </div>
        <div class="lesson-content">
            <p>In Python, data can take the different forms. This lesson will cover a few of the basics.</p>
            <p>The <i>String</i> data type allows words and sentences to be manipulated by Python code. The <i>char</i> data type represents individual characters. The <i>int</i> data type (short for Integer) represents whole numbers, for example <i>3</i> or <i>-7</i>. The <i>float</i> data type represents numbers with decimal places, such as 0.5 or 304.7. Finally, the list data type represents an array of multiple data types, such as <i>[1, -30.4, "banana", 'c']</i></p>
            <p>The numerical data types (int and float) can be represented in Python by merely entering the numbers as they are. However, the text-based data types (String and char) are represented by quotation marks and apostrophe marks. This can be seen below.</p>
            <div class="code-snippet">
<pre>
Integer:
    5


Float:
    3.14159


String:
    "This is a String"

    
Char:
        'c'
</pre>
            </div>
            <p>Try modifying the print statement from before to print different data types in your code editor.</p>
        </div>
<pre>
<iframe src="https://trinket.io/embed/python/ce7a0369bfbf?runOption=run" width="100%" height="356" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
</pre>
        <div class="lesson-actions">
            <a href="python_level1_print.php" class="btn">← Previous</a>
            <a href="python_level1_variables.php" class="btn">Next →</a>
        </div>
    </div>

</body>
</html>
