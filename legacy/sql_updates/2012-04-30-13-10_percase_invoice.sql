CREATE TABLE `dental_percase_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11),
  `docid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

ALTER TABLE dental_ledger ADD COLUMN percase_date datetime;
ALTER TABLE dental_ledger ADD COLUMN percase_name varchar(100);
ALTER TABLE dental_ledger ADD COLUMN percase_amount decimal(11,2);
ALTER TABLE dental_ledger ADD COLUMN percase_status tinyint(1) default 0;
ALTER TABLE dental_ledger ADD COLUMN percase_invoice int(11);
