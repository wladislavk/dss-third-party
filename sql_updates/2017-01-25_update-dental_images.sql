ALTER TABLE dental_q_image
    ADD INDEX formid (formid),
    ADD INDEX patientid (patientid),
    ADD INDEX imagetypeid (imagetypeid),
    ADD INDEX userid (userid),
    ADD INDEX docid (docid),
    ADD INDEX status (status),
    ADD INDEX adminid (adminid);