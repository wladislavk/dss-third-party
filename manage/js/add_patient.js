var clickedBut;
var existingPatient = patientId = getParameterByName('pid');

$(document).ready(function() {

  var pid = getParameterByName('pid');
  var insurance_nums = [];
  $(':input:not(#patient_search)').change(function() { 
    window.onbeforeunload = confirmExit;
  });

  $('#patientfrm').submit(function() {
    window.onbeforeunload = null;
  });

  $('input,select').keypress(function(event) {
    return event.keyCode != 13; 
  });

  updateNumber('p_m_ins_phone');
  updateNumber2('s_m_ins_phone');

  $('#patientfrm :submit').click(function() { 
    clickedBut = $(this).attr("name");  
  }); 
  setup_autocomplete('referredby_name', 'referredby_hints', 'referred_by', 'referred_source', 'list_referrers.php', 'referrer', pid);
  setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'p_m_eligible_payer', '', 'https://eligibleapi.com/resources/payers/claims/medical.json', 'ins_payer');
  setup_autocomplete_local('s_m_ins_payer_name', 's_m_ins_payer_hints', 's_m_eligible_payer', '', 'https://eligibleapi.com/resources/payers/claims/medical.json', 's_m_ins_payer');
  setup_autocomplete('docpcp_name', 'docpcp_hints', 'docpcp', '', 'list_contacts.php');
  setup_autocomplete('docent_name', 'docent_hints', 'docent', '', 'list_contacts.php');
  setup_autocomplete('docsleep_name', 'docsleep_hints', 'docsleep', '', 'list_contacts.php', 'contact', pid);
  setup_autocomplete('docdentist_name', 'docdentist_hints', 'docdentist', '', 'list_contacts.php', 'contact', pid);
  setup_autocomplete('docmdother_name', 'docmdother_hints', 'docmdother', '', 'list_contacts.php', 'contact', pid);
  setup_autocomplete('docmdother2_name', 'docmdother2_hints', 'docmdother2', '', 'list_contacts.php', 'contact', pid);
  setup_autocomplete('docmdother3_name', 'docmdother3_hints', 'docmdother3', '', 'list_contacts.php', 'contact', pid);

  var cal1 = new calendar2(document.getElementById('ins_dob'));
  var cal2 = new calendar2(document.getElementById('ins2_dob'));
  var cal3 = new calendar2(document.getElementById('dob'));
  var cal4 = new calendar2(document.getElementById('copyreqdate'));

  $('.dss_file_radio').click(function(){
    if($('#p_m_dss_file_no').is(':checked') && $('#s_m_dss_file_yes').is(':checked')){
      alert(billing_co + ' must file Primary Insurance in order to file Secondary Insurance.');
      return false;
    } 
    if($('#p_m_dss_file_yes').is(':checked') && $('#s_m_dss_file_no').is(':checked')){
      return confirm('You indicated that ' + billing_co + ' will file Primary insurance claims but NOT Secondary insurance claims. Normally patients expect claims to be filed in both cases; please select "Yes" for Secondary unless you are sure of your choice.');
    } 
  });

  $('.pay_to_patient_radio').click(function(){
    return confirm('Selecting "Payment to Patient" means NO payment will go to your office (payment will be mailed to patient). Select "Accept Assignment of Benefits" to have the insurance check go to your office instead. "Accept Assignment" is recommended in nearly all cases, so make sure you choose correctly.');
  });

  if (getParameterByName('sendPin')) {
    loadPopupWithClose('patient_access_code.php?pid=' + patientId, 'add_patient.php?ed=' + existingPatient + '&preview=1&addtopat=1&pid=' + patientId);
  }
});

function confirmExit(){
  return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
}

function remove_notification(id){
  $.ajax({
    url: 'includes/notifications_remove.php',
    type: 'post',
    data: 'id='+id,
    success: function( data ) {
      var r = $.parseJSON(data);
      if(r.success){
         $('#not_'+id).hide('slow');
      }else{
        //alert('Error');
      }
    }
  });
}

function cal_bmi(){
  var fa = $('[name=patientfrm], #patientfrm');
  if(fa.find('[name=feet]').val() != 0 && fa.find('[name=inches]').val() != -1 && fa.find('[name=weight]').val() != 0) {
    var inc = (parseInt(fa.find('[name=feet]').val()) * 12) + parseInt(fa.find('[name=inches]').val());
    //alert(inc);

    var inc_sqr = parseInt(inc) * parseInt(inc);
    var wei = parseInt(fa.find('[name=weight]').val()) * 703;
    var bmi = parseInt(wei) / parseInt(inc_sqr);

    //alert("BMI " + bmi.toFixed(2));
    fa.find('[name=bmi]').val(bmi.toFixed(1));
  } else {
    fa.find('[name=bmi]').val('');
  }
}

function show_referredby(t, rs){
  if(t=='person'){
    $('#referred_notes').hide();
    $('#referred_person').show();
  }else{
    $('#referred_notes').show();
    $('#referred_person').hide();
  }
  $('#referred_source').val(rs);
}

function updateNumber(f){
  var selectBox = $("#p_m_ins_co");
  var selectedValue = selectBox.val();
  $('#' + f).html((typeof insurance_nums === 'object' ? insurance_nums : [])[selectedValue]);
}

function updateNumber2(f){
  var selectBox = $("#s_m_ins_co");
  var selectedValue = selectBox.val();
  $('#' + f).html((typeof insurance_nums === 'object' ? insurance_nums : [])[selectedValue]);
}

function clearInfo(){
  $('.s_m_ins_div input[type="text"]').val('');
  $('.s_m_ins_div select option[value=]').attr('selected', 'selected');
  $('.s_m_ins_div input[type="radio"]').removeAttr("checked");
}

function add_md(){          
  if($('#docmdother2_tr').css('display') == 'none'){
    $('#docmdother2_tr').css('display', 'table-row');
  }else if($('#docmdother3_tr').css('display') == 'none'){
    $('#docmdother3_tr').css('display', 'table-row');
  }    

  if($('#docmdother2_tr').css('display') != 'none' && $('#docmdother3_tr').css('display') != 'none'){
    $('#add_new_md').hide();
  }
}

function cancel_md(md){
  $('#'+md).val('');
  $('#'+md+'_name').val('');
  $('#'+md+'_tr').hide();
}

function updatePPAlert(){
  if($('#status').val()==2){
    $('#ppAlert').show();
  }else{
    $('#ppAlert').hide();
  }
}

function updateReferredBy(o, el){
  $('#'+el).append(o);
}
function updateContactField(inField, inVal, idField, idVal){
  $('#'+inField).val(inVal);
  $('#'+idField).val(idVal);
  if(inField=="referredby_name"){
    $('#referred_source').val('2');
  }
}

function updateProfileImage(img){
  $('#profile_image').html("<img src='display_file.php?f="+img+"' height='150' style='float:right;' />");
}

function updateInsCard(img, field){
  $('#'+field).text('View Insurance Card Image');
  $('#'+field).attr('onclick', "window.open('imageholder.php?image="+img+"','welcome','width=800,height=400,scrollbars=yes'); return false;");
}

function update_insurance_type(){
  if($('#p_m_ins_type').val()==1){
    $('#p_m_ins_grp').val('NONE');
    $('#p_m_ins_plan').val('');
    $('#p_m_ins_grp').attr('readonly', 'readonly');
    $('#p_m_ins_plan').attr('readonly', 'readonly');
  }else{
    $('#p_m_ins_grp').removeAttr('readonly');
    $('#p_m_ins_plan').removeAttr('readonly');
  }
}

function checkMedicare(){
  if($('#s_m_ins_type').val() == 1){
    //$('#s_m_ins_type').val('');
    alert("Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.");
  }
}