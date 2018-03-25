CREATE TABLE `dental_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100),
  `docid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

ALTER TABLE dental_summary ADD COLUMN location int(11);
