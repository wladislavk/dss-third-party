ALTER TABLE dental_users ADD COLUMN mailing_practice varchar(255);
ALTER TABLE dental_users ADD COLUMN mailing_name varchar(255);
ALTER TABLE dental_users ADD COLUMN mailing_address text;
ALTER TABLE dental_users ADD COLUMN mailing_city varchar(255);
ALTER TABLE dental_users ADD COLUMN mailing_state varchar(255);
ALTER TABLE dental_users ADD COLUMN mailing_zip varchar(255);
ALTER TABLE dental_users ADD COLUMN mailing_phone varchar(250);



ALTER TABLE dental_contact ADD COLUMN referredby_notes text;
