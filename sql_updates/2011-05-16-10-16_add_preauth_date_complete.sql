ALTER TABLE dental_insurance_preauth
  ADD COLUMN date_completed datetime DEFAULT NULL;

UPDATE dental_insurance_preauth SET date_completed = NOW() WHERE status = 1 AND date_completed IS NULL;