CREATE TABLE `dental_faxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11),
  `userid` int(11),
  `docid` int(11),
  `sent_date` datetime,
  `pages` int(2),
  `contactid` int(11),
  `to_number` varchar(15),
  `to_name` varchar(50),
  `letterid` int(11),
  `filename` varchar(100),
  `status` tinyint(1),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;


