ALTER TABLE dental_letters DROP recipientids;
ALTER TABLE dental_letters ADD topatient tinyint(1);
ALTER TABLE dental_letters ADD md_list varchar(255);
ALTER TABLE dental_letters ADD md_referral_list varchar(255);
