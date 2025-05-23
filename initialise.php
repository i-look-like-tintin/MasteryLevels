<?php
session_start();
echo "<script>console.log('Starting database initialisation...');</script>";
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_website";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    echo "<script>console.error('Database connection failed: " . addslashes($conn->connect_error) . "');</script>";
    die("Connection failed: " . $conn->connect_error);
}
// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);
$conn->select_db('information_schema');
$tableCountResult = $conn->query("
    SELECT COUNT(*) AS table_count
    FROM information_schema.tables
    WHERE table_schema = 'exam_website'
");

$hasTables = false;

if ($tableCountResult && $row = $tableCountResult->fetch_assoc()) {
    $hasTables = $row['table_count'] > 0;
    echo "<script>console.log('Table count = " . $row['table_count'] . "');</script>";
} else {
    echo "<script>console.log('Failed to retrieve table count');</script>";
}

if (!$hasTables) {
echo "<script>console.log('Dropping....');</script>";
// Select the database
$conn->select_db($dbname);
$sqlTemp = "DROP DATABASE exam_website";
$conn->query($sqlTemp);


// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);
echo "<script>console.log('Creating DB if not exists....');</script>";
// Select the database
$conn->select_db($dbname);
    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('student', 'teacher') NOT NULL DEFAULT 'student'
    )";
    $conn->query($sql);
echo "<script>console.log('Creating U....');</script>";
    // Modify the users table to add the 'role' column if it doesn't exist
    $alterUsersTable = "
        ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('student', 'teacher') DEFAULT 'student';
";
    $conn->query($alterUsersTable);
    echo "<script>console.log('Altering U....');</script>";
    // Insert the default teacher account
    $conn->query("INSERT INTO users (email, password, role) 
        VALUES ('teacher@teacher', '" . password_hash('password', PASSWORD_DEFAULT) . "', 'teacher')
                            ON DUPLICATE KEY UPDATE email=email");
    
    // *** CREATE Necessary Tables IF NOT EXISTS ***
    $createQuizzesTableQuery = "
    CREATE TABLE IF NOT EXISTS quizzes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(255) NOT NULL,
        level VARCHAR(50) NOT NULL,
        question TEXT NOT NULL,
        option_a VARCHAR(255) NOT NULL,
        option_b VARCHAR(255) NOT NULL,
        option_c VARCHAR(255) NOT NULL,
        option_d VARCHAR(255) NOT NULL,
        correct_option CHAR(1) NOT NULL
    )
";
    if ($conn->query($createQuizzesTableQuery) === FALSE) {
        die("Error creating quizzes table: " . htmlspecialchars($conn->error));
    }
echo "<script>console.log('Creating Q....');</script>";
    $createProgressTableQuery = "
    CREATE TABLE IF NOT EXISTS student_progress (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        question_id INT NOT NULL,
        selected_option CHAR(1),
        completed BOOLEAN DEFAULT 0,
        UNIQUE KEY unique_progress (student_id, subject, question_id)
    )
    ";
    if ($conn->query($createProgressTableQuery) === FALSE) {
    die("Error creating student_progress table: " . htmlspecialchars($conn->error));
    }
    echo "<script>console.log('Creating P....');</script>";
    $createResultsTableQuery = "
    CREATE TABLE IF NOT EXISTS results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        score INT NOT NULL,
        total_questions INT NOT NULL,
        exam_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_result (student_id, subject)
    )
    ";
    if ($conn->query($createResultsTableQuery) === FALSE) {
    die("Error creating results table: " . htmlspecialchars($conn->error));
    }
echo "<script>console.log('Creating R....');</script>";
    $createPythonLevels = "-- To create LEVELS, QUESTIONS, and ANSWER tables:
CREATE TABLE IF NOT EXISTS Levels (
    levelID INT PRIMARY KEY,
    level VARCHAR(50)
);";
if ($conn->query($createPythonLevels) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
echo "<script>console.log('Creating L....');</script>";
$createPythonQuestions = "CREATE TABLE IF NOT EXISTS Questions (
    questionID INT PRIMARY KEY,
    levelID INT,
    question VARCHAR(300),
    FOREIGN KEY (levelID) REFERENCES Levels(levelID)
);";
if ($conn->query($createPythonQuestions) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
echo "<script>console.log('Creating Q2....');</script>";
$createPythonAnswers = "CREATE TABLE IF NOT EXISTS Answers (
    answerID INT AUTO_INCREMENT PRIMARY KEY,
    questionID INT,
    answer VARCHAR(100),
    answer_character VARCHAR(1), -- e.g., A, B, C, D
    correct BOOLEAN,
    FOREIGN KEY (questionID) REFERENCES Questions(questionID)
);
";
if ($conn->query($createPythonAnswers) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
echo "<script>console.log('Creating A....');</script>";
$insertPythonLevels = "-- inserting levels, questions and answers into the tables 
INSERT INTO Levels (levelID, level) VALUES
-- Part 1 – Strings, “input()“, “print()“ ---------------------------
( 1, 'Part 1 “print()“ & literals'),
( 2, 'Part 1 “input()“ & variables'),
( 3, 'Part 1 “+“ string concatenation'),
( 4, 'Part 1 assignment “=“'),
-- Part 2 – Lists & basic flow-control ------------------------------
( 5, 'Part 2 list syntax “[ ]“'),
( 6, 'Part 2 list method “.append()“'),
( 7, 'Part 2 membership test “in“'),
( 8, 'Part 2 “if / else“ logic'),
-- Part 3 – “for“ loops & “range()“ --------------------------------
( 9, 'Part 3 keyword “for“'),
(10, 'Part 3 “range()“ basics'),
(11, 'Part 3 index iteration with “len()“'),
(12, 'Part 3 casting numbers via “str()“'),
-- Part 4 – Numbers & arithmetic -----------------------------------
(13, 'Part 4 multiplication “*“'),
(14, 'Part 4 “input()“ returns text'),
(15, 'Part 4 convert to float with “float()“'),
(16, 'Part 4 branching using “elif“'),
-- Part 5 – “while“ loops & Booleans --------------------------------
(17, 'Part 5 loop keyword “while“'),
(18, 'Part 5 updating the control variable'),
(19, 'Part 5 Boolean values “True“ / “False“'),
(20, 'Part 5 augmented assign “+=“'),
-- Part 6 – Slicing & list operations -------------------------------
(21, 'Part 6 list method “.pop()“'),
(22, 'Part 6 slice “my_list[1:4]“'),
(23, 'Part 6 first index is “0“'),
(24, 'Part 6 reverse slice “[::-1]“'),
-- Part 7 – “random“ module & micro-projects ------------------------
(25, 'Part 7 “import random“'),
(26, 'Part 7 “random.randint()“'),
(27, 'Part 7 “random.choice()“'),
(28, 'Part 7 logical operator “or“'),
-- Part 8 – Functions & algorithms ----------------------------------
(29, 'Part 8 define with “def“'),
(30, 'Part 8 parameter list “( … )“'),
(31, 'Part 8 type check “type()“'),
(32, 'Part 8 divide-and-conquer design');
";
if ($conn->query($insertPythonLevels) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
echo "<script>console.log('Inserting Q2....');</script>";
$insertPythonQuestions = "INSERT INTO Questions (questionID, levelID, question) VALUES
--  Part 1 – Strings, input(), print()  --------------------------------------
( 1,  1, 'Which of the following is a valid Python string literal?'),
( 2,  2, 'Which built-in function pauses the program to ask the user for text?'),
( 3,  3, 'Which operator joins (concatenates) two strings together?'),
( 4,  4, 'In Python, which symbol is the assignment operator?'),
(33,  1, 'What result does the expression “Hello“ + “ “ + “World“ produce?'),
(34,  2, 'Which prefix turns a string into an f-string in Python?'),
--  Part 2 – Lists, if/else, list methods  -----------------------------------
( 5,  5, 'What pair of characters encloses a Python list?'),
( 6,  6, 'Which list method adds an element to the end of a list?'),
( 7,  7, 'The expression  member in my_list  tests for what?'),
( 8,  8, 'What happens when an if-condition is False and there is an else clause?'),
(35,  5, 'What value does my_list.index(x) return?'),
(36,  6, 'Which comparison operator checks two values for equality?'),
--  Part 3 – for-loops & range()  --------------------------------------------
( 9,  9, 'Which keyword begins a counted for-loop in Python?'),
(10, 10, 'What sequence does  list(range(0,3))  produce?'),
(11, 11, 'Inside  for i in range(len(my_list))  the variable i holds …?'),
(12, 12, 'Which built-in function converts an integer to a string?'),
(37,  9, 'How many iterations run in  for _ in range(5) ?'),
(38, 10, 'Which helper simultaneously returns index and element during iteration?'),
--  Part 4 – Numbers & arithmetic  ------------------------------------------
(13, 13, 'Which operator performs multiplication in Python?'),
(14, 14, 'What type does  input()  return by default?'),
(15, 15, 'Which built-in converts the string “7.5“ to a floating-point number?'),
(16, 16, 'Within an if / elif / else chain,  elif  stands for …?'),
(39, 13, 'Which operator returns the remainder of a division?'),
(40, 14, 'What is the result of 5 // 2  in Python?'),
--  Part 5 – while loops & Booleans  ----------------------------------------
(17, 17, 'Which loop repeats its body while a condition remains True?'),
(18, 18, 'Inside a while loop, what must usually happen to the control variable?'),
(19, 19, 'How many Boolean values exist in Python and what are they?'),
(20, 20, 'The operator  +=  does which of the following?'),
(41, 17, 'Which keyword immediately exits the current loop?'),
(42, 18, 'What Boolean value does  bool(““)  evaluate to?'),
--  Part 6 – Slicing & advanced list ops  -----------------------------------
(21, 21, 'Which list method removes and returns the last element?'),
(22, 22, 'Given  my_list[1:4] , which indices are included?'),
(23, 23, 'What is the index of the first element of any list?'),
(24, 24, 'Which slice reverses a list in one step?'),
(43, 21, 'Which slice returns every second element from a list?'),
(44, 22, 'What does  my_list.clear()  do?'),
--  Part 7 – random module & micro-projects  --------------------------------
(25, 25, 'Which statement correctly imports the random module?'),
(26, 26, 'What is a possible result of  random.randint(1,6) ?'),
(27, 27, 'Which random function picks a single element from a list?'),
(28, 28, 'In Rock-Paper-Scissors, which logical operator can chain multiple win-conditions?'),
(45, 25, 'Which function shuffles a list in place?'),
(46, 26, 'Which random function returns a float in the half-open range [0.0, 1.0)?'),
--  Part 8 – Functions, algorithms & testing  -------------------------------
(29, 29, 'Which keyword is used to define a function?'),
(30, 30, 'Where are a function’s parameters written?'),
(31, 31, 'What does  print(type(3.14))  display?'),
(32, 32, 'Which software-design principle means “break the problem into sub-projects”?'),
(47, 29, 'A variable created inside a function has what kind of scope?'),
(48, 30, 'Which statement ends a function and optionally sends a value back?');";
if ($conn->query($insertPythonQuestions) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
echo "<script>console.log('Inserting A....');</script>";
$insertPythonAnswers = "INSERT INTO Answers
        (answerID, questionID, answer_character, answer, correct) VALUES
(  1,  1, 'A', '“Hello“', 1),
(  2,  1, 'B', 'Hello without quotes', 0),
(  3,  1, 'C', '#Hello', 0),
(  4,  1, 'D', '<<Hello>>', 0),
(  5,  2, 'A', 'range()', 0),
(  6,  2, 'B', 'input()', 1),
(  7,  2, 'C', 'print()', 0),
(  8,  2, 'D', 'len()', 0),
(  9,  3, 'A', '*', 0),
( 10,  3, 'B', '&', 0),
( 11,  3, 'C', '+', 1),
( 12,  3, 'D', '-', 0),
( 13,  4, 'A', '==', 0),
( 14,  4, 'B', '=>', 0),
( 15,  4, 'C', ':=', 0),
( 16,  4, 'D', '=', 1),
( 17,  5, 'A', 'Square brackets [ ]', 1),
( 18,  5, 'B', 'Curly braces { }', 0),
( 19,  5, 'C', 'Parentheses ( )', 0),
( 20,  5, 'D', 'Angle brackets < >', 0),
( 21,  6, 'A', '.index()', 0),
( 22,  6, 'B', '.append()', 1),
( 23,  6, 'C', '.remove()', 0),
( 24,  6, 'D', '.pop()', 0),
( 25,  7, 'A', 'It reverses a list', 0),
( 26,  7, 'B', 'It sorts a list in place', 0),
( 27,  7, 'C', 'It tests if the left value is an element of the list on the right', 1),
( 28,  7, 'D', 'It joins two lists', 0),
( 29,  8, 'A', 'Nothing at all can be executed', 0),
( 30,  8, 'B', 'The program exits immediately', 0),
( 31,  8, 'C', 'Python raises a SyntaxError', 0),
( 32,  8, 'D', 'The statements under else run', 1),
( 33,  9, 'A', 'loop', 0),
( 34,  9, 'B', 'iterate', 0),
( 35,  9, 'C', 'repeat', 0),
( 36,  9, 'D', 'for', 1),
( 37, 10, 'A', '[1, 2, 3]', 0),
( 38, 10, 'B', '(0,1,2,3)', 0),
( 39, 10, 'C', 'A syntax error', 0),
( 40, 10, 'D', '[0, 1, 2]', 1),
( 41, 11, 'A', 'Always zero', 0),
( 42, 11, 'B', 'The length of the list', 0),
( 43, 11, 'C', 'The current index (position) in the list', 1),
( 44, 11, 'D', 'The current element value itself', 0),
( 45, 12, 'A', 'int()', 0),
( 46, 12, 'B', 'float()', 0),
( 47, 12, 'C', 'list()', 0),
( 48, 12, 'D', 'str()', 1),
( 49, 13, 'A', '//', 0),
( 50, 13, 'B', '**', 0),
( 51, 13, 'C', '%', 0),
( 52, 13, 'D', '*', 1),
( 53, 14, 'A', 'Integer', 0),
( 54, 14, 'B', 'Float', 0),
( 55, 14, 'C', 'Boolean', 0),
( 56, 14, 'D', 'String', 1),
( 57, 15, 'A', 'int()', 0),
( 58, 15, 'B', 'str()', 0),
( 59, 15, 'C', 'round()', 0),
( 60, 15, 'D', 'float()', 1),
( 61, 16, 'A', 'end if', 0),
( 62, 16, 'B', 'error list', 0),
( 63, 16, 'C', 'evaluate if', 0),
( 64, 16, 'D', 'else if', 1),
( 65, 17, 'A', 'for', 0),
( 66, 17, 'B', 'loop', 0),
( 67, 17, 'C', 'until', 0),
( 68, 17, 'D', 'while', 1),
( 69, 18, 'A', 'It should stay constant', 0),
( 70, 18, 'B', 'It must be deleted', 0),
( 71, 18, 'C', 'It must be turned into a list', 0),
( 72, 18, 'D', 'It must eventually be changed so the condition becomes False', 1),
( 73, 19, 'A', 'One: 0', 0),
( 74, 19, 'B', 'Three: yes / no / maybe', 0),
( 75, 19, 'C', 'An unlimited number', 0),
( 76, 19, 'D', 'Two:  True and False', 1),
( 77, 20, 'A', 'Divides the variable by the right-hand value', 0),
( 78, 20, 'B', 'Creates a Boolean flag', 0),
( 79, 20, 'C', 'Compares two values for equality', 0),
( 80, 20, 'D', 'Adds the right-hand value and re-assigns the variable', 1),
( 81, 21, 'A', '.remove()', 0),
( 82, 21, 'B', '.append()', 0),
( 83, 21, 'C', '.clear()', 0),
( 84, 21, 'D', '.pop()', 1),
( 85, 22, 'A', 'Elements with indices 1 and 4', 0),
( 86, 22, 'B', 'Elements with indices 0, 1, 2, 3', 0),
( 87, 22, 'C', 'Elements with indices 2 and 3 only', 0),
( 88, 22, 'D', 'Elements with indices 1, 2, 3', 1),
( 89, 23, 'A', '1', 0),
( 90, 23, 'B', '-1', 0),
( 91, 23, 'C', 'Depends on list length', 0),
( 92, 23, 'D', '0', 1),
( 93, 24, 'A', 'my_list[1:]', 0),
( 94, 24, 'B', 'my_list[::1]', 0),
( 95, 24, 'C', 'reversed(my_list) without assignment', 0),
( 96, 24, 'D', 'my_list[::-1]', 1),
( 97, 25, 'A', 'include random', 0),
( 98, 25, 'B', '#import random', 0),
( 99, 25, 'C', 'using random', 0),
(100, 25, 'D', 'import random', 1),
(101, 26, 'A', '0', 0),
(102, 26, 'B', '6.5', 0),
(103, 26, 'C', 'A list of numbers', 0),
(104, 26, 'D', '3', 1),
(105, 27, 'A', 'random.pick()', 0),
(106, 27, 'B', 'choice.random()', 0),
(107, 27, 'C', 'rand.choice()', 0),
(108, 27, 'D', 'random.choice()', 1),
(109, 28, 'A', 'and', 0),
(110, 28, 'B', 'not', 0),
(111, 28, 'C', 'xor', 0),
(112, 28, 'D', 'or', 1),
(113, 29, 'A', 'func', 0),
(114, 29, 'B', 'lambda', 0),
(115, 29, 'C', 'define', 0),
(116, 29, 'D', 'def', 1),
(117, 30, 'A', 'After the colon on the next line', 0),
(118, 30, 'B', 'In a separate variable outside the function', 0),
(119, 30, 'C', 'They are written inside square brackets', 0),
(120, 30, 'D', 'Inside the parentheses that follow the function name', 1),
(121, 31, 'A', '<type ''double''>', 0),
(122, 31, 'B', 'float', 0),
(123, 31, 'C', '<class ''int''>', 0),
(124, 31, 'D', '<class ''float''>', 1),
(125, 32, 'A', 'Bubble-sort', 0),
(126, 32, 'B', 'Pair-programming', 0),
(127, 32, 'C', 'Waterfall', 0),
(128, 32, 'D', 'Divide-and-conquer', 1),
(129, 33, 'A', '“HelloWorld“', 0),
(130, 33, 'B', '“Hello + World“', 0),
(131, 33, 'C', '“HelloWorld “', 0),
(132, 33, 'D', '“Hello World“', 1),
(133, 34, 'A', 'F', 0),
(134, 34, 'B', 'fmt', 0),
(135, 34, 'C', '%', 0),
(136, 34, 'D', 'f', 1),
(137, 35, 'A', 'Always -1', 0),
(138, 35, 'B', 'The last element in the list', 0),
(139, 35, 'C', 'A Boolean value', 0),
(140, 35, 'D', 'The index of the first occurrence of x', 1),
(141, 36, 'A', '=', 0),
(142, 36, 'B', '===', 0),
(143, 36, 'C', '!=', 0),
(144, 36, 'D', '==', 1),
(145, 37, 'A', '4', 0),
(146, 37, 'B', '6', 0),
(147, 37, 'C', 'It loops forever', 0),
(148, 37, 'D', '5', 1),
(149, 38, 'A', 'zip()', 0),
(150, 38, 'B', 'map()', 0),
(151, 38, 'C', 'counter()', 0),
(152, 38, 'D', 'enumerate()', 1),
(153, 39, 'A', '//', 0),
(154, 39, 'B', '**', 0),
(155, 39, 'C', '*', 0),
(156, 39, 'D', '%', 1),
(157, 40, 'A', '2.5', 0),
(158, 40, 'B', '3', 0),
(159, 40, 'C', 'An error is raised', 0),
(160, 40, 'D', '2', 1),
(161, 41, 'A', 'continue', 0),
(162, 41, 'B', 'exit', 0),
(163, 41, 'C', 'stop', 0),
(164, 41, 'D', 'break', 1),
(165, 42, 'A', 'True', 0),
(166, 42, 'B', 'None', 0),
(167, 42, 'C', 'SyntaxError', 0),
(168, 42, 'D', 'False', 1),
(169, 43, 'A', 'my_list[2::]', 0),
(170, 43, 'B', 'my_list[2]', 0),
(171, 43, 'C', 'my_list[:2]', 0),
(172, 43, 'D', 'my_list[::2]', 1),
(173, 44, 'A', 'Deletes only the first element', 0),
(174, 44, 'B', 'Returns a reversed copy', 0),
(175, 44, 'C', 'Copies the list to another variable', 0),
(176, 44, 'D', 'Removes all elements, leaving an empty list', 1),
(177, 45, 'A', 'random.mix()', 0),
(178, 45, 'B', 'shuffle.random()', 0),
(179, 45, 'C', 'random.reorder()', 0),
(180, 45, 'D', 'random.shuffle()', 1),
(181, 46, 'A', 'random.float()', 0),
(182, 46, 'B', 'random.rand()', 0),
(183, 46, 'C', 'random.uniform(0,1)', 0),
(184, 46, 'D', 'random.random()', 1),
(185, 47, 'A', 'Global', 0),
(186, 47, 'B', 'Static', 0),
(187, 47, 'C', 'Public', 0),
(188, 47, 'D', 'Local', 1),
(189, 48, 'A', 'yield', 0),
(190, 48, 'B', 'break', 0),
(191, 48, 'C', 'end', 0),
(192, 48, 'D', 'return', 1);";
if ($conn->query($insertPythonAnswers) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
echo "<script>console.log('Creating c_s....');</script>";
$createCodeSubmissionsTable = "CREATE TABLE IF NOT EXISTS code_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED,
    subject VARCHAR(255) NOT NULL,
    code TEXT NOT NULL,
    question VARCHAR(255),
    correct TINYINT(1),
    submission_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);";
if ($conn->query($createCodeSubmissionsTable) === FALSE) {
    die("Error creating code submissions table: " . htmlspecialchars($conn->error));
}

$conn->close();

    $_SESSION['initialised'] = true;
    echo "<script>console.log('Initialisation complete, redirecting back to login.php...'); window.location.href = 'login.php';</script>";
    exit();
    
    
}
else{
    echo "<script>console.log('Tables found, not resetting...');</script>";
    $conn->close();

    $_SESSION['initialised'] = true;
    echo "<script>console.log('Initialisation complete, redirecting back to login.php...'); window.location.href = 'login.php';</script>";
    exit();
}
    ?>