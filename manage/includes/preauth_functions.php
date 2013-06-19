<?php


function claim_errors( $pid, $medicare = false ){
  $errors = array();

/*
   $sql = "SELECT * FROM dental_patients p WHERE p.referred_source IS NOT NULL AND p.referred_source != '' AND p.patientid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing referral - Flow Sheet");
  }
*/
 if($medicare){
  $sql = "SELECT p_m_ins_type FROM dental_patients p WHERE p.patientid=".$pid." LIMIT 1";
  $my = mysql_query($sql);
  $row = mysql_fetch_array($my);
  if($row['p_m_ins_type']==1){
    array_push($errors, "patient has Medicare Insurance. You can change patient\'s insurance type in the Patient Info section");
  }

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
  if( $m[0]!=1 && $_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE ){
    array_push($errors, "Primary DSS filing insurance not selected - Patient Info");
  }

  $sql = "SELECT * FROM dental_patients p JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' WHERE p.patientid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing transaction code E0486");
  }


$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

  $result = mysql_query($sleepstudies);
  $num = mysql_num_rows($result);
  if( $num <= 0 ){
    array_push($errors, "Summary Sheet - Missing completed sleep study");
  }else{ 


$p_sql = "SELECT p_m_ins_type FROM dental_patients WHERE patientid='".$pid."';";
$p_q = mysql_query($p_sql);
$p = mysql_fetch_assoc($p_q);
if($p['p_m_ins_type']==1){

$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

  $result = mysql_query($sleepstudies);
  $num = mysql_num_rows($result);
  if( $num <= 0 ){
    array_push($errors, "Flowsheet - Sleep Study: Diagnosing Phys. and Diagnosing NPI# are required for Medicare claims.");
  }
}
}

/*
$sql = "SELECT * FROM dental_summ_sleeplab p WHERE p.patiendid=".$pid;
  $my = mysql_query($sql);
  $num = mysql_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing sleep lab");
  }
*/
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


    if($rxrec == '' || $lomnrec == '' ){
       array_push($errors, "Insurance - Rx and LOMN not completed");
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


function create_vob( $pid ){

  $sql = "SELECT "
       . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
       . "  p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
       . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
       . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
       . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
       . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
       . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
       . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
       . "  d.userid as 'doc_id', p.home_phone as 'patient_phone'  "
       . "FROM "
       . "  dental_patients p  "
       . "  LEFT JOIN dental_contact r ON p.referred_by = r.contactid  "
       . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
       . "  JOIN dental_users d ON p.docid = d.userid "
       . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
       . "  LEFT JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
       . "WHERE "
       . "  p.patientid = ".$pid;
  $my = mysql_query($sql);
  $my_array = mysql_fetch_array($my);

  $sleepstudies = "SELECT diagnosis FROM dental_summ_sleeplab WHERE (diagnosis IS NOT NULL && diagnosis != '') AND filename IS NOT NULL AND patiendid = '".$pid."' ORDER BY id DESC LIMIT 1;";
  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $diagnosis = $d['diagnosis'];
  //print_r($my_array);exit;
  $sd = date('Y-m-d H:i:s');
  $sql = "INSERT INTO dental_insurance_preauth ("
       . "  patient_id, doc_id, ins_co, ins_rank, ins_phone, patient_ins_group_id, "
       . "  patient_ins_id, patient_firstname, patient_lastname, patient_phone, patient_add1, "
       . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
       . "  insured_first_name, insured_last_name, insured_dob, doc_npi, referring_doc_npi, "
       . "  trxn_code_amount, diagnosis_code, doc_medicare_npi, doc_tax_id_or_ssn, "
       . "  front_office_request_date, status, userid, viewed "
       . ") VALUES ("
       . "  " . $pid . ", "
       . "  " . mysql_real_escape_string($my_array['doc_id']) . ", "
       . "  '" . mysql_real_escape_string($my_array['ins_co']) . "', "
       . "  '" . mysql_real_escape_string($my_array['ins_rank']) . "', "
       . "  '" . mysql_real_escape_string($my_array['ins_phone']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_ins_group_id']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_ins_id']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_firstname']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_lastname']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_phone']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_add1']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_add2']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_city']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_state']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_zip']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_dob']) . "', "
       . "  '" . mysql_real_escape_string($my_array['insured_first_name']) . "', "
       . "  '" . mysql_real_escape_string($my_array['insured_last_name']) . "', "
       . "  '" . mysql_real_escape_string($my_array['insured_dob']) . "', "
       . "  '" . mysql_real_escape_string($my_array['doc_npi']) . "', "
       . "  '" . mysql_real_escape_string($my_array['referring_doc_npi']) . "', "
       . "  '" . mysql_real_escape_string($my_array['trxn_code_amount']) . "', "
       . "  '" . mysql_real_escape_string($diagnosis) . "', "
       . "  '" . mysql_real_escape_string($my_array['doc_medicare_npi']) . "', "
       . "  '" . mysql_real_escape_string($my_array['doc_tax_id_or_ssn']) . "', "
       . "  '" . mysql_real_escape_string($sd) . "', "
       . DSS_PREAUTH_PENDING . ", "
       . "  '" . mysql_real_escape_string($_SESSION['userid']) . "', "
       . 1
       . ")";
  return mysql_query($sql);
}



?>
