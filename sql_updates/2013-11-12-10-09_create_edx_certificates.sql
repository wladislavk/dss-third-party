CREATE TABLE `edx_certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200),
  `edx_id` int(11),
  `course_name` varchar(200),
  `course_section` varchar(200),
  `course_subsection` varchar(200),
  `number_ce` int(4),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

