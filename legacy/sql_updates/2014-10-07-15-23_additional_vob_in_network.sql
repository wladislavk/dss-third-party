ALTER TABLE dental_insurance_preauth ADD COLUMN has_in_network_benefits int(1);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_is_pre_auth_required int(1);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_verbal_pre_auth_name varchar(255);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_verbal_pre_auth_ref_num varchar(255);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_verbal_pre_auth_notes text;
ALTER TABLE dental_insurance_preauth ADD COLUMN in_written_pre_auth_date_received varchar(255);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_pre_auth_num varchar(255);
ALTER TABLE dental_insurance_preauth ADD COLUMN in_written_pre_auth_notes text;