ALTER TABLE dental_insurance_preauth ADD COLUMN family_amount_left_to_meet decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN deductible_from int(1) NOT NULL default 0;
