CREATE TABLE `dental_percase_invoice_extra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percase_date` date,
  `percase_name` varchar(100),
  `percase_amount` decimal(11,2),
  `percase_status` tinyint(1) default 0,
  `percase_invoice` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
