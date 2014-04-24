ALTER TABLE dental_claim_electronic ADD COLUMN percase_date datetime;
ALTER TABLE dental_claim_electronic ADD COLUMN percase_name varchar(100);
ALTER TABLE dental_claim_electronic ADD COLUMN percase_amount decimal(11,2);
ALTER TABLE dental_claim_electronic ADD COLUMN percase_status tinyint(1) default 0;
ALTER TABLE dental_claim_electronic ADD COLUMN percase_invoice int(11);
ALTER TABLE dental_claim_electronic ADD COLUMN percase_free tinyint(1);
ALTER TABLE dental_ledger ADD COLUMN percase_free tinyint(1);


CREATE TABLE `dental_eligibility_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11),
  `description` varchar(255),
  `start_date` date,
  `end_date` date,
  `amount` decimal(11,2),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

ALTER TABLE dental_eligibility ADD COLUMN eligibility_invoice_id int(11);

CREATE TABLE `dental_enrollment_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11),
  `description` varchar(255),
  `start_date` date,
  `end_date` date,
  `amount` decimal(11,2),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=latin1;

ALTER TABLE dental_eligible_enrollment ADD COLUMN enrollment_invoice_id int(11);

