<?php 
session_start();
require_once('../admin/includes/config.php');
require_once('../includes/constants.inc');
include("../includes/sescheck.php");
require_once('../includes/general_functions.php');
?>
<script type="text/javascript" src="../admin/script/jquery-1.6.2.min.js"></script>
<?php
if(isset($_REQUEST['submit']))
{
$sql = "SELECT * FROM dental_ex_page5 where patientid='".$_GET['pid']."'";
$q = mysql_query($sql);
if(mysql_num_rows($q)==0){
  $sqlex = "INSERT INTO dental_ex_page5 set 
                dentaldevice='".mysql_real_escape_string($_REQUEST['dentaldevice'])."', 
                patientid='".$_GET['pid']."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
}else{

  $sqlex = "update dental_ex_page5 set dentaldevice='".mysql_real_escape_string($_REQUEST['dentaldevice'])."' where patientid='".$_GET['pid']."'";
}
$qex = mysql_query($sqlex);
$flow_sql = "UPDATE dental_flow_pg2_info SET
		device_id='".mysql_real_escape_string($_REQUEST['dentaldevice'])."'
		WHERE id='".mysql_real_escape_string($_GET['id'])."'";
mysql_query($flow_sql);
?>
<script type="text/javascript">
parent.updateDentalDevice('<?= $_GET['id']; ?>', '<?= $_REQUEST['dentaldevice']; ?>');
parent.disablePopup1();
</script>

<?php
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="javascript" type="text/javascript" src="../script/validation.js"></script>

<script type="text/javascript" src="../script/wufoo.js"></script>
</head>
<body>
<?php
  $s = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
?>

<h2 style="margin-top:20px;">What device will you make for <?= $r['firstname']." ".$r['lastname']; ?>?</h2>
<!--<a href="device_guide.php?pid=<?= $_GET['pid']; ?>&id=<?= $_GET['id']; ?>">Help me decide</a>-->
<?php
$sqlex = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
$myex = mysql_query($sqlex);
$myarrayex = mysql_fetch_array($myex);
$dentaldevice = st($myarrayex['dentaldevice']);
?>
<form action="#" method="post">
    Device
        <select name="dentaldevice" style="width:250px">
        <option value=""></option>
        <?php        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                                                                $device_my = mysql_query($device_sql);
                                                                while($device_myarray = mysql_fetch_array($device_my))
                                                                {
                ?>
                                                                 <option <?= ($device_myarray['deviceid']==$dentaldevice)?'selected="selected"':''; ?>value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                                                                 <?php
                                                                 }
                                                                ?>
    </select>
    <input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>
