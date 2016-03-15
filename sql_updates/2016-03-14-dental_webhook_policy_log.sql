CREATE TABLE IF NOT EXISTS dental_webhook_policy_log (
    id INT(11) NOT NULL AUTO_INCREMENT,
    claimid INT(11) NOT NULL DEFAULT 0,
    reference_id VARCHAR(50) NOT NULL DEFAULT '',
    current_status VARCHAR(50) NOT NULL,
    rejected_status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(id),
    INDEX claimid (claimid),
    INDEX reference_id (reference_id),
    INDEX current_status (current_status),
    INDEX rejected_status (rejected_status)
);