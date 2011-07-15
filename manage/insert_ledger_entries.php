<?php 
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
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
$authorized = false;
if($_SESSION['user_access']==DSS_USER_TYPE_ADMIN){
  $authorized = true;
}else{
$auth_sql = "SELECT userid FROM dental_users 
		WHERE 
			username='".mysql_real_escape_string($_POST['username'])."' AND 
			password='".mysql_real_escape_string($_POST['password'])."' AND
			user_access=".DSS_USER_TYPE_ADMIN;
  $auth_q = mysql_query($auth_sql);
  if(mysql_num_rows($auth_q)>0){
    $authorized = true;
  }
}
if($authorized){
$sqlinsertqry .= "INSERT INTO `dental_ledger` (
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
`transaction_code`,
`producerid`
) VALUES ";
foreach($_POST[form] as $form){
if($d <= $i){
$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_codeid='".$form[proccode]."' LIMIT 1;";
$descquery = mysql_query($descsql);
$txcode = mysql_fetch_array($descquery);
if($form[procedure_code] == '1' && $form[service_date] != '' && $form['amount'] != ''){
$sqlinsertqry .= "( NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'),";
                                                                             
}elseif($form[procedure_code] == '2' && $form[service_date] != '' && $form['amount'] != '' || $form[procedure_code] == '3' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
),";

}elseif($form[procedure_code] == '6' && $form[proccode] == '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
),";

}elseif($form[procedure_code] == '6' && $form[proccode] != '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
),";

}elseif($form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
),";

}
}elseif($d == $i){
echo $form[status];
$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_code='".$form[proccode]."' LIMIT 1;";
$descquery = mysql_query($descsql);
while($txcode = mysql_fetch_array($descquery)){

if($form[procedure_code] == '1' && $form[service_date] != '' && $form['amount'] != ''){
$service_date = $form[service_date];
$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($service_date))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
)";

}elseif($form[procedure_code] == '2' && $form[service_date] != '' && $form['amount'] != '' || $form[procedure_code] == '3' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
)";

}elseif($form[procedure_code] == '6' && $form[proccode] == '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
)";

}elseif($form[procedure_code] == '6' && $form[proccode] != '100' && $form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
)";

}elseif($form[service_date] != '' && $form['amount'] != ''){

$sqlinsertqry .= "(
NULL , '0', '".$_POST['patientid']."', '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form[status]."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."', '".$form[producer]."'
)";

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
<?= $sqlinsertqry; ?>
<?php
}else{
?>
<script type="text/javascript">
eraseCookie('tempforledgerentry');
alert('Transaction(s) successfully added!');
parent.window.location = parent.window.location;
</script>
<?php
}



}else{ //NOT AUTHORIZED
?>
<script type="text/javascript">
alert('YOU ARE NOT AUTHORIZED TO COMPLETE THIS REQUEST;');
history.go(-1);
</script>
<?php

}
?>
















<?php
/*
//NOT SURE WHAT THIS IS. COMMENTNIG OUT FOR NOW

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

*/
?>


























</body>
</html>
