CREATE TABLE `dental_ledger_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payer` enum('Primary Insurance', 'Secondary Insurance', 'Patient'),
  `amount` decimal(11,2),
  `payment_type` varchar(50),
  `payment_date` date,
  `entry_date` date,
  `ledgerid` int(11),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
 
