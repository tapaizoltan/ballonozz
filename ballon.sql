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
-- Dumping data for table `aircraft`
--

LOCK TABLES `aircraft` WRITE;
/*!40000 ALTER TABLE `aircraft` DISABLE KEYS */;
INSERT INTO `aircraft` VALUES (1,'Kisrepülő',1,'HA-7652',2,250,'2024-03-05 14:26:10','2024-03-05 15:42:02',NULL),(2,'Kicsi légballon',0,'HA-1234',4,400,'2024-03-05 14:28:16','2024-03-05 15:42:28',NULL),(4,'Közepes légballon',0,'HA-6542',6,650,'2024-03-05 15:45:22','2024-03-18 08:36:47',NULL),(5,'teszt',1,'ha-3232',2,90,'2024-03-12 14:57:47','2024-03-12 14:58:40','2024-03-12 14:58:40');
/*!40000 ALTER TABLE `aircraft` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `aircraft_location_pilots`
--

LOCK TABLES `aircraft_location_pilots` WRITE;
/*!40000 ALTER TABLE `aircraft_location_pilots` DISABLE KEYS */;
INSERT INTO `aircraft_location_pilots` VALUES (1,'2024-03-13','14:39:20',1,1,1,0,NULL,'2024-03-18 08:31:33'),(2,'2024-03-09','06:00:00',1,1,2,1,'2024-03-08 15:38:26','2024-03-11 17:42:12');
/*!40000 ALTER TABLE `aircraft_location_pilots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `area_types`
--

LOCK TABLES `area_types` WRITE;
/*!40000 ALTER TABLE `area_types` DISABLE KEYS */;
INSERT INTO `area_types` VALUES (1,'akna'),(2,'akna-alsó'),(3,'akna-felső'),(4,'alagút'),(5,'alsórakpart'),(6,'arborétum'),(7,'autóút'),(8,'barakképület'),(9,'barlang'),(10,'bejáró'),(11,'bekötőút'),(12,'bánya'),(13,'bányatelep'),(14,'bástya'),(15,'bástyája'),(16,'csárda'),(17,'csónakházak'),(18,'domb'),(19,'dűlő'),(20,'dűlők'),(21,'dűlősor'),(22,'dűlőterület'),(23,'dűlőút'),(24,'egyetemváros'),(25,'egyéb'),(26,'elágazás'),(27,'emlékút'),(28,'erdészház'),(29,'erdészlak'),(30,'erdő'),(31,'erdősor'),(32,'fasor'),(33,'fasora'),(34,'felső'),(35,'forduló'),(36,'főmérnökség'),(37,'főtér'),(38,'főút'),(39,'föld'),(40,'gyár'),(41,'gyártelep'),(42,'gyárváros'),(43,'gyümölcsös'),(44,'gát'),(45,'gátsor'),(46,'gátőrház'),(47,'határsor'),(48,'határút'),(49,'hegy'),(50,'hegyhát'),(51,'hegyhát dűlő'),(52,'hegyhát'),(53,'köz'),(54,'hrsz'),(55,'hrsz.'),(56,'ház'),(57,'hídfő'),(58,'iskola'),(59,'játszótér'),(60,'kapu'),(61,'kastély'),(62,'kert'),(63,'kertsor'),(64,'kerület'),(65,'kilátó'),(66,'kioszk'),(67,'kocsiszín'),(68,'kolónia'),(69,'korzó'),(70,'kultúrpark'),(71,'kunyhó'),(72,'kör'),(73,'körtér'),(74,'körvasútsor'),(75,'körzet'),(76,'körönd'),(77,'körút'),(78,'köz'),(79,'kút'),(80,'kültelek'),(81,'lakóház'),(82,'lakókert'),(83,'lakónegyed'),(84,'lakópark'),(85,'lakótelep'),(86,'lejtő'),(87,'lejáró'),(88,'liget'),(89,'lépcső'),(90,'major'),(91,'malom'),(92,'menedékház'),(93,'munkásszálló'),(94,'mélyút'),(95,'műút'),(96,'oldal'),(97,'orom'),(98,'park'),(99,'parkja'),(100,'parkoló'),(101,'part'),(102,'pavilon'),(103,'piac'),(104,'pihenő'),(105,'pince'),(106,'pincesor'),(107,'postafiók'),(108,'puszta'),(109,'pálya'),(110,'pályaudvar'),(111,'rakpart'),(112,'repülőtér'),(113,'rész'),(114,'rét'),(115,'sarok'),(116,'sor'),(117,'sora'),(118,'sportpálya'),(119,'sporttelep'),(120,'stadion'),(121,'strandfürdő'),(122,'sugárút'),(123,'szer'),(124,'sziget'),(125,'szivattyútelep'),(126,'szállás'),(127,'szállások'),(128,'szél'),(129,'szőlő'),(130,'szőlőhegy'),(131,'szőlők'),(132,'sánc'),(133,'sávház'),(134,'sétány'),(135,'tag'),(136,'tanya'),(137,'tanyák'),(138,'telep'),(139,'temető'),(140,'tere'),(141,'tető'),(142,'turistaház'),(143,'téli kikötő'),(144,'tér'),(145,'tömb'),(146,'udvar'),(147,'utak'),(148,'utca'),(149,'utcája'),(150,'vadaskert'),(151,'vadászház'),(152,'vasúti megálló'),(153,'vasúti őrház'),(154,'vasútsor'),(155,'vasútállomás'),(156,'vezetőút'),(157,'villasor'),(158,'vágóhíd'),(159,'vár'),(160,'várköz'),(161,'város'),(162,'vízmű'),(163,'völgy'),(164,'zsilip'),(165,'zug'),(166,'állat és növ.kert'),(167,'állomás'),(168,'árnyék'),(169,'árok'),(170,'átjáró'),(171,'őrház'),(172,'őrházak'),(173,'őrházlak'),(174,'út'),(175,'útja'),(176,'útőrház'),(177,'üdülő'),(178,'üdülő-part'),(179,'üdülő-sor'),(180,'üdülő-telep');
/*!40000 ALTER TABLE `area_types` ENABLE KEYS */;
UNLOCK TABLES;

-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'m123456','Meglepkék',2,0,0,0,0,NULL,NULL),(2,'m987654','Meglepkék',2,2,0,0,0,NULL,NULL),(3,'rh456456','RH Sound',1,0,1,0,0,NULL,NULL);
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Siófok-Kiliti reptér',8600,'Siófok','Szekszárdi',174,'17','119/43217',NULL,'2024-03-06 14:31:19',NULL),(3,'Békéscsaba Airport',5600,'Békéscsaba','Repülőtéri',174,'13','0296/8/A','2024-03-06 12:56:42','2024-03-06 14:31:02',NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pilots`
--

LOCK TABLES `pilots` WRITE;
/*!40000 ALTER TABLE `pilots` DISABLE KEYS */;
INSERT INTO `pilots` VALUES (1,'Zoltán','Tápai','972232TA',NULL,NULL,NULL),(2,'Jakab','Gipsz','PPL-SEP','2024-03-06 14:46:41','2024-03-06 14:46:41',NULL);
/*!40000 ALTER TABLE `pilots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tickettype_aircraft`
--

LOCK TABLES `tickettype_aircraft` WRITE;
/*!40000 ALTER TABLE `tickettype_aircraft` DISABLE KEYS */;
INSERT INTO `tickettype_aircraft` VALUES (2,1),(2,2),(2,4),(3,4);
/*!40000 ALTER TABLE `tickettype_aircraft` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tickettypes`
--

LOCK TABLES `tickettypes` WRITE;
/*!40000 ALTER TABLE `tickettypes` DISABLE KEYS */;
INSERT INTO `tickettypes` VALUES (2,'Felnőtt 2 személyes VIP jegy','Ez egy két személyes VIP repülés','Meglepkék','Hőlégballonozás Szekszárd felett 2 fő részére',2,0,1,0,'2024-03-11 10:03:24','2024-03-11 10:03:24',NULL),(3,'Felnőtt 3 személyes VIP és PRIVÁT jegy','Ez egy három személyes VIP repülés PRIVÁT ellátással','Meglepkék','Hőlégballonozás Miskolc felett 2 fő részére',2,1,1,1,'2024-03-11 11:25:38','2024-03-11 11:25:38',NULL);
/*!40000 ALTER TABLE `tickettypes` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2024-03-19 11:33:35
