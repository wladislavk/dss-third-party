<?php 
session_start();
require_once('../admin/includes/config.php');
require_once('../includes/constants.inc');
include("../includes/sescheck.php");
require_once('../includes/general_functions.php');
?>
<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<?php
if(isset($_REQUEST['submit']))
{
$sqlex = "update dental_flow_pg2_info set delay_reason='".mysql_real_escape_string($_REQUEST['delay_reason'])."' where id='".mysql_real_escape_string($_GET['id'])."' AND patientid='".$_GET['pid']."'";
$qex = mysql_query($sqlex);
?>
<script type="text/javascript">
parent.updateDelayReason('<?= $_GET['id']; ?>', '<?= $_REQUEST['delay_reason']; ?>');
parent.disablePopup1();
<?php
if($_REQUEST['delay_reason']=='other'){ ?>
parent.loadPopup('flowsheet_other_reason.php?ed=<?=$_GET['id'];?>&pid=<?=$_GET['pid']; ?>&sid=5');
<?php } ?>
</script>

<?php
}

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
  $s = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
?>

<h2 style="margin-top:20px;">What is the reason for delaying treatment for <?= $r['firstname']." ".$r['lastname']; ?>?</h2>

<?php
$sql = "select * from dental_flow_pg2_info where id='".$_GET['id']."' AND patientid='".$_GET['pid']."'";
$q = mysql_query($sql);
$r = mysql_fetch_array($q);
$sid = st($r['segmentid']);
?>
<form action="#" method="post">
     Reason
<select name="delay_reason" width="250px">
<option value="insurance">Insurance</option>
<option value="dental work">Dental Work</option>
<option value="deciding">Deciding</option>
<option value="sleep study">Sleep Study</option>
<option value="other">Other</option>
</select>
    <input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>
