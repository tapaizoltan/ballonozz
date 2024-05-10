-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: mysql    Database: ballon
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Table structure for table `aircraft`
--

DROP TABLE IF EXISTS `aircraft`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aircraft` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL COMMENT 'feltöltése enum-ból',
  `registration_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'lajstromjel',
  `number_of_person` int unsigned NOT NULL,
  `payload_capacity` int unsigned NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft`
--

LOCK TABLES `aircraft` WRITE;
/*!40000 ALTER TABLE `aircraft` DISABLE KEYS */;
INSERT INTO `aircraft` VALUES (1,'Kisrepülő',1,'HA-7652',2,250,NULL,'2024-03-05 14:26:10','2024-03-27 13:12:21',NULL),(2,'Kicsi légballon',0,'HA-1234',2,300,NULL,'2024-03-05 14:28:16','2024-03-28 15:54:33',NULL),(6,'Nagy légballon',0,'HA-765',10,800,'Ez egy teszt leírás a Nagy légballonról.','2024-03-22 10:22:47','2024-04-22 09:18:58',NULL);
/*!40000 ALTER TABLE `aircraft` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aircraft_location_pilots`
--

DROP TABLE IF EXISTS `aircraft_location_pilots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aircraft_location_pilots` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `period_of_time` time NOT NULL DEFAULT '04:00:00',
  `aircraft_id` int unsigned NOT NULL,
  `region_id` int unsigned NOT NULL DEFAULT '1',
  `location_id` int unsigned DEFAULT NULL,
  `pilot_id` int unsigned DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT 'feltöltése enum-ból',
  `public_description` longtext COLLATE utf8mb4_unicode_ci,
  `non_public_description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aircraft_location_pilots_aircraft_id_foreign` (`aircraft_id`),
  KEY `aircraft_location_pilots_location_id_foreign` (`location_id`),
  KEY `aircraft_location_pilots_pilot_id_foreign` (`pilot_id`),
  KEY `aircraft_location_pilots_region_id_foreign` (`region_id`),
  CONSTRAINT `aircraft_location_pilots_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft` (`id`),
  CONSTRAINT `aircraft_location_pilots_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `aircraft_location_pilots_pilot_id_foreign` FOREIGN KEY (`pilot_id`) REFERENCES `pilots` (`id`),
  CONSTRAINT `aircraft_location_pilots_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft_location_pilots`
--

LOCK TABLES `aircraft_location_pilots` WRITE;
/*!40000 ALTER TABLE `aircraft_location_pilots` DISABLE KEYS */;
INSERT INTO `aircraft_location_pilots` VALUES (1,'2024-04-21','14:30:00','04:00:00',2,3,1,1,3,NULL,NULL,NULL,'2024-05-10 08:58:58'),(2,'2024-04-18','18:00:00','04:00:00',6,1,NULL,2,3,NULL,NULL,'2024-03-08 15:38:26','2024-05-09 14:35:48'),(3,'2024-05-11','08:00:00','04:00:00',6,1,NULL,1,1,NULL,NULL,'2024-03-22 10:32:16','2024-04-22 13:26:46'),(4,'2024-05-11','12:30:00','04:00:00',2,1,NULL,4,0,NULL,NULL,'2024-03-22 10:33:06','2024-04-29 12:41:54'),(5,'2024-05-11','16:00:00','04:00:00',6,1,NULL,4,2,NULL,NULL,'2024-03-22 10:35:55','2024-04-22 06:36:06'),(6,'2024-05-18','08:00:00','04:00:00',6,1,NULL,2,0,'publikus leírás','nem publikus leírás','2024-03-22 10:36:39','2024-04-22 13:24:48'),(7,'2024-04-27','08:00:00','04:00:00',6,1,NULL,2,0,NULL,NULL,'2024-04-04 11:44:47','2024-04-22 13:24:48'),(8,'2024-04-30','08:00:00','03:30:00',6,1,1,1,2,NULL,NULL,'2024-04-25 11:58:33','2024-04-25 12:52:53');
/*!40000 ALTER TABLE `aircraft_location_pilots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aircraft_tickettype`
--

DROP TABLE IF EXISTS `aircraft_tickettype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aircraft_tickettype` (
  `aircraft_id` int unsigned DEFAULT NULL,
  `tickettype_id` int unsigned DEFAULT NULL,
  KEY `aircraft_tickettype_aircraft_id_foreign` (`aircraft_id`),
  KEY `aircraft_tickettype_tickettype_id_foreign` (`tickettype_id`),
  CONSTRAINT `aircraft_tickettype_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft` (`id`) ON DELETE CASCADE,
  CONSTRAINT `aircraft_tickettype_tickettype_id_foreign` FOREIGN KEY (`tickettype_id`) REFERENCES `tickettypes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft_tickettype`
--

LOCK TABLES `aircraft_tickettype` WRITE;
/*!40000 ALTER TABLE `aircraft_tickettype` DISABLE KEYS */;
INSERT INTO `aircraft_tickettype` VALUES (2,10),(6,2),(6,8),(1,10);
/*!40000 ALTER TABLE `aircraft_tickettype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_types`
--

DROP TABLE IF EXISTS `area_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `area_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_types`
--

LOCK TABLES `area_types` WRITE;
/*!40000 ALTER TABLE `area_types` DISABLE KEYS */;
INSERT INTO `area_types` VALUES (1,'akna'),(2,'akna-alsó'),(3,'akna-felső'),(4,'alagút'),(5,'alsórakpart'),(6,'arborétum'),(7,'autóút'),(8,'barakképület'),(9,'barlang'),(10,'bejáró'),(11,'bekötőút'),(12,'bánya'),(13,'bányatelep'),(14,'bástya'),(15,'bástyája'),(16,'csárda'),(17,'csónakházak'),(18,'domb'),(19,'dűlő'),(20,'dűlők'),(21,'dűlősor'),(22,'dűlőterület'),(23,'dűlőút'),(24,'egyetemváros'),(25,'egyéb'),(26,'elágazás'),(27,'emlékút'),(28,'erdészház'),(29,'erdészlak'),(30,'erdő'),(31,'erdősor'),(32,'fasor'),(33,'fasora'),(34,'felső'),(35,'forduló'),(36,'főmérnökség'),(37,'főtér'),(38,'főút'),(39,'föld'),(40,'gyár'),(41,'gyártelep'),(42,'gyárváros'),(43,'gyümölcsös'),(44,'gát'),(45,'gátsor'),(46,'gátőrház'),(47,'határsor'),(48,'határút'),(49,'hegy'),(50,'hegyhát'),(51,'hegyhát dűlő'),(52,'hegyhát'),(53,'köz'),(54,'hrsz'),(55,'hrsz.'),(56,'ház'),(57,'hídfő'),(58,'iskola'),(59,'játszótér'),(60,'kapu'),(61,'kastély'),(62,'kert'),(63,'kertsor'),(64,'kerület'),(65,'kilátó'),(66,'kioszk'),(67,'kocsiszín'),(68,'kolónia'),(69,'korzó'),(70,'kultúrpark'),(71,'kunyhó'),(72,'kör'),(73,'körtér'),(74,'körvasútsor'),(75,'körzet'),(76,'körönd'),(77,'körút'),(78,'köz'),(79,'kút'),(80,'kültelek'),(81,'lakóház'),(82,'lakókert'),(83,'lakónegyed'),(84,'lakópark'),(85,'lakótelep'),(86,'lejtő'),(87,'lejáró'),(88,'liget'),(89,'lépcső'),(90,'major'),(91,'malom'),(92,'menedékház'),(93,'munkásszálló'),(94,'mélyút'),(95,'műút'),(96,'oldal'),(97,'orom'),(98,'park'),(99,'parkja'),(100,'parkoló'),(101,'part'),(102,'pavilon'),(103,'piac'),(104,'pihenő'),(105,'pince'),(106,'pincesor'),(107,'postafiók'),(108,'puszta'),(109,'pálya'),(110,'pályaudvar'),(111,'rakpart'),(112,'repülőtér'),(113,'rész'),(114,'rét'),(115,'sarok'),(116,'sor'),(117,'sora'),(118,'sportpálya'),(119,'sporttelep'),(120,'stadion'),(121,'strandfürdő'),(122,'sugárút'),(123,'szer'),(124,'sziget'),(125,'szivattyútelep'),(126,'szállás'),(127,'szállások'),(128,'szél'),(129,'szőlő'),(130,'szőlőhegy'),(131,'szőlők'),(132,'sánc'),(133,'sávház'),(134,'sétány'),(135,'tag'),(136,'tanya'),(137,'tanyák'),(138,'telep'),(139,'temető'),(140,'tere'),(141,'tető'),(142,'turistaház'),(143,'téli kikötő'),(144,'tér'),(145,'tömb'),(146,'udvar'),(147,'utak'),(148,'utca'),(149,'utcája'),(150,'vadaskert'),(151,'vadászház'),(152,'vasúti megálló'),(153,'vasúti őrház'),(154,'vasútsor'),(155,'vasútállomás'),(156,'vezetőút'),(157,'villasor'),(158,'vágóhíd'),(159,'vár'),(160,'várköz'),(161,'város'),(162,'vízmű'),(163,'völgy'),(164,'zsilip'),(165,'zug'),(166,'állat és növ.kert'),(167,'állomás'),(168,'árnyék'),(169,'árok'),(170,'átjáró'),(171,'őrház'),(172,'őrházak'),(173,'őrházlak'),(174,'út'),(175,'útja'),(176,'útőrház'),(177,'üdülő'),(178,'üdülő-part'),(179,'üdülő-sor'),(180,'üdülő-telep');
/*!40000 ALTER TABLE `area_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkins`
--

DROP TABLE IF EXISTS `checkins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `checkins` (
  `aircraft_location_pilot_id` int unsigned NOT NULL,
  `coupon_id` int unsigned NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`aircraft_location_pilot_id`,`coupon_id`),
  KEY `checkins_coupon_id_foreign` (`coupon_id`),
  CONSTRAINT `checkins_aircraft_location_pilot_id_foreign` FOREIGN KEY (`aircraft_location_pilot_id`) REFERENCES `aircraft_location_pilots` (`id`),
  CONSTRAINT `checkins_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkins`
--

LOCK TABLES `checkins` WRITE;
/*!40000 ALTER TABLE `checkins` DISABLE KEYS */;
INSERT INTO `checkins` VALUES (2,12,0,'2024-04-04 13:20:33'),(3,12,0,'2024-03-27 17:15:38'),(5,12,0,'2024-03-27 17:15:41'),(8,12,0,'2024-04-25 13:12:51'),(8,61,1,'2024-04-25 12:53:04');
/*!40000 ALTER TABLE `checkins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon_code_attempts`
--

DROP TABLE IF EXISTS `coupon_code_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupon_code_attempts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_code_attempts`
--

LOCK TABLES `coupon_code_attempts` WRITE;
/*!40000 ALTER TABLE `coupon_code_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_code_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adult` int NOT NULL,
  `children` int NOT NULL,
  `tickettype_id` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `expiration_at` date NOT NULL DEFAULT '2024-04-16',
  `total_price` int DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (8,NULL,1,'etwetwetw','Egyéb',2,0,10,4,'2024-04-16',NULL,NULL,'2024-03-20 10:27:21','2024-04-17 09:10:12'),(12,NULL,1,'dsa343223','Egyéb',1,0,10,1,'2025-04-16',NULL,NULL,'2024-03-21 15:17:33','2024-05-07 06:28:12'),(13,NULL,1,'dsasd','Egyéb',2,0,8,3,'2025-04-16',NULL,NULL,'2024-03-21 16:02:15','2024-03-21 16:02:15'),(14,12,1,'e507638','Egyéb',2,0,8,1,'2025-04-16',NULL,NULL,'2024-03-22 14:06:53','2024-05-09 11:36:29'),(15,NULL,1,'zzz-7543','Meglepkék',1,1,8,4,'2024-04-15',NULL,NULL,'2024-03-25 07:37:29','2024-03-27 09:12:04'),(16,NULL,1,'wq1234','Egyéb',2,2,6,0,'2025-04-16',NULL,NULL,'2024-04-04 13:02:45','2024-04-16 13:59:21'),(54,NULL,2,'1256','Ballonozz',2,2,2,1,'2025-04-16',NULL,NULL,'2024-04-09 07:37:28','2024-04-09 07:37:28'),(57,NULL,2,'1567','Ballonozz',3,0,2,1,'2025-03-28',NULL,NULL,'2024-04-16 07:31:06','2024-04-16 07:31:06'),(58,NULL,3,'cdcd','Egyéb',2,2,NULL,0,'2025-04-17',NULL,NULL,'2024-04-17 07:59:46','2024-04-17 07:59:46'),(59,NULL,2,'543210','Egyéb',2,0,NULL,0,'2024-04-19',NULL,NULL,'2024-04-19 06:58:47','2024-04-19 06:58:47'),(60,NULL,1,'1588','Ballonozz',2,0,2,1,'2025-04-23',112000,NULL,'2024-04-23 14:44:45','2024-05-09 11:36:29'),(61,NULL,2,'ezatobb','Egyéb',2,2,2,5,'2025-04-24',NULL,NULL,'2024-04-25 12:41:46','2024-05-07 06:28:12'),(62,NULL,2,'teszt','Egyéb',2,1,NULL,0,'2025-04-30',NULL,NULL,'2024-04-26 07:33:53','2024-04-26 07:33:53'),(64,54,2,'virtual94499','Kiegészítő',1,1,2,1,'2024-05-04',NULL,NULL,'2024-05-03 12:28:04',NULL),(65,NULL,2,'gift61006','Ajándék',2,2,2,1,'2024-05-04',NULL,NULL,'2024-05-03 12:51:15',NULL),(66,12,1,'virtual98165','Kiegészítő',1,0,10,1,'2024-05-31',NULL,NULL,'2024-05-06 06:25:16',NULL),(67,12,1,'virtual44065','Kiegészítő',2,0,10,1,'2024-05-06',NULL,NULL,'2024-05-06 10:07:12',NULL),(68,60,1,'virtual14524','Kiegészítő',1,0,2,1,'2024-05-10',NULL,NULL,'2024-05-09 07:27:17','2024-05-09 07:27:17'),(69,60,1,'virtual47986','Kiegészítő',0,0,2,1,'2025-04-23',30000,'Ez egy teszt megjegyzés a kiegészítő jegyhez.','2024-05-09 14:52:48','2024-05-09 14:52:48');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Születésnap','The metaphone key is the phonetic representation of an input string. ','2024-04-30','2024-05-02',1,NULL,'2024-04-29 08:36:50'),(2,'Teszt esemény','ide jön majd egy hosszabb és részletesebb leírás az eseményről.','2024-04-25','2024-04-27',1,'2024-04-23 09:11:40','2024-04-29 08:37:03');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exports`
--

DROP TABLE IF EXISTS `exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exports_user_id_foreign` (`user_id`),
  CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exports`
--

LOCK TABLES `exports` WRITE;
/*!40000 ALTER TABLE `exports` DISABLE KEYS */;
INSERT INTO `exports` VALUES (1,'2024-05-10 11:45:08','public','exportálás-1-users','App\\Filament\\Exports\\UserExporter',4,4,4,1,'2024-05-10 11:45:08','2024-05-10 11:45:08'),(2,'2024-05-10 11:49:58','public','exportálás-2-users','App\\Filament\\Exports\\UserExporter',4,4,4,1,'2024-05-10 11:49:58','2024-05-10 11:49:58'),(3,'2024-05-10 12:02:10','public','exportálás-3-users','App\\Filament\\Exports\\UserExporter',4,4,4,1,'2024-05-10 12:02:09','2024-05-10 12:02:10'),(4,'2024-05-10 12:03:54','public','exportálás-4-users','App\\Filament\\Exports\\UserExporter',4,4,4,1,'2024-05-10 12:02:48','2024-05-10 12:03:54'),(5,'2024-05-10 12:05:30','public','exportálás-5-users','App\\Filament\\Exports\\UserExporter',4,4,4,1,'2024-05-10 12:05:27','2024-05-10 12:05:30'),(6,'2024-05-10 12:22:08','public','exportálás-6-users','App\\Filament\\Exports\\UserExporter',4,4,4,1,'2024-05-10 12:22:08','2024-05-10 12:22:08');
/*!40000 ALTER TABLE `exports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_import_rows`
--

DROP TABLE IF EXISTS `failed_import_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_import_rows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data` json NOT NULL,
  `import_id` bigint unsigned NOT NULL,
  `validation_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_import_rows_import_id_foreign` (`import_id`),
  CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_import_rows`
--

LOCK TABLES `failed_import_rows` WRITE;
/*!40000 ALTER TABLE `failed_import_rows` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_import_rows` ENABLE KEYS */;
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
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imports_user_id_foreign` (`user_id`),
  CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imports`
--

LOCK TABLES `imports` WRITE;
/*!40000 ALTER TABLE `imports` DISABLE KEYS */;
/*!40000 ALTER TABLE `imports` ENABLE KEYS */;
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
INSERT INTO `job_batches` VALUES ('9c026821-5591-456f-b222-37e79f8e1a31','',2,0,0,'[]','a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5464:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":7:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:45:08\";s:10:\"created_at\";s:19:\"2024-05-10 11:45:08\";s:2:\"id\";i:1;s:9:\"file_name\";s:20:\"exportálás-1-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:45:08\";s:10:\"created_at\";s:19:\"2024-05-10 11:45:08\";s:2:\"id\";i:1;s:9:\"file_name\";s:20:\"exportálás-1-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-1-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:19:\"chainCatchCallbacks\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2383:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:45:08\";s:10:\"created_at\";s:19:\"2024-05-10 11:45:08\";s:2:\"id\";i:1;s:9:\"file_name\";s:20:\"exportálás-1-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:45:08\";s:10:\"created_at\";s:19:\"2024-05-10 11:45:08\";s:2:\"id\";i:1;s:9:\"file_name\";s:20:\"exportálás-1-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-1-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}\";}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000010cd0000000000000000\";}\";s:4:\"hash\";s:44:\"2pQmU2sCl/3UyZyblXDYDQZn4eIzPvjqtWsz39ahjZ8=\";}}}}',NULL,1715341508,1715341508),('9c0269db-50c9-4204-9017-04f16906279e','',2,0,0,'[]','a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5405:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":6:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:49:58\";s:10:\"created_at\";s:19:\"2024-05-10 11:49:58\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"exportálás-2-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:49:58\";s:10:\"created_at\";s:19:\"2024-05-10 11:49:58\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"exportálás-2-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-2-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}s:19:\"chainCatchCallbacks\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2469:\"O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":5:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:49:58\";s:10:\"created_at\";s:19:\"2024-05-10 11:49:58\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"exportálás-2-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 11:49:58\";s:10:\"created_at\";s:19:\"2024-05-10 11:49:58\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"exportálás-2-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-2-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0formats\";a:1:{i:0;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}}\";}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000036dc0000000000000000\";}\";s:4:\"hash\";s:44:\"/HnEYntKI9IbgiXPo6aRDfGaGQltP/kWtIosFh3Nreg=\";}}}}',NULL,1715341798,1715341798),('9c026e37-6982-4f48-aefb-1432c90e948f','',2,0,0,'[]','a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5405:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":6:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:09\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:09\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"exportálás-3-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:09\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:09\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"exportálás-3-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-3-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}s:19:\"chainCatchCallbacks\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2469:\"O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":5:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:09\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:09\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"exportálás-3-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:09\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:09\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"exportálás-3-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-3-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0formats\";a:1:{i:0;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}}\";}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000036dc0000000000000000\";}\";s:4:\"hash\";s:44:\"DF+sRQ1gLxJnPOYkjQ9BngA/KTixT/w43VIcOu7RLME=\";}}}}',NULL,1715342529,1715342529),('9c026ed6-2517-4b9a-a3ae-94df560a4ba0','',2,0,0,'[]','a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5405:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":6:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:48\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:48\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"exportálás-4-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:48\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:48\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"exportálás-4-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-4-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}s:19:\"chainCatchCallbacks\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2469:\"O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":5:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:48\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:48\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"exportálás-4-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:02:48\";s:10:\"created_at\";s:19:\"2024-05-10 12:02:48\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"exportálás-4-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-4-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0formats\";a:1:{i:0;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}}\";}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000bb70000000000000000\";}\";s:4:\"hash\";s:44:\"anuVUFENEImRPVafssmhLk311M3Zm5wrBnEIWHvz1ek=\";}}}}',NULL,1715342633,1715342634),('9c026f69-8d26-4551-8c13-659250a1bdb6','',2,0,0,'[]','a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5405:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":6:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:05:27\";s:10:\"created_at\";s:19:\"2024-05-10 12:05:27\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"exportálás-5-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:05:27\";s:10:\"created_at\";s:19:\"2024-05-10 12:05:27\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"exportálás-5-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-5-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}s:19:\"chainCatchCallbacks\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2469:\"O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":5:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:05:27\";s:10:\"created_at\";s:19:\"2024-05-10 12:05:27\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"exportálás-5-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:05:27\";s:10:\"created_at\";s:19:\"2024-05-10 12:05:27\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"exportálás-5-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-5-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0formats\";a:1:{i:0;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}}\";}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c160000000000000000\";}\";s:4:\"hash\";s:44:\"MeRywfJoskfod1oBalxZ/DsFNIFcrSd7GwRxiF6WEes=\";}}}}',NULL,1715342730,1715342730),('9c02755c-070f-4f11-a953-f1b8a71efe45','',2,0,0,'[]','a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5405:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":6:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:22:08\";s:10:\"created_at\";s:19:\"2024-05-10 12:22:08\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"exportálás-6-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:22:08\";s:10:\"created_at\";s:19:\"2024-05-10 12:22:08\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"exportálás-6-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-6-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}s:19:\"chainCatchCallbacks\";a:0:{}s:7:\"chained\";a:1:{i:0;s:2469:\"O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":5:{s:11:\"\0*\0exporter\";O:33:\"App\\Filament\\Exports\\UserExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:22:08\";s:10:\"created_at\";s:19:\"2024-05-10 12:22:08\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"exportálás-6-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:33:\"App\\Filament\\Exports\\UserExporter\";s:10:\"total_rows\";i:4;s:9:\"file_disk\";s:6:\"public\";s:10:\"updated_at\";s:19:\"2024-05-10 12:22:08\";s:10:\"created_at\";s:19:\"2024-05-10 12:22:08\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"exportálás-6-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"exportálás-6-users\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:5:{s:4:\"name\";s:4:\"Név\";s:5:\"email\";s:11:\"E-mail cím\";s:5:\"phone\";s:12:\"Telefonszám\";s:10:\"created_at\";s:18:\"Ekkor regisztrált\";s:13:\"last_login_at\";s:24:\"Utoljára ekkor volt itt\";}s:10:\"\0*\0formats\";a:1:{i:0;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}}\";}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c3f0000000000000000\";}\";s:4:\"hash\";s:44:\"HeDonGhbfEaNnPRLfkBmZWqPLWb5xfT4OM6kPZNi3jo=\";}}}}',NULL,1715343728,1715343728);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int NOT NULL,
  `zip_code` int DEFAULT NULL,
  `settlement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_type_id` int DEFAULT NULL COMMENT 'feltöltése area_types táblából',
  `address_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coordinates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `online_map_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Siófok-Kiliti reptér',1,8600,'Siófok','Szekszárdi',174,'17','47.6458345,19.9761906','https://www.google.com/maps/@47.6458345,19.9761906,19.5z?entry=ttu','form-attachments/01HW5NRW658F6M22QSNZSCPK9F.png',NULL,'2024-04-23 14:29:18',NULL),(3,'Békéscsaba Airport',3,5600,'Békéscsaba','Repülőtéri',174,'13',NULL,NULL,NULL,'2024-03-06 12:56:42','2024-04-03 13:37:45',NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2024_03_05_074750_create_aircrafts_table',2),(7,'2024_03_05_075315_create_locations_table',3),(8,'2024_03_05_080828_create_pilots_table',4),(9,'2024_03_05_080959_create_aircraft_location_pilots_table',5),(10,'2024_03_05_081104_create_tickettypes_table',6),(12,'2024_03_05_084152_create_aircraft_table',8),(13,'2024_03_05_084857_create_aircraft_location_pilots_table',9),(14,'2024_03_05_085249_create_tickettype_aircraft_table',10),(17,'2024_03_06_092937_create_area_types_table',11),(23,'2024_03_11_130827_create_tickettype_aircraft_table',12),(25,'2024_03_18_120004_create_coupons_table',13),(26,'2024_03_19_105531_create_passengers_table',14),(27,'2024_03_19_132138_add_field_to_coupons_table',15),(29,'2024_03_19_140228_create_jobs_table',16),(30,'2024_03_19_125745_create_permission_tables',17),(33,'2024_03_19_150033_add_coupon_code_column_to_coupons_table',18),(34,'2024_03_19_155715_add_body_weight_column_to_passengers_table',19),(38,'2024_03_20_091008_add_coupon_id_column_to_passengers_table',20),(40,'2024_03_21_094811_add_tickettype_id_column_to_coupons_table',21),(41,'2024_03_21_095628_create_checkins_table',22),(42,'2024_03_21_071203_add_phone_column_to_users_table',23),(43,'2024_03_26_140026_add_ticket_type_flags_columns_to_aircraft_table',24),(44,'2024_03_28_121758_add_aircraft_type_column_to_coupons_table',25),(45,'2024_03_28_131125_add_deleted_at_column_to_users_table',25),(46,'2024_03_28_141306_create_coupon_code_attempts_table',25),(48,'2024_04_02_095958_add_email_and_phone_columns_to_passengers_table',26),(51,'2024_04_02_134327_modifying_columns_to_tickettypes_table',27),(52,'2024_04_03_074914_modifying_columns_to_aircraft_table',28),(53,'2024_04_03_084825_add_period_of_time_column_to_aircraft_location_pilots_table',29),(54,'2024_04_03_094115_create_regions_table',30),(58,'2024_04_03_122627_add_region_id_column_to_locations_table',31),(59,'2024_04_03_141000_create_aircraft_tickettype_table',32),(60,'2024_04_04_070055_modifying_columns_to_coupons_table',33),(61,'2024_04_04_072218_add_default_column_to_tickettypes_table',34),(62,'2024_04_04_093023_modifying_columns_to_aircraft_location_pilots',35),(63,'2024_04_16_072618_add_expiration_at_column_to_coupons_table',36),(64,'2024_04_19_063410_create_tickettype_region_table',37),(66,'2024_04_22_064925_drop_period_of_time_column_from_aircraft_location_pilots_table',38),(67,'2024_04_22_065205_add_period_of_time_column_to_aircraft_location_pilots_table',39),(68,'2024_04_22_085525_add_description_column_to_aircraft_table',40),(69,'2024_04_22_092559_add_public_and_non_public_description_columns_to_aircraft_location_pilots_table',41),(70,'2024_04_22_140324_create_events_table',42),(71,'2024_04_22_142530_add_last_login_at_column_to_users_table',42),(72,'2024_04_23_094102_add_parent_coupon_column_to_coupons_table',43),(73,'2024_04_23_122225_modifying_columns_to_locations_table',44),(74,'2024_04_23_143747_add_total_price_column_to_coupons_table',45),(77,'2024_04_26_072246_modifying_columns_to_passengers_table',46),(78,'2024_04_30_075603_modifying_columns_to_copuons_table',47),(79,'2024_05_09_144147_add_description_column_to_coupons_table',48),(82,'2024_05_10_114329_create_job_batches_table',49),(83,'2024_05_10_114342_create_notifications_table',49),(84,'2024_05_10_114410_create_imports_table',49),(85,'2024_05_10_114412_create_failed_import_rows_table',49),(86,'2024_05_10_114445_create_exports_table',49);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(2,'App\\Models\\User',3),(3,'App\\Models\\User',4);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passengers`
--

DROP TABLE IF EXISTS `passengers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passengers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL COMMENT 'születési dátum',
  `id_card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'igazolvány szám',
  `body_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'testsúly',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passengers`
--

LOCK TABLES `passengers` WRITE;
/*!40000 ALTER TABLE `passengers` DISABLE KEYS */;
INSERT INTO `passengers` VALUES (3,8,'Katalin','Tápai','1984-02-09','972232TA','67',NULL,NULL,'2024-03-20 13:01:28','2024-03-20 13:01:28'),(4,8,'Zoltán','Tápai','1979-01-15','987997TZ','103',NULL,NULL,'2024-03-20 13:06:29','2024-03-20 13:06:29'),(5,12,'wtttt','weee','2024-03-21','qre','2','teszt@teszt.hu','+36 20 369 4747','2024-03-22 09:38:10','2024-04-02 13:48:29'),(9,61,'ttt','ttt','2024-04-26','222','1',NULL,NULL,'2024-04-25 12:43:21','2024-04-25 12:43:21'),(10,61,'rtt','rtt','2024-04-27','2333','2',NULL,NULL,'2024-04-25 12:43:21','2024-04-25 12:43:21'),(11,61,'ttt','wtt','2024-04-27','3433','1',NULL,NULL,'2024-04-25 12:43:21','2024-04-25 12:43:21'),(12,61,'qtt','qtt','2024-04-26','211','1',NULL,NULL,'2024-04-25 12:43:21','2024-04-25 12:43:21'),(13,62,NULL,'Első',NULL,NULL,NULL,NULL,NULL,'2024-04-26 07:40:42','2024-04-26 07:40:42'),(14,62,NULL,'Második',NULL,NULL,NULL,NULL,NULL,'2024-04-26 07:40:42','2024-04-26 07:40:42'),(15,62,NULL,'Harmadik',NULL,NULL,NULL,NULL,NULL,'2024-04-26 07:40:42','2024-04-26 07:40:42');
/*!40000 ALTER TABLE `passengers` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(2,'view_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(3,'create_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(4,'update_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(5,'restore_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(6,'restore_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(7,'replicate_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(8,'reorder_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(9,'delete_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(10,'delete_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(11,'force_delete_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(12,'force_delete_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(13,'view_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(14,'view_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(15,'create_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(16,'update_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(17,'restore_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(18,'restore_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(19,'replicate_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(20,'reorder_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(21,'delete_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(22,'delete_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(23,'force_delete_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(24,'force_delete_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(25,'view_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(26,'view_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(27,'create_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(28,'update_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(29,'restore_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(30,'restore_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(31,'replicate_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(32,'reorder_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(33,'delete_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(34,'delete_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(35,'force_delete_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(36,'force_delete_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(37,'view_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(38,'view_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(39,'create_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(40,'update_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(41,'restore_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(42,'restore_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(43,'replicate_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(44,'reorder_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(45,'delete_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(46,'delete_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(47,'force_delete_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(48,'force_delete_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(49,'view_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(50,'view_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(51,'create_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(52,'update_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(53,'restore_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(54,'restore_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(55,'replicate_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(56,'reorder_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(57,'delete_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(58,'delete_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(59,'force_delete_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(60,'force_delete_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(61,'view_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(62,'view_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(63,'create_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(64,'update_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(65,'restore_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(66,'restore_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(67,'replicate_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(68,'reorder_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(69,'delete_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(70,'delete_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(71,'force_delete_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(72,'force_delete_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(73,'view_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(74,'view_any_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(75,'create_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(76,'update_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(77,'delete_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(78,'delete_any_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(79,'view_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(80,'view_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(81,'create_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(82,'update_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(83,'restore_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(84,'restore_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(85,'replicate_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(86,'reorder_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(87,'delete_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(88,'delete_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(89,'force_delete_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(90,'force_delete_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(91,'view_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(92,'view_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(93,'create_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(94,'update_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(95,'restore_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(96,'restore_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(97,'replicate_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(98,'reorder_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(99,'delete_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(100,'delete_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(101,'force_delete_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(102,'force_delete_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(103,'view_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(104,'view_any_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(105,'create_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(106,'update_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(107,'restore_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(108,'restore_any_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(109,'replicate_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(110,'reorder_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(111,'delete_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(112,'delete_any_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(113,'force_delete_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(114,'force_delete_any_pendingcoupon','web','2024-03-26 12:57:56','2024-03-26 12:57:56'),(115,'page_Checkin','web','2024-03-26 13:00:09','2024-03-26 13:00:09');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pilots`
--

DROP TABLE IF EXISTS `pilots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pilots` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilot_license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pilóta igazolvány száma',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pilots`
--

LOCK TABLES `pilots` WRITE;
/*!40000 ALTER TABLE `pilots` DISABLE KEYS */;
INSERT INTO `pilots` VALUES (1,'Gábor','Nagy','432766ZU',NULL,'2024-03-22 10:33:48',NULL),(2,'János Imre','Reichardt','934245HJ','2024-03-06 14:46:41','2024-03-22 10:34:18',NULL),(4,'László','Szijártó-Kiss','118946KE','2024-03-22 10:35:03','2024-03-22 10:35:03',NULL);
/*!40000 ALTER TABLE `pilots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (1,'Siófoki régió',NULL,NULL),(2,'Paksi régió',NULL,NULL),(3,'Békéscsabai régió','2024-04-03 13:23:40','2024-04-03 13:23:40');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (25,2),(26,2),(27,2),(28,2),(30,2),(32,2),(1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3),(24,3),(37,3),(38,3),(39,3),(40,3),(41,3),(42,3),(43,3),(44,3),(45,3),(46,3),(47,3),(48,3),(61,3),(62,3),(63,3),(64,3),(65,3),(66,3),(67,3),(68,3),(69,3),(70,3),(71,3),(72,3),(79,3),(80,3),(81,3),(82,3),(83,3),(84,3),(85,3),(86,3),(87,3),(88,3),(89,3),(90,3),(103,3),(104,3),(105,3),(106,3),(107,3),(108,3),(109,3),(110,3),(111,3),(112,3),(113,3),(114,3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(2,'vásárló','web','2024-03-26 07:28:36','2024-03-26 07:28:36'),(3,'admin','web','2024-03-26 12:57:56','2024-03-26 13:00:56');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickettype_region`
--

DROP TABLE IF EXISTS `tickettype_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickettype_region` (
  `tickettype_id` int unsigned DEFAULT NULL,
  `region_id` int unsigned DEFAULT NULL,
  KEY `tickettype_region_tickettype_id_foreign` (`tickettype_id`),
  KEY `tickettype_region_region_id_foreign` (`region_id`),
  CONSTRAINT `tickettype_region_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tickettype_region_tickettype_id_foreign` FOREIGN KEY (`tickettype_id`) REFERENCES `tickettypes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettype_region`
--

LOCK TABLES `tickettype_region` WRITE;
/*!40000 ALTER TABLE `tickettype_region` DISABLE KEYS */;
INSERT INTO `tickettype_region` VALUES (2,2),(2,3),(2,1);
/*!40000 ALTER TABLE `tickettype_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickettypes`
--

DROP TABLE IF EXISTS `tickettypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickettypes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `aircrafttype` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettypes`
--

LOCK TABLES `tickettypes` WRITE;
/*!40000 ALTER TABLE `tickettypes` DISABLE KEYS */;
INSERT INTO `tickettypes` VALUES (2,'Normál','Egy egy általános jegytípus','#ff00ee',1,0,'2024-03-11 10:03:24','2024-04-19 06:53:54',NULL),(5,'Privát','Ez egy privát jegytípus','#e88014',0,0,'2024-03-22 10:41:25','2024-04-09 14:26:43',NULL),(6,'Félprivát','Ez egy félprivát jegytípus','#d10000',0,0,'2024-03-22 10:42:34','2024-04-03 07:12:30',NULL),(7,'VIP','Ez egy VIP jegytípus','#ffffff',0,0,'2024-03-22 10:44:07','2024-04-04 13:24:21',NULL),(8,'Sztratoszféra','Ez egy sztratoszféra jegytípus','#001db5',0,0,'2024-03-22 10:45:10','2024-04-03 07:15:01',NULL),(9,'Szuperior','Ez egy szuperior jegytípus','#34e000',0,0,'2024-03-22 10:49:52','2024-04-03 07:15:43',NULL),(10,'Kisrepülős','Ez egy kisrepülős jegytípus','#8829e8',1,1,'2024-04-03 07:16:28','2024-04-09 12:01:16',NULL);
/*!40000 ALTER TABLE `tickettypes` ENABLE KEYS */;
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
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@admin.hu',NULL,'2024-03-01 09:00:00','$2y$12$LP5/dG8ZFoKdoztZZ4MeqOMVlK5P7qv7c1xRZweVFG/8fHxcyHXzK',NULL,'2024-03-05 08:34:58','2024-04-30 06:25:56','2024-04-30 06:25:56',NULL),(2,'Vásárló Egy','vasarlo1@vasarlo.hu','+36301234567','2024-03-01 09:00:00','$2y$12$bAR5bTuNWHxOxx/j58LhreAtQKA4asOjw6a7s70wacHOzMYcqK3Gy',NULL,'2024-03-26 07:50:01',NULL,'2024-03-26 07:50:01',NULL),(3,'Vásárló Kettő','vasarlo2@vasarlo.hu','+36309876543','2024-03-01 09:00:00','$2y$12$9msNkMAxxZTRo7B27ZPH6OqvrcWQxz3nuHAyZCCgncyAA1hX02Yyu',NULL,'2024-03-26 07:51:22',NULL,'2024-03-26 07:51:22',NULL),(4,'Balázs','balazs@ballonozz.hu','+36301234567','2024-03-01 09:00:00','$2y$12$szCj6y9hGFU0nGcf9JiOl.CTBwfTU7osD.umf.gtTBQKr7gxse26a',NULL,'2024-03-26 12:58:53',NULL,'2024-03-26 12:58:53',NULL);
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

-- Dump completed on 2024-05-10 14:26:57
