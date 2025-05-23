<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="dashboard-header">
    <div class="logo">
        <h1>MasteryLevels</h1>
    </div>
    <nav class="dashboard-nav" id="dashboardNav">
        <ul>
            <li><a href="teacher_dashboard.php" class="<?php echo $currentPage == 'teacher_dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="manage_students.php" class="<?php echo $currentPage == 'manage_students.php' ? 'active' : ''; ?>">Manage Students</a></li>
            <li><a href="manage_quizzes.php" class="<?php echo $currentPage == 'manage_quizzes.php' ? 'active' : ''; ?>">Manage Quizzes</a></li>
            <li><a href="reports.php" class="<?php echo $currentPage == 'reports.php' ? 'active' : ''; ?>">Reports</a></li>
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