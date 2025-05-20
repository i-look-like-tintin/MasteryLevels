<?php
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Handle logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Destroy the session and redirect to login
    session_destroy();
    header("Location: login.php");
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$currentUserId = $_SESSION['id'];

// Database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'exam_website';

// Connect to MySQL using mysqli with error handling
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Fetch student's results and progress
$results_query = "SELECT subject, score, total_questions FROM results WHERE student_id = ?";
$stmt = $conn->prepare($results_query);
$stmt->bind_param("i", $currentUserId);
$stmt->execute();
$results_result = $stmt->get_result();

$course_progress = [];
while ($row = $results_result->fetch_assoc()) {
    $subject = $row['subject'];
    $score = (int)$row['score'];
    $total = (int)$row['total_questions'];
    $percentage = ($total > 0) ? ($score / $total) * 100 : 0;
    $is_completed = ($percentage >= 80);

    $course_progress[$subject] = [
        'score' => $score,
        'total' => $total,
        'percentage' => $percentage,
        'completed' => $is_completed
    ];
}
$stmt->close();

// Fetch all levels from the quizzes table
$levels_query = "SELECT DISTINCT level FROM quizzes ORDER BY level ASC";
$levels_result = $conn->query($levels_query);

$levels = [];
while ($level_row = $levels_result->fetch_assoc()) {
    $levels[] = $level_row['level'];
}
$levels_result->free();

// Calculate completion for each level
$level_completion = [];
foreach ($levels as $level) {
    $courses_query = "SELECT subject FROM quizzes WHERE level = ?";
    $stmt = $conn->prepare($courses_query);
    $stmt->bind_param("s", $level);
    $stmt->execute();
    $courses_result = $stmt->get_result();

    $total_courses = $courses_result->num_rows;
    $completed_courses = 0;

    while ($course_row = $courses_result->fetch_assoc()) {
        $subject = $course_row['subject'];
        if (isset($course_progress[$subject]) && $course_progress[$subject]['completed']) {
            $completed_courses++;
        }
    }

    // Calculate completion percentage
    $percentage_complete = ($total_courses > 0) ? ($completed_courses / $total_courses) * 100 : 0;
    $level_completion[$level] = $percentage_complete;

    $stmt->close();
}

$_SESSION['level1_completed'] = isset($level_completion[1]) && $level_completion[1] >= 100;
$_SESSION['level2_completed'] = isset($level_completion[2]) && $level_completion[2] >= 100;

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Progress</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body.dashboard {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard-header {
            background-color: #333;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-header .logo h1 {
            margin: 0;
            font-size: 24px;
        }
        .dashboard-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .dashboard-nav ul li {
            margin-left: 20px;
        }
        .dashboard-nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }
        .user-info {
            font-size: 16px;
        }
        .logout-btn {
            background-color: #ff4d4d;
            border: none;
            padding: 8px 12px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .logout-btn:hover {
            background-color: #ff1a1a;
        }
        .dashboard-content {
            padding: 50px 20px;
            display: block;
        }
        .dashboard-section {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin-bottom: 40px;
        }
        .dashboard-section h2 {
            margin-top: 0;
            color: #333;
        }
        /* Progress Table Styles */
        .progress-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .progress-table th, .progress-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .progress-table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .completed {
            background-color: #c8e6c9;
            color: #2e7d32;
            font-weight: bold;
        }
        .pending {
            background-color: #ffcdd2;
            color: #c62828;
            font-weight: bold;
        }
        /* Level Completion Styles */
        .level-progress table th, .level-progress table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .level-progress table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .level-complete {
            background-color: #c8e6c9;
            color: #2e7d32;
            font-weight: bold;
        }
        .level-pending {
            background-color: #ffcdd2;
            color: #c62828;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .dashboard-nav ul {
                flex-direction: column;
                align-items: flex-start;
            }
            .dashboard-nav ul li {
                margin-left: 0;
                margin-top: 10px;
            }
            .progress-table th, .progress-table td {
                padding: 8px;
            }
            .level-progress table th, .level-progress table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body class="dashboard">
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
        <form method="POST" style="display: inline;">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>
</header>

<div class="dashboard-content">
    <!-- Courses Progress Section -->
    <section class="dashboard-section">
        <h2>Courses Progress</h2>
        <p>Here are your grades in each course. A course is marked as <strong>Completed</strong> if you've scored above 80%.</p>

        <?php if (empty($course_progress)): ?>
            <p>You haven't taken any exams yet.</p>
        <?php else: ?>
            <table class="progress-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Score</th>
                        <th>Percentage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($course_progress as $subject => $data): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject); ?></td>
                            <td><?php echo htmlspecialchars($data['score']) . " / " . htmlspecialchars($data['total']); ?></td>
                            <td><?php echo number_format($data['percentage'], 2) . "%"; ?></td>
                            <td class="<?php echo $data['completed'] ? 'completed' : 'pending'; ?>">
                                <?php echo $data['completed'] ? 'Completed' : 'Pending'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <!-- Levels Completion Section -->
    <section class="dashboard-section level-progress">
        <h2>Levels Completion</h2>
        <p>Below is the completion status of each level based on your course performances.</p>

        <table class="progress-table">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>Percentage Complete</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($level_completion as $level => $percentage): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($level); ?></td>
                        <td><?php echo number_format($percentage, 2) . "%"; ?></td>
                        <td class="<?php echo ($percentage >= 100) ? 'level-complete' : 'level-pending'; ?>">
                            <?php echo ($percentage >= 100) ? 'Completed' : 'Pending'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>
