ALTER TABLE dental_patient_summary
ADD patient_info INT(1);

UPDATE dental_patient_summary
SET patient_info = 1 
WHERE patient_info = NULL;

ALTER TABLE dental_referredby
ADD referredby_info INT(1);

UPDATE dental_referredby
SET referredby_info = 1 
WHERE referredby_info = NULL;
