CREATE TABLE `dental_hst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11),
  `user_id` int(11),
  `patient_id` int(11),
  `ins_co_id` int(11),
  `patient_ins_group_id` varchar(255),
  `patient_ins_id` varchar(255),
  `patient_firstname` varchar(255),
  `patient_lastname` varchar(255),
  `patient_add1` varchar(255),
  `patient_add2` varchar(255),
  `patient_city` varchar(255),
  `patient_state` varchar(255),
  `patient_zip` varchar(255),
  `patient_dob` varchar(255),
  `insured_firstname` varchar(255),
  `insured_lastname` varchar(255),
  `insured_dob` varchar(255),
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








