ALTER TABLE dental_users ADD COLUMN claim_margin_top int(3) default 0;
ALTER TABLE dental_users ADD COLUMN claim_margin_left int(3) default 0;

ALTER TABLE dental_insurance ADD COLUMN mailed_date datetime;
