<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

$pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

if (!empty($_REQUEST['device_date'])) {
    $d = date('Y-m-d', strtotime($_REQUEST['device_date']));
} else {
    $d = date('Y-m-d');
}

$db = new Db();

$sql = "SELECT * FROM dental_ex_page5_pivot where patientid='".$pid."'";

$escapedDate = $db->escape($d);
if ($db->getNumberRows($sql) == 0) {
    $s = "INSERT INTO dental_ex_page5 set 
        dentaldevice_date='$escapedDate', 
        patientid='".$pid."',
        userid = '".s_for($_SESSION['userid'])."',
        docid = '".s_for($_SESSION['docid'])."',
        adddate = now(),
        ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
} else {
    $exPage5Row = $db->getRow($sql);
    $exPage5Id = $exPage5Row['ex_page5id'];
    $s = "UPDATE dental_ex_page5 set dentaldevice_date='$escapedDate' where ex_page5id=$exPage5Id";
}
  
$last_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid=".$db->escape($pid)." ORDER BY date_completed DESC";

$last_r = $db->getRow($last_sql);
$u = "UPDATE dental_flow_pg2_info SET date_completed='".$db->escape($d)."' WHERE id='".$last_r['id']."'";
$db->query($u);

$q = $db->query($s);

$imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".$db->escape($pid)."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";

$imp_r = $db->getRow($imp_s);

//competed_date changed to date_completed
$flow_sql = "UPDATE dental_flow_pg2_info SET
    date_completed='".$db->escape($d)."'
    WHERE id='".$db->escape($imp_r['id'])."'";
$db->query($flow_sql);

if ($q) {
    echo '{"success":true}';
} else {
    echo '{"error":true}';
}
