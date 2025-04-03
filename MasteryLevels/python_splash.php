<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Handle logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
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
}
    $progress_query = "SELECT python_progression FROM results WHERE student_id = " . $currentUserId;
    $stmt = $conn->query($progress_query);
    if ($stmt->num_rows > 0) {
        $row = $stmt->fetch_assoc();
        $integerValue = (int) $row['python_progression'];

        echo'<script>console.log(' . json_encode($integerValue) . ');</script>';
    }
    else {
        $insertResultQuery = "
        INSERT INTO results (student_id, subject, score, total_questions)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE score = VALUES(score), total_questions = VALUES(total_questions), exam_date = CURRENT_TIMESTAMP
        ";
        $stmt_insert = $conn->prepare($insertResultQuery);
        if ($stmt_insert === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        $subject = "Test";
        $score = 0;
        $total_questions = 1;
        $stmt_insert->bind_param("isii", $currentUserId, $subject, $score, $total_questions);
        if (!$stmt_insert->execute()) {
            die("Error inserting results: " . htmlspecialchars($stmt_insert->error));
        }
        $stmt_insert->close();
    }


    $stmt->close();


// Calculate level completion based on the correct keys
$level1_completed = isset($level_completion['Level 1']) && $level_completion['Level 1'] >= 100;
$level2_completed = isset($level_completion['Level 2']) && $level_completion['Level 2'] >= 100;
$level3_completed = isset($level_completion['Level 3']) && $level_completion['Level 3'] >= 100;

// Session tracking
$_SESSION['level1_completed'] = $level1_completed;
$_SESSION['level2_completed'] = $level2_completed;
$_SESSION['level3_completed'] = $level3_completed;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasteryLevels - Python Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #f0f4f8;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .dashboard-section {
            display: flex;
            flex-direction: column;
            margin-bottom: 40px;
            width: 100%;
            max-width: 800px;
            text-align: center;
        }

        .progress-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .progress-table th, .progress-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .progress-table th {
            background-color: #4A90E2;
            color: white;
        }

        .progress-table td {
            background-color: #f9f9f9;
        }

        .completed {
            background-color: #c8e6c9;
            color: #2e7d32;
        }

        .pending {
            background-color: #ffcdd2;
            color: #c62828;
        }

        .level-buttons {
            max-width: 700px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        /* Logout Button Style */
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
    </style>
</head>
<body class="dashboard">
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
            <form method="POST" style="display:inline;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <div class="dashboard-content">
        <section class="dashboard-section">
            <h2>Select a Python Mastery Level</h2>
            <div class="level-buttons">
                <a href="python_level1_welcome.php" class="level-btn">Python Level 1 Learning</a>
                <a href="python_level1_test.php" class="level-btn">Python Level 1 Test</a>
                <a href="<?php echo $level1_completed ? 'python_level2.php' : '#'; ?>"
                   class="level-btn <?php echo $level1_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level1_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 2 Learning</a>
                    <a href="<?php echo $level1_completed ? 'python_level2_test.php' : '#'; ?>"
                   class="level-btn <?php echo $level1_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level1_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 2 Test</a>
                <a href="<?php echo $level2_completed ? 'python_level3.php' : '#'; ?>"
                   class="level-btn <?php echo $level2_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level2_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 3 Learning
                </a>
                <a href="<?php echo $level1_completed ? 'python_level3_test.php' : '#'; ?>"
                   class="level-btn <?php echo $level1_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level1_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 3 Test</a>
                <a href="<?php echo $level2_completed ? 'python_level4.php' : '#'; ?>"
                   class="level-btn <?php echo $level2_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level2_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 4 Learning
                </a>
                <a href="<?php echo $level1_completed ? 'python_level4_test.php' : '#'; ?>"
                   class="level-btn <?php echo $level1_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level1_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 4 Test</a>
                <a href="<?php echo $level2_completed ? 'python_level5.php' : '#'; ?>"
                   class="level-btn <?php echo $level2_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level2_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 5 Learning
                </a>
                <a href="<?php echo $level2_completed ? 'python_level5_test.php' : '#'; ?>"
                   class="level-btn <?php echo $level2_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level2_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 5 Test
                </a>
                <a href="<?php echo $level2_completed ? 'python_level6.php' : '#'; ?>"
                   class="level-btn <?php echo $level2_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level2_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 6 Learning
                </a>
                <a href="<?php echo $level2_completed ? 'python_level6_test.php' : '#'; ?>"
                   class="level-btn <?php echo $level2_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level2_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Python Level 6 Test
                </a>
            </div>
        </section>

        <section class="dashboard-section">
            <h2>Levels Completion</h2>
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
                            <td><?php echo htmlspecialchars("Level " . $level); ?></td>
                            <td><?php echo number_format($percentage, 2) . "%"; ?></td>
                            <td class="<?php echo ($percentage >= 100) ? 'completed' : 'pending'; ?>">
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
