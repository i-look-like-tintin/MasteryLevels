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

$tableCount = $conn->query("SELECT COUNT(*) > 0 AS has_tables
FROM information_schema.tables
WHERE table_schema = '$dbName';");

if ($tableCount === 0) {

// Select the database
$conn->select_db($dbname);

//TODO: THIS IS ONLY HERE FOR TESTING. IT DELETES THE ENTIRE DATABASE IF SESSION COOKIE NOT SET. IT SHOULD BE REMOVED EVENTUALLY
$sqlTemp = "DROP DATABASE exam_website";
$conn->query($sqlTemp);
echo "<script>console.error('DATABASE DESTROYED');</script>";

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

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

    // Modify the users table to add the 'role' column if it doesn't exist
    $alterUsersTable = "
        ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('student', 'teacher') DEFAULT 'student';
";
    $conn->query($alterUsersTable);
    
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

    $createPythonLevels = "-- To create LEVELS, QUESTIONS, and ANSWER tables:
CREATE TABLE IF NOT EXISTS Levels (
    levelID INT PRIMARY KEY,
    level VARCHAR(50)
);";
if ($conn->query($createPythonLevels) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
$createPythonQuestions = "CREATE TABLE IF NOT EXISTS Questions (
    questionID INT PRIMARY KEY,
    levelID INT,
    question VARCHAR(100),
    FOREIGN KEY (levelID) REFERENCES Levels(levelID)
);";
if ($conn->query($createPythonQuestions) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}
$createPythonAnswers = "CREATE TABLE IF NOT EXISTS Answers (
    answerID INT PRIMARY KEY,
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

$insertPythonLevels = "-- inserting levels, questions and answers into the tables 
INSERT INTO Levels (levelID, level) VALUES 
(1, 'Intro to Python'),
(2, 'Variables and Data Types I'),
(3, 'Variables & Data Types II'),
(4, 'Print Statements'),
(5, 'Operators and Expressions I'),
(6, 'Operators and Expressions II'),
(7, 'Basic String Operators I'),
(8, 'Basic String Operators II'),
(9, 'Basic String Operators III'),
(10, 'Control Flow Conditionals I'),
(11, 'Control Flow Conditionals II'),
(12, 'While Loops'),
(13, 'For Loops'),
(14, 'Loop Control'),
(15, 'Functions I'),
(16, 'Functions II'),
(17, 'List Operations I'),
(18, 'List Operations II'),
(19, 'List Operations III'),
(20, 'Tuples and Sets I'),
(21, 'Tuples and Sets II'),
(22, 'Dictionaries and Dictionary Methods I'),
(23, 'Dictionaries and Dictionary Methods II'),
(24, 'Dictionaries and Dictionary Methods III');";
if ($conn->query($insertPythonLevels) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}

$insertPythonQuestions = "INSERT INTO Questions (questionID, levelID, question)
VALUES 
(1, 1, 'What is the correct file extension for a Python file?'),
(2, 1, 'Which of the following is the correct way to output text in Python?'),
(3, 1, 'How do you run a Python script from the terminal (assuming your file is named script.py)?'),
(4, 1, 'Which symbol is used to write a comment in Python?'),

(5, 2, 'Which of the following is a valid integer in Python?'),
(6, 2, 'What data type is the value ``Hello`` in Python?'),
(7, 2, 'What will type(True) return?'),
(8, 2, 'Which of these is a float in Python?'),

(9, 3, 'What is the result of int(``5``)?'),
(10, 3, 'Which function converts a float to an integer in Python?'),
(11, 3, 'What does str(123) return?'),
(12, 3, 'What happens when you run int(``abc``)'),

(13, 4, 'What does print(``Hello World!``) output?'),
(14, 4, 'What will print(``3 + 4``) output?'),
(15, 4, 'What symbol is used to denote a string inside a print statement?'),
(16, 4, 'Which of the following will print two seperate lines?'),

(17, 5, 'What is the result of (4 + 2 * 3)?'),
(18, 5, 'What does 5 == 5 evaluate to?'),
(19, 5, 'Which operator checks if two values are not equal?'),
(20, 5, 'What is the result of (TRUE and FALSE)?'),

(21, 6, 'What is the result of (2 + 3 * 4)?'),
(22, 6, 'Which of the following operators has the highest precedence?'),
(23, 6, 'In the expression 5 + 3 > 6, what is evaluated first?'),
(24, 6, 'What will (2 * (3 + 4)) evaluate to?'),

(25, 7, 'What is the result of ``Hello`` + ``World``?'),
(26, 7, 'What does ``abc`` * 3 produce?'),
(27, 7, 'What happens when you try ``1`` + 1?'),
(28, 7, 'Which of these can concatenate two strings?'),

(29, 8, 'What does ``Python``[0] return?'),
(30, 8, 'What does ``Python``[-1] return?'),
(31, 8, 'What does ``Python``[1:4] return?'),
(32, 8, 'Which index gives the first character in a string?'),

(33, 9, 'What does ``hello``.upper() return?'),
(34, 9, 'What does ``HeLLo``.lower() return?'),
(35, 9, 'What does `` hello ``.strip() return?'),
(36, 9, 'Which method removes whitespace from both ends of a string?'),

(37, 10, 'Which keyword is used for a simple conditional in Python?'),
(38, 10, 'What does if 5 > 2: do?'),
(39, 10, 'What is the purpose of elif?'),
(40, 10, 'What happens if no condition in if-elif-else is true?'),

(41, 11, 'What is a nested conditional in Python?'),
(42, 11, 'Which of the following represents a nested conditional?'),
(43, 11, 'Nested conditionals are used when:'),
(44, 11, 'Which of these best describes good use of nested if statements?'),

(45, 12, 'What is the purpose of a while loop?'),
(46, 12, 'Which of these is a valid while loop header?'),
(47, 12, 'When should you be careful using while loops?'),
(48, 12, 'Which keyword is used to exit a while loop early?'),

(49, 13, 'What does a for loop do in Python?'),
(50, 13, 'Which is a valid for loop header?'),
(51, 13, 'A for loop can be used with:'),
(52, 13, 'What will range(3) produce?'),

(53, 14, 'What does the break statement do in a loop?'),
(54, 14, 'What is the purpose of the continue statement?'),
(55, 14, 'What does the pass statement do?'),
(56, 14, 'Which statement is useful when you are planning to add code later?'),

(57, 15, 'What keyword is used to define a function in Python?'),
(58, 15, 'Which of the following correctly defines a function?'),
(59, 15, 'How do you call a function named greet?'),
(60, 15, 'What is the purpose of a function?'),

(61, 16, 'What is a local variable?'),
(62, 16, 'Which variable is accessible anywhere in the script?'),
(63, 16, 'What happens if a function defines a variable with the same name as a global one?'),
(64, 16, 'What keyword is used to modify a global variable inside a function?'),

(65, 17, 'Which of these defines a list?'),
(66, 17, 'How do you add an item to a list?'),
(67, 17, 'What is the index of the first element in a list?'),
(68, 17, 'How do you change the second element of a list my_list to ``new``?'),

(69, 18, 'What is iteration?'),
(70, 18, 'Which is a valid way to iterate through a list?'),
(71, 18, 'In a loop, item refers to:'),
(72, 18, 'What happens if you loop over an empty list?'),

(73, 19, 'What does append() do?'),
(74, 19, 'Which method removes a specific item from a list?'),
(75, 19, 'What does sort() do?'),
(76, 19, 'What does pop() do with a list?'),

(77, 20, 'What is the purpose of set() in Python?'),
(78, 20, 'What does union() do?'),
(79, 20, 'Which method returns common elements between two sets?'),
(80, 20, 'Sets do not allow:'),

(81, 21, 'Which of these is immutable?'),
(82, 21, 'Which type is ordered and allows duplicates?'),
(83, 21, 'Which is the best choice when you need fast membership testing?'),
(84, 21, 'Which of these allows key-value pairs?'),

(85, 22, 'What is a dictionary in Python?'),
(86, 22, 'How do you access a value from a dictionary?'),
(87, 22, 'Which of these creates a dictionary?'),
(88, 22, 'What will my_dict[\'age\'] return?'),

(89, 23, 'How do you add a new key-value pair?'),
(90, 23, 'What does update() do?'),
(91, 23, 'How do you delete a key from a dictionary?'),
(92, 23, 'Which method removes a key and returns its value?'),

(93, 24, 'How do you iterate over dictionary keys?'),
(94, 24, 'What does items() return?'),
(95, 24, 'How do you get all the values in a dictionary?'),
(96, 24, 'Which loop gives both key and value?');";
if ($conn->query($insertPythonQuestions) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}

$insertPythonAnswers = "INSERT INTO Answers (answerID, questionID, answer, answer_character, correct)
VALUES
(1, 1, '.pt', 'A', FALSE),
(2, 1, '.pyt', 'B', FALSE),
(3, 1, '.py', 'C', TRUE),
(4, 1, '.script', 'D', FALSE),

(5, 2, 'print(``Hello World``)', 'A', TRUE),
(6, 2, 'echo(``Hello World``)', 'B', FALSE),
(7, 2, 'say(``Hello World``)', 'C', FALSE),
(8, 2, 'console.log(``Hello World``)', 'D', FALSE),

(9, 3, 'python run script.py', 'A', FALSE),
(10, 3, 'run script.py', 'B', FALSE),
(11, 3, 'python script.py', 'C', TRUE),
(12, 3, 'execute script.py', 'D', FALSE),

(13, 4, '//', 'A', FALSE),
(14, 4, '<!--', 'B', FALSE),
(15, 4, '#', 'C', TRUE),
(16, 4, '**', 'D', FALSE),

(17, 5, '5.0', 'A', FALSE),
(18, 5, '``5``', 'B', FALSE),
(19, 5, '5', 'C', TRUE),
(20, 5, 'True', 'D', FALSE),

(21, 6, 'Integer', 'A', FALSE),
(22, 6, 'String', 'B', TRUE),
(23, 6, 'Boolean', 'C', FALSE),
(24, 6, 'Float', 'D', FALSE),

(25, 7, '<class ''int''>', 'A', FALSE),
(26, 7, '<class ''float''>', 'B', FALSE),
(27, 7, '<class ''str''>', 'C', FALSE),
(28, 7, '<class ''bool''>', 'D', TRUE),

(29, 8, '2', 'A', FALSE),
(30, 8, '3.5', 'B', TRUE),
(31, 8, '``3.5``', 'C', FALSE),
(32, 8, 'True', 'D', FALSE),

(33, 9, '``5``', 'A', FALSE),
(34, 9, '5', 'B', TRUE),
(35, 9, '5.0', 'C', FALSE),
(36, 9, 'Error', 'D', FALSE),

(37, 10, 'str()', 'A', FALSE),
(38, 10, 'bool()', 'B', FALSE),
(39, 10, 'float()', 'C', FALSE),
(40, 10, 'int()', 'D', TRUE),

(41, 11, '123', 'A', FALSE),
(42, 11, '``123``', 'B', TRUE),
(43, 11, '1, 2, 3', 'C', FALSE),
(44, 11, 'Error', 'D', FALSE),

(45, 12, 'abc', 'A', FALSE),
(46, 12, 'None', 'B', FALSE),
(47, 12, 'ERROR', 'C', TRUE),
(48, 12, '0', 'D', FALSE),

(49, 13, 'Hello World', 'A', FALSE),
(50, 13, 'Hello World!', 'B', TRUE),
(51, 13, '``Hello World!``', 'C', FALSE),
(52, 13, 'print Hello World!', 'D', FALSE),

(53, 14, '7', 'A', FALSE),
(54, 14, '``7``', 'B', FALSE),
(55, 14, '3 + 4', 'C', TRUE),
(56, 14, 'ERROR', 'D', FALSE),

(57, 15, '#', 'A', FALSE),
(58, 15, '''', 'B', TRUE),
(59, 15, '@', 'C', FALSE),
(60, 15, '&', 'D', FALSE),

(61, 16, 'print(``Line 1`` + ``Line 2``)', 'A', FALSE),
(62, 16, 'print(``Line 1\nLine 2``)', 'B', TRUE),
(63, 16, 'print(``line 1 Line 2``)', 'C', FALSE),
(64, 16, 'print(Line 1, Line 2)', 'D', FALSE),

(65, 17, '18', 'A', FALSE),
(66, 17, '10', 'B', TRUE),
(67, 17, '24', 'C', FALSE),
(68, 17, '14', 'D', FALSE),

(69, 18, 'True', 'A', TRUE),
(70, 18, 'False', 'B', FALSE),
(71, 18, 'None', 'C', FALSE),
(72, 18, 'ERROR', 'D', FALSE),

(73, 19, '!=', 'A', TRUE),
(74, 19, '<>', 'B', FALSE),
(75, 19, '<=', 'C', FALSE),
(76, 19, '==', 'D', FALSE),

(77, 20, 'False', 'A', TRUE),
(78, 20, 'True', 'B', FALSE),
(79, 20, 'None', 'C', FALSE),
(80, 20, 'ERROR', 'D', FALSE),

(81, 21, '20', 'A', FALSE),
(82, 21, '14', 'B', TRUE),
(83, 21, '24', 'C', FALSE),
(84, 21, '10', 'D', FALSE),

(85, 22, '+', 'A', FALSE),
(86, 22, '-', 'B', FALSE),
(87, 22, '*', 'C', TRUE),
(88, 22, '/', 'D', FALSE),

(89, 23, '>', 'A', FALSE),
(90, 23, '+', 'B', TRUE),
(91, 23, '5 + 3 >', 'C', FALSE),
(92, 23, '6', 'D', FALSE),

(93, 24, '10', 'A', FALSE),
(94, 24, '16', 'B', TRUE),
(95, 24, '12', 'C', FALSE),
(96, 24, '9', 'D', FALSE),

(97, 25, 'HelloWorld', 'A', TRUE),
(98, 25, 'Hello World', 'B', FALSE),
(99, 25, 'Hello+World', 'C', FALSE),
(100, 25, 'Error', 'D', FALSE),

(101, 26, 'abcabcabc', 'A', TRUE),
(102, 26, 'abc3', 'B', FALSE),
(103, 26, 'abc abc abc', 'C', FALSE),
(104, 26, 'Error', 'D', FALSE),

(105, 27, '1 + 1', 'A', FALSE),
(106, 27, '``1`` + 1', 'B', TRUE),
(107, 27, '1 + ``1``', 'C', FALSE),
(108, 27, 'Error', 'D', FALSE),

(109, 28, '+', 'A', FALSE),
(110, 28, '-', 'B', FALSE),
(111, 28, '*', 'C', TRUE),
(112, 28, '/', 'D', FALSE),

(113, 29, 'P', 'A', TRUE),
(114, 29, 'Y', 'B', FALSE),
(115, 29, 'n', 'C', FALSE),
(116, 29, 'Error', 'D', FALSE),

(117, 30, 'P', 'A', FALSE),
(118, 30, 'n', 'B', TRUE),
(119, 30, 'o', 'C', FALSE),
(120, 30, 'Error', 'D', FALSE),

(121, 31, 'yth', 'A', TRUE),
(122, 31, 'ytho', 'B', FALSE),
(123, 31, 'Pyt', 'C', FALSE),
(124, 31, 'tho', 'D', FALSE),

(125, 32, '-1', 'A', FALSE),
(126, 32, '0', 'B', TRUE),
(127, 32, '1', 'C', FALSE),
(128, 32, 'None', 'D', FALSE),

(129, 33, 'HELLO', 'A', TRUE),
(130, 33, 'hello', 'B', FALSE),
(131, 33, 'Hello', 'C', FALSE),
(132, 33, 'Upper', 'D', FALSE),

(133, 34, 'HELLO', 'A', FALSE),
(134, 34, 'hello', 'B', TRUE),
(135, 34, 'HeLLo', 'C', FALSE),
(136, 34, 'Lower', 'D', FALSE),

(137, 35, 'hello', 'A', TRUE),
(138, 35, ' hello', 'B', FALSE),
(139, 35, 'hello ', 'C', FALSE),
(140, 35, '`` hello ``', 'D', FALSE),

(141, 36, 'strip()', 'A', TRUE),
(142, 36, 'trim()', 'B', FALSE),
(143, 36, 'remove()', 'C', FALSE),
(144, 36, 'cut()', 'D', FALSE),

(145, 37, 'while', 'A', FALSE),
(146, 37, 'if', 'B', TRUE),
(147, 37, 'loop', 'C', FALSE),
(148, 37, 'do', 'D', FALSE),

(149, 38, 'Prints 5', 'A', FALSE),
(150, 38, 'Executes the next indented block', 'B', TRUE),
(151, 38, 'Errors out', 'C', FALSE),
(152, 38, 'Compares as string', 'D', FALSE),

(153, 39, 'Ends a block', 'A', FALSE),
(154, 39, 'Always runs', 'B', FALSE),
(155, 39, 'Adds another condition', 'C', TRUE),
(156, 39, 'Repeats code', 'D', FALSE),

(157, 40, 'It crashes', 'A', FALSE),
(158, 40, 'The else block runs', 'B', TRUE),
(159, 40, 'All blocks run', 'C', FALSE),
(160, 40, 'Nothing runs', 'D', FALSE),

(161, 41, 'A conditional inside a function', 'A', FALSE),
(162, 41, 'A loop inside an if statement', 'B', FALSE),
(163, 41, 'An if or else statement inside another if', 'C', TRUE),
(164, 41, 'A variable that stores a condition', 'D', FALSE),

(165, 42, 'if x == 5 and y == 10:', 'A', FALSE),
(166, 42, 'if x == 5: if y == 10: print(``Yes``)', 'B', TRUE),
(167, 42, 'if x == 5 or y == 10:', 'C', FALSE),
(168, 42, 'if x == 5, y == 10:', 'D', FALSE),

(169, 43, 'You need to run code regardless of condition', 'A', FALSE),
(170, 43, 'Multiple variables must be defined', 'B', FALSE),
(171, 43, 'One decision depends on another', 'C', TRUE),
(172, 43, 'You are importing modules', 'D', FALSE),

(173, 44, 'Always use nested conditionals for clarity', 'A', FALSE),
(174, 44, 'Use when one condition needs another to be true', 'B', TRUE),
(175, 44, 'Avoid them; they are not valid in Python', 'C', FALSE),
(176, 44, 'Use them only in for loops', 'D', FALSE),

(177, 45, 'To perform an operation once', 'A', FALSE),
(178, 45, 'To perform repeated tasks until a condition is false', 'B', TRUE),
(179, 45, 'To call functions', 'C', FALSE),
(180, 45, 'To loop through dictionaries', 'D', FALSE),

(181, 46, 'while x > 0:', 'A', TRUE),
(182, 46, 'while (x > 0)', 'B', FALSE),
(183, 46, 'repeat while x > 0', 'C', FALSE),
(184, 46, 'loop x > 0:', 'D', FALSE),

(185, 47, 'When using print statements', 'A', FALSE),
(186, 47, 'When conditions never become false', 'B', TRUE),
(187, 47, 'When declaring functions', 'C', FALSE),
(188, 47, 'When importing libraries', 'D', FALSE),

(189, 48, 'skip', 'A', FALSE),
(190, 48, 'end', 'B', FALSE),
(191, 48, 'break', 'C', TRUE),
(192, 48, 'stop', 'D', FALSE),

(193, 49, 'It defines a function', 'A', FALSE),
(194, 49, 'It executes code while a condition is true', 'B', FALSE),
(195, 49, 'It iterates over a sequence', 'C', TRUE),
(196, 49, 'It checks conditions', 'D', FALSE),

(197, 50, 'for (x in range(5)):', 'A', FALSE),
(198, 50, 'for x to 5:', 'B', FALSE),
(199, 50, 'for x in range(5):', 'C', TRUE),
(200, 50, 'loop x = 0 to 5', 'D', FALSE),

(201, 51, 'Strings', 'A', FALSE),
(202, 51, 'Lists', 'B', FALSE),
(203, 51, 'Ranges', 'C', FALSE),
(204, 51, 'All of the above', 'D', TRUE),

(205, 52, '1, 2, 3', 'A', FALSE),
(206, 52, '0, 1, 2', 'B', TRUE),
(207, 52, '0, 1, 2, 3', 'C', FALSE),
(208, 52, 'Nothing', 'D', FALSE),

(209, 53, 'Skips to the next item', 'A', FALSE),
(210, 53, 'Exits the loop completely', 'B', TRUE),
(211, 53, 'Restarts the loop', 'C', FALSE),
(212, 53, 'Does nothing', 'D', FALSE),

(213, 54, 'Stops the entire program', 'A', FALSE),
(214, 54, 'Exits the loop', 'B', FALSE),
(215, 54, 'Skips the rest of the loop body and goes to the next iteration', 'C', TRUE),
(216, 54, 'Pauses the loop', 'D', FALSE),

(217, 55, 'Skips the loop', 'A', FALSE),
(218, 55, 'Does nothing; its a placeholder', 'B', TRUE),
(219, 55, 'Exits the function', 'C', FALSE),
(220, 55, 'Skips one line', 'D', FALSE),

(221, 56, 'return', 'A', FALSE),
(222, 56, 'skip', 'B', FALSE),
(223, 56, 'pass', 'C', TRUE),
(224, 56, 'break', 'D', FALSE),

(225, 57, 'define', 'A', FALSE),
(226, 57, 'func', 'B', FALSE),
(227, 57, 'def', 'C', TRUE),
(228, 57, 'function', 'D', FALSE),

(229, 58, 'def my_function():', 'A', TRUE),
(230, 58, 'function my_function()', 'B', FALSE),
(231, 58, 'my_function(): def', 'C', FALSE),
(232, 58, 'def: my_function()', 'D', FALSE),

(233, 59, 'call greet()', 'A', FALSE),
(234, 59, 'run greet()', 'B', FALSE),
(235, 59, 'greet()', 'C', TRUE),
(236, 59, 'start greet', 'D', FALSE),

(237, 60, 'To write conditions', 'A', FALSE),
(238, 60, 'To repeat code in loops', 'B', FALSE),
(239, 60, 'To group code that can be reused', 'C', TRUE),
(240, 60, 'To declare variables', 'D', FALSE),

(241, 61, 'A variable defined inside a function', 'A', TRUE),
(242, 61, 'A variable defined outside all functions', 'B', FALSE),
(243, 61, 'A variable from another module', 'C', FALSE),
(244, 61, 'A reserved keyword', 'D', FALSE),

(245, 62, 'Local', 'A', FALSE),
(246, 62, 'Private', 'B', FALSE),
(247, 62, 'Global', 'C', TRUE),
(248, 62, 'Constant', 'D', FALSE),

(249, 63, 'It updates the global one', 'A', FALSE),
(250, 63, 'It causes an error', 'B', FALSE),
(251, 63, 'It creates a new local variable', 'C', TRUE),
(252, 63, 'It deletes the global one', 'D', FALSE),

(253, 64, 'change', 'A', FALSE),
(254, 64, 'override', 'B', FALSE),
(255, 64, 'global', 'C', TRUE),
(256, 64, 'set', 'D', FALSE),

(257, 65, 'list = {}', 'A', FALSE),
(258, 65, 'list = ()', 'B', FALSE),
(259, 65, 'list = []', 'C', TRUE),
(260, 65, 'list = <>', 'D', FALSE),

(261, 66, 'list.add(item)', 'A', FALSE),
(262, 66, 'list.push(item)', 'B', FALSE),
(263, 66, 'list.append(item)', 'C', TRUE),
(264, 66, 'list.insert(item)', 'D', FALSE),

(265, 67, '1', 'A', FALSE),
(266, 67, '0', 'B', TRUE),
(267, 67, '-1', 'C', FALSE),
(268, 67, 'It depends', 'D', FALSE),

(269, 68, 'my_list[2] = ``new``', 'A', FALSE),
(270, 68, 'my_list[1] = ``new``', 'B', TRUE),
(271, 68, 'my_list[0] = ``new``', 'C', FALSE),
(272, 68, 'my_list[``2``] = ``new``', 'D', FALSE),

(273, 69, 'Changing elements in a list', 'A', FALSE),
(274, 69, 'Repeating actions over items', 'B', TRUE),
(275, 69, 'Copying a list', 'C', FALSE),
(276, 69, 'Sorting items in a list', 'D', FALSE),

(277, 70, 'for item of list:', 'A', FALSE),
(278, 70, 'for list in item:', 'B', FALSE),
(279, 70, 'for item in my_list:', 'C', TRUE),
(280, 70, 'loop item from my_list:', 'D', FALSE),

(281, 71, 'The index number', 'A', FALSE),
(282, 71, 'Each value in the list', 'B', TRUE),
(283, 71, 'The length of the list', 'C', FALSE),
(284, 71, 'A new list', 'D', FALSE),

(285, 72, 'It prints ``empty``', 'A', FALSE),
(286, 72, 'It runs once', 'B', FALSE),
(287, 72, 'It throws an error', 'C', FALSE),
(288, 72, 'It does nothing', 'D', TRUE),

(289, 73, 'Removes an element', 'A', FALSE),
(290, 73, 'Sorts the list', 'B', FALSE),
(291, 73, 'Adds an element to the end', 'C', TRUE),
(292, 73, 'Adds two lists', 'D', FALSE),

(293, 74, 'delete()', 'A', FALSE),
(294, 74, 'remove()', 'B', TRUE),
(295, 74, 'pop()', 'C', FALSE),
(296, 74, 'clear()', 'D', FALSE),

(297, 75, 'Sorts the list alphabetically or numerically', 'A', TRUE),
(298, 75, 'Removes duplicate values', 'B', FALSE),
(299, 75, 'Adds items to a new list', 'C', FALSE),
(300, 75, 'Splits the list', 'D', FALSE),

(301, 76, 'Adds an element', 'A', FALSE),
(302, 76, 'Removes the last element and returns it', 'B', TRUE),
(303, 76, 'Empties the list', 'C', FALSE),
(304, 76, 'Sorts it in reverse', 'D', FALSE),

(305, 77, 'To create a tuple', 'A', FALSE),
(306, 77, 'To create an ordered list', 'B', FALSE),
(307, 77, 'To create an unordered collection of unique values', 'C', TRUE),
(308, 77, 'To define constants', 'D', FALSE),

(309, 78, 'Finds common elements', 'A', FALSE),
(310, 78, 'Combines two sets, removing duplicates', 'B', TRUE),
(311, 78, 'Removes elements from both sets', 'C', FALSE),
(312, 78, 'Sorts both sets', 'D', FALSE),

(313, 79, 'join()', 'A', FALSE),
(314, 79, 'merge()', 'B', FALSE),
(315, 79, 'intersection()', 'C', TRUE),
(316, 79, 'duplicate()', 'D', FALSE),

(317, 80, 'Integers', 'A', FALSE),
(318, 80, 'Strings', 'B', FALSE),
(319, 80, 'Duplicate values', 'C', TRUE),
(320, 80, 'Operations', 'D', FALSE),

(321, 81, 'List', 'A', FALSE),
(322, 81, 'Tuple', 'B', TRUE),
(323, 81, 'Set', 'C', FALSE),
(324, 81, 'Dictionary', 'D', FALSE),

(325, 82, 'Set', 'A', FALSE),
(326, 82, 'List', 'B', TRUE),
(327, 82, 'Dictionary', 'C', FALSE),
(328, 82, 'Tuple', 'D', FALSE),

(329, 83, 'List', 'A', FALSE),
(330, 83, 'Tuple', 'B', FALSE),
(331, 83, 'Set', 'C', TRUE),
(332, 83, 'String', 'D', FALSE),

(333, 84, 'Tuple', 'A', FALSE),
(334, 84, 'Set', 'B', FALSE),
(335, 84, 'List', 'C', FALSE),
(336, 84, 'Dictionary', 'D', TRUE),

(337, 85, 'A list of words', 'A', FALSE),
(338, 85, 'An unordered collection of key-value pairs', 'B', TRUE),
(339, 85, 'A set of strings', 'C', FALSE),
(340, 85, 'A function list', 'D', FALSE),

(341, 86, 'dict.value(key)', 'A', FALSE),
(342, 86, 'dict.get(value)', 'B', FALSE),
(343, 86, 'dict[key]', 'C', TRUE),
(344, 86, 'dict -> key', 'D', FALSE),

(345, 87, '{}', 'A', TRUE),
(346, 87, '[]', 'B', FALSE),
(347, 87, '()', 'C', FALSE),
(348, 87, '<>', 'D', FALSE),

(349, 88, 'The key \'age\'', 'A', FALSE),
(350, 88, 'The value assigned to \'age\'', 'B', TRUE),
(351, 88, 'The entire dictionary', 'C', FALSE),
(352, 88, 'A tuple', 'D', FALSE),

(353, 89, 'dict.add(\'key\', \'value\')', 'A', FALSE),
(354, 89, 'dict[\'key\'] = \'value\'', 'B', TRUE),
(355, 89, 'dict.push(\'key\', \'value\')', 'C', FALSE),
(356, 89, 'dict.update(\'key\', \'value\')', 'D', FALSE),

(357, 90, 'Adds or modifies key-value pairs', 'A', TRUE),
(358, 90, 'Sorts the dictionary', 'B', FALSE),
(359, 90, 'Removes a key', 'C', FALSE),
(360, 90, 'Clears the dictionary', 'D', FALSE),

(361, 91, 'remove dict[\'key\']', 'A', FALSE),
(362, 91, 'dict.delete(\'key\')', 'B', FALSE),
(363, 91, 'del dict[\'key\']', 'C', TRUE),
(364, 91, 'dict.popall()', 'D', FALSE),

(365, 92, 'pop()', 'A', TRUE),
(366, 92, 'remove()', 'B', FALSE),
(367, 92, 'cut()', 'C', FALSE),
(368, 92, 'pull()', 'D', FALSE),

(369, 93, 'for key in dict:', 'A', TRUE),
(370, 93, 'for dict in key:', 'B', FALSE),
(371, 93, 'loop key from dict', 'C', FALSE),
(372, 93, 'dict.forEach()', 'D', FALSE),

(373, 94, 'A list of keys', 'A', FALSE),
(374, 94, 'A list of values', 'B', FALSE),
(375, 94, 'A list of key-value pairs', 'C', TRUE),
(376, 94, 'A sorted dictionary', 'D', FALSE),

(377, 95, 'dict.getall()', 'A', FALSE),
(378, 95, 'dict.values()', 'B', TRUE),
(379, 95, 'dict.keyvalues()', 'C', FALSE),
(380, 95, 'dict.pairs()', 'D', FALSE),

(381, 96, 'for key in dict:', 'A', FALSE),
(382, 96, 'for key, value in dict.items():', 'B', TRUE),
(383, 96, 'for item in dict.values():', 'C', FALSE),
(384, 96, 'for item in dict.keys():', 'D', FALSE);";
if ($conn->query($insertPythonAnswers) === FALSE) {
    die("Error creating quizzes table: " . htmlspecialchars($conn->error));
}



$conn->close();

    $_SESSION['initialised'] = true;
    echo "<script>console.log('Initialisation complete, redirecting back to login.php...'); window.location.href = 'login.php';</script>";
    exit();
    
    
}
else{
    $conn->close();

    $_SESSION['initialised'] = true;
    echo "<script>console.log('Initialisation complete, redirecting back to login.php...'); window.location.href = 'login.php';</script>";
    exit();
}
    ?>
