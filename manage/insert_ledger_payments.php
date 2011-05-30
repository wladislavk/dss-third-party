<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
?>
<html>
<head>
<script type="text/javascript">
<!--
function ledgerconfirmation(){
	var answer = confirm("Transactions Successfully Added?")
	if (answer){
    history.go(-1);
	}
	else{
    history.go(-1);
	}
}
//-->
</script>
</head>
<body>
<?php

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
eraseCookie('tempforledgerentry');
</script>                               
<?= $sqlinsertqry; ?>
<?php
}else{
?>
<script type="text/javascript">
eraseCookie('tempforledgerentry');
alert('Payment(s) successfully added!');
history.go(-1);
</script>
<?php
}
?>


