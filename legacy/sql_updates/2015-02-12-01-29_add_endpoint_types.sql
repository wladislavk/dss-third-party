ALTER TABLE dental_enrollment_transaction_type ADD COLUMN endpoint_type varchar(255);
UPDATE dental_enrollment_transaction_type SET endpoint_type = 'coverage' WHERE transaction_type = "270";
UPDATE dental_enrollment_transaction_type SET endpoint_type = 'payment status' WHERE transaction_type = "276";
UPDATE dental_enrollment_transaction_type SET endpoint_type = 'payment reports' WHERE transaction_type = "835";
UPDATE dental_enrollment_transaction_type SET endpoint_type = 'professional claims' WHERE transaction_type = "837P";