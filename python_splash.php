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

// Fetch all levels
$levelsQuery = "SELECT levelID, level FROM Levels ORDER BY levelID ASC";
$levelsResult = $conn->query($levelsQuery);

// Fetch user's completed subjects and grades
$userResultsQuery = "
    SELECT subject, score, total_questions
    FROM results
    WHERE student_id = ?
";
$stmt = $conn->prepare($userResultsQuery);
$stmt->bind_param("i", $currentUserId);
$stmt->execute();
$userResults = $stmt->get_result();

$userGrades = [];

while ($row = $userResults->fetch_assoc()) {
    $userGrades[$row['subject']] = [
        'score' => $row['score'],
        'total' => $row['total_questions'],
        'percentage' => ($row['total_questions'] > 0) ? round(($row['score'] / $row['total_questions']) * 100, 1) : 0
    ];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python Levels</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
.container {
    width: 90%;
    max-width: 1200px;
    margin: 50px auto 0 auto; /* <- 50px margin on top */
    padding-top: 400px;
}

.levels-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    width: 100%;
    max-width: 1200px;
}

.level-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-align: center;
    min-height: 160px;
    transition: transform 0.2s ease;
}

.level-card:hover {
    transform: scale(1.03);
}

.level-card.level-locked {
    background: #f0f0f0;
}

.level-title {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #333;
}

.level-grade {
    margin-bottom: 20px;
    font-size: 1em;
    color: #666;
}

.level-button {
    padding: 10px 20px;
    background: linear-gradient(90deg, rgba(0, 146, 255, 1) 0%, rgba(228, 0, 255, 1) 100%);
    color: white;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-size: 1em;
    cursor: pointer;
    transition: background 0.3s;
}

.level-button:hover {
    background: linear-gradient(90deg, rgb(96, 184, 252) 0%, rgb(236, 98, 252) 100%);
}

.level-button.disabled {
    background: #9e9e9e;
    cursor: not-allowed;
}
.dashboard-content {
    padding: clamp(30px, 5vw, 400px)
    display: flex;
    justify-content: center;
    align-items: flex-start;
}
.dashboard-section h1 {
    margin-bottom: 30px;
    text-align: center;
}
.dashboard-section {
    margin-top: 0%;
}

</style>

</head>
<body>
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
            <span>Hi, <?php echo htmlspecialchars($user); ?></span>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
        </div>
    </header>
<div class="dashboard-content">
    <div class = "dashboard-section">
    <h1>Welcome to Python Mastery Levels</h1>

    <div class="levels-grid">
<?php
$levelsQuery = "SELECT levelID, level FROM Levels ORDER BY levelID ASC";
$levelsResult = $conn->query($levelsQuery);

$levels = [];
while ($row = $levelsResult->fetch_assoc()) {
    $levels[] = $row;
}

$levelGroups = array_chunk($levels, 4); // 6 groups
$canAccessNext = true;
$groupNumber = 1;

foreach ($levelGroups as $group) {
    $displayTitle = "Level " . $groupNumber; // Visible button title

    // NEW: Check result for 'Level 1', 'Level 2', etc
    $groupResultKey = "Python Level " . $groupNumber;
    $groupComplete = isset($userGrades[$groupResultKey]) && $userGrades[$groupResultKey]['percentage'] == 100;

    $isLocked = !$canAccessNext;
    echo "<div class='level-card " . ($isLocked ? "level-locked" : "") . "'>";
    echo "<h2 class='level-title'>{$displayTitle}</h2>";
    echo "<p class='level-grade'>" . ($groupComplete ? "Completed with 100%" : "Not Completed") . "</p>";

    if (!$isLocked) {
        echo "<a href='python_level".$groupNumber."_1.php' class='level-button'>Start Level</a>";
    }
    elseif ($groupComplete) {
        echo "<a href='python_level".$groupNumber."_1.php' class='level-button'>Start Level</a>";
    }
    else {
        echo "<button class='level-button disabled' disabled>Locked</button>";
    }

    echo "</div>";

    // Only unlock next group if this group test was completed 100%
    $canAccessNext = $groupComplete;
    $groupNumber++;
}
?>

    </div>
    </div>
</div>
<script>
function applyDynamicHeaderPadding() {
    const header = document.querySelector('.dashboard-header');
    const content = document.querySelector('.dashboard-content');

    if (!header || !content) return;

    const headerHeight = header.offsetHeight;
    const paddingTop = headerHeight + 20; // breathing room

        // Set padding-top with !important to override any CSS
        content.style.setProperty('padding-top', paddingTop + 'px', 'important');
}

// Run once DOM is fully ready
window.addEventListener('DOMContentLoaded', applyDynamicHeaderPadding);

// Rerun if window resizes or moves between screens
window.addEventListener('resize', applyDynamicHeaderPadding);
</script>
</body>
</html>