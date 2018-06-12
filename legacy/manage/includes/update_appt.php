<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
$comp_date = (!empty($_REQUEST['comp_date']) ? $_REQUEST['comp_date'] : '');
$pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

$db = new Db();

$s = "SELECT * FROM dental_flow_pg2_info WHERE id=".mysqli_real_escape_string($con, $id)." AND patientid=".mysqli_real_escape_string($con, $pid);
$r = $db->getRow($s);

if (!empty($r['segmentid']) && $r['segmentid'] == 7){ //Update dental device date for device delivery step
    $last_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid=".mysqli_real_escape_string($con, $pid)." ORDER BY date_completed DESC";
    $last_r = $db->getRow($last_sql);

    if (!empty($last_r['id']) && $id == $last_r['id']) {
        $sql = "SELECT * FROM dental_ex_page5_pivot where patientid='".$pid."'";

        $compDateEscaped = mysqli_real_escape_string($con, $comp_date);
        $compDateString = date('Y-m-d', strtotime($compDateEscaped));
        if ($db->getNumberRows($sql) == 0) {
            $s = "INSERT INTO dental_ex_page5 set 
                dentaldevice_date='$compDateString', 
                patientid='".$pid."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
        } else {
            $exPage5Row = $db->getRow($sql);
            $exPage5Id = $exPage5Row['ex_page5id'];
            $db->query("UPDATE dental_ex_page5 SET dentaldevice_date='$compDateString' where ex_page5id=$exPage5Id");
        }
    }
}

if (!empty($comp_date)) {
    $dateCompleted = date('Y-m-d', strtotime($comp_date));
} else {
    $dateCompleted = date('Y-m-d');
}

$s = "update dental_flow_pg2_info set date_completed='" . $dateCompleted . "' WHERE id=".mysqli_real_escape_string($con, $id)." AND patientid=".mysqli_real_escape_string($con, $pid);
$q = $db->query($s);

if (!empty($q)) {
  echo '{"success":true}';
} else {
  echo '{"error":true}';
}
