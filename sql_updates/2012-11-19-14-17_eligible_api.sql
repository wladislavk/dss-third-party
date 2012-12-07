ALTER TABLE dental_users ADD COLUMN use_eligible_api tinyint(1) not null default 0;
ALTER TABLE companies ADD COLUMN eligible_api_key varchar(255);
