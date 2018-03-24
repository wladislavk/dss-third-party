ALTER TABLE dental_users ADD COLUMN use_digital_fax tinyint(1) NOT NULL default 0;
ALTER TABLE dental_users ADD COLUMN fax varchar(250) NOT NULL;
