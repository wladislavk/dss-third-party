CREATE TABLE `dental_hst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11),
  `user_id` int(11),
  `company_id` int(11),
  `patient_id` int(11),
  `screener_id` int(11),
  `ins_co_id` int(11),
  `ins_phone` varchar(30),
  `patient_ins_group_id` varchar(255),
  `patient_ins_id` varchar(255),
  `patient_firstname` varchar(255),
  `patient_lastname` varchar(255),
  `patient_add1` varchar(255),
  `patient_add2` varchar(255),
  `patient_city` varchar(255),
  `patient_state` varchar(255),
  `patient_zip` varchar(255),
  `patient_dob` date,
  `patient_cell_phone` varchar(30),
  `patient_home_phone` varchar(30),
  `patient_email` varchar(100),
  `diagnosis_id` int(11),
  `hst_type` int(11),
  `provider_firstname` varchar(255),
  `provider_lastname` varchar(255),
  `provider_address` varchar(255),
  `provider_city` varchar(255),
  `provider_state` varchar(255),
  `provider_zip` varchar(255),
  `provider_signature` varchar(100),
  `provider_date` date,
  `snore_1` tinyint(1),
  `snore_2` tinyint(1),
  `snore_3` tinyint(1),
  `snore_4` tinyint(1),
  `snore_5` tinyint(1),
  `viewed` tinyint(1) default 0,
  `status` int(1),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);


CREATE TABLE `dental_hst_epworth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hst_id` int(11),
  `epworth_id` int(11),
  `response` tinyint(1),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);


CREATE TABLE `dental_user_hst_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11),
  `companyid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);






