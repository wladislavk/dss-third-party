<?php
session_start();
require_once '../admin/includes/main_include.php';
require_once 'constants.inc';
$npi = $_REQUEST['npi'];
$payer = $_REQUEST['payer'];
$payer_id = substr($payer,0,strpos($payer, '-'));

$sql = "SELECT e.* from dental_eligible_enrollment e
	JOIN dental_enrollment_transaction_type t ON t.id = e.transaction_type_id
	WHERE t.transaction_type='835'
		AND e.npi='".mysql_real_escape_string($npi)."'
		AND e.payer_id = '".mysql_real_escape_string($payer_id)."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);

$u_sql ="SELECT userid FROM dental_users where npi='".mysql_real_escape_string($npi)."' OR service_npi='".mysql_real_escape_string($npi)."'";
$u_q = mysql_query($u_sql);
$u_r = mysql_fetch_assoc($u_q);

if(mysql_num_rows($q) == 0){
  echo '{"enrolled":"no", "message":"You must enroll for this payer.", "userid":"'.$u_r['userid'].'"}';
}elseif($r['status'] == DSS_ENROLLMENT_SUBMITTED){
  echo '{"enrolled":"no", "message":"Enrollment is submitted, but not yet accepted.", "userid":"'.$u_r['userid'].'"}';
}elseif($r['status'] == DSS_ENROLLMENT_ACCEPTED){
  echo '{"enrolled":"yes"}';
}elseif($r['status'] == DSS_ENROLLMENT_REJECTED){
  echo '{"enrolled":"no", "message":"Enrollment has be rejected. Please resubmit.", "userid":"'.$u_r['userid'].'"}';
}

?>
