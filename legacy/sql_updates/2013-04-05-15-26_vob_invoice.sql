ALTER TABLE dental_insurance_preauth ADD COLUMN invoice_date datetime;
ALTER TABLE dental_insurance_preauth ADD COLUMN invoice_amount decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN invoice_status tinyint(1) default 0;
ALTER TABLE dental_insurance_preauth ADD COLUMN invoice_id int(11);
