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

function checkUserEmail($e, $i){
  if(trim($e) == ''){
    $n = 0;
  }else{
    $s = "SELECT userid FROM dental_users WHERE 
        email='".mysql_real_escape_string($e)."' AND 
        userid!='".mysql_real_escape_string($i)."'"; 
    $q = mysql_query($s);
    $n = mysql_num_rows($q);
  }
  return $n;
}

function checkUsername($u, $i){
  if(trim($u) == ''){
    $n = 0;
  }else{
    $s = "SELECT userid FROM dental_users WHERE 
        username='".mysql_real_escape_string($u)."' AND 
        userid!='".mysql_real_escape_string($i)."'";
    $q = mysql_query($s);
    $n = mysql_num_rows($q);
  }
  return $n;
}
?>
