<?php

//inserts row into dental_insurance_history
function claim_history_update($insid, $userid, $adminid){
  $sql = "INSERT INTO dental_insurance_history
		SELECT i.*, '".mysql_real_escape_string($userid)."','".mysql_real_escape_string($adminid)."', now(), NULL
			FROM dental_insurance i
			WHERE i.insuranceid='".mysql_real_escape_string($insid)."'";

  return mysql_query($sql);
}
