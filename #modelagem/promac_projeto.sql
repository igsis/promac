-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: promac
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.30-MariaDB

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
-- Table structure for table `projeto`
--

DROP TABLE IF EXISTS `projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projeto` (
  `idProjeto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(15) DEFAULT NULL,
  `tipoPessoa` tinyint(1) DEFAULT NULL COMMENT '1 - pessoa física\n2 - pessoa jurídica',
  `idPj` int(11) DEFAULT NULL,
  `contratoGestao` tinyint(1) DEFAULT NULL,
  `idPf` int(11) DEFAULT NULL,
  `nomeProjeto` varchar(200) DEFAULT NULL,
  `idAreaAtuacao` int(11) DEFAULT NULL,
  `valorProjeto` decimal(9,2) DEFAULT NULL,
  `valorIncentivo` decimal(9,2) DEFAULT NULL,
  `valorFinanciamento` decimal(9,2) DEFAULT NULL,
  `idRenunciaFiscal` int(11) DEFAULT NULL,
  `exposicaoMarca` longtext,
  `resumoProjeto` longtext,
  `curriculo` longtext,
  `descricao` longtext,
  `justificativa` longtext,
  `objetivo` longtext,
  `metodologia` longtext,
  `contrapartida` longtext,
  `publicoAlvo` longtext,
  `planoDivulgacao` longtext,
  `inicioCronograma` date DEFAULT NULL,
  `fimCronograma` date DEFAULT NULL,
  `idCronograma` int(10) unsigned DEFAULT NULL,
  `totalPreProducao` decimal(9,2) DEFAULT NULL,
  `totalProducao` decimal(9,2) DEFAULT NULL,
  `totalImprensa` decimal(9,2) DEFAULT NULL,
  `totalCustosAdministrativos` decimal(9,2) DEFAULT NULL,
  `totalImpostos` decimal(9,2) DEFAULT NULL,
  `totalAgenciamento` decimal(9,2) DEFAULT NULL,
  `totalOutrosFinanciamentos` decimal(9,2) DEFAULT NULL,
  `video1` varchar(50) DEFAULT NULL,
  `video2` varchar(50) DEFAULT NULL,
  `video3` varchar(50) DEFAULT NULL,
  `valorAprovado` decimal(9,2) DEFAULT NULL,
  `idStatus` int(11) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idProjeto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto`
--

LOCK TABLES `projeto` WRITE;
/*!40000 ALTER TABLE `projeto` DISABLE KEYS */;
INSERT INTO `projeto` VALUES (1,'2018032100001',1,NULL,NULL,1,'Projeto Teste Diego',7,100000.00,80000.00,20000.00,1,'Teste Descrição Exposição','Teste Resumo','Teste Curriculo','Teste Descrição do Objeto','Teste Justificativa','Teste Objetivo','Teste Metodologia','Teste Descrição da Contrapartida','Teste Publico Alvo','Teste Plano','2018-01-01','2018-03-31',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://www.youtube.com/watch?v=OQQmjbGX9nM','','https://www.youtube.com/watch?v=EKkzbbLYPuI',50000.00,5,1),(2,'2018032100001',2,1,0,NULL,'OSAKDOASJKDIAS',21,0.00,0.00,0.00,3,'asdasd','asdasd','asdasdsa','asdasdasd','asdasd','asdasdas','asasdasd','asdasdsa','asdsad','asdasdasd','2018-03-09','2018-03-31',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost/promac/visual/index_pj.php?perfil','http://localhost/promac/visual/index_pj.php?perfil','http://localhost/promac/visual/index_pj.php?perfil',10000.00,5,1),(3,NULL,1,NULL,NULL,3,'asdasd',19,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1);
/*!40000 ALTER TABLE `projeto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-22 11:54:39
