<?php
namespace Ds3\Libraries\Legacy;

include_once 'includes/constants.inc';
include_once 'admin/includes/main_include.php';

$db = new Db();

$field_path = "form1[0].#subform[0]";
if (!empty($_SERVER['HTTPS'])) {
    $path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
} else {
    $path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
}

// need to know what file the data will go into
$pdf_doc= $path.'claim.pdf';
// generate the file content

$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$pat_myarray = $db->getRow($pat_sql);

$insurancetype = st($pat_myarray['p_m_ins_type']);
$insured_firstname = strtoupper(st($pat_myarray['p_m_partyfname']));
$insured_lastname = strtoupper(st($pat_myarray['p_m_partylname']));
$insured_middle = strtoupper(st($pat_myarray['p_m_partymname']));
$other_insured_firstname = strtoupper(st($pat_myarray['s_m_partyfname']));
$other_insured_lastname = strtoupper(st($pat_myarray['s_m_partylname']));
$other_insured_middle = strtoupper(st($pat_myarray['s_m_partymname']));
$insured_id_number = st($pat_myarray['p_m_ins_id']);
$insured_dob = st($pat_myarray['ins_dob']);
$other_insured_dob = st($pat_myarray['ins2_dob']);
$other_insured_insurance_plan = strtoupper(st($pat_myarray['s_m_ins_plan']));

if ($pat_myarray['p_m_ins_type'] == 1) {
    $insured_policy_group_feca = "NONE";
    $insured_insurance_plan = '';
    $insured_employer_school_name = '';
} else {
    $insured_policy_group_feca = $pat_myarray['p_m_ins_grp'];
    $insured_insurance_plan = $pat_myarray['p_m_ins_plan'];
}

$other_insured_policy_group_feca = strtoupper(st($pat_myarray['s_m_ins_grp']));
$docid = st($pat_myarray['docid']);

$sql = "select * from dental_insurance where insuranceid='".(!empty($_GET['insid']) ? $_GET['insid'] : '')."' and patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";

$my = $db->getResults($sql);
$myarray = (!empty($my[0]) ? $my[0] : []);

if (!empty($myarray)) {
    $insuranceid = st($myarray['insuranceid']);
    $pica1 = st($myarray['pica1']);
    $pica2 = st($myarray['pica2']);
    $pica3 = st($myarray['pica3']);
    $patient_lastname = strtoupper(st($myarray['patient_lastname']));
    $patient_firstname = strtoupper(st($myarray['patient_firstname']));
    $patient_middle = strtoupper(st($myarray['patient_middle']));
    $patient_dob = str_replace('-','/',st($myarray['patient_dob']));
    $patient_sex = st($myarray['patient_sex']);

    $patient_relation_insured = st($myarray['patient_relation_insured']);
    $patient_status = st($myarray['patient_status']);
    $patient_status_array = explode('~', $patient_status);
    $patient_phone_code = st($myarray['patient_phone_code']);
    $patient_phone = st($myarray['patient_phone']);
    $employment = st($myarray['employment']);
    $auto_accident = st($myarray['auto_accident']);
    $auto_accident_place = st($myarray['auto_accident_place']);
    $other_accident = st($myarray['other_accident']);
    $insured_employer_school_name = strtoupper(st($myarray['insured_employer_school_name']));
    $other_insured_employer_school_name = strtoupper(st($myarray['other_insured_employer_school_name']));

    if (!empty($_GET['type']) && $_GET['type'] == 'secondary') {
        $insurancetype = st($myarray['other_insurance_type']);
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
    } else {
        $insurancetype = st($myarray['insurance_type']);
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
    }

    $reserved_local_use = strtoupper(st($myarray['reserved_local_use']));
}

if ($pat_myarray['p_m_ins_type'] != 1 && $pat_myarray['has_s_m_ins'] == 'Yes' && $pat_myarray['p_m_dss_file'] == 1 && $pat_myarray['s_m_dss_file'] == 1) {
    $another_plan = 'YES';
} else {
    $another_plan = 'NO';
}

if (!empty($myarray)) {
    $patient_signature = st($myarray['patient_signature']);
    $patient_signed_date = st($myarray['patient_signed_date']);
    $insured_signature = st($myarray['insured_signature']);
    $date_current = str_replace('-', '/', st($myarray['date_current']));
    $date_same_illness = str_replace('-', '/', st($myarray['date_same_illness']));
    $unable_date_from = str_replace('-', '/', st($myarray['unable_date_from']));
    $unable_date_to = str_replace('-', '/', st($myarray['unable_date_to']));
    $referring_provider = strtoupper(st($myarray['referring_provider']));
    $field_17a = st($myarray['field_17a']);
    $hospitalization_date_from = str_replace('-', '/', st($myarray['hospitalization_date_from']));
    $hospitalization_date_to = str_replace('-', '/', st($myarray['hospitalization_date_to']));
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
    $patient_account_no = st($myarray['patient_account_no']);
    $total_charge = str_replace(",", '', st($myarray['total_charge']));
    $amount_paid = str_replace(",", '', st($myarray['amount_paid']));
    $balance_due = str_replace(",", '', st($myarray['balance_due']));
    $signature_physician = st($myarray['signature_physician']);
    $service_info_b_other = strtoupper(st($myarray['service_info_b_other']));
    $billing_provider_b_other = strtoupper(st($myarray['billing_provider_b_other']));
}

if (empty($insured_sex)) {
   $insured_sex = $pat_myarray['gender'];
}

if (empty($patient_sex)) {
    $patient_sex = $pat_myarray['gender'];
}

if (empty($patient_firstname)) {
    $patient_firstname = $pat_myarray['firstname'];
}

if (empty($patient_lastname)) {
    $patient_lastname = $pat_myarray['lastname'];
}

if (empty($patient_middle)) {
    $patient_middle = $pat_myarray['middlename'];
}

if (empty($patient_firstname)) {
    $patient_firstname = $pat_myarray['firstname'];
}

if (empty($patient_phone)) {
    $patient_phone_code = substr($pat_myarray['home_phone'], 0, 3);
    $patient_phone = substr($pat_myarray['home_phone'], 3);
}

if (empty($patient_dob)) {
    $patient_dob = $pat_myarray['dob'];
}

if (empty($insured_id_number)) {
    $insured_id_number = $pat_myarray['p_m_ins_id'];
}

if (empty($insured_firstname)) {
    $insured_firstname = $pat_myarray['p_d_party'];
}

if (empty($insured_address)) {
    $insured_address = $pat_myarray['add1'];
}

if (empty($insured_city)) {
    $insured_city = $pat_myarray['city'];
}

if (empty($insured_state)) {
    $insured_state = $pat_myarray['state'];
}

if (empty($insured_zip)) {
    $insured_zip = $pat_myarray['zip'];
}

if (empty($insured_phone)) {
    $insured_phone_code = substr($pat_myarray['home_phone'], 0, 4);
}

$insured_phone = substr($pat_myarray['home_phone'], 3);

if (empty($insured_dob)) {
    $insured_dob = $pat_myarray['ins_dob'];
}

if (empty($patient_relation_insured)) {
    $patient_relation_insured = $pat_myarray['p_m_relation'];
}

if (empty($insured_employer_school_name)) {
    $insured_employer_school_name = $pat_myarray['employer'];
}

if (empty($insured_policy_group_feca)) {
    $insured_policy_group_feca = $pat_myarray['group_number'];
}

if (empty($insured_insurance_plan)) {
    $insured_insurance_plan = $pat_myarray['plan_name'];
}

if ($pat_myarray['p_m_ins_type'] == 1) {
    $insured_policy_group_feca = "NONE";
    $insured_insurance_plan = '';
    $insured_employer_school_name = '';
}

$accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
$accept_assignment = $accept_assignmentnew;

$sleepstudies = "SELECT ss.completed, ss.diagnosising_doc, ss.diagnosising_npi FROM dental_summ_sleeplab ss                                 
    JOIN dental_patients p on ss.patiendid=p.patientid                        
    WHERE (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) 
    AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') 
    AND ss.filename IS NOT NULL AND ss.patiendid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."';";

$d = $db->getRow($sleepstudies);
$diagnosising_npi = $d['diagnosising_npi'];
if ($insurancetype != 1) {
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

$prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".$db->escape( (!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";

$prod_r = $db->getRow($prod_s);
$claim_producer = $prod_r['producer'];

$getuserinfo = "SELECT * FROM `dental_users` WHERE producer_files=1 AND `userid` = '".$claim_producer."'";

if ($userinfo = $db->getRow($getuserinfo)) {
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

$docinfo = $db->getRow($getdocinfo);
if (empty($phone)) {
    $phone = $docinfo['phone'];
}
if (empty($practice)) {
    $practice = $docinfo['practice'];
}
if (empty($address)) {
    $address = $docinfo['address'];
}
if (empty($city)) {
    $city = $docinfo['city'];
}
if (empty($state)) {
    $state = $docinfo['state'];
}
if (empty($zip)) {
    $zip = $docinfo['zip'];
}
if (empty($npi)) {
    $npi = $docinfo['npi'];
}
if (empty($medicare_npi)) {
    $medicare_npi = $docinfo['medicare_npi'];
}

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_1) ? $diagnosis_1 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);

$dia = explode('.', (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : ''));
$diagnosis_1_left_fill = $dia[0];
$diagnosis_1_right_fill = (!empty($dia[1]) ? $dia[1] : '');

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_2) ? $diagnosis_2 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);

$dia = explode('.', (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : ''));
$diagnosis_2_left_fill = $dia[0];
$diagnosis_2_right_fill = (!empty($dia[1]) ? $dia[1] : '');

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_3) ? $diagnosis_3 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);

$dia = explode('.', (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : ''));
$diagnosis_3_left_fill = $dia[0];
$diagnosis_3_right_fill = (!empty($dia[1]) ? $dia[1] : '');

$ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid=".(!empty($diagnosis_4) ? $diagnosis_4 : '');
$ins_diag_myarray = $db->getRow($ins_diag_sql);

$dia = explode('.', (!empty($ins_diag_myarray['ins_diagnosis']) ? $ins_diag_myarray['ins_diagnosis'] : ''));
$diagnosis_4_left_fill = $dia[0];
$diagnosis_4_right_fill = (!empty($dia[1]) ? $dia[1] : '');

$fdf = "
    %FDF-1.2
    1 0 obj
    << /FDF 
    << /Fields 
    [ 
        << /T(".$field_path.".carrier_name_fill[0]) /V(".escapeFdf(strtoupper($inscoinfo['company'])).") >>
        << /T(".$field_path.".carrier_address1_fill[0]) /V(".escapeFdf(strtoupper($inscoinfo['add1'])).") >>
        << /T(".$field_path.".carrier_address2_fill[0]) /V(".escapeFdf(strtoupper($inscoinfo['add2'])).") >>
        << /T(".$field_path.".carrier_citystatezip_fill[0]) /V(".escapeFdf(strtoupper($inscoinfo['city'])." ".strtoupper($inscoinfo['state']).", ".$inscoinfo['zip']).") >>
        << /T(".$field_path.".pica_right_side_fill[0]) /V(".escapeFdf((!empty($pica1) ? $pica1 : '').(!empty($pica2) ? $pica2 : '').(!empty($pica3) ? $pica3 : '')).") >>

        << /T(".$field_path.".medicare_chkbox[0]) /V(".escapeFdf((($insurancetype == '1')?1:'')).") >>
        << /T(".$field_path.".medicaid_chkbox[0]) /V(".escapeFdf((($insurancetype == '2')?1:'')).") >>
        << /T(".$field_path.".tricare_chkbox[0]) /V(".escapeFdf((($insurancetype == '3')?1:'')).") >>
        << /T(".$field_path.".champva_chkbox[0]) /V(".escapeFdf((($insurancetype == '4')?1:'')).") >>
        << /T(".$field_path.".grouphealth_chkbox[0]) /V(".escapeFdf((($insurancetype == '5')?1:'')).") >>
        << /T(".$field_path.".feca_chkbox[0]) /V(".escapeFdf((($insurancetype == '6')?1:'')).") >>
        << /T(".$field_path.".otherins_chkbox[0]) /V(".escapeFdf((($insurancetype == '7')?1:'')).") >>

        << /T(".$field_path.".insured_id_number_fill[0]) /V(".escapeFdf($insured_id_number).") >>
        << /T(".$field_path.".pt_name_fill[0]) /V(".escapeFdf($patient_lastname.", ".$patient_firstname.((trim($patient_middle)!='')?", ".$patient_middle:'')).") >>
";

if ($patient_dob!='') {
    $fdf .= "
        << /T(".$field_path.".pt_birth_date_mm_fill[0]) /V(".escapeFdf(date('m',strtotime($patient_dob))).") >>
        << /T(".$field_path.".pt_birth_date_dd_fill[0]) /V(".escapeFdf(date('d',strtotime($patient_dob))).") >>
        << /T(".$field_path.".pt_birth_date_yy_fill[0]) /V(".escapeFdf(date('Y',strtotime($patient_dob))).") >>
    ";
}
$fdf .= "
    << /T(".$field_path.".pt_sex_m_chkbox[0]) /V(".escapeFdf((($patient_sex == "M" || $patient_sex == "Male")?1:'')).") >>
    << /T(".$field_path.".pt_sex_f_chkbox[0]) /V(".escapeFdf((($patient_sex == "F" || $patient_sex == "Female")?1:'')).") >>
    << /T(".$field_path.".insured_name_ln_fn_mi_fill[0]) /V(".escapeFdf($insured_lastname.", ".$insured_firstname.((trim($insured_middle)!='')?", ".$insured_middle:'')).") >>
    << /T(".$field_path.".pt_address_fill[0]) /V(".escapeFdf($insured_address).") >>
    << /T(".$field_path.".pt_relation_self_chkbox[0]) /V(".escapeFdf((($patient_relation_insured == "Self")?1:'')).") >>
    << /T(".$field_path.".pt_relation_spouse_chkbox[0]) /V(".escapeFdf((($patient_relation_insured == "Spouse")?1:'')).") >>
    << /T(".$field_path.".pt_relation_child_chkbox[0]) /V(".escapeFdf((($patient_relation_insured == "Child")?1:'')).") >>
    << /T(".$field_path.".pt_relation_other_chkbox[0]) /V(".escapeFdf((($patient_relation_insured == "Others")?1:'')).") >>
    << /T(".$field_path.".insured_address_fill[0]) /V(".escapeFdf($insured_address).") >>
    << /T(".$field_path.".pt_city_fill[0]) /V(".escapeFdf($insured_city).") >>
    << /T(".$field_path.".pt_state_fill[0]) /V(".escapeFdf($insured_state).") >>
    << /T(".$field_path.".pt_status_single_chkbox[0]) /V(".escapeFdf(((!empty($patient_status_array) && in_array("Single", $patient_status_array))?1:'')).") >>
    << /T(".$field_path.".pt_status_married_chkbox[0]) /V(".escapeFdf(((!empty($patient_status_array) && in_array("Married", $patient_status_array))?1:'')).") >>
    << /T(".$field_path.".pt_status_other_chkbox[0]) /V(".escapeFdf(((!empty($patient_status_array) && in_array("Others", $patient_status_array))?1:'')).") >>
    << /T(".$field_path.".insured_city_fill[0]) /V(".escapeFdf($insured_city).") >>
    << /T(".$field_path.".insured_state_fill[0]) /V(".escapeFdf($insured_state).") >>
    << /T(".$field_path.".pt_zipcode_fill[0]) /V(".escapeFdf($insured_zip).") >>
    << /T(".$field_path.".pt_phone_areacode_fill[0]) /V(".escapeFdf($patient_phone_code).") >>
    << /T(".$field_path.".pt_phone_number_fill[0]) /V(".escapeFdf($patient_phone).") >>
    << /T(".$field_path.".pt_status_employed_chkbox[0]) /V(".escapeFdf(((!empty($patient_status_array) && in_array("Employed", $patient_status_array))?1:'')).") >>
    << /T(".$field_path.".pt_status_ftstudent_chkbox[0]) /V(".escapeFdf(((!empty($patient_status_array) && in_array("Full Time Student", $patient_status_array))?1:'')).") >>
    << /T(".$field_path.".pt_status_ptstudent_chkbox[0]) /V(".escapeFdf(((!empty($patient_status_array) && in_array("Part Time Student", $patient_status_array))?1:'')).") >>
    << /T(".$field_path.".insured_zipcode_fill[0]) /V(".escapeFdf($insured_zip).") >>
    << /T(".$field_path.".insured_phone_areacode_fill[0]) /V(".escapeFdf($insured_phone_code).") >>
    << /T(".$field_path.".insured_phone_number_fill[0]) /V(".escapeFdf($insured_phone).") >>
    << /T(".$field_path.".other_insured_name_fill[0]) /V(".escapeFdf($other_insured_lastname." ".$other_insured_firstname." ".$other_insured_middle).") >>
    << /T(".$field_path.".insured_policy_group_fill[0]) /V(".escapeFdf($insured_policy_group_feca).") >>
    << /T(".$field_path.".other_insured_policy_fill[0]) /V(".escapeFdf($other_insured_policy_group_feca).") >>
    << /T(".$field_path.".pt_condition_employment_yes_chkbox[0]) /V(".escapeFdf(((!empty($employment) && $employment == "YES")?1:'')).") >>
    << /T(".$field_path.".pt_condition_employment_no_chkbox[0]) /V(".escapeFdf(((!empty($employment) && $employment == "NO")?1:'')).") >>
    << /T(".$field_path.".pt_condition_auto_yes_chkbox[0]) /V(".escapeFdf(((!empty($auto_accident) && $auto_accident == "YES")?1:'')).") >>
    << /T(".$field_path.".pt_condition_auto_no_chkbox[0]) /V(".escapeFdf(((!empty($auto_accident) && $auto_accident == "NO")?1:'')).") >>
    << /T(".$field_path.".pt_condition_place_fill[0]) /V(".escapeFdf((!empty($auto_accident_place) ? $auto_accident_place : '')).") >>
    << /T(".$field_path.".pt_condition_otheracc_yes_chkbox[0]) /V(".escapeFdf(((!empty($other_accident) && $other_accident == "YES")?1:'')).") >>
    << /T(".$field_path.".pt_condition_otheracc_no_chkbox[0]) /V(".escapeFdf(((!empty($other_accident) && $other_accident == "NO")?1:'')).") >>
";

if ($insured_dob != '') {
    $fdf .= "
        << /T(".$field_path.".insured_dob_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($insured_dob))).") >>
        << /T(".$field_path.".insured_dob_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($insured_dob))).") >>
        << /T(".$field_path.".insured_dob_yy_fill[0]) /V(".escapeFdf(date('Y', strtotime($insured_dob))).") >>
    ";
}
$fdf .= "
    << /T(".$field_path.".insured_sex_m_chkbox[0]) /V(".escapeFdf((($insured_sex == "M" || $insured_sex == "Male")?1:'')).") >>
    << /T(".$field_path.".insured_sex_f_chkbox[0]) /V(".escapeFdf((($insured_sex == "F" || $insured_sex == "Female")?1:'')).") >>
";

if ($other_insured_dob != '') {
    $fdf .= "
        << /T(".$field_path.".other_insured_dob_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($other_insured_dob))).") >>
        << /T(".$field_path.".other_insured_dob_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($other_insured_dob))).") >>
        << /T(".$field_path.".other_insured_dob_yy_fill[0]) /V(".escapeFdf(date('Y', strtotime($other_insured_dob))).") >>
    ";
}

$fdf .= "
    << /T(".$field_path.".other_insured_sex_m_chkbox[0]) /V(".escapeFdf(((!empty($other_insured_sex) && ($other_insured_sex == "M" || $other_insured_sex == "Male"))?1:'')).") >>
    << /T(".$field_path.".other_insured_sex_f_chkbox[0]) /V(".escapeFdf(((!empty($other_insured_sex) && ($other_insured_sex == "F" || $other_insured_sex == "Female"))?1:'')).") >>
    << /T(".$field_path.".insured_employers_name_fill[0]) /V(".escapeFdf($insured_employer_school_name).") >>
    << /T(".$field_path.".employers_name_fill[0]) /V(".escapeFdf((!empty($other_insured_employer_school_name) ? $other_insured_employer_school_name : '')).") >>
    << /T(".$field_path.".insured_ins_plan_name_fill[0]) /V(".escapeFdf($insured_insurance_plan).") >>
    << /T(".$field_path.".ins_plan_name_fill[0]) /V(".escapeFdf($other_insured_insurance_plan).") >>
    << /T(".$field_path.".reserved_local_use_fill[0]) /V(".escapeFdf((!empty($reserved_local_use) ? $reserved_local_use : '')).") >>
    << /T(".$field_path.".another_health_benefit_yes_chkbox[0]) /V(".escapeFdf((($another_plan == "YES")?1:'')).") >>
    << /T(".$field_path.".another_health_benefit_no_chkbox[0]) /V(".escapeFdf((($another_plan == "NO")?1:'')).") >>
    << /T(".$field_path.".pt_signature_fill[0]) /V(".escapeFdf(((!empty($patient_signature))?'SIGNATURE ON FILE':'')).") >>
";

if (!empty($patient_signature)) {
    $fdf .= "<< /T(".$field_path.".pt_signature_date_fill[0]) /V(".escapeFdf($patient_signed_date).") >>";
}

$fdf .= "
    << /T(".$field_path.".insured_signature_fill[0]) /V(".escapeFdf(((!empty($insured_signature))?'SIGNATURE ON FILE':'')).") >>
";

if (!empty($date_current)) {
    $fdf .= "
        << /T(".$field_path.".date_of_current_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($date_current))).") >>
        << /T(".$field_path.".date_of_current_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($date_current))).") >>
        << /T(".$field_path.".date_of_current_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($date_current))).") >>
    ";
}

if (!empty($date_same_illness)) {
    $fdf .= "
        << /T(".$field_path.".pt_similar_illness_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($date_same_illness))).") >>
        << /T(".$field_path.".pt_similar_illness_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($date_same_illness))).") >>
        << /T(".$field_path.".pt_similar_illness_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($date_same_illness))).") >>
    ";
}
if (!empty($unable_date_from)) {
    $fdf .= "
        << /T(".$field_path.".date_pt_unable_work_from_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($unable_date_from))).") >>
        << /T(".$field_path.".date_pt_unable_work_from_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($unable_date_from))).") >>
        << /T(".$field_path.".date_pt_unable_work_from_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($unable_date_from))).") >>
    ";
}
if (!empty($unable_date_to)) {
    $fdf .= "
        << /T(".$field_path.".date_pt_unable_work_to_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($unable_date_to))).") >>
        << /T(".$field_path.".date_pt_unable_work_to_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($unable_date_to))).") >>
        << /T(".$field_path.".date_pt_unable_work_to_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($unable_date_to))).") >>
    ";
}
$fdf .= "
    << /T(".$field_path.".name_referring_provider_fill[0]) /V(".escapeFdf((!empty($referring_provider) ? $referring_provider : '')).") >>
    << /T(".$field_path.".seventeenA_fill[0]) /V(".escapeFdf((!empty($field_17a) ? $field_17a : '')).") >>
    << /T(".$field_path.".seventeenb_NPI_fill[0]) /V(".escapeFdf((!empty($diagnosising_npi) ? $diagnosising_npi : '')).") >>
";
if (!empty($hospitalization_date_from)) {
    $fdf .= "
        << /T(".$field_path.".hospitalization_date_from_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($hospitalization_date_from))).") >>
        << /T(".$field_path.".hospitalization_date_from_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($hospitalization_date_from))).") >>
        << /T(".$field_path.".hospitalization_date_from_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($hospitalization_date_from))).") >>
    ";
}
if (!empty($hospitalization_date_to)) {
    $fdf .= "
        << /T(".$field_path.".hospitalization_date_to_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($hospitalization_date_to))).") >>
        << /T(".$field_path.".hospitalization_date_to_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($hospitalization_date_to))).") >>
        << /T(".$field_path.".hospitalization_date_to_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($hospitalization_date_to))).") >>
    ";
}
$fdf .= "
    << /T(".$field_path.".reserved_for_local_fill[0]) /V(".escapeFdf((!empty($reserved_local_use1) ? $reserved_local_use1 : '')).") >>
    << /T(".$field_path.".outside_lab_yes_chkbox[0]) /V(".escapeFdf(((!empty($outside_lab) && $outside_lab == "YES")?1:'')).") >>
    << /T(".$field_path.".outside_lab_no_chkbox[0]) /V(".escapeFdf(((!empty($outside_lab) && $outside_lab == "NO")?1:'')).") >>
    << /T(".$field_path.".charges_fill[0]) /V(".escapeFdf((!empty($s_charges) ? $s_charges : '')).") >>
    << /T(".$field_path.".diagnosis_one_left_fill[0]) /V(".escapeFdf($diagnosis_1_left_fill).") >>
    << /T(".$field_path.".diagnosis_one_right_fill[0]) /V(".escapeFdf($diagnosis_1_right_fill).") >>
    << /T(".$field_path.".diagnosis_two_left_fill[0]) /V(".escapeFdf($diagnosis_2_left_fill).") >>
    << /T(".$field_path.".diagnosis_two_right_fill[0]) /V(".escapeFdf($diagnosis_2_right_fill).") >>
    << /T(".$field_path.".diagnosis_three_left_fill[0]) /V(".escapeFdf($diagnosis_3_left_fill).") >>
    << /T(".$field_path.".diagnosis_three_right_fill[0]) /V(".escapeFdf($diagnosis_3_right_fill).") >>
    << /T(".$field_path.".diagnosis_four_left_fill[0]) /V(".escapeFdf($diagnosis_4_left_fill).") >>
    << /T(".$field_path.".diagnosis_four_right_fill[0]) /V(".escapeFdf($diagnosis_4_right_fill).") >>
    << /T(".$field_path.".medicaid_resubmission_code_fill[0]) /V(".escapeFdf((!empty($medicaid_resubmission_code) ? $medicaid_resubmission_code : '')).") >>
    << /T(".$field_path.".orignial_ref_no_fill[0]) /V(".escapeFdf((!empty($original_ref_no) ? $original_ref_no : '')).") >>
    << /T(".$field_path.".prior_auth_number_fill[0]) /V(".escapeFdf((!empty($prior_authorization_number) ? $prior_authorization_number : '')).") >>
";

$prefix = ['ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX'];

// Get modifier codes
$mod_sql = "SELECT * FROM dental_modifier_code";

$mod_my = $db->getResults($mod_sql);
$mod_array = [];
if ($mod_my) {
    foreach ($mod_my as $mod_row) {
        $mod_array[] = $mod_row;
    }
}

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$sql = "SELECT ledger.*, ";

if ($insurancetype == '1') {
    $sql .= " user.medicare_npi ";
} else {
    $sql .= " user.npi ";
}

$sql .= " as 'provider_id', ps.place_service as 'place' "
    . "FROM "
    . "  dental_ledger ledger "
    . "  JOIN dental_users user ON user.userid = ledger.docid "
    . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
    . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
    . "WHERE "
    . "  ledger.primary_claim_id = " . (!empty($insuranceid) ? $insuranceid : '') . " "
    . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
    . "  AND ledger.docid = " . $docid . " "
    . "  AND trxn_code.docid = " . $docid . " "
    . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
    . "ORDER BY "
    . "  ledger.service_date ASC";

$query = $db->getResults($sql);
$c = 0;

if ($query) {
    foreach ($query as $array) {
        $p = $prefix[$c];
        $c++;
        if ($array['service_date'] != '') {
            $fdf .= "
                << /T(".$field_path.".".$p."_dates_of_service_from_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($array['service_date']))).") >>
                << /T(".$field_path.".".$p."_dates_of_service_from_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($array['service_date']))).") >>
                << /T(".$field_path.".".$p."_dates_of_service_from_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($array['service_date']))).") >>
            ";
        }
        if ($array['service_date']) {
            $fdf .= " 
                << /T(".$field_path.".".$p."_dates_of_service_to_mm_fill[0]) /V(".escapeFdf(date('m', strtotime($array['service_date']))).") >>
                << /T(".$field_path.".".$p."_dates_of_service_to_dd_fill[0]) /V(".escapeFdf(date('d', strtotime($array['service_date']))).") >>
                << /T(".$field_path.".".$p."_dates_of_service_to_yy_fill[0]) /V(".escapeFdf(date('y', strtotime($array['service_date']))).") >>
            ";
        }
        $fdf .= "
            << /T(".$field_path.".".$p."_place_of_service_fill[0]) /V(".escapeFdf($array['placeofservice']).") >>
            << /T(".$field_path.".".$p."_EMG_fill[0]) /V(".escapeFdf($array['emg']).") >>
            << /T(".$field_path.".".$p."_CPT_fill[0]) /V(".escapeFdf($array['transaction_code'] ).") >>
            << /T(".$field_path.".".$p."_modifier_one_fill[0]) /V(".escapeFdf($array['modcode']).") >>
            << /T(".$field_path.".".$p."_modifier_two_fill[0]) /V(".escapeFdf($array['modcode2']).") >>
            << /T(".$field_path.".".$p."_modifier_three_fill[0]) /V(".escapeFdf($array['modcode3']).") >>
            << /T(".$field_path.".".$p."_modifier_four_fill[0]) /V(".escapeFdf($array['modcode4']).") >>
            << /T(".$field_path.".".$p."_diagnosis_pointer_fill[0]) /V(".escapeFdf($array['diagnosispointer']).") >>
            << /T(".$field_path.".".$p."_charges_dollars_fill[0]) /V(".escapeFdf(number_format($array['amount'],0)).") >>
            << /T(".$field_path.".".$p."_charges_cents_fill[0]) /V(".escapeFdf(fill_cents($array['amount']-floor($array['amount']))).") >>
            << /T(".$field_path.".".$p."_days_or_units_fill[0]) /V(".escapeFdf($array['daysorunits']).") >>
            << /T(".$field_path.".".$p."_EPSDT_fill[0]) /V(".escapeFdf($array['epsdt']).") >>
            << /T(".$field_path.".".$p."_rendering_provider_fill[0]) /V(".escapeFdf($array['provider_id']).") >> ";
    }
}

if ($userinfo['tax_id_or_ssn'] != '') {
    $tax_id_or_ssn = $userinfo['tax_id_or_ssn'];
} else {
    $tax_id_or_ssn = $docinfo['tax_id_or_ssn'];
}

if ($userinfo['ssn'] != '' && $userinfo['producer_files'] == 1) {
    $ssn = $userinfo['ssn'];
} else {
    $ssn = $docinfo['ssn'];
}

if ($userinfo['ein'] != '' && $userinfo['producer_files'] == 1) {
    $ein = $userinfo['ein'];
} else {
    $ein = $docinfo['ein'];
}

if (!isset($total_charge)) {
    $total_charge = 0;
}

if (!isset($amount_paid)) {
    $amount_paid = 0;
}

if (!isset($balance_due)) {
    $balance_due = 0;
}

$fdf .= "
    << /T(".$field_path.".fed_tax_id_number_fill[0]) /V(".escapeFdf($tax_id_or_ssn).") >>
    << /T(".$field_path.".fed_tax_id_SSN_chkbox[0]) /V(".escapeFdf((($ssn == "1")?1:'')).") >>
    << /T(".$field_path.".fed_tax_id_EIN_chkbox[0]) /V(".escapeFdf((($ein == "1")?1:'')).") >>
    << /T(".$field_path.".pt_account_number_fill[0]) /V(".escapeFdf((!empty($patient_account_no) ? $patient_account_no : '')).") >>
    << /T(".$field_path.".accept_assignment_yes_chkbox[0]) /V(".escapeFdf((($accept_assignment == "Yes") ? 1 : '')).") >>
    << /T(".$field_path.".accept_assignment_no_chkbox[0]) /V(".escapeFdf((($accept_assignment == "No") ? 1 : '')).") >>
  
    << /T(".$field_path.".total_charge_dollars_fill[0]) /V(".escapeFdf(number_format($total_charge, 0)).") >>
    << /T(".$field_path.".total_charge_cents_fill[0]) /V(".escapeFdf(fill_cents(floor(($total_charge - floor($total_charge)) * 100))).") >>
    << /T(".$field_path.".amount_paid_dollars_fill[0]) /V(".escapeFdf(number_format($amount_paid, 0)).") >>
    << /T(".$field_path.".amount_paid_cents_fill[0]) /V(".escapeFdf(fill_cents(floor(($amount_paid - floor($amount_paid)) * 100))).") >>
    << /T(".$field_path.".balance_due_dollars_fill[0]) /V(".escapeFdf(number_format($balance_due, 0)).") >>
    << /T(".$field_path.".balance_due_cents_fill[0]) /V(".escapeFdf(fill_cents(floor(($balance_due - floor($balance_due)) * 100))).") >>
  
    << /T(".$field_path.".service_facility_location_info_fill[0]) /V(".escapeFdf(strtoupper($practice)."\n".strtoupper($address)."\n".strtoupper($city).", ".strtoupper($state)." ".$zip).") >>
    << /T(".$field_path.".billing_provider_phone_areacode_fill[0]) /V(".escapeFdf(split_phone($phone, true)).") >>
    << /T(".$field_path.".billing_provider_phone_number_fill[0]) /V(".escapeFdf(split_phone($phone, false)).") >>
    << /T(".$field_path.".billing_provider_info_fill[0]) /V(".escapeFdf(strtoupper($practice)."\n".strtoupper($address)."\n".strtoupper($city).", ".strtoupper($state)." ".$zip).") >>
    << /T(".$field_path.".signature_of_physician-supplier_signed_fill[0]) /V(".escapeFdf((!empty($signature_physician) ? $signature_physician : '')).") >>  
    << /T(".$field_path.".signature_of_physician-supplier_date_fill[0]) /V(".escapeFdf(date('m/d/y')).") >>
    << /T(".$field_path.".service_facility_NPI_a_fill[0]) /V(".escapeFdf((($insurancetype == '1')?$medicare_npi:$npi)).") >>
    << /T(".$field_path.".service_facility_other_id_b_fill[0]) /V(".escapeFdf((!empty($service_info_b_other) ? $service_info_b_other : '')).") >>
    << /T(".$field_path.".billing_provider_NPI_a_fill[0]) /V(".escapeFdf((($insurancetype == '1')?$medicare_npi:$npi)).") >>
    << /T(".$field_path.".billing_provider_other_id_b_fill[0]) /V(".escapeFdf((!empty($billing_provider_b_other) ? $billing_provider_b_other : '')).") >>
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

$d = date('YmdHms');
$file = "fdf_".(!empty($_GET['insid']) ? $_GET['insid'] : '')."_".(!empty($_GET['pid']) ? $_GET['pid'] : '')."_".$d.".fdf";

if (!empty($_REQUEST['type']) && $_REQUEST['type'] == "secondary") {
    $fdf_field = "secondary_fdf";
} else {
    $fdf_field = "primary_fdf";
}

$sql = "UPDATE dental_insurance SET ".$fdf_field."='".$db->escape($file)."' WHERE insuranceid='".$db->escape((!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";
$db->query($sql);

$handle = fopen("../../../shared/q_file/".$file, 'x+');
fwrite($handle, $fdf);
fclose($handle);

$xfdf_file_path = '../../../shared/q_file/'.$file;
$pdf_template_path = 'claim.pdf';
$pdftk = '/usr/bin/pdftk';
$pdf_name = substr( $xfdf_file_path, 0, -4 ) . '.pdf';
$result_pdf = $pdf_name;
$command = "$pdftk $pdf_template_path fill_form $xfdf_file_path output $result_pdf flatten";

exec($command, $output, $exitStatus);

if ($exitStatus) {
    error_log("Print claim failed. PDFtk command: $command");
    error_log("PDFtk output:\n\t" . join("\n\t", $output));
    error_log("PDFtk exit status: $exitStatus");
}

include_once '3rdParty/fpdi/fpdi.php';

class PDF extends \FPDI {
    /**
     * "Remembers" the template id of the imported page
     */
    public $_tplIdx;
    public $_template;
    private $db;
    private $con;

    public function __construct(
        Db $db,
        $orientation = 'P',
        $unit = 'mm',
        $format = 'A4',
        $unicode = true,
        $encoding = 'UTF-8',
        $diskcache = false
    ) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
        $this->db = $db;
        $this->con = $GLOBALS['con'];
    }

    /**
     * include a background template for every page
     */

    public function Header()
    {
        if (is_null($this->_tplIdx)) {
            $this->setSourceFile($this->_template);
            $this->_tplIdx = $this->importPage(1);
        }

        if (isset($_SESSION['adminuserid'])) {
            $d_sql = "SELECT claim_margin_top, claim_margin_left FROM admin where adminid='".mysqli_real_escape_string($this->con, $_SESSION['adminuserid'])."'";

            $d_r = $this->db->getRow($d_sql);
            $claim_margin_left = $d_r['claim_margin_left'];
            $claim_margin_top = $d_r['claim_margin_top'];
        } elseif (isset($_SESSION['userid'])) {
            $d_sql = "SELECT claim_margin_top, claim_margin_left FROM dental_users where userid='".mysqli_real_escape_string($this->con, $_SESSION['docid'])."'";

            $d_r = $this->db->getRow($d_sql);
            $claim_margin_left = $d_r['claim_margin_left'];
            $claim_margin_top = $d_r['claim_margin_top'];
        } else {
            $claim_margin_left = 0;
            $claim_margin_top = 0;
        }

        $this->useTemplate($this->_tplIdx, $claim_margin_left, $claim_margin_top);
    }

    public function Footer()
    {
        // no content
    }
}

// initiate PDF
$pdf = new PDF($db, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->_template = $result_pdf;
$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(true, 40);
$pdf->setFontSubsetting(false);

// add a page
$pdf->AddPage();

$pdf->Output('insurance_claim.pdf', 'D');

function fill_cents($v)
{
    if ($v < 10) {
        return '0'.$v;
    } else {
        return $v;
    }
}

function escapeFdf($value)
{
    return addcslashes($value, '\()');
}
