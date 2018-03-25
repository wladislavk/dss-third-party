ALTER TABLE dental_insurance ADD COLUMN primary_claim_version tinyint(1) default 2;
ALTER TABLE dental_insurance ADD COLUMN secondary_claim_version tinyint(1) default 2;

