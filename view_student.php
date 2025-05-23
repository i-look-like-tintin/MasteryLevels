<?php
session_start();

// Check if the user is logged in and has the role of 'teacher'
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
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

// *** CREATE Necessary Tables IF NOT EXISTS ***
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

// FETCH THE STUDENT ID FROM GET
if (!isset($_GET['id'])) {
    die("No student selected.");
}

$student_id = intval($_GET['id']);

// QUERY TO GET THE STUDENT'S INFORMATION
$studentQuery = $conn->prepare("SELECT email FROM users WHERE id = ? AND role = 'student'");
if ($studentQuery === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}
$studentQuery->bind_param("i", $student_id);
$studentQuery->execute();
$student_result = $studentQuery->get_result();

if ($student_result->num_rows == 0) {
    die("Student not found.");
}

$student = $student_result->fetch_assoc();
$studentQuery->close();

// QUERY TO GET THE STUDENT'S TEST RESULTS 
$resultsQuery = $conn->prepare("SELECT subject, score, total_questions FROM results WHERE student_id = ?");
if ($resultsQuery === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}
$resultsQuery->bind_param("i", $student_id);
$resultsQuery->execute();
$results_result = $resultsQuery->get_result();

// Initialize an array to store course progress
$course_progress = [];

// Populate the course_progress array with subjects, scores, and their completion status
while ($row = $results_result->fetch_assoc()) {
    $subject = $row['subject'];
    $score = (int)$row['score'];
    $total = (int)$row['total_questions'];

    // Calculate percentage; handle division by zero
    $percentage = ($total > 0) ? ($score / $total) * 100 : 0;

    // Determine if the course is completed (80% or above)
    $is_completed = ($percentage >= 80) ? true : false;

    // If the course already exists in the array, check if this attempt is better
    if (isset($course_progress[$subject])) {
        if ($percentage > $course_progress[$subject]['percentage']) {
            $course_progress[$subject]['score'] = $score;
            $course_progress[$subject]['total'] = $total;
            $course_progress[$subject]['percentage'] = $percentage;
            $course_progress[$subject]['completed'] = $is_completed;
        }
    } else {
        $course_progress[$subject] = [
            'score' => $score,
            'total' => $total,
            'percentage' => $percentage,
            'completed' => $is_completed
        ];
    }
}

$resultsQuery->close();

// *** FETCH ALL LEVELS FROM THE QUIZZES TABLE ***
$levels_query = "SELECT DISTINCT level FROM quizzes ORDER BY level ASC";
$levels_result = $conn->query($levels_query);

if (!$levels_result) {
    die("Error fetching levels: " . htmlspecialchars($conn->error));
}

$levels = [];
while ($level_row = $levels_result->fetch_assoc()) {
    $levels[] = $level_row['level'];
}

$levels_result->free();

// *** FETCH COURSES FOR EACH LEVEL AND CALCULATE COMPLETION ***
$level_completion = []; // Array to store completion percentage per level

foreach ($levels as $level) {
    // Fetch all courses for the current level
    $courses_query = $conn->prepare("SELECT DISTINCT subject FROM quizzes WHERE level = ?");
    if ($courses_query === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $courses_query->bind_param("s", $level);
    $courses_query->execute();
    $courses_result = $courses_query->get_result();

    if (!$courses_result) {
        die("Error fetching courses: " . htmlspecialchars($conn->error));
    }

    $total_courses = $courses_result->num_rows;
    $completed_courses = 0;

    while ($course_row = $courses_result->fetch_assoc()) {
        $subject = $course_row['subject'];
        if (isset($course_progress[$subject]) && $course_progress[$subject]['completed']) {
            $completed_courses++;
        }
    }

    // Calculate percentage completion for the level
    $percentage_complete = ($total_courses > 0) ? ($completed_courses / $total_courses) * 100 : 0;
    $level_completion[$level] = $percentage_complete;

    $courses_query->close();
}

// *** HANDLE RESET PROGRESS REQUEST ***
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_progress'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die("Invalid CSRF token");
    }

    // Get the subject from POST data
    if (isset($_POST['subject'])) {
        $subject = $conn->real_escape_string($_POST['subject']);
    } else {
        die("No subject specified.");
    }

    // Reset student_progress for this subject
    $resetProgressQuery = "DELETE FROM student_progress WHERE student_id = ? AND subject = ?";
    $stmt_reset = $conn->prepare($resetProgressQuery);
    if ($stmt_reset === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt_reset->bind_param("is", $student_id, $subject);
    if (!$stmt_reset->execute()) {
        die("Error resetting progress: " . htmlspecialchars($stmt_reset->error));
    }
    $stmt_reset->close();

    // Delete the previous result
    $deleteResultQuery = "DELETE FROM results WHERE student_id = ? AND subject = ?";
    $stmt_delete = $conn->prepare($deleteResultQuery);
    if ($stmt_delete === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt_delete->bind_param("is", $student_id, $subject);
    if (!$stmt_delete->execute()) {
        die("Error deleting previous result: " . htmlspecialchars($stmt_delete->error));
    }
    $stmt_delete->close();

    // Redirect to the same page to reflect changes
    header("Location: view_student.php?id=" . urlencode($student_id));
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results - <?php echo htmlspecialchars($student['email']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Inline CSS for demonstration; consider moving to styles.css */
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
            /* Ensure the content container is block-level */
            display: block;
        }
        .dashboard-section {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Ensure each section takes full width and stacks vertically */
            width: 100%;
            display: block;
            margin-bottom: 40px;
        }
        .dashboard-section h2 {
            margin-top: 0;
            color: #333;
        }
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
        /* Responsive Design */
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
        }
    </style>
</head>
<body class="dashboard">
<?php include 'teacher_navbar.php'; ?>

<div class="dashboard-content">
    <!-- Student Information Section -->
    <section class="dashboard-section">
        <h2>Student: <?php echo htmlspecialchars($student['email']); ?></h2>
        <!-- Reset Progress Button -->
        <form method="POST" style="margin-top: 20px;">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
            <input type="hidden" name="subject" value="<?php echo htmlspecialchars($subject); ?>">
            <button type="submit" name="reset_progress" class="btn retake-exam-btn" onclick="return confirm('Are you sure you want to reset this student\'s progress?');">Reset Progress</button>
        </form>
    </section>

    <!-- Courses Progress Section -->
    <section class="dashboard-section">
        <h2>Courses Progress</h2>
        <p>Here are the student's grades in each course. A course is marked as <strong>Completed</strong> if they've scored above 80%.</p>

        <?php if (empty($course_progress)): ?>
            <p>No test results found for this student.</p>
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
    <section class="dashboard-section">
        <h2>Levels Completion</h2>
        <p>Below is the completion status of each level based on the student's course performances.</p>

        <?php if (empty($level_completion)): ?>
            <p>No levels found for this student.</p>
        <?php else: ?>
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
                            <td class="<?php echo ($percentage >= 100) ? 'completed' : 'pending'; ?>">
                                <?php echo ($percentage >= 100) ? 'Completed' : 'Pending'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>
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
