CREATE TABLE `dental_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(11,2),
  `userid` int(11),
  `adminid` int(11),
  `charge_date` datetime,
  `stripe_customer` varchar(255),
  `stripe_charge` varchar(255),
  `stripe_card_fingerprint` varchar(255),
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
