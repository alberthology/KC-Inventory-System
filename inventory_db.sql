-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 21, 2024 at 09:10 AM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand_table`
--

DROP TABLE IF EXISTS `brand_table`;
CREATE TABLE IF NOT EXISTS `brand_table` (
  `brand_id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(100) NOT NULL,
  `category_id` int DEFAULT NULL,
  `description` text,
  `country_of_origin` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`brand_id`),
  KEY `fk_product_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `brand_table`
--

INSERT INTO `brand_table` (`brand_id`, `brand_name`, `category_id`, `description`, `country_of_origin`) VALUES
(1, 'Nike', 3, 'A leading global brand known for its sportswear, footwear, and athletic equipment.', 'USA'),
(2, 'Adidas', 15, 'A multinational corporation that designs and manufactures sports shoes, clothing, and accessories.', 'Germany'),
(3, 'Apple', 4, 'An American multinational technology company that designs and manufactures consumer electronics.', 'USA'),
(4, 'Samsung', 4, 'A South Korean multinational conglomerate known for its electronics, including smartphones and TVs.', 'South Korea'),
(5, 'Levi\'s', 3, 'Famous for its denim jeans and other apparel, Levi\'s is a global leader in casual wear.', 'USA'),
(6, 'Wrangler', 3, 'A brand known for its denim jeans and casual wear, popular in the Western fashion segment.', 'USA'),
(7, 'Canon', 4, 'A Japanese multinational specializing in imaging and optical products, including cameras and printers.', 'Japan'),
(8, 'Nikon', 4, 'A Japanese multinational corporation that specializes in optics and imaging products.', 'Japan'),
(9, 'L\'Oréal', 10, 'A global cosmetics and beauty company, one of the largest in the world.', 'France'),
(10, 'Estée Lauder', 10, 'A leading American manufacturer and marketer of prestige skincare, makeup, and fragrance products.', 'USA'),
(11, 'Bosch', 16, 'A global engineering and technology company, Bosch is a leader in power tools and home appliances.', 'Germany'),
(12, 'DeWalt', 16, 'Known for high-quality power tools and equipment used by construction professionals.', 'USA'),
(13, 'Panasonic', 13, ' Japanese multinational electronics company', 'Japan');

-- --------------------------------------------------------

--
-- Table structure for table `category_table`
--

DROP TABLE IF EXISTS `category_table`;
CREATE TABLE IF NOT EXISTS `category_table` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`category_id`, `category_name`, `description`) VALUES
(3, 'Apparel', 'Apparel'),
(4, 'Electronics', 'Electronics'),
(5, 'Furniture', 'Furniture'),
(6, 'Food & Beverages', 'Food & Beverages'),
(7, 'Beauty & Personal Care', 'Beauty & Personal Care'),
(8, 'Books', 'Books'),
(9, 'Automotive', 'Automotive'),
(10, 'Health & Wellness', 'Health & Wellness'),
(11, 'Stationery', 'Stationery'),
(12, 'Toys & Games', 'Toys & Games'),
(13, 'Appliances', 'Appliances'),
(15, 'Sports Equipment', 'Sports Equipment'),
(16, 'Hardware & Tools', 'Hardware & Tools'),
(17, 'Pet Supplies', 'Pet Supplies'),
(18, 'Wearable Accessories', 'Different Accessories that adds fashion and style');

-- --------------------------------------------------------

--
-- Table structure for table `customer_table`
--

DROP TABLE IF EXISTS `customer_table`;
CREATE TABLE IF NOT EXISTS `customer_table` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_table`
--

INSERT INTO `customer_table` (`customer_id`, `customer_name`, `contact_number`, `email`, `address`) VALUES
(20, 'Roy', '12346578912', NULL, NULL),
(21, 'Chan', '12345678901', NULL, NULL),
(22, 'Jd', '12345678902', NULL, NULL),
(23, 'Jd', '12345678902', NULL, NULL),
(24, 'Yawa', '12345678i0', NULL, NULL),
(25, 'Joe', '2345678909', NULL, NULL),
(26, 'Janjan', '12345678909', NULL, NULL),
(27, 'Loyloy', '12345678909', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transaction_table`
--

DROP TABLE IF EXISTS `inventory_transaction_table`;
CREATE TABLE IF NOT EXISTS `inventory_transaction_table` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `transaction_type` enum('purchase','sale','return') DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `transaction_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item_table`
--

DROP TABLE IF EXISTS `order_item_table`;
CREATE TABLE IF NOT EXISTS `order_item_table` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_item_table`
--

INSERT INTO `order_item_table` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `payment`) VALUES
(23, 20, 7, 2, 59.99, 119.98, 119.98),
(24, 21, 6, 1, 899.99, 899.99, 500.00),
(25, 21, 3, 2, 129.99, 259.98, 259.98),
(26, 22, 8, 1, 49.99, 49.99, 30.00),
(27, 23, 6, 1, 899.99, 899.99, 200.00),
(28, 23, 8, 1, 49.99, 49.99, 20.00),
(29, 24, 6, 1, 899.99, 899.99, 200.00),
(30, 25, 21, 1, 20000.00, 20000.00, 10000.00),
(31, 25, 7, 2, 59.99, 119.98, 119.98),
(32, 26, 24, 1, 200.00, 200.00, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

DROP TABLE IF EXISTS `order_table`;
CREATE TABLE IF NOT EXISTS `order_table` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`order_id`, `customer_id`, `order_date`, `total_amount`, `status`) VALUES
(20, 20, '2024-11-19 19:12:48', 119.98, 'completed'),
(21, 21, '2024-11-19 19:13:39', 1159.97, ''),
(22, 23, '2024-11-19 19:51:55', 49.99, ''),
(23, 24, '2024-11-19 19:52:55', 949.98, ''),
(24, 25, '2024-11-21 09:36:10', 899.99, ''),
(25, 26, '2024-11-21 09:50:44', 20119.98, ''),
(26, 27, '2024-11-21 12:05:40', 200.00, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `product_table`
--

DROP TABLE IF EXISTS `product_table`;
CREATE TABLE IF NOT EXISTS `product_table` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(150) NOT NULL,
  `product_size` varchar(50) DEFAULT NULL,
  `product_color` varchar(100) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `description` text,
  `quantity_in_stock` int DEFAULT '0',
  `price` decimal(10,2) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `fk_product_brand` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_table`
--

INSERT INTO `product_table` (`product_id`, `product_name`, `product_size`, `product_color`, `category_id`, `description`, `quantity_in_stock`, `price`, `supplier_id`, `brand_id`) VALUES
(3, 'Air Max 270', 'Medium', 'White', 15, 'A stylish, comfortable running shoe with air cushioning.', 50, 129.99, NULL, 1),
(4, 'Ultraboost', 'Large', 'Red', 15, 'Premium running shoe with Boost technology for comfort.', 30, 179.99, NULL, 2),
(6, 'Galaxy S24', 'Default', 'Black', 4, 'Powerful smartphone with AMOLED display and 5G support.', 75, 899.99, NULL, 4),
(7, '501 Jeans', 'Medium', 'Denim', 3, 'Classic straight-leg jeans made from premium denim.', 200, 59.99, NULL, 5),
(8, 'Wrangler Bootcut', 'Small', 'Blue', 3, 'Bootcut jeans, perfect for casual and work settings.', 150, 49.99, NULL, 6),
(9, 'Canon EOS 90D', 'Default', 'Black', 4, 'High-performance DSLR camera with 32.5 MP sensor.', 20, 1199.99, NULL, 7),
(10, 'Nikon D7500', 'Default', 'Black', 4, 'DSLR camera with 4K video recording and fast autofocus.', 25, 899.99, NULL, 8),
(11, 'L\'Oréal Revitalift', 'Default', 'Default', 10, 'Anti-aging cream that smoothes and firms the skin.', 100, 29.99, NULL, 9),
(12, 'Estée Lauder Advanced Night Repair', 'Default', 'Default', 10, 'Overnight serum that reduces the look of wrinkles.', 80, 89.99, NULL, 10),
(13, 'Bosch Drill Set', 'Default', 'Black', 16, 'Compact power drill with multiple bits for various tasks.', 40, 99.99, NULL, 11),
(14, 'DeWalt Cordless Drill', 'Default', 'Yellow', 16, 'Durable cordless drill with high torque for heavy-duty tasks.', 60, 149.99, NULL, 12),
(20, 'iPhone 11', 'Default', 'White', 4, 'Sample data', 6, 17000.00, NULL, 3),
(21, 'iPhone 15', 'Default', 'White', 4, 'Sample data 2', 6, 20000.00, NULL, 3),
(24, 'Air Max 270', 'Small', 'Black', 3, NULL, 20, 200.00, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item_table`
--

DROP TABLE IF EXISTS `purchase_item_table`;
CREATE TABLE IF NOT EXISTS `purchase_item_table` (
  `purchase_item_id` int NOT NULL AUTO_INCREMENT,
  `purchase_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`purchase_item_id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_table`
--

DROP TABLE IF EXISTS `purchase_table`;
CREATE TABLE IF NOT EXISTS `purchase_table` (
  `purchase_id` int NOT NULL AUTO_INCREMENT,
  `supplier_id` int DEFAULT NULL,
  `purchase_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('completed','pending','cancelled') DEFAULT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment_table`
--

DROP TABLE IF EXISTS `stock_adjustment_table`;
CREATE TABLE IF NOT EXISTS `stock_adjustment_table` (
  `adjustment_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `adjustment_type` enum('increase','decrease') NOT NULL,
  `quantity` int NOT NULL,
  `adjustment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `reason` text,
  PRIMARY KEY (`adjustment_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_table`
--

DROP TABLE IF EXISTS `supplier_table`;
CREATE TABLE IF NOT EXISTS `supplier_table` (
  `supplier_id` int NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(100) NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

DROP TABLE IF EXISTS `user_table`;
CREATE TABLE IF NOT EXISTS `user_table` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','warehouse_manager','sales','cashier') DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brand_table`
--
ALTER TABLE `brand_table`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category_table` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_transaction_table`
--
ALTER TABLE `inventory_transaction_table`
  ADD CONSTRAINT `inventory_transaction_table_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_transaction_table_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item_table`
--
ALTER TABLE `order_item_table`
  ADD CONSTRAINT `order_item_table_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_table` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_table_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `order_table`
--
ALTER TABLE `order_table`
  ADD CONSTRAINT `order_table_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_table` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_table`
--
ALTER TABLE `product_table`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brand_table` (`brand_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `product_table_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_table` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_table_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_table` (`supplier_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `purchase_item_table`
--
ALTER TABLE `purchase_item_table`
  ADD CONSTRAINT `purchase_item_table_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase_table` (`purchase_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_item_table_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `purchase_table`
--
ALTER TABLE `purchase_table`
  ADD CONSTRAINT `purchase_table_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_table` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_adjustment_table`
--
ALTER TABLE `stock_adjustment_table`
  ADD CONSTRAINT `stock_adjustment_table_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
