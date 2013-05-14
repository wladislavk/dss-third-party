CREATE TABLE `dental_ledger_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producerid` int(11),
  `filename` varchar(100),
  `service_date` date,
  `entry_date` date,
  `patientid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1; 
