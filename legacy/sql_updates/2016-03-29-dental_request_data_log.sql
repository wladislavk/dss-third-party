CREATE TABLE IF NOT EXISTS dental_request_data_log (
    id INT(11) NOT NULL AUTO_INCREMENT,
    patientid INT(11) NOT NULL DEFAULT 0,
    userid INT(11) NOT NULL DEFAULT 0,
    adminid INT(11) NOT NULL DEFAULT 0,
    script TEXT NOT NULL,
    referer TEXT NOT NULL,
    request_time DOUBLE NOT NULL DEFAULT 0.0,
    get_data TEXT NOT NULL,
    post_data TEXT NOT NULL,
    files_data TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(id),
    INDEX patientid (patientid),
    INDEX userid (userid),
    INDEX adminid (adminid),
    INDEX script (script(20)),
    INDEX referer (referer(20))
);

CREATE TABLE IF NOT EXISTS dental_request_data_type (
    id INT(11) NOT NULL AUTO_INCREMENT,
    log_id INT(11) NOT NULL DEFAULT 0,
    item_id INT(11) NOT NULL DEFAULT 0,
    item_table VARCHAR(64) NOT NULL DEFAULT '',
    created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(id),
    INDEX item_id (item_id),
    INDEX item_table (item_table)
);