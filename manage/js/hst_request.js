function check_fields(f){
  var errors= new Array();
  if(f.patient_firstname.value==''){
    errors.push('First Name');
  }
  if(f.patient_lastname.value==''){
    errors.push('Last Name');
  }
  if(f.patient_dob.value==''){
    errors.push('DOB');
  }
  if(f.patient_add1.value=='' || f.patient_city.value=='' || f.patient_state.value=='' || f.patient_zip.value==''){
    errors.push('Address');
  }
  if($('input[name=diagnosis_id]:checked').size() == 0){
    errors.push('Diagnosis');
  }
  if($('input[name=hst_type]:checked').size() == 0){
    errors.push('Home Sleep Diagnostic Testing');
  }
  if(f.provider_firstname.value==''){
    errors.push('Provider First Name');
  }
  if(f.provider_lastname.value==''){
    errors.push('Provider Last Name');
  }
  if(f.provider_phone.value==''){
    errors.push('Provider Phone');
  }
  if(f.provider_address.value=='' || f.provider_city.value=='' || f.provider_state.value=='' || f.provider_zip.value==''){
    errors.push('Provider Address');
  }

  if(errors.length > 0){
    var a = "Following fields must be entered.\n"; 
    for (var i = 0; i < errors.length; i++) {
      a += errors[i]+"\n";
    } 
    alert(a);
    return false;
  }
  return true;
}