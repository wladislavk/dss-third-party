ALTER TABLE dental_patients ADD COLUMN has_p_m_ins varchar(5);
ALTER TABLE dental_patients ADD COLUMN registration_status int(1) default 0;
ALTER TABLE dental_users ADD COLUMN use_patient_portal tinyint(1) default 0;
