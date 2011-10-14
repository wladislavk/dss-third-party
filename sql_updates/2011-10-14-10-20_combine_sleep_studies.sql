ALTER TABLE dental_summ_sleeplab ADD COLUMN testnumber varchar(255);
ALTER TABLE dental_summ_sleeplab ADD COLUMN needed varchar(255);
ALTER TABLE dental_summ_sleeplab ADD COLUMN scheddate varchar(255);
ALTER TABLE dental_summ_sleeplab ADD COLUMN completed varchar(255);
ALTER TABLE dental_summ_sleeplab ADD COLUMN interpolation varchar(255);
ALTER TABLE dental_summ_sleeplab ADD COLUMN copyreqdate varchar(255);
ALTER TABLE dental_summ_sleeplab ADD COLUMN sleeplab varchar(255);

INSERT INTO dental_summ_sleeplab (date, sleeptesttype, place, patiendid, filename, testnumber, needed, scheddate, completed, interpolation, copyreqdate, sleeplab) 
      SELECT date, labtype, sleeplabwheresched, patientid, CONCAT(filename, '.', scanext), testnumber, needed, scheddate, completed, interpolation, copyreqdate, sleeplab
          FROM dental_sleepstudy;
