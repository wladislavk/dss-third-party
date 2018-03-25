create table dental_ledger_history LIKE dental_ledger;
ALTER TABLE dental_ledger_history ADD COLUMN updated_by_user int(11);
ALTER TABLE dental_ledger_history ADD COLUMN updated_by_admin int(11);
ALTER TABLE dental_ledger_history ADD COLUMN primary_claim_history_id int(11);
ALTER TABLE dental_ledger_history ADD COLUMN updated_at datetime;
ALTER TABLE dental_ledger_history CHANGE ledgerid ledgerid INT(11);
ALTER TABLE dental_ledger_history DROP PRIMARY KEY;
ALTER TABLE dental_ledger_history ADD COLUMN id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY;

ALTER TABLE dental_ledger ADD COLUMN secondary_claim_id int(11);
