ALTER TABLE `dental_flow_pg2_info` ADD INDEX(`appointment_type`);
ALTER TABLE `dental_flow_pg2_info` ADD INDEX(`date_completed`);

ALTER TABLE `dental_flow_pg1` ADD INDEX(`pid`);

ALTER TABLE `dental_ledger` ADD INDEX(`docid`);
ALTER TABLE `dental_ledger` ADD INDEX(`paid_amount`);
ALTER TABLE `dental_ledger` ADD INDEX(`patientid`);
ALTER TABLE `dental_ledger` ADD INDEX(`amount`);
ALTER TABLE `dental_ledger` ADD INDEX(`ledgerid`);

ALTER TABLE `dental_ledger_payment` ADD INDEX(`ledgerid`);

ALTER TABLE `dental_summ_sleeplab` ADD INDEX(`patiendid`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX(`diagnosising_doc`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX(`diagnosising_npi`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX(`diagnosis`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX(`filename`);

ALTER TABLE `dental_q_page3` ADD INDEX(`patientid`);

ALTER TABLE `dental_ex_page5` ADD INDEX(`patientid`);
ALTER TABLE `dental_ex_page5` ADD INDEX(`dentaldevice`);

ALTER TABLE `dental_patients` ADD INDEX(`lastname`);
ALTER TABLE `dental_patients` ADD INDEX(`firstname`);
ALTER TABLE `dental_patients` ADD INDEX(`p_m_ins_type`);