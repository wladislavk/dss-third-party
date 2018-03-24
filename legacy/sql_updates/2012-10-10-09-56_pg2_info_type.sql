ALTER TABLE dental_flow_pg2_info ADD COLUMN appointment_type tinyint(1) NOT NULL default 1;

UPDATE dental_flow_pg2_info SET appointment_type = 0 WHERE date_scheduled != "0000-00-00" AND date_scheduled IS NOT NULL AND date_scheduled!='';

UPDATE dental_flow_pg2_info SET appointment_type = 1 WHERE date_completed != "0000-00-00" AND date_completed IS NOT NULL AND date_completed!='';
