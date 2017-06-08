-- This is NOT NEEDED WITH DOCKER
-- CREATE DATABASE  IF NOT EXISTS `ds3_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
-- USE `ds3_db`;													


-- MySQL dump 10.13  Distrib 5.6.26-74.0, for Linux (x86_64)
--
-- Host: localhost    Database: dentalsl_main_prod
-- ------------------------------------------------------
-- Server version	5.6.26-74.0-log

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
  `admin_access` int(11) DEFAULT '1',
  `last_accessed_date` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `claim_margin_top` int(3) DEFAULT '0',
  `claim_margin_left` int(3) DEFAULT '0',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `add1` varchar(100) DEFAULT NULL,
  `add2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `eligible_api_key` varchar(255) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `stripe_secret_key` varchar(255) DEFAULT NULL,
  `stripe_publishable_key` varchar(255) DEFAULT NULL,
  `monthly_fee` decimal(11,2) DEFAULT '0.00',
  `default_new` tinyint(1) DEFAULT '0',
  `free_fax` int(4) DEFAULT '0',
  `sfax_security_context` varchar(255) DEFAULT NULL,
  `sfax_app_id` varchar(255) DEFAULT NULL,
  `sfax_app_key` varchar(255) DEFAULT NULL,
  `sfax_init_vector` varchar(255) DEFAULT NULL,
  `fax_fee` decimal(11,2) DEFAULT '0.00',
  `company_type` tinyint(2) DEFAULT '1',
  `phone` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `sfax_encryption_key` varchar(255) DEFAULT NULL,
  `use_support` tinyint(1) DEFAULT '1',
  `exclusive` tinyint(1) DEFAULT '0',
  `vob_require_test` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `default_new` (`default_new`),
  KEY `sfax_app_id` (`sfax_app_id`),
  KEY `free_fax` (`free_fax`),
  KEY `company_type` (`company_type`),
  KEY `plan_id` (`plan_id`),
  KEY `use_support` (`use_support`),
  KEY `exclusive` (`exclusive`),
  KEY `vob_require_test` (`vob_require_test`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


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
  `status` tinyint(1) DEFAULT '1',
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `rec_pattern` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_change_list`
--

DROP TABLE IF EXISTS `dental_change_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_change_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `percase_date` datetime DEFAULT NULL,
  `percase_name` varchar(100) DEFAULT NULL,
  `percase_amount` decimal(11,2) DEFAULT NULL,
  `percase_status` tinyint(1) DEFAULT '0',
  `percase_invoice` int(11) DEFAULT NULL,
  `percase_free` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `claimid` (`claimid`),
  KEY `reference_id` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_claim_note_attachment`
--

DROP TABLE IF EXISTS `dental_claim_note_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_claim_note_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_claim_notes`
--

DROP TABLE IF EXISTS `dental_claim_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_claim_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claim_id` int(11) DEFAULT NULL,
  `create_type` int(1) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `note` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_claim_text`
--

DROP TABLE IF EXISTS `dental_claim_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_claim_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `default_text` tinyint(1) DEFAULT NULL,
  `companyid` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `merge_id` int(11) DEFAULT NULL,
  `merge_date` datetime DEFAULT NULL,
  `corporate` tinyint(1) DEFAULT '0',
  `dea_number` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`contactid`),
  KEY `docid` (`docid`),
  KEY `contacttypeid` (`contacttypeid`),
  KEY `status` (`status`),
  KEY `merge_id` (`merge_id`),
  KEY `national_provider_id` (`national_provider_id`),
  KEY `qualifierid` (`qualifierid`),
  KEY `manage_contact` (`docid`,`merge_id`,`status`,`lastname`,`company`),
  KEY `lastname` (`lastname`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `corporate` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`contacttypeid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`deviceid`),
  KEY `sortby` (`sortby`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `range_start_label` varchar(100) DEFAULT NULL,
  `range_end` int(2) DEFAULT NULL,
  `range_end_label` varchar(100) DEFAULT NULL,
  `options` int(2) DEFAULT NULL,
  `rank` int(2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `response` text,
  `eligibility_invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_eligibility_invoice`
--

DROP TABLE IF EXISTS `dental_eligibility_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_eligibility_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_eligible_enrollment`
--

DROP TABLE IF EXISTS `dental_eligible_enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_eligible_enrollment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `payer_id` varchar(20) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `response` text,
  `status` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `payer_name` text,
  `transaction_type_id` int(11) DEFAULT NULL,
  `enrollment_invoice_id` int(11) DEFAULT NULL,
  `npi` varchar(30) DEFAULT NULL,
  `facility_name` varchar(200) DEFAULT NULL,
  `provider_name` varchar(200) DEFAULT NULL,
  `tax_id` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `zip` varchar(200) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `contact_number` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `download_url` text,
  `signed_download_url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id`),
  KEY `claimid` (`claimid`),
  KEY `reference_id` (`reference_id`),
  KEY `adddate` (`adddate`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_email_log`
--

DROP TABLE IF EXISTS `dental_email_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_email_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `headers` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `to` (`to`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_enrollment_invoice`
--

DROP TABLE IF EXISTS `dental_enrollment_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_enrollment_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_enrollment_transaction_type`
--

DROP TABLE IF EXISTS `dental_enrollment_transaction_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_enrollment_transaction_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(10) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `endpoint_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`ex_page5id`),
  KEY `patientid` (`patientid`),
  KEY `dentaldevice` (`dentaldevice`),
  KEY `formid` (`formid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `status` (`status`),
  KEY `dentaldevice_date` (`dentaldevice_date`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `sfax_completed` tinyint(1) DEFAULT '0',
  `sfax_response` text,
  `sfax_status` tinyint(1) DEFAULT '0',
  `sfax_error_code` varchar(20) DEFAULT NULL,
  `letter_body` text,
  `viewed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `patientid` (`patientid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `contactid` (`contactid`),
  KEY `letterid` (`letterid`),
  KEY `sfax_completed` (`sfax_completed`),
  KEY `sfax_transmission_id` (`sfax_transmission_id`),
  KEY `sfax_status` (`sfax_status`),
  KEY `viewed` (`viewed`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `pid` int(11) NOT NULL,
  `referreddate` varchar(255) NOT NULL,
  `rx_imgid` int(11) DEFAULT NULL,
  `lomn_imgid` int(11) DEFAULT NULL,
  `notes_imgid` int(11) DEFAULT NULL,
  `rxlomn_imgid` int(11) DEFAULT NULL,
  `rxlomnrec` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  KEY `segmentid` (`segmentid`),
  KEY `appointment_type` (`appointment_type`),
  KEY `date_completed` (`date_completed`),
  KEY `stepid` (`stepid`),
  KEY `letterid` (`letterid`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id`),
  KEY `sort_by` (`sort_by`),
  KEY `section` (`section`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `child_id` (`child_id`),
  KEY `sort_by` (`sort_by`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `company_id` int(11) DEFAULT NULL,
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
  `provider_phone` varchar(255) NOT NULL DEFAULT '',
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
  `office_notes` text,
  `sleep_study_id` int(11) DEFAULT NULL,
  `authorized_id` int(11) DEFAULT NULL,
  `authorizeddate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `rejected_reason` text,
  `rejecteddate` datetime DEFAULT NULL,
  `canceled_id` int(11) NOT NULL DEFAULT '0',
  `canceled_date` datetime DEFAULT NULL,
  `hst_nights` int(11) DEFAULT '2',
  `hst_positions` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_id` (`doc_id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`),
  KEY `patient_id` (`patient_id`),
  KEY `screener_id` (`screener_id`),
  KEY `ins_co_id` (`ins_co_id`),
  KEY `patient_ins_id` (`patient_ins_id`),
  KEY `diagnosis_id` (`diagnosis_id`),
  KEY `viewed` (`viewed`),
  KEY `status` (`status`),
  KEY `sleep_study_id` (`sleep_study_id`),
  KEY `authorized_id` (`authorized_id`),
  KEY `canceled_id` (`canceled_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_hst_sleeplab`
--

DROP TABLE IF EXISTS `dental_hst_sleeplab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_hst_sleeplab` (
  `hst_id` int(11) NOT NULL DEFAULT '0',
  `sleep_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `hst_sleep` (`hst_id`,`sleep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `other_insurance_type` tinyint(2) DEFAULT NULL,
  `patient_relation_other_insured` varchar(255) DEFAULT NULL,
  `p_m_billing_id` int(11) DEFAULT NULL,
  `p_m_dss_file` tinyint(1) DEFAULT NULL,
  `s_m_billing_id` int(11) DEFAULT NULL,
  `s_m_dss_file` tinyint(1) DEFAULT NULL,
  `other_insured_address` varchar(100) DEFAULT NULL,
  `other_insured_city` varchar(100) DEFAULT NULL,
  `other_insured_state` varchar(100) DEFAULT NULL,
  `other_insured_zip` varchar(100) DEFAULT NULL,  
  `nucc_8a` varchar(255) DEFAULT NULL,
  `nucc_8b` varchar(255) DEFAULT NULL,
  `nucc_9a` varchar(255) DEFAULT NULL,
  `nucc_9b` varchar(255) DEFAULT NULL,            
  `nucc_30` varchar(255) DEFAULT NULL,
  `claim_codes` varchar(255) DEFAULT NULL,
  `other_claim_id` varchar(255) DEFAULT NULL,
  `icd_ind` tinyint(2) DEFAULT NULL,
  `name_referring_provider_qualifier` varchar(25) DEFAULT NULL,
  `diagnosis_a` varchar(25) DEFAULT NULL,
  `diagnosis_b` varchar(25) DEFAULT NULL,
  `diagnosis_c` varchar(25) DEFAULT NULL,
  `diagnosis_d` varchar(25) DEFAULT NULL,
  `diagnosis_e` varchar(25) DEFAULT NULL,
  `diagnosis_f` varchar(25) DEFAULT NULL,
  `diagnosis_g` varchar(25) DEFAULT NULL,
  `diagnosis_h` varchar(25) DEFAULT NULL,
  `diagnosis_i` varchar(25) DEFAULT NULL,
  `diagnosis_j` varchar(25) DEFAULT NULL,
  `diagnosis_k` varchar(25) DEFAULT NULL,
  `diagnosis_l` varchar(25) DEFAULT NULL,
  `current_qual` varchar(25) DEFAULT NULL,
  `same_illness_qual` varchar(25) DEFAULT NULL,
  `resubmission_code` varchar(50) DEFAULT NULL,
  `primary_claim_version` tinyint(1) DEFAULT '2',
  `secondary_claim_version` tinyint(1) DEFAULT '2',
  `eligible_token` varchar(255) DEFAULT NULL,
  `percase_date` datetime DEFAULT NULL,
  `percase_name` varchar(100) DEFAULT NULL,
  `percase_amount` decimal(11,2) DEFAULT NULL,
  `percase_status` tinyint(1) DEFAULT '0',
  `percase_invoice` int(11) DEFAULT NULL,
  `primary_claim_id` int(11) DEFAULT NULL,
  `fo_paid_viewed` tinyint(1) DEFAULT '0',
  `bo_paid_viewed` tinyint(1) DEFAULT '0',
  `closed_by_office_type` tinyint(1) DEFAULT NULL,
  `s_m_eligible_payer_id` varchar(20) DEFAULT NULL,
  `s_m_eligible_payer_name` varchar(200) DEFAULT NULL,
  `nucc_9c` varchar(255) DEFAULT NULL,
  `nucc_10d` varchar(255) DEFAULT NULL,
  `resubmission_code_fill` tinyint(2) DEFAULT NULL,
  `other_insured_id_number` varchar(255) DEFAULT NULL,
  `responsibility_sequence` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_1` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_1` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_1` varchar(255) DEFAULT NULL,
  `rendering_provider_org_1` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_1` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_2` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_2` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_2` varchar(255) DEFAULT NULL,
  `rendering_provider_org_2` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_2` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_3` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_3` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_3` varchar(255) DEFAULT NULL,
  `rendering_provider_org_3` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_3` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_4` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_4` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_4` varchar(255) DEFAULT NULL,
  `rendering_provider_org_4` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_4` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_5` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_5` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_5` varchar(255) DEFAULT NULL,
  `rendering_provider_org_5` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_5` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_6` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_6` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_6` varchar(255) DEFAULT NULL,
  `rendering_provider_org_6` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_6` varchar(255) DEFAULT NULL,
  `payer_id` varchar(100) DEFAULT NULL,
  `payer_name` varchar(100) DEFAULT NULL,
  `payer_address` varchar(100) DEFAULT NULL,
  `payer_city` varchar(100) DEFAULT NULL,
  `payer_state` varchar(100) DEFAULT NULL,
  `payer_zip` varchar(100) DEFAULT NULL,
  `billing_provider_taxonomy_code` varchar(100) DEFAULT NULL,
  `other_insured_insurance_type` varchar(100) DEFAULT NULL,
  `claim_info_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`insuranceid`),
  KEY `formid` (`formid`),
  KEY `patientid` (`patientid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `status` (`status`),
  KEY `producer` (`producer`),
  KEY `primary_claim_id` (`primary_claim_id`),
  KEY `amount_paid` (`amount_paid`),
  KEY `p_m_eligible_payer_id` (`p_m_eligible_payer_id`),
  KEY `s_m_eligible_payer_id` (`s_m_eligible_payer_id`),
  KEY `other_claim_id` (`other_claim_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_insurance_bo_status`
--

DROP TABLE IF EXISTS `dental_insurance_bo_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_insurance_bo_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insuranceid` int(11) NOT NULL DEFAULT '0',
  `p_m_dss_file` int(11) NOT NULL DEFAULT '0',
  `adminid` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(255) NOT NULL DEFAULT '',
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `insuranceid` (`insuranceid`),
  KEY `p_m_dss_file` (`p_m_dss_file`),
  KEY `adminid` (`adminid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_insurance_history`
--

DROP TABLE IF EXISTS `dental_insurance_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_insurance_history` (
  `insuranceid` int(11) NOT NULL DEFAULT '0',
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
  `other_insurance_type` tinyint(2) DEFAULT NULL,
  `patient_relation_other_insured` varchar(255) DEFAULT NULL,
  `p_m_billing_id` int(11) DEFAULT NULL,
  `p_m_dss_file` tinyint(1) DEFAULT NULL,
  `s_m_billing_id` int(11) DEFAULT NULL,
  `s_m_dss_file` tinyint(1) DEFAULT NULL,
  `other_insured_address` varchar(100) DEFAULT NULL,
  `other_insured_city` varchar(100) DEFAULT NULL,
  `other_insured_state` varchar(100) DEFAULT NULL,
  `other_insured_zip` varchar(100) DEFAULT NULL,
  `nucc_8a` varchar(255) DEFAULT NULL,
  `nucc_8b` varchar(255) DEFAULT NULL,
  `nucc_9a` varchar(255) DEFAULT NULL,
  `nucc_9b` varchar(255) DEFAULT NULL, 
  `nucc_30` varchar(255) DEFAULT NULL,
  `claim_codes` varchar(255) DEFAULT NULL,
  `other_claim_id` varchar(255) DEFAULT NULL,
  `icd_ind` tinyint(2) DEFAULT NULL,
  `name_referring_provider_qualifier` varchar(25) DEFAULT NULL,
  `diagnosis_a` varchar(25) DEFAULT NULL,
  `diagnosis_b` varchar(25) DEFAULT NULL,
  `diagnosis_c` varchar(25) DEFAULT NULL,
  `diagnosis_d` varchar(25) DEFAULT NULL,
  `diagnosis_e` varchar(25) DEFAULT NULL,
  `diagnosis_f` varchar(25) DEFAULT NULL,
  `diagnosis_g` varchar(25) DEFAULT NULL,
  `diagnosis_h` varchar(25) DEFAULT NULL,
  `diagnosis_i` varchar(25) DEFAULT NULL,
  `diagnosis_j` varchar(25) DEFAULT NULL,
  `diagnosis_k` varchar(25) DEFAULT NULL,
  `diagnosis_l` varchar(25) DEFAULT NULL,
  `current_qual` varchar(25) DEFAULT NULL,
  `same_illness_qual` varchar(25) DEFAULT NULL,
  `resubmission_code` varchar(50) DEFAULT NULL,
  `primary_claim_version` tinyint(1) DEFAULT '2',
  `secondary_claim_version` tinyint(1) DEFAULT '2',
  `eligible_token` varchar(255) DEFAULT NULL,
  `updated_by_user` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percase_date` datetime DEFAULT NULL,
  `percase_name` varchar(100) DEFAULT NULL,
  `percase_amount` decimal(11,2) DEFAULT NULL,
  `percase_status` tinyint(1) DEFAULT '0',
  `percase_invoice` int(11) DEFAULT NULL,
  `primary_claim_id` int(11) DEFAULT NULL,
  `nucc_9c` varchar(255) DEFAULT NULL,
  `nucc_10d` varchar(255) DEFAULT NULL,
  `resubmission_code_fill` tinyint(2) DEFAULT NULL,
  `other_insured_id_number` varchar(255) DEFAULT NULL,
  `responsibility_sequence` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_1` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_1` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_1` varchar(255) DEFAULT NULL,
  `rendering_provider_org_1` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_1` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_2` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_2` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_2` varchar(255) DEFAULT NULL,
  `rendering_provider_org_2` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_2` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_3` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_3` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_3` varchar(255) DEFAULT NULL,
  `rendering_provider_org_3` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_3` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_4` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_4` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_4` varchar(255) DEFAULT NULL,
  `rendering_provider_org_4` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_4` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_5` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_5` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_5` varchar(255) DEFAULT NULL,
  `rendering_provider_org_5` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_5` varchar(255) DEFAULT NULL,
  `rendering_provider_entity_6` varchar(255) DEFAULT NULL,
  `rendering_provider_first_name_6` varchar(255) DEFAULT NULL,
  `rendering_provider_last_name_6` varchar(255) DEFAULT NULL,
  `rendering_provider_org_6` varchar(255) DEFAULT NULL,
  `rendering_provider_npi_6` varchar(255) DEFAULT NULL,
  `payer_id` varchar(100) DEFAULT NULL,
  `payer_name` varchar(100) DEFAULT NULL,
  `payer_address` varchar(100) DEFAULT NULL,
  `payer_city` varchar(100) DEFAULT NULL,
  `payer_state` varchar(100) DEFAULT NULL,
  `payer_zip` varchar(100) DEFAULT NULL,
  `billing_provider_taxonomy_code` varchar(100) DEFAULT NULL,
  `other_insured_insurance_type` varchar(100) DEFAULT NULL,
  `claim_info_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `in_deductible_from` int(1) DEFAULT NULL,
  `in_patient_deductible` decimal(11,2) DEFAULT NULL,
  `in_patient_amount_met` decimal(11,2) DEFAULT NULL,
  `in_patient_amount_left_to_meet` decimal(11,2) DEFAULT NULL,
  `in_family_deductible` decimal(11,2) DEFAULT NULL,
  `in_family_amount_met` decimal(11,2) DEFAULT NULL,
  `in_family_amount_left_to_meet` decimal(11,2) DEFAULT NULL,
  `in_deductible_reset_date` varchar(255) DEFAULT NULL,
  `in_out_of_pocket_met` int(1) NOT NULL DEFAULT '0',
  `in_expected_insurance_payment` decimal(11,2) DEFAULT NULL,
  `in_expected_patient_payment` decimal(11,2) DEFAULT NULL,
  `in_call_reference_num` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `doc_name` varchar(200) DEFAULT NULL,
  `doc_practice` varchar(200) DEFAULT NULL,
  `doc_address` varchar(200) DEFAULT NULL,
  `doc_phone` varchar(200) DEFAULT NULL,
  `has_in_network_benefits` int(1) DEFAULT NULL,
  `in_is_pre_auth_required` int(1) DEFAULT NULL,
  `in_verbal_pre_auth_name` varchar(255) DEFAULT NULL,
  `in_verbal_pre_auth_ref_num` varchar(255) DEFAULT NULL,
  `in_verbal_pre_auth_notes` text,
  `in_written_pre_auth_date_received` varchar(255) DEFAULT NULL,
  `in_pre_auth_num` varchar(255) DEFAULT NULL,
  `in_written_pre_auth_notes` text,
  PRIMARY KEY (`id`),
  KEY `doc_id` (`doc_id`),
  KEY `patient_id` (`patient_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `updated_by` (`updated_by`),
  KEY `patient_ins_group_id` (`patient_ins_group_id`),
  KEY `patient_ins_id` (`patient_ins_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `adminid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_js_error_log`
--

DROP TABLE IF EXISTS `dental_js_error_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_js_error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `adminid` int(11) NOT NULL DEFAULT '0',
  `report` text NOT NULL,
  `ip_address` varchar(50) NOT NULL DEFAULT '',
  `referrer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `adminid` (`adminid`),
  KEY `referrer` (`referrer`(15))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `service_date` datetime DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL,
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
  `daysorunits` varchar(255) NOT NULL DEFAULT '1',
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
  `percase_status` tinyint(1) DEFAULT '0',
  `percase_invoice` int(11) DEFAULT NULL,
  `percase_free` tinyint(1) DEFAULT NULL,
  `secondary_claim_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ledgerid`),
  KEY `formid` (`formid`),
  KEY `patientid` (`patientid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `status` (`status`),
  KEY `producerid` (`producerid`),
  KEY `primary_claim_id` (`primary_claim_id`),
  KEY `percase_status` (`percase_status`),
  KEY `percase_invoice` (`percase_invoice`),
  KEY `percase_free` (`percase_free`),
  KEY `secondary_claim_id` (`secondary_claim_id`),
  KEY `primary_paper_claim_id` (`primary_paper_claim_id`),
  KEY `paid_amount` (`paid_amount`),
  KEY `amount` (`amount`),
  KEY `ledgerid` (`ledgerid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_ledger_history`
--

DROP TABLE IF EXISTS `dental_ledger_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ledger_history` (
  `ledgerid` int(11) NOT NULL DEFAULT '0',
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
  `percase_status` tinyint(1) DEFAULT '0',
  `percase_invoice` int(11) DEFAULT NULL,
  `percase_free` tinyint(1) DEFAULT NULL,
  `updated_by_user` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `primary_claim_history_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secondary_claim_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `history_ledgerid` (`ledgerid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `allowed` decimal(11,2) DEFAULT '0.00',
  `ins_paid` decimal(11,2) DEFAULT '0.00',
  `deductible` decimal(11,2) DEFAULT '0.00',
  `copay` decimal(11,2) DEFAULT '0.00',
  `coins` decimal(11,2) DEFAULT '0.00',
  `overpaid` decimal(11,2) DEFAULT '0.00',
  `followup` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `amount_allowed` decimal(11,2) DEFAULT NULL,
  `is_secondary` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ledgerid` (`ledgerid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_ledger_payment_history`
--

DROP TABLE IF EXISTS `dental_ledger_payment_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_ledger_payment_history` (
  `paymentid` int(11) NOT NULL DEFAULT '0',
  `payer` int(1) DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `payment_type` int(1) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `ledgerid` int(11) DEFAULT NULL,
  `allowed` decimal(11,2) DEFAULT '0.00',
  `ins_paid` decimal(11,2) DEFAULT '0.00',
  `deductible` decimal(11,2) DEFAULT '0.00',
  `copay` decimal(11,2) DEFAULT '0.00',
  `coins` decimal(11,2) DEFAULT '0.00',
  `overpaid` decimal(11,2) DEFAULT '0.00',
  `followup` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `amount_allowed` decimal(11,2) DEFAULT NULL,
  `updated_by_user` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_secondary` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id`),
  KEY `default_letter` (`default_letter`),
  KEY `companyid` (`companyid`),
  KEY `triggerid` (`triggerid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `send_method` varchar(32) DEFAULT NULL,
  `template` text,
  `pdf_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `delivered` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `templateid` int(11) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `topatient` tinyint(1) DEFAULT NULL,
  `md_list` varchar(255) DEFAULT NULL,
  `md_referral_list` varchar(255) DEFAULT NULL,
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
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`letterid`),
  KEY `patientid` (`patientid`),
  KEY `stepid` (`stepid`),
  KEY `templateid` (`templateid`),
  KEY `parentid` (`parentid`),
  KEY `docid` (`docid`),
  KEY `userid` (`userid`),
  KEY `info_id` (`info_id`),
  KEY `edit_userid` (`edit_userid`),
  KEY `deleted_by` (`deleted_by`),
  KEY `status` (`status`),
  KEY `delivered` (`delivered`),
  KEY `deleted` (`deleted`),
  KEY `trigger_letter1and2` (`md_list`,`templateid`),
  KEY `pending_letters` (`docid`,`patientid`,`status`,`delivered`,`mailed_date`,`deleted`,`letterid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- !!!!DEPRECATED!!!! CONSIDER REMOVAL NOT USED IN DEVELOPMENT DB
--
-- Table structure for table `dental_letters_old`
--

DROP TABLE IF EXISTS `dental_letters_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_letters_old` (
  `letterid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `stepid` int(11) DEFAULT NULL,
  `generated_date` datetime DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `send_method` varchar(32) DEFAULT NULL,
  `template` text,
  `pdf_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `delivered` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `templateid` int(11) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `topatient` tinyint(1) DEFAULT NULL,
  `md_list` varchar(255) DEFAULT NULL,
  `md_referral_list` varchar(255) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `info_id` int(11) DEFAULT NULL,
  `edit_userid` int(11) DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `mailed_date` datetime DEFAULT NULL,
  `mailed_once` tinyint(1) DEFAULT '0',
  `template_type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`letterid`),
  KEY `patientid` (`patientid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_locations`
--

DROP TABLE IF EXISTS `dental_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `default_location` tinyint(1) DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`notesid`),
  KEY `patientid` (`patientid`),
  KEY `parentid` (`parentid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `signed_id` (`signed_id`),
  KEY `edited` (`edited`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `patient_info` int(1) DEFAULT NULL,
  `tracker_notes` varchar(255) NOT NULL DEFAULT '',
  KEY `pid` (`pid`),
  KEY `fspage1_complete` (`fspage1_complete`),
  KEY `patient_info` (`patient_info`),
  KEY `appliance` (`appliance`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `alert_text` text,
  `display_alert` int(1) DEFAULT NULL,
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
  `access_code` varchar(100) DEFAULT NULL,
  `parent_patientid` int(11) DEFAULT NULL,
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
  `symptoms_status` tinyint(1) DEFAULT '0',
  `sleep_status` tinyint(1) DEFAULT '0',
  `treatments_status` tinyint(1) DEFAULT '0',
  `history_status` tinyint(1) DEFAULT '0',
  `access_code_date` datetime DEFAULT NULL,
  `email_bounce` tinyint(1) NOT NULL DEFAULT '0',
  `docmdother2` varchar(255) NOT NULL,
  `docmdother3` varchar(255) NOT NULL,
  `last_reg_sect` int(3) NOT NULL DEFAULT '0',
  `access_type` int(1) DEFAULT '1',
  `p_m_eligible_id` varchar(20) DEFAULT NULL,
  `p_m_eligible_payer_id` varchar(20) DEFAULT NULL,
  `p_m_eligible_payer_name` varchar(200) DEFAULT NULL,
  `p_m_gender` varchar(20) DEFAULT NULL,
  `s_m_gender` varchar(20) DEFAULT NULL,
  `p_m_same_address` tinyint(1) DEFAULT '1',
  `p_m_address` varchar(100) DEFAULT NULL,
  `p_m_state` varchar(100) DEFAULT NULL,
  `p_m_city` varchar(100) DEFAULT NULL,
  `p_m_zip` varchar(20) DEFAULT NULL,
  `s_m_same_address` tinyint(1) DEFAULT '1',
  `s_m_address` varchar(100) DEFAULT NULL,
  `s_m_city` varchar(100) DEFAULT NULL,
  `s_m_state` varchar(100) DEFAULT NULL,
  `s_m_zip` varchar(20) DEFAULT NULL,
  `new_fee_date` date DEFAULT NULL,
  `new_fee_amount` decimal(11,2) DEFAULT NULL,
  `new_fee_desc` varchar(255) DEFAULT NULL,
  `new_fee_invoice_id` int(11) DEFAULT NULL,
  `s_m_eligible_payer_id` varchar(20) DEFAULT NULL,
  `s_m_eligible_payer_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`patientid`),
  KEY `patientid` (`patientid`),
  KEY `parent_patientid` (`parent_patientid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `new_fee_invoice_id` (`new_fee_invoice_id`),
  KEY `status` (`status`),
  KEY `access_type` (`access_type`),
  KEY `p_d_ins_id` (`p_d_ins_id`),
  KEY `s_d_ins_id` (`s_d_ins_id`),
  KEY `p_m_ins_id` (`p_m_ins_id`),
  KEY `s_m_ins_id` (`s_m_ins_id`),
  KEY `p_m_eligible_id` (`p_m_eligible_id`),
  KEY `p_m_eligible_payer_id` (`p_m_eligible_payer_id`),
  KEY `s_m_eligible_payer_id` (`s_m_eligible_payer_id`),
  KEY `docpcp` (`docpcp`),
  KEY `docent` (`docent`),
  KEY `docsleep` (`docsleep`),
  KEY `docdentist` (`docdentist`),
  KEY `docmdother` (`docmdother`),
  KEY `docmdother2` (`docmdother2`),
  KEY `docmdother3` (`docmdother3`),
  KEY `premedcheck` (`premedcheck`),
  KEY `registered` (`registered`),
  KEY `registration_status` (`registration_status`),
  KEY `text_num` (`text_num`),
  KEY `use_patient_portal` (`use_patient_portal`),
  KEY `symptoms_status` (`symptoms_status`),
  KEY `sleep_status` (`sleep_status`),
  KEY `treatments_status` (`treatments_status`),
  KEY `history_status` (`history_status`),
  KEY `email_bounce` (`email_bounce`),
  KEY `last_reg_sect` (`last_reg_sect`),
  KEY `p_m_same_address` (`p_m_same_address`),
  KEY `s_m_same_address` (`s_m_same_address`),
  KEY `basic_details` (`patientid`,`firstname`,`lastname`),
  KEY `lastname` (`lastname`),
  KEY `firstname` (`firstname`),
  KEY `p_m_ins_type` (`p_m_ins_type`),
  KEY `referred_by` (`referred_by`),
  KEY `referred_source` (`referred_source`),
  KEY `copyreqdate` (`copyreqdate`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_payment_reports`
--

DROP TABLE IF EXISTS `dental_payment_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_payment_reports` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `claimid` int(11) DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL,
  `response` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`payment_id`),
  KEY `viewed` (`viewed`),
  KEY `claimid` (`claimid`),
  KEY `reference_id` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_pcont`
--

DROP TABLE IF EXISTS `dental_pcont`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_pcont` (
  `patient_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `companyid` int(11) DEFAULT NULL,
  `user_fee_date` date DEFAULT NULL,
  `user_fee_amount` decimal(11,2) DEFAULT NULL,
  `producer_fee_date` date DEFAULT NULL,
  `producer_fee_amount` decimal(11,2) DEFAULT NULL,
  `user_fee_desc` varchar(255) DEFAULT NULL,
  `producer_fee_desc` varchar(255) DEFAULT NULL,
  `invoice_type` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `adminid` (`adminid`),
  KEY `docid` (`docid`),
  KEY `status` (`status`),
  KEY `companyid` (`companyid`),
  KEY `invoice_type` (`invoice_type`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `eligibility_fee` decimal(11,2) DEFAULT '0.00',
  `free_eligibility` int(11) DEFAULT '0',
  `enrollment_fee` decimal(11,2) DEFAULT '0.00',
  `free_enrollment` int(11) DEFAULT '0',
  `claim_fee` decimal(11,2) DEFAULT '0.00',
  `free_claim` int(11) DEFAULT '0',
  `vob_fee` decimal(11,2) DEFAULT '0.00',
  `free_vob` int(11) DEFAULT '0',
  `office_type` tinyint(1) DEFAULT '1',
  `efile_fee` decimal(11,2) DEFAULT '0.00',
  `free_efile` int(11) DEFAULT '0',
  `duration` int(11) DEFAULT '0',
  `producer_fee` decimal(11,2) DEFAULT '0.00',
  `user_fee` decimal(11,2) DEFAULT '0.00',
  `patient_fee` decimal(11,2) DEFAULT '0.00',
  `e0486_bill` tinyint(1) DEFAULT '1',
  `e0486_fee` decimal(11,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `trial_period` (`trial_period`),
  KEY `free_fax` (`free_fax`),
  KEY `status` (`status`),
  KEY `free_eligibility` (`free_eligibility`),
  KEY `free_enrollment` (`free_enrollment`),
  KEY `free_claim` (`free_claim`),
  KEY `free_vob` (`free_vob`),
  KEY `office_type` (`office_type`),
  KEY `free_efile` (`free_efile`),
  KEY `duration` (`duration`),
  KEY `e0486_bill` (`e0486_bill`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `adminid` int(11) DEFAULT NULL,
  PRIMARY KEY (`imageid`),
  KEY `formid` (`formid`),
  KEY `patientid` (`patientid`),
  KEY `imagetypeid` (`imagetypeid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `status` (`status`),
  KEY `adminid` (`adminid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `additional_paragraph` text,
  `allergenscheck` tinyint(1) DEFAULT '0',
  `medicationscheck` tinyint(1) DEFAULT '0',
  `historycheck` tinyint(1) DEFAULT '0',
  `parent_patientid` int(11) DEFAULT NULL,
  PRIMARY KEY (`q_page3id`),
  KEY `patientid` (`patientid`),
  KEY `formid` (`formid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `status` (`status`),
  KEY `parent_patientid` (`parent_patientid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_refund`
--

DROP TABLE IF EXISTS `dental_refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(11,2) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `adminid` int(11) DEFAULT NULL,
  `refund_date` datetime DEFAULT NULL,
  `charge_id` int(11) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_request_data_log`
--

DROP TABLE IF EXISTS `dental_request_data_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_request_data_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `adminid` int(11) NOT NULL DEFAULT '0',
  `script` text NOT NULL,
  `referer` text NOT NULL,
  `request_time` double NOT NULL DEFAULT '0',
  `get_data` text NOT NULL,
  `post_data` text NOT NULL,
  `files_data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `patientid` (`patientid`),
  KEY `userid` (`userid`),
  KEY `adminid` (`adminid`),
  KEY `script` (`script`(20)),
  KEY `referer` (`referer`(20))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- !!! IS THIS STILL NEEDED?  !!!
--
-- Table structure for table `dental_request_data_log_swap`
--

DROP TABLE IF EXISTS `dental_request_data_log_swap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_request_data_log_swap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `adminid` int(11) NOT NULL DEFAULT '0',
  `script` text NOT NULL,
  `referer` text NOT NULL,
  `request_time` double NOT NULL DEFAULT '0',
  `get_data` text NOT NULL,
  `post_data` text NOT NULL,
  `files_data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `patientid` (`patientid`),
  KEY `userid` (`userid`),
  KEY `adminid` (`adminid`),
  KEY `script` (`script`(20)),
  KEY `referer` (`referer`(20))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_request_data_type`
--

DROP TABLE IF EXISTS `dental_request_data_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_request_data_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `item_table` varchar(64) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `item_table` (`item_table`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `patient_id` int(11) DEFAULT NULL,
  `rx_metabolic_syndrome` tinyint(1) DEFAULT '0',
  `rx_obesity` tinyint(1) DEFAULT '0',
  `rx_afib` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `patients_screener` (`userid`,`adddate`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_sms_log`
--

DROP TABLE IF EXISTS `dental_sms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT '',
  `sid` varchar(50) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `sid` (`sid`(20))
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patiendid` (`patiendid`),
  KEY `diagnosising_doc` (`diagnosising_doc`),
  KEY `diagnosising_npi` (`diagnosising_npi`),
  KEY `diagnosis` (`diagnosis`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`summaryid`),
  KEY `formid` (`formid`),
  KEY `patientid` (`patientid`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_support_responses`
--

DROP TABLE IF EXISTS `dental_support_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_support_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `responder_id` int(11) DEFAULT NULL,
  `body` text,
  `response_type` tinyint(1) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT '0',
  `attachment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `responder_id` (`responder_id`),
  KEY `response_type` (`response_type`),
  KEY `viewed` (`viewed`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `company_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `docid` (`docid`),
  KEY `category_id` (`category_id`),
  KEY `status` (`status`),
  KEY `viewed` (`viewed`),
  KEY `creator_id` (`creator_id`),
  KEY `create_type` (`create_type`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `responsibleid` (`responsibleid`),
  KEY `status` (`status`),
  KEY `patientid` (`patientid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `days_units` varchar(255) NOT NULL DEFAULT '1',
  `amount_adjust` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`transaction_codeid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `companyid` (`companyid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_user_signatures`
--

DROP TABLE IF EXISTS `dental_user_signatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_user_signatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `signature_json` text,
  `adddate` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `use_patient_portal` tinyint(1) DEFAULT '0',
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
  `manage_staff` tinyint(1) NOT NULL DEFAULT '0',
  `cc_id` varchar(150) DEFAULT NULL,
  `user_type` tinyint(1) DEFAULT '1',
  `letter_margin_header` int(3) DEFAULT '48',
  `letter_margin_footer` int(3) DEFAULT '26',
  `letter_margin_top` int(3) DEFAULT '14',
  `letter_margin_bottom` int(3) DEFAULT '40',
  `letter_margin_left` int(3) DEFAULT '18',
  `letter_margin_right` int(3) DEFAULT '18',
  `claim_margin_top` int(3) DEFAULT '0',
  `claim_margin_left` int(3) DEFAULT '0',
  `homepage` tinyint(1) DEFAULT '0',
  `logo` varchar(100) DEFAULT NULL,
  `use_letter_header` tinyint(1) DEFAULT '1',
  `access_code_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `indent_address` tinyint(1) DEFAULT '1',
  `registration_date` datetime DEFAULT NULL,
  `header_space` tinyint(1) DEFAULT NULL,
  `billing_company_id` int(11) DEFAULT NULL,
  `tracker_letters` tinyint(1) DEFAULT '1',
  `intro_letters` tinyint(1) DEFAULT '1',
  `plan_id` int(11) DEFAULT NULL,
  `suspended_reason` text,
  `suspended_date` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `signature_file` varchar(100) DEFAULT NULL,
  `signature_json` text,
  `edx_id` int(11) DEFAULT NULL,
  `help_id` int(11) DEFAULT NULL,
  `use_service_npi` tinyint(1) DEFAULT '0',
  `service_name` varchar(100) DEFAULT NULL,
  `service_address` varchar(100) DEFAULT NULL,
  `service_city` varchar(100) DEFAULT NULL,
  `service_state` varchar(100) DEFAULT NULL,
  `service_zip` varchar(100) DEFAULT NULL,
  `service_phone` varchar(100) DEFAULT NULL,
  `service_fax` varchar(100) DEFAULT NULL,
  `service_npi` varchar(100) DEFAULT NULL,
  `service_medicare_npi` varchar(100) DEFAULT NULL,
  `service_medicare_ptan` varchar(100) DEFAULT NULL,
  `service_tax_id_or_ssn` varchar(100) DEFAULT NULL,
  `service_ssn` tinyint(1) DEFAULT NULL,
  `service_ein` tinyint(1) DEFAULT NULL,
  `eligible_test` tinyint(1) DEFAULT '0',
  `billing_plan_id` int(11) DEFAULT NULL,
  `post_ledger_adjustments` tinyint(1) DEFAULT '0',
  `edit_ledger_entries` tinyint(1) DEFAULT '0',
  `use_payment_reports` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `docid` (`docid`),
  KEY `access_code_id` (`access_code_id`),
  KEY `billing_company_id` (`billing_company_id`),
  KEY `edx_id` (`edx_id`),
  KEY `help_id` (`help_id`),
  KEY `plan_id` (`plan_id`),
  KEY `billing_plan_id` (`billing_plan_id`),
  KEY `status` (`status`),
  KEY `producer` (`producer`),
  KEY `cc_id` (`cc_id`),
  KEY `user_access` (`user_access`),
  KEY `ssn` (`ssn`),
  KEY `ein` (`ein`),
  KEY `use_patient_portal` (`use_patient_portal`),
  KEY `use_digital_fax` (`use_digital_fax`),
  KEY `use_letters` (`use_letters`),
  KEY `sign_notes` (`sign_notes`),
  KEY `use_eligible_api` (`use_eligible_api`),
  KEY `text_num` (`text_num`),
  KEY `producer_files` (`producer_files`),
  KEY `use_course` (`use_course`),
  KEY `use_course_staff` (`use_course_staff`),
  KEY `manage_staff` (`manage_staff`),
  KEY `user_type` (`user_type`),
  KEY `letter_margin_header` (`letter_margin_header`),
  KEY `letter_margin_footer` (`letter_margin_footer`),
  KEY `letter_margin_top` (`letter_margin_top`),
  KEY `letter_margin_bottom` (`letter_margin_bottom`),
  KEY `letter_margin_left` (`letter_margin_left`),
  KEY `letter_margin_right` (`letter_margin_right`),
  KEY `claim_margin_top` (`claim_margin_top`),
  KEY `claim_margin_left` (`claim_margin_left`),
  KEY `homepage` (`homepage`),
  KEY `use_letter_header` (`use_letter_header`),
  KEY `indent_address` (`indent_address`),
  KEY `header_space` (`header_space`),
  KEY `tracker_letters` (`tracker_letters`),
  KEY `intro_letters` (`intro_letters`),
  KEY `use_service_npi` (`use_service_npi`),
  KEY `service_ssn` (`service_ssn`),
  KEY `service_ein` (`service_ein`),
  KEY `eligible_test` (`eligible_test`),
  KEY `post_ledger_adjustments` (`post_ledger_adjustments`),
  KEY `edit_ledger_entries` (`edit_ledger_entries`),
  KEY `use_payment_reports` (`use_payment_reports`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dental_webhook_policy_log`
--

DROP TABLE IF EXISTS `dental_webhook_policy_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dental_webhook_policy_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claimid` int(11) NOT NULL DEFAULT '0',
  `reference_id` varchar(50) NOT NULL DEFAULT '',
  `current_status` varchar(50) NOT NULL,
  `rejected_status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `claimid` (`claimid`),
  KEY `reference_id` (`reference_id`),
  KEY `current_status` (`current_status`),
  KEY `rejected_status` (`rejected_status`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


-- NEW FROM DEV
--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `pageid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(1000) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `top_image` varchar(2048) DEFAULT NULL,
  `adddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pageid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

/* REVIEW!!! NOT USED IN DEV */
--
-- Temporary view structure for view `v_users`
--

DROP TABLE IF EXISTS `v_users`;
/*!50001 DROP VIEW IF EXISTS `v_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_users` AS SELECT 
 1 AS `id`,
 1 AS `email`,
 1 AS `name`,
 1 AS `first_name`,
 1 AS `last_name`,
 1 AS `username`,
 1 AS `password`,
 1 AS `salt`,
 1 AS `status`,
 1 AS `ip_address`,
 1 AS `access`,
 1 AS `adddate`*/;
SET character_set_client = @saved_cs_client;

/* REVIEW!!! NOT USED IN DEV */
--
-- Final view structure for view `v_users`
--

/*!50001 DROP VIEW IF EXISTS `v_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dssproduser`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_users` AS select (concat('u_',`dental_users`.`userid`) collate utf8_unicode_ci) AS `id`,`dental_users`.`email` AS `email`,if(isnull(`dental_users`.`name`),concat(`dental_users`.`first_name`,' ',`dental_users`.`last_name`),`dental_users`.`name`) AS `name`,`dental_users`.`first_name` AS `first_name`,`dental_users`.`last_name` AS `last_name`,`dental_users`.`username` AS `username`,`dental_users`.`password` AS `password`,`dental_users`.`salt` AS `salt`,`dental_users`.`status` AS `status`,`dental_users`.`ip_address` AS `ip_address`,`dental_users`.`user_access` AS `access`,`dental_users`.`adddate` AS `adddate` from `dental_users` union select (concat('a_',`admin`.`adminid`) collate utf8_unicode_ci) AS `id`,`admin`.`email` AS `email`,if(isnull(`admin`.`name`),concat(`admin`.`first_name`,' ',`admin`.`last_name`),`admin`.`name`) AS `name`,`admin`.`first_name` AS `first_name`,`admin`.`last_name` AS `last_name`,`admin`.`username` AS `username`,`admin`.`password` AS `password`,`admin`.`salt` AS `salt`,`admin`.`status` AS `status`,`admin`.`ip_address` AS `ip_address`,`admin`.`admin_access` AS `access`,`admin`.`adddate` AS `adddate` from `admin` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-18 21:02:33
