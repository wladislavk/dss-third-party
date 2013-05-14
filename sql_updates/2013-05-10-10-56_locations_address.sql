ALTER TABLE dental_locations ADD COLUMN name varchar(100);
ALTER TABLE dental_locations ADD COLUMN address varchar(100);
ALTER TABLE dental_locations ADD COLUMN city varchar(100);
ALTER TABLE dental_locations ADD COLUMN state varchar(20);
ALTER TABLE dental_locations ADD COLUMN zip varchar(10);
ALTER TABLE dental_locations ADD COLUMN phone varchar(20);
ALTER TABLE dental_locations ADD COLUMN fax varchar(20);
ALTER TABLE dental_locations ADD COLUMN default_location tinyint(1) default 0;


INSERT INTO dental_locations (location, docid, name, address, city, state, zip, phone, fax, default_location) SELECT mailing_practice, userid, mailing_name, mailing_address, mailing_city, mailing_state, mailing_zip, mailing_phone, fax, '1' FROM dental_users where docid=0;

