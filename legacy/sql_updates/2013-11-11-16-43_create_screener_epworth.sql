CREATE TABLE `dental_screener_epworth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `screener_id` int(11),
  `epworth_id` int(11),
  `response` tinyint(1),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

