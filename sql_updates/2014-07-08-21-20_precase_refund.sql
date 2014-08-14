CREATE TABLE `dental_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(11,2),
  `userid` int(11),
  `adminid` int(11),
  `refund_date` datetime,
  `charge_id` int(11),
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
); 
