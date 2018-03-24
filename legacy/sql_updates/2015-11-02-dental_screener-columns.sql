ALTER TABLE dental_screener ADD (
    rx_metabolic_syndrome TINYINT(1) DEFAULT 0,
    rx_obesity TINYINT(1) DEFAULT 0,
    rx_afib TINYINT(1) DEFAULT 0
);