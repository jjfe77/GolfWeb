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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jugadores`
--

LOCK TABLES `jugadores` WRITE;
/*!40000 ALTER TABLE `jugadores` DISABLE KEYS */;
INSERT INTO `jugadores` VALUES (1,'Juanjo',23,'[]'),(3,'Jose',36,'[]');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partidas`
--

LOCK TABLES `partidas` WRITE;
/*!40000 ALTER TABLE `partidas` DISABLE KEYS */;
INSERT INTO `partidas` VALUES (1,2,'2026-09-27 01:46:45','blanca','[\"1\", \"3\"]'),(2,2,'2026-09-27 01:52:13','blanca','[\"1\"]'),(3,2,'2026-09-27 03:34:42','blanca','[\"1\"]'),(4,2,'2026-09-27 15:45:11','blanca','[\"1\"]');
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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
INSERT INTO `scores` VALUES (1,2,1,1,2,3),(2,2,1,2,1,1),(3,2,1,3,1,1),(4,2,1,4,1,1),(5,2,1,5,1,1),(6,2,1,6,1,1),(7,2,1,7,1,1),(8,2,1,8,1,1),(9,2,1,9,1,1),(10,2,1,10,1,1),(11,2,1,11,1,1),(12,2,1,12,1,1),(13,2,1,13,1,1),(14,2,1,14,1,1),(15,2,1,15,1,1),(16,2,1,16,1,1),(17,2,1,17,1,1),(18,2,1,18,1,1),(19,2,1,18,1,1),(20,3,1,1,1,1),(21,3,1,2,1,1),(22,3,1,3,1,1),(23,3,1,4,1,1),(24,3,1,5,1,1),(25,3,1,6,1,1),(26,3,1,7,1,1),(27,3,1,8,1,1),(28,3,1,9,1,1),(29,3,1,10,1,1),(30,3,1,11,1,1),(31,3,1,12,1,1),(32,3,1,13,1,1),(33,3,1,14,1,1),(34,3,1,15,2,2),(35,3,1,16,1,1),(36,3,1,17,1,1),(37,3,1,18,1,1),(38,4,1,1,4,2),(39,4,1,2,2,1),(40,4,1,3,3,1),(41,4,1,4,3,1),(42,4,1,5,4,1),(43,4,1,6,3,2),(44,4,1,7,5,3),(45,4,1,8,5,2),(46,4,1,9,4,2),(47,4,1,10,5,4),(48,4,1,11,10,6),(49,4,1,12,6,3),(50,4,1,13,5,2),(51,4,1,14,5,2),(52,4,1,15,5,2),(53,4,1,16,5,4),(54,4,1,17,5,2),(55,4,1,18,5,4),(56,4,1,18,5,4),(57,4,1,18,5,4),(58,4,1,18,5,4);
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

-- Dump completed on 2026-09-27 21:35:36
