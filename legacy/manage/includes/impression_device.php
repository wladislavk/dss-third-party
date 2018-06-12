<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';
include_once '../includes/constants.inc';
include "../includes/sescheck.php";
include_once '../includes/general_functions.php';

?>
<script type="text/javascript" src="../admin/script/jquery-1.6.2.min.js"></script>
<?php
$db = new Db();
if (isset($_REQUEST['submit'])) {
    $sql = "SELECT * FROM dental_ex_page5_pivot where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";

    $dentalDeviceRequest = mysqli_real_escape_string($con, $_REQUEST['dentaldevice']);
    if ($db->getNumberRows($sql) == 0) {
        $sqlex = "INSERT INTO dental_ex_page5 set 
            dentaldevice='".$dentalDeviceRequest."', 
            patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."',
            userid = '".s_for($_SESSION['userid'])."',
            docid = '".s_for($_SESSION['docid'])."',
            adddate = now(),
            ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
    } else {
        $exPage5IdRow = $db->getRow($sql);
        $exPage5Id = $exPage5IdRow['ex_page5id'];
        $sqlex = "update dental_ex_page5 set dentaldevice='".$dentalDeviceRequest."' where ex_page5id=$exPage5Id";
    }

    $qex = $db->query($sqlex);
    $flow_sql = "UPDATE dental_flow_pg2_info SET
        device_id='".mysqli_real_escape_string($con,$_REQUEST['dentaldevice'])."'
        WHERE id='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."'";
    $db->query($flow_sql);
?>
    <script type="text/javascript">
        parent.updateDentalDevice('<?php echo (!empty($_GET['id']) ? $_GET['id'] : ''); ?>', '<?php echo $_REQUEST['dentaldevice']; ?>');
        parent.disablePopup1();
    </script>
    <?php
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="../css/admin_buttons.css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/admin/script/validation.js"></script>
</head>
<body>
<?php
$s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$r = $db->getRow($s);
?>
<h2 style="margin-top:20px;">What device will you make for <?php echo $r['firstname']." ".$r['lastname']; ?>?</h2>
<a href="device_guide.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=<?php echo (!empty($_GET['id']) ? $_GET['id'] : ''); ?>">Help me decide</a>
<?php
$sqlex = "select * from dental_ex_page5_pivot where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarrayex = $db->getRow($sqlex);
$dentaldevice = st($myarrayex['dentaldevice']);
?>
<form action="#" method="post">
    Device
    <select name="dentaldevice" style="width:250px">
        <option value=""></option>
        <?php
        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
        $device_my = $db->getResults($device_sql);
        if ($device_my) {
            foreach ($device_my as $device_myarray) { ?>
                <option <?php echo ($device_myarray['deviceid'] == $dentaldevice) ? 'selected="selected"' : ''; ?>value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
                <?php
            }
        } ?>
    </select>
    <input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>
