<?php
header("Content-type: application/vnd.fdf");
header('Content-Disposition: attachment; filename="file.fdf"');
session_start();
require_once('includes/constants.inc');
require_once('admin/includes/config.php');
$field_path = "form1[0].#subform[0]";
if(!empty($_SERVER['HTTPS'])){
$path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
}else{
$path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
}

$fdf_file=time().'.fdf';

            // need to know what file the data will go into
            $pdf_doc= $path.'claim.pdf';
            // generate the file content

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);
$name = strtoupper(st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']));
$insurancetype = st($pat_myarray['p_m_ins_type']);
$insured_firstname = strtoupper(st($pat_myarray['p_m_partyfname']));
$insured_lastname = strtoupper(st($pat_myarray['p_m_partylname']));
$insured_middle = strtoupper(st($pat_myarray['p_m_partymname']));
$other_insured_firstname = strtoupper(st($pat_myarray['s_m_partyfname']));
$other_insured_lastname = strtoupper(st($pat_myarray['s_m_partymname']));
$other_insured_middle = strtoupper(st($pat_myarray['s_m_partylname']));
$insured_id_number = st($pat_myarray['p_m_ins_id']);
$insured_dob = st($pat_myarray['ins_dob']);
$p_m_ins_ass = st($pat_myarray['p_m_ins_ass']);
$other_insured_dob = st($pat_myarray['ins2_dob']);
$insured_insurance_plan = strtoupper(st($pat_myarray['p_m_ins_plan']));
$other_insured_insurance_plan = strtoupper(st($pat_myarray['s_m_ins_plan']));
$insured_policy_group_feca = strtoupper(st($pat_myarray['p_m_ins_grp']));
$other_insured_policy_group_feca = strtoupper(st($pat_myarray['s_m_ins_grp']));
$referredby = st($pat_myarray['referred_by']);
$referred_source = st($pat_myarray['referred_source']);
$docid = st($pat_myarray['docid']);

$sql = "select * from dental_insurance where insuranceid='".$_GET['insid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$insuranceid = st($myarray['insuranceid']);
$pica1 = st($myarray['pica1']);
$pica2 = st($myarray['pica2']);
$pica3 = st($myarray['pica3']);
$insurance_type = st($myarray['insurance_type']);
$patient_lastname = strtoupper(st($myarray['patient_lastname']));
$patient_firstname = strtoupper(st($myarray['patient_firstname']));
$patient_middle = strtoupper(st($myarray['patient_middle']));
$patient_dob = st($myarray['patient_dob']);
$patient_sex = st($myarray['patient_sex']);
$patient_address = strtoupper(st($myarray['patient_address']));
$patient_relation_insured = st($myarray['patient_relation_insured']);
$insured_address = strtoupper(st($myarray['insured_address']));
$patient_city = strtoupper(st($myarray['patient_city']));
$patient_state = strtoupper(st($myarray['patient_state']));
$patient_status = strtoupper(st($myarray['patient_status']));
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
$patient_signature = st($myarray['patient_signature']);
$patient_signed_date = st($myarray['patient_signed_date']);
$insured_signature = st($myarray['insured_signature']);
$date_current = st($myarray['date_current']);
$date_same_illness = st($myarray['date_same_illness']);
$unable_date_from = st($myarray['unable_date_from']);
$unable_date_to = st($myarray['unable_date_to']);
$referring_provider = strtoupper(st($myarray['referring_provider']));
$field_17a_dd = st($myarray['field_17a_dd']);
$field_17a = st($myarray['field_17a']);
$field_17b = st($myarray['field_17b']);
$hospitalization_date_from = st($myarray['hospitalization_date_from']);
$hospitalization_date_to = st($myarray['hospitalization_date_to']);
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
$service_date1_from = st($myarray['service_date1_from']);
$service_date1_to = st($myarray['service_date1_to']);
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
$service_date2_from = st($myarray['service_date2_from']);
$service_date2_to = st($myarray['service_date2_to']);
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
$service_date3_from = st($myarray['service_date3_from']);
$service_date3_to = st($myarray['service_date3_to']);
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
$service_date4_from = st($myarray['service_date4_from']);
$service_date4_to = st($myarray['service_date4_to']);
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

$is_sent = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? true : false;

if($insured_sex == '')
	$insured_sex = $pat_myarray['gender'];
  
$patient_sex = $pat_myarray['gender'];

if($patient_firstname == '')
	$patient_firstname = $pat_myarray['firstname'];

if($patient_lastname == '')
	$patient_lastname = $pat_myarray['lastname'];

if($patient_middle == '')
	$patient_middle = $pat_myarray['middlename'];
	
if($patient_firstname == '')
	$patient_firstname = $pat_myarray['firstname'];
	
if($patient_address == '')
	$patient_address = $pat_myarray['add1'];

if($patient_city == '')
	$patient_city = $pat_myarray['city'];

if($patient_state == '')
	$patient_state = $pat_myarray['state'];

if($patient_zip == '')
	$patient_zip = $pat_myarray['zip'];

if($patient_phone == '')
	$patient_phone = $pat_myarray['home_phone'];

if($patient_dob == '')
	$patient_dob = $pat_myarray['dob'];

if($patient_status == '')
	$patient_status = $pat_myarray['marital_status'];	

if($insured_id == '')
	$insured_id_number = $pat_myarray['p_m_ins_id'];
		
if($insured_firstname == '')
	$insured_firstname = $pat_myarray['p_d_party'];
	
if($insured_address == '')
	$insured_address = $pat_myarray['add1'];

if($insured_city == '')
	$insured_city = $pat_myarray['city'];

if($insured_state == '')
	$insured_state = $pat_myarray['state'];

if($insured_zip == '')
	$insured_zip = $pat_myarray['zip'];

if($insured_phone == '')
	$insured_phone_code = substr($pat_myarray['home_phone'], 0, 4);

$insured_phone = substr($pat_myarray['home_phone'], 3);

if($insured_dob == '')
	$insured_dob = $pat_myarray['ins_dob'];	

if($patient_relation_insured == '')
	$patient_relation_insured = $pat_myarray['p_m_relation'];

if($insured_employer_school_name == '')
	$insured_employer_school_name = $pat_myarray['employer'];

if($insured_policy_group_feca == '')
	$insured_policy_group_feca = $pat_myarray['group_number'];

if($insured_insurance_plan == '')
	$insured_insurance_plan = $pat_myarray['plan_name'];	

$accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
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
    $my = mysql_query($sql);
    $num_rows = mysql_num_rows($my);
    
    if ($num_rows > 0) {
        $myarray = mysql_fetch_array($my);
        $prior_authorization_number = $myarray['pre_auth_num'];
    }
}

$inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['p_m_ins_co'])."'";
$inscoarray = mysql_query($inscoquery);
$inscoinfo = mysql_fetch_array($inscoarray);

$referredby_sql = "select * from dental_contact where `contactid` = ".$referredby." LIMIT 1;";
$referredby_my = mysql_query($referredby_sql);

                if($referred_source==1){
                  $rsql = "SELECT lastname, firstname FROM dental_patients WHERE patientid=".$referredby;
                  $rq = mysql_query($rsql);
                  $r = mysql_fetch_assoc($rq);
                  $ref_name = $r['firstname'].", ".$r['lastname'];                
		}elseif($referred_source==2){
                  $rsql = "SELECT lastname, firstname FROM dental_contact WHERE contactid=".$referredby;
                  $rq = mysql_query($rsql);
                  $r = mysql_fetch_assoc($rq);
                  $ref_name = $r['firstname']." ".$r['lastname'];
                }

$qua_sql = "select * from dental_qualifier where qualifierid=".$field_17a_dd;
$qua_my = mysql_query($qua_sql);
$qua_myarray = mysql_fetch_array($qua_my);
$seventeenA = $qua_myarray['qualifier'];

                      $getuserinfo = "SELECT * FROM `dental_users` WHERE `userid` = '".$docid."'";
                      $userquery = mysql_query($getuserinfo);
                      $userinfo = mysql_fetch_array($userquery);

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".$diagnosis_1;
$ins_diag_my = mysql_query($ins_diag_sql);
$ins_diag_myarray = mysql_fetch_array($ins_diag_my);
$dia = explode('.', $ins_diag_myarray['ins_diagnosis']);
$diagnosis_1_left_fill = $dia[0];
$diagnosis_1_right_fill = $dia[1];

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".$diagnosis_2;
$ins_diag_my = mysql_query($ins_diag_sql);
$ins_diag_myarray = mysql_fetch_array($ins_diag_my);                            
$dia = explode('.', $ins_diag_myarray['ins_diagnosis']);
$diagnosis_2_left_fill = $dia[0];
$diagnosis_2_right_fill = $dia[1];

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".$diagnosis_3;
$ins_diag_my = mysql_query($ins_diag_sql);
$ins_diag_myarray = mysql_fetch_array($ins_diag_my);                            
$dia = explode('.', $ins_diag_myarray['ins_diagnosis']);
$diagnosis_3_left_fill = $dia[0];
$diagnosis_3_right_fill = $dia[1];

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".$diagnosis_4;
$ins_diag_my = mysql_query($ins_diag_sql);
$ins_diag_myarray = mysql_fetch_array($ins_diag_my);                            
$dia = explode('.', $ins_diag_myarray['ins_diagnosis']);
$diagnosis_4_left_fill = $dia[0];
$diagnosis_4_right_fill = $dia[1];

$fdf = "
%FDF-1.2
1 0 obj
<< /FDF 
<< /Fields 
[ 
  << /T(".$field_path.".carrier_name_fill[0]) /V(".strtoupper($inscoinfo['company']).") >>
  << /T(".$field_path.".carrier_address1_fill[0]) /V(".strtoupper($inscoinfo['add1']).") >>
  << /T(".$field_path.".carrier_address2_fill[0]) /V(".strtoupper($inscoinfo['add2']).") >>
  << /T(".$field_path.".carrier_citystatezip_fill[0]) /V(".strtoupper($inscoinfo['city'])." ".strtoupper($inscoinfo['state']).", ".$inscoinfo['zip'].") >>
  << /T(".$field_path.".pica_right_side_fill[0]) /V(".$pica1.$pica2.$pica3.") >>

  << /T(".$field_path.".medicare_chkbox[0]) /V(".(($insurancetype == '1')?1:'').") >>
  << /T(".$field_path.".medicaid_chkbox[0]) /V(".(($insurancetype == '2')?1:'').") >>
  << /T(".$field_path.".tricare_chkbox[0]) /V(".(($insurancetype == '3')?1:'').") >>
  << /T(".$field_path.".champva_chkbox[0]) /V(".(($insurancetype == '4')?1:'').") >>
  << /T(".$field_path.".grouphealth_chkbox[0]) /V(".(($insurancetype == '5')?1:'').") >>
  << /T(".$field_path.".feca_chkbox[0]) /V(".(($insurancetype == '6')?1:'').") >>
  << /T(".$field_path.".otherins_chkbox[0]) /V(".(($insurancetype == '7')?1:'').") >>

  << /T(".$field_path.".insured_id_number_fill[0]) /V(".$insured_id_number.") >>
  << /T(".$field_path.".pt_name_fill[0]) /V(".$patient_lastname.", ".$patient_firstname.", ".$patient_middle.") >>
  ";
  if($patient_dob!=''){
    $fdf .= "
      << /T(".$field_path.".pt_birth_date_mm_fill[0]) /V(".date('m',strtotime($patient_dob)).") >>
      << /T(".$field_path.".pt_birth_date_dd_fill[0]) /V(".date('d',strtotime($patient_dob)).") >>
      << /T(".$field_path.".pt_birth_date_yy_fill[0]) /V(".date('y',strtotime($patient_dob)).") >>
    ";
  }
  $fdf .= "
  << /T(".$field_path.".pt_sex_m_chkbox[0]) /V(".(($patient_sex == "M" || $patient_sex == "Male")?1:'').") >>
  << /T(".$field_path.".pt_sex_f_chkbox[0]) /V(".(($patient_sex == "F" || $patient_sex == "Female")?1:'').") >>
  << /T(".$field_path.".insured_name_ln_fn_mi_fill[0]) /V(".$insured_lastname.", ".$insured_firstname.", ".$insured_middle.") >>
  << /T(".$field_path.".pt_address_fill[0]) /V(".$patient_address.") >>
  << /T(".$field_path.".pt_relation_self_chkbox[0]) /V(".(($patient_relation_insured == "Self")?1:'').") >>
  << /T(".$field_path.".pt_relation_spouse_chkbox[0]) /V(".(($patient_relation_insured == "Spouse")?1:'').") >>
  << /T(".$field_path.".pt_relation_child_chkbox[0]) /V(".(($patient_relation_insured == "Child")?1:'').") >>
  << /T(".$field_path.".pt_relation_other_chkbox[0]) /V(".(($patient_relation_insured == "Others")?1:'').") >>
  << /T(".$field_path.".insured_address_fill[0]) /V(".$insured_address.") >>
  << /T(".$field_path.".pt_city_fill[0]) /V(".$patient_city.") >>
  << /T(".$field_path.".pt_state_fill[0]) /V(".$patient_state.") >>
  << /T(".$field_path.".pt_status_single_chkbox[0]) /V(".((in_array("Single", $patient_status_array))?1:'').") >>
  << /T(".$field_path.".pt_status_married_chkbox[0]) /V(".((in_array("Married", $patient_status_array))?1:'').") >>
  << /T(".$field_path.".pt_status_other_chkbox[0]) /V(".((in_array("Others", $patient_status_array))?1:'').") >>
  << /T(".$field_path.".insured_city_fill[0]) /V(".$insured_city.") >>
  << /T(".$field_path.".insured_state_fill[0]) /V(".$insured_state.") >>
  << /T(".$field_path.".pt_zipcode_fill[0]) /V(".$patient_zip.") >>
  << /T(".$field_path.".pt_phone_areacode_fill[0]) /V(".substr($patient_phone,0,3).") >>
  << /T(".$field_path.".pt_phone_number_fill[0]) /V(".substr($patient_phone,3).") >>
  << /T(".$field_path.".pt_status_employed_chkbox[0]) /V(".((in_array("Employed", $patient_status_array))?1:'').") >>
  << /T(".$field_path.".pt_status_ftstudent_chkbox[0]) /V(".((in_array("Full Time Student", $patient_status_array))?1:'').") >>
  << /T(".$field_path.".pt_status_ptstudent_chkbox[0]) /V(".((in_array("Part Time Student", $patient_status_array))?1:'').") >>
  << /T(".$field_path.".insured_zipcode_fill[0]) /V(".$insured_zip.") >>
  << /T(".$field_path.".insured_phone_areacode_fill[0]) /V(".$insured_phone_code.") >>
  << /T(".$field_path.".insured_phone_number_fill[0]) /V(".$insured_phone.") >>
  << /T(".$field_path.".other_insured_name_fill[0]) /V(".$other_insured_lastname." ".$other_insured_firstname." ".$other_insured_middle.") >>
  << /T(".$field_path.".insured_policy_group_fill[0]) /V(".$insured_policy_group_feca.") >>
  << /T(".$field_path.".other_insured_policy_fill[0]) /V(".$other_insured_policy_group_feca.") >>
  << /T(".$field_path.".pt_condition_employment_yes_chkbox[0]) /V(".(($employment == "YES")?1:'').") >>
  << /T(".$field_path.".pt_condition_employment_no_chkbox[0]) /V(".(($employment == "NO")?1:'').") >>
  << /T(".$field_path.".pt_condition_auto_yes_chkbox[0]) /V(".(($auto_accident == "YES")?1:'').") >>
  << /T(".$field_path.".pt_condition_auto_no_chkbox[0]) /V(".(($auto_accident == "NO")?1:'').") >>
  << /T(".$field_path.".pt_condition_place_fill[0]) /V(".$auto_accident_place.") >>
  << /T(".$field_path.".pt_condition_otheracc_yes_chkbox[0]) /V(".(($other_accident == "YES")?1:'').") >>
  << /T(".$field_path.".pt_condition_otheracc_no_chkbox[0]) /V(".(($other_accident == "NO")?1:'').") >>
  ";

  if($insured_dob!=''){
    $fdf .= "
      << /T(".$field_path.".insured_dob_mm_fill[0]) /V(".date('m', strtotime($insured_dob)).") >>
      << /T(".$field_path.".insured_dob_dd_fill[0]) /V(".date('d', strtotime($insured_dob)).") >>
      << /T(".$field_path.".insured_dob_yy_fill[0]) /V(".date('y', strtotime($insured_dob)).") >>
    ";
  }
  $fdf .= "
  << /T(".$field_path.".insured_sex_m_chkbox[0]) /V(".(($insured_sex == "M" || $insured_sex == "Male")?1:'').") >>
  << /T(".$field_path.".insured_sex_f_chkbox[0]) /V(".(($insured_sex == "F" || $insured_sex == "Female")?1:'').") >>
  ";
  if($other_insured_dob!=''){
    $fdf .= "
      << /T(".$field_path.".other_insured_dob_mm_fill[0]) /V(".date('m', strtotime($other_insured_dob)).") >>
      << /T(".$field_path.".other_insured_dob_dd_fill[0]) /V(".date('d', strtotime($other_insured_dob)).") >>
      << /T(".$field_path.".other_insured_dob_yy_fill[0]) /V(".date('y', strtotime($other_insured_dob)).") >>
    ";
  }
  $fdf .= "
  << /T(".$field_path.".other_insured_sex_m_chkbox[0]) /V(".(($other_insured_sex == "M" || $other_insured_sex == "Male")?1:'').") >>
  << /T(".$field_path.".other_insured_sex_f_chkbox[0]) /V(".(($other_insured_sex == "F" || $other_insured_sex == "Female")?1:'').") >>
  << /T(".$field_path.".insured_employers_name_fill[0]) /V(".$insured_employer_school_name.") >>
  << /T(".$field_path.".employers_name_fill[0]) /V(".$other_insured_employer_school_name.") >>
  << /T(".$field_path.".insured_ins_plan_name_fill[0]) /V(".$insured_insurance_plan.") >>
  << /T(".$field_path.".ins_plan_name_fill[0]) /V(".$other_insured_insurance_plan.") >>
  << /T(".$field_path.".reserved_local_use_fill[0]) /V(".$reserved_local_use.") >>
  << /T(".$field_path.".another_health_benefit_yes_chkbox[0]) /V(".(($another_plan == "YES")?1:'').") >>
  << /T(".$field_path.".another_health_benefit_no_chkbox[0]) /V(".(($another_plan == "NO")?1:'').") >>
  << /T(".$field_path.".pt_signature_fill[0]) /V(".(($patient_signature)?'SIGNATURE ON FILE':'').") >>
  ";
  if($patient_signature){
    $fdf .= "<< /T(".$field_path.".pt_signature_date_fill[0]) /V(".$patient_signed_date.") >>";
  }
  $fdf .= "
  << /T(".$field_path.".insured_signature_fill[0]) /V(".(($insured_signature)?'SIGNATURE ON FILE':'').") >>
  ";
  if($date_current!=''){
    $fdf .= "
      << /T(".$field_path.".date_of_current_mm_fill[0]) /V(".date('m', strtotime($date_current)).") >>
      << /T(".$field_path.".date_of_current_dd_fill[0]) /V(".date('d', strtotime($date_current)).") >>
      << /T(".$field_path.".date_of_current_yy_fill[0]) /V(".date('y', strtotime($date_current)).") >>
    ";
  }
  if($date_same_illness!=''){
    $fdf .= "
      << /T(".$field_path.".pt_similar_illness_mm_fill[0]) /V(".date('m', strtotime($date_same_illness)).") >>
      << /T(".$field_path.".pt_similar_illness_dd_fill[0]) /V(".date('d', strtotime($date_same_illness)).") >>
      << /T(".$field_path.".pt_similar_illness_yy_fill[0]) /V(".date('y', strtotime($date_same_illness)).") >>
    ";
  }
  if($unable_date_from != ''){
    $fdf .= "
      << /T(".$field_path.".date_pt_unable_work_from_mm_fill[0]) /V(".date('m', strtotime($unable_date_from)).") >>
      << /T(".$field_path.".date_pt_unable_work_from_dd_fill[0]) /V(".date('d', strtotime($unable_date_from)).") >>
      << /T(".$field_path.".date_pt_unable_work_from_yy_fill[0]) /V(".date('y', strtotime($unable_date_from)).") >>
    ";
  }
  if($unable_date_to!=''){
    $fdf .= "
      << /T(".$field_path.".date_pt_unable_work_to_mm_fill[0]) /V(".date('m', strtotime($unable_date_to)).") >>
      << /T(".$field_path.".date_pt_unable_work_to_dd_fill[0]) /V(".date('d', strtotime($unable_date_to)).") >>
      << /T(".$field_path.".date_pt_unable_work_to_yy_fill[0]) /V(".date('y', strtotime($unable_date_to)).") >>
    ";
  }
  $fdf .= "
  << /T(".$field_path.".name_referring_provider_fill[0]) /V(".$ref_name.") >>
  << /T(".$field_path.".seventeenA_fill[0]) /V(".$field_17a.") >>
  << /T(".$field_path.".seventeenb_NPI_fill[0]) /V() >>
  ";
  if($hospitalization_date_from!=''){
    $fdf .= "
      << /T(".$field_path.".hospitalization_date_from_mm_fill[0]) /V(".date('m', strtotime($hospitalization_date_from)).") >>
      << /T(".$field_path.".hospitalization_date_from_dd_fill[0]) /V(".date('d', strtotime($hospitalization_date_from)).") >>
      << /T(".$field_path.".hospitalization_date_from_yy_fill[0]) /V(".date('y', strtotime($hospitalization_date_from)).") >>
    ";
  }
  if($hospitalization_date_to!=''){
    $fdf .= "
      << /T(".$field_path.".hospitalization_date_to_mm_fill[0]) /V(".date('m', strtotime($hospitalization_date_to)).") >>
      << /T(".$field_path.".hospitalization_date_to_dd_fill[0]) /V(".date('d', strtotime($hospitalization_date_to)).") >>
      << /T(".$field_path.".hospitalization_date_to_yy_fill[0]) /V(".date('y', strtotime($hospitalization_date_to)).") >>
    ";
  }
  $fdf .= "
  << /T(".$field_path.".reserved_for_local_fill[0]) /V(".$reserved_local_use1.") >>
  << /T(".$field_path.".outside_lab_yes_chkbox[0]) /V(".(($outside_lab == "YES")?1:'').") >>
  << /T(".$field_path.".outside_lab_no_chkbox[0]) /V(".(($outside_lab == "NO")?1:'').") >>
  << /T(".$field_path.".charges_fill[0]) /V(".$s_charges.") >>
  << /T(".$field_path.".diagnosis_one_left_fill[0]) /V(".$diagnosis_1_left_fill.") >>
  << /T(".$field_path.".diagnosis_one_right_fill[0]) /V(".$diagnosis_1_right_fill.") >>
  << /T(".$field_path.".diagnosis_two_left_fill[0]) /V(".$diagnosis_2_left_fill.") >>
  << /T(".$field_path.".diagnosis_two_right_fill[0]) /V(".$diagnosis_2_right_fill.") >>
  << /T(".$field_path.".diagnosis_three_left_fill[0]) /V(".$diagnosis_3_left_fill.") >>
  << /T(".$field_path.".diagnosis_three_right_fill[0]) /V(".$diagnosis_3_right_fill.") >>
  << /T(".$field_path.".diagnosis_four_left_fill[0]) /V(".$diagnosis_4_left_fill.") >>
  << /T(".$field_path.".diagnosis_four_right_fill[0]) /V(".$diagnosis_4_right_fill.") >>
  << /T(".$field_path.".medicaid_resubmission_code_fill[0]) /V(".$medicaid_resubmission_code.") >>
  << /T(".$field_path.".orignial_ref_no_fill[0]) /V(".$original_ref_no.") >>
  << /T(".$field_path.".prior_auth_number_fill[0]) /V(".$prior_authorization_number.") >>
";

$prefix = array( 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX');

// Get modifier codes
$mod_sql = "SELECT * FROM dental_modifier_code";
$mod_my = mysql_query($mod_sql);
$mod_array = array();
while ($mod_row = mysql_fetch_array($mod_my)) {
  $mod_array[] = $mod_row;
}

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
       . "  AND ledger.patientid = " . $_GET['pid'] . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";

$query = mysql_query($sql);
$c=0;
while ($array = mysql_fetch_array($query)) { 
$p = $prefix[$c];
$c++;
  if($array['service_date']!=''){
    $fdf .= "
      << /T(".$field_path.".".$p."_dates_of_service_from_mm_fill[0]) /V(".date('m', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_from_dd_fill[0]) /V(".date('d', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_from_yy_fill[0]) /V(".date('y', strtotime($array['service_date'])).") >>
    ";
  }
  if($array['service_date']){
    $fdf .= " 
      << /T(".$field_path.".".$p."_dates_of_service_to_mm_fill[0]) /V(".date('m', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_to_dd_fill[0]) /V(".date('d', strtotime($array['service_date'])).") >>
      << /T(".$field_path.".".$p."_dates_of_service_to_yy_fill[0]) /V(".date('y', strtotime($array['service_date'])).") >>
    ";
  }
  $fdf .= "
  << /T(".$field_path.".".$p."_place_of_service_fill[0]) /V(".$array['place'].") >>
  << /T(".$field_path.".".$p."_EMG_fill[0]) /V(".$array['emg'].") >>
  << /T(".$field_path.".".$p."_CPT_fill[0]) /V(".$array['transaction_code'] . " - " .$array['description'].") >>
  << /T(".$field_path.".".$p."_modifier_one_fill[0]) /V(".$array['modcode'].") >>
  << /T(".$field_path.".".$p."_modifier_two_fill[0]) /V(".$array['modcode2'].") >>
  << /T(".$field_path.".".$p."_modifier_three_fill[0]) /V(".$array['modcode3'].") >>
  << /T(".$field_path.".".$p."_modifier_four_fill[0]) /V(".$array['modcode4'].") >>
  << /T(".$field_path.".".$p."_diagnosis_pointer_fill[0]) /V(".$array['diagnosispointer'].") >>
  << /T(".$field_path.".".$p."_charges_dollars_fill[0]) /V(".number_format($array['amount'],0).") >>
  << /T(".$field_path.".".$p."_charges_cents_fill[0]) /V(".fill_cents($array['amount']-floor($array['amount'])).") >>
  << /T(".$field_path.".".$p."_days_or_units_fill[0]) /V(".$array['daysorunits'].") >>
  << /T(".$field_path.".".$p."_EPSDT_fill[0]) /V(".$array['epsdt'].") >>
  << /T(".$field_path.".".$p."_rendering_provider_fill[0]) /V(".$array['provider_id'].") >> ";
}

  // re-calculate balance due
  //$balance_due = $total_charge - $amount_paid;

$fdf .= "
  << /T(".$field_path.".fed_tax_id_number_fill[0]) /V(".$userinfo['tax_id_or_ssn'].") >>
  << /T(".$field_path.".fed_tax_id_SSN_chkbox[0]) /V(".(($userinfo['ssn'] == "1")?1:'').") >>
  << /T(".$field_path.".fed_tax_id_EIN_chkbox[0]) /V(".(($userinfo['ein'] == "1")?1:'').") >>
  << /T(".$field_path.".pt_account_number_fill[0]) /V(".$patient_account_no.") >>
  << /T(".$field_path.".accept_assignment_yes_chkbox[0]) /V(".(($accept_assignment == "Yes")?1:'').") >>
  << /T(".$field_path.".accept_assignment_no_chkbox[0]) /V(".(($accept_assignment == "No")?1:'').") >>
  << /T(".$field_path.".total_charge_dollars_fill[0]) /V(".number_format($total_charge,0).") >>
  << /T(".$field_path.".total_charge_cents_fill[0]) /V(".fill_cents($total_charge-floor($total_charge)).") >>
  << /T(".$field_path.".amount_paid_dollars_fill[0]) /V(0) >>
  << /T(".$field_path.".amount_paid_cents_fill[0]) /V(00) >>
  << /T(".$field_path.".balance_due_dollars_fill[0]) /V(".number_format($total_charge,0).") >>
  << /T(".$field_path.".balance_due_cents_fill[0]) /V(".fill_cents($total_charge-floor($total_charge)).") >>
  << /T(".$field_path.".service_facility_location_info_fill[0]) /V(".$userinfo['name']."\n".strtoupper($userinfo['address'])."\n".strtoupper($userinfo['city']).", ".strtoupper($userinfo['state'])." ".$userinfo['zipcode'].") >>
  << /T(".$field_path.".billing_provider_phone_areacode_fill[0]) /V(".format_phone($userinfo['phone'], true).") >>
  << /T(".$field_path.".billing_provider_phone_number_fill[0]) /V(".format_phone($userinfo['phone'], false).") >>
  << /T(".$field_path.".billing_provider_info_fill[0]) /V(".strtoupper($userinfo['name'])."\n".strtoupper($userinfo['address'])."\n".strtoupper($userinfo['city']).", ".strtoupper($userinfo['state'])." ".$userinfo['zipcode'].") >>
  << /T(".$field_path.".signature_of_physician-supplier_signed_fill[0]) /V(".$signature_physician.") >>  
  << /T(".$field_path.".signature_of_physician-supplier_date_fill[0]) /V(".date('m/d/Y').") >>
  << /T(".$field_path.".service_facility_NPI_a_fill[0]) /V(".$userinfo['npi'].") >>
  << /T(".$field_path.".service_facility_other_id_b_fill[0]) /V(".$service_info_b_other.") >>
  << /T(".$field_path.".billing_provider_NPI_a_fill[0]) /V(".$userinfo['npi'].") >>
  << /T(".$field_path.".billing_provider_other_id_b_fill[0]) /V(".$billing_provider_b_other.") >>
";


$fdf .= "
]
/F (".$pdf_doc.") 
>>
>>
endobj
trailer
<<
/Root 1 0 R

>>
%%EOF
";



            // this is where you'd do any custom handling of the data
            // if you wanted to put it in a database, email the
            // FDF data, push ti back to the user with a header() call, etc.

            // write the file out
              echo  $fdf;

function fill_cents($v){
  if($v<10){
	return '0'.$v;
  }else{
	return $v;
  }
}

function format_phone($num, $a){
        $num = ereg_replace("[^0-9]", "", $num);
        preg_match('/([0-1]*)(.*)/',$num, $m);
        $num = $m[2];
  if($a){
        return substr($num, 0, 3);
  }else{
        return substr($num,3);
  }
  return $num;
}

?>

