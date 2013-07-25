CREATE TABLE `dental_access_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_code` varchar(50),
  `notes` text,
  `status` tinyint(1) default 1,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

ALTER TABLE dental_users ADD COLUMN access_code_id int(11);
