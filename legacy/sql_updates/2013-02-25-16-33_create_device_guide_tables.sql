CREATE TABLE `dental_device_guide_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `adddate` datetime,
  `ip_address` varchar(25),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

CREATE TABLE `dental_device_guide_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `setting_type` tinyint(1),
  `range_start` int(2),
  `range_start_label` varchar(100),
  `range_end` int(2),
  `range_end_label` varchar(100),
  `options` int(2),
  `rank` int(2),
  `adddate` datetime,
  `ip_address` varchar(25),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

CREATE TABLE `dental_device_guide_device_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11),
  `setting_id` int(11),
  `value` int(11),
  `adddate` datetime,
  `ip_address` varchar(25),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

CREATE TABLE `dental_device_guide_setting_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(2),
  `setting_id` int(11),
  `label` varchar(100),
  `adddate` datetime,
  `ip_address` varchar(25),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

