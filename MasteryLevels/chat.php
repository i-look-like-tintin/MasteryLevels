<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}
// Load .env file
$env = parse_ini_file(__DIR__ . '/key.env');

if (!$env || !isset($env["OPENAI_API_KEY"])) {
    echo json_encode(["error" => "API key not found in .env"]);
    exit;
}

$api_key = $env["OPENAI_API_KEY"];

if (!$api_key) {
    echo json_encode(["error" => "API key not found."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$user_message = $data["message"] ?? "";

if (!$user_message) {
    echo json_encode(["error" => "Empty message received."]);
    exit;
}

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $api_key
]);

$request_data = json_encode([
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => $user_message]
    ]
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$response_data = json_decode($response, true);

if ($http_code !== 200 || !isset($response_data["choices"][0]["message"]["content"])) {
    echo json_encode(["error" => "API request failed", "http_code" => $http_code, "response" => $response_data]);
    exit;
}

// ✅ Correctly return the assistant's response
$chatbot_reply = $response_data["choices"][0]["message"]["content"];
echo json_encode(["reply" => $chatbot_reply]);
?>


