-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: euronav_db
-- ------------------------------------------------------
-- Server version	8.0.42-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('euronav_cache_356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1750119585),('euronav_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1750119585;',1750119585);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_day`
--

DROP TABLE IF EXISTS `course_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_day` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `day_id` bigint unsigned NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_day_course_id_foreign` (`course_id`),
  KEY `course_day_day_id_foreign` (`day_id`),
  CONSTRAINT `course_day_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_day_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_day`
--

LOCK TABLES `course_day` WRITE;
/*!40000 ALTER TABLE `course_day` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `subject_id` bigint unsigned DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_subject_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'A1',NULL,NULL,'active','2025-06-13 19:22:53','2025-06-13 19:22:53'),(2,'A2',NULL,NULL,'active','2025-06-13 19:35:37','2025-06-13 19:35:37'),(3,'B1',NULL,NULL,'active','2025-06-13 19:35:45','2025-06-13 19:35:45'),(4,'B2',NULL,NULL,'active','2025-06-13 19:35:52','2025-06-13 19:35:52');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `number` int NOT NULL,
  `course_id` bigint unsigned DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_course_id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days`
--

LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` VALUES (1,'Day 1',1,1,'active','2025-06-14 19:31:23','2025-06-14 19:31:23','Day 1'),(2,'Day 4',4,3,'active','2025-06-14 19:48:49','2025-06-14 19:48:49','Day 4'),(3,'Day 6',6,4,'active','2025-06-14 19:50:15','2025-06-14 19:50:15','Day 6'),(4,'Day 1',1,2,'active','2025-06-14 21:17:35','2025-06-14 21:17:35','Day 1'),(5,'Day 8',8,1,'active','2025-06-14 21:59:37','2025-06-14 21:59:37','Day 8'),(6,'Day 9',9,1,'active','2025-06-14 22:01:44','2025-06-14 22:01:44','Day 9'),(7,'Day 11',11,3,'active','2025-06-14 22:03:18','2025-06-14 22:03:18','Day 11'),(8,'Day 1',1,4,'active','2025-06-14 22:05:03','2025-06-14 22:05:03','Day 1'),(9,'Day 14',14,1,'active','2025-06-14 22:07:00','2025-06-14 22:07:00','Day 14'),(10,'Day 1',1,3,'active','2025-06-14 22:08:04','2025-06-14 22:08:04','Day 1'),(11,'Day 13',13,4,'active','2025-06-14 22:23:28','2025-06-14 22:23:28','Day 13'),(12,'Day 21',21,4,'active','2025-06-14 22:29:03','2025-06-14 22:29:03','Day 21'),(13,'Day 10',10,1,'active','2025-06-15 07:42:40','2025-06-15 07:42:40','Day 10'),(14,'Day 4',4,1,'active','2025-06-15 07:58:57','2025-06-15 07:58:57','Day 4'),(15,'Day 21',21,3,'active','2025-06-16 13:41:42','2025-06-16 13:41:42','Day 21'),(16,'Day 31',31,2,'active','2025-06-16 15:35:16','2025-06-16 15:35:16','Day 31'),(17,'Day 31',31,4,'active','2025-06-16 15:39:09','2025-06-16 15:39:09','Day 31'),(18,'Day 41',41,4,'active','2025-06-16 15:49:21','2025-06-16 15:49:21','Day 41'),(19,'Day 51',51,2,'active','2025-06-16 16:00:55','2025-06-16 16:00:55','Day 51'),(20,'Day 51',51,4,'active','2025-06-16 16:11:39','2025-06-16 16:11:39','Day 51'),(21,'Day 4',4,4,'active','2025-06-16 18:18:19','2025-06-16 18:18:19','Day 4');
/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `levels_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `levels`
--

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_03_19_000000_add_options_to_questions_table',1),(5,'2024_06_13_171000_add_role_and_admin_user',2),(6,'2024_03_21_create_notes_table',3),(7,'2024_03_21_create_videos_table',3),(8,'2025_06_16_175717_remove_day_id_from_notes_and_videos_tables',4),(9,'2025_05_25_150029_create_options_table',5),(10,'2025_05_25_150030_create_question_media_table',5),(11,'2025_05_25_153455_create_course_day_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `day_number` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notes_course_id_foreign` (`course_id`),
  KEY `notes_subject_id_foreign` (`subject_id`),
  CONSTRAINT `notes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notes_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,'Demo pdf','details','notes/01JXX0FFEA0YCS137831DYHBV4.pdf',3,3,7,'2025-06-16 18:36:57','2025-06-16 21:37:11');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint unsigned NOT NULL,
  `option_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `options_question_id_foreign` (`question_id`),
  CONSTRAINT `options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_media`
--

DROP TABLE IF EXISTS `question_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_type` enum('image','audio') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_media_question_id_foreign` (`question_id`),
  CONSTRAINT `question_media_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_media`
--

LOCK TABLES `question_media` WRITE;
/*!40000 ALTER TABLE `question_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_types`
--

DROP TABLE IF EXISTS `question_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `question_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_types`
--

LOCK TABLES `question_types` WRITE;
/*!40000 ALTER TABLE `question_types` DISABLE KEYS */;
INSERT INTO `question_types` VALUES (1,'mcq_single',NULL,NULL),(2,'mcq_multiple',NULL,NULL),(3,'reorder',NULL,NULL),(4,'picture_mcq',NULL,NULL),(5,'form_fill',NULL,NULL),(6,'opinion',NULL,NULL),(7,'statement_match',NULL,NULL),(9,'audio_mcq_single','2025-06-14 19:44:05','2025-06-14 19:44:05'),(10,'audio_image_text_single','2025-06-14 19:44:05','2025-06-14 19:44:05'),(11,'audio_image_text_multiple','2025-06-14 19:44:05','2025-06-14 19:44:05'),(12,'true_false','2025-06-14 19:44:05','2025-06-14 19:44:05'),(13,'true_false_multiple','2025-06-14 19:44:05','2025-06-14 19:44:05'),(14,'audio_fill_blank','2025-06-16 13:45:00','2025-06-16 13:45:00'),(15,'picture_fill_blank','2025-06-16 15:41:48','2025-06-16 15:41:48'),(16,'video_fill_blank','2025-06-16 15:49:21','2025-06-16 15:49:21'),(17,'audio_picture_match','2025-06-16 16:00:55','2025-06-16 16:00:55');
/*!40000 ALTER TABLE `question_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `day_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `question_type_id` bigint unsigned NOT NULL,
  `instruction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_data` json NOT NULL,
  `answer_data` json NOT NULL,
  `points` int DEFAULT '1',
  `explanation` text COLLATE utf8mb4_unicode_ci,
  `left_options` json DEFAULT NULL,
  `right_options` json DEFAULT NULL,
  `correct_pairs` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `audio_image_text_images` json DEFAULT NULL,
  `audio_image_text_audio_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture_mcq_images` json DEFAULT NULL,
  `audio_image_text_multiple_pairs` json DEFAULT NULL,
  `true_false_questions` json DEFAULT NULL,
  `form_fill_paragraph` text COLLATE utf8mb4_unicode_ci,
  `reorder_fragments` json DEFAULT NULL,
  `reorder_answer_key` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (3,3,4,4,13,'turned on','\"{\\\"main_instruction\\\":\\\"turned on\\\",\\\"questions\\\":[{\\\"statement\\\":\\\"i am working\\\",\\\"text\\\":\\\"i am working\\\",\\\"options\\\":[\\\"True\\\",\\\"False\\\"],\\\"correct_answer\\\":\\\"true\\\",\\\"correct_indices\\\":[0]},{\\\"statement\\\":\\\"it have bugs\\\",\\\"text\\\":\\\"it have bugs\\\",\\\"options\\\":[\\\"True\\\",\\\"False\\\"],\\\"correct_answer\\\":\\\"false\\\",\\\"correct_indices\\\":[1]}]}\"','\"{\\\"true_false_answers\\\":[{\\\"correct_answer\\\":\\\"true\\\",\\\"correct_indices\\\":[0]},{\\\"correct_answer\\\":\\\"false\\\",\\\"correct_indices\\\":[1]}]}\"',5,NULL,NULL,NULL,NULL,'2025-06-14 19:50:15','2025-06-14 19:50:15',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,5,1,1,10,'audio image text type','\"{\\\"main_instruction\\\":\\\"audio image text type\\\",\\\"audio_file\\\":\\\"question-audio\\\\/FCEDA9hcDdl9RpGnDINWiT2bkOIADszW1LNb05xX.mp3\\\",\\\"images\\\":[\\\"question-images\\\\/yIT8jFPNx8FCoPXjwFKCSSAyNnRltaWH3Y2rKj4o.jpg\\\",\\\"question-images\\\\/LpRNXLgcQpPgIxdR9awrbo5EUckaXUIaQauUKFeR.jpg\\\",\\\"question-images\\\\/iOyu41Y45lu6YeyfBLgCT6GFBxLNH4NzqSln5YG2.jpg\\\"],\\\"right_options\\\":[\\\"car\\\",\\\"body\\\",\\\"brain\\\"]}\"','\"{\\\"correct_pairs\\\":[{\\\"left\\\":0,\\\"right\\\":0},{\\\"left\\\":1,\\\"right\\\":2},{\\\"left\\\":2,\\\"right\\\":1}]}\"',1,NULL,NULL,'[\"car\", \"body\", \"brain\"]','[{\"left\": 0, \"right\": 0}, {\"left\": 1, \"right\": 2}, {\"left\": 2, \"right\": 1}]','2025-06-14 21:59:37','2025-06-15 02:37:40',1,'[\"question-images/yIT8jFPNx8FCoPXjwFKCSSAyNnRltaWH3Y2rKj4o.jpg\", \"question-images/LpRNXLgcQpPgIxdR9awrbo5EUckaXUIaQauUKFeR.jpg\", \"question-images/iOyu41Y45lu6YeyfBLgCT6GFBxLNH4NzqSln5YG2.jpg\"]','question-audio/FCEDA9hcDdl9RpGnDINWiT2bkOIADszW1LNb05xX.mp3',NULL,NULL,NULL,NULL,NULL,NULL),(5,6,1,2,9,'single audio mcq','\"{\\\"main_instruction\\\":\\\"single audio mcq\\\",\\\"audio_file\\\":\\\"question-audio\\\\/a9ujoxq08HgIv5ewcNdMfCK4KFPlbDOiiPN1c5b8.mp3\\\",\\\"sub_questions\\\":[{\\\"question\\\":\\\"main question is this\\\",\\\"options\\\":[\\\"pain\\\",\\\"venom\\\"],\\\"correct_indices\\\":[0]},{\\\"question\\\":\\\"second question triggered\\\",\\\"options\\\":[\\\"body\\\",\\\"car\\\"],\\\"correct_indices\\\":[1]}]}\"','\"{\\\"sub_questions_answers\\\":[[0],[1]]}\"',1,NULL,NULL,NULL,NULL,'2025-06-14 22:01:45','2025-06-15 02:35:10',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,7,3,2,4,'picture mcq type','\"{\\\"main_instruction\\\":\\\"picture mcq type\\\",\\\"images\\\":[\\\"question-images\\\\/J6VomG9btjZFU7cTIE3ZqLUaaqfHf6jpVd1yM0S3.jpg\\\",\\\"question-images\\\\/3D6wA1dG8AVfUiBDiRyWoNF0DtqNqOXVilaD6FKm.jpg\\\"],\\\"right_options\\\":[\\\"car\\\",\\\"body\\\"]}\"','\"{\\\"correct_pairs\\\":[{\\\"left\\\":0,\\\"right\\\":0},{\\\"left\\\":1,\\\"right\\\":1}]}\"',1,NULL,NULL,'[\"car\", \"body\"]','[{\"left\": 0, \"right\": 0}, {\"left\": 1, \"right\": 1}]','2025-06-14 22:03:18','2025-06-15 02:34:09',1,NULL,NULL,'[\"question-images/J6VomG9btjZFU7cTIE3ZqLUaaqfHf6jpVd1yM0S3.jpg\", \"question-images/3D6wA1dG8AVfUiBDiRyWoNF0DtqNqOXVilaD6FKm.jpg\"]',NULL,NULL,NULL,NULL,NULL),(7,8,4,2,11,'multiple audio multiple image','\"{\\\"main_instruction\\\":\\\"multiple audio multiple image\\\",\\\"image_audio_pairs\\\":[{\\\"audio\\\":\\\"question-audio\\\\/bC3jVvSlCDHKWBVtyrTDlwRKYzY6scNp6Pru0OqX.mp3\\\",\\\"image\\\":\\\"question-images\\\\/3JXiCgPZuqBLWNblZcaIJ7vVMoh4UYVJTAcumUiE.jpg\\\"},{\\\"audio\\\":\\\"question-audio\\\\/RzwxHe90I9mkFlmjmrVTdkAB0jHGpa5uksWMzM6v.mp3\\\",\\\"image\\\":null},{\\\"audio\\\":\\\"question-audio\\\\/A4Fa76TruhpYRaJhULWHfJMIk0gtdWCLpENlRlrl.mp3\\\",\\\"image\\\":null}],\\\"right_options\\\":[\\\"car\\\",\\\"body\\\",\\\"head\\\"]}\"','\"{\\\"correct_pairs\\\":[{\\\"left\\\":0,\\\"right\\\":1},{\\\"left\\\":1,\\\"right\\\":0},{\\\"left\\\":2,\\\"right\\\":2}]}\"',12,NULL,NULL,'[\"car\", \"body\", \"head\"]','[{\"left\": 0, \"right\": 1}, {\"left\": 1, \"right\": 0}, {\"left\": 2, \"right\": 2}]','2025-06-14 22:05:04','2025-06-15 02:32:57',1,NULL,NULL,NULL,'[{\"audio\": \"question-audio/bC3jVvSlCDHKWBVtyrTDlwRKYzY6scNp6Pru0OqX.mp3\", \"image\": \"question-images/3JXiCgPZuqBLWNblZcaIJ7vVMoh4UYVJTAcumUiE.jpg\"}, {\"audio\": \"question-audio/RzwxHe90I9mkFlmjmrVTdkAB0jHGpa5uksWMzM6v.mp3\", \"image\": null}, {\"audio\": \"question-audio/A4Fa76TruhpYRaJhULWHfJMIk0gtdWCLpENlRlrl.mp3\", \"image\": null}]',NULL,NULL,NULL,NULL),(9,10,3,4,6,'writing','\"{\\\"main_instruction\\\":\\\"writing\\\",\\\"opinion_answer\\\":\\\"\\\"}\"','\"{\\\"opinion_answer\\\":\\\"\\\"}\"',10,NULL,NULL,NULL,NULL,'2025-06-14 22:08:04','2025-06-14 22:08:04',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,11,4,4,5,'fill in the blanks','\"{\\\"main_instruction\\\":\\\"fill in the blanks\\\",\\\"paragraph\\\":\\\"india is a ___ , we ___ india. india has become the ___th country to be independent.\\\",\\\"options\\\":[\\\"love\\\",\\\"country\\\",\\\"5\\\"],\\\"blank_count\\\":3}\"','\"{\\\"answer_keys\\\":[\\\"country\\\",\\\"love\\\",\\\"5\\\"],\\\"blank_count\\\":3}\"',1,NULL,NULL,NULL,NULL,'2025-06-14 22:23:28','2025-06-15 01:42:24',1,NULL,NULL,NULL,NULL,NULL,'india is a ___ , we ___ india. india has become the ___th country to be independent.',NULL,NULL),(11,10,3,4,3,'reorder ','\"{\\\"main_instruction\\\":\\\"reorder \\\",\\\"fragments\\\":[\\\"newton discovered\\\",\\\"apple fall\\\",\\\"laws when \\\"]}\"','\"{\\\"answer_key\\\":\\\"newton discovered laws when apple fall\\\",\\\"fragments_count\\\":3}\"',1,NULL,NULL,NULL,NULL,'2025-06-14 22:27:19','2025-06-15 01:40:53',1,NULL,NULL,NULL,NULL,NULL,NULL,'[\"newton discovered\", \"apple fall\", \"laws when \"]','newton discovered laws when apple fall'),(12,8,4,3,2,'mcq multiple','\"{\\\"main_instruction\\\":\\\"mcq multiple\\\",\\\"sub_questions\\\":[{\\\"question\\\":\\\"multiple\\\",\\\"options\\\":[\\\"yes\\\",\\\"no\\\"],\\\"correct_indices\\\":[0]},{\\\"question\\\":\\\"completed\\\",\\\"options\\\":[\\\"yes\\\",\\\"no\\\"],\\\"correct_indices\\\":[1]},{\\\"question\\\":\\\"developer\\\",\\\"options\\\":[\\\"yes\\\",\\\"no\\\"],\\\"correct_indices\\\":[0]}]}\"','\"{\\\"sub_questions_answers\\\":[[0],[1],[0]]}\"',15,NULL,NULL,NULL,NULL,'2025-06-14 22:29:04','2025-06-15 01:39:41',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,1,1,1,11,'Drei Personen stellen sich vor. Hören und lesen Sie. Ziehen Sie die passenden Elemente in die Sätze.','\"{\\\"main_instruction\\\":\\\"Drei Personen stellen sich vor. H\\\\u00f6ren und lesen Sie. Ziehen Sie die passenden Elemente in die S\\\\u00e4tze.\\\",\\\"audio_pairs\\\":[{\\\"audio\\\":\\\"question-audio\\\\/AHM6SK7UDEEyvDGWUr73peQ3C8fi6ZEDRn6zPkHk.mp3\\\",\\\"image\\\":null},{\\\"audio\\\":\\\"question-audio\\\\/cdmAN1Pt8jxYwxIrIAaJ2zFolbmUHskmc8l9KnwI.mp3\\\",\\\"image\\\":null},{\\\"audio\\\":\\\"question-audio\\\\/ol5eFfeoGJ7ks1gQaFcV3ki7E1wNrctqby59EMXS.mp3\\\",\\\"image\\\":null}],\\\"right_options\\\":[\\\"Hallo Ich bin Nora.\\\",\\\"Hallo Mein Name ist Ben Weber.\\\",\\\"Guten Tag Ich hei\\\\u00dfe Karin Jungmann.\\\"]}\"','\"{\\\"correct_pairs\\\":[{\\\"left\\\":0,\\\"right\\\":0},{\\\"left\\\":1,\\\"right\\\":1},{\\\"left\\\":2,\\\"right\\\":2}]}\"',1,NULL,NULL,'[\"Hallo Ich bin Nora.\", \"Hallo Mein Name ist Ben Weber.\", \"Guten Tag Ich heiße Karin Jungmann.\"]','[{\"left\": 0, \"right\": 0}, {\"left\": 1, \"right\": 1}, {\"left\": 2, \"right\": 2}]','2025-06-15 03:49:37','2025-06-15 03:49:37',1,NULL,NULL,NULL,'[{\"audio\": \"question-audio/AHM6SK7UDEEyvDGWUr73peQ3C8fi6ZEDRn6zPkHk.mp3\", \"image\": null}, {\"audio\": \"question-audio/cdmAN1Pt8jxYwxIrIAaJ2zFolbmUHskmc8l9KnwI.mp3\", \"image\": null}, {\"audio\": \"question-audio/ol5eFfeoGJ7ks1gQaFcV3ki7E1wNrctqby59EMXS.mp3\", \"image\": null}]',NULL,NULL,NULL,NULL),(14,1,1,1,9,'Hören Sie den Dialog und bringen Sie die Sätze in die richtige Reihenfolge','\"{\\\"main_instruction\\\":\\\"H\\\\u00f6ren Sie den Dialog und bringen Sie die S\\\\u00e4tze in die richtige Reihenfolge\\\",\\\"audio_file\\\":\\\"question-audio\\\\/ZWq8eD1oaHIfz8OyxfodxBQNtLyHWPKI1OvybjdF.mp3\\\",\\\"sub_questions\\\":[{\\\"question\\\":\\\"1ST SENTENCE\\\",\\\"options\\\":[\\\"Hallo, ich hei\\\\u00dfe Marie.\\\",\\\"Hallo, ich bin Max.\\\",\\\"Ich bin Julia.\\\",\\\"Und wer bist du?\\\"],\\\"correct_indices\\\":[1]},{\\\"question\\\":\\\"2ND SENTENCE\\\",\\\"options\\\":[\\\"Hallo, ich hei\\\\u00dfe Marie.\\\",\\\"Hallo, ich bin Max.\\\",\\\"Ich bin Julia.\\\",\\\"Und wer bist du?\\\"],\\\"correct_indices\\\":[0]},{\\\"question\\\":\\\"3RD SENTENCE\\\",\\\"options\\\":[\\\"Hallo, ich hei\\\\u00dfe Marie.\\\",\\\"Hallo, ich bin Max.\\\",\\\"Ich bin Julia.\\\",\\\"Und wer bist du?\\\"],\\\"correct_indices\\\":[3]},{\\\"question\\\":\\\"4TH SENTENCE\\\",\\\"options\\\":[\\\"Hallo, ich hei\\\\u00dfe Marie.\\\",\\\"Hallo, ich bin Max.\\\",\\\"Ich bin Julia.\\\",\\\"Und wer bist du?\\\"],\\\"correct_indices\\\":[2]}]}\"','\"{\\\"sub_questions_answers\\\":[[1],[0],[3],[2]]}\"',1,NULL,NULL,NULL,NULL,'2025-06-15 03:59:14','2025-06-15 03:59:14',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,1,1,1,9,'Hören Sie die Dialoge und lesen Sie die Aussagen. Welche Aussage passt? Wählen Sie aus.\n\n','\"{\\\"main_instruction\\\":\\\"H\\\\u00f6ren Sie die Dialoge und lesen Sie die Aussagen. Welche Aussage passt? W\\\\u00e4hlen Sie aus.\\\\n\\\\n\\\",\\\"audio_file\\\":\\\"question-audio\\\\/qLRUTkozu8zcPltXgr0HzNhC3rEdVdUtBX8RXxVP.mp3\\\",\\\"sub_questions\\\":[{\\\"question\\\":\\\"H\\\\u00f6ren Sie die Dialoge und lesen Sie die Aussagen. Welche Aussage passt? W\\\\u00e4hlen Sie aus.\\\",\\\"options\\\":[\\\" Frau Helmer findet die K\\\\u00fcche sch\\\\u00f6n. \\\",\\\"Frau Helmer findet die K\\\\u00fcche sehr klein.\\\",\\\"Frau Helmer findet das Bad nicht sch\\\\u00f6n.\\\"],\\\"correct_indices\\\":[0]}]}\"','\"{\\\"sub_questions_answers\\\":[[0]]}\"',1,'explanations/RflblwA3zZKAwrsVhmQ5gj5XQbLVJFe1qjdWEBXc.png',NULL,NULL,NULL,'2025-06-15 07:15:19','2025-06-15 07:15:19',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,13,1,4,4,'Wo ist der Aufzug? Ergänzen Sie das passende Stockwerk. Schreiben Sie.\n\n1.	Der Aufzug ist im vierten Stock.\n2. Der Aufzug ist _______\n3. Der Aufzug ist _______\n4. Der Aufzug ist _______\n5. Der Aufzug ist _______','\"{\\\"main_instruction\\\":\\\"Wo ist der Aufzug? Erg\\\\u00e4nzen Sie das passende Stockwerk. Schreiben Sie.\\\\n\\\\n1.\\\\tDer Aufzug ist im vierten Stock.\\\\n2. Der Aufzug ist _______\\\\n3. Der Aufzug ist _______\\\\n4. Der Aufzug ist _______\\\\n5. Der Aufzug ist _______\\\",\\\"images\\\":[\\\"question-images\\\\/iGImrr68s0Uq29LSD3MohOh58RLFx3UqMyIEDvBl.png\\\",\\\"question-images\\\\/X8HhlQ5lxPMQva3dzliDcMD59Du8F6H4OiecLH3R.png\\\",\\\"question-images\\\\/3UQYZFgA65tespx1Gs6gCosOD6r5gz1DQOQ1uSUJ.png\\\",\\\"question-images\\\\/PbLnTxzxn30qpUv23cr1TMJKxlw0mNCrKxigW7RG.png\\\",\\\"question-images\\\\/QOlqc61OzOh1uUAyeJQdXF28xSx9zN4L4y2UCeTD.png\\\"],\\\"right_options\\\":[\\\"im vierten Stock.\\\",\\\"im dritten Stock.\\\",\\\"im Erdgeschoss.\\\",\\\"im ersten Stock.\\\",\\\"im zweiten Stock.\\\"]}\"','\"{\\\"correct_pairs\\\":[{\\\"left\\\":0,\\\"right\\\":0},{\\\"left\\\":1,\\\"right\\\":1},{\\\"left\\\":2,\\\"right\\\":2},{\\\"left\\\":3,\\\"right\\\":3},{\\\"left\\\":4,\\\"right\\\":4}]}\"',1,NULL,NULL,'[\"im vierten Stock.\", \"im dritten Stock.\", \"im Erdgeschoss.\", \"im ersten Stock.\", \"im zweiten Stock.\"]','[{\"left\": 0, \"right\": 0}, {\"left\": 1, \"right\": 1}, {\"left\": 2, \"right\": 2}, {\"left\": 3, \"right\": 3}, {\"left\": 4, \"right\": 4}]','2025-06-15 07:42:41','2025-06-15 07:42:41',1,NULL,NULL,'[\"question-images/iGImrr68s0Uq29LSD3MohOh58RLFx3UqMyIEDvBl.png\", \"question-images/X8HhlQ5lxPMQva3dzliDcMD59Du8F6H4OiecLH3R.png\", \"question-images/3UQYZFgA65tespx1Gs6gCosOD6r5gz1DQOQ1uSUJ.png\", \"question-images/PbLnTxzxn30qpUv23cr1TMJKxlw0mNCrKxigW7RG.png\", \"question-images/QOlqc61OzOh1uUAyeJQdXF28xSx9zN4L4y2UCeTD.png\"]',NULL,NULL,NULL,NULL,NULL),(17,1,1,2,3,'Wo stehen die Modalverben im Satz? Bringen Sie die Satzteile in die richtige Reihenfolge.','\"{\\\"main_instruction\\\":\\\"Wo stehen die Modalverben im Satz? Bringen Sie die Satzteile in die richtige Reihenfolge.\\\",\\\"fragments\\\":[\\\"Ich kann am Abend nicht ins Kino gehen .\\\",\\\"Wo will Lea am Nachmittag spielen ?\\\",\\\"Wollen wir morgen zusammen Kaffee trinken ?\\\",\\\"Daniel muss heute lange arbeiten .\\\",\\\"Ich muss arbeiten .\\\",\\\"Paul muss am Nachmittag zum Fu\\\\u00dfball fahren .\\\"]}\"','\"{\\\"answer_key\\\":\\\"1, 5,3,6,4,2\\\",\\\"fragments_count\\\":6}\"',1,'explanations/XnSmkFxi1ecYV7DrCFh1nCvHOeSDtzWVwlailC9S.png',NULL,NULL,NULL,'2025-06-15 07:49:46','2025-06-15 07:49:46',1,NULL,NULL,NULL,NULL,NULL,NULL,'[\"Ich kann am Abend nicht ins Kino gehen .\", \"Wo will Lea am Nachmittag spielen ?\", \"Wollen wir morgen zusammen Kaffee trinken ?\", \"Daniel muss heute lange arbeiten .\", \"Ich muss arbeiten .\", \"Paul muss am Nachmittag zum Fußball fahren .\"]','1, 5,3,6,4,2'),(18,12,4,2,14,'test','\"{\\\"main_instruction\\\":\\\"test\\\",\\\"paragraph\\\":\\\"i am a ___ , used to work ___ . i can ___ all night\\\",\\\"audio_file\\\":\\\"audio\\\\/16eGG1cmvz9iAiw6B7JvEZXCDFbMUoAlpB6vb4qR.mp3\\\",\\\"blank_count\\\":3}\"','\"{\\\"answer_keys\\\":[\\\"developer\\\",\\\"daily\\\",\\\"work\\\"],\\\"blank_count\\\":3}\"',1,NULL,NULL,NULL,NULL,'2025-06-16 13:45:00','2025-06-16 23:56:50',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,8,4,1,15,'test','\"{\\\"main_instruction\\\":\\\"test\\\",\\\"paragraph\\\":\\\"i am a ___ , working for ___ a day. new ___ is coming.\\\",\\\"image_file\\\":\\\"question-images\\\\/5AymFSMVQLvj69ueXlCA5guXMcgqGfxE80H0uh1q.png\\\",\\\"blank_count\\\":3}\"','\"{\\\"answer_keys\\\":[\\\"developer\\\",\\\"8 hours\\\",\\\"day\\\"],\\\"blank_count\\\":3}\"',1,NULL,NULL,NULL,NULL,'2025-06-16 15:41:48','2025-06-17 00:18:53',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,18,4,3,16,'video','\"{\\\"main_instruction\\\":\\\"video\\\",\\\"paragraph\\\":\\\"this ___ is based on a ___ . main ___ is taken.\\\",\\\"video_file\\\":\\\"videos\\\\/BeqA2WgPE6uBSzTNiA5pLRR7PVu51kmEH1UFDsVE.mp4\\\",\\\"blank_count\\\":3}\"','\"{\\\"answer_keys\\\":[\\\"video\\\",\\\"cartoon\\\",\\\"role\\\"],\\\"blank_count\\\":3}\"',1,NULL,NULL,NULL,NULL,'2025-06-16 15:49:21','2025-06-17 00:29:27',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,19,2,2,17,'demo audio image matching','\"{\\\"main_instruction\\\":\\\"demo audio image matching\\\",\\\"audios\\\":[\\\"audio\\\\/l4rPbO0FrsOU5yAPExihqXcxCWFWU83itKbrBu8Y.mp3\\\",\\\"audio\\\\/UWWX2calY0IiSSKYcnJJfPUKE8LWKNPqvEriOxXI.mp3\\\"],\\\"images\\\":[\\\"images\\\\/yyubYiOedi0HEz37dwJlBrxITtnqv49zAsRugrzc.png\\\",\\\"images\\\\/hJhEU1scfWcV1kgdE8l60v9SH2oYGPJLuZ5YWJKa.png\\\"]}\"','\"{\\\"correct_pairs\\\":[{\\\"left\\\":\\\"0\\\",\\\"right\\\":\\\"1\\\"},{\\\"left\\\":\\\"1\\\",\\\"right\\\":\\\"0\\\"}]}\"',1,NULL,NULL,NULL,NULL,'2025-06-16 16:00:55','2025-06-17 11:01:29',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,20,4,3,14,'test','\"{\\\"audio_file\\\":\\\"audio\\\\/W5WuQk4CX78pG6bDeszm6qv7hFEJ1ofNnQAL6ShW.mp3\\\",\\\"paragraph\\\":\\\"i am ___ developer\\\",\\\"blank_count\\\":1}\"','\"{\\\"answer_keys\\\":[\\\"a\\\"],\\\"blank_count\\\":1}\"',1,NULL,NULL,NULL,NULL,'2025-06-16 16:11:39','2025-06-16 16:11:39',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'Listening','2025-06-13 19:15:55','2025-06-13 19:15:55'),(2,'Speaking','2025-06-13 19:15:55','2025-06-13 19:15:55'),(3,'Reading','2025-06-13 19:15:55','2025-06-13 19:15:55'),(4,'Writing','2025-06-13 19:15:55','2025-06-13 19:15:55');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@example.com',NULL,'$2y$12$sDUDGganaj21UOB5VPVSFO1yrMUfb9I0c4D45pnWKicq4PKYwiBUi','admin',NULL,'2025-06-13 17:23:52','2025-06-13 17:23:52'),(2,'Tittu','tittueldho@gmail.com',NULL,'$2y$12$aCiIxRxuRqr/o/5v/QpKke1BJCrZrjyQDL3.hXS/lGUwrwUZ4XbZ6','admin',NULL,'2025-06-14 05:46:54','2025-06-14 05:46:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `day_number` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `videos_course_id_foreign` (`course_id`),
  KEY `videos_subject_id_foreign` (`subject_id`),
  CONSTRAINT `videos_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `videos_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'Demo 1','details','videos/01JXX08P1J5BZ0P9YBHA9GT9J5.mp4',1,1,6,'2025-06-16 18:33:14','2025-06-16 21:29:28');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-17 12:01:44
