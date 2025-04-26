<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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


// --- RANDOM MULTIPLE CHOICE SECTION ---

// Fetch 3 random Level 1 questions
$questionQuery = "
    SELECT q.questionID, q.question 
    FROM Questions q
    INNER JOIN Levels l ON q.levelID = l.levelID
    WHERE l.levelID <= 4
    ORDER BY RAND()
    LIMIT 3
";

$questionResult = $conn->query($questionQuery);

if (!$questionResult) {
    die("Error fetching questions: " . htmlspecialchars($conn->error));
}

$questions = [];

while ($row = $questionResult->fetch_assoc()) {
    $questions[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python Level 1 Test</title>
    <link rel="stylesheet" href="your_existing_styles.css"> <!-- if you want -->
    <style>
        /* Extra Clean Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .main-content {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            color: #333;
        }
        .exam-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .question-section {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 8px;
        }
        .question-text {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #222;
        }
        .answer-option {
            margin-bottom: 10px;
        }
        .answer-option input[type="radio"] {
            margin-right: 10px;
        }
        .coding-question-section {
            background: #eef2f7;
            padding: 20px;
            border-radius: 8px;
        }
        .instructions {
            margin-bottom: 10px;
            font-size: 1em;
        }
        .code-textarea {
            width: 100%;
            height: 250px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 1em;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
        }
        .submit-section {
            text-align: center;
            margin-top: 20px;
        }
        .submit-button {
            background: #4CAF50;
            color: white;
            padding: 12px 25px;
            font-size: 1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .quit-button {
            background:rgb(172, 34, 29);
            color: white;
            padding: 12px 25px;
            font-size: 1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .submit-button:hover {
            background: #45a049;
        }
        .question-divider {
            border: none;
            height: 1px;
            background: #ddd;
            margin: 30px 0;
        }
    </style>
</head>
<body>

<div class="main-content">
    <h1 class="page-title">Python Level 1 Test</h1>

    <form action="submit_exam.php" method="post" class="exam-form">
    <input type="hidden" name="subject" value="Python Level 1">
    <div style="text-align: right; margin-bottom: 20px;">
    <a href="python_splash.php" class="quit-button" onclick="return confirm('Are you sure you want to quit and return to the menu?');">Quit</a>
</div>
        <!-- Dynamically Generated Multiple Choice Questions -->
        <?php
        foreach ($questions as $index => $question) {
            echo "<div class='question-section'>";
            echo "<h2 class='question-text'>Question " . ($index + 1) . ": " . htmlspecialchars($question['question']) . "</h2>";

            // Fetch corresponding answers
            $answerQuery = "
                SELECT answerID, answer, answer_character
                FROM Answers
                WHERE questionID = ?
                ORDER BY answer_character ASC
            ";

            $stmt = $conn->prepare($answerQuery);
            if (!$stmt) {
                die("Error preparing answer query: " . htmlspecialchars($conn->error));
            }

            $stmt->bind_param("i", $question['questionID']);
            $stmt->execute();
            $answerResult = $stmt->get_result();

            if ($answerResult->num_rows == 0) {
                echo "<p class='no-answers-warning'>No answers available for this question.</p>";
            } else {
                while ($answer = $answerResult->fetch_assoc()) {
                    echo "<div class='answer-option'>";
                    echo "<label>";
                    echo "<input type='radio' name='question_" . $question['questionID'] . "' value='" . htmlspecialchars($answer['answer_character']) . "' required> ";
                    echo "<span class='answer-text'>" . htmlspecialchars($answer['answer_character']) . ". " . htmlspecialchars($answer['answer']) . "</span>";
                    echo "</label>";
                    echo "</div>";
                }
            }
            echo "</div><hr class='question-divider'>";
        }
        ?>

        <!-- Coding Question Section -->
        <div class="coding-question-section">

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="300" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>

            <h2 class="question-text">Python Coding Question:</h2>
            <p class="instructions">Write Python code to instantiate a variable named 'myVariable' with the value of 3. The program should then square this variable, and print the result.</p>
            <textarea name="code_answer" class="code-textarea" placeholder="Use the IDE above to test and develop your code, then copy and paste it here to submit your answer..." required></textarea>
        </div>

        <div class="submit-section">
            <button type="submit" class="submit-button">Submit Test</button>
        </div>

    </form>
</div>

</body>
</html>