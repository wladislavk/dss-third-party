$('#transaction_type').on("change", update_list);
$('#provider_select').change(function(event){
  var json = $(this).val();
  var r = $.parseJSON(json);
  if(r.signature=="0"){
    alert("Error - No e-signature on file for "+r.provider_name+".  In order to submit electronic enrollments this user must add an e-signature on his/her ‘Profile’ page.");
	$('#provider_select option:first-child').attr("selected", "selected");
	exit;
  }
  $('#facility_name').val(r.facility_name);
  $('#provider_name').val(r.provider_name);
  $('#tax_id').val(r.tax_id);
  $('#address').val(r.address);
  $('#city').val(r.city);
  $('#state').val(r.state);
  $('#zip').val(r.zip);
  $('#npi').val(r.npi);
  $('#ptan').val(r.medicare_ptan);
  $('#first_name').val(r.first_name);
  $('#last_name').val(r.last_name);
  $('#contact_number').val(r.contact_number);
  $('#email').val(r.email);
}).change();

$("input[type='text'][readonly]").click( function(){
  alert('These fields can only be edited or updated via the user profile page.');
});

function update_list(){
  var t = $('#transaction_type').val();
  $('#ins_payer_name').val('');
  if(t == '1'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'ins_payer', '','','','','','coverage');
  }else if(t == '2'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/payment/status.json', 'ins_payer');
  }else if(t == '4'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/era.json', 'ins_payer', '','','','','','payment reports');
  }else if(t == '5'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', '', 'ins_payer');
  }else if(t == '6'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/dental.json', 'ins_payer');
  }else if(t == '7'){
    setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/claims/institutional.json', 'ins_payer', '','','','','','professional claims');
  }
}
