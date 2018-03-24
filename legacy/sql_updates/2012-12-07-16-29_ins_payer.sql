CREATE TABLE `dental_ins_payer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `payer_id` varchar(50),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
 

#load data local infile 'ins_payer.csv' into table dental_ins_payer fields terminated by ',' enclosed by '"' lines terminated by '\n' (name, payer_id)
