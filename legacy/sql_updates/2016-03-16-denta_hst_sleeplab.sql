CREATE TABLE IF NOT EXISTS dental_hst_sleeplab (
    hst_id INT(11) NOT NULL DEFAULT 0,
    sleep_id INT(11) NOT NULL DEFAULT 0,
    UNIQUE hst_sleep (hst_id, sleep_id)
);