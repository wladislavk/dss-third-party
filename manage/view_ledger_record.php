<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>

<?php
$rec_qry = "SELECT `ledgerid`,`formid` ,`patientid`,`service_date` ,`entry_date`,`description` ,`producer` ,`amount` ,`transaction_type` ,`paid_amount` ,`userid` ,`docid` ,`status` ,`adddate` ,`ip_address`,`transaction_code` FROM dental_ledger_rec WHERE patientid='". $_GET['pid'] ."' ORDER BY service_date ASC";
$result = mysql_query($rec_qry);

$num_rows = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
print '<table style="margin:20px;" border="1" width="95%"><tr>';
foreach($row as $name => $value) {
print "<th>$name</th>";
}
print '</tr>';
while($row) {
print '<tr>';
foreach($row as $value) {
print "<td style=\"color:#FFFFFF;\">$value</td>";
}
print '</tr>';
$row = mysql_fetch_assoc($result);
}
print '</table>';

?>	
	
</body>
</html>