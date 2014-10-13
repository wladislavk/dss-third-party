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

      $n = $db->getNumberRows($s);
    }
    return $n;
  }

  function checkUserEmail($e, $i){
    if(trim($e) == ''){
      $n = 0;
    } else {
      $s = "SELECT userid FROM dental_users WHERE 
          email='".mysql_real_escape_string($e)."' AND 
          userid!='".mysql_real_escape_string($i)."'"; 

      $n = $db->getNumberRows($s);
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

      $n = $db->getNumberRows($s);
    }
    return $n;
  }
?>
