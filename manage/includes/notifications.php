<?php

function create_notification($pid, $docid, $n, $n_type, $s=1){

  $db = new Db();
  $con = $GLOBALS['con'];
  
  $s = "INSERT INTO dental_notifications (patientid, docid, notification, notification_type, status, notification_date)
		VALUES
	('".mysqli_real_escape_string($con,$pid)."',
		 '".mysqli_real_escape_string($con,$docid)."',
		 '".mysqli_real_escape_string($con,$n)."',
		 '".mysqli_real_escape_string($con,$n_type)."',
		 '".mysqli_real_escape_string($con,$s)."',
		 NOW())";

  $q = $db->query($s);
  return $q;
}


function find_patient_notifications($p){

  $db = new Db();
  $con = $GLOBALS['con'];

  $s = "SELECT * FROM dental_notifications WHERE patientid='".mysqli_real_escape_string($con,$p)."' AND status=1";
  
  $q = $db->getResults($s);
  $not = array();
  if ($q) foreach ($q as $r){
    array_push($not, $r);
  }
  return $not;
}


?>
