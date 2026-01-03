-- Database: fowzi_store

-- Users Table (Admin)
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Default Admin (password: admin123)
-- In a real app, use password_hash(). For this demo, we use simple text matching or md5 in the PHP.
INSERT INTO `users` (`username`, `password`) VALUES
('admin', 'admin123');

-- Products Table
CREATE TABLE IF NOT EXISTS `products` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Initial Products
INSERT INTO `products` (`name`, `category`, `price`, `old_price`, `image`, `rating`, `featured`, `description`) VALUES
('Apple Smart Watch Series 7', 'electronics', 399.99, 450.00, 'images/apple.jpg', 4.5, 1, 'The latest Apple Watch with larger display and faster charging.'),
('Running Sports Shoes', 'fashion', 89.99, 120.00, 'images/shoes.jpg', 4.2, 1, 'Comfortable and stylish running shoes for daily workouts.'),
('Canon DSLR Camera', 'electronics', 850.00, 999.00, 'images/canon.jpg', 4.8, 1, 'Professional DSLR camera with high resolution and 4K video.'),
('Classic Analog Watch', 'fashion', 150.00, 199.99, 'images/gen.jpg', 4.0, 1, 'Timeless classic design for every occasion.'),
('Smartphone Pro Max', 'electronics', 999.99, 1099.99, 'images/phone.jpg', 4.7, 0, 'Ultimate performance with the newest processor and camera system.'),
('Digital Camera Compact', 'electronics', 299.99, 350.00, 'images/camera.jpg', 3.9, 0, 'Compact digital camera perfect for travel and vlogging.'),
('Smart Fitness Band', 'electronics', 49.99, 70.00, 'images/smart watch.jpeg', 4.3, 0, 'Track your health and fitness goals with ease.'),
('Men\'s Casual Shirt', 'fashion', 35.00, 50.00, 'images/nng.jpeg', 4.1, 0, 'Stylish casual shirt made from premium cotton.');

-- Orders Table
CREATE TABLE IF NOT EXISTS `orders` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order Items Table
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
