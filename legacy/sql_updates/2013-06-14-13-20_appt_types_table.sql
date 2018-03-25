-- use database dentalsl_main;
create table dental_appt_types (id int auto_increment primary key, name varchar(255), color varchar(255));
--alter table dental_appt_types add unique (name);
alter table dental_appt_types add classname varchar(255);
--alter table dental_appt_types add unique (classname);
