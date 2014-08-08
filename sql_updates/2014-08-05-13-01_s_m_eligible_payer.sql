ALTER TABLE dental_patients ADD COLUMN s_m_eligible_payer_id varchar(20);
ALTER TABLE dental_patients ADD COLUMN s_m_eligible_payer_name varchar(200);
ALTER TABLE dental_insurance ADD COLUMN s_m_eligible_payer_id varchar(20);
ALTER TABLE dental_insurance ADD COLUMN s_m_eligible_payer_name varchar(200);
