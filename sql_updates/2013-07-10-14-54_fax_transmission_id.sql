ALTER TABLE dental_faxes ADD COLUMN sfax_transmission_id varchar(255);
ALTER TABLE dental_faxes ADD COLUMN sfax_completed tinyint(1) default 0;
ALTER TABLE dental_faxes ADD COLUMN sfax_response text;
ALTER TABLE dental_faxes ADD COLUMN sfax_status tinyint(1) default 0;
ALTER TABLE dental_faxes ADD COLUMN sfax_error_code varchar(20);
