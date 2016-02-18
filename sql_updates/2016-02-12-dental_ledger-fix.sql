-- Updates for ledger items removed the references to the primary claim id
-- effectively duplicating the secondary claim id
-- This query fixes these references
--
-- Backup first!
UPDATE dental_ledger ledger
  JOIN dental_insurance secondary ON secondary.insuranceid = ledger.secondary_claim_id
SET ledger.primary_claim_id = secondary.primary_claim_id
WHERE ledger.primary_claim_id = ledger.secondary_claim_id;

ALTER TABLE dental_ledger_payment ADD COLUMN is_secondary TINYINT NOT NULL DEFAULT 0;
ALTER TABLE dental_ledger_payment_history ADD COLUMN is_secondary TINYINT NOT NULL DEFAULT 0;
ALTER TABLE dental_ledger_history ADD COLUMN secondary_claim_id INT(11) NOT NULL DEFAULT 0;
