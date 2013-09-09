<?php
require_once 'admin/includes/main_include.php';
$request_body = file_get_contents('php://input');
$json = json_decode($request_body);

$event = $json->{"event"};
$ref_id = $json->{"reference_id"};

$sql = "INSERT INTO dental_eligible_response SET
	response = '".mysql_real_escape_string($request_body)."',
	reference_id = '".mysql_real_escape_string($ref_id)."',
	event_type = '".mysql_real_escape_string($event)."',
	adddate = now(),
	ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
mysql_query($sql);


if($event == "claim_rejected"){
  $e_sql = "SELECT claim_id FROM dental_claim_electronic WHERE reference_id='".mysql_real_escape_string($ref_id)."'";
  $e_q = mysql_query($e_sql);
  $e = mysql_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
		status='".DSS_CLAIM_REJECTED."'
		WHERE insuranceid='".mysql_real_escape_string($e['claim_id'])."'";
  mysql_query($up_sql);
}
?>
