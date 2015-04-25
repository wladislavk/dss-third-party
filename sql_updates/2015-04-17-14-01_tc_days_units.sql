ALTER TABLE dental_transaction_code MODIFY COLUMN days_units varchar(255) NOT NULL default '1';
update dental_transaction_code set days_units='1' where days_units='';
