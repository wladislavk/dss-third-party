<?php namespace Ds3\Libraries\Legacy; ?><?php
//header("Content-type: application/vnd.fdf");
//header('Content-Disposition: attachment; filename="file.fdf"');

include_once('includes/constants.inc');
include_once('admin/includes/main_include.php');
include_once('admin/includes/invoice_functions.php');

require_once __DIR__ . '/admin/includes/claim_functions.php';

$secondaryIdTypes = [
    '0B' => 'State License Number',
    '1G' => 'Provider UPIN Number',
    'G2' => 'Provider Commercial Number'
];

$field_path = "form1[0].#subform[0]";
$pdf_doc= __DIR__ . '/claim_v2.pdf';

$claimId = intval($_GET['insid']);
$patientId = intval($_GET['pid']);

$claimData = ClaimFormData::storedDataForClaim($claimId, $patientId);
$patientData = $db->getRow("SELECT * FROM dental_patients WHERE patientid = '$patientId'");

$isSecondary =
    ClaimFormData::isSecondary($claimData['status']) || ($_GET['instype'] == 2) || ($_GET['type'] == 'secondary');
$docId = intval($patientData['docid']);

$pica1 = strtoupper($claimData['pica1']);
$pica2 = strtoupper($claimData['pica2']);
$pica3 = strtoupper($claimData['pica3']);

$insurancetype = strtoupper($claimData['insurance_type']);

$patient_lastname = strtoupper(st($claimData['patient_lastname']));
$patient_firstname = strtoupper(st($claimData['patient_firstname']));
$patient_middle = strtoupper(st($claimData['patient_middle']));
$patient_dob = str_replace('-','/',st($claimData['patient_dob']));
$patient_sex = strtoupper($claimData['patient_sex']);
$patient_phone_code = strtoupper($claimData['patient_phone_code']);
$patient_phone = strtoupper($claimData['patient_phone']);
$patient_relation_insured = strtoupper($claimData['patient_relation_insured']);
$patient_status = strtoupper($claimData['patient_status']);
$patient_status_array = split('~', $patient_status);

$insured_id_number =preg_replace("/[^A-Za-z0-9 ]/", '', $claimData['insured_id_number']);
$insured_firstname = strtoupper($claimData['insured_firstname']);
$insured_middle = strtoupper($claimData['insured_middle']);
$insured_lastname = strtoupper($claimData['insured_lastname']);
$insured_dob =str_replace('-', '/', $claimData['insured_dob']);
$insured_sex = strtoupper($claimData['insured_sex']);
$insured_address = strtoupper(st($claimData['insured_address']));
$insured_city = strtoupper(st($claimData['insured_city']));
$insured_state = strtoupper(st($claimData['insured_state']));
$insured_zip = strtoupper($claimData['insured_zip']);
$insured_phone_code = strtoupper($claimData['insured_phone_code']);
$insured_phone = strtoupper($claimData['insured_phone']);
$insured_employer_school_name = strtoupper(st($claimData['insured_employer_school_name']));
$insured_insurance_plan = strtoupper($claimData['insured_insurance_plan']);
$insured_policy_group_feca = strtoupper($claimData['insured_policy_group_feca']);

$other_insured_firstname = strtoupper($claimData['other_insured_firstname']);
$other_insured_lastname = strtoupper($claimData['other_insured_lastname']);
$other_insured_middle = strtoupper($claimData['other_insured_middle']);
$other_insured_dob =str_replace('-', '/', $claimData['other_insured_dob']);
$other_insured_sex = strtoupper($claimData['other_insured_sex']);
$other_insured_employer_school_name = strtoupper(st($claimData['other_insured_employer_school_name']));
$other_insured_insurance_plan = strtoupper($claimData['other_insured_insurance_plan']);
$other_insured_policy_group_feca = strtoupper($claimData['other_insured_policy_group_feca']);

$employment = strtoupper($claimData['employment']);
$auto_accident = strtoupper($claimData['auto_accident']);
$auto_accident_place = strtoupper($claimData['auto_accident_place']);
$other_accident = strtoupper($claimData['other_accident']);

$current_qual = strtoupper($claimData['current_qual']);
$same_illness_qual = strtoupper($claimData['same_illness_qual']);

$another_plan = strtoupper(st($claimData['another_plan']));

$patient_signature = strtoupper($claimData['patient_signature']);
$patient_signed_date = strtoupper($claimData['patient_signed_date']);
$insured_signature = strtoupper($claimData['insured_signature']);
$date_current = str_replace('-','/',st($claimData['date_current']));
$date_same_illness = str_replace('-','/',st($claimData['date_same_illness']));
$unable_date_from = str_replace('-','/',st($claimData['unable_date_from']));
$unable_date_to = str_replace('-','/',st($claimData['unable_date_to']));
$referring_provider = strtoupper(st($claimData['referring_provider']));
$field_17a_dd = strtoupper($claimData['field_17a_dd']);
$field_17a = strtoupper($claimData['field_17a']);
$field_17b = strtoupper($claimData['field_17b']);
$hospitalization_date_from = str_replace('-','/',st($claimData['hospitalization_date_from']));
$hospitalization_date_to = str_replace('-','/',st($claimData['hospitalization_date_to']));
$reserved_local_use1 = strtoupper(st($claimData['reserved_local_use1']));
$outside_lab = strtoupper(st($claimData['outside_lab']));
$s_charges = strtoupper($claimData['s_charges']);
$diagnosis_1 = strtoupper($claimData['diagnosis_1']);
$diagnosis_2 = strtoupper($claimData['diagnosis_2']);
$diagnosis_3 = strtoupper($claimData['diagnosis_3']);
$diagnosis_4 = strtoupper($claimData['diagnosis_4']);
$diagnosis_a = strtoupper($claimData['diagnosis_a']);
$diagnosis_b = strtoupper($claimData['diagnosis_b']);
$diagnosis_c = strtoupper($claimData['diagnosis_c']);
$diagnosis_d = strtoupper($claimData['diagnosis_d']);
$diagnosis_e = strtoupper($claimData['diagnosis_e']);
$diagnosis_f = strtoupper($claimData['diagnosis_f']);
$diagnosis_g = strtoupper($claimData['diagnosis_g']);
$diagnosis_h = strtoupper($claimData['diagnosis_h']);
$diagnosis_i = strtoupper($claimData['diagnosis_i']);
$diagnosis_j = strtoupper($claimData['diagnosis_j']);
$diagnosis_k = strtoupper($claimData['diagnosis_k']);
$diagnosis_l = strtoupper($claimData['diagnosis_l']);

$medicaid_resubmission_code = strtoupper($claimData['medicaid_resubmission_code']);
$original_ref_no = strtoupper($claimData['original_ref_no']);
$prior_authorization_number = strtoupper($claimData['prior_authorization_number']);

$service_date1_from = str_replace('-','/',st($claimData['service_date1_from']));
$service_date1_to = str_replace('-','/',st($claimData['service_date1_to']));
$place_of_service1 = strtoupper(st($claimData['place_of_service1']));
$emg1 = strtoupper(st($claimData['emg1']));
$cpt_hcpcs1 = strtoupper($claimData['cpt_hcpcs1']);
$modifier1_1 = strtoupper($claimData['modifier1_1']);
$modifier1_2 = strtoupper($claimData['modifier1_2']);
$modifier1_3 = strtoupper($claimData['modifier1_3']);
$modifier1_4 = strtoupper($claimData['modifier1_4']);
$diagnosis_pointer1 = strtoupper($claimData['diagnosis_pointer1']);
$s_charges1_1 = strtoupper($claimData['s_charges1_1']);
$s_charges1_2 = strtoupper($claimData['s_charges1_2']);
$days_or_units1 = strtoupper($claimData['days_or_units1']);
$epsdt_family_plan1 = strtoupper(st($claimData['epsdt_family_plan1']));
$id_qua1 = strtoupper($claimData['id_qua1']);
$rendering_provider_id1 = strtoupper($claimData['rendering_provider_id1']);

$service_date2_from = str_replace('-','/',st($claimData['service_date2_from']));
$service_date2_to = str_replace('-','/',st($claimData['service_date2_to']));
$place_of_service2 = strtoupper(st($claimData['place_of_service2']));
$emg2 = strtoupper($claimData['emg2']);
$cpt_hcpcs2 = strtoupper($claimData['cpt_hcpcs2']);
$modifier2_1 = strtoupper($claimData['modifier2_1']);
$modifier2_2 = strtoupper($claimData['modifier2_2']);
$modifier2_3 = strtoupper($claimData['modifier2_3']);
$modifier2_4 = strtoupper($claimData['modifier2_4']);
$diagnosis_pointer2 = strtoupper($claimData['diagnosis_pointer2']);
$s_charges2_1 = strtoupper($claimData['s_charges2_1']);
$s_charges2_2 = strtoupper($claimData['s_charges2_2']);
$days_or_units2 = strtoupper($claimData['days_or_units2']);
$epsdt_family_plan2 = strtoupper($claimData['epsdt_family_plan2']);
$id_qua2 = strtoupper($claimData['id_qua2']);
$rendering_provider_id2 = strtoupper($claimData['rendering_provider_id2']);

$service_date3_from = str_replace('-','/',st($claimData['service_date3_from']));
$service_date3_to = str_replace('-','/',st($claimData['service_date3_to']));
$place_of_service3 = strtoupper(st($claimData['place_of_service3']));
$emg3 = strtoupper($claimData['emg3']);
$cpt_hcpcs3 = strtoupper($claimData['cpt_hcpcs3']);
$modifier3_1 = strtoupper($claimData['modifier3_1']);
$modifier3_2 = strtoupper($claimData['modifier3_2']);
$modifier3_3 = strtoupper($claimData['modifier3_3']);
$modifier3_4 = strtoupper($claimData['modifier3_4']);
$diagnosis_pointer3 = strtoupper($claimData['diagnosis_pointer3']);
$s_charges3_1 = strtoupper($claimData['s_charges3_1']);
$s_charges3_2 = strtoupper($claimData['s_charges3_2']);
$days_or_units3 = strtoupper($claimData['days_or_units3']);
$epsdt_family_plan3 = strtoupper($claimData['epsdt_family_plan3']);
$id_qua3 = strtoupper($claimData['id_qua3']);
$rendering_provider_id3 = strtoupper($claimData['rendering_provider_id3']);

$service_date4_from = str_replace('-','/',st($claimData['service_date4_from']));
$service_date4_to = str_replace('-','/',st($claimData['service_date4_to']));
$place_of_service4 = strtoupper(st($claimData['place_of_service4']));
$emg4 = strtoupper($claimData['emg4']);
$cpt_hcpcs4 = strtoupper($claimData['cpt_hcpcs4']);
$modifier4_1 = strtoupper($claimData['modifier4_1']);
$modifier4_2 = strtoupper($claimData['modifier4_2']);
$modifier4_3 = strtoupper($claimData['modifier4_3']);
$modifier4_4 = strtoupper($claimData['modifier4_4']);
$diagnosis_pointer4 = strtoupper($claimData['diagnosis_pointer4']);
$s_charges4_1 = strtoupper($claimData['s_charges4_1']);
$s_charges4_2 = strtoupper($claimData['s_charges4_2']);
$days_or_units4 = strtoupper($claimData['days_or_units4']);
$epsdt_family_plan4 = strtoupper($claimData['epsdt_family_plan4']);
$id_qua4 = strtoupper($claimData['id_qua4']);
$rendering_provider_id4 = strtoupper($claimData['rendering_provider_id4']);

$service_date5_from = str_replace('-','/',st($claimData['service_date5_from']));
$service_date5_to = str_replace('-','/',st($claimData['service_date5_to']));
$place_of_service5 = strtoupper($claimData['place_of_service5']);
$emg5 = strtoupper($claimData['emg5']);
$cpt_hcpcs5 = strtoupper($claimData['cpt_hcpcs5']);
$modifier5_1 = strtoupper($claimData['modifier5_1']);
$modifier5_2 = strtoupper($claimData['modifier5_2']);
$modifier5_3 = strtoupper($claimData['modifier5_3']);
$modifier5_4 = strtoupper($claimData['modifier5_4']);
$diagnosis_pointer5 = strtoupper($claimData['diagnosis_pointer5']);
$s_charges5_1 = strtoupper($claimData['s_charges5_1']);
$s_charges5_2 = strtoupper($claimData['s_charges5_2']);
$days_or_units5 = strtoupper($claimData['days_or_units5']);
$epsdt_family_plan5 = strtoupper($claimData['epsdt_family_plan5']);
$id_qua5 = strtoupper($claimData['id_qua5']);
$rendering_provider_id5 = strtoupper($claimData['rendering_provider_id5']);

$service_date6_from = str_replace('-','/',st($claimData['service_date6_from']));
$service_date6_to = str_replace('-','/',st($claimData['service_date6_to']));
$place_of_service6 = strtoupper($claimData['place_of_service6']);
$emg6 = strtoupper($claimData['emg6']);
$cpt_hcpcs6 = strtoupper($claimData['cpt_hcpcs6']);
$modifier6_1 = strtoupper($claimData['modifier6_1']);
$modifier6_2 = strtoupper($claimData['modifier6_2']);
$modifier6_3 = strtoupper($claimData['modifier6_3']);
$modifier6_4 = strtoupper($claimData['modifier6_4']);
$diagnosis_pointer6 = strtoupper($claimData['diagnosis_pointer6']);
$s_charges6_1 = strtoupper($claimData['s_charges6_1']);
$s_charges6_2 = strtoupper($claimData['s_charges6_2']);
$days_or_units6 = strtoupper($claimData['days_or_units6']);
$epsdt_family_plan6 = strtoupper($claimData['epsdt_family_plan6']);
$id_qua6 = strtoupper($claimData['id_qua6']);
$rendering_provider_id6 = strtoupper($claimData['rendering_provider_id6']);

$federal_tax_id_number = strtoupper($claimData['federal_tax_id_number']);
$ssn = strtoupper($claimData['ssn']);
$ein = strtoupper($claimData['ein']);
$patient_account_no = strtoupper($claimData['patient_account_no']);
$accept_assignment = strtoupper($claimData['accept_assignment']);
$total_charge = str_replace(",", '',strtoupper($claimData['total_charge']));
$amount_paid = str_replace(",", '',strtoupper($claimData['amount_paid']));
$balance_due = str_replace(",", '',strtoupper($claimData['balance_due']));
$signature_physician = strtoupper($claimData['signature_physician']);
$physician_signed_date = strtoupper($claimData['physician_signed_date']);

$service_facility_info_name = strtoupper(st($claimData['service_facility_info_name']));
$service_facility_info_address = strtoupper(st($claimData['service_facility_info_address']));
$service_facility_info_city = strtoupper(st($claimData['service_facility_info_city']));
$service_info_a = strtoupper(st($claimData['service_info_a']));
$service_info_dd = strtoupper(st($claimData['service_info_dd']));
$service_info_b_other = strtoupper(st($claimData['service_info_b_other']));
$billing_provider_phone_code = strtoupper($claimData['billing_provider_phone_code']);
$billing_provider_phone = strtoupper($claimData['billing_provider_phone']);
$billing_provider_name = strtoupper(st($claimData['billing_provider_name']));
$billing_provider_address = strtoupper(st($claimData['billing_provider_address']));
$billing_provider_city = strtoupper(st($claimData['billing_provider_city']));
$billing_provider_a = strtoupper(st($claimData['billing_provider_a']));
$billing_provider_dd = strtoupper(st($claimData['billing_provider_dd']));
$billing_provider_b_other = strtoupper(st($claimData['billing_provider_b_other']));

$nucc_8a = strtoupper($claimData['nucc_8a']);
$nucc_8b = strtoupper($claimData['nucc_8b']);
$nucc_9a = strtoupper($claimData['nucc_9a']);
$nucc_9b = strtoupper($claimData['nucc_9b']);
$nucc_30 = strtoupper($claimData['nucc_30']);
$claim_codes = strtoupper($claimData['claim_codes']);
$other_claim_id = strtoupper($claimData['other_claim_id']);
$nucc_9c = strtoupper($claimData['nucc_9c']);
$icd_ind = strtoupper($claimData['icd_ind']);
$resubmission_code_fill = strtoupper($claimData['resubmission_code_fill']);
$name_referring_provider_qualifier= strtoupper($claimData['name_referring_provider_qualifier']);

$insuranceCompanyId = intval($isSecondary ? $patientData['s_m_ins_co'] : $patientData['p_m_ins_co']);
$insuranceCompanyData = $db->getRow("SELECT * FROM dental_contact WHERE contactid ='$insuranceCompanyId'");
$insuranceCompanyData = $insuranceCompanyData ?: [];

// Standardize the dates
$patient_dob = dateToTime($patient_dob);
$insured_dob = dateToTime($insured_dob);
$other_insured_dob = dateToTime($other_insured_dob);
$date_current = dateToTime($date_current);
$date_same_illness = dateToTime($date_same_illness);
$unable_date_from = dateToTime($unable_date_from);
$unable_date_to = dateToTime($unable_date_to);
$hospitalization_date_from = dateToTime($hospitalization_date_from);
$hospitalization_date_to = dateToTime($hospitalization_date_to);
$patient_signed_date = dateFormat($patient_signed_date, false);
$physician_signed_date = dateFormat($physician_signed_date, false);

list($patient_phone_code, $patient_phone) = parsePhoneNumber($patient_phone_code, $patient_phone);
list($insured_phone_code, $insured_phone) = parsePhoneNumber($insured_phone_code, $insured_phone);
list($billing_provider_phone_code, $billing_provider_phone) = parsePhoneNumber(
    $billing_provider_phone_code, $billing_provider_phone
);

$fdf = "
        %FDF-1.2
        1 0 obj
        << /FDF 
        << /Fields 
        [ 
          << /T(".$field_path.".carrier_name_fill[0]) /V(".escapeFdf(strtoupper($insuranceCompanyData['company'])).") >>
          << /T(".$field_path.".carrier_address1_fill[0]) /V(".escapeFdf(strtoupper($insuranceCompanyData['add1'])).") >>
          << /T(".$field_path.".carrier_address2_fill[0]) /V(".escapeFdf(strtoupper($insuranceCompanyData['add2'])).") >>
          << /T(".$field_path.".carrier_citystatezip_fill[0]) /V(".escapeFdf(strtoupper($insuranceCompanyData['city'])." ".strtoupper($insuranceCompanyData['state']).", ".$insuranceCompanyData['zip']).") >>
          << /T(".$field_path.".pica_right_side_fill[0]) /V(".escapeFdf((!empty($pica1) ? $pica1 : '').(!empty($pica2) ? $pica2 : '').(!empty($pica3) ? $pica3 : '')).") >>

          << /T(".$field_path.".medicare_chkbox[0]) /V(".escapeFdf((($insurancetype == '1')?1:'')).") >>
          << /T(".$field_path.".medicaid_chkbox[0]) /V(".escapeFdf((($insurancetype == '2')?1:'')).") >>
          << /T(".$field_path.".tricare_chkbox[0]) /V(".escapeFdf((($insurancetype == '3')?1:'')).") >>
          << /T(".$field_path.".champva_chkbox[0]) /V(".escapeFdf((($insurancetype == '4')?1:'')).") >>
          << /T(".$field_path.".grouphealth_chkbox[0]) /V(".escapeFdf((($insurancetype == '5')?1:'')).") >>
          << /T(".$field_path.".feca_chkbox[0]) /V(".escapeFdf((($insurancetype == '6')?1:'')).") >>
          << /T(".$field_path.".otherins_chkbox[0]) /V(".escapeFdf((($insurancetype == '7')?1:'')).") >>

          << /T(".$field_path.".box8_nucc[0]) /V(".escapeFdf((!empty($nucc_8a) ? $nucc_8a : '')).") >>
          << /T(".$field_path.".box9b_nucc[0]) /V(".escapeFdf((!empty($nucc_9b) ? $nucc_9b : '')).") >>
          << /T(".$field_path.".insured_id_number_fill[0]) /V(".escapeFdf($insured_id_number).") >>
          << /T(".$field_path.".insured_id_number_fill[0]) /V(".escapeFdf($insured_id_number).") >>
          << /T(".$field_path.".insured_id_number_fill[0]) /V(".escapeFdf($insured_id_number).") >>

          << /T(".$field_path.".insured_id_number_fill[0]) /V(".escapeFdf($insured_id_number).") >>
          << /T(".$field_path.".pt_name_fill[0]) /V(".escapeFdf($patient_lastname.", ".$patient_firstname.((trim($patient_middle)!='')?", ".$patient_middle:'')).") >>
          ";
if($patient_dob!=''){
    $fdf .= "
          << /T(".$field_path.".pt_birth_date_mm_fill[0]) /V(".escapeFdf(date('m', $patient_dob)).") >>
          << /T(".$field_path.".pt_birth_date_dd_fill[0]) /V(".escapeFdf(date('d', $patient_dob)).") >>
          << /T(".$field_path.".pt_birth_date_yy_fill[0]) /V(".escapeFdf(date('Y', $patient_dob)).") >>
        ";
}
$fdf .= "
        << /T(".$field_path.".pt_sex_m_chkbox[0]) /V(".escapeFdf((($patient_sex == "M" || $patient_sex == "Male")?1:'')).") >>
        << /T(".$field_path.".pt_sex_f_chkbox[0]) /V(".escapeFdf((($patient_sex == "F" || $patient_sex == "Female")?1:'')).") >>
        << /T(".$field_path.".insured_name_ln_fn_mi_fill[0]) /V(".escapeFdf($insured_lastname.", ".$insured_firstname.((trim($insured_middle)!='')?", ".$insured_middle:'')).") >>
        << /T(".$field_path.".pt_address_fill[0]) /V(".escapeFdf($insured_address).") >>
        << /T(".$field_path.".pt_relation_self_chkbox[0]) /V(".escapeFdf(((strtoupper($patient_relation_insured) == "SELF")?1:'')).") >>
        << /T(".$field_path.".pt_relation_spouse_chkbox[0]) /V(".escapeFdf(((strtoupper($patient_relation_insured) == "SPOUSE" || $patient_relation_insured == '01')?1:'')).") >>
        << /T(".$field_path.".pt_relation_child_chkbox[0]) /V(".escapeFdf(((strtoupper($patient_relation_insured) == "CHILD"|| $patient_relation_insured == '19')?1:'')).") >>
        << /T(".$field_path.".pt_relation_other_chkbox[0]) /V(".escapeFdf(((strtoupper($patient_relation_insured) == "OTHER" || $patient_relation_insured == 'G8')?1:'')).") >>
        << /T(".$field_path.".insured_address_fill[0]) /V(".escapeFdf($insured_address).") >>
        << /T(".$field_path.".pt_city_fill[0]) /V(".escapeFdf($insured_city).") >>
        << /T(".$field_path.".pt_state_fill[0]) /V(".escapeFdf($insured_state).") >>
        << /T(".$field_path.".pt_status_single_chkbox[0]) /V(".escapeFdf(((isset($patient_status_array) && in_array("Single", $patient_status_array))?1:'')).") >>
        << /T(".$field_path.".pt_status_married_chkbox[0]) /V(".escapeFdf(((isset($patient_status_array) && in_array("Married", $patient_status_array))?1:'')).") >>
        << /T(".$field_path.".pt_status_other_chkbox[0]) /V(".escapeFdf(((isset($patient_status_array) && in_array("Others", $patient_status_array))?1:'')).") >>
        << /T(".$field_path.".insured_city_fill[0]) /V(".escapeFdf($insured_city).") >>
        << /T(".$field_path.".insured_state_fill[0]) /V(".escapeFdf($insured_state).") >>
        << /T(".$field_path.".pt_zipcode_fill[0]) /V(".escapeFdf($insured_zip).") >>
        << /T(".$field_path.".pt_phone_areacode_fill[0]) /V(".escapeFdf($patient_phone_code).") >>
        << /T(".$field_path.".pt_phone_number_fill[0]) /V(".escapeFdf($patient_phone).") >>
        << /T(".$field_path.".pt_status_employed_chkbox[0]) /V(".escapeFdf(((isset($patient_status_array) && in_array("Employed", $patient_status_array))?1:'')).") >>
        << /T(".$field_path.".pt_status_ftstudent_chkbox[0]) /V(".escapeFdf(((isset($patient_status_array) && in_array("Full Time Student", $patient_status_array))?1:'')).") >>
        << /T(".$field_path.".pt_status_ptstudent_chkbox[0]) /V(".escapeFdf(((isset($patient_status_array) && in_array("Part Time Student", $patient_status_array))?1:'')).") >>
        << /T(".$field_path.".insured_zipcode_fill[0]) /V(".escapeFdf($insured_zip).") >>
        << /T(".$field_path.".insured_phone_areacode_fill[0]) /V(".escapeFdf($insured_phone_code).") >>
        << /T(".$field_path.".insured_phone_number_fill[0]) /V(".escapeFdf($insured_phone).") >>
        << /T(".$field_path.".other_insured_name_fill[0]) /V(".escapeFdf($other_insured_lastname." ".$other_insured_firstname." ".$other_insured_middle).") >>
        << /T(".$field_path.".insured_policy_group_fill[0]) /V(".escapeFdf($insured_policy_group_feca).") >>
        << /T(".$field_path.".other_insured_policy_fill[0]) /V(".escapeFdf($other_insured_policy_group_feca).") >>
        << /T(".$field_path.".pt_condition_employment_yes_chkbox[0]) /V(".escapeFdf(isOptionSelected($employment) ? 1 : '').") >>
        << /T(".$field_path.".pt_condition_employment_no_chkbox[0]) /V(".escapeFdf(!isoptionselected($employment) ? 1 : '').") >>
        << /T(".$field_path.".pt_condition_auto_yes_chkbox[0]) /V(".escapeFdf(isOptionSelected($auto_accident) ? 1 : '').") >>
        << /T(".$field_path.".pt_condition_auto_no_chkbox[0]) /V(".escapeFdf(!isOptionSelected($auto_accident) ? 1 : '').") >>
        << /T(".$field_path.".pt_condition_place_fill[0]) /V(".escapeFdf((!empty($auto_accident_place) ? $auto_accident_place : '')).") >>
        << /T(".$field_path.".pt_condition_otheracc_yes_chkbox[0]) /V(".escapeFdf(isOptionSelected($other_accident) ? 1 : '').") >>
        << /T(".$field_path.".pt_condition_otheracc_no_chkbox[0]) /V(".escapeFdf(!isOptionSelected($other_accident) ? 1 : '').") >>
        ";

if(!empty($insured_dob)){
    $fdf .= "
          << /T(".$field_path.".insured_dob_mm_fill[0]) /V(".escapeFdf(date('m', $insured_dob)).") >>
          << /T(".$field_path.".insured_dob_dd_fill[0]) /V(".escapeFdf(date('d', $insured_dob)).") >>
          << /T(".$field_path.".insured_dob_yy_fill[0]) /V(".escapeFdf(date('Y', $insured_dob)).") >>
        ";
}
$fdf .= "
        << /T(".$field_path.".current_qual[0]) /V(".escapeFdf(!empty($current_qual) ? $current_qual : '').") >>
        << /T(".$field_path.".same_illness_qual[0]) /V(".escapeFdf(!empty($same_illness_qual) ? $same_illness_qual : '').") >>
    ";
$fdf .= "
        << /T(".$field_path.".insured_sex_m_chkbox[0]) /V(".escapeFdf((($insured_sex == "M" || $insured_sex == "Male")?1:'')).") >>
        << /T(".$field_path.".insured_sex_f_chkbox[0]) /V(".escapeFdf((($insured_sex == "F" || $insured_sex == "Female")?1:'')).") >>
        ";
if($other_insured_dob!=''){
    $fdf .= "
          << /T(".$field_path.".other_insured_dob_mm_fill[0]) /V(".escapeFdf(date('m', $other_insured_dob)).") >>
          << /T(".$field_path.".other_insured_dob_dd_fill[0]) /V(".escapeFdf(date('d', $other_insured_dob)).") >>
          << /T(".$field_path.".other_insured_dob_yy_fill[0]) /V(".escapeFdf(date('Y', $other_insured_dob)).") >>
        ";
}
$fdf .= "
        << /T(".$field_path.".other_insured_sex_m_chkbox[0]) /V(".escapeFdf(((!empty($other_insured_sex) && ($other_insured_sex == "M" || $other_insured_sex == "Male"))?1:'')).") >>
        << /T(".$field_path.".other_insured_sex_f_chkbox[0]) /V(".escapeFdf(((!empty($other_insured_sex) && ($other_insured_sex == "F" || $other_insured_sex == "Female"))?1:'')).") >>
        << /T(".$field_path.".insured_employers_name_fill[0]) /V(".escapeFdf($insured_employer_school_name).") >>
        << /T(".$field_path.".employers_name_fill[0]) /V(".escapeFdf((!empty($other_insured_employer_school_name) ? $other_insured_employer_school_name : '')).") >>
        << /T(".$field_path.".insured_ins_plan_name_fill[0]) /V(".escapeFdf($insured_insurance_plan).") >>
        << /T(".$field_path.".box11b_nucc[0]) /V(".escapeFdf($other_claim_id).") >>
        << /T(".$field_path.".box9c_nucc[0]) /V(".escapeFdf($nucc_9c).") >>
        << /T(".$field_path.".ins_plan_name_fill[0]) /V(".escapeFdf($other_insured_insurance_plan).") >>
        << /T(".$field_path.".reserved_local_use_fill[0]) /V(".escapeFdf((!empty($claim_codes) ? $claim_codes : '')).") >>
        << /T(".$field_path.".another_health_benefit_yes_chkbox[0]) /V(".escapeFdf(isOptionSelected($another_plan) ? 1 : '').") >>
        << /T(".$field_path.".another_health_benefit_no_chkbox[0]) /V(".escapeFdf(!isOptionSelected($another_plan) ? 1 : '').") >>
        << /T(".$field_path.".pt_signature_fill[0]) /V(".escapeFdf(isOptionSelected($patient_signature) ? 'SIGNATURE ON FILE' : '').") >>
        ";
if(!empty($patient_signature)){
    $fdf .= "<< /T(".$field_path.".pt_signature_date_fill[0]) /V(".escapeFdf($patient_signed_date).") >>";
}
$fdf .= "<< /T(".$field_path.".insured_signature_fill[0]) /V(".escapeFdf(isOptionSelected($insured_signature) ? 'SIGNATURE ON FILE' : '').") >>";
if(!empty($date_current)){
    $fdf .= "
          << /T(".$field_path.".date_of_current_mm_fill[0]) /V(".escapeFdf(date('m', $date_current)).") >>
          << /T(".$field_path.".date_of_current_dd_fill[0]) /V(".escapeFdf(date('d', $date_current)).") >>
          << /T(".$field_path.".date_of_current_yy_fill[0]) /V(".escapeFdf(date('y', $date_current)).") >>
        ";
}
if(!empty($date_same_illness)){
    $fdf .= "
          << /T(".$field_path.".pt_similar_illness_mm_fill[0]) /V(".escapeFdf(date('m', $date_same_illness)).") >>
          << /T(".$field_path.".pt_similar_illness_dd_fill[0]) /V(".escapeFdf(date('d', $date_same_illness)).") >>
          << /T(".$field_path.".pt_similar_illness_yy_fill[0]) /V(".escapeFdf(date('y', $date_same_illness)).") >>
        ";
}
if(!empty($unable_date_from)){
    $fdf .= "
          << /T(".$field_path.".date_pt_unable_work_from_mm_fill[0]) /V(".escapeFdf(date('m', $unable_date_from)).") >>
          << /T(".$field_path.".date_pt_unable_work_from_dd_fill[0]) /V(".escapeFdf(date('d', $unable_date_from)).") >>
          << /T(".$field_path.".date_pt_unable_work_from_yy_fill[0]) /V(".escapeFdf(date('y', $unable_date_from)).") >>
        ";
}
if(!empty($unable_date_to)){
    $fdf .= "
          << /T(".$field_path.".date_pt_unable_work_to_mm_fill[0]) /V(".escapeFdf(date('m', $unable_date_to)).") >>
          << /T(".$field_path.".date_pt_unable_work_to_dd_fill[0]) /V(".escapeFdf(date('d', $unable_date_to)).") >>
          << /T(".$field_path.".date_pt_unable_work_to_yy_fill[0]) /V(".escapeFdf(date('y', $unable_date_to)).") >>
        ";
}
$fdf .= "
        << /T(".$field_path.".name_referring_provider_fill[0]) /V(".escapeFdf((!empty($referring_provider) ? $referring_provider : '')).") >>
        << /T(".$field_path.".seventeenA_fill[0]) /V(".escapeFdf(isset($secondaryIdTypes[$field_17a]) ? $secondaryIdTypes[$field_17a] : '').") >>
        << /T(".$field_path.".seventeenb_NPI_fill[0]) /V(".escapeFdf((!empty($field_17b) ? $field_17b : '')).") >>
        ";
if(!empty($hospitalization_date_from)){
    $fdf .= "
          << /T(".$field_path.".hospitalization_date_from_mm_fill[0]) /V(".escapeFdf(date('m', $hospitalization_date_from)).") >>
          << /T(".$field_path.".hospitalization_date_from_dd_fill[0]) /V(".escapeFdf(date('d', $hospitalization_date_from)).") >>
          << /T(".$field_path.".hospitalization_date_from_yy_fill[0]) /V(".escapeFdf(date('y', $hospitalization_date_from)).") >>
        ";
}
if(!empty($hospitalization_date_to)){
    $fdf .= "
          << /T(".$field_path.".hospitalization_date_to_mm_fill[0]) /V(".escapeFdf(date('m', $hospitalization_date_to)).") >>
          << /T(".$field_path.".hospitalization_date_to_dd_fill[0]) /V(".escapeFdf(date('d', $hospitalization_date_to)).") >>
          << /T(".$field_path.".hospitalization_date_to_yy_fill[0]) /V(".escapeFdf(date('y', $hospitalization_date_to)).") >>
        ";
}
$fdf .= "<< /T(".$field_path.".reserved_for_local_fill[0]) /V(".escapeFdf((!empty($reserved_local_use1) ? $reserved_local_use1 : '')).") >>
            << /T(".$field_path.".outside_lab_yes_chkbox[0]) /V(".escapeFdf(isOptionSelected($outside_lab) ? 1 : '').") >>
            << /T(".$field_path.".outside_lab_no_chkbox[0]) /V(".escapeFdf(!isOptionSelected($outside_lab) ? 1 : '').") >>
            << /T(".$field_path.".charges_fill[0]) /V(".escapeFdf((!empty($s_charges) ? $s_charges : '')).") >>
            << /T(".$field_path.".icd_ind[0]) /V(".escapeFdf((isset($icd_ind) && $icd_ind != 0 ? $icd_ind : '')).") >>
            << /T(".$field_path.".diagnosis_a[0]) /V(".escapeFdf((!empty($diagnosis_a) ? $diagnosis_a : '')).") >>
            << /T(".$field_path.".diagnosis_b[0]) /V(".escapeFdf((!empty($diagnosis_b) ? $diagnosis_b : '')).") >>
            << /T(".$field_path.".diagnosis_c[0]) /V(".escapeFdf((!empty($diagnosis_c) ? $diagnosis_c : '')).") >>
            << /T(".$field_path.".diagnosis_d[0]) /V(".escapeFdf((!empty($diagnosis_d) ? $diagnosis_d : '')).") >>
            << /T(".$field_path.".diagnosis_e[0]) /V(".escapeFdf((!empty($diagnosis_e) ? $diagnosis_e : '')).") >>
            << /T(".$field_path.".diagnosis_f[0]) /V(".escapeFdf((!empty($diagnosis_f) ? $diagnosis_f : '')).") >>
            << /T(".$field_path.".diagnosis_g[0]) /V(".escapeFdf((!empty($diagnosis_g) ? $diagnosis_g : '')).") >>
            << /T(".$field_path.".diagnosis_h[0]) /V(".escapeFdf((!empty($diagnosis_h) ? $diagnosis_h : '')).") >>
            << /T(".$field_path.".diagnosis_i[0]) /V(".escapeFdf((!empty($diagnosis_i) ? $diagnosis_i : '')).") >>
            << /T(".$field_path.".diagnosis_j[0]) /V(".escapeFdf((!empty($diagnosis_j) ? $diagnosis_j : '')).") >>
            << /T(".$field_path.".diagnosis_k[0]) /V(".escapeFdf((!empty($diagnosis_k) ? $diagnosis_k : '')).") >>
            << /T(".$field_path.".diagnosis_l[0]) /V(".escapeFdf((!empty($diagnosis_l) ? $diagnosis_l : '')).") >>
            << /T(".$field_path.".medicaid_resubmission_code_fill[0]) /V(".escapeFdf((!empty($resubmission_code_fill) && $resubmission_code_fill != 1 ? $resubmission_code_fill : '')).") >>
            << /T(".$field_path.".original_ref_no_fill[0]) /V(".escapeFdf((!empty($original_ref_no) ? $original_ref_no : '')).") >>
            << /T(".$field_path.".name_referring_provider_qualifier[0]) /V(".escapeFdf((!empty($name_referring_provider_qualifier) ? $name_referring_provider_qualifier : '')).") >>
            << /T(".$field_path.".prior_auth_number_fill[0]) /V(".escapeFdf((!empty($prior_authorization_number) ? $prior_authorization_number : '')).") >>";

$prefix = array( 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX');

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
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
    . "  ledger.primary_claim_id = '$claimId' "
    . "  AND ledger.patientid = '$patientId' "
    . "  AND ledger.docid = '$docId' "
    . "  AND trxn_code.docid = '$docId' "
    . "  AND trxn_code.type = '" . DSS_TRXN_TYPE_MED . "' "
    . "ORDER BY "
    . "  ledger.service_date ASC";

$query = $db->getResults($sql);
$c = 0;
$diagnosis_array = array('','A','B','C','D','E','F','H','I','J','K','L','M');
if ($query) foreach ($query as $array) {
    $p = $prefix[$c];
    $c++;

    $service_date = dateToTime($array['service_date']);

    if($array['service_date']!=''){
        $fdf .= "
              << /T(".$field_path.".".$p."_dates_of_service_from_mm_fill[0]) /V(".escapeFdf(date('m', $service_date)).") >>
              << /T(".$field_path.".".$p."_dates_of_service_from_dd_fill[0]) /V(".escapeFdf(date('d', $service_date)).") >>
              << /T(".$field_path.".".$p."_dates_of_service_from_yy_fill[0]) /V(".escapeFdf(date('y', $service_date)).") >>
            ";
    }
    if($array['service_date']){
        $fdf .= "
              << /T(".$field_path.".".$p."_dates_of_service_to_mm_fill[0]) /V(".escapeFdf(date('m', $service_date)).") >>
              << /T(".$field_path.".".$p."_dates_of_service_to_dd_fill[0]) /V(".escapeFdf(date('d', $service_date)).") >>
              << /T(".$field_path.".".$p."_dates_of_service_to_yy_fill[0]) /V(".escapeFdf(date('y', $service_date)).") >>
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
        << /T(".$field_path.".".$p."_diagnosis_pointer_fill[0]) /V(".escapeFdf($diagnosis_array[$array['diagnosispointer']]).") >> 
        << /T(".$field_path.".".$p."_charges_dollars_fill[0]) /V(".escapeFdf(number_format(floor($array['amount']),0,'.','')).") >>
        << /T(".$field_path.".".$p."_charges_cents_fill[0]) /V(".escapeFdf(fill_cents(roundToCents($array['amount']))).") >>
        << /T(".$field_path.".".$p."_days_or_units_fill[0]) /V(".escapeFdf($array['daysorunits']).") >>
        << /T(".$field_path.".".$p."_EPSDT_fill[0]) /V(".escapeFdf($array['epsdt']).") >>
        << /T(".$field_path.".".$p."_rendering_provider_fill[0]) /V(".escapeFdf($array['provider_id']).") >> ";
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
      << /T(".$field_path.".fed_tax_id_number_fill[0]) /V(".escapeFdf($federal_tax_id_number).") >>
      << /T(".$field_path.".fed_tax_id_SSN_chkbox[0]) /V(".escapeFdf(isOptionSelected($ssn == "1") ? 1 : '').") >>
      << /T(".$field_path.".fed_tax_id_EIN_chkbox[0]) /V(".escapeFdf(isOptionSelected($ein == "1") ? 1 : '').") >>
      << /T(".$field_path.".pt_account_number_fill[0]) /V(".escapeFdf((!empty($patient_account_no) ? $patient_account_no : '')).") >>
      << /T(".$field_path.".accept_assignment_yes_chkbox[0]) /V(".escapeFdf(isOptionSelected($accept_assignment) || $accept_assignment == "A" ? 1 : '').") >>
  << /T(".$field_path.".accept_assignment_no_chkbox[0]) /V(".escapeFdf(!isOptionSelected($accept_assignment) || $accept_assignment == "C" ? 1 : '').") >>
      
      << /T(".$field_path.".total_charge_dollars_fill[0]) /V(".escapeFdf(number_format(floor($total_charge),0,'.','')).") >>
      << /T(".$field_path.".total_charge_cents_fill[0]) /V(".escapeFdf(fill_cents(roundToCents($total_charge))).") >>
      << /T(".$field_path.".amount_paid_dollars_fill[0]) /V(".escapeFdf(number_format(floor($amount_paid),0,'.','')).") >>
      << /T(".$field_path.".amount_paid_cents_fill[0]) /V(".escapeFdf(fill_cents(roundToCents($amount_paid))).") >>
      << /T(".$field_path.".balance_due_dollars_fill[0]) /V(".escapeFdf(number_format(floor($balance_due),0,'.','')).") >>
      << /T(".$field_path.".balance_due_cents_fill[0]) /V(".escapeFdf(fill_cents(roundToCents($balance_due))).") >>

      << /T(".$field_path.".service_facility_location_info_fill[0]) /V(".escapeFdf(strtoupper((!empty($service_facility_info_name) ? $service_facility_info_name : ''))."\n".strtoupper((!empty($service_facility_info_address) ? $service_facility_info_address : ''))."\n".strtoupper((!empty($service_facility_info_city) ? $service_facility_info_city : ''))).") >>
      << /T(".$field_path.".billing_provider_phone_areacode_fill[0]) /V(".escapeFdf((!empty($billing_provider_phone_code) ? $billing_provider_phone_code : '')).") >>
      << /T(".$field_path.".billing_provider_phone_number_fill[0]) /V(".escapeFdf((!empty($billing_provider_phone) ? $billing_provider_phone : '')).") >>
      << /T(".$field_path.".billing_provider_info_fill[0]) /V(".escapeFdf(strtoupper((!empty($billing_provider_name) ? $billing_provider_name : ''))."\n".strtoupper((!empty($billing_provider_address) ? $billing_provider_address : ''))."\n".strtoupper((!empty($billing_provider_city) ? $billing_provider_city : ''))).") >>
      << /T(".$field_path.".signature_of_physician-supplier_signed_fill[0]) /V(".escapeFdf((!empty($signature_physician) ? $signature_physician : '')).") >>  
      << /T(".$field_path.".signature_of_physician-supplier_date_fill[0]) /V(".escapeFdf($physician_signed_date).") >>
      << /T(".$field_path.".service_facility_NPI_a_fill[0]) /V(".escapeFdf((!empty($service_info_a) ? $service_info_a : '')).") >>
      << /T(".$field_path.".billing_provider_a[0]) /V(".escapeFdf((!empty($billing_provider_a) ? $billing_provider_a : '')).") >>
      << /T(".$field_path.".service_facility_other_id_b_fill[0]) /V(".escapeFdf((!empty($service_info) ? $service_info : ''))."".escapeFdf((!empty($service_info_b_other) ? $service_info_b_other : '')).") >>
      << /T(".$field_path.".billing_provider_NPI_a_fill[0]) /V(".escapeFdf(((!empty($billing_provider_a) ? $billing_provider_a : ''))).") >>
      << /T(".$field_path.".billing_provider_other_id_b_fill[0]) /V(".escapeFdf((!empty($billing_info) ? $billing_info : ''))."".escapeFdf((!empty($billing_provider_b_other) ? $billing_provider_b_other : '')).") >>
    ";

$fdf .= "
  << /T(".$field_path.".fed_tax_id_number_fill[0]) /V(".escapeFdf($federal_tax_id_number).") >>
  << /T(".$field_path.".fed_tax_id_SSN_chkbox[0]) /V(".escapeFdf((($ssn == "1")?1:'')).") >>
  << /T(".$field_path.".fed_tax_id_EIN_chkbox[0]) /V(".escapeFdf((($ein == "1")?1:'')).") >>
  << /T(".$field_path.".pt_account_number_fill[0]) /V(".escapeFdf($patient_account_no).") >>
  << /T(".$field_path.".accept_assignment_yes_chkbox[0]) /V(".escapeFdf(isOptionSelected($accept_assignment) || $accept_assignment == "A" ? 1 : '').") >>
  << /T(".$field_path.".accept_assignment_no_chkbox[0]) /V(".escapeFdf(!isOptionSelected($accept_assignment) || $accept_assignment == "C" ? 1 : '').") >>
  
  << /T(".$field_path.".total_charge_dollars_fill[0]) /V(".escapeFdf(number_format(floor($total_charge),0,'.','')).") >>
  << /T(".$field_path.".total_charge_cents_fill[0]) /V(".escapeFdf(fill_cents(roundToCents($total_charge))).") >>
  << /T(".$field_path.".amount_paid_dollars_fill[0]) /V(".escapeFdf(number_format(floor($amount_paid),0,'.','')).") >>
  << /T(".$field_path.".amount_paid_cents_fill[0]) /V(".escapeFdf(fill_cents(roundToCents($amount_paid))).") >>
  << /T(".$field_path.".balance_due_dollars_fill[0]) /V(".escapeFdf(number_format(floor($balance_due),0,'.','')).") >>
  << /T(".$field_path.".balance_due_cents_fill[0]) /V(".escapeFdf(fill_cents(roundToCents($balance_due))).") >>
  
  << /T(".$field_path.".service_facility_location_info_fill[0]) /V(".escapeFdf(strtoupper($service_facility_info_name)."\n".strtoupper($service_facility_info_address)."\n".strtoupper($service_facility_info_city)).") >>
  << /T(".$field_path.".billing_provider_phone_areacode_fill[0]) /V(".escapeFdf($billing_provider_phone_code).") >>
  << /T(".$field_path.".billing_provider_phone_number_fill[0]) /V(".escapeFdf($billing_provider_phone).") >>
  << /T(".$field_path.".billing_provider_info_fill[0]) /V(".escapeFdf(strtoupper($billing_provider_name)."\n".strtoupper($billing_provider_address)."\n".strtoupper($billing_provider_city)).") >>
  << /T(".$field_path.".signature_of_physician-supplier_signed_fill[0]) /V(".escapeFdf($signature_physician).") >>  
  << /T(".$field_path.".signature_of_physician-supplier_date_fill[0]) /V(".escapeFdf($physician_signed_date).") >>
  << /T(".$field_path.".service_facility_NPI_a_fill[0]) /V(".escapeFdf($service_info_a).") >>
  << /T(".$field_path.".billing_provider_a[0]) /V(".escapeFdf($billing_provider_a).") >>
  << /T(".$field_path.".billing_provider_NPI_a_fill[0]) /V(".escapeFdf(((!empty($billing_provider_a) ? $billing_provider_a : ''))).") >>
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

$date = date('YmdHms');
$file = "fdf_{$claimId}_{$patientId}_{$date}.fdf";
$fdf_field = $isSecondary ? 'secondary_fdf' : 'primary_fdf';

// This invoice add, should be added to the patient's docid? or the current logged-in user?
invoice_add_claim('1', $docId, $claimId);

$db->query("UPDATE dental_insurance SET $fdf_field = '$file'
    WHERE insuranceid = '$claimId'");

outputPdf($file, $fdf);
