<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';
include_once '../includes/constants.inc';
include_once '../includes/preauth_functions.php';

$db = new Db();

$pid = (!empty($_POST['pid']) ? $_POST['pid'] : '');
$c = create_vob( $pid );
if ($c===true){
    echo '{"success":true}';
    $up_sql = "UPDATE dental_insurance_preauth SET viewed=1 WHERE (viewed=0 OR viewed is NULL) AND patient_id='".$db->escape($pid)."'";
    $db->query($up_sql);
}else{
    echo '{"error":true, "code":"'.$c.'"}';
}
