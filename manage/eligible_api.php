<link rel="stylesheet" href="css/eligible_api.css" />
<?php
  $s = "SELECT p.*, c.company, u.name as doc_name, u.npi from dental_patients p
	 LEFT JOIN dental_contact c ON c.contactid = p.p_m_ins_co
	 LEFT JOIN dental_users u ON u.userid = p.docid
   	 WHERE p.patientid='".mysql_real_escape_string($_GET['pid'])."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  $doc_name = $r['doc_name'];
  $doc_array = explode(' ',$doc_name);
  $doc_first_name = $doc_array[0];
  $doc_last_name = $doc_array[1];
?>
<form method="post">

<div id="eligible_api">

  <div>
    <label></label>
    <?= $r['company']; ?>
  </div>

  <div>
    <label>Payer Name</label>
    <input type="input" id="payer_name" name="payer_name" value="" />
    <span class="description">Insurance Company Name
	<br />
        <div id="payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                <ul id="payer_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
        </div>
     </span>
  </div>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('payer_name', 'payer_hints', 'payer_id', '', 'list_ins_payers.php');
});

</script>
 
  <div>
    <label>Payer ID</label>
    <input type="input" id="payer_id" name="payer_id" />
    <span class="description">Insurance Company ID</span>
  </div>

  <div>
    <label>Provider First Name</label>
    <input type="input" id="provider_first_name" name="provider_first_name" value="<?= $doc_first_name; ?>" />
    <span class="description">Provider First Name</span>
  </div>

  <div>
    <label>Provider Last Name</label>
    <input type="input" id="provider_last_name" name="provider_last_name" value="<?= $doc_last_name; ?>" />
    <span class="description">Provider Last Name</span>
  </div>

  <div>
    <label>Provider NPI</label>
    <input type="input" id="provider_npi" name="provider_npi" value="<?= $r['npi']; ?>" />
    <span class="description">National Provider Identifier</span>
  </div>

  <div>
    <label>Patient Member ID</label>
    <input type="input" id="patient_member_id" name="patient_member_id" value="<?= $r['p_m_ins_id']; ?>" />
    <span class="description">ID number found on patient insurance card</span>
  </div>

  <div>
    <label>Patient First Name</label>
    <input type="input" id="patient_first_name" name="patient_first_name" value="<?= $r['firstname']; ?>" />
    <span class="description">First name of patient being searched</span>
  </div>

  <div>
    <label>Patient Last Name</label>
    <input type="input" id="patient_last_name" name="patient_last_name" value="<?= $r['lastname']; ?>" />
    <span class="description">Last name of patient being searched</span>
  </div>

  <div>
    <label>Patient DOB</label>
    <input type="input" id="patient_dob" name="patient_dob" value="<?= ($r['dob']!='')?date('Y-m-d', strtotime($r['dob'])):''; ?>" />
    <span class="description">Birthday of patient being searched please use YYYY-MM-DD</span>
  </div>

  <div>
    <label>Service Type Code</label>
    <input type="input" id="service_type_code" name="service_type_code" />
    <span class="description">Optional. Use specific service coverage (diagnostic, lab, etc)</span>
  </div>


  <a id="api_submit" href="#" onclick="return false;">Submit Request</a>
</form>
<div id="api_output"></div>
  <script type="text/javascript">
    $('#api_submit').click( function(){
                                  $.ajax({
                                        url: "https://eligibleapi.net/eligibility.asp",
                                        type: "get",
					dataType: 'json',
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
                                        complete: function(data){
						//$('#api_output').html(data.responseText);
						$('#api_output').html('');
						var r = $.parseJSON(data.responseText);
						response = r['health_care_eligibility_benefit_response'];
						if(response.error){
						  //alert('error');
                                                  $('#api_output').append('<h3>Error</h3><strong>'+response.error.reject_reason_description+'</strong><br />'+response.error['Follow-up_action_description']);
						}else{
						  oopn = response.subscriber.services.health_benefit_plan_coverage.out_of_plan_network;
						  indiv_oop = oopn.individual['out_of_pocket_(stop_loss)'];
						  $('#api_output').append('<h3>Out of Network - Individual out of pocket (stop loss)</h3>');
						  $('#api_output').append('Service Year: $'+indiv_oop[0].service_year);
						  $('#api_output').append('<br />Year to date: $'+indiv_oop[1].year_to_date);
                                                  $('#api_output').append('<br />Remaining: $'+indiv_oop[2].remaining);

	                                          ipn = response.subscriber.services.health_benefit_plan_coverage.in_plan_network;
                                                  indiv_oop = ipn.individual['out_of_pocket_(stop_loss)'];
                                                  $('#api_output').append('<h3>In Network - Individual out of pocket (stop loss)</h3>');
                                                  $('#api_output').append('Service Year: $'+indiv_oop[1].service_year);
                                                  $('#api_output').append('<br />Year to date: $'+indiv_oop[2].year_to_date);
                                                  $('#api_output').append('<br />Remaining: $'+indiv_oop[0].remaining);
						  //$('#api_output').append(oopn);
						  console.log(ipn);
						}
                                        },
                                        failure: function(data){
                                                alert('fail');
                                        }
                                  });
	
    });


  </script>

