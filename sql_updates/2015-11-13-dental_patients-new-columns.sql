ALTER TABLE dental_patients ADD alert_text TEXT AFTER patient_notes;
ALTER TABLE dental_patients ADD display_alert INT(1) AFTER alert_text;
