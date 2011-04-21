CREATE TABLE dental_flow_pg2_info
(
patientid int(11),
stepid int(11),
segmentid int(11),
date_scheduled date,
date_completed date,
delay_reason varchar(32),
study_type varchar(16),
FOREIGN KEY (patientid) REFERENCES dental_patients(patientid),
FOREIGN KEY (segmentid) REFERENCES flowsheet_segments(id)
)
