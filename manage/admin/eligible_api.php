<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/invoice_functions.php'; ?>
<link rel="stylesheet" href="../css/eligible_api.css" />
 <script type="text/javascript" src="../script/autocomplete.js"></script>
 <script type="text/javascript" src="../script/autocomplete_local.js"></script>

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

<div id="eligible_api" >
<h3>EligibleAPI Instant Eligibility</h3>
  <div>
    <label>Insurance from Pt Info:</label>
    <?= $r['company']; ?>
  </div>

  <div style="clear:both;">
    <label>Payer Name</label>
    <input type="input" id="payer_name" name="payer_name" value="Type Insurance Here" onclick="clear_payer_name(this);" />
    <span class="description">Insurance Company Name
	<br />
        <div id="payer_hints" class="search_hints" style="margin-top:20px; display:none; height: 200px; overflow-y:scroll;">
                <ul id="payer_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
        </div>
     </span>
  </div>
<script type="text/javascript">

function clear_payer_name(f){
  if(f.value=="Type Insurance Here"){
    $('#payer_name').val('');
  }
}

$(document).ready(function(){
  setup_autocomplete_local('payer_name', 'payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'eligibility');
});

</script>
 
  <div style="clear:both;">
    <label>Payer ID</label>
    <input type="input" id="payer_id" name="payer_id" />
    <span class="description">Insurance Company ID</span>
  </div>

  <div style="clear:both;">
    <label>Provider First Name</label>
    <input type="input" id="provider_first_name" name="provider_first_name" value="<?= $doc_first_name; ?>" />
    <span class="description">Provider First Name</span>
  </div>

  <div style="clear:both;">
    <label>Provider Last Name</label>
    <input type="input" id="provider_last_name" name="provider_last_name" value="<?= $doc_last_name; ?>" />
    <span class="description">Provider Last Name</span>
  </div>

  <div style="clear:both;">
    <label>Provider NPI</label>
    <input type="input" id="provider_npi" name="provider_npi" value="<?= $r['npi']; ?>" />
    <span class="description">National Provider Identifier</span>
  </div>

  <div style="clear:both;">
    <label>Patient Member ID</label>
    <input type="input" id="patient_member_id" name="patient_member_id" value="<?= $r['p_m_ins_id']; ?>" />
    <span class="description">ID number found on patient insurance card</span>
  </div>

  <div style="clear:both;">
    <label>Patient First Name</label>
    <input type="input" id="patient_first_name" name="patient_first_name" value="<?= $r['firstname']; ?>" />
    <span class="description">First name of patient being searched</span>
  </div>

  <div style="clear:both;">
    <label>Patient Last Name</label>
    <input type="input" id="patient_last_name" name="patient_last_name" value="<?= $r['lastname']; ?>" />
    <span class="description">Last name of patient being searched</span>
  </div>

  <div style="clear:both;">
    <label>Patient DOB</label>
    <input type="input" id="patient_dob" name="patient_dob" value="<?= ($r['dob']!='')?date('Y-m-d', strtotime($r['dob'])):''; ?>" />
    <span class="description">Birthday of patient being searched please use YYYY-MM-DD</span>
  </div>

  <div style="clear:both;">
    <label>Service Type Code</label>
    <input type="input" id="service_type_code" name="service_type_code" value="30" />
    <span class="description">Optional. Use specific service coverage (diagnostic, lab, etc)</span>
  </div>


  <!--<input type="submit" style="clear:both;"  name="api_submit" id="api_submit_old" class="addButton" value="Submit Request" />-->
  <a href="#" onclick="return false;" class="addButton" id="api_submit">Submit AJAX</a>
</form>

<?php
  if(isset($_POST['api_submit'])){
$payer_id = substr($_POST['payer_id'],0,strpos($_POST['payer_id'], '-'));
$data = array();
$data['test'] = "true";
$data['api_key'] = "33b2e3a5-8642-1285-d573-07a22f8a15b4";
$data['payer_id'] =  $payer_id;
$data['service_provider_first_name'] =  $_POST['provider_first_name'];
$data['service_provider_last_name'] =  $_POST['provider_last_name'];
$data['provider_npi'] =  $_POST['provider_npi'];
$data['member_id'] =  $_POST['patient_member_id'];
$data['member_first_name'] =  $_POST['patient_first_name'];
$data['member_last_name'] =  $_POST['patient_last_name'];
$data['member_dob'] =  $_POST['patient_dob'];
$data['service_type'] =  $_POST['service_type_code'];

$data_string = json_encode($data);                                                                               

echo $data_string."<br /><br />"; 
//$ch = curl_init('https://v1.eligibleapi.net/claim/submit.json?api_key=33b2e3a5-8642-1285-d573-07a22f8a15b4');                                                                      
$ch = curl_init('https://gds.eligibleapi.com/v1.1/coverage/all.json');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                              
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                  
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                      
    'Content-Type: application/json',                                                                            
    'Content-Length: ' . strlen($data_string))                                                                   
);                                                                                                               

$result = curl_exec($ch);
echo $result;
}
?>

<div id="api_output"></div>
  <script type="text/javascript">
    $('#api_submit').click( function(){
/*
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
*/
					//API - 33b2e3a5-8642-1285-d573-07a22f8a15b4
                                  $.ajax({
                                        url: "https://gds.eligibleapi.com/v1.3/coverage/all.json",
                                        type: "get",
                                        data: {api_key: '33b2e3a5-8642-1285-d573-07a22f8a15b4',
                                                payer_id: $('#payer_id').val(),
                                                service_provider_first_name: $('#provider_first_name').val(),
                                                service_provider_last_name: $('#provider_last_name').val(),
                                                provider_npi: $('#provider_npi').val(),
                                                member_id: $('#patient_member_id').val(),
                                                member_first_name: $('#patient_first_name').val(),
                                                member_last_name: $('#patient_last_name').val(),
                                                member_dob: $('#patient_dob').val(),
						service_type: $('#service_type_code').val() 
                                                },
                                        complete: function(data){
console.log(data);
                                                //$('#api_output').html(data.responseText);
                                                $('#api_output').html('');
                                                var r = $.parseJSON(data.responseText);
						$.ajax({
							url: "../includes/eligibility_save.php",
							type: "post",
							data: {response: data.responseText, type: 2},
							success: function(data2){
								//$('#api_output').append(data2);
								//alert(data2);
							}
						}); 
                                                pr = false;//r['primary_insurance'];
if(pr){
						din_ind = r.deductible_in_network.individual
                                                din_fam = r.deductible_in_network.family
                                                don_ind = r.deductible_out_network.individual
                                                don_fam = r.deductible_out_network.family

						$('#api_output').append('<h3>Primary Insurance</h3>');
						$('#api_output').append('Name: '+pr.name);
                                                $('#api_output').append('<br />Group Name: '+pr.group_name);
                                                $('#api_output').append('<br />Status: '+r.coverage_status);
                                                $('#api_output').append('<h3>Deductible In Network</h3>');
                                                $('#api_output').append('<h4>Individual</h4>');
                                                $('#api_output').append('Base Period: '+din_ind.base_period);
                                                $('#api_output').append('<br />Remaining: '+din_ind.remaining);
                                                $('#api_output').append('<h4>Family</h4>');
                                                $('#api_output').append('Base Period: '+din_fam.base_period);
                                                $('#api_output').append('<br />Remaining: '+din_fam.remaining);

                                                $('#api_output').append('<h3>Deductible out of Network</h3>');
                                                $('#api_output').append('<h4>Individual</h4>');
                                                $('#api_output').append('Base Period: '+don_ind.base_period);
                                                $('#api_output').append('<br />Remaining: '+don_ind.remaining);
                                                $('#api_output').append('<h4>Family</h4>');
                                                $('#api_output').append('Base Period: '+don_fam.base_period);
                                                $('#api_output').append('<br />Remaining: '+don_fam.remaining);
}else{
//$('#api_output').append("<h3>Error</h3>");
}
pr = r['primary_insurance'];
s1 = r['1'];
s12 = r['12'];
s30 = r['30'];
if(pr){ 
  pr = JSON.stringify(pr, null, 4);
  pr = pr.replace(/\n/g,"<br />");
  $('#api_output').append(pr);
}
  api_output = "<table width=\"95%\"><tr>";
if(s1){
  s1 = JSON.stringify(s1, null, 4);
  s1 = s1.replace(/\n/g,"<br />");
  api_output += "<td>"+s1+"</td>";
}
if(s12){
  s12 = JSON.stringify(s12, null, 4);
  s12 = s12.replace(/\n/g,"<br />");
  api_output += "<td>"+s12+"</td>";
}
if(s30){
  s30 = JSON.stringify(s30, null, 4);
  s30 = s30.replace(/\n/g,"<br />");
  api_output += "<td>"+s30+"</td>";
}
  $('#api_output').append(api_output+"</tr></table>");

data = JSON.stringify(data.responseText, null, '\t');
data = data.replace(/\\n/g,"<br />");
data = data.replace(/\\/g,"");
$('#api_output').append(data);
$('#api_output').show();
					}
				});

	
    });


  </script>
