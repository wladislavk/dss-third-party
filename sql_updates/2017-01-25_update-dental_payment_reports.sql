ALTER TABLE dental_payment_reports
    ADD INDEX claimid (claimid),
    ADD INDEX reference_id (reference_id);