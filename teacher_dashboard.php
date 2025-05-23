<?php
session_start();

// Check if the user is logged in and has the role of 'teacher'
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

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

//  CREATE Necessary Tables IF NOT EXISTS
$createProgressTableQuery = "
    CREATE TABLE IF NOT EXISTS student_progress (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        question_id INT NOT NULL,
        selected_option CHAR(1),
        completed BOOLEAN DEFAULT 0,
        UNIQUE KEY unique_progress (student_id, subject, question_id)
    )
";
if ($conn->query($createProgressTableQuery) === FALSE) {
    die("Error creating student_progress table: " . htmlspecialchars($conn->error));
}

$createResultsTableQuery = "
    CREATE TABLE IF NOT EXISTS results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        score INT NOT NULL,
        total_questions INT NOT NULL,
        exam_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_result (student_id, subject)
    )
";
if ($conn->query($createResultsTableQuery) === FALSE) {
    die("Error creating results table: " . htmlspecialchars($conn->error));
}

// FETCH OVERVIEW STATISTICS
// Total Students
$totalStudentsQuery = "SELECT COUNT(*) AS total FROM users WHERE role = 'student'";
$totalStudentsResult = $conn->query($totalStudentsQuery);
$totalStudents = $totalStudentsResult->fetch_assoc()['total'] ?? 0;

// Total Quizzes
$totalQuizzesQuery = "SELECT COUNT(DISTINCT subject) AS total FROM quizzes";
$totalQuizzesResult = $conn->query($totalQuizzesQuery);
$totalQuizzes = $totalQuizzesResult->fetch_assoc()['total'] ?? 0;

// Average Score Across All Quizzes
$averageScoreQuery = "SELECT AVG((score / total_questions) * 100) AS average_percentage FROM results";
$averageScoreResult = $conn->query($averageScoreQuery);
$averageScore = $averageScoreResult->fetch_assoc()['average_percentage'] ?? 0;

// Pass Rate (Assuming pass mark is 80%)
$passRateQuery = "SELECT COUNT(*) AS passed FROM results WHERE (score / total_questions) * 100 >= 80";
$passRateResult = $conn->query($passRateQuery);
$passRate = ($totalQuizzes > 0) ? ($passRateResult->fetch_assoc()['passed'] / $totalQuizzes) * 100 : 0;

// FETCH RECENT ACTIVITIES
$recentActivitiesQuery = "
    SELECT r.student_id, u.email, r.subject, r.score, r.total_questions, r.exam_date
    FROM results r
    JOIN users u ON r.student_id = u.id
    ORDER BY r.exam_date DESC
    LIMIT 5
";
$recentActivitiesResult = $conn->query($recentActivitiesQuery);

//FETCH ALL STUDENTS FOR MANAGEMENT
$studentsQuery = "SELECT id, email FROM users WHERE role = 'student'";
$studentsResult = $conn->query($studentsQuery);

// HANDLE LOGOUT
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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - MasteryLevels</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Base Styles */
        body.dashboard {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
        }
        /* Header */
        .dashboard-header {
            background-color: #4A90E2;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        /* Dashboard Content */
        .dashboard-content {
            padding: 40px 50px;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        /* Overview Cards */
        .overview-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            flex: 1 1 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin: 10px 0 5px 0;
            color: #4A90E2;
        }
        .card p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        /* Recent Activities */
        .recent-activities {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .recent-activities h2 {
            margin-top: 0;
            color: #333;
        }
        .activities-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .activities-table th, .activities-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .activities-table th {
            background-color: #f7f7f7;
            color: #333;
        }
        /* Students Management */
        .students-management {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .students-management h2 {
            margin-top: 0;
            color: #333;
        }
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .students-table th, .students-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .students-table th {
            background-color: #f7f7f7;
            color: #333;
        }
        .students-table tr:hover {
            background-color: #f1f1f1;
        }
        .view-btn {
            background-color: #4A90E2;
            border: none;
            padding: 6px 12px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .view-btn:hover {
            background-color: #357ABD;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-content {
                padding: 30px 20px;
            }
            .dashboard-nav ul li {
                margin-left: 15px;
            }
            .overview-cards {
                flex-direction: column;
            }
        }
        @media (max-width: 480px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .dashboard-nav ul {
                flex-direction: column;
                width: 100%;
            }
            .dashboard-nav ul li {
                margin-left: 0;
                margin-top: 10px;
            }
            .user-info {
                margin-top: 10px;
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
                <li><a href="teacher_dashboard.php">Dashboard</a></li>
                <li><a href="manage_students.php">Manage Students</a></li>
                <li><a href="manage_quizzes.php">Manage Quizzes</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </nav>
        <div class="user-info">
            <span>Hi, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
        </div>
    </header>

    <div class="dashboard-content">
        <!-- Overview Statistics -->
        <section class="dashboard-section overview-cards">
            <div class="card">
                <h3>Total Students</h3>
                <p><?php echo htmlspecialchars($totalStudents); ?></p>
            </div>
            <div class="card">
                <h3>Total Quizzes</h3>
                <p><?php echo htmlspecialchars($totalQuizzes); ?></p>
            </div>
            <div class="card">
                <h3>Average Exam Score</h3>
                <p><?php echo number_format($averageScore, 2) . "%"; ?></p>
            </div>
            <div class="card">
                <h3>Student Completion</h3>
                <p><?php echo number_format($passRate, 2) . "%"; ?></p>
            </div>
        </section>

        <!-- Recent Activities -->
        <section class="dashboard-section recent-activities">
            <h2>Recent Exam Submissions</h2>
            <?php if ($recentActivitiesResult->num_rows > 0): ?>
                <table class="activities-table">
                    <thead>
                        <tr>
                            <th>Student Email</th>
                            <th>Subject</th>
                            <th>Score</th>
                            <th>Total Questions</th>
                            <th>Exam Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($activity = $recentActivitiesResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($activity['email']); ?></td>
                                <td><?php echo htmlspecialchars($activity['subject']); ?></td>
                                <td><?php echo htmlspecialchars($activity['score']); ?></td>
                                <td><?php echo htmlspecialchars($activity['total_questions']); ?></td>
                                <td><?php echo htmlspecialchars(date("F j, Y, g:i a", strtotime($activity['exam_date']))); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No recent exam submissions.</p>
            <?php endif; ?>
        </section>

        <!-- Students Management -->
        <section class="dashboard-section students-management">
            <h2>Students Management</h2>
            <?php if ($studentsResult->num_rows > 0): ?>
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($student = $studentsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td>
                                    <a href="view_student.php?id=<?php echo urlencode($student['id']); ?>" class="view-btn">View Results</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No students found.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
