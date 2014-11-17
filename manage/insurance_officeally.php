<?php
	include_once('includes/constants.inc');
	include_once('admin/includes/main_include.php');

	if(!empty($_SERVER['HTTPS'])) {
		$path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
	}else{
		$path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
	}

	$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
	
	$pat_myarray = $db->getRow($pat_sql);
	$name = strtoupper(st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']));
	$pat_lastname = $pat_myarray['lastname'];
	$pat_firstname = $pat_myarray['firstname'];
	$pat_gender = substr($pat_myarray['gender'],0,1);
	$pat_dob = ($pat_myarray['dob']!='')?date('Y-m-d', strtotime($pat_myarray['dob'])):'';

	switch($pat_myarray['p_m_relation']){
		case 'Self':
			$relationship_id = '18';
			break;
		case 'Spouse':
            $relationship_id = '01';
            break;
	    case 'Child':
            $relationship_id = '19';
            break;
	    case 'Other':
            $relationship_id = 'G8';
            break;
		default:
			$relationship_id = '21';
			break;
	}

	$insurancetype = st($pat_myarray['p_m_ins_type']);
	$insured_firstname = strtoupper(st($pat_myarray['p_m_partyfname']));
	$insured_lastname = strtoupper(st($pat_myarray['p_m_partylname']));
	$insured_middle = strtoupper(st($pat_myarray['p_m_partymname']));
	$other_insured_firstname = strtoupper(st($pat_myarray['s_m_partyfname']));
	$other_insured_lastname = strtoupper(st($pat_myarray['s_m_partylname']));
	$other_insured_middle = strtoupper(st($pat_myarray['s_m_partymname']));
	$insured_id_number = st($pat_myarray['p_m_ins_id']);
	$insured_dob = st($pat_myarray['ins_dob']);
	$claim_ins_dob = ($insured_dob!='')?date('Y-m-d', strtotime($insured_dob)):'';
	$p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
	$claim_assignment = ($p_m_ins_ass == 'Yes')?"A":"C";
	$other_insured_dob = st($pat_myarray['ins2_dob']);
	$other_insured_insurance_plan = strtoupper(st($pat_myarray['s_m_ins_plan']));

	if($pat_myarray['p_m_ins_type']==1){
		$insured_policy_group_feca = "NONE";
		$insured_insurance_plan = '';
		$insured_employer_school_name = '';
	}else{
		$insured_policy_group_feca = $pat_myarray['p_m_ins_grp'];
		$insured_insurance_plan = $pat_myarray['p_m_ins_plan'];
	}

	$other_insured_policy_group_feca = strtoupper(st($pat_myarray['s_m_ins_grp']));
	$referredby = st($pat_myarray['referred_by']);
	$referred_source = st($pat_myarray['referred_source']);
	$docid = st($pat_myarray['docid']);

	$sql = "select * from dental_insurance where insuranceid='".(!empty($_GET['insid']) ? $_GET['insid'] : '')."' and patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
	
	$my = $db->getResults($sql);
	$myarray = (!empty($my[0]) ? $my[0] : array());
	$dent_rows = count($my);
	$insuranceid = st((!empty($myarray['insuranceid']) ? $myarray['insuranceid'] : ''));
	$ins_payer_id = st($pat_myarray['p_m_eligible_id']);
	$payer_sql = "SELECT * FROM dental_ins_payer WHERE id='".mysqli_real_escape_string($con,$ins_payer_id)."'";
	error_log($payer_sql);
	
	$payer = $db->getRow($payer_sql);
	$eligible_id = $payer['payer_id'];
	$eligible_ins = $payer['name'];

	if (!empty($myarray)) {
		$pica1 = st($myarray['pica1']);
		$pica2 = st($myarray['pica2']);
		$pica3 = st($myarray['pica3']);
		$insurancetype = st($myarray['insurance_type']);
		$patient_lastname = strtoupper(st($myarray['patient_lastname']));
		$patient_firstname = strtoupper(st($myarray['patient_firstname']));
		$patient_middle = strtoupper(st($myarray['patient_middle']));
		$patient_dob = str_replace('-','/',st($myarray['patient_dob']));
		$patient_sex = st($myarray['patient_sex']);
		$other_insured_firstname = st($myarray['other_insured_firstname']);
		$other_insured_lastname = st($myarray['other_insured_lastname']);
		$other_insured_middle = st($myarray['other_insured_middle']);
		$other_insured_dob = str_replace('-','/',st($myarray['other_insured_dob']));
		$other_insured_sex = st($myarray['other_insured_sex']);
		$other_insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
		$insured_id_number = st($myarray['insured_id_number']);
		$insured_lastname = strtoupper(st($myarray['insured_lastname']));
		$insured_firstname = strtoupper(st($myarray['insured_firstname']));
		$insured_middle = strtoupper(st($myarray['insured_middle']));
		$insured_dob = str_replace('-','/',st($myarray['insured_dob']));
		$insured_insurance_plan = st($myarray['insured_insurance_plan']);
		$insured_policy_group_feca = st($myarray['insured_policy_group_feca']);

		$patient_address = strtoupper(st($myarray['patient_address']));
		$patient_relation_insured = st($myarray['patient_relation_insured']);
		$insured_address = strtoupper(st($myarray['insured_address']));
		$patient_city = strtoupper(st($myarray['patient_city']));
		$patient_state = strtoupper(st($myarray['patient_state']));
		$patient_status = st($myarray['patient_status']);
		$patient_status_array = split('~', $patient_status);
		$insured_city = strtoupper(st($myarray['insured_city']));
		$insured_state = strtoupper(st($myarray['insured_state']));
		$patient_zip = st($myarray['patient_zip']);
		$patient_phone_code = st($myarray['patient_phone_code']);
		$patient_phone = st($myarray['patient_phone']);
		$insured_zip = st($myarray['insured_zip']);
		$insured_phone_code = st($myarray['insured_phone_code']);
		$insured_phone = st($myarray['insured_phone']);
		$employment = st($myarray['employment']);
		$auto_accident = st($myarray['auto_accident']);
		$auto_accident_place = st($myarray['auto_accident_place']);
		$other_accident = st($myarray['other_accident']);
		$insured_sex = st($myarray['insured_sex']);
		$other_insured_sex = st($myarray['other_insured_sex']);
		$insured_employer_school_name = strtoupper(st($myarray['insured_employer_school_name']));
		$other_insured_employer_school_name = strtoupper(st($myarray['other_insured_employer_school_name']));
		$reserved_local_use = strtoupper(st($myarray['reserved_local_use']));
		$another_plan = strtoupper(st($myarray['another_plan']));
	}

	if($pat_myarray['p_m_ins_type']!=1 && $pat_myarray['has_s_m_ins'] == 'Yes' && $pat_myarray['p_m_dss_file'] == 1 && $pat_myarray['s_m_dss_file'] ==1){
		$another_plan = 'YES';
	}else{
		$another_plan = 'NO';
	}

	if (!empty($myarray)) {
		$patient_signature = st($myarray['patient_signature']);
		$patient_signed_date = st($myarray['patient_signed_date']);
		$insured_signature = st($myarray['insured_signature']);
		$date_current = str_replace('-','/',st($myarray['date_current']));
		$date_same_illness = str_replace('-','/',st($myarray['date_same_illness']));
		$unable_date_from = str_replace('-','/',st($myarray['unable_date_from']));
		$unable_date_to = str_replace('-','/',st($myarray['unable_date_to']));
		$referring_provider = strtoupper(st($myarray['referring_provider']));
		$field_17a_dd = st($myarray['field_17a_dd']);
		$field_17a = st($myarray['field_17a']);
		$field_17b = st($myarray['field_17b']);
		$hospitalization_date_from = str_replace('-','/',st($myarray['hospitalization_date_from']));
		$hospitalization_date_to = str_replace('-','/',st($myarray['hospitalization_date_to']));
		$reserved_local_use1 = strtoupper(st($myarray['reserved_local_use1']));
		$outside_lab = strtoupper(st($myarray['outside_lab']));
		$s_charges = st($myarray['s_charges']);
		$diagnosis_1 = st($myarray['diagnosis_1']);
		$diagnosis_2 = st($myarray['diagnosis_2']);
		$diagnosis_3 = st($myarray['diagnosis_3']);
		$diagnosis_4 = st($myarray['diagnosis_4']);
		$medicaid_resubmission_code = st($myarray['medicaid_resubmission_code']);
		$original_ref_no = st($myarray['original_ref_no']);
		$prior_authorization_number = st($myarray['prior_authorization_number']);
		$service_date1_from = str_replace('-','/',st($myarray['service_date1_from']));
		$service_date1_to = str_replace('-','/',st($myarray['service_date1_to']));
		$place_of_service1 = strtoupper(st($myarray['place_of_service1']));
		$emg1 = strtoupper(st($myarray['emg1']));
		$cpt_hcpcs1 = st($myarray['cpt_hcpcs1']);
		$modifier1_1 = st($myarray['modifier1_1']);
		$modifier1_2 = st($myarray['modifier1_2']);
		$modifier1_3 = st($myarray['modifier1_3']);
		$modifier1_4 = st($myarray['modifier1_4']);
		$diagnosis_pointer1 = st($myarray['diagnosis_pointer1']);
		$s_charges1_1 = st($myarray['s_charges1_1']);
		$s_charges1_2 = st($myarray['s_charges1_2']);
		$days_or_units1 = st($myarray['days_or_units1']);
		$epsdt_family_plan1 = strtoupper(st($myarray['epsdt_family_plan1']));
		$id_qua1 = st($myarray['id_qua1']);
		$rendering_provider_id1 = st($myarray['rendering_provider_id1']);
		$service_date2_from = str_replace('-','/',st($myarray['service_date2_from']));
		$service_date2_to = str_replace('-','/',st($myarray['service_date2_to']));
		$place_of_service2 = strtoupper(st($myarray['place_of_service2']));
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
		$service_date3_from = str_replace('-','/',st($myarray['service_date3_from']));
		$service_date3_to = str_replace('-','/',st($myarray['service_date3_to']));
		$place_of_service3 = strtoupper(st($myarray['place_of_service3']));
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
		$service_date4_from = str_replace('-','/',st($myarray['service_date4_from']));
		$service_date4_to = str_replace('-','/',st($myarray['service_date4_to']));
		$place_of_service4 = strtoupper(st($myarray['place_of_service4']));
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
		$service_date5_from = str_replace('-','/',st($myarray['service_date5_from']));
		$service_date5_to = str_replace('-','/',st($myarray['service_date5_to']));
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
		$service_date6_from = str_replace('-','/',st($myarray['service_date6_from']));
		$service_date6_to = str_replace('-','/',st($myarray['service_date6_to']));
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
		$total_charge = str_replace(",", '', st($myarray['total_charge']));
		$amount_paid = str_replace(",", '', st($myarray['amount_paid']));
		$balance_due = str_replace(",", '', st($myarray['balance_due']));
		$signature_physician = st($myarray['signature_physician']);
		$physician_signed_date = st($myarray['physician_signed_date']);
		$service_facility_info_name = strtoupper(st($myarray['service_facility_info_name']));
		$service_facility_info_address = strtoupper(st($myarray['service_facility_info_address']));
		$service_facility_info_city = strtoupper(st($myarray['service_facility_info_city']));
		$service_info_a = strtoupper(st($myarray['service_info_a']));
		$service_info_dd = strtoupper(st($myarray['service_info_dd']));
		$service_info_b_other = strtoupper(st($myarray['service_info_b_other']));
		$billing_provider_phone_code = st($myarray['billing_provider_phone_code']);
		$billing_provider_phone = st($myarray['billing_provider_phone']);
		$billing_provider_name = strtoupper(st($myarray['billing_provider_name']));
		$billing_provider_address = strtoupper(st($myarray['billing_provider_address']));
		$billing_provider_city = strtoupper(st($myarray['billing_provider_city']));
		$billing_provider_a = strtoupper(st($myarray['billing_provider_a']));
		$billing_provider_dd = strtoupper(st($myarray['billing_provider_dd']));
		$billing_provider_b_other = strtoupper(st($myarray['billing_provider_b_other']));
		$status = st($myarray['status']);
	}

	$is_sent = (!empty($status) && ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT)) ? true : false;

	if(empty($insured_sex)) {
		$insured_sex = $pat_myarray['gender'];
	}
	  
	if(empty($patient_sex)) {
		$patient_sex = $pat_myarray['gender'];
	}

	if(empty($patient_firstname)) {
		$patient_firstname = $pat_myarray['firstname'];
	}

	if(empty($patient_lastname)) {
		$patient_lastname = $pat_myarray['lastname'];
	}

	if(empty($patient_middle)) {
		$patient_middle = $pat_myarray['middlename'];
	}
		
	if(empty($patient_firstname)) {
		$patient_firstname = $pat_myarray['firstname'];
	}
		
	if(empty($patient_address)) {
		$patient_address = $pat_myarray['add1'];
	}

	if(empty($patient_city)) {
		$patient_city = $pat_myarray['city'];
	}

	if(empty($patient_state)) {
		$patient_state = $pat_myarray['state'];
	}

	if(empty($patient_zip)) {
		$patient_zip = $pat_myarray['zip'];
	}

	if(empty($patient_phone)){
		$patient_phone_code = substr($pat_myarray['home_phone'],0,3);
		$patient_phone = substr($pat_myarray['home_phone'],3);
	}

	if(empty($patient_dob)) {
		$patient_dob = $pat_myarray['dob'];
	}

	if(empty($patient_status)) {
		$patient_status = $pat_myarray['marital_status'];
	}	

	if(empty($insured_id_number)) {
		$insured_id_number = $pat_myarray['p_m_ins_id'];
	}
			
	if(empty($insured_firstname)) {
		$insured_firstname = $pat_myarray['p_d_party'];
	}
		
	if(empty($insured_address)) {
		$insured_address = $pat_myarray['add1'];
	}

	if(empty($insured_city)) {
		$insured_city = $pat_myarray['city'];
	}

	if(empty($insured_state)) {
		$insured_state = $pat_myarray['state'];
	}

	if(empty($insured_zip)) {
		$insured_zip = $pat_myarray['zip'];
	}

	if(empty($insured_phone)) {
		$insured_phone_code = substr($pat_myarray['home_phone'], 0, 4);
	}

	$insured_phone = substr($pat_myarray['home_phone'], 3);

	if(empty($insured_dob)) {
		$insured_dob = $pat_myarray['ins_dob'];	
	}

	if(empty($patient_relation_insured)) {
		$patient_relation_insured = $pat_myarray['p_m_relation'];
	}

	if(empty($insured_employer_school_name)) {
		$insured_employer_school_name = $pat_myarray['employer'];
	}

	if(empty($insured_policy_group_feca)) {
		$insured_policy_group_feca = $pat_myarray['group_number'];
	}

	if(empty($insured_insurance_plan)) {
		$insured_insurance_plan = $pat_myarray['plan_name'];
	}	
        
	if($pat_myarray['p_m_ins_type']==1) {
		$insured_policy_group_feca = "NONE";
		$insured_insurance_plan = '';
		$insured_employer_school_name = '';
	}

	$accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
	$accept_assignment = $accept_assignmentnew;

	$sleepstudies = "SELECT ss.completed, ss.diagnosising_doc, ss.diagnosising_npi FROM dental_summ_sleeplab ss                                 
                     JOIN dental_patients p on ss.patiendid=p.patientid                        
                	 WHERE                                 
                     (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                     (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                     ss.filename IS NOT NULL AND ss.patiendid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."';";

	$d = $db->getRow($sleepstudies);
	$diagnosising_doc = $d['diagnosising_doc'];
	$diagnosising_npi = $d['diagnosising_npi'];

	if($insurancetype!=1){
		$diagnosising_doc = '';
		$diagnosising_npi = '';
	}
	// If claim doesn't yet have a preauth number, try to load it
	// from the patient's most recently completed preauth.
	if (empty($prior_authorization_number)) {
	    $sql = "SELECT "
	         . "  * "
	         . "FROM "
	         . "  dental_insurance_preauth "
	         . "WHERE "
	         . "  patient_id = '" . (!empty($_GET['pid']) ? $_GET['pid'] : '') . "' "
	         . "  AND status = " . DSS_PREAUTH_COMPLETE . " "
	         . "ORDER BY "
	         . "  date_completed desc "
	         . "LIMIT 1";

	    $my = $db->getResults($sql);
	    $num_rows = count($my);
	    
	    if ($num_rows > 0) {
	        $myarray = $my[0];
	        $prior_authorization_number = $myarray['pre_auth_num'];
	    }
	}

	$inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['p_m_ins_co'])."'";

	$inscoinfo = $db->getRow($inscoquery);

	$referredby_sql = "select * from dental_contact where `contactid` = ".$referredby." LIMIT 1;";
	


	$referredby_my = $db->query($referredby_sql);




	if($referred_source==1){
		$rsql = "SELECT lastname, firstname FROM dental_patients WHERE patientid=".$referredby;
		
		$r = $db->getRow($rsql);
		$ref_name = $r['firstname'].", ".$r['lastname'];                
	}elseif($referred_source==2){
		$rsql = "SELECT lastname, firstname FROM dental_contact WHERE contactid=".$referredby;
		
		$r = $db->getRow($rsql);
		$ref_name = $r['firstname']." ".$r['lastname'];
	}

	$qua_sql = "select * from dental_qualifier where qualifierid=".(isset($field_17a_dd) ? $field_17a_dd : '');
	
	$qua_myarray = $db->getRow($qua_sql);
	$seventeenA = (!empty($qua_myarray['qualifier']) ? $qua_myarray['qualifier'] : '');

    $getuserinfo = "SELECT *, ";
	if($insurancetype == '1'){
		$getuserinfo .= " dental_users.medicare_npi ";
	}else{
		$getuserinfo .= " dental_users.npi ";
	}
	$getuserinfo .= " as 'provider_id' ";
	$getuserinfo .= " FROM `dental_users` WHERE `userid` = '".$docid."'";

	$userinfo = $db->getRow($getuserinfo);
    $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";
    
    $prod_r = $db->getRow($prod_s);
    $claim_producer = $prod_r['producer'];

	$getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";
	
	if($userinfo = $db->getRow($getuserinfo)){
		$phone = $userinfo['phone'];
		$practice = $userinfo['practice'];
		$address = $userinfo['address'];
		$city = $userinfo['city'];
		$state = $userinfo['state'];
		$zip = $userinfo['zip'];
		$npi = $userinfo['npi'];
		$medicare_npi = $userinfo['medicare_npi'];
		$tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
		$medicare_ptan = $userinfo['medicare_ptan'];
	}

	$getdocinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".$docid."'";
	
	$docinfo = $db->getRow($getdocinfo);
	if(empty($phone)){ $phone = $docinfo['phone']; }
	if(empty($practice)){ $practice = $docinfo['practice']; }
	if(empty($address)){ $address = $docinfo['address']; }
	if(empty($city)){ $city = $docinfo['city']; }
	if(empty($state)){ $state = $docinfo['state']; }
	if(empty($zip)){ $zip = $docinfo['zip']; }
	if(empty($npi)){ $npi = $docinfo['npi']; }
	if(empty($medicare_npi)){ $medicare_npi = $docinfo['medicare_npi']; }
	if(empty($tax_id_or_ssn)){ $tax_id_or_ssn = $docinfo['tax_id_or_ssn']; }
	if(empty($medicare_ptan)){ $medicare_ptan = $docinfo['medicare_ptan']; }

	$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_1) ? $diagnosis_1 : '');
	
	$ins_diag_myarray = $db->getRow($ins_diag_sql);

	$ins_diagnosis = (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : '');

	$dia = explode('.', $ins_diagnosis);
	$diagnosis_1 = $ins_diagnosis;
	$diagnosis_1_left_fill = $dia[0];
	$diagnosis_1_right_fill = (!empty($dia[1]) ? $dia[1] : '');

	$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_2) ? $diagnosis_2 : '');

	$ins_diag_myarray = $db->getRow($ins_diag_sql);                            
	$dia = explode('.', $ins_diagnosis);
	$diagnosis_2 = $ins_diagnosis;
	$diagnosis_2_left_fill = $dia[0];
	$diagnosis_2_right_fill = (!empty($dia[1]) ? $dia[1] : '');

	$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_3) ? $diagnosis_3 : '');

	$ins_diag_myarray = $db->getRow($ins_diag_sql);                            
	$dia = explode('.', $ins_diagnosis);
	$diagnosis_3 = $ins_diagnosis;
	$diagnosis_3_left_fill = $dia[0];
	$diagnosis_3_right_fill = (!empty($dia[1]) ? $dia[1] : '');

	$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_4) ? $diagnosis_4 : '');
	
	$ins_diag_myarray = $db->getRow($ins_diag_sql);                            
	$dia = explode('.', $ins_diagnosis);
	$diagnosis_4 = $ins_diagnosis;
	$diagnosis_4_left_fill = $dia[0];
	$diagnosis_4_right_fill = (!empty($dia[1]) ? $dia[1] : '');

	//FOR TESTING PURPOSES
	if(isset($_GET['memid']) && $_GET['memid']!=''){
		$insured_id_number = $_GET['memid'];
	}

	$d = array();
	$d[] = $eligible_ins;
	//$d[] = 

	$data = array();                                                                    
	if(isset($_GET['test']) && $_GET['test']==1){
	  $data['test'] = 'true';
	}
	$data['api_key'] = '33b2e3a5-8642-1285-d573-07a22f8a15b4';

	$data['receiver'] = array(
		"organization_name" => $eligible_ins,
		"id" => $eligible_id);
	$data['billing_provider']= array(
		"taxonomy_code" => "332B00000X",
		"practice_name" => $practice,
		"npi" => $npi,
		"address" => array(
			"street_line_1" => str_replace(',','',$address),
			"street_line_2"=> "",
			"city" => $city,
			"state" => $state,
			"zip" => $zip),
		"tin" => $tax_id_or_ssn,
		"insurance_provider_id" => $medicare_ptan);

	$data['subscriber'] = array(
		"last_name" => $insured_lastname,
		"first_name" => $insured_firstname,
		"member_id" => $insured_id_number,
		"group_id" => $insured_policy_group_feca,
		"group_name" => $insured_insurance_plan,
        "gender" => $pat_gender,
        "address" => array(
            "street_line_1" => $patient_address,
            "street_line_2" => "",
            "city" => $patient_city,
            "state" => $patient_state,
            "zip" => $patient_zip),
		"dob" => $claim_ins_dob);

	$ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contactid='".mysqli_real_escape_string($con,$pat_myarray['p_m_ins_co'])."' AND contacttypeid = '11' AND docid='".$pat_myarray['docid']."'";

	$ins_contact_res = $db->getRow($ins_contact_qry);

	$data['payer'] = array(
		"name" => $eligible_ins,
		"id" => $eligible_id,
		"address" => array(
			"street_line_1" => $ins_contact_res['add1'],
			"street_line_2" =>  $ins_contact_res['add2'],
			"city" =>  $ins_contact_res['city'],
			"state" =>  $ins_contact_res['state'],
			"zip" =>  $ins_contact_res['zip'])
		);

	if($relationship_id!=18){
		$data['dependent'] = array(
			"relationship" => $relationship_id,
			"last_name" => $pat_lastname,
			"first_name" => $pat_firstname,
			"dob" => $pat_dob,
			"gender" => $pat_gender,
	        "address" => array(
                "street_line_1" => $patient_address,
                "street_line_2" => "",
                "city" => $patient_city,
                "state" => $patient_state,
                "zip" => $patient_zip)
	        );
	}

	$diagnosis_pointer = array();
	$diagnosis_pointer[1] = $diagnosis_1;
	$diagnosis_pointer[2] = $diagnosis_2;
	$diagnosis_pointer[3] = $diagnosis_3;
	$diagnosis_pointer[4] = $diagnosis_4;
	// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
	$sql = "";
  	$sql = "SELECT "
         . "  ledger.*, ";
	if($insurancetype == '1'){
        $sql .= " user.medicare_npi ";
	}else{
        $sql .= " user.npi ";
	}
  	$sql .= " as 'provider_id', ps.place_service as 'place' "
	      . "FROM "
	      . "  dental_ledger ledger "
	      . "  JOIN dental_users user ON user.userid = ledger.docid "
	      . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
	      . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
	      . "WHERE "
	      . "  ledger.primary_claim_id = " . $insuranceid . " "
	      . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
	      . "  AND ledger.docid = " . $docid . " "
	      . "  AND trxn_code.docid = " . $docid . " "
	      . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
	      . "ORDER BY "
	      . "  ledger.service_date ASC";

	$query = $db->getResults($sql);
	$c = 0;
	$claim_lines = array();
	if ($query) foreach ($query as $array) {
		$c++;
		$pos = preg_replace("/[^0-9]/","",$array['placeofservice']);
		$diagnosis = '';
		if($array['diagnosispointer']!=''){
			if(isset($diagnosis_pointer[$array['diagnosispointer']])){
				$diagnosis = $diagnosis_pointer[$array['diagnosispointer']];
			}
		}
		$a = array(
			"line_number" => "$c",
			"qualifier" => "HC",
			"product_service" => $array['transaction_code'],
			"charge_amount" => $array['amount'],
			"place_of_service" => preg_replace("/[^0-9]/","",$array['placeofservice']),
			"modifier_1" => $array['modcode'],
			"modifier_2" => $array['modcode2'],
			"modifier_3" => $array['modcode3'],
			"modifier_4" => $array['modcode4'],
			"diagnosis_1" => $diagnosis,
			"service_start" => ($array['service_date'] != '')?date('Y-m-d', strtotime($array['service_date'])):'',
			"service_end" =>  ($array['service_date'] != '')?date('Y-m-d', strtotime($array['service_date'])):''
		);
		array_push($claim_lines, $a);
	}

	$data['claim'] = array(
		"claim_number" => (!empty($_GET['insid']) ? $_GET['insid'] : ''),
		"total_charge_amount" => (isset($total_charge) ? $total_charge : ''),
		"claim_frequency" => "1",
		"patient_signature_on_file" => "Y",
		"provider_plan_participation" => $claim_assignment,
		"direct_payment_authorized" => "Y",
		"release_of_information" => "I",
		"service_lines" => $claim_lines
	);

	$data_string = json_encode($data);                                                                                   
	
	$ch = curl_init('https://gds.eligibleapi.com/v1.1/claims.json');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	    'Content-Type: application/json',                                                                                
	    'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
 
	$result = curl_exec($ch);

	$json_response = json_decode($result);

	if (!empty($json_response)) {
		$ref_id = $json_response->{"reference_id"};		
	} else {
		$ref_id = '';
	}

	$up_sql = "INSERT INTO dental_claim_electronic SET 
        		claimid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."',
				reference_id = '".mysqli_real_escape_string($con,$ref_id)."',
				response='".mysqli_real_escape_string($con,$result)."',
        		adddate=now(),
        		ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'
        		";

	$db->query($up_sql);
?>
	<script type="text/javascript">
		c = confirm('RESPONSE: <?php echo  $result; ?> Do you want to mark the claim sent?');
		if(c){
			window.location = "manage_claims.php?insid=<?php echo  $_GET['insid']; ?>&upstatus=<?php echo  DSS_CLAIM_SENT; ?>"; 
		}
	</script>
<?php

	function fill_cents($v)
	{
		if($v<10){
			return '0'.$v;
		}else{
			return $v;
		}
	}
?>