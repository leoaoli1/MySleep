-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: zfactor
-- ------------------------------------------------------
-- Server version	8.0.16

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
-- Table structure for table `activity_diary_data_table`
--

DROP TABLE IF EXISTS `activity_diary_data_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_diary_data_table` (
  `diaryId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `diaryGrade` int(11) DEFAULT NULL,
  `diaryDate` date DEFAULT NULL,
  `submissionDeadline` datetime DEFAULT NULL,
  `alertSent` int(11) DEFAULT '0',
  `timeCompleted` datetime DEFAULT NULL,
  `interaction` enum('excellent','good','somewhatDifficult','challenging') DEFAULT NULL,
  `behavior` enum('excellent','good','somewhatDifficult','challenging') DEFAULT NULL,
  `attention` enum('never','little','sometimes','mostly','always') DEFAULT NULL,
  `symptomOtherContent` mediumtext,
  `symptomOther` tinyint(1) DEFAULT NULL,
  `symptomUnknown` tinyint(1) DEFAULT NULL,
  `symptomStomach` tinyint(1) DEFAULT NULL,
  `symptomBodyAches` tinyint(1) DEFAULT NULL,
  `symptomCoughing` tinyint(1) DEFAULT NULL,
  `symptomSneezing` tinyint(1) DEFAULT NULL,
  `symptomFever` tinyint(1) DEFAULT NULL,
  `symptomHeadache` tinyint(1) DEFAULT NULL,
  `symptomItchyEyes` tinyint(1) DEFAULT NULL,
  `symptomStuffyNose` tinyint(1) DEFAULT NULL,
  `symptomSoreThroat` tinyint(1) DEFAULT NULL,
  `symptomRunnyNose` tinyint(1) DEFAULT NULL,
  `minTechnology` int(11) DEFAULT NULL,
  `minComputer` int(11) DEFAULT NULL,
  `minVideoGame` int(11) DEFAULT NULL,
  `napStart` time DEFAULT NULL,
  `napEnd` time DEFAULT NULL,
  `minExercised` int(11) DEFAULT NULL,
  `numCaffeinatedDrinks` int(11) DEFAULT NULL,
  `feltDuringDay` enum('veryPleasant','pleasant','sometimesPleasant','unpleasant','veryUnpleasant') DEFAULT NULL,
  `howSleepy` enum('not','somewhat','sleepy','very') DEFAULT NULL,
  `howAttentive` enum('very','mostly','not') DEFAULT NULL,
  `practice` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`diaryId`)
) ENGINE=MyISAM AUTO_INCREMENT=137892 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_diary_data_table`
--

LOCK TABLES `activity_diary_data_table` WRITE;
/*!40000 ALTER TABLE `activity_diary_data_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_diary_data_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_info`
--

DROP TABLE IF EXISTS `activity_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_info` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` varchar(45) DEFAULT NULL,
  `description` longtext,
  `enable_grade` tinyint(4) DEFAULT '1',
  `enable_group` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`recordId`),
  UNIQUE KEY `activity_id_UNIQUE` (`activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_info`
--

LOCK TABLES `activity_info` WRITE;
/*!40000 ALTER TABLE `activity_info` DISABLE KEYS */;
INSERT INTO `activity_info` VALUES (1,'animal-card-test','Sort animals by amount of sleep needed.',1,1),(2,'why-do-we-sleep',NULL,1,1),(3,'enough-sleep-vote',NULL,1,1),(4,'sleep-environment','Assign one photo to teams of 2 to 3 students (some teams may have the same photo).  Explain that the teams will examine the features of the room in more detail but first \nyou are asking for students to provide an overall impression of the competing \nfactors for discussion. After teams have had time to confer, display the Sleep Environment Photos to the class for team to share their overall \nimpressions. ',1,1),(5,'roomEnvironment','We have learned about ways that our sleep can be affected, by the factors inour environment, including light, temperature, sounds and habits. Now we are going to look at creating out own environment, including things in our own bedroom!',1,1),(6,'estrella-actogram-draw','In this activity, students answer questions by plotting in estrella actogram',1,1),(7,'estrella-datahunt','Data search and analysis',1,1),(8,'practice-diary-menu','practice diaries and watch instructions',1,1),(9,'sleep-stories','read, highlight and summarize',1,1),(10,'circadian-rhythm-tempery','Circadian Rhythm video',1,1),(11,'animal-card-retest','re-sort animals in 3 categories - least, intermediate and most sleep',1,1);
/*!40000 ALTER TABLE `activity_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `age_sleep_hours_test_answers_table`
--

DROP TABLE IF EXISTS `age_sleep_hours_test_answers_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `age_sleep_hours_test_answers_table` (
  `userId` int(11) NOT NULL,
  `S_1_2_years_old` mediumtext,
  `S_3_5_years_old` mediumtext,
  `S_6_13_years_old` mediumtext,
  `S_14_17_years_old` mediumtext,
  `S_18_64_years_old` mediumtext,
  `S_65_years_and_older` mediumtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT '1',
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `age_sleep_hours_test_answers_table`
--

LOCK TABLES `age_sleep_hours_test_answers_table` WRITE;
/*!40000 ALTER TABLE `age_sleep_hours_test_answers_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `age_sleep_hours_test_answers_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal_card_retest`
--

DROP TABLE IF EXISTS `animal_card_retest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal_card_retest` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `sortResult` mediumtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `submit` tinyint(1) DEFAULT '1',
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal_card_retest`
--

LOCK TABLES `animal_card_retest` WRITE;
/*!40000 ALTER TABLE `animal_card_retest` DISABLE KEYS */;
/*!40000 ALTER TABLE `animal_card_retest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal_card_test_answers_table`
--

DROP TABLE IF EXISTS `animal_card_test_answers_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal_card_test_answers_table` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `sortResult` mediumtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `submit` tinyint(1) DEFAULT '1',
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=431 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal_card_test_answers_table`
--

LOCK TABLES `animal_card_test_answers_table` WRITE;
/*!40000 ALTER TABLE `animal_card_test_answers_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `animal_card_test_answers_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avatar_table`
--

DROP TABLE IF EXISTS `avatar_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avatar_table` (
  `avatarId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `image` longblob NOT NULL,
  PRIMARY KEY (`avatarId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avatar_table`
--

LOCK TABLES `avatar_table` WRITE;
/*!40000 ALTER TABLE `avatar_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `avatar_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `basketball_test_answers_table`
--

DROP TABLE IF EXISTS `basketball_test_answers_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basketball_test_answers_table` (
  `record` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `player` int(11) DEFAULT NULL,
  `percentage_after_sleep_made` float DEFAULT NULL,
  `percentage_after_more_sleep_made` float DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`record`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basketball_test_answers_table`
--

LOCK TABLES `basketball_test_answers_table` WRITE;
/*!40000 ALTER TABLE `basketball_test_answers_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `basketball_test_answers_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `basketball_test_table`
--

DROP TABLE IF EXISTS `basketball_test_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basketball_test_table` (
  `player` int(11) DEFAULT NULL,
  `attempt` int(11) DEFAULT NULL,
  `after_sleep_made` tinyint(1) DEFAULT NULL,
  `after_more_sleep_made` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basketball_test_table`
--

LOCK TABLES `basketball_test_table` WRITE;
/*!40000 ALTER TABLE `basketball_test_table` DISABLE KEYS */;
INSERT INTO `basketball_test_table` VALUES (1,1,1,1,'0000-00-00 00:00:00'),(1,2,1,1,'0000-00-00 00:00:00'),(1,3,1,1,'0000-00-00 00:00:00'),(1,4,1,1,'0000-00-00 00:00:00'),(1,5,1,1,'0000-00-00 00:00:00'),(1,6,0,1,'0000-00-00 00:00:00'),(1,7,1,1,'0000-00-00 00:00:00'),(1,8,1,1,'0000-00-00 00:00:00'),(1,9,1,1,'0000-00-00 00:00:00'),(1,10,1,0,'0000-00-00 00:00:00'),(2,1,0,1,'0000-00-00 00:00:00'),(2,2,1,1,'0000-00-00 00:00:00'),(2,3,1,1,'0000-00-00 00:00:00'),(2,4,1,1,'0000-00-00 00:00:00'),(2,5,1,1,'0000-00-00 00:00:00'),(2,6,0,1,'0000-00-00 00:00:00'),(2,7,1,1,'0000-00-00 00:00:00'),(2,8,1,1,'0000-00-00 00:00:00'),(2,9,1,1,'0000-00-00 00:00:00'),(2,10,1,1,'0000-00-00 00:00:00'),(3,1,1,1,'0000-00-00 00:00:00'),(3,2,0,1,'0000-00-00 00:00:00'),(3,3,0,1,'0000-00-00 00:00:00'),(3,4,1,1,'0000-00-00 00:00:00'),(3,5,1,1,'0000-00-00 00:00:00'),(3,6,1,0,'0000-00-00 00:00:00'),(3,7,1,1,'0000-00-00 00:00:00'),(3,8,1,1,'0000-00-00 00:00:00'),(3,9,1,1,'0000-00-00 00:00:00'),(3,10,1,1,'0000-00-00 00:00:00'),(4,1,0,0,'0000-00-00 00:00:00'),(4,2,1,1,'0000-00-00 00:00:00'),(4,3,1,1,'0000-00-00 00:00:00'),(4,4,1,1,'0000-00-00 00:00:00'),(4,5,1,1,'0000-00-00 00:00:00'),(4,6,1,1,'0000-00-00 00:00:00'),(4,7,1,1,'0000-00-00 00:00:00'),(4,8,1,1,'0000-00-00 00:00:00'),(4,9,0,1,'0000-00-00 00:00:00'),(4,10,1,0,'0000-00-00 00:00:00'),(5,1,0,1,'0000-00-00 00:00:00'),(5,2,0,1,'0000-00-00 00:00:00'),(5,3,1,1,'0000-00-00 00:00:00'),(5,4,1,1,'0000-00-00 00:00:00'),(5,5,1,1,'0000-00-00 00:00:00'),(5,6,0,1,'0000-00-00 00:00:00'),(5,7,1,1,'0000-00-00 00:00:00'),(5,8,1,0,'0000-00-00 00:00:00'),(5,9,1,1,'0000-00-00 00:00:00'),(5,10,1,1,'0000-00-00 00:00:00'),(6,1,1,1,'0000-00-00 00:00:00'),(6,2,1,0,'0000-00-00 00:00:00'),(6,3,1,1,'0000-00-00 00:00:00'),(6,4,1,1,'0000-00-00 00:00:00'),(6,5,1,0,'0000-00-00 00:00:00'),(6,6,0,1,'0000-00-00 00:00:00'),(6,7,1,1,'0000-00-00 00:00:00'),(6,8,1,1,'0000-00-00 00:00:00'),(6,9,1,1,'0000-00-00 00:00:00'),(6,10,0,1,'0000-00-00 00:00:00'),(7,1,1,1,'0000-00-00 00:00:00'),(7,2,1,1,'0000-00-00 00:00:00'),(7,3,1,1,'0000-00-00 00:00:00'),(7,4,1,1,'0000-00-00 00:00:00'),(7,5,1,1,'0000-00-00 00:00:00'),(7,6,0,1,'0000-00-00 00:00:00'),(7,7,1,1,'0000-00-00 00:00:00'),(7,8,0,1,'0000-00-00 00:00:00'),(7,9,0,1,'0000-00-00 00:00:00'),(7,10,1,0,'0000-00-00 00:00:00'),(8,1,1,1,'0000-00-00 00:00:00'),(8,2,0,1,'0000-00-00 00:00:00'),(8,3,1,0,'0000-00-00 00:00:00'),(8,4,1,1,'0000-00-00 00:00:00'),(8,5,1,1,'0000-00-00 00:00:00'),(8,6,0,1,'0000-00-00 00:00:00'),(8,7,0,1,'0000-00-00 00:00:00'),(8,8,1,1,'0000-00-00 00:00:00'),(8,9,0,1,'0000-00-00 00:00:00'),(8,10,1,1,'0000-00-00 00:00:00'),(9,1,1,0,'0000-00-00 00:00:00'),(9,2,1,1,'0000-00-00 00:00:00'),(9,3,1,1,'0000-00-00 00:00:00'),(9,4,1,1,'0000-00-00 00:00:00'),(9,5,1,1,'0000-00-00 00:00:00'),(9,6,1,1,'0000-00-00 00:00:00'),(9,7,1,1,'0000-00-00 00:00:00'),(9,8,0,1,'0000-00-00 00:00:00'),(9,9,1,1,'0000-00-00 00:00:00'),(9,10,1,0,'0000-00-00 00:00:00'),(10,1,1,1,'0000-00-00 00:00:00'),(10,2,1,1,'0000-00-00 00:00:00'),(10,3,1,1,'0000-00-00 00:00:00'),(10,4,0,1,'0000-00-00 00:00:00'),(10,5,1,1,'0000-00-00 00:00:00'),(10,6,0,1,'0000-00-00 00:00:00'),(10,7,1,1,'0000-00-00 00:00:00'),(10,8,1,0,'0000-00-00 00:00:00'),(10,9,1,1,'0000-00-00 00:00:00'),(10,10,1,1,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `basketball_test_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bigQuestions`
--

DROP TABLE IF EXISTS `bigQuestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bigQuestions` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `hypothesis` mediumtext,
  `evidence` mediumtext,
  `vote` mediumtext,
  `submitted` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bigQuestions`
--

LOCK TABLES `bigQuestions` WRITE;
/*!40000 ALTER TABLE `bigQuestions` DISABLE KEYS */;
/*!40000 ALTER TABLE `bigQuestions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bodyChanger`
--

DROP TABLE IF EXISTS `bodyChanger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bodyChanger` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `nervous` mediumtext,
  `immune` mediumtext,
  `cardiovascular` mediumtext,
  `endocrine` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bigdata` mediumtext,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=562 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bodyChanger`
--

LOCK TABLES `bodyChanger` WRITE;
/*!40000 ALTER TABLE `bodyChanger` DISABLE KEYS */;
/*!40000 ALTER TABLE `bodyChanger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bottomLine`
--

DROP TABLE IF EXISTS `bottomLine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bottomLine` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `content` mediumtext,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bottomLine`
--

LOCK TABLES `bottomLine` WRITE;
/*!40000 ALTER TABLE `bottomLine` DISABLE KEYS */;
/*!40000 ALTER TABLE `bottomLine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_config`
--

DROP TABLE IF EXISTS `class_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `classId` int(11) NOT NULL,
  `lesson_num` int(2) NOT NULL,
  `activity_num` int(2) NOT NULL,
  `activity_type` varchar(45) DEFAULT 'normal',
  `activity_id` varchar(45) NOT NULL,
  `activity_db` varchar(45) DEFAULT NULL,
  `activity_title` mediumtext,
  `parent_id` varchar(45) NOT NULL,
  `group_feature` int(11) DEFAULT '0',
  `gradable` int(11) DEFAULT '0',
  `authenticate` varchar(45) DEFAULT 'teacher,student,parent',
  `actived` int(11) DEFAULT '1',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=782 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_config`
--

LOCK TABLES `class_config` WRITE;
/*!40000 ALTER TABLE `class_config` DISABLE KEYS */;
INSERT INTO `class_config` VALUES (253,50024,5,5,'normal','posters','','Putting Z-PIECES Together','lesson-menu',1,0,'teacher,student,parent',1),(63,50024,4,1,'normal','itdepends','','It Depends','lesson-menu',1,0,'teacher,student,parent',1),(68,50024,3,2,'normal','actogram-at-glance-slides','','Raulâ€™s Zzz','lesson-menu',0,0,'teacher,student,parent',1),(62,50024,3,4,'normal','predict-sleep-profile','','Z-Identity','lesson-menu',0,0,'teacher,student,parent',1),(64,50023,-2,2,'normal','fourcorner','fourthGradeFourCorner','What Do We think affected our Zzz?','lesson-menu',0,1,'teacher,student,parent',1),(65,50023,5,2,'normal','bottom-line','','ZZZ Bottom Line','lesson-menu',1,0,'teacher,student,parent',1),(66,50023,5,3,'normal','posters','','Putting ZZZ Pieces Together','lesson-menu',1,0,'teacher,student,parent',1),(67,50023,-2,1,'normal','big-question','','Zzz Big Questions','lesson-menu',1,1,'teacher,student,parent',1),(69,50024,5,4,'normal','bottom-line','','Z-Bottom Line','lesson-menu',1,0,'teacher,student,parent',1),(49,50024,5,2,'normal','ourzzz','','Class Z-Profile','lesson-menu',1,0,'teacher,student,parent',1),(48,50023,3,4,'normal','actogram-at-glance-slides','','ZZZ at a Glance','lesson-menu',0,0,'teacher,student,parent',1),(47,50023,4,3,'normal','ourzzz','','Our Zzz','lesson-menu',1,0,'teacher,student,parent',1),(46,50024,3,1,'normal','practice-diary-menu','','Collect your own Z-data','lesson-menu',0,0,'teacher,student,parent',1),(45,50024,5,3,'normal','analysis-project-g5','','What is Z significance?','lesson-menu',1,0,'teacher,student,parent',1),(41,50024,4,2,'normal','brain-games','','Brain Games','lesson-menu',1,0,'teacher,student,parent',1),(40,50024,2,3,'normal','body-changer','','Zzz are a Body Changer','lesson-menu',1,1,'teacher,student,parent',1),(39,50024,2,2,'normal','grade-changer','','Zzz are a Grade Changer','lesson-menu',1,1,'teacher,student,parent',1),(38,50024,2,1,'normal','basketball-test-player','','Zzz are a Game Changer','lesson-menu',1,1,'teacher,student,parent',1),(42,50024,-2,3,'link','https://classroom.google.com','','Lab Notebook (Google Classroom)','lesson-menu',1,1,'teacher,student,parent',1),(43,50024,5,1,'normal','my-sleep-data','','Z-Data Reveal','lesson-menu',1,0,'teacher,student,parent',1),(44,50024,4,3,'normal','big-question','','Z-Big Questions','lesson-menu',1,1,'teacher,student,parent',1),(33,50024,-2,2,'link','https://classroom.google.com','','Lab Notebook (Google Classroom)','lesson-menu',1,1,'teacher,student,parent',1),(32,50024,3,3,'normal','zprofile','','Zzz Profiles','lesson-menu',1,1,'teacher,student,parent',1),(31,50024,-2,1,'link','https://classroom.google.com','','Lab Notebook (Google Classroom)','lesson-menu',1,1,'teacher,student,parent',1),(30,50024,1,3,'normal','story-list','','Zzz in the News','lesson-menu',1,0,'teacher,student,parent',1),(29,50024,1,2,'normal','effect-card-test','','Z-Effects','lesson-menu',1,0,'teacher,student,parent',1),(28,50024,1,1,'normal','age-sleep-hour-test','','How many Zzz?','lesson-menu',1,0,'teacher,student,parent',1),(27,50024,0,0,'normal','fifth-grade-lesson-menu','','Who gets enough Zzz?&z&Do Zzz Matter?&z&Do the Zzz fit?&z&What are Z questions?&z&What are Z Answers?','main-page',0,0,'teacher,student,parent',1),(26,50023,3,2,'normal','fourcorner','fourthGradeFourCorner','What has the biggest effect on your sleep?','lesson-menu',1,0,'teacher,student,parent',1),(25,50023,5,1,'normal','analysis-project-g4','','What Affected our Zzz? ','lesson-menu',1,1,'teacher,student,parent',1),(24,50023,2,5,'normal','lidzzz','','I Lidzzz','lesson-menu',1,0,'teacher,student,parent',1),(23,50023,-2,3,'normal','comparingzzz','','Comparing ZZZ','lesson-menu',1,0,'teacher,student,parent',1),(22,50023,1,1,'normal','what-is-sleep','fourthGradeLessonOneWhatSleep','What is Sleep?','lesson-menu',0,1,'teacher,student,parent',1),(21,50023,-1,1,'assignment','interview-adult','fourthGradeLessonOneAdultInterview','Parent Interview','lesson-menu',1,1,'teacher,student,parent',1),(20,50023,1,2,'normal','do-animal-sleep','fourthGradeLessonDoAnimalSleep','Do all animals sleep?','lesson-menu',0,1,'teacher,student,parent',1),(19,50023,2,1,'normal','interview-adult','fourthGradeLessonOneAdultInterview','Adult ZZZ Interview','lesson-menu',0,0,'teacher,student',1),(18,50023,1,5,'normal','adult-pre-interview','fourthGradeLessonOnePreInterview','Adult ZZZ','lesson-menu',1,1,'teacher,student,parent',1),(16,50023,2,3,'normal','animal-card-retest','animal_card_retest','Animal re-ZZZ','lesson-menu',1,1,'teacher,student,parent',1),(15,50023,3,3,'normal','practice-diary-menu','','Collecting ZZZ data','lesson-menu',0,0,'teacher,student,parent',1),(14,50023,2,2,'normal','sleep-habits-of-animals','','ZZZ of Familiar Animals','lesson-menu',1,0,'teacher,student,parent',1),(13,50023,2,4,'normal','circadian-rhythm-tempery','','About a Day','lesson-menu',1,0,'teacher,student,parent',1),(12,50023,4,5,'portal','upload-my-actogram-result','','Upload Student Actograms','lesson-menu',0,0,'teacher',1),(10,50023,4,2,'normal','graph-my-zzz','','My ZZZ','lesson-menu',0,0,'teacher,student,parent',1),(11,50023,3,1,'normal','sleep-stories','fourth_grade_lesson_three_story','Purpose of Sleep','lesson-menu',0,1,'teacher,student,parent',1),(8,50023,3,5,'normal','estrella-actogram-draw','estrellaActogramDraw','Estrellaâ€™s Actogram','lesson-menu',1,1,'teacher,student,parent',1),(9,50023,-2,5,'normal','estrella-datahunt','fourthGradeLessonTwoEstrellaActogram','Estrellaâ€™s Sleep Data','lesson-menu',1,1,'teacher,student,parent',1),(7,50023,1,4,'normal','enough-sleep-vote','fourthGradeLessonOneSleepVote','Do People Get Enough Sleep?','lesson-menu',1,1,'teacher,student,parent',1),(6,50023,-2,6,'normal','why-do-we-sleep','fourthGradeLessonOneWhySleep','Why do We Sleep?','lesson-menu',1,1,'teacher,student,parent',1),(5,50023,1,3,'normal','animal-card-test','animal_card_test_answers_table','Animal ZZZ','lesson-menu',1,1,'teacher,student,parent',1),(4,50023,4,4,'portal','teacher-aggregate-table','','Aggregate Class Data Table','lesson-menu',0,0,'teacher',1),(3,50023,4,1,'normal','roomEnvironment','','Make Room for Zzz','fourth-grade-lesson-menu',0,0,'teacher,student,parent',1),(2,50023,0,0,'normal','fourth-grade-lesson-menu','','Who needs sleep?&z&How Much Sleep?&z&Why Sleep?&z&What\'s best for sleep?&z&How does our sleep compare?','main-page',0,0,'teacher,student,parent',1),(1,50023,-2,4,'normal','sleep-environment','sleepEnvironment','Sleep Environment','fourth-grade-lesson-menu',1,1,'teacher,student,parent',1);
/*!40000 ALTER TABLE `class_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_info_table`
--

DROP TABLE IF EXISTS `class_info_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_info_table` (
  `classId` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(50) DEFAULT NULL,
  `grade` int(11) NOT NULL,
  `semester` varchar(2) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `initialActiveDate` varchar(15) DEFAULT NULL,
  `schoolName` varchar(30) DEFAULT NULL,
  `schoolNum` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `reminder` int(11) DEFAULT NULL,
  `diaryComputation` tinyint(1) DEFAULT '0',
  `EstrellaDataHuntBar` tinyint(1) NOT NULL DEFAULT '0',
  `Lesson_1` tinyint(1) NOT NULL DEFAULT '0',
  `Lesson_2` tinyint(1) NOT NULL DEFAULT '0',
  `Lesson_3` tinyint(1) NOT NULL DEFAULT '0',
  `Lesson_4` tinyint(1) NOT NULL DEFAULT '0',
  `Lesson_5` tinyint(1) NOT NULL DEFAULT '0',
  `player1` int(11) NOT NULL DEFAULT '0',
  `player2` int(11) NOT NULL DEFAULT '0',
  `player3` int(11) NOT NULL DEFAULT '0',
  `player4` int(11) NOT NULL DEFAULT '0',
  `player5` int(11) NOT NULL DEFAULT '0',
  `player6` int(11) NOT NULL DEFAULT '0',
  `player7` int(11) NOT NULL DEFAULT '0',
  `player8` int(11) NOT NULL DEFAULT '0',
  `player9` int(11) NOT NULL DEFAULT '0',
  `player10` int(11) NOT NULL DEFAULT '0',
  `createAndChangeTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`classId`)
) ENGINE=MyISAM AUTO_INCREMENT=50067 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_info_table`
--

LOCK TABLES `class_info_table` WRITE;
/*!40000 ALTER TABLE `class_info_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_info_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_table`
--

DROP TABLE IF EXISTS `class_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_table` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `classId` int(11) NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=587 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_table`
--

LOCK TABLES `class_table` WRITE;
/*!40000 ALTER TABLE `class_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_tracking_table`
--

DROP TABLE IF EXISTS `class_tracking_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_tracking_table` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `classId` int(11) NOT NULL,
  `initialEnrollDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=484 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_tracking_table`
--

LOCK TABLES `class_tracking_table` WRITE;
/*!40000 ALTER TABLE `class_tracking_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_tracking_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_header_table`
--

DROP TABLE IF EXISTS `data_header_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_header_table` (
  `dataHeaderId` int(11) NOT NULL AUTO_INCREMENT,
  `contents` longtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dataHeaderId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_header_table`
--

LOCK TABLES `data_header_table` WRITE;
/*!40000 ALTER TABLE `data_header_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_header_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dependCardGame`
--

DROP TABLE IF EXISTS `dependCardGame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dependCardGame` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `beginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rounds` int(11) DEFAULT NULL,
  `newDVpool` mediumtext,
  `usedDVpool` mediumtext,
  `iv1` mediumtext,
  `iv2` mediumtext,
  `iv3` mediumtext,
  `iv4` mediumtext,
  `pair1` mediumtext,
  `pair2` mediumtext,
  `pair3` mediumtext,
  `pair4` mediumtext,
  `pairedDV` mediumtext,
  `winner` int(11) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dependCardGame`
--

LOCK TABLES `dependCardGame` WRITE;
/*!40000 ALTER TABLE `dependCardGame` DISABLE KEYS */;
/*!40000 ALTER TABLE `dependCardGame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diary_data_table`
--

DROP TABLE IF EXISTS `diary_data_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diary_data_table` (
  `diaryId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `diaryGrade` int(11) DEFAULT NULL,
  `diaryDate` date DEFAULT NULL,
  `submissionDeadline` datetime DEFAULT NULL,
  `alertSent` int(11) DEFAULT '0',
  `timeCompleted` datetime DEFAULT NULL,
  `wakeUpWay` int(11) DEFAULT NULL,
  `parentSetBedTime` tinyint(1) DEFAULT NULL,
  `timeToBed` time DEFAULT NULL,
  `timeWakeup` time DEFAULT NULL,
  `numWokeup` int(11) DEFAULT NULL,
  `minFallAsleep` int(11) DEFAULT NULL,
  `medTaken` tinyint(1) DEFAULT NULL,
  `timeFellAsleep` time DEFAULT NULL,
  `timeLightsOff` time DEFAULT NULL,
  `timeElectronicsOff` time DEFAULT NULL,
  `timeOutOfBed` time DEFAULT NULL,
  `minWokeup` int(11) DEFAULT NULL,
  `disturbedByNoise` tinyint(1) DEFAULT NULL,
  `disturbedBypets` tinyint(1) DEFAULT NULL,
  `disturbedByElectronics` tinyint(1) DEFAULT NULL,
  `disturbedByFamily` tinyint(1) DEFAULT NULL,
  `disturbedByDream` tinyint(1) DEFAULT NULL,
  `disturbedByBathroomNeed` tinyint(1) DEFAULT NULL,
  `disturbedByTemperature` tinyint(1) DEFAULT NULL,
  `disturbedByIllness` tinyint(1) DEFAULT NULL,
  `disturbedByBodilyPain` tinyint(1) DEFAULT NULL,
  `disturbedByWorries` tinyint(1) DEFAULT NULL,
  `disturbedByBusyMinds` tinyint(1) DEFAULT NULL,
  `disturbedByLighting` tinyint(1) DEFAULT NULL,
  `disturbedByUnknown` tinyint(1) DEFAULT NULL,
  `disturbedByNothing` tinyint(1) DEFAULT NULL,
  `disturbedByOther` tinyint(1) DEFAULT NULL,
  `disturbedByOtherContent` longtext,
  `hourSlept` float DEFAULT NULL,
  `hourSleptStudentCompute` float DEFAULT NULL,
  `actBefSleepTV` tinyint(1) DEFAULT NULL,
  `actBefSleepMusic` tinyint(1) DEFAULT NULL,
  `actBefSleepVideoGame` tinyint(1) DEFAULT NULL,
  `actBefSleepComp` tinyint(1) DEFAULT NULL,
  `actBefSleepRead` tinyint(1) DEFAULT NULL,
  `actBefSleepHomework` tinyint(1) DEFAULT NULL,
  `actBefSleepShower` tinyint(1) DEFAULT NULL,
  `actBefSleepPlayWithPeople` tinyint(1) DEFAULT NULL,
  `actBefSleepSnack` tinyint(1) DEFAULT NULL,
  `actBefSleepText` tinyint(1) DEFAULT NULL,
  `actBefSleepPhone` tinyint(1) DEFAULT NULL,
  `actBefSleepDrinkCaff` tinyint(1) DEFAULT NULL,
  `actBefSleepExercise` tinyint(1) DEFAULT NULL,
  `actBefSleepMeal` tinyint(1) DEFAULT NULL,
  `actBefSleepOther` tinyint(1) DEFAULT NULL,
  `actBefSleepOtherContent` longtext,
  `wokeupState` enum('refreshed','lessRefreshed','tired') DEFAULT NULL,
  `sleepQuality` enum('veryRestless','restless','average','sound','verySound') DEFAULT NULL,
  `sleepCompare` enum('worse','same','better') DEFAULT NULL,
  `roomDarkness` int(11) DEFAULT NULL,
  `roomQuietness` int(11) DEFAULT NULL,
  `roomWarmness` int(11) DEFAULT NULL,
  `practice` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`diaryId`)
) ENGINE=MyISAM AUTO_INCREMENT=137896 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diary_data_table`
--

LOCK TABLES `diary_data_table` WRITE;
/*!40000 ALTER TABLE `diary_data_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `diary_data_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `effect_card_test_table`
--

DROP TABLE IF EXISTS `effect_card_test_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `effect_card_test_table` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `tag` int(11) DEFAULT NULL,
  `preSchoolPos` longtext,
  `preSchoolNeg` longtext,
  `schoolAgePos` longtext,
  `schoolAgeNeg` longtext,
  `adultPos` longtext,
  `adultNeg` longtext,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=754 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `effect_card_test_table`
--

LOCK TABLES `effect_card_test_table` WRITE;
/*!40000 ALTER TABLE `effect_card_test_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `effect_card_test_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estrellaActogramDraw`
--

DROP TABLE IF EXISTS `estrellaActogramDraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estrellaActogramDraw` (
  `recordRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `dataHunt` longblob,
  `gradedHunt` longblob,
  `comment` mediumtext,
  `score` int(2) DEFAULT '0',
  `contributors` mediumtext,
  `classId` int(11) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `submit` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`recordRow`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estrellaActogramDraw`
--

LOCK TABLES `estrellaActogramDraw` WRITE;
/*!40000 ALTER TABLE `estrellaActogramDraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `estrellaActogramDraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fifthGradeLessonOneStorySummary`
--

DROP TABLE IF EXISTS `fifthGradeLessonOneStorySummary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fifthGradeLessonOneStorySummary` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `summary` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fifthGradeLessonOneStorySummary`
--

LOCK TABLES `fifthGradeLessonOneStorySummary` WRITE;
/*!40000 ALTER TABLE `fifthGradeLessonOneStorySummary` DISABLE KEYS */;
/*!40000 ALTER TABLE `fifthGradeLessonOneStorySummary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fifthGradeLessonOneWorksheet`
--

DROP TABLE IF EXISTS `fifthGradeLessonOneWorksheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fifthGradeLessonOneWorksheet` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `story` int(11) DEFAULT '0',
  `Q1` longtext,
  `Q2` longtext,
  `Q3` longtext,
  `Q4` longtext,
  `Q5` longtext,
  `Q6` longtext,
  `Q7` longtext,
  `Q8` longtext,
  `groupMember` mediumtext,
  `happen` longtext,
  `factor` longtext,
  `affect` longtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isSubmitted` tinyint(1) DEFAULT NULL,
  `contributors` mediumtext,
  `classId` int(11) DEFAULT NULL,
  `comment` mediumtext,
  `score` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fifthGradeLessonOneWorksheet`
--

LOCK TABLES `fifthGradeLessonOneWorksheet` WRITE;
/*!40000 ALTER TABLE `fifthGradeLessonOneWorksheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `fifthGradeLessonOneWorksheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fifthGradeLessonThreeTakeHome`
--

DROP TABLE IF EXISTS `fifthGradeLessonThreeTakeHome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fifthGradeLessonThreeTakeHome` (
  `record` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `score` float DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`record`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fifthGradeLessonThreeTakeHome`
--

LOCK TABLES `fifthGradeLessonThreeTakeHome` WRITE;
/*!40000 ALTER TABLE `fifthGradeLessonThreeTakeHome` DISABLE KEYS */;
/*!40000 ALTER TABLE `fifthGradeLessonThreeTakeHome` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fifthGradeLessonTwoProfile`
--

DROP TABLE IF EXISTS `fifthGradeLessonTwoProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fifthGradeLessonTwoProfile` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `response` longtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `revisionResponse` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=392 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fifthGradeLessonTwoProfile`
--

LOCK TABLES `fifthGradeLessonTwoProfile` WRITE;
/*!40000 ALTER TABLE `fifthGradeLessonTwoProfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `fifthGradeLessonTwoProfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourth_grade_lesson_three_story`
--

DROP TABLE IF EXISTS `fourth_grade_lesson_three_story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourth_grade_lesson_three_story` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `highlightWord` longtext,
  `storyNotes` longtext,
  `storyId` int(11) DEFAULT NULL,
  `highlightWordSpanName` longtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=283 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourth_grade_lesson_three_story`
--

LOCK TABLES `fourth_grade_lesson_three_story` WRITE;
/*!40000 ALTER TABLE `fourth_grade_lesson_three_story` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourth_grade_lesson_three_story` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeComparingzzz`
--

DROP TABLE IF EXISTS `fourthGradeComparingzzz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeComparingzzz` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT NULL,
  `userId` int(11) DEFAULT '1',
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `answer1` varchar(45) DEFAULT NULL,
  `answer2` varchar(45) DEFAULT NULL,
  `answer3` varchar(45) DEFAULT NULL,
  `answer4` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeComparingzzz`
--

LOCK TABLES `fourthGradeComparingzzz` WRITE;
/*!40000 ALTER TABLE `fourthGradeComparingzzz` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeComparingzzz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeFourCorner`
--

DROP TABLE IF EXISTS `fourthGradeFourCorner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeFourCorner` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT NULL,
  `userId` int(11) DEFAULT '1',
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `answer1` varchar(45) DEFAULT NULL,
  `answer2` varchar(45) DEFAULT NULL,
  `answer3` varchar(45) DEFAULT NULL,
  `corner` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeFourCorner`
--

LOCK TABLES `fourthGradeFourCorner` WRITE;
/*!40000 ALTER TABLE `fourthGradeFourCorner` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeFourCorner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonDoAnimalSleep`
--

DROP TABLE IF EXISTS `fourthGradeLessonDoAnimalSleep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonDoAnimalSleep` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT NULL,
  `userId` int(11) DEFAULT '1',
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `response` longtext,
  `agree` int(2) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonDoAnimalSleep`
--

LOCK TABLES `fourthGradeLessonDoAnimalSleep` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonDoAnimalSleep` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonDoAnimalSleep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOneAdultInterview`
--

DROP TABLE IF EXISTS `fourthGradeLessonOneAdultInterview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOneAdultInterview` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `interviewSubject` varchar(255) DEFAULT NULL,
  `otherSubject` varchar(255) DEFAULT NULL,
  `A1` varchar(255) DEFAULT NULL,
  `A1Exp` longtext,
  `A2` longtext,
  `A3` longtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Q4` longtext,
  `A4` longtext,
  `Q5` longtext,
  `A5` longtext,
  `Q6` longtext,
  `A6` longtext,
  `Q7` longtext,
  `A7` longtext,
  `Q8` longtext,
  `A8` longtext,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOneAdultInterview`
--

LOCK TABLES `fourthGradeLessonOneAdultInterview` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOneAdultInterview` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOneAdultInterview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOneAdultInterviewQuestions`
--

DROP TABLE IF EXISTS `fourthGradeLessonOneAdultInterviewQuestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOneAdultInterviewQuestions` (
  `userId` int(11) NOT NULL,
  `interviewId` int(11) DEFAULT NULL,
  `Q4` longtext,
  `Q5` longtext,
  `Q6` longtext,
  `Q7` longtext,
  `Q8` longtext,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOneAdultInterviewQuestions`
--

LOCK TABLES `fourthGradeLessonOneAdultInterviewQuestions` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOneAdultInterviewQuestions` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOneAdultInterviewQuestions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOneInterview`
--

DROP TABLE IF EXISTS `fourthGradeLessonOneInterview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOneInterview` (
  `uniqueId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `Q1` varchar(255) DEFAULT NULL,
  `Q2` varchar(255) DEFAULT NULL,
  `Q3` varchar(255) DEFAULT NULL,
  `Q3Response` longtext,
  `Q4` longtext,
  `Q5` longtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isSubmitted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`uniqueId`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOneInterview`
--

LOCK TABLES `fourthGradeLessonOneInterview` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOneInterview` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOneInterview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOneInterviewQuestions`
--

DROP TABLE IF EXISTS `fourthGradeLessonOneInterviewQuestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOneInterviewQuestions` (
  `uniqueId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `question` longtext,
  `response` longtext,
  `interviewId` int(11) DEFAULT NULL,
  PRIMARY KEY (`uniqueId`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOneInterviewQuestions`
--

LOCK TABLES `fourthGradeLessonOneInterviewQuestions` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOneInterviewQuestions` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOneInterviewQuestions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOnePreInterview`
--

DROP TABLE IF EXISTS `fourthGradeLessonOnePreInterview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOnePreInterview` (
  `userId` int(11) NOT NULL,
  `interviewSubject` varchar(255) DEFAULT NULL,
  `interviewSubjectOther` varchar(255) DEFAULT NULL,
  `subjectResponse` int(11) DEFAULT NULL,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOnePreInterview`
--

LOCK TABLES `fourthGradeLessonOnePreInterview` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOnePreInterview` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOnePreInterview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOneSleepVote`
--

DROP TABLE IF EXISTS `fourthGradeLessonOneSleepVote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOneSleepVote` (
  `userId` int(11) NOT NULL,
  `vote` int(11) DEFAULT NULL,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `submit` tinyint(1) DEFAULT '1',
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOneSleepVote`
--

LOCK TABLES `fourthGradeLessonOneSleepVote` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOneSleepVote` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOneSleepVote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOneWhatSleep`
--

DROP TABLE IF EXISTS `fourthGradeLessonOneWhatSleep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOneWhatSleep` (
  `userId` int(11) NOT NULL,
  `response` longtext,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT '1',
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `agree` mediumtext,
  `disagree` mediumtext,
  `notSure` mediumtext,
  PRIMARY KEY (`resultRow`,`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOneWhatSleep`
--

LOCK TABLES `fourthGradeLessonOneWhatSleep` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOneWhatSleep` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOneWhatSleep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonOneWhySleep`
--

DROP TABLE IF EXISTS `fourthGradeLessonOneWhySleep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonOneWhySleep` (
  `userId` int(11) NOT NULL,
  `response` longtext,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT '1',
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `agree` mediumtext,
  `disagree` mediumtext,
  `notSure` mediumtext,
  PRIMARY KEY (`resultRow`,`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonOneWhySleep`
--

LOCK TABLES `fourthGradeLessonOneWhySleep` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonOneWhySleep` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonOneWhySleep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonThreeTableOne`
--

DROP TABLE IF EXISTS `fourthGradeLessonThreeTableOne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonThreeTableOne` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `userType` enum('teacher','student') DEFAULT NULL,
  `facilitatorAnswers` mediumtext,
  `competitorAnswers` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonThreeTableOne`
--

LOCK TABLES `fourthGradeLessonThreeTableOne` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonThreeTableOne` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonThreeTableOne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonThreeTableThree`
--

DROP TABLE IF EXISTS `fourthGradeLessonThreeTableThree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonThreeTableThree` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `familyRoutinesHardChange` mediumtext,
  `familyRoutinesEasyChange` mediumtext,
  `activitiesHardChange` mediumtext,
  `activitiesEasyChange` mediumtext,
  `environmentHardChange` mediumtext,
  `environmentEasyChange` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonThreeTableThree`
--

LOCK TABLES `fourthGradeLessonThreeTableThree` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonThreeTableThree` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonThreeTableThree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonThreeTableTwo`
--

DROP TABLE IF EXISTS `fourthGradeLessonThreeTableTwo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonThreeTableTwo` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `familyRoutines` mediumtext,
  `activities` mediumtext,
  `environment` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonThreeTableTwo`
--

LOCK TABLES `fourthGradeLessonThreeTableTwo` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonThreeTableTwo` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonThreeTableTwo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonTwoEstrellaActogram`
--

DROP TABLE IF EXISTS `fourthGradeLessonTwoEstrellaActogram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonTwoEstrellaActogram` (
  `recordRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `dataHunt` longblob,
  `D1` int(3) DEFAULT NULL,
  `D2` int(3) DEFAULT NULL,
  `D3` int(3) DEFAULT NULL,
  `D4` int(3) DEFAULT NULL,
  `D5` int(3) DEFAULT NULL,
  `D6` int(3) DEFAULT NULL,
  `DS` int(11) DEFAULT NULL,
  `S1` int(11) DEFAULT NULL,
  `S2` int(11) DEFAULT NULL,
  `S3` int(11) DEFAULT NULL,
  `S4` int(11) DEFAULT NULL,
  `S5` int(11) DEFAULT NULL,
  `S6` int(11) DEFAULT NULL,
  `SS` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT '1',
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  PRIMARY KEY (`recordRow`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonTwoEstrellaActogram`
--

LOCK TABLES `fourthGradeLessonTwoEstrellaActogram` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonTwoEstrellaActogram` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonTwoEstrellaActogram` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fourthGradeLessonTwoMySleepDataHunt`
--

DROP TABLE IF EXISTS `fourthGradeLessonTwoMySleepDataHunt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fourthGradeLessonTwoMySleepDataHunt` (
  `recordRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `dataHunt` longblob,
  `D1` int(11) DEFAULT NULL,
  `D2` int(11) DEFAULT NULL,
  `D3` int(11) DEFAULT NULL,
  `D4` int(11) DEFAULT NULL,
  `D5` int(11) DEFAULT NULL,
  `D6` int(11) DEFAULT NULL,
  `DS` int(11) DEFAULT NULL,
  `S1` int(11) DEFAULT NULL,
  `S2` int(11) DEFAULT NULL,
  `S3` int(11) DEFAULT NULL,
  `S4` int(11) DEFAULT NULL,
  `S5` int(11) DEFAULT NULL,
  `S6` int(11) DEFAULT NULL,
  `SS` int(11) DEFAULT NULL,
  PRIMARY KEY (`recordRow`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fourthGradeLessonTwoMySleepDataHunt`
--

LOCK TABLES `fourthGradeLessonTwoMySleepDataHunt` WRITE;
/*!40000 ALTER TABLE `fourthGradeLessonTwoMySleepDataHunt` DISABLE KEYS */;
/*!40000 ALTER TABLE `fourthGradeLessonTwoMySleepDataHunt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gameChanger`
--

DROP TABLE IF EXISTS `gameChanger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gameChanger` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `hypothesis` varchar(20) DEFAULT NULL,
  `player` int(11) DEFAULT NULL,
  `improvement` varchar(4) DEFAULT NULL,
  `support` varchar(4) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `gameChanger` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gameChanger`
--

LOCK TABLES `gameChanger` WRITE;
/*!40000 ALTER TABLE `gameChanger` DISABLE KEYS */;
/*!40000 ALTER TABLE `gameChanger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gradeChanger`
--

DROP TABLE IF EXISTS `gradeChanger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gradeChanger` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `userId` varchar(30) NOT NULL,
  `hypothesis` varchar(30) NOT NULL,
  `hypothesizedValueB` int(3) NOT NULL,
  `hypothesizedValueCD` int(3) NOT NULL,
  `hypothesisSupported` varchar(30) NOT NULL,
  `hypothesisBenefit` varchar(30) NOT NULL,
  `conclusionsCalcOne` varchar(30) NOT NULL,
  `conclusionsCalcTwo` varchar(30) NOT NULL,
  `conclusionsCalcThree` varchar(30) NOT NULL,
  `conclusionsCalcFour` varchar(30) NOT NULL,
  `conclusionsCalcFive` varchar(30) NOT NULL,
  `conclusionsCalcSix` varchar(30) NOT NULL,
  `conclusionsDiffGreatest` varchar(30) NOT NULL,
  `conclusionsDiffLeast` varchar(30) NOT NULL,
  `responseOne` longtext NOT NULL,
  `responseTwo` longtext NOT NULL,
  `responseThree` longtext NOT NULL,
  `isSubmitted` int(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hypothesisB` varchar(45) DEFAULT NULL,
  `hypothesisD` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gradeChanger`
--

LOCK TABLES `gradeChanger` WRITE;
/*!40000 ALTER TABLE `gradeChanger` DISABLE KEYS */;
/*!40000 ALTER TABLE `gradeChanger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identificationTaskResults`
--

DROP TABLE IF EXISTS `identificationTaskResults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `identificationTaskResults` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `userId` int(6) NOT NULL,
  `turn` int(11) DEFAULT NULL,
  `suit` varchar(255) DEFAULT NULL,
  `card` varchar(255) DEFAULT NULL,
  `response` varchar(255) DEFAULT NULL,
  `time` int(4) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9452 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identificationTaskResults`
--

LOCK TABLES `identificationTaskResults` WRITE;
/*!40000 ALTER TABLE `identificationTaskResults` DISABLE KEYS */;
/*!40000 ALTER TABLE `identificationTaskResults` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lidzzz`
--

DROP TABLE IF EXISTS `lidzzz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lidzzz` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT NULL,
  `userId` int(11) DEFAULT '1',
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `sleepiness1` int(11) DEFAULT NULL,
  `sleepiness2` int(11) DEFAULT NULL,
  `sleepiness3` int(11) DEFAULT NULL,
  `sleepiness4` int(11) DEFAULT NULL,
  `sleepiness5` int(11) DEFAULT NULL,
  `alertness1` int(11) DEFAULT NULL,
  `alertness2` int(11) DEFAULT NULL,
  `alertness3` int(11) DEFAULT NULL,
  `alertness4` int(11) DEFAULT NULL,
  `alertness5` int(11) DEFAULT NULL,
  `selectedPattern` int(2) DEFAULT NULL,
  `reasons` mediumtext,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lidzzz`
--

LOCK TABLES `lidzzz` WRITE;
/*!40000 ALTER TABLE `lidzzz` DISABLE KEYS */;
/*!40000 ALTER TABLE `lidzzz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memoryTaskResults`
--

DROP TABLE IF EXISTS `memoryTaskResults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memoryTaskResults` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `userId` int(6) NOT NULL,
  `turn` int(11) DEFAULT NULL,
  `trialNum` int(6) DEFAULT NULL,
  `trialType` varchar(255) DEFAULT NULL,
  `response` varchar(255) DEFAULT NULL,
  `time` int(4) DEFAULT NULL,
  `letterShown` varchar(255) DEFAULT NULL,
  `letterTwoBack` varchar(255) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5762 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memoryTaskResults`
--

LOCK TABLES `memoryTaskResults` WRITE;
/*!40000 ALTER TABLE `memoryTaskResults` DISABLE KEYS */;
/*!40000 ALTER TABLE `memoryTaskResults` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `my_actogram`
--

DROP TABLE IF EXISTS `my_actogram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_actogram` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `imgSrc` longblob,
  `myActogramNote` longblob,
  `startDate` longtext,
  `startDay` longtext,
  `endDate` longtext,
  `endDay` longtext,
  `bedTime` longtext,
  `getUpTime` longtext,
  `timeInBed` longtext,
  `totalSleepTime` longtext,
  `timeItTookToFallAsleep` longtext,
  `averageSleepQuality` longtext,
  `numberOfAwak` longtext,
  `awakeTime` longtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=413 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_actogram`
--

LOCK TABLES `my_actogram` WRITE;
/*!40000 ALTER TABLE `my_actogram` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_actogram` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mySleepData`
--

DROP TABLE IF EXISTS `mySleepData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mySleepData` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `D1` int(11) DEFAULT NULL,
  `D2` int(11) DEFAULT NULL,
  `D3` int(11) DEFAULT NULL,
  `D4` int(11) DEFAULT NULL,
  `D5` int(11) DEFAULT NULL,
  `D6` int(11) DEFAULT NULL,
  `DS` int(11) DEFAULT NULL,
  `W1` int(11) DEFAULT NULL,
  `W2` int(11) DEFAULT NULL,
  `W3` int(11) DEFAULT NULL,
  `W4` int(11) DEFAULT NULL,
  `W5` int(11) DEFAULT NULL,
  `W6` int(11) DEFAULT NULL,
  `A1` varchar(45) DEFAULT NULL,
  `A2` varchar(45) DEFAULT NULL,
  `A3` varchar(45) DEFAULT NULL,
  `A4` varchar(45) DEFAULT NULL,
  `A5` varchar(45) DEFAULT NULL,
  `A6` varchar(45) DEFAULT NULL,
  `watch1` varchar(45) DEFAULT NULL,
  `watch2` varchar(45) DEFAULT NULL,
  `watch3` varchar(45) DEFAULT NULL,
  `diary1` varchar(45) DEFAULT NULL,
  `diary2` varchar(45) DEFAULT NULL,
  `diary3` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mySleepData`
--

LOCK TABLES `mySleepData` WRITE;
/*!40000 ALTER TABLE `mySleepData` DISABLE KEYS */;
/*!40000 ALTER TABLE `mySleepData` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ourzzz`
--

DROP TABLE IF EXISTS `ourzzz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ourzzz` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `durationCount` mediumtext,
  `durationDescript` mediumtext,
  `consistencyCount` mediumtext,
  `consistencyDescript` mediumtext,
  `qualityCount` mediumtext,
  `qualityDescript` mediumtext,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ourzzz`
--

LOCK TABLES `ourzzz` WRITE;
/*!40000 ALTER TABLE `ourzzz` DISABLE KEYS */;
/*!40000 ALTER TABLE `ourzzz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ourzzzdata`
--

DROP TABLE IF EXISTS `ourzzzdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ourzzzdata` (
  `classId` int(11) NOT NULL,
  `duration` mediumtext,
  `durationRange` mediumtext,
  `durationTitle` mediumtext,
  `consistency` mediumtext,
  `consistencyRange` mediumtext,
  `consistencyTitle` mediumtext,
  `quality` mediumtext,
  `qualityRange` mediumtext,
  `qualityTitle` mediumtext,
  `wakeUpState` mediumtext,
  `wakeUpStateRange` mediumtext,
  `wakeupTitle` mediumtext,
  `awakeTitle` mediumtext,
  `awakening` mediumtext,
  `awakeRange` mediumtext,
  PRIMARY KEY (`classId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ourzzzdata`
--

LOCK TABLES `ourzzzdata` WRITE;
/*!40000 ALTER TABLE `ourzzzdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `ourzzzdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_feedback`
--

DROP TABLE IF EXISTS `parent_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_feedback` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `childrenFirstName` varchar(50) DEFAULT NULL,
  `childrenLastName` varchar(50) DEFAULT NULL,
  `relationship` varchar(20) DEFAULT NULL,
  `emailAddress` varchar(254) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `contactMethod` varchar(7) DEFAULT NULL,
  `quetionType` tinytext,
  `feedback` mediumtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_feedback`
--

LOCK TABLES `parent_feedback` WRITE;
/*!40000 ALTER TABLE `parent_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `parent_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practice_activity_diary_data_table`
--

DROP TABLE IF EXISTS `practice_activity_diary_data_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practice_activity_diary_data_table` (
  `diaryId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `diaryGrade` int(11) DEFAULT NULL,
  `diaryDate` date DEFAULT NULL,
  `submissionDeadline` datetime DEFAULT NULL,
  `alertSent` int(11) DEFAULT '0',
  `timeCompleted` datetime DEFAULT NULL,
  `interaction` enum('excellent','good','somewhatDifficult','challenging') DEFAULT NULL,
  `behavior` enum('excellent','good','somewhatDifficult','challenging') DEFAULT NULL,
  `attention` enum('never','little','sometimes','mostly','always') DEFAULT NULL,
  `symptomOtherContent` mediumtext,
  `symptomOther` tinyint(1) DEFAULT NULL,
  `symptomUnknown` tinyint(1) DEFAULT NULL,
  `symptomStomach` tinyint(1) DEFAULT NULL,
  `symptomBodyAches` tinyint(1) DEFAULT NULL,
  `symptomCoughing` tinyint(1) DEFAULT NULL,
  `symptomSneezing` tinyint(1) DEFAULT NULL,
  `symptomFever` tinyint(1) DEFAULT NULL,
  `symptomHeadache` tinyint(1) DEFAULT NULL,
  `symptomItchyEyes` tinyint(1) DEFAULT NULL,
  `symptomStuffyNose` tinyint(1) DEFAULT NULL,
  `symptomSoreThroat` tinyint(1) DEFAULT NULL,
  `symptomRunnyNose` tinyint(1) DEFAULT NULL,
  `minTechnology` int(11) DEFAULT NULL,
  `minComputer` int(11) DEFAULT NULL,
  `minVideoGame` int(11) DEFAULT NULL,
  `napStart` time DEFAULT NULL,
  `napEnd` time DEFAULT NULL,
  `minExercised` int(11) DEFAULT NULL,
  `numCaffeinatedDrinks` int(11) DEFAULT NULL,
  `feltDuringDay` enum('veryPleasant','pleasant','sometimesPleasant','unpleasant','veryUnpleasant') DEFAULT NULL,
  `howSleepy` enum('not','somewhat','sleepy','very') DEFAULT NULL,
  `howAttentive` enum('very','mostly','not') DEFAULT NULL,
  `practice` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`diaryId`)
) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practice_activity_diary_data_table`
--

LOCK TABLES `practice_activity_diary_data_table` WRITE;
/*!40000 ALTER TABLE `practice_activity_diary_data_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `practice_activity_diary_data_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practice_diary_data_table`
--

DROP TABLE IF EXISTS `practice_diary_data_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practice_diary_data_table` (
  `diaryId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `diaryGrade` int(11) DEFAULT NULL,
  `diaryDate` date DEFAULT NULL,
  `submissionDeadline` datetime DEFAULT NULL,
  `alertSent` int(11) DEFAULT '0',
  `timeCompleted` datetime DEFAULT NULL,
  `wakeUpWay` int(11) DEFAULT NULL,
  `parentSetBedTime` tinyint(1) DEFAULT NULL,
  `timeToBed` time DEFAULT NULL,
  `timeWakeup` time DEFAULT NULL,
  `numWokeup` int(11) DEFAULT NULL,
  `minFallAsleep` int(11) DEFAULT NULL,
  `medTaken` tinyint(1) DEFAULT NULL,
  `timeFellAsleep` time DEFAULT NULL,
  `timeLightsOff` time DEFAULT NULL,
  `timeElectronicsOff` time DEFAULT NULL,
  `timeOutOfBed` time DEFAULT NULL,
  `minWokeup` int(11) DEFAULT NULL,
  `disturbedByNoise` tinyint(1) DEFAULT NULL,
  `disturbedBypets` tinyint(1) DEFAULT NULL,
  `disturbedByElectronics` tinyint(1) DEFAULT NULL,
  `disturbedByFamily` tinyint(1) DEFAULT NULL,
  `disturbedByDream` tinyint(1) DEFAULT NULL,
  `disturbedByBathroomNeed` tinyint(1) DEFAULT NULL,
  `disturbedByTemperature` tinyint(1) DEFAULT NULL,
  `disturbedByIllness` tinyint(1) DEFAULT NULL,
  `disturbedByBodilyPain` tinyint(1) DEFAULT NULL,
  `disturbedByWorries` tinyint(1) DEFAULT NULL,
  `disturbedByBusyMinds` tinyint(1) DEFAULT NULL,
  `disturbedByLighting` tinyint(1) DEFAULT NULL,
  `disturbedByUnknown` tinyint(1) DEFAULT NULL,
  `disturbedByNothing` tinyint(1) DEFAULT NULL,
  `disturbedByOther` tinyint(1) DEFAULT NULL,
  `disturbedByOtherContent` longtext,
  `hourSlept` float DEFAULT NULL,
  `hourSleptStudentCompute` float DEFAULT NULL,
  `actBefSleepTV` tinyint(1) DEFAULT NULL,
  `actBefSleepMusic` tinyint(1) DEFAULT NULL,
  `actBefSleepVideoGame` tinyint(1) DEFAULT NULL,
  `actBefSleepComp` tinyint(1) DEFAULT NULL,
  `actBefSleepRead` tinyint(1) DEFAULT NULL,
  `actBefSleepHomework` tinyint(1) DEFAULT NULL,
  `actBefSleepShower` tinyint(1) DEFAULT NULL,
  `actBefSleepPlayWithPeople` tinyint(1) DEFAULT NULL,
  `actBefSleepSnack` tinyint(1) DEFAULT NULL,
  `actBefSleepText` tinyint(1) DEFAULT NULL,
  `actBefSleepPhone` tinyint(1) DEFAULT NULL,
  `actBefSleepDrinkCaff` tinyint(1) DEFAULT NULL,
  `actBefSleepExercise` tinyint(1) DEFAULT NULL,
  `actBefSleepMeal` tinyint(1) DEFAULT NULL,
  `actBefSleepOther` tinyint(1) DEFAULT NULL,
  `actBefSleepOtherContent` longtext,
  `wokeupState` enum('refreshed','lessRefreshed','tired') DEFAULT NULL,
  `sleepQuality` enum('veryRestless','restless','average','sound','verySound') DEFAULT NULL,
  `sleepCompare` enum('worse','same','better') DEFAULT NULL,
  `roomDarkness` int(11) DEFAULT NULL,
  `roomQuietness` int(11) DEFAULT NULL,
  `roomWarmness` int(11) DEFAULT NULL,
  `practice` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`diaryId`),
  KEY `userId_idx` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=250 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practice_diary_data_table`
--

LOCK TABLES `practice_diary_data_table` WRITE;
/*!40000 ALTER TABLE `practice_diary_data_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `practice_diary_data_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practiceDiaryNote`
--

DROP TABLE IF EXISTS `practiceDiaryNote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practiceDiaryNote` (
  `recordRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `note` mediumtext,
  PRIMARY KEY (`recordRow`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practiceDiaryNote`
--

LOCK TABLES `practiceDiaryNote` WRITE;
/*!40000 ALTER TABLE `practiceDiaryNote` DISABLE KEYS */;
/*!40000 ALTER TABLE `practiceDiaryNote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `predictSleepProfile`
--

DROP TABLE IF EXISTS `predictSleepProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predictSleepProfile` (
  `recordRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `prediction` mediumtext,
  PRIMARY KEY (`recordRow`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `predictSleepProfile`
--

LOCK TABLES `predictSleepProfile` WRITE;
/*!40000 ALTER TABLE `predictSleepProfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `predictSleepProfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projectQuestion`
--

DROP TABLE IF EXISTS `projectQuestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projectQuestion` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `questions` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projectQuestion`
--

LOCK TABLES `projectQuestion` WRITE;
/*!40000 ALTER TABLE `projectQuestion` DISABLE KEYS */;
/*!40000 ALTER TABLE `projectQuestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `random_code_table`
--

DROP TABLE IF EXISTS `random_code_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `random_code_table` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `random` varchar(32) DEFAULT NULL,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `random_code_table`
--

LOCK TABLES `random_code_table` WRITE;
/*!40000 ALTER TABLE `random_code_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `random_code_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomConstruction`
--

DROP TABLE IF EXISTS `roomConstruction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomConstruction` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `noise` mediumtext,
  `temp` mediumtext,
  `bed` mediumtext,
  `light` mediumtext,
  `other` mediumtext,
  `response` mediumtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomConstruction`
--

LOCK TABLES `roomConstruction` WRITE;
/*!40000 ALTER TABLE `roomConstruction` DISABLE KEYS */;
/*!40000 ALTER TABLE `roomConstruction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_info`
--

DROP TABLE IF EXISTS `school_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_info` (
  `schoolId` int(11) NOT NULL AUTO_INCREMENT,
  `schoolName` longtext,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`schoolId`)
) ENGINE=MyISAM AUTO_INCREMENT=30019 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_info`
--

LOCK TABLES `school_info` WRITE;
/*!40000 ALTER TABLE `school_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sleepEnvironment`
--

DROP TABLE IF EXISTS `sleepEnvironment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sleepEnvironment` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `pictureId` int(11) DEFAULT NULL,
  `promoteGoodSleep` mediumtext,
  `preventGoodSleep` mediumtext,
  `groupMember` mediumtext,
  `submit` tinyint(1) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` mediumtext,
  `score` int(2) DEFAULT '0',
  `contributors` mediumtext,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=193 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sleepEnvironment`
--

LOCK TABLES `sleepEnvironment` WRITE;
/*!40000 ALTER TABLE `sleepEnvironment` DISABLE KEYS */;
/*!40000 ALTER TABLE `sleepEnvironment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_group`
--

DROP TABLE IF EXISTS `student_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_group` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `linkUserId` int(11) NOT NULL,
  `classId` int(11) NOT NULL,
  `lesson` varchar(10) DEFAULT NULL,
  `activity` varchar(1) DEFAULT NULL,
  `tab` varchar(50) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_group`
--

LOCK TABLES `student_group` WRITE;
/*!40000 ALTER TABLE `student_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_link_table`
--

DROP TABLE IF EXISTS `user_link_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_link_table` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `linkUserId` int(11) NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=MyISAM AUTO_INCREMENT=415 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_link_table`
--

LOCK TABLES `user_link_table` WRITE;
/*!40000 ALTER TABLE `user_link_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_link_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_setting_table`
--

DROP TABLE IF EXISTS `user_setting_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_setting_table` (
  `userId` int(11) NOT NULL,
  `diaryEnabled` tinyint(1) DEFAULT '1',
  `diarySubmitByTime` time DEFAULT '09:00:00',
  `diaryAvailableStartTime` time DEFAULT '00:00:00',
  `diaryDailyEntryNum` int(11) DEFAULT '1',
  `diaryMissingAlertEnabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_setting_table`
--

LOCK TABLES `user_setting_table` WRITE;
/*!40000 ALTER TABLE `user_setting_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_setting_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_table`
--

DROP TABLE IF EXISTS `user_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_table` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `firstId` varchar(10) DEFAULT NULL,
  `secondId` varchar(10) DEFAULT NULL,
  `comment` varchar(320) DEFAULT NULL,
  `userName` varchar(320) DEFAULT NULL,
  `password` varchar(254) DEFAULT NULL,
  `type` enum('admin','researcher','teacher','parent','student') DEFAULT NULL,
  `firstName` varchar(25) DEFAULT NULL,
  `lastName` varchar(25) DEFAULT NULL,
  `gender` varchar(5) DEFAULT NULL,
  `currentGrade` tinyint(4) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `schoolId` mediumtext,
  `diaryStartDateFour` date DEFAULT NULL,
  `diaryEndDateFour` date DEFAULT NULL,
  `diaryStartDateFive` date DEFAULT NULL,
  `diaryEndDateFive` date DEFAULT NULL,
  `activityStartDateFour` date DEFAULT NULL,
  `activityEndDateFour` date DEFAULT NULL,
  `activityStartDateFive` date DEFAULT NULL,
  `activityEndDateFive` date DEFAULT NULL,
  `emailAddress` varchar(254) DEFAULT NULL,
  `logOnTimes` int(11) DEFAULT '0',
  `changeTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=11765 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_table`
--

LOCK TABLES `user_table` WRITE;
/*!40000 ALTER TABLE `user_table` DISABLE KEYS */;
INSERT INTO `user_table` VALUES (10001,NULL,NULL,NULL,'cmVzZWFyY2hlcg==','dGVzdA==','researcher','Main','Researcher',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2020-06-04 22:14:16');
/*!40000 ALTER TABLE `user_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `watch_challenge_data_table`
--

DROP TABLE IF EXISTS `watch_challenge_data_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `watch_challenge_data_table` (
  `userId` int(11) DEFAULT NULL,
  `recordNum` int(11) DEFAULT NULL,
  `epoch` int(11) DEFAULT NULL,
  `second` int(11) DEFAULT NULL,
  `date` varchar(15) DEFAULT NULL,
  `time` varchar(15) DEFAULT NULL,
  `offWrist` tinyint(1) DEFAULT NULL,
  `activity` int(11) DEFAULT NULL,
  `marker` int(11) DEFAULT NULL,
  `whiteLight` float DEFAULT NULL,
  `redLight` float DEFAULT NULL,
  `greenLight` float DEFAULT NULL,
  `blueLight` float DEFAULT NULL,
  `awake` tinyint(1) DEFAULT NULL,
  `intervalStatus` varchar(10) DEFAULT NULL,
  `dataHeader` int(11) DEFAULT NULL,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `watch_challenge_data_table`
--

LOCK TABLES `watch_challenge_data_table` WRITE;
/*!40000 ALTER TABLE `watch_challenge_data_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `watch_challenge_data_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `watch_challenge_waveform_table`
--

DROP TABLE IF EXISTS `watch_challenge_waveform_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `watch_challenge_waveform_table` (
  `userId` int(11) NOT NULL,
  `second` longtext,
  `offWrist` longtext,
  `activity` longtext,
  `whiteLight` longtext,
  `redLight` longtext,
  `greenLight` longtext,
  `blueLight` longtext,
  `submitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `watch_challenge_waveform_table`
--

LOCK TABLES `watch_challenge_waveform_table` WRITE;
/*!40000 ALTER TABLE `watch_challenge_waveform_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `watch_challenge_waveform_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zprofile`
--

DROP TABLE IF EXISTS `zprofile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zprofile` (
  `resultRow` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `contributors` mediumtext,
  `comment` mediumtext,
  `score` int(2) DEFAULT NULL,
  `q1` mediumtext,
  `q2` mediumtext,
  `q3` mediumtext,
  `q4` mediumtext,
  `q5` mediumtext,
  `q6` mediumtext,
  `pattern` mediumtext,
  `caseID` int(11) DEFAULT NULL,
  PRIMARY KEY (`resultRow`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zprofile`
--

LOCK TABLES `zprofile` WRITE;
/*!40000 ALTER TABLE `zprofile` DISABLE KEYS */;
/*!40000 ALTER TABLE `zprofile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-04 16:30:18
