ALTER TABLE dental_patients ADD COLUMN login varchar(100);
ALTER TABLE dental_patients ADD COLUMN password varchar(255);
ALTER TABLE dental_patients ADD COLUMN salt varchar(100);
ALTER TABLE dental_patients ADD COLUMN recover_hash varchar(100);
ALTER TABLE dental_patients ADD COLUMN recover_time datetime;
ALTER TABLE dental_patients ADD COLUMN registered tinyint(1);
