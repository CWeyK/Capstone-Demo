-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: classai
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'View Role','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(2,'Create & Edit Role','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(3,'View Permission','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(4,'Create & Edit Permission','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(5,'View System & Audit Log','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(6,'View User','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(7,'View User Details','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(8,'Create User','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(9,'Edit User','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(10,'Suspend User','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(11,'View Order','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(12,'Create & Edit Order','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(13,'Cancel Order','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(14,'View Product','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(15,'Create & Edit Product','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(16,'View Category','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(17,'Create & Edit Category','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(18,'View Group','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(19,'Create & Edit Group','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(20,'View Commission Scheme','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(21,'Create & Edit Commission Scheme','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(22,'View Withdrawal','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(23,'Create Withdrawal','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(24,'View Payout','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(25,'Create Payout','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(26,'View Ad Spend','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(27,'Create & Edit Ad Spend','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(28,'Reject Ad Spend','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(29,'View Transaction','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(30,'Approve & Reject Transaction','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(31,'Create & Edit Bank Account','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(32,'Promote Rank','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(33,'View Customer','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(34,'Create & Edit Customer','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(35,'View Family Tree','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(36,'Create & Edit Order Delivery','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(37,'View Currency','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(38,'Edit Currency','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(39,'View Shipping','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(40,'View Event','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(41,'Create & Edit Event','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(42,'View Voucher','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(43,'Create & Edit Voucher','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(44,'View Provider','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(45,'Create & Edit Provider','web','2025-07-23 07:41:18','2025-07-23 07:41:18'),(46,'Approve Withdrawal','web','2025-07-23 07:41:18','2025-07-23 07:41:18');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-25  8:46:54
