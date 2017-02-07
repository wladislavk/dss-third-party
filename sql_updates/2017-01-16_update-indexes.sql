ALTER TABLE dental_flow_pg2_info
    ADD INDEX stepid (stepid),
    ADD INDEX letterid (letterid),
    ADD INDEX device_id (device_id);

ALTER TABLE dental_flowsheet_steps
    ADD INDEX sort_by (sort_by),
    ADD INDEX section (section);

ALTER TABLE dental_flowsheet_steps_next
    ADD INDEX parent_id (parent_id),
    ADD INDEX child_id (child_id),
    ADD INDEX sort_by (sort_by);

ALTER TABLE dental_letter_templates
    ADD INDEX default_letter (default_letter),
    ADD INDEX companyid (companyid),
    ADD INDEX triggerid (triggerid);