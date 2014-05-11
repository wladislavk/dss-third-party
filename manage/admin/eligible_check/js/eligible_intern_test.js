var type_watch = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  }
})();

(function($) {
  var re = /([^&=]+)=?([^&]*)/g;
  var decodeRE = /\+/g; // Regex for replacing addition symbol with a space
  var decode = function (str) {return decodeURIComponent( str.replace(decodeRE, " ") );};
  $.parseParams = function(query) {
    var params = {}, e;
    while ( e = re.exec(query) ) {
      var k = decode( e[1] ), v = decode( e[2] );
      if (k.substring(k.length - 2) === '[]') {
        k = k.substring(0, k.length - 2);
        (params[k] || (params[k] = [])).push(v);
      }
      else params[k] = v;
    }
    return params;
  };
})(jQuery);

var autocomplete_fields = function() {
  var url = $("#test_url").val();
  data = $.parseParams(url.split('?')[1] || '' );

  var api_key = data['api_key'] || data['APIKey'];
  var payer_id = data['payer_id'] || data['PayerID'];

  var internal_id = data['internal_id'];
  var cascade = data['cascade'];
  var date = data['date'];
  var from_date = data['from_date'];
  var to_date = data['to_date'];
  var service_type = data['service_type'] || data['service_type_code'] || data['ServiceTypeCode'];
  
  var provider_npi = data['service_provider_npi'] || data['DoctorNPI'];
  var provider_last_name = data['service_provider_last_name'] || data['DoctorLastName'];
  var provider_first_name = data['service_provider_first_name'] || data['DoctorFirstName'];

  var member_id = data['subscriber_id'] || data['InsureeMemberID'] || data['SubscriberMemberID'];
  var member_last_name = data['subscriber_last_name'] || data['InsureeLastName'] || data['SubscriberLastName'];
  var member_first_name = data['subscriber_first_name'] || data['InsureeFirstName'] || data['SubscriberFirstName'];
  var member_dob = data['subscriber_dob'] || data['InsureeDOB'] || data['SubscriberDOB'];

  var provider_organization_name = data['service_provider_organization_name'] || data['provider_organization_name'];
  var provider_tax_id = data['service_provider_tax_id'] || data['provider_tax_id'];
  var provider_taxonomy_code = data['provider_taxonomy_code'];
  var provider_submitter_id = data['service_provider_submitter_id'] || data['provider_submitter_id'];
  var provider_street_line_1 = data['provider_street_line_1'];
  var provider_street_line_2 = data['provider_street_line_2'];
  var provider_city = data['provider_city'];
  var provider_state = data['provider_state'];
  var provider_zip = data['provider_zip'];

  var member_ssn = data['subscriber_ssn'] || data['member_ssn'];
  var member_employee_id = data['subscriber_employee_id'] || data['member_employee_id'];
  var member_gender = data['subscriber_gender'] || data['member_gender'];
  var member_group_id = data['subscribergroupid'] || data['SubscriberGroupId'] || data['SubscriberGroupID'] ||
    data['insureegroupid'] || data['InsureeGroupId'] || data['InsureeGroupID'] || data['subscriber_group_id'] ||
    data['member_group_id'];
  var member_state = data['subscriberstate'] || data['SubscriberState'] || data['subscriber_state'] || data['member_state'];
  var member_city = data['subscribercity'] || data['SubscriberCity'] || data['subscriber_city'] || data['member_city'];
  var member_zip = data['subscriberzip'] || data['SubscriberZIP'] || data['subscriber_zip'] || data['member_zip'];

  var dependent_ssn = data['dependent_ssn'];
  var dependent_employee_id = data['dependent_employee_id'];
  var dependent_gender = data['dependent_gender'];
  var dependent_group_id = data['dependent_group_id'];
  var dependent_state = data['dependent_state'];
  var dependent_city = data['dependent_city'];
  var dependent_zip = data['dependent_zip'];



  try {
    if (api_key && api_key.length > 0) $("#api_key").val(api_key);
    if (payer_id && payer_id.length > 0) $("#payer_id").val(payer_id);
    if (internal_id && internal_id.length > 0) $("#internal_id").val(payer_id);
    if (cascade && cascade.length > 0) $("#cascade").val(cascade);
    if (date && date.length > 0) $("#date").val(date);
    if (from_date && from_date.length > 0) $("#from_date").val(from_date);
    if (to_date && to_date.length > 0) $("#to_date").val(to_date);
    if (service_type && service_type.length > 0) $("#service_type").val(service_type);

    if (provider_npi && provider_npi.length > 0) $("#provider_npi").val(provider_npi);
    if (provider_last_name && provider_last_name.length > 0) $("#provider_last_name").val(provider_last_name);
    if (provider_first_name && provider_first_name.length > 0) $("#provider_first_name").val(provider_first_name);

    if (member_id && member_id.length > 0) $("#member_id").val(member_id);
    if (member_last_name && member_last_name.length > 0) $("#member_last_name").val(member_last_name);
    if (member_first_name && member_first_name.length > 0) $("#member_first_name").val(member_first_name);
    if (member_dob && member_dob.length > 0) $("#member_dob").val(member_dob);

    if (provider_organization_name && provider_organization_name.length > 0) $("#provider_organization_name").val(provider_organization_name);
    if (provider_tax_id && provider_tax_id.length > 0) $("#provider_tax_id").val(provider_tax_id);
    if (provider_taxonomy_code && provider_taxonomy_code.length > 0) $("#provider_taxonomy_code").val(provider_taxonomy_code);
    if (provider_submitter_id && provider_submitter_id.length > 0) $("#provider_submitter_id").val(provider_submitter_id);
    if (provider_street_line_1 && provider_street_line_1.length > 0) $("#provider_street_line_1").val(provider_street_line_1);
    if (provider_street_line_2 && provider_street_line_2.length > 0) $("#provider_street_line_2").val(provider_street_line_2);
    if (provider_city && provider_city.length > 0) $("#provider_city").val(provider_city);
    if (provider_state && provider_state.length > 0) $("#provider_state").val(provider_state);
    if (provider_zip && provider_zip.length > 0) $("#provider_zip").val(provider_zip);

    if (member_ssn && member_ssn.length > 0) $("#member_ssn").val(member_ssn);
    if (member_employee_id && member_employee_id.length > 0) $("#member_employee_id").val(member_employee_id);
    if (member_gender && member_gender.length > 0) $("#member_gender").val(member_gender);
    if (member_group_id && member_group_id.length > 0) $("#member_group_id").val(member_group_id);
    if (member_state && member_state.length > 0) $("#member_state").val(member_state);
    if (member_city && member_city.length > 0) $("#member_city").val(member_city);
    if (member_zip && member_zip.length > 0) $("#member_zip").val(member_zip);

    if (dependent_ssn && dependent_ssn.length > 0) $("#dependent_ssn").val(dependent_ssn);
    if (dependent_employee_id && dependent_employee_id.length > 0) $("#dependent_employee_id").val(dependent_employee_id);
    if (dependent_gender && dependent_gender.length > 0) $("#dependent_gender").val(dependent_gender);
    if (dependent_group_id && dependent_group_id.length > 0) $("#dependent_group_id").val(dependent_group_id);
    if (dependent_state && dependent_state.length > 0) $("#dependent_state").val(dependent_state);
    if (dependent_city && dependent_city.length > 0) $("#dependent_city").val(dependent_city);
    if (dependent_zip && dependent_zip.length > 0) $("#dependent_zip").val(dependent_zip);
  } catch(ex) {
    console.log(ex);
  }
}

$(document).ready(function() {
  $("#test_url").on('keyup', function () {
    type_watch(function () {
      autocomplete_fields();
    }, 500);
  });

  autocomplete_fields();
});