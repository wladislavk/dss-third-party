CREATE TABLE `dental_user_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11),
  `adminid` int(11),
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
