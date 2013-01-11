ALTER TABLE dental_users ADD COLUMN producer_files tinyint(1) NOT NULL default 0;
ALTER TABLE dental_insurance ADD COLUMN producer int(11);
