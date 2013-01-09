ALTER TABLE dental_users ADD COLUMN access_code varchar(100);
ALTER TABLE dental_users ADD COLUMN text_date datetime;
ALTER TABLE dental_users ADD COLUMN text_num int(2) NOT NULL default 0;
ALTER TABLE dental_users ADD COLUMN access_code_date datetime;
