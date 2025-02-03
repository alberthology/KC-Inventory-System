-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 02, 2025 at 03:50 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transaction_table`
--

DROP TABLE IF EXISTS `inventory_transaction_table`;
CREATE TABLE IF NOT EXISTS `inventory_transaction_table` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `transaction_type` enum('Purchase','Sale','Return') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `transaction_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

DROP TABLE IF EXISTS `user_table`;
CREATE TABLE IF NOT EXISTS `user_table` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
