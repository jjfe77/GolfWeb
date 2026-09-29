CREATE DATABASE  IF NOT EXISTS `golf_app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `golf_app`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: golf_app
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `canchas`
--

DROP TABLE IF EXISTS `canchas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `canchas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `pares` json NOT NULL,
  `slope` float DEFAULT '126',
  `rating` float DEFAULT '71.5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canchas`
--

LOCK TABLES `canchas` WRITE;
/*!40000 ALTER TABLE `canchas` DISABLE KEYS */;
INSERT INTO `canchas` VALUES (2,'Sierra de los Padres','[4, 4, 4, 3, 4, 4, 3, 5, 4, 5, 4, 3, 4, 4, 3, 4, 5, 4]',126,71.5);
/*!40000 ALTER TABLE `canchas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jugadores`
--

DROP TABLE IF EXISTS `jugadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jugadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `handicap_actual` float DEFAULT NULL,
  `historial_scores` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jugadores`
--

LOCK TABLES `jugadores` WRITE;
/*!40000 ALTER TABLE `jugadores` DISABLE KEYS */;
INSERT INTO `jugadores` VALUES (1,'Juanjo',23,'[]'),(3,'Jose',36,'[]'),(5,'Jorge',25,'[]');
/*!40000 ALTER TABLE `jugadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partidas`
--

DROP TABLE IF EXISTS `partidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cancha_id` int DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bocha` enum('blanca','azul','roja') DEFAULT NULL,
  `jugadores_ids` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cancha_id` (`cancha_id`),
  CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`cancha_id`) REFERENCES `canchas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partidas`
--

LOCK TABLES `partidas` WRITE;
/*!40000 ALTER TABLE `partidas` DISABLE KEYS */;
INSERT INTO `partidas` VALUES (2,2,'2026-09-27 01:52:13','blanca','[\"1\"]'),(3,2,'2026-09-27 03:34:42','blanca','[\"1\"]'),(4,2,'2026-09-27 15:45:11','blanca','[\"1\"]'),(5,2,'2026-09-28 00:47:09','blanca','[\"1\"]'),(6,2,'2026-09-28 01:48:05','blanca','null'),(7,2,'2026-09-28 03:37:35','blanca','null'),(8,2,'2026-09-28 03:40:15','blanca','null'),(9,2,'2026-09-28 03:49:42','blanca','[\"1\", \"3\"]'),(10,2,'2026-09-28 03:50:33','blanca','[\"1\", \"3\"]'),(11,2,'2026-09-28 03:56:21','blanca','[\"1\"]'),(12,2,'2026-09-28 03:56:34','blanca','[\"1\", \"3\"]'),(13,2,'2026-09-28 04:06:28','blanca','[\"1\", \"3\"]'),(14,2,'2026-09-28 04:11:31','azul','[\"1\", \"3\"]'),(15,2,'2026-09-28 04:15:23','blanca','[\"1\", \"3\"]'),(16,2,'2026-09-28 05:27:52','blanca','null');
/*!40000 ALTER TABLE `partidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partida_id` int DEFAULT NULL,
  `jugador_id` int DEFAULT NULL,
  `hoyo` int DEFAULT NULL,
  `golpes` int DEFAULT NULL,
  `putts` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partida_id` (`partida_id`),
  KEY `jugador_id` (`jugador_id`),
  CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`partida_id`) REFERENCES `partidas` (`id`),
  CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`jugador_id`) REFERENCES `jugadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=280 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
INSERT INTO `scores` VALUES (1,2,1,1,2,3),(2,2,1,2,1,1),(3,2,1,3,1,1),(4,2,1,4,1,1),(5,2,1,5,1,1),(6,2,1,6,1,1),(7,2,1,7,1,1),(8,2,1,8,1,1),(9,2,1,9,1,1),(10,2,1,10,1,1),(11,2,1,11,1,1),(12,2,1,12,1,1),(13,2,1,13,1,1),(14,2,1,14,1,1),(15,2,1,15,1,1),(16,2,1,16,1,1),(17,2,1,17,1,1),(18,2,1,18,1,1),(19,2,1,18,1,1),(20,3,1,1,1,1),(21,3,1,2,1,1),(22,3,1,3,1,1),(23,3,1,4,1,1),(24,3,1,5,1,1),(25,3,1,6,1,1),(26,3,1,7,1,1),(27,3,1,8,1,1),(28,3,1,9,1,1),(29,3,1,10,1,1),(30,3,1,11,1,1),(31,3,1,12,1,1),(32,3,1,13,1,1),(33,3,1,14,1,1),(34,3,1,15,2,2),(35,3,1,16,1,1),(36,3,1,17,1,1),(37,3,1,18,1,1),(38,4,1,1,4,2),(39,4,1,2,2,1),(40,4,1,3,3,1),(41,4,1,4,3,1),(42,4,1,5,4,1),(43,4,1,6,3,2),(44,4,1,7,5,3),(45,4,1,8,5,2),(46,4,1,9,4,2),(47,4,1,10,5,4),(48,4,1,11,10,6),(49,4,1,12,6,3),(50,4,1,13,5,2),(51,4,1,14,5,2),(52,4,1,15,5,2),(53,4,1,16,5,4),(54,4,1,17,5,2),(55,4,1,18,5,4),(56,4,1,18,5,4),(57,4,1,18,5,4),(58,4,1,18,5,4),(59,5,1,1,32,8),(60,5,1,2,1,1),(61,5,1,3,1,1),(62,5,1,4,1,1),(63,5,1,5,1,1),(64,5,1,6,1,1),(65,5,1,7,1,1),(66,5,1,8,1,1),(67,5,1,9,1,1),(68,5,1,10,1,1),(69,5,1,11,1,1),(70,5,1,12,1,1),(71,5,1,13,1,1),(72,5,1,14,1,1),(73,5,1,15,1,1),(74,5,1,16,1,1),(75,5,1,17,1,1),(76,5,1,18,1,1),(77,5,1,18,1,1),(78,5,1,18,1,1),(79,5,1,18,1,1),(80,5,1,17,1,1),(81,5,1,18,1,1),(82,5,1,18,1,1),(83,5,1,18,1,1),(84,5,1,18,1,1),(85,5,1,18,1,1),(86,5,1,18,1,1),(87,5,1,18,1,1),(88,9,1,1,4,0),(89,9,3,1,3,0),(90,9,1,2,3,0),(91,9,3,2,4,0),(92,9,1,3,4,0),(93,9,3,3,5,0),(94,9,1,4,0,0),(95,9,3,4,0,0),(96,9,1,5,0,0),(97,9,3,5,0,0),(98,9,1,6,0,0),(99,9,3,6,0,0),(100,9,1,7,0,0),(101,9,3,7,0,0),(102,9,1,8,0,0),(103,9,3,8,0,0),(104,9,1,9,0,0),(105,9,3,9,0,0),(106,9,1,10,0,0),(107,9,3,10,0,0),(108,9,1,11,0,0),(109,9,3,11,0,0),(110,9,1,12,0,0),(111,9,3,12,0,0),(112,9,1,13,0,0),(113,9,3,13,0,0),(114,9,1,14,0,0),(115,9,3,14,0,0),(116,9,1,15,0,0),(117,9,3,15,0,0),(118,9,1,16,0,0),(119,9,3,16,0,0),(120,9,1,17,0,0),(121,9,3,17,0,0),(122,9,1,18,0,0),(123,9,3,18,0,0),(124,10,1,1,1,0),(125,10,3,1,1,0),(126,10,1,2,0,0),(127,10,3,2,0,0),(128,10,1,3,0,0),(129,10,3,3,0,0),(130,10,1,4,0,0),(131,10,3,4,0,0),(132,10,1,5,0,0),(133,10,3,5,0,0),(134,10,1,6,0,0),(135,10,3,6,0,0),(136,10,1,7,0,0),(137,10,3,7,0,0),(138,10,1,8,0,0),(139,10,3,8,0,0),(140,10,1,9,0,0),(141,10,3,9,0,0),(142,10,1,10,0,0),(143,10,3,10,0,0),(144,10,1,11,0,0),(145,10,3,11,0,0),(146,10,1,12,0,0),(147,10,3,12,0,0),(148,10,1,13,0,0),(149,10,3,13,0,0),(150,10,1,14,0,0),(151,10,3,14,0,0),(152,10,1,15,0,0),(153,10,3,15,0,0),(154,10,1,16,0,0),(155,10,3,16,0,0),(156,10,1,17,0,0),(157,10,3,17,0,0),(158,10,1,18,0,0),(159,10,3,18,0,0),(160,12,1,1,4,0),(161,12,3,1,3,0),(162,12,1,2,6,0),(163,12,3,2,4,0),(164,12,1,3,0,0),(165,12,3,3,0,0),(166,12,1,4,0,0),(167,12,3,4,0,0),(168,12,1,5,0,0),(169,12,3,5,0,0),(170,12,1,6,0,0),(171,12,3,6,0,0),(172,12,1,7,0,0),(173,12,3,7,0,0),(174,12,1,8,0,0),(175,12,3,8,0,0),(176,12,1,9,0,0),(177,12,3,9,0,0),(178,12,1,10,0,0),(179,12,3,10,0,0),(180,12,1,11,0,0),(181,12,3,11,0,0),(182,12,1,12,0,0),(183,12,3,12,0,0),(184,12,1,13,0,0),(185,12,3,13,0,0),(186,12,1,14,0,0),(187,12,3,14,0,0),(188,12,1,15,19,0),(189,12,3,15,19,0),(190,12,1,16,13,0),(191,12,3,16,8,0),(192,12,1,17,0,0),(193,12,3,17,0,0),(194,12,1,18,0,0),(195,12,3,18,0,0),(196,13,1,1,6,0),(197,13,3,1,4,0),(198,13,1,2,41,0),(199,13,3,2,37,0),(200,13,1,3,0,0),(201,13,3,3,0,0),(202,13,1,4,0,0),(203,13,3,4,0,0),(204,13,1,5,0,0),(205,13,3,5,0,0),(206,13,1,6,0,0),(207,13,3,6,0,0),(208,13,1,7,0,0),(209,13,3,7,0,0),(210,13,1,8,0,0),(211,13,3,8,0,0),(212,13,1,9,0,0),(213,13,3,9,0,0),(214,13,1,10,0,0),(215,13,3,10,0,0),(216,13,1,11,0,0),(217,13,3,11,0,0),(218,13,1,12,0,0),(219,13,3,12,0,0),(220,13,1,13,0,0),(221,13,3,13,0,0),(222,13,1,14,0,0),(223,13,3,14,0,0),(224,13,1,15,0,0),(225,13,3,15,0,0),(226,13,1,16,0,0),(227,13,3,16,0,0),(228,13,1,17,0,0),(229,13,3,17,0,0),(230,13,1,18,0,0),(231,13,3,18,0,0),(232,14,1,1,3,0),(233,14,3,1,4,0),(234,14,1,2,0,0),(235,14,3,2,0,0),(236,14,1,3,0,0),(237,14,3,3,0,0),(238,14,1,4,5,0),(239,14,3,4,0,0),(240,14,1,5,0,0),(241,14,3,5,0,0),(242,14,1,6,0,0),(243,14,3,6,0,0),(244,15,1,1,0,0),(245,15,3,1,0,0),(246,15,1,2,0,0),(247,15,3,2,4,0),(248,15,1,3,0,0),(249,15,3,3,0,0),(250,15,1,4,0,0),(251,15,3,4,0,0),(252,15,1,5,0,0),(253,15,3,5,0,0),(254,15,1,6,35,0),(255,15,3,6,35,0),(256,15,1,7,0,0),(257,15,3,7,0,0),(258,15,1,8,0,0),(259,15,3,8,0,0),(260,15,1,9,0,0),(261,15,3,9,0,0),(262,15,1,10,0,0),(263,15,3,10,0,0),(264,15,1,11,0,0),(265,15,3,11,0,0),(266,15,1,12,0,0),(267,15,3,12,0,0),(268,15,1,13,0,0),(269,15,3,13,0,0),(270,15,1,14,4,0),(271,15,3,14,2,0),(272,15,1,15,0,1),(273,15,3,15,0,1),(274,15,1,16,0,0),(275,15,3,16,0,0),(276,15,1,17,1,0),(277,15,3,17,0,0),(278,15,1,18,1,0),(279,15,3,18,0,0);
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','admin') DEFAULT 'usuario',
  `es_primer_ingreso` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'jjfe77@gmail.com','$2y$10$oHFipoCY4Ldoe572LUXhyehBjyjzeSGzBLfx7vr.DPmxWKuayZ2pW','admin',0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-28 10:59:12
