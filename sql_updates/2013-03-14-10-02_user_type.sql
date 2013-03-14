ALTER TABLE dental_users ADD COLUMN user_type tinyint(1) default 1;
ALTER TABLE dental_letters ADD COLUMN mailed_date datetime;
