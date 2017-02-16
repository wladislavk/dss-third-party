-- Version from production
ALTER TABLE dental_q_page3
    ADD INDEX formid (formid),
    ADD INDEX userid (userid),
    ADD INDEX docid (docid),
    ADD INDEX status (status),
    ADD INDEX parent_patientid (parent_patientid);