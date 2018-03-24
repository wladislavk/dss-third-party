CREATE TABLE `dental_insurance_status_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insuranceid` int(11),
  `status` int(2),
  `userid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

