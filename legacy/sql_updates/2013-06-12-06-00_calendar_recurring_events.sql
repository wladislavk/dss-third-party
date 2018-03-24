-- use database dentalsl_main;
alter table dental_calendar add column rec_type varchar(64);
alter table dental_calendar add column event_length bigint;
alter table dental_calendar add column event_pid bigint;
alter table dental_calendar add column res_id int;
