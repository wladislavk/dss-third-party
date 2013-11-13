<?php

function create_hst( $pid ){

  $sql = "SELECT u.* FROM 
                dental_patients p 
                JOIN dental_users u ON p.docid = u.userid 
                WHERE p.patientid = '".mysql_real_escape_string($pid)."' AND
			u.npi != '' AND u.npi IS NOT NULL AND
			u.tax_id_or_ssn != '' AND u.tax_id_or_ssn IS NOT NULL AND
			(u.ssn = 1 OR u.ein = 1) 
			";
  $q = mysql_query($sql);
  $user_info = (mysql_num_rows($q)>0);

  $sql = "SELECT "
       . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
       . "  p.p_m_ins_co, p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
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


  $thorton_sql = "SELECT * FROM dental_thorton WHERE patientid = '".mysql_real_escape_string($pid)."'";
  $thorton_q = mysql_query($thorton_sql);
  $thorton = mysql_fetch_assoc($thorton_q);

  $sleepstudies = "SELECT diagnosis FROM dental_summ_sleeplab WHERE (diagnosis IS NOT NULL && diagnosis != '') AND filename IS NOT NULL AND patiendid = '".$pid."' ORDER BY id DESC LIMIT 1;";
  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $diagnosis = $d['diagnosis'];
  //print_r($my_array);exit;
  $sd = date('Y-m-d H:i:s');
  $sql = "INSERT INTO dental_hst ("
       . "  patient_id, doc_id, user_id, ins_co_id, patient_ins_group_id, "
       . "  patient_ins_id, patient_firstname, patient_lastname, patient_add1, "
       . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
       . "  insured_firstname, insured_lastname, insured_dob, "
       . "  snore_1, snore_2, snore_3, snore_4, snore_5, "
       . "  status, adddate, ip_address "
       . ") VALUES ("
       . "  " . $pid . ", "
       . "  " . mysql_real_escape_string($my_array['doc_id']) . ", "
       . "  '" . mysql_real_escape_string($_SESSION['userid']) . "', "
       . "  '" . mysql_real_escape_string($my_array['p_m_ins_co']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_ins_group_id']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_ins_id']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_firstname']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_lastname']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_add1']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_add2']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_city']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_state']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_zip']) . "', "
       . "  '" . mysql_real_escape_string($my_array['patient_dob']) . "', "
       . "  '" . mysql_real_escape_string($my_array['insured_first_name']) . "', "
       . "  '" . mysql_real_escape_string($my_array['insured_last_name']) . "', "
       . "  '" . mysql_real_escape_string($my_array['insured_dob']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_1']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_2']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_3']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_4']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_5']) . "', "
       . DSS_HST_PENDING . ", "
       . "  now(), "
       . "  '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' " 
       . ")";
  $hst = mysql_query($sql);
  $hst_id = mysql_insert_id();

$sql = "select * from dental_q_sleep where patientid='".$pid."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_sleepid = st($myarray['q_sleepid']);
$epworthid = st($myarray['epworthid']);
$analysis = st($myarray['analysis']);

if($epworthid <> '')
{
        $epworth_arr1 = split('~',$epworthid);

        foreach($epworth_arr1 as $i => $val)
        {
                $epworth_arr2 = explode('|',$val);

                $epid[$i] = $epworth_arr2[0];
                $epseq[$i] = $epworth_arr2[1];
        }
}


  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysql_query($epworth_sql);
  $epworth_number = mysql_num_rows($epworth_my);
  while($epworth_myarray = mysql_fetch_array($epworth_my))
  { 
    if(@array_search($epworth_myarray['epworthid'],$epid) === false)
    {
      $chk = '';
    }
    else
    {
      $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
    }

    if($chk != ''){
      $hst_sql = "INSERT INTO dental_hst_epworth SET
			hst_id = '".mysql_real_escape_string($hst_id)."',
			epworth_id = '".mysql_real_escape_string($epworth_myarray['epworthid'])."',
			response = '".mysql_real_escape_string($chk)."',
			adddate = now(),
			ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
      mysql_query($hst_sql);
    }
  }

  return $hst;
}



?>
