<?php
/*
$url = 'https://eligibleapi.net/eligibility.asp?APIKey=33b2e3a5-8642-1285-d573-07a22f8a15b4';
$response = get_web_page($url);
   $resArr = array();
   $resArr = json_decode($response);
   echo "<pre>"; print_r($resArr); echo "</pre>";
       function get_web_page($url) {
      $options = array (CURLOPT_RETURNTRANSFER => true, // return web page
    CURLOPT_HEADER => false, // don't return headers
    CURLOPT_FOLLOWLOCATION => true, // follow redirects
    CURLOPT_ENCODING => "", // handle compressed
    CURLOPT_USERAGENT => "test", // who am i
    CURLOPT_AUTOREFERER => true, // set referer on redirect
    CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
    CURLOPT_TIMEOUT => 120, // timeout on response
    CURLOPT_MAXREDIRS => 10 ); // stop after 10 redirects


      $ch = curl_init ( $url );
      curl_setopt_array ( $ch, $options );
      $content = curl_exec ( $ch );
      $err = curl_errno ( $ch );
      $errmsg = curl_error ( $ch );
      $header = curl_getinfo ( $ch );
      $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

      curl_close ( $ch );

      $header ['errno'] = $err;
      $header ['errmsg'] = $errmsg;
      $header ['content'] = $content;
      return $header ['content'];
     }
*/
?>
<form method="post">

<div id="eligible_api">

  <div>
    <label>Payer Name</label>
    <input type="input" id="payer_name" name="payer_name" />
    <span class="description">Insurance Company Name</span>
  </div>
  
  <div>
    <label>Payer ID</label>
    <input type="input" id="payer_id" name="payer_id" />
    <span class="description">Insurance Company ID</span>
  </div>

  <div>
    <label>Provider First Name</label>
    <input type="input" id="provider_first_name" name="provider_first_name" />
    <span class="description">Provider First Name</span>
  </div>

  <div>
    <label>Provider Last Name</label>
    <input type="input" id="provider_last_name" name="provider_last_name" />
    <span class="description">Provider Last Name</span>
  </div>

  <div>
    <label>Provider NPI</label>
    <input type="input" id="provider_npi" name="provider_npi" />
    <span class="description">National Provider Identifier</span>
  </div>

  <div>
    <label>Patient Member ID</label>
    <input type="input" id="patient_member_id" name="patient_member_id" />
    <span class="description">ID number found on patient insurance card</span>
  </div>

  <div>
    <label>Patient First Name</label>
    <input type="input" id="patient_first_name" name="patient_first_name" />
    <span class="description">First name of patient being searched</span>
  </div>

  <div>
    <label>Patient Last Name</label>
    <input type="input" id="patient_last_name" name="patient_last_name" />
    <span class="description">Last name of patient being searched</span>
  </div>

  <div>
    <label>Patient DOB</label>
    <input type="input" id="patient_dob" name="patient_dob" />
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
						$('#api_output').html(data.responseText);
                                        },
                                        failure: function(data){
                                                alert('fail');
                                        }
                                  });
	
    });


  </script>

