UPDATE dental_enrollment_transaction_type SET description = "Eligibility / Coverage" WHERE description="Eligibility/Benefits";
UPDATE dental_enrollment_transaction_type SET description = "Payment Status" WHERE description="Claim Status";
UPDATE dental_enrollment_transaction_type SET description = "Payment Report (ERA)" WHERE description="Claim Payment (ERA)";
UPDATE dental_enrollment_transaction_type SET description = "Medical Claim" WHERE description="Professional Claim";
