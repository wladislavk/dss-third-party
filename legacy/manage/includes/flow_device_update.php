<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
$d = (!empty($_REQUEST['device']) ? $_REQUEST['device'] : '');
$pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

$info_sql = "UPDATE dental_flow_pg2_info SET
    device_id='".mysqli_real_escape_string($con, $d)."'
    WHERE id='".mysqli_real_escape_string($con, $id)."'";

$db = new Db();
$q = $db->query($info_sql);

$last_sql = "SELECT id FROM dental_flow_pg2_info
    WHERE appointment_type=1 AND
    patientid='".$pid."'
    AND (segmentid='7' OR segmentid='4')
    order BY date_completed DESC, id DESC";

$last_r = $db->getRow($last_sql);
if ($last_r['id'] == $id) {
    $sql = "SELECT * FROM dental_ex_page5_pivot where patientid='".$pid."'";

    if ($db->getNumberRows($sql) == 0) {
        $sql = "INSERT INTO dental_ex_page5 set 
            dentaldevice='".mysqli_real_escape_string($con,$d)."', 
            patientid='".$pid."',
            userid = '".s_for($_SESSION['userid'])."',
            docid = '".s_for($_SESSION['docid'])."',
            adddate = now(),
            ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
    } else {
        $exPageId5Row = $db->getRow($sql);
        $exPage5Id = $exPageId5Row['ex_page5id'];
        $sql = "update dental_ex_page5 set dentaldevice='".mysqli_real_escape_string($con, $d)."' where ex_page5id=$exPage5Id";
    }
    $q = $db->query($sql);
}
if (!empty($q)) {
    echo '{"success":true}';
} else {
    echo '{"error":true}';
}
