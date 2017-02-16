ALTER TABLE dental_hst
    ADD INDEX doc_id (doc_id),
    ADD INDEX user_id (user_id),
    ADD INDEX company_id (company_id),
    ADD INDEX patient_id (patient_id),
    ADD INDEX screener_id (screener_id),
    ADD INDEX ins_co_id (ins_co_id),
    ADD INDEX patient_ins_id (patient_ins_id),
    ADD INDEX diagnosis_id (diagnosis_id),
    ADD INDEX viewed (viewed),
    ADD INDEX status (status),
    ADD INDEX sleep_study_id (sleep_study_id),
    ADD INDEX authorized_id (authorized_id),
    ADD INDEX canceled_id (canceled_id);