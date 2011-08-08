### dentalsl_site_
ALTER TABLE admin ADD COLUMN salt varchar(100);
ALTER TABLE admin ADD COLUMN recover_hash varchar(100);
ALTER TABLE admin ADD COLUMN recover_time datetime;
