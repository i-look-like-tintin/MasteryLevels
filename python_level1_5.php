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
            <h2>Introduction to Python Operations</h2>
        </div>
        <div class="lesson-content">
            <p>Python is a popular coding language for the purposes of mathematical modelling and simulation - as well as much more! We can do some basic mathematics in Python, by learning about the operators.</p>
            <p>As you would expect, the <i>+</i> operator is used for addition, and the <i>-</i> operator is for subtraction. In python, the asterisk <i>*</i> is used for multiplication, and the <i>/</i> operator is used for division. Check it out below:</p>
            <div class="code-snippet">
<pre>
x = 2+2-1

y = 3*2

z = 6/3
</pre>
            </div>
            <p>We can also represent one number raised to the power of another, using the <i>**</i> operator. Finally, we can use the modulus operator <i>%</i> to calculate the remainder of the euclidean division of one number by another. Or, to put it more plainly, the modulus operator <i>%</i> calculates the remainder of dividing one number by another multiple times, until further division would result in a fraction.</p>
      <div class = "code-snippet">
<pre>
In this example, the variable called <i>power</i> will end up holding the value of 9, as this is 3 squared.

            power = 3**2



And in this example, the variable called <i>mod</i> will hold the value of 1
as we can divide 9 by 4 twice, until we only have 1 left over.

            mod = 9%4
</pre>
</div>  
            <div>
                Give it a go in the code editor!
            </div>
            <iframe src="https://trinket.io/embed/python/ce7a0369bfbf?runOption=run" width="100%" height="356" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
    </div>
        <div class="lesson-actions">
            <a href="ython_level1_4.php" class="btn">← Previous</a>
            <a href="python_level1_test.php" class="btn">Take the Test! →</a>
        </div>
    </div>

</body>
</html>
