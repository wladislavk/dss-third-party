<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
$r = (!empty($_REQUEST['reason']) ? $_REQUEST['reason'] : '');
$pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

$db = new Db();

$s = "UPDATE dental_flow_pg2_info SET
          delay_reason = '".$db->escape($r)."'
      WHERE patientid = '".$db->escape($pid)."' 
      AND id = '".$db->escape($id)."'";

$q = $db->query($s);
if(!empty($q)){
    echo '{"success":true}';
}else{
    echo '{"error":true}';
}
