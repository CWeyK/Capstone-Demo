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
-- Table structure for table `subject_classes`
--

DROP TABLE IF EXISTS `subject_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint unsigned NOT NULL,
  `class_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_classes_subject_id_foreign` (`subject_id`),
  CONSTRAINT `subject_classes_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_classes`
--

LOCK TABLES `subject_classes` WRITE;
/*!40000 ALTER TABLE `subject_classes` DISABLE KEYS */;
INSERT INTO `subject_classes` VALUES (1,1,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(2,1,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(3,2,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(4,2,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(5,3,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(6,3,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(7,4,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(8,4,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(9,5,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(10,5,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(11,6,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(12,6,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(13,7,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(14,7,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(15,8,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(16,8,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(17,9,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(18,9,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(19,10,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(20,10,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(21,11,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(22,11,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(23,12,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(24,12,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(25,13,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(26,13,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(27,14,'Lecture',1,'2025-07-25 12:52:45','2025-07-25 12:52:45'),(28,14,'Tutorial',2,'2025-07-25 12:52:45','2025-07-25 12:52:45');
/*!40000 ALTER TABLE `subject_classes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-25 21:59:28
