<?php
// api/add_product.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $name = $data['name'];
    $category = $data['category'];
    $price = $data['price'];
    $image = $data['image'];
    $rating = isset($data['rating']) ? $data['rating'] : 4.5;
    $featured = isset($data['featured']) ? $data['featured'] : 0;
    $description = isset($data['description']) ? $data['description'] : '';

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, image, rating, featured, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsdis", $name, $category, $price, $image, $rating, $featured, $description);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Product Added"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add product"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Data"]);
}

$conn->close();
?>
