-- MySQL dump 10.14  Distrib 5.5.44-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: advanzer_ch
-- ------------------------------------------------------
-- Server version	5.5.44-MariaDB

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
-- Table structure for table `Areas`
--

DROP TABLE IF EXISTS `Areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `estatus` int(1) DEFAULT '1',
  `direccion` int(11) NOT NULL,
  PRIMARY KEY (`id`,`direccion`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  KEY `fk_Areas_Direcciones1_idx` (`direccion`),
  CONSTRAINT `fk_Areas_Direcciones1` FOREIGN KEY (`direccion`) REFERENCES `Direcciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Areas`
--

LOCK TABLES `Areas` WRITE;
/*!40000 ALTER TABLE `Areas` DISABLE KEYS */;
INSERT INTO `Areas` VALUES (1,'GENERAL',1,1),(2,'MERCADOTECNIA',1,2),(3,'ARQUITECTURA DE SOLUCIONES',1,2),(4,'CAPITAL HUMANO',1,2),(5,'PREVENTA INICIATIVA PRIVADA',1,2),(6,'COMERCIAL INICIATIVA PRIVADA',1,2),(7,'GESTIÓN ADMINISTRATIVA',1,3),(8,'TESORERÍA',1,3),(9,'FINANZAS',1,3),(10,'PROJECT CONTROLLING',1,3),(11,'CONSULTORÍA SAP',1,4),(12,'GESTIÓN FINANCIERA GUBERNAMENTAL',1,4),(13,'CONSULTORÍA DE NEGOCIOS',1,4),(14,'CONSULTORÍA SAP BW',1,4),(15,'SOPORTE APLICATIVO',1,4),(16,'CONSULTORÍA BPC/CONSOLIDACIÓN',1,4),(17,'CONSULTORÍA BPC/PLANEACIÓN',1,4),(18,'ADMINISTRACIÓN VENTAS Y LICITACIONES',1,5),(19,'PREVENTA SECTOR PÚBLICO',1,5),(20,'PMO',1,6),(21,'BANKING',1,7),(22,'TELECOMUNICACIONES',1,8);
/*!40000 ALTER TABLE `Areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Bitacora`
--

DROP TABLE IF EXISTS `Bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Bitacora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accion` int(2) DEFAULT '1' COMMENT '1=eliminar\n2=cambios en el sistema\n3=inserción de datos\n4=periodo para modificar\n5=acceso al sistema',
  `descripcion` varchar(2000) DEFAULT NULL,
  `valor` varchar(100) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Bitacora`
--

LOCK TABLES `Bitacora` WRITE;
/*!40000 ALTER TABLE `Bitacora` DISABLE KEYS */;
INSERT INTO `Bitacora` VALUES (1,3,'se agrega nuevo registro en Porcentajes_Objetivos','1147','2015-11-19 23:31:15'),(2,3,'se agrega nuevo registro en Porcentajes_Objetivos','1148','2015-11-19 23:31:16'),(3,3,'se agrega nuevo registro en Porcentajes_Objetivos','1149','2015-11-19 23:31:17'),(4,3,'se agrega nuevo registro en Porcentajes_Objetivos','1150','2015-11-19 23:31:18'),(5,3,'se agrega nuevo registro en Porcentajes_Objetivos','1151','2015-11-19 23:31:19');
/*!40000 ALTER TABLE `Bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Competencias`
--

DROP TABLE IF EXISTS `Competencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Competencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `indicador` int(11) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `estatus` int(1) DEFAULT '1',
  `resumen` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  KEY `fk_Competencias_Indicadores1_idx` (`indicador`),
  CONSTRAINT `fk_Competencias_Indicadores1` FOREIGN KEY (`indicador`) REFERENCES `Indicadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Competencias`
--

LOCK TABLES `Competencias` WRITE;
/*!40000 ALTER TABLE `Competencias` DISABLE KEYS */;
INSERT INTO `Competencias` VALUES (1,'Confiabilidad',1,'Capacidad de comprometerse y cumplir con lo acordado.',1,''),(2,'Planeación',1,'Capacidad de establecer con claridad secuencias de trabajo así como su seguimiento.',1,''),(3,'Rendición de Cuentas',1,'Capacidad de responsabilizarse de sus actos y dar cuenta de ellos.',1,''),(4,'Comunicación',2,'Capacidad de recibir y transmitir información de manera efectiva.',1,''),(5,'Trabajo en equipo',2,'Capacidad de relacionarse adecuadamente dentro de los grupos de colaboración.',1,''),(6,'Orientación al cliente',2,'Capacidad de establecer relaciones de negocio basadas en el servicio a los demás.',1,''),(7,'Creatividad e Innovación',3,'Capacidad de crear y/o mejorar lo ya establecido a nivel servicio u operación diaria.',1,''),(8,'Sensibilidad tecnológica',3,'Capacidad de incorporar tecnología y trabajar con ella de manera cotidiana.',1,''),(9,'Aprendizaje continuo',3,'Capacidad de estar receptivo a los nuevos conocimientos, a su búsqueda y diseminación.',1,''),(10,'Liderazgo',4,'Capacidad de influenciar en los demás para el logro de los resultados.',1,''),(11,'Supervisión matricial',4,'Capacidad de gestionar eficazmente a su equipo de trabajo.',1,''),(12,'Toma de decisiones',4,'Capacidad de operar y solucionar contingencias de forma eficaz.',1,''),(13,'Empoderamiento de otros',5,'Capacidad de favorecer el desarrollo integral de su equipo de trabajo.',1,''),(14,'Visión de negocio',5,'Capacidad de operar con una perspectiva integral de socio.',1,''),(15,'Pensamiento estratégico',5,'Capacidad de afrontar entornos complejos, situaciones de crisis y oportunidades emergentes.',1,'');
/*!40000 ALTER TABLE `Competencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comportamiento_Posicion`
--

DROP TABLE IF EXISTS `Comportamiento_Posicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comportamiento_Posicion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comportamiento` int(11) NOT NULL,
  `nivel_posicion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comportamiento_UNIQUE` (`comportamiento`,`nivel_posicion`),
  KEY `fk_Comportamieento_Posicion_Comportamientos1_idx` (`comportamiento`),
  CONSTRAINT `fk_Comportamieento_Posicion_Comportamientos1` FOREIGN KEY (`comportamiento`) REFERENCES `Comportamientos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comportamiento_Posicion`
--

LOCK TABLES `Comportamiento_Posicion` WRITE;
/*!40000 ALTER TABLE `Comportamiento_Posicion` DISABLE KEYS */;
INSERT INTO `Comportamiento_Posicion` VALUES (6,1,3),(5,1,4),(4,1,5),(3,1,6),(2,1,7),(1,1,8),(12,2,3),(11,2,4),(10,2,5),(9,2,6),(8,2,7),(7,2,8),(18,3,3),(17,3,4),(16,3,5),(15,3,6),(14,3,7),(13,3,8),(23,4,3),(22,4,4),(21,4,5),(20,4,6),(19,4,7),(27,5,3),(26,5,4),(25,5,5),(24,5,6),(33,6,3),(32,6,4),(31,6,5),(30,6,6),(29,6,7),(28,6,8),(39,7,3),(38,7,4),(37,7,5),(36,7,6),(35,7,7),(34,7,8),(44,8,3),(43,8,4),(42,8,5),(41,8,6),(40,8,7),(48,9,3),(47,9,4),(46,9,5),(45,9,6),(51,10,3),(50,10,4),(49,10,5),(54,11,3),(53,11,4),(52,11,5),(60,12,3),(59,12,4),(58,12,5),(57,12,6),(56,12,7),(55,12,8),(66,13,3),(65,13,4),(64,13,5),(63,13,6),(62,13,7),(61,13,8),(72,14,3),(71,14,4),(70,14,5),(69,14,6),(68,14,7),(67,14,8),(78,15,3),(77,15,4),(76,15,5),(75,15,6),(74,15,7),(73,15,8),(83,16,3),(82,16,4),(81,16,5),(80,16,6),(79,16,7),(89,17,3),(88,17,4),(87,17,5),(86,17,6),(85,17,7),(84,17,8),(95,18,3),(94,18,4),(93,18,5),(92,18,6),(91,18,7),(90,18,8),(100,19,3),(99,19,4),(98,19,5),(97,19,6),(96,19,7),(104,20,3),(103,20,4),(102,20,5),(101,20,6),(107,21,3),(106,21,4),(105,21,5),(113,22,3),(112,22,4),(111,22,5),(110,22,6),(109,22,7),(108,22,8),(118,23,3),(117,23,4),(116,23,5),(115,23,6),(114,23,7),(122,24,3),(121,24,4),(120,24,5),(119,24,6),(125,25,3),(124,25,4),(123,25,5),(128,26,3),(127,26,4),(126,26,5),(134,27,3),(133,27,4),(132,27,5),(131,27,6),(130,27,7),(129,27,8),(140,28,3),(139,28,4),(138,28,5),(137,28,6),(136,28,7),(135,28,8),(146,29,3),(145,29,4),(144,29,5),(143,29,6),(142,29,7),(141,29,8),(150,30,3),(149,30,4),(148,30,5),(147,30,6),(156,31,3),(155,31,4),(154,31,5),(153,31,6),(152,31,7),(151,31,8),(161,32,3),(160,32,4),(159,32,5),(158,32,6),(157,32,7),(165,33,3),(164,33,4),(163,33,5),(162,33,6),(168,34,3),(167,34,4),(166,34,5),(171,35,3),(170,35,4),(169,35,5),(177,36,3),(176,36,4),(175,36,5),(174,36,6),(173,36,7),(172,36,8),(182,37,3),(181,37,4),(180,37,5),(179,37,6),(178,37,7),(186,38,3),(185,38,4),(184,38,5),(183,38,6),(189,39,3),(188,39,4),(187,39,5),(195,40,3),(194,40,4),(193,40,5),(192,40,6),(191,40,7),(190,40,8),(201,41,3),(200,41,4),(199,41,5),(198,41,6),(197,41,7),(196,41,8),(206,42,3),(205,42,4),(204,42,5),(203,42,6),(202,42,7),(210,43,3),(209,43,4),(208,43,5),(207,43,6),(214,44,3),(213,44,4),(212,44,5),(211,44,6),(217,45,3),(216,45,4),(215,45,5),(220,46,3),(219,46,4),(218,46,5),(223,47,3),(222,47,4),(221,47,5),(226,48,3),(225,48,4),(224,48,5),(228,49,3),(227,49,4),(231,50,3),(230,50,4),(229,50,5),(234,51,3),(233,51,4),(232,51,5),(237,52,3),(236,52,4),(235,52,5),(240,53,3),(239,53,4),(238,53,5),(243,54,3),(242,54,4),(241,54,5),(246,55,3),(245,55,4),(244,55,5),(249,56,3),(248,56,4),(247,56,5),(252,57,3),(251,57,4),(250,57,5),(255,58,3),(254,58,4),(253,58,5),(257,59,3),(256,59,4),(258,60,3),(259,61,3),(260,62,3),(261,63,3),(262,64,3),(263,65,3),(264,66,3),(265,67,3),(266,68,3),(267,69,3),(268,70,3),(269,71,3),(270,72,3),(271,73,3);
/*!40000 ALTER TABLE `Comportamiento_Posicion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comportamientos`
--

DROP TABLE IF EXISTS `Comportamientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comportamientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) NOT NULL,
  `competencia` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Comportamientos_Competencias1_idx` (`competencia`),
  CONSTRAINT `fk_Comportamientos_Competencias1` FOREIGN KEY (`competencia`) REFERENCES `Competencias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comportamientos`
--

LOCK TABLES `Comportamientos` WRITE;
/*!40000 ALTER TABLE `Comportamientos` DISABLE KEYS */;
INSERT INTO `Comportamientos` VALUES (1,'Actúa con transparencia',1),(2,'Se comporta de acuerdo a lo acordado',1),(3,'Trata la información sensible o confidencial de manera adecuada',1),(4,'Le da el crédito apropiado a los demás',1),(5,'Proporciona un entorno en el que otros pueden hablar y actuar sin miedo a las repercusiones',1),(6,'Utiliza el tiempo de manera eficiente',2),(7,'Asigna cantidad adecuada de tiempo y recursos para completar el trabajo',2),(8,'Identifica las actividades y tareas prioritarias; ajusta su agenda según sea necesario',2),(9,'Monitorea y ajusta sus planes y acciones según considere necesarias',2),(10,'Desarrolla metas claras y congruentes a las estrategias organizacionales',2),(11,'Prevé riesgos y contempla contingencias',2),(12,'Se apropia de todas sus responsabilidades',3),(13,'Asume su responsabilidad ante sus propias áreas de oportunidad',3),(14,'Actúa en función de los procedimientos y las políticas de la organización',3),(15,'Entrega los productos a su cargo dentro de los estándares de tiempo, costo y calidad prescritos',3),(16,'Apoya a subordinados, proporciona supervisión y se responsabiliza de las actividades delegadas',3),(17,'Realiza pregunta para clarificar y muestra interés en una interacción de dos vías',4),(18,'Adecua lenguaje, tono, estilo y formato según la audiencia',4),(19,'Se expresa clara y efectivamente de manera verbal y escrita',4),(20,'Demuestra apertura al compartir y mantener informada a la gente',4),(21,'Escucha a otros, comprende correctamente los mensajes de los demás y responde apropiadamente',4),(22,'Trabaja colaborativamente con compañeros para alcanzar los objetivos organizacionales',5),(23,'Solicita contribuciones valorando genuinamente las ideas y la experiencia de los demás',5),(24,'Prioriza en función de su equipo y no de intereses personales',5),(25,'Actúa de acuerdo a la decisión final del equipo, aun cuando la resolución no refleja totalmente su propia decisión',5),(26,'Comparte el crédito por los logros del equipo y acepta la responsabilidad conjunta de las deficiencias',5),(27,'Considera a todos a aquellos a quienes da servicio como “clientes” y trata de ver las cosas desde el punto de vista de ellos',6),(28,'Mantiene informado a sus clientes del progreso o retroceso de los pendientes',6),(29,'Cumple en tiempo la entrega de productos o servicios a los clientes',6),(30,'Establece y mantiene alianzas productivas con los clientes mediante la obtención de su confianza y respeto',6),(31,'Muestra interés en nuevas ideas y nuevas formas de hacer las cosas',7),(32,'Ofrece nuevas y diferentes opciones para abordar problemas o satisfacer necesidades',7),(33,'Busca activamente mejorar los programas o servicios',7),(34,'Promueve y persuade a otros a considerar nuevas ideas',7),(35,'Toma riesgos calculados sobre ideas nuevas e inusuales',7),(36,'Muestra interés en aprender nuevas tecnologías',8),(37,'Se mantiene actualizado de la tecnología disponible',8),(38,'Entiende la aplicabilidad y las limitaciones de la tecnología para el trabajo',8),(39,'Busca activamente aplicar la tecnología adecuada en las tareas diarias',8),(40,'Muestra disposición a aprender de los demás',9),(41,'Busca retroalimentación para aprender y mejorar',9),(42,'Se mantiene actualizado de los nuevos avances en su área de especialidad',9),(43,'Busca activamente cómo desarrollarse profesional y personalmente',9),(44,'Contribuye al aprendizaje de colaboradores y subordinados',9),(45,'Establece y mantiene relaciones con una amplia gama de personas para entender las necesidades y obtener apoyo',10),(46,'Anticipa y resuelve los conflictos mediante la aplicación de soluciones de mutuo acuerdo',10),(47,'Es proactivo en el desarrollo de estrategias para lograr los objetivos',10),(48,'Promueve el cambio y la mejora; no acepta el status quo',10),(49,'Es un ejemplo de modelo a seguir para su equipo de trabajo',10),(50,'Evalúa el desempeño de forma justa',11),(51,'Se asegura que los roles, responsabilidades y líneas de reporte sean claros para cada miembro de su equipo',11),(52,'Cuestiona la cantidad de tiempo y recursos necesarios para llevar a cabo una tarea vs',11),(53,'Controla el progreso con base a los milestones y deadlines',11),(54,'Proporciona retroalimentación y asesoría a su equipo derivado del rendimiento mostrado',11),(55,'Recopila información relevante antes de tomar una decisión',12),(56,'Propone un curso de acción basada en toda la información disponible',12),(57,'Identifica las cuestiones clave en una situación compleja y llega a la raíz del problema rápidamente',12),(58,'Considera impactos positivos y negativos de las decisiones antes de tomarlas',12),(59,'Toma decisiones considerando el impacto en los demás y en la Organización',12),(60,'Apoya activamente las aspiraciones de desarrollo y carrera de su staff',13),(61,'Faculta a los demás para traducir la visión en resultados',13),(62,'Alienta a la toma de riesgos y apoya la creatividad y la iniciativa',13),(63,'Delegados la responsabilidad apropiada, la rendición de cuentas y la autoridad para la toma de decisiones',13),(64,'Comprende los fundamentos y prácticas esenciales del negocio',14),(65,'Aplica el conocimiento de la industria, el mercado y las tendencias del negocio para dar prioridad a las actividades',14),(66,'Aprovecha las oportunidades del sector empresarial y la dinámica del mercado para ejecutar la estrategia de la compañía',14),(67,'Inculca un enfoque orientada a los negocios propiciando la investigación y el avance tecnológico',14),(68,'Es un top model dentro de la compañía y en el mercado como para ser considerado un socio de confianza',14),(69,'Discrimina entre situaciones de la operación diaria y temas estratégicos con el fin de abordarlos puntualmente',15),(70,'Define distintos escenarios tomando en cuenta su experiencia previa y su percepción de la situación actual',15),(71,'Evalúa cuantiva y culitativamente el conjunto de alternativas previo a llevarlas a la práctica',15),(72,'Implementa de forma sistemática la mejor alternativa así como un proceso de seguimiento para medir el impacto',15),(73,'Conduce bajo un enfoque de mejora cotinua cada una de sus asignaciones analizando recursivamente sus avances',15);
/*!40000 ALTER TABLE `Comportamientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Detalle_Evaluacion`
--

DROP TABLE IF EXISTS `Detalle_Evaluacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Detalle_Evaluacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asignacion` int(11) NOT NULL,
  `metrica` int(11) DEFAULT NULL,
  `objetivo` int(11) NOT NULL,
  `justificacion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Detalle_Evaluacion_Evaluadores1_idx` (`asignacion`),
  KEY `fk_Detalle_Evaluacion_Metricas1_idx` (`metrica`,`objetivo`),
  CONSTRAINT `fk_Detalle_Evaluacion_Evaluadores1` FOREIGN KEY (`asignacion`) REFERENCES `Evaluadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Detalle_Evaluacion_Metricas1` FOREIGN KEY (`metrica`, `objetivo`) REFERENCES `Metricas` (`id`, `objetivo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Detalle_Evaluacion`
--

LOCK TABLES `Detalle_Evaluacion` WRITE;
/*!40000 ALTER TABLE `Detalle_Evaluacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Detalle_Evaluacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Detalle_Evaluacion_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Detalle_Evaluacion` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Detalle_Evaluacion',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Detalle_Evaluacion_AFTER_UPDATE_Bitacora` 
AFTER UPDATE ON `Detalle_Evaluacion` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(2,concat('se modifica registro (metrica: ',OLD.metrica,' - ',NEW.metrica,
		', justificacion: ',OLD.justificacion,' - ',NEW.justificacion,', de la asignacion: '
        ,OLD.asignacion,' del objetivo: ',OLD.objetivo),NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Detalle_ev_360`
--

DROP TABLE IF EXISTS `Detalle_ev_360`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Detalle_ev_360` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asignacion` int(11) NOT NULL,
  `competencia` int(11) NOT NULL,
  `respuesta` int(1) DEFAULT NULL,
  `justificacion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Detalle_ev_360_Evaluadores1_idx` (`asignacion`),
  KEY `fk_Detalle_ev_360_Competencias1_idx` (`competencia`),
  CONSTRAINT `fk_Detalle_ev_360_Competencias1` FOREIGN KEY (`competencia`) REFERENCES `Competencias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Detalle_ev_360_Evaluadores1` FOREIGN KEY (`asignacion`) REFERENCES `Evaluadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Detalle_ev_360`
--

LOCK TABLES `Detalle_ev_360` WRITE;
/*!40000 ALTER TABLE `Detalle_ev_360` DISABLE KEYS */;
/*!40000 ALTER TABLE `Detalle_ev_360` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Detalle_ev_Competencia`
--

DROP TABLE IF EXISTS `Detalle_ev_Competencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Detalle_ev_Competencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asignacion` int(11) NOT NULL,
  `comportamiento` int(11) NOT NULL,
  `respuesta` int(1) DEFAULT NULL,
  `justificacion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`,`asignacion`,`comportamiento`),
  KEY `fk_Detalle_ev_Competencia_Evaluadores1_idx` (`asignacion`),
  KEY `fk_Detalle_ev_Competencia_Comportamientos1_idx` (`comportamiento`),
  CONSTRAINT `fk_Detalle_ev_Competencia_Comportamientos1` FOREIGN KEY (`comportamiento`) REFERENCES `Comportamientos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Detalle_ev_Competencia_Evaluadores1` FOREIGN KEY (`asignacion`) REFERENCES `Evaluadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='de la asignacion(evaluador-evaluado) por cada comportamiento obtiene un valor esperado 0 o 1 falso o verdadero';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Detalle_ev_Competencia`
--

LOCK TABLES `Detalle_ev_Competencia` WRITE;
/*!40000 ALTER TABLE `Detalle_ev_Competencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `Detalle_ev_Competencia` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Detalle_ev_Competencia_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Detalle_ev_Competencia` FOR EACH ROW BEGIN
	INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Detalle_ev_Competencia',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Detalle_ev_Competencia_AFTER_UPDATE_Bitacora` 
AFTER UPDATE ON `Detalle_ev_Competencia` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(2,concat('se modifica registro (respuesta: ',OLD.respuesta,' - ',NEW.respuesta,
		', justificacion: ',OLD.justificacion,' - ',NEW.justificacion,', de la asignacion: ',
        OLD.asignacion,' del comportamiento: ',OLD.comportamiento),NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Detalle_ev_Proyecto`
--

DROP TABLE IF EXISTS `Detalle_ev_Proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Detalle_ev_Proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `respuesta` int(1) DEFAULT NULL,
  `justificacion` varchar(500) DEFAULT NULL,
  `dominio` int(11) NOT NULL,
  `asignacion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Detalle_ev_Proyecto_Dominios1_idx` (`dominio`),
  KEY `fk_Detalle_ev_Proyecto_Evaluadores1_idx` (`asignacion`),
  CONSTRAINT `fk_Detalle_ev_Proyecto_Dominios1` FOREIGN KEY (`dominio`) REFERENCES `Dominios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Detalle_ev_Proyecto_Evaluadores1` FOREIGN KEY (`asignacion`) REFERENCES `Evaluadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Detalle_ev_Proyecto`
--

LOCK TABLES `Detalle_ev_Proyecto` WRITE;
/*!40000 ALTER TABLE `Detalle_ev_Proyecto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Detalle_ev_Proyecto` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Detalle_ev_Proyecto_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Detalle_ev_Proyecto` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Detalle_ev_Proyecto',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Detalle_ev_Proyecto_AFTER_UPDATE_Bitacora` 
AFTER UPDATE ON `Detalle_ev_Proyecto` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(2,concat('se modifica registro (respuesta: ',OLD.respuesta,' - ',NEW.respuesta,
		', justificacion: ',OLD.justificacion,' - ',NEW.justificacion,', del dominio: '
        ,OLD.dominio,' de la asignacion',OLD.asignacion),NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Direcciones`
--

DROP TABLE IF EXISTS `Direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Direcciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Direcciones`
--

LOCK TABLES `Direcciones` WRITE;
/*!40000 ALTER TABLE `Direcciones` DISABLE KEYS */;
INSERT INTO `Direcciones` VALUES (3,'ADMINISTRACIÓN Y FINANZAS'),(5,'COMERCIAL SECTOR PÚBLICO'),(4,'CONSULTORÍA Y OPERACIONES'),(1,'GENERAL'),(2,'INICIATIVA PRIVADA Y PLATAFORMAS ESTRATÉGICAS'),(6,'PMO Y SERVICIOS FINANCIEROS'),(7,'SOLUCIONES SERVICIOS FINANCIEROS'),(8,'TELECOMUNICACIONES');
/*!40000 ALTER TABLE `Direcciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Dominios`
--

DROP TABLE IF EXISTS `Dominios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Dominios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estatus` int(1) DEFAULT '1',
  `descripcion` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Dominios`
--

LOCK TABLES `Dominios` WRITE;
/*!40000 ALTER TABLE `Dominios` DISABLE KEYS */;
INSERT INTO `Dominios` VALUES (51,'Tiempo',1,'Cumplió con los plazos acordados para la entrega de información requerida.'),(52,'Costo',1,'Llevó a cabo acciones que permitieron eficientar los gastos del proyecto en el que participó, así como aprovechar al máximo los recursos disponibles.'),(53,'Calidad',1,'Realizó cada una de sus actividades y/o asignaciones con el nivel de excelencia requerido.'),(54,'Entregables',1,'Entregó los productos comprometidos cumpliendo con las especificaciones acordadas/necesarias.'),(55,'Relación con clientes',1,'Desarrolló vínculos efectivos de colaboración con cada uno de los clientes a los que les dio servicio, sin importar que fueran internos o externos.'),(56,'Generación de Negocio',1,'Capitalizó su interacción con el cliente externo para identificar y sugerir/plantear alguna oportunidad comercial.'),(57,'Habilidades',1,'Demostró la expertise necesaria (conocimientos, aptitudes, destrezas, etc.) para dar respuesta a las demandas del proyecto/asignación.');
/*!40000 ALTER TABLE `Dominios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Evaluaciones`
--

DROP TABLE IF EXISTS `Evaluaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Evaluaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estatus` int(1) DEFAULT '1',
  `anio` int(4) DEFAULT NULL,
  `inicio` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `lider` int(11) DEFAULT NULL,
  `tipo` int(1) DEFAULT NULL,
  `inicio_periodo` date DEFAULT NULL,
  `fin_periodo` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`,`anio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Evaluaciones`
--

LOCK TABLES `Evaluaciones` WRITE;
/*!40000 ALTER TABLE `Evaluaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `Evaluaciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Evaluaciones_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Evaluaciones` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Evaluaciones',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Evaluaciones_AFTER_UPDATE_Bitacora` 
AFTER UPDATE ON `Evaluaciones` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(2,concat('se modifica registro (nombre: ',OLD.nombre,' - ',NEW.nombre,
		', estatus: ',OLD.estatus,' - ',NEW.estatus,', anio: ',OLD.anio,' - '
        ,NEW.anio,', inicio: ',OLD.inicio,' - ',NEW.inicio,',fin: ',OLD.fin,' - ',NEW.fin
        ,', lider: ',OLD.lider,' - ',NEW.lider,', inicio-periodo: ',OLD.inicio_periodo,' - '
        ,NEW.inicio_periodo,', fin-periodo: ',OLD.fin_periodo,' - ',NEW.fin_periodo),NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Evaluadores`
--

DROP TABLE IF EXISTS `Evaluadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Evaluadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluador` int(11) NOT NULL,
  `evaluado` int(11) NOT NULL,
  `estatus` int(1) DEFAULT '0',
  `evaluacion` int(11) DEFAULT NULL,
  `comentarios` varchar(1000) DEFAULT NULL,
  `anual` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `evaluador_UNIQUE` (`evaluador`,`evaluado`,`evaluacion`),
  KEY `fk_Evaluadores_Evaluaciones1_idx` (`evaluacion`),
  CONSTRAINT `fk_Evaluadores_Evaluaciones1` FOREIGN KEY (`evaluacion`) REFERENCES `Evaluaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Evaluadores`
--

LOCK TABLES `Evaluadores` WRITE;
/*!40000 ALTER TABLE `Evaluadores` DISABLE KEYS */;
/*!40000 ALTER TABLE `Evaluadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Feedbacks`
--

DROP TABLE IF EXISTS `Feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estatus` int(1) DEFAULT '0' COMMENT '1=enviado;2=enterado',
  `fortalezas` varchar(2000) DEFAULT NULL,
  `resultado` int(11) NOT NULL,
  `feedbacker` int(11) NOT NULL DEFAULT '0',
  `oportunidad` varchar(2000) DEFAULT NULL,
  `compromisos` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`,`resultado`,`feedbacker`),
  KEY `fk_Feedbacks_Resultados_Evaluacion1_idx` (`resultado`),
  KEY `fk_Feedbacks_Users1_idx` (`feedbacker`),
  CONSTRAINT `fk_Feedbacks_Resultados_Evaluacion1` FOREIGN KEY (`resultado`) REFERENCES `Resultados_Evaluacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Feedbacks_Users1` FOREIGN KEY (`feedbacker`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Feedbacks`
--

LOCK TABLES `Feedbacks` WRITE;
/*!40000 ALTER TABLE `Feedbacks` DISABLE KEYS */;
/*!40000 ALTER TABLE `Feedbacks` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Feedbacks_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Feedbacks` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Feedbacks',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Feedbacks_AFTER_UPDATE_Bitacora` 
AFTER UPDATE ON `Feedbacks` FOR EACH ROW BEGIN
    INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(2,concat('se modifica registro (estatus: ',OLD.estatus,' - ',NEW.estatus,
		', fortalezas: ',OLD.fortalezas,' - ',NEW.fortalezas,', oportunidad: ',OLD.oportunidad,
        ' - ',NEW.oportunidad,', compromisos: ',OLD.compromisos,' - ',NEW.compromisos,
        ', feedbacker: ',OLD.feedbacker,' - '
        ,NEW.feedbacker,', del resultado: ',OLD.resultado),NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Historial`
--

DROP TABLE IF EXISTS `Historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Historial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anio` int(4) DEFAULT NULL,
  `rating` char(1) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `comentarios` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Historial`
--

LOCK TABLES `Historial` WRITE;
/*!40000 ALTER TABLE `Historial` DISABLE KEYS */;
INSERT INTO `Historial` VALUES (1,2013,'B','tadeo.zavala@advanzer.com',''),(2,2013,'C','monica.saenz@advanzer.com',''),(3,2013,'C','erick.quinones@advanzer.com',''),(4,2013,'C','alma.trejo@advanzer.com',''),(5,2013,'C','tere.vazquez@advanzer.com',''),(6,2013,'B','marcos.ramos@advanzer.com',''),(7,2013,'C','mauricio.guerrero@advanzer.com',''),(8,2013,'B','abigail.flores@advanzer.com',''),(9,2013,'C','josefina.ramos@advanzer.com',''),(10,2013,'B','dora.ramirez@advanzer.com',''),(11,2013,'C','gabriela.rodriguez@advanzer.com',''),(12,2013,'C','jorge.salvans@advanzer.com',''),(13,2013,'C','juanjose.malanche@advanzer.com',''),(14,2013,'C','rodolfo.cortes@advanzer.com',''),(15,2013,'B','edson.rodriguez@advanzer.com',''),(16,2013,'D','javier.ynoquio@advanzer.com',''),(17,2013,'C','eduardo.ochoa@advanzer.com',''),(18,2013,'B','enrique.bernal@advanzer.com',''),(19,2013,'C','yabneel.longoria@advanzer.com',''),(20,2013,'C','jorgeluis.zuniga@advanzer.com',''),(21,2013,'C','pricila.moncada@advanzer.com',''),(22,2013,'C','leticia.cavazos@advanzer.com',''),(23,2013,'C','amira.chavez@advanzer.com',''),(24,2013,'B','daniel.garfunkel@advanzer.com',''),(25,2013,'C','roberto.banales@advanzer.com',''),(26,2013,'C','ignacio.herrera@advanzer.com',''),(27,2013,'C','nancy.vazquez@advanzer.com',''),(28,2013,'C','martin.garza@advanzer.com',''),(29,2013,'C','esteban.cansino@advanzer.com',''),(30,2013,'C','rolando.berain@advanzer.com',''),(31,2013,'C','miguel.martinez@advanzer.com',''),(32,2013,'C','ana.gonzalez@advanzer.com',''),(33,2013,'C','oscar.lozano@advanzer.com',''),(34,2013,'C','ramon.diaz@advanzer.com',''),(35,2013,'B','micaela.llano@advanzer.com',''),(36,2013,'B','luisgerardo.gallegos@advanzer.com',''),(37,2013,'C','amado.gonzalez@advanzer.com',''),(38,2013,'C','francisco.herrera@advanzer.com',''),(39,2013,'C','victor.martinez@advanzer.com',''),(40,2014,'D','magdalena.guerrero@advanzer.com',''),(41,2014,'D','rodolfo.cortes@advanzer.com',''),(42,2014,'C','francisco.herrera@advanzer.com',''),(43,2014,'B','micaela.llano@advanzer.com',''),(44,2014,'C','raul.lopez@advanzer.com',''),(45,2014,'C','abigail.flores@advanzer.com',''),(46,2014,'C','adriana.tamez@advanzer.com',''),(47,2014,'C','alma.trejo@advanzer.com',''),(48,2014,'C','amado.gonzalez@advanzer.com',''),(49,2014,'C','amira.chavez@advanzer.com',''),(50,2014,'B','ana.gonzalez@advanzer.com',''),(51,2014,'C','cesar.rodriguez@advanzer.com',''),(52,2014,'A','daniel.garfunkel@advanzer.com',''),(53,2014,'C','diana.sepulveda@advanzer.com',''),(54,2014,'B','dora.ramirez@advanzer.com',''),(55,2014,'B','edson.rodriguez@advanzer.com',''),(56,2014,'C','eduardo.ochoa@advanzer.com',''),(57,2014,'D','erick.quinones@advanzer.com',''),(58,2014,'C','erika.cruz@advanzer.com',''),(59,2014,'C','esteban.cansino@advanzer.com',''),(60,2014,'','abigail.montemayor@advanzer.com',''),(61,2014,'C','daniel.gallegos@advanzer.com',''),(62,2014,'C','gabriela.rodriguez@advanzer.com',''),(63,2014,'D','gustavo.pastrana@entuizer.com',''),(64,2014,'D','hernan.gonzalez@advanzer.com',''),(65,2014,'C','hugo.alvarez@advanzer.com',''),(66,2014,'C','ignacio.herrera@advanzer.com',''),(67,2014,'D','ivan.hernandezm@advanzer.com',''),(68,2014,'C','javier.ynoquio@advanzer.com',''),(69,2014,'E','jesus.gonzalez@advanzer.com',''),(70,2014,'C','rolando.berain@advanzer.com',''),(71,2014,'A','jorge.salvans@advanzer.com',''),(72,2014,'C','jorgeluis.zuniga@advanzer.com',''),(73,2014,'C','jose.gutierrez@advanzer.com',''),(74,2014,'C','josefina.ramos@advanzer.com',''),(75,2014,'C','juanjose.malanche@advanzer.com',''),(76,2014,'C','luisgerardo.gallegos@advanzer.com',''),(77,2014,'D','luis.garibay@advanzer.com',''),(78,2014,'C','tere.vazquez@advanzer.com',''),(79,2014,'D','manuel.cruz@advanzer.com',''),(80,2014,'C','marcos.ramos@advanzer.com',''),(81,2014,'C','martin.garza@advanzer.com',''),(82,2014,'C','mauricio.guerrero@advanzer.com',''),(83,2014,'C','miguel.hilario@advanzer.com',''),(84,2014,'B','miguel.martinez@advanzer.com',''),(85,2014,'B','monica.saenz@advanzer.com',''),(86,2014,'B','nancy.vazquez@advanzer.com',''),(87,2014,'C','leticia.cavazos@advanzer.com',''),(88,2014,'C','oscar.lozano@advanzer.com',''),(89,2014,'A','pricila.moncada@advanzer.com',''),(90,2014,'B','ramon.diaz@advanzer.com',''),(91,2014,'B','roberto.banales@advanzer.com',''),(92,2014,'D','saul.castro@advanzer.com',''),(93,2014,'B','tadeo.zavala@advanzer.com',''),(94,2014,'A','victor.castro@advanzer.com',''),(95,2014,'C','yabneel.longoria@advanzer.com','');
/*!40000 ALTER TABLE `Historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Indicadores`
--

DROP TABLE IF EXISTS `Indicadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Indicadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estatus` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Indicadores`
--

LOCK TABLES `Indicadores` WRITE;
/*!40000 ALTER TABLE `Indicadores` DISABLE KEYS */;
INSERT INTO `Indicadores` VALUES (1,'Autogestión',1),(2,'Interacción',1),(3,'Negocio',1),(4,'Gerenciamiento',1),(5,'Dirección',1);
/*!40000 ALTER TABLE `Indicadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Metricas`
--

DROP TABLE IF EXISTS `Metricas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Metricas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` int(11) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `objetivo` int(11) NOT NULL,
  PRIMARY KEY (`id`,`objetivo`),
  KEY `fk_Metricas_Objetivos1_idx` (`objetivo`),
  CONSTRAINT `fk_Metricas_Objetivos1` FOREIGN KEY (`objetivo`) REFERENCES `Objetivos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Metricas`
--

LOCK TABLES `Metricas` WRITE;
/*!40000 ALTER TABLE `Metricas` DISABLE KEYS */;
INSERT INTO `Metricas` VALUES (1,5,' Entrega 10 días antes de lo pactado.',1),(2,4,' Entrega 5 días antes de lo pactado.',1),(3,3,' Entrega el día pactado.',1),(4,2,' Entrega un día después de lo pactado.',1),(5,1,' Entrega dos o más días después de lo pactado.',1),(6,5,' Mayor que 116%.',2),(7,4,' Entre 101% y 115%.',2),(8,3,' Entre 86% y 100%.',2),(9,2,' Entre 65% y 85%.',2),(10,1,' Menor que 66%.',2),(11,5,' Horas reales menores al 65% del presupuesto',3),(12,4,' Entre el 66% y 85% del presupuesto.',3),(13,3,' Entre 86% y 100%.',3),(14,2,' Entre 101% y 115%.',3),(15,1,' Horas reales mayores al 116% del presupuesto.',3),(16,5,' El cliente expresa su satisfacción global por medio del reconocimiento y publicación del servicio brindado.',4),(17,4,' El cliente muestra reconocimiento por la superación de sus expectativas.',4),(18,3,' El cliente se encuentra satisfecho (entre el 86% y el 100% de aceptación).',4),(19,2,' El cliente muestra inconformidad (entre el 65% y el 85% de aceptación).',4),(20,1,' El cliente expresa insatisfacción (menos del 64% de aceptación).',4),(21,5,' Sin errores y acorde a las mejores prácticas.',5),(22,4,' Sin errores.',5),(23,3,' Menos del 14% de errores en sus entregas.',5),(24,2,' Entre el 15% y 35% de erres en sus entregas.',5),(25,1,' Más de 66% de errores en sus entregas.',5),(26,5,' Sin errores y acorde a las mejores prácticas.',6),(27,4,' Sin errores.',6),(28,3,' Menos del 14% de errores en sus entregas.',6),(29,2,' Entre el 15% y 35% de erres en sus entregas.',6),(30,1,' Más de 66% de errores en sus entregas.',6),(31,5,' Sin errores y acorde a las mejores prácticas.',7),(32,4,' Sin errores.',7),(33,3,' Menos del 14% de errores en sus entregas.',7),(34,2,' Entre el 15% y 35% de erres en sus entregas.',7),(35,1,' Más de 66% de errores en sus entregas.',7),(36,5,' Sin errores y acorde a las mejores prácticas.',8),(37,4,' Sin errores.',8),(38,3,' Menos del 14% de errores en sus entregas.',8),(39,2,' Entre el 15% y 35% de erres en sus entregas.',8),(40,1,' Más de 66% de errores en sus entregas.',8),(41,5,' Sin errores y acorde a las mejores prácticas.',9),(42,4,' Sin errores.',9),(43,3,' Menos del 14% de errores en sus entregas.',9),(44,2,' Entre el 15% y 35% de erres en sus entregas.',9),(45,1,' Más de 66% de errores en sus entregas.',9),(46,5,' Sin errores y acorde a las mejores prácticas.',10),(47,4,' Sin errores.',10),(48,3,' Menos del 14% de errores en sus entregas.',10),(49,2,' Entre el 15% y 35% de erres en sus entregas.',10),(50,1,' Más de 66% de errores en sus entregas.',10),(51,5,' Más del 90% de proyectos con evidencia de apego al modelo.',11),(52,4,' Entre 81% y 90% de con evidencia de apego al modelo.',11),(53,3,' Entre el 71% y 80% de con evidencia de apego al modelo.',11),(54,2,' Entre el 61% y 70% de con evidencia de apego al modelo.',11),(55,1,' Menos del 60%  de los proyectos con evidencia de apego al modelo.',11),(56,5,' Propone adecuaciones a los estándares y  procedimientos para la documentación de información basado en las mejores prácticas de su especialidad.',12),(57,4,' Sugiere mejoras a los estándares y procedimientos para la documentación de información.',12),(58,3,' Genera los entregables, siguiendo adecuadamente los estándares y procedimientos para la documentación de información.',12),(59,2,' Genera los entregables siguiendo parcialente los estándares y procedimientos para la documentación de información.',12),(60,1,' No sigue los estándares y procedimientos para la documentación de información.',12),(61,5,' Promueve el uso, actualización y mejora de las metodologías de la compañía / Cliente.',13),(62,4,' Implementó al menos una de metología y realizó mejoras a otra ya existente en la compañía / Cliente.',13),(63,3,' Implementó al menos una metodología de trabajo en la compañía / Cliente.',13),(64,2,' Realizó mejoras a las metodologías existentes en la compañía.',13),(65,1,' No se aseguró de la correcta utilización de las metodologías a su cargo.',13),(66,5,' El cliente solicita expresamente la asignación del colaborador a uno de sus proyectos.',14),(67,4,' El cliente reconocer públicamente el desempeño del colaborador como clave para el éxito de proyecto.',14),(68,3,' El cliente expresa que el nivel de contribución del colaborador es relevante para el proyecto.',14),(69,2,' El cliente ha dado sugerencias de mejora en relación al desempeño del colaborador pero no considera que su permamencia comprometa el éxito del proyecto.',14),(70,1,' El cliente ha expesado inconformidad en reiteradas ocasiones en relación a su desempeño por lo que ha solicitado el reemplazo del colaborador.',14),(71,5,' Genera una propuesta de cómo integrar los hallazgos a un proyecto nuevo o un control de cambios al proyecto actual.',15),(72,4,' Analiza la viabilidad de los hallazgos identificados.',15),(73,3,' Documenta por escrito los hallazgos que pudieran desencadenar en una oportunidad de negocio.',15),(74,2,' Comenta de manera verbal los hallazgos que pudieran desencadenar en una oportunidad de negocio.',15),(75,1,' Confunde dudas del cliente sobre del proyecto como posibles oportunidades de negocio.',15),(76,5,' Genera negocio en más de una ocasión con más de un cliente en conjunto con el área Comercial.',16),(77,4,' Genera al menos un nuevo negocio con un cliente a través de una venta realizada en conjunto con el área Comercial.',16),(78,3,' Presenta al menos una propuesta de nueva oportunidad de negocio con cliente involucrando al área Comercial.',16),(79,2,' Propone al menos una propuesta de nueva oportunidad de negocio internamnete e involucra al área Comercial para su evaluación y prospección',16),(80,1,' Identifica al menos tres oportunidades nuevas de negocio e involucra al área Comercial para su evaluación.',16),(81,5,' Genera un valor agregado al lograr al menos dos soluciones completamente empaquetadas  y funcionales comercialmente.',17),(82,4,' Conforma un equipo de trabajo para la mejora o diseño del empaquetamieno tuna solución.',17),(83,3,' Logra el empaquetamiento completo de al menos una solución ',17),(84,2,' Buscó la participación en el empaquetamiento de soluciones adicionales.',17),(85,1,' Se involucra únicamente cuando se le asignaron soluciones a empquetar',17),(86,5,' Habilitación de las soluciones que se acuerden y otras soluciones propuestas por el propio equipo de Innovación.',18),(87,4,' Habilitación de las soluciones que se acuerden antes de tiempo, en forma y con un presupuesto menor.',18),(88,3,' Habilitación de las soluciones que se acuerden en tiempo, forma y bajo presupuesto.',18),(89,2,' 0Habilitación de las soluciones que se acuerden, con retrasos, con problemas y excediendo el presupuesto.',18),(90,1,' No habilitación de las soluciones acordadas.',18),(91,5,' Que se generen soluciones, prácticas de gestión, nuevas iniciativas e innovación a través del uso de los sites.',19),(92,4,' Que el 100% de los proyectos, iniciativas tengan sus sites, se usen y estén actualizados.',19),(93,3,' Carga el 100% de las iniciativas a su cargo.',19),(94,2,' Carga parcialmente las iniciativas del área.',19),(95,1,' No carga las iniciativas de su área.',19),(96,5,' Logra que al menos dos personas a su cargo adquieran un diploma académico acorde a su área de expertise.',20),(97,4,' Genera estrategias formales de tutoría y mentoría con su equipo de trabajo, capacita a su gente personalmente, promueve el capitalizar el conocimiento y experiencias de proyectos anteriores',20),(98,3,' Auto desarrolla material, provee información adicional para su equipo de trabajo, así como por medio de delegación de mayor responsabilidad.',20),(99,2,' Comparte documentación de experiencias anteriores, asi como material  relevante para el aprendizaje adicional de su equipo de trabajo.',20),(100,1,' Se limita a seguir las iniciativas y Políticas de Desarrollo de Talento.',20),(101,5,' Sin errores y acorde a las mejores prácticas.',21),(102,4,' Sin errores.',21),(103,3,' Menos del 14% de errores en sus entregas.',21),(104,2,' Entre el 15% y 35% de erres en sus entregas.',21),(105,1,' Más de 66% de errores en sus entregas.',21),(106,5,' Sin errores y acorde a las mejores prácticas.',22),(107,4,' Sin errores.',22),(108,3,' Menos del 14% de errores en sus entregas.',22),(109,2,' Entre el 15% y 35% de erres en sus entregas.',22),(110,1,' Más de 66% de errores en sus entregas.',22),(111,5,' Herramienta implementada con seguimiento automatizado de incidencias - visibilidad del estatus de incidencias para toma de decisión, notificación a usuarios y generación automatizada de informes de desempeño de Soporte Aplicativo.',23),(112,4,' Herramienta implementada con seguimiento automatizado de incidencias - visibilidad del estatus de incidencias para toma de decisión, notificación a usuarios y generación manual de informes de desempeño de Soporte Aplicativo.',23),(113,3,' Herramienta implementada con seguimiento automatizado de incidencias - visibilidad del estatus de incidencias para toma de decisión y notificación a usuarios.',23),(114,2,' Herramienta implementada sin seguimiento autoamtizado de incidencias - no visibilidad del estatus de incidencias para toma de decisiones y notificación a usuarios',23),(115,1,' Herramienta no implementada - Únicamente análisis de viabilidad sin implementación.',23),(116,5,' El Cliente acepta ser y proveer referencia para futuros prospectos y clientes de la empresa.',24),(117,4,' El Cliente firma de confirmidad el Acuerdo de Nivel de Servicio expresando que sus expectativas fueron superadas por el sevicio recibido.',24),(118,3,' El cliente firma de conformidad el Acuerdo de Nivel de Servicio.',24),(119,2,' El Cliente manifiesta inconrmidad con el servicio recibido vs el Acuerdo de Nivel de Servico definido.',24),(120,1,' No se presenta Acuerdo de Nivel de Servicio al cliente.',24),(121,5,' Cumple con el 100% de los casos que son asignados en un tiempo 50% menor al límite, provee soluciones de fondo a los problemas repetitivos y diagnostica de forma rápida problemas complejos.',25),(122,4,' Cumple con el 100% de los casos que son asignados en un tiempo 20% menor al límite, provee soluciones de fondo a los problemas repetitivos y diagnostica de forma rápida problemas complejos.',25),(123,3,' Cumple con el 100% de los casos que son asignados y provee soluciones de fondo a los problemas repetitivos.',25),(124,2,' Cumple con al menos del 80% de los casos que le son asignados',25),(125,1,' Cumple con menos del 50% de los casos que le son asignados.',25),(126,5,'s reactivos serán los siguientes:',26),(127,4,' El consultor muestra una actitud de servicio y busca proactivamente la forma de resolver el problema o requerimiento de soporte.',26),(128,3,' El consultor es sensible a la prioridad de los casos y responde con el objetivo de minimizar el impacto en el negocio.',26),(129,2,' El consultor presenta disponibilidad según los horarios y tiempos de respuesta definidos en el Acuerdo de Nivel de Servicio.',26),(130,1,' El consultor demuestra su capacidad técnica en su área de especialidad de SAP.',26),(131,5,' Mejora los resultados de los Indicadores de Servico mes tras mes.',27),(132,4,' Establece una relación de desempeño entre los indicadores y los colabores del área.',27),(133,3,' Genera un reporte mensual con los Indicadores de Servicio.',27),(134,2,' Define indicadores para medir el servicio brindado.',27),(135,1,' Se trabaja sin indicaores de servicio.',27),(136,5,' Presenta la documentación ante el cliente en tiempo y forma y los mismos son aceptados en la primer entrega.',28),(137,4,' Presenta la documentación ante el cliente en tiempo y forma y los mismos son aceptados en la segunda entrega.',28),(138,3,' Presenta la documentación ante el cliente en tiempo y forma y los mismos son aceptados en la tercer entrega.',28),(139,2,' Presenta la documentación ante el cliente fuera de tiempo y los mismos son aceptados después de la tercer entrega.',28),(140,1,' No presenta la documentación en tiempo y forma lo que deriva en que no sean aceptados y no se pueda avanzar con el proceso comercial de licitación.',28),(141,5,' Presenta la documentación de la licitación en tiempo y forma y obtiene un puntaje de al menos el 90% de la propuesta Técnica en todas las licitaciones',29),(142,4,' Presenta la documentación de la licitación en tiempo y forma y obtiene un puntaje de al menos el 85% de la propuesta Técnica en todas las licitaciones',29),(143,3,' Presenta la documentación de la licitación en tiempo y forma y obtiene un puntaje de al menos el 80% de la propuesta Técnica en todas las licitaciones',29),(144,2,' No presenta la documentación de la licitación en tiempo y forma o se obtiene un puntaje menor al 75% en al menos 1 oportunidad',29),(145,1,' No presenta la documentación de la licitación en tiempo y forma o se obtiene un puntaje menor al 75% en al menos 3 oportunidades',29),(146,5,' Propone mejores prácticas de gestión comercial y al menos implementa 3 cambios en la herramienta para el Seguimiento al Forecast, Road to Close (RTC) o Road to Start (RTS). Mantiene actualizado el Forecast y participa activamente en su presentación con Socios y la Dirección de Sector Público.',30),(147,4,' Propone mejores prácticas de gestión comercial y al menos implementa 1 cambio en la herramienta para el Seguimiento al Forecast, Road to Close (RTC) o Road to Start (RTS). Mantiene actualizado el Forecast y participa activamente en su presentación con Socios y la Dirección de Sector Público.',30),(148,3,' Implementa las mejoras propuestas por la Dirección Comercial adecuadamente en las herramientas de Seguimiento al Forecast, Road to Close (RTC) o Road to Start (RTS). Mantiene actualizado el Forecast y es un soporte eficaz en la presentación con Socios.',30),(149,2,' Mantiene actualizado el Forecast ante los comentarios de la Dirección Comercial y es un soporte eficaz en la presentación con Socios.',30),(150,1,' El Forecast no se mantiene actualizado, complicando el Seguimiento Comercial de Sector Público.',30),(151,5,' Logra implementar el mecanismo para la Detección de nuevas oportunidades, generando al menos 12 nuevos deals en el Forecast',31),(152,4,' Logra implementar el mecanismo para la Detección de nuevas oportunidades, generando al menos 8 nuevos deals en el Forecast ',31),(153,3,' Logra implementar mecanismos para la detección de nuevas oportunidades, generando al menos 4 nuevos deals en el Forecast ',31),(154,2,' Logra implementar al menos 1 mecanismo (Compranet o base de contactos del Sector Público) para la detección de nuevas oportunidades pero no logra instrumentar nuevos deals.',31),(155,1,' No logra implementar ningún mecanismo para la detección de nuevas oportunidades.',31),(156,5,' Implementa mejoras en el material relacionado con las Presentaciones Comerciales de Sector Público, propuestas técnicas y económicas y participa en forma independiente en al menos 3 reuniones con prospectos.',32),(157,4,' Utiliza correctamente las Presentaciones Comerciales de Sector Público y participa activamente en las reuniones con clientes.',32),(158,3,' Utiliza correctamente las Presentaciones Comerciales de Sector Público, complementa a la Dirección Comercial en la elaboración de Propuestas Técnicas y Económicas ',32),(159,2,' Utiliza correctamente las Presentaciones Comerciales de Sector Público.',32),(160,1,' No utiliza correctamente las Presentaciones Comerciales de Sector Público.',32),(161,5,' Se presentaron los resultados en los primeros 5 días del mes.',33),(162,4,' Se presentaron los resultados de los proyectos dentro de los 8 primeros días del mes.',33),(163,3,' Se presentaron los resultados de los proyectos en tiempo y sin errores.',33),(164,2,' Se presentaron los resultados con errores y fuera de tiempo.',33),(165,1,' No se presentaron los resultados.',33),(166,5,' Se identifican las riesgos y se definen acciones efectivas para evitarlos.',34),(167,4,' Se identifican los riesgos y las acciones definidas son efectivas para evitarlos y mitigarlos.',34),(168,3,' Se identifican la mayoría de los riesgos y las acciones definidas permiten evitarlos o mitigar su impacto.',34),(169,2,' Algunos riesgos afectan al control información y reportes sin impactar las fechas comprometidas.',34),(170,1,' Los riesgos aparecen sin ser previamente identificados y atendidos, ocasionando atrasos en la información y reportes o afectaciones en el control.',34),(171,5,' Se informó y retroalimentó a los directores y usuarios los resultados del seguimiento de horas reportadas en Harvest.',35),(172,4,' Se informó y retroalimentó a los directores los resultados del seguimiento de horas reportadas en Harvest.',35),(173,3,' Se reportó a los directores el seguimiento puntual de las horas en Harvest.',35),(174,2,' Se dio seguimiento parcial a las horas reportadas en Harvest.',35),(175,1,' No se dio seguimiento a las horas reportadas en Harvest.',35),(176,5,'  Se registraron los costos en el sistema asegurándose de los cargos para control de proyectos y generó un análisis acompañado de propuestas de mejora para la reducción de costos.',36),(177,4,' Se registraron los costos en el sistema asegurándose de la correcta asignación de cargos para control de proyectos y generó un análisis de los conceptos que afectan más los proyectos.',36),(178,3,' Se registraron los costos en el sistema asegurándose de la correcta asignación de cargos para control de proyectos.',36),(179,2,' Se registraron los costos en el sistema sin asegurarse que cargos para control de proyectos están bien asignados.',36),(180,1,' No se realizó el registro de costos en sistema.',36),(181,5,' Se elaboraron/actualizaron políticas, se dio seguimiento a cada una de ellas, establece estrategias que faciliten su adopción y mantiene actualizadas según la operación del área.',37),(182,4,' Se elaboraron/actualizaron políticas, se dio seguimiento a cada una de ellas y establece estrategias que faciliten su adopción.',37),(183,3,' Se elaboraron/actualizaron políticas y se dio seguimiento a cada una de ellas.',37),(184,2,' Se elaboraron/actualizaron políticas pero no se les dio seguimiento.',37),(185,1,' No se elaboraron ni actualizaron las políticas.',37),(186,5,' Se liberó el 100% de las fianzas sin dejar temas ni documentación pendientes y se negociaron mejores condiciones con la afianzadora.',38),(187,4,' Se liberó el 100% de las fianzas sin dejar temas ni documentación pendientes.',38),(188,3,' Se liberó el 100% de las fianzas.',38),(189,2,' Se liberó al menos el 75% de las fianzas.',38),(190,1,' Se liberó al menos el 50% de las fianzas.',38),(191,5,' Se automatizó el proceso de reportes en un sistema y con un formato de tablero de control para la Dirección General',39),(192,4,' El reporte tiene funcionalidad de tablero de control',39),(193,3,' Se estandarizó el reporte a la dirección General',39),(194,2,' Los reportes fueron esporádicos y sin estructura',39),(195,1,' No se realizaron reportes a la Dirección General',39),(196,5,' Se asegura que los involucrados conozcan el procedimiento para control de propuestas y contratos.',40),(197,4,' Se controlan las propuestas y los contratos a través del procedimiento establecido.',40),(198,3,' Establece un procedimiento para control de propuestas y contratos.',40),(199,2,' Se presentaron ideas generales para el control de presentaciones y contratos.',40),(200,1,' No se presentaron opciones para el control de presentaciones y contratos.',40),(201,5,' Logra que la cobranza se realice previo a las fechas establecidas.',41),(202,4,' La cobranza se encuentra bajo los acuerdos establecidos y establece mejores prácticas para propiciar los pagos adelantados.',41),(203,3,' La cobranza se encuentra bajo los acuerdos establecidos.',41),(204,2,' La cobranza presenta 15 días de rezago.',41),(205,1,' La cobranza presenta un mes de rezago.',41),(206,5,' Que se generen soluciones, prácticas de gestión, nuevas iniciativas e innovación a través del uso de los sites.',42),(207,4,' Que el 100% de los proyectos, iniciativas tengan sus sites, se usen y estén actualizados.',42),(208,3,' Promover el uso de los SItes de Advanzer a través de comunicar presentaciones, guías, capacitaciones, manuales, que se establezca una práctica de uso y gestión.',42),(209,2,' Que los sites solo se usen por quienes saben de ellos y no se use por la compañía como herramienta de colaboración y compartir conocimiento.',42),(210,1,' Que existan iniciativas que no tengan su site donde se guarde la información.',42),(211,5,' Se registran correctamente los movimientos bancarios y se hace un reporte analítico con propuestas de mejoras a l manejo de las cuentas.',43),(212,4,' Se registran los movimientos y saldos bancarios y se elabora un reporte a ls dirección d de finanzas.',43),(213,3,' Se registran los movimientos y saldos bancarios correctamente.',43),(214,2,' Se registran los movimientos y saldos bancarios con errores.',43),(215,1,' No se registran los movimientos y saldos bancarios.',43),(216,5,'s reactivos serán los siguientes:',44),(217,4,' El área muestra una actitud de servicio y busca proactivamente la forma de resolver el problema.',44),(218,3,' El área es sensible a la prioridad de los casos y responde con el objetivo de minimizar el impacto en el negocio.',44),(219,2,' El área presenta disponibilidad según los horarios y tiempos de respuesta definidos.',44),(220,1,' El área demuestra su capacidad técnica en su área de especialidad.',44),(221,5,' Se presentó el reporte de flujos de efectivo en tiempo y sin errores dentro de los 3 primeros días del mes',45),(222,4,'  Se presentó el reporte de flujos de efectivo en tiempo y sin errores dentro de los 5 primeros días del mes',45),(223,3,'  Se presentó el reporte de flujos de efectivo en tiempo y sin errores',45),(224,2,' Se presentó el reporte de flujos de efectivo con errores y fuera de tiempo.',45),(225,1,' No se preparan reportes de flujos de efectivo',45),(226,5,' Se controlan los recursos financieros de la empresa y se aseguran los flujos positivos tomando ventaja de las condiciones de mercado invirtiendo en instrumentos con ventajas para la empresa.',46),(227,4,' Se controlan los recursos de la empresa aprovechando ventajas en el mercado consiguiendo mejores instrumentos de inversión.',46),(228,3,' Se controlan los recursos de la empresa con eficiencia y se invierten los excedentes.',46),(229,2,' Se controlan los recursos financieros con algunas deficiencias y se invierte eventualmente.',46),(230,1,' No se controlan los recursos financieros de la empresa y no ae invierte oportunamente.',46),(231,5,' Se controlaron los gastos de viaje y se detectaron áreas de mejora que repercutieron en la reducción de costos .',47),(232,4,' Se controlaron los gastos de viaje y se establecieron mejoras',47),(233,3,' Se controlaron los gastos de viaje',47),(234,2,' Se controlaron los gastos de viaje con errores',47),(235,1,' No se controlan los gastos de viaje',47),(236,5,'  Registra correctamente las cuentas por pagar a los proveedores, e informa del estatus de los pagos a los usuarios internos y externos y logra negociar condiciones favorables para la empresa con los proveedores.',48),(237,4,' Registra los pagos a los proveedores, correctamente y se asegura de que los usuarios internos y externos estén enterados del status de los pagos a proveedores.',48),(238,3,' Registra correctamente las cuentas or pagar a los proveedores y se asegura de pagar correctamente.',48),(239,2,' Registra los proveedores y se presentan eventuales errores',48),(240,1,' Tiene errores en el registro de proveedores',48),(241,5,'  Se reciben las solicitudes y se da seguimiento a los viáticos en tiempo y forma asegurando que los usuarios se apeguen a la política estableciendo acciones para evitar retrabajos.',49),(242,4,' Se reciben las solicitudes y se da seguimiento a los viáticos en tiempo y forma asegurando que los usuarios se apeguen a la política',49),(243,3,' Se reciben las solicitudes y se da seguimiento a los viáticos en tiempo y forma.',49),(244,2,' Se registran las solicitudes de gastos de viaje con errores y no se da seguimiento.',49),(245,1,' No realiza acciones sobre las solicitudes de gastos de viajes.',49),(246,5,' Se presentaron los Estados financieros y flujos  en los primeros 3 días del mes',50),(247,4,' Se presentaron los Estados financieros y flujos  dentro de los 5 primeros días del mes',50),(248,3,' Se presentaron los Estados financieros y flujos en tiempo y sin errores',50),(249,2,' Se presentaron los Estados financieros y flujos con errores y fuera de tiempo.',50),(250,1,' No se presentaron los Estados financieros.',50),(251,5,' Se cumplieron con las obligaciones patronales/fiscales que marca la ley en tiempo y correctamente y genera un reporte mensual acumulado generando una prospección para el resto del año.',51),(252,4,'  Se cumplieron con las obligaciones patronales/fiscales que marca la ley en tiempo y correctamente y genera un reporte mensual acumulado',51),(253,3,'  Se cumplieron con las obligaciones patronales/fiscales que marca la ley en tiempo y correctamente',51),(254,2,' Se cumplieron con las obligaciones patronales/fiscales que marca la ley pero con errores y/o fuera de tiempo.',51),(255,1,' No se cumplieron con las obligaciones patronales/fiscales que marca la ley',51),(256,5,' Se realizó el registro contable con una veracidad del 100% y generando un reporte de operaciones realizadas',52),(257,4,' Se realizó el registro contable con una veracidad del 100%',52),(258,3,' Se realizó el registro contable con una veracidad entre el 90% y el 95%',52),(259,2,' Se realizó registro contable con una veracidad entre el 85% y el 90%',52),(260,1,' No se realizó registro contable con una veracidad menor al 85%',52),(261,5,' Se automatizó el proceso de reporteo de Estados financieros y con su análisis permite la toma de decisiones a la Dirección General',53),(262,4,' Se entregaron los Estados financieros en tiempo y forma a la Dirección General y su análisis tienen estructura y buena presentación',53),(263,3,' Se entregaron los Estados financieros en tiempo y forma a la Dirección General',53),(264,2,' Los Estados financieros solo se entregaron esporádicamente',53),(265,1,' No se entregaron los Estados financieros a la Dirección General',53),(266,5,'Entrega 10 días antes de lo pactado.',54),(267,4,'Entrega 5 días antes de lo pactado.',54),(268,3,'Entrega el día pactado.',54),(269,2,'Entrega un día después de lo pactado.',54),(270,1,'Entrega dos o más días después de lo pactado.',54),(271,5,'Registra los issues y riesgos diariamente, actualiza el estatus de cada uno de ellos diariamente, y los clasifica en Puntos de Atención, Riesgos, Problemas diariamente, registra las acciones a seguir y asigna responsables para resolver el issue.',55),(272,4,'Registra los issues y riesgos semanalmente, actualiza el estatus de cada uno de ellos semanalmente, y los clasifica en Puntos de Atención, Riesgos, Problemas y registra las acciones a seguir y asigna responsables para resolver el issues semanalmente.',55),(273,3,'Registra los issues y riesgos, actualiza el estatus de cada uno de ellos, y los clasifica en Puntos de Atención, Riesgos, Problemas y registra las acciones a seguir y asigna responsables para resolver el issues.',55),(274,2,'Rara vez registra los issues y riesgos, rara vez actualiza el estatus de cada uno de ellos, rara vez los clasifica en Puntos de Atención, Riesgos, Problemas.',55),(275,1,'No registra los issues y riesgos, no actualiza el estatus de cada uno de ellos, y no los clasifica en Puntos de Atención, Riesgos, Problemas.',55),(276,5,'Mayor que 116%.',56),(277,4,'Entre 101% y 115%.',56),(278,3,'Entre 86% y 100%.',56),(279,2,'Entre 65% y 85%.',56),(280,1,'Menor que 66%.',56);
/*!40000 ALTER TABLE `Metricas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Objetivos`
--

DROP TABLE IF EXISTS `Objetivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Objetivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `dominio` int(11) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `estatus` int(1) DEFAULT '1',
  `tipo` varchar(45) DEFAULT 'ESPECÍFICA',
  PRIMARY KEY (`id`),
  KEY `fk_Objetivos_Dominios1_idx` (`dominio`),
  CONSTRAINT `fk_Objetivos_Dominios1` FOREIGN KEY (`dominio`) REFERENCES `Dominios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Objetivos`
--

LOCK TABLES `Objetivos` WRITE;
/*!40000 ALTER TABLE `Objetivos` DISABLE KEYS */;
INSERT INTO `Objetivos` VALUES (1,'Fechas de entrega',51,'Cumple con cualquier fecha de entrega pactada, medido como una comparación entre la fecha acordada y la fecha real de entrega.',1,'CORE'),(2,'Margen del proyecto',52,'Mantiene el costo total del proyecto dentro del margen definido en la propuesta, medido como la relación entre margen real sobre margen meta.',1,'ESPECÍFICA'),(3,'Control del presupesto',52,'Cumple con el presupuesto planeado de horas-costo registradas en el Gantt, medido como horas reales (costo real) entre horas planeadas (costo planeado).',1,'ESPECÍFICA'),(4,'Satisfacción del Cliente',53,'Percepción global de satisfacción por parte del cliente tomando como referencia la firma de la Carta de Aceptación.',1,'CORE'),(5,'Minimas fallas',53,'Ejecuta acciones acorde a los requerimientos pactados con su jefe inmediato.',1,'ESPECÍFICA'),(6,'Minimas fallas Planeación',53,'Realiza en tiempo y forma la planificación del proyecto.',1,'ESPECÍFICA'),(7,'Minimas fallas Diseño de la Solución',53,'Realiza en tiempo y forma las actividades de mapeo de estados financieros en apego a las definiciones de la Ley General de Contabilidad General (LGCG).',1,'ESPECÍFICA'),(8,'Minimas fallas Habilitación',53,'Desarrolla y/o complementa materialaes de capacitación con las definiciones del proceso de Armonización Contable realizadas en el proeycto.',1,'ESPECÍFICA'),(9,'Minimas fallas Capacitación',53,'Imparte en tiempo y forma la capacitación al usuario final obteniendo evaluaciones satisfactorias por parte de este.',1,'ESPECÍFICA'),(10,'Minimas fallas Soporte y Estabilización',53,'Resuelve en tiempo y forma las dudas de proceso reportadas por el usuario durante la etapa de estabilización proveyendo soporte al equipo interno y externo.',1,'ESPECÍFICA'),(11,'Adopción del modelo del PMI',53,'Gestiona y reporta el avance de los proyectos con apego a la metodología del PMI, medido con el porcentaje de proyectos con evidencia de apego.',1,'ESPECÍFICA'),(12,'Seguimiento de estándares de documentaión',54,'Utiliza correctamente los estándares y procedimientos definidos para la documentación de la información, medido como el cumplimiento de los procedimientos de documentación.',1,'ESPECÍFICA'),(13,'Uso y Desarrollo de Metodologías',54,'Utiliza y genera metodologías (definiciones, plantillas, presentaciones, etc.) que promueven el valor agregado de la compañía, medido como las metodologías utilizadas, generadas e implementadas dentro de la compañía y/o en los clientes.',1,'CORE'),(14,'Eficacia laboral',55,'Desarrolla sus actividades conforme a lo esperado, medido como la percepción global del cliente sobre su aportación al equipo del proyecto.',1,'ESPECÍFICA'),(15,'Búsqueda de oportunidades',56,'Identifica nuevas oportunidades de negocio para la empresa, medido con la forma en que se da seguimiento a las oportunidades.',1,'ESPECÍFICA'),(16,'Creación de negocio',56,'Concreta nuevas oportunidades de negocio para la empresa, medido como la cantidad de propuestas viables generadas.',1,'ESPECÍFICA'),(17,'Diseño de soluciones',56,'Participa en el empaquetamiento  de soluciones (servicios, sistemas, etc.), medido con las iniciativas en las que el está asigando o en aquellas en las que se involucra proactivamente.',1,'ESPECÍFICA'),(18,'Ventaja competitiva',56,'Desarrolla y mantiene la ventaja competitiva de la compañía medido como a través de la generación de soluciones y su mejora continua.',1,'ESPECÍFICA'),(19,'Socialización del conocimiento',57,'Cumple con la estrategia de Gestión del Conocimiento, medido como el porcentaje de las iniciativas anuales cargadas completamente.',1,'CORE'),(20,'Capitalización del conocimiento',57,'Propicia el crecimiento profesional y personal tanto propio como el de los colaboradores a su cargo generando capacidades, técnicas, administrativas y/o de liderazgo a través de capacitación formal, informal y capitalizando el conocimiento y experiencias en los procesos administrativos',1,'CORE'),(21,'Minimas fallas Construcción de la Solución',53,'Asegura el cumplimiento de la LGCG durante el proceso de implementación de sistemas de información con base en mapeos realizados.',1,'ESPECÍFICA'),(22,'Minimas fallas Conversión y Migración.',53,'Planifica y ejecuta en tiempo y forma actividades de migración y conversión de datos proveyendo apoyo, soporte  y guía al equipo de trabajo interno y externo.',1,'ESPECÍFICA'),(23,'Gestión de incidencias',53,'Implementa (en caso requerido) de alguna herramienta para la gestión de incidencias reportadas, medido con la puesta en marcha exitosa de la herramienta.',1,'ESPECÍFICA'),(24,'Acuerdo de Nivel de Servicio',53,'Define Acuerdo de Nivel de Servicio acorde a las necesidades del proyecto, medido con la firma del SLA por el cliente.',1,'ESPECÍFICA'),(25,'Monitoreo de Tickets',53,'Cumple con el procedimiento de Monitoreo de Tickets, medido con el porcentaje de cumplimiento según los casos que le son asignados.',1,'ESPECÍFICA'),(26,'Satisfacción del Cliente con el servicio de Soporte Aplicativo',53,'Percepción global de satisfacción por parte del cliente tomando como referencia una encuesta de 6 reactivos a por lo menos 3 usuarios finales por parte del cliente o clientes a los cuales se les brinda el servicio, medido como el promedio de las encuestas aplicadas.',1,'ESPECÍFICA'),(27,'Indicadores de Servicio',54,'Generación de reportes estándares de desempeño medido como la gneración y emisión de estos para la toma oportuna de decisiones.',1,'ESPECÍFICA'),(28,'Documentación previa al proceso de licitación',53,'Colabora con la elaboración y presentación de Documentación previa al proceso de Licitación.',1,'ESPECÍFICA'),(29,'Documentación durante el proceso de licitación',53,'Colabora con la elaboración y presentación de Documentos durante el proceso de Licitación.',1,'ESPECÍFICA'),(30,'Seguimiento Comercial en Sector Público',54,'Brinda adecuado seguimiento al Forecast, elaboración de Road to Close y Road to Start mediante la implementación de mejores prácticas de gestión comercial.',1,'ESPECÍFICA'),(31,'Prospección Comercial',56,'Genera nuevos deals a través de la creación e implementación de mecanismos para la detección de nuevas oportunidades de negocio.',1,'ESPECÍFICA'),(32,'Presentaciones Comerciales',57,'Utiliza correctamente las Presentaciones Comerciales de Sector Público y complementa a la Dirección Comercial en la elaboración de Propuestas Técnicas y Económicas.',1,'ESPECÍFICA'),(33,'Resultados de proyectos',51,'Reporta los resultados de los proyectos medido como la diferencia entre la fecha acordada para reportar resultados y la fecha real de reporte.',1,'ESPECÍFICA'),(34,'Mitigación de riesgos',53,'Identifica riesgos que puedan afectar el control e implementa acciones que permitan reducir su impacto, medido con el seguimiento de los issues de las actividades administrativas correspondientes.',1,'ESPECÍFICA'),(35,'Plan de Staffing',53,'Da seguimiento a las horas reportadas por los consultores en Harvest medido con el reporte de seguimiento a Directores.',1,'ESPECÍFICA'),(36,'Sistema de control',53,'Registra los costos de los proyectos en el sistema de control medido con la correcta asignación de los cargos.',1,'ESPECÍFICA'),(37,'Seguimiento a PPP',53,'Elabora/actualiza y da a conocer políticas, procesos y procedimientos de su área para institucionalizar a la organización, medido con el seguimiento a los issues de lo implementado.',1,'CORE'),(38,'Liberación de fianzas',54,'Logra la liberación de fianzas de los proyectos finalizados (plaza MTY) medido como el porcentaje de fianzas liberadas.',1,'ESPECÍFICA'),(39,'Reporte mensual de estatus de proyectos',54,'Establece un reporte mensual de estatus de proyectos para Dirección General medido con la implementación de un formato estándar',1,'ESPECÍFICA'),(40,'Control de propuestas y contratos',54,'Establece un procedimiento de control de propuestas y contratos medido con la autorización del procedimiento por parte del director de área.',1,'ESPECÍFICA'),(41,'Cobranza',56,'Ejecuta acciones para asegurar la cobranza, medido con la comparación entre la fecha de cobranza y la fecha previamente pactada con el cliente.',1,'ESPECÍFICA'),(42,'Gestión del conocimiento',57,'Establece la plataforma de Google Sites para compartir información, metodologías, empaquetamiento, etc., medido como el porcentaje de las iniciativas anuales cargadas completamente.',1,'CORE'),(43,'Registro de datos bancarios',53,'Registra diariamente la información de movimientos y saldos de bancos y la reporta correctamente',1,'ESPECÍFICA'),(44,'Satisfacción del Cliente Interno',53,'Percepción global de satisfacción por parte del cliente interno tomando como referencia una encuesta de 6 reactivos a por lo menos 3 clientes internos a los cuales se  les brinda el servicio, medido como el promedio de las encuestas aplicadas.',1,'CORE'),(45,'Flujo de efectivo',54,'Genera un reporte de flujo de efectivo medido con la confiabilidad de los datos presentados en él',1,'ESPECÍFICA'),(46,'Control de recursos',54,'Controla los recursos financieros de la empresa e invierte oportunamente los excedentes',1,'ESPECÍFICA'),(47,'Gastos de viaje',52,'Se controlan los gastos de viaje',1,'ESPECÍFICA'),(48,'Cuantas por pagar a proveedores',53,'Se asegura el correcto registro de las cuentas por pagar a proveedores aplicando las condiciones de pago',1,'ESPECÍFICA'),(49,'Viáticos',53,'Recibe, registra y da seguimiento a las solicitudes de viáticos de acuerdo a la política establecida para ellos',1,'ESPECÍFICA'),(50,'Reportes de estados financieros y flujos',51,'Reporta en tiempo los estados financieros y flujos medido como la diferencia entre la fecha acordada para reportar resultados y la fecha real de reporte.',1,'ESPECÍFICA'),(51,'Obligaciones fiscales y patronales',53,'Cumplir con las obligaciones patronales/fiscales medido en función del cumplimiento en los tiempos que marca la ley',1,'ESPECÍFICA'),(52,'Registro contable',53,'Realiza el registro de todas las operaciones contables de la compañía medido a través de la veracidad de la información capturada.',1,'ESPECÍFICA'),(53,'Estados financieros',54,'Establece el mecanismo de elaboración y entrega de los estados financieros para informar a la Dirección General medido con la oportunidad y veracidad de la información presentada.',1,'ESPECÍFICA'),(54,'Fechas de entrega',51,'Cumple con cualquier fecha de entrega pactada, medido como una comparación entre la fecha acordada y la fecha real de entrega.',1,'CORE'),(55,'Administración de Issues y Riesgos',52,'Gestiona acciones para solucionar diferentes situaciones del proyecto,  clasificádonlas como issues, riesgos o puntos de atención.',1,'ESPECÍFICA'),(56,'Margen del proyecto',52,'Mantiene el costo total del proyecto dentro del margen definido en la propuesta, medido como la relación entre margen real sobre margen meta.',1,'ESPECÍFICA');
/*!40000 ALTER TABLE `Objetivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Objetivos_Areas`
--

DROP TABLE IF EXISTS `Objetivos_Areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Objetivos_Areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area` int(11) NOT NULL COMMENT '	',
  `objetivo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_UNIQUE` (`area`,`objetivo`),
  KEY `fk_Objetivos_Areas_Areas1_idx` (`area`),
  KEY `fk_Objetivos_Areas_Objetivos1_idx` (`objetivo`),
  CONSTRAINT `fk_Objetivos_Areas_Areas1` FOREIGN KEY (`area`) REFERENCES `Areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objetivos_Areas_Objetivos1` FOREIGN KEY (`objetivo`) REFERENCES `Objetivos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Objetivos_Areas`
--

LOCK TABLES `Objetivos_Areas` WRITE;
/*!40000 ALTER TABLE `Objetivos_Areas` DISABLE KEYS */;
INSERT INTO `Objetivos_Areas` VALUES (181,7,20),(178,7,37),(179,7,38),(175,7,41),(180,7,42),(177,7,44),(173,7,47),(174,7,48),(176,7,49),(165,8,1),(172,8,20),(167,8,34),(171,8,42),(166,8,43),(168,8,44),(169,8,45),(170,8,46),(190,9,20),(183,9,34),(186,9,37),(189,9,42),(184,9,44),(182,9,50),(185,9,51),(187,9,52),(188,9,53),(164,10,20),(154,10,33),(155,10,34),(156,10,35),(157,10,36),(158,10,37),(159,10,38),(160,10,39),(161,10,40),(162,10,41),(163,10,42),(21,11,1),(22,11,2),(23,11,3),(24,11,4),(25,11,5),(26,11,6),(27,11,7),(30,11,8),(31,11,9),(32,11,10),(33,11,11),(34,11,12),(35,11,13),(36,11,14),(37,11,15),(38,11,16),(39,11,17),(40,11,18),(41,11,19),(42,11,20),(28,11,21),(29,11,22),(109,12,1),(110,12,2),(111,12,3),(112,12,4),(113,12,5),(114,12,6),(115,12,7),(117,12,8),(118,12,9),(119,12,10),(120,12,11),(121,12,12),(122,12,13),(123,12,14),(124,12,15),(125,12,16),(126,12,17),(127,12,18),(128,12,19),(129,12,20),(116,12,21),(1,13,1),(2,13,2),(3,13,3),(4,13,4),(5,13,5),(6,13,6),(7,13,7),(8,13,8),(9,13,9),(10,13,10),(11,13,11),(12,13,12),(13,13,13),(14,13,14),(15,13,15),(16,13,16),(17,13,17),(18,13,18),(19,13,19),(20,13,20),(43,14,1),(44,14,2),(45,14,3),(46,14,4),(47,14,5),(48,14,6),(49,14,7),(52,14,8),(53,14,9),(54,14,10),(55,14,11),(56,14,12),(57,14,13),(58,14,14),(59,14,15),(60,14,16),(61,14,17),(62,14,18),(63,14,19),(64,14,20),(50,14,21),(51,14,22),(130,15,1),(131,15,2),(132,15,3),(138,15,12),(139,15,13),(140,15,17),(141,15,18),(142,15,19),(143,15,20),(133,15,23),(134,15,24),(135,15,25),(136,15,26),(137,15,27),(87,16,1),(88,16,2),(89,16,3),(90,16,4),(91,16,5),(92,16,6),(93,16,7),(96,16,8),(97,16,9),(98,16,10),(99,16,11),(100,16,12),(101,16,13),(102,16,14),(103,16,15),(104,16,16),(105,16,17),(106,16,18),(107,16,19),(108,16,20),(94,16,21),(95,16,22),(65,17,1),(66,17,2),(67,17,3),(68,17,4),(69,17,5),(70,17,6),(71,17,7),(74,17,8),(75,17,9),(76,17,10),(77,17,11),(78,17,12),(79,17,13),(80,17,14),(81,17,15),(82,17,16),(83,17,17),(84,17,18),(85,17,19),(86,17,20),(72,17,21),(73,17,22),(144,18,1),(147,18,12),(148,18,13),(151,18,19),(152,18,20),(145,18,28),(146,18,29),(149,18,30),(150,18,31),(153,18,32),(191,20,54),(192,20,55),(193,20,56);
/*!40000 ALTER TABLE `Objetivos_Areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Porcentajes_Objetivos`
--

DROP TABLE IF EXISTS `Porcentajes_Objetivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Porcentajes_Objetivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` int(3) DEFAULT '0',
  `nivel_posicion` int(11) DEFAULT NULL,
  `objetivo_area` int(11) NOT NULL,
  PRIMARY KEY (`id`,`objetivo_area`),
  UNIQUE KEY `area_UNIQUE` (`nivel_posicion`,`objetivo_area`),
  KEY `fk_Porcentajes_Objetivos_Objetivos_Areas1_idx` (`objetivo_area`),
  CONSTRAINT `fk_Porcentajes_Objetivos_Objetivos_Areas1` FOREIGN KEY (`objetivo_area`) REFERENCES `Objetivos_Areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1152 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Porcentajes_Objetivos`
--

LOCK TABLES `Porcentajes_Objetivos` WRITE;
/*!40000 ALTER TABLE `Porcentajes_Objetivos` DISABLE KEYS */;
INSERT INTO `Porcentajes_Objetivos` VALUES (1,10,8,1),(2,10,7,1),(3,10,6,1),(4,5,5,1),(5,5,4,1),(6,5,3,1),(7,5,8,2),(8,5,7,2),(9,5,6,2),(10,5,5,2),(11,10,4,2),(12,10,3,2),(13,10,8,3),(14,10,7,3),(15,10,6,3),(16,10,5,3),(17,10,4,3),(18,10,3,3),(19,10,8,4),(20,10,7,4),(21,10,6,4),(22,10,5,4),(23,10,4,4),(24,10,3,4),(25,10,8,5),(26,10,7,5),(27,3,6,5),(28,3,5,5),(29,3,4,5),(30,3,3,5),(31,0,8,6),(32,0,7,6),(33,3,6,6),(34,4,5,6),(35,4,4,6),(36,5,3,6),(37,5,8,7),(38,5,7,7),(39,4,6,7),(40,4,5,7),(41,2,4,7),(42,2,3,7),(43,5,8,8),(44,5,7,8),(45,5,6,8),(46,5,5,8),(47,2,4,8),(48,2,3,8),(49,5,8,9),(50,5,7,9),(51,5,6,9),(52,5,5,9),(53,1,4,9),(54,0,3,9),(55,5,8,10),(56,5,7,10),(57,5,6,10),(58,5,5,10),(59,2,4,10),(60,1,3,10),(61,5,8,11),(62,5,7,11),(63,5,6,11),(64,5,5,11),(65,5,4,11),(66,5,3,11),(67,5,8,12),(68,5,7,12),(69,5,6,12),(70,5,5,12),(71,5,4,12),(72,3,3,12),(73,5,8,13),(74,5,7,13),(75,5,6,13),(76,5,5,13),(77,5,4,13),(78,3,3,13),(79,0,8,14),(80,0,7,14),(81,5,6,14),(82,5,5,14),(83,5,4,14),(84,5,3,14),(85,0,8,15),(86,0,7,15),(87,5,6,15),(88,5,5,15),(89,5,4,15),(90,10,3,15),(91,0,8,16),(92,0,7,16),(93,5,6,16),(94,5,5,16),(95,10,4,16),(96,10,3,16),(97,0,8,17),(98,0,7,17),(99,0,6,17),(100,5,5,17),(101,5,4,17),(102,5,3,17),(103,0,8,18),(104,0,7,18),(105,0,6,18),(106,3,5,18),(107,5,4,18),(108,5,3,18),(109,10,8,19),(110,10,7,19),(111,5,6,19),(112,3,5,19),(113,3,4,19),(114,3,3,19),(115,10,8,20),(116,10,7,20),(117,5,6,20),(118,3,5,20),(119,3,4,20),(120,3,3,20),(121,10,8,21),(122,10,7,21),(123,10,6,21),(124,5,5,21),(125,5,4,21),(126,5,3,21),(127,5,8,22),(128,5,7,22),(129,5,6,22),(130,5,5,22),(131,10,4,22),(132,10,3,22),(133,10,8,23),(134,10,7,23),(135,10,6,23),(136,10,5,23),(137,10,4,23),(138,10,3,23),(139,10,8,24),(140,10,7,24),(141,10,6,24),(142,10,5,24),(143,10,4,24),(144,10,3,24),(145,10,8,25),(146,10,7,25),(147,3,6,25),(148,3,5,25),(149,3,4,25),(150,3,3,25),(151,0,8,26),(152,0,7,26),(153,3,6,26),(154,4,5,26),(155,4,4,26),(156,5,3,26),(157,5,8,27),(158,5,7,27),(159,4,6,27),(160,4,5,27),(161,4,4,27),(162,1,3,27),(163,5,8,28),(164,5,7,28),(165,3,6,28),(166,3,5,28),(167,3,4,28),(168,1,3,28),(169,5,8,29),(170,5,7,29),(171,3,6,29),(172,3,5,29),(173,1,4,29),(174,1,3,29),(175,5,8,30),(176,5,7,30),(177,3,6,30),(178,3,5,30),(179,1,4,30),(180,1,3,30),(181,5,8,31),(182,5,7,31),(183,3,6,31),(184,3,5,31),(185,1,4,31),(186,0,3,31),(187,5,8,32),(188,5,7,32),(189,3,6,32),(190,3,5,32),(191,2,4,32),(192,1,3,32),(193,5,8,33),(194,5,7,33),(195,5,6,33),(196,5,5,33),(197,5,4,33),(198,5,3,33),(199,5,8,34),(200,5,7,34),(201,5,6,34),(202,5,5,34),(203,5,4,34),(204,3,3,34),(205,5,8,35),(206,5,7,35),(207,5,6,35),(208,5,5,35),(209,5,4,35),(210,3,3,35),(211,0,8,36),(212,0,7,36),(213,5,6,36),(214,5,5,36),(215,5,4,36),(216,5,3,36),(217,0,8,37),(218,0,7,37),(219,5,6,37),(220,5,5,37),(221,5,4,37),(222,10,3,37),(223,0,8,38),(224,0,7,38),(225,5,6,38),(226,5,5,38),(227,5,4,38),(228,10,3,38),(229,0,8,39),(230,0,7,39),(231,0,6,39),(232,5,5,39),(233,5,4,39),(234,5,3,39),(235,0,8,40),(236,0,7,40),(237,0,6,40),(238,3,5,40),(239,5,4,40),(240,5,3,40),(241,5,8,41),(242,5,7,41),(243,5,6,41),(244,3,5,41),(245,3,4,41),(246,3,3,41),(247,5,8,42),(248,5,7,42),(249,5,6,42),(250,3,5,42),(251,3,4,42),(252,3,3,42),(253,10,8,43),(254,10,7,43),(255,10,6,43),(256,5,5,43),(257,5,4,43),(258,5,3,43),(259,5,8,44),(260,5,7,44),(261,5,6,44),(262,5,5,44),(263,10,4,44),(264,10,3,44),(265,10,8,45),(266,10,7,45),(267,10,6,45),(268,10,5,45),(269,10,4,45),(270,10,3,45),(271,10,8,46),(272,10,7,46),(273,10,6,46),(274,10,5,46),(275,10,4,46),(276,10,3,46),(277,10,8,47),(278,10,7,47),(279,3,6,47),(280,3,5,47),(281,3,4,47),(282,3,3,47),(283,0,8,48),(284,0,7,48),(285,3,6,48),(286,4,5,48),(287,4,4,48),(288,5,3,48),(289,5,8,49),(290,5,7,49),(291,4,6,49),(292,4,5,49),(293,4,4,49),(294,1,3,49),(295,5,8,50),(296,5,7,50),(297,3,6,50),(298,3,5,50),(299,3,4,50),(300,1,3,50),(301,5,8,51),(302,5,7,51),(303,3,6,51),(304,3,5,51),(305,1,4,51),(306,1,3,51),(307,5,8,52),(308,5,7,52),(309,3,6,52),(310,3,5,52),(311,1,4,52),(312,1,3,52),(313,5,8,53),(314,5,7,53),(315,3,6,53),(316,3,5,53),(317,1,4,53),(318,0,3,53),(319,5,8,54),(320,5,7,54),(321,3,6,54),(322,3,5,54),(323,2,4,54),(324,1,3,54),(325,5,8,55),(326,5,7,55),(327,5,6,55),(328,5,5,55),(329,5,4,55),(330,5,3,55),(331,5,8,56),(332,5,7,56),(333,5,6,56),(334,5,5,56),(335,5,4,56),(336,3,3,56),(337,5,8,57),(338,5,7,57),(339,5,6,57),(340,5,5,57),(341,5,4,57),(342,3,3,57),(343,0,8,58),(344,0,7,58),(345,5,6,58),(346,5,5,58),(347,5,4,58),(348,5,3,58),(349,0,8,59),(350,0,7,59),(351,5,6,59),(352,5,5,59),(353,5,4,59),(354,10,3,59),(355,0,8,60),(356,0,7,60),(357,5,6,60),(358,5,5,60),(359,5,4,60),(360,10,3,60),(361,0,8,61),(362,0,7,61),(363,0,6,61),(364,5,5,61),(365,5,4,61),(366,5,3,61),(367,0,8,62),(368,0,7,62),(369,0,6,62),(370,3,5,62),(371,5,4,62),(372,5,3,62),(373,5,8,63),(374,5,7,63),(375,5,6,63),(376,3,5,63),(377,3,4,63),(378,3,3,63),(379,5,8,64),(380,5,7,64),(381,5,6,64),(382,3,5,64),(383,3,4,64),(384,3,3,64),(385,10,8,65),(386,10,7,65),(387,10,6,65),(388,5,5,65),(389,5,4,65),(390,5,3,65),(391,5,8,66),(392,5,7,66),(393,5,6,66),(394,5,5,66),(395,10,4,66),(396,10,3,66),(397,10,8,67),(398,10,7,67),(399,10,6,67),(400,10,5,67),(401,10,4,67),(402,10,3,67),(403,10,8,68),(404,10,7,68),(405,10,6,68),(406,10,5,68),(407,10,4,68),(408,10,3,68),(409,10,8,69),(410,10,7,69),(411,3,6,69),(412,3,5,69),(413,3,4,69),(414,3,3,69),(415,0,8,70),(416,0,7,70),(417,3,6,70),(418,4,5,70),(419,4,4,70),(420,5,3,70),(421,5,8,71),(422,5,7,71),(423,4,6,71),(424,4,5,71),(425,4,4,71),(426,1,3,71),(427,5,8,72),(428,5,7,72),(429,3,6,72),(430,3,5,72),(431,3,4,72),(432,1,3,72),(433,5,8,73),(434,5,7,73),(435,3,6,73),(436,3,5,73),(437,1,4,73),(438,1,3,73),(439,5,8,74),(440,5,7,74),(441,3,6,74),(442,3,5,74),(443,1,4,74),(444,1,3,74),(445,5,8,75),(446,5,7,75),(447,3,6,75),(448,3,5,75),(449,1,4,75),(450,0,3,75),(451,5,8,76),(452,5,7,76),(453,3,6,76),(454,3,5,76),(455,2,4,76),(456,1,3,76),(457,5,8,77),(458,5,7,77),(459,5,6,77),(460,5,5,77),(461,5,4,77),(462,5,3,77),(463,5,8,78),(464,5,7,78),(465,5,6,78),(466,5,5,78),(467,5,4,78),(468,3,3,78),(469,5,8,79),(470,5,7,79),(471,5,6,79),(472,5,5,79),(473,5,4,79),(474,3,3,79),(475,0,8,80),(476,0,7,80),(477,5,6,80),(478,5,5,80),(479,5,4,80),(480,5,3,80),(481,0,8,81),(482,0,7,81),(483,5,6,81),(484,5,5,81),(485,5,4,81),(486,10,3,81),(487,0,8,82),(488,0,7,82),(489,5,6,82),(490,5,5,82),(491,5,4,82),(492,10,3,82),(493,0,8,83),(494,0,7,83),(495,0,6,83),(496,5,5,83),(497,5,4,83),(498,5,3,83),(499,0,8,84),(500,0,7,84),(501,0,6,84),(502,3,5,84),(503,5,4,84),(504,5,3,84),(505,5,8,85),(506,5,7,85),(507,5,6,85),(508,3,5,85),(509,3,4,85),(510,3,3,85),(511,5,8,86),(512,5,7,86),(513,5,6,86),(514,3,5,86),(515,3,4,86),(516,3,3,86),(517,10,8,87),(518,10,7,87),(519,10,6,87),(520,5,5,87),(521,5,4,87),(522,5,3,87),(523,5,8,88),(524,5,7,88),(525,5,6,88),(526,5,5,88),(527,10,4,88),(528,10,3,88),(529,10,8,89),(530,10,7,89),(531,10,6,89),(532,10,5,89),(533,10,4,89),(534,10,3,89),(535,10,8,90),(536,10,7,90),(537,10,6,90),(538,10,5,90),(539,10,4,90),(540,10,3,90),(541,10,8,91),(542,10,7,91),(543,3,6,91),(544,3,5,91),(545,3,4,91),(546,3,3,91),(547,0,8,92),(548,0,7,92),(549,3,6,92),(550,4,5,92),(551,4,4,92),(552,5,3,92),(553,5,8,93),(554,5,7,93),(555,4,6,93),(556,4,5,93),(557,4,4,93),(558,1,3,93),(559,5,8,94),(560,5,7,94),(561,3,6,94),(562,3,5,94),(563,3,4,94),(564,1,3,94),(565,5,8,95),(566,5,7,95),(567,3,6,95),(568,3,5,95),(569,1,4,95),(570,1,3,95),(571,5,8,96),(572,5,7,96),(573,3,6,96),(574,3,5,96),(575,1,4,96),(576,1,3,96),(577,5,8,97),(578,5,7,97),(579,3,6,97),(580,3,5,97),(581,1,4,97),(582,0,3,97),(583,5,8,98),(584,5,7,98),(585,3,6,98),(586,3,5,98),(587,2,4,98),(588,1,3,98),(589,5,8,99),(590,5,7,99),(591,5,6,99),(592,5,5,99),(593,5,4,99),(594,5,3,99),(595,5,8,100),(596,5,7,100),(597,5,6,100),(598,5,5,100),(599,5,4,100),(600,3,3,100),(601,5,8,101),(602,5,7,101),(603,5,6,101),(604,5,5,101),(605,5,4,101),(606,3,3,101),(607,0,8,102),(608,0,7,102),(609,5,6,102),(610,5,5,102),(611,5,4,102),(612,5,3,102),(613,0,8,103),(614,0,7,103),(615,5,6,103),(616,5,5,103),(617,5,4,103),(618,10,3,103),(619,0,8,104),(620,0,7,104),(621,5,6,104),(622,5,5,104),(623,5,4,104),(624,10,3,104),(625,0,8,105),(626,0,7,105),(627,0,6,105),(628,5,5,105),(629,5,4,105),(630,5,3,105),(631,0,8,106),(632,0,7,106),(633,0,6,106),(634,3,5,106),(635,5,4,106),(636,5,3,106),(637,5,8,107),(638,5,7,107),(639,5,6,107),(640,3,5,107),(641,3,4,107),(642,3,3,107),(643,5,8,108),(644,5,7,108),(645,5,6,108),(646,3,5,108),(647,3,4,108),(648,3,3,108),(649,10,8,109),(650,10,7,109),(651,10,6,109),(652,5,5,109),(653,5,4,109),(654,5,3,109),(655,5,8,110),(656,5,7,110),(657,5,6,110),(658,5,5,110),(659,10,4,110),(660,10,3,110),(661,10,8,111),(662,10,7,111),(663,10,6,111),(664,10,5,111),(665,10,4,111),(666,10,3,111),(667,10,8,112),(668,10,7,112),(669,10,6,112),(670,10,5,112),(671,10,4,112),(672,10,3,112),(673,10,8,113),(674,10,7,113),(675,3,6,113),(676,3,5,113),(677,3,4,113),(678,3,3,113),(679,0,8,114),(680,0,7,114),(681,3,6,114),(682,4,5,114),(683,4,4,114),(684,5,3,114),(685,5,8,115),(686,5,7,115),(687,4,6,115),(688,4,5,115),(689,4,4,115),(690,1,3,115),(691,5,8,116),(692,5,7,116),(693,4,6,116),(694,4,5,116),(695,3,4,116),(696,1,3,116),(697,5,8,117),(698,5,7,117),(699,4,6,117),(700,4,5,117),(701,1,4,117),(702,1,3,117),(703,5,8,118),(704,5,7,118),(705,4,6,118),(706,4,5,118),(707,1,4,118),(708,0,3,118),(709,5,8,119),(710,5,7,119),(711,3,6,119),(712,3,5,119),(713,2,4,119),(714,1,3,119),(715,5,8,120),(716,5,7,120),(717,5,6,120),(718,5,5,120),(719,5,4,120),(720,5,3,120),(721,5,8,121),(722,5,7,121),(723,5,6,121),(724,5,5,121),(725,5,4,121),(726,3,3,121),(727,5,8,122),(728,5,7,122),(729,5,6,122),(730,5,5,122),(731,5,4,122),(732,3,3,122),(733,5,8,123),(734,5,7,123),(735,5,6,123),(736,5,5,123),(737,5,4,123),(738,5,3,123),(739,0,8,124),(740,0,7,124),(741,5,6,124),(742,5,5,124),(743,5,4,124),(744,10,3,124),(745,0,8,125),(746,0,7,125),(747,5,6,125),(748,5,5,125),(749,5,4,125),(750,10,3,125),(751,0,8,126),(752,0,7,126),(753,0,6,126),(754,5,5,126),(755,6,4,126),(756,6,3,126),(757,0,8,127),(758,0,7,127),(759,0,6,127),(760,3,5,127),(761,5,4,127),(762,5,3,127),(763,5,8,128),(764,5,7,128),(765,5,6,128),(766,3,5,128),(767,3,4,128),(768,3,3,128),(769,5,8,129),(770,5,7,129),(771,5,6,129),(772,3,5,129),(773,3,4,129),(774,3,3,129),(775,10,8,130),(776,10,7,130),(777,10,6,130),(778,5,5,130),(779,5,4,130),(780,5,3,130),(781,5,8,131),(782,5,7,131),(783,5,6,131),(784,5,5,131),(785,5,4,131),(786,5,3,131),(787,10,8,132),(788,10,7,132),(789,10,6,132),(790,10,5,132),(791,10,4,132),(792,10,3,132),(793,0,8,133),(794,0,7,133),(795,0,6,133),(796,15,5,133),(797,15,4,133),(798,15,3,133),(799,0,8,134),(800,0,7,134),(801,0,6,134),(802,15,5,134),(803,15,4,134),(804,15,3,134),(805,35,8,135),(806,35,7,135),(807,30,6,135),(808,10,5,135),(809,10,4,135),(810,10,3,135),(811,30,8,136),(812,20,7,136),(813,20,6,136),(814,5,5,136),(815,5,4,136),(816,5,3,136),(817,0,8,137),(818,0,7,137),(819,0,6,137),(820,10,5,137),(821,10,4,137),(822,10,3,137),(823,10,8,138),(824,10,7,138),(825,0,6,138),(826,0,5,138),(827,0,4,138),(828,0,3,138),(829,0,8,139),(830,0,7,139),(831,10,6,139),(832,5,5,139),(833,5,4,139),(834,5,3,139),(835,0,8,140),(836,5,7,140),(837,10,6,140),(838,5,5,140),(839,5,4,140),(840,5,3,140),(841,0,8,141),(842,0,7,141),(843,0,6,141),(844,5,5,141),(845,5,4,141),(846,5,3,141),(847,0,8,142),(848,0,7,142),(849,0,6,142),(850,5,5,142),(851,5,4,142),(852,5,3,142),(853,0,8,143),(854,5,7,143),(855,5,6,143),(856,5,5,143),(857,5,4,143),(858,5,3,143),(859,20,8,144),(860,20,7,144),(861,10,6,144),(862,10,5,144),(863,5,4,144),(864,5,3,144),(865,20,8,145),(866,20,7,145),(867,20,6,145),(868,20,5,145),(869,10,4,145),(870,10,3,145),(871,20,8,146),(872,20,7,146),(873,20,6,146),(874,20,5,146),(875,10,4,146),(876,10,3,146),(877,20,8,147),(878,20,7,147),(879,10,6,147),(880,10,5,147),(881,5,4,147),(882,5,3,147),(883,0,8,148),(884,0,7,148),(885,5,6,148),(886,5,5,148),(887,10,4,148),(888,10,3,148),(889,20,8,149),(890,20,7,149),(891,10,6,149),(892,10,5,149),(893,10,4,149),(894,10,3,149),(895,0,8,150),(896,0,7,150),(897,10,6,150),(898,10,5,150),(899,20,4,150),(900,20,3,150),(901,0,8,151),(902,0,7,151),(903,5,6,151),(904,5,5,151),(905,10,4,151),(906,10,3,151),(907,0,8,152),(908,0,7,152),(909,5,6,152),(910,5,5,152),(911,10,4,152),(912,10,3,152),(913,0,8,153),(914,0,7,153),(915,5,6,153),(916,5,5,153),(917,10,4,153),(918,10,3,153),(919,0,8,154),(920,0,7,154),(921,10,6,154),(922,0,5,154),(923,0,4,154),(924,0,3,154),(925,0,8,155),(926,0,7,155),(927,5,6,155),(928,0,5,155),(929,0,4,155),(930,0,3,155),(931,0,8,156),(932,0,7,156),(933,5,6,156),(934,0,5,156),(935,0,4,156),(936,0,3,156),(937,0,8,157),(938,0,7,157),(939,25,6,157),(940,0,5,157),(941,0,4,157),(942,0,3,157),(943,0,8,158),(944,0,7,158),(945,5,6,158),(946,0,5,158),(947,0,4,158),(948,0,3,158),(949,0,8,159),(950,0,7,159),(951,10,6,159),(952,0,5,159),(953,0,4,159),(954,0,3,159),(955,0,8,160),(956,0,7,160),(957,10,6,160),(958,0,5,160),(959,0,4,160),(960,0,3,160),(961,0,8,161),(962,0,7,161),(963,10,6,161),(964,0,5,161),(965,0,4,161),(966,0,3,161),(967,0,8,162),(968,0,7,162),(969,10,6,162),(970,0,5,162),(971,0,4,162),(972,0,3,162),(973,0,8,163),(974,0,7,163),(975,5,6,163),(976,0,5,163),(977,0,4,163),(978,0,3,163),(979,0,8,164),(980,0,7,164),(981,5,6,164),(982,0,5,164),(983,0,4,164),(984,0,3,164),(985,0,8,165),(986,0,7,165),(987,0,6,165),(988,5,5,165),(989,0,4,165),(990,0,3,165),(991,0,8,166),(992,0,7,166),(993,0,6,166),(994,15,5,166),(995,0,4,166),(996,0,3,166),(997,0,8,167),(998,0,7,167),(999,0,6,167),(1000,10,5,167),(1001,0,4,167),(1002,0,3,167),(1003,0,8,168),(1004,0,7,168),(1005,0,6,168),(1006,5,5,168),(1007,0,4,168),(1008,0,3,168),(1009,0,8,169),(1010,0,7,169),(1011,0,6,169),(1012,35,5,169),(1013,0,4,169),(1014,0,3,169),(1015,0,8,170),(1016,0,7,170),(1017,0,6,170),(1018,20,5,170),(1019,0,4,170),(1020,0,3,170),(1021,0,8,171),(1022,0,7,171),(1023,0,6,171),(1024,5,5,171),(1025,0,4,171),(1026,0,3,171),(1027,0,8,172),(1028,0,7,172),(1029,0,6,172),(1030,5,5,172),(1031,0,4,172),(1032,0,3,172),(1033,0,8,173),(1034,0,7,173),(1035,20,6,173),(1036,0,5,173),(1037,0,4,173),(1038,0,3,173),(1039,0,8,174),(1040,0,7,174),(1041,10,6,174),(1042,0,5,174),(1043,0,4,174),(1044,0,3,174),(1045,0,8,175),(1046,0,7,175),(1047,10,6,175),(1048,0,5,175),(1049,0,4,175),(1050,0,3,175),(1051,0,8,176),(1052,0,7,176),(1053,20,6,176),(1054,0,5,176),(1055,0,4,176),(1056,0,3,176),(1057,0,8,177),(1058,0,7,177),(1059,10,6,177),(1060,0,5,177),(1061,0,4,177),(1062,0,3,177),(1063,0,8,178),(1064,0,7,178),(1065,10,6,178),(1066,0,5,178),(1067,0,4,178),(1068,0,3,178),(1069,0,8,179),(1070,0,7,179),(1071,10,6,179),(1072,0,5,179),(1073,0,4,179),(1074,0,3,179),(1075,0,8,180),(1076,0,7,180),(1077,5,6,180),(1078,0,5,180),(1079,0,4,180),(1080,0,3,180),(1081,0,8,181),(1082,0,7,181),(1083,5,6,181),(1084,0,5,181),(1085,0,4,181),(1086,0,3,181),(1087,10,8,182),(1088,10,7,182),(1089,10,6,182),(1090,20,5,182),(1091,15,4,182),(1092,15,3,182),(1093,10,8,183),(1094,10,7,183),(1095,15,6,183),(1096,15,5,183),(1097,20,4,183),(1098,15,3,183),(1099,20,8,184),(1100,10,7,184),(1101,10,6,184),(1102,5,5,184),(1103,5,4,184),(1104,5,3,184),(1105,15,8,185),(1106,20,7,185),(1107,15,6,185),(1108,15,5,185),(1109,15,4,185),(1110,15,3,185),(1111,10,8,186),(1112,5,7,186),(1113,10,6,186),(1114,10,5,186),(1115,10,4,186),(1116,10,3,186),(1117,20,8,187),(1118,25,7,187),(1119,5,6,187),(1120,5,5,187),(1121,0,4,187),(1122,0,3,187),(1123,15,8,188),(1124,15,7,188),(1125,20,6,188),(1126,20,5,188),(1127,20,4,188),(1128,20,3,188),(1129,0,8,189),(1130,0,7,189),(1131,5,6,189),(1132,5,5,189),(1133,5,4,189),(1134,5,3,189),(1135,0,8,190),(1136,5,7,190),(1137,10,6,190),(1138,5,5,190),(1139,10,4,190),(1140,15,3,190),(1141,20,8,191),(1142,10,7,191),(1143,5,6,191),(1144,3,5,191),(1145,3,4,191),(1146,5,3,191),(1147,5,8,192),(1148,10,7,192),(1149,7,6,192),(1150,3,5,192),(1151,3,4,192);
/*!40000 ALTER TABLE `Porcentajes_Objetivos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Porcentajes_Objetivos_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Porcentajes_Objetivos` FOR EACH ROW BEGIN
	INSERT INTO Bitacora(accion,descripcion,valor)
    VALUES(3,'se agrega nuevo registro en Porcentajes_Objetivos',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Porcentajes_Objetivos_AFTER_UPDATE_Bitacora` 
AFTER UPDATE ON `Porcentajes_Objetivos` FOR EACH ROW BEGIN
	INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(2,concat('se modifica registro (valor: ',OLD.valor,' - ',NEW.valor,
	'del nivel: ',OLD.nivel_posicion,' del objetivo-area: ',OLD.objetivo_area),NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Posicion_Track`
--

DROP TABLE IF EXISTS `Posicion_Track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Posicion_Track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `track` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`track`,`posicion`),
  KEY `fk_Posicion_Track_Tracks1_idx` (`track`),
  KEY `fk_Posicion_Track_Posiciones1_idx` (`posicion`),
  CONSTRAINT `fk_Posicion_Track_Posiciones1` FOREIGN KEY (`posicion`) REFERENCES `Posiciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Posicion_Track_Tracks1` FOREIGN KEY (`track`) REFERENCES `Tracks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Posicion_Track`
--

LOCK TABLES `Posicion_Track` WRITE;
/*!40000 ALTER TABLE `Posicion_Track` DISABLE KEYS */;
INSERT INTO `Posicion_Track` VALUES (1,1,1),(2,1,2),(3,1,4),(4,1,5),(5,1,9),(6,1,10),(7,1,14),(8,1,15),(9,1,19),(10,1,21),(11,1,23),(12,1,25),(13,2,1),(14,2,2),(16,2,5),(15,2,6),(18,2,10),(17,2,11),(20,2,15),(19,2,16),(21,2,19),(22,2,21),(23,2,23),(24,2,25),(25,3,1),(26,3,3),(27,3,7),(28,3,8),(29,3,12),(30,3,13),(31,3,17),(32,3,18),(33,3,19),(34,3,21),(35,3,23),(36,3,25),(37,4,1),(38,4,5),(39,4,10),(40,4,15),(41,4,20),(42,4,22),(43,4,23),(45,4,24),(44,4,25),(46,5,1),(47,5,5),(48,5,10),(49,5,15),(52,5,23),(53,5,25),(50,5,26),(51,5,27),(54,6,5);
/*!40000 ALTER TABLE `Posicion_Track` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Posiciones`
--

DROP TABLE IF EXISTS `Posiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Posiciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `nivel` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Posiciones`
--

LOCK TABLES `Posiciones` WRITE;
/*!40000 ALTER TABLE `Posiciones` DISABLE KEYS */;
INSERT INTO `Posiciones` VALUES (1,'CEO',1),(2,'Director Asociado',2),(3,'Director Comercial',2),(4,'Director SAP',3),(5,'Director',3),(6,'Director Experto',3),(7,'Director de Preventa',3),(8,'Director Ventas',3),(9,'SAP Experto',4),(10,'Gerente Sr',4),(11,'Business Matter Expert',4),(12,'Gerente Sr de Preventa',4),(13,'Gerente Sr Ventas',4),(14,'SAP Master',5),(15,'Gerente',5),(16,'Master de Negocios',5),(17,'Gerente de Preventa',5),(18,'Gerente Ventas',5),(19,'Consultor Sr',6),(20,'Especialista Sr',6),(21,'Consultor',7),(22,'Especialista',7),(23,'Analista',8),(24,'Asistente Jr',8),(25,'Entrenamiento',9),(26,'Ing Telecom Sr',6),(27,'Ing Telecom',7);
/*!40000 ALTER TABLE `Posiciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Resultados_Evaluacion`
--

DROP TABLE IF EXISTS `Resultados_Evaluacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Resultados_Evaluacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluacion` int(11) NOT NULL,
  `colaborador` int(11) NOT NULL,
  `total` double DEFAULT NULL,
  `rating` char(1) DEFAULT NULL,
  `cumple_gastos` char(2) DEFAULT NULL,
  `cumple_harvest` char(2) DEFAULT NULL,
  `cumple_cv` char(2) DEFAULT NULL,
  `comentarios` varchar(1000) DEFAULT NULL,
  `total_competencias` double DEFAULT NULL,
  `total_responsabilidades` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_table1_Evaluaciones1` (`evaluacion`),
  KEY `fk_table1_Users1_idx` (`colaborador`),
  CONSTRAINT `fk_table1_Evaluaciones1` FOREIGN KEY (`evaluacion`) REFERENCES `Evaluaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_Users1` FOREIGN KEY (`colaborador`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Resultados_Evaluacion`
--

LOCK TABLES `Resultados_Evaluacion` WRITE;
/*!40000 ALTER TABLE `Resultados_Evaluacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Resultados_Evaluacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Resultados_Evaluacion_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Resultados_Evaluacion` FOR EACH ROW BEGIN
	INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Resultados_Evaluacion',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Resultados_Evaluacion_AFTER_UPDATE_Bitacora` 
AFTER UPDATE ON `Resultados_Evaluacion` FOR EACH ROW BEGIN
	INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(2,concat('se modifica registro (total: ',OLD.total,' - ',NEW.total,
		', rating: ',OLD.rating,' - ',NEW.rating,', cumple-gastos: ',OLD.cumple_gastos,' - '
        ,NEW.cumple_gastos,', cumple-harvest: ',OLD.cumple_harvest,' - ',NEW.cumple_harvest,
        ',cumple-cv: ',OLD.cumple_cv,' - ',NEW.cumple_cv,',comentarios: ',OLD.comentarios,' - '
        ,NEW.comentarios,', de la evaluacion: ',OLD.evaluacion,' del colaborador: ',OLD.colaborador)
        ,NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Resultados_ev_Competencia`
--

DROP TABLE IF EXISTS `Resultados_ev_Competencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Resultados_ev_Competencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asignacion` int(11) NOT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`,`asignacion`),
  KEY `fk_Resultados_ev_Competencia_Evaluadores1_idx` (`asignacion`),
  CONSTRAINT `fk_Resultados_ev_Competencia_Evaluadores1` FOREIGN KEY (`asignacion`) REFERENCES `Evaluadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Resultados_ev_Competencia`
--

LOCK TABLES `Resultados_ev_Competencia` WRITE;
/*!40000 ALTER TABLE `Resultados_ev_Competencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `Resultados_ev_Competencia` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Resultados_ev_Competencia_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Resultados_ev_Competencia` FOR EACH ROW BEGIN
	INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Resultados_ev_Competencia',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Resultados_ev_Responsabilidad`
--

DROP TABLE IF EXISTS `Resultados_ev_Responsabilidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Resultados_ev_Responsabilidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` double DEFAULT NULL,
  `asignacion` int(11) NOT NULL,
  PRIMARY KEY (`id`,`asignacion`),
  KEY `fk_Resultados_Evaluaciones_Evaluadores1_idx` (`asignacion`),
  CONSTRAINT `fk_Resultados_Evaluaciones_Evaluadores1` FOREIGN KEY (`asignacion`) REFERENCES `Evaluadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Resultados_ev_Responsabilidad`
--

LOCK TABLES `Resultados_ev_Responsabilidad` WRITE;
/*!40000 ALTER TABLE `Resultados_ev_Responsabilidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `Resultados_ev_Responsabilidad` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `advanzer_ch`.`Resultados_ev_Responsabilidad_AFTER_INSERT_Bitacora` 
AFTER INSERT ON `Resultados_ev_Responsabilidad` FOR EACH ROW BEGIN
	INSERT INTO Bitacora(accion,descripcion,valor)
	VALUES(3,'se agrega nuevo registro en Resultados_ev_Responsabilidad',NEW.id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Tracks`
--

DROP TABLE IF EXISTS `Tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tracks`
--

LOCK TABLES `Tracks` WRITE;
/*!40000 ALTER TABLE `Tracks` DISABLE KEYS */;
INSERT INTO `Tracks` VALUES (3,'Comercial'),(2,'Consultoría de Negocios'),(6,'Dirección General'),(1,'SAP'),(4,'Soporte de Negocio'),(5,'Telecomunicaciones');
/*!40000 ALTER TABLE `Tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `nombre` varchar(500) NOT NULL,
  `foto` varchar(100) DEFAULT 'sin_foto.png',
  `empresa` int(1) DEFAULT '1',
  `estatus` int(1) DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `categoria` varchar(10) DEFAULT NULL,
  `nomina` int(11) NOT NULL,
  `area` int(11) DEFAULT NULL,
  `posicion_track` int(11) DEFAULT NULL,
  `plaza` varchar(45) DEFAULT NULL,
  `tipo` int(11) DEFAULT '0' COMMENT '0=normal;1=requisicion,2=admin,3=req&admin',
  `fecha_baja` date DEFAULT NULL,
  `tipo_baja` varchar(45) DEFAULT NULL,
  `motivo` varchar(1000) DEFAULT NULL,
  `jefe` int(11) DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomina_UNIQUE` (`nomina`),
  KEY `fk_Users_Areas1_idx` (`area`),
  KEY `fk_Users_Posicion_Track1_idx` (`posicion_track`),
  CONSTRAINT `fk_Users_Areas1` FOREIGN KEY (`area`) REFERENCES `Areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_Posicion_Track1` FOREIGN KEY (`posicion_track`) REFERENCES `Posicion_Track` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'mauricio.cruz@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','MAURICIO CRUZ VELÁZQUEZ DE LEÓN','1.jpg',1,1,'2015-10-22 13:55:00','2015-11-13 16:23:46','CE0',1,18,54,'MTY',3,NULL,NULL,NULL,0,'2006-02-14'),(2,'julio.luna@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JULIO VALENTE LUNA ALATORRE','3.jpg',1,1,'2015-10-22 13:55:00','2015-11-12 23:21:26','C42',3,6,16,'MTY',3,NULL,NULL,NULL,1,'2010-07-01'),(3,'erika.cruz@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ERIKA ROSARIO CRUZ MADRIGAL','sin_foto.png',1,0,'2015-10-22 13:55:00','2015-11-11 22:53:31','N18',5,7,41,'MTY',0,NULL,'Involuntaria','Reestructura de área',22,'2007-11-01'),(4,'tadeo.zavala@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','TADEO FABIÁN ZAVALA GUTIÉRREZ','6.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S14',6,11,9,'MTY',0,'0000-00-00','','',18,'2007-11-01'),(5,'monica.saenz@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','MONICA JANETT SÁENZ MARTÍNEZ','7.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C13',7,12,21,'MTY',0,'0000-00-00','','',7,'2009-06-02'),(6,'erick.quinones@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ERICK FERNANDO QUIÑONES CERDA','9.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C12',9,12,21,'MTY',0,'0000-00-00','','',7,'2010-10-01'),(7,'alma.trejo@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ALMA DELIA TREJO ZUÑIGA','11.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C27',11,12,17,'MTY',0,'0000-00-00','','',16,'2010-07-01'),(8,'tere.vazquez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','LUZ MARÍA TERESA VÁZQUEZ CORTÉS','12.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C20',12,12,21,'MTY',0,'0000-00-00','','',7,'2010-07-01'),(9,'','5f4dcc3b5aa765d61d8327deb882cf99','MARCOS RAMOS RODRÍGUEZ','13.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','N00',13,7,44,'MTY',0,'0000-00-00','','',3,'2008-11-06'),(10,'mauricio.guerrero@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','MAURICIO JAVIER GUERRERO GARCÍA','sin_foto.png',1,1,'2015-10-22 13:55:00','2015-10-22 19:22:29','N19',14,8,40,'MTY',0,'0000-00-00','','',22,'2011-03-01'),(11,'abigail.flores@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ABIGAIL FLORES SERNA','15.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C14',15,13,21,'MTY',0,'0000-00-00','','',16,'2011-03-28'),(12,'','5f4dcc3b5aa765d61d8327deb882cf99','JOSEFINA RAMOS RODRÍGUEZ','30.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','N00',30,7,44,'MTY',0,'0000-00-00','','',3,'2011-10-10'),(13,'dora.ramirez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','DORA ALICIA RAMÍREZ GARCÍA','32.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C07',32,12,22,'MTY',0,'0000-00-00','','',7,'2011-10-24'),(14,'gabriela.rodriguez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','GABRIELA RODRÍGUEZ ALMEIDA','33.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','N19',33,2,40,'MTY',0,'0000-00-00','','',2,'2011-11-01'),(15,'jorge.salvans@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JORGE ALBERTO SALVANS SANDOVAL','37.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S34',37,NULL,4,'DF',0,'0000-00-00','','',1,'2012-02-20'),(16,'juanjose.malanche@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JUAN JOSÉ MALANCHE ABDALÁ','38.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S34',38,NULL,4,'MTY',0,'0000-00-00','','',1,'2012-03-05'),(17,'rodolfo.cortes@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','RODOLFO CORTÉS MARROQUÍN','39.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S26',39,3,6,'MTY',0,'0000-00-00','','',2,'2012-03-05'),(18,'edson.rodriguez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','EDSON ERNESTO RODRÍGUEZ ESCALANTE','41.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S26',41,11,8,'MTY',0,'0000-00-00','','',16,'2012-03-20'),(19,'javier.ynoquio@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JAVIER GREGORIO YNOQUIO AÑAZCO','45.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S22',45,14,8,'MTY',0,'0000-00-00','','',16,'2012-04-23'),(20,'eduardo.ochoa@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','EDUARDO OCHOA RIZO','54.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S22',54,3,7,'MTY',6,'0000-00-00','','',17,'2012-06-13'),(21,'enrique.bernal@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ENRIQUE BERNAL CONDE','55.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','N18',55,4,41,'MTY',4,'0000-00-00','','',40,'2015-02-01'),(22,'manuel.cruz@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','MANUEL FRANCISCO CRUZ VELÁZQUEZ DE LEÓN','57.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','N40',57,NULL,38,'MTY',0,'0000-00-00','','',1,'2012-06-16'),(23,'yabneel.longoria@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','YABNEEL ARELY LONGORIA ÁLVAREZ','58.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C09',58,13,22,'MTY',0,'0000-00-00','','',11,'2012-06-18'),(24,'jorgeluis.zuniga@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JORGE LUIS ZÚÑIGA CORTÉZ','60.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S24',60,3,7,'MTY',0,'0000-00-00','','',17,'2012-07-05'),(25,'pricila.moncada@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','PRICILA CATALINA MONCADA GUAJARDO','61.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C19',61,20,21,'DF',0,'0000-00-00','','',15,'2012-07-09'),(26,'mauricio.sandoval@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JUAN MAURICIO SANDOVAL JIMÉNEZ','62.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','S21',62,3,8,'DF',0,'0000-00-00','','',39,'2015-01-09'),(27,'leticia.cavazos@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','NORMA LETICIA CAVAZOS GARCÍA','67.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:02','C17',67,15,20,'MTY',0,'0000-00-00','','',16,'2012-07-30'),(28,'amira.chavez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','AMIRA AGLAE CHAVEZ VILLEGAS','68.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C09',68,13,22,'MTY',0,'0000-00-00','','',11,'2012-07-30'),(29,'daniel.garfunkel@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','DANIEL GARFUNKEL','73.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','V39',73,NULL,26,'DF',0,'0000-00-00','','',1,'2012-09-03'),(30,'roberto.banales@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ROBERTO MIGUEL BAÑALES RODRÍGUEZ','83.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S07',83,11,10,'MTY',0,'0000-00-00','','',18,'2012-10-15'),(31,'ignacio.herrera@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','IGNACIO RAFAEL HERRERA GARCÍA','90.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C04',90,11,11,'MTY',0,'0000-00-00','','',18,'2012-11-09'),(32,'nancy.vazquez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','NANCY KARINA VÁZQUEZ PÉREZ','91.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S03',91,15,11,'MTY',0,'0000-00-00','','',27,'2012-11-09'),(33,'martin.garza@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','MARTÍN GARZA GUZMÁN','100.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','N15',100,9,42,'MTY',0,'0000-00-00','','',22,'2012-12-10'),(34,'esteban.cansino@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ESTEBAN CANSINO VÁSQUEZ','104.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S21',104,16,8,'MTY',0,'0000-00-00','','',16,'2013-01-07'),(35,'rolando.berain@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JESÚS ROLANDO BERAIN CALDERÓN','106.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S19',106,17,8,'MTY',0,'0000-00-00','','',16,'2013-01-07'),(36,'miguel.martinez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','MIGUEL ANGEL MARTÍNEZ DÍAZ','108.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S17',108,16,9,'DF',0,'0000-00-00','','',34,'2013-01-07'),(37,'ana.gonzalez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ANA GONZÁLEZ MENA','109.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S06',109,17,10,'MTY',0,'0000-00-00','','',35,'2013-01-07'),(38,'oscar.lozano@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ÓSCAR GUADALUPE LOZANO MARTÍNEZ','111.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S14',111,14,9,'MTY',0,'0000-00-00','','',19,'2013-01-15'),(39,'ramon.diaz@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','RAMÓN ALEJANDRO DÍAZ ACOSTA','117.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S19',117,3,9,'DF',0,'0000-00-00','','',17,'2013-02-18'),(40,'micaela.llano@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','MICAELA LLANO AGUILAR','122.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','N34',122,4,39,'MTY',5,'0000-00-00','','',2,'2013-04-01'),(41,'luisgerardo.gallegos@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','LUIS GERARDO GALLEGOS SANDOVAL','128.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S18',128,3,9,'MTY',0,'0000-00-00','','',24,'2013-07-01'),(42,'amado.gonzalez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','AMADO ELISEO GONZÁLEZ CASTILLO','129.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S19',129,16,8,'DF',0,'0000-00-00','','',34,'2013-07-08'),(43,'francisco.herrera@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','FRANCISCO JAVIER HERRERA GAONA','132.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C01',132,15,23,'MTY',0,'0000-00-00','','',27,'2013-10-01'),(44,'victor.castro@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','VÍCTOR RENÉ CASTRO RODRÍGUEZ','134.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S07',134,11,10,'MTY',0,'0000-00-00','','',18,'2014-04-01'),(45,'edna.guzman@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','EDNA DENNIS GUZMÁN RIVERA','sin_foto.png',2,1,'2015-10-22 13:55:00','2015-10-28 19:09:33','T07',136,22,51,'DF',0,'0000-00-00','','',52,'2014-04-14'),(46,'daniel.gallegos@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','FRANCISCO DANIEL GALLEGOS AGUILAR','140.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S07',140,11,10,'DF',0,'0000-00-00','','',18,'2014-06-01'),(47,'','5f4dcc3b5aa765d61d8327deb882cf99','RODOLFO CUEVAS JIMÉNEZ','143.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','N00',143,9,44,'DF',0,'0000-00-00','','',22,'2014-06-01'),(48,'ivan.hernandezm@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','IVÁN HERNÁNDEZ MARTÍNEZ','sin_foto.png',1,1,'2015-10-22 13:55:00','2015-10-22 19:22:29','S07',145,11,10,'DF',0,'0000-00-00','','',18,'2014-07-16'),(49,'raul.lopez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','RAÚL MANUEL LÓPEZ GARCÍA','148.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S18',148,11,9,'DF',0,'0000-00-00','','',18,'2014-08-16'),(50,'jose.gutierrez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JOSÉ GUTIERREZ GALVEZ','149.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C21',149,20,21,'DF',0,'0000-00-00','','',15,'2014-08-25'),(51,'jlperalta@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','JOSE LUIS PERALTA HIGUERA','150.jpg',2,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','T40',150,NULL,47,'DF',0,'0000-00-00','','',NULL,'2014-09-01'),(52,'guillermo.montero@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','GUILLERMO MONTERO AMERENA','sin_foto.png',2,1,'2015-10-22 13:55:00',NULL,'T35',151,NULL,47,'DF',0,'0000-00-00','','',51,'2014-09-01'),(53,'cesar.rodriguez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','CÉSAR ESTEBAN RODRÍGUEZ VARGAS','155.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C04',155,15,23,'MTY',0,'0000-00-00','','',27,'2014-09-17'),(54,'raul.juarez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','RAÚL JUÁREZ LARA','156.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S15',156,17,9,'DF',0,'0000-00-00','','',35,'2014-10-14'),(55,'alejandra.torres@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ALEJANDRA TORRES PUENTE','158.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','N01',158,1,45,'MTY',0,'0000-00-00','','',1,'2014-10-31'),(56,'christian.valerio@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','CHRISTIAN DANIEL VALERIO CERDA','159.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C01',159,15,23,'MTY',0,'0000-00-00','','',27,'2014-11-10'),(57,'luz.castillo@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','LUZ ELENA CASTILLO DELGADO','160.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C01',160,15,23,'MTY',0,'0000-00-00','','',27,'2014-11-10'),(58,'sergio.nieto@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','SERGIO ANTONIO NIETO DARAN','sin_foto.png',1,1,'2015-10-22 13:55:00',NULL,'C02',161,13,23,'DF',0,'0000-00-00','','',11,'2014-11-10'),(59,'anabel.sanchez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ANABEL SÁNCHEZ GARCÍA','162.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','C05',162,13,23,'DF',0,'0000-00-00','','',11,'2014-11-10'),(60,'belinda.lopez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','BELINDA ALEJANDRA LÓPEZ GARIBAY','sin_foto.png',1,1,'2015-10-22 13:55:00','2015-10-22 19:22:29','N20',166,10,41,'DF',2,'0000-00-00','','',22,'2014-12-01'),(61,'roman.uranga@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JOSÉ ROMÁN URANGA RAMÍREZ','167.jpg',1,1,'2015-10-22 13:55:00','2015-11-13 18:52:36','N18',167,9,41,'MTY',0,'0000-00-00','','',33,'2014-12-15'),(62,'silvia.garza@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','SILVIA VERÓNICA GARZA IBARRA','168.jpg',1,1,'2015-10-22 13:55:00','2015-11-12 23:25:55','C04',168,15,23,'MTY',0,'0000-00-00','','',27,'2014-12-15'),(63,'victor.martinez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','VÍCTOR AZAHEL MARTÍNEZ LOZANO','170.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:03','S09',170,11,10,'MTY',0,'0000-00-00','','',18,'2015-01-19'),(64,'keren.lozano@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','KEREN YANIRE LOZANO CHAPA','171.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','C04',171,15,23,'MTY',0,'0000-00-00','','',27,'2015-01-26'),(65,'pablos.yanez@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','PABLOS YÁÑEZ BOLAÑOS','sin_foto.png',2,1,'2015-10-22 13:55:00','2015-10-22 19:22:29','T20',172,22,49,'DF',0,'0000-00-00','','',52,'2015-01-03'),(66,'luis.tenorio@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','LUIS FERNANDO TENORIO NIETO','sin_foto.png',1,1,'2015-10-22 13:55:00',NULL,'S17',173,11,9,'DF',0,'0000-00-00','','',18,'2015-02-16'),(67,'eduardo.rivera@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','EDUARDO RIVERA LEÓN','174.jpg',1,1,'2015-10-22 13:55:00','2015-11-18 16:21:53','C18',174,20,9,'DF',0,'0000-00-00','','',15,'2015-02-23'),(68,'camila.moya@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','CAMILA ALEJANDRA MOYA GARZA','sin_foto.png',1,1,'2015-10-22 13:55:00',NULL,'N00',175,4,44,'MTY',0,'0000-00-00','','',21,'2015-03-02'),(69,'gustavo.sanroman@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','GUSTAVO ADOLFO SANROMAN CALLEROS','176.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','S17',176,3,9,'DF',0,'0000-00-00','','',20,'2015-03-17'),(70,'hector.rodriguez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','HÉCTOR EMMANUEL RODRÍGUEZ CARVALLO','177.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','C14',177,18,33,'DF',0,'0000-00-00','','',29,'2015-03-19'),(71,'keissy.olvera@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','KEISSY OLVERA SEAÑEZ','178.jpg',2,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','T25',178,22,49,'DF',0,'0000-00-00','','',51,'2015-04-16'),(72,'jorge.narvaez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JORGE IVÁN NARVAEZ ESTRELLA','179.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','S12',179,3,10,'DF',0,'0000-00-00','','',20,'2015-04-21'),(73,'angelica.rodriguez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ANGÉLICA DEYANIRA RODRÍGUEZ GARIBAY','181.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','N00',181,7,45,'MTY',0,'0000-00-00','','',3,'2015-05-04'),(74,'ana.desaracho@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','ANA DE SARACHO O\'BRIEN','sin_foto.png',2,1,'2015-10-22 13:55:00',NULL,'T35',182,NULL,47,'DF',0,'0000-00-00','','',51,'2015-06-01'),(75,'fredy.torres@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','EDSON FREDY TORRES GONZÁLEZ','183.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','S13',183,11,9,'DF',0,'0000-00-00','','',18,'2015-06-01'),(76,'erendira.sanchez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ERENDIRA SÁNCHEZ SIERRA','184.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','C02',184,13,23,'DF',0,'0000-00-00','','',11,'2015-06-12'),(77,'daniel.rios@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JUAN DANIEL RÍOS DÍAZ','186.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','S17',186,3,9,'DF',0,'0000-00-00','','',20,'2015-07-01'),(78,'jesus.salas@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','JESÚS HUMBERTO SALAS SANSABAS','185.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','N06',185,3,43,'MTY',6,'0000-00-00','','',20,'2015-06-22'),(79,'adolfo.garcia@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','ADOLFO ALBERTO GARCÍA GARCÍA','187.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','S17',187,3,9,'MTY',0,'0000-00-00','','',39,'2015-07-01'),(80,'diego.rivera@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','DIEGO ALBERTO RIVERA HERNÁNDEZ','188.jpg',2,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','T17',188,22,50,'DF',0,'0000-00-00','','',74,'2015-08-05'),(81,'andrea.gonzalez@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','ANDREA FERNANDA GONZÁLEZ VERDE','189.jpg',2,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','T04',189,22,52,'DF',0,'0000-00-00','','',74,'2015-09-01'),(82,'jonathan.estrada@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','JONATHAN ESTRADA GONZÁLEZ','190.jpg',2,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','T04',190,22,52,'DF',0,'0000-00-00','','',74,'2015-09-01'),(83,'daniel.chavez@entuizer.com','5f4dcc3b5aa765d61d8327deb882cf99','DANIEL CHÁVEZ MUÑOZ','sin_foto.png',2,1,'2015-10-22 13:55:00','2015-10-22 19:22:30','T12',191,22,51,'DF',0,'0000-00-00','','',74,'2015-09-01'),(84,'omar.trevino@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','OMAR TREVIÑO MARTÍNEZ','192.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','C18',192,13,21,'MTY',0,'0000-00-00','','',11,'2015-09-09'),(85,'perla.valdez@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','PERLA FABIOLA VALDÉZ GAYTÁN','193.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','N19',193,4,41,'MTY',3,'0000-00-00','','',40,'2015-09-21'),(86,'francis.cobos@advanzer.com','5f4dcc3b5aa765d61d8327deb882cf99','FRANCIS ANDRÉS COBOS PEÑARRETA','194.jpg',1,1,'2015-10-22 13:55:00','2015-11-10 19:30:04','C30',194,21,18,'DF',0,'0000-00-00','','',1,'2015-10-01');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`advanzer_ch`@`localhost`*/ /*!50003 TRIGGER `Users_AFTER_INSERT_Bitacora` AFTER INSERT ON `Users` FOR EACH ROW INSERT INTO Bitacora(accion,descripcion,valor) 
    VALUES(3,'se agrega nuevo registro en Users',NEW.id) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`advanzer_ch`@`localhost`*/ /*!50003 TRIGGER `Users_AFTER_UPDATE_Bitacora` BEFORE UPDATE ON `Users` 
FOR EACH ROW 
	IF OLD.foto = NEW.foto THEN
		INSERT INTO Bitacora(accion,descripcion,valor)
		VALUES(2,concat('se modifica registro (email: ',OLD.email,' - ',NEW.email,
		', nombre: ',OLD.nombre,' - ',NEW.nombre,', empresa: ',OLD.empresa,' - ',NEW.empresa,
		', jefe: ',OLD.jefe,' - ',NEW.jefe,',plaza: ',OLD.plaza,' - ',NEW.plaza,
		',posicion-track: ',OLD.posicion_track,' - ',NEW.posicion_track,', area: ',OLD.area,' - ',NEW.area,
		',fecha ingreso: ',OLD.fecha_ingreso,' - ',NEW.fecha_ingreso,', nomina: ',OLD.nomina,' - ',NEW.nomina,
		',categoria: ',OLD.categoria,' - ',NEW.categoria,', tipo: ',OLD.tipo,' - ',NEW.tipo,
		', fecha_baja: ',OLD.fecha_baja,' - ',NEW.fecha_baja,', tipo baja: ',OLD.tipo_baja,' - ',NEW.tipo_baja,
		', motivo: ',OLD.motivo,' - ',NEW.motivo,', estatus: ',OLD.estatus,' - ',NEW.estatus,') 
		actualizado el: ',NEW.update_time),NEW.id);
	ELSE
		INSERT INTO Bitacora(accion,descripcion,valor) VALUES(2,'Se modifico la foto',NEW.id);
    END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-19 17:33:24
