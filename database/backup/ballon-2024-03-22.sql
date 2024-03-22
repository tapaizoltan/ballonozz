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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft`
--

LOCK TABLES `aircraft` WRITE;
/*!40000 ALTER TABLE `aircraft` DISABLE KEYS */;
INSERT INTO `aircraft` VALUES (1,'Kisrepülő',1,'HA-7652',2,250,'2024-03-05 14:26:10','2024-03-05 15:42:02',NULL),(2,'Kicsi légballon',0,'HA-1234',2,300,'2024-03-05 14:28:16','2024-03-22 10:51:08',NULL),(4,'Közepes légballon',0,'HA-6542',6,650,'2024-03-05 15:45:22','2024-03-22 10:22:13','2024-03-22 10:22:13'),(5,'teszt',1,'ha-3232',2,90,'2024-03-12 14:57:47','2024-03-12 14:58:40','2024-03-12 14:58:40'),(6,'Nagy légballon',0,'HA-765',10,800,'2024-03-22 10:22:47','2024-03-22 10:45:58',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aircraft_location_pilots`
--

LOCK TABLES `aircraft_location_pilots` WRITE;
/*!40000 ALTER TABLE `aircraft_location_pilots` DISABLE KEYS */;
INSERT INTO `aircraft_location_pilots` VALUES (1,'2024-04-18','14:30:00',2,1,1,1,NULL,'2024-03-22 10:31:32'),(2,'2024-04-18','18:00:00',6,1,2,1,'2024-03-08 15:38:26','2024-03-22 10:30:55'),(3,'2024-05-11','08:00:00',6,3,1,1,'2024-03-22 10:32:16','2024-03-22 10:32:16'),(4,'2024-05-11','12:30:00',2,3,4,1,'2024-03-22 10:33:06','2024-03-22 10:35:21'),(5,'2024-05-11','16:00:00',6,3,4,1,'2024-03-22 10:35:55','2024-03-22 10:35:55'),(6,'2024-05-18','08:00:00',6,1,2,0,'2024-03-22 10:36:39','2024-03-22 10:36:39');
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
/*!40000 ALTER TABLE `checkins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adult` int NOT NULL,
  `children` int NOT NULL,
  `vip` tinyint(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `tickettype_id` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,1,'m123456','Meglepkék',2,0,0,0,NULL,0,NULL,NULL),(2,1,'m987654','Meglepkék',2,2,0,0,NULL,0,NULL,NULL),(3,1,'r918273','RH Sound',1,0,1,1,NULL,0,NULL,NULL),(4,1,'RE45678','Egyeb',1,0,1,1,NULL,2,'2024-03-20 10:02:58','2024-03-20 10:02:58'),(8,1,'etwetwetw','Egyéb',2,0,1,1,NULL,1,'2024-03-20 10:27:21','2024-03-20 14:04:36'),(12,1,'dsa343223','Egyéb',1,1,0,1,NULL,1,'2024-03-21 15:17:33','2024-03-21 15:17:33'),(13,1,'dsasd','Egyéb',2,0,0,0,NULL,3,'2024-03-21 16:02:15','2024-03-21 16:02:15');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2024_03_05_074750_create_aircrafts_table',2),(7,'2024_03_05_075315_create_locations_table',3),(8,'2024_03_05_080828_create_pilots_table',4),(9,'2024_03_05_080959_create_aircraft_location_pilots_table',5),(10,'2024_03_05_081104_create_tickettypes_table',6),(11,'2024_03_05_081325_create_tickettype_aircrafts_table',7),(12,'2024_03_05_084152_create_aircraft_table',8),(13,'2024_03_05_084857_create_aircraft_location_pilots_table',9),(14,'2024_03_05_085249_create_tickettype_aircraft_table',10),(17,'2024_03_06_092937_create_area_types_table',11),(23,'2024_03_11_130827_create_tickettype_aircraft_table',12),(25,'2024_03_18_120004_create_coupons_table',13),(26,'2024_03_19_105531_create_passengers_table',14),(27,'2024_03_19_132138_add_field_to_coupons_table',15),(29,'2024_03_19_140228_create_jobs_table',16),(30,'2024_03_19_125745_create_permission_tables',17),(33,'2024_03_19_150033_add_coupon_code_column_to_coupons_table',18),(34,'2024_03_19_155715_add_body_weight_column_to_passengers_table',19),(38,'2024_03_20_091008_add_coupon_id_column_to_passengers_table',20),(40,'2024_03_21_094811_add_tickettype_id_column_to_coupons_table',21),(41,'2024_03_21_095628_create_checkins_table',22);
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
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
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
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL COMMENT 'születési dátum',
  `id_card_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'igazolvány szám',
  `body_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'testsúly',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passengers`
--

LOCK TABLES `passengers` WRITE;
/*!40000 ALTER TABLE `passengers` DISABLE KEYS */;
INSERT INTO `passengers` VALUES (3,8,'Katalin','Tápai','1984-02-09','972232TA','67','2024-03-20 13:01:28','2024-03-20 13:01:28'),(4,8,'Zoltán','Tápai','1979-01-15','987997TZ','103','2024-03-20 13:06:29','2024-03-20 13:06:29'),(5,12,'wtttt','weee','2024-03-21','qre','2','2024-03-22 09:38:10','2024-03-22 09:38:10'),(8,12,'gfdgdfgd','gfdgdg','2024-03-05','dfgdgd','4','2024-03-22 09:43:36','2024-03-22 09:43:36');
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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(2,'view_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(3,'create_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(4,'update_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(5,'restore_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(6,'restore_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(7,'replicate_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(8,'reorder_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(9,'delete_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(10,'delete_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(11,'force_delete_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(12,'force_delete_any_aircraft','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(13,'view_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(14,'view_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(15,'create_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(16,'update_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(17,'restore_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(18,'restore_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(19,'replicate_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(20,'reorder_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(21,'delete_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(22,'delete_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(23,'force_delete_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(24,'force_delete_any_aircraft::location::pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(25,'view_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(26,'view_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(27,'create_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(28,'update_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(29,'restore_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(30,'restore_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(31,'replicate_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(32,'reorder_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(33,'delete_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(34,'delete_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(35,'force_delete_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(36,'force_delete_any_coupon','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(37,'view_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(38,'view_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(39,'create_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(40,'update_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(41,'restore_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(42,'restore_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(43,'replicate_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(44,'reorder_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(45,'delete_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(46,'delete_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(47,'force_delete_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(48,'force_delete_any_location','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(49,'view_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(50,'view_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(51,'create_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(52,'update_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(53,'restore_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(54,'restore_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(55,'replicate_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(56,'reorder_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(57,'delete_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(58,'delete_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(59,'force_delete_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(60,'force_delete_any_passenger','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(61,'view_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(62,'view_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(63,'create_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(64,'update_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(65,'restore_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(66,'restore_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(67,'replicate_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(68,'reorder_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(69,'delete_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(70,'delete_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(71,'force_delete_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(72,'force_delete_any_pilot','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(73,'view_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(74,'view_any_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(75,'create_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(76,'update_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(77,'delete_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(78,'delete_any_role','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(79,'view_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(80,'view_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(81,'create_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(82,'update_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(83,'restore_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(84,'restore_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(85,'replicate_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(86,'reorder_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(87,'delete_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(88,'delete_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(89,'force_delete_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(90,'force_delete_any_tickettype','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(91,'view_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(92,'view_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(93,'create_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(94,'update_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(95,'restore_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(96,'restore_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(97,'replicate_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(98,'reorder_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(99,'delete_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(100,'delete_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(101,'force_delete_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42'),(102,'force_delete_any_user','web','2024-03-19 14:47:42','2024-03-19 14:47:42');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','web','2024-03-19 14:47:42','2024-03-19 14:47:42');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
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
INSERT INTO `tickettype_aircraft` VALUES (2,2),(6,2),(8,2),(3,4),(4,6),(5,6),(7,6),(9,6);
/*!40000 ALTER TABLE `tickettype_aircraft` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettypes`
--

LOCK TABLES `tickettypes` WRITE;
/*!40000 ALTER TABLE `tickettypes` DISABLE KEYS */;
INSERT INTO `tickettypes` VALUES (2,'Felnőtt 2 személyes VIP jegy','Ez egy két személyes VIP repülés','Ballonozz.hu','Hőlégballonozás Szekszárd felett 2 fő részére',2,0,1,0,'2024-03-11 10:03:24','2024-03-22 10:50:07','2024-03-22 10:50:07'),(3,'Felnőtt 3 személyes VIP és PRIVÁT jegy','Ez egy három személyes VIP repülés PRIVÁT ellátással','Ballonozz.hu','Hőlégballonozás Miskolc felett 2 fő részére',2,1,1,1,'2024-03-11 11:25:38','2024-03-22 10:50:15','2024-03-22 10:50:15'),(4,'Gyermek jegy','Gyermek jegyünket 6-14 éves korig tudja egy ifjú titán igénybe venni felnőtt kísérővel.','Ballonozz.hu','Gyermek jegy',0,1,0,0,'2024-03-22 10:40:00','2024-03-22 10:40:16',NULL),(5,'Felnőtt jegy','Gyere és repülj velünk több helyszínünk valamelyikén.\nEz a jegy egy felnőtt repülésre használható fel.','Ballonozz.hu','Felnőtt jegy',1,0,0,0,'2024-03-22 10:41:25','2024-03-22 10:41:25',NULL),(6,'Privát jegy','Repülés a kisebbik verseny ballonunkkal történik.\nA kosárban csak te leszel a pilótával, így az állandó csodálatos kilátás garantált.','Ballonozz.hu','Privát jegy',1,0,0,1,'2024-03-22 10:42:34','2024-03-22 10:42:34',NULL),(7,'Családi csomag','A jegyet összesen 2+2 fő részére használhatod 2 felnőtt és 2 gyermeknek számító 6-14 év közötti fiatal utas bontásban.','Ballonozz.hu','Családi csomag',2,2,0,0,'2024-03-22 10:44:07','2024-03-22 10:44:07',NULL),(8,'VIP páros','VIP páros repülésünk 2 főnek szóló program, ahol egyedülálló, székkel ellátott kosárból élvezhetitek a remek látképet . Rajtatok kívül csak a személyzet fog a kosárban tartózkodni.','Ballonozz.hu','VIP páros',2,0,1,0,'2024-03-22 10:45:10','2024-03-22 10:45:19',NULL),(9,'Csoportos jegy','Csoportos jegyünk esetében maximum 800kg-ig és 10 főig biztosítunk repülést számotokra.','Ballonozz.hu','Csoportos jegy',10,0,0,1,'2024-03-22 10:49:52','2024-03-22 10:49:52',NULL);
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
INSERT INTO `users` VALUES (1,'Admin','admin@admin.hu','2024-03-01 09:00:00','$2y$12$LP5/dG8ZFoKdoztZZ4MeqOMVlK5P7qv7c1xRZweVFG/8fHxcyHXzK',NULL,'2024-03-05 08:34:58','2024-03-05 08:34:58');
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

-- Dump completed on 2024-03-22 12:25:33
