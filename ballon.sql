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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft`
--

LOCK TABLES `aircraft` WRITE;
/*!40000 ALTER TABLE `aircraft` DISABLE KEYS */;
INSERT INTO `aircraft` VALUES (1,'Kisrepülő',1,'HA-7652',2,250,'2024-03-05 14:26:10','2024-03-05 15:42:02',NULL),(2,'Kicsi légballon',0,'HA-1234',4,400,'2024-03-05 14:28:16','2024-03-05 15:42:28',NULL),(4,'Közepes légballon',0,'HA-6542',6,650,'2024-03-05 15:45:22','2024-03-05 15:45:22',NULL);
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
  `aircraft_id` int unsigned NOT NULL,
  `location_id` int unsigned NOT NULL,
  `pilot_id` int unsigned DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT 'feltöltése enum-ból',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aircraft_location_pilots_aircraft_id_foreign` (`aircraft_id`),
  KEY `aircraft_location_pilots_location_id_foreign` (`location_id`),
  KEY `aircraft_location_pilots_pilot_id_foreign` (`pilot_id`),
  CONSTRAINT `aircraft_location_pilots_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft` (`id`),
  CONSTRAINT `aircraft_location_pilots_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `aircraft_location_pilots_pilot_id_foreign` FOREIGN KEY (`pilot_id`) REFERENCES `pilots` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft_location_pilots`
--

LOCK TABLES `aircraft_location_pilots` WRITE;
/*!40000 ALTER TABLE `aircraft_location_pilots` DISABLE KEYS */;
/*!40000 ALTER TABLE `aircraft_location_pilots` ENABLE KEYS */;
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
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` int DEFAULT NULL,
  `settlement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_type_id` int DEFAULT NULL COMMENT 'feltöltése area_types táblából',
  `address_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parcel_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'helyrajzi szám',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Siófok-Kiliti reptér',8600,'Siófok','Szekszárdi',174,'17','119/43217',NULL,'2024-03-06 14:31:19',NULL),(3,'Békéscsaba Airport',5600,'Békéscsaba','Repülőtéri',174,'13','0296/8/A','2024-03-06 12:56:42','2024-03-06 14:31:02',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2024_03_05_074750_create_aircrafts_table',2),(7,'2024_03_05_075315_create_locations_table',3),(8,'2024_03_05_080828_create_pilots_table',4),(9,'2024_03_05_080959_create_aircraft_location_pilots_table',5),(10,'2024_03_05_081104_create_tickettypes_table',6),(11,'2024_03_05_081325_create_tickettype_aircrafts_table',7),(12,'2024_03_05_084152_create_aircraft_table',8),(13,'2024_03_05_084857_create_aircraft_location_pilots_table',9),(14,'2024_03_05_085249_create_tickettype_aircraft_table',10),(17,'2024_03_06_092937_create_area_types_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pilots`
--

LOCK TABLES `pilots` WRITE;
/*!40000 ALTER TABLE `pilots` DISABLE KEYS */;
INSERT INTO `pilots` VALUES (1,'Zoltán','Tápai','972232TA',NULL,NULL,NULL),(2,'Jakab','Gipsz','PPL-SEP','2024-03-06 14:46:41','2024-03-06 14:46:41',NULL);
/*!40000 ALTER TABLE `pilots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickettype_aircraft`
--

DROP TABLE IF EXISTS `tickettype_aircraft`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickettype_aircraft` (
  `tickettype_id` int unsigned NOT NULL,
  `aircraft_id` int unsigned NOT NULL,
  PRIMARY KEY (`tickettype_id`,`aircraft_id`),
  KEY `tickettype_aircraft_aircraft_id_foreign` (`aircraft_id`),
  CONSTRAINT `tickettype_aircraft_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft` (`id`),
  CONSTRAINT `tickettype_aircraft_tickettype_id_foreign` FOREIGN KEY (`tickettype_id`) REFERENCES `tickettypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettype_aircraft`
--

LOCK TABLES `tickettype_aircraft` WRITE;
/*!40000 ALTER TABLE `tickettype_aircraft` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickettype_aircraft` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickettype_aircrafts`
--

DROP TABLE IF EXISTS `tickettype_aircrafts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickettype_aircrafts` (
  `tickettype_id` int unsigned NOT NULL,
  `aircraft_id` int unsigned NOT NULL,
  PRIMARY KEY (`tickettype_id`,`aircraft_id`),
  KEY `tickettype_aircrafts_aircraft_id_foreign` (`aircraft_id`),
  CONSTRAINT `tickettype_aircrafts_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircrafts` (`id`),
  CONSTRAINT `tickettype_aircrafts_tickettype_id_foreign` FOREIGN KEY (`tickettype_id`) REFERENCES `tickettypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettype_aircrafts`
--

LOCK TABLES `tickettype_aircrafts` WRITE;
/*!40000 ALTER TABLE `tickettype_aircrafts` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickettype_aircrafts` ENABLE KEYS */;
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
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_stored_at_source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adult` int NOT NULL,
  `children` int NOT NULL,
  `vip` tinyint(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettypes`
--

LOCK TABLES `tickettypes` WRITE;
/*!40000 ALTER TABLE `tickettypes` DISABLE KEYS */;
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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@admin.hu',NULL,'$2y$12$LP5/dG8ZFoKdoztZZ4MeqOMVlK5P7qv7c1xRZweVFG/8fHxcyHXzK',NULL,'2024-03-05 08:34:58','2024-03-05 08:34:58');
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

-- Dump completed on 2024-03-07  8:11:46
