<?php 
session_start();
require_once('includes/main_include.php');
require_once('../includes/constants.inc');
include("includes/sescheck.php");
require_once('../includes/authorization_functions.php');
require_once 'includes/claim_functions.php';
require_once '../includes/claim_functions.php';
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
$sqlinsertqry = "INSERT INTO `dental_ledger_payment` (
`ledgerid` ,
`payment_date` ,
`entry_date` ,
`amount` ,
`amount_allowed` ,
`payment_type` ,
`payer`
) VALUES ";
$lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id=".$_POST['claimid'];
$lq = mysql_query($lsql);
while($row = mysql_fetch_assoc($lq)){
$id = $row['ledgerid'];
if($_POST['amount_'.$id]!=''){
$sqlinsertqry .= "(
".$id.", '".date('Y-m-d', strtotime($_POST['payment_date_'.$id]))."', '".date('Y-m-d')."', '".str_replace(',','',$_POST['amount_'.$id])."',  '".str_replace(',','',$_POST['amount_allowed_'.$id])."', '".$_POST['payment_type']."', '".$_POST['payer']."'
),";
}

}
$sqlinsertqry = substr($sqlinsertqry, 0, -1).";";
$insqry = mysql_query($sqlinsertqry);

$paysql = "SELECT SUM(lp.amount) as payment
                        FROM dental_ledger_payment lp
                                JOIN dental_ledger dl on lp.ledgerid=dl.ledgerid
                        WHERE dl.primary_claim_id='".$_POST['claimid']."'
                                AND lp.payer='".DSS_TRXN_PAYER_PRIMARY."'";
$payq = mysql_query($paysql);
$payr = mysql_fetch_assoc($payq);
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

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../../../shared/q_file/".$banner1);
                        @chmod("../../../../shared/q_file/".$banner1,0777);
         }

          $note_sql = "INSERT INTO dental_ledger_note SET
                service_date = CURDATE(),
                entry_date = CURDATE(),
                private = 1,
                docid = '".$_pat['docid']."',
                patientid = '".$_POST['patientid']."',
                admin_producerid = '".$_SESSION['adminuserid']."',
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
                ".mysqli_real_escape_string($con, $_POST['claimid']).",
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
                ".mysqli_real_escape_string($con, $_POST['claimid']).",
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
                ".mysqli_real_escape_string($con, $_POST['claimid']).",
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
                ".mysqli_real_escape_string($con, $_POST['claimid']).",
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
	               $pat_sql = "select p.*, u.billing_company_id from dental_patients p 
                JOIN dental_users u ON u.userid=p.docid
                where p.patientid='".s_for($_POST['patientid'])."'";
             $pat_my = mysql_query($pat_sql);
             $pat_myarray = mysql_fetch_array($pat_my);
		$s_m_dss_file = $pat_myarray['s_m_dss_file'];
		$s_m_billing_id = $pat_myarray['billing_company_id'];

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

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../../shared/q_file/".$banner1);
                        @chmod("../../../shared/q_file/".$banner1,0777);

$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
		status,
                adddate,
                ip_address)
              VALUES (
                ".mysqli_real_escape_string($con, $_POST['claimid']).",
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

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../../shared/q_file/".$banner1);
                        @chmod("../../../shared/q_file/".$banner1,0777);
$image_sql = "INSERT INTO dental_insurance_file (
                claimid,
                claimtype,
                filename,
		status,
                adddate,
                ip_address)
              VALUES (
                ".mysqli_real_escape_string($con, $_POST['claimid']).",
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
  if($new_status==DSS_CLAIM_SEC_PENDING){
    //claim_create_sec($_POST['patientid'], $_POST['claimid'],'0');
    $x = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_INSURANCE."'  ";
  }else{
    $x = "UPDATE dental_insurance SET status='".$new_status."'  ";
  }
    if($_POST['close'] == 1){
	$x = ", closed_by_office_type = 2 ";
    }
  if($new_status == DSS_CLAIM_SENT || $new_status == DSS_CLAIM_SEC_SENT || $new_status == DSS_CLAIM_DISPUTE || $new_status == DSS_CLAIM_SEC_DISPUTE || $new_status == DSS_CLAIM_REJECTED || $new_status == DSS_CLAIM_SEC_REJECTED  || $new_status == DSS_CLAIM_PATIENT_DISPUTE || $new_status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $x .= ", mailed_date = NULL ";
  }
  if($new_status == DSS_CLAIM_SEC_PENDING){
    $x .= ", s_m_billing_id = '".$s_m_billing_id."', s_m_dss_file = '".$s_m_dss_file."' ";
  }
  $x .= " WHERE insuranceid='".$_POST['claimid']."';";
  mysql_query($x);
  claim_status_history_update($_POST['claimid'], $new_status, $claim['status'], $_SESSION['userid']);
}



if(isset($_POST['close']) && $_POST['close']==1 && $new_status!=DSS_CLAIM_SEC_PENDING){
  $new_status = DSS_CLAIM_PAID_INSURANCE;
  $msg = 'Payment Successfully Added';
  $x = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_INSURANCE."'  WHERE insuranceid='".$_POST['claimid']."';";
  mysql_query($x); 
}
if($secsql){
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
claim_history_update($_POST['claimid'], $_SESSION['userid'], $_SESSION['adminuserid']);
?>
<script type="text/javascript">
alert('<?= $msg; ?>');
<?php
if($new_status==DSS_CLAIM_SEC_PENDING){
?>
  //window.location = 'manage_claims.php';
  window.location = 'includes/claim_check_secondary.php?pid=<?= $_POST['patientid']; ?>&cid=<?= $_POST['claimid']; ?>&prod=0';
<?php }else{ ?>
  window.location = 'manage_claims.php';
<?php } ?>
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


