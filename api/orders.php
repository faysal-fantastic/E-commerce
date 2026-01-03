<?php
// api/orders.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $name = $data['customer_name'];
    $email = $data['customer_email'];
    $phone = $data['customer_phone'];
    $address = $data['address'];
    $total = $data['total_amount'];
    $payment = $data['payment_method'];
    $items = $data['items'];

    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, address, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $name, $email, $phone, $address, $total, $payment);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert Order Items
        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($items as $item) {
            $item_stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
            $item_stmt->execute();
        }

        echo json_encode(["status" => "success", "message" => "Order placement successful", "order_id" => $order_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Order placement failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Data"]);
}

$conn->close();
?>
