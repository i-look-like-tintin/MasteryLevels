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

    $stmt->close();
}

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
    <title>MasteryLevels - Exam Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Default (light mode) styles */
        :root {
            --bg-color: #f0f4f8;
            --text-color: #333;
            --button-bg: #007bff;
            --button-hover-bg: #0056b3;
            --button-disabled-bg: #ccc;
            --header-bg: #ffffff;
            --header-text-color: #333;
            --table-bg: #fff;
            --table-header-bg: #4A90E2;
            --table-header-text-color: white;
            --completed-bg: #c8e6c9;
            --completed-text-color: #2e7d32;
            --pending-bg: #ffcdd2;
            --pending-text-color: #c62828;
            --logout-bg: #FF5C5C;
            --logout-hover-bg: #FF1E1E;
        }

        /* Dark mode styles */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .dashboard-content {
            background-color: #1f1f1f;
        }

        body.dark-mode .dashboard-header {
            background-color: #333;
            color: #e0e0e0;
        }

        body.dark-mode .progress-table th {
            background-color: #333;
            color: #e0e0e0;
        }

        body.dark-mode .progress-table td {
            background-color: #333;
            color: #e0e0e0;
        }

        body.dark-mode .completed {
            background-color: #4caf50;
            color: #fff;
        }

        body.dark-mode .pending {
            background-color: #f44336;
            color: #fff;
        }

        body.dark-mode .logout-btn {
            background-color: #d32f2f;
        }

        body.dark-mode .logout-btn:hover {
            background-color: #b71c1c;
        }

        body.dark-mode .level-btn {
            background-color: #333;
            color: #e0e0e0;
        }

        body.dark-mode .level-btn:hover {
            background-color: #555;
        }

        body.dark-mode .disabled {
            background-color: #555;
            color: #ccc;
            cursor: not-allowed;
        }

        /* Light Mode */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: var(--header-bg);
            color: var(--header-text-color);
        }

        .dashboard-header a {
            text-decoration: none;
            color: var(--text-color);
            padding: 10px;
        }

        .dashboard-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: var(--bg-color);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .dashboard-section {
            margin-bottom: 40px;
            width: 100%;
            max-width: 800px;
            text-align: center;
        }

        .level-btn {
            background-color: var(--button-bg);
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .level-btn:hover {
            background-color: var(--button-hover-bg);
        }

        .disabled {
            background-color: var(--button-disabled-bg);
            color: #666;
            cursor: not-allowed;
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
            background-color: var(--table-header-bg);
            color: var(--table-header-text-color);
        }

        .progress-table td {
            background-color: var(--table-bg);
        }

        .completed {
            background-color: var(--completed-bg);
            color: var(--completed-text-color);
        }

        .pending {
            background-color: var(--pending-bg);
            color: var(--pending-text-color);
        }

        /* Logout Button Style */
        .logout-btn {
            background-color: var(--logout-bg);
            border: none;
            padding: 8px 16px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: var(--logout-hover-bg);
        }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ccc;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 50%;
        }

        .theme-toggle-btn:hover {
            background-color: #aaa;
        }

    </style>
    <script>
        // Check if user has a saved theme preference
        window.onload = function() {
            const theme = localStorage.getItem('theme');
            if (theme) {
                document.body.classList.add(theme);
            }
        }

        // Function to toggle between light and dark mode
        function toggleTheme() {
            const currentTheme = document.body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode';
            const newTheme = currentTheme === 'light-mode' ? 'dark-mode' : 'light-mode';

            // Toggle class on body to switch themes
            document.body.classList.remove(currentTheme);
            document.body.classList.add(newTheme);

            // Save user preference in localStorage
            localStorage.setItem('theme', newTheme);
        }
    </script>
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
        <!-- Theme Toggle Button -->
        <button class="theme-toggle-btn" onclick="toggleTheme()">🌙/🌞</button>

        <section class="dashboard-section">
            <h2>Select a Course Level</h2>
            <div class="level-buttons">
                <a href="level1.php" class="level-btn">Level 1 Courses</a>
                <a href="<?php echo $level1_completed ? 'level2.php' : '#'; ?>"
                   class="level-btn <?php echo $level1_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level1_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Level 2 Courses</a>
                <a href="<?php echo $level2_completed ? 'level3.php' : '#'; ?>"
                   class="level-btn <?php echo $level2_completed ? '' : 'disabled'; ?>"
                   style="<?php echo !$level2_completed ? 'background-color: #ccc; color: #666; cursor: not-allowed; pointer-events: none;' : ''; ?>">
                    Level 3 Courses
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
