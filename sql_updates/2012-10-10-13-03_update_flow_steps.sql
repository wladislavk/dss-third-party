
DELETE FROM dental_flowsheet_steps where id=10;
UPDATE dental_flowsheet_steps SET name="Titration Sleep Study" WHERE id="3";
UPDATE dental_flow_pg2_info SET segmentid=3 WHERE segmentid=10;
