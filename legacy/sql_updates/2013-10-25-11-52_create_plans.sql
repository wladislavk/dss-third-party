CREATE TABLE `dental_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50),
  `monthly_fee` decimal(11,2),
  `trial_period` int(4),
  `fax_fee` decimal(11,2),
  `free_fax` int(4),
  `status` tinyint(1) default 1,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);


ALTER TABLE dental_users ADD COLUMN plan_id int(11);
ALTER TABLE dental_access_codes ADD COLUMN plan_id int(11);
