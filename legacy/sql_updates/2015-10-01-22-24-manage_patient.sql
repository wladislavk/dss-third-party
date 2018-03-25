ALTER TABLE `dental_flow_pg2_info` ADD INDEX `appointment_type` (`appointment_type`);
ALTER TABLE `dental_flow_pg2_info` ADD INDEX `date_completed` (`date_completed`);

ALTER TABLE `dental_flow_pg1` ADD INDEX `pid` (`pid`);

ALTER TABLE `dental_ledger` ADD INDEX `docid` (`docid`);
ALTER TABLE `dental_ledger` ADD INDEX `paid_amount` (`paid_amount`);
ALTER TABLE `dental_ledger` ADD INDEX `patientid` (`patientid`);
ALTER TABLE `dental_ledger` ADD INDEX `amount` (`amount`);
ALTER TABLE `dental_ledger` ADD INDEX `ledgerid` (`ledgerid`);

ALTER TABLE `dental_ledger_payment` ADD INDEX `ledgerid` (`ledgerid`);

ALTER TABLE `dental_summ_sleeplab` ADD INDEX `patiendid` (`patiendid`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX `diagnosising_doc` (`diagnosising_doc`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX `diagnosising_npi` (`diagnosising_npi`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX `diagnosis` (`diagnosis`);
ALTER TABLE `dental_summ_sleeplab` ADD INDEX `filename` (`filename`);

ALTER TABLE `dental_q_page3` ADD INDEX `patientid` (`patientid`);

ALTER TABLE `dental_ex_page5` ADD INDEX `patientid` (`patientid`);
ALTER TABLE `dental_ex_page5` ADD INDEX `dentaldevice` (`dentaldevice`);

ALTER TABLE `dental_patients` ADD INDEX `lastname` (`lastname`);
ALTER TABLE `dental_patients` ADD INDEX `firstname` (`firstname`);
ALTER TABLE `dental_patients` ADD INDEX `p_m_ins_type` (`p_m_ins_type`);