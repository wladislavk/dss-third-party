alter table dental_faxes add column letter_body text;
alter table dental_faxes add column viewed tinyint(1) default 0;
