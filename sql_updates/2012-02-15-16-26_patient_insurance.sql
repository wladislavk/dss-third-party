CREATE TABLE `dental_patient_insurance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11),
  `insurancetype` int(1),
  `company` varchar(100),
  `address1` varchar(100),
  `address2` varchar(100),
  `city` varchar(100),
  `state` varchar(15),
  `zip` varchar(15),
  `phone` varchar(20),
  `fax` varchar(20),
  `email` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

