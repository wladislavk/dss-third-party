

<div id="eligible_api">

  <div>
    <label>Payer Name</label>
    <input type="input" name="payer_name" />
    <span class="description">Insurance Company Name</span>
  </div>
  
  <div>
    <label>Payer ID</label>
    <input type="input" name="payer_id" />
    <span class="description">Insurance Company ID</span>
  </div>

  <div>
    <label>Provider First Name</label>
    <input type="input" name="provider_first_name" />
    <span class="description">Provider First Name</span>
  </div>

  <div>
    <label>Provider Last Name</label>
    <input type="input" name="provider_last_name" />
    <span class="description">Provider Last Name</span>
  </div>

  <div>
    <label>Provider NPI</label>
    <input type="input" name="provider_npi" />
    <span class="description">National Provider Identifier</span>
  </div>

  <div>
    <label>Patient Member ID</label>
    <input type="input" name="patient_member_id" />
    <span class="description">ID number found on patient insurance card</span>
  </div>

  <div>
    <label>Patient First Name</label>
    <input type="input" name="patient_first_name" />
    <span class="description">First name of patient being searched</span>
  </div>

  <div>
    <label>Patient Last Name</label>
    <input type="input" name="patient_last_name" />
    <span class="description">Last name of patient being searched</span>
  </div>

  <div>
    <label>Patient DOB</label>
    <input type="input" name="patient_dob" />
    <span class="description">Birthday of patient being searched please use YYYY-MM-DD</span>
  </div>

  <div>
    <label>Service Type Code</label>
    <input type="input" name="service_type_code" />
    <span class="description">Optional. Use specific service coverage (diagnostic, lab, etc)</span>
  </div>


  <a id="api_submit" href="#" onclick="return false;">Submit Request</a>

<div id="api_output"></div>
  <script type="text/javascript">
    $('#api_submit').click( function(){
                                  $.ajax({
                                        url: "https://eligibleapi.net/eligibility.asp",
                                        type: "get",
                                        data: {APIKey: '33b2e3a5-8642-1285-d573-07a22f8a15b4',
						PayerName: $('#payer_name').val(),
						PayerID: $('#payer_id').val(),
						ProviderFirstName: $('#provider_first_name').val(),
						ProviderLastName: $('#provider_last_name').val(),
						ProviderNPI: $('#provider_npi').val(),
						PatientMemberID: $('#patient_member_id').val(),
						PatientFirstName: $('#patient_first_name').val(),
						PatientLastName: $('#patient_last_name').val(),
						PatientDOB: $('#patient_dob').val()
						},
                                        success: function(data){
						alert(data);
						$('#api_output').val(data);
                                                var r = $.parseJSON(data);
						alert(r);
                                        },
                                        failure: function(data){
                                                alert('fail');
                                        }
                                  });
	
    });


  </script>

