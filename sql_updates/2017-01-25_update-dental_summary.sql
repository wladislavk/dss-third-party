ALTER TABLE dental_summary
    ADD INDEX formid (formid),
    ADD INDEX patientid (patientid),
    ADD INDEX userid (userid),
    ADD INDEX docid (docid);