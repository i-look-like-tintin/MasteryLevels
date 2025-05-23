<?php
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// *** CREATE Necessary Tables IF NOT EXISTS ***
$createQuizzesTableQuery = "
    CREATE TABLE IF NOT EXISTS quizzes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(255) NOT NULL,
        level VARCHAR(50) NOT NULL,
        question TEXT NOT NULL,
        option_a VARCHAR(255) NOT NULL,
        option_b VARCHAR(255) NOT NULL,
        option_c VARCHAR(255) NOT NULL,
        option_d VARCHAR(255) NOT NULL,
        correct_option CHAR(1) NOT NULL
    )
";
if ($conn->query($createQuizzesTableQuery) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}

// *** HANDLE LOGOUT ***
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

// *** HANDLE ADD QUIZ ***
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_quiz'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Retrieve and sanitize input
    $subject = trim($_POST['subject']);
    $level = trim($_POST['level']);
    $question = trim($_POST['question']);
    $option_a = trim($_POST['option_a']);
    $option_b = trim($_POST['option_b']);
    $option_c = trim($_POST['option_c']);
    $option_d = trim($_POST['option_d']);
    $correct_option = strtoupper(trim($_POST['correct_option']));

    // Basic validation
    if (empty($subject) || empty($level) || empty($question) || empty($option_a) || empty($option_b) || empty($option_c) || empty($option_d) || empty($correct_option)) {
        $error = "All fields are required.";
    } elseif (!in_array($correct_option, ['A', 'B', 'C', 'D'])) {
        $error = "Correct option must be one of A, B, C, or D.";
    } else {
        // Insert new quiz
        $insertQuizQuery = $conn->prepare("INSERT INTO quizzes (subject, level, question, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertQuizQuery->bind_param("ssssssss", $subject, $level, $question, $option_a, $option_b, $option_c, $option_d, $correct_option);

        if ($insertQuizQuery->execute()) {
            $success = "Quiz added successfully.";
        } else {
            $error = "Error adding quiz: " . htmlspecialchars($insertQuizQuery->error);
        }

        $insertQuizQuery->close();
    }
}

// *** HANDLE DELETE QUIZ ***
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_quiz'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Retrieve and sanitize quiz ID
    $quiz_id = intval($_POST['quiz_id']);

    // Delete quiz
    $deleteQuizQuery = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
    $deleteQuizQuery->bind_param("i", $quiz_id);

    if ($deleteQuizQuery->execute()) {
        if ($deleteQuizQuery->affected_rows > 0) {
            $success = "Quiz deleted successfully.";
        } else {
            $error = "Quiz not found or already deleted.";
        }
    } else {
        $error = "Error deleting quiz: " . htmlspecialchars($deleteQuizQuery->error);
    }

    $deleteQuizQuery->close();
}

// *** FETCH ALL QUIZZES ***
$quizzesQuery = "SELECT * FROM quizzes";
$quizzesResult = $conn->query($quizzesQuery);

if (!$quizzesResult) {
    die("Error fetching quizzes: " . htmlspecialchars($conn->error));
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quizzes - MasteryLevels</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Base Styles */
        body.dashboard {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
        }
        /* Manage Quizzes Section */
        .manage-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: 0 auto 40px auto;
            width: 100%;
            box-sizing: border-box;
            overflow-x: auto; /* Add this line */
        }
        .manage-section h2 {
            margin-top: 0;
            color: #333;
            margin-bottom: 20px;
        }
        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #4A90E2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #357ABD;
        }
        /* Error and Success Messages */
        .message {
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .error {
            background-color: #FFC9C9;
            color: #D8000C;
        }
        .success {
            background-color: #C9FFD5;
            color: #4F8A10;
        }
        /* Quizzes Table */
        .quizzes-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            min-width: 900px; /* Set a min-width so it scrolls on small screens */
            box-sizing: border-box;
        }
        .quizzes-table th, .quizzes-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .quizzes-table th {
            background-color: #f7f7f7;
            color: #333;
        }
        .quizzes-table tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn {
            background-color: #FF5C5C;
            border: none;
            padding: 6px 12px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-btn:hover {
            background-color: #FF1E1E;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-content {
                padding: 30px 20px;
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
        @media (max-width: 1100px) {
            .manage-section {
                max-width: 100vw;
                padding: 20px 5px;
            }
            .quizzes-table {
                min-width: 700px;
                font-size: 14px;
            }
        }
        /* Scrollable Table Container */
        .table-scroll {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 10px;
        }
    </style>
</head>
<body class="dashboard">
     <?php include 'teacher_navbar.php'; ?>
    <div class="dashboard-content">
        <!-- Manage Quizzes Section -->
        <section class="manage-section">
            <h2>Add New Quiz</h2>

            <?php if (isset($error)): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="message success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="level">Level:</label>
                    <select id="level" name="level" required>
                        <option value="">Select Level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="question">Question:</label>
                    <textarea id="question" name="question" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="option_a">Option A:</label>
                    <input type="text" id="option_a" name="option_a" required>
                </div>
                <div class="form-group">
                    <label for="option_b">Option B:</label>
                    <input type="text" id="option_b" name="option_b" required>
                </div>
                <div class="form-group">
                    <label for="option_c">Option C:</label>
                    <input type="text" id="option_c" name="option_c" required>
                </div>
                <div class="form-group">
                    <label for="option_d">Option D:</label>
                    <input type="text" id="option_d" name="option_d" required>
                </div>
                <div class="form-group">
                    <label for="correct_option">Correct Option (A/B/C/D):</label>
                    <input type="text" id="correct_option" name="correct_option" maxlength="1" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_quiz">Add Quiz</button>
                </div>
            </form>

            <h2>Existing Quizzes</h2>
            <?php if ($quizzesResult->num_rows > 0): ?>
                <div class="table-scroll">
                    <table class="quizzes-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Level</th>
                                <th>Question</th>
                                <th>Option A</th>
                                <th>Option B</th>
                                <th>Option C</th>
                                <th>Option D</th>
                                <th>Correct Option</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($quiz = $quizzesResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($quiz['id']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['level']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['question']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['option_a']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['option_b']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['option_c']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['option_d']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['correct_option']); ?></td>
                                    <td>
                                        <!-- Optional: Add Edit functionality here -->
                                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');" style="display: inline;">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                            <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz['id']); ?>">
                                            <button type="submit" name="delete_quiz" class="delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No quizzes found.</p>
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
