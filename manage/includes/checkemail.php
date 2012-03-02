<?php

function checkEmail($e, $i){
  if(trim($e) == ''){
    $n = 0;
  }else{
    $s = "SELECT patientid FROM dental_patients WHERE 
	email='".mysql_real_escape_string($e)."' AND 
	((patientid!='".mysql_real_escape_string($i)."' AND 
		parent_patientid!='".mysql_real_escape_string($i)."') OR 
        (patientid!='".mysql_real_escape_string($i)."' AND 
                parent_patientid IS NULL)) ";
    $q = mysql_query($s);
    $n = mysql_num_rows($q);
  }
  return $n;
}
?>
