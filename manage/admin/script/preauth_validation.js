function validateDate(dtControl) {
    var input = document.getElementById(dtControl)
    var validformat=/^\d{1,2}\/\d{1,2}\/\d{4}$/ //Basic check for format validity
    var returnval=false
    if (!validformat.test(input.value))
    alert('Invalid Day, Month, or Year range detected. Please correct. Must be xx/xx/xxxx');
    else{ //Detailed check for valid date ranges
    var monthfield=input.value.split("/")[0]
    var dayfield=input.value.split("/")[1]
    var yearfield=input.value.split("/")[2]
    var dayobj = new Date(yearfield, monthfield-1, dayfield)
    if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
    alert('Invalid Day, Month, or Year range detected. Please correct. Must be xx/xx/xxxx')
    else
    {
        returnval=true
    }
    }
    
    if (!validformat.test(input.value)){
    document.getElementById(dtControl).focus;
    }
    if (returnval==false){ input.focus() }
    return returnval
    focusIt(dtControl);
}

function validatePreAuthForm(form) {
  var errorMsg = '';
  
  if (form.complete.checked) {
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
    
    if (trim(form.patient_phone.value) == "") {
      errorMsg += "- Missing Patient's Phone #\n";
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
      errorMsg += "- Missing Patient's Diagnosis Code from Page 3 of Sleep Test Questionnaire\n";
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
    
    if (trim(form.how_often.value) == "") {
      errorMsg += "- Missing How Often You Will Pay for Another Device\n";
    }
    
    if (trim(form.patient_deductible.value) == "") {
      errorMsg += "- Missing Patient Deductible\n";
    }
    
    if (trim(form.patient_amount_met.value) == "") {
      errorMsg += "- Missing Patient Amount Met\n";
    }
    
    if (trim(form.patient_amount_left_to_meet.value) == "") {
      errorMsg += "- Missing Patient Amount Left to Meet\n";
    }
    
    if (trim(form.family_deductible.value) == "") {
      errorMsg += "- Missing Family Deductible\n";
    }
    
    if (trim(form.family_amount_met.value) == "") {
      errorMsg += "- Missing Family Amount Met\n";
    }
    
    if (trim(form.deductible_reset_date.value) == "") {
      errorMsg += "- Missing Deductible Reset Date\n";
    }
    
    if (trim(form.trxn_code_amount.value) == "") {
      errorMsg += "- Missing Device Amount\n";
    }
    
    if (trim(form.expected_insurance_payment.value) == "") {
      errorMsg += "- Missing Expected Insurance Payment\n";
    }
    
    if (trim(form.expected_patient_payment.value) == "") {
      errorMsg += "- Missing Expected Patient Payment\n";
    }
  }
  
  if (errorMsg != '') {
    alert(errorMsg);
  }
  
  return (errorMsg == '');
}
