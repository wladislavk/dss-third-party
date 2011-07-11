ALTER TABLE dental_letters
  ADD COLUMN date_sent datetime DEFAULT NULL;

ALTER TABLE dental_letters
  CHANGE generated_date generated_date datetime;

ALTER TABLE dental_letters
  CHANGE delivery_date delivery_date datetime;

UPDATE dental_letters SET date_sent = NOW() WHERE status = 1 AND date_sent IS NULL;
