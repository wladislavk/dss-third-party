ALTER TABLE dental_patients ADD COLUMN last_reg_sect int(3) NOT NULL default 0;
ALTER TABLE dental_contact ADD COLUMN merge_id int(11);
ALTER TABLE dental_contact ADD COLUMN merge_date datetime;
