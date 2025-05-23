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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Python Levels</title>
    <link rel="stylesheet" href="styles.css"> 

</head>
<body>
<?php include 'navbar.php'; ?>
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

            $isLocked = false;
            //TODO: Reset this
            //$isLocked = !$canAccessNext;
            echo "<div class='level-card " . ($isLocked ? "level-locked" : "") . "'>";
            echo "<h2 class='level-title'>{$displayTitle}</h2>";
            echo "<p class='level-grade'>" . ($groupComplete ? "Completed with 100%" : "Not Completed") . "</p>";

            if (!$isLocked) {
                echo "<a href='python_level.php?FzYps43NmreQ=".($groupNumber*5446124)."' class='level-button'>Start Level</a>";
            }
            elseif ($groupComplete) {
             echo "<a href='python_level.php?FzYps43NmreQ=".($groupNumber*5446124)."' class='level-button'>Start Level</a>";
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
function adjustDashboardPadding() {
    var header = document.querySelector('.dashboard-header');
    var content = document.querySelector('.dashboard-content');
    if (header && content) {
        content.style.paddingTop = (header.offsetHeight + 20) + 'px'; // 20px is a small buffer
    }
}
window.addEventListener('DOMContentLoaded', adjustDashboardPadding);
window.addEventListener('resize', adjustDashboardPadding);
</script>
</body>
</html>
