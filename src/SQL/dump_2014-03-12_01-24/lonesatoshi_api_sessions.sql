CREATE DATABASE  IF NOT EXISTS `lonesatoshi` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lonesatoshi`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: localhost    Database: lonesatoshi
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api_sessions`
--

DROP TABLE IF EXISTS `api_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_sessions` (
  `session_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `api_key_id` int(10) unsigned NOT NULL,
  `session_key` varchar(45) NOT NULL,
  `created` datetime NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_sessions`
--

LOCK TABLES `api_sessions` WRITE;
/*!40000 ALTER TABLE `api_sessions` DISABLE KEYS */;
INSERT INTO `api_sessions` VALUES (1,1,'Session_531fa1f21ee8d5.70993896','2014-03-11 23:53:22','2014-03-12 00:23:22'),(2,1,'Session_531fa218b575a0.13191953','2014-03-11 23:54:00','2014-03-12 00:24:00'),(3,1,'Session_531fa21e3feef4.15605645','2014-03-11 23:54:06','2014-03-12 00:24:06'),(4,1,'Session_531fa21ee6fb94.91945219','2014-03-11 23:54:06','2014-03-12 00:24:06'),(5,1,'Session_531fa22e9e6093.27184064','2014-03-11 23:54:22','2014-03-12 00:24:22'),(6,1,'Session_531fa31097de31.54360185','2014-03-11 23:58:08','2014-03-12 00:28:08'),(7,1,'Session_531fa313146867.90542170','2014-03-11 23:58:11','2014-03-12 00:28:11'),(8,1,'Session_531fa313f12385.35791028','2014-03-11 23:58:11','2014-03-12 00:28:11'),(9,1,'Session_531fa316d309f6.62606188','2014-03-11 23:58:14','2014-03-12 00:28:14'),(10,1,'Session_531fa317954ce7.07719850','2014-03-11 23:58:15','2014-03-12 00:28:15'),(11,1,'Session_531fa318389590.90104252','2014-03-11 23:58:16','2014-03-12 00:28:16'),(12,1,'Session_531fa3430ccf84.30989517','2014-03-11 23:58:59','2014-03-12 00:28:59'),(13,1,'Session_531fa3a622fbb8.07186173','2014-03-12 00:00:38','2014-03-12 00:30:38'),(14,1,'Session_531fa3a6eeeda6.31749940','2014-03-12 00:00:38','2014-03-12 01:20:12'),(15,2,'Session_531faff0486e35.48758098','2014-03-12 00:53:04','2014-03-12 01:23:04'),(16,1,'Session_531fb6c7d33951.98182632','2014-03-12 01:22:15','2014-03-12 01:52:15');
/*!40000 ALTER TABLE `api_sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-12  1:24:17
