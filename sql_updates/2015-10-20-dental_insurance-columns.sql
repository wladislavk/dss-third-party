ALTER TABLE dental_insurance ADD (
    payer_id VARCHAR(100),
    payer_name VARCHAR(100),
    payer_address VARCHAR(100),
    payer_city VARCHAR(100),
    payer_state VARCHAR(100),
    payer_zip VARCHAR(100),
    billing_provider_taxonomy_code VARCHAR(100),
    other_insured_insurance_type VARCHAR(100)
);