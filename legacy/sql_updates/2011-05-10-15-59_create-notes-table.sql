CREATE TABLE `dental_ledger_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producerid` int(11),
  `note` text,
  `private` int(1),
  `service_date` date,
  `entry_date` date,
  `patientid` int(11),
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1; 
