<?php

//inserts row into dental_insurance_history
function claim_history_update($insid, $userid, $adminid){
  $sql = "INSERT INTO dental_insurance_history(
    insuranceid,
    formid,
    patientid,
    pica1,
    pica2,
    pica3,
    insurance_type,
    insured_id_number,
    patient_firstname,
    patient_lastname,
    patient_middle,
    patient_dob,
    patient_sex,
    insured_firstname,
    insured_lastname,
    insured_middle,
    patient_address,
    patient_relation_insured,
    insured_address,
    patient_city,
    patient_state,
    patient_status,
    insured_city,
    insured_state,
    patient_zip,
    patient_phone_code,
    patient_phone,
    insured_zip,
    insured_phone_code,
    insured_phone,
    other_insured_firstname,
    other_insured_lastname,
    other_insured_middle,
    employment,
    auto_accident,
    auto_accident_place,
    other_accident,
    insured_policy_group_feca,
    other_insured_policy_group_feca,
    insured_dob,
    insured_sex,
    other_insured_dob,
    other_insured_sex,
    insured_employer_school_name,
    other_insured_employer_school_name,
    insured_insurance_plan,
    other_insured_insurance_plan,
    reserved_local_use,
    another_plan,
    patient_signature,
    patient_signed_date,
    insured_signature,
    date_current,
    date_same_illness,
    unable_date_from,
    unable_date_to,
    referring_provider,
    field_17a_dd,
    field_17a,
    field_17b,
    hospitalization_date_from,
    hospitalization_date_to,
    reserved_local_use1,
    outside_lab,
    s_charges,
    diagnosis_1,
    diagnosis_2,
    diagnosis_3,
    diagnosis_4,
    medicaid_resubmission_code,
    original_ref_no,
    prior_authorization_number,
    service_date1_from,
    service_date1_to,
    place_of_service1,
    emg1,
    cpt_hcpcs1,
    modifier1_1,
    modifier1_2,
    modifier1_3,
    modifier1_4,
    diagnosis_pointer1,
    s_charges1_1,
    s_charges1_2,
    days_or_units1,
    epsdt_family_plan1,
    id_qua1,
    rendering_provider_id1,
    service_date2_from,
    service_date2_to,
    place_of_service2,
    emg2,
    cpt_hcpcs2,
    modifier2_1,
    modifier2_2,
    modifier2_3,
    modifier2_4,
    diagnosis_pointer2,
    s_charges2_1,
    s_charges2_2,
    days_or_units2,
    epsdt_family_plan2,
    id_qua2,
    rendering_provider_id2,
    service_date3_from,
    service_date3_to,
    place_of_service3,
    emg3,
    cpt_hcpcs3,
    modifier3_1,
    modifier3_2,
    modifier3_3,
    modifier3_4,
    diagnosis_pointer3,
    s_charges3_1,
    s_charges3_2,
    days_or_units3,
    epsdt_family_plan3,
    id_qua3,
    rendering_provider_id3,
    service_date4_from,
    service_date4_to,
    place_of_service4,
    emg4,
    cpt_hcpcs4,
    modifier4_1,
    modifier4_2,
    modifier4_3,
    modifier4_4,
    diagnosis_pointer4,
    s_charges4_1,
    s_charges4_2,
    days_or_units4,
    epsdt_family_plan4,
    id_qua4,
    rendering_provider_id4,
    service_date5_from,
    service_date5_to,
    place_of_service5,
    emg5,
    cpt_hcpcs5,
    modifier5_1,
    modifier5_2,
    modifier5_3,
    modifier5_4,
    diagnosis_pointer5,
    s_charges5_1,
    s_charges5_2,
    days_or_units5,
    epsdt_family_plan5,
    id_qua5,
    rendering_provider_id5,
    service_date6_from,
    service_date6_to,
    place_of_service6,
    emg6,
    cpt_hcpcs6,
    modifier6_1,
    modifier6_2,
    modifier6_3,
    modifier6_4,
    diagnosis_pointer6,
    s_charges6_1,
    s_charges6_2,
    days_or_units6,
    epsdt_family_plan6,
    id_qua6,
    rendering_provider_id6,
    federal_tax_id_number,
    ssn,
    ein,
    patient_account_no,
    accept_assignment,
    total_charge,
    amount_paid,
    balance_due,
    signature_physician,
    physician_signed_date,
    service_facility_info_name,
    service_facility_info_address,
    service_facility_info_city,
    service_info_a,
    service_info_dd,
    service_info_b_other,
    billing_provider_phone_code,
    billing_provider_phone,
    billing_provider_name,
    billing_provider_address,
    billing_provider_city,
    billing_provider_a,
    billing_provider_dd,
    billing_provider_b_other,
    userid,
    docid,
    status,
    card,
    adddate,
    ip_address,
    dispute_reason,
    sec_dispute_reason,
    reject_reason,
    primary_fdf,
    secondary_fdf,
    producer,
    mailed_date,
    eligible_response,
    p_m_eligible_payer_id,
    p_m_eligible_payer_name,
    sec_mailed_date,
    other_insurance_type,
    patient_relation_other_insured,
    p_m_billing_id,
    p_m_dss_file,
    s_m_billing_id,
    s_m_dss_file,
    other_insured_address,
    other_insured_city,
    other_insured_state,
    other_insured_zip,
    nucc_8a,
    nucc_8b,
    nucc_9b,
    nucc_9c,
    nucc_10d,
    other_claim_id,
    icd_ind,
    resubmission_code_fill,
    name_referring_provider_qualifier,
    diagnosis_a,
    diagnosis_b,
    diagnosis_c,
    diagnosis_d,
    diagnosis_e,
    diagnosis_f,
    diagnosis_g,
    diagnosis_h,
    diagnosis_i,
    diagnosis_j,
    diagnosis_k,
    diagnosis_l,
    claim_codes,
    nucc_9a,
    nucc_30,
    primary_claim_version,
    secondary_claim_version,
    eligible_token,
    percase_date,
    percase_name,
    percase_amount,
    percase_status,
    percase_invoice,
    primary_claim_id,
    updated_by_user,
    updated_by_admin,
    updated_at
		)
		SELECT 
      insuranceid,
      formid,
      patientid,
      pica1,
      pica2,
      pica3,
      insurance_type,
      insured_id_number,
      patient_firstname,
      patient_lastname,
      patient_middle,
      patient_dob,
      patient_sex,
      insured_firstname,
      insured_lastname,
      insured_middle,
      patient_address,
      patient_relation_insured,
      insured_address,
      patient_city,
      patient_state,
      patient_status,
      insured_city,
      insured_state,
      patient_zip,
      patient_phone_code,
      patient_phone,
      insured_zip,
      insured_phone_code,
      insured_phone,
      other_insured_firstname,
      other_insured_lastname,
      other_insured_middle,
      employment,
      auto_accident,
      auto_accident_place,
      other_accident,
      insured_policy_group_feca,
      other_insured_policy_group_feca,
      insured_dob,
      insured_sex,
      other_insured_dob,
      other_insured_sex,
      insured_employer_school_name,
      other_insured_employer_school_name,
      insured_insurance_plan,
      other_insured_insurance_plan,
      reserved_local_use,
      another_plan,
      patient_signature,
      patient_signed_date,
      insured_signature,
      date_current,
      date_same_illness,
      unable_date_from,
      unable_date_to,
      referring_provider,
      field_17a_dd,
      field_17a,
      field_17b,
      hospitalization_date_from,
      hospitalization_date_to,
      reserved_local_use1,
      outside_lab,
      s_charges,
      diagnosis_1,
      diagnosis_2,
      diagnosis_3,
      diagnosis_4,
      medicaid_resubmission_code,
      original_ref_no,
      prior_authorization_number,
      service_date1_from,
      service_date1_to,
      place_of_service1,
      emg1,
      cpt_hcpcs1,
      modifier1_1,
      modifier1_2,
      modifier1_3,
      modifier1_4,
      diagnosis_pointer1,
      s_charges1_1,
      s_charges1_2,
      days_or_units1,
      epsdt_family_plan1,
      id_qua1,
      rendering_provider_id1,
      service_date2_from,
      service_date2_to,
      place_of_service2,
      emg2,
      cpt_hcpcs2,
      modifier2_1,
      modifier2_2,
      modifier2_3,
      modifier2_4,
      diagnosis_pointer2,
      s_charges2_1,
      s_charges2_2,
      days_or_units2,
      epsdt_family_plan2,
      id_qua2,
      rendering_provider_id2,
      service_date3_from,
      service_date3_to,
      place_of_service3,
      emg3,
      cpt_hcpcs3,
      modifier3_1,
      modifier3_2,
      modifier3_3,
      modifier3_4,
      diagnosis_pointer3,
      s_charges3_1,
      s_charges3_2,
      days_or_units3,
      epsdt_family_plan3,
      id_qua3,
      rendering_provider_id3,
      service_date4_from,
      service_date4_to,
      place_of_service4,
      emg4,
      cpt_hcpcs4,
      modifier4_1,
      modifier4_2,
      modifier4_3,
      modifier4_4,
      diagnosis_pointer4,
      s_charges4_1,
      s_charges4_2,
      days_or_units4,
      epsdt_family_plan4,
      id_qua4,
      rendering_provider_id4,
      service_date5_from,
      service_date5_to,
      place_of_service5,
      emg5,
      cpt_hcpcs5,
      modifier5_1,
      modifier5_2,
      modifier5_3,
      modifier5_4,
      diagnosis_pointer5,
      s_charges5_1,
      s_charges5_2,
      days_or_units5,
      epsdt_family_plan5,
      id_qua5,
      rendering_provider_id5,
      service_date6_from,
      service_date6_to,
      place_of_service6,
      emg6,
      cpt_hcpcs6,
      modifier6_1,
      modifier6_2,
      modifier6_3,
      modifier6_4,
      diagnosis_pointer6,
      s_charges6_1,
      s_charges6_2,
      days_or_units6,
      epsdt_family_plan6,
      id_qua6,
      rendering_provider_id6,
      federal_tax_id_number,
      ssn,
      ein,
      patient_account_no,
      accept_assignment,
      total_charge,
      amount_paid,
      balance_due,
      signature_physician,
      physician_signed_date,
      service_facility_info_name,
      service_facility_info_address,
      service_facility_info_city,
      service_info_a,
      service_info_dd,
      service_info_b_other,
      billing_provider_phone_code,
      billing_provider_phone,
      billing_provider_name,
      billing_provider_address,
      billing_provider_city,
      billing_provider_a,
      billing_provider_dd,
      billing_provider_b_other,
      userid,
      docid,
      status,
      card,
      adddate,
      ip_address,
      dispute_reason,
      sec_dispute_reason,
      reject_reason,
      primary_fdf,
      secondary_fdf,
      producer,
      mailed_date,
      eligible_response,
      p_m_eligible_payer_id,
      p_m_eligible_payer_name,
      sec_mailed_date,
      other_insurance_type,
      patient_relation_other_insured,
      p_m_billing_id,
      p_m_dss_file,
      s_m_billing_id,
      s_m_dss_file,
      other_insured_address,
      other_insured_city,
      other_insured_state,
      other_insured_zip,
      nucc_8a,
      nucc_8b,
      nucc_9b,
      nucc_9c,
      nucc_10d,
      other_claim_id,
      icd_ind,
      resubmission_code_fill,
      name_referring_provider_qualifier,
      diagnosis_a,
      diagnosis_b,
      diagnosis_c,
      diagnosis_d,
      diagnosis_e,
      diagnosis_f,
      diagnosis_g,
      diagnosis_h,
      diagnosis_i,
      diagnosis_j,
      diagnosis_k,
      diagnosis_l,
      claim_codes,
      nucc_9a,
      nucc_30,
      primary_claim_version,
      secondary_claim_version,
      eligible_token,
      percase_date,
      percase_name,
      percase_amount,
      percase_status,
      percase_invoice,
      primary_claim_id,
     '".mysql_real_escape_string($userid)."','".mysql_real_escape_string($adminid)."', now()
    			FROM dental_insurance i
    			WHERE i.insuranceid='".mysql_real_escape_string($insid)."'";

  $hid = $db->getInsertId($sql);
  $sql = "INSERT INTO dental_ledger_history(
    ledgerid,
    formid,
    patientid,
    service_date,
    entry_date,
    description,
    producer,
    amount,
    transaction_type,
    paid_amount,
    userid,
    docid,
    status,
    adddate,
    ip_address,
    transaction_code,
    placeofservice,
    emg,
    diagnosispointer,
    daysorunits,
    epsdt,
    idqual,
    modcode,
    producerid,
    primary_claim_id,
    primary_paper_claim_id,
    modcode2,
    modcode3,
    modcode4,
    percase_date,
    percase_name,
    percase_amount,
    percase_invoice,
    percase_status,
    percase_free,
    primary_claim_history_id,
    updated_by_user,
    updated_by_admin,
    updated_at
    )
    SELECT 
      ledgerid,
      formid,
      patientid,
      service_date,
      entry_date,
      description,
      producer,
      amount,
      transaction_type,
      paid_amount,
      userid,
      docid,
      status,
      adddate,
      ip_address,
      transaction_code,
      placeofservice,
      emg,
      diagnosispointer,
      daysorunits,
      epsdt,
      idqual,
      modcode,
      producerid,
      primary_claim_id,
      primary_paper_claim_id,
      modcode2,
      modcode3,
      modcode4,
      percase_date,
      percase_name,
      percase_amount,
      percase_invoice,
      percase_status,
      percase_free, 
      '".$hid."',
      '".mysql_real_escape_string($userid)."','".mysql_real_escape_string($adminid)."', now()
                        FROM dental_ledger l
                        WHERE l.primary_claim_id='".mysql_real_escape_string($insid)."'";

  $db->query($sql);
  return $hid;
}