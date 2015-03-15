<?php namespace Ds3\Legacy; ?><?php

function create_claim($pid, $prod)
{
    $db = new Db();
    $con = $GLOBALS['con'];

    $pat_sql = "select * from dental_patients where patientid='".s_for($pid)."'";
    $pat_myarray = $db->getRow($pat_sql);

    $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
    $insurancetype = st($pat_myarray['p_m_ins_type']);
    $insured_firstname = st($pat_myarray['p_m_partyfname']);
    $insured_lastname = st($pat_myarray['p_m_partymname']);
    $insured_middle = st($pat_myarray['p_m_partylname']);
    $other_insured_firstname = st($pat_myarray['s_m_partyfname']);
    $other_insured_lastname = st($pat_myarray['s_m_partymname']);
    $other_insured_middle = st($pat_myarray['s_m_partylname']);
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
    $insured_sex = $pat_myarray['gender'];
    $patient_firstname = $pat_myarray['firstname'];
    $patient_lastname = $pat_myarray['lastname'];
    $patient_middle = $pat_myarray['middlename'];
    $patient_address = $pat_myarray['add1'];
    $patient_city = $pat_myarray['city'];
    $patient_state = $pat_myarray['state'];
    $patient_zip = $pat_myarray['zip'];
    $patient_dob = $pat_myarray['dob'];

    if ($pat_myarray['p_m_ins_ass'] == 'Yes') {
      $insured_signature = 1;
    }

    $patient_signature = 1;
    $signature_physician = "Signature on File";
    $patient_signed_date = date('m/d/Y', strtotime($pat_myarray['adddate']));
    $physician_signed_date = date('m/d/Y');
    $patient_phone_code = format_phone($pat_myarray['home_phone'], true);
    $patient_phone = format_phone($pat_myarray['home_phone'], false);
    $insured_phone_code = format_phone($pat_myarray['home_phone'], true);
    $insured_phone = format_phone($pat_myarray['home_phone'], false);
    $patient_status = $pat_myarray['marital_status'];
    $insured_id_number = $pat_myarray['p_m_ins_id'];
    $insured_firstname = $pat_myarray['p_d_party'];
    $insured_address = $pat_myarray['add1'];
    $insured_city = $pat_myarray['city'];
    $insured_state = $pat_myarray['state'];
    $insured_zip = $pat_myarray['zip'];
    $insured_dob = $pat_myarray['ins_dob'];
    $patient_relation_insured = $pat_myarray['p_m_relation'];
    $insured_employer_school_name = $pat_myarray['employer'];
    $insured_policy_group_feca = $pat_myarray['group_number'];
    $insured_insurance_plan = $pat_myarray['plan_name'];
    $p_m_eligible_payer_id = $pat_myarray['p_m_eligible_payer_id'];
    $p_m_eligible_payer_name = $pat_myarray['p_m_eligible_payer_name'];
    $sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                    JOIN dental_patients p on ss.patiendid=p.patientid                        
                    WHERE 
                    (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                    (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                    ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

    $d = $db->getRow($sleepstudies);
    $diagnosis_1 = $d['diagnosis'];

    $sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                    JOIN dental_patients p on ss.patiendid=p.patientid                        
                    WHERE                                 
                    (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                    (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                    ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$pid."';";

    $d = $db->getRow($sleepstudies);

    $diagnosising_doc = $d['diagnosising_doc'];
    $diagnosising_npi = $d['diagnosising_npi'];
    $accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);

    if (!empty($dent_rows) && $dent_rows <= 0) {
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
             . "  patient_id = '" . (!empty($_GET['pid']) ? $_GET['pid'] : '') . "' "
             . "  AND status = " . DSS_PREAUTH_COMPLETE . " "
             . "ORDER BY "
             . "  date_completed desc "
             . "LIMIT 1";

        $num_rows = $db->getNumberRows($sql);

        if ($num_rows > 0) {
            $myarray = $db->getRow($sql);
            $prior_authorization_number = $myarray['pre_auth_num'];
        }
    }

    $ins_sql = " insert into dental_insurance set 
    patientid = '".s_for($pid)."',
    pica1 = '".s_for((!empty($pica1) ? $pica1 : ''))."',
    pica2 = '".s_for((!empty($pica2) ? $pica2 : ''))."',
    pica3 = '".s_for((!empty($pica3) ? $pica3 : ''))."',
    insurance_type = '".s_for($insurancetype)."',
    insured_id_number = '".s_for($insured_id_number)."',
    patient_lastname = '".s_for($patient_lastname)."',
    patient_firstname = '".s_for($patient_firstname)."',
    patient_middle = '".s_for($patient_middle)."',
    patient_dob = '".s_for($patient_dob)."',
    patient_sex = '".s_for((!empty($patient_sex) ? $patient_sex : ''))."',
    insured_firstname = '".s_for($insured_firstname)."',
    insured_lastname = '".s_for($insured_lastname)."',
    insured_middle = '".s_for($insured_middle)."',
    patient_address = '".s_for($patient_address)."',
    patient_relation_insured = '".s_for($patient_relation_insured)."',
    insured_address = '".s_for($insured_address)."',
    patient_city = '".s_for($patient_city)."',
    patient_state = '".s_for($patient_state)."',
    patient_status = '".s_for((!empty($patient_status_arr) ? $patient_status_arr : ''))."',
    insured_city = '".s_for($insured_city)."',
    insured_state = '".s_for($insured_state)."',
    patient_zip = '".s_for($patient_zip)."',
    patient_phone_code = '".s_for($patient_phone_code)."',
    patient_phone = '".s_for($patient_phone)."',
    insured_zip = '".s_for($insured_zip)."',
    insured_phone_code = '".s_for($insured_phone_code)."',
    insured_phone = '".s_for($insured_phone)."',
    other_insured_firstname = '".s_for($other_insured_firstname)."',
    other_insured_lastname = '".s_for($other_insured_lastname)."',
    other_insured_middle = '".s_for($other_insured_middle)."',
    employment = '".s_for((!empty($employment) ? $employment : ''))."',
    auto_accident = '".s_for((!empty($auto_accident) ? $auto_accident : ''))."',
    auto_accident_place = '".s_for((!empty($auto_accident_place) ? $auto_accident_place : ''))."',
    other_accident = '".s_for((!empty($other_accident) ? $other_accident : ''))."',
    insured_policy_group_feca = '".s_for($insured_policy_group_feca)."',
    other_insured_policy_group_feca = '".s_for($other_insured_policy_group_feca)."',
    insured_dob = '".s_for($insured_dob)."',
    insured_sex = '".s_for($insured_sex)."',
    other_insured_dob = '".s_for($other_insured_dob)."',
    other_insured_sex = '".s_for((!empty($other_insured_sex) ? $other_insured_sex : ''))."',
    insured_employer_school_name = '".s_for($insured_employer_school_name)."',
    other_insured_employer_school_name = '".s_for((!empty($other_insured_employer_school_name) ? $other_insured_employer_school_name : ''))."',
    insured_insurance_plan = '".s_for($insured_insurance_plan)."',
    other_insured_insurance_plan = '".s_for($other_insured_insurance_plan)."',
    reserved_local_use = '".s_for((!empty($reserved_local_use) ? $reserved_local_use : ''))."',
    another_plan = '".s_for((!empty($another_plan) ? $another_plan : ''))."',
    patient_signature = '".$patient_signature."',
    patient_signed_date = '".s_for($patient_signed_date)."',
    insured_signature = '".s_for($insured_signature)."',
    date_current = '".s_for((!empty($date_current) ? $date_current : ''))."',
    date_same_illness = '".s_for((!empty($date_same_illness) ? $date_same_illness : ''))."',
    unable_date_from = '".s_for((!empty($unable_date_from) ? $unable_date_from : ''))."',
    unable_date_to = '".s_for((!empty($unable_date_to) ? $unable_date_to : ''))."',
    referring_provider = '".s_for((!empty($referring_provider) ? $referring_provider : ''))."',
    field_17a_dd = '".s_for(!empty($field_17a_dd) ? $field_17a_dd : '')."',
    field_17a = '".s_for(!empty($field_17a) ? $field_17a : '')."',
    field_17b = '".s_for(!empty($field_17b) ? $field_17b : '')."',
    hospitalization_date_from = '".s_for(!empty($hospitalization_date_from) ? $hospitalization_date_from : '')."',
    hospitalization_date_to = '".s_for(!empty($hospitalization_date_to) ? $hospitalization_date_to : '')."',
    reserved_local_use1 = '".s_for(!empty($reserved_local_use1) ? $reserved_local_use1 : '')."',
    outside_lab = '".s_for(!empty($outside_lab) ? $outside_lab : '')."',
    s_charges = '".s_for(!empty($s_charges) ? $s_charges : '')."',
    diagnosis_1 = '".s_for($diagnosis_1)."',
    diagnosis_2 = '".s_for(!empty($diagnosis_2) ? $diagnosis_2 : '')."',
    diagnosis_3 = '".s_for(!empty($diagnosis_3) ? $diagnosis_3 : '')."',
    diagnosis_4 = '".s_for(!empty($diagnosis_4) ? $diagnosis_4 : '')."',
    medicaid_resubmission_code = '".s_for(!empty($medicaid_resubmission_code) ? $medicaid_resubmission_code : '')."',
    original_ref_no = '".s_for(!empty($original_ref_no) ? $original_ref_no : '')."',
    prior_authorization_number = '".s_for(!empty($prior_authorization_number) ? $prior_authorization_number : '')."',
    service_date1_from = '".s_for(!empty($service_date1_from) ? $service_date1_from : '')."',
    service_date1_to = '".s_for(!empty($service_date1_to) ? $service_date1_to : '')."',
    place_of_service1 = '".s_for(!empty($place_of_service1) ? $place_of_service1 : '')."',
    emg1 = '".s_for(!empty($emg1) ? $emg1 : '')."',
    cpt_hcpcs1 = '".s_for(!empty($cpt_hcpcs1) ? $cpt_hcpcs1 : '')."',
    modifier1_1 = '".s_for(!empty($modifier1_1) ? $modifier1_1 : '')."',
    modifier1_2 = '".s_for(!empty($modifier1_2) ? $modifier1_2 : '')."',
    modifier1_3 = '".s_for(!empty($modifier1_3) ? $modifier1_3 : '')."',
    modifier1_4 = '".s_for(!empty($modifier1_4) ? $modifier1_4 : '')."',
    diagnosis_pointer1 = '".s_for(!empty($diagnosis_pointer1) ? $diagnosis_pointer1 : '')."',
    s_charges1_1 = '".s_for(!empty($s_charges1_1) ? $s_charges1_1 : '')."',
    s_charges1_2 = '".s_for(!empty($s_charges1_2) ? $s_charges1_2 : '')."',
    days_or_units1 = '".s_for(!empty($days_or_units1) ? $days_or_units1 : '')."',
    epsdt_family_plan1 = '".s_for(!empty($epsdt_family_plan1) ? $epsdt_family_plan1 : '')."',
    id_qua1 = '".s_for(!empty($id_qua1) ? $id_qua1 : '')."',
    rendering_provider_id1 = '".s_for(!empty($rendering_provider_id1) ? $rendering_provider_id1 : '')."',
    service_date2_from = '".s_for(!empty($service_date2_from) ? $service_date2_from : '')."',
    service_date2_to = '".s_for(!empty($service_date2_to) ? $service_date2_to : '')."',
    place_of_service2 = '".s_for(!empty($place_of_service2) ? $place_of_service2 : '')."',
    emg2 = '".s_for(!empty($emg2) ? $emg2 : '')."',
    cpt_hcpcs2 = '".s_for(!empty($cpt_hcpcs2) ? $cpt_hcpcs2 : '')."',
    modifier2_1 = '".s_for(!empty($modifier2_1) ? $modifier2_1 : '')."',
    modifier2_2 = '".s_for(!empty($modifier2_2) ? $modifier2_2 : '')."',
    modifier2_3 = '".s_for(!empty($modifier2_3) ? $modifier2_3 : '')."',
    modifier2_4 = '".s_for(!empty($modifier2_4) ? $modifier2_4 : '')."',
    diagnosis_pointer2 = '".s_for(!empty($diagnosis_pointer2) ? $diagnosis_pointer2 : '')."',
    s_charges2_1 = '".s_for(!empty($s_charges2_1) ? $s_charges2_1 : '')."',
    s_charges2_2 = '".s_for(!empty($s_charges2_2) ? $s_charges2_2 : '')."',
    days_or_units2 = '".s_for(!empty($days_or_units2) ? $days_or_units2 : '')."',
    epsdt_family_plan2 = '".s_for(!empty($epsdt_family_plan2) ? $epsdt_family_plan2 : '')."',
    id_qua2 = '".s_for(!empty($id_qua2) ? $id_qua2 : '')."',
    rendering_provider_id2 = '".s_for(!empty($rendering_provider_id2) ? $rendering_provider_id2 : '')."',
    service_date3_from = '".s_for(!empty($service_date3_from) ? $service_date3_from : '')."',
    service_date3_to = '".s_for(!empty($service_date3_to) ? $service_date3_to : '')."',
    place_of_service3 = '".s_for(!empty($place_of_service3) ? $place_of_service3 : '')."',
    emg3 = '".s_for(!empty($emg3) ? $emg3 : '')."',
    cpt_hcpcs3 = '".s_for(!empty($cpt_hcpcs3) ? $cpt_hcpcs3 : '')."',
    modifier3_1 = '".s_for(!empty($modifier3_1) ? $modifier3_1 : '')."',
    modifier3_2 = '".s_for(!empty($modifier3_2) ? $modifier3_2 : '')."',
    modifier3_3 = '".s_for(!empty($modifier3_3) ? $modifier3_3 : '')."',
    modifier3_4 = '".s_for(!empty($modifier3_4) ? $modifier3_4 : '')."',
    diagnosis_pointer3 = '".s_for(!empty($diagnosis_pointer3) ? $diagnosis_pointer3 : '')."',
    s_charges3_1 = '".s_for(!empty($s_charges3_1) ? $s_charges3_1 : '')."',
    s_charges3_2 = '".s_for(!empty($s_charges3_2) ? $s_charges3_2 : '')."',
    days_or_units3 = '".s_for(!empty($days_or_units3) ? $days_or_units3 : '')."',
    epsdt_family_plan3 = '".s_for(!empty($epsdt_family_plan3) ? $epsdt_family_plan3 : '')."',
    id_qua3 = '".s_for(!empty($id_qua3) ? $id_qua3 : '')."',
    rendering_provider_id3 = '".s_for(!empty($rendering_provider_id3) ? $rendering_provider_id3 : '')."',
    service_date4_from = '".s_for(!empty($service_date4_from) ? $service_date4_from : '')."',
    service_date4_to = '".s_for(!empty($service_date4_to) ? $service_date4_to : '')."',
    place_of_service4 = '".s_for(!empty($place_of_service4) ? $place_of_service4 : '')."',
    emg4 = '".s_for(!empty($emg4) ? $emg4 : '')."',
    cpt_hcpcs4 = '".s_for(!empty($cpt_hcpcs4) ? $cpt_hcpcs4 : '')."',
    modifier4_1 = '".s_for(!empty($modifier4_1) ? $modifier4_1 : '')."',
    modifier4_2 = '".s_for(!empty($modifier4_2) ? $modifier4_2 : '')."',
    modifier4_3 = '".s_for(!empty($modifier4_3) ? $modifier4_3 : '')."',
    modifier4_4 = '".s_for(!empty($modifier4_4) ? $modifier4_4 : '')."',
    diagnosis_pointer4 = '".s_for(!empty($diagnosis_pointer4) ? $diagnosis_pointer4 : '')."',
    s_charges4_1 = '".s_for(!empty($s_charges4_1) ? $s_charges4_1 : '')."',
    s_charges4_2 = '".s_for(!empty($s_charges4_2) ? $s_charges4_2 : '')."',
    days_or_units4 = '".s_for(!empty($days_or_units4) ? $days_or_units4 : '')."',
    epsdt_family_plan4 = '".s_for(!empty($epsdt_family_plan4) ? $epsdt_family_plan4 : '')."',
    id_qua4 = '".s_for(!empty($id_qua4) ? $id_qua4 : '')."',
    rendering_provider_id4 = '".s_for(!empty($rendering_provider_id4) ? $rendering_provider_id4 : '')."',
    service_date5_from = '".s_for(!empty($service_date5_from) ? $service_date5_from : '')."',
    service_date5_to = '".s_for(!empty($service_date5_to) ? $service_date5_to : '')."',
    place_of_service5 = '".s_for(!empty($place_of_service5) ? $place_of_service5 : '')."',
    emg5 = '".s_for(!empty($emg5) ? $emg5 : '')."',
    cpt_hcpcs5 = '".s_for(!empty($cpt_hcpcs5) ? $cpt_hcpcs5 : '')."',
    modifier5_1 = '".s_for(!empty($modifier5_1) ? $modifier5_1 : '')."',
    modifier5_2 = '".s_for(!empty($modifier5_2) ? $modifier5_2 : '')."',
    modifier5_3 = '".s_for(!empty($modifier5_3) ? $modifier5_3 : '')."',
    modifier5_4 = '".s_for(!empty($modifier5_4) ? $modifier5_4 : '')."',
    diagnosis_pointer5 = '".s_for(!empty($diagnosis_pointer5) ? $diagnosis_pointer5 : '')."',
    s_charges5_1 = '".s_for(!empty($s_charges5_1) ? $s_charges5_1 : '')."',
    s_charges5_2 = '".s_for(!empty($s_charges5_2) ? $s_charges5_2 : '')."',
    days_or_units5 = '".s_for(!empty($days_or_units5) ? $days_or_units5 : '')."',
    epsdt_family_plan5 = '".s_for(!empty($epsdt_family_plan5) ? $epsdt_family_plan5 : '')."',
    id_qua5 = '".s_for(!empty($id_qua5) ? $id_qua5 : '')."',
    rendering_provider_id5 = '".s_for(!empty($rendering_provider_id5) ? $rendering_provider_id5 : '')."',
    service_date6_from = '".s_for(!empty($service_date6_from) ? $service_date6_from : '')."',
    service_date6_to = '".s_for(!empty($service_date6_to) ? $service_date6_to : '')."',
    place_of_service6 = '".s_for(!empty($place_of_service6) ? $place_of_service6 : '')."',
    emg6 = '".s_for(!empty($emg6) ? $emg6 : '')."',
    cpt_hcpcs6 = '".s_for(!empty($cpt_hcpcs6) ? $cpt_hcpcs6 : '')."',
    modifier6_1 = '".s_for(!empty($modifier6_1) ? $modifier6_1 : '')."',
    modifier6_2 = '".s_for(!empty($modifier6_2) ? $modifier6_2 : '')."',
    modifier6_3 = '".s_for(!empty($modifier6_3) ? $modifier6_3 : '')."',
    modifier6_4 = '".s_for(!empty($modifier6_4) ? $modifier6_4 : '')."',
    diagnosis_pointer6 = '".s_for(!empty($diagnosis_pointer6) ? $diagnosis_pointer6 : '')."',
    s_charges6_1 = '".s_for(!empty($s_charges6_1) ? $s_charges6_1 : '')."',
    s_charges6_2 = '".s_for(!empty($s_charges6_2) ? $s_charges6_2 : '')."',
    days_or_units6 = '".s_for(!empty($days_or_units6) ? $days_or_units6 : '')."',
    epsdt_family_plan6 = '".s_for(!empty($epsdt_family_plan6) ? $epsdt_family_plan6 : '')."',
    id_qua6 = '".s_for(!empty($id_qua6) ? $id_qua6 : '')."',
    rendering_provider_id6 = '".s_for(!empty($rendering_provider_id6) ? $rendering_provider_id6 : '')."',
    federal_tax_id_number = '".s_for(!empty($federal_tax_id_number) ? $federal_tax_id_number : '')."',
    ssn = '".s_for(!empty($ssn) ? $ssn : '')."',
    ein = '".s_for(!empty($ein) ? $ein : '')."',
    patient_account_no = '".s_for(!empty($patient_account_no) ? $patient_account_no : '')."',
    accept_assignment = '".s_for(!empty($accept_assignment) ? $accept_assignment : '')."',
    total_charge = '".s_for(!empty($total_charge) ? $total_charge : '')."',
    amount_paid = '".s_for(!empty($amount_paid) ? $amount_paid : '')."',
    balance_due = '".s_for(!empty($balance_due) ? $balance_due : '')."',
    signature_physician = '".s_for(!empty($signature_physician) ? $signature_physician : '')."',
    physician_signed_date = '".s_for(!empty($physician_signed_date) ? $physician_signed_date : '')."',
    service_facility_info_name = '".s_for(!empty($service_facility_info_name) ? $service_facility_info_name : '')."',
    service_facility_info_address = '".s_for(!empty($service_facility_info_address) ? $service_facility_info_address : '')."',
    service_facility_info_city = '".s_for(!empty($service_facility_info_city) ? $service_facility_info_city : '')."',
    service_info_a = '".s_for(!empty($service_info_a) ? $service_info_a : '')."',
    service_info_dd = '".s_for(!empty($service_info_dd) ? $service_info_dd : '')."',
    service_info_b_other = '".s_for(!empty($service_info_b_other) ? $service_info_b_other : '')."',
    billing_provider_phone_code = '".s_for(!empty($billing_provider_phone_code) ? $billing_provider_phone_code : '')."',
    billing_provider_phone = '".s_for(!empty($billing_provider_phone) ? $billing_provider_phone : '')."',
    billing_provider_name = '".s_for(!empty($billing_provider_name) ? $billing_provider_name : '')."',
    billing_provider_address = '".s_for(!empty($billing_provider_address) ? $billing_provider_address : '')."',
    billing_provider_city = '".s_for(!empty($billing_provider_city) ? $billing_provider_city : '')."',
    billing_provider_a = '".s_for(!empty($billing_provider_a) ? $billing_provider_a : '')."',
    billing_provider_dd = '".s_for(!empty($billing_provider_dd) ? $billing_provider_dd : '')."',
    billing_provider_b_other = '".s_for(!empty($billing_provider_b_other) ? $billing_provider_b_other : '')."',
    p_m_eligible_payer_id = '".mysqli_real_escape_string($con,$p_m_eligible_payer_id)."',
    p_m_eligible_payer_name = '".mysqli_real_escape_string($con,$p_m_eligible_payer_name)."',
    status = '".s_for(DSS_CLAIM_PENDING)."',
    userid = '".s_for($_SESSION['userid'])."',
    docid = '".s_for($_SESSION['docid'])."',
    producer = '".s_for($prod)."',
    adddate = now(),
    ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

    $primary_claim_id = $db->getInsertId($ins_sql);
	claim_history_update($primary_claim_id, $_SESSION['userid'], null);
    return $primary_claim_id;
}

function create_claim_sec($pid, $primary_claim_id, $prod)
{
    $db = new Db();
    $con = $GLOBALS['con'];

    $pat_sql = "select p.*, u.billing_company_id from dental_patients p 
		        JOIN dental_users u ON u.userid=p.docid
		        where p.patientid='".s_for($pid)."'";

    $pat_myarray = $db->getRow($pat_sql);

    $p_m_dss_file = $pat_myarray['s_m_dss_file'];
    $p_m_billing_id = $pat_myarray['billing_company_id'];
    $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
    $insurancetype = st($pat_myarray['p_m_ins_type']);
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
    $referredby = st($pat_myarray['referred_by']);
    $referred_source = st($pat_myarray['referred_source']);
    $docid = $pat_myarray['docid'];
    $insured_sex = $pat_myarray['s_m_gender'];
    $other_insured_sex = $pat_myarray['p_m_gender'];
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
    $insured_id_number = $pat_myarray['s_m_ins_id'];

	if ($pat_myarray['p_m_same_address']=='1') {
          $other_insured_address = $pat_myarray['add1'];
          $other_insured_city = $pat_myarray['city'];
          $other_insured_state = $pat_myarray['state'];
          $other_insured_zip = $pat_myarray['zip'];
	} else {
          $other_insured_address = $pat_myarray['p_m_address'];
          $other_insured_city = $pat_myarray['p_m_city'];
          $other_insured_state = $pat_myarray['p_m_state'];
          $other_insured_zip = $pat_myarray['p_m_zip'];
	}

	if ($pat_myarray['s_m_same_address']=='1') {
          $insured_address = $pat_myarray['add1'];
          $insured_city = $pat_myarray['city'];
          $insured_state = $pat_myarray['state'];
          $insured_zip = $pat_myarray['zip'];
	} else {
          $insured_address = $pat_myarray['s_m_address'];
          $insured_city = $pat_myarray['s_m_city'];
          $insured_state = $pat_myarray['s_m_state'];
          $insured_zip = $pat_myarray['s_m_zip'];
	}

    $insured_dob = $pat_myarray['ins2_dob'];
    $patient_relation_insured = $pat_myarray['s_m_relation'];
    $patient_relation_other_insured = $pat_myarray['p_m_relation'];
    $insured_employer_school_name = $pat_myarray['employer'];

    //NEED SECONDARY?
    $p_m_eligible_payer_id = $pat_myarray['p_m_eligible_payer_id'];
    $p_m_eligible_payer_name = $pat_myarray['p_m_eligible_payer_name'];
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
    if (!empty($dent_rows) && $dent_rows <= 0) {
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
             . "  patient_id = '" . (!empty($_GET['pid']) ? $_GET['pid'] : '') . "' "
             . "  AND status = " . DSS_PREAUTH_COMPLETE . " "
             . "ORDER BY "
             . "  date_completed desc "
             . "LIMIT 1";   

        $num_rows = $db->getNumberRows($sql);

        if ($num_rows > 0) {
            $myarray = $db->getRow($sql);
            $prior_authorization_number = $myarray['pre_auth_num'];
        }
    }

	$ins_sql = " insert into dental_insurance set 
	patientid = '".s_for($pid)."',
	pica1 = '".s_for(!empty($pica1) ? $pica1 : '')."',
	pica2 = '".s_for(!empty($pica2) ? $pica2 : '')."',
	pica3 = '".s_for(!empty($pica3) ? $pica3 : '')."',
	insurance_type = '".s_for($insurancetype)."',
	other_insurance_type = '".s_for($other_insurancetype)."',
	insured_id_number = '".s_for($insured_id_number)."',
	patient_lastname = '".s_for($patient_lastname)."',
	patient_firstname = '".s_for($patient_firstname)."',
	patient_middle = '".s_for($patient_middle)."',
	patient_dob = '".s_for($patient_dob)."',
	patient_sex = '".s_for(!empty($patient_sex) ? $patient_sex : '')."',
	insured_firstname = '".s_for($insured_firstname)."',
	insured_lastname = '".s_for($insured_lastname)."',
	insured_middle = '".s_for($insured_middle)."',
	patient_address = '".s_for($patient_address)."',
	patient_relation_insured = '".s_for($patient_relation_insured)."',
	patient_relation_other_insured = '".s_for($patient_relation_other_insured)."',
	patient_city = '".s_for($patient_city)."',
	patient_state = '".s_for($patient_state)."',
	patient_status = '".s_for(!empty($patient_status_arr) ? $patient_status_arr : '')."',
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
	employment = '".s_for(!empty($employment) ? $employment : '')."',
	auto_accident = '".s_for(!empty($auto_accident) ? $auto_accident : '')."',
	auto_accident_place = '".s_for(!empty($auto_accident_place) ? $auto_accident_place : '')."',
	other_accident = '".s_for(!empty($other_accident) ? $other_accident : '')."',
	insured_policy_group_feca = '".s_for($insured_policy_group_feca)."',
	other_insured_policy_group_feca = '".s_for($other_insured_policy_group_feca)."',
	insured_dob = '".s_for($insured_dob)."',
	insured_sex = '".s_for($insured_sex)."',
	other_insured_dob = '".s_for($other_insured_dob)."',
	other_insured_sex = '".s_for($other_insured_sex)."',
	insured_employer_school_name = '".s_for($insured_employer_school_name)."',
	other_insured_employer_school_name = '".s_for(!empty($other_insured_employer_school_name) ? $other_insured_employer_school_name : '')."',
	insured_insurance_plan = '".s_for($insured_insurance_plan)."',
	other_insured_insurance_plan = '".s_for($other_insured_insurance_plan)."',
	reserved_local_use = '".s_for(!empty($reserved_local_use) ? $reserved_local_use : '')."',
	another_plan = '".s_for(!empty($another_plan) ? $another_plan : '')."',
	patient_signature = '".$patient_signature."',
	patient_signed_date = '".s_for($patient_signed_date)."',
    insured_signature = '".s_for(!empty($insured_signature) ? $insured_signature : '')."',
    date_current = '".s_for(!empty($date_current) ? $date_current : '')."',
    date_same_illness = '".s_for(!empty($date_same_illness) ? $date_same_illness : '')."',
    unable_date_from = '".s_for(!empty($unable_date_from) ? $unable_date_from : '')."',
    unable_date_to = '".s_for(!empty($unable_date_to) ? $unable_date_to : '')."',
    referring_provider = '".s_for(!empty($referring_provider) ? $referring_provider : '')."',
    field_17a_dd = '".s_for(!empty($field_17a_dd) ? $field_17a_dd : '')."',
    field_17a = '".s_for(!empty($field_17a) ? $field_17a : '')."',
    field_17b = '".s_for(!empty($field_17b) ? $field_17b : '')."',
    hospitalization_date_from = '".s_for(!empty($hospitalization_date_from) ? $hospitalization_date_from : '')."',
    hospitalization_date_to = '".s_for(!empty($hospitalization_date_to) ? $hospitalization_date_to : '')."',
    reserved_local_use1 = '".s_for(!empty($reserved_local_use1) ? $reserved_local_use1 : '')."',
    outside_lab = '".s_for(!empty($outside_lab) ? $outside_lab : '')."',
    s_charges = '".s_for(!empty($s_charges) ? $s_charges : '')."',
    diagnosis_1 = '".s_for(!empty($diagnosis_1) ? $diagnosis_1 : '')."',
    diagnosis_2 = '".s_for(!empty($diagnosis_2) ? $diagnosis_2 : '')."',
    diagnosis_3 = '".s_for(!empty($diagnosis_3) ? $diagnosis_3 : '')."',
    diagnosis_4 = '".s_for(!empty($diagnosis_4) ? $diagnosis_4 : '')."',
    diagnosis_a = '".s_for(!empty($diagnosis_a) ? $diagnosis_a : '')."',
    diagnosis_b = '".s_for(!empty($diagnosis_b) ? $diagnosis_b : '')."',
    diagnosis_c = '".s_for(!empty($diagnosis_c) ? $diagnosis_c : '')."',
    diagnosis_d = '".s_for(!empty($diagnosis_d) ? $diagnosis_d : '')."',
    diagnosis_e = '".s_for(!empty($diagnosis_e) ? $diagnosis_e : '')."',
    diagnosis_f = '".s_for(!empty($diagnosis_f) ? $diagnosis_f : '')."',
    diagnosis_g = '".s_for(!empty($diagnosis_g) ? $diagnosis_g : '')."',
    diagnosis_h = '".s_for(!empty($diagnosis_h) ? $diagnosis_h : '')."',
    diagnosis_i = '".s_for(!empty($diagnosis_i) ? $diagnosis_i : '')."',
    diagnosis_j = '".s_for(!empty($diagnosis_j) ? $diagnosis_j : '')."',
    diagnosis_k = '".s_for(!empty($diagnosis_k) ? $diagnosis_k : '')."',
    diagnosis_l = '".s_for(!empty($diagnosis_l) ? $diagnosis_l : '')."',
    medicaid_resubmission_code = '".s_for(!empty($medicaid_resubmission_code) ? $medicaid_resubmission_code : '')."',
    original_ref_no = '".s_for(!empty($original_ref_no) ? $original_ref_no : '')."',
    prior_authorization_number = '".s_for(!empty($prior_authorization_number) ? $prior_authorization_number : '')."',
    service_date1_from = '".s_for(!empty($service_date1_from) ? $service_date1_from : '')."',
    service_date1_to = '".s_for(!empty($service_date1_to) ? $service_date1_to : '')."',
    place_of_service1 = '".s_for(!empty($place_of_service1) ? $place_of_service1 : '')."',
    emg1 = '".s_for(!empty($emg1) ? $emg1 : '')."',
    cpt_hcpcs1 = '".s_for(!empty($cpt_hcpcs1) ? $cpt_hcpcs1 : '')."',
    modifier1_1 = '".s_for(!empty($modifier1_1) ? $modifier1_1 : '')."',
    modifier1_2 = '".s_for(!empty($modifier1_2) ? $modifier1_2 : '')."',
    modifier1_3 = '".s_for(!empty($modifier1_3) ? $modifier1_3 : '')."',
    modifier1_4 = '".s_for(!empty($modifier1_4) ? $modifier1_4 : '')."',
    diagnosis_pointer1 = '".s_for(!empty($diagnosis_pointer1) ? $diagnosis_pointer1 : '')."',
    s_charges1_1 = '".s_for(!empty($s_charges1_1) ? $s_charges1_1 : '')."',
    s_charges1_2 = '".s_for(!empty($s_charges1_2) ? $s_charges1_2 : '')."',
    days_or_units1 = '".s_for(!empty($days_or_units1) ? $days_or_units1 : '')."',
    epsdt_family_plan1 = '".s_for(!empty($epsdt_family_plan1) ? $epsdt_family_plan1 : '')."',
    id_qua1 = '".s_for(!empty($id_qua1) ? $id_qua1 : '')."',
    rendering_provider_id1 = '".s_for(!empty($rendering_provider_id1) ? $rendering_provider_id1 : '')."',
    service_date2_from = '".s_for(!empty($service_date2_from) ? $service_date2_from : '')."',
    service_date2_to = '".s_for(!empty($service_date2_to) ? $service_date2_to : '')."',
    place_of_service2 = '".s_for(!empty($place_of_service2) ? $place_of_service2 : '')."',
    emg2 = '".s_for(!empty($emg2) ? $emg2 : '')."',
    cpt_hcpcs2 = '".s_for(!empty($cpt_hcpcs2) ? $cpt_hcpcs2 : '')."',
    modifier2_1 = '".s_for(!empty($modifier2_1) ? $modifier2_1 : '')."',
    modifier2_2 = '".s_for(!empty($modifier2_2) ? $modifier2_2 : '')."',
    modifier2_3 = '".s_for(!empty($modifier2_3) ? $modifier2_3 : '')."',
    modifier2_4 = '".s_for(!empty($modifier2_4) ? $modifier2_4 : '')."',
    diagnosis_pointer2 = '".s_for(!empty($diagnosis_pointer2) ? $diagnosis_pointer2 : '')."',
    s_charges2_1 = '".s_for(!empty($s_charges2_1) ? $s_charges2_1 : '')."',
    s_charges2_2 = '".s_for(!empty($s_charges2_2) ? $s_charges2_2 : '')."',
    days_or_units2 = '".s_for(!empty($days_or_units2) ? $days_or_units2 : '')."',
    epsdt_family_plan2 = '".s_for(!empty($epsdt_family_plan2) ? $epsdt_family_plan2 : '')."',
    id_qua2 = '".s_for(!empty($id_qua2) ? $id_qua2 : '')."',
    rendering_provider_id2 = '".s_for(!empty($rendering_provider_id2) ? $rendering_provider_id2 : '')."',
    service_date3_from = '".s_for(!empty($service_date3_from) ? $service_date3_from : '')."',
    service_date3_to = '".s_for(!empty($service_date3_to) ? $service_date3_to : '')."',
    place_of_service3 = '".s_for(!empty($place_of_service3) ? $place_of_service3 : '')."',
    emg3 = '".s_for(!empty($emg3) ? $emg3 : '')."',
    cpt_hcpcs3 = '".s_for(!empty($cpt_hcpcs3) ? $cpt_hcpcs3 : '')."',
    modifier3_1 = '".s_for(!empty($modifier3_1) ? $modifier3_1 : '')."',
    modifier3_2 = '".s_for(!empty($modifier3_2) ? $modifier3_2 : '')."',
    modifier3_3 = '".s_for(!empty($modifier3_3) ? $modifier3_3 : '')."',
    modifier3_4 = '".s_for(!empty($modifier3_4) ? $modifier3_4 : '')."',
    diagnosis_pointer3 = '".s_for(!empty($diagnosis_pointer3) ? $diagnosis_pointer3 : '')."',
    s_charges3_1 = '".s_for(!empty($s_charges3_1) ? $s_charges3_1 : '')."',
    s_charges3_2 = '".s_for(!empty($s_charges3_2) ? $s_charges3_2 : '')."',
    days_or_units3 = '".s_for(!empty($days_or_units3) ? $days_or_units3 : '')."',
    epsdt_family_plan3 = '".s_for(!empty($epsdt_family_plan3) ? $epsdt_family_plan3 : '')."',
    id_qua3 = '".s_for(!empty($id_qua3) ? $id_qua3 : '')."',
    rendering_provider_id3 = '".s_for(!empty($rendering_provider_id3) ? $rendering_provider_id3 : '')."',
    service_date4_from = '".s_for(!empty($service_date4_from) ? $service_date4_from : '')."',
    service_date4_to = '".s_for(!empty($service_date4_to) ? $service_date4_to : '')."',
    place_of_service4 = '".s_for(!empty($place_of_service4) ? $place_of_service4 : '')."',
    emg4 = '".s_for(!empty($emg4) ? $emg4 : '')."',
    cpt_hcpcs4 = '".s_for(!empty($cpt_hcpcs4) ? $cpt_hcpcs4 : '')."',
    modifier4_1 = '".s_for(!empty($modifier4_1) ? $modifier4_1 : '')."',
    modifier4_2 = '".s_for(!empty($modifier4_2) ? $modifier4_2 : '')."',
    modifier4_3 = '".s_for(!empty($modifier4_3) ? $modifier4_3 : '')."',
    modifier4_4 = '".s_for(!empty($modifier4_4) ? $modifier4_4 : '')."',
    diagnosis_pointer4 = '".s_for(!empty($diagnosis_pointer4) ? $diagnosis_pointer4 : '')."',
    s_charges4_1 = '".s_for(!empty($s_charges4_1) ? $s_charges4_1 : '')."',
    s_charges4_2 = '".s_for(!empty($s_charges4_2) ? $s_charges4_2 : '')."',
    days_or_units4 = '".s_for(!empty($days_or_units4) ? $days_or_units4 : '')."',
    epsdt_family_plan4 = '".s_for(!empty($epsdt_family_plan4) ? $epsdt_family_plan4 : '')."',
    id_qua4 = '".s_for(!empty($id_qua4) ? $id_qua4 : '')."',
    rendering_provider_id4 = '".s_for(!empty($rendering_provider_id4) ? $rendering_provider_id4 : '')."',
    service_date5_from = '".s_for(!empty($service_date5_from) ? $service_date5_from : '')."',
    service_date5_to = '".s_for(!empty($service_date5_to) ? $service_date5_to : '')."',
    place_of_service5 = '".s_for(!empty($place_of_service5) ? $place_of_service5 : '')."',
    emg5 = '".s_for(!empty($emg5) ? $emg5 : '')."',
    cpt_hcpcs5 = '".s_for(!empty($cpt_hcpcs5) ? $cpt_hcpcs5 : '')."',
    modifier5_1 = '".s_for(!empty($modifier5_1) ? $modifier5_1 : '')."',
    modifier5_2 = '".s_for(!empty($modifier5_2) ? $modifier5_2 : '')."',
    modifier5_3 = '".s_for(!empty($modifier5_3) ? $modifier5_3 : '')."',
    modifier5_4 = '".s_for(!empty($modifier5_4) ? $modifier5_4 : '')."',
    diagnosis_pointer5 = '".s_for(!empty($diagnosis_pointer5) ? $diagnosis_pointer5 : '')."',
    s_charges5_1 = '".s_for(!empty($s_charges5_1) ? $s_charges5_1 : '')."',
    s_charges5_2 = '".s_for(!empty($s_charges5_2) ? $s_charges5_2 : '')."',
    days_or_units5 = '".s_for(!empty($days_or_units5) ? $days_or_units5 : '')."',
    epsdt_family_plan5 = '".s_for(!empty($epsdt_family_plan5) ? $epsdt_family_plan5 : '')."',
    id_qua5 = '".s_for(!empty($id_qua5) ? $id_qua5 : '')."',
    rendering_provider_id5 = '".s_for(!empty($rendering_provider_id5) ? $rendering_provider_id5 : '')."',
    service_date6_from = '".s_for(!empty($service_date6_from) ? $service_date6_from : '')."',
    service_date6_to = '".s_for(!empty($service_date6_to) ? $service_date6_to : '')."',
    place_of_service6 = '".s_for(!empty($place_of_service6) ? $place_of_service6 : '')."',
    emg6 = '".s_for(!empty($emg6) ? $emg6 : '')."',
    cpt_hcpcs6 = '".s_for(!empty($cpt_hcpcs6) ? $cpt_hcpcs6 : '')."',
    modifier6_1 = '".s_for(!empty($modifier6_1) ? $modifier6_1 : '')."',
    modifier6_2 = '".s_for(!empty($modifier6_2) ? $modifier6_2 : '')."',
    modifier6_3 = '".s_for(!empty($modifier6_3) ? $modifier6_3 : '')."',
    modifier6_4 = '".s_for(!empty($modifier6_4) ? $modifier6_4 : '')."',
    diagnosis_pointer6 = '".s_for(!empty($diagnosis_pointer6) ? $diagnosis_pointer6 : '')."',
    s_charges6_1 = '".s_for(!empty($s_charges6_1) ? $s_charges6_1 : '')."',
    s_charges6_2 = '".s_for(!empty($s_charges6_2) ? $s_charges6_2 : '')."',
    days_or_units6 = '".s_for(!empty($days_or_units6) ? $days_or_units6 : '')."',
    epsdt_family_plan6 = '".s_for(!empty($epsdt_family_plan6) ? $epsdt_family_plan6 : '')."',
    id_qua6 = '".s_for(!empty($id_qua6) ? $id_qua6 : '')."',
    rendering_provider_id6 = '".s_for(!empty($rendering_provider_id6) ? $rendering_provider_id6 : '')."',
    federal_tax_id_number = '".s_for(!empty($federal_tax_id_number) ? $federal_tax_id_number : '')."',
    ssn = '".s_for(!empty($ssn) ? $ssn : '')."',
    ein = '".s_for(!empty($ein) ? $ein : '')."',
    patient_account_no = '".s_for(!empty($patient_account_no) ? $patient_account_no : '')."',
    accept_assignment = '".s_for(!empty($accept_assignment) ? $accept_assignment : '')."',
    total_charge = '".s_for(!empty($total_charge) ? $total_charge : '')."',
    amount_paid = '".s_for(!empty($amount_paid) ? $amount_paid : '')."',
    balance_due = '".s_for(!empty($balance_due) ? $balance_due : '')."',
    signature_physician = '".s_for(!empty($signature_physician) ? $signature_physician : '')."',
    physician_signed_date = '".s_for(!empty($physician_signed_date) ? $physician_signed_date : '')."',
    service_facility_info_name = '".s_for(!empty($service_facility_info_name) ? $service_facility_info_name : '')."',
    service_facility_info_address = '".s_for(!empty($service_facility_info_address) ? $service_facility_info_address : '')."',
    service_facility_info_city = '".s_for(!empty($service_facility_info_city) ? $service_facility_info_city : '')."',
    service_info_a = '".s_for(!empty($service_info_a) ? $service_info_a : '')."',
    service_info_dd = '".s_for(!empty($service_info_dd) ? $service_info_dd : '')."',
    service_info_b_other = '".s_for(!empty($service_info_b_other) ? $service_info_b_other : '')."',
    billing_provider_phone_code = '".s_for(!empty($billing_provider_phone_code) ? $billing_provider_phone_code : '')."',
    billing_provider_phone = '".s_for(!empty($billing_provider_phone) ? $billing_provider_phone : '')."',
    billing_provider_name = '".s_for(!empty($billing_provider_name) ? $billing_provider_name : '')."',
    billing_provider_address = '".s_for(!empty($billing_provider_address) ? $billing_provider_address : '')."',
    billing_provider_city = '".s_for(!empty($billing_provider_city) ? $billing_provider_city : '')."',
    billing_provider_a = '".s_for(!empty($billing_provider_a) ? $billing_provider_a : '')."',
    billing_provider_dd = '".s_for(!empty($billing_provider_dd) ? $billing_provider_dd : '')."',
    billing_provider_b_other = '".s_for(!empty($billing_provider_b_other) ? $billing_provider_b_other : '')."',
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
	return $secondary_claim_id;
}

?>
