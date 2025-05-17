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

if (isset($_GET['FzYps43NmreQ'])) {
    $moduleValue = $_GET['FzYps43NmreQ'];
    $sectionNumber = $moduleValue / 5446124;
}
else{
    header("Location: python_splash.php");
}
//Level number must be modified with each increasing level

$selected_level = 'Level ' . $sectionNumber;

require_once 'Parsedown.php';


$markdown = file_get_contents('markdowntest.md');


preg_match('/<!-- START section'.$sectionNumber.' -->(.*?)<!-- END section'.$sectionNumber.' -->/s', $markdown, $matches);
$partContent = $matches[1] ?? '';


$subsections = preg_split('/<!-- SUBSECTION -->/', $partContent);
$subsections = array_map('trim', array_filter($subsections));


$Parsedown = new Parsedown();
$parsedSections = array_map([$Parsedown, 'text'], $subsections);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python Lesson</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">

    <!-- Highlight.js core script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>

    <style>
        .lesson-container {
            width: 90%;
            max-width: 900px;
            margin: 100px auto 40px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-height: calc(100vh - 160px);
            overflow-y: auto;
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
        .markdown-body {
            font-family: system-ui, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .markdown-body h1,
        .markdown-body h2,
        .markdown-body h3 { margin-top: 1.3em; }


        .markdown-body p {
            margin: 1em 0;
        }


        .markdown-body ul, .markdown-body ol {
            padding-left: 2em;
            margin: 1em 0;
        }


        .markdown-body pre {
            overflow-x: auto;
            border-radius: 6px;
            padding: 1em;
            background: #272822;          
            color: #f8f8f2;               
        }
        .markdown-body blockquote {
            background: #e6f7ff;                      
            border-left: 4px solid #1e90ff;          
            padding: 1em 1.5em;
            margin: 1.5em 0;
            font-style: normal;
            color: #222;
            border-radius: 4px;
            position: relative;
        }

        .lesson-container::-webkit-scrollbar {
            width: 8px;
        }
        .lesson-container::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }
        .lesson-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
            max-width: 900px;
            padding-bottom: 40px;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        button:disabled {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .markdown-body.lesson-container {
            width: 90%;
            max-width: 900px;
            margin: 100px auto 40px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            line-height: 1.6;
            max-height: calc(100vh - 160px); 
            overflow-y: auto;
        }
        .markdown-body hr { border: 0; height: 1px; background: #e0e0e0; }
        .markdown-body code {
            background:rgb(204, 202, 198);
            padding: 0.15em 0.4em;
            border-radius: 4px;
        }
        aside {
            background: #f7f5ff;
            border-left: 4px solid #7b2ff7;
            padding: 1rem 1.5rem;
            margin: 1.5em 0;
            font-style: italic;
            border-radius: 6px;
        }
        .quit-button {
            background:rgb(172, 34, 29);
            color: white;
            padding: 12px 25px;
            font-size: 1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
    </style>        


    <article class="markdown-body lesson-container" id="markdown-body">

    </article>
    <div class="lesson-actions">
        <a href="python_splash.php" class="quit-button">Back to Menu</a>
        <button onclick="prevSection()" id="prevBtn" class="btn" disabled>Previous</button>
        <button onclick="nextSection()" id="nextBtn" class="btn">Next</button>
    </div>

    <script>
    const sections = <?php echo json_encode($parsedSections); ?>;
    let currentIndex = 0;
    showSection(currentIndex);
    function showSection(index) {
        const display = document.getElementById("markdown-body");

        document.getElementById("prevBtn").disabled = true;
        document.getElementById("nextBtn").disabled = true;

        display.classList.add("fade-out");

        setTimeout(() => {
            display.innerHTML = sections[index];
            updateNavButtons();


            if (typeof hljs !== 'undefined') {
                hljs.highlightAll();
            }

        display.classList.remove("fade-out");

        }, 400);
    }
    

    function nextSection() {
        if (currentIndex < sections.length - 1) {
            currentIndex++;
            showSection(currentIndex);
        }
    }

    function prevSection() {
        if (currentIndex > 0) {
            currentIndex--;
            showSection(currentIndex);
        }
    }


    showSection(currentIndex);
    const nextBtn = document.getElementById("nextBtn");

function updateNavButtons() {
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    prevBtn.disabled = currentIndex === 0;

    if (currentIndex === sections.length - 1) {
        nextBtn.disabled = false;
        nextBtn.textContent = "Take the Test!";
        nextBtn.onclick = () =>{
            <?php echo 'window.location.href = "python_level'.$sectionNumber.'_test.php"' ?>
        }
    } else {
        nextBtn.disabled = false;
        nextBtn.textContent = "Next";
        nextBtn.onclick = nextSection;
    }
}
</script>

<div id="chat-bubble">💬</div>


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


        let messages = document.getElementById("chat-messages");
        messages.innerHTML += `<div><strong>You:</strong> ${userInput}</div>`;


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
