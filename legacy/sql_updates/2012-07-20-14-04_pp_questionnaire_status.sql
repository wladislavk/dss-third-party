ALTER TABLE dental_patients ADD COLUMN symptoms_status tinyint(1) default 0;
ALTER TABLE dental_patients ADD COLUMN sleep_status tinyint(1) default 0;
ALTER TABLE dental_patients ADD COLUMN treatments_status tinyint(1) default 0;
ALTER TABLE dental_patients ADD COLUMN history_status tinyint(1) default 0;
