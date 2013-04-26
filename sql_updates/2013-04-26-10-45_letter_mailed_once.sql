ALTER TABLE dental_letters ADD COLUMN mailed_once tinyint(1) default 0 ;


UPDATE dental_letters SET mailed_once=1 WHERE mailed_date IS NOT NULL;
