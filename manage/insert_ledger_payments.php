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
$d_sql = ''; //to update disput reason
//Determine new status
if($_POST['dispute']==1){
                        $fname = $_FILES["attachment"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"q_file/".$banner1);
                        @chmod("q_file/".$banner1,0777);

  if($claim['status']==DSS_CLAIM_SENT || $claim['status']==DSS_CLAIM_PAID_INSURANCE){
    $new_status = DSS_CLAIM_DISPUTE;
    $msg = 'Disputed Primary Insurance';
    $d_sql = ", dispute_reason='".mysql_escape_string($_POST['dispute_reason'])."'";
    $image_sql = "INSERT INTO dental_insurance_file (
                claimid,
		claimtype,
		filename,
		adddate,
		ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'primary',
		'".$banner1."',
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);   

  }elseif($claim['status']==DSS_CLAIM_SEC_SENT || $claim['status']==DSS_CLAIM_PAID_SEC_INSURANCE){
    $new_status = DSS_CLAIM_SEC_DISPUTE;
    $msg = 'Disputed Secondary Insurance';
    $d_sql = ", sec_dispute_reason='".mysql_escape_string($_POST['dispute_reason'])."'";
$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
                adddate,
                ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'secondary',
                '".$banner1."',
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);    

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
  $x = "UPDATE dental_insurance SET status='".$new_status."' ".$d_sql." WHERE insuranceid='".$_POST['claimid']."';";
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


