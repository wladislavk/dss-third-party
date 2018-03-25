CREATE TABLE `dental_eligible_enrollment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11),
  `payer_id` varchar(20),
  `reference_id` int(11),
  `response` text,
  `status` tinyint(1),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

