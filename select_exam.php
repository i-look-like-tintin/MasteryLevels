<?php
// select_exam.php

// Include the database connection
include 'db_connect.php'; // Ensure this file contains your DB connection logic

// Initialize selected level
$selected_level = '';

// Check if a level has been selected via GET
if (isset($_GET['level'])) {
    $selected_level = $conn->real_escape_string($_GET['level']);
}

// Fetch distinct levels from quizzes table for the level selection dropdown/buttons
$levels_query = "SELECT DISTINCT level FROM quizzes ORDER BY level ASC";
$levels_result = $conn->query($levels_query);

// Fetch courses based on selected level, or default to Level 1 if no level selected
if ($selected_level != '') {
    // Fetch courses for the selected level
    $courses_query = "SELECT DISTINCT subject FROM quizzes WHERE level = '$selected_level' ORDER BY subject ASC";
} else {
    // Default to Level 1
    $selected_level = 'Level 1';
    $courses_query = "SELECT DISTINCT subject FROM quizzes WHERE level = '$selected_level' ORDER BY subject ASC";
}
$courses_result = $conn->query($courses_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select an Exam</title>
    <link rel="stylesheet" href="styles.css">
    <style>

        .exam-container {
            text-align: center;
            padding: 50px;
        }
        .level-selection {
            margin-bottom: 30px;
        }
        .level-selection form {
            display: inline-block;
        }
        .level-selection select, .level-selection button {
            padding: 10px 20px;
            font-size: 16px;
            margin-right: 10px;
        }
        .exam-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn {
            display: block;
            padding: 15px 25px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            min-width: 200px;
            text-align: center;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="exam-container">
    <h1>Select an Exam</h1>

    <div class="level-selection">
        <form method="GET" action="select_exam.php">
            <label for="level">Choose Level:</label>
            <select name="level" id="level" onchange="this.form.submit()">
                <?php
                if ($levels_result->num_rows > 0) {
                    while ($level = $levels_result->fetch_assoc()) {
                        $level_name = $level['level'];
                        // Check if this level is the selected level
                        $selected_attr = ($level_name == $selected_level) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($level_name) . "' $selected_attr>" . htmlspecialchars($level_name) . "</option>";
                    }
                }
                ?>
            </select>

        </form>
    </div>

    <div class="exam-buttons">
        <?php
        if ($courses_result->num_rows > 0) {
            while ($course = $courses_result->fetch_assoc()) {
                // Prepare URL parameters by encoding them to handle spaces and special characters
                $subject = urlencode($course['subject']);
                $level = urlencode($selected_level);

                // Display the exam button
                echo "<a href='exam_page.php?subject={$subject}&level={$level}' class='btn'>" . htmlspecialchars($course['subject']) . " - " . htmlspecialchars($selected_level) . "</a>";
            }
        } else {
            echo "<p>No exams available for this level.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</div>

</body>
</html>