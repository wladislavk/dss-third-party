CREATE TABLE `dental_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11),
  `docid` int(11),
  `notification` varchar(255),
  `notification_type` varchar(100),
  `status` int(1),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


