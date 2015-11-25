ALTER TABLE dental_patients DROP INDEX parent_patientid_2;
ALTER TABLE dental_patients DROP INDEX patientid_2;
ALTER TABLE dental_patients DROP INDEX parent_patientid_3;
ALTER TABLE dental_patient_summary ADD INDEX `pid` (`pid`);