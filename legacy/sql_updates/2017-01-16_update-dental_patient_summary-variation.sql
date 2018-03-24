-- As planned from production
-- There was a mismatch in indexes between dev and production
ALTER TABLE dental_patient_summary
    ADD INDEX fspage1_complete (fspage1_complete),
    ADD INDEX patient_info (patient_info),
    ADD INDEX appliance (appliance);