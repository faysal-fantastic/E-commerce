<?php
// api/login.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $username = $data['username'];
    $password = $data['password'];

    // In production, use password_verify with hashed passwords
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Login Successful", "user" => $username]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Credentials"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Data"]);
}

$conn->close();
?>
