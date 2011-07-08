<?php

function claim_errors( $pid ){
  $errors = array();

   $sql = "SELECT * FROM dental_patients p JOIN dental_referredby r ON p.referred_by = r.referredbyid WHERE p.patientid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing referral - Flow Sheet");
  }
  $sql = "SELECT * FROM dental_patients p JOIN dental_contact i ON p.p_m_ins_co = i.contactid WHERE p.patientid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing insurance company - Patient Info");
  }

  $sql = "SELECT * FROM dental_patients p JOIN dental_users d ON p.docid = d.userid WHERE p.patientid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing doctor");
  }

  $sql = "SELECT p_m_dss_file FROM dental_patients p WHERE p.patientid=".$pid;
  $my = mysql_query($sql);
  $m = mysql_fetch_row($my);
  if( $m[0]!=1 ){
    array_push($errors, "Primary DSS filing insurance not selected - Patient Info");
  }

  $sql = "SELECT * FROM dental_patients p JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' WHERE p.patientid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing transaction code E0486");
  }

$sql = "SELECT * FROM dental_summ_sleeplab p WHERE p.patiendid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing sleep lab");
  }
/*  $sql = "SELECT * FROM dental_patients p JOIN dental_q_page2 q2 ON p.patientid = q2.patientid WHERE p.patientid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing questionnaire page 2");
  }
*/


$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$pid."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
if(mysql_num_rows($flowresult) <= 0){
  array_push($errors, "Does not have flowsheet");
}else{
    $flow = mysql_fetch_array($flowresult);
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $clinnotereq = $flow['clinnotereq'];
    $clinnoterec = $flow['clinnoterec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];
    $insverbendate2 = $flow['insverbendate2'];
}


    if($insinforec == '' || $rxreq == '' || $rxrec == '' || $lomnreq == '' || $lomnrec == '' || $clinnotereq == '' || $clinnoterec == ''){
       array_push($errors, "Medical insurance dates are not filled out - Flow Sheet");
     }



return $errors;
}


function list_preauth_errors( $pid ){
$errors = preauth_errors($pid);
if(count($errors)>0){
$e_text = 'Unable to request verification of benefits:\n';
foreach($errors as $e){
$e_text .= '\n'.$e;
}
}
return $e_text;
}


?>
