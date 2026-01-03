<?php
// api/get_orders.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include '../includes/db.php';

$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
$orders = [];

while ($row = $result->fetch_assoc()) {
    // Ideally fetch item count here too, but for simplicity returning order headers
    $orders[] = $row;
}

echo json_encode($orders);

$conn->close();
?>
