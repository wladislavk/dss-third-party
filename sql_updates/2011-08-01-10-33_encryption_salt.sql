ALTER TABLE dental_users ADD COLUMN salt varchar(100);
ALTER TABLE dental_users ADD COLUMN recover_hash varchar(100);
ALTER TABLE dental_users ADD COLUMN recover_time datetime;
