CREATE TABLE dental_insurance_bo_status (
    id INT(11) NOT NULL AUTO_INCREMENT,
    insuranceid INT(11) NOT NULL DEFAULT 0,
    p_m_dss_file INT(11) NOT NULL DEFAULT 0,
    adminid INT(11) NOT NULL DEFAULT 0,
    ip_address VARCHAR(255) NOT NULL DEFAULT '',
    adddate TIMESTAMP,
    PRIMARY KEY(id),
    INDEX insuranceid (insuranceid),
    INDEX p_m_dss_file (p_m_dss_file),
    INDEX adminid (adminid)
);