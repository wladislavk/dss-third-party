CREATE TABLE `dental_claim_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claim_id` int(11),
  `create_type` int(1),
  `creator_id` int(11),
  `note` text,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE `dental_claim_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100),
  `description` text,
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);


CREATE TABLE `dental_claim_note_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11),
  `filename` varchar(100),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);


