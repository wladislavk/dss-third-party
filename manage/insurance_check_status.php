<?php
    include_once('includes/constants.inc');
    include_once('admin/includes/main_include.php');

    if(!empty($_SERVER['HTTPS'])){
        $path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
    }else{
        $path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
    }

    $_GET['id'] = (!empty($_GET['insid']) ? $_GET['insid'] : '');
    $sql = "SELECT i.*, u.npi, u.tax_id_or_ssn,
      		ce.reference_id,
      		u.first_name, u.last_name
      		FROM dental_claim_electronic ce 
          	JOIN dental_insurance i ON i.insuranceid = ce.claimid
          	JOIN dental_users u ON i.docid = u.userid
  	        WHERE ce.claimid='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."' 
          	AND ce.reference_id!=''
          	ORDER BY id DESC LIMIT 1";

    $r = $db->getRow($sql);

    $l_sql = "SELECT * FROM dental_ledger WHERE primary_claim_id='".mysqli_real_escape_string($con,$_GET['id'])."'";

    $l = $db->getRow($l_sql);
    $reference_id = $r['reference_id'];

    $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
    $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".mysqli_real_escape_string($con, $r['user_id'])."'";
    $api_key_query = mysqli_query($con, $api_key_sql);
    $api_key_result = mysqli_fetch_assoc($api_key_query);
    if($api_key_result && !empty($api_key_result['eligible_api_key'])){
      if(trim($api_key_result['eligible_api_key']) != ""){
        $api_key = $api_key_result['eligible_api_key'];
      }
    }
    $data = array();                                                                    

    $data['api_key'] = $api_key;
    $data['payer_id'] = $r['p_m_eligible_payer_id'];
    $data['provider_first_name'] = $r['first_name'];
    $data['provider_last_name'] = $r['last_name'];
    $data['provider_npi']  = preg_replace("/[^0-9]/","",$r['npi']);
    $data['provider_tax_id'] = preg_replace("/[^0-9]/","",$r['tax_id_or_ssn']);
    $data['member_id'] = preg_replace("/[^0-9]/","",$r['insured_id_number']);
    $data['member_last_name'] = $r['patient_lastname'];
    $data['member_first_name'] = $r['patient_firstname'];
    $data['member_dob'] = date('m-d-Y',strtotime($r['patient_dob']));
    $data['charge_amount'] = preg_replace("/[^0-9\.]/","",$r['total_charge']);
    $data['start_date'] = date('Y-m-d',strtotime($l['service_date']));
    $data['end_date'] = date('Y-m-d',strtotime($l['service_date']));

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,'https://gds.eligibleapi.com/v1.5/payment/status.json');
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    $data = curl_exec ($ch); 
    curl_close ($ch);
    //var_dump($data);

    function fill_cents($v)
    {
        if($v<10){
    	   return '0'.$v;
        }else{
    	   return $v;
        }
    }
?>
