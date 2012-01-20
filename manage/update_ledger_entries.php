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

foreach($_POST[form] as $form){
$sql = "UPDATE dental_ledger SET service_date = '".date('Y-m-d', strtotime($form['service_date']))."', status='".$form['status']."' WHERE ledgerid=".$form['ledgerid']; 

mysql_query($sql);
echo $sql;
}
?>
<script type="text/javascript">
//history.go(-1);
parent.location.reload();
</script>



</body>
</html>
