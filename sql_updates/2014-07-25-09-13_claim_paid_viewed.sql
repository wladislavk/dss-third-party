ALTER TABLE dental_insurance ADD COLUMN fo_paid_viewed tinyint(1) default 0;
ALTER TABLE dental_insurance ADD COLUMN bo_paid_viewed tinyint(1) default 0;
ALTER TABLE dental_insurance ADD COLUMN closed_by_office_type tinyint(1);
