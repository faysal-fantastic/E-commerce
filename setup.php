<?php
// setup.php

$host = "localhost";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Database
$sql = "CREATE DATABASE IF NOT EXISTS fowzi_store";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->select_db("fowzi_store");

// Create Users Table
$sql = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
)";
$conn->query($sql);

// Insert Admin
$sql = "INSERT IGNORE INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123')";
$conn->query($sql);

// Create Products Table
$sql = "CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `rating` decimal(2,1) DEFAULT 4.5,
  `featured` tinyint(1) DEFAULT 0,
  `description` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)";
$conn->query($sql);

// Insert default products if empty
$result = $conn->query("SELECT count(*) as count FROM products");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    $products = [
        "('Apple Smart Watch Series 7', 'electronics', 399.99, 450.00, 'images/apple.jpg', 4.5, 1, 'Description here')",
        "('Running Sports Shoes', 'fashion', 89.99, 120.00, 'images/shoes.jpg', 4.2, 1, 'Description here')",
        "('Canon DSLR Camera', 'electronics', 850.00, 999.00, 'images/canon.jpg', 4.8, 1, 'Description here')",
        "('Classic Analog Watch', 'fashion', 150.00, 199.99, 'images/gen.jpg', 4.0, 1, 'Description here')"
    ];
    foreach($products as $p) {
        $conn->query("INSERT INTO products (name, category, price, old_price, image, rating, featured, description) VALUES $p");
    }
    echo "Inserted default products.<br>";
}

// Create Orders Table
$sql = "CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `order_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)";
$conn->query($sql);

// Create Order Items Table
$sql = "CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
)";
$conn->query($sql);

echo "<h1>✅ Setup Complete! Tables created.</h1>";
echo "<a href='index.html'>Go to Homepage</a>";

$conn->close();
?>
