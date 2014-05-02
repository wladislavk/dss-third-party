ALTER TABLE dental_plans ADD COLUMN office_type tinyint(1) default 1;
ALTER TABLE dental_plans ADD COLUMN efile_fee decimal(11,2) default '0.00';
ALTER TABLE dental_plans ADD COLUMN free_efile int(11) default 0;
ALTER TABLE companies ADD COLUMN plan_id int(11);
