<?php
namespace Ds3\Libraries\Legacy;

include_once '../../admin/includes/main_include.php';
include_once '../../admin/includes/password.php';

$db = new Db();
$code = preg_replace('/\D+/', '', $_POST['code']);

$s = "SELECT u.* FROM dental_users u 
      WHERE 
      u.email='".$db->escape($_POST['email'])."' AND
      u.access_code='".$db->escape($code)."'";

$q = $db->getResults($s);
if(count($q)>0){
    $r = $q[0];
    linkRequestData('dental_users', $r['userid']);

    $psql = "UPDATE dental_users set access_code='' WHERE userid='".$db->escape($r['userid'])."'";

    $db->query($psql);
    $_SESSION['regid'] = $r['userid'];
    echo '{"success":true}';
}else{
    linkRequestData('dental_users', 0);
    echo '{"error":"code"}';
}
