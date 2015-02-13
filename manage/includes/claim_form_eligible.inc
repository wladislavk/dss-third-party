<?php
$status_sql = "SELECT status FROM dental_insurance
                WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'
                        AND patientid='".mysql_real_escape_string($_GET['pid'])."'";
$status_q = mysql_query($status_sql);
$status_r = mysql_fetch_assoc($status_q);
$status = $status_r['status'];
$is_sent = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? true : false;
$is_pending = ($status == DSS_CLAIM_PENDING || $status == DSS_CLAIM_SEC_PENDING) ? true : false;
$is_pri_pending = ($status == DSS_CLAIM_PENDING) ? true : false;
$is_sec_pending = ($status == DSS_CLAIM_SEC_PENDING) ? true : false;
$is_disputed = ($status == DSS_CLAIM_DISPUTE || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_PATIENT_DISPUTE || $status == DSS_CLAIM_SEC_PATIENT_DISPUTE) ? true : false;
$is_rejected = ($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED) ? true : false;
$is_secondary = ($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_SENT || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_SEC_REJECTED);

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);
$docid = $pat_myarray['docid'];
if($is_pri_pending){
// Load patient info from dental_patients table using pid on query string
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
$insurancetype = st($pat_myarray['p_m_ins_type']);
$other_insurancetype = $pat_myarray['s_m_ins_type'];
$insured_firstname = st($pat_myarray['p_m_partyfname']);
$insured_lastname = st($pat_myarray['p_m_partylname']);
$insured_middle = st($pat_myarray['p_m_partymname']);
$other_insured_firstname = st($pat_myarray['s_m_partyfname']);
$other_insured_lastname = st($pat_myarray['s_m_partylname']);
$other_insured_middle = st($pat_myarray['s_m_partymname']);
$insured_id_number = st($pat_myarray['p_m_ins_id']);
$insured_dob = st($pat_myarray['ins_dob']);
$p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
$other_insured_dob = st($pat_myarray['ins2_dob']);
$insured_insurance_plan = st($pat_myarray['p_m_ins_plan']);
$other_insured_insurance_plan = st($pat_myarray['s_m_ins_plan']);
$insured_policy_group_feca = st($pat_myarray['p_m_ins_grp']);
$other_insured_policy_group_feca = st($pat_myarray['s_m_ins_grp']);
$referredby = st($pat_myarray['referred_by']); 
$referred_source = st($pat_myarray['referred_source']);
$docid = $pat_myarray['docid'];
// if patient does not have an id, redirect to manage_patient.php to address the issue
if ($pat_myarray['patientid'] == '') {
    print '<script type="text/javascript">';
    print '  window.location="manage_patient.php";';
    print '</script>';

	die(); // already did a javascript redirect...just die
}
}
$ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
// In the case where we have first come to this page, load the claim form
// info from dental_insurance and place them into variables.
$sql = "select * from dental_insurance where insuranceid='".$_GET['insid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);
$dent_rows = mysql_num_rows($my);
$insuranceid = st($myarray['insuranceid']);
$orig_claim_id = st($myarray['primary_claim_id']);
$p_m_eligible_payer_id = $myarray['p_m_eligible_payer_id'];
$p_m_eligible_payer_name = $myarray['p_m_eligible_payer_name'];
$s_m_eligible_payer_id = $myarray['s_m_eligible_payer_id'];
$s_m_eligible_payer_name = $myarray['s_m_eligible_payer_name'];
if(!$is_pri_pending){
$pica1 = st($myarray['pica1']);
$pica2 = st($myarray['pica2']);
$pica3 = st($myarray['pica3']);
$p_m_dss_file = $pat_myarray['p_m_dss_file'];
$s_m_dss_file = $pat_myarray['s_m_dss_file'];
$patient_lastname = st($myarray['patient_lastname']);
$patient_firstname = st($myarray['patient_firstname']);
$patient_middle = st($myarray['patient_middle']);
$patient_dob = st($myarray['patient_dob']);
$patient_sex = st($myarray['patient_sex']);
if($_GET['instype']==2){
  $insurancetype = st($myarray['other_insurance_type']);
  $other_insurancetype = $myarray['insurance_type'];
  $other_insured_firstname = st($myarray['insured_firstname']);
  $other_insured_lastname = st($myarray['insured_lastname']);
  $other_insured_middle = st($myarray['insured_middle']);
  $other_insured_dob = st($myarray['insured_dob']);
  $other_insured_sex = st($myarray['insured_sex']);
  $other_insured_insurance_plan = st($myarray['insured_insurance_plan']);
  $other_insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
  $insured_id_number = st($myarray['other_insured_id_number']);
  $insured_firstname = st($myarray['other_insured_firstname']);
  $insured_middle = st($myarray['other_insured_middle']);
  $insured_lastname = st($myarray['other_insured_lastname']);
  $insured_dob = st($myarray['other_insured_dob']);
  $insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
  $insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
  $insured_address = st($myarray['other_insured_address']);
  $insured_city = st($myarray['other_insured_city']);
  $insured_state = st($myarray['other_insured_state']);
  $insured_zip = st($myarray['other_insured_zip']);
  $insured_phone_code = st($myarray['insured_phone_code']);
  $insured_phone = st($myarray['insured_phone']);
  $insured_sex = st($myarray['other_insured_sex']);
  $patient_relation_insured = st($myarray['patient_relation_other_insured']);
}else{
  $insurancetype = st($myarray['insurance_type']);
  $other_insurancetype = $myarray['other_insurance_type'];
  $other_insured_firstname = st($myarray['other_insured_firstname']);
  $other_insured_lastname = st($myarray['other_insured_lastname']);
  $other_insured_middle = st($myarray['other_insured_middle']);
  $other_insured_dob = st($myarray['other_insured_dob']);
  $other_insured_sex = st($myarray['other_insured_sex']);
  $other_insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
  $other_insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
  $insured_id_number = st($myarray['insured_id_number']);
  $insured_firstname = st($myarray['insured_firstname']);
  $insured_middle = st($myarray['insured_middle']);
  $insured_lastname = st($myarray['insured_lastname']);
  $insured_dob = st($myarray['insured_dob']);
  $insured_insurance_plan = st($myarray['insured_insurance_plan']);
  $insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
  $insured_address = st($myarray['insured_address']);
  $insured_city = st($myarray['insured_city']);
  $insured_state = st($myarray['insured_state']);
  $insured_zip = st($myarray['insured_zip']);
  $insured_phone_code = st($myarray['insured_phone_code']);
  $insured_phone = st($myarray['insured_phone']);
  $insured_sex = st($myarray['insured_sex']);
  $patient_relation_insured = st($myarray['patient_relation_insured']);
}
$patient_address = st($myarray['patient_address']);
$patient_city = st($myarray['patient_city']);
$patient_state = st($myarray['patient_state']);
$patient_status = st($myarray['patient_status']);
$patient_status_array = split('~',$patient_status);
$patient_zip = st($myarray['patient_zip']);
$patient_phone_code = st($myarray['patient_phone_code']);
$patient_phone = st($myarray['patient_phone']);
$employment = st($myarray['employment']);
$auto_accident = st($myarray['auto_accident']);
$auto_accident_place = st($myarray['auto_accident_place']);
$other_accident = st($myarray['other_accident']);
$insured_employer_school_name = st($myarray['insured_employer_school_name']);
$other_insured_employer_school_name = st($myarray['other_insured_employer_school_name']);
$reserved_local_use = st($myarray['reserved_local_use']);
$another_plan = st($myarray['another_plan']);
$patient_signature = st($myarray['patient_signature']);
$patient_signed_date = st($myarray['patient_signed_date']);
$insured_signature = st($myarray['insured_signature']);
$date_current = st($myarray['date_current']);
$date_same_illness = st($myarray['date_same_illness']);
$unable_date_from = st($myarray['unable_date_from']);
$unable_date_to = st($myarray['unable_date_to']);
$referring_provider = st($myarray['referring_provider']);
$field_17a_dd = st($myarray['field_17a_dd']);
$field_17a = st($myarray['field_17a']);
$field_17b = st($myarray['field_17b']);
$diagnosising_npi = st($myarray['field_17b']);
$hospitalization_date_from = st($myarray['hospitalization_date_from']);
$hospitalization_date_to = st($myarray['hospitalization_date_to']);
$reserved_local_use1 = st($myarray['reserved_local_use1']);
$outside_lab = st($myarray['outside_lab']);
$s_charges = st($myarray['s_charges']);
$diagnosis_1 = st($myarray['diagnosis_1']);
$diagnosis_2 = st($myarray['diagnosis_2']);
$diagnosis_3 = st($myarray['diagnosis_3']);
$diagnosis_4 = st($myarray['diagnosis_4']);
$icd_ind = st($myarray['icd_ind']);
$diagnosis_a = st($myarray['diagnosis_a']);
$diagnosis_b = st($myarray['diagnosis_b']);
$diagnosis_c = st($myarray['diagnosis_c']);
$diagnosis_d = st($myarray['diagnosis_d']);
$diagnosis_e = st($myarray['diagnosis_e']);
$diagnosis_f = st($myarray['diagnosis_f']);
$diagnosis_g = st($myarray['diagnosis_g']);
$diagnosis_h = st($myarray['diagnosis_h']);
$diagnosis_i = st($myarray['diagnosis_i']);
$diagnosis_j = st($myarray['diagnosis_j']);
$diagnosis_k = st($myarray['diagnosis_k']);
$diagnosis_l = st($myarray['diagnosis_l']);

$medicaid_resubmission_code = st($myarray['medicaid_resubmission_code']);
$original_ref_no = st($myarray['original_ref_no']);
$prior_authorization_number = st($myarray['prior_authorization_number']);
$service_date1_from = st($myarray['service_date1_from']);
$service_date1_to = st($myarray['service_date1_to']);
$place_of_service1 = st($myarray['place_of_service1']);
$emg1 = st($myarray['emg1']);
$cpt_hcpcs1 = st($myarray['cpt_hcpcs1']);
$modifier1_1 = st($myarray['modifier1_1']);
$modifier1_2 = st($myarray['modifier1_2']);
$modifier1_3 = st($myarray['modifier1_3']);
$modifier1_4 = st($myarray['modifier1_4']);
$diagnosis_pointer1 = st($myarray['diagnosis_pointer1']);
$s_charges1_1 = st($myarray['s_charges1_1']);
$s_charges1_2 = st($myarray['s_charges1_2']);
$days_or_units1 = st($myarray['days_or_units1']);
$epsdt_family_plan1 = st($myarray['epsdt_family_plan1']);
$id_qua1 = st($myarray['id_qua1']);
$rendering_provider_id1 = st($myarray['rendering_provider_id1']);
$service_date2_from = st($myarray['service_date2_from']);
$service_date2_to = st($myarray['service_date2_to']);
$place_of_service2 = st($myarray['place_of_service2']);
$emg2 = st($myarray['emg2']);
$cpt_hcpcs2 = st($myarray['cpt_hcpcs2']);
$modifier2_1 = st($myarray['modifier2_1']);
$modifier2_2 = st($myarray['modifier2_2']);
$modifier2_3 = st($myarray['modifier2_3']);
$modifier2_4 = st($myarray['modifier2_4']);
$diagnosis_pointer2 = st($myarray['diagnosis_pointer2']);
$s_charges2_1 = st($myarray['s_charges2_1']);
$s_charges2_2 = st($myarray['s_charges2_2']);
$days_or_units2 = st($myarray['days_or_units2']);
$epsdt_family_plan2 = st($myarray['epsdt_family_plan2']);
$id_qua2 = st($myarray['id_qua2']);
$rendering_provider_id2 = st($myarray['rendering_provider_id2']);
$service_date3_from = st($myarray['service_date3_from']);
$service_date3_to = st($myarray['service_date3_to']);
$place_of_service3 = st($myarray['place_of_service3']);
$emg3 = st($myarray['emg3']);
$cpt_hcpcs3 = st($myarray['cpt_hcpcs3']);
$modifier3_1 = st($myarray['modifier3_1']);
$modifier3_2 = st($myarray['modifier3_2']);
$modifier3_3 = st($myarray['modifier3_3']);
$modifier3_4 = st($myarray['modifier3_4']);
$diagnosis_pointer3 = st($myarray['diagnosis_pointer3']);
$s_charges3_1 = st($myarray['s_charges3_1']);
$s_charges3_2 = st($myarray['s_charges3_2']);
$days_or_units3 = st($myarray['days_or_units3']);
$epsdt_family_plan3 = st($myarray['epsdt_family_plan3']);
$id_qua3 = st($myarray['id_qua3']);
$rendering_provider_id3 = st($myarray['rendering_provider_id3']);
$service_date4_from = st($myarray['service_date4_from']);
$service_date4_to = st($myarray['service_date4_to']);
$place_of_service4 = st($myarray['place_of_service4']);
$emg4 = st($myarray['emg4']);
$cpt_hcpcs4 = st($myarray['cpt_hcpcs4']);
$modifier4_1 = st($myarray['modifier4_1']);
$modifier4_2 = st($myarray['modifier4_2']);
$modifier4_3 = st($myarray['modifier4_3']);
$modifier4_4 = st($myarray['modifier4_4']);
$diagnosis_pointer4 = st($myarray['diagnosis_pointer4']);
$s_charges4_1 = st($myarray['s_charges4_1']);
$s_charges4_2 = st($myarray['s_charges4_2']);
$days_or_units4 = st($myarray['days_or_units4']);
$epsdt_family_plan4 = st($myarray['epsdt_family_plan4']);
$id_qua4 = st($myarray['id_qua4']);
$rendering_provider_id4 = st($myarray['rendering_provider_id4']);
$service_date5_from = st($myarray['service_date5_from']);
$service_date5_to = st($myarray['service_date5_to']);
$place_of_service5 = st($myarray['place_of_service5']);
$emg5 = st($myarray['emg5']);
$cpt_hcpcs5 = st($myarray['cpt_hcpcs5']);
$modifier5_1 = st($myarray['modifier5_1']);
$modifier5_2 = st($myarray['modifier5_2']);
$modifier5_3 = st($myarray['modifier5_3']);
$modifier5_4 = st($myarray['modifier5_4']);
$diagnosis_pointer5 = st($myarray['diagnosis_pointer5']);
$s_charges5_1 = st($myarray['s_charges5_1']);
$s_charges5_2 = st($myarray['s_charges5_2']);
$days_or_units5 = st($myarray['days_or_units5']);
$epsdt_family_plan5 = st($myarray['epsdt_family_plan5']);
$id_qua5 = st($myarray['id_qua5']);
$rendering_provider_id5 = st($myarray['rendering_provider_id5']);
$service_date6_from = st($myarray['service_date6_from']);
$service_date6_to = st($myarray['service_date6_to']);
$place_of_service6 = st($myarray['place_of_service6']);
$emg6 = st($myarray['emg6']);
$cpt_hcpcs6 = st($myarray['cpt_hcpcs6']);
$modifier6_1 = st($myarray['modifier6_1']);
$modifier6_2 = st($myarray['modifier6_2']);
$modifier6_3 = st($myarray['modifier6_3']);
$modifier6_4 = st($myarray['modifier6_4']);
$diagnosis_pointer6 = st($myarray['diagnosis_pointer6']);
$s_charges6_1 = st($myarray['s_charges6_1']);
$s_charges6_2 = st($myarray['s_charges6_2']);
$days_or_units6 = st($myarray['days_or_units6']);
$epsdt_family_plan6 = st($myarray['epsdt_family_plan6']);
$id_qua6 = st($myarray['id_qua6']);
$rendering_provider_id6 = st($myarray['rendering_provider_id6']);
$federal_tax_id_number = st($myarray['federal_tax_id_number']);
$ssn = st($myarray['ssn']);
$ein = st($myarray['ein']);
$patient_account_no = st($myarray['patient_account_no']);
$accept_assignment = st($myarray['accept_assignment']);
$total_charge = st($myarray['total_charge']);
$amount_paid = st($myarray['amount_paid']);
$balance_due = st($myarray['balance_due']);
$signature_physician = st($myarray['signature_physician']);
$physician_signed_date = st(($myarray['physician_signed_date']!='')?$myarray['physician_signed_date']:date('m/d/Y'));
$service_facility_info_name = st($myarray['service_facility_info_name']);
$service_facility_info_address = st($myarray['service_facility_info_address']);
$service_facility_info_city = st($myarray['service_facility_info_city']);
$service_info_a = st($myarray['service_info_a']);
$service_info_dd = st($myarray['service_info_dd']);
$service_info_b_other = st($myarray['service_info_b_other']);
$billing_provider_phone_code = st($myarray['billing_provider_phone_code']);
$billing_provider_phone = st($myarray['billing_provider_phone']);
$billing_provider_name = st($myarray['billing_provider_name']);
$billing_provider_address = st($myarray['billing_provider_address']);
$billing_provider_city = st($myarray['billing_provider_city']);
$billing_provider_a = st($myarray['billing_provider_a']);
$billing_provider_dd = st($myarray['billing_provider_dd']);
$billing_provider_b_other = st($myarray['billing_provider_b_other']);
$reject_reason = st($myarray['reject_reason']);
$status = st($myarray['status']);
}
if($pat_myarray['p_m_ins_type']!=1 && $pat_myarray['has_s_m_ins'] == 'Yes' && $pat_myarray['p_m_dss_file'] == 1 && $pat_myarray['s_m_dss_file'] ==1){
  $another_plan = 'YES';
}else{
  $another_plan = 'NO';
}
if($is_pri_pending){
  $insured_sex = $pat_myarray['p_m_gender'];
  $other_insured_sex = $pat_myarray['s_m_gender'];
  $patient_sex = $pat_myarray['gender'];
  $patient_firstname = $pat_myarray['firstname'];
	$patient_lastname = $pat_myarray['lastname'];
	$patient_middle = $pat_myarray['middlename'];
	$patient_firstname = $pat_myarray['firstname'];
	$patient_address = $pat_myarray['add1'];
	$patient_city = $pat_myarray['city'];
	$patient_state = $pat_myarray['state'];
	$patient_zip = $pat_myarray['zip'];
	$patient_dob = $pat_myarray['dob'];
	if($pat_myarray['p_m_ins_ass']=='Yes'){
	  $insured_signature = 1;
	}
	$patient_signature = 1;
	$signature_physician = "Signature on File";
	$patient_signed_date = date('m/d/Y', strtotime($pat_myarray['adddate']));
        $physician_signed_date = date('m/d/Y');	
	$patient_phone_code = split_phone($pat_myarray['home_phone'], true);
	$patient_phone = split_phone($pat_myarray['home_phone'], false);
	$insured_phone_code = split_phone($pat_myarray['home_phone'], true);
	$insured_phone = split_phone($pat_myarray['home_phone'], false);
	$patient_status = $pat_myarray['marital_status'];	
	$insured_id_number = $pat_myarray['p_m_ins_id'];
	$insured_address = $myarray['insured_address'];
	$insured_city = $myarray['insured_city'];
	$insured_state = $myarray['insured_state'];
	$insured_zip = $myarray['insured_zip'];
	$insured_dob = $pat_myarray['ins_dob'];	
	$patient_relation_insured = $pat_myarray['p_m_relation'];
	$insured_employer_school_name = $pat_myarray['employer'];
	if($pat_myarray['p_m_ins_type']==1){
	  $insured_policy_group_feca = "NONE";
          $insured_insurance_plan = '';
	  $insured_employer_school_name = '';
	}else{
	  $insured_policy_group_feca = $pat_myarray['p_m_ins_grp'];
	  $insured_insurance_plan = $pat_myarray['p_m_ins_plan'];	
	}
$sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."' ORDER BY id DESC LIMIT 1;";

  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $diagnosis_1 = $d['diagnosis'];

$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."' ORDER BY id DESC LIMIT 1;";

  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $referring_provider = $d['diagnosising_doc'];
  $diagnosising_npi = $d['diagnosising_npi'];
if($insurancetype!=1){
  $referring_provider = '';
  $diagnosising_npi = '';

}

$accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
//if ($dent_rows <= 0) {
    $accept_assignment = $accept_assignmentnew;
//}
}
// If claim doesn't yet have a preauth number, try to load it
// from the patient's most recently completed preauth.
if (empty($prior_authorization_number)) {
    $sql = "SELECT "
         . "  * "
         . "FROM "
         . "  dental_insurance_preauth "
         . "WHERE "
         . "  patient_id = '" . $_GET['pid'] . "' "
         . "  AND status = " . DSS_PREAUTH_COMPLETE . " "
         . "ORDER BY "
         . "  date_completed desc "
         . "LIMIT 1";
    $my = mysql_query($sql);
    $num_rows = mysql_num_rows($my);
    if ($num_rows > 0) {
        $myarray = mysql_fetch_array($my);
        $prior_authorization_number = $myarray['pre_auth_num'];
    }
}



 $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
        $prod_q = mysql_query($prod_s);
        $prod_r = mysql_fetch_assoc($prod_q);
        $claim_producer = $prod_r['producer'];

                      $getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
                      $userquery = mysql_query($getuserinfo);
                      if($userinfo = mysql_fetch_array($userquery)){
                        $phone = $userinfo['phone'];
                        $practice = $userinfo['practice'];
                        $address = $userinfo['address'];
                        $city = $userinfo['city'];
                        $state = $userinfo['state'];
                        $zip = $userinfo['zip'];
                        $npi = $userinfo['npi'];
                        $medicare_npi = $userinfo['medicare_npi'];
                      }
                      $getdocinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".$docid."'";
                      $docquery = mysql_query($getdocinfo);
                      $docinfo = mysql_fetch_array($docquery);
                        if($phone == ""){ $phone = $docinfo['phone']; }
                        if($practice == ""){ $practice = $docinfo['practice']; }
                        if($address == ""){ $address = $docinfo['address']; }
                        if($city == ""){ $city = $docinfo['city']; }
                        if($state == ""){ $state = $docinfo['state']; }
                        if($zip == ""){ $zip = $docinfo['zip']; }
                        if($npi == ""){ $npi = $docinfo['npi']; }
                        if($medicare_npi == ""){ $medicare_npi = $docinfo['medicare_npi']; }

                        if($docinfo['use_service_npi']==1){
                          $service_npi = $docinfo['service_npi'];
                          $service_practice = $docinfo['service_name'];
                          $service_address = $docinfo['service_address'];
                          $service_city = $docinfo['service_city'];
                          $service_state = $docinfo['service_state'];
                          $service_zip = $docinfo['service_zip'];
                          $service_medicare_npi = $docinfo['service_medicare_npi'];
                        }else{
                          $service_npi = $npi;
                          $service_practice = $practice;
                          $service_address = $address;
                          $service_city = $city;
                          $service_state = $state;
                          $service_zip = $zip;
                          $service_medicare_npi = $medicare_npi;
                        }

                        if($insurancetype == 1){
                          $service_npi = "";
                          $service_practice = "";
                          $service_address = "";
                          $service_city = "";
                          $service_state = "";
                          $service_zip = "";
                          $service_medicare_npi = "";
                        }





?>
<html>
<head>

        <!-- Jquery -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <!-- Jquery UI-->

        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

        <script src="https://eligibleapi.com/js/eligible-claim-1500-2014.min.js"></script>

        <link href="https://eligibleapi.com/css/eligible-claim-1500-2014.min.css" rel="stylesheet">

        <script type="text/javascript"> window.eligiblePublicKey="-a7xWM5Kn7V9sciZtT4zV92dlpp_RWvnpHS-"</script>

	<style type="text/css">
		.claim.form-submit{ padding:5px 15px; cursor: pointer;}

	</style>


    </head>

    <body>
<div style="width:250px;float:left;">
Instructions to E-File: Enter electronic Payer ID or Name in Box 1.  Verify all claim details.  Click “Submit” on bottom left of claim to e-file your claim.
</div>
<input type="button" onclick="change_form();" value="Switch to Paper File" style="float:right;margin-right:20px;" />
<?php if ($is_front_office) { ?>
 <input type="button" onclick="window.location='view_claim.php?claimid=<?=$_GET['insid'];?>&pid=<?=$_GET['pid']?>'; return false;" value="Back to Insurance Page" style="float:right;">
<?php } else if ($is_back_office) { ?>
 <input type="button" onclick="window.location='manage_claims.php'; return false;" value="Back to Insurance Page" style="float:right;">
<?php } ?>
<?php
if ($is_back_office){
?>
                <input style="float:right;" type="button" class="print-button" onclick="window.location='claim_notes.php?id=<?= $_GET['insid']; ?>&pid=<?= $_GET['pid']; ?>'" value="View Notes" />
<?php
}
?>



<?php
  if($is_rejected){
  ?> <div style="clear:both;margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">  <?php
  $r_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysql_real_escape_string($_GET['insid'])."' ORDER BY adddate DESC LIMIT 1";
$r_my = mysql_query($r_sql);
$r = mysql_fetch_assoc($r_my);
if($r['reference_id']){
    $w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysql_real_escape_string($r['reference_id'])."' ORDER BY adddate DESC LIMIT 1";
    $w_q = mysql_query($w_sql);
    $w_r = mysql_fetch_assoc($w_q);
    if($w_r['response']!=''){
                          ?><h3><?= $w_r['event_type']; ?> on
                <?= $w_r['adddate']; ?></h3>
<?php $p = json_decode($w_r['response']); ?>
                                <p>Category: <?= $p->{"details"}->{"codes"}->{"category_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"category_label"}; ?><br />
                                Status: <?= $p->{"details"}->{"codes"}->{"status_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"status_label"}; ?>
                                </p>

                        <?php
    }
}
if(!$r['reference_id'] || !$w_r['response']){
        ?>
                <h3>Claim Electronically filed on
                <?= $r['adddate']; ?></h3>
                        <?php
                        $d = json_decode($r['response']);
                        $success = $d->{"success"};
                        if($success=="true"){
                                ?><p><strong>Success Response:</strong><br /><?php
                        }else{
                                ?><p><strong>Error Response:</strong><br /><?php
                                        $errors = $d->{"errors"}->{"messages"};
                                        foreach($errors as $error){
                                          echo $error."<br />";
                                        }
                        }
                        ?>
                </p>
<?php } ?>
        </div>

<?php
}
?>
<?php if($is_secondary){ ?>
        <h4>Secondary Claim (<a href="insurance_claim_eligible.php?insid=<?php echo $orig_claim_id; ?>&pid=<?php echo $_GET['pid']; ?>">Primary is <?php echo $orig_claim_id; ?></a>)</h4>
<?php }else{ 
  $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='".mysql_real_escape_string($_GET['insid'])."'";
  $sec_q = mysql_query($sec_sql);
  $sec_r = mysql_fetch_assoc($sec_q);
?>
        <h4>Primary Claim
        <?php if(mysql_num_rows($sec_q)){ ?>
                (<a href="insurance_claim_eligible.php?insid=<?php echo $sec_r['insuranceid']; ?>&pid=<?php echo $_GET['pid']; ?>">Secondary is <?php echo $sec_r['insuranceid']; ?></a>)
        <?php } ?>
        </h4>
<?php } ?>

    <form style="clear:both;" action="claim_handler.php?insid=<?= $_REQUEST['insid']; ?>&pid=<?= $_REQUEST['pid']; ?>" method="POST">

        <div id="eligibleapi-claim-1500-form"></div>

    </form>


<script type="text/javascript">
  $(document).ready( function(){

	//$('#eligibleapi-claim-1500-form .claim.form-submit').clone().appendTo('#eligibleapi-claim-1500-form');

	//alert($("button.eligibleapi.claim.form-submit").length);

                                  <?php
        if(isset($_GET['instype']) && $_GET['instype']==2){
          $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['s_m_ins_co'])."'";
        }else{
          $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['p_m_ins_co'])."'";
        }
        $inscoarray = mysql_query($inscoquery);
        $inscoinfo = mysql_fetch_array($inscoarray);
      ?>

    <?php if($is_secondary){ ?>
      $('input[name="payer[id]"]').val("<?= $s_m_eligible_payer_id;?>");
      $('input[name="payer[name]"]').val("<?= $s_m_eligible_payer_name;?>");
    <?php }else{ ?>
      $('input[name="payer[id]"]').val("<?= $p_m_eligible_payer_id;?>");
      $('input[name="payer[name]"]').val("<?= $p_m_eligible_payer_name;?>");
    <?php } ?>
    $('input[name="payer[address][street_line_1]"]').val("<?= $inscoinfo['add1'];?>");
    $('input[name="payer[address][street_line_2]"]').val("<?= $inscoinfo['add2'];?>");
    $('input[name="payer[address][city]"]').val("<?= $inscoinfo['city'];?>");
    $('input[name="payer[address][state]"]').val("<?= trim($inscoinfo['state']);?>");
    $('input[name="payer[address][zip]"]').val("<?= $inscoinfo['zip'];?>");

    $('input[name="subscriber[id]"]').val("<?= $insured_id_number;?>");

    $('input[name="dependent[last_name]"]').val("<?= $patient_lastname;?>");
    $('input[name="dependent[first_name]"]').val("<?= $patient_firstname;?>");
    $('input[name="dependent[middle_name]"]').val("<?= $patient_middle;?>");
    $('input[name="dependent[dob]"]').val("<?= date('Y-m-d', strtotime(str_replace('-','/',$patient_dob)));?>");
    $('input[name="dependent[gender]"][value="<?= substr($patient_sex,0,1); ?>"]').attr("checked", "checked");
    $('input[name="dependent[address][street_line_1]"]').val("<?= $patient_address;?>");
    $('input[name="dependent[address][city]"]').val("<?= $patient_city;?>");
    $('input[name="dependent[address][state]"]').val("<?= $patient_state;?>");
    $('input[name="dependent[address][zip]"]').val("<?= $patient_zip;?>");
    $('input[name="dependent[phone_number]"]').val("<?= $patient_phone;?>");
	
    <?php if($patient_relation_insured == 'Spouse'){ ?>
      $('input[name="dependent[relationship]"][value="01"]').attr("checked", "checked");
    <?php }elseif($patient_relation_insured == 'Child'){ ?>
      $('input[name="dependent[relationship]"][value="19"]').attr("checked", "checked");
    <?php }elseif($patient_relation_insured == 'Other'){ ?>
      $('input[name="dependent[relationship]"][value="G8"]').attr("checked", "checked");
    <?php } ?>
    $('input[name="subscriber[last_name]"]').val("<?= $insured_lastname;?>");
    $('input[name="subscriber[first_name]"]').val("<?= $insured_firstname;?>");
    $('input[name="subscriber[middle_name]"]').val("<?= $insured_middle;?>");
    $('input[name="subscriber[dob]"]').val("<?= date('Y-m-d', strtotime(str_replace('-','/',$insured_dob)));?>");
    $('input[name="subscriber[gender]"][value="<?= substr($insured_sex,0,1); ?>"]').attr("checked", "checked");
    $('input[name="subscriber[address][street_line_1]"]').val("<?= $insured_address;?>");
    $('input[name="subscriber[address][city]"]').val("<?= $insured_city;?>");
    $('input[name="subscriber[address][state]"]').val("<?= $insured_state;?>");
    $('input[name="subscriber[address][zip]"]').val("<?= $insured_zip;?>");
    $('input[name="subscriber[phone_number]"]').val("<?= $insured_phone;?>");
    $('input[name="subscriber[group_id]"]').val("<?= $insured_policy_group_feca;?>");
    $('input[name="subscriber[group_name]"]').val("<?= $insured_insurance_plan;?>");

    $('input[name="other_payers[0][subscriber][last_name]"]').val("<?= $other_insured_lastname;?>");
    $('input[name="other_payers[0][subscriber][first_name]"]').val("<?= $other_insured_firstname;?>");
    $('input[name="other_payers[0][subscriber][middle_name]"]').val("<?= $other_insured_middle;?>");
    $('input[name="other_payers[0][subscriber][group_id]"]').val("<?= $other_insured_policy_group_feca;?>");
    $('input[name="other_payers[0][subscriber][group_name]"]').val("<?= $other_insured_insurance_plan;?>");

    <?php if($employment == "YES"){ ?>
      $('input[name="claim[related_to_employment]"][value="true"]').attr("checked", "checked");
    <?php }elseif($employment == "NO"){ ?>
      $('input[name="claim[related_to_employment]"][value="false"]').attr("checked", "checked");
    <?php } ?>
    <?php if($auto_accident == "YES"){ ?>
      $('input[name="claim[auto_accident]"][value="true"]').attr("checked", "checked");
    <?php }elseif($auto_accident == "NO"){ ?>
      $('input[name="claim[auto_accident]"][value="false"]').attr("checked", "checked");
    <?php } ?>
    $('input[name="claim[auto_accident_state]"]').val("<?= $auto_accident_place;?>");
    <?php if($other_accident == "YES"){ ?>
      $('input[name="claim[other_accident]"][value="true"]').attr("checked", "checked");
    <?php }elseif($other_accident == "NO"){ ?>
      $('input[name="claim[other_accident]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    <?php if($another_plan == "YES"){ ?>
      $('input[name="claim[other_payer]"][value="true"]').attr("checked", "checked");
    <?php }elseif($another_plan == "NO"){ ?>
      $('input[name="claim[other_payer]"][value="false"]').attr("checked", "checked");
    <?php } ?>



    $('input[name="claim[last_worked_date]"]').val("<?= $unable_date_from; ?>");
    $('input[name="claim[work_return_date]"]').val("<?= $unable_date_to; ?>");
    $('input[name="claim[admission_date]"]').val("<?= $hospitalization_date_from; ?>");
    $('input[name="claim[discharge_date]"]').val("<?= $hospitalization_date_to; ?>");

    $('input[name="referring_provider[first_name]"]').val("<?= substr($referring_provider, 0, strpos($referring_provider,' ')); ?>");
    $('input[name="referring_provider[last_name]"]').val("<?= substr($referring_provider, strpos($referring_provider,' ')); ?>");
    $('input[name="referring_provider[secondary_id]"]').val("<?= $field_17a; ?>");
    $('input[name="referring_provider[npi]"]').val("<?= $diagnosising_npi; ?>");

    <?php if($outside_lab == "YES"){ ?>
      $('input[name="claim[outside_lab]"][value="true"]').attr("checked", "checked");
    <?php }elseif($outside_lab == "NO"){ ?>
      $('input[name="claim[outside_lab]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    $('input[name="claim[original_ref_number]"]').val("<?= $original_ref_no; ?>");
    $('input[name="claim[prior_authorization_number]"]').val("<?= $prior_authorization_number; ?>");
  <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_1)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][1]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");
   <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_2)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][2]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");
   <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_3)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][3]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");
   <?php
$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysql_real_escape_string($diagnosis_4)."'";
     $ins_diag_q = mysql_query($ins_diag_sql);
     $ins_diag = mysql_fetch_assoc($ins_diag_q);
   ?>
    $('input[name="claim[diagnosis_codes][4]"]').val("<?= $ins_diag['ins_diagnosis']; ?>");


  $('input[name="claim[diagnosis_codes][1]"]').val("<?= $diagnosis_a;?>");
  $('input[name="claim[diagnosis_codes][2]"]').val("<?= $diagnosis_b;?>");
  $('input[name="claim[diagnosis_codes][3]"]').val("<?= $diagnosis_c;?>");
  $('input[name="claim[diagnosis_codes][4]"]').val("<?= $diagnosis_d;?>");
  $('input[name="claim[diagnosis_codes][5]"]').val("<?= $diagnosis_e;?>");
  $('input[name="claim[diagnosis_codes][6]"]').val("<?= $diagnosis_f;?>");
  $('input[name="claim[diagnosis_codes][7]"]').val("<?= $diagnosis_g;?>");
  $('input[name="claim[diagnosis_codes][8]"]').val("<?= $diagnosis_h;?>");
  $('input[name="claim[diagnosis_codes][9]"]').val("<?= $diagnosis_i;?>");
  $('input[name="claim[diagnosis_codes][10]"]').val("<?= $diagnosis_j;?>");
  $('input[name="claim[diagnosis_codes][11]"]').val("<?= $diagnosis_k?>");
  $('input[name="claim[diagnosis_codes][12]"]').val("<?= $diagnosis_l;?>");


<?php
// Get modifier codes
$mod_sql = "SELECT * FROM dental_modifier_code";
$mod_my = mysql_query($mod_sql);
$mod_array = array();
while ($mod_row = mysql_fetch_array($mod_my)) {
  $mod_array[] = $mod_row;
}

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$sql = "";
if ($is_new_claim) {
  $sql = "SELECT "
       . "  ledger.*, trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_1 as modcode2, trxn_code.days_units as daysorunits, ";
if($insurancetype == '1'){
        $sql .= " user.medicare_npi ";
}else{
        $sql .= " user.npi ";
}
  $sql .= " as 'provider_id', ps.place_service as 'place' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "  JOIN dental_users user ON user.userid = ledger.docid "
       . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
} else {
  $sql = "SELECT "
       . "  ledger.*, ";
if($is_pending || $is_rejected){
  $sql .= "trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_2 as modcode2, trxn_code.days_units as daysorunits, ";
}
if($insurancetype == '1'){
        $sql .= " user.medicare_npi ";
}else{
        $sql .= " user.npi ";
}
  $sql .= "  as 'provider_id', ps.place_service as 'place', ps2.description AS place_description, user.first_name as provider_first_name, user.last_name as provider_last_name "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_users user ON user.userid = ledger.docid "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
       . "  LEFT JOIN dental_place_service ps2 ON ledger.placeofservice = ps2.place_service "
       . "WHERE "
       . "  ledger.primary_claim_id = " . $insuranceid . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = '" . $docid . "' "
       . "  AND trxn_code.docid = '" . $docid . "' "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
}
$query = mysql_query($sql);
// Display ledger trxns
?>
  <?php $li = 0; ?>
  <?php while ($array = mysql_fetch_array($query)) { ?>
  <?php  $pos = ($array['placeofservice']!='')?$array['placeofservice']:$array['place']; ?>
  <?php $dp = ($array['diagnosispointer']!='')?$array['diagnosispointer']:1; ?>
    $('input[name="claim[service_lines][<?=$li;?>][service_date_from]"]').val("<?= date('Y-m-d', strtotime($array['service_date'])); ?>");
    $('input[name="claim[service_lines][<?=$li;?>][service_date_to]"]').val("<?= date('Y-m-d', strtotime($array['service_date'])) ?>");
    $('select[name="claim[service_lines][<?=$li;?>][place_of_service]"]').val("<?= $pos; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][emergency]"]').val("<?= $x; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_code]"]').val("<?php echo $array['transaction_code']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][0]"]').val("<?= $array['modcode']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][1]"]').val("<?= $array['modcode2']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][2]"]').val("<?= $array['modcode3']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][procedure_modifiers][3]"]').val("<?= $array['modcode4']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][diagnosis_code_pointers][<?=$dp-1; ?>]"]').attr("checked","checked");
    $('input[name="claim[service_lines][<?=$li;?>][charge_amount]"]').val("<?= number_format($array['amount'], 2,'.',''); ?>");
    $('input[name="claim[service_lines][<?=$li;?>][units]"]').val("<?= $array['daysorunits']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][rendering_provider][first_name]"]').val("<?= $array['provider_first_name']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][rendering_provider][last_name]"]').val("<?= $array['provider_last_name']; ?>");
    $('input[name="claim[service_lines][<?=$li;?>][rendering_provider][npi]"]').val("<?= $array['provider_id']; ?>");
	


    <?php $li++; ?>
  <?php } 

                                                                                                  if($userinfo['tax_id_or_ssn'] != ''){
                                                                                                        $tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
                                                                                                  }else{
                                                                                                        $tax_id_or_ssn = $docinfo['tax_id_or_ssn'];
                                                                                                  }
                                                                                                  if($userinfo['ssn'] != '' && $userinfo['producer_files']==1){
                                                                                                        $ssn = $userinfo['ssn'];
                                                                                                  }else{
                                                                                                        $ssn = $docinfo['ssn'];
                                                                                                  }
                                                                                                  if($userinfo['ein'] != '' && $userinfo['producer_files']==1){
                                                                                                        $ein = $userinfo['ein'];
                                                                                                  }else{         
                                                                                                        $ein = $docinfo['ein'];
                                                                                                  }

	?>

    <? if($accept_assignment=="Yes"){ ?>
    $('input[name="claim[accept_assignment_code]"][value="A"]').attr("checked", "checked");
    <?php }elseif($accept_assignment=="No"){ ?>
    $('input[name="claim[accept_assignment_code]"][value="C"]').attr("checked", "checked");
    <?php } ?>



    $('input[name="billing_provider[tax_id]"]').val("<?= $tax_id_or_ssn; ?>"); 
    <? if($ssn=="1"){ ?>
    $('input[name="billing_provider[tax_id_type]"][value="SY"]').attr("checked", "checked"); 
    <?php }elseif($ein=="1"){ ?>
    $('input[name="billing_provider[tax_id_type]"][value="EI"]').attr("checked", "checked"); 
    <?php } ?>
    $('input[name="billing_provider[entity]"][value="true"]').click();//attr("checked", "checked"); 
    $('input[name="service_facility[name]"]').val("<?= $service_practice; ?>");
    $('input[name="service_facility[address][street_line_1]"]').val("<?= $service_address; ?>");
    $('input[name="service_facility[address][city]"]').val("<?= $service_city; ?>");
    $('input[name="service_facility[address][state]"]').val("<?= $service_state; ?>");
    $('input[name="service_facility[address][zip]"]').val("<?= $service_zip; ?>");
    $('input[name="service_facility[npi]"]').val("<?= ($insurancetype == '1')?$service_medicare_npi:$service_npi; ?>");
 
    $('input[name="billing_provider[phone_number]"]').val("<?= $phone; ?>");
    $('input[name="billing_provider[organization_name]"]').val("<?= $practice; ?>");
    $('input[name="billing_provider[address][street_line_1]"]').val("<?= $address; ?>");
    $('input[name="billing_provider[address][city]"]').val("<?= $city; ?>");
    $('input[name="billing_provider[address][state]"]').val("<?= $state; ?>");
    $('input[name="billing_provider[address][zip]"]').val("<?= $zip; ?>");
    $('input[name="billing_provider[npi]"]').val("<?= ($insurancetype == '1')?$medicare_npi:$npi; ?>"); 
    $('input[name="billing_provider[taxonomy_code]"]').val("332B00000X");
	//<?= $billing_provider_b_other; ?>"); 


<?php
$total_charge = (empty($total_charge)) ? 0.00 : $total_charge;
$amount_paid = (empty($amount_paid)) ? 0.00 : number_format($amount_paid, 2);
$balance_due = (empty($balance_due)) ? 0.00 : number_format($balance_due,2);

// We only calculate the dollar amounts when a new claim is created because
// right now we aren't appending any trxns to an existing claim.
if ($is_pending) {

  // get total_charge
  if($is_pri_pending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysql_query($sql);
    if ($charge_my && (mysql_num_rows($charge_my) > 0)) {
      $charge_row = mysql_fetch_array($charge_my);
      $total_charge = $charge_row['total_charge'];
    }
  }
  if($is_sec_pending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.primary_claim_id = " . $orig_claim_id . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysql_query($sql);
    if ($charge_my && (mysql_num_rows($charge_my) > 0)) {
      $charge_row = mysql_fetch_array($charge_my);
      $total_charge = $charge_row['total_charge'];
    }
  }

  // get amount paid
  $sql = "SELECT "
       . "  SUM(ledger.paid_amount) as 'amount_paid' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type IN (" . DSS_TRXN_TYPE_PATIENT . "," . DSS_TRXN_TYPE_INS . "," . DSS_TRXN_TYPE_ADJ . ") "
       . "ORDER BY "
       . "  ledger.service_date ASC";
  if($status == DSS_CLAIM_SEC_PENDING){
    $sql = "SELECT
                sum(dlp.amount) as amount_paid
        from dental_ledger dl
                LEFT JOIN dental_users p ON dl.producerid=p.userid
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$docid."' and dl.patientid='".s_for($_GET['pid'])."'
                        AND primary_claim_id=".$orig_claim_id."
                        AND dlp.amount != 0
                        AND dlp.payer = 0
        ";
  }
  $paid_my = mysql_query($sql);
  if ($paid_my && (mysql_num_rows($paid_my) > 0)) {
    $paid_row = mysql_fetch_array($paid_my);
    $amount_paid = $paid_row['amount_paid'];
  }

  // re-calculate balance due
  $balance_due = $total_charge - $amount_paid;
  // format calculations
  $total_charge = number_format($total_charge, 2, '.','');
  $amount_paid = number_format($amount_paid, 2, '.','');
  $balance_due = number_format($balance_due, 2, '.','');

}
?>


    $('input[name="claim[total_charge]"]').val("<?= $total_charge; ?>");
    $('input[name="claim[patient_amount_paid]"]').val("<?= $amount_paid; ?>");
    $('input[name="claim[signature_date]"]').val("<?= date('Y-m-d'); ?>");

    $('input').each( function(){
//      $(this).val($(this).val().toUpperCase());
    });

  });

function change_form(){
  if(form_changed){
    if(confirm('Your changes to this claim will be lost if you change to paper submission. Click \'Ok\' to proceed or \'Cancel\' to return to electronic form.')){
      window.location = "<?= $v2_form; ?>";
    }
  }else{
    window.location = "<?= $v2_form; ?>";
  }
  return false;
}

$(document).ready(function(){
  form_changed=false;
$('input, select').bind('change', function(){
  form_changed=true;
});

});

</script>

<div id="change_confirm" style="display:none;top:0;height:100%;background:#fff; position:fixed; top:20px; width:100%; opacity:90%;">
  <p>MESSAGE</p>

  <input type="button" value="Save" />
  <input type="button" onclick="window.location='<?= $v2_form; ?>';" value="Don't Save" />
  <input type="button" onclick="$('#change_confirm').hide();" value="Cancel" />


</div>


</body>
</html>
