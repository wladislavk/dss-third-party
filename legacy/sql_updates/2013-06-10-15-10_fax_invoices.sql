CREATE TABLE `dental_fax_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11),
  `description` varchar(255),
  `start_date` date,
  `end_date` date,
  `amount` decimal(11,2),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

ALTER TABLE dental_faxes ADD COLUMN fax_invoice_id int(11);

