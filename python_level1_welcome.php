<?php


session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}


// Database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'exam_website';

// Connect to MySQL
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select the exam database
$conn->select_db($database);



// Initialize selected level
$selected_level = 'Level 1';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python Lesson</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        .lesson-container {
            width: 90%;
            max-width: 900px;
            margin: 100px auto 40px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .lesson-header {
            margin-bottom: 1.5rem;
        }

        .lesson-header h2 {
            font-size: 2rem;
            color: #333;
        }

        .lesson-content p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #444;
        }

        .code-snippet {
            background: #f4f4f4;
            border-left: 4px solid #007BFF;
            padding: 1rem;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }

        .lesson-actions {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
        }

        .lesson-actions a {
            text-decoration: none;
        }
    </style>
</head>
<body class="dashboard">

    <div class="lesson-container">
        <div class="lesson-header">
            <h2>Introduction to Mastery Levels Python programming!</h2>
        </div>
        <div class="lesson-content">
            <p>Welcome to the Mastery Levels Python Learning application. This program consists of multiple levels, each designed to expand your Python programming knowledge and skillset. At the end of each module is a short test, designed to check your knowledge from the module. These tests involve multiple choice questions, and a programming exercise.</p>
            <div class="code-snippet">
            You also have access to an AI-powered virtual teaching assistant! Should you need any help, or have any questions, just click the 💬 button in the bottom-right to get talking! 
        </div>
        <div class="lesson-actions">
            <a href="python_splash.php" class="btn">← Back to Menu</a>
            <a href="python_level1_print.php" class="btn">Next →</a>
        </div>
    </div>
<!-- Chat Bubble -->
<div id="chat-bubble">💬</div>

<!-- Chat Window -->
<div id="chat-window">
    <div id="chat-messages"></div>
    <div id="chat-input">
        <input type="text" id="user-input" placeholder="Type a message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
    document.getElementById("chat-bubble").addEventListener("click", function() {
        let chatWindow = document.getElementById("chat-window");
        chatWindow.style.display = (chatWindow.style.display === "none" || chatWindow.style.display === "") ? "flex" : "none";
    });

    function sendMessage() {
        let userInput = document.getElementById("user-input").value;
        if (!userInput.trim()) return;

        // Display user message
        let messages = document.getElementById("chat-messages");
        messages.innerHTML += `<div><strong>You:</strong> ${userInput}</div>`;

        // Send user message to backend
        fetch("chat.php", {
        method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ message: userInput })
})
.then(response => response.json())
.then(data => {
    if (data.reply) {
        console.log("AI Teacher:", data.reply);
        document.querySelector("#chat-messages").innerHTML += `<p>\n<strong>AI Teacher: </strong>${data.reply}</p>`;
    } else {
        console.error("Error:", data.error || "Unknown error occurred.");
    }
})
.catch(error => console.error("Fetch error:", error));
    }
</script>
</body>
</html>
