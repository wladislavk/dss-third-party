CREATE TABLE `dental_support_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11),
  `response_id` int(11),
  `filename` varchar(100),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

