<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
$sql = "SELECT * FROM dental_ledger_payment WHERE id='".$_POST['id']."' ;";
$p_sql = mysql_query($sql);
while($p = mysql_fetch_array($p_sql)){
$s = "UPDATE dental_ledger_payment SET
entry_date='".mysql_real_escape_string(date('Y-m-d', strtotime($_POST['entry_date_'.$p['id']])))."',
payment_date='".mysql_real_escape_string(date('Y-m-d',strtotime($_POST['payment_date_'.$p['id']])))."',
payer='".mysql_real_escape_string($_POST['payer_'.$p['id']])."',
payment_type='".mysql_real_escape_string($_POST['payment_type_'.$p['id']])."',
amount='".mysql_real_escape_string(str_replace(',','',$_POST['amount_'.$p['id']]))."'
WHERE id='".mysql_real_escape_string($p['id'])."'";
mysql_query($s);
}

?>
<script type="text/javascript">
parent.window.location = parent.window.location;
</script>
