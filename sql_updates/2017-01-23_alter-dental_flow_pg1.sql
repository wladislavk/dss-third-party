-- One of the indexes is non an integer
ALTER TABLE dental_flow_pg1
    MODIFY COLUMN pid INT(11) DEFAULT 0,
    ADD INDEX pid (pid),
    ADD INDEX rx_imgid (rx_imgid),
    ADD INDEX lomn_imgid (lomn_imgid),
    ADD INDEX notes_imgid (notes_imgid),
    ADD INDEX rxlomn_imgid (rxlomn_imgid);