CREATE TABLE `dental_flowsheet_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `sort_by` int(11),
  `section` int(11),
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;


CREATE TABLE `dental_flowsheet_steps_next` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11),
  `child_id` int(11),
  `sort_by` int(11),
  `adddate` datetime,
  `ip_address` varchar(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;


INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (1, 'Initial Contact', 1, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (15, 'Baseline Sleep Test', 2, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (2, 'Consult', 3, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (4, 'Impressions', 4, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (7, 'Device Delivery', 5, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (8, 'Check/Follow Up', 6, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (10, 'Home Sleep Test', 7, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (3, 'Sleep Study', 8, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (11, 'Treatment Complete', 9, 1, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (12, 'Annual Recall', 1, 2, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (14, 'Not a Candidate', 1, 3, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (5, 'Delaying Tx/Waiting', 2, 3, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (9, 'Pt. Non-compliant', 3, 3, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (6, 'Refused Treatment', 4, 3, NOW());
INSERT into dental_flowsheet_steps (id, name, sort_by, section, adddate) values (13, 'Termination', 5, 3, NOW());

