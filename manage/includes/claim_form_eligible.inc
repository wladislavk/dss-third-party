<?php namespace Ds3\Libraries\Legacy; ?><?php

  $status_sql = "SELECT status FROM dental_insurance
                 WHERE insuranceid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'
                 AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";

  $status_r = $db->getRow($status_sql);
  $status = $status_r['status'];
  $is_sent = ($status == DSS_CLAIM_SENT || $status == DSS_CLAIM_SEC_SENT) ? true : false;
  $is_pending = ($status == DSS_CLAIM_PENDING || $status == DSS_CLAIM_SEC_PENDING) ? true : false;
  $is_pri_pending = ($status == DSS_CLAIM_PENDING) ? true : false;
  $is_sec_pending = ($status == DSS_CLAIM_SEC_PENDING) ? true : false;
  $is_disputed = ($status == DSS_CLAIM_DISPUTE || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_PATIENT_DISPUTE || $status == DSS_CLAIM_SEC_PATIENT_DISPUTE) ? true : false;
  $is_rejected = ($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED) ? true : false;
  $is_secondary = ($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_SENT || $status == DSS_CLAIM_SEC_DISPUTE || $status == DSS_CLAIM_SEC_REJECTED) || ($_GET['instype'] == 2);

  $pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
  
  $pat_myarray = $db->getRow($pat_sql);
  $docid = $pat_myarray['docid'];
  if($is_pri_pending){
    // Load patient info from dental_patients table using pid on query string
    $pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
    
    $pat_myarray = $db->getRow($pat_sql);
    $p_m_dss_file = $pat_myarray['p_m_dss_file'];
    $s_m_dss_file = $pat_myarray['s_m_dss_file'];
    $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
    $insurancetype = st($pat_myarray['p_m_ins_type']);
    $other_insurancetype = $pat_myarray['s_m_ins_type'];
    $insured_firstname = st($pat_myarray['p_m_partyfname']);
    $insured_lastname = st($pat_myarray['p_m_partylname']);
    $insured_middle = st($pat_myarray['p_m_partymname']);
      if ($pat_myarray['p_m_same_address'] == 1){
          $insured_address = st($pat_myarray['add1']);
          $insured_city = st($pat_myarray['city']);
          $insured_state = st($pat_myarray['state']);
          $insured_zip = st($pat_myarray['zip']);
      } else {
          $insured_address = st($pat_myarray['p_m_address']);
          $insured_city = st($pat_myarray['p_m_city']);
          $insured_state = st($pat_myarray['p_m_state']);
          $insured_zip = st($pat_myarray['p_m_zip']);
      }
    $other_insured_firstname = st($pat_myarray['s_m_partyfname']);
    $other_insured_lastname = st($pat_myarray['s_m_partylname']);
    $other_insured_middle = st($pat_myarray['s_m_partymname']);
      if ($pat_myarray['s_m_same_address'] == 1){
          $other_insured_address = st($pat_myarray['add1']);
          $other_insured_city = st($pat_myarray['city']);
          $other_insured_state = st($pat_myarray['state']);
          $other_insured_zip = st($pat_myarray['zip']);
      } else {
          $other_insured_address = st($pat_myarray['s_m_address']);
          $other_insured_city = st($pat_myarray['s_m_city']);
          $other_insured_state = st($pat_myarray['s_m_state']);
          $other_insured_zip = st($pat_myarray['s_m_zip']);
      }
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
    	trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die

    }
  }

  // In the case where we have first come to this page, load the claim form
  // info from dental_insurance and place them into variables.
  $sql = "select * from dental_insurance where insuranceid='".(!empty($_GET['insid']) ? $_GET['insid'] : '')."' and patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";

  $my = $db->getResults($sql);
  $myarray = (!empty($my[0]) ? $my[0] : '');
  $dent_rows = count($my);
  $insuranceid = st(!empty($myarray['insuranceid']) ? $myarray['insuranceid'] : '');
  $orig_claim_id = st(!empty($myarray['primary_claim_id']) ? $myarray['primary_claim_id'] : '');
  $p_m_eligible_payer_id = (!empty($myarray['p_m_eligible_payer_id']) ? $myarray['p_m_eligible_payer_id'] : '');
  $p_m_eligible_payer_name = (!empty($myarray['p_m_eligible_payer_name']) ? $myarray['p_m_eligible_payer_name'] : '');
  $s_m_eligible_payer_id = (!empty($myarray['s_m_eligible_payer_id']) ? $myarray['s_m_eligible_payer_id'] : '');
  $s_m_eligible_payer_name = (!empty($myarray['s_m_eligible_payer_name']) ? $myarray['s_m_eligible_payer_name'] : '');
  $responsibility_sequence = st($myarray['responsibility_sequence']);
  $icd_indicator = st($myarray['icd_ind']);

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

    if($is_secondary){
      $insurancetype = st($myarray['other_insurance_type']);
      $other_insurancetype = $myarray['insurance_type'];
      $other_insured_firstname = st($myarray['insured_firstname']);
      $other_insured_lastname = st($myarray['insured_lastname']);
      $other_insured_middle = st($myarray['insured_middle']);
      $other_insured_dob = st($pat_myarray['ins_dob']);
      $other_insured_sex = st($pat_myarray['s_m_gender']);

      if (empty($other_insured_insurance_plan)) {
        $other_insured_insurance_plan = st($myarray['insured_insurance_plan']);
      }
      
      $other_insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
      $other_insured_address = st($myarray['insured_address']);
      $other_insured_city = st($myarray['insured_city']);
      $other_insured_state = st($myarray['insured_state']);
      $other_insured_zip = st($myarray['insured_zip']);

      $insured_id_number = $pat_myarray['s_m_ins_id'];
      $insured_firstname = st($myarray['other_insured_firstname']);
      $insured_middle = st($myarray['other_insured_middle']);
      $insured_lastname = st($myarray['other_insured_lastname']);
      $insured_dob = st($pat_myarray['ins2_dob']);

      $insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
      $insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
      $other_insured_id_number = st($myarray['insured_id_number']);

        if ($pat_myarray['s_m_same_address'] == 1) {
            $insured_address = st($pat_myarray['add1']);
            $insured_city = st($pat_myarray['city']);
            $insured_state = st($pat_myarray['state']);
            $insured_zip = st($pat_myarray['zip']);
        } else {
            $insured_address = st($pat_myarray['s_m_address']);
            $insured_city = st($pat_myarray['s_m_city']);
            $insured_state = st($pat_myarray['s_m_state']);
            $insured_zip = st($pat_myarray['s_m_zip']);
        }
      $insured_phone_code = st($myarray['insured_phone_code']);
      $insured_phone = st($myarray['insured_phone']);
      $insured_sex = st($pat_myarray['s_m_gender']);
      $patient_relation_insured = st($myarray['patient_relation_insured']);
    } else {
      $insurancetype = st($myarray['insurance_type']);
      $other_insurancetype = $myarray['other_insurance_type'];
      $other_insured_firstname = st($myarray['other_insured_firstname']);
      $other_insured_lastname = st($myarray['other_insured_lastname']);
      $other_insured_middle = st($myarray['other_insured_middle']);
      $other_insured_dob = st($myarray['other_insured_dob']);
      $other_insured_sex = st($myarray['other_insured_sex']);

      if (empty($other_insured_insurance_plan)) {
        $other_insured_insurance_plan = st($myarray['other_insured_insurance_plan']);
      }

      $other_insured_policy_group_feca = st($myarray['other_insured_policy_group_feca']);
      $other_insured_address = st($myarray['other_insured_address']);
      $other_insured_city = st($myarray['other_insured_city']);
      $other_insured_state = st($myarray['other_insured_state']);
      $other_insured_zip = st($myarray['other_insured_zip']);
      $insured_id_number = st($myarray['insured_id_number']);
      $insured_firstname = st($myarray['insured_firstname']);
      $insured_middle = st($myarray['insured_middle']);
      $insured_lastname = st($myarray['insured_lastname']);
      $insured_dob = st($myarray['insured_dob']);
      $insured_insurance_plan = st($myarray['insured_insurance_plan']);
      $insured_policy_group_feca = st($myarray['insured_policy_group_feca']);
      $other_insured_id_number = st($myarray['other_insured_id_number']);
      $insured_address = st($myarray['insured_address']);
      $insured_city = st($myarray['insured_city']);
      $insured_state = st($myarray['insured_state']);
      $insured_zip = st($myarray['insured_zip']);
      $insured_phone_code = st($myarray['insured_phone_code']);
      $insured_phone = st($myarray['insured_phone']);
      $insured_sex = st($myarray['insured_sex']);
      $patient_relation_insured = st($myarray['patient_relation_insured']);
      $patient_relation_other_insured = st($myarray['patient_relation_other_insured']);  
    }

    $patient_address = st($myarray['patient_address']);
    $patient_city = st($myarray['patient_city']);
    $patient_state = st($myarray['patient_state']);
    $patient_status = st($myarray['patient_status']);
    $patient_status_array = explode('~',$patient_status);
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
    $current_qual = st($myarray['current_qual']);
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

    $claim_codes = st($myarray['claim_codes']);
    $medicaid_resubmission_code = st($myarray['medicaid_resubmission_code']);
    $resubmission_code_fill = st($myarray['resubmission_code_fill']);
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
      $rendering_provider_entity_1  = st($myarray['rendering_provider_entity_1']);
      $rendering_provider_first_name_1  = st($myarray['rendering_provider_first_name_1']);
      $rendering_provider_last_name_1  = st($myarray['rendering_provider_last_name_1']);
      $rendering_provider_org_1  = st($myarray['rendering_provider_org_1']);
      $rendering_provider_npi_1  = st($myarray['rendering_provider_npi_1']);
      $rendering_provider_entity_2  = st($myarray['rendering_provider_entity_2']);
      $rendering_provider_first_name_2 = st($myarray['rendering_provider_first_name_2']);
      $rendering_provider_last_name_2  = st($myarray['rendering_provider_last_name_2']);
      $rendering_provider_org_2  = st($myarray['rendering_provider_org_2']);
      $rendering_provider_npi_2  = st($myarray['rendering_provider_npi_2']);
      $rendering_provider_entity_3  = st($myarray['rendering_provider_entity_3']);
      $rendering_provider_first_name_3  = st($myarray['rendering_provider_first_name_3']);
      $rendering_provider_last_name_3  = st($myarray['rendering_provider_last_name_3']);
      $rendering_provider_org_3  = st($myarray['rendering_provider_org_3']);
      $rendering_provider_npi_3  = st($myarray['rendering_provider_npi_3']);
      $rendering_provider_entity_4  = st($myarray['rendering_provider_entity_4']);
      $rendering_provider_first_name_4  = st($myarray['rendering_provider_first_name_4']);
      $rendering_provider_last_name_4  = st($myarray['rendering_provider_last_name_4']);
      $rendering_provider_org_4  = st($myarray['rendering_provider_org_4']);
      $rendering_provider_npi_4  = st($myarray['rendering_provider_npi_4']);
      $rendering_provider_entity_5  = st($myarray['rendering_provider_entity_5']);
      $rendering_provider_first_name_5  = st($myarray['rendering_provider_first_name_5']);
      $rendering_provider_last_name_5  = st($myarray['rendering_provider_last_name_5']);
      $rendering_provider_org_5  = st($myarray['rendering_provider_org_5']);
      $rendering_provider_npi_5  = st($myarray['rendering_provider_npi_5']);
      $rendering_provider_entity_6  = st($myarray['rendering_provider_entity_6']);
      $rendering_provider_first_name_6  = st($myarray['rendering_provider_first_name_6']);
      $rendering_provider_last_name_6  = st($myarray['rendering_provider_last_name_6']);
      $rendering_provider_org_6  = st($myarray['rendering_provider_org_6']);
      $rendering_provider_npi_6  = st($myarray['rendering_provider_npi_6']);
    $federal_tax_id_number = st($myarray['federal_tax_id_number']);
    $ssn = st($myarray['ssn']);
    $ein = st($myarray['ein']);
    $patient_account_no = st($myarray['patient_account_no']);
    $accept_assignment = st($myarray['accept_assignment']);
    $total_charge = st($myarray['total_charge']);
    $amount_paid = st($myarray['amount_paid']);
    $balance_due = st($myarray['balance_due']);
    $signature_physician = st($myarray['signature_physician']);
    $physician_signed_date = st(($myarray['physician_signed_date']!='')?$myarray['physician_signed_date']:date('Y-m-d'));
    $service_facility_info_name = st($myarray['service_facility_info_name']);
    $service_facility_info_address = st($myarray['service_facility_info_address']);
    $service_facility_info_city = st($myarray['service_facility_info_city']);
    $service_facility_info = parseCityStateZip($service_facility_info_city);
    $service_info_a = st($myarray['service_info_a']);
    $service_info_dd = st($myarray['service_info_dd']);
    $service_info_b_other = st($myarray['service_info_b_other']);
    $billing_provider_phone_code = st($myarray['billing_provider_phone_code']);
    $billing_provider_phone = st($myarray['billing_provider_phone']);
    $billing_provider_name = st($myarray['billing_provider_name']);
    $billing_provider_address = st($myarray['billing_provider_address']);
    $billing_provider_city = st($myarray['billing_provider_city']);
    $billing_provider_info = parseCityStateZip($billing_provider_city);
    $billing_provider_a = st($myarray['billing_provider_a']);
    $billing_provider_dd = st($myarray['billing_provider_dd']);
    $billing_provider_b_other = st($myarray['billing_provider_b_other']);
    $reject_reason = st($myarray['reject_reason']);
    $status = st($myarray['status']);

    $billing_provider_sql = "select * from dental_qualifier where qualifierid='".(isset($billing_provider_dd) ? $billing_provider_dd : '') . "'";
    $billing_array = $db->getRow($billing_provider_sql);

    $billing_info = (!empty($billing_array['qualifier']) ? substr($billing_array['qualifier'], 0, 2) : '');
  }

/**
 * Logic:
 *
 * IF dental_insurance.another_plan IS set THEN use another_plan
 * IF dental_insurance.another_plan IS not set THEN read options from dental_patients.p_m_dss_file
 */
$another_plan = isset($another_plan) ? $another_plan : '';
$another_plan = strtolower($another_plan);

if ($another_plan != 'yes' && $another_plan != 'no') {
    if ((isset($p_m_dss_file) && $p_m_dss_file == 1) || (isset($s_m_dss_file) && $s_m_dss_file == 1)) {
        $another_plan = 'yes';
    } else {
        $another_plan = 'no';
    }
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

    if (strtolower($pat_myarray['p_m_ins_ass']) == 'yes'){
      $insured_signature = 1;
    }else{
      $insured_signature = 0;
    }
  	$patient_signature = 1;
  	//$signature_physician = "Signature on File";
  	$patient_signed_date = date('Y-m-d', strtotime($pat_myarray['adddate']));
    $physician_signed_date = date('Y-m-d');	
  	$patient_phone_code = split_phone($pat_myarray['home_phone'], true);
  	$patient_phone = split_phone($pat_myarray['home_phone'], false);
  	$insured_phone_code = split_phone($pat_myarray['home_phone'], true);
  	$insured_phone = split_phone($pat_myarray['home_phone'], false);
  	$patient_status = $pat_myarray['marital_status'];	
  	$insured_id_number = $pat_myarray['p_m_ins_id'];
    $other_insured_id_number = $pat_myarray['s_m_ins_id'];
  	$insured_address = (!empty($myarray['insured_address']) ? $myarray['insured_address'] : '');
  	$insured_city = (!empty($myarray['insured_city']) ? $myarray['insured_city'] : '');
  	$insured_state = (!empty($myarray['insured_state']) ? $myarray['insured_state'] : '');
  	$insured_zip = (!empty($myarray['insured_zip']) ? $myarray['insured_zip'] : '');
  	$insured_dob = $pat_myarray['ins_dob'];	
  	// $patient_relation_insured = $pat_myarray['p_m_relation'];
    $patient_relation_other_insured = $pat_myarray['s_m_relation'];
  	$insured_employer_school_name = $pat_myarray['employer'];

  	if($pat_myarray['p_m_ins_type']==1){
  	  $insured_policy_group_feca = "NONE";
            $insured_insurance_plan = '';
  	  $insured_employer_school_name = '';
  	} else {
  	  $insured_policy_group_feca = $pat_myarray['p_m_ins_grp'];
  	  $insured_insurance_plan = $pat_myarray['p_m_ins_plan'];	
  	}

    $sleepstudies = "SELECT ss.diagnosis FROM dental_summ_sleeplab ss                                 
                     JOIN dental_patients p on ss.patiendid=p.patientid
                     WHERE                                 
                     (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                      (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                      ss.filename IS NOT NULL AND ss.patiendid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY id DESC LIMIT 1;";

    $d = $db->getRow($sleepstudies);
    $diagnosis_1 = $d['diagnosis'];

    $sleepstudies = "SELECT ss.diagnosising_doc, diagnosising_npi FROM dental_summ_sleeplab ss                                 
                     JOIN dental_patients p on ss.patiendid=p.patientid
                     WHERE                                 
                      (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                      (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                      ss.filename IS NOT NULL AND ss.patiendid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY id DESC LIMIT 1;";

    $d = $db->getRow($sleepstudies);
    $referring_provider = $d['diagnosising_doc'];
    $diagnosising_npi = $d['diagnosising_npi'];

    if($insurancetype!=1){
      $referring_provider = '';
      $diagnosising_npi = '';
    }

    $accept_assignmentnew = st($pat_myarray['p_m_ins_ass']);
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

      $my = $db->getResults($sql);
      $num_rows = count($my);
      if ($num_rows > 0) {
          $myarray = $my[0];
          $prior_authorization_number = $myarray['pre_auth_num'];
      }
  }

  $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";

  $prod_r = $db->getRow($prod_s);
  $claim_producer = $prod_r['producer'];
  $getuserinfo = "SELECT * FROM dental_users WHERE producer_files = 1 AND userid = '".$claim_producer."'";

  if($userinfo = $db->getRow($getuserinfo)){
    $phone = $userinfo['phone'];
    $practice = $userinfo['practice'];
    $address = $userinfo['address'];
    $city = $userinfo['city'];
    $state = $userinfo['state'];
    $zip = $userinfo['zip'];
    $npi = $userinfo['npi'];
    $medicare_npi = $userinfo['medicare_npi'];
  }

  $getdocinfo = "SELECT * FROM dental_users WHERE userid = '".$docid."'";

  $docinfo = $db->getRow($getdocinfo);
  if(empty($phone)){ $phone = $docinfo['phone']; }
  if(empty($practice)){ $practice = $docinfo['practice']; }
  if(empty($address)){ $address = $docinfo['address']; }
  if(empty($city)){ $city = $docinfo['city']; }
  if(empty($state)){ $state = $docinfo['state']; }
  if(empty($zip)){ $zip = $docinfo['zip']; }
  if(empty($npi)){ $npi = $docinfo['npi']; }
  if(empty($medicare_npi)){ $medicare_npi = $docinfo['medicare_npi']; }
  if($docinfo['use_service_npi']==1){
    $service_npi = $docinfo['service_npi'];
    $service_practice = $docinfo['service_name'];
    $service_address = $docinfo['service_address'];
    $service_city = $docinfo['service_city'];
    $service_state = $docinfo['service_state'];
    $service_zip = $docinfo['service_zip'];
    $service_medicare_npi = $docinfo['service_medicare_npi'];
  } else {
    $service_npi = (!empty($npi) ? $npi : '');
    $service_practice = (!empty($practice) ? $practice : '');
    $service_address = (!empty($address) ? $address : '');
    $service_city = (!empty($city) ? $city : '');
    $service_state = (!empty($state) ? $state : '');
    $service_zip = (!empty($zip) ? $zip : '');
    $service_medicare_npi = (!empty($medicare_npi) ? $medicare_npi : '');
  }

  if ($service_info_a != "") {
    $service_npi = $service_info_a;
  }
?>

<html>
<head>
    <title>Health Insurance E-File Claim Form</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://eligibleapi.com/css/eligible-claim-1500-2014.min.css" />
    <link rel="stylesheet" href="/manage/css/claim_form_eligible.css?v=<?= time() ?>" />
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript" src="https://eligibleapi.com/js/eligible-claim-1500-2014.min.js"></script>
    <script type="text/javascript" src="/manage/js/claim_form_eligible.js"></script>
    <?php if (config('app.debug')) { ?>
        <link rel="stylesheet" href="/manage/css/claim-form-mock.css?v=<?= time() ?>" />
        <script type="text/javascript" src="/manage/js/claim-form-mock-data.js?v=<?= time() ?>"></script>
        <script type="text/javascript" src="/manage/js/claim-form-mock.js?v=<?= time() ?>"></script>
    <?php } ?>
    <script type="text/javascript">
        window.eligiblePublicKey = "-a7xWM5Kn7V9sciZtT4zV92dlpp_RWvnpHS-";
        var stateList = <?= json_encode(stateList()) ?>;
    </script>
</head>

<body>
    <div id="top-banner">
        <h2>E-File Claim Form</h2>
        <input type="button" onclick="change_form();" value="Switch to Paper File" style="float:right;margin-right:20px;" />
        <?php if (!empty($is_front_office)) { ?>
            <input type="button" value="Back to Insurance Page" style="float:right;"
                onclick="window.location='view_claim.php?claimid=<?= intval($_GET['insid']) ?>&pid=<?= intval($_GET['pid']) ?>'; return false;" />
        <?php } elseif ($is_back_office) { ?>
            <input type="button" value="Back to Insurance Page" style="float:right;"
                onclick="window.location='manage_claims.php'; return false;" />
            <input type="button" class="print-button" value="View Notes" style="float:right;"
                onclick="window.location='claim_notes.php?id=<?= intval($_GET['insid']) ?>&pid=<?= intval($_GET['pid']) ?>'" />
        <?php } ?>
        <ol>
            <li>Enter electronic Payer ID or Name in Box 1.</li>
            <li>Verify all claim details.</li>
            <li>Click “Submit” on bottom left of claim to e-file your claim.</li>
        </ol>
    </div>

    <?php if($is_rejected) { ?>
      <div style="clear:both;margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
        <?php
          $r_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."' ORDER BY adddate DESC LIMIT 1";

          $r = $db->getRow($r_sql);
          if($r['reference_id']){
            $w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysqli_real_escape_string($con,$r['reference_id'])."' ORDER BY adddate DESC LIMIT 1";

            $w_r = $db->getRow($w_sql);
            if($w_r['response']!=''){
        ?>
              <h3><?php echo  $w_r['event_type']; ?>
                    <?php echo  $w_r['adddate']; ?></h3>
              <?php $p = json_decode($w_r['response']); ?>
                <?php if ($p->{"acknowledgements"} != "") {
                    $ack_array = $p->{"acknowledgements"};
                    $latest = $ack_array[0];
                    ?>
                    <p>Status: <?= htmlspecialchars($latest->{"status"}); ?> <br />
                       Message: <?= htmlspecialchars($latest->{"message"}); ?>
                    </p>
                        <?php
                        }else{
                        ?>
                    <p>Category: <?= htmlspecialchars($p->{"details"}->{"codes"}->{"category_code"}); ?>
                        - <?= htmlspecialchars($p->{"details"}->{"codes"}->{"category_label"}); ?><br/>
                        Status: <?php echo htmlspecialchars($p->{"details"}->{"codes"}->{"status_code"}); ?>
                        - <?php echo htmlspecialchars($p->{"details"}->{"codes"}->{"status_label"}); ?>
                    </p>
                <?php
                }
            }
          }

        if(!$r['reference_id'] || !$w_r || !$w_r['response'] || $w_r['response']==''){
        ?>
            <h3>Claim Electronically filed on <?php echo  $r['adddate']; ?></h3>
            <?php
              $d = json_decode($r['response']);
              $success = $d->{"success"};
              if($success=="true") {
            ?>
                <p><strong>Success Response:</strong><br />
            <?php
              } else {
            ?>
                <p><strong>Error Response:</strong><br />
                  <?php
                      $errors = $d->{"errors"};
                      foreach($errors as $error){
                        echo $error->{"message"}."<br />";
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
        <h4>Secondary Claim (<a href="insurance_claim_eligible.php?insid=<?php echo $orig_claim_id; ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Primary is <?php echo $orig_claim_id; ?></a>)</h4>
<?php }else{ 
  $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='".mysqli_real_escape_string($con,(!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";
  $sec_r = $db->getRow($sec_sql);
?>
        <h4>Primary Claim
        <?php if(!empty($sec_r)){ ?>
                (<a href="insurance_claim_eligible.php?insid=<?php echo $sec_r['insuranceid']; ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&instype=2">Secondary is <?php echo $sec_r['insuranceid']; ?></a>)
        <?php } ?>
        </h4>
<?php } ?>

    <form style="clear:both;" method="post" id="claim-form"
        action="claim_handler.php?insid=<?= intval($_REQUEST['insid']) ?>&pid=<?= intval($_REQUEST['pid']) ?>">
        <div id="eligibleapi-claim-1500-form"></div>
    </form>

<script type="text/javascript">
function stateDropdown (fieldName) {
    var options = '', stateCode;

    // stateList is global
    for (stateCode in stateList) {
        options += '<option value="%code">%code - %name</option>'
            .replace(/%code/g, stateCode)
            .replace(/%name/g, stateList[stateCode]);
    }

    return '<select name="' + fieldName + '" class="input state">' + options + '</select>';
}

  $(document).ready( function(){

    // set a patient signed date
    $('.input.grayout').find('input[placeholder="date"]').val('<?php echo $patient_signed_date; ?>');

      // Replace service_facility[address][state] field with a dropdown
      $('[name="service_facility[address][state]"]').replaceWith(stateDropdown('service_facility[address][state]'));
      $('[name="billing_provider[address][state]"]').replaceWith(stateDropdown('billing_provider[address][state]'));

    <?php
      if($is_secondary) {
        $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['s_m_ins_co'])."'";
      } else {
        $inscoquery = "SELECT * FROM dental_contact WHERE contactid ='".st($pat_myarray['p_m_ins_co'])."'";
      }

      $inscoinfo = $db->getRow($inscoquery);
    ?>
      <?php if ($is_secondary) { ?>
      $('input[name="payer[id]"]').val("<?= $s_m_eligible_payer_id;?>");
      $('input[name="payer[name]"]').val("<?= $s_m_eligible_payer_name;?>");

      <?php } else { ?>

      $('input[name="payer[id]"]').val("<?= $p_m_eligible_payer_id;?>");
      $('input[name="payer[name]"]').val("<?= $p_m_eligible_payer_name;?>");

      <?php } ?>

    $('input[name="payer[address][street_line_1]"]').val("<?php echo  $inscoinfo['add1'];?>");
    $('input[name="payer[address][street_line_2]"]').val("<?php echo  $inscoinfo['add2'];?>");
    $('input[name="payer[address][city]"]').val("<?php echo  $inscoinfo['city'];?>");
    $('input[name="payer[address][state]"]').val("<?= strtoupper(trim($inscoinfo['state'])) ?>");
    $('input[name="payer[address][zip]"]').val("<?php echo  $inscoinfo['zip'];?>");
    $('input[name="code"]').val("<?php echo $claim_codes;?>");

    $('input[name="subscriber[id]"]').val("<?php echo  $insured_id_number;?>");
    $('input[name="claim[note]"]').val("<?php echo (!empty($reserved_local_use1) ? $reserved_local_use1 : '');?>");
    $('input[name="claim[date]"]').val("<?php echo (!empty($date_current) ?  dateFormat($date_current) : '');?>");
    $('select[name="claim[date_type]"]').val(<?= $current_qual ?>);
    $('input[name="claim[outside_lab_charges]"]').val("<?php echo (!empty($s_charges) ? $s_charges : '');?>");

    $('input[name="dependent[last_name]"]').val("<?php echo  $patient_lastname;?>");
    $('input[name="dependent[first_name]"]').val("<?php echo  $patient_firstname;?>");
    $('input[name="dependent[middle_name]"]').val("<?php echo  $patient_middle;?>");

    $('input[name="dependent[dob]"]').val("<?php echo date('Y-m-d', strtotime(str_replace('-','/',$patient_dob)));?>");

    $('input[name="dependent[gender]"][value="<?php echo  substr($patient_sex,0,1); ?>"]').attr("checked", "checked");
    $('input[name="dependent[address][street_line_1]"]').val("<?php echo  $patient_address;?>");
    $('input[name="dependent[address][city]"]').val("<?php echo  $patient_city;?>");
    $('input[name="dependent[address][state]"]').val("<?= strtoupper(trim($patient_state)) ?>").addClass("statemask");
    $('input[name="dependent[address][zip]"]').val("<?php echo  $patient_zip;?>").addClass("zipmask");
    $('input[name="dependent[phone_number]"]').val("<?php echo  $patient_phone_code.$patient_phone;?>").addClass("numbermask");
    <?php if($patient_relation_insured == 'Spouse' || $patient_relation_insured == '01'){ ?>
          $('input[name="dependent[relationship]"][value="01"]').trigger('click');
    <?php }elseif($patient_relation_insured == 'Child' || $patient_relation_insured == '19'){ ?>
          $('input[name="dependent[relationship]"][value="19"]').trigger('click');
    <?php }elseif($patient_relation_insured == 'Other' || $patient_relation_insured == 'G8'){ ?>
          $('input[name="dependent[relationship]"][value="G8"]').trigger('click');
    <?php } ?>
    $('input[name="subscriber[last_name]"]').val("<?= $insured_lastname;?>");
    $('input[name="subscriber[first_name]"]').val("<?= $insured_firstname;?>");
    $('input[name="subscriber[middle_name]"]').val("<?= $insured_middle;?>");
    $('input[name="subscriber[dob]"]').val("<?= date('Y-m-d', strtotime(str_replace('-','/',$insured_dob)));?>");
    $('input[name="subscriber[gender]"][value="<?= substr($insured_sex,0,1); ?>"]').attr("checked", "checked");
    $('input[name="subscriber[address][street_line_1]"]').val("<?= $insured_address;?>");
    $('input[name="subscriber[address][city]"]').val("<?= $insured_city;?>");
    $('input[name="subscriber[address][state]"]').val("<?= strtoupper(trim($insured_state)) ?>").addClass("statemask");
    $('input[name="subscriber[address][zip]"]').val("<?= $insured_zip;?>").addClass("zipmask");
    $('input[name="subscriber[phone_number]"]').val("<?= $insured_phone_code.$insured_phone;?>").addClass("numbermask");
    $('input[name="subscriber[group_id]"]').val("<?= $insured_policy_group_feca;?>");
    $('input[name="subscriber[group_name]"]').val("<?= $insured_insurance_plan;?>");


      $('input[name="other_payers[0][name]"]').val("<?= $other_insured_insurance_plan;?>");
      $('input[name="other_payers[0][subscriber][last_name]"]').val("<?= $other_insured_lastname;?>");
      $('input[name="other_payers[0][subscriber][first_name]"]').val("<?= $other_insured_firstname;?>");
      $('input[name="other_payers[0][subscriber][middle_name]"]').val("<?= $other_insured_middle;?>");
      $('input[name="other_payers[0][subscriber][group_id]"]').val("<?= $other_insured_policy_group_feca;?>");
      $('select[name="other_payers[0][responsibility_sequence]"]').val("<?php echo $responsibility_sequence ?>");

      <?php
      if (isOptionSelected($employment)) { ?>
      $('input[name="claim[related_to_employment]"][value="true"]').attr("checked", "checked");
    <?php } else { ?>
      $('input[name="claim[related_to_employment]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    <?php if (isOptionSelected($auto_accident)) { ?>
      $('input[name="claim[auto_accident]"][value="true"]').attr("checked", "checked");
    <?php } else { ?>
      $('input[name="claim[auto_accident]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    $('input[name="claim[auto_accident_state]"]').val("<?php echo  $auto_accident_place;?>");
  
    <?php if (isOptionSelected($other_accident)) { ?>
      $('input[name="claim[other_accident]"][value="true"]').attr("checked", "checked");
    <?php } else { ?>
      $('input[name="claim[other_accident]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    <?php if (isOptionSelected($another_plan)) { ?>
      $('input[name="other_payer"][value="true"]').attr("checked", "checked");
    <?php } else { ?>
      $('input[name="other_payer"][value="false"]').attr("checked", "checked");
    <?php } ?>

    $('input[name="claim[last_worked_date]"]').val("<?php echo dateFormat($unable_date_from); ?>");
    $('input[name="claim[work_return_date]"]').val("<?php echo dateFormat($unable_date_to); ?>");
    $('input[name="claim[admission_date]"]').val("<?php echo dateFormat($hospitalization_date_from); ?>");
    $('input[name="claim[discharge_date]"]').val("<?php echo dateFormat($hospitalization_date_to); ?>");

    <?php

    if (strpos($referring_provider, ',') !== false) {
        list($referring_provider_last, $referring_provider_first) = preg_split('/ *, */', $referring_provider, 2);
    } else {
        list($referring_provider_first, $referring_provider_last) = preg_split('/ +/', $referring_provider, 2);
    }

    ?>
    $('input[name="referring_provider[first_name]"]').val("<?= $referring_provider_first ?>");
    $('input[name="referring_provider[last_name]"]').val("<?= $referring_provider_last ?>");
    $('select[name="referring_provider[secondary_id_type]"]').val("<?php echo  $field_17a_dd; ?>");
    $('input[name="referring_provider[secondary_id]"]').val("<?php echo  $field_17a; ?>");
    $('input[name="referring_provider[npi]"]').val("<?php echo  $diagnosising_npi; ?>");

    <?php if (isOptionSelected($outside_lab)) { ?>
      $('input[name="claim[outside_lab]"][value="true"]').attr("checked", "checked");
    <?php }else { ?>
      $('input[name="claim[outside_lab]"][value="false"]').attr("checked", "checked");
    <?php } ?>

    $('input[name="claim[payer_control_number]"]').val("<?php echo $original_ref_no; ?>");
    $('input[name="claim[prior_authorization_number]"]').val("<?php echo $prior_authorization_number; ?>");
  <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysqli_real_escape_string($con, $diagnosis_1)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_a)){
      $diagnosis_a = $ins_diag['ins_diagnosis'];
     }
   ?>
   <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysqli_real_escape_string($con, $diagnosis_2)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_b)){
       $diagnosis_b = $ins_diag['ins_diagnosis'];
     }
   ?>
   <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysqli_real_escape_string($con, $diagnosis_3)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_c)){
       $diagnosis_c = $ins_diag['ins_diagnosis'];
     }
   ?>
   <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".mysqli_real_escape_string($con, $diagnosis_4)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_d)){
       $diagnosis_d = $ins_diag['ins_diagnosis'];
     }
   ?>

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

  if($is_pri_pending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
       . "  AND ledger.docid = " . $docid . " "
       . "  AND trxn_code.docid = " . $docid . " "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysqli_query($con, $sql);
    if ($charge_my && (mysqli_num_rows($charge_my) > 0)) {
      $charge_row = mysqli_fetch_array($charge_my);
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
       . "  ledger.primary_claim_id = '" . $orig_claim_id . "' "
       . "  AND ledger.patientid = '" . (!empty($_GET['pid']) ? $_GET['pid'] : '') . "' "
       . "  AND ledger.docid = '" . $docid . "' "
       . "  AND trxn_code.docid = '" . $docid . "' "
       . "  AND trxn_code.type = '" . DSS_TRXN_TYPE_MED . "' "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysqli_query($con, $sql);
    if ($charge_my && (mysqli_num_rows($charge_my) > 0)) {
      $charge_row = mysqli_fetch_array($charge_my);
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
       . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
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
                        where dl.docid='".$docid."' and dl.patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'
                        AND primary_claim_id='".$orig_claim_id."'
                        AND dlp.amount != 0
                        AND dlp.payer = 0
        ";
  }
  $paid_my = $db->getRow($sql);
  if (!empty($paid_my)) {
    $paid_row = $paid_my;
  }

      // Get modifier codes
      $mod_sql = "SELECT * FROM dental_modifier_code";

      $mod_my = $db->getResults($mod_sql);
      $mod_array = array();
      if ($mod_my) foreach ($mod_my as $mod_row) {
        $mod_array[] = $mod_row;
      }

  // Load pending medical trxns if new claim form. Otherwise, load associated trxns.

      $sql = "";
      if ($is_new_claim) {
        $sql = "SELECT "
             . "  ledger.*, trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_1 as modcode2, trxn_code.days_units as daysorunits, ";

        if($insurancetype == '1') {
          $sql .= " user.medicare_npi ";
        } else {
          $sql .= " user.npi ";
        }

        $sql .= " as 'provider_id', ps.place_service as 'place' "
             . "FROM "
             . "  dental_ledger ledger "
             . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
             . "  JOIN dental_users user ON user.userid = ledger.docid "
             . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
             . "  WHERE "
             . "  ledger.status = " . DSS_TRXN_PENDING . " "
             . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
             . "  AND ledger.docid = " . $docid . " "
             . "  AND trxn_code.docid = " . $docid . " "
             . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
             . "  ORDER BY "
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

        $pri_claim_id = ($is_secondary ? $orig_claim_id : $insuranceid);
        $sql .= "  as 'provider_id', ps.place_service as 'place', ps2.description AS place_description, user.first_name as provider_first_name, user.last_name as provider_last_name "
             . "FROM "
             . "  dental_ledger ledger "
             . "  JOIN dental_users user ON user.userid = ledger.docid "
             . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
             . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
             . "  LEFT JOIN dental_place_service ps2 ON ledger.placeofservice = ps2.place_service "
             . "  WHERE "
             . "  ledger.primary_claim_id = '" . $pri_claim_id . "' "
             . "  AND ledger.patientid = '" . (!empty($_GET['pid']) ? $_GET['pid'] : '') . "' "
             . "  AND ledger.docid = '" . $docid . "' "
             . "  AND trxn_code.docid = '" . $docid . "' "
             . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
             . "  ORDER BY "
             . "  ledger.service_date ASC";
      }

      $query = $db->getResults($sql);
      // Display ledger trxns
  ?>
  <?php

      /**
       * @see CS-29
       *
       * ICD-10 can be stored as "0" (paper) or "10" (e-file)
       * Since 2015-10-01, ICD-10 must be enforced
       */
      $li = 0;
      $oldestServiceDate = null;

      if ($query) foreach ($query as $array) {
        if (is_null($oldestServiceDate)) {
          $oldestServiceDate = dateToTime($array['service_date']);
        } else {
          $currentServiceDate = dateToTime($array['service_date']);
          $oldestServiceDate = $oldestServiceDate < $currentServiceDate ? $oldestServiceDate : $currentServiceDate;
        }

        $pos = ($array['placeofservice']!='')?$array['placeofservice']:$array['place'];
        $dp = ($array['diagnosispointer']!='')?$array['diagnosispointer']:1;
  ?>
        $('input[name="claim[service_lines][<?php echo $li;?>][service_date_from]"]').val("<?php echo  date('Y-m-d', strtotime($array['service_date'])); ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][service_date_to]"]').val("<?php echo  date('Y-m-d', strtotime($array['service_date'])) ?>");
        $('select[name="claim[service_lines][<?php echo $li;?>][place_of_service]"]').val("<?php echo  $pos; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][emergency]"]').val("<?php echo  $x; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_code]"]').val("<?php echo $array['transaction_code']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][0]"]').val("<?php echo  $array['modcode']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][1]"]').val("<?php echo  $array['modcode2']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][2]"]').val("<?php echo  $array['modcode3']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][3]"]').val("<?php echo  $array['modcode4']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][diagnosis_code_pointers][<?php echo $dp-1; ?>]"]').attr("checked","checked");
        $('input[name="claim[service_lines][<?php echo $li;?>][charge_amount]"]').val("<?php echo  number_format($array['amount'], 2,'.',''); ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][units]"]').val("<?php echo  $array['daysorunits']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][rendering_provider][first_name]"]').val("<?php echo  $array['provider_first_name']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][rendering_provider][last_name]"]').val("<?php echo  $array['provider_last_name']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][rendering_provider][npi]"]').val("<?php echo  $array['provider_id']; ?>");
<?php
        $li++;
      }

      // Deactivate the ledger transactions that cannot be edited
      for (;$li<6;$li++) { ?>
          $('[name="claim[service_lines][<?= $li ?>][service_date_from]"]')
              .closest('tr')
              .addClass('grayout')
              .find('input, select')
              .attr('readonly', true);
      <?php }

    /**
     * @see CS-29
     *
     * ICD-10 can be stored as "0" (paper) or "10" (e-file)
     * Since 2015-10-01, ICD-10 must be enforced
     */
    if (is_null($oldestServiceDate)) {
        $icdEnforcement = true;
    } else {
        $icdEnforcement = $oldestServiceDate >= dateToTime('2015-10-01');
    }

    // if ($icdEnforcement) {
    //     $icd_indicator = '10';
    // } else {
    //     $icd_indicator = "$icd_indicator" === '0' || "$icd_indicator" === "10" ? '10' : $icd_indicator;
    // }

    ?>
      $('input[name="claim[frequency]"][value="<?= $resubmission_code_fill ?>"]').click();
      // ICD Indicator: <?= $icd_indicator ?> .
      $('input[name="claim[icd_indicator]"]').val("<?= $icd_indicator ?>").addClass('numbermask');

  <?php if ($rendering_provider_first_name_1 != "") { ?>
      <?php if ($rendering_provider_entity_1){ ?>
      $('input[name="claim[service_lines][0][rendering_provider][entity]"][value="true"]').trigger('click');
      <?php } else { ?>
      $('input[name="claim[service_lines][0][rendering_provider][entity]"][value=""]').prop("checked", true);
      <?php } ?>
      $('input[name="claim[service_lines][0][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_1; ?>");
      $('input[name="claim[service_lines][0][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_1;  ?>");
      $('input[name="claim[service_lines][0][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_1;  ?>");
      $('input[name="claim[service_lines][0][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_1;  ?>");
      $('input[name="claim[service_lines][0][units]"]').val("<?php echo $days_or_units1;  ?>");
      <?php if ($rendering_provider_entity_2){ ?>
      $('input[name="claim[service_lines][1][rendering_provider][entity]"][value="true"]').trigger('click');
      <?php } else { ?>
      $('input[name="claim[service_lines][1][rendering_provider][entity]"][value=""]').prop("checked", true);
      <?php } ?>
      $('input[name="claim[service_lines][1][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_2; ?>");
      $('input[name="claim[service_lines][1][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_2;  ?>");
      $('input[name="claim[service_lines][1][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_2;  ?>");
      $('input[name="claim[service_lines][1][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_2;  ?>");
      $('input[name="claim[service_lines][1][units]"]').val("<?php echo $days_or_units2;  ?>");
      <?php if ($rendering_provider_entity_3){ ?>
      $('input[name="claim[service_lines][2][rendering_provider][entity]"][value="true"]').trigger('click');
      <?php } else { ?>
      $('input[name="claim[service_lines][2][rendering_provider][entity]"][value=""]').prop("checked", true);
      <?php } ?>
      $('input[name="claim[service_lines][2][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_3; ?>");
      $('input[name="claim[service_lines][2][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_3;  ?>");
      $('input[name="claim[service_lines][2][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_3;  ?>");
      $('input[name="claim[service_lines][2][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_3;  ?>");
      $('input[name="claim[service_lines][2][units]"]').val("<?php echo $days_or_units3;  ?>");
      <?php if ($rendering_provider_entity_4){ ?>
      $('input[name="claim[service_lines][3][rendering_provider][entity]"][value="true"]').trigger('click');
      <?php } else { ?>
      $('input[name="claim[service_lines][3][rendering_provider][entity]"][value=""]').prop("checked", true);
      <?php } ?>
      $('input[name="claim[service_lines][3][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_4; ?>");
      $('input[name="claim[service_lines][3][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_4;  ?>");
      $('input[name="claim[service_lines][3][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_4;  ?>");
      $('input[name="claim[service_lines][3][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_4;  ?>");
      $('input[name="claim[service_lines][3][units]"]').val("<?php echo $days_or_units4;  ?>");
      <?php if ($rendering_provider_entity_5){ ?>
      $('input[name="claim[service_lines][4][rendering_provider][entity]"][value="true"]').trigger('click');
      <?php } else { ?>
      $('input[name="claim[service_lines][4][rendering_provider][entity]"][value=""]').prop("checked", true);
      <?php } ?>
      $('input[name="claim[service_lines][4][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_5; ?>");
      $('input[name="claim[service_lines][4][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_5;  ?>");
      $('input[name="claim[service_lines][4][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_5;  ?>");
      $('input[name="claim[service_lines][4][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_5;  ?>");
      $('input[name="claim[service_lines][4][units]"]').val("<?php echo $days_or_units5;  ?>");
      <?php if ($rendering_provider_entity_6){ ?>
      $('input[name="claim[service_lines][5][rendering_provider][entity]"][value="true"]').trigger('click');
      <?php } else { ?>
      $('input[name="claim[service_lines][5][rendering_provider][entity]"][value=""]').prop("checked", true);
      <?php } ?>
      $('input[name="claim[service_lines][5][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_6; ?>");
      $('input[name="claim[service_lines][5][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_6;  ?>");
      $('input[name="claim[service_lines][5][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_6;  ?>");
      $('input[name="claim[service_lines][5][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_6;  ?>");
      $('input[name="claim[service_lines][5][units]"]').val("<?php echo $days_or_units6; ?>");
      <?php
}

  if($accept_assignment=="Yes" || $accept_assignment == "A"){ ?>
        $('input[name="claim[accept_assignment_code]"][value="A"]').prop("checked", true);
      <?php }elseif($accept_assignment=="No" || $accept_assignment == "C"){ ?>
        $('input[name="claim[accept_assignment_code]"][value="C"]').prop("checked", true);
      <?php } ?>

      $('input[name="billing_provider[tax_id]"]').val("<?= $federal_tax_id_number ?>");
     
      <?php if($ssn=="1") { ?>
        $('input[name="billing_provider[tax_id_type]"][value="SY"]').attr("checked", "checked"); 
      <?php } elseif($ein == "1") { ?>
        $('input[name="billing_provider[tax_id_type]"][value="EI"]').attr("checked", "checked"); 
      <?php } ?>

      $('input[name="billing_provider[entity]"][value="true"]').click();
      $('input[name="service_facility[name]"]').val("<?= $service_facility_info_name ?>");
      $('input[name="service_facility[address][street_line_1]"]').val("<?= $service_facility_info_address ?>");
      $('input[name="service_facility[address][city]"]').val("<?= $service_facility_info['city'] ?>");
      $('[name="service_facility[address][state]"]').val("<?= $service_facility_info['stateCode'] ?>");
      $('input[name="service_facility[address][zip]"]').val("<?= $service_facility_info['zip'] ?>").addClass("zipmask");
      $('input[name="service_facility[npi]"]').val("<?= $service_info_a ?>");
      $('input[name="billing_provider[phone_number]"]').val("<?= $billing_provider_phone_code.$billing_provider_phone ?>").addClass("numbermask");
      $('input[name="billing_provider[organization_name]"]').val("<?= $billing_provider_name ?>");
      $('input[name="billing_provider[address][street_line_1]"]').val("<?= $billing_provider_address ?>");
      $('input[name="billing_provider[address][city]"]').val("<?= $billing_provider_info['city'] ?>");
      $('[name="billing_provider[address][state]"]').val("<?= $billing_provider_info['stateCode'] ?>");
      $('input[name="billing_provider[address][zip]"]').val("<?= $billing_provider_info['zip'] ?>").addClass("zipmask");
      $('input[name="billing_provider[npi]"]').val("<?= $billing_provider_a ?>");
      $('input[name="billing_provider[taxonomy_code]"]').val("332B00000X");
      <?php if ($insured_signature): ?>
        $('input[name="claim[direct_payment_authorized]"]').prop('checked',true);
      <?php else: ?>
        $('input[name="claim[direct_payment_authorized]"]').prop('checked',false);
      <?php endif; ?>

<?php
      $total_charge = (empty($total_charge)) ? 0.00 : $total_charge;
      $amount_paid = (empty($amount_paid)) ? 0.00 : number_format($amount_paid, 2);

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
             . "  AND ledger.primary_claim_id = '" . $insuranceid . "' "
           . "  AND ledger.patientid = '" . (!empty($_GET['pid']) ? $_GET['pid'] : '') . "' "
           . "  AND ledger.docid = '" . $docid . "' "
           . "  AND trxn_code.docid = '" . $docid . "' "
           . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
           . "ORDER BY "
           . "  ledger.service_date ASC";

          $charge_my = $db->getResults($sql);
          if (($charge_my !== false) && (count($charge_my) > 0)) {
            $charge_row = $charge_my[0];
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
             . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
             . "  AND ledger.docid = " . $docid . " "
             . "  AND trxn_code.docid = " . $docid . " "
             . "  AND trxn_code.type IN (" . DSS_TRXN_TYPE_PATIENT . "," . DSS_TRXN_TYPE_INS . "," . DSS_TRXN_TYPE_ADJ . ") "
             . "ORDER BY "
             . "  ledger.service_date ASC";

        if($is_secondary && $status == DSS_CLAIM_SEC_PENDING) {
          $sql = "SELECT sum(dlp.amount) as amount_paid
                  from dental_ledger dl
                  LEFT JOIN dental_users p ON dl.producerid=p.userid
                  LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                  where dl.docid='".$docid."' and dl.patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'
                  AND primary_claim_id='".(!empty($_GET['insid']) ? $_GET['insid'] : '')."'
                  AND dlp.amount != 0
                  AND dlp.payer = 0";
        }

        $paid_my = $db->getResults($sql);
        if (($paid_my !== false) && (count($paid_my) > 0)) {
          $paid_row = $paid_my[0];
        }

        // format calculations
        $total_charge = number_format($total_charge, 2, '.','');
      }
?>
      $('input[name="claim[total_charge]"]').val("<?php echo  $total_charge; ?>");
      $('input[name="claim[patient_amount_paid]"]').val("<?php echo  $amount_paid; ?>");
      $('input[name="claim[patient_signature_on_file]"]').prop('checked', <?= isOptionSelected($patient_signature) ? 'true' : 'false' ?>);
      $('input[name="claim[provider_signature_on_file]"]').prop('checked', <?= isOptionSelected($signature_physician) ? 'true' : 'false' ?>);
      $('input[name="claim[signature_date]"]').val("<?php echo dateFormat($physician_signed_date); ?>");
      $('input').each( function(){
        // $(this).val($(this).val().toUpperCase());
      });
      $('input, select').bind('change', function(){
          form_changed=true;
      });

      // No DB columns for these fields
      $('\
          [name="dependent[address][street_line_2]"],\
          [name="subscriber[address][street_line_2]"],\
          [name="referring_provider[middle_name]"],\
          [name="service_facility[address][street_line_2]"],\
          [name="billing_provider[address][street_line_2]"]\
      ')
          .attr('readonly', true)
          .addClass('grayout')
          .closest('td')
          .addClass('grayout');
  });

  $(".date_field").keydown(function(e){
      var key = e.charCode || e.keyCode || 0;

      // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
      return (
          key == 8 ||
              key == 9 ||
              key == 46 ||
              key == 189 ||
              key == 191 ||
              (key >= 37 && key <= 40) ||
              (key >= 48 && key <= 57) ||
              (key >= 96 && key <= 105));
  });
  $(".number_field").keydown(function(e){
      var key = e.charCode || e.keyCode || 0;

      // allow backspace, tab, delete, numbers and keypad numbers ONLY
      return (
          key == 8 ||
              key == 9 ||
              key == 46 ||
              key == 110 ||
              key == 190 ||
              (key >= 48 && key <= 57) ||
              (key >= 96 && key <= 105));
  });

  function file_reject_claim(){
      if($('#p_m_ins_payer_id').val()==""){
          alert('Insurance payer must be selected to electronically file claim.');
          return false;
      }
      c = confirm('You are about to resubmit a rejected claim. Please make sure you have corrected all errors, then click OK to resend the claim.');
      return c;
  }
  function file_claim(){
      if($('#p_m_ins_payer_id').val()==""){
          alert('Insurance payer must be selected to electronically file claim.');
          return false;
      }
      c = confirm('You are about to electronically submit this claim, are you sure?');
      return c;
  }

  function change_form(){
      if(form_changed){
          if(confirm('Your changes to this claim will be lost if you change to electronic submission. Click \'Ok\' to proceed or \'Cancel\' to return to paper form.')){
              window.location = "<?= $v2_form ?>";
          }
      }else{
          window.location = "<?= $v2_form ?>";
      }
      return false;
  }
  form_changed=false;

</script>

  <div id="change_confirm" style="display:none;top:0;height:100%;background:#fff; position:fixed; top:20px; width:100%; opacity:90%;">
    <p>MESSAGE</p>
    <input type="button" value="Save" />
    <input type="button" onclick="window.location='<?php echo  $v2_form; ?>';" value="Don't Save" />
    <input type="button" onclick="$('#change_confirm').hide();" value="Cancel" />
  </div>

</body>
</html>
