ALTER TABLE dental_ledger 
ADD COLUMN primary_claim_id int(11) DEFAULT NULL,
ADD COLUMN primary_paper_claim_id varchar(255) DEFAULT NULL;