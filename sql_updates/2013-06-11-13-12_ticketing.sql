CREATE TABLE `dental_support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255),
  `userid` int(11),
  `docid` int(11),
  `body` text,
  `category_id` int(11),
  `adddate` datetime,
  `status` tinyint(1) default 0,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);
ALTER TABLE dental_support_tickets ADD COLUMN attachment varchar(255);

CREATE TABLE `dental_support_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255),
  `status` tinyint(1) default 0,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE `dental_support_category_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11),
  `category_id` int(11),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE `dental_support_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11),
  `responder_id` int(11),
  `body` text,
  `response_type` tinyint(1),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);       
