<?php namespace Ds3\Libraries\Legacy; ?><?php

require_once __DIR__ . '/../../3rdParty/tcpdf/tcpdf.php';
require_once __DIR__ . '/../../3rdParty/fpdi/fpdi.php';

function claim_status_history_update($insuranceid, $new, $old, $userid, $adminid=''){

  $db = new Db();
  $con = $GLOBALS['con'];

  if($old != $new){
    $sql = "INSERT INTO dental_insurance_status_history SET
		insuranceid='".mysqli_real_escape_string($con,$insuranceid)."',
		status='".mysqli_real_escape_string($con,$new)."',
		userid='".mysqli_real_escape_string($con,$userid)."',
		adminid='".mysqli_real_escape_string($con,$adminid)."',
		adddate=now(),
		ip_address = '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";

    $db->query($sql);
  }
}


function claim_create_sec($pid, $primary_claim_id, $prod, $reuse_sec = false){

  $db = new Db();
  $con = $GLOBALS['con'];

             $pat_sql = "select p.*, u.billing_company_id from dental_patients p 
		JOIN dental_users u ON u.userid=p.docid
		where p.patientid='".s_for($pid)."'";

             $pat_myarray = $db->getRow($pat_sql);
$p_m_dss_file = $pat_myarray['s_m_dss_file'];
$p_m_billing_id = $pat_myarray['billing_company_id'];
$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
$referredby = st($pat_myarray['referred_by']);
$referred_source = st($pat_myarray['referred_source']);
$docid = $pat_myarray['docid'];
$patient_firstname = $pat_myarray['firstname'];
$patient_lastname = $pat_myarray['lastname'];
$patient_middle = $pat_myarray['middlename'];
$patient_address = $pat_myarray['add1'];
$patient_city = $pat_myarray['city'];
$patient_state = $pat_myarray['state'];
$patient_zip = $pat_myarray['zip'];
$patient_dob = $pat_myarray['dob'];
       if($pat_myarray['s_m_ins_ass']=='Yes'){
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


//USE SECONDARY INSURANCE FROM PRIMARY CLAIM
if($reuse_sec){
  $p_sql = "SELECT * FROM dental_insurance WHERE insuranceid='".$primary_claim_id."'";

  $p_r = $db->getRow($p_sql);
  $insurancetype = st($p_r['other_insurance_type']);
  $other_insurancetype = $p_r['insurance_type'];
  $other_insured_firstname = st($p_r['insured_firstname']);
  $other_insured_lastname = st($p_r['insured_lastname']);
  $other_insured_middle = st($p_r['insured_middle']);
  $other_insured_dob = st($p_r['insured_dob']);
  $other_insured_sex = st($p_r['insured_sex']);
  $other_insured_insurance_plan = st($p_r['insured_insurance_plan']);
  $other_insured_policy_group_feca = st($p_r['insured_policy_group_feca']);
  $insured_id_number = st($p_r['other_insured_id_number']);
  $insured_firstname = st($p_r['other_insured_firstname']);
  $insured_middle = st($p_r['other_insured_middle']);
  $insured_lastname = st($p_r['other_insured_lastname']);
  $insured_dob = st($p_r['other_insured_dob']);
  $insured_insurance_plan = st($p_r['other_insured_insurance_plan']);
  $insured_policy_group_feca = st($p_r['other_insured_policy_group_feca']);
  $insured_address = st($p_r['other_insured_address']);
  $insured_city = st($p_r['other_insured_city']);
  $insured_state = st($p_r['other_insured_state']);
  $insured_zip = st($p_r['other_insured_zip']);
  $insured_phone_code = st($p_r['insured_phone_code']);
  $insured_phone = st($p_r['insured_phone']);
  $insured_sex = st($p_r['other_insured_sex']);
  $patient_relation_insured = st($p_r['patient_relation_other_insured']);


}else{
//INSURANCE FROM PATIENT INFO
        $insured_id_number = $pat_myarray['s_m_ins_id'];
        //$insured_firstname = $pat_myarray['p_d_party'];
	if($pat_myarray['p_m_same_address']=='1'){
          $other_insured_address = $pat_myarray['add1'];
          $other_insured_city = $pat_myarray['city'];
          $other_insured_state = $pat_myarray['state'];
          $other_insured_zip = $pat_myarray['zip'];
	}else{
          $other_insured_address = $pat_myarray['p_m_address'];
          $other_insured_city = $pat_myarray['p_m_city'];
          $other_insured_state = $pat_myarray['p_m_state'];
          $other_insured_zip = $pat_myarray['p_m_zip'];
	}
	if($pat_myarray['s_m_same_address']=='1'){
          $insured_address = $pat_myarray['add1'];
          $insured_city = $pat_myarray['city'];
          $insured_state = $pat_myarray['state'];
          $insured_zip = $pat_myarray['zip'];
	}else{
          $insured_address = $pat_myarray['s_m_address'];
          $insured_city = $pat_myarray['s_m_city'];
          $insured_state = $pat_myarray['s_m_state'];
          $insured_zip = $pat_myarray['s_m_zip'];
	}
$insurancetype = st($pat_myarray['s_m_ins_type']);
$other_insurancetype = st($pat_myarray['p_m_ins_type']);
$insured_firstname = st($pat_myarray['s_m_partyfname']);
$insured_lastname = st($pat_myarray['s_m_partylname']);
$insured_middle = st($pat_myarray['s_m_partymname']);
$other_insured_firstname = st($pat_myarray['p_m_partyfname']);
$other_insured_lastname = st($pat_myarray['p_m_partylname']);
$other_insured_middle = st($pat_myarray['p_m_partymname']);
$insured_id_number = st($pat_myarray['s_m_ins_id']);
$insured_dob = st($pat_myarray['ins2_dob']);
$p_m_ins_ass = st($pat_myarray['s_m_ins_ass']);
$other_insured_dob = st($pat_myarray['ins_dob']);
$insured_insurance_plan = st($pat_myarray['s_m_ins_plan']);
$other_insured_insurance_plan = st($pat_myarray['p_m_ins_plan']);
$insured_policy_group_feca = st($pat_myarray['s_m_ins_grp']);
$other_insured_policy_group_feca = st($pat_myarray['p_m_ins_grp']);
$insured_sex = $pat_myarray['s_m_gender'];
$other_insured_sex = $pat_myarray['p_m_gender'];
        $insured_dob = $pat_myarray['ins2_dob'];
        $patient_relation_insured = $pat_myarray['s_m_relation'];
        $patient_relation_other_insured = $pat_myarray['p_m_relation'];
        $insured_employer_school_name = $pat_myarray['employer'];

///////////////////////
}



        //$insured_policy_group_feca = $pat_myarray['group_number'];
        //$insured_insurance_plan = $pat_myarray['plan_name'];
//NEED SECONDARY?
  $p_m_eligible_payer_id = $pat_myarray['s_m_eligible_payer_id'];
  $p_m_eligible_payer_name = $pat_myarray['s_m_eligible_payer_name'];
$sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

  $d = $db->getRow($sleepstudies);
  $diagnosis_1 = $d['diagnosis'];

  $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysqli_real_escape_string($con,$diagnosis_1)."'";
     
     $ins_diag = $db->getRow($ins_diag_sql);
     $diagnosis_a = $ins_diag['ins_diagnosis'];

$sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

  $d = $db->getRow($sleepstudies);
  $diagnosising_doc = $d['diagnosising_doc'];
  $diagnosising_npi = $d['diagnosising_npi'];

$accept_assignmentnew = st($pat_myarray['s_m_ins_ass']);
if ($dent_rows <= 0) {
    $accept_assignment = $accept_assignmentnew;
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

    $my = $db->getRow($sql);

    if (!empty($my)) {
        $prior_authorization_number = $my['pre_auth_num'];
    }
}
		$ins_sql = " insert into dental_insurance set 
		patientid = '".s_for($pid)."',
		pica1 = '".s_for($pica1)."',
		pica2 = '".s_for($pica2)."',
		pica3 = '".s_for($pica3)."',
		insurance_type = '".s_for($insurancetype)."',
		other_insurance_type = '".s_for($other_insurancetype)."',
		insured_id_number = '".s_for($insured_id_number)."',
		patient_lastname = '".s_for($patient_lastname)."',
		patient_firstname = '".s_for($patient_firstname)."',
		patient_middle = '".s_for($patient_middle)."',
		patient_dob = '".s_for($patient_dob)."',
		patient_sex = '".s_for($patient_sex)."',
		insured_firstname = '".s_for($insured_firstname)."',
		insured_lastname = '".s_for($insured_lastname)."',
		insured_middle = '".s_for($insured_middle)."',
		patient_address = '".s_for($patient_address)."',
		patient_relation_insured = '".s_for($patient_relation_insured)."',
		patient_relation_other_insured = '".s_for($patient_relation_other_insured)."',
		patient_city = '".s_for($patient_city)."',
		patient_state = '".s_for($patient_state)."',
		patient_status = '".s_for($patient_status_arr)."',
		insured_address = '".s_for($insured_address)."',
		insured_city = '".s_for($insured_city)."',
		insured_state = '".s_for($insured_state)."',
		insured_zip = '".s_for($insured_zip)."',
		other_insured_address = '".s_for($other_insured_address)."',
		other_insured_city = '".s_for($other_insured_city)."',
		other_insured_state = '".s_for($other_insured_state)."',
		other_insured_zip = '".s_for($other_insured_zip)."',
		patient_zip = '".s_for($patient_zip)."',
		patient_phone_code = '".s_for($patient_phone_code)."',
		patient_phone = '".s_for($patient_phone)."',
		insured_phone_code = '".s_for($insured_phone_code)."',
		insured_phone = '".s_for($insured_phone)."',
		other_insured_firstname = '".s_for($other_insured_firstname)."',
		other_insured_lastname = '".s_for($other_insured_lastname)."',
		other_insured_middle = '".s_for($other_insured_middle)."',
		employment = '".s_for($employment)."',
		auto_accident = '".s_for($auto_accident)."',
		auto_accident_place = '".s_for($auto_accident_place)."',
		other_accident = '".s_for($other_accident)."',
		insured_policy_group_feca = '".s_for($insured_policy_group_feca)."',
		other_insured_policy_group_feca = '".s_for($other_insured_policy_group_feca)."',
		insured_dob = '".s_for($insured_dob)."',
		insured_sex = '".s_for($insured_sex)."',
		other_insured_dob = '".s_for($other_insured_dob)."',
		other_insured_sex = '".s_for($other_insured_sex)."',
		insured_employer_school_name = '".s_for($insured_employer_school_name)."',
		other_insured_employer_school_name = '".s_for($other_insured_employer_school_name)."',
		insured_insurance_plan = '".s_for($insured_insurance_plan)."',
		other_insured_insurance_plan = '".s_for($other_insured_insurance_plan)."',
		reserved_local_use = '".s_for($reserved_local_use)."',
		another_plan = '".s_for($another_plan)."',
		patient_signature = '".$patient_signature."',
		patient_signed_date = '".s_for($patient_signed_date)."',
                insured_signature = '".s_for($insured_signature)."',
                date_current = '".s_for($date_current)."',
                date_same_illness = '".s_for($date_same_illness)."',
                unable_date_from = '".s_for($unable_date_from)."',
                unable_date_to = '".s_for($unable_date_to)."',
                referring_provider = '".s_for($referring_provider)."',
                field_17a_dd = '".s_for($field_17a_dd)."',
                field_17a = '".s_for($field_17a)."',
                field_17b = '".s_for($field_17b)."',
                hospitalization_date_from = '".s_for($hospitalization_date_from)."',
                hospitalization_date_to = '".s_for($hospitalization_date_to)."',
                reserved_local_use1 = '".s_for($reserved_local_use1)."',
                outside_lab = '".s_for($outside_lab)."',
                s_charges = '".s_for($s_charges)."',
                diagnosis_1 = '".s_for($diagnosis_1)."',
                diagnosis_2 = '".s_for($diagnosis_2)."',
                diagnosis_3 = '".s_for($diagnosis_3)."',
                diagnosis_4 = '".s_for($diagnosis_4)."',
                diagnosis_a = '".s_for($diagnosis_a)."',
                diagnosis_b = '".s_for($diagnosis_b)."',
                diagnosis_c = '".s_for($diagnosis_c)."',
                diagnosis_d = '".s_for($diagnosis_d)."',
                diagnosis_e = '".s_for($diagnosis_e)."',
                diagnosis_f = '".s_for($diagnosis_f)."',
                diagnosis_g = '".s_for($diagnosis_g)."',
                diagnosis_h = '".s_for($diagnosis_h)."',
                diagnosis_i = '".s_for($diagnosis_i)."',
                diagnosis_j = '".s_for($diagnosis_j)."',
                diagnosis_k = '".s_for($diagnosis_k)."',
                diagnosis_l = '".s_for($diagnosis_l)."',
                medicaid_resubmission_code = '".s_for($medicaid_resubmission_code)."',
                original_ref_no = '".s_for($original_ref_no)."',
                prior_authorization_number = '".s_for($prior_authorization_number)."',
                service_date1_from = '".s_for($service_date1_from)."',
                service_date1_to = '".s_for($service_date1_to)."',
                place_of_service1 = '".s_for($place_of_service1)."',
                emg1 = '".s_for($emg1)."',
                cpt_hcpcs1 = '".s_for($cpt_hcpcs1)."',
                modifier1_1 = '".s_for($modifier1_1)."',
                modifier1_2 = '".s_for($modifier1_2)."',
                modifier1_3 = '".s_for($modifier1_3)."',
                modifier1_4 = '".s_for($modifier1_4)."',
                diagnosis_pointer1 = '".s_for($diagnosis_pointer1)."',
                s_charges1_1 = '".s_for($s_charges1_1)."',
                s_charges1_2 = '".s_for($s_charges1_2)."',
                days_or_units1 = '".s_for($days_or_units1)."',
                epsdt_family_plan1 = '".s_for($epsdt_family_plan1)."',
                id_qua1 = '".s_for($id_qua1)."',
                rendering_provider_id1 = '".s_for($rendering_provider_id1)."',
                service_date2_from = '".s_for($service_date2_from)."',
                service_date2_to = '".s_for($service_date2_to)."',
                place_of_service2 = '".s_for($place_of_service2)."',
                emg2 = '".s_for($emg2)."',
                cpt_hcpcs2 = '".s_for($cpt_hcpcs2)."',
                modifier2_1 = '".s_for($modifier2_1)."',
                modifier2_2 = '".s_for($modifier2_2)."',
                modifier2_3 = '".s_for($modifier2_3)."',
                modifier2_4 = '".s_for($modifier2_4)."',
                diagnosis_pointer2 = '".s_for($diagnosis_pointer2)."',
                s_charges2_1 = '".s_for($s_charges2_1)."',
                s_charges2_2 = '".s_for($s_charges2_2)."',
                days_or_units2 = '".s_for($days_or_units2)."',
                epsdt_family_plan2 = '".s_for($epsdt_family_plan2)."',
                id_qua2 = '".s_for($id_qua2)."',
                rendering_provider_id2 = '".s_for($rendering_provider_id2)."',
                service_date3_from = '".s_for($service_date3_from)."',
                service_date3_to = '".s_for($service_date3_to)."',
                place_of_service3 = '".s_for($place_of_service3)."',
                emg3 = '".s_for($emg3)."',
                cpt_hcpcs3 = '".s_for($cpt_hcpcs3)."',
                modifier3_1 = '".s_for($modifier3_1)."',
                modifier3_2 = '".s_for($modifier3_2)."',
                modifier3_3 = '".s_for($modifier3_3)."',
                modifier3_4 = '".s_for($modifier3_4)."',
                diagnosis_pointer3 = '".s_for($diagnosis_pointer3)."',
                s_charges3_1 = '".s_for($s_charges3_1)."',
                s_charges3_2 = '".s_for($s_charges3_2)."',
                days_or_units3 = '".s_for($days_or_units3)."',
                epsdt_family_plan3 = '".s_for($epsdt_family_plan3)."',
                id_qua3 = '".s_for($id_qua3)."',
                rendering_provider_id3 = '".s_for($rendering_provider_id3)."',
                service_date4_from = '".s_for($service_date4_from)."',
                service_date4_to = '".s_for($service_date4_to)."',
                place_of_service4 = '".s_for($place_of_service4)."',
                emg4 = '".s_for($emg4)."',
                cpt_hcpcs4 = '".s_for($cpt_hcpcs4)."',
                modifier4_1 = '".s_for($modifier4_1)."',
                modifier4_2 = '".s_for($modifier4_2)."',
                modifier4_3 = '".s_for($modifier4_3)."',
                modifier4_4 = '".s_for($modifier4_4)."',
                diagnosis_pointer4 = '".s_for($diagnosis_pointer4)."',
                s_charges4_1 = '".s_for($s_charges4_1)."',
                s_charges4_2 = '".s_for($s_charges4_2)."',
                days_or_units4 = '".s_for($days_or_units4)."',
                epsdt_family_plan4 = '".s_for($epsdt_family_plan4)."',
                id_qua4 = '".s_for($id_qua4)."',
                rendering_provider_id4 = '".s_for($rendering_provider_id4)."',
                service_date5_from = '".s_for($service_date5_from)."',
                service_date5_to = '".s_for($service_date5_to)."',
                place_of_service5 = '".s_for($place_of_service5)."',
                emg5 = '".s_for($emg5)."',
                cpt_hcpcs5 = '".s_for($cpt_hcpcs5)."',
                modifier5_1 = '".s_for($modifier5_1)."',
                modifier5_2 = '".s_for($modifier5_2)."',
                modifier5_3 = '".s_for($modifier5_3)."',
                modifier5_4 = '".s_for($modifier5_4)."',
                diagnosis_pointer5 = '".s_for($diagnosis_pointer5)."',
                s_charges5_1 = '".s_for($s_charges5_1)."',
                s_charges5_2 = '".s_for($s_charges5_2)."',
                days_or_units5 = '".s_for($days_or_units5)."',
                epsdt_family_plan5 = '".s_for($epsdt_family_plan5)."',
                id_qua5 = '".s_for($id_qua5)."',
                rendering_provider_id5 = '".s_for($rendering_provider_id5)."',
                service_date6_from = '".s_for($service_date6_from)."',
                service_date6_to = '".s_for($service_date6_to)."',
                place_of_service6 = '".s_for($place_of_service6)."',
                emg6 = '".s_for($emg6)."',
                cpt_hcpcs6 = '".s_for($cpt_hcpcs6)."',
                modifier6_1 = '".s_for($modifier6_1)."',
                modifier6_2 = '".s_for($modifier6_2)."',
                modifier6_3 = '".s_for($modifier6_3)."',
                modifier6_4 = '".s_for($modifier6_4)."',
                diagnosis_pointer6 = '".s_for($diagnosis_pointer6)."',
                s_charges6_1 = '".s_for($s_charges6_1)."',
                s_charges6_2 = '".s_for($s_charges6_2)."',
                days_or_units6 = '".s_for($days_or_units6)."',
                epsdt_family_plan6 = '".s_for($epsdt_family_plan6)."',
                id_qua6 = '".s_for($id_qua6)."',
                rendering_provider_id6 = '".s_for($rendering_provider_id6)."',
                federal_tax_id_number = '".s_for($federal_tax_id_number)."',
                ssn = '".s_for($ssn)."',
                ein = '".s_for($ein)."',
                patient_account_no = '".s_for($patient_account_no)."',
                accept_assignment = '".s_for($accept_assignment)."',
                total_charge = '".s_for($total_charge)."',
                amount_paid = '".s_for($amount_paid)."',
                balance_due = '".s_for($balance_due)."',
                signature_physician = '".s_for($signature_physician)."',
                physician_signed_date = '".s_for($physician_signed_date)."',
                service_facility_info_name = '".s_for($service_facility_info_name)."',
                service_facility_info_address = '".s_for($service_facility_info_address)."',
                service_facility_info_city = '".s_for($service_facility_info_city)."',
                service_info_a = '".s_for($service_info_a)."',
                service_info_dd = '".s_for($service_info_dd)."',
                service_info_b_other = '".s_for($service_info_b_other)."',
                billing_provider_phone_code = '".s_for($billing_provider_phone_code)."',
                billing_provider_phone = '".s_for($billing_provider_phone)."',
                billing_provider_name = '".s_for($billing_provider_name)."',
                billing_provider_address = '".s_for($billing_provider_address)."',
                billing_provider_city = '".s_for($billing_provider_city)."',
                billing_provider_a = '".s_for($billing_provider_a)."',
                billing_provider_dd = '".s_for($billing_provider_dd)."',
                billing_provider_b_other = '".s_for($billing_provider_b_other)."',
		p_m_eligible_payer_id = '".mysqli_real_escape_string($con,$p_m_eligible_payer_id)."',
                p_m_eligible_payer_name = '".mysqli_real_escape_string($con,$p_m_eligible_payer_name)."',
		primary_claim_id = '".mysqli_real_escape_string($con,$primary_claim_id)."',
                status = '".s_for(DSS_CLAIM_SEC_PENDING)."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
		producer = '".s_for($prod)."',
		p_m_billing_id='".s_for($p_m_billing_id)."',
		p_m_dss_file='".s_for($p_m_dss_file)."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
                
	$secondary_claim_id = $db->getInsertId($ins_sql);
	claim_history_update($secondary_claim_id, $_SESSION['userid'], '');

	$l_sql = "UPDATE dental_ledger SET secondary_claim_id = '".$secondary_claim_id."' 
			WHERE primary_claim_id='".$primary_claim_id."'";
	
  $db->query($l_sql);

	return $secondary_claim_id;
}

/**
 * Auxiliary function to retrieve the Eligible responses related to it. The response can be in one of three tables.
 *
 * @param int $claimId
 * @return array
 */
function retrieveEClaimResponse ($claimId) {
    $db = new Db();

    $claimId = intval($claimId);

    $paymentData = $db->getRow("SELECT payment_id, reference_id, adddate
        FROM dental_payment_reports
        WHERE claimid = '$claimId'
        ORDER BY adddate DESC
        LIMIT 1");

    if ($paymentData) {
        $response = [
            'type' => 'payment',
            'data' => $paymentData
        ];

        return $response;
    }

    // No payment, therefore search for eligible webhooks, or initial response
    $eResponse = $db->getRow("SELECT reference_id, response, adddate
        FROM dental_claim_electronic
        WHERE claimid = '$claimId'
        ORDER BY adddate DESC
        LIMIT 1");

    // If there are no e-responses of any kind, return the default, empty response
    if (!$eResponse) {
        $response = [
            'type' => 'none',
            'data' => []
        ];

        return $response;
    }

    // If there is an eligible reference, search for data in webhooks
    if ($eResponse['reference_id']) {
        $referenceId = $db->escape($eResponse['reference_id']);

        $eWebHook = $db->getRow("SELECT reference_id, event_type, adddate
            FROM dental_eligible_response
            WHERE (reference_id != '' AND reference_id = '$referenceId')
                OR claimid = '$claimId'
            ORDER BY adddate DESC
            LIMIT 1");

        // If there is data in the webhooks, overwrite the response array with this data
        if ($eWebHook) {
            $response = [
                'type' => 'webhook',
                'data' => $eWebHook
            ];

            return $response;
        }
    }

    /**
     * If the only response we got is the Eligible reply with the original submission, we need to parse the response
     * to determine if we have a rejection or something else.
     */
    $responseJson = @json_decode($eResponse['response']);

    if (is_array($responseJson) && !empty($responseJson['success'])) {
        $response = [
            'type' => 'response',
            'data' => [
                'event_type' => 'claim_submitted',
                'adddate' => $eResponse['adddate']
            ]
        ];
    } else {
        $response = [
            'type' => 'response',
            'data' => [
                'event_type' => 'claim_rejected',
                'adddate' => $eResponse['adddate']
            ]
        ];
    }

    return $response;
}

class ClaimFormData
{
    /**
     * @var bool
     */
    static $throwExceptions = false;

    /**
     * List of fields that need to be taken into consideration when populating boxes 32. and 33.
     *
     * @var array
     */
    private static $taxDataFields = [
        'city',
        'state',
        'zip',
        'phone',
        'practice',
        'address',
        'medicare_npi',
        'npi',
        'tax_id_or_ssn',
        'ssn',
        'ein',
        'use_service_npi',
        'service_city',
        'service_state',
        'service_zip',
        'service_name',
        'service_address',
        'service_medicare_npi',
        'service_npi'
    ];

    /**
     * @var array
     */
    private static $claimStatuses = [
        'pending'             => [DSS_CLAIM_PENDING, DSS_CLAIM_SEC_PENDING],
        'sent'                => [DSS_CLAIM_SENT, DSS_CLAIM_SEC_SENT],
        'paid'                => [DSS_CLAIM_PAID_INSURANCE, DSS_CLAIM_PAID_SEC_INSURANCE,
                                    DSS_CLAIM_PAID_INSURANCE, DSS_CLAIM_PAID_SEC_INSURANCE],
        'paid-insurance'      => [DSS_CLAIM_PAID_INSURANCE, DSS_CLAIM_PAID_SEC_INSURANCE],
        'paid-patient'        => [DSS_CLAIM_PAID_PATIENT, DSS_CLAIM_PAID_SEC_PATIENT],
        'dispute'             => [DSS_CLAIM_DISPUTE, DSS_CLAIM_SEC_DISPUTE,
                                    DSS_CLAIM_PATIENT_DISPUTE, DSS_CLAIM_SEC_PATIENT_DISPUTE],
        'dispute-not-patient' => [DSS_CLAIM_DISPUTE, DSS_CLAIM_SEC_DISPUTE],
        'dispute-patient'     => [DSS_CLAIM_PATIENT_DISPUTE, DSS_CLAIM_SEC_PATIENT_DISPUTE],
        'rejected'            => [DSS_CLAIM_REJECTED, DSS_CLAIM_SEC_REJECTED],
        'efile-accepted'      => [DSS_CLAIM_EFILE_ACCEPTED, DSS_CLAIM_SEC_EFILE_ACCEPTED],
    ];

    /**
     * Auxiliary function to determine sequence of the claim status
     *
     * @param int $status
     * @return bool
     */
    public static function isPrimary ($status) {
        return !self::isSecondary($status);
    }

    /**
     * Auxiliary function to determine sequence of the claim status
     *
     * @param int $status
     * @return bool
     */
    public static function isSecondary ($status) {
        return in_array(
            $status,
            [
                DSS_CLAIM_SEC_PENDING,
                DSS_CLAIM_SEC_SENT,
                DSS_CLAIM_SEC_DISPUTE,
                DSS_CLAIM_PAID_SEC_INSURANCE,
                DSS_CLAIM_PAID_SEC_PATIENT,
                DSS_CLAIM_SEC_PATIENT_DISPUTE,
                DSS_CLAIM_SEC_REJECTED,
                DSS_CLAIM_SEC_EFILE_ACCEPTED,
            ]
        );
    }

    /**
     * Auxiliary function to get the list of statuses that belong to a status label
     *
     * Most statuses are pairs, being the first one the primary, and the second one the secondary.
     *
     * In case there are more than 2 states, odd elements represent primary statuses, even elements represent
     * secondary statuses.
     *
     * @param string $name
     * @return array
     */
    public static function statusListByName ($name) {
        $statusList = self::$claimStatuses;

        if (array_key_exists($name, $statusList)) {
                return $statusList[$name];
        }

        return [];
    }

    /**
     * Auxiliary method to identify associated statuses. Useful for filtering functionality where the legacy code
     * only implements a single status (almost always primary).
     *
     * The function can return an empty array, or an array with one or two items.
     * There are statuses that appear in more than one named status.
     *
     * @param int $status
     * @return array
     */
    public static function statusListByStatus ($status) {
        $statusList = self::$claimStatuses;

        // Only return sections of the statuses where the status appear
        $filteredList = array_filter($statusList, function ($statuses) use ($status) {
            return in_array($status, $statuses);
        });

        return $filteredList;
    }

    /**
     * Auxiliary function to determine if some status matches its label/name
     *
     * @param string $name
     * @param int    $status
     * @return bool
     */
    public static function isStatus ($name, $status) {
        $statusList = self::statusListByName($name);

        return in_array($status, $statusList);
    }

    /**
     * Auxiliary function to error logs, or throw exceptions
     *
     * @param string $message
     * @throws \RuntimeException
     */
    private static function raiseError ($message) {
        if (self::$throwExceptions) {
            throw new \RuntimeException($message);
        }

        error_log($message);
    }

    /**
     * Auxiliary method to:
     *
     * - whitelist db column fields
     * - escape fields
     * - concatenate fields: column_name = "column value", ...
     * 
     * Ready for DB insertion
     *
     * @param array $claimData
     * @return string
     */
    private static function prepareClaimDataFields ($claimData) {
        $db = new Db();

        $dbFields = [
            'pica1',
            'pica2',
            'pica3',
            'insurance_type',
            'other_insurance_type',
            'insured_id_number',
            'patient_lastname',
            'patient_firstname',
            'patient_middle',
            'patient_dob',
            'patient_sex',
            'insured_firstname',
            'insured_lastname',
            'insured_middle',
            'patient_address',
            'patient_relation_insured',
            'patient_relation_other_insured',
            'patient_city',
            'patient_state',
            'patient_status',
            'responsibility_sequence',
            'another_plan',
            'icd_ind',
            'insured_address',
            'insured_city',
            'insured_state',
            'insured_zip',
            'other_insured_address',
            'other_insured_city',
            'other_insured_state',
            'other_insured_zip',
            'patient_zip',
            'patient_phone_code',
            'patient_phone',
            'insured_phone_code',
            'insured_phone',
            'other_insured_firstname',
            'other_insured_lastname',
            'other_insured_middle',
            'employment',
            'auto_accident',
            'auto_accident_place',
            'other_accident',
            'insured_policy_group_feca',
            'other_insured_policy_group_feca',
            'insured_dob',
            'insured_sex',
            'other_insured_dob',
            'other_insured_sex',
            'insured_employer_school_name',
            'other_insured_employer_school_name',
            'insured_insurance_plan',
            'other_insured_insurance_plan',
            'reserved_local_use',
            'patient_signature',
            'patient_signed_date',
            'insured_signature',
            'date_current',
            'date_same_illness',
            'unable_date_from',
            'unable_date_to',
            'referring_provider',
            'field_17a_dd',
            'field_17a',
            'field_17b',
            'hospitalization_date_from',
            'hospitalization_date_to',
            'reserved_local_use1',
            'outside_lab',
            's_charges',
            'diagnosis_1',
            'diagnosis_2',
            'diagnosis_3',
            'diagnosis_4',
            'diagnosis_a',
            'diagnosis_b',
            'diagnosis_c',
            'diagnosis_d',
            'diagnosis_e',
            'diagnosis_f',
            'diagnosis_g',
            'diagnosis_h',
            'diagnosis_i',
            'diagnosis_j',
            'diagnosis_k',
            'diagnosis_l',
            'resubmission_code_fill',
            'medicaid_resubmission_code',
            'original_ref_no',
            'prior_authorization_number',
            'service_date1_from',
            'service_date1_to',
            'place_of_service1',
            'emg1',
            'cpt_hcpcs1',
            'modifier1_1',
            'modifier1_2',
            'modifier1_3',
            'modifier1_4',
            'diagnosis_pointer1',
            's_charges1_1',
            's_charges1_2',
            'days_or_units1',
            'epsdt_family_plan1',
            'id_qua1',
            'rendering_provider_id1',
            'service_date2_from',
            'service_date2_to',
            'place_of_service2',
            'emg2',
            'cpt_hcpcs2',
            'modifier2_1',
            'modifier2_2',
            'modifier2_3',
            'modifier2_4',
            'diagnosis_pointer2',
            's_charges2_1',
            's_charges2_2',
            'days_or_units2',
            'epsdt_family_plan2',
            'id_qua2',
            'rendering_provider_id2',
            'service_date3_from',
            'service_date3_to',
            'place_of_service3',
            'emg3',
            'cpt_hcpcs3',
            'modifier3_1',
            'modifier3_2',
            'modifier3_3',
            'modifier3_4',
            'diagnosis_pointer3',
            's_charges3_1',
            's_charges3_2',
            'days_or_units3',
            'epsdt_family_plan3',
            'id_qua3',
            'rendering_provider_id3',
            'service_date4_from',
            'service_date4_to',
            'place_of_service4',
            'emg4',
            'cpt_hcpcs4',
            'modifier4_1',
            'modifier4_2',
            'modifier4_3',
            'modifier4_4',
            'diagnosis_pointer4',
            's_charges4_1',
            's_charges4_2',
            'days_or_units4',
            'epsdt_family_plan4',
            'id_qua4',
            'rendering_provider_id4',
            'service_date5_from',
            'service_date5_to',
            'place_of_service5',
            'emg5',
            'cpt_hcpcs5',
            'modifier5_1',
            'modifier5_2',
            'modifier5_3',
            'modifier5_4',
            'diagnosis_pointer5',
            's_charges5_1',
            's_charges5_2',
            'days_or_units5',
            'epsdt_family_plan5',
            'id_qua5',
            'rendering_provider_id5',
            'service_date6_from',
            'service_date6_to',
            'place_of_service6',
            'emg6',
            'cpt_hcpcs6',
            'modifier6_1',
            'modifier6_2',
            'modifier6_3',
            'modifier6_4',
            'diagnosis_pointer6',
            's_charges6_1',
            's_charges6_2',
            'days_or_units6',
            'epsdt_family_plan6',
            'id_qua6',
            'rendering_provider_id6',
            'federal_tax_id_number',
            'ssn',
            'ein',
            'patient_account_no',
            'accept_assignment',
            'total_charge',
            'amount_paid',
            'balance_due',
            'signature_physician',
            'physician_signed_date',
            'service_facility_info_name',
            'service_facility_info_address',
            'service_facility_info_city',
            'service_info_a',
            'service_info_dd',
            'service_info_b_other',
            'billing_provider_phone_code',
            'billing_provider_phone',
            'billing_provider_name',
            'billing_provider_address',
            'billing_provider_city',
            'billing_provider_a',
            'billing_provider_dd',
            'billing_provider_b_other',
            'p_m_eligible_payer_id',
            'p_m_eligible_payer_name',
            'p_m_billing_id',
            'p_m_dss_file',
            'billing_provider_taxonomy_code',

            'patientid',
            'docid',
            'userid',
            'producer',
            'status',
            'primary_claim_id',
            'ip_address'
        ];

        $escapedFields = [];

        foreach ($dbFields as $field) {
            $value = isset($claimData[$field]) ? $db->escape($claimData[$field]) : '';
            $escapedFields []= "$field = '$value'";
        }

        return implode(', ', $escapedFields);
    }

    /**
     * Auxiliary function to retrieve amount paid, from the primary claim
     *
     * @param int $claimId
     * @return int|float
     */
    public static function amountPaidForClaim ($claimId) {
        $db = new Db();
        $amount = 0;

        $primaryClaim = $db->getRow("SELECT amount_paid
            FROM dental_insurance
            WHERE insuranceid = '$claimId'");

        if ($primaryClaim) {
            $amount = $primaryClaim['amount_paid'];
        }

        return $amount;
    }

    /**
     * Retrieve ledger items for either the given claim, or a new claim
     *
     * @param int $claimId
     * @param int $docId
     * @param int $patientId
     * @param int $insuranceType
     * @return array
     */
    public static function ledgerItems ($claimId, $docId, $patientId, $insuranceType) {
        $db = new Db();

        $claimId = intval($claimId);
        $docId = intval($docId);
        $patientId = intval($patientId);

        $isNewClaim = !$claimId;

        $trxnStatusPending = DSS_TRXN_PENDING;
        $trxnTypeMed = DSS_TRXN_TYPE_MED;

        // Non-strict comparison
        $insuranceSource = $insuranceType == 1 ? 'medicare_npi' : 'npi';
        $pendingOrLinkedConditional = $isNewClaim ? "ledger.status = '$trxnStatusPending'" :
            "(ledger.primary_claim_id = '$claimId' OR ledger.secondary_claim_id = '$claimId')";

        /**
         * Control the source of the producer / doctor.
         *
         * The LEFT JOIN on producerid will set the proper values for the producer. If the producerid is not valid then
         * the joined values will be null, evaluating to FALSE by default.
         *
         * Thus, the producer is the source of data if:
         *
         * - ledger.producerid is valid (given by the LEFT JOIN)
         * - producer.producer_files is set to "1"
         * - the given field is not empty
         *
         * Otherwise, retrieve data from the doctor.
         */
        $transactionsQuery = "SELECT
            ledger.*,
            trxn_code.days_units AS daysorunits,
            name_source.place_service AS 'place',
            description_source.description AS place_description,
            CASE WHEN producer.producer_files AND LENGTH(TRIM(producer.$insuranceSource))
                THEN producer.$insuranceSource
                ELSE doctor.$insuranceSource
            END AS 'provider_id',
            CASE WHEN producer.producer_files AND LENGTH(TRIM(producer.first_name))
                THEN producer.first_name
                ELSE doctor.first_name
            END AS 'provider_first_name',
            CASE WHEN producer.producer_files AND LENGTH(TRIM(producer.last_name))
                THEN producer.last_name
                ELSE doctor.last_name
            END AS 'provider_last_name'
        FROM dental_ledger ledger
            JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code
            JOIN dental_users doctor ON doctor.userid = ledger.docid
            LEFT JOIN dental_users producer ON producer.userid = ledger.producerid
            LEFT JOIN dental_place_service name_source ON name_source.place_serviceid = trxn_code.place
            LEFT JOIN dental_place_service description_source
                ON description_source.place_service = ledger.placeofservice
        WHERE $pendingOrLinkedConditional
            AND ledger.patientid = '$patientId'
            AND ledger.docid = '$docId'
            AND trxn_code.docid = '$docId'
            AND trxn_code.type = '$trxnTypeMed'
        ORDER BY ledger.service_date ASC, ledger.amount DESC, ledger.ledgerid DESC";

        $transactions = $db->getResults($transactionsQuery);
        return $transactions;
    }

    /**
     * Base fields to include in a claim
     *
     * @param  int    $patientId
     * @param  int    $producerId
     * @param  string $sequence
     * @param  int    $primaryClaimId
     * @throws \RuntimeException
     * @return array
     */
    private static function emptyClaimData ($patientId, $producerId, $sequence, $primaryClaimId) {
        /**
         * Always assume primary unless explicit request of secondary
         * Also, enforce valid values for primary claim ids, or we will have "dangling" secondary claims
         */
        $isPrimary = $sequence !== 'secondary';

        /**
         * If the claim is secondary, then has_s_m_ins MUST be true and $primaryClaimId must be set
         */
        if (!$isPrimary && !$primaryClaimId) {
            self::raiseError(
                "Cannot create secondary claim for patientId $patientId, producerId $producerId. " .
                "\$primaryClaimId is empty"
            );
        }

        $docId = intval($_SESSION['docid']);
        $userId = intval($_SESSION['userid']);

        return [
            'patientid' => $patientId,
            'producer' => $producerId,
            'docid' => $docId,
            'userid' => $userId,
            'status' => $isPrimary ? DSS_CLAIM_PENDING : DSS_CLAIM_SEC_PENDING,
            'primary_claim_id' => $isPrimary ? 0 : $primaryClaimId
        ];
    }

    /**
     * Gather patient, doctor, and insurance data for the claim. Does not process ledger transactions.
     * 
     * @param  int    $patientId
     * @param  int    $producerId
     * @param  string $sequence
     * @param  int    $primaryClaimId
     * @throws \RuntimeException
     * @return array
     */
    public static function dynamicClaimData ($patientId, $producerId, $sequence='primary', $primaryClaimId=null) {
        $db = new Db();

        $patientId = intval($patientId);
        $producerId = intval($producerId);

        /**
         * Only two possible options: primary or secondary
         */
        $isPrimary = strtolower($sequence) !== 'secondary';

        /**
         * If the CLAIM SEQUENCE is PRIMARY, then:
         * - insured data comes from fields marked as "p_m_..."
         * - other insured data comes from fields marked as "s_m_..."
         *
         * If the CLAIM SEQUENCE is SECONDARY, then:
         * - insured data comes from fields marked as "p_m_..."
         * - other insured data comes from fields marked as "s_m_..."
         *
         * Instead of switching each field individually, define prefixes to read from the correct fields
         * It is also possible to parse the fields, and generate some array:
         *
         * $patientData['p_m_dss_file']    --->    $patientData['p_m']['dss_file']
         * $patientData['s_m_dss_file']    --->    $patientData['s_m']['dss_file']
         *
         * Then read the equivalent values, from different arrays
         *
         * This trick does NOT work for Date of Birth fields, the names are ins_dob and ins2_dob
         */
        $primaryPrefix = $isPrimary ? 'p_m' : 's_m';
        $secondaryPrefix = $isPrimary ? 's_m' : 'p_m';

        $patientData = $db->getRow("SELECT p.*, u.billing_company_id
            FROM dental_patients p
                JOIN dental_users u ON u.userid=p.docid
            WHERE p.patientid = '$patientId'");

        $docId = intval($patientData['docid']);
        $hasSecondaryInsurance = isOptionSelected($patientData['has_s_m_ins']);

        /**
         * If the claim is secondary, then has_s_m_ins MUST be true
         */
        if (!$isPrimary && !$hasSecondaryInsurance) {
            self::raiseError(
                "Dynamic claim data for patientId $patientId, producerId $producerId inconsistency: " .
                "the sequence is secondary but the patient does not have secondary insurance enabled."
            );
        }

        $claimData = self::emptyClaimData($patientId, $producerId, $sequence, $primaryClaimId);

        $claimData['patient_firstname'] = $patientData['firstname'];
        $claimData['patient_lastname'] = $patientData['lastname'];
        $claimData['patient_middle'] = $patientData['middlename'];
        $claimData['patient_address'] = $patientData['add1'];
        $claimData['patient_city'] = $patientData['city'];
        $claimData['patient_state'] = $patientData['state'];
        $claimData['patient_zip'] = $patientData['zip'];
        $claimData['patient_dob'] = $patientData['dob'];
        $claimData['patient_sex'] = $patientData['gender'];

        // Not sure what these fields do
        $claimData['p_m_dss_file'] = $patientData["{$primaryPrefix}_dss_file"];
        $claimData['p_m_billing_id'] = $patientData['billing_company_id'];

        $insuranceType = $patientData["{$primaryPrefix}_ins_type"];
        $isMedicare = $insuranceType == 1;

        $claimData['insurance_type']                  = $insuranceType;
        $claimData['insured_firstname']               = $patientData["{$primaryPrefix}_partyfname"];
        $claimData['insured_lastname']                = $patientData["{$primaryPrefix}_partylname"];
        $claimData['insured_middle']                  = $patientData["{$primaryPrefix}_partymname"];
        $claimData['insured_id_number']               = $patientData["{$primaryPrefix}_ins_id"];
        $claimData['insured_insurance_plan']          = $patientData["{$primaryPrefix}_ins_plan"];
        $claimData['insured_policy_group_feca']       = $patientData["{$primaryPrefix}_ins_grp"];
        $claimData['insured_sex']                     = $patientData["{$primaryPrefix}_gender"];

        $claimData['other_insurance_type']            = $patientData["{$secondaryPrefix}_ins_type"];
        $claimData['other_insured_firstname']         = $patientData["{$secondaryPrefix}_partyfname"];
        $claimData['other_insured_lastname']          = $patientData["{$secondaryPrefix}_partylname"];
        $claimData['other_insured_middle']            = $patientData["{$secondaryPrefix}_partymname"];
        $claimData['other_insured_id_number']         = $patientData["{$secondaryPrefix}_ins_id"];
        $claimData['other_insured_insurance_plan']    = $patientData["{$secondaryPrefix}_ins_plan"];
        $claimData['other_insured_policy_group_feca'] = $patientData["{$secondaryPrefix}_ins_grp"];
        $claimData['other_insured_sex']               = $patientData["{$secondaryPrefix}_gender"];

        /**
         * DOB fields are exceptions to the naming rule
         *
         * Sequence value represents the alternate source of insurance data.
         * Therefore, its value is inverse to the sequence
         */
        if ($isPrimary) {
            $claimData['insured_dob'] = $patientData['ins_dob'];
            $claimData['other_insured_dob'] = $patientData['ins2_dob'];
            $claimData['responsibility_sequence'] = $hasSecondaryInsurance ? 'S' : '';
        } else {
            $claimData['insured_dob'] = $patientData['ins2_dob'];
            $claimData['other_insured_dob'] = $patientData['ins_dob'];
            $claimData['responsibility_sequence'] = 'P';
        }

        /**
         * @see CS-29
         *
         * Default value since 10-oct-2015
         * We depend on ledger entries dates. We don't have them available here, we just guess
         */
        $claimData['icd_ind'] = 10;

        $claimData['another_plan'] = $hasSecondaryInsurance || !$isPrimary;
        $claimData['insured_signature'] = isOptionSelected($patientData["{$primaryPrefix}_ins_ass"]);

        $claimData['patient_signature'] = 1;
        $claimData['signature_physician'] = 1;
        $claimData['patient_signed_date'] = dateFormat($patientData['adddate']);
        $claimData['physician_signed_date'] = dateFormat('Y-m-d');
        list($claimData['patient_phone_code'], $claimData['patient_phone']) =
            parsePhoneNumber($patientData['home_phone']);
        list($claimData['insured_phone_code'], $claimData['insured_phone']) =
            parsePhoneNumber($patientData['home_phone']);
        $claimData['patient_status'] = $patientData['marital_status'];
        $claimData['insured_id_number'] = $patientData["{$primaryPrefix}_ins_id"];

        if (isOptionSelected($patientData["{$primaryPrefix}_same_address"])) {
            $claimData['insured_address'] = $patientData['add1'];
            $claimData['insured_city'] = $patientData['city'];
            $claimData['insured_state'] = $patientData['state'];
            $claimData['insured_zip'] = $patientData['zip'];
        } else {
            $claimData['insured_address'] = $patientData["{$primaryPrefix}_address"];
            $claimData['insured_city'] = $patientData["{$primaryPrefix}_city"];
            $claimData['insured_state'] = $patientData["{$primaryPrefix}_state"];
            $claimData['insured_zip'] = $patientData["{$primaryPrefix}_zip"];
        }

        if (isOptionSelected($patientData["{$secondaryPrefix}_same_address"])) {
            $claimData['other_insured_address'] = $patientData['add1'];
            $claimData['other_insured_city'] = $patientData['city'];
            $claimData['other_insured_state'] = $patientData['state'];
            $claimData['other_insured_zip'] = $patientData['zip'];
        } else {
            $claimData['other_insured_address'] = $patientData["{$secondaryPrefix}_address"];
            $claimData['other_insured_city'] = $patientData["{$secondaryPrefix}_city"];
            $claimData['other_insured_state'] = $patientData["{$secondaryPrefix}_state"];
            $claimData['other_insured_zip'] = $patientData["{$secondaryPrefix}_zip"];
        }

        $claimData['patient_relation_insured'] = $patientData["{$primaryPrefix}_relation"];
        $claimData['patient_relation_other_insured'] = $patientData["{$secondaryPrefix}_relation"];
        $claimData['insured_employer_school_name'] = $patientData['employer'];
        $claimData['p_m_eligible_payer_id'] = $patientData["{$primaryPrefix}_eligible_payer_id"];
        $claimData['p_m_eligible_payer_name'] = $patientData["{$primaryPrefix}_eligible_payer_name"];
        $claimData['accept_assignment'] = $patientData["{$primaryPrefix}_ins_ass"];

        $producerData = $db->getRow("SELECT * FROM dental_users WHERE producer_files = 1 AND userid = '$producerId'");
        $doctorData = $db->getRow("SELECT * FROM dental_users WHERE userid = '$docId'");

        /**
         * 'producer_files' signals whether the action must be marked as the original producer OR the current docid
         *
         * IF $producerData['producer_files'] == 1
         * THEN use producer data, fallback to doctor data
         * ELSE use doctor data
         *
         * Set the doctor data first. Overwrite values where appropiate IF producer_files = 1
         */
        $taxSource = array_only($doctorData, self::$taxDataFields);

        if ($producerData['producer_files'] == 1) {
            array_walk($taxSource, function (&$taxField, $index) use ($producerData) {
                $producerField = trim($producerData[$index]);

                // IF producer_files = 1 THEN use the option from the producer
                if ($index === 'use_service_npi') {
                    $taxField = $producerField;
                }

                // If the corresponding producer value is set, use that value instead
                if (strlen($producerField)) {
                    $taxField = $producerField;
                }
            });
        }

        /**
         * Billing info always comes from the same place. Service info has the following restrictions:
         *
         * IF $isMedicare THEN empty
         * IF use_service_npi THEN service info
         * ELSE same as billing info
         */
        $billingAddress = [
            'city' => $taxSource['city'],
            'state' => $taxSource['state'],
            'zip' => $taxSource['zip']
        ];

        $claimData['billing_provider_phone'] = $taxSource['phone'];
        $claimData['billing_provider_name'] = $taxSource['practice'];
        $claimData['billing_provider_address'] = $taxSource['address'];
        $claimData['billing_provider_city'] = trim(preg_replace('/ +/', ' ', implode(' ', $billingAddress)));
        $claimData['billing_provider_a'] = $isMedicare ? $taxSource['medicare_npi'] : $taxSource['npi'];

        $claimData['federal_tax_id_number'] = $taxSource['tax_id_or_ssn'];
        $claimData['ssn'] = $taxSource['ssn'];
        $claimData['ein'] = !$taxSource['ssn'];

        /**
         * Only include service facility info IF NOT Medicare
         */
        if (!$isMedicare) {
            /**
             * IF user_service_npi
             * THEN populate from service facility info
             * ELSE copy from billing info
             */
            if ($taxSource['use_service_npi'] == 1) {
                $serviceAddress = [
                    'city' => $taxSource['service_city'],
                    'state' => $taxSource['service_state'],
                    'zip' => $taxSource['service_zip']
                ];

                $claimData['service_facility_info_name'] = $taxSource['service_name'];
                $claimData['service_facility_info_address'] = $taxSource['service_address'];
                $claimData['service_facility_info_city'] =
                    trim(preg_replace('/ +/', ' ', implode(' ', $serviceAddress)));
                $claimData['service_info_a'] = $isMedicare ?
                    $taxSource['service_medicare_npi'] : $taxSource['service_npi'];
            } else {
                $claimData['service_facility_info_name'] = $claimData['billing_provider_name'];
                $claimData['service_facility_info_address'] = $claimData['billing_provider_address'];
                $claimData['service_facility_info_city'] = $claimData['billing_provider_city'];
                $claimData['service_info_a'] = $claimData['billing_provider_a'];
            }
        }

        /**
         * Retrieve diagnosis
         * Also referrer details, fields 17a. 17b. (only for Medicare)
         */
        $sleepStudies = $db->getRow("SELECT ss.diagnosis, ss.diagnosising_doc, ss.diagnosising_npi
            FROM dental_summ_sleeplab ss
                JOIN dental_patients p ON ss.patiendid = p.patientid
            WHERE (
                    p.p_m_ins_type != '1'
                    OR (
                        COALESCE(ss.diagnosising_doc, '') != ''
                        AND COALESCE(ss.diagnosising_npi, '') != ''
                    )
                )
                AND COALESCE(ss.diagnosis, '') != ''
                AND ss.filename IS NOT NULL
                AND ss.patiendid = '$patientId'");

        if ($sleepStudies) {
            $claimData['diagnosis_1'] = $sleepStudies['diagnosis'];
            $diagnosisId = intval($claimData['diagnosis_1']);

            $ins_diag = $db->getRow("SELECT * FROM dental_ins_diagnosis WHERE ins_diagnosisid = '$diagnosisId'");
            $claimData['diagnosis_a'] = $ins_diag['ins_diagnosis'];

            // Fields 17a. 17b.
            if ($isMedicare) {
                $claimData['referring_provider'] = $sleepStudies['diagnosising_doc'];
                $claimData['field_17b'] = $sleepStudies['diagnosising_npi'];
                $claimData['name_referring_provider_qualifier'] = 'DN';
            }
        }

        // If claim doesn't yet have a preauth number, try to load it
        // from the patient's most recently completed preauth.
        if (empty($claimData['prior_authorization_number'])) {
            $preAuthStatus = DSS_PREAUTH_COMPLETE;
            $preAuth = $db->getRow("SELECT *
                FROM dental_insurance_preauth
                WHERE patient_id = '$patientId'
                    AND status = $preAuthStatus
                ORDER BY date_completed DESC LIMIT 1");

            if ($preAuth) {
                $claimData['prior_authorization_number'] = $preAuth['pre_auth_num'];
            }
        }

        if (!$isPrimary) {
            $claimData['amount_paid'] = self::amountPaidForClaim($primaryClaimId);
        }

        $claimData['resubmission_code_fill'] = 1;
        $claimData['billing_provider_taxonomy_code'] = '332B00000X';

        return $claimData;
    }


    /**
     * Create new claim item, including patient, doctor, and insurance data. Does not process ledger transactions.
     *
     * @param int    $patientId
     * @param int    $producerId
     * @param string $sequence
     * @param int    $primaryClaimId
     * @param bool   $empty
     * @return int
     */
    public static function createClaim ($patientId, $producerId, $sequence, $primaryClaimId, $empty=false) {
        $db = new Db();

        $patientId = intval($patientId);
        $producerId = intval($producerId);
        $primaryClaimId = intval($primaryClaimId);

        $claimData = $empty ?
            self::emptyClaimData($patientId, $producerId, $sequence, $primaryClaimId) :
            self::dynamicClaimData($patientId, $producerId, $sequence, $primaryClaimId);
        $claimData['ip_address'] = $_SERVER['REMOTE_ADDR'];

        /**
         * Add amount_paid if the claim is secondary
         */
        if ($sequence === 'secondary') {
            $claimData['amount_paid'] = self::amountPaidForClaim($primaryClaimId);
        }

        $preparedFields = self::prepareClaimDataFields($claimData);

        $newClaimQuery = "INSERT INTO dental_insurance SET
            adddate = NOW(),
            $preparedFields";

        $newClaimId = $db->getInsertId($newClaimQuery);

        /**
         * Now, associate current ledger items to the secondary claim
         */
        if ($sequence === 'secondary') {
            $db->query("UPDATE dental_ledger
              SET secondary_claim_id = '$newClaimId'
              WHERE primary_claim_id = '$primaryClaimId'");
        }

        return $newClaimId;
    }

    /**
     * Does not process ledger transactions.
     *
     * @param int $patientId
     * @param int $producerId
     * @return int
     */
    public static function createPrimaryClaim ($patientId, $producerId) {
        return self::createClaim($patientId, $producerId, 'primary', null, false);
    }

    /**
     * Only saves patientid, docid, userid, producer and adddate.
     *
     * @param int $patientId
     * @param int $producerId
     * @return int
     */
    public static function createEmptyPrimaryClaim ($patientId, $producerId) {
        return self::createClaim($patientId, $producerId, 'primary', null, true);
    }

    /**
     * Does not process ledger transactions.
     *
     * @param int $patientId
     * @param int $producerId
     * @param int $primaryClaimId
     * @return int
     */
    public static function createSecondaryClaim ($patientId, $producerId, $primaryClaimId) {
        return self::createClaim($patientId, $producerId, 'secondary', $primaryClaimId, false);
    }

    /**
     * Only saves
     *
     * @param int $patientId
     * @param int $producerId
     * @param int $primaryClaimId
     * @return int
     */
    public static function createEmptySecondaryClaim ($patientId, $producerId, $primaryClaimId) {
        return self::createClaim($patientId, $producerId, 'secondary', $primaryClaimId, true);
    }

    /**
     * @param int $claimId
     * @return array
     */
    public static function dynamicDataForClaim ($claimId) {
        $db = new Db();
        $claimId = intval($claimId);

        $claimDetails = $db->getRow("SELECT patientid, producer, status, primary_claim_id
            FROM dental_insurance
            WHERE insuranceid = '$claimId'");
        $claimDetails = $claimDetails ?: [];

        if (!count($claimDetails)) {
            self::raiseError("The claim $claimId does not exist");
        }

        $patientId = array_get($claimDetails, 'patientid', 0);
        $producerId = array_get($claimDetails, 'producer', 0);
        $status = array_get($claimDetails, 'status', 0);
        $primaryClaimId = array_get($claimDetails, 'primary_claim_id', 0);

        $sequence = in_array($status, [DSS_CLAIM_SEC_PENDING, DSS_CLAIM_SEC_SENT, DSS_CLAIM_SEC_DISPUTE, DSS_CLAIM_SEC_REJECTED]) ?
            'secondary' : 'primary';

        $claimData = self::dynamicClaimData($patientId, $producerId, $sequence, $primaryClaimId);

        // Some scripts will rely on the insuranceid field being set
        $claimData['insuranceid'] = $claimId;

        return $claimData;
    }

    /**
     * Claim model
     *
     * @param int      $claimId
     * @param int|null $patientId
     * @return array
     */
    public static function storedDataForClaim ($claimId, $patientId=null) {
        $db = new Db();
        $claimId = intval($claimId);

        $sql = "SELECT * FROM dental_insurance WHERE insuranceid = '$claimId'";

        if (!is_null($patientId)) {
            $patientId = intval($patientId);
            $sql .= " AND patientid = '$patientId'";
        }

        $claimData = $db->getRow($sql);

        return $claimData ?: [];
    }
}

/**
 * Auxiliary function for webhooks / Eligible events
 *
 * @param int $referenceId
 * @return string
 */
function referenceIdFromClaimId ($claimId) {
    $db = new Db();
    $claimId = intval($claimId);

    $eClaim = $db->getRow("SELECT reference_id
        FROM dental_claim_electronic
        WHERE COALESCE(claimid, '') != '' AND claimid = '$claimId'");

    return $eClaim ? $eClaim['reference_id'] : '';
}

/**
 * Auxiliary function for webhooks / Eligible events
 *
 * @param string $referenceId
 * @return int
 */
function claimIdFromReferenceId ($referenceId) {
    $db = new Db();
    $referenceId = $db->escape($referenceId);

    $eClaim = $db->getRow("SELECT claimid
        FROM dental_claim_electronic
        WHERE COALESCE(reference_id, '') != '' AND reference_id = '$referenceId'");

    return $eClaim ? intval($eClaim['claimid']) : 0;
}

/**
 * Auxiliary function for webhooks / Eligible events
 *
 * @param string $referenceId
 * @return array
 */
function minimalClaimDataFromReferenceId ($referenceId) {
    $db = new Db();

    $claimId = claimIdFromReferenceId($referenceId);

    $claim = $db->getRow("SELECT insuranceid, status
        FROM dental_insurance
        WHERE insuranceid = '$claimId'");

    return $claim ?: [];
}

/**
 * Encapsulate update status logic
 *
 * @param string $referenceId
 * @param string $statusName
 */
function updateClaimStatusFromReferenceId ($referenceId, $statusName) {
    $db = new Db();

    $claimData = minimalClaimDataFromReferenceId($referenceId);

    echo "Claim ID {$claimData['insuranceid']} with reference '$referenceId' needs to change to status '$statusName'";

    /**
     * Update claim only if the statuses differ
     */
    if ($claimData && !ClaimFormData::isStatus($statusName, $claimData['status'])) {
        // This status list returns a pair: [primary status, secondary status]
        $possibleStatuses = ClaimFormData::statusListByName($statusName);
        $newStatus = ClaimFormData::isPrimary($claimData['status']) ? $possibleStatuses[0] : $possibleStatuses[1];

        $db->query("UPDATE dental_insurance
            SET status = '".$db->escape($newStatus)."'
            WHERE insuranceid = '".$db->escape($claimData['insuranceid'])."'");

        claim_status_history_update($claimData['insuranceid'], $newStatus, $claimData['status'], 0, 0);
    }
}

/**
 * Encapsulates the logic that sets the claim status (and other values) based on Eligible events
 *
 * @param string $plainTextResponse
 * @param bool   $saveResponse
 * @return object
 */
function processEligibleResponse ($plainTextResponse, $saveResponse = true) {
    $db = new Db();
    $jsonResponse = json_decode($plainTextResponse);

    /**
     * JSON.event = claim event
     * JSON.status = acknowledgement event
     */
    $eventType = !empty($jsonResponse->event) ? $jsonResponse->event : $jsonResponse->status;
    $referenceId = isset($jsonResponse->reference_id) ? $jsonResponse->reference_id : '';

    switch ($eventType) {
        case 'claim_rejected':
        case 'claim_denied':
        case 'claim_more_info_required':
        case 'rejected':
        case 'denied':
        case 'more_info_required':
            updateClaimStatusFromReferenceId($referenceId, 'rejected');
            break;
        case 'claim_paid':
        case 'paid':
            updateClaimStatusFromReferenceId($referenceId, 'paid-insurance');
            break;
        case 'claim_submitted':
        case 'claim_pended':
        case 'claim_created':
        case 'claim_received':
        case 'submitted':
        case 'pended':
        case 'created':
        case 'received':
            updateClaimStatusFromReferenceId($referenceId, 'sent');
            break;
        case 'claim_accepted':
        case 'accepted':
            updateClaimStatusFromReferenceId($referenceId, 'efile-accepted');
            break;
        case 'enrollment_status':
            $referenceId = $jsonResponse->details->id;
            $status = $jsonResponse->details->status;

            if ($status == 'accepted') {
                $db->query("UPDATE dental_eligible_enrollment SET
                    status = '1'
                    WHERE reference_id = '".$db->escape($referenceId)."'");
            }

            break;
        case 'received_pdf':
            $referenceId = $jsonResponse->details->id;
            $downloadUrl = $jsonResponse->details->received_pdf->download_url;

            if ($downloadUrl) {
                $db->query("UPDATE dental_eligible_enrollment SET
                    status = '".DSS_ENROLLMENT_PDF_RECEIVED."',
                    download_url = '".$db->escape($downloadUrl)."'
                    WHERE reference_id = '".$db->escape($referenceId)."'");
            }

            break;
        case 'payment_report':
            $claimId = claimIdFromReferenceId($referenceId);

            $db->query("INSERT INTO dental_payment_reports SET
                claimid = '$claimId',
                reference_id = '".$db->escape($referenceId)."',
                response = '".$db->escape($plainTextResponse)."',
                adddate = now(),
                ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'");

            updateClaimStatusFromReferenceId($referenceId, 'paid-insurance');

            break;
    }

    /**
     * Save webhook payload
     */
    if ($saveResponse) {
        $db->query("INSERT INTO dental_eligible_response SET
            response = '".$db->escape($plainTextResponse)."',
            reference_id = '".$db->escape($referenceId)."',
            event_type = '".$db->escape($eventType)."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'");
    }

    return $jsonResponse;
}

/**
 * Retrieve a description from the different kinds of Eligible responses
 *
 * @param object $jsonResponse
 * @return string
 */
function detailsFromEligibleResponse ($jsonResponse) {
    if (isset($jsonResponse->details)) {
        return $jsonResponse->details;
    }

    $message = [];

    /**
     * Eligible responses have its own status.
     *
     * Acknowledgements don't hold the latest value of the claim. Example:
     *
     * {
     *     status: claim_denied,
     *     acknowledgements: [{
     *         status: claim_received ...
     *     }],
     *     payment_reports: [{
     *         ...
     *         paid: 0.0,
     *         ...
     *     }],
     *     ...
     * }
     */
    $responseStatus = isset($jsonResponse->event) ? $jsonResponse->event : $jsonResponse->status;
    $latestAcknowledgement = !empty($jsonResponse->acknowledgements) ? head($jsonResponse->acknowledgements) : null;
    $serviceLines = !empty($jsonResponse->payment_reports[0]->details->claim->service_lines) ?
        $jsonResponse->payment_reports[0]->details->claim->service_lines : null;

    if ($latestAcknowledgement) {
        $acknowledgementStatus = $latestAcknowledgement->status;

        if ($responseStatus == $acknowledgementStatus) {
            $message []= 'Status: ' . $responseStatus;
            $message []= 'Message: ' . $latestAcknowledgement->message;

            if (!empty($latestAcknowledgement->errors)) {
                foreach ($latestAcknowledgement->errors as $error) {
                    $message []= 'ERROR: ' . $error->message;
                }
            }
        }
    }

    if ($responseStatus === 'claim_denied') {
        $message []= 'Status: ' . $responseStatus;

        // payment_reports[].details.claim.service_lines[].adjustments[].reason_label
        if ($serviceLines) {
            foreach ($serviceLines as $serviceLine) {
                if (empty($serviceLine->adjustments)) {
                    continue;
                }

                foreach ($serviceLine->adjustments as $adjustment) {
                    if (empty($adjustment->reason_label)) {
                        continue;
                    }

                    $message []= 'ERROR: ' . $adjustment->reason_label;
                }
            }
        }
    }

    return $message;
}

/**
 * Retrieve a description from the last Eligible response / webhook
 *
 * @param int $claimId
 * @return array
 */
function eligibleDetailsFromClaimId ($claimId) {
    $db = new Db();
    $claimId = intval($claimId);

    $eResponse = $db->getRow("SELECT *
        FROM dental_claim_electronic
        WHERE claimid = '$claimId'
        ORDER BY adddate DESC
        LIMIT 1");

    $eResponse = $eResponse ?: [];
    $eligibleResponse = [];

    if ($eResponse) {
        $eResponse['response'] = json_decode($eResponse['response']);

        /**
         * Some eligible responses don't report status changes, we need to exclude those
         */
        if ($eResponse['reference_id']) {
            $referenceId = $db->escape($eResponse['reference_id']);
            $eligibleResponses = $db->getResults("SELECT *
                FROM dental_eligible_response
                WHERE reference_id = '$referenceId'
                ORDER BY adddate DESC, id DESC");

            /**
             * Walk the collection of responses, select the first one with details set
             */
            foreach ($eligibleResponses as $each) {
                $each['response'] = json_decode($each['response']);
                $eDetails = detailsFromEligibleResponse($each['response']);

                if ($eDetails) {
                    $each['response']->details = $eDetails;
                    $eligibleResponse = $each;

                    break;
                }
            }
        }
    }

    return [
        'e_response' => $eResponse,
        'eligible_response' => $eligibleResponse
    ];
}

/**
 * Generate PDF based on FDF field list
 *
 * @param string $fileName
 * @param array $fdfData
 */
function outputPdf ($fileName, $fdfData) {
    $filePath = ROOT_DIR . "/../../shared/q_file/{$fileName}";
    $fdfContents = prepareFdf($fdfData);

    // Create FDF file
    $handle = fopen($filePath, 'x+');
    fwrite($handle, $fdfContents);
    fclose($handle);

    // Create PDF from FDF + PDF claim form
    $pdfTemplatePath = 'claim_v2.pdf';
    $pdftk = '/usr/bin/pdftk';
    $pdfName = substr($filePath, 0, -4) . '.pdf';
    $command = "$pdftk $pdfTemplatePath fill_form $filePath output $pdfName flatten";

    exec($command, $output, $exitStatus);

    if ($exitStatus) {
        error_log("Print claim failed. PDFtk command: $command");
        error_log("PDFtk output:\n\t" . join("\n\t", $output));
        error_log("PDFtk exit status: $exitStatus");
    }

    // initiate PDF
    $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->_template = $pdfName;
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(true, 40);
    $pdf->setFontSubsetting(false);

    // add a page
    $pdf->AddPage();
    $pdf->Output('insurance_claim.pdf', 'D');
}

/**
 * Parse fieldName => $fieldValue array into a valid FDF string
 *
 * @param array $fdfFields
 * @return string
 */
function prepareFdf ($fdfFields) {
    $fieldPath = 'form1[0].#subform[0]';
    $pdfPath = ROOT_DIR . '/manage/claim_v2.pdf';

    foreach ($fdfFields as $fieldName=>&$fieldValue) {
        $fieldName = escapeFdf($fieldName);
        $escapedValue = strtoupper(escapeFdf($fieldValue));

        // All fields are children of the same form, and all are the first element of the collection: [0]
        $fieldValue = "<< /T({$fieldPath}.{$fieldName}[0]) /V({$escapedValue}) >>";
    }

    // Join the sections, adding new lines and indentation
    $fdfFields = implode("\n    ", $fdfFields);

    /**
     * Use an array to:
     *
     * - create a string from the parts
     * - preserve the fdf indentation
     * - preserve code indentation
     *
     * We could just use a simple string
     */
    $fdfData = [
        '', // Empty line at start of file
        '%FDF-1.2',
        '1 0 obj',
        '<< /FDF',
        '  << /Fields [',
        "    $fdfFields",
        "  ] /F ({$pdfPath}) >>",
        '>>',
        'endobj',
        'trailer',
        '<< /Root 1 0 R >>',
        '%%EOF',
        '', // Empty line at EOF
    ];
    $fdfData = implode("\n", $fdfData);

    return $fdfData;
}

function roundToCents ($amount) {
    $cents = floor($amount*100) - floor($amount)*100;
    $cents = intval($cents);

    return $cents;
}

function fill_cents ($v) {
    return $v < 10 ? "0$v" : $v;
}

function escapeFdf ($value) {
    return addcslashes($value, '\()');
}

class PDF extends \FPDI
{
    /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx;
    var $_template;

    function Header()
    {
        $db = new Db();
        $config = [];

        if (is_null($this->_tplIdx)) {
            $this->setSourceFile($this->_template);
            $this->_tplIdx = $this->importPage(1);
        }

        if (isset($_SESSION['adminuserid'])) {
            $userId = intval($_SESSION['adminuserid']);
            $config = $db->getRow("SELECT claim_margin_top, claim_margin_left FROM admin where adminid = '$userId'");
        } elseif (isset($_SESSION['docid'])) {
            $userId = intval($_SESSION['docid']);
            $config = $db->getRow("SELECT claim_margin_top, claim_margin_left FROM dental_users where userid = '$userId'");
        }

        if ($config) {
            $claim_margin_left = $config['claim_margin_left'];
            $claim_margin_top = $config['claim_margin_top'];
        } else {
            $claim_margin_left = 0;
            $claim_margin_top = 0;
        }

        $this->useTemplate($this->_tplIdx, $claim_margin_left, $claim_margin_top);
    }

    function Footer() {}
}
