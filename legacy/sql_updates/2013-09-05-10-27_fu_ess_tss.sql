CREATE TABLE `dentalsummfu_ess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `followupid` int(11),
  `epworthid` int(11),
  `answer` tinyint(2),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE `dentalsummfu_tss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `followupid` int(11),
  `thorntonid` int(11),
  `answer` tinyint(2),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);
