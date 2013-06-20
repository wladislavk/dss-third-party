create table dental_letter_templates_custom (
	id int auto_increment primary key, 
	name varchar(255), 
	body text,
	docid int,
	adddate datetime,
	ip_address varchar(50)
);
