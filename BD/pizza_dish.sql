-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: pizza
-- ------------------------------------------------------
-- Server version	8.0.39

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
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dish` (
  `id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `Description_sh` varchar(105) DEFAULT NULL,
  `Description_fu` varchar(500) DEFAULT NULL,
  `Picture` varchar(45) DEFAULT NULL,
  `Cost` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish`
--

LOCK TABLES `dish` WRITE;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` VALUES (1,'Маргарита','Классическая пицца с томатным соусом и базиликом.','Классическая пицца Маргарита — это идеальное сочетание свежести и простоты. Тонкое тесто, покрытое ароматным томатным соусом, щедро посыпанное моцареллой и украшенное свежими листьями базилика. Это блюдо стало символом итальянской кухни и любимым выбором многих гурманов.','',500),(2,'Пепперони','Пикантная пицца с колбасой пепперони.','Пепперони — это пицца, которая покоряет сердца любителей мяса. Сочные ломтики пикантной колбасы пепперони на фоне расплавленной моцареллы и насыщенного томатного соуса создают неповторимый вкус. Идеальный выбор для тех, кто любит остроту и насыщенность.','',600),(3,'Гавайская','Пицца с ветчиной и ананасами.','Гавайская пицца — это смелое сочетание сладких ананасов и нежной ветчины. Каждый кусочек этой пиццы приносит радость благодаря гармонии вкусов: сладость ананаса прекрасно дополняет соленость ветчины, создавая уникальный гастрономический опыт.','',650),(4,'Четыре сыра','Пицца с четырьмя видами сыра.','Четыре сыра — это мечта для любителей сыра! Эта пицца сочетает в себе разнообразие вкусов: мягкость моцареллы, пикантность горгонзолы, насыщенность пармезана и кремовость рикотты. Каждый укус — это наслаждение сырной симфонии!','',700),(5,'Вегетарианская','Пицца с овощами на томатном соусе.','Вегетарианская пицца — это настоящий праздник для любителей овощей! Сочный перец, ароматные грибы и оливки создают яркую палитру вкусов на фоне легкого томатного соуса. Это блюдо не только вкусное, но и полезное!','',550),(6,'Мясная','Пицца с ветчиной и беконом.','Мясная пицца — это идеальный выбор для настоящих мясоедов. В каждом кусочке вы найдете сочетание ветчины, колбасы и бекона на хрустящем тесте. Насыщенный вкус мяса в сочетании с расплавленным сыром создает неповторимое удовольствие.','',750),(7,'Острая','Пицца с острым перцем чили.','Острая пицца — это вызов для любителей пикантного! Сочетание остроты перца чили с нежным сыром делает это блюдо настоящим испытанием для ваших вкусовых рецепторов. Идеально подходит для тех, кто ищет острые ощущения!','',600),(8,'С морепродуктами','Пицца с креветками и мидиями.','С морепродуктами — это изысканная пицца для ценителей морских деликатесов. Сочные креветки и мидии на фоне ароматного томатного соуса создают незабываемый вкус. Это блюдо перенесет вас на побережье Италии!','',800),(9,'Капричоза','Пицца с грибами и артишоками.','Капричоза — это изысканная комбинация грибов и артишоков на тонком тесте. Каждый кусочек этой пиццы наполнен ароматами итальянской кухни. Это блюдо станет отличным выбором для романтического ужина или дружеской встречи.','',700),(10,'Фунги','Пицца с грибами в сливочном соусе.','Фунги — это настоящая находка для любителей грибов! Нежные грибы в сливочном соусе создают гармоничное сочетание с расплавленной моцареллой. Это блюдо подарит вам уютные моменты наслаждения!','',650);
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-29 18:06:43
