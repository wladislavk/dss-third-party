<?php
require_once 'admin/includes/main_include.php';
$request_body = file_get_contents('php://input');
$json = json_decode($request_body);

$event = $json->{"event"};
$success = $json->{"success"};
if($event == "claim_rejected"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_REJECTED."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);

}elseif($event == "claim_paid"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_PAID_INSURANCE."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);

}elseif($event == "claim_denied"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_REJECTED."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);

}elseif($event == "claim_pended"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_SENT."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);

}elseif($event == "claim_created"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_SENT."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);

}elseif($event == "claim_received"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_SENT."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);

}elseif($event == "claim_accepted"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_EFILE_ACCEPTED."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);
  
}elseif($event == "claim_more_info_required"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_REJECTED."'
                WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);

}elseif($event == "enrollment_status"){
  $ref_id = $json->{"details"}->{"id"};
  $status = $json->{"details"}->{"status"};
  if($status=="accepted"){
    $up_sql = "UPDATE dental_eligible_enrollment SET
    status='1'
    WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
    mysql_query($up_sql);
  }
}

$sql = "INSERT INTO dental_eligible_response SET
	response = '".mysql_real_escape_string($request_body)."',
	reference_id = '".mysql_real_escape_string($ref_id)."',
	event_type = '".mysql_real_escape_string($event)."',
	adddate = now(),
	ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
mysql_query($sql);


?>
