<?php 
session_start();
require_once('../admin/includes/main_include.php');
require_once('../includes/constants.inc');
include("../includes/sescheck.php");
require_once('../includes/general_functions.php');
?>
<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<?php
if(isset($_REQUEST['submit']))
{
$sqlex = "update dental_flow_pg2_info set study_type='".mysql_real_escape_string($_REQUEST['study_type'])."' where id='".mysql_real_escape_string($_GET['id'])."' AND patientid='".$_GET['pid']."'";
$qex = mysql_query($sqlex);
?>
<script type="text/javascript">
parent.updateStudyType('<?= $_GET['id']; ?>', '<?= $_REQUEST['study_type']; ?>');
parent.disablePopup1();
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

<h2 style="margin-top:20px;">What type of sleep test will be performed on <?= $r['firstname']." ".$r['lastname']; ?>?</h2>

<?php
$sql = "select * from dental_flow_pg2_info where id='".$_GET['id']."' AND patientid='".$_GET['pid']."'";
$q = mysql_query($sql);
$r = mysql_fetch_array($q);
$sid = st($r['segmentid']);
?>
<form action="#" method="post">
     Study Type    
        <select name="study_type" style="width:250px">
        <option value=""></option>
	<?php
	if($sid==3){ ?>
	  <option value="HST Titration">HST Titration</option>
	  <option value="PSG Titration">PSG Titration</option>
        <?php }elseif($sid==15) { ?>
          <option value="HST Baseline">HST Baseline</option>
          <option value="PSG Baseline">PSG Baseline</option>
	<?php } ?>
    </select>
    <input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>
