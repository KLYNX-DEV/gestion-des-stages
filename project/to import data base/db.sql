CREATE DATABASE  IF NOT EXISTS `gestion_stages` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestion_stages`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: gestion_stages
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `email_admin` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password_admin` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_admin` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom_admin` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'default.jpg',
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email_admin` (`email_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin@gmail.com','admin','amine','haiti','2025-05-26 20:27:02','amime pic.jpg'),(2,'hh@gmail.com','2002','haiti','hatim','2025-05-29 01:27:09','default.jpg');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidatures`
--

DROP TABLE IF EXISTS `candidatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidatures` (
  `id_cand` int NOT NULL AUTO_INCREMENT,
  `id_etu` int NOT NULL,
  `id_offre` int NOT NULL,
  `date_postulation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `etat` enum('envoyée','en cours','acceptée','refusée') COLLATE utf8mb4_general_ci DEFAULT 'envoyée',
  PRIMARY KEY (`id_cand`),
  KEY `id_etu` (`id_etu`),
  KEY `id_offre` (`id_offre`),
  CONSTRAINT `candidatures_ibfk_1` FOREIGN KEY (`id_etu`) REFERENCES `etudiants` (`id_etu`) ON DELETE CASCADE,
  CONSTRAINT `candidatures_ibfk_2` FOREIGN KEY (`id_offre`) REFERENCES `offres` (`id_offre`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidatures`
--

LOCK TABLES `candidatures` WRITE;
/*!40000 ALTER TABLE `candidatures` DISABLE KEYS */;
INSERT INTO `candidatures` VALUES (1,1,3,'2025-06-01 04:56:32','envoyée'),(2,1,15,'2025-07-03 19:02:38','acceptée'),(3,1,16,'2025-07-03 19:02:54','acceptée'),(4,1,5,'2025-07-03 19:03:00','envoyée'),(5,1,16,'2025-07-03 19:03:03','acceptée'),(6,1,4,'2025-07-03 19:07:57','envoyée'),(7,1,19,'2025-07-03 19:08:03','envoyée'),(8,1,20,'2025-07-03 21:19:52','acceptée'),(9,1,17,'2025-07-03 21:20:33','envoyée'),(10,1,18,'2025-07-03 21:20:38','envoyée'),(11,1,7,'2025-07-03 21:20:40','envoyée'),(12,1,8,'2025-07-03 21:20:41','envoyée'),(13,1,9,'2025-07-03 21:20:43','envoyée'),(14,1,6,'2025-07-03 21:20:52','envoyée'),(15,7,20,'2025-07-03 22:00:38','envoyée'),(16,1,10,'2025-07-03 22:14:16','envoyée');
/*!40000 ALTER TABLE `candidatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etudiants` (
  `id_etu` int NOT NULL AUTO_INCREMENT,
  `email_etu` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password_etu` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_etu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom_etu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cv` text COLLATE utf8mb4_general_ci,
  `formation` text COLLATE utf8mb4_general_ci,
  `competence` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_etu` varchar(500) COLLATE utf8mb4_general_ci DEFAULT 'profileetu.jpeg',
  PRIMARY KEY (`id_etu`),
  UNIQUE KEY `email_etu` (`email_etu`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiants`
--

LOCK TABLES `etudiants` WRITE;
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` VALUES (1,'haitimohammedamine@gmail.com','123','haiti','MOHAMMED','uploads/cv/PHP--TP--CRUD.pdf','1 er annee develepoment degital','html\r\n\r\n','2025-05-26 09:16:41','IMG_20240413_213014.jpg'),(3,'fghj@gmail.com','8520','amine','yamal',NULL,NULL,NULL,'2025-05-26 19:14:16','profileetu.jpeg'),(4,'hatimhaitdvssdi@gmail.com','123','haiti','hatim',NULL,NULL,NULL,'2025-05-27 20:00:52','profileetu.jpeg'),(5,'kd@gmail.com','123','KLYNX','DEV!',NULL,NULL,NULL,'2025-07-03 21:46:22','profileetu.jpeg'),(7,'klynx@gmail.com','123','KLYNX','DEV!','uploads/cv/M106 - CH4.pdf',NULL,'php \r\njava','2025-07-03 21:55:46','IMG_20240424_134950_185.jpg');
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sujet` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (3,'HAITI','MOHAMMED AMINE','haitimohammedamine@gmail.com','feedback','jkhgnfxcvbnj;kjnfbcvbnmj,hmgnxfbn','2025-07-03 20:13:12'),(4,'HAITI','MOHAMMED AMINE','haitimohammedamine@gmail.com','feedback','jkhgnfxcvbnj;kjnfbcvbnmj,hmgnxfbn','2025-07-03 20:44:34'),(5,'HAITI','MOHAMMED AMINE','haitimohammedamine@gmail.com','feedback','jkhgnfxcvbnj;kjnfbcvbnmj,hmgnxfbn','2025-07-03 20:44:53');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offres`
--

DROP TABLE IF EXISTS `offres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offres` (
  `id_offre` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `entreprise` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_offre`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `offres_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id_admin`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offres`
--

LOCK TABLES `offres` WRITE;
/*!40000 ALTER TABLE `offres` DISABLE KEYS */;
INSERT INTO `offres` VALUES (3,'hatim','hhh','haiti','2025-05-28','2025-05-31',1,'2025-05-28 15:19:48'),(4,'hatim','hhhhhhhhhhhhhhhhhhhhhhhhhhhh','haiti','2025-05-28','2025-05-31',1,'2025-05-28 15:36:00'),(5,'hatim','hhhhhhhhhhhhhhhhhhhhhhhhhhhh','haiti','2025-05-28','2025-05-31',1,'2025-05-28 15:36:23'),(6,'amine','bbbbbbbbbbbbbbb','haiti','2025-05-30','2025-06-08',1,'2025-05-28 15:37:58'),(7,'hhhh','yuvhcbcjwnc wc','hhhhhhhhhhhhhh','2025-06-06','2025-06-04',1,'2025-05-28 15:42:01'),(8,'hhhh','yuvhcbcjwnc wc','hhhhhhhhhhhhhh','2025-06-06','2025-06-04',1,'2025-05-28 15:47:46'),(9,'hhhh','yuvhcbcjwnc wc','hhhhhhhhhhhhhh','2025-06-06','2025-06-04',1,'2025-05-28 15:48:19'),(10,'hhhh','8965320','hhhhhhhhhhhhhh','2025-06-06','2025-06-04',1,'2025-05-28 15:48:39'),(11,'hhhh','8965320','hhhhhhhhhhhhhh','2025-06-06','2025-06-04',1,'2025-05-28 15:50:26'),(12,'khnbkj ','894561230.','mnbvcfghn','2025-06-06','2025-06-08',1,'2025-05-28 15:51:00'),(13,'khnbkj ','lkjhgcxchj','mnbvcfghn','2025-06-06','2025-06-08',1,'2025-05-28 15:51:34'),(14,'khnbkj ','lkjhgcxchj','mnbvcfghn','2025-06-06','2025-06-08',1,'2025-05-28 15:56:12'),(15,'gggrr','fbk; b,b83b4Fb','lkmbfb','2025-06-08','2025-06-29',1,'2025-05-28 15:56:47'),(16,'gggrr','fbk; b,b83b4Fb','lkmbfb','2025-06-08','2025-06-29',1,'2025-05-28 15:57:07'),(17,'gggrr','fbk; b,b83b4Fb','lkmbfb','2025-06-08','2025-06-29',1,'2025-05-28 16:02:12'),(18,'gggrr','8520','lkmbfb','2025-06-08','2025-06-29',1,'2025-05-28 16:04:25'),(19,'ba3','hello','klynx','2025-05-29','2025-06-07',2,'2025-05-29 01:28:17'),(20,'test','kjhgfcxvbn','test','2025-07-03','2025-07-04',1,'2025-07-03 19:36:18');
/*!40000 ALTER TABLE `offres` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-04  2:38:22
