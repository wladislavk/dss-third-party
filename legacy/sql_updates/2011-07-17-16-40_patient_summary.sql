CREATE TABLE dental_patient_summary
(
pid INT(11) NOT NULL,
fspage1_complete INT(1),
next_visit DATE,
last_visit DATE,
last_treatment VARCHAR(255),
appliance INT(11),
delivery_date DATE,
vob VARCHAR(255),
ledger FLOAT(11,2)
)
