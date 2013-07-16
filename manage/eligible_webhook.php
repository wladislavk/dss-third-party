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
?>
