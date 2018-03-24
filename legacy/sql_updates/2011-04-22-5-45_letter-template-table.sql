ALTER TABLE dental_letters
ADD templateid int(11);

CREATE TABLE dental_letter_templates
(
id int(11) unsigned NOT NULL auto_increment,
name varchar(255),
template varchar(255),
PRIMARY KEY (id)
)
