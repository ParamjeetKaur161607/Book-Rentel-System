-- MySQL dump 10.13  Distrib 8.0.35, for Win64 (x86_64)
--
-- Host: localhost    Database: bookrentelsystem
-- ------------------------------------------------------
-- Server version	8.0.35

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `admin_id` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_phone` varchar(10) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_gender` varchar(20) NOT NULL,
  `admin_dob` date NOT NULL,
  `admin_address` text NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_image` varchar(255) DEFAULT NULL,
  `admin_created` date NOT NULL,
  `admin_modified` date NOT NULL,
  PRIMARY KEY (`admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `book_id` varchar(255) NOT NULL,
  `book_sku` varchar(20) NOT NULL,
  `book_title` varchar(50) NOT NULL,
  `book_author` varchar(50) NOT NULL,
  `book_category` varchar(255) NOT NULL,
  `book_discription` text NOT NULL,
  `book_quantity` int NOT NULL,
  `book_price` int NOT NULL,
  `book_sale_price` int NOT NULL,
  `book_image` varchar(255) NOT NULL,
  `book_path` varchar(255) NOT NULL,
  `book_uploaded` date NOT NULL,
  `book_modified` date NOT NULL,
  PRIMARY KEY (`book_sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES ('657bd6fc2944e','Poetry-1','Poetry','Param','None','dn4ufnmd fc',1,1000,50,'abc.jpg','BOOKS_IMAGES/abc.jpg','2023-12-15','2023-12-15');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_category`
--

DROP TABLE IF EXISTS `book_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_category` (
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_category`
--

LOCK TABLES `book_category` WRITE;
/*!40000 ALTER TABLE `book_category` DISABLE KEYS */;
INSERT INTO `book_category` VALUES ('None');
/*!40000 ALTER TABLE `book_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `user_email` varchar(255) NOT NULL,
  `book_sku` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES ('sajli123@gmail.com','Poetry-1');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` int NOT NULL,
  `customer_address` text NOT NULL,
  `book_sku` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `return_date` date NOT NULL,
  `payment` varchar(255) NOT NULL,
  `Note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES ('657be16091a61','sajli123@gmail.com','sajli',1111113245,'#ndjrenfmd ','Poetry-1','2023-12-15','2023-12-28','','nurhfjdn c');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_order`
--

DROP TABLE IF EXISTS `return_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `return_order` (
  `customer_email` varchar(255) NOT NULL,
  `book_sku` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `return_date` date NOT NULL,
  `review` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_order`
--

LOCK TABLES `return_order` WRITE;
/*!40000 ALTER TABLE `return_order` DISABLE KEYS */;
INSERT INTO `return_order` VALUES ('sajli123@gmail.com','Poetry-1','2023-12-15','2023-12-28',NULL);
/*!40000 ALTER TABLE `return_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `super_admin`
--

DROP TABLE IF EXISTS `super_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `super_admin` (
  `s_admin_id` int NOT NULL,
  `s_admin_email` varchar(255) NOT NULL,
  `s_admin_phone` varchar(10) NOT NULL,
  `s_admin_name` varchar(255) NOT NULL,
  `s_admin_gender` varchar(20) NOT NULL,
  `s_admin_dob` date NOT NULL,
  `s_admin_address` text NOT NULL,
  `s_admin_password` varchar(255) NOT NULL,
  `s_admin_image` varchar(255) DEFAULT NULL,
  `s_admin_created` date NOT NULL,
  `s_admin_modified` date NOT NULL,
  PRIMARY KEY (`s_admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `super_admin`
--

LOCK TABLES `super_admin` WRITE;
/*!40000 ALTER TABLE `super_admin` DISABLE KEYS */;
INSERT INTO `super_admin` VALUES (1,'paramjeetkaur@gmail.com','7973276717','Paramjeet Kaur','male','2002-10-07','#param,chandigarh\r\n                        ','Param@161607','xyz.jpg','2023-12-14','2023-12-15');
/*!40000 ALTER TABLE `super_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_file`
--

DROP TABLE IF EXISTS `user_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_file` (
  `user_email` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_image_path` varchar(255) DEFAULT NULL,
  `user_image_uniqe_id` varchar(255) DEFAULT NULL,
  KEY `user_email` (`user_email`),
  CONSTRAINT `user_file_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `user_reg` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_file`
--

LOCK TABLES `user_file` WRITE;
/*!40000 ALTER TABLE `user_file` DISABLE KEYS */;
INSERT INTO `user_file` VALUES ('sajli123@gmail.com',NULL,NULL,NULL),('jyoti@gmail.com','abc.jpg','USER_IMAGES/abc.jpg','657c285a924ec');
/*!40000 ALTER TABLE `user_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_reg`
--

DROP TABLE IF EXISTS `user_reg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_reg` (
  `user_id` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(10) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_gender` varchar(20) NOT NULL,
  `user_dob` date NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `name_on_card` varchar(255) NOT NULL,
  `cvv` varchar(3) NOT NULL,
  `expiry_month` int NOT NULL,
  `expiry_year` int NOT NULL,
  `user_security_question` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_status` varchar(20) NOT NULL,
  `user_created` date NOT NULL,
  `user_modified` date NOT NULL,
  PRIMARY KEY (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_reg`
--

LOCK TABLES `user_reg` WRITE;
/*!40000 ALTER TABLE `user_reg` DISABLE KEYS */;
INSERT INTO `user_reg` VALUES ('657b92cbda2b4','jyoti@gmail.com','6753213212','jyoti','male','2023-12-01','#fbyurbfnd ','1111111111111111','Jyoti','111',4,2032,'Jyoti','$2y$10$bpKsdqDTrfKELY86gmxHauoHfhviz0sURGk9MzqJH7ZK3Wla2aAaa','ACTIVE','2023-12-15','2023-12-15'),('657b716abb990','sajli123@gmail.com','1111113245','sajli','male','2023-12-08','#ndjrenfmd ','1111111111111111','Sajal','111',2,26,'fnrfmd ','$2y$10$9P3B5WLvSdBZnGUKBLzSee3WQoL8eCQ9kkJHHTKmqe4qOSCnE4hjm','ACTIVE','2023-12-14','2023-12-15');
/*!40000 ALTER TABLE `user_reg` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-18  0:07:30
