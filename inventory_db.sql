-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 06, 2025 at 09:08 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `brand_table`
--

INSERT INTO `brand_table` (`brand_id`, `brand_name`, `category_id`, `description`, `country_of_origin`) VALUES
(39, 'BRAND 1-1', 32, '', ''),
(40, 'BRAND X', 33, '', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`category_id`, `category_name`, `description`) VALUES
(32, 'CATEGORY 1', NULL),
(33, 'CATEGORY X', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_table`
--

INSERT INTO `customer_table` (`customer_id`, `customer_name`, `contact_number`, `email`, `address`) VALUES
(67, 'Joshua Abelgas', '091237894503', NULL, NULL),
(68, 'Denver Smith', '12442134213', NULL, NULL),
(69, 'Freda Sundemo', '09161352790', NULL, NULL),
(70, 'Dawid Podsiadto', '09335267381', NULL, NULL),
(71, 'Kenia OS', '0912890241', NULL, NULL),
(72, 'MKTO', '123213123123', NULL, NULL),
(73, 'Benson Boone', '2451412', NULL, NULL),
(74, 'Jake Miller', '1244512412', NULL, NULL),
(75, 'Illenium', '12904781209', NULL, NULL),
(76, 'Hayley Williams', '214214213', NULL, NULL),
(77, 'Major Lazer', '2152134123', NULL, NULL),
(78, 'Jayde', '12345678912', NULL, NULL),
(79, 'Bowjaaey', '654643218', NULL, NULL),
(80, 'Janjan', '2313213', NULL, NULL),
(81, 'Troy Sivan', '1324654654', NULL, NULL),
(82, 'Jonathan Doe', '2313213', NULL, NULL),
(83, 'Ed Sheeran', '456455231', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transaction_table`
--

DROP TABLE IF EXISTS `inventory_transaction_table`;
CREATE TABLE IF NOT EXISTS `inventory_transaction_table` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `transaction_type` enum('Purchase','Sale','Return') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `transaction_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory_transaction_table`
--

INSERT INTO `inventory_transaction_table` (`transaction_id`, `product_id`, `user_id`, `transaction_type`, `quantity`, `transaction_date`, `transaction_amount`) VALUES
(39, 46, 1, 'Purchase', 15, '2025-01-03 09:00:44', 120.00),
(42, 49, 4, 'Purchase', 15, '2025-01-03 09:06:57', 300.00),
(43, 46, 1, 'Sale', 2, '2025-01-03 09:09:25', 16.00),
(44, 49, 6, 'Sale', 1, '2025-01-03 09:13:01', 20.00),
(45, 50, 4, 'Purchase', 6, '2025-01-04 09:40:35', 1200.00),
(46, 50, 4, 'Sale', 2, '2025-01-04 09:42:42', 400.00),
(47, 50, 1, 'Purchase', 2, '2025-01-04 09:43:39', 400.00),
(48, 50, 4, 'Sale', 1, '2025-01-04 09:45:19', 200.00),
(49, 50, 4, 'Sale', 1, '2025-01-13 22:29:41', 200.00),
(50, 46, 4, 'Sale', 1, '2025-01-13 23:30:32', 8.00),
(51, 50, 1, 'Purchase', 1, '2025-01-13 23:31:52', 200.00),
(52, 46, 1, 'Sale', 1, '2025-01-14 15:54:07', 8.00),
(53, 49, 1, 'Sale', 1, '2025-01-14 16:22:58', 20.00),
(54, 46, 1, 'Sale', 1, '2025-01-14 16:28:12', 8.00),
(55, 50, 1, 'Sale', 1, '2025-01-14 16:47:35', 200.00),
(56, 46, 1, 'Sale', 1, '2025-01-14 16:55:01', 8.00),
(57, 50, 1, 'Purchase', 4, '2025-02-06 14:58:56', 800.00),
(58, 49, 4, 'Sale', 2, '2025-02-06 15:00:58', 40.00),
(59, 50, 4, 'Sale', 2, '2025-02-06 15:17:12', 400.00),
(60, 46, 4, 'Sale', 4, '2025-02-06 16:17:55', 32.00),
(61, 50, 4, 'Sale', 6, '2025-02-06 16:44:48', 1200.00),
(62, 50, 1, 'Purchase', 11, '2025-02-06 16:45:05', 2200.00),
(63, 50, 4, 'Sale', 4, '2025-02-06 16:49:05', 800.00),
(64, 50, 4, 'Sale', 3, '2025-02-06 16:58:12', 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_item_table`
--

DROP TABLE IF EXISTS `order_item_table`;
CREATE TABLE IF NOT EXISTS `order_item_table` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_item_table`
--

INSERT INTO `order_item_table` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `payment`) VALUES
(69, 63, 46, 2, 8.00, 16.00, 16.00),
(70, 64, 49, 1, 20.00, 20.00, 20.00),
(71, 65, 50, 2, 200.00, 400.00, 400.00),
(72, 66, 50, 1, 200.00, 200.00, 200.00),
(73, 67, 50, 1, 200.00, 200.00, 100.00),
(74, 68, 46, 1, 8.00, 8.00, 8.00),
(75, 69, 46, 1, 8.00, 8.00, 8.00),
(76, 70, 49, 1, 20.00, 20.00, 20.00),
(77, 71, 46, 1, 8.00, 8.00, 8.00),
(78, 72, 50, 1, 200.00, 200.00, 200.00),
(79, 73, 46, 1, 8.00, 8.00, 8.00),
(80, 74, 49, 2, 20.00, 40.00, 40.00),
(81, 75, 50, 2, 200.00, 400.00, 120.00),
(82, 76, 46, 4, 8.00, 32.00, 32.00),
(83, 77, 50, 6, 200.00, 1200.00, 1200.00),
(84, 78, 50, 4, 200.00, 800.00, 500.00),
(85, 79, 50, 3, 200.00, 600.00, 20.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`order_id`, `customer_id`, `order_date`, `total_amount`, `status`) VALUES
(63, 67, '2025-01-03 09:09:25', 16.00, 'Completed'),
(64, 68, '2025-01-03 09:13:01', 20.00, 'Completed'),
(65, 69, '2025-01-04 09:42:42', 400.00, 'Completed'),
(66, 70, '2025-01-04 09:45:19', 200.00, 'Completed'),
(67, 71, '2025-01-13 22:29:41', 200.00, 'Ongoing'),
(68, 72, '2025-01-13 23:30:32', 8.00, 'Completed'),
(69, 73, '2025-01-14 15:54:07', 8.00, 'Completed'),
(70, 74, '2025-01-14 16:22:58', 20.00, 'Completed'),
(71, 75, '2025-01-14 16:28:12', 8.00, 'Completed'),
(72, 76, '2025-01-14 16:47:35', 200.00, 'Completed'),
(73, 77, '2025-01-14 16:55:01', 8.00, 'Completed'),
(74, 78, '2025-02-06 15:00:58', 40.00, 'Completed'),
(75, 79, '2025-02-06 15:17:12', 400.00, 'Ongoing'),
(76, 80, '2025-02-06 16:17:55', 32.00, 'Completed'),
(77, 81, '2025-02-06 16:44:48', 1200.00, 'Completed'),
(78, 82, '2025-02-06 16:49:05', 800.00, 'Ongoing'),
(79, 83, '2025-02-06 16:58:12', 600.00, 'Ongoing');

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_table`
--

INSERT INTO `product_table` (`product_id`, `product_name`, `product_size`, `product_color`, `category_id`, `description`, `quantity_in_stock`, `price`, `supplier_id`, `brand_id`) VALUES
(46, 'PRODUCT A1', 'DEFUALT', 'DEFUALT', 32, '', 5, 8.00, NULL, 39),
(49, 'PRODUCT A2', 'DEFAULT', 'DEFAULT', 32, '', 11, 20.00, NULL, 39),
(50, 'PRODUCT X', 'DEFAULT', 'DEFAULT', 33, '', 4, 200.00, NULL, 40);

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
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `password`, `role`, `full_name`, `email`, `created_at`) VALUES
(1, 'admin', '$2y$10$oxptj6EMjbb9VmlqulYe6.m58t452caS0RbEBi.u.VxD2S2FBjzg2', 'Admin', 'administrator', 'admin@gmail.com', '2024-12-15 17:48:50'),
(4, 'itdev1', '$2y$10$wQEZ1bgJmaMKqo2vqzYjL.jXY8A1GJl9u.D/4OxulA0m8APauvzoW', 'Developer', 'Roy Albert L. Bug-os', 'royalbertb@gmail.com', '2025-01-02 23:29:04'),
(5, 'Mark01', '$2y$10$VFaUedl3lCuajUUqdid6L.YoqKlA.rNQ8Wr/19VcUFiUEedHZ73y6', 'Admin', 'Mark Anton Señeres', 'seneres@gmail.com', '2025-01-02 23:44:35'),
(6, 'KCIS', '$2y$10$kAnYhbo1rSEOr/HJ0J5UA.ubVt4XbxUCbq2/tF.fZrgFYz6yNRXLG', 'Manager', 'KC Inventory System', 'inventorysystem.business@gmail.com', '2025-01-02 23:45:08');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brand_table`
--
ALTER TABLE `brand_table`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category_table` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inventory_transaction_table`
--
ALTER TABLE `inventory_transaction_table`
  ADD CONSTRAINT `inventory_transaction_table_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_transaction_table_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_item_table`
--
ALTER TABLE `order_item_table`
  ADD CONSTRAINT `order_item_table_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_table` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_table_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `product_table_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_table` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `product_table_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_table` (`supplier_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `purchase_item_table`
--
ALTER TABLE `purchase_item_table`
  ADD CONSTRAINT `purchase_item_table_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase_table` (`purchase_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_item_table_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_table` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_table`
--
ALTER TABLE `purchase_table`
  ADD CONSTRAINT `purchase_table_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_table` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
