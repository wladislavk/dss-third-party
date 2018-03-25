CREATE TABLE `dental_eligible_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claimid` varchar(255),
  `claim_electronic_id` int(11),
  `response` text,
  `event_type` varchar(50),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

