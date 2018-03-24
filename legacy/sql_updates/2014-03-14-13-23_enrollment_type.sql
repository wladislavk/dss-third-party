CREATE TABLE `dental_enrollment_transaction_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(10),
  `description` varchar(200),
  `adddate` datetime,
  `ip_address` varchar(50),
  PRIMARY KEY (`id`)
);

INSERT INTO dental_enrollment_transaction_type (transaction_type, description, adddate) VALUES ('270', 'Eligibility/Benefits', now());
INSERT INTO dental_enrollment_transaction_type (transaction_type, description, adddate) VALUES ('276', 'Claim Status', now());
INSERT INTO dental_enrollment_transaction_type (transaction_type, description, adddate) VALUES ('278', 'Request for Review (Referral/Authorization)', now());
INSERT INTO dental_enrollment_transaction_type (transaction_type, description, adddate) VALUES ('835', 'Claim Payment (ERA)', now());
INSERT INTO dental_enrollment_transaction_type (transaction_type, description, adddate) VALUES ('835P', 'Profession Claim Filing', now());
INSERT INTO dental_enrollment_transaction_type (transaction_type, description, adddate) VALUES ('837D', 'Dental Claim Filing', now());
INSERT INTO dental_enrollment_transaction_type (transaction_type, description, adddate) VALUES ('837I', 'Institutional Claim Filing', now());

ALTER TABLE dental_eligible_enrollment ADD COLUMN transaction_type_id int(11);
