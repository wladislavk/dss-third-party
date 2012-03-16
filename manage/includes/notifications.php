<?php

function create_notification($pid, $docid, $n, $n_type, $s=1){
  $s = "INSERT INTO dental_notifications (patientid, docid, notification, notification_type, status, notification_date)
		VALUES
	('".mysql_real_escape_string($pid)."',
		 '".mysql_real_escape_string($docid)."',
		 '".mysql_real_escape_string($n)."',
		 '".mysql_real_escape_string($n_type)."',
		 '".mysql_real_escape_string($s)."',
		 NOW())";
  $q = mysql_query($s);
  return $q;
}


function find_patient_notifications($p){

  $s = "SELECT * FROM dental_notifications WHERE patientid='".mysql_real_escape_string($p)."' AND status=1";
  $q = mysql_query($s);
  $not = array();
  while($r = mysql_fetch_assoc($q)){
    array_push($not, $r);
  }
  return $not;
}


?>
