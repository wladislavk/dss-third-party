-- MySQL dump 10.13  Distrib 5.1.67, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: dentalsl_main_skin
-- ------------------------------------------------------
-- Server version	5.1.67-0ubuntu0.10.04.1

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `recover_hash` varchar(100) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `admin_access` int(11) DEFAULT '1',
  `last_accessed_date` datetime DEFAULT NULL,
  `claim_margin_top` int(3) DEFAULT '0',
  `claim_margin_left` int(3) DEFAULT '0',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (21,'Test User','testuser','32b02ef357fe6f0c021062d4411538a429f300819a372844c375c7a27f9b3980',1,NULL,NULL,'237ad3ba853e',NULL,NULL,NULL,1,'2014-01-29 12:47:45',0,0,'test','user'),(22,NULL,'HSTtestadmin','0fba6787eb9dac7d81b854f323a1ae53da482fc2ed9761798059329f0d6f2581',1,'2014-01-28 23:01:48','10.20.1.168','4f624790bdd9',NULL,NULL,'nathan+hsttestadmin@dentalsleepsolutions.com',6,NULL,0,0,'HST_test','Admin'),(23,NULL,'billingadmintest','c241065c13533063aedd5c928f2e17dd7dedab5ab955f1746936e43da8b52d32',1,'2014-01-28 23:03:01','10.20.1.168','85a2742d3ea8',NULL,NULL,'nathan+billinadmintest@dentalsleepsolutions.com',4,NULL,0,0,'billingadmin','test');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_company`
--

DROP TABLE IF EXISTS `admin_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_company`
--

LOCK TABLES `admin_company` WRITE;
/*!40000 ALTER TABLE `admin_company` DISABLE KEYS */;
INSERT INTO `admin_company` VALUES (24,22,18,NULL,NULL),(25,23,17,NULL,NULL);
/*!40000 ALTER TABLE `admin_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `add1` varchar(100) DEFAULT NULL,
  `add2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `eligible_api_key` varchar(255) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `stripe_secret_key` varchar(255) DEFAULT NULL,
  `stripe_publishable_key` varchar(255) DEFAULT NULL,
  `monthly_fee` decimal(11,2) DEFAULT '0.00',
  `default_new` tinyint(1) DEFAULT '0',
  `sfax_security_context` varchar(255) DEFAULT NULL,
  `sfax_app_id` varchar(255) DEFAULT NULL,
  `sfax_app_key` varchar(255) DEFAULT NULL,
  `sfax_init_vector` varchar(255) DEFAULT NULL,
  `fax_fee` decimal(11,2) DEFAULT '0.00',
  `free_fax` int(4) DEFAULT '0',
  `company_type` tinyint(2) DEFAULT '1',
  `phone` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `shipping_label` varchar(100) DEFAULT NULL,
  `print_label` tinyint(1) DEFAULT NULL,
  `turnaround_time` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (17,'Insurance & Billing',1,'2014-01-28 23:00:18','10.20.1.168','123 Test','Ste A','TestCity','fl','45678','',NULL,'','','0.00',0,'','','','','0.00',0,0,'','','',NULL,NULL,NULL,NULL),(18,'HST Company',1,'2014-01-28 23:00:46','10.20.1.168','1110 Austin Hwy','Suite C','TestCity','fl','45678','',NULL,'','','0.00',0,'','','','','0.00',0,2,'','','',NULL,NULL,NULL,NULL),(19,'Software Company',1,'2014-01-28 23:04:27','10.20.1.168','123 Test','Ste A','TestCity','fl','55614-0338','',NULL,'','','0.00',0,'','','','','0.00',0,1,'','','',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_devices`
--

DROP TABLE IF EXISTS `company_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_devices`
--

LOCK TABLES `company_devices` WRITE;
/*!40000 ALTER TABLE `company_devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_access_codes`
--

DROP TABLE IF EXISTS `dental_access_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_access_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_code` varchar(50) DEFAULT NULL,
  `notes` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `plan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_access_codes`
--

LOCK TABLES `dental_access_codes` WRITE;
/*!40000 ALTER TABLE `dental_access_codes` DISABLE KEYS */;
INSERT INTO `dental_access_codes` VALUES (5,'accesscode1','test access code',NULL,NULL,1,4);
/*!40000 ALTER TABLE `dental_access_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_allergens`
--

DROP TABLE IF EXISTS `dental_allergens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_allergens` (
  `allergensid` int(11) NOT NULL AUTO_INCREMENT,
  `allergens` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`allergensid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_allergens`
--

LOCK TABLES `dental_allergens` WRITE;
/*!40000 ALTER TABLE `dental_allergens` DISABLE KEYS */;
INSERT INTO `dental_allergens` VALUES (1,'Antibiotics','',2,1,'2010-03-10 15:41:05','192.168.1.55'),(2,'Asprin',NULL,3,1,'2010-03-10 15:41:54','192.168.1.55'),(3,'Barbiturates',NULL,4,1,'2010-03-10 15:41:54','192.168.1.55'),(4,'Codeine',NULL,5,1,'2010-03-10 15:41:54','192.168.1.55'),(5,'Iodine',NULL,6,1,'2010-03-10 15:41:54','192.168.1.55'),(6,'Latex',NULL,6,1,'2010-03-10 15:41:54','192.168.1.55'),(7,'Local anesthetics',NULL,8,1,'2010-04-14 13:51:36','192.168.1.55'),(8,'Metals',NULL,9,1,'2010-04-14 13:51:36','192.168.1.55'),(9,'Penicillin',NULL,10,1,'2010-04-14 13:51:36','192.168.1.55'),(10,'Plastic',NULL,11,1,'2010-04-14 13:51:36','192.168.1.55'),(11,'Sedatives',NULL,12,1,'2010-04-14 13:51:36','192.168.1.55'),(12,'Sleeping pills',NULL,13,1,'2010-04-14 13:51:36','192.168.1.55'),(13,'Sulfa drugs',NULL,14,1,'2010-04-14 13:51:36','192.168.1.55'),(15,'Acrylic','',1,1,'2010-05-05 12:09:26','59.181.135.49'),(16,'Jewelry','',7,1,'2010-05-05 12:10:33','59.181.135.49');
/*!40000 ALTER TABLE `dental_allergens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_appt_types`
--

DROP TABLE IF EXISTS `dental_appt_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_appt_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `classname` varchar(255) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1242 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_appt_types`
--

LOCK TABLES `dental_appt_types` WRITE;
/*!40000 ALTER TABLE `dental_appt_types` DISABLE KEYS */;
INSERT INTO `dental_appt_types` VALUES (1236,'General','FFF9CF','general',244),(1237,'Follow-up','D6CFFF','follow-up',244),(1238,'Sleep Test','CFF5FF','sleep_test',244),(1239,'Impressions','DFFFCF','impressions',244),(1240,'New Pt','FFCFCF','new_pt',244),(1241,'Deliver Device','FBA16C','deliver_device',244);
/*!40000 ALTER TABLE `dental_appt_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_assess_addition`
--

DROP TABLE IF EXISTS `dental_assess_addition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_assess_addition` (
  `assess_additionid` int(11) NOT NULL AUTO_INCREMENT,
  `assess_addition` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`assess_additionid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_assess_addition`
--

LOCK TABLES `dental_assess_addition` WRITE;
/*!40000 ALTER TABLE `dental_assess_addition` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_assess_addition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_assessment`
--

DROP TABLE IF EXISTS `dental_assessment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_assessment` (
  `assessmentid` int(11) NOT NULL AUTO_INCREMENT,
  `assessment` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`assessmentid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_assessment`
--

LOCK TABLES `dental_assessment` WRITE;
/*!40000 ALTER TABLE `dental_assessment` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_assessment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_calendar`
--

DROP TABLE IF EXISTS `dental_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `description` text,
  `event_id` bigint(8) unsigned DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `producer_id` int(11) DEFAULT NULL,
  `patientid` int(11) DEFAULT NULL,
  `rec_type` varchar(64) DEFAULT NULL,
  `event_length` bigint(20) DEFAULT NULL,
  `event_pid` bigint(20) DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_calendar`
--

LOCK TABLES `dental_calendar` WRITE;
/*!40000 ALTER TABLE `dental_calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_charge`
--

DROP TABLE IF EXISTS `dental_charge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(11,2) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `adminid` int(11) DEFAULT NULL,
  `charge_date` datetime DEFAULT NULL,
  `stripe_customer` varchar(255) DEFAULT NULL,
  `stripe_charge` varchar(255) DEFAULT NULL,
  `stripe_card_fingerprint` varchar(255) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(5) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_charge`
--

LOCK TABLES `dental_charge` WRITE;
/*!40000 ALTER TABLE `dental_charge` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_charge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_claim_electronic`
--

DROP TABLE IF EXISTS `dental_claim_electronic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_claim_electronic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claimid` int(11) DEFAULT NULL,
  `response` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_claim_electronic`
--

LOCK TABLES `dental_claim_electronic` WRITE;
/*!40000 ALTER TABLE `dental_claim_electronic` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_claim_electronic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_complaint`
--

DROP TABLE IF EXISTS `dental_complaint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_complaint` (
  `complaintid` int(11) NOT NULL AUTO_INCREMENT,
  `complaint` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`complaintid`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_complaint`
--

LOCK TABLES `dental_complaint` WRITE;
/*!40000 ALTER TABLE `dental_complaint` DISABLE KEYS */;
INSERT INTO `dental_complaint` VALUES (1,'Frequent snoring','',1,1,'2010-03-10 14:15:50','192.168.1.55'),(11,'Excessive daytime sleepiness (EDS)',NULL,3,1,'2010-03-10 14:54:11','192.168.1.55'),(12,'Others have observed that I stop breathing while I sleep.','',4,1,'2010-03-10 14:54:11','192.168.1.55'),(10,'Snoring  which affects the sleep of others',NULL,2,1,'2010-03-10 14:54:11','192.168.1.55'),(13,'Difficulty falling asleep',NULL,5,1,'2010-03-10 14:54:28','192.168.1.55'),(14,'Difficulty in maintaining sleep','',6,1,'2010-03-10 14:54:47','192.168.1.55'),(15,'Waking up gasping',NULL,7,1,'2010-03-10 14:55:01','192.168.1.55'),(16,'Choking while sleeping',NULL,8,1,'2010-03-10 14:56:14','192.168.1.55'),(17,'Nighttime heartburn or GERD','',9,1,'2010-03-10 14:56:14','192.168.1.55'),(18,'Feeling unrefreshed in the morning',NULL,10,1,'2010-03-10 14:56:14','192.168.1.55'),(19,'Morning headaches',NULL,11,1,'2010-03-10 14:56:14','192.168.1.55'),(20,'Nasal problems or difficulty breathing through the nose',NULL,12,1,'2010-03-10 14:56:14','192.168.1.55'),(21,'Clenching or grinding teeth at night','',13,1,'2010-03-10 14:56:14','192.168.1.55'),(22,'TMJ or jaw pain',NULL,14,1,'2010-03-10 14:56:14','192.168.1.55'),(23,'Neck or facial pain',NULL,15,1,'2010-03-10 14:56:14','192.168.1.55'),(24,'Sounds in jaw joint (clicking, popping or grating)',NULL,16,1,'2010-03-10 14:56:14','192.168.1.55'),(25,'I have been told that I stop breathing when I sleep','',17,1,'2010-04-13 17:35:29','122.169.49.151'),(26,'Memory Problems',NULL,999,1,'2010-05-03 16:56:13','122.169.48.127'),(27,'Irritability or mood swings',NULL,999,1,'2010-05-03 16:56:13','122.169.48.127');
/*!40000 ALTER TABLE `dental_complaint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_consultation`
--

DROP TABLE IF EXISTS `dental_consultation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_consultation` (
  `consultationid` int(11) NOT NULL AUTO_INCREMENT,
  `consultation` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`consultationid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_consultation`
--

LOCK TABLES `dental_consultation` WRITE;
/*!40000 ALTER TABLE `dental_consultation` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_consultation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_contact`
--

DROP TABLE IF EXISTS `dental_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_contact` (
  `contactid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `add1` varchar(255) DEFAULT NULL,
  `add2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `national_provider_id` varchar(255) DEFAULT NULL,
  `qualifier` varchar(255) DEFAULT NULL,
  `qualifierid` varchar(255) DEFAULT NULL,
  `greeting` varchar(255) DEFAULT NULL,
  `sincerely` varchar(255) DEFAULT NULL,
  `contacttypeid` int(11) DEFAULT '0',
  `notes` text,
  `preferredcontact` varchar(255) NOT NULL,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `referredby_info` int(1) DEFAULT NULL,
  `old_referredbyid` int(11) DEFAULT NULL,
  `referredby_notes` text,
  `dea_number` varchar(100) DEFAULT NULL,
  `merge_id` int(11) DEFAULT NULL,
  `merge_date` datetime DEFAULT NULL,
  PRIMARY KEY (`contactid`)
) ENGINE=MyISAM AUTO_INCREMENT=1609 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_contact`
--

LOCK TABLES `dental_contact` WRITE;
/*!40000 ALTER TABLE `dental_contact` DISABLE KEYS */;
INSERT INTO `dental_contact` VALUES (1605,244,'Dr.','One','Doctor','','Doctor Office #1','123 Fake Street NEW','','Simi Valley','CA','93065','5555555555','','5555555555','','987654321','0','','','',29,'','fax',1,'2014-01-28 23:10:39','10.20.1.168',NULL,NULL,NULL,NULL,NULL,NULL),(1606,244,'Dr.','Primarycare','Test','','Primary CareOffice','123 Test','','Austin','TX','92689','5555555555','','5555555555','','','0','','','',29,'','fax',1,'2014-01-28 23:12:09','10.20.1.168',NULL,NULL,NULL,NULL,NULL,NULL),(1607,244,'','','','','Insurance #1','123 Test','','Holmes Beach','TX','92689','4444444444','','5555555555','','','0','','','',31,'','fax',1,'2014-01-28 23:13:13','10.20.1.168',NULL,NULL,NULL,NULL,NULL,NULL),(1608,244,'','','','','Insurance #1','123 Fake Street NEW','','bradenton','TX','92689','5555555555','','5555555555','','','0','','','',31,'','fax',1,'2014-01-28 23:14:36','10.20.1.168',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dental_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_contacttype`
--

DROP TABLE IF EXISTS `dental_contacttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_contacttype` (
  `contacttypeid` int(11) NOT NULL AUTO_INCREMENT,
  `contacttype` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `physician` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`contacttypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_contacttype`
--

LOCK TABLES `dental_contacttype` WRITE;
/*!40000 ALTER TABLE `dental_contacttype` DISABLE KEYS */;
INSERT INTO `dental_contacttype` VALUES (23,'Other Physician','',7,1,'2011-04-14 22:14:37','72.77.128.163',1),(24,'Dentist','',3,1,'2011-04-14 22:15:13','72.77.128.163',1),(22,'ENT Physician','',4,1,'2011-04-14 22:14:37','72.77.128.163',1),(12,'Other',NULL,8,1,'2010-03-12 13:40:21','192.168.1.55',NULL),(13,'Parent',NULL,10,1,'2010-03-12 13:40:21','192.168.1.55',NULL),(25,'Pulmonologist','',6,1,'2013-08-21 16:47:11','72.179.13.112',1),(21,'Sleep Physician','',2,1,'2011-04-14 22:13:05','72.77.128.163',1),(20,'Primary Care Physician','',1,1,'2011-04-14 22:12:43','72.77.128.163',1),(19,'Unknown',NULL,9,1,'2010-03-12 13:40:21','192.168.1.55',NULL),(11,'Insurance',NULL,11,1,'2011-05-14 20:47:43','127.0.0.1',NULL),(26,'Cardiologist','',5,1,'2013-10-22 16:28:27','68.253.133.237',1);
/*!40000 ALTER TABLE `dental_contacttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_cpt_code`
--

DROP TABLE IF EXISTS `dental_cpt_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_cpt_code` (
  `cpt_codeid` int(11) NOT NULL AUTO_INCREMENT,
  `cpt_code` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`cpt_codeid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_cpt_code`
--

LOCK TABLES `dental_cpt_code` WRITE;
/*!40000 ALTER TABLE `dental_cpt_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_cpt_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_custom`
--

DROP TABLE IF EXISTS `dental_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_custom` (
  `customid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `default_text` int(1) DEFAULT NULL,
  PRIMARY KEY (`customid`)
) ENGINE=MyISAM AUTO_INCREMENT=1213 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_custom`
--

LOCK TABLES `dental_custom` WRITE;
/*!40000 ALTER TABLE `dental_custom` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_device`
--

DROP TABLE IF EXISTS `dental_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_device` (
  `deviceid` int(11) NOT NULL AUTO_INCREMENT,
  `device` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `image_path` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_device`
--

LOCK TABLES `dental_device` WRITE;
/*!40000 ALTER TABLE `dental_device` DISABLE KEYS */;
INSERT INTO `dental_device` VALUES (21,'TAP','',1,1,'2014-01-28 22:52:21','10.20.1.168','dental_device_21.jpg'),(22,'Somnodent Herbst','',2,1,'2014-01-28 22:54:17','10.20.1.168','dental_device_22.jpg');
/*!40000 ALTER TABLE `dental_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_device_guide_device_setting`
--

DROP TABLE IF EXISTS `dental_device_guide_device_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_device_guide_device_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `setting_id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=579 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_device_guide_device_setting`
--

LOCK TABLES `dental_device_guide_device_setting` WRITE;
/*!40000 ALTER TABLE `dental_device_guide_device_setting` DISABLE KEYS */;
INSERT INTO `dental_device_guide_device_setting` VALUES (577,21,15,2,'2014-01-28 22:53:28','10.20.1.168'),(578,22,15,3,'2014-01-28 22:54:17','10.20.1.168');
/*!40000 ALTER TABLE `dental_device_guide_device_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_device_guide_devices`
--

DROP TABLE IF EXISTS `dental_device_guide_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_device_guide_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_device_guide_devices`
--

LOCK TABLES `dental_device_guide_devices` WRITE;
/*!40000 ALTER TABLE `dental_device_guide_devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_device_guide_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_device_guide_setting_options`
--

DROP TABLE IF EXISTS `dental_device_guide_setting_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_device_guide_setting_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(2) DEFAULT NULL,
  `setting_id` int(11) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_device_guide_setting_options`
--

LOCK TABLES `dental_device_guide_setting_options` WRITE;
/*!40000 ALTER TABLE `dental_device_guide_setting_options` DISABLE KEYS */;
INSERT INTO `dental_device_guide_setting_options` VALUES (147,1,15,'Low Choice',NULL,NULL),(148,2,15,'Medium Choice',NULL,NULL),(149,3,15,'High Choice',NULL,NULL);
/*!40000 ALTER TABLE `dental_device_guide_setting_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_device_guide_settings`
--

DROP TABLE IF EXISTS `dental_device_guide_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_device_guide_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `setting_type` tinyint(1) DEFAULT NULL,
  `range_start` int(2) DEFAULT NULL,
  `range_end` int(2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(25) DEFAULT NULL,
  `rank` int(2) DEFAULT NULL,
  `options` int(2) DEFAULT NULL,
  `range_start_label` varchar(100) DEFAULT NULL,
  `range_end_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_device_guide_settings`
--

LOCK TABLES `dental_device_guide_settings` WRITE;
/*!40000 ALTER TABLE `dental_device_guide_settings` DISABLE KEYS */;
INSERT INTO `dental_device_guide_settings` VALUES (15,'Test Setting #1',0,1,3,'2014-01-28 22:53:15','10.20.1.168',1,3,'Low','High');
/*!40000 ALTER TABLE `dental_device_guide_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_diagnostic`
--

DROP TABLE IF EXISTS `dental_diagnostic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_diagnostic` (
  `diagnosticid` int(11) NOT NULL AUTO_INCREMENT,
  `diagnostic` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`diagnosticid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_diagnostic`
--

LOCK TABLES `dental_diagnostic` WRITE;
/*!40000 ALTER TABLE `dental_diagnostic` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_diagnostic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_doc_dvd`
--

DROP TABLE IF EXISTS `dental_doc_dvd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_doc_dvd` (
  `doc_dvdid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_file` varchar(255) DEFAULT NULL,
  `doc_file` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` text,
  PRIMARY KEY (`doc_dvdid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_doc_dvd`
--

LOCK TABLES `dental_doc_dvd` WRITE;
/*!40000 ALTER TABLE `dental_doc_dvd` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_doc_dvd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_doc_educational`
--

DROP TABLE IF EXISTS `dental_doc_educational`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_doc_educational` (
  `doc_educationalid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_file` varchar(255) DEFAULT NULL,
  `doc_file` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` text,
  PRIMARY KEY (`doc_educationalid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_doc_educational`
--

LOCK TABLES `dental_doc_educational` WRITE;
/*!40000 ALTER TABLE `dental_doc_educational` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_doc_educational` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_doc_insurance`
--

DROP TABLE IF EXISTS `dental_doc_insurance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_doc_insurance` (
  `doc_insuranceid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_file` varchar(255) DEFAULT NULL,
  `doc_file` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` text,
  PRIMARY KEY (`doc_insuranceid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_doc_insurance`
--

LOCK TABLES `dental_doc_insurance` WRITE;
/*!40000 ALTER TABLE `dental_doc_insurance` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_doc_insurance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_doc_lab`
--

DROP TABLE IF EXISTS `dental_doc_lab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_doc_lab` (
  `doc_labid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_file` varchar(255) DEFAULT NULL,
  `doc_file` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` text,
  PRIMARY KEY (`doc_labid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_doc_lab`
--

LOCK TABLES `dental_doc_lab` WRITE;
/*!40000 ALTER TABLE `dental_doc_lab` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_doc_lab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_doc_marketing`
--

DROP TABLE IF EXISTS `dental_doc_marketing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_doc_marketing` (
  `doc_marketingid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_file` varchar(255) DEFAULT NULL,
  `doc_file` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` text,
  PRIMARY KEY (`doc_marketingid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_doc_marketing`
--

LOCK TABLES `dental_doc_marketing` WRITE;
/*!40000 ALTER TABLE `dental_doc_marketing` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_doc_marketing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_doc_new`
--

DROP TABLE IF EXISTS `dental_doc_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_doc_new` (
  `doc_newid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_file` varchar(255) DEFAULT NULL,
  `doc_file` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` text,
  PRIMARY KEY (`doc_newid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_doc_new`
--

LOCK TABLES `dental_doc_new` WRITE;
/*!40000 ALTER TABLE `dental_doc_new` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_doc_new` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_doc_welcome`
--

DROP TABLE IF EXISTS `dental_doc_welcome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_doc_welcome` (
  `doc_welcomeid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `video_file` varchar(255) DEFAULT NULL,
  `doc_file` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` text,
  PRIMARY KEY (`doc_welcomeid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_doc_welcome`
--

LOCK TABLES `dental_doc_welcome` WRITE;
/*!40000 ALTER TABLE `dental_doc_welcome` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_doc_welcome` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_document`
--

DROP TABLE IF EXISTS `dental_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_document` (
  `documentid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`documentid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_document`
--

LOCK TABLES `dental_document` WRITE;
/*!40000 ALTER TABLE `dental_document` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_document_category`
--

DROP TABLE IF EXISTS `dental_document_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_document_category` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_document_category`
--

LOCK TABLES `dental_document_category` WRITE;
/*!40000 ALTER TABLE `dental_document_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_document_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_eligibility`
--

DROP TABLE IF EXISTS `dental_eligibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_eligibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `eligible_id` varchar(255) DEFAULT NULL,
  `pi_name` varchar(255) DEFAULT NULL,
  `pi_id` int(11) DEFAULT NULL,
  `pi_group_name` varchar(255) DEFAULT NULL,
  `pi_plan_begins` date DEFAULT NULL,
  `pi_plan_ends` date DEFAULT NULL,
  `pi_comments` text,
  `pi_deductible_in_individual_base_period` decimal(11,2) DEFAULT NULL,
  `pi_deductible_in_individual_remaining` decimal(11,2) DEFAULT NULL,
  `pi_deductible_in_individual_comments` text,
  `pi_deductible_in_family_base_period` decimal(11,2) DEFAULT NULL,
  `pi_deductible_in_family_remaining` decimal(11,2) DEFAULT NULL,
  `pi_deductible_in_family_comments` text,
  `pi_deductible_out_individual_base_period` decimal(11,2) DEFAULT NULL,
  `pi_deductible_out_individual_remaining` decimal(11,2) DEFAULT NULL,
  `pi_deductible_out_individual_comments` text,
  `pi_deductible_out_family_base_period` decimal(11,2) DEFAULT NULL,
  `pi_deductible_out_family_remaining` decimal(11,2) DEFAULT NULL,
  `pi_deductible_out_family_comments` text,
  `pi_stop_loss_in_individual_base_period` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_in_individual_remaining` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_in_individual_comments` text,
  `pi_stop_loss_in_family_base_period` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_in_family_remaining` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_in_family_comments` text,
  `pi_stop_loss_out_individual_base_period` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_out_individual_remaining` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_out_individual_comments` text,
  `pi_stop_loss_out_family_base_period` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_out_family_remaining` decimal(11,2) DEFAULT NULL,
  `pi_stop_loss_out_family_comments` text,
  `pi_balance` decimal(11,2) DEFAULT NULL,
  `medical_care_coverage_status` int(2) DEFAULT NULL,
  `medical_care_coinsurance_in_individual_percent` int(11) DEFAULT NULL,
  `medical_care_coinsurance_in_individual_comments` text,
  `medical_care_coinsurance_in_family_percent` int(11) DEFAULT NULL,
  `medical_care_coinsurance_in_family_comments` text,
  `medical_care_coinsurance_out_individual_percent` int(11) DEFAULT NULL,
  `medical_care_coinsurance_out_individual_comments` text,
  `medical_care_coinsurance_out_family_percent` int(11) DEFAULT NULL,
  `medical_care_coinsurance_out_family_comments` text,
  `medical_care_copayment_in_individual_amount` decimal(11,2) DEFAULT NULL,
  `medical_care_copayment_in_individual_comments` text,
  `medical_care_copayment_in_family_amount` decimal(11,2) DEFAULT NULL,
  `medical_care_copayment_in_family_comments` text,
  `medical_care_copayment_out_individual_amount` decimal(11,2) DEFAULT NULL,
  `medical_care_copayment_out_individual_comments` text,
  `medical_care_copayment_out_family_amount` decimal(11,2) DEFAULT NULL,
  `medical_care_copayment_out_family_comments` text,
  `medical_care_deductible_in_individual_base_period` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_in_individual_remaining` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_in_individual_comments` text,
  `medical_care_deductible_in_family_base_period` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_in_family_remaining` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_in_family_comments` text,
  `medical_care_deductible_out_individual_base_period` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_out_individual_remaining` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_out_individual_comments` text,
  `medical_care_deductible_out_family_base_period` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_out_family_remaining` decimal(11,2) DEFAULT NULL,
  `medical_care_deductible_out_family_comments` text,
  `medical_care_precertification_needed` varchar(100) DEFAULT NULL,
  `medical_care_visits_in_individual_total` int(11) DEFAULT NULL,
  `medical_care_visits_in_individual_remaining` int(11) DEFAULT NULL,
  `medical_care_visits_in_individual_comments` text,
  `medical_care_visits_in_family_total` int(11) DEFAULT NULL,
  `medical_care_visits_in_family_remaining` int(11) DEFAULT NULL,
  `medical_care_visits_in_family_comments` text,
  `medical_care_visits_out_individual_total` int(11) DEFAULT NULL,
  `medical_care_visits_out_individual_remaining` int(11) DEFAULT NULL,
  `medical_care_visits_out_individual_comments` text,
  `medical_care_visits_out_family_total` int(11) DEFAULT NULL,
  `medical_care_visits_out_family_remaining` int(11) DEFAULT NULL,
  `medical_care_visits_out_family_comments` text,
  `medical_care_additional_insurance_comments` text,
  `medical_equipment_coverage_status` int(2) DEFAULT NULL,
  `medical_equipment_coinsurance_in_individual_percent` int(11) DEFAULT NULL,
  `medical_equipment_coinsurance_in_individual_comments` text,
  `medical_equipment_coinsurance_in_family_percent` int(11) DEFAULT NULL,
  `medical_equipment_coinsurance_in_family_comments` text,
  `medical_equipment_coinsurance_out_individual_percent` int(11) DEFAULT NULL,
  `medical_equipment_coinsurance_out_individual_comments` text,
  `medical_equipment_coinsurance_out_family_percent` int(11) DEFAULT NULL,
  `medical_equipment_coinsurance_out_family_comments` text,
  `medical_equipment_copayment_in_individual_amount` decimal(11,2) DEFAULT NULL,
  `medical_equipment_copayment_in_individual_comments` text,
  `medical_equipment_copayment_in_family_amount` decimal(11,2) DEFAULT NULL,
  `medical_equipment_copayment_in_family_comments` text,
  `medical_equipment_copayment_out_individual_amount` decimal(11,2) DEFAULT NULL,
  `medical_equipment_copayment_out_individual_comments` text,
  `medical_equipment_copayment_out_family_amount` decimal(11,2) DEFAULT NULL,
  `medical_equipment_copayment_out_family_comments` text,
  `medical_equipment_deductible_in_individual_base_period` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_in_individual_remaining` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_in_individual_comments` text,
  `medical_equipment_deductible_in_family_base_period` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_in_family_remaining` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_in_family_comments` text,
  `medical_equipment_deductible_out_individual_base_period` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_out_individual_remaining` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_out_individual_comments` text,
  `medical_equipment_deductible_out_family_base_period` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_out_family_remaining` decimal(11,2) DEFAULT NULL,
  `medical_equipment_deductible_out_family_comments` text,
  `medical_equipment_precertification_needed` varchar(100) DEFAULT NULL,
  `medical_equipment_visits_in_individual_total` int(11) DEFAULT NULL,
  `medical_equipment_visits_in_individual_remaining` int(11) DEFAULT NULL,
  `medical_equipment_visits_in_individual_comments` text,
  `medical_equipment_visits_in_family_total` int(11) DEFAULT NULL,
  `medical_equipment_visits_in_family_remaining` int(11) DEFAULT NULL,
  `medical_equipment_visits_in_family_comments` text,
  `medical_equipment_visits_out_individual_total` int(11) DEFAULT NULL,
  `medical_equipment_visits_out_individual_remaining` int(11) DEFAULT NULL,
  `medical_equipment_visits_out_individual_comments` text,
  `medical_equipment_visits_out_family_total` int(11) DEFAULT NULL,
  `medical_equipment_visits_out_family_remaining` int(11) DEFAULT NULL,
  `medical_equipment_visits_out_family_comments` text,
  `medical_equipment_additional_insurance_comments` text,
  `plan_coverage_coverage_status` int(2) DEFAULT NULL,
  `plan_coverage_coinsurance_in_individual_percent` int(11) DEFAULT NULL,
  `plan_coverage_coinsurance_in_individual_comments` text,
  `plan_coverage_coinsurance_in_family_percent` int(11) DEFAULT NULL,
  `plan_coverage_coinsurance_in_family_comments` text,
  `plan_coverage_coinsurance_out_individual_percent` int(11) DEFAULT NULL,
  `plan_coverage_coinsurance_out_individual_comments` text,
  `plan_coverage_coinsurance_out_family_percent` int(11) DEFAULT NULL,
  `plan_coverage_coinsurance_out_family_comments` text,
  `plan_coverage_copayment_in_individual_amount` decimal(11,2) DEFAULT NULL,
  `plan_coverage_copayment_in_individual_comments` text,
  `plan_coverage_copayment_in_family_amount` decimal(11,2) DEFAULT NULL,
  `plan_coverage_copayment_in_family_comments` text,
  `plan_coverage_copayment_out_individual_amount` decimal(11,2) DEFAULT NULL,
  `plan_coverage_copayment_out_individual_comments` text,
  `plan_coverage_copayment_out_family_amount` decimal(11,2) DEFAULT NULL,
  `plan_coverage_copayment_out_family_comments` text,
  `plan_coverage_deductible_in_individual_base_period` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_in_individual_remaining` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_in_individual_comments` text,
  `plan_coverage_deductible_in_family_base_period` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_in_family_remaining` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_in_family_comments` text,
  `plan_coverage_deductible_out_individual_base_period` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_out_individual_remaining` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_out_individual_comments` text,
  `plan_coverage_deductible_out_family_base_period` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_out_family_remaining` decimal(11,2) DEFAULT NULL,
  `plan_coverage_deductible_out_family_comments` text,
  `plan_coverage_precertification_needed` varchar(100) DEFAULT NULL,
  `plan_coverage_visits_in_individual_total` int(11) DEFAULT NULL,
  `plan_coverage_visits_in_individual_remaining` int(11) DEFAULT NULL,
  `plan_coverage_visits_in_individual_comments` text,
  `plan_coverage_visits_in_family_total` int(11) DEFAULT NULL,
  `plan_coverage_visits_in_family_remaining` int(11) DEFAULT NULL,
  `plan_coverage_visits_in_family_comments` text,
  `plan_coverage_visits_out_individual_total` int(11) DEFAULT NULL,
  `plan_coverage_visits_out_individual_remaining` int(11) DEFAULT NULL,
  `plan_coverage_visits_out_individual_comments` text,
  `plan_coverage_visits_out_family_total` int(11) DEFAULT NULL,
  `plan_coverage_visits_out_family_remaining` int(11) DEFAULT NULL,
  `plan_coverage_visits_out_family_comments` text,
  `plan_coverage_additional_insurance_comments` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_eligibility`
--

LOCK TABLES `dental_eligibility` WRITE;
/*!40000 ALTER TABLE `dental_eligibility` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_eligibility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_eligible_response`
--

DROP TABLE IF EXISTS `dental_eligible_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_eligible_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claimid` varchar(255) DEFAULT NULL,
  `response` text,
  `event_type` varchar(50) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_eligible_response`
--

LOCK TABLES `dental_eligible_response` WRITE;
/*!40000 ALTER TABLE `dental_eligible_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_eligible_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_epworth`
--

DROP TABLE IF EXISTS `dental_epworth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_epworth` (
  `epworthid` int(11) NOT NULL AUTO_INCREMENT,
  `epworth` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`epworthid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_epworth`
--

LOCK TABLES `dental_epworth` WRITE;
/*!40000 ALTER TABLE `dental_epworth` DISABLE KEYS */;
INSERT INTO `dental_epworth` VALUES (1,'Sitting and reading','',1,1,'2010-03-18 13:24:45','192.168.1.55'),(2,'Watching TV',NULL,2,1,'2010-03-18 13:25:27','192.168.1.55'),(3,'Sitting inactive in a public place (e.g. a theater or meeting)',NULL,3,1,'2010-03-18 13:25:27','192.168.1.55'),(4,'As a passenger in a car for an hour without a break',NULL,4,1,'2010-03-18 13:25:27','192.168.1.55'),(5,'Lying down to rest in the afternoon when circumstances permit',NULL,5,1,'2010-03-18 13:25:27','192.168.1.55'),(6,'Sitting and talking to someone',NULL,6,1,'2010-03-18 13:25:27','192.168.1.55'),(7,'Sitting quietly after a lunch without alcohol',NULL,7,1,'2010-03-18 13:25:27','192.168.1.55'),(8,'In a car, while stopped for a few minutes in traffic','',8,1,'2010-03-18 13:25:27','192.168.1.55');
/*!40000 ALTER TABLE `dental_epworth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_evaluation_est`
--

DROP TABLE IF EXISTS `dental_evaluation_est`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_evaluation_est` (
  `evaluation_estid` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_est` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`evaluation_estid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_evaluation_est`
--

LOCK TABLES `dental_evaluation_est` WRITE;
/*!40000 ALTER TABLE `dental_evaluation_est` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_evaluation_est` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_evaluation_new`
--

DROP TABLE IF EXISTS `dental_evaluation_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_evaluation_new` (
  `evaluation_newid` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_new` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`evaluation_newid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_evaluation_new`
--

LOCK TABLES `dental_evaluation_new` WRITE;
/*!40000 ALTER TABLE `dental_evaluation_new` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_evaluation_new` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page1`
--

DROP TABLE IF EXISTS `dental_ex_page1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page1` (
  `ex_page1id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `blood_pressure` varchar(255) DEFAULT NULL,
  `pulse` varchar(255) DEFAULT NULL,
  `neck_measurement` varchar(255) DEFAULT NULL,
  `bmi` varchar(255) DEFAULT NULL,
  `additional_paragraph` text,
  `tongue` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ex_page1id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page1`
--

LOCK TABLES `dental_ex_page1` WRITE;
/*!40000 ALTER TABLE `dental_ex_page1` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page2`
--

DROP TABLE IF EXISTS `dental_ex_page2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page2` (
  `ex_page2id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `mallampati` varchar(255) DEFAULT NULL,
  `tonsils` text,
  `tonsils_grade` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `additional_notes` text,
  PRIMARY KEY (`ex_page2id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page2`
--

LOCK TABLES `dental_ex_page2` WRITE;
/*!40000 ALTER TABLE `dental_ex_page2` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page3`
--

DROP TABLE IF EXISTS `dental_ex_page3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page3` (
  `ex_page3id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `maxilla` text,
  `other_maxilla` text,
  `mandible` text,
  `other_mandible` text,
  `soft_palate` text,
  `other_soft_palate` text,
  `uvula` text,
  `other_uvula` text,
  `gag_reflex` text,
  `other_gag_reflex` text,
  `nasal_passages` text,
  `other_nasal_passages` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ex_page3id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page3`
--

LOCK TABLES `dental_ex_page3` WRITE;
/*!40000 ALTER TABLE `dental_ex_page3` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page4`
--

DROP TABLE IF EXISTS `dental_ex_page4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page4` (
  `ex_page4id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `exam_teeth` text,
  `other_exam_teeth` text,
  `caries` varchar(255) DEFAULT NULL,
  `where_facets` varchar(255) DEFAULT NULL,
  `cracked_fractured` varchar(255) DEFAULT NULL,
  `old_worn_inadequate_restorations` varchar(255) DEFAULT NULL,
  `dental_class_right` varchar(255) DEFAULT NULL,
  `dental_division_right` varchar(255) DEFAULT NULL,
  `dental_class_left` varchar(255) DEFAULT NULL,
  `dental_division_left` varchar(255) DEFAULT NULL,
  `additional_paragraph` text,
  `initial_tooth` text,
  `open_proximal` text,
  `deistema` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `missing` varchar(255) DEFAULT NULL,
  `crossbite` text,
  PRIMARY KEY (`ex_page4id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page4`
--

LOCK TABLES `dental_ex_page4` WRITE;
/*!40000 ALTER TABLE `dental_ex_page4` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page5`
--

DROP TABLE IF EXISTS `dental_ex_page5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page5` (
  `ex_page5id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `palpationid` text,
  `palpationRid` text,
  `additional_paragraph_pal` text,
  `joint_exam` text,
  `jointid` text,
  `i_opening_from` varchar(255) DEFAULT NULL,
  `i_opening_to` varchar(255) DEFAULT NULL,
  `i_opening_equal` varchar(255) DEFAULT NULL,
  `protrusion_from` varchar(255) DEFAULT NULL,
  `protrusion_to` varchar(255) DEFAULT NULL,
  `protrusion_equal` varchar(255) DEFAULT NULL,
  `l_lateral_from` varchar(255) DEFAULT NULL,
  `l_lateral_to` varchar(255) DEFAULT NULL,
  `l_lateral_equal` varchar(255) DEFAULT NULL,
  `r_lateral_from` varchar(255) DEFAULT NULL,
  `r_lateral_to` varchar(255) DEFAULT NULL,
  `r_lateral_equal` varchar(255) DEFAULT NULL,
  `deviation_from` varchar(255) DEFAULT NULL,
  `deviation_to` varchar(255) DEFAULT NULL,
  `deviation_equal` varchar(255) DEFAULT NULL,
  `deflection_from` varchar(255) DEFAULT NULL,
  `deflection_to` varchar(255) DEFAULT NULL,
  `deflection_equal` varchar(255) DEFAULT NULL,
  `range_normal` varchar(255) DEFAULT NULL,
  `normal` varchar(255) DEFAULT NULL,
  `other_range_motion` text,
  `additional_paragraph_rm` text,
  `screening_aware` varchar(255) DEFAULT NULL,
  `screening_normal` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `deviation_r_l` varchar(255) DEFAULT NULL,
  `deflection_r_l` varchar(255) DEFAULT NULL,
  `dentaldevice` int(11) DEFAULT NULL,
  `dentaldevice_date` date DEFAULT NULL,
  PRIMARY KEY (`ex_page5id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page5`
--

LOCK TABLES `dental_ex_page5` WRITE;
/*!40000 ALTER TABLE `dental_ex_page5` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page5` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page6`
--

DROP TABLE IF EXISTS `dental_ex_page6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page6` (
  `ex_page6id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `completed` text,
  `recommended` text,
  `other_diagnostic` text,
  `additional_paragraph` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ex_page6id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page6`
--

LOCK TABLES `dental_ex_page6` WRITE;
/*!40000 ALTER TABLE `dental_ex_page6` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page6` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page7`
--

DROP TABLE IF EXISTS `dental_ex_page7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page7` (
  `ex_page7id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `sleep_study_on` varchar(255) DEFAULT NULL,
  `sleep_study_by` varchar(255) DEFAULT NULL,
  `assessment_chk` varchar(50) DEFAULT '0',
  `assessment_chkyes` varchar(50) NOT NULL,
  `assessment` text,
  `assess_addition` text,
  `consultation` text,
  `evaluation_new` text,
  `evaluation_est` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `additional_paragraph_candidate` text,
  `additional_paragraph_suffers` text,
  PRIMARY KEY (`ex_page7id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page7`
--

LOCK TABLES `dental_ex_page7` WRITE;
/*!40000 ALTER TABLE `dental_ex_page7` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ex_page8`
--

DROP TABLE IF EXISTS `dental_ex_page8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ex_page8` (
  `ex_page8id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `inserted` text,
  `recommended` text,
  `other_inserted` text,
  `other_recommended` text,
  `see_number` int(11) DEFAULT NULL,
  `see_type` varchar(50) DEFAULT NULL,
  `followup` text,
  `additional_paragraph_followup` text,
  `referring` text,
  `plan_enable_referral` varchar(50) NOT NULL,
  `additional_paragraph_referral` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ex_page8id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ex_page8`
--

LOCK TABLES `dental_ex_page8` WRITE;
/*!40000 ALTER TABLE `dental_ex_page8` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ex_page8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_exam_teeth`
--

DROP TABLE IF EXISTS `dental_exam_teeth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_exam_teeth` (
  `exam_teethid` int(11) NOT NULL AUTO_INCREMENT,
  `exam_teeth` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`exam_teethid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_exam_teeth`
--

LOCK TABLES `dental_exam_teeth` WRITE;
/*!40000 ALTER TABLE `dental_exam_teeth` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_exam_teeth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_fax_error_codes`
--

DROP TABLE IF EXISTS `dental_fax_error_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_fax_error_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `error_code` varchar(10) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `resolution` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_fax_error_codes`
--

LOCK TABLES `dental_fax_error_codes` WRITE;
/*!40000 ALTER TABLE `dental_fax_error_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_fax_error_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_fax_invoice`
--

DROP TABLE IF EXISTS `dental_fax_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_fax_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_fax_invoice`
--

LOCK TABLES `dental_fax_invoice` WRITE;
/*!40000 ALTER TABLE `dental_fax_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_fax_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_faxes`
--

DROP TABLE IF EXISTS `dental_faxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_faxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `pages` int(2) DEFAULT NULL,
  `contactid` int(11) DEFAULT NULL,
  `to_number` varchar(15) DEFAULT NULL,
  `to_name` varchar(50) DEFAULT NULL,
  `letterid` int(11) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `fax_invoice_id` int(11) DEFAULT NULL,
  `sfax_transmission_id` varchar(255) DEFAULT NULL,
  `sfax_response` text,
  `sfax_completed` tinyint(1) DEFAULT '0',
  `sfax_status` tinyint(1) DEFAULT '0',
  `sfax_error_code` varchar(20) DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT '0',
  `letter_body` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_faxes`
--

LOCK TABLES `dental_faxes` WRITE;
/*!40000 ALTER TABLE `dental_faxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_faxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_fcontact`
--

DROP TABLE IF EXISTS `dental_fcontact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_fcontact` (
  `contactid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `add1` varchar(255) DEFAULT NULL,
  `add2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `greeting` varchar(255) DEFAULT NULL,
  `sincerely` varchar(255) DEFAULT NULL,
  `contacttypeid` int(11) DEFAULT '0',
  `notes` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`contactid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_fcontact`
--

LOCK TABLES `dental_fcontact` WRITE;
/*!40000 ALTER TABLE `dental_fcontact` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_fcontact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_fcontacttype`
--

DROP TABLE IF EXISTS `dental_fcontacttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_fcontacttype` (
  `contacttypeid` int(11) NOT NULL DEFAULT '0',
  `contacttype` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_fcontacttype`
--

LOCK TABLES `dental_fcontacttype` WRITE;
/*!40000 ALTER TABLE `dental_fcontacttype` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_fcontacttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_flow_pg1`
--

DROP TABLE IF EXISTS `dental_flow_pg1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_flow_pg1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copyreqdate` varchar(255) NOT NULL,
  `referred_by` varchar(255) NOT NULL,
  `thxletter` varchar(255) NOT NULL,
  `queststartdate` varchar(255) NOT NULL,
  `questcompdate` varchar(255) NOT NULL,
  `insinforec` varchar(255) NOT NULL,
  `rxreq` varchar(255) NOT NULL,
  `rxrec` varchar(255) NOT NULL,
  `lomnreq` varchar(255) NOT NULL,
  `lomnrec` varchar(255) NOT NULL,
  `clinnotereq` varchar(255) NOT NULL,
  `clinnoterec` varchar(255) NOT NULL,
  `contact_location` varchar(255) NOT NULL,
  `questsendmeth` varchar(255) NOT NULL,
  `questsender` varchar(255) NOT NULL,
  `refneed` varchar(255) NOT NULL,
  `refneeddate1` varchar(255) NOT NULL,
  `refneeddate2` varchar(255) NOT NULL,
  `preauth` varchar(255) NOT NULL,
  `preauth1` varchar(255) NOT NULL,
  `preauth2` varchar(255) NOT NULL,
  `insverbendate1` varchar(255) NOT NULL,
  `insverbendate2` varchar(255) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `referreddate` varchar(255) NOT NULL,
  `rx_imgid` int(11) DEFAULT NULL,
  `lomn_imgid` int(11) DEFAULT NULL,
  `notes_imgid` int(11) DEFAULT NULL,
  `rxlomn_imgid` int(11) DEFAULT NULL,
  `rxlomnrec` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_flow_pg1`
--

LOCK TABLES `dental_flow_pg1` WRITE;
/*!40000 ALTER TABLE `dental_flow_pg1` DISABLE KEYS */;
INSERT INTO `dental_flow_pg1` VALUES (230,'01/28/2014','','','','','','','','','','','','','','','','','','','','','','','467','',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dental_flow_pg1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_flow_pg2`
--

DROP TABLE IF EXISTS `dental_flow_pg2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_flow_pg2` (
  `patientid` varchar(255) NOT NULL,
  `steparray` varchar(255) NOT NULL,
  PRIMARY KEY (`patientid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_flow_pg2`
--

LOCK TABLES `dental_flow_pg2` WRITE;
/*!40000 ALTER TABLE `dental_flow_pg2` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_flow_pg2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_flow_pg2_info`
--

DROP TABLE IF EXISTS `dental_flow_pg2_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_flow_pg2_info` (
  `patientid` int(11) DEFAULT NULL,
  `stepid` int(11) DEFAULT NULL,
  `segmentid` int(11) DEFAULT NULL,
  `date_scheduled` date DEFAULT NULL,
  `date_completed` date DEFAULT NULL,
  `delay_reason` varchar(32) DEFAULT NULL,
  `study_type` varchar(16) DEFAULT NULL,
  `letterid` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `noncomp_reason` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_date` date DEFAULT NULL,
  `appointment_type` tinyint(1) NOT NULL DEFAULT '1',
  `device_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patientid` (`patientid`),
  KEY `segmentid` (`segmentid`)
) ENGINE=MyISAM AUTO_INCREMENT=1347 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_flow_pg2_info`
--

LOCK TABLES `dental_flow_pg2_info` WRITE;
/*!40000 ALTER TABLE `dental_flow_pg2_info` DISABLE KEYS */;
INSERT INTO `dental_flow_pg2_info` VALUES (467,1,1,'0000-00-00','2014-01-28',NULL,NULL,NULL,NULL,NULL,1346,NULL,1,NULL);
/*!40000 ALTER TABLE `dental_flow_pg2_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_flowsheet`
--

DROP TABLE IF EXISTS `dental_flowsheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_flowsheet` (
  `flowsheetid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `inquiry_call_apt` varchar(255) DEFAULT NULL,
  `inquiry_call_comp` varchar(255) DEFAULT NULL,
  `send_np` varchar(255) DEFAULT NULL,
  `send_np_comp` varchar(255) DEFAULT NULL,
  `acquire_ss_apt` varchar(255) DEFAULT NULL,
  `acquire_ss_comp` varchar(255) DEFAULT NULL,
  `referral_dss_apt` varchar(255) DEFAULT NULL,
  `referral_dss_comp` varchar(255) DEFAULT NULL,
  `ss_requested_apt` varchar(255) DEFAULT NULL,
  `ss_requested_comp` varchar(255) DEFAULT NULL,
  `ss_received_apt` varchar(255) DEFAULT NULL,
  `ss_received_comp` varchar(255) DEFAULT NULL,
  `consultation_apt` varchar(255) DEFAULT NULL,
  `consultation_comp` varchar(255) DEFAULT NULL,
  `m_insurance_apt` varchar(255) DEFAULT NULL,
  `m_insurance_comp` varchar(255) DEFAULT NULL,
  `select_type` varchar(255) DEFAULT NULL,
  `exam_impressions_apt` varchar(255) DEFAULT NULL,
  `exam_impressions_comp` varchar(255) DEFAULT NULL,
  `ltr_physicians_apt` varchar(255) DEFAULT NULL,
  `ltr_physicians_comp` varchar(255) DEFAULT NULL,
  `ltr_marketing_apt` varchar(255) DEFAULT NULL,
  `ltr_marketing_comp` varchar(255) DEFAULT NULL,
  `delivery_device_apt` varchar(255) DEFAULT NULL,
  `delivery_device_comp` varchar(255) DEFAULT NULL,
  `ltr_marketing_pt_apt` varchar(255) DEFAULT NULL,
  `ltr_marketing_pt_comp` varchar(255) DEFAULT NULL,
  `ltr_corr_phy_apt` varchar(255) DEFAULT NULL,
  `ltr_corr_phy_comp` varchar(255) DEFAULT NULL,
  `first_check_apt` varchar(255) DEFAULT NULL,
  `first_check_comp` varchar(255) DEFAULT NULL,
  `add_check_apt` varchar(255) DEFAULT NULL,
  `add_check_comp` varchar(255) DEFAULT NULL,
  `home_sleep_apt` varchar(255) DEFAULT NULL,
  `home_sleep_comp` varchar(255) DEFAULT NULL,
  `further_checks_apt` varchar(255) DEFAULT NULL,
  `further_checks_comp` varchar(255) DEFAULT NULL,
  `comp_treatment_apt` varchar(255) DEFAULT NULL,
  `comp_treatment_comp` varchar(255) DEFAULT NULL,
  `ltr_copy_ss_apt` varchar(255) DEFAULT NULL,
  `ltr_copy_ss_comp` varchar(255) DEFAULT NULL,
  `annual_exam_apt` varchar(255) DEFAULT NULL,
  `annual_exam_comp` varchar(255) DEFAULT NULL,
  `pos_home_sleep_apt` varchar(255) DEFAULT NULL,
  `pos_home_sleep_comp` varchar(255) DEFAULT NULL,
  `ltr_corr_phy1_apt` varchar(255) DEFAULT NULL,
  `ltr_corr_phy1_comp` varchar(255) DEFAULT NULL,
  `ambulatory_ss_apt` varchar(255) DEFAULT NULL,
  `ambulatory_ss_comp` varchar(255) DEFAULT NULL,
  `diag_s_md_apt` varchar(255) DEFAULT NULL,
  `diag_s_md_comp` varchar(255) DEFAULT NULL,
  `psg_apt` varchar(255) DEFAULT NULL,
  `psg_comp` varchar(255) DEFAULT NULL,
  `pt_not_ds_apt` varchar(255) DEFAULT NULL,
  `pt_not_ds_comp` varchar(255) DEFAULT NULL,
  `not_candidate_apt` varchar(255) DEFAULT NULL,
  `not_candidate_comp` varchar(255) DEFAULT NULL,
  `fin_restraints_apt` varchar(255) DEFAULT NULL,
  `fin_restraints_comp` varchar(255) DEFAULT NULL,
  `pt_needing_apt` varchar(255) DEFAULT NULL,
  `pt_needing_comp` varchar(255) DEFAULT NULL,
  `inadequate_apt` varchar(255) DEFAULT NULL,
  `inadequate_comp` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `step` int(2) NOT NULL DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`flowsheetid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_flowsheet`
--

LOCK TABLES `dental_flowsheet` WRITE;
/*!40000 ALTER TABLE `dental_flowsheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_flowsheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_flowsheet_new`
--

DROP TABLE IF EXISTS `dental_flowsheet_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_flowsheet_new` (
  `flowsheetid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `inquiry_call_comp` varchar(255) DEFAULT NULL,
  `send_np` varchar(255) DEFAULT NULL,
  `send_np_comp` varchar(255) DEFAULT NULL,
  `acquire_ss_apt` varchar(255) DEFAULT NULL,
  `acquire_ss_comp` varchar(255) DEFAULT NULL,
  `pt_not_ss` varchar(255) DEFAULT NULL,
  `ss_date_requested` varchar(255) DEFAULT NULL,
  `ss_date_received` varchar(255) DEFAULT NULL,
  `date_referred` varchar(255) DEFAULT NULL,
  `dss_dentists` varchar(255) DEFAULT NULL,
  `ss_requested_apt` varchar(255) DEFAULT NULL,
  `ss_requested_comp` varchar(255) DEFAULT NULL,
  `ss_received_apt` varchar(255) DEFAULT NULL,
  `ss_received_comp` varchar(255) DEFAULT NULL,
  `consultation_apt` varchar(255) DEFAULT NULL,
  `consultation_comp` varchar(255) DEFAULT NULL,
  `m_insurance_date` varchar(255) DEFAULT NULL,
  `select_type` varchar(255) DEFAULT NULL,
  `exam_impressions_apt` varchar(255) DEFAULT NULL,
  `exam_impressions_comp` varchar(255) DEFAULT NULL,
  `dsr_prepared` varchar(255) DEFAULT NULL,
  `dsr_sent` varchar(255) DEFAULT NULL,
  `delivery_device_apt` varchar(255) DEFAULT NULL,
  `delivery_device_comp` varchar(255) DEFAULT NULL,
  `dsr_date_delivered` varchar(255) DEFAULT NULL,
  `ltr_phy_prepared` varchar(255) DEFAULT NULL,
  `ltr_phy_sent` varchar(255) DEFAULT NULL,
  `first_check_apt` varchar(255) DEFAULT NULL,
  `first_check_comp` varchar(255) DEFAULT NULL,
  `add_check_apt` varchar(255) DEFAULT NULL,
  `add_check_comp` varchar(255) DEFAULT NULL,
  `home_sleep_apt` varchar(255) DEFAULT NULL,
  `home_sleep_comp` varchar(255) DEFAULT NULL,
  `further_checks_apt` varchar(255) DEFAULT NULL,
  `further_checks_comp` varchar(255) DEFAULT NULL,
  `comp_treatment_date` varchar(255) DEFAULT NULL,
  `portable_date_comp` varchar(255) DEFAULT NULL,
  `treatment_success` varchar(255) DEFAULT NULL,
  `ltr_doc_ss_date_prepared` varchar(255) DEFAULT NULL,
  `ltr_doc_ss_date_sent` varchar(255) DEFAULT NULL,
  `annual_exam_apt` varchar(255) DEFAULT NULL,
  `annual_exam_comp` varchar(255) DEFAULT NULL,
  `ltr_doc_pt_date_prepared` varchar(255) DEFAULT NULL,
  `ltr_doc_pt_date_sent` varchar(255) DEFAULT NULL,
  `ambulatory_ss_apt` varchar(255) DEFAULT NULL,
  `ambulatory_ss_comp` varchar(255) DEFAULT NULL,
  `diag_s_md_sent` varchar(255) DEFAULT NULL,
  `diag_s_md_received` varchar(255) DEFAULT NULL,
  `psg_apt` varchar(255) DEFAULT NULL,
  `psg_comp` varchar(255) DEFAULT NULL,
  `sleep_lab` varchar(255) DEFAULT NULL,
  `lomn` varchar(255) NOT NULL,
  `rxfrommd` varchar(255) NOT NULL,
  `not_candidate` varchar(255) DEFAULT NULL,
  `financial_restraints` varchar(255) DEFAULT NULL,
  `pt_needing_dental_work` varchar(255) DEFAULT NULL,
  `inadequate_dentition` varchar(255) DEFAULT NULL,
  `pt_not_ds_other` varchar(255) DEFAULT NULL,
  `ltr_pp_date_prepared` varchar(255) DEFAULT NULL,
  `ltr_pp_date_sent` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `step` int(2) NOT NULL DEFAULT '0',
  `sstep` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`flowsheetid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_flowsheet_new`
--

LOCK TABLES `dental_flowsheet_new` WRITE;
/*!40000 ALTER TABLE `dental_flowsheet_new` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_flowsheet_new` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_flowsheet_steps`
--

DROP TABLE IF EXISTS `dental_flowsheet_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_flowsheet_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_flowsheet_steps`
--

LOCK TABLES `dental_flowsheet_steps` WRITE;
/*!40000 ALTER TABLE `dental_flowsheet_steps` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_flowsheet_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_flowsheet_steps_next`
--

DROP TABLE IF EXISTS `dental_flowsheet_steps_next`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_flowsheet_steps_next` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `child_id` int(11) DEFAULT NULL,
  `sort_by` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_flowsheet_steps_next`
--

LOCK TABLES `dental_flowsheet_steps_next` WRITE;
/*!40000 ALTER TABLE `dental_flowsheet_steps_next` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_flowsheet_steps_next` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_followup`
--

DROP TABLE IF EXISTS `dental_followup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_followup` (
  `followupid` int(11) NOT NULL AUTO_INCREMENT,
  `followup` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`followupid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_followup`
--

LOCK TABLES `dental_followup` WRITE;
/*!40000 ALTER TABLE `dental_followup` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_followup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_forms`
--

DROP TABLE IF EXISTS `dental_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_forms` (
  `formid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `formtype` int(11) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`formid`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_forms`
--

LOCK TABLES `dental_forms` WRITE;
/*!40000 ALTER TABLE `dental_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_gag_reflex`
--

DROP TABLE IF EXISTS `dental_gag_reflex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_gag_reflex` (
  `gag_reflexid` int(11) NOT NULL AUTO_INCREMENT,
  `gag_reflex` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`gag_reflexid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_gag_reflex`
--

LOCK TABLES `dental_gag_reflex` WRITE;
/*!40000 ALTER TABLE `dental_gag_reflex` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_gag_reflex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_history`
--

DROP TABLE IF EXISTS `dental_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_history` (
  `historyid` int(11) NOT NULL AUTO_INCREMENT,
  `history` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`historyid`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_history`
--

LOCK TABLES `dental_history` WRITE;
/*!40000 ALTER TABLE `dental_history` DISABLE KEYS */;
INSERT INTO `dental_history` VALUES (1,'Anemia','',44,1,'2010-03-10 16:20:30','192.168.1.55'),(2,'Arteriosclerosis',NULL,999,1,'2010-03-10 16:23:11','192.168.1.55'),(3,'Asthma',NULL,46,1,'2010-03-10 16:23:11','192.168.1.55'),(4,'Autoimmune disorders',NULL,47,1,'2010-03-10 16:23:11','192.168.1.55'),(5,'Bleeding easily',NULL,999,1,'2010-03-10 16:23:11','192.168.1.55'),(6,'Chronic sinus problems',NULL,999,1,'2010-03-10 16:23:11','192.168.1.55'),(7,'Chronic fatigue',NULL,49,1,'2010-03-10 16:23:11','192.168.1.55'),(8,'Congestive heart failure',NULL,999,1,'2010-03-10 16:23:11','192.168.1.55'),(9,'Current pregnancy or Nursing','',55,1,'2010-03-10 16:23:11','192.168.1.55'),(10,'Diabetes',NULL,999,1,'2010-03-10 16:23:11','192.168.1.55'),(11,'Difficulty concentrating',NULL,56,1,'2010-03-10 16:23:11','192.168.1.55'),(12,'Dizziness',NULL,1,1,'2010-03-10 16:23:11','192.168.1.55'),(14,'Epilepsy',NULL,58,1,'2010-04-14 14:00:05','192.168.1.55'),(15,'Fibromyalgla',NULL,59,1,'2010-04-14 14:00:05','192.168.1.55'),(16,'Frequent sore throats',NULL,60,1,'2010-04-14 14:00:05','192.168.1.55'),(17,'Gastroesophageal Reflux Disease (GERD)',NULL,41,1,'2010-04-14 14:00:05','192.168.1.55'),(18,'Hayfever',NULL,62,1,'2010-04-14 14:00:05','192.168.1.55'),(19,'Heart disorder',NULL,42,1,'2010-04-14 14:00:05','192.168.1.55'),(20,'Heart murmur',NULL,63,1,'2010-04-14 14:00:05','192.168.1.55'),(21,'Heart pounding or beating irregular during the night',NULL,999,1,'2010-04-14 14:00:05','192.168.1.55'),(22,'Heart pacemaker',NULL,43,1,'2010-04-14 14:05:13','192.168.1.55'),(23,'Heart valve replacement',NULL,999,1,'2010-04-14 14:05:13','192.168.1.55'),(24,'Heartburn or a sour taste in the mouth at night',NULL,999,1,'2010-04-14 14:05:13','192.168.1.55'),(25,'Hepatitis',NULL,999,1,'2010-04-14 14:05:13','192.168.1.55'),(26,'High blood pressure',NULL,999,1,'2010-04-14 14:05:13','192.168.1.55'),(27,'Immune system disorder',NULL,41,1,'2010-04-14 14:05:13','192.168.1.55'),(33,'Irregular heart beat',NULL,999,1,'2010-04-14 14:05:13','192.168.1.55'),(35,'Hypoglycemia (Low blood surgery)','',999,1,'2010-04-14 14:05:13','192.168.1.55'),(36,'Memory loss',NULL,999,1,'2010-04-14 14:05:13','192.168.1.55'),(37,'Migraines',NULL,999,1,'2010-04-14 14:05:13','192.168.1.55'),(39,'Muscle spasms or cramps',NULL,2,1,'2010-04-14 14:05:13','192.168.1.55'),(40,'Needing extra pillows to help breathing at night',NULL,40,1,'2010-04-14 14:05:13','192.168.1.55'),(41,'Nighttime sweating',NULL,41,1,'2010-04-14 14:09:13','192.168.1.55'),(42,'Osteoarthritis',NULL,42,1,'2010-04-14 14:09:13','192.168.1.55'),(43,'Osteoporosis',NULL,43,1,'2010-04-14 14:09:13','192.168.1.55'),(44,'Poor circulation',NULL,44,1,'2010-04-14 14:09:13','192.168.1.55'),(46,'Recent excessive weight gain',NULL,46,1,'2010-04-14 14:09:13','192.168.1.55'),(47,'Rheumatic fever',NULL,47,1,'2010-04-14 14:09:13','192.168.1.55'),(48,'Shortness of breath',NULL,48,1,'2010-04-14 14:09:13','192.168.1.55'),(49,'Swollen, stiff or painful joints',NULL,49,1,'2010-04-14 14:09:13','192.168.1.55'),(50,'Thyroid Problems',NULL,50,1,'2010-04-14 14:09:13','192.168.1.55'),(51,'Tonsillectomy (has had)',NULL,51,1,'2010-04-14 14:09:13','192.168.1.55'),(53,'Heart Attack','',999,1,'2010-05-03 17:00:32','122.169.48.127'),(54,'Angina/Chest Pain',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(55,'Mitral Valve Prolapse',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(56,'Scarlet Fever',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(57,'Heart Surgery',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(58,'Low Blood Pressure',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(59,'Hemophilia',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(60,'Leukemia',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(61,'Lung Disease',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(62,'Breathing Problems',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(63,'Emphysema',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(64,'Tuberculosis',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(65,'Cancer/Tumors',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(66,'Radiation',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(67,'Chemotherapy',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(68,'Stomach Disorders',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(69,'Ulcers',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(70,'Liver Disease',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(71,'Jaundice',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(72,'Kidney Problems',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(73,'Arthritis/Gout',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(74,'Rheumatism',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(75,'Artificial joints',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(76,'HIV',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(77,'AIDS or HIV','',999,1,'2010-05-05 12:20:20','59.181.135.49'),(78,'Nervousness',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(79,'Psychiatric Care',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(80,'Alzheimer\'s','',999,1,'2010-05-05 12:20:20','59.181.135.49'),(81,'Stroke',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49'),(82,'Parkinson\'s','',999,1,'2010-05-05 12:20:20','59.181.135.49'),(83,'Bulimia/Anorexia',NULL,999,1,'2010-05-05 12:20:20','59.181.135.49');
/*!40000 ALTER TABLE `dental_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_hst`
--

DROP TABLE IF EXISTS `dental_hst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_hst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `screener_id` int(11) DEFAULT NULL,
  `ins_co_id` int(11) DEFAULT NULL,
  `ins_phone` varchar(30) DEFAULT NULL,
  `patient_ins_group_id` varchar(255) DEFAULT NULL,
  `patient_ins_id` varchar(255) DEFAULT NULL,
  `patient_firstname` varchar(255) DEFAULT NULL,
  `patient_lastname` varchar(255) DEFAULT NULL,
  `patient_add1` varchar(255) DEFAULT NULL,
  `patient_add2` varchar(255) DEFAULT NULL,
  `patient_city` varchar(255) DEFAULT NULL,
  `patient_state` varchar(255) DEFAULT NULL,
  `patient_zip` varchar(255) DEFAULT NULL,
  `patient_dob` date DEFAULT NULL,
  `patient_cell_phone` varchar(30) DEFAULT NULL,
  `patient_home_phone` varchar(30) DEFAULT NULL,
  `patient_email` varchar(100) DEFAULT NULL,
  `diagnosis_id` int(11) DEFAULT NULL,
  `hst_type` int(11) DEFAULT NULL,
  `provider_firstname` varchar(255) DEFAULT NULL,
  `provider_lastname` varchar(255) DEFAULT NULL,
  `provider_address` varchar(255) DEFAULT NULL,
  `provider_city` varchar(255) DEFAULT NULL,
  `provider_state` varchar(255) DEFAULT NULL,
  `provider_zip` varchar(255) DEFAULT NULL,
  `provider_signature` varchar(100) DEFAULT NULL,
  `provider_date` date DEFAULT NULL,
  `snore_1` tinyint(1) DEFAULT NULL,
  `snore_2` tinyint(1) DEFAULT NULL,
  `snore_3` tinyint(1) DEFAULT NULL,
  `snore_4` tinyint(1) DEFAULT NULL,
  `snore_5` tinyint(1) DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT '0',
  `status` int(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `office_notes` text,
  `hst_filename` varchar(200) DEFAULT NULL,
  `authorized_id` int(11) DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `authorizeddate` datetime DEFAULT NULL,
  `sleep_study_id` int(11) DEFAULT NULL,
  `rejected_reason` text,
  `rejecteddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_hst`
--

LOCK TABLES `dental_hst` WRITE;
/*!40000 ALTER TABLE `dental_hst` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_hst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_hst_epworth`
--

DROP TABLE IF EXISTS `dental_hst_epworth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_hst_epworth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hst_id` int(11) DEFAULT NULL,
  `epworth_id` int(11) DEFAULT NULL,
  `response` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=581 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_hst_epworth`
--

LOCK TABLES `dental_hst_epworth` WRITE;
/*!40000 ALTER TABLE `dental_hst_epworth` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_hst_epworth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_imagetype`
--

DROP TABLE IF EXISTS `dental_imagetype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_imagetype` (
  `imagetypeid` int(11) NOT NULL AUTO_INCREMENT,
  `imagetype` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`imagetypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_imagetype`
--

LOCK TABLES `dental_imagetype` WRITE;
/*!40000 ALTER TABLE `dental_imagetype` DISABLE KEYS */;
INSERT INTO `dental_imagetype` VALUES (1,'Sleep Studies','',1,1,'2010-06-18 11:24:16','192.168.1.55'),(2,'Radiographs',NULL,2,1,'2010-06-18 11:25:21','192.168.1.55'),(3,'Photos',NULL,3,1,'2010-06-18 11:25:21','192.168.1.55'),(4,'Profile (face photo)',NULL,4,1,'2010-06-18 11:25:21','192.168.1.55'),(5,'Other',NULL,5,1,'2010-06-18 11:25:21','192.168.1.55'),(6,'Rx','',6,1,'2011-02-23 12:47:23','97.78.153.94'),(7,'LOMN','',7,1,'2011-02-23 12:47:40','97.78.153.94'),(8,'Clincal Notes','',8,1,'2011-02-23 12:48:28','97.78.153.94'),(9,'Explanation of Benefits','',9,1,'2011-06-21 13:36:37','192.168.1.168'),(10,'Insurance Card (Primary)','',11,1,'2011-10-13 20:24:54','128.12.179.41'),(11,'CPAP Affadavit','CPAP Intolerance Statement',10,1,'2012-01-27 11:09:28','108.9.57.240'),(12,'Insurance Card (Secondary)','',12,1,'2012-07-18 13:52:52','67.169.36.116'),(13,'Clinical Photos (Pre-Tx Individual)','',13,1,'2013-02-26 20:30:23','128.12.179.156'),(14,'LOMN/Rx (combined)','',7,1,'2013-07-24 10:54:17','96.8.134.56');
/*!40000 ALTER TABLE `dental_imagetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ins_diagnosis`
--

DROP TABLE IF EXISTS `dental_ins_diagnosis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ins_diagnosis` (
  `ins_diagnosisid` int(11) NOT NULL AUTO_INCREMENT,
  `ins_diagnosis` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`ins_diagnosisid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ins_diagnosis`
--

LOCK TABLES `dental_ins_diagnosis` WRITE;
/*!40000 ALTER TABLE `dental_ins_diagnosis` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ins_diagnosis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ins_payer`
--

DROP TABLE IF EXISTS `dental_ins_payer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ins_payer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `payer_id` varchar(50) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12502 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ins_payer`
--

LOCK TABLES `dental_ins_payer` WRITE;
/*!40000 ALTER TABLE `dental_ins_payer` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ins_payer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ins_type`
--

DROP TABLE IF EXISTS `dental_ins_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ins_type` (
  `ins_typeid` int(11) NOT NULL AUTO_INCREMENT,
  `ins_type` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`ins_typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ins_type`
--

LOCK TABLES `dental_ins_type` WRITE;
/*!40000 ALTER TABLE `dental_ins_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ins_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_insurance`
--

DROP TABLE IF EXISTS `dental_insurance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_insurance` (
  `insuranceid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `pica1` varchar(255) DEFAULT NULL,
  `pica2` varchar(255) DEFAULT NULL,
  `pica3` varchar(255) DEFAULT NULL,
  `insurance_type` text,
  `insured_id_number` varchar(255) DEFAULT NULL,
  `patient_firstname` varchar(255) DEFAULT NULL,
  `patient_lastname` varchar(255) DEFAULT NULL,
  `patient_middle` varchar(255) DEFAULT NULL,
  `patient_dob` varchar(255) DEFAULT NULL,
  `patient_sex` varchar(255) DEFAULT NULL,
  `insured_firstname` varchar(255) DEFAULT NULL,
  `insured_lastname` varchar(255) DEFAULT NULL,
  `insured_middle` varchar(255) DEFAULT NULL,
  `patient_address` varchar(255) DEFAULT NULL,
  `patient_relation_insured` varchar(255) DEFAULT NULL,
  `insured_address` varchar(255) DEFAULT NULL,
  `patient_city` varchar(255) DEFAULT NULL,
  `patient_state` varchar(255) DEFAULT NULL,
  `patient_status` text,
  `insured_city` varchar(255) DEFAULT NULL,
  `insured_state` varchar(255) DEFAULT NULL,
  `patient_zip` varchar(255) DEFAULT NULL,
  `patient_phone_code` varchar(255) DEFAULT NULL,
  `patient_phone` varchar(255) DEFAULT NULL,
  `insured_zip` varchar(255) DEFAULT NULL,
  `insured_phone_code` varchar(255) DEFAULT NULL,
  `insured_phone` varchar(255) DEFAULT NULL,
  `other_insured_firstname` varchar(255) DEFAULT NULL,
  `other_insured_lastname` varchar(255) DEFAULT NULL,
  `other_insured_middle` varchar(255) DEFAULT NULL,
  `employment` varchar(255) DEFAULT NULL,
  `auto_accident` varchar(255) DEFAULT NULL,
  `auto_accident_place` varchar(255) DEFAULT NULL,
  `other_accident` varchar(255) DEFAULT NULL,
  `insured_policy_group_feca` varchar(255) DEFAULT NULL,
  `other_insured_policy_group_feca` varchar(255) DEFAULT NULL,
  `insured_dob` varchar(255) DEFAULT NULL,
  `insured_sex` varchar(255) DEFAULT NULL,
  `other_insured_dob` varchar(255) DEFAULT NULL,
  `other_insured_sex` varchar(255) DEFAULT NULL,
  `insured_employer_school_name` varchar(255) DEFAULT NULL,
  `other_insured_employer_school_name` varchar(255) DEFAULT NULL,
  `insured_insurance_plan` varchar(255) DEFAULT NULL,
  `other_insured_insurance_plan` varchar(255) DEFAULT NULL,
  `reserved_local_use` varchar(255) DEFAULT NULL,
  `another_plan` varchar(255) DEFAULT NULL,
  `patient_signature` varchar(255) DEFAULT NULL,
  `patient_signed_date` varchar(255) DEFAULT NULL,
  `insured_signature` varchar(255) DEFAULT NULL,
  `date_current` varchar(255) DEFAULT NULL,
  `date_same_illness` varchar(255) DEFAULT NULL,
  `unable_date_from` varchar(255) DEFAULT NULL,
  `unable_date_to` varchar(255) DEFAULT NULL,
  `referring_provider` varchar(255) DEFAULT NULL,
  `field_17a_dd` varchar(255) DEFAULT NULL,
  `field_17a` varchar(255) DEFAULT NULL,
  `field_17b` varchar(255) DEFAULT NULL,
  `hospitalization_date_from` varchar(255) DEFAULT NULL,
  `hospitalization_date_to` varchar(255) DEFAULT NULL,
  `reserved_local_use1` varchar(255) DEFAULT NULL,
  `outside_lab` varchar(255) DEFAULT NULL,
  `s_charges` varchar(255) DEFAULT NULL,
  `diagnosis_1` varchar(255) DEFAULT NULL,
  `diagnosis_2` varchar(255) DEFAULT NULL,
  `diagnosis_3` varchar(255) DEFAULT NULL,
  `diagnosis_4` varchar(255) DEFAULT NULL,
  `medicaid_resubmission_code` varchar(255) DEFAULT NULL,
  `original_ref_no` varchar(255) DEFAULT NULL,
  `prior_authorization_number` varchar(255) DEFAULT NULL,
  `service_date1_from` varchar(255) DEFAULT NULL,
  `service_date1_to` varchar(255) DEFAULT NULL,
  `place_of_service1` varchar(255) DEFAULT NULL,
  `emg1` varchar(255) DEFAULT NULL,
  `cpt_hcpcs1` varchar(255) DEFAULT NULL,
  `modifier1_1` varchar(255) DEFAULT NULL,
  `modifier1_2` varchar(255) DEFAULT NULL,
  `modifier1_3` varchar(255) DEFAULT NULL,
  `modifier1_4` varchar(255) DEFAULT NULL,
  `diagnosis_pointer1` varchar(255) DEFAULT NULL,
  `s_charges1_1` varchar(255) DEFAULT NULL,
  `s_charges1_2` varchar(255) DEFAULT NULL,
  `days_or_units1` varchar(255) DEFAULT NULL,
  `epsdt_family_plan1` varchar(255) DEFAULT NULL,
  `id_qua1` varchar(255) DEFAULT NULL,
  `rendering_provider_id1` varchar(255) DEFAULT NULL,
  `service_date2_from` varchar(255) DEFAULT NULL,
  `service_date2_to` varchar(255) DEFAULT NULL,
  `place_of_service2` varchar(255) DEFAULT NULL,
  `emg2` varchar(255) DEFAULT NULL,
  `cpt_hcpcs2` varchar(255) DEFAULT NULL,
  `modifier2_1` varchar(255) DEFAULT NULL,
  `modifier2_2` varchar(255) DEFAULT NULL,
  `modifier2_3` varchar(255) DEFAULT NULL,
  `modifier2_4` varchar(255) DEFAULT NULL,
  `diagnosis_pointer2` varchar(255) DEFAULT NULL,
  `s_charges2_1` varchar(255) DEFAULT NULL,
  `s_charges2_2` varchar(255) DEFAULT NULL,
  `days_or_units2` varchar(255) DEFAULT NULL,
  `epsdt_family_plan2` varchar(255) DEFAULT NULL,
  `id_qua2` varchar(255) DEFAULT NULL,
  `rendering_provider_id2` varchar(255) DEFAULT NULL,
  `service_date3_from` varchar(255) DEFAULT NULL,
  `service_date3_to` varchar(255) DEFAULT NULL,
  `place_of_service3` varchar(255) DEFAULT NULL,
  `emg3` varchar(255) DEFAULT NULL,
  `cpt_hcpcs3` varchar(255) DEFAULT NULL,
  `modifier3_1` varchar(255) DEFAULT NULL,
  `modifier3_2` varchar(255) DEFAULT NULL,
  `modifier3_3` varchar(255) DEFAULT NULL,
  `modifier3_4` varchar(255) DEFAULT NULL,
  `diagnosis_pointer3` varchar(255) DEFAULT NULL,
  `s_charges3_1` varchar(255) DEFAULT NULL,
  `s_charges3_2` varchar(255) DEFAULT NULL,
  `days_or_units3` varchar(255) DEFAULT NULL,
  `epsdt_family_plan3` varchar(255) DEFAULT NULL,
  `id_qua3` varchar(255) DEFAULT NULL,
  `rendering_provider_id3` varchar(255) DEFAULT NULL,
  `service_date4_from` varchar(255) DEFAULT NULL,
  `service_date4_to` varchar(255) DEFAULT NULL,
  `place_of_service4` varchar(255) DEFAULT NULL,
  `emg4` varchar(255) DEFAULT NULL,
  `cpt_hcpcs4` varchar(255) DEFAULT NULL,
  `modifier4_1` varchar(255) DEFAULT NULL,
  `modifier4_2` varchar(255) DEFAULT NULL,
  `modifier4_3` varchar(255) DEFAULT NULL,
  `modifier4_4` varchar(255) DEFAULT NULL,
  `diagnosis_pointer4` varchar(255) DEFAULT NULL,
  `s_charges4_1` varchar(255) DEFAULT NULL,
  `s_charges4_2` varchar(255) DEFAULT NULL,
  `days_or_units4` varchar(255) DEFAULT NULL,
  `epsdt_family_plan4` varchar(255) DEFAULT NULL,
  `id_qua4` varchar(255) DEFAULT NULL,
  `rendering_provider_id4` varchar(255) DEFAULT NULL,
  `service_date5_from` varchar(255) DEFAULT NULL,
  `service_date5_to` varchar(255) DEFAULT NULL,
  `place_of_service5` varchar(255) DEFAULT NULL,
  `emg5` varchar(255) DEFAULT NULL,
  `cpt_hcpcs5` varchar(255) DEFAULT NULL,
  `modifier5_1` varchar(255) DEFAULT NULL,
  `modifier5_2` varchar(255) DEFAULT NULL,
  `modifier5_3` varchar(255) DEFAULT NULL,
  `modifier5_4` varchar(255) DEFAULT NULL,
  `diagnosis_pointer5` varchar(255) DEFAULT NULL,
  `s_charges5_1` varchar(255) DEFAULT NULL,
  `s_charges5_2` varchar(255) DEFAULT NULL,
  `days_or_units5` varchar(255) DEFAULT NULL,
  `epsdt_family_plan5` varchar(255) DEFAULT NULL,
  `id_qua5` varchar(255) DEFAULT NULL,
  `rendering_provider_id5` varchar(255) DEFAULT NULL,
  `service_date6_from` varchar(255) DEFAULT NULL,
  `service_date6_to` varchar(255) DEFAULT NULL,
  `place_of_service6` varchar(255) DEFAULT NULL,
  `emg6` varchar(255) DEFAULT NULL,
  `cpt_hcpcs6` varchar(255) DEFAULT NULL,
  `modifier6_1` varchar(255) DEFAULT NULL,
  `modifier6_2` varchar(255) DEFAULT NULL,
  `modifier6_3` varchar(255) DEFAULT NULL,
  `modifier6_4` varchar(255) DEFAULT NULL,
  `diagnosis_pointer6` varchar(255) DEFAULT NULL,
  `s_charges6_1` varchar(255) DEFAULT NULL,
  `s_charges6_2` varchar(255) DEFAULT NULL,
  `days_or_units6` varchar(255) DEFAULT NULL,
  `epsdt_family_plan6` varchar(255) DEFAULT NULL,
  `id_qua6` varchar(255) DEFAULT NULL,
  `rendering_provider_id6` varchar(255) DEFAULT NULL,
  `federal_tax_id_number` varchar(255) DEFAULT NULL,
  `ssn` varchar(255) DEFAULT NULL,
  `ein` varchar(255) DEFAULT NULL,
  `patient_account_no` varchar(255) DEFAULT NULL,
  `accept_assignment` varchar(255) DEFAULT NULL,
  `total_charge` varchar(255) DEFAULT NULL,
  `amount_paid` varchar(255) DEFAULT NULL,
  `balance_due` varchar(255) DEFAULT NULL,
  `signature_physician` varchar(255) DEFAULT NULL,
  `physician_signed_date` varchar(255) DEFAULT NULL,
  `service_facility_info_name` varchar(255) DEFAULT NULL,
  `service_facility_info_address` varchar(255) DEFAULT NULL,
  `service_facility_info_city` varchar(255) DEFAULT NULL,
  `service_info_a` varchar(255) DEFAULT NULL,
  `service_info_dd` varchar(255) DEFAULT NULL,
  `service_info_b_other` varchar(255) DEFAULT NULL,
  `billing_provider_phone_code` varchar(255) DEFAULT NULL,
  `billing_provider_phone` varchar(255) DEFAULT NULL,
  `billing_provider_name` varchar(255) DEFAULT NULL,
  `billing_provider_address` varchar(255) DEFAULT NULL,
  `billing_provider_city` varchar(255) DEFAULT NULL,
  `billing_provider_a` varchar(255) DEFAULT NULL,
  `billing_provider_dd` varchar(255) DEFAULT NULL,
  `billing_provider_b_other` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '0',
  `card` tinyint(1) NOT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `dispute_reason` text,
  `sec_dispute_reason` text,
  `reject_reason` text,
  `primary_fdf` varchar(100) DEFAULT NULL,
  `secondary_fdf` varchar(100) DEFAULT NULL,
  `producer` int(11) DEFAULT NULL,
  `mailed_date` datetime DEFAULT NULL,
  `eligible_response` text,
  `p_m_eligible_payer_id` varchar(20) DEFAULT NULL,
  `p_m_eligible_payer_name` varchar(200) DEFAULT NULL,
  `sec_mailed_date` datetime DEFAULT NULL,
  PRIMARY KEY (`insuranceid`)
) ENGINE=MyISAM AUTO_INCREMENT=268 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_insurance`
--

LOCK TABLES `dental_insurance` WRITE;
/*!40000 ALTER TABLE `dental_insurance` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_insurance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_insurance_file`
--

DROP TABLE IF EXISTS `dental_insurance_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_insurance_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claimid` int(11) NOT NULL,
  `claimtype` enum('primary','secondary') DEFAULT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `description` text,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_insurance_file`
--

LOCK TABLES `dental_insurance_file` WRITE;
/*!40000 ALTER TABLE `dental_insurance_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_insurance_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_insurance_preauth`
--

DROP TABLE IF EXISTS `dental_insurance_preauth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_insurance_preauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `ins_co` varchar(255) DEFAULT NULL,
  `ins_rank` varchar(255) NOT NULL DEFAULT 'primary',
  `ins_phone` varchar(255) DEFAULT NULL,
  `patient_ins_group_id` varchar(255) DEFAULT NULL,
  `patient_ins_id` varchar(255) DEFAULT NULL,
  `patient_firstname` varchar(255) DEFAULT NULL,
  `patient_lastname` varchar(255) DEFAULT NULL,
  `patient_add1` varchar(255) DEFAULT NULL,
  `patient_add2` varchar(255) DEFAULT NULL,
  `patient_city` varchar(255) DEFAULT NULL,
  `patient_state` varchar(255) DEFAULT NULL,
  `patient_zip` varchar(255) DEFAULT NULL,
  `patient_dob` varchar(255) DEFAULT NULL,
  `insured_first_name` varchar(255) DEFAULT NULL,
  `insured_last_name` varchar(255) DEFAULT NULL,
  `insured_dob` varchar(255) DEFAULT NULL,
  `doc_npi` varchar(255) DEFAULT NULL,
  `referring_doc_npi` varchar(255) DEFAULT NULL,
  `trxn_code_amount` decimal(11,2) DEFAULT NULL,
  `diagnosis_code` varchar(255) DEFAULT NULL,
  `date_of_call` varchar(255) DEFAULT NULL,
  `insurance_rep` varchar(255) DEFAULT NULL,
  `call_reference_num` varchar(255) DEFAULT NULL,
  `doc_medicare_npi` varchar(255) DEFAULT NULL,
  `doc_tax_id_or_ssn` varchar(255) DEFAULT NULL,
  `ins_effective_date` varchar(255) DEFAULT NULL,
  `ins_cal_year_start` varchar(255) DEFAULT NULL,
  `ins_cal_year_end` varchar(255) DEFAULT NULL,
  `trxn_code_covered` int(1) NOT NULL DEFAULT '0',
  `code_covered_notes` text,
  `has_out_of_network_benefits` int(1) NOT NULL DEFAULT '0',
  `out_of_network_percentage` int(11) DEFAULT NULL,
  `is_hmo` int(1) NOT NULL DEFAULT '0',
  `hmo_date_called` varchar(255) DEFAULT NULL,
  `hmo_date_received` varchar(255) DEFAULT NULL,
  `hmo_needs_auth` int(1) NOT NULL DEFAULT '0',
  `hmo_auth_date_requested` varchar(255) DEFAULT NULL,
  `hmo_auth_date_received` varchar(255) DEFAULT NULL,
  `hmo_auth_notes` text,
  `in_network_percentage` int(11) DEFAULT NULL,
  `in_network_appeal_date_sent` varchar(255) DEFAULT NULL,
  `in_network_appeal_date_received` varchar(255) DEFAULT NULL,
  `is_pre_auth_required` int(1) DEFAULT '0',
  `verbal_pre_auth_name` varchar(255) DEFAULT NULL,
  `verbal_pre_auth_ref_num` varchar(255) DEFAULT NULL,
  `verbal_pre_auth_notes` text,
  `written_pre_auth_notes` text,
  `written_pre_auth_date_received` varchar(255) DEFAULT NULL,
  `front_office_request_date` datetime DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `patient_deductible` decimal(11,2) DEFAULT NULL,
  `patient_amount_met` decimal(11,2) DEFAULT NULL,
  `family_deductible` decimal(11,2) DEFAULT NULL,
  `family_amount_met` decimal(11,2) DEFAULT NULL,
  `deductible_reset_date` varchar(255) DEFAULT NULL,
  `out_of_pocket_met` int(1) NOT NULL DEFAULT '0',
  `patient_amount_left_to_meet` decimal(11,2) DEFAULT NULL,
  `expected_insurance_payment` decimal(11,2) DEFAULT NULL,
  `expected_patient_payment` decimal(11,2) DEFAULT NULL,
  `network_benefits` int(1) NOT NULL DEFAULT '0',
  `viewed` int(1) DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `how_often` varchar(255) DEFAULT NULL,
  `patient_phone` varchar(255) DEFAULT NULL,
  `pre_auth_num` varchar(255) DEFAULT NULL,
  `family_amount_left_to_meet` decimal(11,2) DEFAULT NULL,
  `deductible_from` int(1) NOT NULL DEFAULT '0',
  `reject_reason` text,
  `invoice_date` datetime DEFAULT NULL,
  `invoice_amount` decimal(11,2) DEFAULT NULL,
  `invoice_status` tinyint(1) DEFAULT '0',
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_insurance_preauth`
--

LOCK TABLES `dental_insurance_preauth` WRITE;
/*!40000 ALTER TABLE `dental_insurance_preauth` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_insurance_preauth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_insurance_status_history`
--

DROP TABLE IF EXISTS `dental_insurance_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_insurance_status_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insuranceid` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_insurance_status_history`
--

LOCK TABLES `dental_insurance_status_history` WRITE;
/*!40000 ALTER TABLE `dental_insurance_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_insurance_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_intolerance`
--

DROP TABLE IF EXISTS `dental_intolerance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_intolerance` (
  `intoleranceid` int(11) NOT NULL AUTO_INCREMENT,
  `intolerance` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`intoleranceid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_intolerance`
--

LOCK TABLES `dental_intolerance` WRITE;
/*!40000 ALTER TABLE `dental_intolerance` DISABLE KEYS */;
INSERT INTO `dental_intolerance` VALUES (1,'Mask leaks',NULL,1,1,'2010-03-10 15:18:12','192.168.1.55'),(2,'An inability to get the mask to fit properly',NULL,2,1,'2010-03-10 15:18:12','192.168.1.55'),(3,'Discomfort from the straps or headgear',NULL,3,1,'2010-03-10 15:18:30','192.168.1.55'),(4,'Decrease sleep quality or interrupted sleep from the CPAP device',NULL,4,1,'2010-03-10 15:18:30','192.168.1.55'),(5,'Noise from the device disrupting sleep and/or bedtime partner\\\'s sleep',NULL,5,1,'2010-03-10 15:18:30','192.168.1.55'),(6,'CPAP restricted movements during sleep','',6,1,'2010-03-10 15:18:46','192.168.1.55'),(7,'CPAP seems to be ineffective',NULL,7,1,'2010-03-10 15:19:26','192.168.1.55'),(8,'Device causes teeth or jaw problems','',8,1,'2010-03-10 15:19:26','192.168.1.55'),(9,'A Latex allergy',NULL,9,1,'2010-03-10 15:19:26','192.168.1.55'),(10,'Device causing claustrophobia or panic attacks',NULL,10,1,'2010-03-10 15:19:26','192.168.1.55'),(11,'An unconscious need to remove the CPAP at night',NULL,11,1,'2010-03-10 15:19:26','192.168.1.55'),(13,'GI/ Stomach/Intestinal',NULL,13,1,'2010-03-10 15:20:29','192.168.1.55'),(14,'The cpap device irritated nasal passages','',14,1,'2010-03-10 15:20:29','192.168.1.55'),(15,'Inability to wear due to nasal problems','',15,1,'2010-03-10 15:20:29','192.168.1.55'),(16,'CPAP caused dry nose and/or mouth',NULL,16,1,'2010-03-10 15:20:29','192.168.1.55'),(17,'The device caused eye irritation due to air leak','',17,1,'2010-03-10 15:20:29','192.168.1.55');
/*!40000 ALTER TABLE `dental_intolerance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_joint`
--

DROP TABLE IF EXISTS `dental_joint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_joint` (
  `jointid` int(11) NOT NULL AUTO_INCREMENT,
  `joint` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`jointid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_joint`
--

LOCK TABLES `dental_joint` WRITE;
/*!40000 ALTER TABLE `dental_joint` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_joint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_joint_exam`
--

DROP TABLE IF EXISTS `dental_joint_exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_joint_exam` (
  `joint_examid` int(11) NOT NULL AUTO_INCREMENT,
  `joint_exam` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`joint_examid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_joint_exam`
--

LOCK TABLES `dental_joint_exam` WRITE;
/*!40000 ALTER TABLE `dental_joint_exam` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_joint_exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_lab_cases`
--

DROP TABLE IF EXISTS `dental_lab_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_lab_cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `notes` text,
  `sent_date` datetime DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `received_user` int(11) DEFAULT NULL,
  `authorized_user` int(11) DEFAULT NULL,
  `authorized_date` datetime DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_lab_cases`
--

LOCK TABLES `dental_lab_cases` WRITE;
/*!40000 ALTER TABLE `dental_lab_cases` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_lab_cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ledger`
--

DROP TABLE IF EXISTS `dental_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ledger` (
  `ledgerid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `service_date` varchar(255) DEFAULT NULL,
  `entry_date` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `producer` varchar(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `paid_amount` float DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '0',
  `adddate` varchar(255) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `transaction_code` varchar(255) DEFAULT NULL,
  `placeofservice` varchar(255) NOT NULL,
  `emg` varchar(255) NOT NULL,
  `diagnosispointer` varchar(255) NOT NULL,
  `daysorunits` varchar(255) NOT NULL,
  `epsdt` varchar(255) NOT NULL,
  `idqual` varchar(255) NOT NULL,
  `modcode` varchar(255) NOT NULL,
  `producerid` int(11) DEFAULT NULL,
  `primary_claim_id` int(11) DEFAULT NULL,
  `primary_paper_claim_id` varchar(255) DEFAULT NULL,
  `modcode2` varchar(255) DEFAULT NULL,
  `modcode3` varchar(255) DEFAULT NULL,
  `modcode4` varchar(255) DEFAULT NULL,
  `percase_date` datetime DEFAULT NULL,
  `percase_name` varchar(100) DEFAULT NULL,
  `percase_amount` decimal(11,2) DEFAULT NULL,
  `percase_invoice` int(11) DEFAULT NULL,
  `percase_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ledgerid`)
) ENGINE=MyISAM AUTO_INCREMENT=656 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ledger`
--

LOCK TABLES `dental_ledger` WRITE;
/*!40000 ALTER TABLE `dental_ledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ledger_note`
--

DROP TABLE IF EXISTS `dental_ledger_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ledger_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producerid` int(11) DEFAULT NULL,
  `note` text,
  `private` int(1) DEFAULT NULL,
  `service_date` date DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `patientid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `admin_producerid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ledger_note`
--

LOCK TABLES `dental_ledger_note` WRITE;
/*!40000 ALTER TABLE `dental_ledger_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ledger_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ledger_payment`
--

DROP TABLE IF EXISTS `dental_ledger_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ledger_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payer` int(1) DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `payment_type` int(1) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `ledgerid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=266 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ledger_payment`
--

LOCK TABLES `dental_ledger_payment` WRITE;
/*!40000 ALTER TABLE `dental_ledger_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ledger_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ledger_rec`
--

DROP TABLE IF EXISTS `dental_ledger_rec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ledger_rec` (
  `ledgerid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `service_date` varchar(255) DEFAULT NULL,
  `entry_date` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `producer` varchar(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `paid_amount` float DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` varchar(255) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `transaction_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ledgerid`)
) ENGINE=MyISAM AUTO_INCREMENT=612 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ledger_rec`
--

LOCK TABLES `dental_ledger_rec` WRITE;
/*!40000 ALTER TABLE `dental_ledger_rec` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ledger_rec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_ledger_statement`
--

DROP TABLE IF EXISTS `dental_ledger_statement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ledger_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producerid` int(11) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `service_date` date DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `patientid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_ledger_statement`
--

LOCK TABLES `dental_ledger_statement` WRITE;
/*!40000 ALTER TABLE `dental_ledger_statement` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_ledger_statement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_letter_templates`
--

DROP TABLE IF EXISTS `dental_letter_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_letter_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `default_letter` tinyint(1) NOT NULL DEFAULT '0',
  `companyid` int(11) DEFAULT NULL,
  `triggerid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_letter_templates`
--

LOCK TABLES `dental_letter_templates` WRITE;
/*!40000 ALTER TABLE `dental_letter_templates` DISABLE KEYS */;
INSERT INTO `dental_letter_templates` VALUES (7,'TY MD Referral Pt Not Candidate','/manage/dss_referral_thank_you_pt_not_candidate.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname%</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%. %patient_firstname% had a %type_study% done at the %1st_sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>\r\n<p>I very much appreciate your confidence and the referral, but I regret to inform you that %patient_firstname% is not a candidate for dental device therapy. I have counseled %him/her% to return to your office to discuss other treatment options.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(8,'To Pt Did Not Accept Treatment','/manage/dss_to_pt_no_treatment.php','<p>Dear %contact_firstname%:</p>\r\n<p>Thank you for taking the time to come in and consult with us regarding your sleep disordered breathing problem. I hope that you found it was worth your time. We work very hard to be the best we can be.</p>\r\n<p>I understand that you chose not to pursue treatment with a dental device, and I am concerned that you are not treating your sleep disordered breathing problem.</p>\r\n<p>As you may very well be aware, this disease leads to increased risks for hypertension, heart attack, congestive heart failure, diabetes, stroke, as well as an increased risk for falling asleep while driving, all of which can be reversed by successful treatment!</p>\r\n<p>I wholeheartedly encourage you to pursue some form of treatment for your sleep disordered breathing.</p>\r\n<p>Please know that we are always here to help.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL),(24,'To Pt Termination','/manage/dss_to_pt_thank_you_pt_referral.php','<p>Dear %contact_firstname%:</p>\r\n<p>We delivered your %dental_device% dental device on %delivery_date% and our records show that you are not continuing with the treatment plan we created for you. Please be aware that your decision not follow through on treatment has resulted in you being officially discharged from our sleep disorder program.</p>\r\n<p>We now refer back to your primary care doctor to revisit other treatment options for sleep disordered breathing. Should you wish to reactivate your treatment plan in the future, please contact us.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL),(6,'Welcome Ltr Mail','/manage/dss_welcome.php','<p>Dear %contact_firstname%:</p>\r\n<p>We appreciate the trust you have placed in us by scheduling a consultation appointment for an evaluation of your snoring and/or sleep apnea problem. We will make every effort to honor that trust by providing the quality of care you require and deserve.</p>\r\n<p>&nbsp;</p>\r\n<table width=\"500px\">\r\n<tbody>\r\n<tr>\r\n<td width=\"50%\">Your appointment is scheduled for:</td>\r\n<td width=\"50%\">%consult_date%</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50%\">Our address is:</td>\r\n<td width=\"50%\">%franchisee_addr%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>If you have not already completed our patient forms, please plan on arriving 20 minutes before your scheduled appointment time to complete them. If you have already filled them out, please remember to bring them with you.</p>\r\n<p>If you have any questions that need to be answered prior to your appointment, please call us. Our office staff will assist you in every way possible. We look forward to meeting you!</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> %franchisee_phone%<br /> %franchisee_addr%</p>',1,NULL,NULL),(5,'Welcome Ltr EMail','/manage/dss_welcome_email.php','<p>%contact_email%</p>\r\n<p><br /> </p>\r\n<p>Dear %contact_firstname%,</p>\r\n<p>We appreciate the trust you have placed in us by scheduling a consultation appointment for an evaluation of your snoring and/or sleep apnea problem. We will make every effort to honor that trust by providing the quality of care you require and deserve.</p>\r\n<ol>\r\n<li>You can click on this link [\"www.dentalsleepsolutions.com/ONLINEFORM\"] and fill out your paperwork online (this method will ensure fastest service),<br /> <br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR</li>\r\n<li>You can download the attachment, print it, fill it out, and then bring it with you to your appointment. It is important to bring your paperwork or to fill out the paperwork online, or we may not be able to see you.</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<table width=\"500px\">\r\n<tbody>\r\n<tr>\r\n<td width=\"50%\">Your appointment is scheduled for:</td>\r\n<td width=\"50%\">%consult_date%</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50%\">Our address is:</td>\r\n<td width=\"50%\">%franchisee_addr%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>If you have any questions that need to be answered prior to your appointment, please call us. Our office staff will assist you in every way possible. We look forward to meeting you!</p>\r\n<p>&nbsp;</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> %franchisee_phone%<br /> %franchisee_addr%</p>',1,NULL,NULL),(12,'TY MD Referral Pt Did Not Come In','/manage/dss_referral_thank_you_pt_did_not_come_in.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname% - PATIENT DID NOT ATTEND CONSULTATION</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>Thank you for referring %patient_fullname% to our office.</p>\r\n<p>I appreciate your confidence and the referral, but I regret to inform you that our attempts to arrange a consultation with %patient_firstname% have been unsuccessful. Please be aware that %he/she% may not be treating %his/her% sleep disordered breathing.</p>\r\n<p>Again, thank you and please continue to keep us in mind for all of your mild to moderate sleep apneics, as well as those who cannot tolerate CPAP.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>\r\n<p>cc:<br /> %other_mds%</p>',1,NULL,NULL),(9,'TY MD Referral','/manage/dss_referral_thank_you_pt_scheduled.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname% - ACCEPTS TREATMENT</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%. %medicationssentence% %patient_firstname% had a %completed_type_study% done at the %completed_sleeplab_name% which showed an AHI of %completed_ahi%; %he/she% was diagnosed with %completed_diagnosis%.</p>\r\n<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device. %He/She% is scheduled to begin treatment as soon as we receive the dental device back from the lab</p>\r\n<p>Thank you again for your confidence and the referral. We will keep you updated as treatment progresses.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(11,'TY MD Referral Pt Did Not Accept Treatment','/manage/dss_referral_thank_you_pt_did_not_accept.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname% - PATIENT REFUSED TREATMENT</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%. %medicationssentence% %patient_firstname% had a %completed_type_study% done at the %completed_sleeplab_name% which showed an AHI of %completed_ahi%; %he/she% was diagnosed with %completed_diagnosis%.</p>\r\n<p>I regret to inform you that the patient has refused treatment with a dental sleep device. I am referring %him/her% back to you to discuss other treatment options.</p>\r\n<p>Thank you again for your confidence and the referral. We are committed to helping patients successfully treat their sleep disordered breathing.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(17,'Progress Note to MD and Pt Non Compliance','/manage/dss_progress_note_to_md_pt_non_compliant.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname% - PATIENT NO LONGER DENTAL DEVICE COMPLIANT</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>%patprogress%</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>I write regarding our mutual Patient, %patient_fullname%. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% after undergoing a %type_study% done at the %1st_sleeplab_name%.</p>\r\n<p>We delivered a %dental_device% dental device on %delivery_date%.</p>\r\n<p>I regret to inform you that %he/she% has become non compliant with dental device therapy due to %noncomp_reason%.</p>\r\n<p>I am referring her back to you to discuss other treatment alternatives. Thank you again for the opportunity to participate in %patient_firstname%\'s therapy; please know that we will do our best to follow through with all patients to ensure successful treatment.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%<br /> %ccpatient_fullname%</p>',1,NULL,NULL),(1,'Intro Ltr To MD from DSSFLLC','/manage/dss_intro_to_md_from_dss.php','<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>Thank you for allowing us a few moments of your time. We represent Dental Sleep Solutions Franchising, LLC, a franchise entity that recruits, trains, and provides administrative support to dentists i n the area of dental sleep medicine.</p>\r\n<p>Our dentists receive training from Board Certified dentists in the areas of:</p>\r\n<ul>\r\n<li>Sleep medicine and sleep disorders</li>\r\n<li>Sleep Disordered Breathing (SDB)</li>\r\n<li>Treatment options for SDB</li>\r\n<ul>\r\n<li>Including CPAP, dental device therapy, surgery, and behavioral solutions</li>\r\n<li>Unique hybrid therapies that include mating CPAP to a dental device</li>\r\n</ul>\r\n</ul>\r\n<p>We are writing to you today to invite you to partner with us in diagnosing and treating patients with sleep disordered breathing. We promote a team healthcare approach that involves the physician and dentist working closely to provide a successful treatment modality for each and every patient. If you feel that your patients could benefit from a sleep screening consultation, we invite you to contact us directly so that we can put you in touch with a local Dental Sleep Solutions&reg; provider. Rest assured that when you are dealing with a Dental Sleep Solutions&reg; dentist, you are dealing with an individual who understands the issues and the treatment options.</p>\r\n<p>Please don\'t hesitate to call if you have any questions. We look forward to a long and prosperous relationship and thank you for your referrals in advance.</p>\r\n<p>Regards, <br /> <br /> </p>\r\n<table width=\"100%\">\r\n<tbody>\r\n<tr>\r\n<td width=\"60%\">Richard B. Drake, DDS</td>\r\n<td width=\"40%\">George \"Gy\" Yatros, DMD</td>\r\n</tr>\r\n</tbody>\r\n</table>',1,NULL,NULL),(2,'Intro Ltr to MD from Dental Office','/manage/dss_intro_to_md_from_dentist.php','<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>Thank you for allowing me a few minutes of your time. My name is %franchisee_fullname%, and I am a dentist who has partnered with Dental Sleep Solutions&reg;, a company committed to maximizing successful treatment options for patients who suffer from sleep disordered breathing. As a Dental Sleep Solutions&reg; Dentist, I have completed a \"mini residency\" training program put on by nationally known Board Certified dentists; our office adheres to practice protocols that are consistent with the highest levels of patient care.</p>\r\n<p>We welcome your referrals for the treatment of snoring, upper airway resistance syndrome, and obstructive sleep apnea. We evaluate patients individually and recommend treatment plans based on disease severity and patient preferences, all the while following the guidelines as laid down by the American Academy of Sleep Medicine\'s (AASM) position paper on the parameters for use of oral appliances in the treatment of OSA, as appeared in the February, 2006 issue of <em>Sleep</em>. It states that oral appliances may be used as a first line of therapy for patients with mild to moderate OSA as well as for patients who are severe and have failed CPAP or who prefer them to CPAP.</p>\r\n<p>We are working closely with physicians such as you who recognize the importance of diagnosing and treating this illness. As awareness of the ill effects of OSA (hypertension, MI, CHF, stroke, fatigue, impotence, mood swings, and dozing accidents) increases in the public\'s eye, all of medicine will begin to see an increasing number of patients asking questions about snoring and sleep apnea and seeking treatment options. We hope you\'ll consider referring these patients to us.</p>\r\n<p>Again, thank you for your time, and I look forward to working with you.</p>\r\n<p>Regards, </p>\r\n<p><br /> %franchisee_fullname%</p>',1,NULL,NULL),(13,'To MD Mutual Pt Plan to Treat','/manage/dss_referral_treating_mutual_patient.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname% - DENTAL SLEEP DEVICE TREATMENT</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>We have a mutual patient, %patient_fullname%. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% after undergoing a %type_study% done at %1st_sleeplab_name% on %1ststudy_date%. %He/She% was referred to me %by_referral_fullname% for treatment of %his/her% sleep disordered breathing with a Mandibular Advancement Device.</p>\r\n<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device. %He/She% is scheduled to begin treatment very soon.</p>\r\n<p>We will keep you updated as treatment progresses. Please keep us in mind for all of your patients who suffer from sleep disordered breathing.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(10,'TY MD Referral Pt Waiting On','/manage/dss_referral_thank_you_pt_waiting_on.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname%</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>%tyreferred% As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%. %medicationssentence% %patient_firstname% had a %type_study% done at the %1st_sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>\r\n<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device. However, %he/she% is waiting to begin treatment due to %delay_reason%.</p>\r\n<p>Thank you again for your confidence and the referral. We will keep you updated on %his/her% treatment progress.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(3,'Intro Ltr to Pt of Record','/manage/dss_to_pt_intro.php','<p>Dear %contact_firstname%:</p>\r\n<p>Are you tired at times when you don\'t want to be? Do you find it difficult to get out of bed in the morning? Do you feel fatigued and irritable? Is your bed partner complaining more and more about your snoring?</p>\r\n<p>You may be suffering from Obstructive Sleep Apnea (OSA). Repeated closure of the upper airway during sleep leads to many unwanted outcomes including the following:</p>\r\n<ul>\r\n<li>loud snoring</li>\r\n<li>stopped breathing episodes</li>\r\n<li>poor, unrefreshing sleep</li>\r\n<li>excessive daytime sleepiness</li>\r\n<li>impotence</li>\r\n<li>weight gain</li>\r\n<li>increased risks for hypertension and heart attack</li>\r\n<li>diabetes</li>\r\n<li>congestive heart failure</li>\r\n<li>stroke</li>\r\n<li>increased risk for falling asleep while driving.</li>\r\n</ul>\r\n<p>The good news is that we can do something about these problems!</p>\r\n<p>%franchisee_practice% has joined with <strong>Dental Sleep Solutions&reg;</strong> to undergo specific training on how to treat snoring and sleep apnea utilizing state of the art, FDA approved dental sleep devices.</p>\r\n<p>If you or someone you know is suffering with snoring or sleep apnea and would like more information about how we can help by using dental sleep therapy please call our office and we will be happy to schedule a complimentary consultation. We also invite you to visit our website at www.dentalsleepsolutions.com for more information.</p>\r\n<p>We look forward to helping you or someone you know to get a better night\'s sleep!</p>\r\n<p>Sincerely,</p>\r\n<p><br /> </p>\r\n<p>%franchisee_fullname%</p>',1,NULL,NULL),(19,'Ltr To MD and Pt after HST','/manage/dss_to_md_pt_treatment_complete.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50px\">Re:</td>\r\n<td>%patient_fullname% - DENTAL DEVICE TREATMENT RESULTS</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50px\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>%patprogress%</p>\r\n<p>Dear %contact_salutation% %contact_lastname%:</p>\r\n<p>I write regarding our mutual Patient, %patient_fullname%. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% and/or RDI of %1stRDI% after undergoing a %type_study% done at %1st_sleeplab_name%. %He/She% spent %1stTO290% % of the night below 90% sp O2, and had an O2 nadir of %1stLowO2%.</p>\r\n<p>We delivered %dental_device% device on %delivery_date%, and %he/she% has reported doing well with it. I write to give you a progress update after the initial titration period and following a take home sleep study. %patient_firstname%\'s results, baseline and post appliance insertion appear below.</p>\r\n<table cellpadding=\"7px\">\r\n<tbody>\r\n<tr><th>OBJECTIVE</th><th>Before %1ststudy_date%&nbsp;&nbsp;&nbsp;&nbsp;</th><th>After %2ndstudy_date%</th></tr>\r\n<tr>\r\n<td>RDI / AHI</td>\r\n<td><center>%1stRDI/AHI%</center></td>\r\n<td><center>%2ndRDI/AHI%</center></td>\r\n</tr>\r\n<tr>\r\n<td>Low O2</td>\r\n<td><center>%1stLowO2%</center></td>\r\n<td><center>%2ndLowO2%</center></td>\r\n</tr>\r\n<tr>\r\n<td>T O2 &le; 90%</td>\r\n<td><center>%1stTO290%</center></td>\r\n<td><center>%2ndTO290%</center></td>\r\n</tr>\r\n<tr>\r\n<td>ESS</td>\r\n<td><center>%1stESS%</center></td>\r\n<td><center>%2ndESS%</center></td>\r\n</tr>\r\n<tr><th>SUBJECTIVE</th>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Snoring</td>\r\n<td><center>%1stSnoring%</center></td>\r\n<td><center>%2ndSnoring%</center></td>\r\n</tr>\r\n<tr>\r\n<td>Energy Level</td>\r\n<td><center>%1stEnergy%</center></td>\r\n<td><center>%2ndEnergy%</center></td>\r\n</tr>\r\n<tr>\r\n<td>Sleep Quality</td>\r\n<td><center>%1stQuality%</center></td>\r\n<td><center>%2ndQuality%</center></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>%patient_firstname% has been counseled that OSA is a progressive disease and I have stressed the importance of a team healthcare approach and disciplined follow up. I believe we have reached maximum medical improvement with a dental device, and at this point I plan to refer %patient_firstname% back to your office for further medical care.</p>\r\n<p>Please don\'t hesitate to call if you have any questions. I thank you again for the opportunity to participate in this patient\'s treatment.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%<br /> %ccpatient_fullname%</p>',1,NULL,NULL),(18,'Progress Note to Pt Non Compliance','/manage/dss_to_pt_non_compliant.php','<p>Dear %contact_firstname%:</p>\r\n<p>We delivered your %dental_device% dental device on %delivery_date%. Our follow up schedule mandates at least one follow up appointment within the first 30 days. Somehow, you have slipped through the cracks. We have no record of that visit.</p>\r\n<p>Please contact our office immediately to schedule your follow up appointment.</p>\r\n<p>Thank you.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(21,'To Pt Annual Follow Up','/manage/dss_to_pt_yearly_follow_up.php','<p>Dear %contact_firstname%:</p>\r\n<p>Can you believe it was a year ago that we fabricated your %dental_device% dental sleep device? We hope that you are continuing to do well.</p>\r\n<p>Please take time to contact our office and schedule your yearly follow up. Since sleep disordered breathing is a progressive disorder it is important that we evaluate your appliance for proper fit and discuss your continued treatment regimen.</p>\r\n<p>As you may very well be aware, sleep disordered breathing leads to increased risks for hypertension, heart attack, congestive heart failure, diabetes, stroke, as well as an increased risk for falling asleep while driving -- all of which can be reversed by successful treatment!</p>\r\n<p>We look forward to seeing you soon.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL),(23,'Thirty Month Follow Up','/manage/dss_to_pt_30month_follow_up.php','<p>Dear %contact_firstname%:</p>\r\n<p>It&rsquo;s hard to believe that it was nearly three years ago that we delivered your dental device. I hope that you are wearing your device and continuing to reap the benefits of better sleep and better health. I am writing to you today because most dental devices begin to show significant wear around the three year mark and can lose their ability to effectively treat your sleep disordered breathing. Most insurers will pay to have them remade if necessary, so we\'d like to encourage you to set up an appointment so that we can evaluate your device for possible replacement.</p>\r\n<p>Please give us a call here at the office to schedule an appointment. We look forward to seeing you soon!</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL),(16,'Progress Note to MD and Pt','/manage/dss_to_md_pt_progress_note.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50px\">Re:</td>\r\n<td>%patient_fullname% - DENTAL DEVICE TREATMENT PROGRESS</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50px\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>%patprogress%</p>\r\n<p>Dear %contact_salutation% %contact_lastname%:</p>\r\n<p>I write regarding our mutual Patient, %patient_fullname%. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI/RDI of %ahi%/%1stRDI% after undergoing a %type_study% done at the %1st_sleeplab_name%.</p>\r\n<p>We delivered a %dental_device% dental device on %delivery_date%. We are now seeing %patient_firstname% for follow up.</p>\r\n<p>The patient reports wearing the device %nightsperweek% nights per week. %esstssupdate% Additionally, %he/she% reports less snoring, improved daytime functioning, and more refreshing sleep.</p>\r\n<p>We will continue to update you on %his/her% progress. Thank you for the opportunity to participate in this patient\'s treatment.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%<br /> %ccpatient_fullname%</p>',1,NULL,NULL),(20,'Ty to Other Referral','/manage/dss_to_pt_treatment_complete.php','<table width=\"275\">\r\n<tbody>\r\n<tr>\r\n<td width=\"50px\">Re:</td>\r\n<td>%patient_fullname% - Office Referral</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50px\">&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device. There is no greater compliment than for someone such as you to refer a colleague, friend, or family member.</p>\r\n<p>Thank you again for your confidence and the referral!</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(4,'Cover Ltr for Sleep Screening Questionnaire','/manage/dss_cover_letter_for_sleep_screening.php','<p>Dear %contact_firstname%:</p>\r\n<p>Though you may not realize it, snoring is a telltale sign that you may suffer from a disease called Obstructive Sleep Apnea.</p>\r\n<p>We are excited to inform you that our office has partnered with <strong>Dental Sleep Solutions&reg;</strong>, one of the country\'s most respected and knowledgeable groups in the area of dental sleep medicine. Our entire office has been trained in how to recognize and treat snoring and sleep apnea utilizing leading edge technologies.</p>\r\n<p><strong>Dental Sleep Solutions\'&reg;</strong> techniques help reduce or eliminate snoring and Obstructive Sleep Apnea by creating a custom dental sleep device that is worn while you sleep.</p>\r\n<p>Obstructive Sleep Apnea has been linked to serious, sometimes even life-threatening, health problems. Early recognition and treatment is <strong>very important</strong>. We would appreciate it if you would please fill out our Sleep Screening Questionnaire while you are here today so that we can make an initial assessment and schedule a free consultation if needed.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL),(14,'SOAP Cover Ltr to Pt','/manage/dss_to_pt_soap_cover_ltr.php','<p>Dear %contact_firstname%:</p>\r\n<p>Thank you for choosing Dental Sleep Solutions&reg; and %franchisee_fullname% to treat your sleep disordered breathing. As you are no doubt now aware, Dental Sleep Solutions&reg; dentists are some of the most highly trained and educated dentists in dental sleep medicine. Our dentists are committed to helping you breathe better, sleep better, and feel better.</p>\r\n<p>We have attached a summary of the clinical notes made by %franchisee_lastname% for your records. We hope that you will take an active role in your treatment therapy. Please take the time to visit our website, too, at www.dentalsleepsolutions.com and give us a shout to let us know how we are doing.</p>\r\n<p>In the meantime, spread the word! Many of your friends and family members could likely benefit from a dental sleep medicine consultation. Dental Sleep Solutions&reg; is expanding its network of participating dentists regularly -- please check out our website for details.</p>\r\n<p>Thank you for choosing Dental Sleep Solutions&reg;!</p>\r\n<p>Sincerely, <br /> <br /> </p>\r\n<table width=\"100%\">\r\n<tbody>\r\n<tr>\r\n<td width=\"60%\">Richard B. Drake, DDS</td>\r\n<td width=\"40%\">George \"Gy\" Yatros, DMD</td>\r\n</tr>\r\n</tbody>\r\n</table>',1,NULL,NULL),(15,'SOAP to MD and Pt','/manage/dss_to_md_pt_soap.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">Re:</td>\r\n<td>%patient_fullname%</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>%patient_fullname% is a %patient_age% year old %patient_gender% with a past medical history that includes: %history% and medications: %medications%.</p>\r\n<p><strong>HPI</strong>: Patient underwent a %2ndtype_study% on %2ndstudy_date% due to %reason_seeking_tx%. %He/She% was diagnosed with %2nddiagnosis%.&nbsp; Patient has a BMI of %bmi%.</p>\r\n<p><strong>SUBJECTIVE</strong>: %patient_firstname% presents with subjective complaint(s) of %reason_seeking_tx%. Patient has an initial Epworth Sleepiness Score of %1stESS% and initial energy level of %1stEnergy%/10.</p>\r\n<p><strong>OBJECTIVE</strong>: %patient_firstname% underwent a %2ndtype_study% on %2ndstudy_date%. %He/She% was diagnosed with %2nddiagnosis%. %He/She% had an AHI of %2ndahi%. On %his/her% back, %his/her% AHI was %2ndahisupine%. %He/She% had a low O2 level of %2ndLowO2%; and %he/she% spent %2ndO2Sat90%% of the night below 90% O2.</p>\r\n<p><strong>ASSESSMENT</strong>: %patient_firstname% is a good candidate for dental device therapy based on clinical observation, review of medical history, and oral screening.</p>\r\n<p><strong>PLAN</strong>: Discussed risks, benefits, and alternatives of treatment options. Recommend [Patient\'s Treatment Plan]</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL),(22,'Appeal to Insurance Company','/manage/dss_appeal_to_insurance.php','<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50px\">Re:</td>\r\n<td>%patient_fullname% - DENIAL OF COVERAGE</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50px\">\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>',1,NULL,NULL),(99,'Blank Letter',NULL,'<p>Dear %contact_salutation% %contact_lastname%:</p>\r\n<p>*PLEASE TYPE THE TEXT OF THIS LETTER HERE*</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL),(151,'Sleep Test Referral',NULL,'<table>\r\n<tbody>\r\n<tr>\r\n<td width=\"50px\">Re:</td>\r\n<td>%patient_fullname% - DENTAL SLEEP DEVICE TREATMENT</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50px\">DOB:</td>\r\n<td>%patient_dob%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>We have a mutual patient, %patient_fullname%. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%. %He/She% was referred to me %by_referral_fullname% for treatment of %his/her% sleep disordered breathing with a Mandibular Advancement Device. During oral examination it was noted that %patient_firstname% grinds %his/her% teeth at night, snores most nights.&nbsp; %patient_firstname% presents with subjective complaint(s) of %reason_seeking_tx% and a past medical history that includes: %history% and medications: %medications%.</p>\r\n<p>Please evaluate %patient_fullname% for a possible breathing disorder. %He/She% has declined to undergo home sleep testing (HST) to verify whether a clinical sleep disorder exists.&nbsp; We are now referring %patient_fullname% to your office for a sleep test and additional consultation regarding sleep disordered breathing.</p>\r\n<p>Thank you for your willingness to work with us. Please keep us in mind for all of your sleep disordered breathing patients whom you think may benefit from Mandibular Repositioning Device therapy.</p>\r\n<p>&nbsp;</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%<br /> <br /> cc:<br /> %other_mds%</p>',1,NULL,NULL),(178,'Pedo Referral',NULL,'<p>Dear %salutation% %contact_lastname%:</p>\r\n<p>We have a mutual patient, %patient_fullname%. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%. During oral examination it was noted that %patient_firstname% grinds %his/her% teeth at night, snores most nights, and appears to have enlarged tonsils/adenoids.</p>\r\n<p>We believe in screening not only adults but also children for sleep and breathing disorders. Crowded airways due to large tonsils and adenoids, as well as nasal congestion, all contribute to suboptimal sleep quality for many children. Please evaluate %patient_fullname% for a possible breathing disorder. We will continue to do all we can to develop the patient&rsquo;s dentition and skeletal features to maximize airway patency.</p>\r\n<p>Thank you for your willingness to work with us. Please keep us in mind for all of your sleep disordered breathing patients whom you think may benefit from Mandibular Repositioning Device therapy.</p>\r\n<p>Sincerely, <br /> <br /> <br /> %franchisee_fullname%</p>',1,NULL,NULL);
/*!40000 ALTER TABLE `dental_letter_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_letter_templates_custom`
--

DROP TABLE IF EXISTS `dental_letter_templates_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_letter_templates_custom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `body` text,
  `docid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_letter_templates_custom`
--

LOCK TABLES `dental_letter_templates_custom` WRITE;
/*!40000 ALTER TABLE `dental_letter_templates_custom` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_letter_templates_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_letters`
--

DROP TABLE IF EXISTS `dental_letters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_letters` (
  `letterid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `stepid` int(11) DEFAULT NULL,
  `generated_date` datetime DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `send_method` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `template` text CHARACTER SET latin1,
  `pdf_path` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `delivered` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `templateid` int(11) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `topatient` tinyint(1) DEFAULT NULL,
  `md_list` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `md_referral_list` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `info_id` int(11) DEFAULT NULL,
  `edit_userid` int(11) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `mailed_date` datetime DEFAULT NULL,
  `mailed_once` tinyint(1) DEFAULT '0',
  `template_type` tinyint(1) DEFAULT '0',
  `cc_topatient` tinyint(1) DEFAULT NULL,
  `cc_md_list` varchar(255) DEFAULT NULL,
  `cc_md_referral_list` varchar(255) DEFAULT NULL,
  `font_family` varchar(50) DEFAULT 'dejavusans',
  `font_size` int(4) DEFAULT '10',
  `pat_referral_list` varchar(255) DEFAULT NULL,
  `cc_pat_referral_list` varchar(255) DEFAULT NULL,
  `lab_case_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`letterid`),
  KEY `patientid` (`patientid`)
) ENGINE=MyISAM AUTO_INCREMENT=2494 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_letters`
--

LOCK TABLES `dental_letters` WRITE;
/*!40000 ALTER TABLE `dental_letters` DISABLE KEYS */;
INSERT INTO `dental_letters` VALUES (2492,NULL,NULL,'2014-01-28 23:10:39',NULL,NULL,NULL,NULL,0,0,0,2,NULL,NULL,'1605',NULL,244,244,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'1605',NULL,'dejavusans',10,NULL,NULL,NULL),(2493,NULL,NULL,'2014-01-28 23:12:09',NULL,NULL,NULL,NULL,0,0,0,2,NULL,NULL,'1606',NULL,244,244,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'1606',NULL,'dejavusans',10,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dental_letters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_locations`
--

DROP TABLE IF EXISTS `dental_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `default_location` tinyint(1) DEFAULT '0',
  `address` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_locations`
--

LOCK TABLES `dental_locations` WRITE;
/*!40000 ALTER TABLE `dental_locations` DISABLE KEYS */;
INSERT INTO `dental_locations` VALUES (106,'Test Practice','2014-01-28 22:55:53','10.20.1.168',244,'TestCity','AR','55555','2105081928',1,'123 St','Test FrontUser','');
/*!40000 ALTER TABLE `dental_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_log`
--

DROP TABLE IF EXISTS `dental_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_log`
--

LOCK TABLES `dental_log` WRITE;
/*!40000 ALTER TABLE `dental_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_login`
--

DROP TABLE IF EXISTS `dental_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_login` (
  `loginid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT '0',
  `userid` int(11) DEFAULT '0',
  `login_date` datetime DEFAULT NULL,
  `logout_date` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`loginid`)
) ENGINE=MyISAM AUTO_INCREMENT=3353 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_login`
--

LOCK TABLES `dental_login` WRITE;
/*!40000 ALTER TABLE `dental_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_login_detail`
--

DROP TABLE IF EXISTS `dental_login_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_login_detail` (
  `l_detailid` int(11) NOT NULL AUTO_INCREMENT,
  `loginid` int(11) DEFAULT '0',
  `userid` int(11) DEFAULT '0',
  `cur_page` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`l_detailid`)
) ENGINE=MyISAM AUTO_INCREMENT=93130 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_login_detail`
--

LOCK TABLES `dental_login_detail` WRITE;
/*!40000 ALTER TABLE `dental_login_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_login_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_mandible`
--

DROP TABLE IF EXISTS `dental_mandible`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_mandible` (
  `mandibleid` int(11) NOT NULL AUTO_INCREMENT,
  `mandible` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`mandibleid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_mandible`
--

LOCK TABLES `dental_mandible` WRITE;
/*!40000 ALTER TABLE `dental_mandible` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_mandible` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_maxilla`
--

DROP TABLE IF EXISTS `dental_maxilla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_maxilla` (
  `maxillaid` int(11) NOT NULL AUTO_INCREMENT,
  `maxilla` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`maxillaid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_maxilla`
--

LOCK TABLES `dental_maxilla` WRITE;
/*!40000 ALTER TABLE `dental_maxilla` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_maxilla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_medications`
--

DROP TABLE IF EXISTS `dental_medications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_medications` (
  `medicationsid` int(11) NOT NULL AUTO_INCREMENT,
  `medications` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`medicationsid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_medications`
--

LOCK TABLES `dental_medications` WRITE;
/*!40000 ALTER TABLE `dental_medications` DISABLE KEYS */;
INSERT INTO `dental_medications` VALUES (1,'Antacids','',1,1,'2010-03-10 15:48:00','192.168.1.55'),(2,'Antibiotics',NULL,2,1,'2010-03-10 15:50:14','192.168.1.55'),(3,'Anticoagulants',NULL,3,1,'2010-03-10 15:50:14','192.168.1.55'),(4,'Antidepressants',NULL,4,1,'2010-03-10 15:50:14','192.168.1.55'),(5,'Anti-inflammatory drugs (Non-steroid)',NULL,5,1,'2010-03-10 15:50:14','192.168.1.55'),(6,'Barbiturates',NULL,6,1,'2010-03-10 15:50:14','192.168.1.55'),(7,'Blood thinners',NULL,7,1,'2010-03-10 15:50:14','192.168.1.55'),(8,'Codeine',NULL,8,1,'2010-04-14 13:53:47','192.168.1.55'),(9,'Cortisone',NULL,9,1,'2010-04-14 13:53:47','192.168.1.55'),(10,'Diet pills',NULL,11,1,'2010-04-14 13:53:47','192.168.1.55'),(11,'Heart medication',NULL,12,1,'2010-04-14 13:53:47','192.168.1.55'),(12,'High blood pressure medication',NULL,13,1,'2010-04-14 13:53:47','192.168.1.55'),(13,'Insulin',NULL,14,1,'2010-04-14 13:53:47','192.168.1.55'),(14,'Muscle relaxants',NULL,15,1,'2010-04-14 13:53:47','192.168.1.55'),(15,'Nerve pills',NULL,16,1,'2010-04-14 13:53:47','192.168.1.55'),(16,'Pain medication',NULL,17,1,'2010-04-14 13:53:47','192.168.1.55'),(17,'Sleeping pills',NULL,18,1,'2010-04-14 13:53:47','192.168.1.55'),(18,'Sulfa drugs','',19,1,'2010-04-14 13:53:47','192.168.1.55'),(19,'Tranquilizers',NULL,20,1,'2010-04-14 13:53:47','192.168.1.55'),(20,'Coumadin','',21,1,'2010-05-05 12:13:33','59.181.135.49');
/*!40000 ALTER TABLE `dental_medications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_missing`
--

DROP TABLE IF EXISTS `dental_missing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_missing` (
  `missingid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `pck` text,
  `rec` text,
  `mob` text,
  `rec1` text,
  `pck1` text,
  `s1` varchar(50) DEFAULT NULL,
  `s2` varchar(50) DEFAULT NULL,
  `s3` varchar(50) DEFAULT NULL,
  `s4` varchar(50) DEFAULT NULL,
  `s5` varchar(50) DEFAULT NULL,
  `s6` varchar(50) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`missingid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_missing`
--

LOCK TABLES `dental_missing` WRITE;
/*!40000 ALTER TABLE `dental_missing` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_missing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_modifier_code`
--

DROP TABLE IF EXISTS `dental_modifier_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_modifier_code` (
  `modifier_codeid` int(11) NOT NULL AUTO_INCREMENT,
  `modifier_code` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`modifier_codeid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_modifier_code`
--

LOCK TABLES `dental_modifier_code` WRITE;
/*!40000 ALTER TABLE `dental_modifier_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_modifier_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_nasal_passages`
--

DROP TABLE IF EXISTS `dental_nasal_passages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_nasal_passages` (
  `nasal_passagesid` int(11) NOT NULL AUTO_INCREMENT,
  `nasal_passages` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`nasal_passagesid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_nasal_passages`
--

LOCK TABLES `dental_nasal_passages` WRITE;
/*!40000 ALTER TABLE `dental_nasal_passages` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_nasal_passages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_notes`
--

DROP TABLE IF EXISTS `dental_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_notes` (
  `notesid` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT '0',
  `notes` text,
  `edited` int(1) DEFAULT '0',
  `editor_initials` varchar(255) NOT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `procedure_date` varchar(255) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `signed_id` int(11) DEFAULT NULL,
  `signed_on` datetime DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  PRIMARY KEY (`notesid`)
) ENGINE=MyISAM AUTO_INCREMENT=153 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_notes`
--

LOCK TABLES `dental_notes` WRITE;
/*!40000 ALTER TABLE `dental_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_notifications`
--

DROP TABLE IF EXISTS `dental_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `notification` varchar(255) DEFAULT NULL,
  `notification_type` varchar(100) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `notification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_notifications`
--

LOCK TABLES `dental_notifications` WRITE;
/*!40000 ALTER TABLE `dental_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_pages`
--

DROP TABLE IF EXISTS `dental_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_pages` (
  `pageid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `description` text,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `keywords` text,
  PRIMARY KEY (`pageid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_pages`
--

LOCK TABLES `dental_pages` WRITE;
/*!40000 ALTER TABLE `dental_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_palpation`
--

DROP TABLE IF EXISTS `dental_palpation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_palpation` (
  `palpationid` int(11) NOT NULL AUTO_INCREMENT,
  `palpation` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`palpationid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_palpation`
--

LOCK TABLES `dental_palpation` WRITE;
/*!40000 ALTER TABLE `dental_palpation` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_palpation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_patient_contacts`
--

DROP TABLE IF EXISTS `dental_patient_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_patient_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacttype` int(2) DEFAULT NULL,
  `patientid` int(11) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(15) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_patient_contacts`
--

LOCK TABLES `dental_patient_contacts` WRITE;
/*!40000 ALTER TABLE `dental_patient_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_patient_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_patient_insurance`
--

DROP TABLE IF EXISTS `dental_patient_insurance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_patient_insurance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `insurancetype` int(1) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(15) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_patient_insurance`
--

LOCK TABLES `dental_patient_insurance` WRITE;
/*!40000 ALTER TABLE `dental_patient_insurance` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_patient_insurance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_patient_summary`
--

DROP TABLE IF EXISTS `dental_patient_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_patient_summary` (
  `pid` int(11) NOT NULL,
  `fspage1_complete` int(1) DEFAULT NULL,
  `next_visit` date DEFAULT NULL,
  `last_visit` date DEFAULT NULL,
  `last_treatment` varchar(255) DEFAULT NULL,
  `appliance` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `vob` varchar(255) DEFAULT NULL,
  `ledger` float(11,2) DEFAULT NULL,
  `patient_info` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_patient_summary`
--

LOCK TABLES `dental_patient_summary` WRITE;
/*!40000 ALTER TABLE `dental_patient_summary` DISABLE KEYS */;
INSERT INTO `dental_patient_summary` VALUES (467,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `dental_patient_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_patients`
--

DROP TABLE IF EXISTS `dental_patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_patients` (
  `patientid` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(2) DEFAULT NULL,
  `salutation` varchar(255) DEFAULT NULL,
  `member_no` varchar(255) NOT NULL,
  `group_no` varchar(255) NOT NULL,
  `plan_no` varchar(255) NOT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `add1` varchar(255) DEFAULT NULL,
  `add2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `ssn` varchar(255) DEFAULT NULL,
  `internal_patient` varchar(255) DEFAULT NULL,
  `home_phone` varchar(255) DEFAULT NULL,
  `work_phone` varchar(255) DEFAULT NULL,
  `cell_phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `patient_notes` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `p_d_party` varchar(255) DEFAULT NULL,
  `p_d_relation` varchar(255) DEFAULT NULL,
  `p_d_other` varchar(255) DEFAULT NULL,
  `p_d_employer` varchar(255) DEFAULT NULL,
  `p_d_ins_co` varchar(255) DEFAULT NULL,
  `p_d_ins_id` varchar(255) DEFAULT NULL,
  `s_d_party` varchar(255) DEFAULT NULL,
  `s_d_relation` varchar(255) DEFAULT NULL,
  `s_d_other` varchar(255) DEFAULT NULL,
  `s_d_employer` varchar(255) DEFAULT NULL,
  `s_d_ins_co` varchar(255) DEFAULT NULL,
  `s_d_ins_id` varchar(255) DEFAULT NULL,
  `p_m_partyfname` varchar(255) DEFAULT NULL,
  `p_m_partymname` varchar(255) NOT NULL,
  `p_m_partylname` varchar(255) NOT NULL,
  `p_m_relation` varchar(255) DEFAULT NULL,
  `p_m_other` varchar(255) DEFAULT NULL,
  `p_m_employer` varchar(255) DEFAULT NULL,
  `p_m_ins_co` varchar(255) DEFAULT NULL,
  `p_m_ins_id` varchar(255) DEFAULT NULL,
  `s_m_partyfname` varchar(255) DEFAULT NULL,
  `s_m_partymname` varchar(255) NOT NULL,
  `s_m_partylname` varchar(255) NOT NULL,
  `s_m_relation` varchar(255) DEFAULT NULL,
  `s_m_other` varchar(255) DEFAULT NULL,
  `s_m_employer` varchar(255) DEFAULT NULL,
  `s_m_ins_co` varchar(255) DEFAULT NULL,
  `s_m_ins_id` varchar(255) DEFAULT NULL,
  `p_m_ins_grp` varchar(255) NOT NULL,
  `s_m_ins_grp` varchar(255) NOT NULL,
  `p_m_ins_plan` varchar(255) NOT NULL,
  `s_m_ins_plan` varchar(255) NOT NULL,
  `p_m_dss_file` varchar(255) NOT NULL,
  `s_m_dss_file` varchar(255) NOT NULL,
  `p_m_ins_type` varchar(255) NOT NULL,
  `s_m_ins_type` varchar(255) NOT NULL,
  `p_m_ins_ass` varchar(255) NOT NULL,
  `s_m_ins_ass` varchar(255) NOT NULL,
  `ins_dob` varchar(255) NOT NULL,
  `ins2_dob` varchar(255) NOT NULL,
  `employer` varchar(255) DEFAULT NULL,
  `emp_add1` varchar(255) DEFAULT NULL,
  `emp_add2` varchar(255) DEFAULT NULL,
  `emp_city` varchar(255) DEFAULT NULL,
  `emp_state` varchar(255) DEFAULT NULL,
  `emp_zip` varchar(255) DEFAULT NULL,
  `emp_phone` varchar(255) DEFAULT NULL,
  `emp_fax` varchar(255) DEFAULT NULL,
  `plan_name` varchar(255) DEFAULT NULL,
  `group_number` varchar(255) DEFAULT NULL,
  `ins_type` varchar(255) DEFAULT NULL,
  `accept_assignment` varchar(255) DEFAULT NULL,
  `print_signature` varchar(255) DEFAULT NULL,
  `medical_insurance` varchar(255) DEFAULT NULL,
  `mark_yes` varchar(255) DEFAULT NULL,
  `inactive` varchar(255) DEFAULT NULL,
  `partner_name` varchar(255) DEFAULT NULL,
  `emergency_name` varchar(255) DEFAULT NULL,
  `emergency_number` varchar(255) DEFAULT NULL,
  `referred_source` varchar(255) DEFAULT NULL,
  `referred_by` varchar(255) DEFAULT NULL,
  `premedcheck` tinyint(1) NOT NULL DEFAULT '0',
  `premed` text NOT NULL,
  `docsleep` varchar(255) NOT NULL,
  `docpcp` varchar(255) NOT NULL,
  `docdentist` varchar(255) NOT NULL,
  `docent` varchar(255) NOT NULL,
  `docmdother` varchar(255) NOT NULL,
  `preferredcontact` varchar(255) DEFAULT NULL,
  `copyreqdate` varchar(255) DEFAULT NULL,
  `best_time` varchar(10) DEFAULT NULL,
  `best_number` varchar(10) DEFAULT NULL,
  `emergency_relationship` varchar(255) DEFAULT NULL,
  `has_s_m_ins` varchar(5) DEFAULT NULL,
  `referred_notes` varchar(255) DEFAULT NULL,
  `login` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `recover_hash` varchar(100) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `registered` tinyint(1) DEFAULT NULL,
  `parent_patientid` int(11) DEFAULT NULL,
  `access_code` varchar(100) DEFAULT NULL,
  `has_p_m_ins` varchar(5) DEFAULT NULL,
  `registration_status` int(1) DEFAULT '0',
  `text_date` datetime DEFAULT NULL,
  `text_num` int(2) NOT NULL DEFAULT '0',
  `use_patient_portal` int(1) NOT NULL DEFAULT '1',
  `registration_senton` datetime DEFAULT NULL,
  `preferred_name` varchar(100) DEFAULT NULL,
  `feet` varchar(255) DEFAULT NULL,
  `inches` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `bmi` varchar(255) DEFAULT NULL,
  `docmdother2` varchar(255) NOT NULL,
  `symptoms_status` tinyint(1) DEFAULT '0',
  `sleep_status` tinyint(1) DEFAULT '0',
  `treatments_status` tinyint(1) DEFAULT '0',
  `history_status` tinyint(1) DEFAULT '0',
  `access_code_date` datetime DEFAULT NULL,
  `email_bounce` tinyint(1) NOT NULL DEFAULT '0',
  `docmdother3` varchar(255) NOT NULL,
  `last_reg_sect` int(3) NOT NULL DEFAULT '0',
  `access_type` int(1) DEFAULT '1',
  `p_m_eligible_id` varchar(20) DEFAULT NULL,
  `homepage` tinyint(1) DEFAULT '0',
  `p_m_eligible_payer_id` varchar(20) DEFAULT NULL,
  `p_m_eligible_payer_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`patientid`)
) ENGINE=MyISAM AUTO_INCREMENT=468 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_patients`
--

LOCK TABLES `dental_patients` WRITE;
/*!40000 ALTER TABLE `dental_patients` DISABLE KEYS */;
INSERT INTO `dental_patients` VALUES (467,'Doe','John','','Mr.','','','','12/07/1977','123 Fake Street NEW','','Sparta','CA','888888','Male','Married','222222222',NULL,'3333333333','','5555555555','test@test.com','',244,244,1,'2014-01-28 23:12:15','10.20.1.168','','','','','','','','','','','','','John','','Doe','Self','','','','2343434','','','','','','','','','23434','','234343','','2','','7','','Yes','','12/07/1977','','Employer #1','123 Test','','Testcity','FL','45678','5555555555','5555555555','','','','','','','','','Jane Doe','Jane Doe','3333333333','2','1605',0,'','','1606','','','','paper','01/28/2014','morning','','wife','No','','jdoe','1a32b3be28e952694335044ebbef0e3f93f463b806d56ed9631e57f48a8ae1c6','4fd10892f1da','a105563396bbf2378abb1faa4e5d3a932d6ecdc743712f02acd7e71194e31df6','2014-01-28 23:14:56',NULL,NULL,'',NULL,1,'2014-01-28 23:14:56',0,1,'2014-01-28 23:14:56','John','6','1','210','27.7','',0,0,0,0,NULL,0,'',0,1,NULL,0,'','');
/*!40000 ALTER TABLE `dental_patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_pcont`
--

DROP TABLE IF EXISTS `dental_pcont`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_pcont` (
  `patient_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_pcont`
--

LOCK TABLES `dental_pcont` WRITE;
/*!40000 ALTER TABLE `dental_pcont` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_pcont` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_percase_invoice`
--

DROP TABLE IF EXISTS `dental_percase_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_percase_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `monthly_fee_date` date DEFAULT NULL,
  `monthly_fee_amount` decimal(11,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=446 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_percase_invoice`
--

LOCK TABLES `dental_percase_invoice` WRITE;
/*!40000 ALTER TABLE `dental_percase_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_percase_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_percase_invoice_extra`
--

DROP TABLE IF EXISTS `dental_percase_invoice_extra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_percase_invoice_extra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percase_date` date DEFAULT NULL,
  `percase_name` varchar(100) DEFAULT NULL,
  `percase_amount` decimal(11,2) DEFAULT NULL,
  `percase_status` tinyint(1) DEFAULT '0',
  `percase_invoice` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_percase_invoice_extra`
--

LOCK TABLES `dental_percase_invoice_extra` WRITE;
/*!40000 ALTER TABLE `dental_percase_invoice_extra` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_percase_invoice_extra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_place_service`
--

DROP TABLE IF EXISTS `dental_place_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_place_service` (
  `place_serviceid` int(11) NOT NULL AUTO_INCREMENT,
  `place_service` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`place_serviceid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_place_service`
--

LOCK TABLES `dental_place_service` WRITE;
/*!40000 ALTER TABLE `dental_place_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_place_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_plan_text`
--

DROP TABLE IF EXISTS `dental_plan_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_plan_text` (
  `plan_textid` int(11) NOT NULL AUTO_INCREMENT,
  `plan_text` text,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`plan_textid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_plan_text`
--

LOCK TABLES `dental_plan_text` WRITE;
/*!40000 ALTER TABLE `dental_plan_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_plan_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_plans`
--

DROP TABLE IF EXISTS `dental_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `monthly_fee` decimal(11,2) DEFAULT NULL,
  `trial_period` int(4) DEFAULT NULL,
  `fax_fee` decimal(11,2) DEFAULT NULL,
  `free_fax` int(4) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_plans`
--

LOCK TABLES `dental_plans` WRITE;
/*!40000 ALTER TABLE `dental_plans` DISABLE KEYS */;
INSERT INTO `dental_plans` VALUES (4,'plan1','199.00',14,'0.33',10,1,'2014-01-28 23:05:47','10.20.1.168');
/*!40000 ALTER TABLE `dental_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_procedure`
--

DROP TABLE IF EXISTS `dental_procedure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_procedure` (
  `procedureid` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT '0',
  `insuranceid` int(11) DEFAULT '0',
  `service_date_from` varchar(255) DEFAULT NULL,
  `service_date_to` varchar(255) DEFAULT NULL,
  `place_service` varchar(255) DEFAULT NULL,
  `type_service` varchar(255) DEFAULT NULL,
  `cpt_code` varchar(255) DEFAULT NULL,
  `units` varchar(255) DEFAULT NULL,
  `charge` varchar(255) DEFAULT NULL,
  `total_charge` varchar(255) DEFAULT NULL,
  `applies_icd` varchar(255) DEFAULT NULL,
  `npi` varchar(255) DEFAULT NULL,
  `other_id` varchar(255) DEFAULT NULL,
  `other_id_qualifier` varchar(255) DEFAULT NULL,
  `modifier_code_1` varchar(255) DEFAULT NULL,
  `modifier_code_2` varchar(255) DEFAULT NULL,
  `modifier_code_3` varchar(255) DEFAULT NULL,
  `modifier_code_4` varchar(255) DEFAULT NULL,
  `epsdt` varchar(255) DEFAULT NULL,
  `emg` varchar(255) DEFAULT NULL,
  `supplemental_info` varchar(255) DEFAULT NULL,
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`procedureid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_procedure`
--

LOCK TABLES `dental_procedure` WRITE;
/*!40000 ALTER TABLE `dental_procedure` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_procedure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_image`
--

DROP TABLE IF EXISTS `dental_q_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_image` (
  `imageid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `imagetypeid` int(11) DEFAULT '0',
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`imageid`)
) ENGINE=MyISAM AUTO_INCREMENT=405 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_image`
--

LOCK TABLES `dental_q_image` WRITE;
/*!40000 ALTER TABLE `dental_q_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_page1`
--

DROP TABLE IF EXISTS `dental_q_page1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_page1` (
  `q_page1id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `member_no` varchar(255) DEFAULT NULL,
  `group_no` varchar(255) DEFAULT NULL,
  `plan_no` varchar(255) DEFAULT NULL,
  `primary_care_physician` varchar(255) DEFAULT NULL,
  `feet` varchar(255) DEFAULT NULL,
  `inches` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `bmi` varchar(255) DEFAULT NULL,
  `sleep_qual` varchar(3) NOT NULL,
  `complaintid` text,
  `other_complaint` text,
  `additional_paragraph` text,
  `energy_level` varchar(255) DEFAULT NULL,
  `snoring_sound` varchar(255) DEFAULT NULL,
  `wake_night` varchar(255) DEFAULT NULL,
  `breathing_night` varchar(255) DEFAULT NULL,
  `morning_headaches` varchar(255) DEFAULT NULL,
  `hours_sleep` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `quit_breathing` varchar(255) DEFAULT NULL,
  `bed_time_partner` varchar(255) DEFAULT 'N/A',
  `sleep_same_room` varchar(255) DEFAULT NULL,
  `told_you_snore` varchar(255) DEFAULT NULL,
  `main_reason` text,
  `main_reason_other` varchar(255) DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `chief_complaint_text` text,
  `tss` varchar(20) DEFAULT NULL,
  `ess` varchar(20) DEFAULT NULL,
  `parent_patientid` int(11) DEFAULT NULL,
  PRIMARY KEY (`q_page1id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_page1`
--

LOCK TABLES `dental_q_page1` WRITE;
/*!40000 ALTER TABLE `dental_q_page1` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_page1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_page2`
--

DROP TABLE IF EXISTS `dental_q_page2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_page2` (
  `q_page2id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `polysomnographic` int(11) DEFAULT '0',
  `sleep_center_name` varchar(255) DEFAULT NULL,
  `sleep_study_on` varchar(255) DEFAULT NULL,
  `confirmed_diagnosis` varchar(255) DEFAULT NULL,
  `rdi` varchar(255) DEFAULT NULL,
  `ahi` varchar(255) DEFAULT NULL,
  `cpap` varchar(50) DEFAULT NULL,
  `intolerance` text,
  `other_intolerance` text,
  `other_therapy` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `affidavit` varchar(50) DEFAULT NULL,
  `type_study` varchar(255) DEFAULT NULL,
  `nights_wear_cpap` varchar(255) DEFAULT NULL,
  `percent_night_cpap` varchar(255) DEFAULT NULL,
  `custom_diagnosis` varchar(255) DEFAULT NULL,
  `sleep_study_by` varchar(255) DEFAULT NULL,
  `triedquittried` varchar(255) NOT NULL,
  `timesovertime` varchar(255) NOT NULL,
  `cur_cpap` varchar(50) DEFAULT NULL,
  `sleep_center_name_text` varchar(255) DEFAULT NULL,
  `dd_wearing` varchar(50) DEFAULT NULL,
  `dd_prev` varchar(50) DEFAULT NULL,
  `dd_otc` varchar(50) DEFAULT NULL,
  `dd_fab` varchar(50) DEFAULT NULL,
  `dd_who` varchar(255) DEFAULT NULL,
  `dd_experience` text,
  `surgery` varchar(50) DEFAULT NULL,
  `parent_patientid` int(11) DEFAULT NULL,
  PRIMARY KEY (`q_page2id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_page2`
--

LOCK TABLES `dental_q_page2` WRITE;
/*!40000 ALTER TABLE `dental_q_page2` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_page2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_page2_surgery`
--

DROP TABLE IF EXISTS `dental_q_page2_surgery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_page2_surgery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `surgery_date` varchar(255) DEFAULT NULL,
  `surgery` varchar(255) DEFAULT NULL,
  `surgeon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_page2_surgery`
--

LOCK TABLES `dental_q_page2_surgery` WRITE;
/*!40000 ALTER TABLE `dental_q_page2_surgery` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_page2_surgery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_page3`
--

DROP TABLE IF EXISTS `dental_q_page3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_page3` (
  `q_page3id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `allergens` text,
  `other_allergens` text,
  `medications` text,
  `other_medications` text,
  `history` text,
  `other_history` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `dental_health` varchar(255) DEFAULT NULL,
  `removable` varchar(255) DEFAULT NULL,
  `year_completed` varchar(255) DEFAULT NULL,
  `tmj` varchar(255) DEFAULT NULL,
  `gum_problems` varchar(255) DEFAULT NULL,
  `dental_pain` varchar(255) DEFAULT NULL,
  `dental_pain_describe` text,
  `completed_future` varchar(255) DEFAULT NULL,
  `clinch_grind` varchar(255) DEFAULT NULL,
  `wisdom_extraction` varchar(255) DEFAULT NULL,
  `injurytohead` varchar(255) NOT NULL,
  `injurytoneck` varchar(255) NOT NULL,
  `injurytoface` varchar(255) NOT NULL,
  `injurytoteeth` varchar(255) NOT NULL,
  `injurytomouth` varchar(255) NOT NULL,
  `drymouth` varchar(255) NOT NULL,
  `jawjointsurgery` varchar(255) NOT NULL,
  `no_allergens` varchar(1) DEFAULT '0',
  `no_medications` varchar(1) DEFAULT '0',
  `no_history` varchar(1) DEFAULT '0',
  `orthodontics` varchar(255) DEFAULT NULL,
  `family_hd` varchar(50) DEFAULT NULL,
  `family_bp` varchar(50) DEFAULT NULL,
  `family_dia` varchar(50) DEFAULT NULL,
  `family_sd` varchar(50) DEFAULT NULL,
  `alcohol` varchar(50) DEFAULT NULL,
  `sedative` varchar(50) DEFAULT NULL,
  `caffeine` varchar(50) DEFAULT NULL,
  `smoke` varchar(50) DEFAULT NULL,
  `smoke_packs` varchar(50) DEFAULT NULL,
  `tobacco` varchar(50) DEFAULT NULL,
  `wisdom_extraction_text` varchar(255) DEFAULT NULL,
  `removable_text` varchar(255) DEFAULT NULL,
  `dentures` varchar(50) DEFAULT NULL,
  `dentures_text` varchar(255) DEFAULT NULL,
  `tmj_cp` varchar(50) DEFAULT NULL,
  `tmj_cp_text` varchar(255) DEFAULT NULL,
  `tmj_pain` varchar(50) DEFAULT NULL,
  `tmj_pain_text` varchar(255) DEFAULT NULL,
  `tmj_surgery` varchar(50) DEFAULT NULL,
  `tmj_surgery_text` varchar(255) DEFAULT NULL,
  `injury` varchar(50) DEFAULT NULL,
  `injury_text` varchar(255) DEFAULT NULL,
  `gum_prob` varchar(50) DEFAULT NULL,
  `gum_prob_text` varchar(255) DEFAULT NULL,
  `gum_surgery` varchar(50) DEFAULT NULL,
  `gum_surgery_text` varchar(255) DEFAULT NULL,
  `clinch_grind_text` varchar(255) DEFAULT NULL,
  `future_dental_det` varchar(255) DEFAULT NULL,
  `drymouth_text` varchar(255) DEFAULT NULL,
  `allergenscheck` tinyint(1) DEFAULT '0',
  `medicationscheck` tinyint(1) DEFAULT '0',
  `historycheck` tinyint(1) DEFAULT '0',
  `parent_patientid` int(11) DEFAULT NULL,
  `additional_paragraph` text,
  PRIMARY KEY (`q_page3id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_page3`
--

LOCK TABLES `dental_q_page3` WRITE;
/*!40000 ALTER TABLE `dental_q_page3` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_page3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_page4`
--

DROP TABLE IF EXISTS `dental_q_page4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_page4` (
  `q_page4id` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `family_had` varchar(255) DEFAULT NULL,
  `family_diagnosed` varchar(255) DEFAULT NULL,
  `additional_paragraph` text,
  `alcohol` varchar(255) DEFAULT NULL,
  `sedative` varchar(255) DEFAULT NULL,
  `caffeine` varchar(255) DEFAULT NULL,
  `smoke` varchar(255) DEFAULT NULL,
  `smoke_packs` varchar(255) DEFAULT NULL,
  `tobacco` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `parent_patientid` int(11) DEFAULT NULL,
  PRIMARY KEY (`q_page4id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_page4`
--

LOCK TABLES `dental_q_page4` WRITE;
/*!40000 ALTER TABLE `dental_q_page4` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_page4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_recipients`
--

DROP TABLE IF EXISTS `dental_q_recipients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_recipients` (
  `q_recipientsid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `referring_physician` text,
  `dentist` text,
  `physicians_other` text,
  `patient_info` text,
  `q_file1` varchar(255) DEFAULT NULL,
  `q_file2` varchar(255) DEFAULT NULL,
  `q_file3` varchar(255) DEFAULT NULL,
  `q_file4` varchar(255) DEFAULT NULL,
  `q_file5` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `q_file6` varchar(255) DEFAULT NULL,
  `q_file7` varchar(255) DEFAULT NULL,
  `q_file8` varchar(255) DEFAULT NULL,
  `q_file9` varchar(255) DEFAULT NULL,
  `q_file10` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`q_recipientsid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_recipients`
--

LOCK TABLES `dental_q_recipients` WRITE;
/*!40000 ALTER TABLE `dental_q_recipients` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_recipients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_q_sleep`
--

DROP TABLE IF EXISTS `dental_q_sleep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_q_sleep` (
  `q_sleepid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `epworthid` text,
  `analysis` text,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `parent_patientid` int(11) DEFAULT NULL,
  PRIMARY KEY (`q_sleepid`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_q_sleep`
--

LOCK TABLES `dental_q_sleep` WRITE;
/*!40000 ALTER TABLE `dental_q_sleep` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_q_sleep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_qualifier`
--

DROP TABLE IF EXISTS `dental_qualifier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_qualifier` (
  `qualifierid` int(11) NOT NULL AUTO_INCREMENT,
  `qualifier` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`qualifierid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_qualifier`
--

LOCK TABLES `dental_qualifier` WRITE;
/*!40000 ALTER TABLE `dental_qualifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_qualifier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_range_motion`
--

DROP TABLE IF EXISTS `dental_range_motion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_range_motion` (
  `range_motionid` int(11) NOT NULL AUTO_INCREMENT,
  `range_motion` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`range_motionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_range_motion`
--

LOCK TABLES `dental_range_motion` WRITE;
/*!40000 ALTER TABLE `dental_range_motion` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_range_motion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_referredby`
--

DROP TABLE IF EXISTS `dental_referredby`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_referredby` (
  `referredbyid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `add1` varchar(255) DEFAULT NULL,
  `add2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `national_provider_id` varchar(255) DEFAULT NULL,
  `qualifier` varchar(255) DEFAULT NULL,
  `qualifierid` varchar(255) DEFAULT NULL,
  `greeting` varchar(255) DEFAULT NULL,
  `sincerely` varchar(255) DEFAULT NULL,
  `contacttypeid` int(11) DEFAULT '0',
  `notes` text,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `preferredcontact` varchar(255) DEFAULT NULL,
  `referredby_info` int(1) DEFAULT NULL,
  PRIMARY KEY (`referredbyid`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_referredby`
--

LOCK TABLES `dental_referredby` WRITE;
/*!40000 ALTER TABLE `dental_referredby` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_referredby` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_resources`
--

DROP TABLE IF EXISTS `dental_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=206 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_resources`
--

LOCK TABLES `dental_resources` WRITE;
/*!40000 ALTER TABLE `dental_resources` DISABLE KEYS */;
INSERT INTO `dental_resources` VALUES (205,'Chair 1',1,244);
/*!40000 ALTER TABLE `dental_resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_screener`
--

DROP TABLE IF EXISTS `dental_screener`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_screener` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `epworth_reading` tinyint(1) DEFAULT '0',
  `epworth_public` tinyint(1) DEFAULT '0',
  `epworth_passenger` tinyint(1) DEFAULT '0',
  `epworth_lying` tinyint(1) DEFAULT '0',
  `epworth_talking` tinyint(1) DEFAULT '0',
  `epworth_lunch` tinyint(1) DEFAULT '0',
  `epworth_traffic` tinyint(1) DEFAULT '0',
  `snore_1` tinyint(1) DEFAULT '0',
  `snore_2` tinyint(1) DEFAULT '0',
  `snore_3` tinyint(1) DEFAULT '0',
  `snore_4` tinyint(1) DEFAULT '0',
  `snore_5` tinyint(1) DEFAULT '0',
  `breathing` tinyint(1) DEFAULT '0',
  `driving` tinyint(1) DEFAULT '0',
  `gasping` tinyint(1) DEFAULT '0',
  `sleepy` tinyint(1) DEFAULT '0',
  `snore` tinyint(1) DEFAULT '0',
  `weight_gain` tinyint(1) DEFAULT '0',
  `blood_pressure` tinyint(1) DEFAULT '0',
  `jerk` tinyint(1) DEFAULT '0',
  `burning` tinyint(1) DEFAULT '0',
  `headaches` tinyint(1) DEFAULT '0',
  `falling_asleep` tinyint(1) DEFAULT '0',
  `staying_asleep` tinyint(1) DEFAULT '0',
  `rx_blood_pressure` tinyint(1) DEFAULT '0',
  `rx_hypertension` tinyint(1) DEFAULT '0',
  `rx_heart_disease` tinyint(1) DEFAULT '0',
  `rx_stroke` tinyint(1) DEFAULT '0',
  `rx_apnea` tinyint(1) DEFAULT '0',
  `rx_diabetes` tinyint(1) DEFAULT '0',
  `rx_lung_disease` tinyint(1) DEFAULT '0',
  `rx_insomnia` tinyint(1) DEFAULT '0',
  `rx_depression` tinyint(1) DEFAULT '0',
  `rx_narcolepsy` tinyint(1) DEFAULT '0',
  `rx_medication` tinyint(1) DEFAULT '0',
  `rx_restless_leg` tinyint(1) DEFAULT '0',
  `rx_headaches` tinyint(1) DEFAULT '0',
  `rx_heartburn` tinyint(1) DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `rx_cpap` tinyint(1) DEFAULT '0',
  `phone` varchar(30) DEFAULT NULL,
  `contacted` tinyint(1) DEFAULT '0',
  `rx_heart_failure` tinyint(1) DEFAULT '0',
  `rx_metabolic_syndrome` tinyint(1) DEFAULT '0',
  `rx_obesity` tinyint(1) DEFAULT '0',
  `patient_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_screener`
--

LOCK TABLES `dental_screener` WRITE;
/*!40000 ALTER TABLE `dental_screener` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_screener` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_screener_epworth`
--

DROP TABLE IF EXISTS `dental_screener_epworth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_screener_epworth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `screener_id` int(11) DEFAULT NULL,
  `epworth_id` int(11) DEFAULT NULL,
  `response` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1680 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_screener_epworth`
--

LOCK TABLES `dental_screener_epworth` WRITE;
/*!40000 ALTER TABLE `dental_screener_epworth` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_screener_epworth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_screening`
--

DROP TABLE IF EXISTS `dental_screening`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_screening` (
  `screeningid` int(11) NOT NULL AUTO_INCREMENT,
  `screening` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`screeningid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_screening`
--

LOCK TABLES `dental_screening` WRITE;
/*!40000 ALTER TABLE `dental_screening` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_screening` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_sleeplab`
--

DROP TABLE IF EXISTS `dental_sleeplab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_sleeplab` (
  `sleeplabid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `add1` varchar(255) DEFAULT NULL,
  `add2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `greeting` varchar(255) DEFAULT NULL,
  `sincerely` varchar(255) DEFAULT NULL,
  `notes` text,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sleeplabid`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_sleeplab`
--

LOCK TABLES `dental_sleeplab` WRITE;
/*!40000 ALTER TABLE `dental_sleeplab` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_sleeplab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_sleepstudy`
--

DROP TABLE IF EXISTS `dental_sleepstudy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_sleepstudy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testnumber` varchar(255) NOT NULL,
  `docid` varchar(255) NOT NULL,
  `patientid` varchar(255) NOT NULL,
  `needed` varchar(255) NOT NULL,
  `scheddate` varchar(255) NOT NULL,
  `sleeplabwheresched` varchar(255) NOT NULL,
  `completed` varchar(255) NOT NULL,
  `interpolation` varchar(255) NOT NULL,
  `labtype` varchar(255) NOT NULL,
  `copyreqdate` varchar(255) NOT NULL,
  `sleeplab` varchar(255) NOT NULL,
  `scanext` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_sleepstudy`
--

LOCK TABLES `dental_sleepstudy` WRITE;
/*!40000 ALTER TABLE `dental_sleepstudy` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_sleepstudy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_soft_palate`
--

DROP TABLE IF EXISTS `dental_soft_palate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_soft_palate` (
  `soft_palateid` int(11) NOT NULL AUTO_INCREMENT,
  `soft_palate` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`soft_palateid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_soft_palate`
--

LOCK TABLES `dental_soft_palate` WRITE;
/*!40000 ALTER TABLE `dental_soft_palate` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_soft_palate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_summ_sleeplab`
--

DROP TABLE IF EXISTS `dental_summ_sleeplab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_summ_sleeplab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `sleeptesttype` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `apnea` varchar(255) NOT NULL,
  `hypopnea` varchar(255) NOT NULL,
  `ahi` varchar(255) NOT NULL,
  `ahisupine` varchar(255) NOT NULL,
  `rdi` varchar(255) NOT NULL,
  `rdisupine` varchar(255) NOT NULL,
  `o2nadir` varchar(255) NOT NULL,
  `t9002` varchar(255) NOT NULL,
  `sleepefficiency` varchar(255) NOT NULL,
  `cpaplevel` varchar(255) NOT NULL,
  `dentaldevice` varchar(255) NOT NULL,
  `devicesetting` varchar(255) NOT NULL,
  `diagnosis` varchar(255) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `patiendid` varchar(255) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `testnumber` varchar(255) DEFAULT NULL,
  `needed` varchar(255) DEFAULT NULL,
  `scheddate` varchar(255) DEFAULT NULL,
  `completed` varchar(255) DEFAULT NULL,
  `interpolation` varchar(255) DEFAULT NULL,
  `copyreqdate` varchar(255) DEFAULT NULL,
  `sleeplab` varchar(255) DEFAULT NULL,
  `diagnosising_doc` varchar(255) DEFAULT NULL,
  `diagnosising_npi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=190 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_summ_sleeplab`
--

LOCK TABLES `dental_summ_sleeplab` WRITE;
/*!40000 ALTER TABLE `dental_summ_sleeplab` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_summ_sleeplab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_summary`
--

DROP TABLE IF EXISTS `dental_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_summary` (
  `summaryid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT NULL,
  `patientid` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `patient_dob` varchar(255) DEFAULT NULL,
  `docpcp` varchar(255) NOT NULL,
  `docsmd` varchar(255) NOT NULL,
  `docomd1` varchar(255) NOT NULL,
  `docomd2` varchar(255) NOT NULL,
  `docdds` varchar(255) NOT NULL,
  `osite` varchar(255) NOT NULL,
  `referral_source` varchar(255) DEFAULT NULL,
  `reason_seeking_tx` text,
  `symptoms_osa` varchar(255) DEFAULT NULL,
  `bed_time_partner` varchar(255) DEFAULT NULL,
  `snoring` varchar(255) DEFAULT NULL,
  `apnea` varchar(255) DEFAULT NULL,
  `history_surgery` text,
  `tried_cpap` varchar(255) DEFAULT NULL,
  `cpap_totalnights` int(1) NOT NULL,
  `fna` varchar(255) NOT NULL DEFAULT 'na',
  `cpap_date` varchar(255) DEFAULT NULL,
  `problem_cpap` text,
  `wearing_cpap` varchar(255) DEFAULT NULL,
  `max_translation_from` varchar(255) DEFAULT NULL,
  `max_translation_to` varchar(255) DEFAULT NULL,
  `max_translation_equal` varchar(255) DEFAULT NULL,
  `initial_device_titration_1` varchar(255) DEFAULT NULL,
  `initial_device_titration_equal_h` varchar(255) DEFAULT NULL,
  `initial_device_titration_equal_v` varchar(255) NOT NULL,
  `optimum_echovision_ver` varchar(255) DEFAULT NULL,
  `optimum_echovision_hor` varchar(255) DEFAULT NULL,
  `type_device` varchar(255) DEFAULT NULL,
  `personal` text,
  `lab_name` varchar(255) DEFAULT NULL,
  `sti_test_1` varchar(255) DEFAULT NULL,
  `sti_test_2` varchar(255) DEFAULT NULL,
  `sti_test_3` varchar(255) DEFAULT NULL,
  `sti_test_4` varchar(255) DEFAULT NULL,
  `sti_date_1` varchar(255) DEFAULT NULL,
  `sti_date_2` varchar(255) DEFAULT NULL,
  `sti_date_3` varchar(255) DEFAULT NULL,
  `sti_date_4` varchar(255) DEFAULT NULL,
  `sti_ahi_1` varchar(255) DEFAULT NULL,
  `sti_ahi_2` varchar(255) DEFAULT NULL,
  `sti_ahi_3` varchar(255) DEFAULT NULL,
  `sti_ahi_4` varchar(255) DEFAULT NULL,
  `sti_rdi_1` varchar(255) DEFAULT NULL,
  `sti_rdi_2` varchar(255) DEFAULT NULL,
  `sti_rdi_3` varchar(255) DEFAULT NULL,
  `sti_rdi_4` varchar(255) DEFAULT NULL,
  `sti_supine_ahi_1` varchar(255) DEFAULT NULL,
  `sti_supine_ahi_2` varchar(255) DEFAULT NULL,
  `sti_supine_ahi_3` varchar(255) DEFAULT NULL,
  `sti_supine_ahi_4` varchar(255) DEFAULT NULL,
  `sti_supine_rdi_1` varchar(255) DEFAULT NULL,
  `sti_supine_rdi_2` varchar(255) DEFAULT NULL,
  `sti_supine_rdi_3` varchar(255) DEFAULT NULL,
  `sti_supine_rdi_4` varchar(255) DEFAULT NULL,
  `sti_lsat_1` varchar(255) DEFAULT NULL,
  `sti_lsat_2` varchar(255) DEFAULT NULL,
  `sti_lsat_3` varchar(255) DEFAULT NULL,
  `sti_lsat_4` varchar(255) DEFAULT NULL,
  `sti_titration_1` varchar(255) DEFAULT NULL,
  `sti_titration_2` varchar(255) DEFAULT NULL,
  `sti_titration_3` varchar(255) DEFAULT NULL,
  `sti_titration_4` varchar(255) DEFAULT NULL,
  `sti_cpap_p_1` varchar(255) DEFAULT NULL,
  `sti_cpap_p_2` varchar(255) DEFAULT NULL,
  `sti_cpap_p_3` varchar(255) DEFAULT NULL,
  `sti_cpap_p_4` varchar(255) DEFAULT NULL,
  `sti_apnea_1` varchar(255) DEFAULT NULL,
  `sti_apnea_2` varchar(255) DEFAULT NULL,
  `sti_apnea_3` varchar(255) DEFAULT NULL,
  `sti_apnea_4` varchar(255) DEFAULT NULL,
  `ep_date_1` varchar(255) DEFAULT NULL,
  `ep_date_2` varchar(255) DEFAULT NULL,
  `ep_date_3` varchar(255) DEFAULT NULL,
  `ep_date_4` varchar(255) DEFAULT NULL,
  `ep_date_5` varchar(255) DEFAULT NULL,
  `dset1` varchar(255) NOT NULL,
  `dset2` varchar(255) NOT NULL,
  `dset3` varchar(255) NOT NULL,
  `dset4` varchar(255) NOT NULL,
  `dset5` varchar(255) NOT NULL,
  `ep_e_1` varchar(255) DEFAULT NULL,
  `ep_e_2` varchar(255) DEFAULT NULL,
  `ep_e_3` varchar(255) DEFAULT NULL,
  `ep_e_4` varchar(255) DEFAULT NULL,
  `ep_e_5` varchar(255) DEFAULT NULL,
  `ep_s_1` varchar(255) DEFAULT NULL,
  `ep_s_2` varchar(255) DEFAULT NULL,
  `ep_s_3` varchar(255) DEFAULT NULL,
  `ep_s_4` varchar(255) DEFAULT NULL,
  `ep_s_5` varchar(255) DEFAULT NULL,
  `ep_w_1` varchar(255) DEFAULT NULL,
  `ep_w_2` varchar(255) DEFAULT NULL,
  `ep_w_3` varchar(255) DEFAULT NULL,
  `ep_w_4` varchar(255) DEFAULT NULL,
  `ep_w_5` varchar(255) DEFAULT NULL,
  `ep_a_1` varchar(255) DEFAULT NULL,
  `ep_a_2` varchar(255) DEFAULT NULL,
  `ep_a_3` varchar(255) DEFAULT NULL,
  `ep_a_4` varchar(255) DEFAULT NULL,
  `ep_a_5` varchar(255) DEFAULT NULL,
  `ep_el_1` varchar(255) DEFAULT NULL,
  `ep_el_2` varchar(255) DEFAULT NULL,
  `ep_el_3` varchar(255) DEFAULT NULL,
  `ep_el_4` varchar(255) DEFAULT NULL,
  `ep_el_5` varchar(255) DEFAULT NULL,
  `ep_h_1` varchar(255) DEFAULT NULL,
  `ep_h_2` varchar(255) DEFAULT NULL,
  `ep_h_3` varchar(255) DEFAULT NULL,
  `ep_h_4` varchar(255) DEFAULT NULL,
  `ep_h_5` varchar(255) DEFAULT NULL,
  `ep_r_1` varchar(255) DEFAULT NULL,
  `ep_r_2` varchar(255) DEFAULT NULL,
  `ep_r_3` varchar(255) DEFAULT NULL,
  `ep_r_4` varchar(255) DEFAULT NULL,
  `ep_r_5` varchar(255) DEFAULT NULL,
  `mini_consult` varchar(255) DEFAULT NULL,
  `exam_impressions` varchar(255) DEFAULT NULL,
  `oa_soap` varchar(255) DEFAULT NULL,
  `fm_blue` varchar(255) DEFAULT NULL,
  `oa_check_1` varchar(255) DEFAULT NULL,
  `oa_check_2` varchar(255) DEFAULT NULL,
  `oa_check_3` varchar(255) DEFAULT NULL,
  `oa_check_4` varchar(255) DEFAULT NULL,
  `oa_check_5` varchar(255) DEFAULT NULL,
  `oa_check_6` varchar(255) DEFAULT NULL,
  `month_check_1` varchar(255) DEFAULT NULL,
  `month_check_2` varchar(255) DEFAULT NULL,
  `month_check_3` varchar(255) DEFAULT NULL,
  `month_check_4` varchar(255) DEFAULT NULL,
  `oa_psg` varchar(255) DEFAULT NULL,
  `year_check_1` varchar(255) DEFAULT NULL,
  `year_check_2` varchar(255) DEFAULT NULL,
  `year_check_3` varchar(255) DEFAULT NULL,
  `year_check_4` varchar(255) DEFAULT NULL,
  `additional_notes` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `office` varchar(255) DEFAULT NULL,
  `sleep_same_room` varchar(255) DEFAULT NULL,
  `currently_wearing` varchar(255) DEFAULT NULL,
  `what_percentage` varchar(255) DEFAULT NULL,
  `how_long` varchar(255) DEFAULT NULL,
  `sleep_md` text,
  `test_type_name` varchar(255) DEFAULT NULL,
  `sti_sleep_efficiency_1` varchar(255) DEFAULT NULL,
  `sti_sleep_efficiency_2` varchar(255) DEFAULT NULL,
  `sti_sleep_efficiency_3` varchar(255) DEFAULT NULL,
  `sti_sleep_efficiency_4` varchar(255) DEFAULT NULL,
  `sti_rem_ahi_1` varchar(255) DEFAULT NULL,
  `sti_rem_ahi_2` varchar(255) DEFAULT NULL,
  `sti_rem_ahi_3` varchar(255) DEFAULT NULL,
  `sti_rem_ahi_4` varchar(255) DEFAULT NULL,
  `sti_o2_1` varchar(255) DEFAULT NULL,
  `sti_o2_2` varchar(255) DEFAULT NULL,
  `sti_o2_3` varchar(255) DEFAULT NULL,
  `sti_o2_4` varchar(255) DEFAULT NULL,
  `sti_other_1` varchar(255) DEFAULT NULL,
  `sti_other_2` varchar(255) DEFAULT NULL,
  `sti_other_3` varchar(255) DEFAULT NULL,
  `sti_other_4` varchar(255) DEFAULT NULL,
  `ep_ts_1` varchar(255) DEFAULT NULL,
  `ep_ts_2` varchar(255) DEFAULT NULL,
  `ep_ts_3` varchar(255) DEFAULT NULL,
  `ep_ts_4` varchar(255) DEFAULT NULL,
  `ep_ts_5` varchar(255) DEFAULT NULL,
  `ep_tr_1` varchar(255) DEFAULT NULL,
  `ep_tr_2` varchar(255) DEFAULT NULL,
  `ep_tr_3` varchar(255) DEFAULT NULL,
  `ep_tr_4` varchar(255) DEFAULT NULL,
  `ep_tr_5` varchar(255) DEFAULT NULL,
  `appt_notes_1` varchar(1000) NOT NULL,
  `appt_notes_2` varchar(1000) NOT NULL,
  `appt_notes_3` varchar(1000) NOT NULL,
  `appt_notes_4` varchar(1000) NOT NULL,
  `appt_notes_1p3` varchar(1000) NOT NULL,
  `appt_notes_2p3` varchar(1000) NOT NULL,
  `appt_notes_3p3` varchar(1000) NOT NULL,
  `appt_notes_4p3` varchar(1000) NOT NULL,
  `appt_notes_5p3` varchar(1000) NOT NULL,
  `wapn1` varchar(255) NOT NULL,
  `wapn2` varchar(255) NOT NULL,
  `wapn3` varchar(255) NOT NULL,
  `wapn4` varchar(255) NOT NULL,
  `wapn5` varchar(255) NOT NULL,
  `patientphoto` varchar(500) NOT NULL,
  `sleep_qual1` varchar(255) NOT NULL,
  `sleep_qual2` varchar(255) NOT NULL,
  `sleep_qual3` varchar(255) NOT NULL,
  `sleep_qual4` varchar(255) NOT NULL,
  `sleep_qual5` varchar(255) NOT NULL,
  `location` int(11) DEFAULT NULL,
  PRIMARY KEY (`summaryid`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_summary`
--

LOCK TABLES `dental_summary` WRITE;
/*!40000 ALTER TABLE `dental_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_support_attachment`
--

DROP TABLE IF EXISTS `dental_support_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_support_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `response_id` int(11) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_support_attachment`
--

LOCK TABLES `dental_support_attachment` WRITE;
/*!40000 ALTER TABLE `dental_support_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_support_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_support_categories`
--

DROP TABLE IF EXISTS `dental_support_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_support_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_support_categories`
--

LOCK TABLES `dental_support_categories` WRITE;
/*!40000 ALTER TABLE `dental_support_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_support_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_support_category_admin`
--

DROP TABLE IF EXISTS `dental_support_category_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_support_category_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_support_category_admin`
--

LOCK TABLES `dental_support_category_admin` WRITE;
/*!40000 ALTER TABLE `dental_support_category_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_support_category_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_support_responses`
--

DROP TABLE IF EXISTS `dental_support_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_support_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `responder_id` int(11) DEFAULT NULL,
  `body` text,
  `response_type` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT '0',
  `attachment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_support_responses`
--

LOCK TABLES `dental_support_responses` WRITE;
/*!40000 ALTER TABLE `dental_support_responses` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_support_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_support_tickets`
--

DROP TABLE IF EXISTS `dental_support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `body` text,
  `category_id` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ip_address` varchar(50) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT '0',
  `creator_id` int(11) DEFAULT NULL,
  `create_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_support_tickets`
--

LOCK TABLES `dental_support_tickets` WRITE;
/*!40000 ALTER TABLE `dental_support_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_support_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_task`
--

DROP TABLE IF EXISTS `dental_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255) DEFAULT NULL,
  `description` text,
  `userid` int(11) DEFAULT NULL,
  `responsibleid` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `recurring` int(11) DEFAULT NULL,
  `recurring_unit` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(5) DEFAULT NULL,
  `patientid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_task`
--

LOCK TABLES `dental_task` WRITE;
/*!40000 ALTER TABLE `dental_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_thorton`
--

DROP TABLE IF EXISTS `dental_thorton`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_thorton` (
  `thortonid` int(11) NOT NULL AUTO_INCREMENT,
  `formid` int(11) DEFAULT '0',
  `patientid` int(11) DEFAULT '0',
  `snore_1` varchar(255) DEFAULT NULL,
  `snore_2` varchar(255) DEFAULT NULL,
  `snore_3` varchar(255) DEFAULT NULL,
  `snore_4` varchar(255) DEFAULT NULL,
  `snore_5` varchar(255) DEFAULT NULL,
  `tot_score` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `docid` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`thortonid`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_thorton`
--

LOCK TABLES `dental_thorton` WRITE;
/*!40000 ALTER TABLE `dental_thorton` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_thorton` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_tongue`
--

DROP TABLE IF EXISTS `dental_tongue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_tongue` (
  `tongueid` int(11) NOT NULL AUTO_INCREMENT,
  `tongue` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`tongueid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_tongue`
--

LOCK TABLES `dental_tongue` WRITE;
/*!40000 ALTER TABLE `dental_tongue` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_tongue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_transaction_code`
--

DROP TABLE IF EXISTS `dental_transaction_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_transaction_code` (
  `transaction_codeid` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(255) NOT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `default_code` int(1) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `place` int(11) DEFAULT NULL,
  `modifier_code_1` varchar(255) DEFAULT NULL,
  `modifier_code_2` varchar(255) DEFAULT NULL,
  `days_units` int(2) DEFAULT NULL,
  `amount_adjust` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`transaction_codeid`)
) ENGINE=MyISAM AUTO_INCREMENT=5438 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_transaction_code`
--

LOCK TABLES `dental_transaction_code` WRITE;
/*!40000 ALTER TABLE `dental_transaction_code` DISABLE KEYS */;
INSERT INTO `dental_transaction_code` VALUES (8,'70320','Full Series Radiograph','1',999,1,'2011-02-02 10:06:54','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(6,'G0399','Unattended Sleep Study','1',999,1,'2011-02-02 10:06:07','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(7,'70355','Panoramic Radiograph','1',999,1,'2011-02-02 10:06:34','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(5,'E0486','Dental Device','1',1,1,'2011-02-02 09:34:19','97.78.153.94',1,NULL,NULL,2,'NU','KX',1,0),(9,'41500','Fixation of Tongue, Mechanical','1',999,1,'2011-02-02 10:07:10','97.78.153.94',1,NULL,NULL,2,NULL,NULL,NULL,0),(10,'92512','Rhinometer','1',999,1,'2011-02-02 10:07:26','97.78.153.94',1,NULL,NULL,1,'','',1,0),(11,'92520','Pharyngometer','1',999,1,'2011-02-02 10:07:43','97.78.153.94',1,NULL,NULL,0,'','',1,0),(12,'95800','Unattended Sleep Study','1',9,1,'2011-02-02 10:08:00','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(13,'95806','Unattended Sleep Study','1',999,1,'2011-02-02 10:08:20','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(14,'99070','Diagnostic Photographs','1',999,1,'2011-02-02 10:08:40','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(15,'99211','Established Patient 5 Minutes','1',999,1,'2011-02-02 10:09:01','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(16,'99212','Established Patient 10 Minutes','1',999,1,'2011-02-02 10:09:17','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(17,'99213','Established Patient 15 Minutes','1',999,1,'2011-02-02 10:09:30','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(18,'99214','Established Patient 25 Minutes','1',999,1,'2011-02-02 10:09:45','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(19,'99215','Established Patient 40 Minutes','1',999,1,'2011-02-02 10:10:07','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(20,'99245','Complex Consultation (60 min)','1',999,1,'2011-02-02 10:10:31','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(21,'99241','Consultation Level 1 (10 min)','1',999,1,'2011-02-02 10:11:10','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(22,'99242','Consultation Level 2 (30 min)','1',999,1,'2011-02-02 10:11:35','97.78.153.94',1,NULL,NULL,1,NULL,NULL,NULL,0),(23,'1','Cash','2',999,1,'2011-02-02 10:11:57','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(24,'2','Check','2',999,1,'2011-02-02 10:12:11','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(25,'3','Debit Card','2',999,1,'2011-02-02 10:12:25','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(26,'4','Visa','2',999,1,'2011-02-02 10:12:38','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(27,'5','MasterCard','2',999,1,'2011-02-02 10:13:01','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(28,'6','Discover Card','2',999,1,'2011-02-02 10:13:15','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(29,'7','American Express','2',999,1,'2011-02-02 10:13:29','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(30,'50','Insurance Payment','3',999,1,'2011-02-02 10:14:01','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(31,'51','Secondary Insurance Payment','3',999,1,'2011-02-02 10:14:30','97.78.153.94',1,NULL,NULL,NULL,NULL,NULL,NULL,0),(34,'98323','Impressions','1',999,1,'2011-04-27 17:08:24','192.168.1.168',1,NULL,'200.00',NULL,NULL,NULL,NULL,0),(377,'52','Writeoff','6',999,1,'2011-11-22 12:55:54','72.64.221.4',1,NULL,NULL,0,NULL,NULL,NULL,0),(378,'53','Pdisc','6',999,1,'2011-11-22 12:57:06','72.64.221.4',1,NULL,NULL,0,NULL,NULL,NULL,0),(691,'54','Refund','6',999,1,'2012-10-25 21:53:40','128.12.179.156',1,NULL,NULL,0,'','',0,0);
/*!40000 ALTER TABLE `dental_transaction_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_transaction_code_doc`
--

DROP TABLE IF EXISTS `dental_transaction_code_doc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_transaction_code_doc` (
  `transaction_codeid` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(255) NOT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `doc` varchar(255) NOT NULL,
  PRIMARY KEY (`transaction_codeid`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_transaction_code_doc`
--

LOCK TABLES `dental_transaction_code_doc` WRITE;
/*!40000 ALTER TABLE `dental_transaction_code_doc` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_transaction_code_doc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_type_service`
--

DROP TABLE IF EXISTS `dental_type_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_type_service` (
  `type_serviceid` int(11) NOT NULL AUTO_INCREMENT,
  `type_service` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`type_serviceid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_type_service`
--

LOCK TABLES `dental_type_service` WRITE;
/*!40000 ALTER TABLE `dental_type_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_type_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_user_company`
--

DROP TABLE IF EXISTS `dental_user_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=338 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_user_company`
--

LOCK TABLES `dental_user_company` WRITE;
/*!40000 ALTER TABLE `dental_user_company` DISABLE KEYS */;
INSERT INTO `dental_user_company` VALUES (337,244,19,NULL,NULL);
/*!40000 ALTER TABLE `dental_user_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_user_devices`
--

DROP TABLE IF EXISTS `dental_user_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_user_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_user_devices`
--

LOCK TABLES `dental_user_devices` WRITE;
/*!40000 ALTER TABLE `dental_user_devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_user_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_user_hst_company`
--

DROP TABLE IF EXISTS `dental_user_hst_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_user_hst_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_user_hst_company`
--

LOCK TABLES `dental_user_hst_company` WRITE;
/*!40000 ALTER TABLE `dental_user_hst_company` DISABLE KEYS */;
INSERT INTO `dental_user_hst_company` VALUES (34,244,18,'2014-01-28 23:06:18','10.20.1.168');
/*!40000 ALTER TABLE `dental_user_hst_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_user_labs`
--

DROP TABLE IF EXISTS `dental_user_labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_user_labs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `use_lab` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_user_labs`
--

LOCK TABLES `dental_user_labs` WRITE;
/*!40000 ALTER TABLE `dental_user_labs` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_user_labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_users`
--

DROP TABLE IF EXISTS `dental_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `user_access` int(11) DEFAULT '1',
  `docid` int(11) DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `npi` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `medicare_npi` varchar(255) DEFAULT NULL,
  `tax_id_or_ssn` varchar(255) DEFAULT NULL,
  `producer` int(1) DEFAULT NULL,
  `practice` varchar(255) DEFAULT NULL,
  `email_header` varchar(255) DEFAULT NULL,
  `email_footer` varchar(255) DEFAULT NULL,
  `fax_header` varchar(255) DEFAULT NULL,
  `fax_footer` varchar(255) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `recover_hash` varchar(100) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `ssn` tinyint(1) DEFAULT NULL,
  `ein` tinyint(1) DEFAULT NULL,
  `use_patient_portal` int(1) DEFAULT '0',
  `mailing_practice` varchar(255) DEFAULT NULL,
  `mailing_name` varchar(255) DEFAULT NULL,
  `mailing_address` text,
  `mailing_city` varchar(255) DEFAULT NULL,
  `mailing_state` varchar(255) DEFAULT NULL,
  `mailing_zip` varchar(255) DEFAULT NULL,
  `mailing_phone` varchar(250) DEFAULT NULL,
  `last_accessed_date` datetime DEFAULT NULL,
  `use_digital_fax` tinyint(1) NOT NULL DEFAULT '0',
  `fax` varchar(250) NOT NULL,
  `use_letters` tinyint(1) NOT NULL DEFAULT '1',
  `sign_notes` tinyint(1) NOT NULL DEFAULT '0',
  `use_eligible_api` tinyint(1) NOT NULL DEFAULT '0',
  `access_code` varchar(100) DEFAULT NULL,
  `text_date` datetime DEFAULT NULL,
  `text_num` int(2) NOT NULL DEFAULT '0',
  `access_code_date` datetime DEFAULT NULL,
  `registration_email_date` datetime DEFAULT NULL,
  `producer_files` tinyint(1) NOT NULL DEFAULT '0',
  `medicare_ptan` varchar(255) DEFAULT NULL,
  `use_course` tinyint(1) NOT NULL DEFAULT '0',
  `use_course_staff` tinyint(1) NOT NULL DEFAULT '0',
  `cc_id` varchar(150) DEFAULT NULL,
  `manage_staff` tinyint(1) NOT NULL DEFAULT '0',
  `user_type` tinyint(1) DEFAULT '1',
  `logo` varchar(100) DEFAULT NULL,
  `letter_margin_top` int(3) DEFAULT '14',
  `letter_margin_bottom` int(3) DEFAULT '40',
  `letter_margin_left` int(3) DEFAULT '18',
  `letter_margin_right` int(3) DEFAULT '18',
  `letter_margin_header` int(3) DEFAULT '48',
  `letter_margin_footer` int(3) DEFAULT '26',
  `claim_margin_top` int(3) DEFAULT '0',
  `claim_margin_left` int(3) DEFAULT '0',
  `homepage` tinyint(1) DEFAULT '0',
  `use_letter_header` tinyint(1) DEFAULT '1',
  `access_code_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `indent_address` tinyint(1) DEFAULT '1',
  `registration_date` datetime DEFAULT NULL,
  `header_space` tinyint(1) DEFAULT NULL,
  `billing_company_id` int(11) DEFAULT NULL,
  `edx_id` int(11) DEFAULT NULL,
  `help_id` int(11) DEFAULT NULL,
  `tracker_letters` tinyint(1) DEFAULT '1',
  `intro_letters` tinyint(1) DEFAULT '1',
  `plan_id` int(11) DEFAULT NULL,
  `suspended_reason` text,
  `suspended_date` datetime DEFAULT NULL,
  `use_labs` tinyint(1) DEFAULT NULL,
  `state_license_num` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=245 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_users`
--

LOCK TABLES `dental_users` WRITE;
/*!40000 ALTER TABLE `dental_users` DISABLE KEYS */;
INSERT INTO `dental_users` VALUES (244,2,0,'testfrontuser','123456','7975efc91aa5adbf889751782fd806b4e7cfe8e32fe9e2a76928fc4475d11528',NULL,'nathan+testfrontuser@dentalsleepsolutions.com','123 St','TestCity','AR','55555','5555555555',1,'2014-01-28 22:55:53','10.20.1.168','123456','987654',NULL,'Test Practice',NULL,NULL,NULL,NULL,'64d955d41e0c','8016dd81091cd49c3f991ed10edd2a2664ddbae547c909b0ba9e5fa2e221e46f','2014-01-28 22:56:34',0,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-01-28 23:15:20',1,'5555555555',1,0,0,'','2014-01-28 22:56:42',1,'2014-01-28 22:56:03','2014-01-28 22:56:34',0,'123456789',0,1,NULL,0,2,NULL,14,40,18,18,48,26,0,0,1,1,5,'Test','FrontUser',1,NULL,NULL,17,0,NULL,1,1,4,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dental_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dental_uvula`
--

DROP TABLE IF EXISTS `dental_uvula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_uvula` (
  `uvulaid` int(11) NOT NULL AUTO_INCREMENT,
  `uvula` varchar(255) DEFAULT NULL,
  `description` text,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`uvulaid`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dental_uvula`
--

LOCK TABLES `dental_uvula` WRITE;
/*!40000 ALTER TABLE `dental_uvula` DISABLE KEYS */;
/*!40000 ALTER TABLE `dental_uvula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentalsummfu`
--

DROP TABLE IF EXISTS `dentalsummfu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentalsummfu` (
  `patientid` int(5) NOT NULL,
  `followupid` int(5) NOT NULL AUTO_INCREMENT,
  `ep_dateadd` date NOT NULL,
  `devadd` varchar(255) NOT NULL,
  `dsetadd` varchar(255) NOT NULL,
  `ep_eadd` varchar(255) NOT NULL,
  `ep_tsadd` varchar(255) NOT NULL,
  `ep_sadd` varchar(255) NOT NULL,
  `ep_radd` varchar(255) NOT NULL,
  `ep_eladd` varchar(255) NOT NULL,
  `sleep_qualadd` varchar(255) NOT NULL,
  `ep_hadd` varchar(255) NOT NULL,
  `ep_wadd` varchar(255) NOT NULL,
  `wapnadd` varchar(255) NOT NULL,
  `hours_sleepadd` varchar(255) NOT NULL,
  `appt_notesadd` text NOT NULL,
  `nightsperweek` varchar(255) NOT NULL,
  PRIMARY KEY (`followupid`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentalsummfu`
--

LOCK TABLES `dentalsummfu` WRITE;
/*!40000 ALTER TABLE `dentalsummfu` DISABLE KEYS */;
/*!40000 ALTER TABLE `dentalsummfu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentalsummfu_ess`
--

DROP TABLE IF EXISTS `dentalsummfu_ess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentalsummfu_ess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `followupid` int(11) DEFAULT NULL,
  `epworthid` int(11) DEFAULT NULL,
  `answer` tinyint(2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=265 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentalsummfu_ess`
--

LOCK TABLES `dentalsummfu_ess` WRITE;
/*!40000 ALTER TABLE `dentalsummfu_ess` DISABLE KEYS */;
/*!40000 ALTER TABLE `dentalsummfu_ess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dentalsummfu_tss`
--

DROP TABLE IF EXISTS `dentalsummfu_tss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dentalsummfu_tss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `followupid` int(11) DEFAULT NULL,
  `thorntonid` int(11) DEFAULT NULL,
  `answer` tinyint(2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dentalsummfu_tss`
--

LOCK TABLES `dentalsummfu_tss` WRITE;
/*!40000 ALTER TABLE `dentalsummfu_tss` DISABLE KEYS */;
/*!40000 ALTER TABLE `dentalsummfu_tss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edx_certificates`
--

DROP TABLE IF EXISTS `edx_certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edx_certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) DEFAULT NULL,
  `edx_id` int(11) DEFAULT NULL,
  `course_name` varchar(200) DEFAULT NULL,
  `course_section` varchar(200) DEFAULT NULL,
  `course_subsection` varchar(200) DEFAULT NULL,
  `number_ce` int(4) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edx_certificates`
--

LOCK TABLES `edx_certificates` WRITE;
/*!40000 ALTER TABLE `edx_certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `edx_certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filemanager`
--

DROP TABLE IF EXISTS `filemanager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filemanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `content` mediumblob NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filemanager`
--

LOCK TABLES `filemanager` WRITE;
/*!40000 ALTER TABLE `filemanager` DISABLE KEYS */;
/*!40000 ALTER TABLE `filemanager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filemanager_al`
--

DROP TABLE IF EXISTS `filemanager_al`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filemanager_al` (
  `id` int(11) NOT NULL DEFAULT '0',
  `docid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `content` mediumblob NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filemanager_al`
--

LOCK TABLES `filemanager_al` WRITE;
/*!40000 ALTER TABLE `filemanager_al` DISABLE KEYS */;
/*!40000 ALTER TABLE `filemanager_al` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filemanager_dvd`
--

DROP TABLE IF EXISTS `filemanager_dvd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filemanager_dvd` (
  `id` int(11) NOT NULL DEFAULT '0',
  `docid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `content` mediumblob NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filemanager_dvd`
--

LOCK TABLES `filemanager_dvd` WRITE;
/*!40000 ALTER TABLE `filemanager_dvd` DISABLE KEYS */;
/*!40000 ALTER TABLE `filemanager_dvd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filemanager_edu`
--

DROP TABLE IF EXISTS `filemanager_edu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filemanager_edu` (
  `id` int(11) NOT NULL DEFAULT '0',
  `docid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `content` mediumblob NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filemanager_edu`
--

LOCK TABLES `filemanager_edu` WRITE;
/*!40000 ALTER TABLE `filemanager_edu` DISABLE KEYS */;
/*!40000 ALTER TABLE `filemanager_edu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filemanager_mark`
--

DROP TABLE IF EXISTS `filemanager_mark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filemanager_mark` (
  `id` int(11) NOT NULL DEFAULT '0',
  `docid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `content` mediumblob NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filemanager_mark`
--

LOCK TABLES `filemanager_mark` WRITE;
/*!40000 ALTER TABLE `filemanager_mark` DISABLE KEYS */;
/*!40000 ALTER TABLE `filemanager_mark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filemanager_sl`
--

DROP TABLE IF EXISTS `filemanager_sl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filemanager_sl` (
  `id` int(11) NOT NULL DEFAULT '0',
  `docid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `content` mediumblob NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filemanager_sl`
--

LOCK TABLES `filemanager_sl` WRITE;
/*!40000 ALTER TABLE `filemanager_sl` DISABLE KEYS */;
/*!40000 ALTER TABLE `filemanager_sl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flowsheet_segments`
--

DROP TABLE IF EXISTS `flowsheet_segments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flowsheet_segments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `sortby` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flowsheet_segments`
--

LOCK TABLES `flowsheet_segments` WRITE;
/*!40000 ALTER TABLE `flowsheet_segments` DISABLE KEYS */;
/*!40000 ALTER TABLE `flowsheet_segments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flowsheet_step_records`
--

DROP TABLE IF EXISTS `flowsheet_step_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flowsheet_step_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) NOT NULL,
  `stepid` int(11) NOT NULL,
  `completed` varchar(255) NOT NULL,
  `scheduled` varchar(255) NOT NULL,
  `generated` varchar(255) NOT NULL,
  `approved` varchar(255) NOT NULL,
  `via` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flowsheet_step_records`
--

LOCK TABLES `flowsheet_step_records` WRITE;
/*!40000 ALTER TABLE `flowsheet_step_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `flowsheet_step_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initial_contact`
--

DROP TABLE IF EXISTS `initial_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initial_contact` (
  `id` mediumint(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `referral_source` varchar(255) NOT NULL,
  `contact_location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initial_contact`
--

LOCK TABLES `initial_contact` WRITE;
/*!40000 ALTER TABLE `initial_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `initial_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memo`
--

DROP TABLE IF EXISTS `memo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memo` (
  `user_id` int(11) NOT NULL,
  `memo` text NOT NULL,
  `show_until` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memo`
--

LOCK TABLES `memo` WRITE;
/*!40000 ALTER TABLE `memo` DISABLE KEYS */;
/*!40000 ALTER TABLE `memo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memo_admin`
--

DROP TABLE IF EXISTS `memo_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memo_admin` (
  `memo_id` int(11) NOT NULL AUTO_INCREMENT,
  `memo` text NOT NULL,
  `last_update` date NOT NULL,
  `off_date` date NOT NULL,
  PRIMARY KEY (`memo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memo_admin`
--

LOCK TABLES `memo_admin` WRITE;
/*!40000 ALTER TABLE `memo_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `memo_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `segments_order`
--

DROP TABLE IF EXISTS `segments_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `segments_order` (
  `patientid` varchar(255) NOT NULL,
  `consultrow` int(11) NOT NULL,
  `sleepstudyrow` int(11) NOT NULL,
  `delayingtreatmentrow` int(11) NOT NULL,
  `refusedtreatmentrow` int(11) NOT NULL,
  `devicedeliveryrow` int(11) NOT NULL,
  `checkuprow` int(11) NOT NULL,
  `patientnoncomprow` int(11) NOT NULL,
  `homesleeptestrow` int(11) NOT NULL,
  `starttreatmentrow` int(11) NOT NULL,
  `annualrecallrow` int(11) NOT NULL,
  `impressionrow` int(11) NOT NULL,
  `terminationrow` int(11) NOT NULL,
  PRIMARY KEY (`patientid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `segments_order`
--

LOCK TABLES `segments_order` WRITE;
/*!40000 ALTER TABLE `segments_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `segments_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spine_area`
--

DROP TABLE IF EXISTS `spine_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spine_area` (
  `areaid` int(11) NOT NULL AUTO_INCREMENT,
  `area` varchar(255) DEFAULT NULL,
  `sortby` int(11) DEFAULT '999',
  `status` int(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`areaid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spine_area`
--

LOCK TABLES `spine_area` WRITE;
/*!40000 ALTER TABLE `spine_area` DISABLE KEYS */;
/*!40000 ALTER TABLE `spine_area` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-30 14:20:07
