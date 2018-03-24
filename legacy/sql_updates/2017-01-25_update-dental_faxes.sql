ALTER TABLE dental_faxes
    ADD INDEX patientid (patientid),
    ADD INDEX userid (userid),
    ADD INDEX docid (docid),
    ADD INDEX contactid (contactid),
    ADD INDEX letterid (letterid),
    ADD INDEX sfax_completed (sfax_completed),
    ADD INDEX sfax_transmission_id (sfax_transmission_id),
    ADD INDEX sfax_status (sfax_status),
    ADD INDEX viewed (viewed);