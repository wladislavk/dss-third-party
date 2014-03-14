CREATE TABLE `dental_user_signatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11),
  `signature_json` text,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);
 
