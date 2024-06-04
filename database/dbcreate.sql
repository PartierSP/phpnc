-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: nc
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.20.04.1

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
-- Table structure for table `baud`
--

DROP TABLE IF EXISTS `baud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `baud` (
  `baudid` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `baudrate` int unsigned DEFAULT NULL,
  PRIMARY KEY (`baudid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `datasize`
--

DROP TABLE IF EXISTS `datasize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datasize` (
  `sizeid` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `size` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`sizeid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `flowcontrol`
--

DROP TABLE IF EXISTS `flowcontrol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flowcontrol` (
  `flowid` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `flow` char(32) DEFAULT NULL,
  PRIMARY KEY (`flowid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `machines`
--

DROP TABLE IF EXISTS `machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `machines` (
  `machineid` int unsigned NOT NULL AUTO_INCREMENT,
  `name` char(16) DEFAULT NULL,
  `newline` char(3) DEFAULT NULL,
  `sendcomments` tinyint(1) DEFAULT NULL,
  `port` char(20) DEFAULT NULL,
  `baud` tinyint unsigned DEFAULT NULL,
  `parity` tinyint unsigned DEFAULT NULL,
  `datasize` tinyint unsigned DEFAULT NULL,
  `stopsize` tinyint unsigned DEFAULT NULL,
  `flowcontrol` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`machineid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parity`
--

DROP TABLE IF EXISTS `parity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parity` (
  `parityid` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `parity` char(8) DEFAULT NULL,
  PRIMARY KEY (`parityid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programs` (
  `programid` int unsigned NOT NULL AUTO_INCREMENT,
  `name` char(12) DEFAULT NULL,
  `description` char(80) DEFAULT NULL,
  `createddate` date DEFAULT NULL,
  `editeddate` date DEFAULT NULL,
  `machineid` int unsigned DEFAULT NULL,
  `program` mediumtext,
  PRIMARY KEY (`programid`)
) ENGINE=InnoDB AUTO_INCREMENT=2593 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stopsize`
--

DROP TABLE IF EXISTS `stopsize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stopsize` (
  `stopid` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `stop` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`stopid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-03 20:50:40
