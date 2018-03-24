CREATE TABLE `dental_claim_electronic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claimid` int(11),
  `response` text,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;


