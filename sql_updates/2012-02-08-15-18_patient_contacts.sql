CREATE TABLE `dental_patient_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_amount_left_to_meet` decimal(11,2) DEFAULT NULL,
  `expected_insurance_payment` decimal(11,2) DEFAULT NULL,
  `expected_patient_payment` decimal(11,2) DEFAULT NULL,
  `network_benefits` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1; 
