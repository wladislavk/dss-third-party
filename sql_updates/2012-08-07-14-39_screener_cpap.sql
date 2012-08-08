ALTER TABLE dental_screener ADD COLUMN rx_cpap tinyint(1) default 0;
ALTER TABLE dental_screener ADD COLUMN phone varchar(30);
ALTER TABLE dental_screener ADD COLUMN contacted tinyint(1) default 0;
