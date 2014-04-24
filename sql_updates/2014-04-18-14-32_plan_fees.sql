ALTER TABLE dental_plans ADD COLUMN eligibility_fee decimal(11,2) default '0.00';
ALTER TABLE dental_plans ADD COLUMN free_eligibility int(11) default '0';
ALTER TABLE dental_plans ADD COLUMN enrollment_fee decimal(11,2) default '0.00';
ALTER TABLE dental_plans ADD COLUMN free_enrollment int(11) default '0';
ALTER TABLE dental_plans ADD COLUMN claim_fee decimal(11,2) default '0.00';
ALTER TABLE dental_plans ADD COLUMN free_claim int(11) default '0';
ALTER TABLE dental_plans ADD COLUMN vob_fee decimal(11,2) default '0.00';
ALTER TABLE dental_plans ADD COLUMN free_vob int(11) default '0';
