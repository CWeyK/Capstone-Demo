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
-- Table structure for table `programme_subject`
--

DROP TABLE IF EXISTS `programme_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programme_subject` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `programme_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programme_subject_programme_id_foreign` (`programme_id`),
  KEY `programme_subject_subject_id_foreign` (`subject_id`),
  CONSTRAINT `programme_subject_programme_id_foreign` FOREIGN KEY (`programme_id`) REFERENCES `programmes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `programme_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programme_subject`
--

LOCK TABLES `programme_subject` WRITE;
/*!40000 ALTER TABLE `programme_subject` DISABLE KEYS */;
INSERT INTO `programme_subject` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,1,3,NULL,NULL),(4,1,4,NULL,NULL),(5,1,5,NULL,NULL),(6,2,2,NULL,NULL),(7,2,6,NULL,NULL),(8,2,7,NULL,NULL),(9,2,12,NULL,NULL),(10,3,1,NULL,NULL),(11,3,14,NULL,NULL),(12,3,8,NULL,NULL),(13,3,9,NULL,NULL),(14,4,10,NULL,NULL),(15,4,11,NULL,NULL),(16,4,12,NULL,NULL),(17,4,13,NULL,NULL),(18,5,14,NULL,NULL),(19,5,1,NULL,NULL),(20,5,5,NULL,NULL),(21,5,9,NULL,NULL);
/*!40000 ALTER TABLE `programme_subject` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-25  8:46:53
