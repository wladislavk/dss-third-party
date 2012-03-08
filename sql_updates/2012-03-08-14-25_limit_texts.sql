ALTER TABLE dental_patients ADD COLUMN text_date datetime;
ALTER TABLE dental_patients ADD COLUMN text_num int(2) NOT NULL default 0;
ALTER TABLE dental_patients ADD COLUMN use_patient_portal int(1) NOT NULL default 1;
