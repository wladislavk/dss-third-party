-- use database dentalsl_main;
create table dental_resources (id int auto_increment primary key, name varchar(255));
--alter table dental_resources add unique (name);
alter table dental_resources add rank int
