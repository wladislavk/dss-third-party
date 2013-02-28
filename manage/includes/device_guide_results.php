<?php
session_start();
require_once('../admin/includes/config.php');
require_once('../includes/constants.inc');
include("../includes/sescheck.php");
require_once('../includes/general_functions.php');
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


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
  $s = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_POST['pid'])."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
?>

<h2 style="margin-top:20px;">Device Selection Results for <?= $r['firstname']." ".$r['lastname']; ?>?</h2>
<?php
$s_sql = "select * FROM dental_device_guide_settings order by rank ASC";
$s_q = mysql_query($s_sql);
$total_val;
?>
    <?php while($s_r = mysql_fetch_assoc($s_q)){ ?>
      <?php

	$val = $_POST['setting'.$s_r['id']];
        $total_val += $val;
    }
     ?>
<?php
  $d_sql = "SELECT d.id,d.name,  ABS((SELECT SUM(ds.value) FROM dental_device_guide_device_setting ds WHERE ds.device_id=d.id)-".$total_val.") AS total FROM dental_device_guide_devices d
		ORDER BY total ASC";

  $d_q = mysql_query($d_sql);
  while($d_r = mysql_fetch_assoc($d_q)){
	?>
	<div style="width:80%; margin:0 auto">
    		<h3><?= $d_r['name']; ?></h3>
        </div>
    	<?php
  }

  ?>

</form>
</body>
</html>

