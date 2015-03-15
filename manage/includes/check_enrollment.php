<?php namespace Ds3\Legacy; ?><?php
  include_once '../admin/includes/main_include.php';
  include_once 'constants.inc';

  $npi = (!empty($_REQUEST['npi']) ? $_REQUEST['npi'] : '');
  $payer = (!empty($_REQUEST['payer']) ? $_REQUEST['payer'] : '');
  $payer_id = substr($payer,0,strpos($payer, '-'));

  $sql = "SELECT e.* from dental_eligible_enrollment e
  	JOIN dental_enrollment_transaction_type t ON t.id = e.transaction_type_id
  	WHERE t.transaction_type='835'
  		AND e.npi='".mysqli_real_escape_string($con,$npi)."'
  		AND e.payer_id = '".mysqli_real_escape_string($con,$payer_id)."'";
  $q = $db->getResults($sql);
  $r = $q[0];

  $u_sql ="SELECT userid FROM dental_users where npi='".mysqli_real_escape_string($con,$npi)."' OR service_npi='".mysqli_real_escape_string($con,$npi)."'";
  $u_r = $db->getRow($u_sql);

  if(count($q) == 0){
    echo '{"enrolled":"no", "message":"You must enroll for this payer.", "userid":"'.$u_r['userid'].'"}';
  }elseif($r['status'] == DSS_ENROLLMENT_SUBMITTED){
    echo '{"enrolled":"no", "message":"Enrollment is submitted, but not yet accepted.", "userid":"'.$u_r['userid'].'"}';
  }elseif($r['status'] == DSS_ENROLLMENT_ACCEPTED){
    echo '{"enrolled":"yes"}';
  }elseif($r['status'] == DSS_ENROLLMENT_REJECTED){
    echo '{"enrolled":"no", "message":"Enrollment has be rejected. Please resubmit.", "userid":"'.$u_r['userid'].'"}';
  }
?>
