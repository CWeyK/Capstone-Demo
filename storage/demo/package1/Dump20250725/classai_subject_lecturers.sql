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
-- Table structure for table `subject_lecturers`
--

DROP TABLE IF EXISTS `subject_lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_lecturers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_lecturers_subject_id_foreign` (`subject_id`),
  KEY `subject_lecturers_user_id_foreign` (`user_id`),
  CONSTRAINT `subject_lecturers_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subject_lecturers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_lecturers`
--

LOCK TABLES `subject_lecturers` WRITE;
/*!40000 ALTER TABLE `subject_lecturers` DISABLE KEYS */;
INSERT INTO `subject_lecturers` VALUES (1,1,8,NULL,NULL),(2,1,7,NULL,NULL),(3,2,13,NULL,NULL),(4,2,12,NULL,NULL),(5,3,6,NULL,NULL),(6,3,9,NULL,NULL),(7,4,10,NULL,NULL),(8,4,2,NULL,NULL),(9,4,11,NULL,NULL),(10,5,12,NULL,NULL),(11,5,7,NULL,NULL),(12,6,2,NULL,NULL),(13,6,8,NULL,NULL),(14,6,13,NULL,NULL),(15,7,13,NULL,NULL),(16,7,10,NULL,NULL),(17,8,10,NULL,NULL),(18,8,6,NULL,NULL),(19,8,9,NULL,NULL),(20,9,5,NULL,NULL),(21,9,4,NULL,NULL),(22,9,2,NULL,NULL),(23,10,8,NULL,NULL),(24,10,7,NULL,NULL),(25,10,6,NULL,NULL),(26,11,4,NULL,NULL),(27,11,5,NULL,NULL),(28,11,9,NULL,NULL),(29,12,5,NULL,NULL),(30,12,8,NULL,NULL),(31,12,2,NULL,NULL),(32,13,13,NULL,NULL),(33,13,4,NULL,NULL),(34,14,6,NULL,NULL),(35,14,12,NULL,NULL);
/*!40000 ALTER TABLE `subject_lecturers` ENABLE KEYS */;
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
