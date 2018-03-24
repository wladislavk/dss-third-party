ALTER TABLE dental_transaction_code ADD COLUMN default_code int(1);
UPDATE dental_transaction_code SET default_code=1;
ALTER TABLE dental_transaction_code ADD COLUMN docid int(11);
ALTER TABLE dental_transaction_code ADD COLUMN amount decimal(11,2);
