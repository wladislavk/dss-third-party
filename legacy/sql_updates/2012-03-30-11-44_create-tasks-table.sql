CREATE TABLE `dental_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255),
  `description` text,
  `docid` int(11),
  `responsibleid` int(11),
  `status` int(1),
  `due_date` datetime,
  `recurring` int(11),
  `recurring_unit` tinyint(1),
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
