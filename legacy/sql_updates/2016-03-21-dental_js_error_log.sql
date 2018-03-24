CREATE TABLE IF NOT EXISTS dental_js_error_log (
    id INT(11) NOT NULL AUTO_INCREMENT,
    userid INT(11) NOT NULL DEFAULT 0,
    adminid INT(11) NOT NULL DEFAULT 0,
    report TEXT NOT NULL,
    ip_address VARCHAR(50) NOT NULL DEFAULT '',
    referrer TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(id),
    INDEX userid (userid),
    INDEX adminid (adminid),
    INDEX referrer (referrer(15))
);