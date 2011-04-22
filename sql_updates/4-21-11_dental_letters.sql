CREATE TABLE dental_letters
(
letterid int(11) unsigned NOT NULL auto_increment,
patientid int(11),
stepid int(11),
generated_date date,
delivery_date date,
send_method varchar(32),
template text,
pdf_path varchar(255),
status tinyint(1),
delivered tinyint(1),
deleted tinyint(1),
PRIMARY KEY (letterid),
FOREIGN KEY (patientid) REFERENCES dental_patients(patientid)
)
