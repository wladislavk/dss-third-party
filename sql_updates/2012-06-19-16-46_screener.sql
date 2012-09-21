CREATE TABLE `dental_screener` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11),
  `userid` int(11),
  `first_name` varchar(50),
  `last_name` varchar(50),
  `email` varchar(70),
  `epworth_reading` tinyint(1) default 0,
  `epworth_public` tinyint(1) default 0,
  `epworth_passenger` tinyint(1) default 0,
  `epworth_lying` tinyint(1) default 0,
  `epworth_talking` tinyint(1) default 0,
  `epworth_lunch` tinyint(1) default 0,
  `epworth_traffic` tinyint(1) default 0,
  `snore_1` tinyint(1) default 0,
  `snore_2` tinyint(1) default 0,
  `snore_3` tinyint(1) default 0,
  `snore_4` tinyint(1) default 0,
  `snore_5` tinyint(1) default 0,
  `breathing` tinyint(1) default 0,
  `driving` tinyint(1) default 0,
  `gasping` tinyint(1) default 0,
  `sleepy` tinyint(1) default 0,
  `snore` tinyint(1) default 0,
  `weight_gain` tinyint(1) default 0,
  `blood_pressure` tinyint(1) default 0,
  `jerk` tinyint(1) default 0,
  `burning` tinyint(1) default 0,
  `headaches` tinyint(1) default 0,
  `falling_asleep` tinyint(1) default 0,
  `staying_asleep` tinyint(1) default 0,
  `rx_blood_pressure` tinyint(1) default 0,
  `rx_hypertension` tinyint(1) default 0,
  `rx_heart_disease` tinyint(1) default 0,
  `rx_stroke` tinyint(1) default 0,
  `rx_apnea` tinyint(1) default 0,
  `rx_diabetes` tinyint(1) default 0,
  `rx_lung_disease` tinyint(1) default 0,
  `rx_insomnia` tinyint(1) default 0,
  `rx_depression` tinyint(1) default 0,
  `rx_narcolepsy` tinyint(1) default 0,
  `rx_medication` tinyint(1) default 0,
  `rx_restless_leg` tinyint(1) default 0,
  `rx_headaches` tinyint(1) default 0,
  `rx_heartburn` tinyint(1) default 0,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
