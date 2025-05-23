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
$conn->select_db($database);


// --- RANDOM MULTIPLE CHOICE SECTION ---

$questionQuery = "
    SELECT q.questionID, q.question 
    FROM Questions q
    INNER JOIN Levels l ON q.levelID = l.levelID
    WHERE l.levelID > 16 AND l.levelID <= 20
    ORDER BY RAND()
    LIMIT 3;
";

$questionResult = $conn->query($questionQuery);

if (!$questionResult) {
    die("Error fetching questions: " . htmlspecialchars($conn->error));
}

$questions = [];

while ($row = $questionResult->fetch_assoc()) {
    $questions[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Python Level 5 Test</title>
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script> 
  	<script src="https://cdn.jsdelivr.net/gh/Tezumie/Skulpt-CDN@latest/skulpt.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/gh/Tezumie/Skulpt-CDN@latest/skulpt-stdlib.js"></script>
    <script>hljs.highlightAll();</script>
    <style>
        /* Extra Clean Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .main-content {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            color: #333;
        }
        .exam-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .question-section {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 8px;
        }
        .question-text {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #222;
        }
        .answer-option {
            margin-bottom: 10px;
        }
        .answer-option input[type="radio"] {
            margin-right: 10px;
        }
        .coding-question-section {
            background: #eef2f7;
            padding: 50px;
            border-radius: 8px;
        }
        .instructions {
            margin-bottom: 10px;
            font-size: 1em;
        }
        .code-textarea {
            width: 100%;
            height: 250px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 1em;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
            background: #f9f9f9;
        }
        .submit-section {
            text-align: center;
            margin-top: 20px;
        }
        .submit-button {
            background: #4CAF50;
            color: white;
            padding: 12px 25px;
            font-size: 1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
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
        .submit-button:hover {
            background: #45a049;
        }
        .question-divider {
            border: none;
            height: 1px;
            background: #ddd;
            margin: 30px 0;
        }
        #codeMirror {
    position: absolute;
    top: 0;
    left: 0;
    padding: 1em;
    width: 100%;
    height: 100%;
    pointer-events: none;
    white-space: pre-wrap;
    word-wrap: break-word;
    z-index: 1;
    overflow-y: auto;
    border-radius: 8px;
    background: #1e1e1e;
}
#language-python {
    pointer-events: none;      /* prevent interaction */
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    padding: 1em;
    border-radius: 6px;


}
#codeEditor {
    position: relative;
    z-index: 2;
    padding: 1em;
    width: 100%;
    min-height: 200px;
    color: transparent;
    background: transparent;
    border: none;
    resize: none;
    overflow: auto;
    caret-color: #ffffff; /* make cursor visible */
    font-family: 'Fira Code', monospace;
    font-size: 1rem;
    line-height: 1.4;
}
#codeInput {
    position: relative;
    background: #1e1e1e;
    color: #000;
    z-index: 2;
    font-size: 1pt;
}
.code-editor-wrapper {
    position: relative;
    width: 96%;
    max-width: 900px;
    min-height: 200px;
    max-height: 250px;
    font-family: 'Fira Code', monospace;
    font-size: 1rem;
    line-height: 1.4;
}
        
    </style>
</head>
<body>

<div class="main-content">
    <h1 class="page-title">Python Level 5 Test</h1>

    <form action="submit_exam.php" method="post" onsubmit="return runSkulptCode();"class="exam-form">
    <input type="hidden" name="subject" value="Python Level 4">
    <div style="text-align: right; margin-bottom: 20px;">
    <a href="python_splash.php" class="quit-button" onclick="return confirm('Are you sure you want to quit and return to the menu?');">Quit</a>
</div>
        <!-- Dynamically Generated Multiple Choice Questions -->
        <?php
        foreach ($questions as $index => $question) {
            echo "<div class='question-section'>";
            echo "<h2 class='question-text'>Question " . ($index + 1) . ": " . htmlspecialchars($question['question']) . "</h2>";

            // Fetch corresponding answers
            $answerQuery = "
                SELECT answerID, answer, answer_character
                FROM Answers
                WHERE questionID = ?
                ORDER BY answer_character ASC
            ";

            $stmt = $conn->prepare($answerQuery);
            if (!$stmt) {
                die("Error preparing answer query: " . htmlspecialchars($conn->error));
            }

            $stmt->bind_param("i", $question['questionID']);
            $stmt->execute();
            $answerResult = $stmt->get_result();

            if ($answerResult->num_rows == 0) {
                echo "<p class='no-answers-warning'>No answers available for this question.</p>";
            } else {
                while ($answer = $answerResult->fetch_assoc()) {
                    echo "<div class='answer-option'>";
                    echo "<label>";
                    echo "<input type='radio' name='question_" . $question['questionID'] . "' value='" . htmlspecialchars($answer['answer_character']) . "' required> ";
                    echo "<span class='answer-text'>" . htmlspecialchars($answer['answer_character']) . ". " . htmlspecialchars($answer['answer']) . "</span>";
                    echo "</label>";
                    echo "</div>";
                }
            }
            echo "</div><hr class='question-divider'>";
        }
        ?>

        <!-- Coding Question Section -->
        <div class="coding-question-section">

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="300" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>

            <h2 class="question-text">Python Coding Question:</h2>
            <p id = "code_question" class="instructions">I am thinking of a number between 1 and 50. Write some code to use a while() loop to keep guessing numbers until your code matches the my secret number!</p>
            <div class="code-editor-wrapper">
            <textarea name="code_answer" class="code-textarea" id="codeEditor"
            placeholder="Use the IDE above to test and develop your code..." 
            required spellcheck="false"></textarea>
            <input id="code_correct" hidden name="code_correct"></input>
            <pre><code id="codeMirror" class = "language-python"></code></pre>
            <b></b>
            
            </div>

            <script>
                const input = document.getElementById("codeEditor");
                const mirror = document.getElementById("codeMirror");

input.addEventListener("input", () => {
    // Copy and escape content
    const code = input.value
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
    
    mirror.innerHTML = code;
    // Re-highlight
    mirror.removeAttribute("data-highlighted");
    hljs.highlightElement(mirror);
});
            </script>
            <script>
                document.getElementById('codeEditor').addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                e.preventDefault();
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Set textarea value to: text before caret + 4 spaces + text after caret
        this.value = this.value.substring(0, start) + "    " + this.value.substring(end);

        // Move caret
        this.selectionStart = this.selectionEnd = start + 4;
        hljs.highlightAll();
    }
});
</script>

<script type="text/javascript"> 
document.getElementById("codeEditor").innerHTML="import random\n\nsecret_number = random.randint(1,50)\n";
function highlightPreset(){
        const input = document.getElementById("codeEditor");
        const mirror = document.getElementById("codeMirror");
        // Copy and escape content
        const code = input.value
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
    
        mirror.innerHTML = code;
        // Re-highlight
        mirror.removeAttribute("data-highlighted");
        hljs.highlightElement(mirror);
    }
    highlightPreset();
    function builtinRead(x) {
        if (Sk.builtinFiles === undefined || Sk.builtinFiles["files"][x] === undefined)
        throw `File not found: '${x}'`;
        return Sk.builtinFiles["files"][x];
}

    function runSkulptCode() {
           const userCode = document.getElementById("codeEditor").value;
    let secret_number = Math.floor(Math.random() * 50) + 1;
    let outputLines = [];

    const injectedCode = `
import random
secret_number = ${secret_number}
` + userCode;

    const hasWhileLoop = /\bwhile\b\s*\(?.+?\)?:/.test(userCode);
    const comparesToSecret = /==\s*secret_number/.test(userCode);
    const usesFlagLogic = /\b(flag)\s*=\s*(True|False)/.test(userCode);

    Sk.configure({
        output: function(text) {
            const trimmed = text.trim();
            if (trimmed !== "") outputLines.push(trimmed);
        },
        read: function(x) {
            if (Sk.builtinFiles === undefined || Sk.builtinFiles["files"][x] === undefined)
                throw "File not found: '" + x + "'";
            return Sk.builtinFiles["files"][x];
        },
        execLimit: 10000  // safety: prevent infinite loops
    });

    Sk.misceval.asyncToPromise(() => Sk.importMainWithBody("<stdin>", false, injectedCode))
        .then(() => {
            // Execution completed without infinite loop
            const valid = (
                hasWhileLoop &&
                comparesToSecret
            );

            if (valid) {
                alert(`✅ Success! Your code reached the correct secret number: ${secret_number}`);
                document.getElementById("code_correct").value = 1;
            } else {
                alert(`❌ Code must:
- Use a while loop
- Compare to secret_number (e.g., 'if guess == secret_number')`);
                document.getElementById("code_correct").value = 0;
                return true;
            }
        })
        .catch(err => {
            alert("❌ Code did not complete successfully. Possible infinite loop or syntax error:\n" + err.toString());
            document.getElementById("code_correct").value = 0;
            return true;
        });

    return false;
}
                  
</script>
        </div>

        <div class="submit-section">
            <button type="submit" class="submit-button">Submit Test</button>

        </div>
    <script>
document.querySelector("form").addEventListener("submit", function () {
    const questionText = document.getElementById("code_question").innerText.trim();
    document.getElementById("hidden_code_question").value = questionText;
});
</script>
    <input type="hidden" name="code_question" id="hidden_code_question" />
    </form>
</div>
            <div id="output" hidden>Output</div>
</body>
</html>