<?php

function checkEmail($e, $i){
  $s = "SELECT patientid FROM dental_patients WHERE 
	email='".mysql_real_escape_string($e)."' AND 
	(patientid!='".mysql_real_escape_string($i)."' OR 
		parent_patientid!='".mysql_real_escape_string($i)."')";
  $q = mysql_query($s);
  return mysql_num_rows($q);
}
?>
