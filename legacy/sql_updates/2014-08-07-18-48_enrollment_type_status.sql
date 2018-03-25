ALTER TABLE dental_enrollment_transaction_type ADD COLUMN status tinyint(1) default 1;
update dental_enrollment_transaction_type SET status=0 WHERE transaction_type NOT IN ('270', '276','835','837I');
