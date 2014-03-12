ALTER TABLE dental_patients ADD COLUMN p_m_same_address tinyint(1) default 1;
ALTER TABLE dental_patients ADD COLUMN p_m_address varchar(100);
ALTER TABLE dental_patients ADD COLUMN p_m_state varchar(100);
ALTER TABLE dental_patients ADD COLUMN p_m_city varchar(100);
ALTER TABLE dental_patients ADD COLUMN p_m_zip varchar(20);
ALTER TABLE dental_patients ADD COLUMN s_m_same_address tinyint(1) default 1;
ALTER TABLE dental_patients ADD COLUMN s_m_address varchar(100);
ALTER TABLE dental_patients ADD COLUMN s_m_city varchar(100);
ALTER TABLE dental_patients ADD COLUMN s_m_state varchar(100);
ALTER TABLE dental_patients ADD COLUMN s_m_zip varchar(20);

ALTER TABLE dental_insurance ADD COLUMN other_insured_address varchar(100);
ALTER TABLE dental_insurance ADD COLUMN other_insured_city varchar(100);
ALTER TABLE dental_insurance ADD COLUMN other_insured_state varchar(100);
ALTER TABLE dental_insurance ADD COLUMN other_insured_zip varchar(100);
