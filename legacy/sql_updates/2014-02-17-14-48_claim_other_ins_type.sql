ALTER TABLE dental_insurance ADD COLUMN other_insurance_type tinyint(2);
ALTER TABLE dental_insurance ADD COLUMN patient_relation_other_insured varchar(255);
ALTER TABLE dental_patients ADD COLUMN p_m_gender varchar(20);
ALTER TABLE dental_patients ADD COLUMN s_m_gender varchar(20);
