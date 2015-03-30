<?php
  require_once('../includes/constants.inc');
  require_once('includes/main_include.php');
  require_once "includes/general.htm";
  include_once 'includes/claim_functions.php';
  include_once 'includes/invoice_functions.php';
  include_once '../includes/claim_functions.php';

  $reference_id_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysql_real_escape_string($_GET['insid'])."' ORDER BY adddate DESC LIMIT 1"; 
  $reference_id_query = mysql_query($reference_id_sql);
  $reference_id_result = mysql_fetch_assoc($reference_id_query);
  if($reference_id_result){
    $reference_id = $reference_id_result['reference_id'];
    if($reference_id != ""){
      $data = array();
      $is_test_sql = "SELECT eligible_test, dental_insurance.docid FROM dental_users JOIN dental_insurance ON dental_users.userid = dental_insurance.docid where insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
      $is_test_query = mysql_query($is_test_sql);
      $is_test_result = mysql_fetch_assoc($is_test_query);
          
      $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
      $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".mysql_real_escape_string($is_test_result['docid'])."'";
      $api_key_query = mysql_query($api_key_sql);
      $api_key_result = mysql_fetch_assoc($api_key_query);
      
      if($api_key_result && !empty($api_key_result['eligible_api_key'])){
        if(trim($api_key_result['eligible_api_key']) != ""){
          $api_key = $api_key_result['eligible_api_key'];
        }
      }
      $url = "https://gds.eligibleapi.com/v1.5/claims/".$reference_id."/acknowledgements?api_key=".$api_key;

      if($is_test_result['eligible_test']=="1"){
       $url .= '&test=true';
      }

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec ($ch);
      echo $result;
      $json_response = json_decode($result);
      $ref_id = $json_response->{"reference_id"};
      $total = $json_response->{"total"};
      $acknowledgements = $json_response->{"acknowledgements"};
      $response_status = $acknowledgements[0]->status;
      $message = "Status: " . $response_status . "\\n\\nMessage: " . $acknowledgements[0]->message;
      echo "<br>".$acknowledgements[0]->errors;
      foreach ($acknowledgements[0]->errors as $error){
        $message .= "\\n\\nERROR: " . $error->message;
      }

      $electronic_claim_sql = "INSERT INTO dental_eligible_response SET
        response = '".mysql_real_escape_string($result)."',
        reference_id = '".mysql_real_escape_string($ref_id)."',
        event_type = '".mysql_real_escape_string($response_status)."',
        adddate = now(),
        ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
      mysql_query($electronic_claim_sql);

      $status = "";

      if ($response_status == "created"){
        $status = DSS_CLAIM_SENT;
      } elseif ($response_status == "received"){
        $status = DSS_CLAIM_SENT;
      } elseif ($response_status == "rejected"){
        $status = DSS_CLAIM_REJECTED;
      } elseif ($response_status == "accepted"){
        $status = DSS_CLAIM_EFILE_ACCEPTED;
      }

      $insurance_update_sql = "UPDATE dental_insurance SET
                status='".mysql_real_escape_string($status)."'
                WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
      mysql_query($insurance_update_sql);

    }
  }
?>

<script type="text/javascript">
   alert("<?php echo $message ?>");
   window.location = "manage_claims.php"; 
</script>
