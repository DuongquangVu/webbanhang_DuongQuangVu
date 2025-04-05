-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for my_store
CREATE DATABASE IF NOT EXISTS `my_store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `my_store`;

-- Dumping structure for table my_store.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.account: ~2 rows (approximately)
INSERT INTO `account` (`id`, `username`, `fullname`, `password`, `role`) VALUES
	(1, 'admin1', 'Dương Quang Vũ', '$2y$12$QXLqcC0zRLXMtIJhUFRf1e/UxNtIwqAwU7HluPThf.BH/7b49hP2e', 'admin'),
	(2, 'Vũ', 'quang vũ', '$2y$12$I39NqCvuiKeJhpAGv80Qme7z4S7HH30AKY7l4ybWeCbIJywj0MA2C', 'user');

-- Dumping structure for table my_store.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.category: ~5 rows (approximately)
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(1, 'Điện thoại', 'Danh mục các loại điện thoại'),
	(2, 'Laptop', 'Danh mục các loại laptop'),
	(3, 'Máy tính bảng', 'Danh mục các loại máy tính bảng'),
	(4, 'Phụ kiện', 'Danh mục phụ kiện điện tử'),
	(5, 'Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro');

-- Dumping structure for table my_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.orders: ~3 rows (approximately)
INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
	(3, 'vu', '777777', 'thu duc\r\n', '2025-03-10 06:33:37'),
	(4, 'vu', '1223', 'vin', '2025-03-24 07:32:59'),
	(5, 'vu', '1223', 'vin', '2025-03-24 07:34:11');

-- Dumping structure for table my_store.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.order_details: ~0 rows (approximately)
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
	(4, 3, 23, 2, 1.00),
	(5, 4, 24, 1, 19000.00),
	(6, 5, 29, 1, 150.00);

-- Dumping structure for table my_store.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.product: ~8 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
	(24, 'iPhone 15', '256GB', 19000.00, 'uploads/iphone-15-pink-2-638629454255353553-750x500.jpg', 1),
	(25, 'iPhone 13 Pro Max', '128GB', 15000.00, 'uploads/iphone13-pro-max-xanh-la-1-750x500.jpg', 1),
	(26, 'Laptop Dell Inspiron 15 3520', 'i5 1235U/16GB/512GB/120Hz/OfficeHS/Win11', 15000.00, 'uploads/dell-inspiron-15-3520-i5-n5i5057w1-12-638724479300370789-750x500.jpg', 2),
	(27, 'Tai nghe Bluetooth AirPods 2', ' Lightning Charge Apple MV7N2', 2790.00, 'uploads/bluetooth-airpods-2-apple-mv7n2-imei-1-750x500.jpg', 5),
	(28, 'Máy chơi game cầm tay MSI Claw A1M-049VN', 'Core Ultra 7 155H/16GB/512GB/120Hz/Win11', 11990.00, 'uploads/msi-claw-a1m-049vn-core-ultra-7-den-8-638687323776791617-750x500.jpg', 3),
	(29, 'Pin sạc dự phòng Polymer ', '10000mAh 12W AVA+ JP299', 150.00, 'uploads/pin-sac-du-phong-polymer-10000mah-ava-jp299-trang-2-750x500.jpg', 3),
	(30, 'Điện thoại Samsung Galaxy Z Flip6 5G', '12GB/256GB', 18500.00, 'uploads/samsung-galaxy-z-flip6-blue-1-1-750x500.jpg', 1),
	(31, 'Máy tính bảng iPad 10', ' 256GB', 13590.00, 'uploads/ipad-10-bbh-org.jpg', 3),
	(32, 'Laptop Hutech', 'A high-performance laptop', 1999.99, NULL, 1),
	(33, 'Laptop Hutech', 'A high-performance laptop', 1999.99, NULL, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
