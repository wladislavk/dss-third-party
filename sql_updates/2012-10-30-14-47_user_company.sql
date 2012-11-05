CREATE TABLE `dental_user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11),
  `companyid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

CREATE TABLE `admin_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11),
  `companyid` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `add1` varchar(100),
  `add2` varchar(100),
  `city` varchar(100),
  `state` varchar(100),
  `zip` varchar(15),
  `status` tinyint(1) not null default 0,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;
