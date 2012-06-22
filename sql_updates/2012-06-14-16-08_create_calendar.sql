CREATE TABLE `dental_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime,
  `end_date` datetime,
  `description` text,
  `event_id` bigint(8) unsigned,
  `docid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
