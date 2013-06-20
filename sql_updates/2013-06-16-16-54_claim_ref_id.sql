ALTER TABLE dental_claim_electronic ADD COLUMN reference_id varchar(50);

ALTER TABLE dental_eligible_response DROP COLUMN claim_electronic_id;
ALTER TABLE dental_eligible_response ADD COLUMN reference_id varchar(50);
