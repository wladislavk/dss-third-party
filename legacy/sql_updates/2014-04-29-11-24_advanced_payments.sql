ALTER TABLE dental_ledger_payment ADD COLUMN allowed decimal(11,2) default '0.00';
ALTER TABLE dental_ledger_payment ADD COLUMN ins_paid decimal(11,2) default '0.00';
ALTER TABLE dental_ledger_payment ADD COLUMN deductible decimal(11,2) default '0.00';
ALTER TABLE dental_ledger_payment ADD COLUMN copay decimal(11,2) default '0.00';
ALTER TABLE dental_ledger_payment ADD COLUMN coins decimal(11,2) default '0.00';
ALTER TABLE dental_ledger_payment ADD COLUMN overpaid decimal(11,2) default '0.00';
ALTER TABLE dental_ledger_payment ADD COLUMN followup datetime;
ALTER TABLE dental_ledger_payment ADD COLUMN note varchar(255);
