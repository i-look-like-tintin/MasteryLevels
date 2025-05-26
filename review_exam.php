<?php

session_start();
//Check if user is logged in
if (!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}
$currentUserId = $_SESSION['id'];

//database connection 
$host = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'exam_website';

$conn = new mysqli($host, $db_username, $db_password, $database); // Fixed undefined variables
if($conn->connect_error){
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

//Get subject from string
if (!isset($_GET['subject']) || empty($_GET['subject'])) {
    echo "<p>No subject specified.</p>";
}
$subject = $conn->real_escape_string($_GET['subject']);
if(str_contains($subject, "Python Level")){


    $query = "SELECT 
    sr.student_id,
    sr.question_id,
    q.question,
    sr.selected_option,
    sa.answer AS selected_answer,
    ca.answer_character AS correct_option,
    ca.answer AS correct_answer,
    (
        SELECT wa.answer
        FROM Answers wa
        WHERE wa.questionID = q.questionID AND wa.correct = FALSE
        ORDER BY RAND()
        LIMIT 1
    ) AS wrong_answer,
    cs_latest.code AS submitted_code,
    cs_latest.submission_time,
    cs_latest.correct AS code_correct,
    cs_latest.question AS code_question
    FROM student_progress sr
    JOIN Questions q ON sr.question_id = q.questionID
    JOIN Answers ca ON q.questionID = ca.questionID AND ca.correct = TRUE
    LEFT JOIN Answers sa 
        ON sa.questionID = sr.question_id AND sa.answer_character = sr.selected_option
    LEFT JOIN (
    SELECT cs1.*
    FROM code_submissions cs1
    JOIN (
        SELECT student_id, subject, MAX(submission_time) AS latest_time
        FROM code_submissions
        GROUP BY student_id, subject
    ) cs2 ON cs1.student_id = cs2.student_id 
         AND cs1.subject = cs2.subject 
         AND cs1.submission_time = cs2.latest_time
    ) AS cs_latest ON cs_latest.student_id = sr.student_id 
               AND cs_latest.subject = sr.subject
    WHERE sr.student_id = ?
    AND sr.subject = ?;


    ";
    $stmt = $conn->prepare($query);
    if ($stmt == false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("is", $currentUserId, $subject);

    if (!$stmt->execute()) {
        die("Execute failed: " . htmlspecialchars($stmt->error)); // Added error handling
    }


}
else{
//fetch all questions and students answers
    $query = "SELECT q.id AS question_id, q.question, q.correct_option, sp.selected_option
        FROM quizzes q
        LEFT JOIN student_progress sp
        ON q.id = sp.question_id AND sp.student_id = ? AND sp.subject = ?
        WHERE q.subject = ?";

    $stmt = $conn->prepare($query);
    if ($stmt == false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }   
    $stmt->bind_param("iss", $currentUserId, $subject, $subject);
    if (!$stmt->execute()) {
        die("Execute failed: " . htmlspecialchars($stmt->error)); // Added error handling
    }
}
$result = $stmt->get_result();


$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
if (empty($questions)) {
    echo "<p>No questions found for the selected subject.</p>"; // Added fallback message
}

if ($result->num_rows === 0) {
    die("No data returned. Check if questions exist for subject: " . htmlspecialchars($subject));
}


$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Review - <?php echo htmlspecialchars($subject); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        .exam-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .code-submission-box {
            background-color:rgb(191, 203, 221);
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 20px;
            font-family: monospace;
            white-space: pre-wrap;
         }
    </style>
</head>
<body>
    <div class="exam-container">
        <h1>Exam Review</h1>
        <h2><?php echo htmlspecialchars($subject); ?><br></h2> <!-- Added <br> for a new line -->
        <table style="border-spacing: 1; padding: 20px; width: 100%;">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Your Answer</th>
                    <th>Correct Answer</th>
                    <th>Result</th>
                    <th>Get Assistance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?php
                                echo htmlspecialchars($question['question']); ?></td>
                        <td><?php echo htmlspecialchars(strtoupper($question['selected_option'] ?? 'Not Answered')); ?>
                        <?php echo " (" . htmlspecialchars($question['selected_answer'], ENT_QUOTES) . ")"; ?>
                        </td>
                        <td><?php echo htmlspecialchars(strtoupper($question['correct_option'])); ?>
                            <?php echo " (" . htmlspecialchars($question['correct_answer'], ENT_QUOTES) . ")"; ?>
                        </td>
                        <td>
                            <?php 
                            $selectedOption = trim((string) $question['selected_option'] ?? '');
                            $correctOption = trim((string) $question['correct_option']);
                            if (strcasecmp($selectedOption, $correctOption) === 0): ?> <!-- Case-insensitive comparison -->
                                <span style="color:green;">Correct</span>
                            <?php else: ?>
                                <span style="color:red;">Incorrect</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            if (strcasecmp($selectedOption, $correctOption) === 0): ?> <!-- Case-insensitive comparison -->
                                
                            <?php else: ?>
                                <button onclick="chatHelp('<?php echo htmlspecialchars($question['question'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($question['wrong_answer'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($question['correct_answer'], ENT_QUOTES); ?>')">Get AI Help💬</button>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
                        if (!empty($question['submitted_code']) && str_contains($subject, "Python Level")) {
                            $q = htmlspecialchars($question['code_question'], ENT_QUOTES);
                            //$_SESSION['codingQuestion'] = str_replace(["\n", "\r", "'"], ['', '', ''], $q);
                            $correct="";
                            $aiPrompt="";
                            if($question['code_correct'] === 1){
                                $correct="Correct ✔️";
                            }
                            else{
                                $correct="Incorrect ❌";
                            }
                            echo '<div class="code-submission-box">';
                            echo '<h4>Question:</h4>';
                            echo '<pre id="codeQuestion">'.$q.'</pre>';
                            echo '<b> </b>';
                            echo '<h4>Submitted Code:</h4>';
                            echo '<pre id="usrCode">' . htmlspecialchars($question['submitted_code']) . '</pre>';
                            echo '<b> </b>';
                            echo '<h3>' . $correct . '</h3>';
                            ?>
                            <?php if($question['code_correct'] === 0): ?>
                            <script>
                            const text = document.getElementById("codeQuestion").innerText;
                            const usCode = document.getElementById("usrCode").innerText;
                            const helpButton = document.createElement("button");
                            helpButton.style.display = "block";
                            helpButton.style.margin = "20px auto";
                            helpButton.textContent = "Get AI Help💬";
                            helpButton.onclick = function() {
                            chatHelpCode(text, usCode);
                            };

                            // Append the button to a known container (like the code box)
                            document.querySelector(".code-submission-box").appendChild(helpButton);
                            </script>
                            <?php endif; ?>
                            
                            <?php
                            echo '</div>';
                         }
                    ?>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
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
    function chatHelp(question, wrongAnswer, correctAnswer) {
        let chatWindow = document.getElementById("chat-window");
        chatWindow.style.display = "flex";
        let userInput = "I need help with a question. The question asked me: " + question + " I selected '" + wrongAnswer + "' as my answer, but the correct answer was instead '" + correctAnswer + "'. Can you please briefly explain the correct answer? Please also briefly include an example.";
        if (!userInput.trim()) return;
        let messages = document.getElementById("chat-messages");
        //messages.innerHTML += `<div><strong>You:</strong> ${userInput}</div>`;
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
    
    function chatHelpCode(question, myCode) {
        let chatWindow = document.getElementById("chat-window");
        chatWindow.style.display = "flex";
        console.log(question);
        console.log(myCode);
        let userInput = "I need help with a question. The question asked me: " + question + " I tried to solve this with the code: " + myCode + " but was marked incorrect. Can you please briefly explain the correct answer, and provide guidance as to why I was wrong?";
        console.log(userInput);
        if (!userInput.trim()) return;
        let messages = document.getElementById("chat-messages");
        //messages.innerHTML += `<div><strong>You:</strong> ${userInput}</div>`;
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
