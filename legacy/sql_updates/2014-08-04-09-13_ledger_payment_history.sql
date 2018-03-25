create table dental_ledger_payment_history LIKE dental_ledger_payment;
ALTER TABLE dental_ledger_payment_history ADD COLUMN updated_by_user int(11);
ALTER TABLE dental_ledger_payment_history ADD COLUMN updated_by_admin int(11);
ALTER TABLE dental_ledger_payment_history ADD COLUMN updated_at datetime;
ALTER TABLE dental_ledger_payment_history CHANGE id paymentid INT(11);
ALTER TABLE dental_ledger_payment_history DROP PRIMARY KEY;
ALTER TABLE dental_ledger_payment_history ADD COLUMN id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY;

