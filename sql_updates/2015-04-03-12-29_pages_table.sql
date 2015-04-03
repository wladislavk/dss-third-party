CREATE TABLE IF NOT EXISTS pages (
    pageid INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) DEFAULT '',
    keywords VARCHAR(1000) DEFAULT '',
    status VARCHAR(1) DEFAULT '',
    top_image VARCHAR(2048) DEFAULT '',
    adddate TIMESTAMP,
    ip_address VARCHAR(255),
    PRIMARY KEY(pageid)
);

