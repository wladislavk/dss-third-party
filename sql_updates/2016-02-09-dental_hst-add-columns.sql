ALTER TABLE dental_hst ADD COLUMN canceled_id INT(11) NOT NULL DEFAULT 0 AFTER rejecteddate;
ALTER TABLE dental_hst ADD COLUMN canceled_date DATETIME AFTER canceled_id;