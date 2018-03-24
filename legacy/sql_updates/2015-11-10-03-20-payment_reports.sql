ALTER TABLE dental_payment_reports ADD COLUMN viewed tinyint(1) default 0;
ALTER TABLE dental_users ADD COLUMN use_payment_reports tinyint(1) default 0;
