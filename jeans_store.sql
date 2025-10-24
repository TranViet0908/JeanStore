-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: jeans_store
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (22,3,1,1,450000.00,'2025-09-08 23:47:43','2025-09-08 23:47:43');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,30,'2025-08-19 00:51:00','2025-08-19 00:51:00'),(2,21,'2025-09-07 19:07:00','2025-09-07 19:07:00'),(3,36,'2025-09-08 23:47:43','2025-09-08 23:47:43'),(4,47,'2025-09-09 00:50:24','2025-09-09 00:50:24');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Jeans Regular Fit','2025-08-11 03:20:24','2025-09-10 03:37:43'),(2,'Jeans Skinny','2025-08-11 03:20:24','2025-09-10 03:37:43'),(3,'Jeans Ripped','2025-08-11 03:20:24','2025-09-10 03:37:43');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_08_11_032736_create_categories_table',0),(2,'2025_08_11_032736_create_order_items_table',0),(3,'2025_08_11_032736_create_orders_table',0),(4,'2025_08_11_032736_create_payments_table',0),(5,'2025_08_11_032736_create_products_table',0),(6,'2025_08_11_032736_create_users_table',0),(7,'2025_08_11_032739_add_foreign_keys_to_order_items_table',0),(8,'2025_08_11_032739_add_foreign_keys_to_orders_table',0),(9,'2025_08_11_032739_add_foreign_keys_to_payments_table',0),(10,'2025_08_11_032739_add_foreign_keys_to_products_table',0);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,1,450000.00),(2,2,2,2,500000.00),(3,3,3,1,520000.00),(4,4,4,2,480000.00),(5,5,5,1,490000.00),(6,6,6,2,470000.00),(7,7,7,1,450000.00),(8,8,8,3,430000.00),(9,9,9,2,440000.00),(10,10,10,1,460000.00),(11,11,11,2,300000.00),(12,12,12,1,470000.00),(13,13,13,1,450000.00),(14,14,14,2,450000.00),(15,15,15,1,480000.00),(16,16,16,2,420000.00),(17,17,17,1,500000.00),(18,18,18,2,490000.00),(19,19,19,1,460000.00),(20,20,20,2,480000.00),(21,28,1,6,450000.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` enum('COD','online') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COD',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,0.00,'pending','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(2,2,0.00,'processing','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(3,3,0.00,'shipped','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(4,4,0.00,'delivered','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(5,5,0.00,'pending','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(6,6,0.00,'pending','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(7,7,0.00,'processing','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(8,8,0.00,'shipped','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(9,9,0.00,'delivered','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(10,10,0.00,'pending','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(11,11,0.00,'pending','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(12,12,0.00,'processing','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(13,13,0.00,'shipped','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(14,14,0.00,'delivered','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(15,15,0.00,'pending','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(16,16,0.00,'processing','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(17,17,0.00,'shipped','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(18,18,0.00,'delivered','COD','2025-08-11 03:20:24','2025-08-25 03:19:26'),(19,19,0.00,'pending','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(20,20,0.00,'processing','online','2025-08-11 03:20:24','2025-08-25 03:19:26'),(21,30,1950000.00,'processing','online','2025-08-24 20:57:56','2025-08-24 20:57:56'),(22,21,3100000.00,'processing','online','2025-09-07 19:07:24','2025-09-07 19:07:24'),(23,21,3180000.00,'pending','COD','2025-09-07 19:08:13','2025-09-08 22:40:23'),(24,21,4220000.00,'pending','COD','2025-09-07 19:40:39','2025-09-07 19:40:39'),(25,21,4220000.00,'pending','COD','2025-09-07 22:38:03','2025-09-07 22:38:03'),(26,21,3250000.00,'pending','online','2025-09-08 20:52:54','2025-09-08 20:52:54'),(27,21,3250000.00,'pending','COD','2025-09-08 20:53:37','2025-09-08 21:44:58'),(28,21,3500000.00,'pending','online','2025-09-08 21:58:03','2025-09-08 22:23:46'),(29,36,450000.00,'pending','COD','2025-09-08 23:47:46','2025-09-08 23:47:46');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('cash','credit_card','bank_transfer','e_wallet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` enum('momo','zalopay','vnpay','stripe') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `provider_txn_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_payload` json DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `idx_provider_txn` (`provider_txn_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,'2025-08-11 03:20:24',450000.00,'cash',NULL,'completed',NULL,NULL,NULL),(2,2,'2025-08-11 03:20:24',950000.00,'credit_card',NULL,'completed',NULL,NULL,NULL),(3,3,'2025-08-11 03:20:24',500000.00,'cash',NULL,'completed',NULL,NULL,NULL),(4,4,'2025-08-11 03:20:24',980000.00,'bank_transfer',NULL,'completed',NULL,NULL,NULL),(5,5,'2025-08-11 03:20:24',450000.00,'cash',NULL,'pending',NULL,NULL,NULL),(6,6,'2025-08-11 03:20:24',900000.00,'credit_card',NULL,'completed',NULL,NULL,NULL),(7,7,'2025-08-11 03:20:24',470000.00,'e_wallet',NULL,'completed',NULL,NULL,NULL),(8,8,'2025-08-11 03:20:24',1000000.00,'bank_transfer',NULL,'completed',NULL,NULL,NULL),(9,9,'2025-08-11 03:20:24',890000.00,'cash',NULL,'completed',NULL,NULL,NULL),(10,10,'2025-08-11 03:20:24',500000.00,'credit_card',NULL,'pending',NULL,NULL,NULL),(11,11,'2025-08-11 03:20:24',940000.00,'cash',NULL,'completed',NULL,NULL,NULL),(12,12,'2025-08-11 03:20:24',460000.00,'e_wallet',NULL,'completed',NULL,NULL,NULL),(13,13,'2025-08-11 03:20:24',500000.00,'bank_transfer',NULL,'completed',NULL,NULL,NULL),(14,14,'2025-08-11 03:20:24',470000.00,'cash',NULL,'completed',NULL,NULL,NULL),(15,15,'2025-08-11 03:20:24',960000.00,'credit_card',NULL,'completed',NULL,NULL,NULL),(16,16,'2025-08-11 03:20:24',500000.00,'e_wallet',NULL,'completed',NULL,NULL,NULL),(17,17,'2025-08-11 03:20:24',900000.00,'bank_transfer',NULL,'completed',NULL,NULL,NULL),(18,18,'2025-08-11 03:20:24',480000.00,'cash',NULL,'completed',NULL,NULL,NULL),(19,19,'2025-08-11 03:20:24',950000.00,'credit_card',NULL,'completed',NULL,NULL,NULL),(20,20,'2025-08-11 03:20:24',500000.00,'e_wallet',NULL,'pending',NULL,NULL,NULL),(21,24,'2025-09-07 19:44:37',4220000.00,'e_wallet','momo','pending',NULL,NULL,NULL),(22,24,'2025-09-07 19:45:57',4220000.00,'e_wallet','momo','pending',NULL,NULL,NULL),(23,24,'2025-09-07 19:48:44',4220000.00,'e_wallet','momo','pending',NULL,NULL,NULL),(24,24,'2025-09-07 19:50:41',4220000.00,'e_wallet','momo','pending',NULL,'{\"amount\": 4220000, \"payUrl\": \"https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT3xQQVktMjQ&s=84d9e76eaa3cd41ade03a11f5ebf28b235fbe118ea3a142e11d81638a99b52d6\", \"message\": \"Thành công.\", \"orderId\": \"PAY-24\", \"deeplink\": \"momo://app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT3xQQVktMjQ&v=3.0\", \"qrCodeUrl\": \"momo://app?action=payWithApp&isScanQR=true&serviceType=qr&sid=TU9NT3xQQVktMjQ&v=3.0\", \"requestId\": \"8bf363f2-f8d1-41d7-ab21-f9fc19227434\", \"resultCode\": 0, \"partnerCode\": \"MOMO\", \"responseTime\": 1757299843147, \"deeplinkMiniApp\": \"momo://app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT3xQQVktMjQ&v=3.0\"}',NULL),(25,24,'2025-09-07 19:51:45',4220000.00,'e_wallet','momo','pending',NULL,'{\"amount\": 4220000, \"payUrl\": \"https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT3xQQVktMjU&s=81f4188f7042e1ffe547ceb620d56812fb30bc3b812c7029eb7b722628847f47\", \"message\": \"Thành công.\", \"orderId\": \"PAY-25\", \"deeplink\": \"momo://app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT3xQQVktMjU&v=3.0\", \"qrCodeUrl\": \"momo://app?action=payWithApp&isScanQR=true&serviceType=qr&sid=TU9NT3xQQVktMjU&v=3.0\", \"requestId\": \"3eca0ae9-b451-4598-b2e4-008cfd7eec5b\", \"resultCode\": 0, \"partnerCode\": \"MOMO\", \"responseTime\": 1757299907836, \"deeplinkMiniApp\": \"momo://app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT3xQQVktMjU&v=3.0\"}',NULL),(26,24,'2025-09-07 19:58:54',4220000.00,'e_wallet','momo','pending',NULL,'{\"amount\": 4220000, \"payUrl\": \"https://test-payment.momo.vn/v2/gateway/pay?t=TU9NT3xQQVktMjY&s=0b18ace29d58e489cef38314ead75e346efd29123f61bb6cc471ecaef649a1ec\", \"message\": \"Thành công.\", \"orderId\": \"PAY-26\", \"deeplink\": \"momo://app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT3xQQVktMjY&v=3.0\", \"qrCodeUrl\": \"momo://app?action=payWithApp&isScanQR=true&serviceType=qr&sid=TU9NT3xQQVktMjY&v=3.0\", \"requestId\": \"0e93095c-39ed-4712-a1ac-22fc4f30b004\", \"resultCode\": 0, \"partnerCode\": \"MOMO\", \"responseTime\": 1757300336210, \"deeplinkMiniApp\": \"momo://app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT3xQQVktMjY&v=3.0\"}',NULL),(27,24,'2025-09-07 20:10:14',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-27\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"YOUR_TMN_CODE\", \"vnp_Version\": \"2.1.0\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don #24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=27&order_id=24\", \"vnp_CreateDate\": \"20250908031014\"}}',NULL),(28,24,'2025-09-07 22:43:40',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-28\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don #24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=28&order_id=24\", \"vnp_CreateDate\": \"20250908054340\"}}',NULL),(29,24,'2025-09-07 22:48:07',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-29\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=29&order_id=24\", \"vnp_CreateDate\": \"20250908054807\"}}',NULL),(30,24,'2025-09-07 22:51:41',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-30\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_BankCode\": \"VNPAYQR\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=30&order_id=24\", \"vnp_CreateDate\": \"20250908055141\"}}',NULL),(31,24,'2025-09-07 22:52:42',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-31\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_BankCode\": \"VNBANK\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=31&order_id=24\", \"vnp_CreateDate\": \"20250908055242\"}}',NULL),(32,24,'2025-09-07 22:52:52',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-32\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_BankCode\": \"VNPAYQR\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=32&order_id=24\", \"vnp_CreateDate\": \"20250908055252\"}}',NULL),(33,24,'2025-09-07 22:55:12',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-33\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_BankCode\": \"VNBANK\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=33&order_id=24\", \"vnp_CreateDate\": \"20250908055512\"}}',NULL),(34,24,'2025-09-07 22:58:29',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-34\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=34&order_id=24\", \"vnp_CreateDate\": \"20250908055829\"}}',NULL),(35,24,'2025-09-07 22:58:36',4220000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 422000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-35\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_BankCode\": \"VNBANK\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 24\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=35&order_id=24\", \"vnp_CreateDate\": \"20250908055836\"}}',NULL),(36,26,'2025-09-08 20:53:03',3250000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 325000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-36\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_BankCode\": \"VNBANK\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 26\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=36&order_id=26\", \"vnp_CreateDate\": \"20250909035303\"}}',NULL),(37,27,'2025-09-08 20:53:38',3250000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 325000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-37\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 27\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=37&order_id=27\", \"vnp_CreateDate\": \"20250909035338\"}}',NULL),(38,27,'2025-09-08 20:53:44',3250000.00,'e_wallet','vnpay','pending',NULL,'{\"init\": {\"vnp_Amount\": 325000000, \"vnp_IpAddr\": \"127.0.0.1\", \"vnp_Locale\": \"vn\", \"vnp_TxnRef\": \"PAY-38\", \"vnp_Command\": \"pay\", \"vnp_TmnCode\": \"4X0JEG9M\", \"vnp_Version\": \"2.1.0\", \"vnp_BankCode\": \"VNBANK\", \"vnp_CurrCode\": \"VND\", \"vnp_OrderInfo\": \"Thanh toan don 27\", \"vnp_OrderType\": \"other\", \"vnp_ReturnUrl\": \"http://127.0.0.1:8000/payments/return?payment_id=38&order_id=27\", \"vnp_CreateDate\": \"20250909035345\"}}',NULL),(39,27,'2025-09-08 21:01:05',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(40,27,'2025-09-08 21:04:20',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(41,27,'2025-09-08 21:04:30',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(42,27,'2025-09-08 21:04:35',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(43,27,'2025-09-08 21:04:39',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(44,27,'2025-09-08 21:08:01',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(45,27,'2025-09-08 21:08:53',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(46,27,'2025-09-08 21:14:29',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(47,27,'2025-09-08 21:16:29',3250000.00,'e_wallet','vnpay','pending',NULL,NULL,NULL),(48,27,'2025-09-08 21:21:45',3250000.00,'cash','vnpay','pending',NULL,NULL,NULL),(49,27,'2025-09-08 21:24:17',3250000.00,'cash','vnpay','pending',NULL,NULL,NULL),(50,27,'2025-09-08 21:29:17',3250000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 11:31:06'),(51,27,'2025-09-08 21:32:40',3250000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 11:34:18'),(52,27,'2025-09-08 21:35:45',3250000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 11:37:24'),(53,27,'2025-09-08 21:44:32',3250000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 11:46:16'),(54,28,'2025-09-08 21:58:04',3500000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 11:59:58'),(55,28,'2025-09-08 22:15:57',6000000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 12:17:38'),(56,28,'2025-09-08 22:17:26',450000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 12:19:08'),(57,28,'2025-09-08 22:20:35',4330000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 12:22:21'),(58,28,'2025-09-08 22:23:25',2700000.00,'cash','vnpay','completed',NULL,NULL,'2025-09-09 12:25:06'),(59,29,'2025-09-08 23:47:46',450000.00,'cash','vnpay','pending',NULL,NULL,NULL);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Quần Jeans Nam Regular Fit Xanh','Chất liệu cotton cao cấp',450000,44,'/images/products/1754982296_quanjean1.jpg','2025-08-11 03:20:24','2025-09-08 22:23:46'),(2,2,'Quần Jeans Nam Skinny Đen','Co giãn tốt, tôn dáng',500000,40,'/images/products/1754982302_quanjean2.jpg','2025-08-11 03:20:24','2025-08-12 00:05:02'),(3,3,'Quần Jeans Nam Ripped Xanh','Phong cách rách gối',520000,30,'/images/products/1754982325_quanjean3.jpg','2025-08-11 03:20:24','2025-08-12 00:05:25'),(4,3,'Quần Jeans Nam Loose Fit','Phong cách rộng rãi thoải mái',480000,25,'/images/products/1754982395_quanjean4.jpg','2025-08-11 03:20:24','2025-09-10 03:37:19'),(5,2,'Quần Jeans Nam Slim Fit Xanh','Ôm vừa, dễ phối đồ',490000,35,'/images/products/1754982578_quanjean5.jpg','2025-08-11 03:20:24','2025-09-10 03:37:19'),(6,1,'Quần Jeans Nữ Skinny Xanh','Tôn dáng, trẻ trung',470000,60,'/images/products/1754982628_quanjean6.jpg','2025-08-11 03:20:24','2025-09-10 03:36:26'),(7,2,'Quần Jeans Nữ Mom Fit','Phong cách cổ điển',450000,55,'/images/products/1754982742_quanjean7.jpg','2025-08-11 03:20:24','2025-09-10 03:36:26'),(8,2,'Quần Jeans Nữ Baggy','Rộng rãi, năng động',430000,45,'/images/products/1754982829_quanjean8.jpg','2025-08-11 03:20:24','2025-09-10 03:36:26'),(9,3,'Quần Jeans Nữ Boyfriend','Thoải mái, cá tính',440000,40,'/images/products/1757396482_quanjean4.jpg','2025-08-11 03:20:24','2025-09-10 03:40:41'),(10,1,'Quần Jeans Nữ Ống Loe','Phong cách vintage',460000,50,'/images/products/1754982296_quanjean1.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(11,1,'Quần Jeans Trẻ Em Xanh','Dễ chịu, co giãn tốt',300000,70,'/images/products/1754982302_quanjean2.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(12,2,'Quần Jeans Đen Nam','Màu đen basic',470000,45,'/images/products/1754982302_quanjean3.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(13,3,'Quần Jeans Xanh Nam','Màu xanh truyền thống',450000,40,'/images/products/1754982302_quanjean4.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(14,2,'Quần Jeans Xanh Nữ','Phong cách nữ tính',450000,35,'/images/products/1754982302_quanjean5.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(15,2,'Quần Jeans Vintage','Phong cách cổ điển',480000,30,'/images/products/1754982302_quanjean6.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(16,1,'Quần Jeans Nam Jogger','Lưng thun, ống bó',420000,50,'/images/products/1754982302_quanjean7.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(17,3,'Quần Jeans Nam Cargo','Nhiều túi tiện lợi',500000,25,'/images/products/1754982302_quanjean8.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(18,3,'Quần Jeans Nữ Lưng Cao','Tôn vòng eo',490000,40,'/images/products/1754982302_quanjean1.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(19,2,'Quần Jeans Nữ Lưng Thấp','Phong cách cá tính',460000,35,'/images/products/1754982302_quanjean2.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12'),(20,1,'Quần Jeans Nam Lưng Cao','Phong cách lịch lãm',480000,20,'/images/products/1754982302_quanjean3.jpg','2025-08-11 03:20:24','2025-09-10 03:40:12');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Nguyễn Văn A','a@example.com',NULL,'hash1',NULL,'customer','0901111111','Hà Nội','2025-08-11 03:20:24','2025-08-18 02:27:11'),(2,'Nguyễn Văn B','b@example.com',NULL,'hash2',NULL,'customer','0902222222','Hồ Chí Minh','2025-08-11 03:20:24','2025-08-18 02:27:11'),(3,'Nguyễn Văn C','c@example.com',NULL,'hash3',NULL,'customer','0903333333','Đà Nẵng','2025-08-11 03:20:24','2025-08-18 02:27:11'),(4,'Nguyễn Văn D','d@example.com',NULL,'hash4',NULL,'customer','0904444444','Cần Thơ','2025-08-11 03:20:24','2025-08-18 02:27:11'),(5,'Nguyễn Văn E','e@example.com',NULL,'hash5',NULL,'customer','0905555555','Hải Phòng','2025-08-11 03:20:24','2025-08-18 02:27:11'),(6,'Nguyễn Văn F','f@example.com',NULL,'hash6',NULL,'customer','0906666666','Bắc Ninh','2025-08-11 03:20:24','2025-08-18 02:27:11'),(7,'Nguyễn Văn G','g@example.com',NULL,'hash7',NULL,'customer','0907777777','Thanh Hóa','2025-08-11 03:20:24','2025-08-18 02:27:11'),(8,'Nguyễn Văn H','h@example.com',NULL,'hash8',NULL,'customer','0908888888','Nghệ An','2025-08-11 03:20:24','2025-08-18 02:27:11'),(9,'Nguyễn Văn I','i@example.com',NULL,'hash9',NULL,'customer','0909999999','Huế','2025-08-11 03:20:24','2025-08-18 02:27:11'),(10,'Nguyễn Văn J','j@example.com',NULL,'hash10',NULL,'customer','0910000000','Hà Nam','2025-08-11 03:20:24','2025-08-18 02:27:11'),(11,'Nguyễn Văn K','k@example.com',NULL,'hash11',NULL,'customer','0911111111','Nam Định','2025-08-11 03:20:24','2025-08-18 02:27:11'),(12,'Nguyễn Văn L','l@example.com',NULL,'hash12',NULL,'customer','0912222222','Bình Dương','2025-08-11 03:20:24','2025-08-18 02:27:11'),(13,'Nguyễn Văn M','m@example.com',NULL,'hash13',NULL,'customer','0913333333','Vũng Tàu','2025-08-11 03:20:24','2025-08-18 02:27:11'),(14,'Nguyễn Văn N','n@example.com',NULL,'hash14',NULL,'customer','0914444444','Long An','2025-08-11 03:20:24','2025-08-18 02:27:11'),(15,'Nguyễn Văn O','o@example.com',NULL,'hash15',NULL,'customer','0915555555','Phú Thọ','2025-08-11 03:20:24','2025-08-18 02:27:11'),(16,'Nguyễn Văn P','p@example.com',NULL,'hash16',NULL,'customer','0916666666','Thái Bình','2025-08-11 03:20:24','2025-08-18 02:27:11'),(17,'Nguyễn Văn Q','q@example.com',NULL,'hash17',NULL,'customer','0917777777','Quảng Nam','2025-08-11 03:20:24','2025-08-18 02:27:11'),(18,'Nguyễn Văn R','r@example.com',NULL,'hash18',NULL,'customer','0918888888','Quảng Ninh','2025-08-11 03:20:24','2025-08-18 02:27:11'),(19,'Nguyễn Văn S','s@example.com',NULL,'hash19',NULL,'customer','0919999999','Bình Thuận','2025-08-11 03:20:24','2025-08-18 02:27:11'),(20,'Admin','admin@example.com',NULL,'hash20',NULL,'admin','0920000000','Hà Nội','2025-08-11 03:20:24','2025-08-18 02:27:11'),(21,'Trần Hải Việt','viettun0908@gmail.com','2025-09-09 00:50:18','$2y$12$IkQQKbbk8BsVDglsVeEpNex7dTsfWU4ZkzZthB7JsEQPoL5zqfKzS',NULL,'customer','0397915683','Thôn Phố Thú Y - Đức Thượng - Hoài Đức - Hà Nội','2025-08-17 19:27:20','2025-08-17 19:27:20'),(24,'Administrator','admin@jeans.com',NULL,'$2y$12$GjrtU1iAF6IadhT7LK/BKuPvEpludEHefDQZjE3HfcvR1Ec4wooxm',NULL,'admin','0123456789','Hà Nội, Việt Nam','2025-08-17 19:58:36','2025-08-17 19:58:36'),(30,'Mail Test','1@gmail.com',NULL,'$2y$12$Jd.24Vxwmkb1kQAOLW8I7egBI/1DFv3WK0KTK8asFJjWzkY3.g/p2',NULL,'admin','0397915683','Address Test','2025-08-18 23:56:17','2025-09-07 21:18:13'),(36,'Tran Hai Viet','tranviet2004@gmail.com',NULL,'$2y$12$eNGSLHJ1dLLx7IgAEtEZheOdsN/eZUL5oDyMenIQCRq93mzuSbFvC',NULL,'customer','0918081988','AAAAAAAAAAAa','2025-09-08 23:47:01','2025-09-08 23:47:01'),(47,'TranHaiViet','tranviet2004v@gmail.com','2025-09-09 00:50:18','$2y$12$FfvMsW.ISk/FCGbjEHplTuB5f8Rxz0gBHbb65OpkNyC49Mjfmktzm',NULL,'customer','0918081988','aAAAAAAAAAAA','2025-09-09 00:49:35','2025-09-09 00:50:18');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-10 10:56:47
