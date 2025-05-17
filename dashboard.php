<?php
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$user_id = $_SESSION['id'];

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Destroy the session and redirect to login
    session_destroy();
    header("Location: login.php");
    exit;
}

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'exam_website';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// *** FETCH RECENT EXAM RESULTS ***
$recentResultsQuery = "
    SELECT r.subject, r.score, r.total_questions
    FROM results r
    WHERE r.student_id = ?
    ORDER BY r.id DESC
    LIMIT 5
";
$recentResultsStmt = $conn->prepare($recentResultsQuery);
$recentResultsStmt->bind_param("i", $user_id);
$recentResultsStmt->execute();
$recentResultsResult = $recentResultsStmt->get_result();
$recentResults = $recentResultsResult->fetch_all(MYSQLI_ASSOC);
$recentResultsStmt->close();

// *** FETCH TOTAL EXAMS TAKEN AND AVERAGE SCORE ***
$totalExamsTaken = 0;
$averageScore = 0;

$totalExamsQuery = "SELECT COUNT(*) AS total, AVG((score / total_questions) * 100) AS avg_score FROM results WHERE student_id = ?";
$totalExamsStmt = $conn->prepare($totalExamsQuery);
$totalExamsStmt->bind_param("i", $user_id);
$totalExamsStmt->execute();
$totalExamsResult = $totalExamsStmt->get_result();
if ($row = $totalExamsResult->fetch_assoc()) {
    $totalExamsTaken = $row['total'] ?? 0;
    $averageScore = $row['avg_score'] ?? 0;
}
$totalExamsStmt->close();

// *** FETCH USER INFORMATION ***
$userInfoQuery = "SELECT id, email, role FROM users WHERE id = ?";
$userInfoStmt = $conn->prepare($userInfoQuery);
$userInfoStmt->bind_param("i", $user_id);
$userInfoStmt->execute();
$userInfoResult = $userInfoStmt->get_result();
$userInfo = $userInfoResult->fetch_assoc();
$userInfoStmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasteryLevels - Exam Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Base Styles */
        body.dashboard {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-top: 80px;
            background-color: #918e91;
            transition: background-color 0.3s, color 0.3s;
        }
        /* Light Mode */
        body.light-mode {
            background-color: #f4f7fc;
            color: #333;
        }
        /* Dark Mode */
        body.dark-mode {
            background-color: #1a1a1a;
            color: #f4f7fc;
        }
        .dashboard-header {
            background-color: #4A90E2;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        .dashboard-header .logo h1 {
            margin: 0;
            font-size: 28px;
        }
        .dashboard-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .dashboard-nav ul li {
            margin-left: 25px;
        }
        .dashboard-nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }
        .dashboard-nav ul li a:hover {
            color: #d1e9ff;
        }
        .user-info {
            display: flex;
            align-items: center;
            font-size: 16px;
        }
        .user-info span {
            margin-right: 15px;
        }
        .logout-btn {
            background-color: #FF5C5C;
            border: none;
            padding: 8px 16px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #FF1E1E;
        }

        .mode-toggle-btn {
            background-color: #4A90E2;
            border: none;
            padding: 8px 16px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .mode-toggle-btn:hover {
            background-color: #3b78b7;
        }
        /* Dashboard Content */
        .dashboard-content {
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .dashboard-sections {
            display: flex;
            gap: 30px;
        }
        .dashboard-intro,
        .performance-section {
            background-color: #d6b0d6;
            border-radius: 8px;
            padding: 30px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            flex: 1;
            min-width: 300px;
        }
        .dashboard-intro h2, .performance-section h2 {
            color: #333;
            margin-top: 0;
        }

        .results-table, .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .results-table th, .results-table td, .user-table th, .user-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .results-table th, .user-table th {
            background-color: #ed8aed;
            color: #333;
        }

        .progress-bar {
            width: 100%;
            background-color: #f0f0f0;
            border-radius: 25px;
            margin: 20px 0;
        }
        .progress-bar-fill {
            height: 20px;
            background-color: #4A90E2;
            border-radius: 25px;
            text-align: center;
            color: white;
            line-height: 20px;
            width: 0;
        }
    </style>
</head>
<body class="dashboard light-mode">
    <!-- Header Section -->
    <header class="dashboard-header">
        <div class="logo">
            <h1>MasteryLevels</h1>
        </div>
        <nav class="dashboard-nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="python_splash.php">Learn Python</a></li>
                <li><a href="exams.php">Exams</a></li>
                <li><a href="progress.php">Progress</a></li>
            </ul>
        </nav>
        <div class="user-info">
            <span>Hi, <?php echo htmlspecialchars($user); ?></span>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
            <!-- Light/Dark Mode Toggle -->
            <button class="mode-toggle-btn" id="mode-toggle-btn">Light/Dark</button>
        </div>
    </header>

    <div class="dashboard-content">
        <div class="dashboard-sections">
            <!-- Introduction Section -->
            <div class="dashboard-intro">
                <h2>Welcome back, <?php echo htmlspecialchars($user); ?>!</h2>
                <p>You can view your progress, take exams, and check your latest scores.</p>
            </div>

            <!-- Performance Statistics Section -->
            <div class="performance-section">
                <h2>Your Performance</h2>
                <p><strong>Total Exams Taken:</strong> <?php echo htmlspecialchars($totalExamsTaken); ?></p>
                <p><strong>Average Score:</strong> <?php echo number_format($averageScore, 2) . "%"; ?></p>

                <!-- Progress bar for average score -->
                <div class="progress-bar">
                    <div class="progress-bar-fill" style="width: <?php echo $averageScore; ?>%;">
                        <?php echo number_format($averageScore, 2); ?>%
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Exam Results Section -->
        <section class="dashboard-section">
            <h3>Recent Exam Results</h3>
            <?php if (!empty($recentResults)): ?>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Score</th>
                            <th>Total Questions</th>
                            <th>Percentage</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentResults as $result): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result['subject']); ?></td>
                                <td><?php echo htmlspecialchars($result['score']); ?></td>
                                <td><?php echo htmlspecialchars($result['total_questions']); ?></td>
                                <td><?php echo number_format(($result['score'] / $result['total_questions']) * 100, 2) . "%"; ?></td>
                                <td><form action="review_exam.php" method="get">
                                    <input type="hidden" name="subject" value="<?php echo htmlspecialchars($result['subject']); ?>">
                                    <button type="submit">Review</button>
                                </form></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No recent exam results available.</p>
            <?php endif; ?>
        </section>

        <!-- User Information Table -->
        <section class="dashboard-section">
            <h3>Your Information</h3>
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($userInfo['id']); ?></td>
                        <td><?php echo htmlspecialchars($userInfo['email']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($userInfo['role'])); ?></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>

    <script>
        // Toggle light/dark mode
        document.getElementById("mode-toggle-btn").addEventListener("click", function() {
            document.body.classList.toggle("dark-mode");
            document.body.classList.toggle("light-mode");
        });
    </script>
</body>
</html>
