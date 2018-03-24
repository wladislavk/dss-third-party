ALTER TABLE dental_users ADD COLUMN header_space tinyint(1);
ALTER TABLE dental_letters ADD COLUMN font_family varchar(50) default 'dejavusans';
ALTER TABLE dental_letters ADD COLUMN font_size int(4) default 10;


