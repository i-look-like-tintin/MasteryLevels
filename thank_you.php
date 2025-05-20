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

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $user);
$stmt->execute();

// Get result
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $currentUserId = $row['id'];
    //echo "User ID: " . $user_id;
} else {
    echo "User not found.";
}

$subject = isset($_GET['subject']) ? trim($_GET['subject']) : 'Unknown Subject';

$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$total = isset($_GET['total']) ? intval($_GET['total']) : 0;

$percentage = ($total > 0) ? round(($score / $total) * 100, 1) : 0;

// Fetch latest submitted code
$submittedCode = "";

$stmt = $conn->prepare("
    SELECT code, question
    FROM code_submissions
    WHERE student_id = ? AND subject = ?
    ORDER BY submission_time DESC
    LIMIT 1
");
$stmt->bind_param("is", $currentUserId, $subject);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $submittedCode = $row['code'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Submitted</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .thank-you-container {
            background: white;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            text-align: center;
            max-width: 600px;
        }
        .thank-you-container h1 {
            font-size: 2em;
            color: #4CAF50;
            margin-bottom: 10px;
        }
        .thank-you-container p {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }
        .score-box {
            margin: 20px 0;
            font-size: 1.5em;
            font-weight: bold;
            color: #222;
        }
        .button-group {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .button-group a {
            display: inline-block;
            margin: 0 auto;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 1em;
            border-radius: 8px;
            width: 80%;
            text-align: center;
            transition: background 0.3s ease;
        }
        .dashboard-button, .retry-button {
            background: #4CAF50;
            color: white;
        }
        .dashboard-button:hover, .retry-button:hover {
            background: #45a049;
        }
        .logout-button {
            background: #e53935;
            color: white;
        }
        .logout-button:hover {
            background: #c62828;
        }
        .code-display {
            margin-top: 30px;
            text-align: left;
        }
        .code-display pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>

<div class="thank-you-container">
    <h1>🎉 Congratulations!</h1>
    <p>You have completed the test.</p>

    <div class="score-box">
        Your Score: <?php echo htmlspecialchars($score) . " / " . htmlspecialchars($total); ?><br>
        (<?php echo htmlspecialchars($percentage); ?>%)
    </div>

    <div class="code-display">
        <h2>Your Submitted Code:</h2>
        <pre><?php echo htmlspecialchars($submittedCode); ?></pre>
    </div>

    <div class="button-group">
        <a href="dashboard.php" class="dashboard-button">Return to Dashboard</a>
        <a href="python_level1_test.php" class="retry-button">Retry Quiz</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</div>

</body>
</html>