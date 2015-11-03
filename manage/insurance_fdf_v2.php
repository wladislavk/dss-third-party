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
$patient_address = strtoupper($claimData['patient_address']);
$patient_city = strtoupper($claimData['patient_city']);
$patient_state = strtoupper($claimData['patient_state']);
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

$qualifiers = $db->getResults("SELECT * FROM dental_qualifier WHERE status = 1 ORDER BY sortby");
$qualifierCodes = [];

foreach ($qualifiers as $each) {
    $qualifierCodes[$each['qualifierid']] = substr($each['qualifier'], 0, 2);
}

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

$fdfData = [];

$fdfData['carrier_name_fill'] = strtoupper($insuranceCompanyData['company']);
$fdfData['carrier_address1_fill'] = strtoupper($insuranceCompanyData['add1']);
$fdfData['carrier_address2_fill'] = strtoupper($insuranceCompanyData['add2']);
$fdfData['carrier_citystatezip_fill'] =
    $insuranceCompanyData['city'] . " " . $insuranceCompanyData['state'] . ", " . $insuranceCompanyData['zip'];
$fdfData['pica_right_side_fill'] =
    (!empty($pica1) ? $pica1 : '').(!empty($pica2) ? $pica2 : '').(!empty($pica3) ? $pica3 : '');

$fdfData['medicare_chkbox'] = $insurancetype == '1' ? 1 : '';
$fdfData['medicaid_chkbox'] = $insurancetype == '2' ? 1 : '';
$fdfData['tricare_chkbox'] = $insurancetype == '3' ? 1 : '';
$fdfData['champva_chkbox'] = $insurancetype == '4' ? 1 : '';
$fdfData['grouphealth_chkbox'] = $insurancetype == '5' ? 1 : '';
$fdfData['feca_chkbox'] = $insurancetype == '6' ? 1 : '';
$fdfData['otherins_chkbox'] = $insurancetype == '7' ? 1 : '';

$fdfData['box8_nucc'] = !empty($nucc_8a) ? $nucc_8a : '';
$fdfData['box9b_nucc'] = !empty($nucc_9b) ? $nucc_9b : '';
$fdfData['insured_id_number_fill'] = $insured_id_number;
$fdfData['insured_id_number_fill'] = $insured_id_number;
$fdfData['insured_id_number_fill'] = $insured_id_number;

$fdfData['insured_id_number_fill'] = $insured_id_number;
$fdfData['pt_name_fill'] = $patient_lastname . ", " . $patient_firstname .
    (trim($patient_middle) != '' ? ", " . $patient_middle : '');

if ($patient_dob != '') {
    $fdfData['pt_birth_date_mm_fill'] = date('m', $patient_dob);
    $fdfData['pt_birth_date_dd_fill'] = date('d', $patient_dob);
    $fdfData['pt_birth_date_yy_fill'] = date('Y', $patient_dob);
}

$fdfData['pt_sex_m_chkbox'] = $patient_sex == 'M' || $patient_sex == 'Male' ? 1 : '';
$fdfData['pt_sex_f_chkbox'] = $patient_sex == 'F' || $patient_sex == 'Female' ? 1 : '';
$fdfData['insured_name_ln_fn_mi_fill'] = $insured_lastname . ", " . $insured_firstname .
    (trim($insured_middle) != '' ? ", " . $insured_middle : '');

$fdfData['pt_relation_self_chkbox'] = strtoupper($patient_relation_insured) == 'SELF' ? 1 : '';
$fdfData['pt_relation_spouse_chkbox'] =
    strtoupper($patient_relation_insured) == 'SPOUSE' || $patient_relation_insured == '01' ? 1 : '';
$fdfData['pt_relation_child_chkbox'] =
    strtoupper($patient_relation_insured) == 'CHILD'|| $patient_relation_insured == '19' ? 1 : '';
$fdfData['pt_relation_other_chkbox'] =
    strtoupper($patient_relation_insured) == 'OTHER' || $patient_relation_insured == 'G8' ? 1 : '';

$fdfData['insured_address_fill'] = $insured_address;
$fdfData['pt_address_fill'] = $patient_address;
$fdfData['pt_city_fill'] = $patient_city;
$fdfData['pt_state_fill'] = $patient_state;

$fdfData['pt_status_single_chkbox'] =
    isset($patient_status_array) && in_array('Single', $patient_status_array) ? 1 : '';
$fdfData['pt_status_married_chkbox'] =
    isset($patient_status_array) && in_array('Married', $patient_status_array) ? 1 : '';
$fdfData['pt_status_other_chkbox'] =
    isset($patient_status_array) && in_array('Others', $patient_status_array) ? 1 : '';

$fdfData['insured_city_fill'] = $insured_city;
$fdfData['insured_state_fill'] = $insured_state;
$fdfData['pt_zipcode_fill'] = $insured_zip;
$fdfData['pt_phone_areacode_fill'] = $patient_phone_code;
$fdfData['pt_phone_number_fill'] = $patient_phone;

$fdfData['pt_status_employed_chkbox'] =
    isset($patient_status_array) && in_array('Employed', $patient_status_array) ? 1 : '';
$fdfData['pt_status_ftstudent_chkbox'] =
    isset($patient_status_array) && in_array("Full Time Student", $patient_status_array) ? 1 : '';
$fdfData['pt_status_ptstudent_chkbox'] =
    isset($patient_status_array) && in_array("Part Time Student", $patient_status_array) ? 1 : '';

$fdfData['insured_zipcode_fill'] = $insured_zip;
$fdfData['insured_phone_areacode_fill'] = $insured_phone_code;
$fdfData['insured_phone_number_fill'] = $insured_phone;
$fdfData['other_insured_name_fill'] =
    $other_insured_lastname . ", " . $other_insured_firstname .
    (trim($other_insured_middle) != '' ? ", " . $other_insured_middle : '');
$fdfData['insured_policy_group_fill'] = $insured_policy_group_feca;
$fdfData['other_insured_policy_fill'] = $other_insured_policy_group_feca;

$fdfData['pt_condition_employment_yes_chkbox'] = isOptionSelected($employment) ? 1 : '';
$fdfData['pt_condition_employment_no_chkbox'] = !isoptionselected($employment) ? 1 : '';
$fdfData['pt_condition_auto_yes_chkbox'] = isOptionSelected($auto_accident) ? 1 : '';
$fdfData['pt_condition_auto_no_chkbox'] = !isOptionSelected($auto_accident) ? 1 : '';
$fdfData['pt_condition_place_fill'] = !empty($auto_accident_place) ? $auto_accident_place : '';
$fdfData['pt_condition_otheracc_yes_chkbox'] = isOptionSelected($other_accident) ? 1 : '';
$fdfData['pt_condition_otheracc_no_chkbox'] = !isOptionSelected($other_accident) ? 1 : '';

if (!empty($insured_dob)) {
    $fdfData['insured_dob_mm_fill'] = date('m', $insured_dob);
    $fdfData['insured_dob_dd_fill'] = date('d', $insured_dob);
    $fdfData['insured_dob_yy_fill'] = date('Y', $insured_dob);
}

$fdfData['current_qual'] = !empty($current_qual) ? $current_qual : '';
$fdfData['same_illness_qual'] = !empty($same_illness_qual) ? $same_illness_qual : '';

$fdfData['insured_sex_m_chkbox'] = $insured_sex == 'M' || $insured_sex == 'Male' ? 1 : '';
$fdfData['insured_sex_f_chkbox'] = $insured_sex == 'F' || $insured_sex == 'Female' ? 1 : '';

if ($other_insured_dob != '') {
    $fdfData['other_insured_dob_mm_fill'] = date('m', $other_insured_dob);
    $fdfData['other_insured_dob_dd_fill'] = date('d', $other_insured_dob);
    $fdfData['other_insured_dob_yy_fill'] = date('Y', $other_insured_dob);
}

$fdfData['other_insured_sex_m_chkbox'] =
    !empty($other_insured_sex) && ($other_insured_sex == 'M' || $other_insured_sex == 'Male') ? 1 : '';
$fdfData['other_insured_sex_f_chkbox'] =
    !empty($other_insured_sex) && ($other_insured_sex == 'F' || $other_insured_sex == 'Female') ? 1 : '';
$fdfData['insured_employers_name_fill'] = $insured_employer_school_name;
$fdfData['employers_name_fill'] =
    !empty($other_insured_employer_school_name) ? $other_insured_employer_school_name : '';

$fdfData['insured_ins_plan_name_fill'] = $insured_insurance_plan;
$fdfData['box11b_nucc'] = $other_claim_id;
$fdfData['box9c_nucc'] = $nucc_9c;
$fdfData['ins_plan_name_fill'] = $other_insured_insurance_plan;
$fdfData['reserved_local_use_fill'] = !empty($claim_codes) ? $claim_codes : '';

$fdfData['another_health_benefit_yes_chkbox'] = isOptionSelected($another_plan) ? 1 : '';
$fdfData['another_health_benefit_no_chkbox'] = !isOptionSelected($another_plan) ? 1 : '';
$fdfData['pt_signature_fill'] = isOptionSelected($patient_signature) ? 'SIGNATURE ON FILE' : '';

if (!empty($patient_signature)) {
    $fdfData['pt_signature_date_fill'] = $patient_signed_date;
}

$fdfData['insured_signature_fill'] = isOptionSelected($insured_signature) ? 'SIGNATURE ON FILE' : '';

if (!empty($date_current)) {
    $fdfData['date_of_current_mm_fill'] = date('m', $date_current);
    $fdfData['date_of_current_dd_fill'] = date('d', $date_current);
    $fdfData['date_of_current_yy_fill'] = date('y', $date_current);
}

if (!empty($date_same_illness)) {
    $fdfData['pt_similar_illness_mm_fill'] = date('m', $date_same_illness);
    $fdfData['pt_similar_illness_dd_fill'] = date('d', $date_same_illness);
    $fdfData['pt_similar_illness_yy_fill'] = date('y', $date_same_illness);
}

if (!empty($unable_date_from)) {
    $fdfData['date_pt_unable_work_from_mm_fill'] = date('m', $unable_date_from);
    $fdfData['date_pt_unable_work_from_dd_fill'] = date('d', $unable_date_from);
    $fdfData['date_pt_unable_work_from_yy_fill'] = date('y', $unable_date_from);
}

if (!empty($unable_date_to)) {
    $fdfData['date_pt_unable_work_to_mm_fill'] = date('m', $unable_date_to);
    $fdfData['date_pt_unable_work_to_dd_fill'] = date('d', $unable_date_to);
    $fdfData['date_pt_unable_work_to_yy_fill'] = date('y', $unable_date_to);
}

$fdfData['name_referring_provider_fill'] = !empty($referring_provider) ? $referring_provider : '';
$fdfData['seventeenA_fill'] = isset($secondaryIdTypes[$field_17a]) ? $secondaryIdTypes[$field_17a] : '';
$fdfData['seventeenb_NPI_fill'] = !empty($field_17b) ? $field_17b : '';

if (!empty($hospitalization_date_from)) {
    $fdfData['hospitalization_date_from_mm_fill'] = date('m', $hospitalization_date_from);
    $fdfData['hospitalization_date_from_dd_fill'] = date('d', $hospitalization_date_from);
    $fdfData['hospitalization_date_from_yy_fill'] = date('y', $hospitalization_date_from);
}

if (!empty($hospitalization_date_to)) {
    $fdfData['hospitalization_date_to_mm_fill'] = date('m', $hospitalization_date_to);
    $fdfData['hospitalization_date_to_dd_fill'] = date('d', $hospitalization_date_to);
    $fdfData['hospitalization_date_to_yy_fill'] = date('y', $hospitalization_date_to);
}

$fdfData['reserved_for_local_fill'] = !empty($reserved_local_use1) ? $reserved_local_use1 : '';
$fdfData['outside_lab_yes_chkbox'] = isOptionSelected($outside_lab) ? 1 : '';
$fdfData['outside_lab_no_chkbox'] = !isOptionSelected($outside_lab) ? 1 : '';
$fdfData['charges_fill'] = !empty($s_charges) ? $s_charges : '';
$fdfData['icd_ind'] = isset($icd_ind) && $icd_ind == 9 ? $icd_ind : '0'; // Only two options
$fdfData['diagnosis_a'] = !empty($diagnosis_a) ? $diagnosis_a : '';
$fdfData['diagnosis_b'] = !empty($diagnosis_b) ? $diagnosis_b : '';
$fdfData['diagnosis_c'] = !empty($diagnosis_c) ? $diagnosis_c : '';
$fdfData['diagnosis_d'] = !empty($diagnosis_d) ? $diagnosis_d : '';
$fdfData['diagnosis_e'] = !empty($diagnosis_e) ? $diagnosis_e : '';
$fdfData['diagnosis_f'] = !empty($diagnosis_f) ? $diagnosis_f : '';
$fdfData['diagnosis_g'] = !empty($diagnosis_g) ? $diagnosis_g : '';
$fdfData['diagnosis_h'] = !empty($diagnosis_h) ? $diagnosis_h : '';
$fdfData['diagnosis_i'] = !empty($diagnosis_i) ? $diagnosis_i : '';
$fdfData['diagnosis_j'] = !empty($diagnosis_j) ? $diagnosis_j : '';
$fdfData['diagnosis_k'] = !empty($diagnosis_k) ? $diagnosis_k : '';
$fdfData['diagnosis_l'] = !empty($diagnosis_l) ? $diagnosis_l : '';

$fdfData['medicaid_resubmission_code_fill'] =
    !empty($resubmission_code_fill) && $resubmission_code_fill != 1 ? $resubmission_code_fill : '';
$fdfData['original_ref_no_fill'] = !empty($original_ref_no) ? $original_ref_no : '';
$fdfData['name_referring_provider_qualifier'] =
    !empty($name_referring_provider_qualifier) ? $name_referring_provider_qualifier : '';
$fdfData['prior_auth_number_fill'] =
    !empty($prior_authorization_number) ? $prior_authorization_number : '';

$prefix = array( 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX');

// Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$transactionType = DSS_TRXN_TYPE_MED;
$npiColumn = $insurancetype == '1' ? 'medicare_npi' : 'npi';

$sql = "SELECT
        ledger.*,
        user.$npiColumn AS 'provider_id',
        ps.place_service AS 'place'
    FROM dental_ledger ledger
        JOIN dental_users user ON user.userid = ledger.docid
        JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code
        LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid
    WHERE ledger.primary_claim_id = '$claimId'
        AND ledger.patientid = '$patientId'
        AND ledger.docid = '$docId'
        AND trxn_code.docid = '$docId'
        AND trxn_code.type = '$transactionType'
    ORDER BY ledger.service_date ASC, ledger.amount DESC, ledger.ledgerid DESC";

$query = $db->getResults($sql);
$diagnosis_array = array('','A','B','C','D','E','F','H','I','J','K','L','M');

foreach ($query as $c=>$array) {
    $p = $prefix[$c];
    $service_date = dateToTime($array['service_date']);

    if ($array['service_date']) {
        $fdfData["{$p}_dates_of_service_from_mm_fill"] = date('m', $service_date);
        $fdfData["{$p}_dates_of_service_from_dd_fill"] = date('d', $service_date);
        $fdfData["{$p}_dates_of_service_from_yy_fill"] = date('y', $service_date);

        $fdfData["{$p}_dates_of_service_to_mm_fill"] = date('m', $service_date);
        $fdfData["{$p}_dates_of_service_to_dd_fill"] = date('d', $service_date);
        $fdfData["{$p}_dates_of_service_to_yy_fill"] = date('y', $service_date);
    }

    $fdfData["{$p}_place_of_service_fill"] = $array['placeofservice'];
    $fdfData["{$p}_EMG_fill"] = isOptionSelected($array['emg']) ? 'y' : '';
    $fdfData["{$p}_CPT_fill"] = $array['transaction_code'];
    $fdfData["{$p}_modifier_one_fill"] = $array['modcode'];
    $fdfData["{$p}_modifier_two_fill"] = $array['modcode2'];
    $fdfData["{$p}_modifier_three_fill"] = $array['modcode3'];
    $fdfData["{$p}_modifier_four_fill"] = $array['modcode4'];
    $fdfData["{$p}_diagnosis_pointer_fill"] = $diagnosis_array[$array['diagnosispointer']];
    $fdfData["{$p}_charges_dollars_fill"] = number_format(floor($array['amount']),0,'.','');
    $fdfData["{$p}_charges_cents_fill"] = fill_cents(roundToCents($array['amount']));
    $fdfData["{$p}_days_or_units_fill"] = $array['daysorunits'];
    $fdfData["{$p}_EPSDT_fill"] = $array['epsdt'];
    $fdfData["{$p}_rendering_provider_fill"] = $array['provider_id'];
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

$fdfData['fed_tax_id_number_fill'] = $federal_tax_id_number;
$fdfData['fed_tax_id_SSN_chkbox'] = isOptionSelected($ssn == '1') ? 1 : '';
$fdfData['fed_tax_id_EIN_chkbox'] = isOptionSelected($ein == '1') ? 1 : '';
$fdfData['pt_account_number_fill'] = !empty($patient_account_no) ? $patient_account_no : '';
$fdfData['accept_assignment_yes_chkbox'] =
    isOptionSelected($accept_assignment) || $accept_assignment == 'A' ? 1 : '';
$fdfData['accept_assignment_no_chkbox'] =
    !isOptionSelected($accept_assignment) || $accept_assignment == 'C' ? 1 : '';

$fdfData['total_charge_dollars_fill'] = number_format(floor($total_charge),0,'.','');
$fdfData['total_charge_cents_fill'] = fill_cents(roundToCents($total_charge));
$fdfData['amount_paid_dollars_fill'] = number_format(floor($amount_paid),0,'.','');
$fdfData['amount_paid_cents_fill'] = fill_cents(roundToCents($amount_paid));
$fdfData['balance_due_dollars_fill'] = number_format(floor($balance_due),0,'.','');
$fdfData['balance_due_cents_fill'] = fill_cents(roundToCents($balance_due));

$fdfData['service_facility_location_info_fill'] =
    (!empty($service_facility_info_name) ? $service_facility_info_name : '') . "\n" .
    (!empty($service_facility_info_address) ? $service_facility_info_address : '') . "\n" .
    (!empty($service_facility_info_city) ? $service_facility_info_city : '');

$fdfData['billing_provider_phone_areacode_fill'] =
    !empty($billing_provider_phone_code) ? $billing_provider_phone_code : '';
$fdfData['billing_provider_phone_number_fill'] =
    !empty($billing_provider_phone) ? $billing_provider_phone : '';
$fdfData['billing_provider_info_fill'] =
    (!empty($billing_provider_name) ? $billing_provider_name : '') . "\n" .
    (!empty($billing_provider_address) ? $billing_provider_address : '') . "\n" .
    (!empty($billing_provider_city) ? $billing_provider_city : '');
$fdfData['signature_of_physician-supplier_signed_fill'] = !empty($signature_physician) ? $signature_physician : '';
$fdfData['signature_of_physician-supplier_date_fill'] = $physician_signed_date;
$fdfData['service_facility_NPI_a_fill'] = !empty($service_info_a) ? $service_info_a : '';
$fdfData['billing_provider_a'] = !empty($billing_provider_a) ? $billing_provider_a : '';
$fdfData['service_facility_other_id_b_fill'] =
    array_get($qualifierCodes, $service_info_dd) . $service_info_b_other;
$fdfData['billing_provider_NPI_a_fill'] = !empty($billing_provider_a) ? $billing_provider_a : '';
$fdfData['billing_provider_other_id_b_fill'] =
    array_get($qualifierCodes, $billing_provider_dd) . $billing_provider_b_other;

$fdfData['fed_tax_id_number_fill'] = $federal_tax_id_number;
$fdfData['fed_tax_id_SSN_chkbox'] = $ssn == 1 ? 1 : '';
$fdfData['fed_tax_id_EIN_chkbox'] = $ein == 1 ? 1 : '';
$fdfData['pt_account_number_fill'] = $patient_account_no;
$fdfData['accept_assignment_yes_chkbox'] =
    isOptionSelected($accept_assignment) || $accept_assignment == 'A' ? 1 : '';
$fdfData['accept_assignment_no_chkbox'] =
    !isOptionSelected($accept_assignment) || $accept_assignment == 'C' ? 1 : '';

$fdfData['total_charge_dollars_fill'] = number_format(floor($total_charge),0,'.','');
$fdfData['total_charge_cents_fill'] = fill_cents(roundToCents($total_charge));
$fdfData['amount_paid_dollars_fill'] = number_format(floor($amount_paid),0,'.','');
$fdfData['amount_paid_cents_fill'] = fill_cents(roundToCents($amount_paid));
$fdfData['balance_due_dollars_fill'] = number_format(floor($balance_due),0,'.','');
$fdfData['balance_due_cents_fill'] = fill_cents(roundToCents($balance_due));

$fdfData['service_facility_location_info_fill'] =
    $service_facility_info_name . "\n" .
    $service_facility_info_address . "\n" .
    $service_facility_info_city;

$fdfData['billing_provider_phone_areacode_fill'] = $billing_provider_phone_code;
$fdfData['billing_provider_phone_number_fill'] = $billing_provider_phone;

$fdfData['billing_provider_info_fill'] =
    $billing_provider_name . "\n" .
    $billing_provider_address . "\n" .
    $billing_provider_city;

$fdfData['signature_of_physician-supplier_signed_fill'] = $signature_physician;
$fdfData['signature_of_physician-supplier_date_fill'] = $physician_signed_date;
$fdfData['service_facility_NPI_a_fill'] = $service_info_a;
$fdfData['billing_provider_a'] = $billing_provider_a;
$fdfData['billing_provider_NPI_a_fill'] = !empty($billing_provider_a) ? $billing_provider_a : '';

$date = date('YmdHms');
$file = "fdf_{$claimId}_{$patientId}_{$date}.fdf";
$fdf_field = $isSecondary ? 'secondary_fdf' : 'primary_fdf';

// This invoice add, should be added to the patient's docid? or the current logged-in user?
invoice_add_claim('1', $docId, $claimId);

$db->query("UPDATE dental_insurance SET $fdf_field = '$file'
    WHERE insuranceid = '$claimId'");

outputPdf($file, $fdfData);
