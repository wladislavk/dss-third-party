CREATE TABLE `dental_patient_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contacttype` int(2),
  `patientid` int(11),
  `firstname` varchar(100),
  `lastname` varchar(100),
  `address1` varchar(100),
  `address2` varchar(100),
  `city` varchar(100),
  `state` varchar(15),
  `zip` varchar(15),
  `phone` varchar(20),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1; 
