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
$createUsersTableQuery = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('student', 'teacher') NOT NULL
    )
";
if ($conn->query($createUsersTableQuery) === FALSE) {
    die("Error creating users table: " . htmlspecialchars($conn->error));
}

$createProgressTableQuery = "
    CREATE TABLE IF NOT EXISTS student_progress (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        question_id INT NOT NULL,
        selected_option CHAR(1),
        completed BOOLEAN DEFAULT 0,
        UNIQUE KEY unique_progress (student_id, subject, question_id),
        FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
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

// *** HANDLE ADD STUDENT ***
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Retrieve and sanitize input
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //TODO: register page should also have this check
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $checkEmailQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmailQuery->bind_param("s", $email);
        $checkEmailQuery->execute();
        $checkEmailResult = $checkEmailQuery->get_result();

        if ($checkEmailResult->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new student
            $insertStudentQuery = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'student')");
            $insertStudentQuery->bind_param("ss", $email, $hashed_password);

            if ($insertStudentQuery->execute()) {
                $success = "Student added successfully.";
            } else {
                $error = "Error adding student: " . htmlspecialchars($insertStudentQuery->error);
            }

            $insertStudentQuery->close();
        }

        $checkEmailQuery->close();
    }
}

// *** HANDLE DELETE STUDENT ***
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Retrieve and sanitize student ID
    $student_id = intval($_POST['student_id']);

    // Prevent deleting oneself
    if ($student_id == $_SESSION['id']) {
        $error = "You cannot delete your own account.";
    } else {
        // Delete student
        $deleteStudentQuery = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'student'");
        $deleteStudentQuery->bind_param("i", $student_id);

        if ($deleteStudentQuery->execute()) {
            if ($deleteStudentQuery->affected_rows > 0) {
                $success = "Student deleted successfully.";
            } else {
                $error = "Student not found or already deleted.";
            }
        } else {
            $error = "Error deleting student: " . htmlspecialchars($deleteStudentQuery->error);
        }

        $deleteStudentQuery->close();
    }
}

// *** FETCH ALL STUDENTS ***
$studentsQuery = "SELECT id, email FROM users WHERE role = 'student'";
$studentsResult = $conn->query($studentsQuery);

if (!$studentsResult) {
    die("Error fetching students: " . htmlspecialchars($conn->error));
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - MasteryLevels</title>
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
            flex-direction: column;
            gap: 40px;
        }
        /* Manage Students Section */
        .manage-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
        .form-group input {
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
        /* Students Table */
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    </style>
</head>
<body class="dashboard">
    <header class="dashboard-header">
        <div class="logo">
            <h1>MasteryLevels - Manage Students</h1>
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
        <!-- Manage Students Section -->
        <section class="manage-section">
            <h2>Add New Student</h2>

            <?php if (isset($error)): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="message success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <div class="form-group">
                    <label for="email">Student Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_student">Add Student</button>
                </div>
            </form>

            <h2>Existing Students</h2>
            <?php if ($studentsResult->num_rows > 0): ?>
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($student = $studentsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['id']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display: inline;">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['id']); ?>">
                                        <button type="submit" name="delete_student" class="delete-btn">Delete</button>
                                    </form>
                                    <!-- Optional: Add Edit functionality here -->
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
