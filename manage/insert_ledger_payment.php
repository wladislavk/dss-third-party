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

$sqlinsertqry .= "INSERT INTO `dental_ledger_payment` (
`ledgerid` ,
`payment_date` ,
`entry_date` ,
`amount` ,
`payment_type` ,
`payer`
) VALUES ";

foreach($_POST[form] as $form){

$sqlinsertqry .= "(
".$_POST['ledgerid'].", '".date('Y-m-d', strtotime($form[service_date]))."', '".date('Y-m-d', strtotime($form[entry_date]))."', '".$form['amount']."', '".$form[payment_type]."', '".$form[payer]."'
),";


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


