ALTER TABLE dental_insurance_preauth ADD COLUMN in_deductible_from int(1);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_patient_deductible decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_patient_amount_met decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_patient_amount_left_to_meet decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_family_deductible decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_family_amount_met decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_family_amount_left_to_meet decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_deductible_reset_date varchar(255);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_out_of_pocket_met int(1) NOT NULL DEFAULT 0;
ALTER TABLE dental_insurance_preauth ADD COLUMN in_expected_insurance_payment decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_expected_patient_payment decimal(11,2);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_call_reference_num varchar(255);

