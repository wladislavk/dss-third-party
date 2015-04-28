<?php
  function checkEmail($e, $i){
    $db = new Db();
    $con = $GLOBALS['con'];

    if(trim($e) == ''){
      $n = 0;
    }else{
      $s = "SELECT patientid FROM dental_patients WHERE 
          	email='".mysqli_real_escape_string($con,$e)."' AND 
          	((patientid!='".mysqli_real_escape_string($con,$i)."' AND 
          	parent_patientid!='".mysqli_real_escape_string($con,$i)."') OR 
            (patientid!='".mysqli_real_escape_string($con,$i)."' AND 
            parent_patientid IS NULL)) ";

      $n = $db->getNumberRows($s);
    }
    return $n;
  }

  function checkUserEmail($e, $i){
    $db = new Db();
    $con = $GLOBALS['con'];

    if(trim($e) == ''){
      $n = 0;
    } else {
      $s = "SELECT userid FROM dental_users WHERE 
          email='".mysqli_real_escape_string($con,$e)."' AND 
          userid!='".mysqli_real_escape_string($con,$i)."'"; 

      $n = $db->getNumberRows($s);
    }
    return $n;
  }

  function checkUsername($u, $i){
    $db = new Db();
    $con = $GLOBALS['con']
    
    if(trim($u) == ''){
      $n = 0;
    }else{
      $s = "SELECT userid FROM dental_users WHERE 
          username='".mysqli_real_escape_string($con,$u)."' AND 
          userid!='".mysqli_real_escape_string($con,$i)."'";

      $n = $db->getNumberRows($s);
    }
    return $n;
  }
?>
