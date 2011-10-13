<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
?>
<html>
<head>
<script type="text/javascript">

function createCookie(name,value,days) {
              if (days) {
                  var date = new Date();
                  date.setTime(date.getTime()+(days*24*60*60*1000));
                  var expires = "; expires="+date.toGMTString();
              }
              else var expires = "";
              document.cookie = name+"="+value+expires+"; path=/";
          }

		
  function readCookie(name) {
              var nameEQ = name + "=";
              var ca = document.cookie.split(';');
              for(var i=0;i < ca.length;i++) {
                  var c = ca[i];
                  while (c.charAt(0)==' ') c = c.substring(1,c.length);
                  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
              }
              return null;
  }
          
  function eraseCookie(name) {
              createCookie(name,"",-1);
  }
</script>
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
$i = $_COOKIE['tempforledgerentry'];
$d = 1;

$sqlinsertqry .= "INSERT INTO `dental_ledger` (
`ledgerid` ,
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
`transaction_code` ,
`status`
) VALUES ";

foreach($_POST[form] as $form){
if($d <= $i){
if($form[status] == "on"){
$status = "Sent";
}else{
$status = "Pend";
}
$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_codeid='".$form[proccode]."' LIMIT 1;";
$descquery = mysql_query($descsql);
$txcode = mysql_fetch_array($descquery);

if($form[procedure_code] == '1'){
$sqlinsertqry .= "( NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."'),";
                                                                             
}elseif($form[procedure_code] == '2' || $form[procedure_code] == '3'){

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."'),";

}elseif($form[procedure_code] == '6' && $form[proccode] == '100'){

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."'),";

}elseif($form[procedure_code] == '6' && $form[proccode] != '100'){

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."'),";

}else{

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."'),";

}
}elseif($d == $i){

$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_code='".$form[proccode]."' LIMIT 1;";
$descquery = mysql_query($descsql);
while($txcode = mysql_fetch_array($descquery)){

if($form[procedure_code] == '1'){
$service_date = $form[service_date];
$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$service_date."', '".$form[entry_date]."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."')";

}elseif($form[procedure_code] == '2' || $form[procedure_code] == '3'){

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'
, '".$status."')";

}elseif($form[procedure_code] == '6' && $form[proccode] == '100'){

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."')";

}elseif($form[procedure_code] == '6' && $form[proccode] != '100'){

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."')";

}else{

$sqlinsertqry .= "(
NULL , '".$_POST['patientid']."', '".$form[service_date]."', '".$form[entry_date]."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '1', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$status."')";

}

$d++;
}
}

}

$sqlinsertqry = substr($sqlinsertqry, 0, -1).";";
$insqry = mysql_query($sqlinsertqry);
if(!$insqry){
?>
<script type="text/javascript">
alert('Could not add ledger entries, please close this window and contact your system administrator');
eraseCookie('tempforledgerentry');
</script>                               
<?php
}else{
?>
<script type="text/javascript">
eraseCookie('tempforledgerentry');
alert('Transaction(s) successfully added!');
history.go(-1);
</script>
<?php
}
?>

</body>
</html>
