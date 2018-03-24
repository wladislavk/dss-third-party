-- From production
ALTER TABLE dental_summ_sleeplab
    ADD INDEX diagnosis (diagnosis),
    ADD INDEX patiendid (patiendid),
    ADD INDEX filename (filename),
    ADD INDEX diagnosising_doc (diagnosising_doc),
    ADD INDEX diagnosising_npi (diagnosising_npi);