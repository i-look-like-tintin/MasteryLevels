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
$conn->select_db($database);

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $user);
$stmt->execute();

// Get result
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $user_id = $row['id'];
    //echo "User ID: " . $user_id;
} else {
    echo "User not found.";
}

$stmt = $conn->prepare("DELETE FROM python_learning WHERE student_id = ?");
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $user_id);
$stmt->execute();

$stmt = $conn->prepare("INSERT INTO python_learning (student_id, progress_level, q1, q2) VALUES (?, 1, 'b', 'c');"); //This is the fucky shit i was trynna do with the SQL, but it doesnt really make sense and probs needs another table
if ($stmt === false) {                                                                                                      //Ive created the table itself in the login.php file
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("s", $user_id);
$stmt->execute();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python Test - Level 1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        .test-container {
            width: 90%;
            max-width: 900px;
            margin: 100px auto 40px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .question-text {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .multiple-choice {
            margin-bottom: 1.5rem;
        }

        .multiple-choice label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
        }

        .code-input {
            margin-top: 1.5rem;
        }

        .code-input textarea {
            width: 100%;
            height: 200px;
            padding: 1rem;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .submit-btn {
            margin-top: 2rem;
            text-align: right;
        }
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

<div class="test-container">
    <form id = "quizForm">
        <h2>Question 1</h2>
        <p class="question-text">
            What will the following Python code output?
        </p>
        <div class="code-snippet">
<pre>
x = 10
y = 5
print(x / y)
</pre>
        </div>

        <div class="multiple-choice" name = multiple-choice-1>
            <label><input type="radio" name="q1" value="a"> 2.0</label>
            <label><input type="radio" name="q1" value="b"> 2</label>
            <label><input type="radio" name="q1" value="c"> 0.5</label>
            <label><input type="radio" name="q1" value="d"> Error</label>
        </div>
        <h2>Question 2</h2>
        <p class="question-text">
            What is the correct way of assigning a variable to hold the String "Ship"
        </p>

        <div class="multiple-choice" name = multiple-choice-2>
            <label><input type="radio" name="q2" value="a"> "Ship" = variable</label>
            <label><input type="radio" name="q2" value="b"> variable = 'Ship'</label>
            <label><input type="radio" name="q2" value="c"> variable = "Ship"</label>
            <label><input type="radio" name="q2" value="d"> 'Ship' = variable</label>
        </div>
        <button type="submit">Submit Multiple Choice</button>
        <div id="feedback"></div>

    </form>
    <form id = "python_code">
        
    <div class="code-input">
            <label for="user_code"><strong>Finally, write a line of Python code to <i>print</i> the mathematical value of 3 to the power of 2.</strong></label>
            <textarea name="user_code" id="user_code" placeholder="Enter your Python code here..."></textarea>
        </div>

        <div class="submit-btn">
            <button type="submit" class="fin-btn">Submit Test</button>
        </div>
        
    </form>


    <!--TODO: ANSWER CHECKING || THIS IS A WIP-->
    <script>
          document.getElementById("quizForm").addEventListener("submit", function (e) {
            e.preventDefault();

        const questionNames = ["q1", "q2"]; // Add all your question input names here
        let allAnswered = true;
        let feedback = "";

        questionNames.forEach((q, i) => {
        const selected = document.querySelector(`input[name="${q}"]:checked`);
        if (!selected) {
            allAnswered = false;
            feedback += `<p>⚠️ Question ${i + 1} is unanswered.</p>`;
        } else {
            feedback += `<p>✅ Question ${i + 1} selected: ${selected.value}</p>`;
        }
  });

  document.getElementById("feedback").innerHTML = feedback;

  if (allAnswered) {
    if
  }
});
        </script>
</div>
</body>
</html>