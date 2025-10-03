mysqldump: [Warning] Using a password on the command line interface can be insecure.
-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: dinolabs_portal
-- ------------------------------------------------------
-- Server version	8.0.42-cll-lve

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
mysqldump: Error: 'Access denied; you need (at least one of) the PROCESS privilege(s) for this operation' when trying to dump tablespaces

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` varchar(111) NOT NULL,
  `fullname` varchar(111) NOT NULL,
  `subject` varchar(111) NOT NULL,
  `mobile` varchar(111) NOT NULL,
  `email` varchar(111) NOT NULL,
  `pass` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arm`
--

DROP TABLE IF EXISTS `arm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `arm` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arm`
--

LOCK TABLES `arm` WRITE;
/*!40000 ALTER TABLE `arm` DISABLE KEYS */;
INSERT INTO `arm` VALUES (1,'A'),(2,'B'),(3,'C'),(4,'D');
/*!40000 ALTER TABLE `arm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES (1,'Computer Studies','JSS 1','Computer_Studies_JSS_1.docx');
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `class` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `arm` varchar(5) COLLATE utf8mb3_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `term_id` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `session_id` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL COMMENT '1=Present, 0=Absent',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_attendance` (`student_id`,`class`,`arm`,`date`,`term_id`,`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'21','SUSAN DAVIS','SS 2','D','2025-07-20','1st Term','2024/2025',1,'2025-07-21 12:40:14'),(2,'42','TINA BLAIR','SS 2','D','2025-07-20','1st Term','2024/2025',0,'2025-07-21 12:40:14'),(3,'21','SUSAN DAVIS','SS 2','D','2025-07-21','1st Term','2024/2025',1,'2025-07-21 12:44:33'),(4,'42','TINA BLAIR','SS 2','D','2025-07-21','1st Term','2024/2025',0,'2025-07-21 12:44:33'),(5,'234123','Abigail Oyinlola','SS 2','D','2025-07-21','1st Term','2024/2025',1,'2025-07-21 14:56:05'),(6,'0588d91d','2024-07-08','0','0','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:09'),(7,'8bc88bcf','2024-07-08','0','0','2025-08-20','1st Term','2024/2025',0,'2025-08-20 15:44:09'),(8,'52631db9','2024-07-09','0','0','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:09'),(9,'e02a35e9','2024-07-09','0','0','2025-08-20','1st Term','2024/2025',0,'2025-08-20 15:44:09'),(10,'139','AMANDA ADAMS','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(11,'57','ASHLEY THOMAS','JSS 2','A','2025-08-20','1st Term','2024/2025',0,'2025-08-20 15:44:54'),(12,'48','CHRISTOPHER ORTIZ','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(13,'128','JEREMY WILSON','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(14,'15','JOHN GUERRERO','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(15,'107','MADELINE CONLEY','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(16,'127','MATTHEW WATKINS','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(17,'1000','Oyin Lola','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(18,'152','ROBERT POWERS','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(19,'65','SAMANTHA LEBLANC','JSS 2','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:44:54'),(20,'115','ANGEL KANE','JSS 1','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:45:58'),(21,'1050','ayo james','JSS 1','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:45:58'),(22,'129','EDWARD JEFFERSON','JSS 1','A','2025-08-20','1st Term','2024/2025',0,'2025-08-20 15:45:58'),(23,'102','JOSEPH WRIGHT','JSS 1','A','2025-08-20','1st Term','2024/2025',0,'2025-08-20 15:45:58'),(24,'112','KAREN HALL','JSS 1','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:45:58'),(25,'200','KAYLA ROGERS','JSS 1','A','2025-08-20','1st Term','2024/2025',0,'2025-08-20 15:45:58'),(26,'125','PAULA RICHARDSON','JSS 1','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:45:58'),(27,'76','SUE YOUNG','JSS 1','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:45:58'),(28,'69','SUSAN GOODMAN','JSS 1','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:45:58'),(29,'142','TAMMY HALL','JSS 1','A','2025-08-20','1st Term','2024/2025',1,'2025-08-20 15:45:58');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bills` (
  `productID` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `productname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `unitprice` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `totalamt` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `invoiceno` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `billdate` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `profit` varchar(222) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills1`
--

DROP TABLE IF EXISTS `bills1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bills1` (
  `productID` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `productname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `unitprice` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `totalamt` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `invoiceno` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `billdate` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `profit` varchar(222) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills1`
--

LOCK TABLES `bills1` WRITE;
/*!40000 ALTER TABLE `bills1` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills2`
--

DROP TABLE IF EXISTS `bills2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bills2` (
  `productID` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `productname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `unitprice` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `totalamt` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `invoiceno` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `billdate` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `profit` varchar(222) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills2`
--

LOCK TABLES `bills2` WRITE;
/*!40000 ALTER TABLE `bills2` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills3`
--

DROP TABLE IF EXISTS `bills3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bills3` (
  `productID` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `productname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `unitprice` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `totalamt` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `invoiceno` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `billdate` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `profit` varchar(222) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills3`
--

LOCK TABLES `bills3` WRITE;
/*!40000 ALTER TABLE `bills3` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bursary`
--

DROP TABLE IF EXISTS `bursary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bursary` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `hostel` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `fee` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `paid` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `outstanding` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bursary`
--

LOCK TABLES `bursary` WRITE;
/*!40000 ALTER TABLE `bursary` DISABLE KEYS */;
/*!40000 ALTER TABLE `bursary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` VALUES (3,'08/25/2025','Cultural Week','next week is our cultural week ');
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capacity`
--

DROP TABLE IF EXISTS `capacity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capacity` (
  `id` int NOT NULL AUTO_INCREMENT,
  `volume` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capacity`
--

LOCK TABLES `capacity` WRITE;
/*!40000 ALTER TABLE `capacity` DISABLE KEYS */;
INSERT INTO `capacity` VALUES (1,'50');
/*!40000 ALTER TABLE `capacity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cbtadmin`
--

DROP TABLE IF EXISTS `cbtadmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cbtadmin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(111) NOT NULL,
  `arm` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  `testdate` varchar(111) NOT NULL,
  `testtime` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cbtadmin`
--

LOCK TABLES `cbtadmin` WRITE;
/*!40000 ALTER TABLE `cbtadmin` DISABLE KEYS */;
INSERT INTO `cbtadmin` VALUES (1,'SS 2','D','1st Term','2024/2025','2025-07-22',5),(2,'SS 2','D','1st Term','2024/2025','2025-07-22',5),(4,'JSS 1','A','1st Term','2024/2025','2025-08-21',20),(5,'JSS 1','A','1st Term','2024/2025','2025-08-21',80);
/*!40000 ALTER TABLE `cbtadmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (1,'JSS 1'),(2,'JSS 2'),(3,'JSS 3'),(4,'SS 1'),(5,'SS 2'),(6,'SS 3');
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classcomments`
--

DROP TABLE IF EXISTS `classcomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classcomments` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `comment` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `schlopen` int NOT NULL,
  `dayspresent` int NOT NULL,
  `daysabsent` int NOT NULL,
  `attentiveness` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `neatness` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `politeness` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `selfcontrol` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `punctuality` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `relationship` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `handwriting` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `music` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `club` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `sport` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `csession` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classcomments`
--

LOCK TABLES `classcomments` WRITE;
/*!40000 ALTER TABLE `classcomments` DISABLE KEYS */;
/*!40000 ALTER TABLE `classcomments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classteacher`
--

DROP TABLE IF EXISTS `classteacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classteacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classteacher`
--

LOCK TABLES `classteacher` WRITE;
/*!40000 ALTER TABLE `classteacher` DISABLE KEYS */;
/*!40000 ALTER TABLE `classteacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `hostel` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `total_amount` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currency` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rate` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currentsession`
--

DROP TABLE IF EXISTS `currentsession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currentsession` (
  `id` int NOT NULL AUTO_INCREMENT,
  `csession` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `regyr` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currentsession`
--

LOCK TABLES `currentsession` WRITE;
/*!40000 ALTER TABLE `currentsession` DISABLE KEYS */;
INSERT INTO `currentsession` VALUES (1,'2024/2025','25');
/*!40000 ALTER TABLE `currentsession` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currentterm`
--

DROP TABLE IF EXISTS `currentterm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currentterm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cterm` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currentterm`
--

LOCK TABLES `currentterm` WRITE;
/*!40000 ALTER TABLE `currentterm` DISABLE KEYS */;
INSERT INTO `currentterm` VALUES (1,'1st Term');
/*!40000 ALTER TABLE `currentterm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curriculum`
--

DROP TABLE IF EXISTS `curriculum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curriculum` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curriculum`
--

LOCK TABLES `curriculum` WRITE;
/*!40000 ALTER TABLE `curriculum` DISABLE KEYS */;
/*!40000 ALTER TABLE `curriculum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee`
--

DROP TABLE IF EXISTS `fee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fee` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `service` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `hostel` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee`
--

LOCK TABLES `fee` WRITE;
/*!40000 ALTER TABLE `fee` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
INSERT INTO `fees` VALUES (1,1,'Tuition',153500),(2,1,'PTA fees',5000),(3,1,'Others',25000),(4,2,'Tuition fees ',75000);
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `firstcum`
--

DROP TABLE IF EXISTS `firstcum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `firstcum` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `ca1` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `ca2` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `exam` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `lastcum` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `average` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `csession` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `firstcum`
--

LOCK TABLES `firstcum` WRITE;
/*!40000 ALTER TABLE `firstcum` DISABLE KEYS */;
/*!40000 ALTER TABLE `firstcum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `license`
--

DROP TABLE IF EXISTS `license`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `license` (
  `id` int NOT NULL AUTO_INCREMENT,
  `license` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `license`
--

LOCK TABLES `license` WRITE;
/*!40000 ALTER TABLE `license` DISABLE KEYS */;
/*!40000 ALTER TABLE `license` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `staffname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'Dinolabs Superuser','Dinolabs','dinolabs','Superuser'),(2,'Ogunmola Abigail','admin','admin','Administrator'),(4,'Yinka','yinka','yinka','Administrator'),(5,'Ayo','ayo','ayo','Administrator');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail`
--

DROP TABLE IF EXISTS `mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `from_user` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `to_user` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail`
--

LOCK TABLES `mail` WRITE;
/*!40000 ALTER TABLE `mail` DISABLE KEYS */;
INSERT INTO `mail` VALUES (1,'Pay up','','2','234123',1,'2025-07-22 08:59:17'),(2,'Re: Pay up','<p>I weill pay up ma, my parents are trying really hard to gather the remaining money ma</p>','234123','2',1,'2025-07-22 09:01:01'),(3,'Test','<p>This is a test message&nbsp;</p>','1','234123',1,'2025-08-21 13:30:53'),(4,'Donation ','<p>I will be donating the sum of&nbsp; #20,000,000 to school, for redevelopment&nbsp;</p>','6','234123',1,'2025-08-21 13:31:36'),(5,'Oay','<p>You know&nbsp;</p>','2','1',1,'2025-08-21 13:32:21'),(6,'Re: Oay','<p>This is my reply&nbsp;</p>','1','2',1,'2025-08-21 13:34:23'),(7,'Re: Donation ','<p>thank you maaaa</p>','234123','6',1,'2025-08-21 13:34:58'),(8,'Okay','I sent you 2m check your balance now ','2','234123',0,'2025-08-21 13:35:10'),(9,'Donation ','<p>I will be donating the sum of&nbsp; #20,000,000 to school, for redevelopment&nbsp;</p>','6','234123',0,'2025-08-21 13:35:14'),(10,'Re: Re: Donation ','<p>You are welcome&nbsp;</p>','6','234123',0,'2025-08-21 13:37:19');
/*!40000 ALTER TABLE `mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mastersheet`
--

DROP TABLE IF EXISTS `mastersheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mastersheet` (
  `id` varchar(111) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(222) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ca1` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ca2` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastcum` int NOT NULL,
  `total` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `average` varchar(111) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(222) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(222) COLLATE utf8mb4_unicode_ci NOT NULL,
  `csession` varchar(222) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(222) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arm` varchar(222) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(111) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(222) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mastersheet`
--

LOCK TABLES `mastersheet` WRITE;
/*!40000 ALTER TABLE `mastersheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `mastersheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_list`
--

DROP TABLE IF EXISTS `message_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conversation_id` int NOT NULL,
  `from_user` int NOT NULL,
  `to_user` int NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `conversation_id` (`conversation_id`),
  KEY `from_user` (`from_user`),
  KEY `to_user` (`to_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_list`
--

LOCK TABLES `message_list` WRITE;
/*!40000 ALTER TABLE `message_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `message` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitoring`
--

DROP TABLE IF EXISTS `monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitoring` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `narration` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `fee` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `paid` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `outstanding` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `transdate` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `staff` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitoring`
--

LOCK TABLES `monitoring` WRITE;
/*!40000 ALTER TABLE `monitoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `monitoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_question`
--

DROP TABLE IF EXISTS `mst_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_question` (
  `que_id` int NOT NULL,
  `test_id` int DEFAULT NULL,
  `que_desc` varchar(2000) DEFAULT NULL,
  `ans1` varchar(75) DEFAULT NULL,
  `ans2` varchar(75) DEFAULT NULL,
  `ans3` varchar(75) DEFAULT NULL,
  `ans4` varchar(75) DEFAULT NULL,
  `true_ans` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_question`
--

LOCK TABLES `mst_question` WRITE;
/*!40000 ALTER TABLE `mst_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_result`
--

DROP TABLE IF EXISTS `mst_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_result` (
  `login` varchar(20) DEFAULT NULL,
  `subject` varchar(111) DEFAULT NULL,
  `test_date` varchar(111) DEFAULT NULL,
  `score` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_result`
--

LOCK TABLES `mst_result` WRITE;
/*!40000 ALTER TABLE `mst_result` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_useranswer`
--

DROP TABLE IF EXISTS `mst_useranswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_useranswer` (
  `sess_id` varchar(80) DEFAULT NULL,
  `subject` varchar(111) DEFAULT NULL,
  `que_des` varchar(200) DEFAULT NULL,
  `ans1` varchar(50) DEFAULT NULL,
  `ans2` varchar(50) DEFAULT NULL,
  `ans3` varchar(50) DEFAULT NULL,
  `ans4` varchar(50) DEFAULT NULL,
  `true_ans` int DEFAULT NULL,
  `your_ans` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_useranswer`
--

LOCK TABLES `mst_useranswer` WRITE;
/*!40000 ALTER TABLE `mst_useranswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_useranswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nextterm`
--

DROP TABLE IF EXISTS `nextterm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nextterm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `term` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Next` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nextterm`
--

LOCK TABLES `nextterm` WRITE;
/*!40000 ALTER TABLE `nextterm` DISABLE KEYS */;
INSERT INTO `nextterm` VALUES (1,'1st Term','2024/2025','12/09/2025');
/*!40000 ALTER TABLE `nextterm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,'Maths ','JSS 2','Maths__JSS_2.csv'),(2,'Basic technology ','JSS 1','Basic_technology__JSS_1.doc');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notices`
--

DROP TABLE IF EXISTS `notices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notices`
--

LOCK TABLES `notices` WRITE;
/*!40000 ALTER TABLE `notices` DISABLE KEYS */;
INSERT INTO `notices` VALUES (2,'Heyyy','This is a notice sent to all parents','2025-08-21 12:19:51');
/*!40000 ALTER TABLE `notices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent`
--

LOCK TABLES `parent` WRITE;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
INSERT INTO `parent` VALUES (6,'him james','0829876426','','','Him','him'),(7,'DINO','08137726887','','','dino','dino');
/*!40000 ALTER TABLE `parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_student`
--

DROP TABLE IF EXISTS `parent_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parent_student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL,
  `student_id` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `parent_student_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`id`),
  CONSTRAINT `parent_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_student`
--

LOCK TABLES `parent_student` WRITE;
/*!40000 ALTER TABLE `parent_student` DISABLE KEYS */;
INSERT INTO `parent_student` VALUES (9,7,'1000'),(10,7,'234123'),(13,6,'00d3d1af');
/*!40000 ALTER TABLE `parent_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ef_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` float NOT NULL,
  `remarks` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thread_id` int NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (5,5,'<p>You better be there</p>','Ogunmola Abigail','2025-08-21 12:48:29');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prebursary`
--

DROP TABLE IF EXISTS `prebursary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prebursary` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `depositor` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `narration` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prebursary`
--

LOCK TABLES `prebursary` WRITE;
/*!40000 ALTER TABLE `prebursary` DISABLE KEYS */;
/*!40000 ALTER TABLE `prebursary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `principalcomments`
--

DROP TABLE IF EXISTS `principalcomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `principalcomments` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `comment` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `csession` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `principalcomments`
--

LOCK TABLES `principalcomments` WRITE;
/*!40000 ALTER TABLE `principalcomments` DISABLE KEYS */;
/*!40000 ALTER TABLE `principalcomments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `productid` int NOT NULL AUTO_INCREMENT,
  `productname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `unitprice` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `sellprice` int NOT NULL,
  `qty` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `total` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `reorder_level` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `reorder_qty` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `profit` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Cabin Biscuits','Akure','80',120,'49','5880','this biscuit is very sweet and fantastic','5','25','40'),(2,'ATV bulb 5watts ','Akure ','5000',5500,'33','181500','','5','20','500');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promote`
--

DROP TABLE IF EXISTS `promote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promote` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `comment` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `csession` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promote`
--

LOCK TABLES `promote` WRITE;
/*!40000 ALTER TABLE `promote` DISABLE KEYS */;
INSERT INTO `promote` VALUES ('1050','ayo james','Repeat','JSS 1','A','1st Term','2024/2025'),('102','JOSEPH WRIGHT','Repeat','JSS 1','A','1st Term','2024/2025'),('234123','Abigail Oyinlola','Repeat','SS 2','D','1st Term','2024/2025'),('10','ERIC JOHNSON','Promoted on Trial','SS 2','D','1st Term','2024/2025');
/*!40000 ALTER TABLE `promote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ques`
--

DROP TABLE IF EXISTS `ques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ques` (
  `id` int NOT NULL,
  `question` varchar(1111) NOT NULL,
  `opt1` varchar(111) NOT NULL,
  `opt2` varchar(111) NOT NULL,
  `opt3` varchar(111) NOT NULL,
  `opt4` varchar(111) NOT NULL,
  `answer` varchar(111) NOT NULL,
  `class` varchar(111) NOT NULL,
  `arm` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `subject` varchar(111) NOT NULL,
  `photo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ques`
--

LOCK TABLES `ques` WRITE;
/*!40000 ALTER TABLE `ques` DISABLE KEYS */;
/*!40000 ALTER TABLE `ques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question` (
  `que_id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(111) NOT NULL,
  `que_desc` varchar(2000) NOT NULL,
  `ans1` varchar(75) NOT NULL,
  `ans2` varchar(75) NOT NULL,
  `ans3` varchar(75) NOT NULL,
  `ans4` varchar(75) NOT NULL,
  `true_ans` varchar(1) NOT NULL,
  `class` varchar(111) NOT NULL,
  `arm` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  PRIMARY KEY (`que_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (11,'Computer Studies','<p>What is a cat</p>','<p>You</p>','<p>She</p>','<p>Him</p>','<p>Me</p>','4','JSS 1','A','1st Term','2024/2025'),(12,'Computer Studies','<p>Full meaning of HTML&nbsp;</p>','<p>Hypotext Markup language&nbsp;</p>','<p>hypertext markup language&nbsp;</p>','<p>hypotext makeup language</p>','<p>hypertext makeup language&nbsp;</p>','2','JSS 1','A','1st Term','2024/2025'),(7,'English Lang','<p>is turkey a food or a country</p>','<p>food</p>','<p>country</p>','<p>both</p>','<p>none of the above</p>','3','SS 2','D','1st Term','2024/2025'),(8,'Computer Studies','<p>What is the full meaning of HTML?</p>','<p>Hyper Time markup Language&nbsp;</p>','<p>Hyper Text Markup Language&nbsp;</p>','<p>Hyped Markup Language&nbsp;</p>','<p>Howdy markup Language&nbsp;</p>','2','JSS 1','A','3rd Term','2024/2025'),(10,'Computer Studies','<p>what is school&nbsp;</p>','<p>Me</p>','<p>You</p>','<p>Us</p>','<p>Them</p>','3','JSS 1','A','1st Term','2024/2025'),(13,'Computer Studies','<p>If told has a ball in hat does that make him&nbsp;</p>','<p>A fool</p>','<p>A weirdo</p>','<p>An addict</p>','<p>All of the above&nbsp;</p>','4','JSS 1','A','1st Term','2024/2025'),(14,'Computer Studies','<p>what brand produces iPhone?</p>','<p>Apple</p>','<p>Banana</p>','<p>Tecno</p>','<p>Hauwei</p>','1','JSS 1','A','1st Term','2024/2025'),(15,'Computer Studies','<p>Are you ___ crazy</p>','<p>&nbsp;Yes i\'m&nbsp;</p>','<p>No I\'m&nbsp;</p>','<p>Only a&nbsp;</p>','<p>All of the above&nbsp;</p>','4','JSS 1','A','1st Term','2024/2025'),(16,'Basic technology ','<p>what\'s the color of clayey sand</p>','<p>goldish brown</p>','<p>brown</p>','<p>black</p>','<p>blue</p>','1','JSS 1','A','1st Term','2024/2025'),(17,'Computer Studies','<p>_____ is a Goat</p>','<p>Ronaldo</p>','<p>You</p>','<p>me</p>','<p>Them</p>','1','JSS 1','A','1st Term','2024/2025');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipt`
--

DROP TABLE IF EXISTS `receipt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receipt` (
  `rproduct` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `rqty` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `rprice` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `rtotal` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `invoice` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipt`
--

LOCK TABLES `receipt` WRITE;
/*!40000 ALTER TABLE `receipt` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regno`
--

DROP TABLE IF EXISTS `regno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sindex` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `sno` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `syear` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regno`
--

LOCK TABLES `regno` WRITE;
/*!40000 ALTER TABLE `regno` DISABLE KEYS */;
/*!40000 ALTER TABLE `regno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `result` (
  `id` varchar(111) NOT NULL,
  `name` varchar(111) NOT NULL,
  `subject` varchar(111) NOT NULL,
  `class` varchar(111) NOT NULL,
  `arm` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  `totalques` int NOT NULL,
  `attemptedques` int NOT NULL,
  `rightanswers` int NOT NULL,
  `marksobtained` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `result`
--

LOCK TABLES `result` WRITE;
/*!40000 ALTER TABLE `result` DISABLE KEYS */;
/*!40000 ALTER TABLE `result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secondcum`
--

DROP TABLE IF EXISTS `secondcum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secondcum` (
  `id` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `ca1` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `ca2` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `exam` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `lastcum` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `average` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `csession` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(111) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secondcum`
--

LOCK TABLES `secondcum` WRITE;
/*!40000 ALTER TABLE `secondcum` DISABLE KEYS */;
/*!40000 ALTER TABLE `secondcum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_no` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_ef_list`
--

DROP TABLE IF EXISTS `student_ef_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_ef_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `ef_no` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `course_id` int NOT NULL,
  `total_fee` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_ef_list`
--

LOCK TABLES `student_ef_list` WRITE;
/*!40000 ALTER TABLE `student_ef_list` DISABLE KEYS */;
INSERT INTO `student_ef_list` VALUES (1,'1','1',1,183500,'2025-07-22 08:43:59'),(3,'3','3',2,75000,'2025-08-21 20:23:40');
/*!40000 ALTER TABLE `student_ef_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `dob` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `placeob` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `studentmobile` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `religion` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `lga` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `schoolname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `schooladdress` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `hobbies` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `lastclass` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `sickle` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `challenge` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `emergency` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `familydoc` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `docaddress` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `docmobile` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `polio` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `tuberculosis` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `measles` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `tetanus` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `whooping` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `gname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `goccupation` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `gaddress` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `grelationship` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `hostel` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `bloodtype` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `bloodgroup` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `height` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `weight` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `photo` blob NOT NULL,
  `status` int NOT NULL,
  `password` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `result` int NOT NULL COMMENT '0 = allow\r\n1 = revoke',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES ('1','Laura Roberson','Female','01/01/1970','Susanside','49247 Miller WellsValeriemouth, ID 54546','493.004.4191x0985','justindavis@ray.com','Islam','Abia','Okitipupa','JSS 1','B','2022/2023','1st Term','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','BASIC 2','No','None','Yes','Susan Cooper','78995 Jon ShoresBellmouth, VA 90842','+1-517-594-1975x9076','Yes','No','Yes','No','No','Martin Reid','+1-788-212-1117x6776','Farmer','947 Johnathan GlenNorth Christinefurt, NH 95241','Mother','Day','AA','A+','1.41','44.6','',0,'1234',0),('10','Michael Lee','Male','39695','South Ashleystad','339 Michael Roads Suite 759\nRyanberg, LA 79752','001-444-686-0574x167','kenneth28@pierce-martinez.com','Christianity','Ondo State','Akoko North-West','SS1','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','Yes','None','(905)214-4908','Gabriel Ewing','57432 Johnson Alley Suite 084\nZamoraview, PA 75181','216.228.9041x670','Yes','No','Yes','Yes','No','Angela Clarke','+1-142-422-9954x124','Doctor','0693 William Corner Suite 816\nJustinshire, MS 87189','Uncle','No','A+','AA','1.86','80.4','',0,'1234',0),('100','Ashley Bauer','Female','41866','New Carl','583 Christopher Well Suite 529\nPort Jonathantown, SD 47442','403-818-2545x20052','lucasmelissa@galvan.com','Christianity','Ondo State','Ifedore','JSS2','A','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','No','Asthma','629.894.0789x83245','Elizabeth Friedman','4195 Mccormick Roads\nPort William, MD 89884','666-184-6342x885','No','Yes','No','Yes','Yes','Monica Mayo','415.334.3847','Doctor','Unit 3279 Box 8021\nDPO AA 79993','Uncle','Yes','B+','SS','1.64','53','',0,'1234',0),('101','Dennis Brown','Male','40451','Dennishaven','337 Thomas Common\nWest Kayla, NY 00926','001-395-921-9833','uhall@gmail.com','Islam','Ondo State','Okitipupa','SS3','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','Yes','Asthma','+1-451-009-9121x847','Barbara Wright','893 Jeff Islands\nPort Sara, TN 89014','044-710-5607','No','Yes','No','No','No','Taylor Cantrell','+1-845-064-4006x6221','Trader','6584 Rogers Flats Apt. 992\nWilliamschester, SD 93410','Sister','Yes','B-','AA','1.8','48.7','',0,'1234',0),('102','Joseph Obrien','Male','41576','Port Matthew','58408 Miguel Stravenue Suite 478\nRoyfurt, WI 09157','2134810794','gregorygeorge@morris.com','Islam','Ondo State','Akoko North-East','JSS2','B','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','Yes','None','079.693.1583x20996','Travis Flowers','541 Thompson Meadow Apt. 040\nEast Holly, LA 11929','(966)317-4642x2142','No','Yes','No','No','No','Justin Harding','+1-072-144-7639x056','Trader','180 Mark Plains Suite 268\nDiazshire, MA 14854','Mother','Yes','B-','SS','1.4','50.8','',0,'1234',0),('103','Michael Nelson','Male','40541','Lake Lori','64476 Burns Orchard\nAmandachester, NH 84878','001-652-210-4254x4724','christine21@perkins.com','Christianity','Ondo State','Akoko North-East','SS3','B','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','Yes','Sight issues','(408)216-4029','Anita Gonzales','54190 David Drives Suite 267\nHollytown, MS 40556','425.974.0962','No','No','No','No','Yes','Kim Barrett','3060230836','Civil Servant','6558 Smith Flats Apt. 035\nPort Emily, MA 32238','Sister','Yes','B+','SS','1.58','64.4','',0,'1234',0),('104','Madison Russell','Female','39203','South Mark','USNV Jones\nFPO AE 86489','001-191-982-1295x4949','daniel55@johnson-steele.com','Traditional','Ondo State','Ondo East','SS3','B','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','No','Asthma','001-006-830-5257x324','Debra Aguilar','1221 Perry Ville Apt. 339\nLake Dustin, WV 49727','814-005-3536x1090','No','Yes','Yes','Yes','No','Kathryn Thompson','3611680519','Doctor','104 Courtney Path Suite 467\nWest Crystal, HI 31071','Aunt','Yes','O+','AS','1.55','60.6','',0,'1234',0),('105','Heather Kelly','Female','40292','Lake Richardshire','89383 Wiley Mountain Suite 419\nRobertville, NH 62101','001-876-169-6803x6663','tomgarza@gmail.com','Christianity','Ondo State','Ose','SS2','B','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','No','None','001-258-062-5523x331','Brian Mitchell','1730 Le Vista\nKylechester, MT 41561','3233535473','Yes','Yes','Yes','No','Yes','Thomas Cox','(460)733-2542x9526','Doctor','293 Moore Vista Suite 342\nLake Michelle, IL 15710','Brother','No','B-','AA','1.36','75','',0,'1234',0),('106','Jaime Gray','Male','41505','Port Alex','6620 Bobby Grove\nMelvinfort, DE 58827','+1-162-251-6903x4595','salinastyler@hotmail.com','Traditional','Ondo State','Owo','SS1','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','Yes','Asthma','(029)884-0995x4163','Hailey Robinson','25763 Wright Bypass\nHannahborough, KS 71443','935.999.0791x998','Yes','Yes','No','No','Yes','Marc Griffin','798.921.7447x522','Civil Servant','1697 Cynthia Port Apt. 927\nNew Kayla, WV 14762','Father','No','O+','AA','1.46','88.5','',0,'1234',0),('107','John Wiley','Male','42231','Lauriefort','6682 Ramirez Parks\nEast Nancy, FL 26279','6833803555','kelly45@williams.info','Islam','Ondo State','Idanre','SS1','D','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','Yes','Sight issues','735-295-3290','Michael Liu','4313 Thompson Street Suite 359\nNew Jamesfort, MI 06151','(493)281-6060','Yes','No','No','Yes','Yes','Danielle Morris','+1-602-393-3803x394','Teacher','604 Cannon Glen\nCollinsview, IN 88092','Brother','Yes','B+','SS','1.34','80.7','',0,'1234',0),('108','Alexandra Harper','Female','42077','Roberttown','7986 Juan Locks Apt. 146\nPort Richardborough, NJ 40332','+1-844-961-0486x89411','melissaprince@gmail.com','Islam','Ondo State','Ile Oluji/Okeigbo','JSS1','A','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','Yes','Sight issues','299.086.9742x05065','Stacey Jones','Unit 1032 Box 0818\nDPO AE 59048','120.094.2921','Yes','Yes','Yes','No','Yes','Kayla Durham','001-626-218-1418x5521','Teacher','3234 Oconnor Ports\nWest Jennifer, CA 16443','Brother','Yes','AB+','AA','1.45','43.3','',0,'1234',0),('109','Joshua Hill','Male','40240','Bobbyville','1435 Bean Center\nRichardport, OH 35455','397-366-9884','lisa28@sullivan.com','Islam','Ondo State','Irele','JSS3','C','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','Yes','Hearing issues','001-763-149-5058','Holly Tran','572 Mueller Mission\nErikville, TN 87298','001-579-616-4186x17096','Yes','No','Yes','Yes','Yes','Luis Perez','001-448-818-0918','Doctor','46047 King Route Suite 860\nTorresside, VA 90075','Uncle','Yes','B-','AS','1.7','47.1','',0,'1234',0),('11','Brian Miller','Male','40960','Grahamside','187 Crystal Corner Suite 276\nNew Kim, KY 14066','621-377-2011x944','justin93@holmes.biz','Islam','Ondo State','Ondo West','SS1','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','Yes','Asthma','885-882-9204x811','Gregory Stephens','127 Thompson Road\nSouth Kevinmouth, WA 78195','465.544.0785x40368','Yes','No','No','No','No','Christopher Phillips','(485)572-7423x615','Teacher','7038 Amber Cove\nRobertberg, SC 40132','Mother','No','B-','AS','1.66','41','',0,'1234',0),('110','Scott Vincent','Male','39879','North Maria','326 Harris Park Suite 631\nNorth Joseph, MO 57827','031.225.8470x2518','vdavis@yahoo.com','Islam','Ondo State','Akoko North-West','SS3','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','Yes','Sight issues','001-379-652-5563x581','Linda Reilly','76937 Peggy Ville\nPort Julialand, WV 22683','871.659.0201','Yes','Yes','No','No','No','Brandi Moore','(607)284-9340','Farmer','73006 Brandon Ville Suite 172\nPatelport, CO 55366','Mother','No','A+','SS','1.52','65.3','',0,'1234',0),('111','Brent Stevens','Male','40511','East Zoe','524 Torres Views Suite 930\nNorth Katherinestad, OK 47341','001-099-615-5461x990','jennifercox@simpson-douglas.com','Traditional','Ondo State','Irele','SS3','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Sight issues','+1-845-906-6820x6839','Kelly Coleman','9268 Collins Lodge\nPort Carrie, ME 98543','(083)612-2046x1501','No','No','No','Yes','Yes','Julie Flores','+1-998-844-3245x197','Farmer','918 Mcdonald Court\nKristinport, ID 53810','Mother','No','A-','AA','1.63','76.8','',0,'1234',0),('112','Michael Owen','Male','40381','West Wanda','350 Michelle Locks Apt. 371\nWest Markfort, KY 28056','423-609-1703','ireed@gmail.com','Traditional','Ondo State','Okitipupa','SS2','A','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Sight issues','001-644-048-9178','Angel Sandoval','8051 Schroeder Roads\nNorth Megan, DE 82098','706.208.0251x966','No','No','No','No','No','Justin Cameron','2280776698','Civil Servant','686 Paul Dale Suite 164\nNew Shannon, IN 82186','Aunt','Yes','A-','AS','1.46','89.1','',0,'1234',0),('113','Gregory Martin','Male','41555','Nicholasfurt','567 Danny Villages\nKingport, RI 46690','939.417.2125','gregory61@hotmail.com','Christianity','Ondo State','Akoko South-West','SS3','C','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','Yes','Hearing issues','843.342.8912','Hannah Johnston','775 White Plains\nPort Robert, SD 25168','(117)025-1433','Yes','No','No','Yes','No','Brian Hurley','6334173506','Civil Servant','1170 Murphy Canyon\nLake Andrea, KY 54427','Uncle','Yes','AB-','AA','1.79','80.8','',0,'1234',0),('114','Anthony Burton','Male','39908','East Markshire','5287 Alejandro Estates\nNew Davidville, MD 64363','511-853-1802x499','everettkristin@hotmail.com','Traditional','Ondo State','Ose','JSS1','C','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','Yes','Asthma','001-770-365-6323x70429','Christina Anderson','294 Shannon Lodge Suite 315\nEast Kathryn, NV 99705','+1-608-149-5214x993','Yes','Yes','Yes','Yes','No','Selena Clements','842-344-8624','Farmer','90494 Brewer Rapids\nNorth Amy, SC 31788','Uncle','No','O+','AS','1.44','76','',0,'1234',0),('115','Kevin Jones','Male','41171','Port Jilltown','8572 Zimmerman Hills Apt. 507\nEast Bridget, MN 44531','348.412.7305','kevintran@flynn.com','Islam','Ondo State','Akoko North-West','SS1','C','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Hearing issues','(941)938-1384x7368','Charles Stewart','69187 Baxter Dale\nRyanside, NV 15696','291.028.0866x43248','No','No','No','No','Yes','Rita Hill','(274)772-8520','Engineer','042 Hall Ranch\nLake Meganland, LA 03268','Uncle','Yes','O+','AA','1.48','68.1','',0,'1234',0),('116','Kelly Roberts','Female','39218','Jennifertown','300 Davila Ridge\nLake Beckyshire, MO 57982','(503)326-8555x84682','paulmorris@gmail.com','Traditional','Ondo State','Akoko South-West','SS3','C','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','Yes','None','021.164.5404','Heather Simmons','6031 David Meadows\nLake Donna, OK 80877','(163)474-8502','Yes','No','Yes','No','Yes','Don Munoz','292.792.3649x6367','Civil Servant','48279 Molly Street\nJenkinsburgh, AK 47838','Aunt','No','B+','SS','1.38','44.8','',0,'1234',0),('117','Anthony Rivera','Male','41074','Crystalmouth','647 Mccarty Estate Apt. 973\nKempfort, FL 96276','+1-000-966-4409x042','hwalsh@yahoo.com','Traditional','Ondo State','Okitipupa','SS1','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','No','Hearing issues','464.475.3043','Lindsay Walker','884 Powers Ways Suite 211\nWest Hannahshire, IL 72583','+1-403-114-0901x3837','Yes','No','Yes','No','No','Gina Barr','266-719-4654x488','Teacher','877 Courtney Crossing\nLake Heatherstad, TN 22517','Brother','Yes','AB-','AS','1.6','45.6','',0,'1234',0),('118','Victoria Short','Female','39102','Lopezberg','8118 Christopher Pass\nNorth David, NV 09439','108.704.2338x004','sstafford@hotmail.com','Islam','Ondo State','Ondo West','SS1','C','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','Yes','Asthma','267.441.3357','Matthew Thompson','385 Nicholas Terrace\nJanetland, IL 90830','001-089-987-6626x847','Yes','No','No','No','Yes','Diane Andrews','001-732-889-0899','Farmer','0897 Dave Mews Suite 772\nNicholasshire, TX 18146','Sister','No','O-','AS','1.75','67.9','',0,'1234',0),('119','Ralph Sexton','Male','40306','South Tylerton','42474 Garcia Rest\nWest Aaron, MI 77639','+1-529-911-7769x03752','samueladams@gmail.com','Traditional','Ondo State','Ondo East','SS3','C','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','No','None','667-150-7096','Thomas Moore','Unit 7209 Box 9591\nDPO AP 72730','5991598388','Yes','No','Yes','No','Yes','Michael Hill','(033)887-2372','Engineer','242 Timothy Square\nLake Jose, LA 88847','Aunt','Yes','B-','AS','1.84','47.9','',0,'1234',0),('12','Brent David','Male','39305','Lake Kimberly','47062 Jacobs Junction Suite 596\nPort Joshuabury, WV 60014','608.028.2935x194','jessica54@yahoo.com','Traditional','Ondo State','Ifedore','SS1','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','Yes','Sight issues','001-874-368-1911x05511','Diana Mcintosh','08373 Stephanie Crossroad Suite 959\nEast Carla, TN 96880','(677)890-5737x78420','Yes','Yes','No','Yes','Yes','Kelly Dillon','919.502.2174','Teacher','5716 Kevin Harbor Apt. 601\nLake Lindseyview, DE 69113','Brother','No','B+','SS','1.65','71','',0,'1234',0),('120','Jackie Davis','Female','38963','Lake Debramouth','1143 Christopher Islands\nMarkville, LA 09282','341-080-9322x4509','brian16@ferguson-nguyen.biz','Christianity','Ondo State','Akoko North-East','SS3','B','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Hearing issues','(840)971-9675x39836','Michael Giles','68828 Jennifer Summit\nWallton, NM 99238','819.844.8296','No','Yes','Yes','No','Yes','Ruth Johnson','+1-917-543-2859x5697','Doctor','657 Stanley Trafficway Apt. 674\nAmymouth, IA 07748','Uncle','Yes','AB-','AS','1.55','87.3','',0,'1234',0),('121','Lisa Li','Female','39817','Alisonburgh','33371 Richard Via Apt. 641\nCarolynbury, WA 63899','(988)264-1951x93192','eflores@ford.com','Islam','Ondo State','Ese Odo','JSS2','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','Yes','Hearing issues','001-589-065-2874x7786','Johnny Murray','66240 Jimmy Coves Suite 017\nEricland, KY 69153','608.784.3237x2606','No','No','No','No','No','Michael Green','752-459-7866','Civil Servant','8798 Hicks Forge Suite 420\nSouth Aaronland, AL 22706','Brother','No','B-','SS','1.45','51.7','',0,'1234',0),('122','Carmen Herman','Female','42045','East Adrian','0012 Ashlee Square Apt. 008\nWest Adrienneland, PA 40171','001-760-834-5265x3742','kmorgan@carter.biz','Islam','Ondo State','Ile Oluji/Okeigbo','JSS2','C','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','Yes','Sight issues','001-940-309-7462x210','Julie Santiago','73667 Crystal Knolls Suite 598\nPort Donna, AL 96692','+1-970-155-8514x8384','Yes','No','No','No','Yes','William Hall','559-614-8608','Farmer','3437 Rodriguez Parkway\nLake Laura, WA 14662','Uncle','No','O+','AS','1.34','78.9','',0,'1234',0),('123','Annette Ray','Female','41214','North Joditon','7646 Ewing Glen Apt. 817\nRebeccaland, FL 69803','162.889.3810x49655','taylorteresa@gardner.biz','Traditional','Ondo State','Ose','JSS3','C','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','Primary 6','No','None','(560)625-0712x269','Aaron Baker','263 Pierce Shoals Suite 079\nNorth Dalefort, WA 94355','876.327.7652x6738','No','Yes','No','No','Yes','Kaitlyn Gutierrez','5344810790','Farmer','53153 Watts Course Suite 454\nGreenburgh, DE 96982','Aunt','No','B+','AA','1.73','43.4','',0,'1234',0),('124','Leah Hood','Female','39917','Austinberg','8022 William Motorway\nJohnsonhaven, MT 16932','+1-199-559-5264x429','cwallace@lyons.com','Christianity','Ondo State','Owo','SS3','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS2','No','None','321537337','Jacob Warren','0673 William Crest\nFrostshire, ME 40310','+1-369-525-1393x763','Yes','Yes','Yes','Yes','No','Stephanie Barnes','271-830-3006x37603','Trader','7969 Zuniga Groves Suite 012\nMunozview, VA 16480','Mother','No','AB-','AS','1.72','41.6','',0,'1234',0),('125','Brooke Carr','Female','39230','East Megan','32366 Sydney Station Suite 245\nLake Madison, SC 34771','780.329.0003','simmonsmicheal@moran.com','Islam','Ondo State','Ifedore','JSS3','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','Yes','Asthma','7876510160','Christopher Conrad','2514 Brian Meadows Suite 794\nSouth Tyler, IL 93239','7583032970','No','No','Yes','No','No','Jodi Villarreal','001-522-318-4634x50924','Farmer','36834 Glass Trafficway Suite 230\nPort Stevenmouth, GA 89817','Aunt','Yes','AB-','AA','1.74','89.2','',0,'1234',0),('126','Christopher Thomas','Male','39689','Cantrellside','203 Smith Valleys Suite 082\nEast Joshuaview, CO 06942','(702)115-7178x9402','harriskathryn@johnson.com','Christianity','Ondo State','Ifedore','JSS1','D','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS1','Yes','Hearing issues','001-368-246-2210x943','Marissa Joseph','10247 Johns Corners Suite 304\nSheliaside, AK 19131','750.785.9927x78638','Yes','Yes','No','Yes','Yes','John Rodriguez','116.865.0253','Teacher','20533 Rhodes Islands Suite 896\nKaylaside, MO 60909','Mother','No','A+','AS','1.62','60.5','',0,'1234',0),('127','Jennifer Harris','Female','40953','Port Heather','9111 Turner Curve Apt. 988\nWest Craig, LA 63836','=1-666-527-9023','campbellalan@gmail.com','Islam','Ondo State','Akoko North-West','SS3','A','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','No','None','+1-607-499-2270x2222','Kiara Perkins','99006 Krystal Flat\nNew Laura, IN 31762','(031)736-3788','No','Yes','Yes','No','No','Gary Clark','052-987-5592','Teacher','3342 Baker Pine\nNicholsland, FL 57758','Sister','Yes','A+','AA','1.67','68.8','',0,'1234',0),('128','Jeffrey Smith','Male','39739','Cliffordton','392 Martin Garden Apt. 025\nNew Desireemouth, AL 21669','046.137.1056','tbuck@jacobs-fisher.biz','Christianity','Ondo State','Ile Oluji/Okeigbo','JSS1','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','Primary 6','Yes','None','890-496-9551x602','John Jones','521 Anderson Turnpike\nRyanborough, OR 40400','863.009.2392x7043','No','No','No','Yes','Yes','Patricia Mueller','+1-780-316-5340x6299','Trader','93721 Marcia Valleys Apt. 160\nBriantown, GA 31684','Mother','No','AB+','AA','1.33','89.9','',0,'1234',0),('129','Kelly Thompson','Male','42218','Port Suzannebury','88184 Denise Ville\nLake Rodney, NC 20756','3794448173','kellygonzalez@scott-clark.com','Christianity','Ondo State','Akoko South-West','SS3','B','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','No','Hearing issues','065-307-6477x530','Jacob Barry','07513 Nathan Terrace Apt. 106\nSouth Mercedeshaven, WI 84547','+1-268-306-3269x30806','Yes','No','No','No','No','Jeffrey Thomas','(808)961-1060x1939','Teacher','439 Lowe Spring\nShieldstown, CO 19415','Aunt','No','A-','AA','1.78','79.7','',0,'1234',0),('13','Todd Hughes','Male','39385','Lake Richardport','033 Joel Passage Suite 385\nSmithborough, MT 54028','2490913716','joshua79@santana-sanchez.net','Traditional','Ondo State','Ilaje','JSS2','A','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','Yes','Asthma','914.251.7925','Daniel Payne','7513 Robin Bypass\nEast Jessica, AZ 29950','847.040.0118x5070','No','No','No','No','Yes','Natalie Johns','(515)720-4605x78541','Trader','434 Philip Mill Suite 140\nShaneview, PA 78088','Mother','Yes','O+','SS','1.67','44','',0,'1234',0),('130','Daniel Patel','Male','41759','Spencerbury','06975 Jones Forges\nWoodshire, TN 52674','7511645809','diane38@hernandez-rose.com','Traditional','Ondo State','Idanre','JSS1','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','No','None','667-453-6230x7367','Deanna Shea','50075 Carol Rue Apt. 361\nLake Michaelfurt, DC 34999','118-756-9216x39692','Yes','Yes','No','No','Yes','Catherine Parker','+1-452-047-1855x80895','Doctor','560 John Route\nEast Cathyburgh, OK 25886','Aunt','No','O+','AA','1.48','81.8','',0,'1234',0),('131','Christopher Shaffer','Male','41119','South Kaitlynborough','Unit 6045 Box 6220\nDPO AP 04297','+1-344-969-2368x924','susanrios@gonzalez-turner.com','Christianity','Ondo State','Odigbo','JSS1','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','No','Asthma','8569829870','Michael Graham','5715 Tracy Fall\nThomastown, RI 60551','=1-214-262-988','No','No','Yes','Yes','No','Michael Sosa','+1-592-519-4539x6775','Teacher','99160 David Estate\nPort Erica, KS 93694','Brother','Yes','A-','SS','1.66','87.5','',0,'1234',0),('132','Lindsay Hale','Female','40624','Frankmouth','832 Denise Trace Suite 321\nMunoztown, MT 18720','001-789-665-5953x62197','mejiajohn@wheeler.net','Traditional','Ondo State','Irele','JSS3','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS1','Yes','None','+1-432-884-3216x944','Melissa Turner','558 Ray Landing Suite 318\nCoxton, RI 66483','001-740-205-4794x021','No','No','No','Yes','No','Christopher Fischer','+1-350-813-1859x5770','Civil Servant','4743 Elizabeth Lock Suite 729\nLynchborough, AZ 59770','Sister','No','A+','AS','1.65','67.7','',0,'1234',0),('133','David Meadows','Male','41366','Cynthiafurt','605 Ryan Estate\nEast Victoria, NY 88571','066-849-3602','torresroger@holmes.org','Islam','Ondo State','Ese Odo','JSS3','C','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','Yes','None','001-014-958-3606x75027','James Weeks','729 Williams Meadow\nJustinfort, CO 43263','=1-696-210-137','No','No','No','Yes','No','Tamara Lopez','028.119.3117x57234','Civil Servant','USCGC Johnson\nFPO AA 92196','Sister','Yes','B-','AA','1.8','79.1','',0,'1234',0),('134','Michael Nunez','Male','39309','West Joyce','6529 Jesse Mountain\nHallland, GA 41991','016.687.7571x7552','mleach@jackson-jones.com','Islam','Ondo State','Idanre','JSS2','B','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','No','Asthma','023.074.0948','Jessica Patel','83488 Barker Parkways Apt. 142\nSamuelside, MA 18695','374-517-4633x954','Yes','Yes','Yes','Yes','Yes','Timothy Greene','1749722677','Farmer','805 Jane Village Suite 125\nPennyfort, WV 73729','Mother','Yes','O+','AA','1.85','78.1','',0,'1234',0),('135','Brittany Marshall','Female','42212','Nicolasfurt','46339 Lindsey Place Suite 965\nNorth Benjaminton, AL 45965','947-356-3588x4896','esparzajeffrey@gmail.com','Islam','Ondo State','Irele','JSS1','D','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','No','Sight issues','9928818519','Joe Griffin','65151 Jason Plains Suite 174\nPort Tracyland, NC 77659','5589004617','Yes','No','Yes','No','Yes','Harold Rose','+1-970-734-9570x456','Farmer','35309 Breanna Walks\nPaigefurt, OH 76629','Father','Yes','AB-','SS','1.54','46.8','',0,'1234',0),('136','Trevor Patel','Male','40289','Davisfort','8875 Mccoy Underpass\nWest Courtney, IL 61688','612-522-0823x95025','andrewmyers@sullivan-brown.com','Islam','Ondo State','Okitipupa','SS2','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','Yes','None','(003)880-9002','Danielle Morton','8248 Mcdaniel Ford Apt. 948\nRayfurt, NM 17272','+1-668-663-3151x30332','Yes','Yes','No','No','Yes','Veronica Oliver','479-276-2976x7585','Civil Servant','49980 Gregory Trafficway Apt. 526\nLake Carmen, KS 01946','Aunt','No','A-','SS','1.7','78.3','',0,'1234',0),('137','Mrs. Gina Williams MD','Female','39009','South Patriciamouth','47479 Craig Brook\nSouth Richardtown, WI 18949','829-481-2244x78853','johnsoncarrie@gillespie.com','Islam','Ondo State','Ose','JSS3','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','Yes','None','648-786-9333x112','Tyler Ford','PSC 5749, Box 1695\nAPO AP 14020','4082446988','No','Yes','Yes','Yes','Yes','Kyle Larson','+1-803-524-3046x483','Teacher','50740 Lopez Unions\nLake Nicholas, WV 45798','Mother','Yes','AB-','AA','1.42','46.4','',0,'1234',0),('138','Dwayne Thompson DDS','Male','39501','Rodriguezberg','Unit 1680 Box 6217\nDPO AP 29563','551.088.3041','leah21@gray.org','Traditional','Ondo State','Ose','JSS1','D','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Hearing issues','(772)272-4650','Kristen Barker','9690 Bradley Fields Apt. 456\nNew Jeremyberg, VA 43462','001-866-629-6635x07796','No','No','Yes','Yes','Yes','Daniel Richard','850-379-1264','Farmer','43931 Levy Junctions\nHernandezfort, KS 43726','Mother','No','B+','SS','1.34','40.5','',0,'1234',0),('139','Carrie Fisher','Female','40355','Port Robertchester','Unit 3622 Box 5280\nDPO AE 71122','+1-662-276-9454x07089','mariahsmith@yahoo.com','Traditional','Ondo State','Irele','JSS3','D','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','Primary 6','Yes','None','086.047.7795','Sabrina Andersen','1764 Proctor Squares\nNorth Michelletown, LA 26132','(080)471-1315','No','Yes','No','Yes','No','Pamela Richardson','(758)848-5587','Doctor','PSC 6176, Box 1875\nAPO AA 36980','Uncle','Yes','O+','AA','1.31','56.2','',0,'1234',0),('14','Ashley Gonzalez','Female','41012','Evansville','1022 Wallace Mountains Apt. 212\nDavismouth, SC 27047','(206)248-3169','owu@lambert.org','Islam','Ondo State','Ondo East','JSS2','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','Yes','Sight issues','820.104.3718x9691','Anthony Myers','6881 Sosa Lodge\nSouth Kristenstad, AK 92395','389.887.0402x86702','No','Yes','Yes','Yes','No','Ronald Young','371-871-9815x2005','Farmer','14320 Melissa Curve Apt. 281\nSouth Dawnbury, AL 22784','Aunt','No','B-','AA','1.78','66.8','',0,'1234',0),('140','Ashley Thompson','Female','39595','Cunninghamstad','88249 Timothy Drive\nSouth Taylormouth, ND 21929','(214)574-4019x8779','ncaldwell@ward-thomas.org','Traditional','Ondo State','Okitipupa','JSS1','C','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','Yes','Hearing issues','2916549130','Clifford Russell','0764 Daniels Hills\nNew Timothyport, NJ 89004','(678)108-9288x7244','Yes','Yes','No','Yes','Yes','Mandy Burgess','001-128-350-7525','Engineer','4971 James Station Apt. 955\nLeetown, ID 19152','Uncle','No','AB+','AS','1.67','83.8','',0,'1234',0),('141','Matthew Garcia','Male','42104','New Danielle','8070 Smith Inlet Suite 392\nKeithside, WI 61897','(700)429-0983x36110','arnoldshawn@gmail.com','Christianity','Ondo State','Akure South','JSS3','C','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','No','None','+1-315-508-5606x043','Amanda Barnes','573 Lee Grove Apt. 348\nNorth Allison, NM 96862','327.155.8675','Yes','Yes','No','Yes','Yes','Bryan Santiago','(623)022-2132x344','Civil Servant','8082 Laurie Course\nMendozashire, IA 51494','Brother','No','B-','SS','1.74','81.1','',0,'1234',0),('142','Michael Briggs','Male','41232','West Andrew','Unit 8907 Box 6640\nDPO AA 06024','(833)252-3649x85661','mallorywiley@hotmail.com','Christianity','Ondo State','Akoko North-West','JSS2','B','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','Yes','Hearing issues','6883790536','Alexander Roberts','335 Andrew Knolls\nWest Bryanfurt, TX 46270','029.792.1244','No','Yes','Yes','Yes','Yes','Michael Bell','(717)570-0224','Engineer','872 Lisa Canyon\nWest Christophershire, NH 22048','Father','No','AB+','SS','1.62','52.7','',0,'1234',0),('143','Emily Henry','Female','41828','West Danaburgh','65222 Jason Ports Suite 540\nNew Jenniferland, DE 58375','+1-884-887-6904x065','jasonshelton@gmail.com','Christianity','Ondo State','Ondo West','SS2','B','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','Yes','None','3688790030','Joshua Phillips','PSC 1111, Box 3226\nAPO AE 80033','304.024.4875','No','Yes','No','Yes','Yes','Lisa Johnson','300-404-9017','Teacher','831 Kelly Mountains Suite 190\nNicholasberg, FL 73275','Sister','No','AB-','AA','1.76','56.7','',0,'1234',0),('144','Erica Mcintosh','Female','39651','South Josephmouth','Unit 5199 Box 7508\nDPO AA 79657','(986)732-1151x1280','sherry41@gmail.com','Christianity','Ondo State','Akoko South-West','JSS1','A','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','Primary 6','Yes','Asthma','008-156-7608','Jason Tucker','44986 Carpenter Loaf Suite 631\nNew Adamstad, AZ 40697','+1-386-245-9382x956','Yes','Yes','No','No','No','Shelly Tucker','176-229-6510x4469','Farmer','9109 Simon Ports Apt. 677\nMoorefurt, IL 30997','Uncle','No','AB-','AS','1.86','72.7','',0,'1234',0),('145','April Daniels','Female','41457','Port William','0039 Graham Island\nPort Andreaburgh, GA 79296','(467)090-0976x663','kemplauren@mcconnell.com','Traditional','Ondo State','Akoko North-West','SS3','C','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','No','Asthma','001-088-331-0627','Theresa Flores','11639 Smith Spurs Suite 870\nEast John, AR 81955','001-435-001-5155x50902','No','Yes','Yes','No','Yes','Jason Wood','915.908.6224x283','Trader','PSC 9834, Box 4987\nAPO AE 21494','Sister','No','O+','AS','1.43','78.4','',0,'1234',0),('146','James Kirby','Male','40708','Angelaview','268 Adkins Vista Suite 007\nPort Aaronland, MS 85839','(399)741-9742','brandimartinez@gmail.com','Islam','Ondo State','Okitipupa','SS1','C','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','Primary 6','Yes','Asthma','+1-783-790-6966x43114','Kevin Wilson','6567 Foley Plain Apt. 779\nNew Paulton, MA 70572','010-159-5791x2256','Yes','No','Yes','Yes','Yes','Chad Jackson','=1-228-411-606','Teacher','6392 Miller Harbors Apt. 801\nCunninghamside, VT 86827','Brother','No','O+','AA','1.34','68.1','',0,'1234',0),('147','Lucas Haynes','Male','39124','North Gregory','5731 Summers Burg Apt. 829\nDianabury, VA 07946','001-708-307-0826','ygill@hudson-hodge.com','Traditional','Ondo State','Ile Oluji/Okeigbo','JSS1','B','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','No','None','(074)250-4657x2868','William Williams','39622 Brandon Stream\nSouth William, KS 14569','001-978-213-3144x55384','No','Yes','No','No','Yes','Laura Perkins','+1-632-657-7117x43212','Trader','Unit 3992 Box 2371\nDPO AP 59321','Uncle','Yes','A+','SS','1.85','67.3','',0,'1234',0),('148','Jessica Nguyen','Female','41440','New Jefferyshire','8161 Nash Club Apt. 497\nMurrayview, FL 66138','153-405-8142','benjamin93@hotmail.com','Traditional','Ondo State','Ile Oluji/Okeigbo','JSS3','A','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','Yes','None','(682)843-7000x645','Nancy Austin','879 Smith Common\nEast Jacktown, VA 01722','341.381.1429','Yes','No','Yes','No','Yes','Jerry Reynolds','8575931159','Trader','9779 Regina Port\nWest Kelseyland, DC 91400','Father','Yes','B+','SS','1.36','74.4','',0,'1234',0),('149','Colleen Gonzales','Female','41615','Lopezbury','2505 Davis Glen\nLake Laura, FL 73458','001-439-073-1305','ipugh@decker-gonzalez.biz','Christianity','Ondo State','Ese Odo','SS1','C','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','Primary 6','Yes','Asthma','001-154-697-9546x9919','Rhonda Phillips','4623 Gross Falls Apt. 422\nSandovalport, OK 39704','(763)887-3754','No','No','Yes','Yes','No','James Gonzales','925-395-0482','Trader','444 Richard Park Apt. 075\nAnthonychester, TX 31354','Brother','No','A+','AS','1.66','82.4','',0,'1234',0),('15','Tyler Bowen','Male','39112','Lake Tiffany','PSC 6949, Box 0670\nAPO AE 88232','+1-737-774-0295x475','adamsfernando@hotmail.com','Christianity','Ondo State','Ese Odo','JSS1','D','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','No','Sight issues','8232070099','Jonathan Duncan','0724 James Garden\nAmandaside, IN 18853','793.233.4496x9498','Yes','Yes','No','Yes','No','Adam Oconnell','8403116143','Doctor','Unit 6647 Box 4185\nDPO AE 60756','Sister','No','B-','SS','1.87','75.3','',0,'1234',0),('150','Anthony Meza','Male','39251','Andersenburgh','7125 Lee Overpass Apt. 520\nNorth Paul, VT 81871','175-193-8179x530','michael12@gibson.org','Islam','Ondo State','Akoko South-West','JSS3','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','Sight issues','508.627.8649','Donald Hernandez','40770 Jeffrey Vista\nShawnside, WY 69606','444.802.8432x11157','No','Yes','No','No','No','Aaron Brown','+1-385-909-3298x3852','Doctor','93335 Tiffany Mountain\nMcguireville, AK 90106','Sister','No','A+','AA','1.38','61.5','',0,'1234',0),('151','Ashley Thomas','Female','40495','Billton','027 Gomez Island\nPort Emilyville, NE 09931','001-835-827-3674','williamwilson@miller.com','Traditional','Ondo State','Ondo West','JSS2','C','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','Yes','Asthma','001-136-878-8136x06473','Maria Crawford','646 Welch Courts\nBonniestad, SD 61333','(817)810-3765x0547','Yes','No','Yes','No','Yes','Joseph Rodriguez','(190)811-7503x1479','Teacher','4312 Marcus Mill Suite 832\nSouth Amanda, WI 47325','Father','Yes','A-','SS','1.81','59.8','',0,'1234',0),('152','Justin Burns','Male','39320','Lake Albert','717 Frey Passage Suite 967\nErikaville, FL 18514','841.321.1374x131','samanthapetersen@yahoo.com','Christianity','Ondo State','Okitipupa','JSS3','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS3','No','None','7406600203','Sonya Howard','0577 Rose Views\nEast Morgan, OK 86976','=1-810-974-616','No','No','Yes','No','Yes','Amanda Patrick','+1-483-117-6594x105','Doctor','295 Gibson Manor Apt. 663\nNew Amanda, DC 95669','Uncle','No','B-','SS','1.35','45.4','',0,'1234',0),('153','Daniel Cabrera','Male','40908','Thomasville','464 Moore Hills Suite 100\nBryantfort, SC 37116','(449)161-3783x68092','stevensmith@butler.biz','Traditional','Ondo State','Akure South','SS3','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','Yes','None','+1-760-479-5813x66533','Cameron Richard','8261 Baldwin Valley Apt. 389\nEast Andrea, HI 55067','888.692.2646x2133','No','Yes','No','No','No','Kimberly Torres','086-559-8741','Civil Servant','678 Wong Path\nLake Ryan, RI 01280','Uncle','No','AB-','AS','1.59','89.5','',0,'1234',0),('154','Erik Brooks','Male','39748','Kristinberg','0905 Moore Turnpike Apt. 965\nWest Jenniferberg, IL 01276','465-818-5572x48070','christina34@yahoo.com','Traditional','Ondo State','Akoko North-West','SS3','C','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','No','None','5310879710','Daniel Horn','241 Amber Light Suite 106\nWest Jonathan, MO 23478','666.672.1851x045','Yes','Yes','No','No','No','Travis Payne','(757)132-8008x406','Trader','96315 Hansen Trace\nPort Susanmouth, FL 82439','Father','No','A-','SS','1.77','84.3','',0,'1234',0),('155','Sydney Smith','Female','41951','South Dianeville','250 Joshua Creek Suite 499\nLake Cynthiashire, MT 11879','428-609-1491x7542','rebeccawheeler@gmail.com','Christianity','Ondo State','Ifedore','SS2','C','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','Yes','Sight issues','001-159-445-3425x494','Charles Paul','56256 Ramos Roads Apt. 700\nMarcushaven, CA 88297','984-717-9445','Yes','Yes','Yes','Yes','No','Mr. Robert Townsend','(329)596-4840x61646','Trader','827 Amy Meadow Suite 590\nAlecburgh, TX 69566','Sister','No','A+','AA','1.68','86.4','',0,'1234',0),('156','Amy Moody','Female','41137','Matthewmouth','835 Lisa Canyon Apt. 885\nKevinville, OH 75824','533.256.7927x49278','cgardner@murphy-hawkins.com','Islam','Ondo State','Akoko South-West','SS2','C','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','No','Sight issues','001-255-350-2816x48314','Christina Gonzalez','7238 Bonnie Mountains\nMarcmouth, MT 54646','518.917.1265','Yes','Yes','No','No','No','Joseph Snyder','+1-301-294-4687x520','Doctor','4692 Lee Extension Apt. 842\nWest Marilynside, AZ 39718','Aunt','No','O+','SS','1.31','55','',0,'1234',0),('157','Todd Parrish','Male','41151','Port Alexachester','41429 Edward Spur\nNorth Tammy, NC 46610','485-074-3827x12541','bensonkaitlyn@williams.com','Christianity','Ondo State','Irele','SS3','D','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','Primary 6','No','Sight issues','231.151.7595x68718','Heather Grant','9477 Foster Walks\nNorth Amy, NM 94658','001-739-893-5847x453','No','Yes','Yes','Yes','Yes','Lauren Torres','001-161-909-9135x2275','Civil Servant','3802 Paul Shoals Suite 753\nSamanthafort, ME 30540','Brother','Yes','B+','AS','1.61','57.4','',0,'1234',0),('158','Robert Lewis','Male','41305','Lake Debra','07218 Torres Islands Apt. 943\nNorth Michaelbury, FL 35041','(254)284-9115x79972','wardteresa@jones.com','Islam','Ondo State','Owo','SS2','D','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','No','Asthma','065.758.8930x2147','Andrew Lee','1872 Pugh Knolls Apt. 480\nWilliambury, NH 33636','(403)511-1052x33606','No','Yes','No','No','Yes','Jessica Young','(318)304-8191x0018','Teacher','4342 Joseph Rapids\nLarrybury, AZ 60319','Uncle','Yes','AB+','AS','1.81','61.8','',0,'1234',0),('159','Kimberly White','Female','41408','New Dannyport','2442 Hernandez Village Suite 286\nGarnerport, FL 29334','085.566.2267','ronaldcastillo@nelson.com','Traditional','Ondo State','Owo','SS3','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','No','Hearing issues','(945)688-8687','Kathryn Snyder','89206 Vasquez Corners Suite 661\nYoungshire, CO 67689','+1-203-053-3017x076','Yes','Yes','No','Yes','No','Sue Perez','995-469-3683x22515','Civil Servant','030 Mckenzie Pine\nEast Amanda, AL 73519','Aunt','No','A-','SS','1.42','61.3','',0,'1234',0),('16','Justin Schmidt DDS','Male','39745','Port Rebecca','20447 Alan Mills\nEast Manuelberg, MD 64223','+1-894-534-6411x03267','rgallagher@yahoo.com','Islam','Ondo State','Akoko South-West','SS3','C','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','No','Sight issues','8574609734','Jacqueline Santos','61988 Richard Shoal\nEast Jeremyborough, MS 75032','485.391.9697x5905','Yes','Yes','No','No','Yes','Carrie Hernandez','190-082-2205x58911','Doctor','980 Nicole Island Suite 059\nCarolmouth, VT 45991','Brother','Yes','AB+','AA','1.77','66.6','',0,'1234',0),('160','Lynn Reid','Female','40787','North Tammyhaven','27135 Davis Drive\nBishopmouth, GA 49456','+1-155-540-2748x456','emmakoch@hotmail.com','Christianity','Ondo State','Akure North','JSS3','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS2','Yes','Sight issues','(801)702-6968x266','Sheila Wilkerson','444 Reynolds Branch\nDavisbury, ID 05667','001-150-743-8110x04753','No','Yes','No','Yes','No','Mary Obrien','(576)617-4580','Teacher','PSC 8193, Box 7391\nAPO AP 81024','Father','No','AB+','AS','1.39','48.6','',0,'1234',0),('161','David Bowman','Male','41300','Jeffreyburgh','483 Herman Knoll Suite 969\nNorth Pamelafort, ND 60159','001-381-388-5844x826','rachel55@gmail.com','Christianity','Ondo State','Akoko South-East','SS1','A','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','Yes','None','+1-594-920-0198x23875','Scott Patrick','53425 Rodriguez Grove\nMeganshire, RI 22081','=1-195-381-3523','No','Yes','Yes','Yes','Yes','Michael White','+1-137-717-7139x09508','Teacher','Unit 3213 Box 9377\nDPO AA 87031','Mother','No','B+','SS','1.4','66','',0,'1234',0),('162','Scott Flores','Male','41383','Jennamouth','12872 Dawn Summit Apt. 051\nJenniferton, SD 17211','(256)552-7983x0449','stephanie51@yahoo.com','Christianity','Ondo State','Odigbo','SS2','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','None','674.386.8917x369','Amanda Hess','678 Cynthia Crest Apt. 799\nTammymouth, MD 88113','473.055.1616x34448','No','No','No','Yes','No','Keith Hunter','017-890-2808','Doctor','1341 Jasmine Stream\nNew Amybury, MI 27354','Aunt','Yes','B-','AA','1.79','44.2','',0,'1234',0),('163','Kylie Martinez','Female','41209','Richardsonhaven','1513 William River\nPort Joseview, IL 47810','+1-341-075-8683x86861','ujensen@gmail.com','Traditional','Ondo State','Akure South','SS3','A','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','Yes','Sight issues','+1-514-057-0905x94326','Kayla Jefferson','186 Melissa Ranch\nAlexanderchester, WA 05956','+1-161-006-2059x8094','No','No','Yes','Yes','No','Brittany Beasley','859-453-9238x20279','Civil Servant','1719 Hubbard Shoals Apt. 105\nSouth Amandafurt, VA 87879','Sister','Yes','O-','AS','1.87','55.2','',0,'1234',0),('164','Corey Hughes','Male','41578','East Alisha','327 Megan Curve Suite 468\nWoodfurt, UT 94871','339.443.4516x650','greenhannah@coleman-camacho.biz','Islam','Ondo State','Akoko South-East','SS2','B','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','Primary 6','No','Hearing issues','+1-923-215-9689x850','Margaret Jones','171 Robert Trail\nNorth William, IL 97025','+1-977-643-9737x5685','Yes','No','No','Yes','No','Linda Middleton','+1-687-825-2900x9359','Civil Servant','2020 Carr Prairie Apt. 054\nPort Petertown, CO 70752','Uncle','No','AB+','AA','1.64','60.8','',0,'1234',0),('165','Michael Edwards','Male','39831','Mcguirechester','086 Natalie Oval\nPort Williambury, MI 96322','=1-886-494-2960','moorejennifer@gmail.com','Christianity','Ondo State','Okitipupa','SS3','D','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','No','Asthma','+1-248-435-7043x58211','Kevin Kelly','174 Coffey Stravenue Suite 733\nWest Melissaburgh, DE 36145','+1-001-182-2384x641','Yes','No','Yes','Yes','Yes','April Coleman','(359)665-6852x9081','Farmer','06407 Hoover Village Apt. 283\nNorth Kelly, TN 41557','Mother','No','AB-','AS','1.86','70.3','',0,'1234',0),('166','Patricia Thompson','Female','39596','West Ashleyport','87768 Moses Plains\nNorth Gail, MN 08956','672.117.0180x5468','egonzalez@gmail.com','Traditional','Ondo State','Okitipupa','SS1','B','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','Yes','None','+1-683-436-7725x8333','Kaitlyn Fisher','3517 John Common\nStacychester, VT 20358','001-209-395-4675','Yes','Yes','Yes','No','Yes','David Douglas MD','+1-191-929-3050x49615','Doctor','7264 Brittany Curve\nWest Cameronchester, MA 19860','Uncle','No','A-','SS','1.42','63.5','',0,'1234',0),('167','Joshua Williams','Male','39588','Katherinemouth','513 Marie Branch\nCampbellside, NJ 44903','741.222.7093x1292','jonesjohn@hotmail.com','Christianity','Ondo State','Akoko North-East','SS3','A','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','No','Sight issues','475.043.6151','William Thomas','514 Haley Expressway Apt. 472\nSherrymouth, DE 94557','383-224-1090x802','No','Yes','Yes','No','Yes','Faith Burgess','9490552654','Trader','193 Sanders Course\nTashaville, TN 08012','Aunt','Yes','O-','SS','1.69','41','',0,'1234',0),('168','Adrian Sullivan','Male','39052','Port Lauren','3731 Fitzgerald Key\nNorth Bethany, RI 47674','192-489-3051','rebecca42@cummings.net','Traditional','Ondo State','Akoko North-West','JSS1','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS1','No','Asthma','(728)327-9606','Louis Brown','242 Valerie Valley\nCraigville, IA 48586','(484)008-6957','No','Yes','Yes','No','No','Corey Hartman','715-826-7377x211','Engineer','Unit 3130 Box 4858\nDPO AE 12677','Sister','No','B+','AS','1.71','68.6','',0,'1234',0),('169','Ryan Mcpherson','Male','39232','East Karafurt','314 John Brooks Suite 064\nRobertview, UT 88579','(351)881-2149x503','charlesthomas@martinez.net','Traditional','Ondo State','Akoko North-West','SS2','C','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','Yes','None','(489)070-6710x39071','Adam Morales','315 Woods Orchard Suite 342\nNew Heatherfurt, WV 71217','+1-748-706-7787x0566','No','No','Yes','No','No','Kimberly Romero','(698)012-9057','Teacher','PSC 7631, Box 2135\nAPO AE 50608','Sister','No','AB+','AA','1.65','61.7','',0,'1234',0),('17','Ian Henry','Male','39399','West Karen','68058 Paula Manor Suite 636\nHorntown, CT 89183','001-484-567-9132x0530','ryanmoreno@thornton.com','Islam','Ondo State','Ile Oluji/Okeigbo','SS3','C','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','Yes','Asthma','462-306-4876x047','Karen Kline','8298 Shelby Fall\nMistychester, RI 11613','821-390-2145x038','No','Yes','Yes','No','No','Michael Lee','922.647.7217x3271','Engineer','USCGC Carter\nFPO AP 04836','Brother','No','AB+','AA','1.7','77.1','',0,'1234',0),('170','Kelly Sullivan','Female','42044','Port Tracey','770 Tim Vista\nEast James, AZ 30570','897.743.9138x321','martin91@barrett-bush.org','Traditional','Ondo State','Ifedore','JSS3','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Hearing issues','748-163-2822','Nicole Wells','227 Howard Points\nNorth Lindaburgh, MD 10051','034.412.9289','No','No','Yes','Yes','No','Andrew Mcbride','+1-006-513-9568x974','Engineer','518 Frances Gateway\nJenniferborough, VT 91317','Aunt','Yes','A-','SS','1.59','52.4','',0,'1234',0),('171','Corey Carter','Male','41873','Erinshire','27811 Mills Circles\nHallton, KY 69489','480-019-6893','alicia73@estrada.info','Traditional','Ondo State','Owo','JSS1','C','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS3','Yes','Hearing issues','001-048-632-9659x45167','Marissa Brown','1253 Benjamin Union Suite 718\nHooverport, WV 77347','881-956-5530x25953','Yes','No','Yes','Yes','Yes','Robert Wagner','(482)674-8973x181','Farmer','9909 Colon Rapid Apt. 009\nJenningston, MD 27004','Brother','Yes','AB-','AA','1.47','72.5','',0,'1234',0),('172','David Johnson','Male','39452','New Brianchester','47038 Keller Glens Suite 678\nSouth Troy, ND 34056','191-700-2390x43970','jermaine99@gmail.com','Christianity','Ondo State','Akure North','JSS3','C','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','No','Hearing issues','+1-419-452-1677x6354','Raymond Wyatt','16482 Kayla Club Suite 005\nPort Joshualand, AK 99852','565.212.2687x403','No','Yes','No','Yes','No','Nathan Hart','+1-339-614-6233x89836','Engineer','292 Tiffany Loaf Apt. 639\nChristianland, ME 17661','Sister','No','B-','AA','1.5','59','',0,'1234',0),('173','Justin Henry','Male','40975','Port Tiffany','4224 Lisa Keys Apt. 757\nNorth April, DE 22226','9073326577','deborahsalinas@cannon.info','Traditional','Ondo State','Odigbo','SS3','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','Yes','Hearing issues','(025)446-9113x693','Karen Perkins','7891 Hernandez Lights\nPort Andrewview, OK 14147','001-917-425-2676','No','Yes','No','Yes','Yes','Dale Peterson','001-176-991-6076x0157','Engineer','522 Wilson Vista\nSouth Danielhaven, CO 53230','Sister','Yes','B-','AS','1.75','56.2','',0,'1234',0),('174','Catherine Brown','Female','41158','Smithburgh','118 Christopher Radial\nRossstad, OR 75970','001-857-737-6577x6832','melissastuart@yahoo.com','Islam','Ondo State','Ese Odo','SS2','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','Asthma','+1-987-960-6842x0367','Shawn Robinson','9680 Smith Mission Apt. 387\nAndersonton, ND 82333','6438902952','No','No','No','No','Yes','Steven Larsen','(730)524-8339x880','Teacher','Unit 7041 Box 0975\nDPO AP 83037','Father','No','A-','AS','1.69','85.7','',0,'1234',0),('175','Steven Myers','Male','40888','South Justinchester','0697 Randall Cliff\nNew Dawnview, ME 80362','2024249987','stacey32@kirby.org','Islam','Ondo State','Owo','JSS3','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','No','None','533.912.1871','Stanley Walters','123 Morgan Island\nJohnsonview, ME 99313','190-097-9387x0077','No','Yes','No','No','No','Haley Williams','(917)029-5978x38325','Trader','1137 Katie Route Suite 881\nStephanietown, WI 93568','Mother','Yes','B-','AS','1.31','66.2','',0,'1234',0),('176','Juan Carter','Male','39079','Changbury','94929 Kevin Flats\nWest Kellystad, WI 35918','(813)734-9587x954','cody14@gmail.com','Christianity','Ondo State','Ese Odo','JSS2','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS3','Yes','Asthma','086.775.8887','Alyssa Bartlett','61891 Stevens Neck\nDonnafort, IL 41145','389-593-8224','Yes','Yes','No','No','No','Lynn Reilly','253.223.1157','Farmer','122 Simmons Trace Suite 608\nFosterbury, KS 10391','Mother','No','O+','AA','1.44','66.9','',0,'1234',0),('177','Elizabeth Aguilar','Female','40431','Espinozafort','408 Cynthia Shore\nNicholsbury, IL 35111','538.793.3931','erikachang@gmail.com','Traditional','Ondo State','Ese Odo','JSS3','D','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Sight issues','+1-395-602-7500x2185','Margaret Contreras','257 Stephanie Turnpike Suite 867\nEast Kathleen, AL 64048','(218)960-1912x846','Yes','Yes','Yes','Yes','No','Michelle Baird','239-673-9725x1322','Engineer','722 Paul Mills Suite 036\nDavidborough, KY 95501','Uncle','No','A+','SS','1.87','79.2','',0,'1234',0),('178','Jennifer Dean','Female','40288','Lake Brianchester','90998 Matthew Route\nWest Rebeccaside, IL 48992','=1-429-778-4777','derricknguyen@yahoo.com','Christianity','Ondo State','Ondo East','SS3','D','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','Primary 6','No','None','8033174660','Thomas Bowen','92782 Porter Lights Suite 918\nPort Stephen, IN 47483','739.461.2613','Yes','Yes','No','No','Yes','Bradley Hale','967.577.3407x6513','Engineer','08108 Guzman Brook\nNataliestad, NH 80769','Sister','Yes','A+','AA','1.52','41.4','',0,'1234',0),('179','Randy Dodson','Male','38996','East Katelyntown','3732 Rodney Port Apt. 407\nLake Davidside, GA 30735','2200488466','hsullivan@yahoo.com','Islam','Ondo State','Ondo East','JSS3','A','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','Yes','Hearing issues','2195110726','Frederick Harris','609 Young Trail\nPort Joannehaven, FL 53276','677.861.9151x33132','No','No','Yes','No','No','Pamela Conway','780.942.6842','Doctor','14447 Brandon Glens\nRobertsborough, MD 23626','Uncle','Yes','AB-','SS','1.38','79.4','',0,'1234',0),('18','Brian Phillips','Male','41791','East Anthony','2644 James Shore Suite 459\nChristinachester, AR 06035','862-729-2990x41400','christinachandler@charles.info','Islam','Ondo State','Akoko North-West','SS3','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS2','No','None','761-153-4226x099','Danielle Reese','PSC 0407, Box 3647\nAPO AP 70411','(566)885-2214','Yes','Yes','Yes','Yes','Yes','Erin Williams','001-299-585-5216','Teacher','94798 Emily Centers\nSouth Micheleborough, MA 08716','Uncle','Yes','B-','AS','1.8','76','',0,'1234',0),('180','Michael Johnson','Male','41900','South Ann','77717 Duran Loop Suite 668\nWest Wendyside, UT 81093','160.892.2482x4443','gilbertmelanie@williams.com','Christianity','Ondo State','Ondo West','SS2','A','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','No','Hearing issues','997.332.3415','Juan Davis','3179 Morgan Centers\nNorth Stephen, WA 00930','001-400-583-6642x78668','Yes','No','No','Yes','No','Nicholas Herring','570-316-6331','Doctor','140 White Course\nWest Kellystad, IL 63733','Sister','Yes','A+','SS','1.87','71.2','',0,'1234',0),('181','Sharon Ramirez','Female','38958','Lake Robertview','39608 Anna Stream Suite 463\nKatherineberg, MI 09731','872.564.8362x38242','erica65@yahoo.com','Traditional','Ondo State','Akoko North-East','JSS2','D','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS3','Yes','None','+1-247-286-5015x5842','Jennifer Smith','768 Garcia Land Suite 924\nBrianville, KY 19436','001-656-044-8793x6688','Yes','Yes','Yes','Yes','Yes','Paul Perkins','(485)252-4955','Doctor','29819 Watson Valley Apt. 385\nAustinville, MD 54546','Sister','No','AB-','SS','1.46','57.3','',0,'1234',0),('182','Mr. Darren Newman Jr.','Male','41772','New Vincent','462 Jared Stravenue\nKellerfurt, MS 01825','+1-516-181-4903x244','uchavez@hotmail.com','Traditional','Ondo State','Akoko South-East','SS3','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','No','Hearing issues','001-714-695-3620','Jeff Smith','84115 Valerie Stream Suite 995\nMedinaton, ID 37461','193.019.4248','Yes','No','Yes','No','Yes','Timothy Schmidt','449-632-9802x282','Engineer','PSC 9705, Box 1338\nAPO AA 61961','Aunt','No','AB+','AS','1.89','88.8','',0,'1234',0),('183','Angela Garza','Female','39296','Gambleside','896 Gwendolyn Unions\nPort Christina, NC 51708','001-329-125-6091','sarah07@yahoo.com','Traditional','Ondo State','Ese Odo','SS1','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','No','Hearing issues','6190898592','Christina Watkins','3740 Jenkins Fall\nNew Kelsey, WI 24691','+1-857-234-4773x758','Yes','No','No','Yes','Yes','Evan Friedman','(944)734-4018','Trader','406 Christine Passage Apt. 195\nNew Kenneth, ME 77423','Father','No','O-','AS','1.3','63.8','',0,'1234',0),('184','Jennifer Charles','Female','41228','Jamesland','69256 Santiago Mountain Suite 765\nNorth Samanthaburgh, AZ 24677','517-585-2041x611','perezgregory@ryan.org','Islam','Ondo State','Owo','JSS3','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS1','No','None','224.024.8790x29124','Jeffrey White','33163 Whitehead Radial\nKeithberg, NY 51904','(797)230-4654x178','No','No','No','Yes','Yes','Alyssa Novak','6751549937','Civil Servant','PSC 2624, Box 2955\nAPO AA 96371','Mother','No','O+','AA','1.6','65.4','',0,'1234',0),('185','Karen Reyes','Female','40766','Lake Robert','7634 Ross Shoals\nMichaelville, PA 64251','001-044-412-4740x29698','breyes@mckee.com','Islam','Ondo State','Irele','JSS3','A','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS1','No','Sight issues','549-475-1726x4644','Brian Reed','67204 Jonathan Wells Suite 084\nTracyland, MA 09378','(277)608-9975','No','Yes','No','No','Yes','Joshua Riley','(453)176-6432x409','Teacher','13607 Troy Lodge\nNorth Carl, TN 21698','Aunt','No','AB+','SS','1.38','61.4','',0,'1234',0),('186','Danielle Doyle','Female','42137','Rachaelfurt','8021 Robert Squares\nLake Scott, NM 54600','(415)708-5530','shawnguerra@rodriguez.net','Islam','Ondo State','Akoko South-West','JSS2','A','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','No','Sight issues','(992)882-4885x1313','Melissa Buckley','9444 Cassandra Mill Suite 384\nVeronicafort, CO 76721','001-602-913-9959x62796','Yes','No','No','No','Yes','Thomas Williams','(404)903-0743','Trader','0897 Martin Keys\nKarentown, IA 89122','Brother','Yes','A+','AA','1.76','67.4','',0,'1234',0),('187','Dr. Adrian Taylor','Male','40311','Douglasberg','USNV Fowler\nFPO AA 71128','406-221-0628x25176','ray29@roberts-banks.com','Christianity','Ondo State','Akoko North-East','JSS2','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','No','Sight issues','797-999-2980','James Rice','USCGC Hale\nFPO AE 11548','=1-789-67-4701','No','No','No','Yes','Yes','Mrs. Jacqueline Moran MD','(512)399-4485','Doctor','875 Wade Locks Suite 128\nMichaelmouth, WV 04039','Uncle','No','AB+','SS','1.65','78','',0,'1234',0),('188','Jennifer Brown','Female','41751','West Megan','42197 William Ferry\nJoshuaborough, VT 20645','001-196-551-4229x44495','danny00@gmail.com','Christianity','Ondo State','Okitipupa','JSS2','D','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','No','Hearing issues','421-192-1547x31957','Kenneth Stevenson','54544 Delgado Rue\nNorth Mark, WI 25583','001-052-869-4593','Yes','No','Yes','No','No','Shelia Cain','(887)438-4548x444','Teacher','29905 Taylor Meadows\nSouth Rogermouth, AZ 24599','Father','Yes','AB-','AS','1.68','68.8','',0,'1234',0),('189','Dakota Bowman','Male','41956','North Taylor','0121 Emily Valley\nNorth Johnfurt, NC 72821','964.771.6506','charles63@powers-hill.com','Islam','Ondo State','Ile Oluji/Okeigbo','JSS1','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS3','Yes','None','8188317201','Brandi Wood','65520 Rice Burg Suite 421\nNorth David, TN 22796','399.393.2629x0630','Yes','No','No','No','Yes','Jordan Walls','+1-086-079-1249x6650','Teacher','2576 Shannon Via Suite 835\nWest Andrea, TN 54832','Mother','No','A-','SS','1.57','71.1','',0,'1234',0),('19','Andrew Rodriguez','Male','40398','North Nicolehaven','349 Matthew Loaf Apt. 579\nLake Jose, NH 43098','(852)042-1551','gateslauren@whitaker.net','Christianity','Ondo State','Akoko South-West','JSS1','C','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','Yes','Sight issues','517-347-4751x765','Michael Graves','007 Victoria Row Apt. 582\nMatthewfurt, MS 54220','683.773.1624x0281','Yes','Yes','Yes','No','Yes','Carlos Ryan','3558739777','Teacher','PSC 1779, Box 8076\nAPO AA 55357','Aunt','No','A-','AA','1.51','66.7','',0,'1234',0),('190','Charles Oneill','Male','41296','Perrystad','7131 Ryan Drives\nNew Peterburgh, OR 64778','427-625-3308x711','kelly25@powell-reed.biz','Christianity','Ondo State','Akure South','JSS3','A','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','Yes','Asthma','(149)732-4088x7231','Timothy Williams','252 Ashley Light Apt. 651\nWest Emily, WA 24474','1465944358','No','Yes','Yes','No','No','Teresa Martin','+1-096-476-7766x2372','Doctor','411 Jerry Port Suite 674\nPort Sarahbury, AL 75976','Mother','No','O-','AA','1.4','71.8','',0,'1234',0),('191','Mr. Bradley Johnson','Male','41876','Port Jamesmouth','1655 Walker Underpass\nLake Josephchester, WY 57803','(783)510-7727','janeyoung@phillips-perez.net','Christianity','Ondo State','Ondo East','SS3','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','Yes','Hearing issues','461.721.8151','Melissa Robertson','8620 Dixon Branch Apt. 034\nTerribury, NY 65026','957-310-3727','No','Yes','No','Yes','No','Beverly Nelson','(763)127-2633x089','Teacher','734 Alan Ports Apt. 115\nLake Claytonfort, AK 96870','Brother','No','A+','AA','1.84','71.1','',0,'1234',0),('192','Anna Hahn','Female','39007','Ricardoborough','Unit 0513 Box 0498\nDPO AE 68464','304-220-0864x25773','owensian@yahoo.com','Christianity','Ondo State','Akure North','SS2','C','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','Yes','Hearing issues','001-850-677-8371x4540','William Martin','28230 Tammy Summit\nStantonshire, WV 85748','450-004-8345','No','No','Yes','Yes','No','Brandon Hardy','001-424-594-9681x33847','Civil Servant','64018 Vickie Island Suite 486\nNew Heathermouth, TX 69558','Mother','Yes','O+','SS','1.36','56.2','',0,'1234',0),('193','Amber Lewis','Female','41262','East Douglasville','49913 Campbell Circles\nRubenmouth, WV 99604','294.678.3060','leahramos@schultz.com','Traditional','Ondo State','Ile Oluji/Okeigbo','JSS2','A','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS3','No','Hearing issues','216-613-4018','James Webb','687 Stafford Track Suite 214\nMonicaport, VA 22887','(757)590-6811','No','No','No','Yes','Yes','Christopher Schmidt','830.685.5301x183','Trader','88443 Clark Underpass\nTheresaside, NY 80672','Brother','No','B+','SS','1.89','73.7','',0,'1234',0),('194','Christine Shelton','Female','42177','New Mary','055 Schroeder Lake Suite 885\nLawrencefurt, MI 84581','5080658403','ggonzalez@hogan.com','Christianity','Ondo State','Owo','SS3','A','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','Yes','Hearing issues','355-011-9123x2628','Mary Franco','5858 Watkins Ford Suite 704\nCurtishaven, DC 45307','+1-076-668-1434x0168','No','Yes','Yes','Yes','No','Joshua Carroll','+1-059-485-7066x297','Civil Servant','3303 Williamson Harbors Suite 104\nSouth Teresa, OR 65938','Brother','Yes','O+','AS','1.88','78.2','',0,'1234',0),('195','Mary Mendoza','Female','41064','Rachelborough','0194 Williams Forge Suite 487\nEast Robinshire, NE 22531','+1-680-017-3827x58206','ubush@yahoo.com','Christianity','Ondo State','Ifedore','JSS3','A','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','No','Sight issues','+1-801-020-9374x69094','Jillian Rivers','13109 Martin Islands\nKimberlyborough, NM 77406','001-235-177-3763','Yes','Yes','Yes','Yes','No','Samantha Spence','(161)418-1572x7916','Teacher','5365 Emily Garden Apt. 986\nJosephton, LA 23149','Brother','Yes','A-','AS','1.42','50.1','',0,'1234',0),('196','Lauren Parks','Female','41586','Coxport','273 Martinez Squares Suite 461\nBridgetborough, NM 93990','023-778-0167','lrodriguez@bowman.com','Christianity','Ondo State','Akure North','JSS3','D','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','No','None','001-075-533-8548x4669','Rachael Payne','1485 Paula Fork\nNorth Jonathan, TN 12138','923.693.6666','No','Yes','Yes','Yes','No','Benjamin Parker','(452)067-1519x23290','Doctor','860 Jackson Lodge Apt. 565\nLeonardborough, OH 52178','Father','No','A-','AS','1.35','50.4','',0,'1234',0),('197','Amanda Arnold','Female','41436','North Michaelfurt','57968 Joseph Brook\nRobinmouth, MT 22875','001-526-917-5086x938','olevine@hotmail.com','Traditional','Ondo State','Ondo East','SS2','B','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','Yes','None','619.422.8024x21800','Breanna Smith','020 Park Oval Apt. 465\nNew Allisonfort, GA 33677','293772667','No','Yes','Yes','No','No','Frank Stephens','001-654-829-5019','Civil Servant','464 Carroll Mills Apt. 056\nLake Jesusburgh, NH 18371','Brother','Yes','AB+','AA','1.52','47.6','',0,'1234',0),('198','Henry Mccoy','Male','39197','New Johnfort','19167 Christopher Key Suite 743\nKatieside, WV 15992','6458162112','gilbertwalton@yahoo.com','Christianity','Ondo State','Okitipupa','SS3','C','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','Yes','Hearing issues','955-578-0658x8465','Christine White','87292 Melinda Plain\nMckeeview, KS 77156','819.679.4996x479','Yes','No','No','Yes','No','Summer Reynolds','+1-816-069-9900x2525','Civil Servant','PSC 0750, Box 3031\nAPO AE 67342','Uncle','Yes','O+','AA','1.37','49.8','',0,'1234',0),('199','Duane Hernandez','Male','38998','Brittneychester','539 Bonilla Heights Suite 897\nWest Shaneport, RI 21526','=1-21-379-4438','kennethruiz@terry-lopez.biz','Traditional','Ondo State','Ifedore','SS2','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','Yes','Hearing issues','(307)494-8938','Lauren Ortega','5553 Colon Club Apt. 466\nEast Kimberlyville, IN 17700','1137875407','Yes','No','No','No','No','Brian Taylor','001-330-489-4641x799','Trader','6835 Nichole Hills\nJerryview, NC 85007','Sister','Yes','B-','AA','1.4','73.3','',0,'1234',0),('2','Heather Jones','Female','41172','Manuelton','01722 Michael Stream Apt. 551\nChristensenfurt, AR 97513','(660)549-8736','ashley34@hotmail.com','Islam','Ondo State','Akoko South-West','SS3','A','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','Yes','Hearing issues','868815987','Tina Diaz','490 Kelly Harbor\nLake Joseville, NM 69521','6153307289','Yes','Yes','No','Yes','Yes','Erin Moreno','467.834.2919x30222','Civil Servant','428 Murray Road Suite 722\nRobersonfort, OK 47423','Mother','Yes','AB-','SS','1.57','55','',0,'1234',0),('20','Rachel Wilson','Female','40096','Grantland','146 Greg Stream\nLake William, OH 97768','(572)280-3914','zwilcox@gmail.com','Christianity','Ondo State','Akure North','SS1','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','Yes','Hearing issues','=1-336-16-5258','Savannah Smith','88862 Clark Alley\nBryanside, NE 12150','=1-643-776-8502','No','No','No','Yes','No','Roger Medina','001-492-393-6775x7201','Trader','101 Meghan Trail Suite 295\nSouth Pamelaview, ID 87077','Aunt','No','AB+','AA','1.45','70','',0,'1234',0),('200','Michelle Perez','Female','41195','East Kimburgh','22568 Sara Camp Apt. 908\nPort Natalie, HI 01921','001-885-206-2976','robin65@gmail.com','Traditional','Ondo State','Akure South','JSS2','B','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','Yes','Hearing issues','1364431514','Anthony Arnold','5299 Kim Vista Suite 697\nRandolphshire, AR 79236','+1-293-752-6294x5889','Yes','No','Yes','Yes','Yes','Jenna Neal','5855391088','Engineer','25859 Brendan Bridge\nConleystad, AZ 61430','Sister','Yes','O-','SS','1.74','40.4','',0,'1234',0),('21','Troy Bruce','Male','39941','North Jeffreytown','47175 Laura Squares\nEast Stephen, ME 45651','396-236-6687x59306','druiz@howard.com','Traditional','Ondo State','Ifedore','JSS1','C','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','Yes','Sight issues','236.207.9006x80400','Andrea Anderson','7007 Rojas Track Suite 259\nEast Rachel, GA 84571','326.934.5955','No','No','Yes','No','Yes','Cory Smith','(221)366-3868','Trader','642 Johnson Bypass Apt. 481\nSouth Jennifermouth, ID 27709','Uncle','Yes','B-','SS','1.42','88.1','',0,'1234',0),('22','Brian Simpson','Male','42172','New Christineport','092 James Underpass Suite 707\nRyanhaven, CT 63389','(022)959-6252','paulabishop@gmail.com','Traditional','Ondo State','Okitipupa','SS2','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS3','No','Hearing issues','001-722-301-1945x43169','Carl Brown','050 Mendez Lake\nSouth Marie, MI 29849','968-918-8279','Yes','Yes','Yes','Yes','No','Shawn Hayden','+1-337-226-9086x8402','Teacher','26626 Jamie Rue Apt. 983\nLake Maryton, FL 61681','Father','Yes','B+','AS','1.52','52.5','',0,'1234',0),('23','Donna Davis','Female','42216','East Amy','6542 Moore Springs\nMitchellland, RI 16434','292-493-6283','allenwendy@gmail.com','Christianity','Ondo State','Ese Odo','JSS1','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','No','Asthma','+1-060-574-1671x7747','Daniel Key','99038 Martin Oval\nRhodeschester, OR 22785','300.391.9225x94028','No','Yes','No','No','No','Anthony Graham','(291)489-5243','Farmer','Unit 1704 Box 8009\nDPO AP 70808','Mother','Yes','A-','AS','1.6','63.6','',0,'1234',0),('24','Mark Walter','Male','42086','Michaelborough','1212 Baker Corners\nDonnaberg, AR 76042','844-190-5376x1959','obriennicholas@soto.com','Traditional','Ondo State','Akure North','SS1','A','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','No','None','850-146-9911x756','Jeffrey Orozco','3003 Garrett Island\nNew Mariaton, DC 71093','(517)999-6175x166','Yes','No','No','Yes','No','Gary Hernandez','600-526-0426x67863','Engineer','3374 Osborn Lock\nWest Desiree, SD 79769','Aunt','Yes','A-','SS','1.5','72.2','',0,'1234',0),('25','Katherine James','Female','41400','Austinfurt','83741 Ashley Canyon\nNorth Matthew, NH 76335','+1-614-718-9938x20433','christineryan@martin-king.com','Traditional','Ondo State','Ese Odo','SS3','A','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','Yes','Hearing issues','608-769-7405x94556','Jerry Brooks','51706 Kimberly Loaf\nEast Sierra, AL 70394','056.591.3781','No','No','No','Yes','Yes','Jeffrey Hill','321697717','Trader','4044 Odonnell Branch Suite 761\nTravisshire, KY 58642','Father','No','B-','SS','1.31','52.8','',0,'1234',0),('26','Timothy Marshall','Male','40478','Justinstad','76456 Melissa Fork Apt. 670\nSouth Amandaberg, IN 06411','779-469-3443x639','steinmelissa@thompson.info','Christianity','Ondo State','Ile Oluji/Okeigbo','SS1','A','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','Asthma','644.406.8837x639','Robert Barber Jr.','USNS Dean\nFPO AA 97368','=1-545-470-357','Yes','No','No','No','No','Susan Hickman','=1-485-45-8484','Farmer','48441 Sullivan Burg\nWest Christophertown, AK 41256','Uncle','Yes','O-','AA','1.3','57.8','',0,'1234',0),('27','Jeffrey Schmidt','Male','39222','Lake Mariahhaven','65246 Hamilton River Apt. 782\nPort Jermaineside, MT 76722','(547)779-6036','angela42@hotmail.com','Christianity','Ondo State','Akoko South-East','JSS1','A','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','No','Sight issues','295.535.2575x399','Jason Bauer','06084 Brett Fields\nSouth Robertland, MT 77797','+1-456-800-5262x91765','No','Yes','No','No','No','Eric Adams','001-759-309-2963x1625','Farmer','35368 Clark Loaf\nSouth Kylemouth, NV 10531','Uncle','No','B-','AA','1.54','64.1','',0,'1234',0),('28','Evan Bell','Male','41165','Haneyland','43486 Vanessa Skyway\nLake Daniel, IN 43518','+1-977-182-7029x26413','kathleenmiranda@hotmail.com','Traditional','Ondo State','Akoko South-East','SS2','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','No','Hearing issues','001-537-597-3158','Wayne Garcia','912 Andrea Rue Suite 827\nCatherineberg, NM 09399','(732)223-7967x841','Yes','Yes','No','No','Yes','Michael Hicks','(579)787-9705','Trader','2095 Abigail Fall\nPort Lindaberg, DE 89483','Uncle','No','AB-','AA','1.59','86','',0,'1234',0),('29','Sarah Holmes','Female','39003','Lewishaven','108 Davis Valleys\nNew Brittanystad, LA 28248','(230)733-5132x9934','briannacampbell@garner.com','Islam','Ondo State','Akoko South-West','JSS2','A','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS1','Yes','None','8705199870','Tammy Smith','6890 Parker Cliff Apt. 362\nOrtegaport, CA 90415','389-121-0401','No','Yes','No','Yes','Yes','Kyle Warner','(823)835-1165','Civil Servant','5465 Julie Port\nPort Ronald, FL 66237','Father','No','B+','AS','1.56','49.4','',0,'1234',0),('3','Melinda Morris','Female','39044','New Kyleberg','9396 Joseph Divide Apt. 455\nMyersstad, VT 24801','436.936.1865x87088','lbrooks@mitchell.net','Traditional','Ondo State','Ese Odo','JSS3','B','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','Yes','Asthma','(641)364-8505x90628','Deborah Gutierrez','64085 Joel Junctions\nWest Nicoleland, SD 77208','806-785-6923x82885','Yes','No','Yes','Yes','Yes','Cheryl Taylor','9224213930','Teacher','29427 Willis Field Suite 488\nJeffreyshire, NV 60724','Mother','Yes','A-','AA','1.37','85.9','',0,'1234',0),('30','Stephen Weaver','Male','39521','East Markborough','43285 Mark Neck Suite 270\nWilliamchester, VA 10627','(445)712-8044','georgesimon@gmail.com','Islam','Ondo State','Owo','JSS2','A','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','Yes','Asthma','(885)873-3039x395','Keith Torres','7970 Robinson Spurs\nNew Lisaburgh, KS 44615','298.494.4040','No','No','Yes','No','No','Sarah Gonzales','694.990.2004','Farmer','3525 Lawson Port\nLake Kaylaburgh, MA 40304','Sister','Yes','B+','AA','1.37','69.2','',0,'1234',0),('31','Sarah Perez','Female','41425','Mcdanielville','59765 Scott Lakes Suite 649\nPort Timothyville, HI 58702','964.572.5541','buchananjessica@gmail.com','Islam','Ondo State','Ilaje','SS1','C','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS1','Yes','Asthma','(245)918-3159x645','Christina Higgins','28155 Timothy Village\nJamesside, OR 79089','001-888-156-5158x091','No','No','Yes','No','Yes','Richard Reese','(463)014-7633x096','Engineer','86304 Gutierrez Springs Apt. 421\nDurhamborough, NH 11035','Sister','No','A-','AS','1.82','65.4','',0,'1234',0),('32','Danielle Noble','Female','40676','Justinberg','5235 Peters Junction\nNealhaven, RI 40878','547.557.4118x0744','umcdaniel@hotmail.com','Christianity','Ondo State','Akoko South-West','SS1','C','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','No','Sight issues','(044)278-9716','Andrew Salazar','4359 Hayes Route Suite 868\nDianaton, OK 37139','572.983.9112x17232','Yes','No','Yes','Yes','Yes','Maria Bradshaw','604-828-1030x493','Doctor','53915 Daniel Valleys Suite 689\nMichaelburgh, MO 63536','Mother','Yes','A+','AA','1.71','45.8','',0,'1234',0),('33','Michelle Mitchell','Female','39364','North Kristopher','0331 Silva Lodge\nEast Mary, NE 30932','+1-474-330-4007x80304','timothyburgess@franklin.com','Traditional','Ondo State','Odigbo','JSS3','B','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','Yes','Asthma','3902183073','Jeremiah Dillon','96190 Wade Harbors\nMichaelhaven, ND 88517','820.355.0505','No','Yes','Yes','No','Yes','Vanessa Duncan','338.193.5743x747','Farmer','41404 Turner Square\nChristopherfurt, NH 80616','Aunt','No','B+','AA','1.8','77.7','',0,'1234',0),('34','Elizabeth Simmons','Female','40301','South Michaelville','837 Javier Keys\nWest Katherine, MS 54154','(431)523-7122x06473','baileywanda@hotmail.com','Traditional','Ondo State','Owo','SS3','A','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','Yes','Sight issues','769-477-1152','Linda Garza','5572 Desiree Trafficway\nPort Marymouth, TX 29273','(564)812-9891x45967','No','No','No','No','No','Robert Cook','958-310-0950x837','Farmer','3124 Rivera Brooks\nBakertown, VT 21190','Aunt','Yes','AB+','AS','1.5','64.6','',0,'1234',0),('35','Patrick Richardson','Male','40727','Richardmouth','05312 Roach Spur Suite 305\nMitchellbury, LA 94654','3933638230','nmccoy@gmail.com','Islam','Ondo State','Akoko North-West','SS3','A','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','No','Sight issues','598.427.5304','Alan Gutierrez','48324 Wagner Hollow\nMcdanielhaven, VA 78189','001-808-418-1762','Yes','Yes','No','No','No','Jeffrey Garrett','(653)658-6038','Civil Servant','9446 Matthew Ferry\nAndersonfort, OH 97746','Sister','Yes','A+','SS','1.74','43.9','',0,'1234',0),('36','Derek Harmon','Male','40836','New Alexandria','456 Krystal Passage Suite 780\nEast Gregory, UT 37781','418.116.7671x0316','jennifercampbell@hotmail.com','Christianity','Ondo State','Akoko South-East','JSS3','D','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS3','Yes','Sight issues','=1-523-603-4430','Dalton Knight','53169 Ortega Village Apt. 999\nSimschester, GA 48965','131.668.1743x4492','Yes','Yes','Yes','No','No','Douglas Rodgers','404-875-7095','Trader','7532 Tracey Drive\nWest Micheletown, NJ 44439','Uncle','Yes','A-','AA','1.35','43.2','',0,'1234',0),('37','Crystal Davis','Female','39797','Kristinafurt','44085 Adams Valleys Apt. 492\nLake Larryview, NJ 97077','496-317-1959','jenna37@ramirez-roberts.com','Christianity','Ondo State','Akoko North-West','JSS2','D','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS1','Yes','Sight issues','1056770232','Rachel Atkins','78295 John Center Suite 755\nPort Jamestown, SC 63717','=1-709-560-7103','No','No','Yes','Yes','Yes','Tim Boyle','001-015-099-9293x585','Trader','100 Michele Key\nHortonton, MO 52320','Brother','Yes','B+','AA','1.52','51.9','',0,'1234',0),('38','Rebecca Salas','Female','41413','Jomouth','11581 Courtney Ville\nSouth Johnnyland, SD 69425','(752)961-8987','mclayton@meyer.biz','Islam','Ondo State','Ese Odo','SS2','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','No','Asthma','805.796.2927x5251','Tyler Keith','71014 George Route Apt. 719\nPort Loriland, IL 29340','+1-325-256-8158x6385','No','Yes','Yes','No','Yes','Sandra Chung','113.007.1578x560','Engineer','384 Mendoza Village\nSouth Lisa, IN 59185','Brother','No','O+','AS','1.47','47.3','',0,'1234',0),('39','William Wilson','Male','40505','West Brittanyton','4503 Johnson Stravenue Suite 219\nLake Rebecca, MT 89893','530.877.0478x143','henry26@white.com','Christianity','Ondo State','Ondo West','SS3','D','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS2','Yes','Asthma','6534611451','Anne Miller','652 Patterson Trail\nCaitlinborough, UT 98933','(308)614-0325x13363','No','Yes','No','Yes','No','Donald Hutchinson','(435)075-1322x39473','Teacher','76594 Moore Island\nEast Emily, IL 73864','Sister','No','B-','AA','1.48','67.3','',0,'1234',0),('4','Hannah Price','Female','39724','North Nathanbury','68368 Anne Streets\nPort Cody, IL 26999','001-666-499-2109x598','panderson@gmail.com','Christianity','Ondo State','Ifedore','SS3','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','No','None','810-288-2084x2259','Kimberly Butler','3318 Eric Shore\nHallville, NV 69945','+1-629-319-0081x0379','No','No','Yes','Yes','Yes','Laura Escobar','(460)821-8840x971','Farmer','55349 Patrick Shoals\nSandraville, LA 69908','Sister','No','A+','SS','1.48','71.7','',0,'1234',0),('40','Laura Nixon','Female','39965','Davidfurt','PSC 1360, Box 0545\nAPO AP 76351','(854)870-9693x40822','shanepeterson@rodriguez.org','Traditional','Ondo State','Ondo West','SS3','C','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','Yes','Hearing issues','194-310-8661x9180','Jose Martin','4280 Jennifer Crescent\nNorth Williamton, NM 99196','471-103-0503','No','Yes','No','No','No','Mrs. Laurie Mendoza','(862)120-0417x146','Civil Servant','571 Murphy Branch Suite 150\nBryanborough, NC 58141','Mother','Yes','O+','AA','1.7','47.6','',0,'1234',0),('41','Jessica Hines','Female','41141','Port Brandonhaven','2001 Rogers Knoll Suite 677\nSouth Jonathon, WA 28703','917.244.0301x16494','xcalderon@bennett.com','Islam','Ondo State','Akure South','JSS1','D','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','Yes','Asthma','945.481.7411x7582','John Montgomery','0398 Murphy Alley\nWest Walterstad, NY 56357','(508)828-4812x32587','No','Yes','Yes','No','Yes','John Martinez','480.623.3507x0494','Doctor','856 Hall Springs\nSouth Samanthaport, WY 64863','Uncle','No','AB+','AS','1.5','43','',0,'1234',0),('42','Jeremy Johnson','Male','41638','Ashleyfurt','182 Mcdonald Passage Apt. 795\nPaulview, WI 06016','+1-611-737-1887x05654','nelsondonna@hotmail.com','Traditional','Ondo State','Akure North','SS2','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS2','Yes','Sight issues','159.575.3829x26480','Jerry Cunningham','2016 Anne Mountain\nNorth Sarahfort, KS 90241','(756)656-7814','Yes','Yes','Yes','Yes','No','James Wells','840-895-0814','Civil Servant','5478 Teresa Expressway Apt. 682\nMitchellburgh, TN 06521','Uncle','Yes','O+','AA','1.4','64.3','',0,'1234',0),('43','Timothy Hill','Male','40113','Andretown','PSC 1972, Box 9015\nAPO AA 18438','58028369','josephrios@friedman-barry.com','Christianity','Ondo State','Akoko North-West','SS1','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','Yes','Sight issues','(284)024-4608','Travis Burton','19976 Michael Inlet\nRussellshire, CA 50536','+1-790-800-7878x516','Yes','No','No','Yes','No','Katherine Smith','001-443-758-4705','Civil Servant','5789 Jason Cliff Apt. 280\nKatherinestad, WA 84420','Uncle','No','O-','AS','1.5','48.6','',0,'1234',0),('44','Jason Massey','Male','39650','Timothyton','Unit 2097 Box 4323\nDPO AP 11425','193.042.3378','bshepherd@yahoo.com','Islam','Ondo State','Ilaje','JSS1','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','No','None','+1-529-994-7266x7389','Kimberly Kelly','8112 Richardson Turnpike Apt. 465\nEast Aliciahaven, WV 33905','(161)280-6547x030','No','No','No','Yes','Yes','Nancy Gallegos','756.681.5433','Civil Servant','8411 Kathryn Circle\nEast Rachel, OR 04826','Sister','Yes','O-','AA','1.81','42','',0,'1234',0),('45','Scott Ward','Male','42047','East Larryside','245 Clinton Causeway\nNorth Jessicamouth, CT 95056','876.143.1015x01267','maynancy@yahoo.com','Islam','Ondo State','Idanre','SS3','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','Yes','Hearing issues','058-199-9266x44523','Steven Hernandez','905 Michael Summit\nLewismouth, CT 01604','3267480001','No','No','Yes','No','Yes','Melissa Edwards','615-175-0303','Engineer','38329 Todd Creek Apt. 312\nSouth Heather, AK 85211','Aunt','No','O+','SS','1.78','86.7','',0,'1234',0),('46','Jonathan Olson','Male','39468','Johnchester','USNV Young\nFPO AP 58096','6499756267','brittneylutz@miller.org','Christianity','Ondo State','Akure North','SS3','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','Primary 6','Yes','Hearing issues','539.156.6252x824','Amanda James','4600 Smith Locks\nNew Andrea, UT 72105','991.258.4320','No','Yes','No','Yes','No','Mary Wood','001-268-887-0569x74677','Trader','66192 Smith Canyon\nSouth Kevin, AK 10789','Uncle','Yes','O-','AA','1.89','59.6','',0,'1234',0),('47','Kelly Bailey','Female','40247','Anaside','84709 Daniels Points Suite 677\nEast Tonyville, WA 50281','(637)403-2721x384','barryeduardo@mcdonald-herman.com','Traditional','Ondo State','Akure South','JSS2','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS1','No','Asthma','(064)509-1051','Lauren Bailey','535 Rachel Branch\nLake Christina, AL 54492','597-287-7894','No','Yes','No','Yes','No','Kayla Shaw','145.150.4310','Engineer','8470 Todd Spur Apt. 061\nSilvamouth, FL 10413','Brother','Yes','B+','SS','1.48','71.1','',0,'1234',0),('48','Eric Davis','Male','41288','South Gregoryshire','7709 Brandon Hollow Suite 142\nWest Kara, UT 16912','273-879-6595x7763','cbarnes@yahoo.com','Traditional','Ondo State','Ese Odo','SS2','B','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','Yes','Asthma','(228)674-3536','Edwin Michael','7681 Bailey Station Apt. 377\nChangville, AL 08223','001-193-955-4223','Yes','Yes','No','Yes','No','Jennifer English','531-709-7125','Doctor','57725 Barron Drive Suite 751\nJeffreyburgh, NJ 83908','Uncle','No','O+','AA','1.71','63.1','',0,'1234',0),('49','Alyssa Hendrix','Female','40279','West Erinbury','2233 James Cape\nChristopherview, ID 67211','001-448-376-1939x47911','westcharles@campbell-taylor.com','Islam','Ondo State','Ese Odo','JSS3','D','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','Primary 6','No','Asthma','(635)768-8699','Christopher Williams','16576 Mary Squares\nPort Jessicaland, OK 99295','(292)974-8210x871','No','Yes','Yes','Yes','No','Deanna Brown','(383)852-6861x525','Doctor','4973 Newton Fork Suite 015\nMariostad, ID 91142','Uncle','No','B+','AA','1.62','65.9','',0,'1234',0),('5','Caitlin Kelly','Female','39739','Port Lindseyfort','3378 Meagan Extension\nSouth Adamview, IA 24867','(174)366-3786x487','billystevens@gmail.com','Traditional','Ondo State','Ose','SS2','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','Yes','Hearing issues','896-481-6966x45644','Alexa Brooks','290 Davila Islands\nNorth Bonniefurt, MN 16337','001-109-929-5911x541','No','No','No','Yes','Yes','Beth Hoffman','8752826655','Teacher','311 David Forest\nSingletonbury, CO 40499','Mother','No','AB-','AS','1.77','59.2','',0,'1234',0),('50','Rachel Thompson','Female','40960','New Shannon','572 Briggs Port Suite 814\nHansenfurt, KY 12738','(192)372-1444','bgonzalez@hotmail.com','Traditional','Ondo State','Ondo East','JSS2','C','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS3','No','Sight issues','146.110.4290x75685','Carolyn Webb','217 Rodney Shore\nEast Kelly, MS 99002','(996)961-2355','No','No','No','No','Yes','Karen Kelly','371-673-5886x856','Trader','4132 William Gateway Apt. 219\nSouth Travistown, CT 70308','Father','No','B-','SS','1.47','53.1','',0,'1234',0),('51','Edgar Figueroa','Male','40957','West Joe','Unit 4797 Box 8313\nDPO AA 59914','001-237-819-7192','srhodes@bowen.com','Islam','Ondo State','Ondo West','SS3','B','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','No','Asthma','029-000-4296x9845','Cassandra Horton','4612 Crystal Lake\nVillanuevahaven, UT 62744','+1-906-533-7219x3181','Yes','Yes','Yes','Yes','Yes','Gary Hernandez','(996)966-6392','Civil Servant','618 Vargas Harbor\nSouth Christina, MO 04567','Aunt','Yes','AB-','AS','1.87','66.3','',0,'1234',0),('52','Aaron Bentley','Male','40862','Copelandtown','59461 Myers Extensions Apt. 562\nSarahhaven, MO 26479','+1-820-721-0626x3077','lauren28@smith.net','Islam','Ondo State','Irele','SS1','B','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','No','Sight issues','+1-448-705-7853x65772','Devin Smith','35674 Eric Lights\nSouth Audrey, SC 46836','001-610-315-6441','Yes','No','No','Yes','No','Kelly Holmes','=1-318-948-9207','Farmer','3166 Cassandra Gateway Suite 677\nShaunbury, NV 80226','Mother','Yes','O-','AA','1.79','84.6','',0,'1234',0),('53','David Walker','Male','42224','New Melissaview','USNV Franco\nFPO AE 89653','(018)025-1948x45129','ricky03@yahoo.com','Islam','Ondo State','Ondo East','JSS1','B','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','Primary 6','No','None','586-091-1630x340','Alexis Rowe','535 Lindsay Lodge Apt. 358\nJasonview, AZ 22134','+1-932-024-8964x5370','Yes','No','Yes','Yes','No','Courtney Taylor MD','(486)679-5270x4377','Farmer','2675 Elizabeth Rest\nKimberlystad, CO 90714','Brother','Yes','AB+','AS','1.38','86.1','',0,'1234',0),('54','Sharon Martin','Female','39452','Lake Corymouth','4533 Christy Points Apt. 497\nMcphersonville, AR 60617','644.900.3466x0323','annette67@nolan-fitzpatrick.com','Islam','Ondo State','Odigbo','JSS3','C','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','Yes','Sight issues','(883)981-2316x7745','Jennifer Thomas','48780 Rachel Expressway\nLake Richard, FL 99769','159.974.0265x3316','No','No','Yes','Yes','Yes','Jonathan Foster','+1-703-673-4120x99713','Doctor','19548 Henry Overpass\nPort Kristin, WY 81435','Father','Yes','A-','AA','1.32','76.9','',0,'1234',0),('55','Ronald Sullivan','Male','41190','Perryton','7890 Gardner Route Suite 932\nMerrittfurt, MO 87869','(279)842-5832','omorales@gmail.com','Christianity','Ondo State','Ilaje','JSS2','C','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','No','Sight issues','315-206-5062x42449','Joseph Clark','976 Timothy Roads\nCarlville, MI 38956','455-147-1434','Yes','No','Yes','Yes','No','Karen Turner','622.343.1001','Doctor','33991 Mary Forest Suite 150\nWardshire, WV 71492','Uncle','No','AB-','SS','1.37','61.8','',0,'1234',0),('56','Tony Adams','Male','42184','North Jamesbury','72867 Jeanne Throughway Suite 643\nGillfort, IL 70622','001-994-424-2038','angela88@murphy.com','Islam','Ondo State','Irele','SS1','C','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','Yes','Asthma','535-392-1873','Theresa Hamilton','PSC 6090, Box 3296\nAPO AP 40117','+1-843-593-0908x11134','No','Yes','Yes','Yes','Yes','Susan Thompson','849-393-5903x46516','Trader','170 Diaz Burg\nMartinmouth, SD 13531','Mother','No','O+','SS','1.82','81.5','',0,'1234',0),('57','Amanda Steele','Female','41431','Port Caitlinberg','74315 Hardin Harbor\nWatsonborough, MS 19898','001-115-452-6149x785','pphillips@hotmail.com','Christianity','Ondo State','Irele','JSS1','B','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','No','Sight issues','410.701.9065','Mercedes Sampson','7374 Lindsey Meadow\nNorth Barbara, ME 17012','(722)558-3828','No','No','Yes','Yes','No','Martha Miller','+1-412-836-6122x0725','Teacher','5407 Camacho Station\nNew Kathryn, NY 45401','Aunt','No','O-','SS','1.83','85','',0,'1234',0),('58','Robert Guerra','Male','39817','Christopherfurt','021 Andrew Mills Suite 423\nMckenzieburgh, MT 30546','6455898924','lindsey65@boyd.org','Christianity','Ondo State','Ondo East','SS2','A','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','Sight issues','(673)716-4947x840','Douglas Robinson','68309 Shane Via\nWest Jesus, RI 12684','7228252394','No','Yes','Yes','Yes','Yes','Mrs. Christina Chandler','(733)454-5947x917','Farmer','19739 Thomas Freeway\nJenniferhaven, WI 03688','Mother','Yes','B+','SS','1.37','42.4','',0,'1234',0),('59','Ronald Porter','Male','41250','West Taraview','3439 Nicole Park Apt. 111\nMillerview, AR 08079','+1-295-345-5402x4221','jordan21@gmail.com','Christianity','Ondo State','Akure North','SS2','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS1','No','Asthma','001-847-701-5298x6762','Joseph Ray','Unit 9424 Box 5211\nDPO AE 33188','=1-846-459-1021','No','Yes','Yes','No','Yes','Steven Wilson','744-607-1485x784','Trader','USS Lee\nFPO AA 03064','Uncle','Yes','B-','SS','1.56','71.1','',0,'1234',0),('6','Jennifer Bullock','Female','41714','North Amytown','553 Brown Ways Suite 760\nRobertmouth, OH 91781','609-914-8242x4177','mthompson@hotmail.com','Islam','Ondo State','Irele','SS1','B','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','Primary 6','Yes','Hearing issues','001-894-396-3292','Jennifer Perry','2499 Smith Walks\nBarretthaven, NC 85368','+1-285-933-6970x3058','Yes','No','No','Yes','No','Joseph Koch','711-614-1789x066','Doctor','34322 Jackson Route Suite 881\nMonicabury, TX 70323','Uncle','No','B+','AA','1.8','56.8','',0,'1234',0),('60','Mindy Hanson','Female','39050','Gomezfort','95524 Perez Ferry Apt. 186\nWest Kristen, MO 99349','+1-507-154-7610x6569','collinskimberly@randall.com','Islam','Ondo State','Ose','SS1','B','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','No','None','014.307.6450x15660','Steven Rojas','630 Kevin Shoals Apt. 517\nThomasberg, KY 43277','001-437-484-9174x6274','Yes','No','No','No','No','Johnny Powers','+1-274-120-5001x86246','Trader','97136 Hartman Pass\nLloydfort, GA 33800','Aunt','No','AB-','AS','1.66','86','',0,'1234',0),('61','Joshua Schwartz','Male','40085','New Taylorburgh','71887 Hardy Bypass\nJillburgh, OK 67272','+1-816-612-9734x2170','swatson@gmail.com','Islam','Ondo State','Akoko South-West','JSS3','C','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS1','No','Asthma','(601)240-8305x5977','Andrea Bonilla','12760 Arias Route\nWilliamburgh, ME 36557','536-199-5586x027','Yes','No','Yes','No','Yes','Dean Mccullough','+1-894-607-3286x545','Doctor','PSC 4666, Box 9985\nAPO AP 74080','Father','Yes','O-','SS','1.63','49.5','',0,'1234',0),('62','Frank Fleming','Male','39852','West Joshuamouth','64236 Melissa Road\nWest Robertbury, UT 41345','001-918-591-8021','andrewgillespie@wells-mcdaniel.com','Islam','Ondo State','Akoko North-East','JSS2','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','Primary 6','No','Hearing issues','045-596-5406x111','Nicholas Gonzalez','USS Reed\nFPO AA 43522','265.513.4881x288','No','Yes','Yes','Yes','No','Cynthia Cantu','(181)191-1210','Teacher','3343 Smith Club\nEast Jennifer, UT 38670','Brother','No','AB+','AS','1.72','87.7','',0,'1234',0),('63','Roy Hernandez','Male','41599','Cynthiabury','60025 Gonzalez Well\nLake Derrick, MD 13264','281.239.2869x67146','mooneydaniel@yahoo.com','Christianity','Ondo State','Akoko North-West','JSS3','D','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','Yes','Asthma','=1-355-378-1006','Gina Brown','PSC 5883, Box 6780\nAPO AE 61004','351.584.0639','No','No','Yes','No','Yes','Dr. Leah Hill','353-814-5196','Civil Servant','11033 Harris Estate Apt. 651\nSmithshire, AR 43428','Brother','Yes','B+','AS','1.71','64.4','',0,'1234',0),('64','Derrick Frazier','Male','39079','South Kimberlyview','5301 Nelson Terrace\nSanchezburgh, ND 67050','749-089-3682','juliebarnes@cox-nunez.biz','Christianity','Ondo State','Akoko South-East','JSS3','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','Primary 6','No','Hearing issues','667.915.4657','Chelsea Morris','083 Chloe Track Suite 342\nSouth Suzanne, SC 34907','001-285-210-3886x367','No','No','Yes','Yes','No','Diana Robinson','=1-815-233-7848','Engineer','25805 Lisa Island Suite 113\nWheelerfort, HI 71337','Brother','Yes','O+','AA','1.75','82.5','',0,'1234',0),('65','John Russell','Male','41158','Chanchester','79372 Strickland Fields\nEast Joshua, MA 70333','774.265.5188x393','cassandra79@combs.com','Christianity','Ondo State','Irele','JSS1','C','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','Yes','Sight issues','(807)288-1083x1537','Mary Castillo','Unit 1201 Box 8766\nDPO AP 29963','687.804.9979','Yes','Yes','Yes','Yes','Yes','Mr. Kyle Hall DVM','+1-404-401-2257x1232','Farmer','1181 Kim Dam\nNelsonfurt, WV 40161','Aunt','No','AB+','AS','1.73','67.1','',0,'1234',0),('66','Daniel Jimenez','Male','41002','Warrenville','59851 Evans Isle\nShaunborough, MD 25251','=1-30-247-3421','aaronwade@yahoo.com','Islam','Ondo State','Akure North','SS2','B','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS1','No','Hearing issues','101-478-7675x4106','Kelly Carter','976 Steven Lane Apt. 389\nDanielville, AK 90912','410-075-9678x2577','No','No','No','No','Yes','Phillip Ryan','(889)136-0106','Farmer','8094 Russell Expressway\nAndrewmouth, NH 12374','Uncle','Yes','A+','AS','1.73','87.5','',0,'1234',0),('67','Evan Cox','Male','41686','North Vickieberg','09472 Brenda Ramp\nEast Brian, NJ 02966','=1-535-354-9895','tammybrown@hotmail.com','Islam','Ondo State','Ose','JSS3','C','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','Yes','None','+1-457-158-4056x76229','Jane Oliver','85077 Samantha Turnpike Suite 801\nLoveville, NV 53459','156.098.0321x8714','Yes','No','No','No','No','Micheal Parker','001-942-729-9257x258','Farmer','51395 Smith Run Apt. 395\nNorth Michelle, MI 49814','Sister','No','A+','AS','1.76','64.4','',0,'1234',0),('68','Howard Gonzalez','Male','42187','Nancyland','288 Vargas Fork Apt. 123\nSouth Tanya, IN 07608','283-573-6226x47830','floresjoseph@ramirez.com','Christianity','Ondo State','Idanre','JSS1','D','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','Yes','Asthma','(048)328-1205','Laurie Morris','817 Reilly Mission Apt. 798\nSouth Breannaport, ND 11139','+1-327-111-0065x025','Yes','No','No','Yes','No','Julie Vazquez','676-144-5763x309','Engineer','765 Miranda Ports\nKarenhaven, IN 89563','Mother','Yes','A-','AA','1.73','55.2','',0,'1234',0),('69','Paul Walters','Male','41594','Kristaville','43843 Zachary Groves\nGregoryshire, ND 08850','=1-794-413-9061','rreynolds@lin.com','Traditional','Ondo State','Idanre','SS1','A','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','Yes','Hearing issues','+1-257-058-2972x0139','Alexander Lopez','667 Baldwin Brooks\nSouth Melissa, GA 92328','(826)020-9838','Yes','Yes','Yes','No','Yes','Catherine Armstrong','575.072.1656','Doctor','1088 Rice Wells Apt. 869\nNorth Dianaview, NE 61854','Uncle','No','AB+','SS','1.59','49.5','',0,'1234',0),('7','Michael Bryan','Male','39466','Jameschester','457 Clark Street Apt. 797\nEast Crystalstad, NJ 33783','001-412-080-3848','richmondcurtis@thompson-johnson.biz','Islam','Ondo State','Ese Odo','SS3','A','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','No','Hearing issues','4451185961','Andrew Meadows','9948 Clark Dam Suite 482\nNorth Johnathan, MO 59662','+1-639-642-9787x02764','No','No','Yes','No','Yes','Kenneth Jenkins Jr.','001-191-950-7795x6112','Doctor','96004 Alexander Freeway Apt. 996\nWoodsport, NV 06824','Brother','Yes','AB+','AA','1.88','60.7','',0,'1234',0),('70','Karen Chambers','Female','39493','Matthewbury','PSC 1709, Box 9829\nAPO AP 19802','2593313677','eringarner@hotmail.com','Islam','Ondo State','Ilaje','SS1','C','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','Yes','Hearing issues','+1-651-514-5058x148','Charles Martin','985 Craig Greens\nPort Mark, RI 56708','999-491-8730x4028','No','Yes','Yes','No','No','Shelby Butler','+1-998-158-9652x2635','Farmer','6937 Christopher Mission Apt. 239\nNew Richard, GA 98635','Sister','No','AB+','AA','1.56','72','',0,'1234',0),('71','Nancy Acosta','Female','41344','South Joseph','3970 Ruiz Shores Suite 172\nWest Hannahport, DE 87972','222-853-1941x163','samuel12@yahoo.com','Traditional','Ondo State','Akoko South-East','JSS2','B','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS3','Yes','Sight issues','=1-831-284-9548','Michael Rogers','859 Shepherd Manor\nLake Autumnstad, NJ 81808','416-888-2971','No','No','Yes','Yes','No','Jonathan Smith','5634498167','Engineer','98267 Eric Ports\nEast Johnland, SD 09792','Sister','No','B-','AS','1.43','47','',0,'1234',0),('72','Molly Johnson','Female','39557','Migueltown','40786 Reynolds Village Apt. 828\nJosephview, SD 67476','001-696-591-5405','halejoshua@thompson-brown.org','Christianity','Ondo State','Idanre','SS3','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','No','Asthma','(815)905-5905x3050','Matthew Ortega','7555 Martinez Union\nCooktown, VA 73767','6150860716','No','No','Yes','Yes','No','Julia Hess','+1-482-149-4433x27604','Trader','804 Booth Skyway\nWest Daniel, MN 76048','Uncle','No','B-','AA','1.45','84.6','',0,'1234',0),('73','Jose Jones','Male','41220','North Sarahberg','1154 Nicole Shore Suite 016\nWest Charles, CA 05081','(856)748-5874x81307','allenhanson@hotmail.com','Islam','Ondo State','Akoko South-East','JSS3','A','2024/2025','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS3','No','Asthma','867-944-6876','Eric Munoz','144 Sarah Hollow Suite 756\nJosefort, TN 08107','507.402.7208','Yes','No','No','Yes','Yes','Christine Brown','(887)359-4863','Trader','047 Lisa Station\nEast Katherine, RI 72803','Brother','No','O+','SS','1.84','65.5','',0,'1234',0),('74','Melinda Baldwin','Female','41541','Port Mario','2908 Brooks Courts Suite 094\nEast Laurenstad, WI 09382','282-575-0448','katherinenicholson@guzman.info','Islam','Ondo State','Ifedore','SS1','B','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','Primary 6','Yes','Asthma','(211)984-6731x41254','Joseph Robinson','5649 Philip Plains\nSarahside, GA 45102','486.198.5728','No','No','No','No','Yes','Sean Garcia','469.651.4857x158','Farmer','PSC 6255, Box 7739\nAPO AA 11497','Brother','Yes','B-','AS','1.81','84.2','',0,'1234',0),('75','Christopher Garcia','Male','40722','West Amy','6478 Brittany Fields\nHuberland, CT 03242','580.596.6694x47736','holly00@hotmail.com','Islam','Ondo State','Ese Odo','SS2','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','Primary 6','Yes','Sight issues','001-776-693-1773x5423','Elizabeth Hardin','56305 Reyes Fork Suite 607\nSouth Juliastad, TN 20644','225.907.4002x616','Yes','Yes','No','Yes','No','Robert Fitzgerald','5589926770','Doctor','353 Richard Prairie\nSouth Lisa, ND 58813','Sister','Yes','A-','AS','1.78','72.9','',0,'1234',0),('76','Kiara Brown','Female','39687','South Kathleenstad','598 Garcia Parkways\nJohnton, HI 59559','001-770-881-1943x60197','perezallen@hotmail.com','Christianity','Ondo State','Akoko South-East','JSS3','C','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS3','Yes','Hearing issues','001-568-490-0957x597','Candace Marshall','813 Ruiz Ports\nNew Jennifershire, RI 19440','(762)957-2613x7405','No','Yes','Yes','No','No','Trevor Coffey','=1-456-279-778','Civil Servant','1563 Alvarez Streets\nBelltown, VA 50791','Father','Yes','B+','AA','1.8','59.3','',0,'1234',0),('77','Jennifer Gonzales','Female','41501','East Alison','9199 Alexa Club\nGarciachester, DC 00678','001-512-722-6065x04389','robertgardner@gmail.com','Traditional','Ondo State','Idanre','SS1','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS1','No','None','001-847-602-0241x2444','Chase Medina','0515 Cobb Road Apt. 547\nNorth Dorothyview, WV 90513','(802)743-3500x1946','No','No','Yes','Yes','No','Cynthia Bowman','7256133822','Engineer','02201 Cain Parks\nWest Jennifer, NY 44342','Brother','Yes','B+','AS','1.33','61.1','',0,'1234',0),('78','Erin Richards','Female','41324','Lewisside','84416 Christopher Islands\nMillerfurt, AZ 78996','457-578-8814x5712','lovevictoria@gmail.com','Islam','Ondo State','Idanre','SS2','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','Sight issues','001-155-727-1507','Samantha Mccarthy','2355 Shelly Glen\nRachelmouth, MI 59566','+1-704-088-0671x9956','Yes','No','Yes','No','Yes','William Brown','121.152.9502x144','Trader','83363 Brian Spurs Suite 184\nWalkerport, FL 85052','Aunt','Yes','A+','AA','1.83','72.6','',0,'1234',0),('79','Michael Bentley','Male','40299','North William','98099 Brown Loop\nSouth Richard, KY 80402','626-429-7417x668','david30@yahoo.com','Christianity','Ondo State','Ifedore','SS1','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Dancing','JSS3','Yes','None','001-219-148-9563x394','Tony Rogers','06353 Rodriguez Skyway\nLake Barbarabury, IA 32294','001-363-877-7229x8988','No','Yes','No','Yes','No','Erica Ryan','6226151755','Engineer','311 Jennifer Drives\nPort Charlene, WV 54352','Uncle','No','A+','AA','1.62','53.6','',0,'1234',0),('8','Donald Smith','Male','39038','Lake Michelemouth','950 Coleman Springs Suite 485\nSouth Beckyport, NH 17217','+1-757-865-7427x3705','jacquelineshah@martin.biz','Islam','Ondo State','Akoko North-West','SS2','B','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','Primary 6','No','Sight issues','736-623-6366','Jennifer Elliott','PSC 7316, Box 8361\nAPO AA 23813','702.786.3572','Yes','No','Yes','Yes','No','James Nicholson','286.022.6105x785','Trader','24504 Ray Mall\nWest Frederickfort, IA 46725','Brother','No','A-','AA','1.66','86.7','',0,'1234',0),('80','Timothy Reyes','Male','39339','Port Edgar','Unit 7276 Box 6052\nDPO AE 76030','=1-474-281-6477','scottcrawford@gmail.com','Islam','Ondo State','Akure North','SS3','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','Primary 6','Yes','Hearing issues','001-378-771-0424x85999','Phillip Torres','1590 Melinda Meadow Apt. 462\nRichardsview, NC 77971','=1-551-767-3422','Yes','Yes','No','No','No','Teresa Jenkins','(199)068-7510x1832','Doctor','USNV Burgess\nFPO AA 34105','Sister','No','B+','AS','1.65','61.6','',0,'1234',0),('81','Jennifer Garner','Female','42198','Strongton','83078 Alexis Path Suite 164\nDerekchester, VA 21833','447.440.3485x4287','robinsmith@yahoo.com','Islam','Ondo State','Owo','JSS2','B','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS3','Yes','Hearing issues','001-132-790-1904x9101','Daniel Taylor','33978 Alicia Summit\nLake Kevinfort, GA 07957','=1-184-187-3056','Yes','No','No','No','Yes','Isabella Ryan','865.139.9492x55981','Engineer','USNS Schmidt\nFPO AA 37556','Mother','Yes','B-','AA','1.54','50.2','',0,'1234',0),('82','Larry Hill','Male','39987','West Kaylaview','USCGC Schmidt\nFPO AP 74043','768-007-1399','victoriariley@moore.info','Christianity','Ondo State','Ondo East','JSS3','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','Yes','Asthma','001-633-664-4094','Julie Peck','416 Grace Club Apt. 297\nEast Renee, ME 76768','4067859433','No','No','Yes','Yes','Yes','Melissa Dorsey','238-896-2328','Farmer','9784 Sean Coves\nBrownhaven, FL 04546','Aunt','No','O+','AS','1.87','40.4','',0,'1234',0),('83','Donald Gonzalez','Male','42101','Lake Chadfurt','23393 Chelsea Locks\nWest Ericmouth, IL 04008','(730)284-0267x4456','wharrington@bennett.com','Islam','Ondo State','Odigbo','SS3','B','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS1','Yes','Asthma','425.116.1908x3023','Jennifer Adams','06704 Justin Path Suite 788\nRyanmouth, UT 77779','008-867-2922','No','Yes','No','No','No','Leah Hobbs','(834)363-9314x36560','Farmer','448 Taylor Meadow Apt. 125\nLake Misty, WI 76369','Sister','No','B+','SS','1.32','45.6','',0,'1234',0),('84','Mrs. Kimberly Carlson','Female','40006','Lake Crystal','29776 John Branch Suite 616\nBethanyfort, MA 71403','+1-519-328-8771x02927','jasonlove@lopez.org','Islam','Ondo State','Idanre','SS3','B','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','No','Sight issues','219-140-4911','Richard Zimmerman','53432 Howe Ridges Suite 446\nNew Leslie, KY 32643','7206952305','Yes','Yes','No','Yes','Yes','Jessica Briggs','385.167.4824x150','Civil Servant','Unit 2348 Box 2397\nDPO AA 99204','Brother','Yes','A+','AA','1.8','57.5','',0,'1234',0),('85','Kimberly Griffin','Female','39372','Timothyburgh','80891 Jacqueline Lane\nNorth Ann, MD 95284','332-648-8807x43657','hickmandaniel@waller-burns.com','Islam','Ondo State','Ifedore','JSS2','C','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','Primary 6','No','Asthma','362-836-1816x13761','Keith Moore','9417 Banks Crescent\nLake Kimberlymouth, MS 72793','(821)996-7759x437','Yes','No','No','No','No','Nicolas Meza','8316926718','Doctor','Unit 7708 Box 0314\nDPO AE 57241','Mother','No','A-','SS','1.46','42.1','',0,'1234',0),('86','Brooke Briggs','Female','41910','New Rodney','08748 Casey Tunnel Suite 904\nEast Jamesfurt, AK 16798','3984239010','wilsonchristina@jacobs.biz','Christianity','Ondo State','Ondo West','SS2','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','No','Sight issues','331.962.7891','Sandra Baker','8975 Esparza Plaza\nNew Johnmouth, HI 25071','+1-780-185-9119x5426','Yes','No','No','Yes','No','Madison Hansen','2631951649','Trader','9033 Lisa Plain Apt. 174\nJamesfurt, VA 17752','Uncle','No','AB+','SS','1.39','84.8','',0,'1234',0),('87','Kristy James','Female','40811','Port Danshire','595 Anderson Place Suite 626\nThomasburgh, CT 64335','145.904.0228','andrea87@yahoo.com','Islam','Ondo State','Akoko North-East','JSS2','C','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS1','Yes','Sight issues','1127315819','Stephen Byrd','6002 Amy Union\nWest Monica, DC 59144','+1-425-249-3570x3365','Yes','Yes','Yes','Yes','Yes','Carmen Smith','001-820-913-3558x79572','Farmer','1985 Bryan Mountains\nRobertville, IA 10233','Brother','No','B+','AS','1.38','53.9','',0,'1234',0),('88','Joshua Reilly','Male','41037','West Josephmouth','48391 Hall Plain\nAlexisfurt, KS 08621','=1-666-774-7372','andrewallen@johnson-johnson.com','Traditional','Ondo State','Idanre','JSS2','C','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS3','No','Hearing issues','+1-285-538-0595x667','Ana Miller','02280 Lewis Shoals\nWest Jeffrey, KS 05704','001-834-591-1071x9703','Yes','Yes','No','Yes','No','Rebecca Bradley','001-203-831-4155x75877','Civil Servant','487 Jillian Loop\nPort Kendra, ME 39259','Sister','Yes','O+','AA','1.39','83.9','',0,'1234',0),('89','Dennis Palmer','Male','40397','Jonathanburgh','10371 Lori Prairie Apt. 988\nParkerfurt, CT 49353','659.805.9717','jefferypacheco@yahoo.com','Traditional','Ondo State','Ose','SS1','A','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Coding','Primary 6','No','None','(599)309-6108x4109','Monique Gonzalez','2225 Tiffany Trail\nHernandezview, VA 71365','776-560-7064x751','No','Yes','No','No','No','James Ali','=1-104-567-5518','Farmer','61274 Chase Crest\nWhitneymouth, NJ 87296','Mother','No','B+','AA','1.63','53.3','',0,'1234',0),('9','Thomas Hamilton','Male','41741','West Carla','710 David Harbor Suite 581\nKristystad, AK 89153','894-119-8458','curtisnewman@hotmail.com','Traditional','Ondo State','Ifedore','SS3','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Coding','JSS3','Yes','Hearing issues','=1-896-456-2059','Peter Colon','13237 Rasmussen Fields\nWest Christine, MO 39735','(880)778-0402x7574','No','No','No','No','Yes','Kayla Brown','(038)157-0232x524','Trader','2228 Griffith Plaza\nNorth Williamshire, SD 24232','Sister','No','B-','AA','1.35','54.8','',0,'1234',0),('90','Matthew Alvarez','Male','40350','South Davidview','7638 Chang Squares Suite 890\nRandyside, VA 97545','001-637-149-5932x70073','derek77@hotmail.com','Islam','Ondo State','Akure South','SS3','D','2022/2023','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Drawing','JSS2','Yes','Hearing issues','001-458-702-7072x04647','Lindsey Salas','09310 Farley Freeway\nSouth Jim, LA 35765','132.126.5041','No','Yes','No','Yes','Yes','Russell Harmon','258.627.2238','Farmer','35362 Tyler Knoll\nMarcchester, VA 83531','Uncle','No','A+','AS','1.57','86.2','',0,'1234',0),('91','Jonathan Hernandez','Male','39165','North Francis','63456 Johnson Wells Suite 051\nNew Ronaldfort, MI 95156','979.232.2857','michaelcrane@benitez.biz','Islam','Ondo State','Owo','SS1','D','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Coding','Primary 6','No','None','=1-770-28-4049','Elijah Miller','675 Lopez Mall Apt. 468\nLake Lisa, AZ 26242','3660964562','No','Yes','Yes','Yes','No','David Goodwin','736.130.9373x6848','Engineer','957 Young Haven\nGreenmouth, VT 47198','Brother','No','AB+','AS','1.68','65.1','',0,'1234',0),('92','Mary Hill','Female','42002','Pamelamouth','508 Kenneth Rest\nJenniferland, GA 90875','460.170.2770x9202','ortizapril@perez-bell.info','Traditional','Ondo State','Akure South','JSS1','A','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','No','Asthma','(001)624-1659x3616','Mrs. Nicole Bishop MD','8032 Scott Plaza Suite 418\nJordanstad, TN 08639','+1-677-687-3038x262','No','No','No','Yes','Yes','Carla Spencer','3483519474','Doctor','742 George Village Apt. 409\nCowanville, AZ 04637','Uncle','No','AB+','AS','1.79','67.9','',0,'1234',0),('93','Raymond Jones','Male','40204','Lake Tanya','PSC 9289, Box 4950\nAPO AE 55973','694.093.3463','william36@yahoo.com','Islam','Ondo State','Akure South','SS2','A','2023/2024','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','Yes','Sight issues','(451)045-4567x964','Cathy Hart','3352 James Canyon\nHuffside, NH 91799','013.896.4061','Yes','No','Yes','Yes','Yes','Susan Benson','+1-525-646-2736x1396','Farmer','245 Laura Springs Suite 136\nNorth Jessicabury, MT 28262','Uncle','Yes','B+','SS','1.46','40.2','',0,'1234',0),('94','Donna Morrow','Female','39106','Brittanyhaven','50145 Justin Lakes Suite 453\nEast Andrew, SC 14549','7356595751','amy12@yahoo.com','Traditional','Ondo State','Owo','JSS1','D','2024/2025','1st','Dinolabs Academy','123 Akure Road, Ondo State','Reading','JSS2','Yes','Asthma','699.595.0426','Amy Hill','0813 Tyler Bridge\nNew Teresafort, MS 30231','=1-575-978-4897','Yes','Yes','Yes','Yes','Yes','Joshua Gonzalez','001-801-615-3079x286','Teacher','PSC 2091, Box 3966\nAPO AP 82348','Father','Yes','AB+','AA','1.79','68','',0,'1234',0),('95','Timothy Ross','Male','39057','Katrinahaven','USNV Smith\nFPO AE 50705','887.758.7797x9188','caitlin21@young-kelly.com','Traditional','Ondo State','Odigbo','JSS1','D','2023/2024','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','Sight issues','(277)816-4779x5859','David Schneider','85787 Katherine Locks Apt. 938\nThompsonberg, VA 58452','(422)879-3113x46353','No','Yes','Yes','No','No','David Gomez','479-760-8547','Civil Servant','213 Garcia Highway Apt. 884\nTuckerland, AR 28763','Aunt','No','A-','SS','1.33','47','',0,'1234',0),('96','Jordan Mahoney','Female','40222','Kevinmouth','397 Joseph Port Apt. 733\nNew Brianport, NY 12155','+1-532-064-4947x8585','robertsonjohn@park.org','Islam','Ondo State','Ifedore','JSS2','C','2022/2023','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Music','JSS2','Yes','None','235.819.3136x481','Justin Flynn','5348 Timothy Squares\nPort Denisefort, NH 40981','001-459-444-8254x93629','No','Yes','Yes','No','No','Melanie Bates','001-441-599-8204x309','Teacher','7676 Vanessa Mountain\nNorth John, FL 49536','Brother','Yes','O+','SS','1.88','88.6','',0,'1234',0),('97','Steven Cruz','Male','39336','Keyhaven','289 Walker Manors Apt. 231\nWest Jodichester, AR 95698','503.383.6970','juliajohnson@patel.biz','Traditional','Ondo State','Ile Oluji/Okeigbo','JSS3','D','2024/2025','3rd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','No','Sight issues','214.066.3020','Trevor Blanchard','29985 Baker Turnpike\nSouth Karen, NE 49841','+1-819-321-0745x240','Yes','Yes','Yes','Yes','No','Christine Chapman','(337)750-3534x70572','Civil Servant','47734 Arnold Shoal Suite 082\nEast Christopher, ID 78983','Aunt','Yes','A+','AA','1.76','49.6','',0,'1234',0),('98','Victor Williams','Male','40243','West Rachel','42238 Bartlett Stream Suite 042\nAndrewshire, MA 35616','+1-284-907-6213x77423','kimberly95@hotmail.com','Traditional','Ondo State','Ilaje','JSS1','B','2022/2023','1st','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','No','Sight issues','641-318-4293','Mary Kennedy','8823 Laura Walks Apt. 016\nGregoryville, TN 28682','(217)909-2731','Yes','Yes','No','No','No','Richard Zuniga','702-587-9478x9110','Trader','3482 Miller Divide Apt. 073\nLake Michael, HI 29689','Aunt','Yes','A+','AS','1.67','54.3','',0,'1234',0),('99','Laura Smith','Female','40012','Annechester','PSC 7077, Box 2756\nAPO AE 51517','5996526800','egonzalez@acosta-graham.com','Islam','Ondo State','Akoko South-West','JSS1','B','2023/2024','2nd','Dinolabs Academy','123 Akure Road, Ondo State','Football','JSS3','Yes','Sight issues','647-220-1018x2759','Angela Martin','07481 Chase Club Suite 141\nNew Ericton, IN 39967','+1-961-694-6326x10041','No','No','No','No','Yes','Frederick Brown','4318939434','Civil Servant','0272 Owens Dale Suite 879\nWest Jennifermouth, MO 39155','Mother','Yes','A+','SS','1.79','84.6','',0,'1234',0);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub`
--

DROP TABLE IF EXISTS `sub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub` (
  `id` int NOT NULL AUTO_INCREMENT,
  `expdate` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub`
--

LOCK TABLES `sub` WRITE;
/*!40000 ALTER TABLE `sub` DISABLE KEYS */;
INSERT INTO `sub` VALUES (1,'31/12/2025');
/*!40000 ALTER TABLE `sub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (3,'Mathematics','SS 2','D'),(4,'English Lang','SS 2','D'),(5,'French','SS 2','D'),(6,'Economics','SS 2','D'),(7,'Yoruba','SS 2','D'),(8,'Further Maths','SS 2','D'),(9,'Biology','SS 2','D'),(11,'Physics','SS 2','D'),(12,'English Language','SS 1','A'),(13,'Computer Studies','JSS 1','A'),(14,'Maths ','JSS 2','A'),(15,'Basic technology ','JSS 1','B'),(16,'Literature ','SS 1','B');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `companyname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_chat`
--

DROP TABLE IF EXISTS `tb_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chat` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_chat`
--

LOCK TABLES `tb_chat` WRITE;
/*!40000 ALTER TABLE `tb_chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pm`
--

DROP TABLE IF EXISTS `tb_pm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_pm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `fromuser` varchar(200) NOT NULL,
  `subject` varchar(300) NOT NULL,
  `message` text NOT NULL,
  `isread` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pm`
--

LOCK TABLES `tb_pm` WRITE;
/*!40000 ALTER TABLE `tb_pm` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_pm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_users`
--

DROP TABLE IF EXISTS `tb_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `staffname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `dp` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_users`
--

LOCK TABLES `tb_users` WRITE;
/*!40000 ALTER TABLE `tb_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbooknumber`
--

DROP TABLE IF EXISTS `tblbooknumber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblbooknumber` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BOOKTITLE` varchar(255) NOT NULL,
  `QTY` int NOT NULL,
  `Desc` varchar(90) NOT NULL,
  `Author` varchar(90) NOT NULL,
  `PublishDate` date NOT NULL,
  `Publisher` varchar(90) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbooknumber`
--

LOCK TABLES `tblbooknumber` WRITE;
/*!40000 ALTER TABLE `tblbooknumber` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblbooknumber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbooks`
--

DROP TABLE IF EXISTS `tblbooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblbooks` (
  `BookID` int NOT NULL AUTO_INCREMENT,
  `AccessionNo` varchar(90) NOT NULL,
  `BookTitle` varchar(125) NOT NULL,
  `BookDesc` varchar(255) NOT NULL,
  `Author` varchar(125) NOT NULL,
  `PublishDate` date NOT NULL,
  `BookPublisher` varchar(125) NOT NULL,
  `CategoryId` int NOT NULL,
  `BookPrice` double NOT NULL,
  `BookQuantity` int NOT NULL,
  `Status` varchar(30) NOT NULL,
  `BookType` varchar(90) NOT NULL,
  `DeweyDecimal` varchar(90) NOT NULL,
  `OverAllQty` int NOT NULL,
  `Donate` tinyint(1) NOT NULL,
  `Remark` varchar(90) NOT NULL,
  PRIMARY KEY (`BookID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbooks`
--

LOCK TABLES `tblbooks` WRITE;
/*!40000 ALTER TABLE `tblbooks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblbooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblborrow`
--

DROP TABLE IF EXISTS `tblborrow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblborrow` (
  `BorrowId` int NOT NULL AUTO_INCREMENT,
  `AccessionNo` varchar(90) NOT NULL,
  `NoCopies` int NOT NULL,
  `DateBorrowed` datetime NOT NULL,
  `Purpose` varchar(90) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `DueDate` datetime NOT NULL,
  `BorrowerId` int NOT NULL,
  `Due` tinyint(1) NOT NULL,
  `Remarks` varchar(90) NOT NULL,
  PRIMARY KEY (`BorrowId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblborrow`
--

LOCK TABLES `tblborrow` WRITE;
/*!40000 ALTER TABLE `tblborrow` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblborrow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblborrower`
--

DROP TABLE IF EXISTS `tblborrower`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblborrower` (
  `IDNO` int NOT NULL AUTO_INCREMENT,
  `BorrowerId` varchar(90) NOT NULL,
  `Firstname` varchar(125) NOT NULL,
  `Lastname` varchar(125) NOT NULL,
  `MiddleName` varchar(125) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Sex` varchar(11) NOT NULL,
  `ContactNo` varchar(125) NOT NULL,
  `CourseYear` varchar(125) NOT NULL,
  `BorrowerPhoto` varchar(255) NOT NULL,
  `BorrowerType` varchar(35) NOT NULL,
  `Stats` varchar(36) NOT NULL,
  `IMGBLOB` blob NOT NULL,
  PRIMARY KEY (`IDNO`),
  UNIQUE KEY `BorrowerId` (`BorrowerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblborrower`
--

LOCK TABLES `tblborrower` WRITE;
/*!40000 ALTER TABLE `tblborrower` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblborrower` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcategory`
--

DROP TABLE IF EXISTS `tblcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcategory` (
  `CategoryId` int NOT NULL AUTO_INCREMENT,
  `Category` varchar(125) NOT NULL,
  `DDecimal` varchar(90) NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcategory`
--

LOCK TABLES `tblcategory` WRITE;
/*!40000 ALTER TABLE `tblcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbllogs`
--

DROP TABLE IF EXISTS `tbllogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbllogs` (
  `LogId` int NOT NULL AUTO_INCREMENT,
  `UserId` int NOT NULL,
  `LogDate` datetime NOT NULL,
  `LogMode` varchar(30) NOT NULL,
  PRIMARY KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbllogs`
--

LOCK TABLES `tbllogs` WRITE;
/*!40000 ALTER TABLE `tbllogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbllogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpayment`
--

DROP TABLE IF EXISTS `tblpayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblpayment` (
  `PaymentId` int NOT NULL AUTO_INCREMENT,
  `BorrowId` int NOT NULL,
  `Payment` double NOT NULL,
  `Change` double NOT NULL,
  `DatePayed` date NOT NULL,
  `BorrowerId` int NOT NULL,
  `Remarks` varchar(125) NOT NULL,
  PRIMARY KEY (`PaymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpayment`
--

LOCK TABLES `tblpayment` WRITE;
/*!40000 ALTER TABLE `tblpayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblpayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblreturn`
--

DROP TABLE IF EXISTS `tblreturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblreturn` (
  `ReturnId` int NOT NULL AUTO_INCREMENT,
  `BorrowId` int NOT NULL,
  `NoCopies` int NOT NULL,
  `DateReturned` datetime NOT NULL,
  `Remarks` varchar(125) NOT NULL,
  PRIMARY KEY (`ReturnId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblreturn`
--

LOCK TABLES `tblreturn` WRITE;
/*!40000 ALTER TABLE `tblreturn` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblreturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbluser` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `Fullname` varchar(124) NOT NULL,
  `User_name` varchar(125) NOT NULL,
  `Pass` varchar(125) NOT NULL,
  `UserRole` varchar(125) NOT NULL,
  `Status` varchar(11) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbluser`
--

LOCK TABLES `tbluser` WRITE;
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `staffid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`staffid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonial`
--

DROP TABLE IF EXISTS `testimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonial` (
  `id` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `remark` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `session` varchar(222) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonial`
--

LOCK TABLES `testimonial` WRITE;
/*!40000 ALTER TABLE `testimonial` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `threads`
--

DROP TABLE IF EXISTS `threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `threads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES (3,'Cultural Week','<p>So, Monday to Friday is our cultural week</p>\r\n<p>Today, we visit the Oba of Akure Kingdom</p>\r\n<p>Tuesday, we\'ll hold cultural dance from different tribes in the school</p>\r\n<p>Wednesday, the school anthem will be sang in different languages by students</p>\r\n<p>Thursday, no event</p>\r\n<p>Friday, all students are encouraged to wear their cultural attire to school&nbsp;</p>\r\n<p>Sure!!!</p>','DANIEL OMOJOLA','2025-07-21 16:33:27'),(4,'Cultural Week','<p>next week is our cultural week</p>','Ogunmola Abigail','2025-08-21 12:41:27'),(5,'Cultural Week','<p>I\'ll be there in Jesus\' name</p>','James Smith ','2025-08-21 12:41:53'),(6,'Cleanliness ','<p>Every student must come to school with clean uniform, socks and shoes&nbsp;</p>\r\n<p>Good health&nbsp;</p>','Yinka','2025-08-21 12:42:13');
/*!40000 ALTER TABLE `threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timer`
--

DROP TABLE IF EXISTS `timer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `studentid` varchar(50) NOT NULL,
  `timer` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timer`
--

LOCK TABLES `timer` WRITE;
/*!40000 ALTER TABLE `timer` DISABLE KEYS */;
INSERT INTO `timer` VALUES (5,'0262a5aa','10:11:44'),(6,'4','10:33:19');
/*!40000 ALTER TABLE `timer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timetable`
--

DROP TABLE IF EXISTS `timetable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timetable` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `arm` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(111) COLLATE utf8mb4_general_ci NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetable`
--

LOCK TABLES `timetable` WRITE;
/*!40000 ALTER TABLE `timetable` DISABLE KEYS */;
INSERT INTO `timetable` VALUES (1,'Monday','SS 2','D','English Language','08:15:00','09:00:00'),(2,'Tuesday','SS 2','D','Mathematics','14:00:00','14:30:00'),(3,'Thursday','JSS 1','A','Computer Studies','10:30:00','12:30:00'),(4,'Thursday','JSS 1','A','Basic Technology ','08:15:00','09:45:00'),(5,'Thursday','JSS 1','A','English','14:30:00','15:15:00');
/*!40000 ALTER TABLE `timetable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactiondetails`
--

DROP TABLE IF EXISTS `transactiondetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactiondetails` (
  `transactionID` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `studentname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `productname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `units` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `transactiondate` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `profit` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `cashier` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `rownumber` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`rownumber`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactiondetails`
--

LOCK TABLES `transactiondetails` WRITE;
/*!40000 ALTER TABLE `transactiondetails` DISABLE KEYS */;
INSERT INTO `transactiondetails` VALUES ('','','Cabin Biscuits','Product Updated','50','6000','07/22/2025 07:34:39','40','Admin',1),('234123','Abigail Oyinlola','Cabin Biscuits','Sales','1','120','2025-07-22 08:36:34','120','Ogunmola Abigail',2),('','','ATV bulb 5watts ','Product Updated','45','247500','08/21/2025 11:06:52','500','Admin',3),('0262a5aa','James Smith ','ATV bulb 5watts ','Sales','12','66000','2025-08-21 12:18:51','66000','Ogunmola Abigail',4);
/*!40000 ALTER TABLE `transactiondetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tuck`
--

DROP TABLE IF EXISTS `tuck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tuck` (
  `regno` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `studentname` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `sex` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `studentclass` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `csession` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `vbalance` varchar(222) COLLATE utf8mb4_general_ci NOT NULL,
  `photo` blob NOT NULL,
  `passcode` int NOT NULL,
  PRIMARY KEY (`regno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tuck`
--

LOCK TABLES `tuck` WRITE;
/*!40000 ALTER TABLE `tuck` DISABLE KEYS */;
INSERT INTO `tuck` VALUES ('0262a5aa','James Smith ','Male','JSS 1','2024/2025','484000','',0),('234123','Abigail Oyinlola','Female','SS 2','2024/2025','380','',0);
/*!40000 ALTER TABLE `tuck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '3' COMMENT '1=Admin,2=Staff, 3= subscriber',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2025-08-27 14:52:31
