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

// CREATE  Tables IF NOT EXISTS
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
        FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY unique_result (student_id, subject)
    )
";
if ($conn->query($createResultsTableQuery) === FALSE) {
    die("Error creating results table: " . htmlspecialchars($conn->error));
}

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

// FETCH OVERVIEW STATISTICS

// Total Students
$totalStudentsQuery = "SELECT COUNT(*) AS total FROM users WHERE role = 'student'";
$totalStudentsResult = $conn->query($totalStudentsQuery);
$totalStudents = $totalStudentsResult->fetch_assoc()['total'] ?? 0;

// Total Quizzes
$totalQuizzesQuery = "SELECT COUNT(DISTINCT subject) AS total FROM quizzes";
$totalQuizzesResult = $conn->query($totalQuizzesQuery);
$totalQuizzes = $totalQuizzesResult->fetch_assoc()['total'] ?? 0;

// Total Exams Taken
$totalExamsQuery = "SELECT COUNT(*) AS total FROM results";
$totalExamsResult = $conn->query($totalExamsQuery);
$totalExams = $totalExamsResult->fetch_assoc()['total'] ?? 0;

// Average Score Across All Quizzes
$averageScoreQuery = "SELECT AVG((score / total_questions) * 100) AS average_percentage FROM results";
$averageScoreResult = $conn->query($averageScoreQuery);
$averageScore = $averageScoreResult->fetch_assoc()['average_percentage'] ?? 0;

// Pass Rate (Assuming pass mark is 80%)
$passRateQuery = "SELECT COUNT(*) AS passed FROM results WHERE (score / total_questions) * 100 >= 80";
$passRateResult = $conn->query($passRateQuery);
$passRate = ($totalExams > 0) ? ($passRateResult->fetch_assoc()['passed'] / $totalExams) * 100 : 0;

// FETCH STUDENT AVERAGE PERFORMANCE DATA
$studentPerformanceQuery = "
    SELECT u.email, AVG((r.score / r.total_questions) * 100) AS average_percentage
    FROM results r
    JOIN users u ON r.student_id = u.id
    GROUP BY u.id
";
$studentPerformanceResult = $conn->query($studentPerformanceQuery);

// Initialize arrays for charts
$students = [];
$averageScores = [];

// Process student performance data
if ($studentPerformanceResult->num_rows > 0) {
    while ($row = $studentPerformanceResult->fetch_assoc()) {
        $students[] = $row['email'];
        $averageScores[] = round($row['average_percentage'], 2);
    }
}

// Calculate top-performing students
$topStudentsQuery = "
    SELECT u.email, r.subject, r.score, r.total_questions, (r.score / r.total_questions) * 100 AS percentage
    FROM results r
    JOIN users u ON r.student_id = u.id
    ORDER BY percentage DESC
    LIMIT 5
";
$topStudentsResult = $conn->query($topStudentsQuery);

// Calculate lowest-performing students
$lowestStudentsQuery = "
    SELECT u.email, r.subject, r.score, r.total_questions, (r.score / r.total_questions) * 100 AS percentage
    FROM results r
    JOIN users u ON r.student_id = u.id
    ORDER BY percentage ASC
    LIMIT 5
";
$lowestStudentsResult = $conn->query($lowestStudentsQuery);

// Calculate quizzes difficulty (average score per quiz)
$quizzesDifficultyQuery = "
    SELECT subject, AVG((score / total_questions) * 100) AS average_percentage
    FROM results
    GROUP BY subject
    ORDER BY average_percentage ASC
";
$quizzesDifficultyResult = $conn->query($quizzesDifficultyQuery);

// Fetch exams over time (monthly)
$examsOverTimeQuery = "
    SELECT DATE_FORMAT(exam_date, '%Y-%m') AS month, COUNT(*) AS total
    FROM results
    GROUP BY month
    ORDER BY month ASC
";
$examsOverTimeResult = $conn->query($examsOverTimeQuery);

// CLOSE DATABASE CONNECTION
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - MasteryLevels</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Base Styles */
        body.dashboard {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
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
        /* Reports Sections */
        .report-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .report-section h2 {
            margin-top: 0;
            color: #333;
            margin-bottom: 20px;
        }
        /* Flexbox for side-by-side sections */
        .reports-flex {
            display: flex;
            gap: 40px; /* Increased from 20px to 40px */
        }
        /* Space between stacked report sections */
        .report-section {
            margin-top: 40px; /* Add space above each report section */
        }
        .report-section:first-of-type {
            margin-top: 40px; /* No margin for the first section */
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
        @media (max-width: 1050px) {
    .reports-flex {
        flex-direction: column;
        gap: 40px; /* keep vertical space between sections */
    }
    .report-section {
        min-width: 0;
        width: 100%;
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
<?php include 'teacher_navbar.php'; ?>

    <div class="dashboard-content">
        <!-- Overview Statistics -->
        <section class="report-section">
            <h2>Overview Statistics</h2>
            <div class="overview-cards">
                <div class="card">
                    <h3>Total Students</h3>
                    <p><?php echo htmlspecialchars($totalStudents); ?></p>
                </div>
                <div class="card">
                    <h3>Total Quizzes</h3>
                    <p><?php echo htmlspecialchars($totalQuizzes); ?></p>
                </div>
                <div class="card">
                    <h3>Total Exams Taken</h3>
                    <p><?php echo htmlspecialchars($totalExams); ?></p>
                </div>
                <div class="card">
                    <h3>Average Score</h3>
                    <p><?php echo number_format($averageScore, 2) . "%"; ?></p>
                </div>
                <div class="card">
                    <h3>Pass Rate</h3>
                    <p><?php echo number_format($passRate, 2) . "%"; ?></p>
                </div>
                <div class="card">
                    <h3>Highest Score Achieved</h3>
                    <p><?php echo htmlspecialchars($highestScore) . htmlspecialchars($highestScoreSubject); ?></p>
                </div>
            </div>
        </section>

        <!-- Reports Sections -->
        <div class="reports-flex">
            <!-- Student Performance Chart -->
            <section class="report-section" style="flex: 1;">
                <h2>Student Average Performance</h2>
                <canvas id="studentPerformanceChart"></canvas>
            </section>

            <!-- Top Performing Students -->
            <section class="report-section" style="flex: 1;">
                <h2>Top Performing Students</h2>
                <?php
                if ($topStudentsResult->num_rows > 0) {
                    echo '<table style="width:100%; border-collapse: collapse;">';
                    echo '<thead><tr><th>Email</th><th>Course</th><th>Score</th><th>Percentage</th></tr></thead><tbody>';
                    while ($row = $topStudentsResult->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['subject']) . '</td>'; // Added course
                        echo '<td>' . htmlspecialchars($row['score']) . ' / ' . htmlspecialchars($row['total_questions']) . '</td>';
                        echo '<td>' . number_format($row['percentage'], 2) . '%</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p>No student performance data available.</p>';
                }
                ?>
            </section>
        </div>

        <!-- Lowest Performing Students -->
        <section class="report-section">
            <h2>Lowest Performing Students</h2>
            <?php
            if ($lowestStudentsResult->num_rows > 0) {
                echo '<table style="width:100%; border-collapse: collapse;">';
                echo '<thead><tr><th>Email</th><th>Course</th><th>Score</th><th>Percentage</th></tr></thead><tbody>';
                while ($row = $lowestStudentsResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['subject']) . '</td>'; // Added course
                    echo '<td>' . htmlspecialchars($row['score']) . ' / ' . htmlspecialchars($row['total_questions']) . '</td>';
                    echo '<td>' . number_format($row['percentage'], 2) . '%</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>No student performance data available.</p>';
            }
            ?>
        </section>
    </div>

    <!-- Chart Scripts -->
    <script>
        // Student Performance Chart
        const studentPerformanceCtx = document.getElementById('studentPerformanceChart').getContext('2d');
        const studentPerformanceChart = new Chart(studentPerformanceCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($students); ?>,
                datasets: [{
                    label: 'Average Score (%)',
                    data: <?php echo json_encode($averageScores); ?>,
                    backgroundColor: 'rgba(74, 144, 226, 0.6)',
                    borderColor: 'rgba(74, 144, 226, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Average Scores of Students'
                    }
                }
            }
        });
    </script>
    <script>
    function adjustDashboardPadding() {
    var header = document.querySelector('.dashboard-header');
    var content = document.querySelector('.dashboard-content');
    if (header && content) {
        content.style.paddingTop = (header.offsetHeight + 20) + 'px';
    }
    }
window.addEventListener('DOMContentLoaded', adjustDashboardPadding);
window.addEventListener('resize', adjustDashboardPadding);
</script>
</body>
</html>
