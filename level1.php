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

// Create the quizzes table if it doesn't exist
$createQuizzesTable = "
    CREATE TABLE IF NOT EXISTS quizzes (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(255),
        level VARCHAR(255),
        question TEXT,
        option_a VARCHAR(255),
        option_b VARCHAR(255),
        option_c VARCHAR(255),
        option_d VARCHAR(255),
        correct_option CHAR(1)
    );
";
$conn->query($createQuizzesTable);

// Clear all previous entries in the quizzes table
$truncateQuizzesTable = "TRUNCATE TABLE quizzes";
$conn->query($truncateQuizzesTable);


// Insert the questions into the quizzes table
$insertQuestions = "
    INSERT INTO quizzes (subject, level, question, option_a, option_b, option_c, option_d, correct_option) VALUES

    -- Core Maths questions
    ('Core Maths', 'Level 1', 'What is the value of the derivative of f(x)=x^2+3x+5 at x = 2?', '7', '8', '11', '13', 'c'),
    ('Core Maths', 'Level 1', 'What is the integral of f(x)=3x^2 with respect to x?', 'x^3', 'x^3 + C', 'x^3 + 3x + C', 'x^3 + C', 'c'),
    ('Core Maths', 'Level 1', 'Which of the following is the limit of (3x^2+2xâ1)/(x-1) as x approaches 1?', '4', '5', '6', '7', 'c'),
    ('Core Maths', 'Level 1', 'What is the solution to the equation ln(x)=3?', 'e', 'e^3', 'e^2', 'e^4', 'b'),
    ('Core Maths', 'Level 1', 'The function f(x)=x^3â3x+1 has how many real roots?', '0', '1', '2', '3', 'd'),
    ('Core Maths', 'Level 1', 'Which of the following is the correct simplification of (2x^2+8x)/2x?', 'x+4', 'x+2', 'x+3', 'x+1', 'b'),
    ('Core Maths', 'Level 1', 'The sum of the series 1+1/2 +1/4 +1/8+ â¯ is?', '1', '1.5', '2', '2.5', 'c'),
    ('Core Maths', 'Level 1', 'Which of the following statements is true for the function f(x)=sin(x) on the interval [0,2Ï]?', 'f(x) is decreasing', 'f(x) is increasing', 'f(x) has one maximum and one minimum', 'f(x) has two maxima and two minima', 'd'),
    ('Core Maths', 'Level 1', 'What is the derivative of f(x)=e^{2x}?', '2e^x', 'e^{2x}', '2e^{2x}', 'e^{2x}+2', 'c'),
    ('Core Maths', 'Level 1', 'The determinant of the matrix \\(\\begin{pmatrix}1 & 3\\\\2 & 4\\end{pmatrix}\\) is:', '-2', '-4', '2', '4', 'b'),

    -- Discrete Maths questions
    ('Discrete Maths', 'Level 1', 'What is the sum of the first 100 natural numbers?', '5050', '4950', '5000', '5100', 'a'),
    ('Discrete Maths', 'Level 1', 'Which of the following is true for an undirected tree with n vertices?', 'It has n-1 edges', 'It has n edges', 'It has n+1 edges', 'It has 2n edges', 'a'),
    ('Discrete Maths', 'Level 1', 'What is the cardinality of the power set of a set with 3 elements?', '3', '6', '8', '9', 'c'),
    ('Discrete Maths', 'Level 1', 'In a simple graph, the sum of the degrees of all vertices is:', 'Equal to the number of edges', 'Twice the number of edges', 'Half the number of edges', 'Independent of the number of edges', 'b'),
    ('Discrete Maths', 'Level 1', 'Which of the following represents a bijective function?', 'f(x)=x^2', 'f(x)=2x+1', 'f(x)=x^3-1', 'f(x)=sqrt(x)', 'b'),
    ('Discrete Maths', 'Level 1', 'What is the result of 5 choose 2?', '5', '10', '15', '20', 'b'),
    ('Discrete Maths', 'Level 1', 'The greatest common divisor of 56 and 98 is:', '7', '14', '28', '49', 'c'),
    ('Discrete Maths', 'Level 1', 'In propositional logic pâq is equivalent to:', 'Â¬pâ¨q', 'pâ§q', 'pâ¨q', 'Â¬pâ§q', 'a'),
    ('Discrete Maths', 'Level 1', 'Which of the following sets is countable?', 'The set of all real numbers', 'The set of all rational numbers', 'The set of all irrational numbers', 'The set of all complex numbers', 'b'),

    -- Introduction to Programming questions
    ('Introduction to Programming', 'Level 1', 'Which of the following is a valid variable name in Python?', '2var', 'var_2', 'var-2', 'var.2', 'b'),
    ('Introduction to Programming', 'Level 1', 'What is the output of the following code: print(2 ** 3)?', '6', '8', '9', '12', 'b'),
    ('Introduction to Programming', 'Level 1', 'Which keyword is used to handle exceptions in Python?', 'try', 'except', 'catch', 'handle', 'b'),
    ('Introduction to Programming', 'Level 1', 'What is the purpose of the break statement in Python?', 'To exit a function', 'To exit a loop', 'To pause execution', 'To exit the program', 'b'),
    ('Introduction to Programming', 'Level 1', 'Which of the following statements is true for a Python dictionary?', 'It is a collection of ordered items', 'It allows duplicate keys', 'It is indexed by keys', 'It is indexed by positions', 'c'),
    ('Introduction to Programming', 'Level 1', 'What will be the output of the following code: print(len(\"Python\"))?', '5', '6', '7', '8', 'b'),
    ('Introduction to Programming', 'Level 1', 'What does the len() function do in Python?', 'It counts the number of items in an object', 'It adds an item to an object', 'It removes an item from an object', 'It modifies an item in an object', 'a'),
    ('Introduction to Programming', 'Level 1', 'What is the result of the expression 5 // 2 in Python?', '2', '2.5', '3', '1', 'a'),
    ('Introduction to Programming', 'Level 1', 'Which of the following is the correct way to define a function in Python?', 'def func[]:', 'def func():', 'def func{}:', 'function func(){}', 'b'),
    ('Introduction to Programming', 'Level 1', 'How do you create a comment in Python?', '/* Comment */', '// Comment', '-- Comment', '# Comment', 'd'),
    ('Introduction to Programming', 'Level 1', 'Which of the following is the correct syntax for a list in Python?', '[1, 2, 3]', '{1, 2, 3}', '(1, 2, 3)', '<1, 2, 3>', 'a'),
    ('Introduction to Programming', 'Level 1', 'Which of the following is not a valid data type in Python?', 'int', 'string', 'float', 'double', 'd'),

    -- Intro to Cyber questions
    ('Intro to Cyber', 'Level 1', 'Which of the following is a type of malware?', 'Firewall', 'Antivirus', 'Trojan', 'VPN', 'c'),
    ('Intro to Cyber', 'Level 1', 'What does the acronym CIA stand for in cyber security?', 'Central Intelligence Agency', 'Confidentiality, Integrity, Availability', 'Cyber Intelligence Agency', 'Confidentiality, Information, Access', 'b'),
    ('Intro to Cyber', 'Level 1', 'What is phishing?', 'A type of encryption', 'A method of hacking passwords', 'A technique to obtain sensitive information by disguising as a trustworthy entity', 'A type of firewall', 'c'),
    ('Intro to Cyber', 'Level 1', 'Which of the following is used to detect and prevent unauthorized access to a network?', 'Router', 'Switch', 'Intrusion Detection System (IDS)', 'Hub', 'c'),
    ('Intro to Cyber', 'Level 1', 'What is the primary purpose of a firewall?', 'To scan for viruses', 'To encrypt data', 'To monitor and control incoming and outgoing network traffic', 'To backup data', 'c'),
    ('Intro to Cyber', 'Level 1', 'Which of the following is an example of a strong password?', 'password123', 'qwerty', 'Abc123', '9f3!@#', 'd'),
    ('Intro to Cyber', 'Level 1', 'What is a Denial of Service (DoS) attack?', 'An attempt to steal data', 'An attempt to block access to a network resource', 'An attempt to encrypt data', 'An attempt to gain unauthorized access to a system', 'b'),
    ('Intro to Cyber', 'Level 1', 'Which of the following is a common method of two-factor authentication?', 'Password and username', 'Password and email', 'Password and OTP (One-Time Password)', 'Password and security question', 'c'),
    ('Intro to Cyber', 'Level 1', 'What is encryption?', 'The process of compressing data', 'The process of converting data into a code to prevent unauthorized access', 'The process of backing up data', 'The process of deleting data', 'b'),
    ('Intro to Cyber', 'Level 1', 'Which of the following best describes a zero-day vulnerability?', 'A vulnerability that has been patched', 'A vulnerability that is widely known', 'A vulnerability that is unknown to the software vendor and has no patch yet', 'A vulnerability that only affects old systems', 'c'),

    -- Computer Fundamentals questions
    ('Computer Fundamentals', 'Level 1', 'What does CPU stand for?', 'Central Processing Unit', 'Central Performance Unit', 'Central Processing Utility', 'Central Performance Utility', 'a'),
    ('Computer Fundamentals', 'Level 1', 'Which of the following is a volatile memory?', 'ROM', 'Hard Disk', 'RAM', 'SSD', 'c'),
    ('Computer Fundamentals', 'Level 1', 'What does BIOS stand for?', 'Basic Input Output System', 'Binary Input Output System', 'Basic Internal Operating System', 'Binary Internal Operating System', 'a'),
    ('Computer Fundamentals', 'Level 1', 'Which of the following is an example of an input device?', 'Monitor', 'Printer', 'Keyboard', 'Speaker', 'c'),
    ('Computer Fundamentals', 'Level 1', 'What is the primary function of an operating system?', 'To perform calculations', 'To manage hardware and software resources', 'To store data', 'To protect data from viruses', 'b'),
    ('Computer Fundamentals', 'Level 1', 'Which of the following is not an example of application software?', 'Microsoft Word', 'Adobe Photoshop', 'Windows 10', 'Google Chrome', 'c'),
    ('Computer Fundamentals', 'Level 1', 'Which of the following is the smallest unit of data in a computer?', 'Byte', 'Bit', 'Nibble', 'Kilobyte', 'b'),
    ('Computer Fundamentals', 'Level 1', 'Which of the following storage devices uses magnetic storage technology?', 'SSD', 'HDD', 'RAM', 'Flash Drive', 'b'),
    ('Computer Fundamentals', 'Level 1', 'What is the function of a router in a network?', 'To connect different networks and route data between them', 'To amplify signals', 'To store data', 'To protect the network from viruses', 'a'),
    ('Computer Fundamentals', 'Level 1', 'Which of the following is an example of system software?', 'Web Browser', 'Database Management System', 'Operating System', 'Word Processor', 'c'),

    -- Cyber Law and Ethics questions
    ('Cyber Law and Ethics', 'Level 1', 'Which of the following acts governs digital copyright laws in the United States?', 'Computer Fraud and Abuse Act', 'Digital Millennium Copyright Act (DMCA)', 'Sarbanes-Oxley Act', 'Patriot Act', 'b'),
    ('Cyber Law and Ethics', 'Level 1', 'What does GDPR stand for?', 'General Data Privacy Regulation', 'General Data Protection Regulation', 'Global Data Privacy Regulation', 'Global Data Protection Regulation', 'b'),
    ('Cyber Law and Ethics', 'Level 1', 'What is the primary goal of cyber ethics?', 'To enforce cyber laws', 'To define right and wrong behavior in cyberspace', 'To regulate online commerce', 'To monitor internet usage', 'b'),
    ('Cyber Law and Ethics', 'Level 1', 'Which of the following is considered illegal under the Computer Fraud and Abuse Act (CFAA)?', 'Accessing a computer without authorization', 'Sending marketing emails', 'Using encryption software', 'Backing up data', 'a'),
    ('Cyber Law and Ethics', 'Level 1', 'What does the term \"phishing\" refer to in cybercrime?', 'Hacking into systems', 'Stealing physical devices', 'Fraudulently obtaining sensitive information by disguising as a trustworthy entity', 'Encrypting data without permission', 'c'),
    ('Cyber Law and Ethics', 'Level 1', 'Which of the following is a key principle of ethical hacking?', 'Exploiting vulnerabilities for personal gain', 'Discovering and fixing vulnerabilities', 'Ignoring security protocols', 'Sharing confidential data', 'b'),
    ('Cyber Law and Ethics', 'Level 1', 'Which of the following laws is designed to protect the privacy of personal data collected by companies?', 'HIPAA', 'COPPA', 'GDPR', 'DMCA', 'c'),
    ('Cyber Law and Ethics', 'Level 1', 'What is the purpose of the Children\'s Online Privacy Protection Act (COPPA)?', 'To regulate online advertising', 'To protect the privacy of children under 13', 'To prevent cyberbullying', 'To enforce copyright laws', 'b'),
    ('Cyber Law and Ethics', 'Level 1', 'Which of the following actions is considered ethical behavior in cyberspace?', 'Sharing someone\'s personal information without consent', 'Respecting others\' privacy and data', 'Spreading false information', 'Accessing unauthorized networks', 'b'),
    ('Cyber Law and Ethics', 'Level 1', 'What does the term \"cyberbullying\" refer to?', 'Unauthorized data access', 'Harassing or threatening someone online', 'Spamming email inboxes', 'Stealing online identities', 'b'),

    -- Algorithms and Computational Problems questions
    ('Algorithms and Computational Problems', 'Level 2', 'What is the time complexity of binary search in a sorted array?', 'O(n)', 'O(log n)', 'O(n^2)', 'O(n log n)', 'b'),
    ('Algorithms and Computational Problems', 'Level 2', 'Which of the following algorithms is used for finding the shortest path in a graph?', 'Quick Sort', 'Merge Sort', 'Dijkstra\'s Algorithm', 'Depth-First Search', 'c'),
    ('Algorithms and Computational Problems', 'Level 2', 'What is the best-case time complexity of Quick Sort?', 'O(n)', 'O(n log n)', 'O(n^2)', 'O(log n)', 'b'),
    ('Algorithms and Computational Problems', 'Level 2', 'Which algorithm is used to solve the Minimum Spanning Tree problem?', 'Kruskal\'s Algorithm', 'Breadth-First Search', 'Bellman-Ford Algorithm', 'Depth-First Search', 'a'),
    ('Algorithms and Computational Problems', 'Level 2', 'What is the time complexity of the Bubble Sort algorithm in the worst case?', 'O(n)', 'O(n log n)', 'O(n^2)', 'O(log n)', 'c'),
    ('Algorithms and Computational Problems', 'Level 2', 'Which of the following problems is solved using dynamic programming?', 'Linear Search', 'Longest Common Subsequence', 'Insertion Sort', 'Depth-First Search', 'b'),
    ('Algorithms and Computational Problems', 'Level 2', 'What is the space complexity of Merge Sort?', 'O(1)', 'O(log n)', 'O(n)', 'O(n^2)', 'c'),
    ('Algorithms and Computational Problems', 'Level 2', 'Which of the following is a greedy algorithm?', 'Depth-First Search', 'Prim\'s Algorithm', 'Merge Sort', 'Binary Search', 'b'),
    ('Algorithms and Computational Problems', 'Level 2', 'What is the purpose of the Big-O notation?', 'To measure the exact time taken by an algorithm', 'To measure the efficiency of an algorithm', 'To measure the space required by an algorithm', 'To describe the correctness of an algorithm', 'b'),
    ('Algorithms and Computational Problems', 'Level 2', 'Which of the following algorithms is used for sorting?', 'Dijkstra\'s Algorithm', 'Breadth-First Search', 'Quick Sort', 'Bellman-Ford Algorithm', 'c'),

    -- Coding and Data Structures questions
    ('Coding and Data Structures', 'Level 2', 'Which data structure uses FIFO (First In First Out) principle?', 'Stack', 'Queue', 'Array', 'Linked List', 'b'),
    ('Coding and Data Structures', 'Level 2', 'What is the time complexity of accessing an element in an array?', 'O(1)', 'O(n)', 'O(log n)', 'O(n log n)', 'a'),
    ('Coding and Data Structures', 'Level 2', 'Which data structure uses LIFO (Last In First Out) principle?', 'Queue', 'Stack', 'Array', 'Linked List', 'b'),
    ('Coding and Data Structures', 'Level 2', 'What is a binary tree in which the value of each node is greater than the values of its children called?', 'Binary Search Tree', 'Min-Heap', 'Max-Heap', 'AVL Tree', 'c'),
    ('Coding and Data Structures', 'Level 2', 'Which of the following is an example of a dynamic data structure?', 'Array', 'Linked List', 'Stack', 'Queue', 'b'),
    ('Coding and Data Structures', 'Level 2', 'What is the time complexity of searching an element in a balanced binary search tree?', 'O(1)', 'O(log n)', 'O(n)', 'O(n^2)', 'b'),
    ('Coding and Data Structures', 'Level 2', 'Which of the following data structures is used for depth-first search of a graph?', 'Queue', 'Stack', 'Array', 'Linked List', 'b'),
    ('Coding and Data Structures', 'Level 2', 'What is the best-case time complexity of the insertion sort algorithm?', 'O(1)', 'O(log n)', 'O(n)', 'O(n^2)', 'c'),
    ('Coding and Data Structures', 'Level 2', 'Which of the following data structures is used to implement recursion?', 'Queue', 'Stack', 'Array', 'Linked List', 'b'),
    ('Coding and Data Structures', 'Level 2', 'What is the time complexity of inserting an element in a hash table in the average case?', 'O(1)', 'O(n)', 'O(log n)', 'O(n log n)', 'a'),

    -- Advanced Math questions
    ('Advanced Math', 'Level 2', 'Which of the following is an eigenvalue of the matrix \\(\\begin{pmatrix}2 & 1\\\\1 & 2\\end{pmatrix}\\)?', '1', '2', '3', '4', 'c'),
    ('Advanced Math', 'Level 2', 'What is the value of the integral \\(\\int_0^1 x^2 dx\\)?', '1/2', '1/3', '1/4', '1/5', 'b'),
    ('Advanced Math', 'Level 2', 'Which of the following is a solution to the differential equation dy/dx = y?', 'y=x', 'y=x^2', 'y=e^x', 'y=sin(x)', 'c'),
    ('Advanced Math', 'Level 2', 'What is the value of the determinant of the matrix \\(\\begin{pmatrix}3 & 0\\\\0 & 4\\end{pmatrix}\\)?', '3', '4', '7', '12', 'd'),
    ('Advanced Math', 'Level 2', 'Which of the following series is convergent?', '\\(\\sum_{n=1}^{\\infty} \\frac{1}{n}\\)', '\\(\\sum_{n=1}^{\\infty} \\frac{1}{n^2}\\)', '\\(\\sum_{n=1}^{\\infty} n\\)', '\\(\\sum_{n=1}^{\\infty} 2^n\\)', 'b'),
    ('Advanced Math', 'Level 2', 'What is the value of \\(\\lim_{x\\to0} \\frac{\\sin(x)}{x}\\)?', '0', '1', 'â', 'ââ', 'b'),
    ('Advanced Math', 'Level 2', 'Which of the following matrices is invertible?', '\\(\\begin{pmatrix}1 & 0 & 0 & 0\\\\0 & 1 & 1 & 0\\\\0 & 1 & 1 & 0\\\\0 & 0 & 0 & 1\\end{pmatrix}\\)', '\\(\\begin{pmatrix}0 & 1 & 1 & 0\\\\1 & 1 & 0 & 0\\\\0 & 1 & 1 & 0\\\\0 & 0 & 0 & 1\\end{pmatrix}\\)', '\\(\\begin{pmatrix}0 & 0 & 0 & 1\\\\0 & 0 & 0 & 1\\\\0 & 0 & 0 & 1\\\\0 & 0 & 0 & 1\\end{pmatrix}\\)', '\\(\\begin{pmatrix}1 & 1 & 1 & 1\\\\1 & 1 & 1 & 1\\\\1 & 1 & 1 & 1\\\\1 & 1 & 1 & 1\\end{pmatrix}\\)', 'b'),
    ('Advanced Math', 'Level 2', 'Which of the following is a real root of the polynomial x^3â2x+1=0?', '-1', '0', '1', '2', 'c'),
    ('Advanced Math', 'Level 2', 'What is the value of the dot product A.B where a=(1,2,3) and b=(4,5,6)?', '32', '34', '36', '38', 'c'),
    ('Advanced Math', 'Level 2', 'Which of the following integrals represents the area under the curve y = x^2 from x = 0 to x =1?', '\\(\\int x^2 dx\\)', '\\(\\int 2x dx\\)', '\\(\\int x dx\\)', '\\(\\int x^4 dx\\)', 'a'),

    -- Computer Systems questions
    ('Computer Systems', 'Level 2', 'Which of the following is a primary component of a computer system?', 'Monitor', 'Printer', 'CPU', 'Keyboard', 'c'),
    ('Computer Systems', 'Level 2', 'What does RAM stand for?', 'Random Access Memory', 'Read Access Memory', 'Rapid Access Memory', 'Read-Only Memory', 'a'),
    ('Computer Systems', 'Level 2', 'What is the function of the operating system?', 'To perform calculations', 'To manage hardware and software resources', 'To store data', 'To protect data from viruses', 'b'),
    ('Computer Systems', 'Level 2', 'Which of the following is an example of an output device?', 'Keyboard', 'Mouse', 'Monitor', 'Scanner', 'c'),
    ('Computer Systems', 'Level 2', 'Which of the following is a non-volatile storage device?', 'RAM', 'Hard Disk Drive', 'Cache', 'Registers', 'b'),
    ('Computer Systems', 'Level 2', 'What is the function of a motherboard?', 'To store data', 'To connect and allow communication between different components of a computer', 'To process data', 'To display data', 'b'),
    ('Computer Systems', 'Level 2', 'Which of the following represents the speed of a CPU?', 'Bytes', 'Hertz', 'Pixels', 'Bits', 'b'),
    ('Computer Systems', 'Level 2', 'What is the purpose of a network interface card (NIC)?', 'To provide a physical connection to a network', 'To process data', 'To store data', 'To display data', 'a'),
    ('Computer Systems', 'Level 2', 'What does the term \"booting\" refer to in computer systems?', 'Shutting down the computer', 'Starting up the computer', 'Installing software', 'Running an application', 'b'),
    ('Computer Systems', 'Level 2', 'Which of the following is an example of system software?', 'Microsoft Word', 'Adobe Photoshop', 'Windows 10', 'Google Chrome', 'c'),

    -- Computer Security questions
    ('Computer Security', 'Level 2', 'Which of the following is a type of malware?', 'Firewall', 'Antivirus', 'Trojan', 'VPN', 'c'),
    ('Computer Security', 'Level 2', 'What does the acronym CIA stand for in cyber security?', 'Central Intelligence Agency', 'Confidentiality, Integrity, Availability', 'Cyber Intelligence Agency', 'Confidentiality, Information, Access', 'b'),
    ('Computer Security', 'Level 2', 'What is phishing?', 'A type of encryption', 'A method of hacking passwords', 'A technique to obtain sensitive information by disguising as a trustworthy entity', 'A type of firewall', 'c'),
    ('Computer Security', 'Level 2', 'Which of the following is used to detect and prevent unauthorized access to a network?', 'Router', 'Switch', 'Intrusion Detection System (IDS)', 'Hub', 'c'),
    ('Computer Security', 'Level 2', 'What is the primary purpose of a firewall?', 'To scan for viruses', 'To encrypt data', 'To monitor and control incoming and outgoing network traffic', 'To backup data', 'c'),
    ('Computer Security', 'Level 2', 'Which of the following is an example of a strong password?', 'password123', 'qwerty', 'Abc123', '9f3!@#', 'd'),
    ('Computer Security', 'Level 2', 'What is a Denial of Service (DoS) attack?', 'An attempt to steal data', 'An attempt to block access to a network resource', 'An attempt to encrypt data', 'An attempt to gain unauthorized access to a system', 'b'),
    ('Computer Security', 'Level 2', 'Which of the following is a common method of two-factor authentication?', 'Password and username', 'Password and email', 'Password and OTP (One-Time Password)', 'Password and security question', 'c'),
    ('Computer Security', 'Level 2', 'What is encryption?', 'The process of compressing data', 'The process of converting data into a code to prevent unauthorized access', 'The process of backing up data', 'The process of deleting data', 'b'),
    ('Computer Security', 'Level 2', 'Which of the following best describes a zero-day vulnerability?', 'A vulnerability that has been patched', 'A vulnerability that is widely known', 'A vulnerability that is unknown to the software vendor and has no patch yet', 'A vulnerability that only affects old systems', 'c'),

    -- System Design and Project Management questions
    ('System Design and Project Management', 'Level 2', 'Which of the following is the first phase in the System Development Life Cycle (SDLC)?', 'Design', 'Implementation', 'Planning', 'Testing', 'c'),
    ('System Design and Project Management', 'Level 2', 'Which of the following methodologies is known for iterative development and flexibility?', 'Waterfall', 'Agile', 'V-Model', 'Spiral', 'b'),
    ('System Design and Project Management', 'Level 2', 'In project management, what does the term \"scope creep\" refer to?', 'A project ahead of schedule', 'A project under budget', 'Uncontrolled changes in project scope', 'Lack of resources', 'c'),
    ('System Design and Project Management', 'Level 2', 'Which of the following is a tool commonly used for project management?', 'SQL', 'Git', 'Gantt Chart', 'HTML', 'c'),
    ('System Design and Project Management', 'Level 2', 'What is the primary goal of a feasibility study in system design?', 'To design the system architecture', 'To implement the system', 'To determine if the project is viable', 'To test the system', 'c'),
    ('System Design and Project Management', 'Level 2', 'What does the acronym PERT stand for in project management?', 'Project Evaluation and Review Technique', 'Project Execution and Reporting Technique', 'Project Estimation and Risk Technique', 'Project Efficiency and Resource Technique', 'a'),
    ('System Design and Project Management', 'Level 2', 'Which of the following is a key component of risk management in project management?', 'Identifying potential risks', 'Ignoring potential risks', 'Minimizing project scope', 'Reducing project budget', 'a'),
    ('System Design and Project Management', 'Level 2', 'In system design, what is the purpose of a use case diagram?', 'To display the system\'s hardware architecture', 'To represent user interactions with the system', 'To illustrate data flow', 'To document coding standards', 'b'),
    ('System Design and Project Management', 'Level 2', 'Which of the following describes a \"critical path\" in project management?', 'The shortest path through a project', 'The longest path through a project with the least amount of slack', 'The path with the most resources', 'The path with the highest costs', 'b'),
    ('System Design and Project Management', 'Level 2', 'What is the purpose of the testing phase in the SDLC?', 'To gather requirements', 'To ensure the system meets specifications and is free of defects', 'To design system architecture', 'To deploy the system', 'b'),

    -- Website Development questions
    ('Website Development', 'Level 3', 'Which of the following languages is primarily used for structuring web pages?', 'JavaScript', 'Python', 'HTML', 'CSS', 'c'),
    ('Website Development', 'Level 3', 'Which HTML tag is used to create a hyperlink?', '<link>', '<a>', '<href>', '<hyper>', 'b'),
    ('Website Development', 'Level 3', 'Which CSS property is used to change the background color?', 'color', 'background-color', 'bgcolor', 'background', 'b'),
    ('Website Development', 'Level 3', 'What does the acronym \"DOM\" stand for?', 'Document Object Model', 'Digital Object Model', 'Document Operation Mode', 'Data Object Model', 'a'),
    ('Website Development', 'Level 3', 'Which of the following is a JavaScript framework for building user interfaces?', 'Laravel', 'Angular', 'Flask', 'Django', 'b'),
    ('Website Development', 'Level 3', 'What is the purpose of the <head> tag in an HTML document?', 'To define the body of the document', 'To specify metadata and links to scripts and stylesheets', 'To display headings', 'To contain the main content of the document', 'b'),
    ('Website Development', 'Level 3', 'Which of the following is used to apply styles to an HTML document?', 'JavaScript', 'SQL', 'CSS', 'PHP', 'c'),
    ('Website Development', 'Level 3', 'What is the purpose of the alt attribute in an <img> tag?', 'To link an image', 'To provide alternative text if the image cannot be displayed', 'To style an image', 'To set the image size', 'b'),
    ('Website Development', 'Level 3', 'Which of the following tags is used to create a table in HTML?', '<div>', '<table>', '<section>', '<article>', 'b'),
    ('Website Development', 'Level 3', 'What is the primary purpose of responsive web design?', 'To improve website speed', 'To make web pages look good on all devices', 'To enhance website security', 'To optimize search engine ranking', 'b'),

    -- Digital Forensics questions
    ('Digital Forensics', 'Level 3', 'What is the primary purpose of digital forensics?', 'To develop new software', 'To investigate and analyze digital devices for evidence', 'To repair computer systems', 'To optimize network performance', 'b'),
    ('Digital Forensics', 'Level 3', 'Which of the following is a common digital forensics tool?', 'Microsoft Word', 'EnCase', 'Adobe Photoshop', 'Notepad++', 'b'),
    ('Digital Forensics', 'Level 3', 'What does the acronym \"FTK\" stand for in digital forensics?', 'Forensic Tool Kit', 'File Transfer Kit', 'Forensic Tracking Kit', 'File Tracking Kit', 'a'),
    ('Digital Forensics', 'Level 3', 'Which of the following is a key step in the digital forensics process?', 'Software development', 'Evidence collection', 'Network configuration', 'System backup', 'b'),
    ('Digital Forensics', 'Level 3', 'What is the purpose of hashing in digital forensics?', 'To compress data', 'To encrypt data', 'To verify data integrity', 'To store data', 'c'),
    ('Digital Forensics', 'Level 3', 'Which of the following is considered volatile data?', 'Hard disk drive data', 'RAM data', 'CD-ROM data', 'USB drive data', 'b'),
    ('Digital Forensics', 'Level 3', 'What is the primary function of a write blocker in digital forensics?', 'To read data faster', 'To prevent any modifications to the evidence', 'To encrypt the data', 'To delete unnecessary files', 'b'),
    ('Digital Forensics', 'Level 3', 'Which file system is commonly used by Windows operating systems?', 'NTFS', 'ext4', 'HFS+', 'FAT32', 'a'),
    ('Digital Forensics', 'Level 3', 'What is steganography?', 'The study of handwriting', 'The practice of hiding data within other files', 'The analysis of network traffic', 'The encryption of data', 'b'),
    ('Digital Forensics', 'Level 3', 'Which of the following is a legal requirement in digital forensics?', 'Data encryption', 'Chain of custody', 'Software licensing', 'Network monitoring', 'b'),

    -- Cryptography questions
    ('Cryptography', 'Level 3', 'What is the primary goal of cryptography?', 'To speed up data transmission', 'To secure communication', 'To store data efficiently', 'To manage databases', 'b'),
    ('Cryptography', 'Level 3', 'Which of the following is a symmetric encryption algorithm?', 'RSA', 'AES', 'DSA', 'ECC', 'b'),
    ('Cryptography', 'Level 3', 'What does the acronym \"RSA\" stand for?', 'Rivest-Shamir-Adleman', 'Random Secure Algorithm', 'Reliable Secure Algorithm', 'Rivest-Secure-Adleman', 'a'),
    ('Cryptography', 'Level 3', 'Which cryptographic method uses two different keys, one for encryption and one for decryption?', 'Symmetric encryption', 'Asymmetric encryption', 'Hashing', 'Steganography', 'b'),
    ('Cryptography', 'Level 3', 'What is the primary purpose of a hash function?', 'To encrypt data', 'To compress data', 'To generate a fixed-size output from variable-size input', 'To decode data', 'c'),
    ('Cryptography', 'Level 3', 'Which of the following is a commonly used hashing algorithm?', 'AES', 'RSA', 'SHA-256', 'ECC', 'c'),
    ('Cryptography', 'Level 3', 'What is a digital signature used for?', 'To compress files', 'To verify the authenticity and integrity of a message', 'To encrypt data', 'To create backups', 'b'),
    ('Cryptography', 'Level 3', 'Which of the following is a characteristic of a strong cryptographic key?', 'Predictability', 'Short length', 'High entropy', 'Fixed pattern', 'c'),
    ('Cryptography', 'Level 3', 'What is the purpose of a public key in asymmetric encryption?', 'To decrypt data', 'To encrypt data', 'To hash data', 'To sign data', 'b'),
    ('Cryptography', 'Level 3', 'What does the term \"brute force attack\" refer to in cryptography?', 'Encrypting data multiple times', 'Using trial and error to crack encryption', 'Hashing data repeatedly', 'Hiding data within other files', 'b'),

    -- Machine Learning questions
    ('Machine Learning', 'Level 3', 'What is the primary goal of machine learning?', 'To build hardware components', 'To enable computers to learn from data and make predictions', 'To create user interfaces', 'To manage databases', 'b'),
    ('Machine Learning', 'Level 3', 'Which of the following is a type of supervised learning?', 'Clustering', 'Regression', 'Dimensionality reduction', 'Reinforcement learning', 'b'),
    ('Machine Learning', 'Level 3', 'What is the purpose of a training dataset in machine learning?', 'To test the model', 'To train the model', 'To visualize data', 'To store data', 'b'),
    ('Machine Learning', 'Level 3', 'Which of the following algorithms is used for classification?', 'Linear regression', 'K-nearest neighbors', 'Principal component analysis', 'K-means clustering', 'b'),
    ('Machine Learning', 'Level 3', 'What is overfitting in machine learning?', 'When the model performs well on training data but poorly on test data', 'When the model performs well on test data but poorly on training data', 'When the model performs equally well on both training and test data', 'When the model cannot make any predictions', 'a'),
    ('Machine Learning', 'Level 3', 'What is the purpose of cross-validation in machine learning?', 'To train the model', 'To reduce overfitting', 'To visualize data', 'To collect data', 'b'),
    ('Machine Learning', 'Level 3', 'Which of the following is an example of an unsupervised learning algorithm?', 'Decision tree', 'Linear regression', 'K-means clustering', 'Logistic regression', 'c'),
    ('Machine Learning', 'Level 3', 'What is a neural network composed of?', 'Layers of interconnected nodes', 'Single nodes', 'Sequential instructions', 'Conditional statements', 'a'),
    ('Machine Learning', 'Level 3', 'What is the activation function used for in a neural network?', 'To initialize weights', 'To transform the input signal to an output signal', 'To train the model', 'To evaluate the model', 'b'),
    ('Machine Learning', 'Level 3', 'Which of the following is a performance metric for classification models?', 'Mean squared error', 'Accuracy', 'R-squared', 'Mean absolute error', 'b'),

    -- Simulation questions
    ('Simulation', 'Level 3', 'What is the primary purpose of simulation?', 'To create animations', 'To model and analyze complex systems', 'To store data', 'To build user interfaces', 'b'),
    ('Simulation', 'Level 3', 'Which of the following is a type of simulation?', 'Physical simulation', 'Discrete event simulation', 'Manual simulation', 'Theoretical simulation', 'b'),
    ('Simulation', 'Level 3', 'What is a Monte Carlo simulation used for?', 'To optimize network performance', 'To model the probability of different outcomes in a process', 'To store large datasets', 'To develop software', 'b'),
    ('Simulation', 'Level 3', 'Which of the following is an advantage of simulation?', 'It provides exact solutions', 'It allows experimentation without risk', 'It reduces the need for data', 'It simplifies complex systems', 'b'),
    ('Simulation', 'Level 3', 'What does the term \"state\" refer to in a simulation model?', 'The hardware configuration', 'The current condition or status of the system', 'The user interface design', 'The data storage format', 'b'),
    ('Simulation', 'Level 3', 'Which of the following software is commonly used for simulation?', 'Microsoft Excel', 'MATLAB', 'Adobe Photoshop', 'Notepad++', 'b'),
    ('Simulation', 'Level 3', 'What is the purpose of a random number generator in simulation?', 'To create user interfaces', 'To introduce variability in the simulation', 'To store data', 'To optimize performance', 'b'),
    ('Simulation', 'Level 3', 'What is the output of a simulation model called?', 'Input data', 'Simulation run', 'Simulation result', 'System state', 'c'),
    ('Simulation', 'Level 3', 'Which of the following best describes a deterministic simulation?', 'A simulation where outcomes are random', 'A simulation where outcomes are predictable', 'A simulation where inputs are unknown', 'A simulation where the system is not modeled', 'b'),
    ('Simulation', 'Level 3', 'What is the purpose of sensitivity analysis in simulation?', 'To simplify the model', 'To determine how different values of an input affect the output', 'To visualize the data', 'To train the model', 'b'),

    -- Deep Learning questions
    ('Deep Learning', 'Level 3', 'What is deep learning a subset of?', 'Machine learning', 'Database management', 'Web development', 'Operating systems', 'a'),
    ('Deep Learning', 'Level 3', 'Which of the following is a key component of a deep learning model?', 'Hyperparameters', 'Neurons and layers', 'Databases', 'User interfaces', 'b'),
    ('Deep Learning', 'Level 3', 'What is the primary function of an activation function in a neural network?', 'To initialize weights', 'To introduce non-linearity', 'To collect data', 'To visualize results', 'b'),
    ('Deep Learning', 'Level 3', 'What is a convolutional neural network (CNN) primarily used for?', 'Natural language processing', 'Image and video recognition', 'Time series analysis', 'Data storage', 'b'),
    ('Deep Learning', 'Level 3', 'What is the purpose of backpropagation in training a neural network?', 'To collect training data', 'To adjust weights to minimize the error', 'To initialize the network', 'To create the model architecture', 'b'),
    ('Deep Learning', 'Level 3', 'What is a recurrent neural network (RNN) best suited for?', 'Static image recognition', 'Sequential data analysis', 'Database management', 'Network security', 'b'),
    ('Deep Learning', 'Level 3', 'Which of the following is a common activation function used in deep learning?', 'Polynomial', 'Sigmoid', 'Linear', 'Exponential', 'b'),
    ('Deep Learning', 'Level 3', 'What is the primary challenge addressed by dropout in neural networks?', 'Overfitting', 'Underfitting', 'Data preprocessing', 'Model evaluation', 'a'),
    ('Deep Learning', 'Level 3', 'What does the term \"epoch\" refer to in the context of training neural networks?', 'One complete pass through the training dataset', 'One batch of training data', 'One layer of the network', 'One node of the network', 'a'),
    ('Deep Learning', 'Level 3', 'Which of the following frameworks is commonly used for deep learning?', 'Django', 'TensorFlow', 'React', 'Angular', 'b')

    ;";

// Execute the INSERT query
if ($conn->query($insertQuestions) === TRUE) {
} else {
    echo "Error inserting questions: " . $conn->error;
}


// Initialize selected level
$selected_level = 'Level 1';


// Fetch distinct levels from quizzes table for the dropdown
$levels_query = "SELECT DISTINCT level FROM quizzes ORDER BY level ASC";
$levels_result = $conn->query($levels_query);

if (!$levels_result) {
    die("Error fetching levels: " . $conn->error);
}

// Fetch courses based on selected level using prepared statements
$stmt = $conn->prepare("SELECT DISTINCT subject FROM quizzes WHERE level = ? ORDER BY subject ASC");
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $selected_level);
$stmt->execute();
$courses_result = $stmt->get_result();

if (!$courses_result) {
    die("Error fetching courses: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select an Exam</title>
    <link rel="stylesheet" href="styles.css">
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard-header {
            background-color: #333;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-header .logo h1 {
            margin: 0;
            font-size: 24px;
        }
        .dashboard-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .dashboard-nav ul li {
            margin-left: 20px;
        }
        .dashboard-nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }
        .user-info {
            font-size: 16px;
        }
        .logout-btn {
            background-color: #ff4d4d;
            border: none;
            padding: 8px 12px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .logout-btn:hover {
            background-color: #ff1a1a;
        }
        .exam-container {
            text-align: center;
            padding: 50px 20px;
        }
        .exam-container h1 {
            margin-bottom: 30px;
            font-size: 32px;
            color: #333;
        }
        .level-selection {
            margin-bottom: 30px;
        }
        .level-selection form {
            display: inline-block;
        }
        .level-selection select {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
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
            min-width: 220px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
        /* Responsive Design */
        @media (max-width: 600px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .dashboard-nav ul {
                flex-direction: column;
                align-items: flex-start;
            }
            .dashboard-nav ul li {
                margin-left: 0;
                margin-top: 10px;
            }
            .exam-buttons {
                flex-direction: column;
                align-items: center;
            }
            .btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

<header class="dashboard-header">
    <div class="logo">
        <h1>MasteryLevels</h1>
    </div>
    <nav class="dashboard-nav">
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="exams.php">Exams</a></li>
            <li><a href="progress.php">Progress</a></li>
        </ul>
    </nav>
    <div class="user-info">
        <span>Hi, <?php echo htmlspecialchars($user); ?></span>
        <form method="POST" style="display: inline;">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>
</header>

<div class="exam-container">
    <h1>Select a Level 1 Exam</h1>
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