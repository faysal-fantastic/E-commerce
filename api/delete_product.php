<?php
// api/delete_product.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data && isset($data['id'])) {
    $id = intval($data['id']);

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Product Deleted"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete product"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Data"]);
}

$conn->close();
?>
