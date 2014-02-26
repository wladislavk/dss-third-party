<?php 
session_start();
require_once('admin/includes/main_include.php');
require_once('includes/constants.inc');
include("includes/sescheck.php");
require_once('includes/authorization_functions.php');
include_once 'admin/includes/claim_functions.php';
?>
<html>
<head>
</head>
<body>
<?php
if(authorize($_POST['username'], $_POST['password'], DSS_USER_TYPE_ADMIN)){
$csql = "SELECT *, REPLACE(i.total_charge,',','') AS amount_due FROM dental_insurance i WHERE i.insuranceid='".$_POST['claimid']."';";
$cq = mysql_query($csql);
$claim = mysql_fetch_array($cq);
$psql = "SELECT * FROM dental_patients p WHERE p.patientid='".$_POST['patientid']."';";
$pq = mysql_query($psql);
$pat = mysql_fetch_array($pq);
$msg = "Payments have been added.";
echo "<br />";
//Determine new status
if($_POST['dispute']==1){
          if($_FILES["attachment"]["name"]!=''){
                        $fname = $_FILES["attachment"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../shared/q_file/".$banner1);
                        @chmod("../../shared/q_file/".$banner1,0777);
         }

          $note_sql = "INSERT INTO dental_ledger_note SET
                service_date = CURDATE(),
                entry_date = CURDATE(),
                private = 1,
                docid = '".$_SESSION['docid']."',
                patientid = '".$_POST['patientid']."',
                producerid = '".$_SESSION['userid']."',
                note = 'Insurance claim ".$_POST['claimid']." disputed because: ".mysql_escape_string($_POST['dispute_reason']).".'";
  mysql_query($note_sql);

  if($claim['status']==DSS_CLAIM_SENT || $claim['status']==DSS_CLAIM_PAID_INSURANCE){
    $new_status = DSS_CLAIM_DISPUTE;
    $msg = 'Disputed Primary Insurance';
if($_FILES["attachment"]["name"]!=''){
    $image_sql = "INSERT INTO dental_insurance_file (
                claimid,
		claimtype,
		filename,
                description,
		status,
		adddate,
		ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'primary',
		'".$banner1."',
		'".mysql_escape_string($_POST['dispute_reason'])."',
		".$new_status.",
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);   
}

  }elseif($claim['status']==DSS_CLAIM_SEC_SENT || $claim['status']==DSS_CLAIM_PAID_SEC_INSURANCE){
    $new_status = DSS_CLAIM_SEC_DISPUTE;
    $msg = 'Disputed Secondary Insurance';
if($_FILES["attachment"]["name"]!=''){
$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
		description,
		status,
                adddate,
                ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'secondary',
                '".$banner1."',
		'".mysql_escape_string($_POST['dispute_reason'])."',
		'".$new_status."',
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);    
}
  }elseif($claim['status']==DSS_CLAIM_PAID_PATIENT){
    $new_status = DSS_CLAIM_PATIENT_DISPUTE;
    $msg = 'Disputed Primary Insurance';
if($_FILES["attachment"]["name"]!=''){
$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
                description,
                status,
                adddate,
                ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'primary',
                '".$banner1."',
                '".mysql_escape_string($_POST['dispute_reason'])."',
                '".$new_status."',
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);
}
  }elseif($claim['status']==DSS_CLAIM_PAID_SEC_PATIENT){
    $new_status = DSS_CLAIM_SEC_PATIENT_DISPUTE;
    $msg = 'Disputed Secondary Insurance';
if($_FILES["attachment"]["name"]!=''){
$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
                description,
                status,
                adddate,
                ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'secondary',
                '".$banner1."',
                '".mysql_escape_string($_POST['dispute_reason'])."',
                '".$new_status."',
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);
}
  }
}else{

  if($claim['status']==DSS_CLAIM_PAID_INSURANCE || $claim['status']==DSS_CLAIM_PAID_SEC_INSURANCE){
    $msg = "Claim saved, status is PAID.";
  }elseif($claim['status']==DSS_CLAIM_PENDING || $claim['status']==DSS_CLAIM_SEC_PENDING){
    //SAVE WITHOUT CHANGING STATUS
  }elseif($claim['status']==DSS_CLAIM_SENT){
    if($_POST['close'] == 1){
      if($pat['s_m_dss_file']==1 && $payr['payment']<$claim['amount_due']){ //secondary

        if($pat['p_m_ins_type']==1){ //medicare
	  if($pat['s_m_ins_ass']=="Yes"){
	    $msg = 'This patient has Medicare and Secondary Insurance. Secondary Insurance has been automatically filed by Medicare. Claim status will now be changed to "Secondary Sent".';
            $new_status = DSS_CLAIM_SEC_SENT;
	  }else{
            $msg = 'This patient has Medicare and Secondary Insurance. Secondary Insurance has been automatically filed by Medicare. Claim status will now be changed to "Secondary Paid to Patient".';
            $new_status = DSS_CLAIM_PAID_SEC_PATIENT;
          }
        }else{
	  $msg = 'Payment Successfully Added\n\nPrimary Insurance claim closed. This patient has secondary insurance and a claim has been auto-generated for the Secondary Insurer.';
          $new_status = DSS_CLAIM_SEC_PENDING;
        }
	          $secsql = "UPDATE dental_insurance SET 
                amount_paid=(SELECT SUM(lp.amount) 
                        FROM dental_ledger_payment lp 
                                JOIN dental_ledger dl on lp.ledgerid=dl.ledgerid 
                        WHERE dl.primary_claim_id='".$_POST['claimid']."' 
                                AND lp.payer='".DSS_TRXN_PAYER_PRIMARY."'),
                balance_due = CAST((REPLACE(total_charge,',','')-amount_paid) AS DECIMAL(6,2))
                WHERE insuranceid='".$_POST['claimid']."'";

      }else{
        $new_status = DSS_CLAIM_PAID_INSURANCE;
      }
if($_FILES["attachment"]["name"]!=''){
                        $fname = $_FILES["attachment"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../shared/q_file/".$banner1);
                        @chmod("../../shared/q_file/".$banner1,0777);

$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
		status,
                adddate,
                ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'primary',
                '".$banner1."',
                '".$new_status."',
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);

    }
}
  }elseif($claim['status']==DSS_CLAIM_SEC_SENT && $_POST['close'] == 1){
    $new_status = DSS_CLAIM_PAID_SEC_INSURANCE;
if($_FILES["attachment"]["name"]!=''){
                        $fname = $_FILES["attachment"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../shared/q_file/".$banner1);
                        @chmod("../../shared/q_file/".$banner1,0777);
$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
		status,
                adddate,
                ip_address)
              VALUES (
                ".mysql_real_escape_string($_POST['claimid']).",
                'secondary',
                '".$banner1."',
                '".$new_status."',
                now(),
                '".s_for($_SERVER['REMOTE_ADDR'])."'
                )";
     mysql_query($image_sql);
}
  }

}
if(isset($new_status)){
  $x = "UPDATE dental_insurance SET status='".$new_status."'  ";
  if($new_status == DSS_CLAIM_SENT || $new_status == DSS_CLAIM_SEC_SENT || $new_status == DSS_CLAIM_DISPUTE || $new_status == DSS_CLAIM_SEC_DISPUTE || $new_status == DSS_CLAIM_REJECTED || $new_status == DSS_CLAIM_SEC_REJECTED  || $new_status == DSS_CLAIM_PATIENT_DISPUTE || $new_status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $x .= ", mailed_date = NULL ";
  }
  $x .= " WHERE insuranceid='".$_POST['claimid']."';";
  mysql_query($x);
  claim_status_history_update($_POST['claimid'], $new_status, $claim['status'], $_SESSION['userid']);
}



$sqlinsertqry = "INSERT INTO `dental_ledger_payment` (
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
".$id.", '".date('Y-m-d', strtotime($_POST['payment_date_'.$id]))."', '".date('Y-m-d')."', '".str_replace(',','',$_POST['amount_'.$id])."', '".$_POST['payment_type']."', '".$_POST['payer']."'
),";
}

}
$sqlinsertqry = substr($sqlinsertqry, 0, -1).";";
$insqry = mysql_query($sqlinsertqry);

if($secsql){
$paysql = "SELECT SUM(lp.amount) as payment
                        FROM dental_ledger_payment lp
                                JOIN dental_ledger dl on lp.ledgerid=dl.ledgerid
                        WHERE dl.primary_claim_id='".$_POST['claimid']."'
                                AND lp.payer='".DSS_TRXN_PAYER_PRIMARY."'";
$payq = mysql_query($paysql);
$payr = mysql_fetch_assoc($payq);
if($payr['payment']>=$claim['amount_due']){
  $new_status = DSS_CLAIM_PAID_INSURANCE;
  $msg = 'Payment Successfully Added';
  $x = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_INSURANCE."'  WHERE insuranceid='".$_POST['claimid']."';";
  mysql_query($x); 
}
  mysql_query($secsql);
}


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

}else{ //NOT AUTHORIZED
?>
<script type="text/javascript">
alert('YOU ARE NOT AUTHORIZED TO COMPLETE THIS REQUEST');
history.go(-1);
</script>
<?php

}


?>


