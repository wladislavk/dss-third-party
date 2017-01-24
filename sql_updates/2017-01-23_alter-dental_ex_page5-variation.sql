-- Version from production
ALTER TABLE dental_ex_page5
    ADD INDEX formid (formid),
    ADD INDEX userid (userid),
    ADD INDEX docid (docid),
    ADD INDEX status (status),
    ADD INDEX dentaldevice_date (dentaldevice_date);