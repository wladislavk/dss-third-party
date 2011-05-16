function validatePreAuthForm(form) {
  var errorMsg = '';
  
  if (trim(form.ins_co.value) == "") {
    errorMsg += "- Missing Patient's Insurance Company\n";
  }
  
  if (trim(form.ins_phone.value) == "") {
    errorMsg += "- Missing Insurance Company's Phone #\n";
  }
  
  if (trim(form.patient_firstname.value) == "") {
    errorMsg += "- Missing Patient's First Name\n";
  }
  
  if (trim(form.patient_lastname.value) == "") {
    errorMsg += "- Missing Patient's Last Name\n";
  }
  
  if (trim(form.patient_add1.value) == "") {
    errorMsg += "- Missing Patient's Address\n";
  }

  if (trim(form.patient_city.value) == "") {
    errorMsg += "- Missing Patient's City\n";
  }
  
  if (trim(form.patient_state.value) == "") {
    errorMsg += "- Missing Patient's State\n";
  }
  
  if (trim(form.patient_zip.value) == "") {
    errorMsg += "- Missing Patient's Zip\n";
  }
  
  if (trim(form.insured_first_name.value) == "") {
    errorMsg += "- Missing Insured's First Name\n";
  }
  
  if (trim(form.insured_last_name.value) == "") {
    errorMsg += "- Missing Insured's Last Name\n";
  }
  
  if (trim(form.insured_dob.value) == "") {
    errorMsg += "- Missing Insured's DOB\n";
  }
  
  if (trim(form.patient_ins_group_id.value) == "") {
    errorMsg += "- Missing Patient's Group Insurance #\n";
  }
  
  if (trim(form.patient_ins_id.value) == "") {
    errorMsg += "- Missing Patient's Insurance ID #\n";
  }
  
  if (trim(form.patient_dob.value) == "") {
    errorMsg += "- Missing Patient's DOB\n";
  }
  
  if (trim(form.doc_npi.value) == "") {
    errorMsg += "- Missing Franchisee's NPI Number\n";
  }
  
  if (trim(form.doc_medicare_npi.value) == "") {
    errorMsg += "- Missing Franchisee's Medicare NPI Number\n";
  }
  
  if (trim(form.doc_tax_id_or_ssn.value) == "") {
    errorMsg += "- Missing Franchisee's Tax ID or SSN\n";
  }
  
  if (trim(form.trxn_code_amount.value) == "") {
    errorMsg += "- Missing Franchisee's Code E0486 Amount\n";
  }
  
  if (trim(form.diagnosis_code.value) == "") {
    errorMsg += "- Missing Patient's Diagnosis Code from Page 2 of Sleep Test Questionnaire\n";
  }
  
  if (trim(form.date_of_call.value) == "") {
    errorMsg += "- Missing Date of Call\n";
  }
  
  if (trim(form.insurance_rep.value) == "") {
    errorMsg += "- Missing Name of Insurance Representative\n";
  }
  
  if (trim(form.call_reference_num.value) == "") {
    errorMsg += "- Missing Call Reference Number\n";
  }
  
  if (trim(form.ins_effective_date.value) == "") {
    errorMsg += "- Missing Insurance Effective Date\n";
  }
  
  if (trim(form.ins_cal_year_start.value) == "") {
    errorMsg += "- Missing Insurance Calendar Year Start\n";
  }
  
  if (trim(form.ins_cal_year_end.value) == "") {
    errorMsg += "- Missing Insurance Calendar Year End\n";
  }
  
  if (errorMsg != '') {
    alert(errorMsg);
  }
  
  return (errorMsg == '');
}
