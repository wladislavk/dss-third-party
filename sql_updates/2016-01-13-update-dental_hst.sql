ALTER TABLE dental_hst ADD COLUMN hst_nights INT(11) DEFAULT 2;
ALTER TABLE dental_hst ADD COLUMN hst_positions TEXT NOT NULL DEFAULT '';

ALTER TABLE dental_hst ADD COLUMN provider_phone VARCHAR(255) NOT NULL DEFAULT '' AFTER provider_lastname;
UPDATE dental_hst SET provider_phone = ins_phone;