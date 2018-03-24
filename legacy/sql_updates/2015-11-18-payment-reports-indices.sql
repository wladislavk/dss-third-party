ALTER TABLE dental_payment_reports ADD INDEX viewed (viewed);
ALTER TABLE dental_users ADD INDEX use_payment_reports (use_payment_reports);