<?php namespace Ds3\Legacy; ?><?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include("includes/constants.inc");
?>
<html>
<head>
</head>
<body>
<?php

foreach($_POST[form] as $form){
    $status = (isset($form['status'])) ? DSS_TRXN_PENDING : DSS_TRXN_NA;

$claim_sql = "SELECT * FROM dental_ledger where ledgerid='".$form['ledgerid']."'";
$claim_q = mysql_query($claim_sql);
$claim_r = mysql_fetch_assoc($claim_q);
if(($claim_r['primary_claim_id']=='' || $claim_r['primary_claim_id']==0) && $status==DSS_TRXN_PENDING){

  $pf_sql = "SELECT producer_files FROM dental_users WHERE userid='".mysql_real_escape_string($claim_r['producerid'])."'";
  $pf_q = mysql_query($pf_sql);
  $pf = mysql_fetch_assoc($pf_q);
  if($pf['producer_files'] == '1'){
    $claim_producer = $claim_r['producerid'];
  }else{
    $claim_producer = $_SESSION['docid'];
  }

  $s = "SELECT insuranceid from dental_insurance where producer='".$claim_producer."' AND patientid='".mysql_real_escape_string($_POST['patientid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
  $q = mysql_query($s);
  $n = mysql_num_rows($q);
  if($n > 0){
        $r = mysql_fetch_assoc($q);
        $claim_id = $r['insuranceid'];
  }else{
        $claim_id = create_claim($_GET['pid'], $claim_producer);
  }
}else{
  $claim_id = $claim_r['primary_claim_id'];
}

if($status == DSS_TRXN_NA){
  $claim_id = '';
}



$sql = "UPDATE dental_ledger SET service_date = '".date('Y-m-d', strtotime($form['service_date']))."', status='".$form['status']."', primary_claim_id='".$claim_id."' WHERE ledgerid=".$form['ledgerid']; 

mysql_query($sql);
//echo $sql;
}
?>
<script type="text/javascript">
//history.go(-1);
parent.window.location = parent.window.location;
</script>



</body>
</html>
