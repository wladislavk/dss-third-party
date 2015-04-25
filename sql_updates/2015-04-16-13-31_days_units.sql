ALTER TABLE dental_ledger MODIFY COLUMN daysorunits varchar(255) NOT NULL default '1';
update dental_ledger set daysorunits='1' where daysorunits='';
