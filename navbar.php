<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="dashboard-header">
    <div class="logo">
        <h1>MasteryLevels</h1>
    </div>
    <nav class="dashboard-nav" id="dashboardNav">
        <ul>
            <li><a href="dashboard.php"<?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo ' class="active"'; ?>>Dashboard</a></li>
            <li><a href="python_splash.php"<?php if(basename($_SERVER['PHP_SELF']) == 'python_splash.php') echo ' class="active"'; ?>>Learn Python</a></li>
            <li><a href="exams.php"<?php if(basename($_SERVER['PHP_SELF']) == 'exams.php') echo ' class="active"'; ?>>Exams</a></li>
            <li><a href="progress.php"<?php if(basename($_SERVER['PHP_SELF']) == 'progress.php') echo ' class="active"'; ?>>Progress</a></li>
        </ul>
    </nav>
    <div class="user-info">
        <span>
            Hi, <?php echo isset($_SESSION['user']) && !empty($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Guest'; ?>
        </span>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>
</header>