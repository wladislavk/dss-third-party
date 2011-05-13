<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
?>
<html>
<head>
</head>
<body>
<?php

$sqlinsertqry .= "INSERT INTO `dental_ledger_note` (
`service_date` ,
`entry_date` ,
`note` ,
`private` ,
`adddate` ,
`ip_address` ,
`producerid`,
`patientid`,
`docid`
) VALUES ";
$private = ($_POST['private'])?1:0;
$sqlinsertqry .= "( '".date('Y-m-d', strtotime($_POST['entry_date']))."', '".date('Y-m-d', strtotime($_POST['entry_date']))."', '".$_POST['note']."', '".$private."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$_POST['producer']."', ".$_POST['patientid'].", ".$_POST['docid'].")";

$insqry = mysql_query($sqlinsertqry);
if(!$insqry){
?>
<script type="text/javascript">
alert('Could not add ledger note, please close this window and contact your system administrator');
eraseCookie('tempforledgerentry');
</script>                               
<?= $sqlinsertqry; ?>
<?php
}else{
?>
<script type="text/javascript">
var p = parent.window.location.toString();
if(p.substr(p.lastIndexOf('/'),15)=='/view_claim.php'){
alert(' Note successfully added! To view note you must go to the patient\'s general ledger.');
}else{
alert(' Note successfully added!');
}
parent.window.location.reload();
</script>
<?php
}
?>
















<?php


$sqlinsertqry2 .= "INSERT INTO `dental_ledger_rec` (
`ledgerid` ,
`formid` ,
`patientid` ,
`service_date` ,
`entry_date` ,
`description` ,
`producer` ,
`amount` ,
`transaction_type` ,
`paid_amount` ,
`userid` ,
`docid` ,
`status` ,
`adddate` ,
`ip_address` ,
`transaction_code`
) VALUES ";




foreach($_POST[form] as $form){
if($d <= $i){

$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_codeid='".$form[proccode]."' LIMIT 1;";
$descquery = mysql_query($descsql);
$txcode = mysql_fetch_array($descquery);

if($form[procedure_code] == '1' && $form[service_date] != '' && $form['amount'] != ''){
$sqlinsertqry2 .= "( NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'),";
                                                                             
}elseif($form[procedure_code] == '2' && $form[service_date] != '' && $form['amount'] != '' || $form[procedure_code] == '3' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
),";

}elseif($form[procedure_code] == '6' && $form[proccode] == '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
),";

}elseif($form[procedure_code] == '6' && $form[proccode] != '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
),";

}else{

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
),";

}
}elseif($d == $i){

$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_code='".$form[proccode]."' LIMIT 1;";
$descquery = mysql_query($descsql);
while($txcode = mysql_fetch_array($descquery)){

if($form[procedure_code] == '1' && $form[service_date] != '' && $form['amount'] != ''){
$service_date = $form[service_date];
$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$service_date."', '".$form[entry_date]."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
)";

}elseif($form[procedure_code] == '2' && $form[service_date] != '' && $form['amount'] != '' || $form[procedure_code] == '3' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
)";

}elseif($form[procedure_code] == '6' && $form[proccode] == '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
)";

}elseif($form[procedure_code] == '6' && $form[proccode] != '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
)";

}elseif($form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry2 .= "(
NULL , '0', '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
)";

}

$d++;
}
}

}


$sqlinsertqry2 = substr($sqlinsertqry2, 0, -1).";";
$insqry = mysql_query($sqlinsertqry2);
?>


























</body>
</html>
