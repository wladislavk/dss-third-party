create table dental_insurance_history LIKE dental_insurance;
ALTER TABLE dental_insurance_history ADD COLUMN updated_by_user int(11);
ALTER TABLE dental_insurance_history ADD COLUMN updated_by_admin int(11);
ALTER TABLE dental_insurance_history ADD COLUMN updated_at datetime;
ALTER TABLE dental_insurance_history CHANGE insuranceid insuranceid INT(11);
ALTER TABLE dental_insurance_history DROP PRIMARY KEY;
ALTER TABLE dental_insurance_history ADD COLUMN id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
