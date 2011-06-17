<?php 
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
include("includes/sescheck.php");
?>
<html>
<head>
</head>
<body>
<?php
$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid='".$_POST['claimid']."';";
$cq = mysql_query($csql);
$claim = mysql_fetch_array($cq);

$psql = "SELECT * FROM dental_patients p WHERE p.patientid='".$_POST['patientid']."';";
$pq = mysql_query($psql);
$pat = mysql_fetch_array($pq);
$msg = "Payments have been added.";
echo "<br />";
//Determine new status
if($_POST['dispute']==1){
  if($claim['status']==DSS_CLAIM_SENT || $claim['status']==DSS_CLAIM_PAID_INSURANCE){
    $new_status = DSS_CLAIM_DISPUTE;
    $msg = 'Disputed Primary Insurance';
  }elseif($claim['status']==DSS_CLAIM_SEC_SENT || $claim['status']==DSS_CLAIM_PAID_SEC_INSURANCE){
    $new_status = DSS_CLAIM_SEC_DISPUTE;
    $msg = 'Disputed Secondary Insurance';
  }
}else{

  if($claim['status']==DSS_CLAIM_PAID_INSURANCE || $claim['status']==DSS_CLAIM_PAID_SEC_INSURANCE){
    $msg = "Claim saved, status is PAID.";
  }elseif($claim['status']==DSS_CLAIM_PENDING || $claim['status']==DSS_CLAIM_SEC_PENDING){
    //SAVE WITHOUT CHANGING STATUS
  }elseif($claim['status']==DSS_CLAIM_SENT){
    if($_POST['close'] == 1){
      if($pat['s_m_dss_file']==1){ //secondary

        if($pat['s_m_ins_type']==1){ //medicare
          $new_status = DSS_CLAIM_SEC_SENT;
        }else{
          $new_status = DSS_CLAIM_SEC_PENDING;
        }

      }else{
        $new_status = DSS_CLAIM_PAID_INSURANCE;
      }
    }
  }elseif($claim['status']==DSS_CLAIM_SEC_SENT && $_POST['close'] == 1){
    $new_status = DSS_CLAIM_PAID_SEC_INSURANCE;
  }

}
if(isset($new_status)){
  $x = "UPDATE dental_insurance SET status='".$new_status."' WHERE insuranceid='".$_POST['claimid']."';";
  mysql_query($x);
}



$sqlinsertqry .= "INSERT INTO `dental_ledger_payment` (
`ledgerid` ,
`payment_date` ,
`entry_date` ,
`amount` ,
`payment_type` ,
`payer`
) VALUES ";
$lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id=".$_POST['claimid'];
$lq = mysql_query($lsql);
while($row = mysql_fetch_assoc($lq)){
$id = $row['ledgerid'];
if($_POST['amount_'.$id]!=''){
$sqlinsertqry .= "(
".$id.", '".date('Y-m-d', strtotime($_POST['payment_date_'.$id]))."', '".date('Y-m-d')."', '".$_POST['amount_'.$id]."', '".$_POST['payment_type']."', '".$_POST['payer']."'
),";
}

}
$sqlinsertqry = substr($sqlinsertqry, 0, -1).";";
$insqry = mysql_query($sqlinsertqry);
if(!$insqry){
?>
<script type="text/javascript">
alert('Could not add ledger payments, please close this window and contact your system administrator');
</script>                               
<?= $sqlinsertqry; ?>
<?php
}else{
?>
<script type="text/javascript">
alert('<?= $msg; ?>');
parent.window.location = parent.window.location;
</script>
<?php
}
?>


