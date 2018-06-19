<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';
include_once 'checkemail.php';

$db = new Db();

$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
$s = "UPDATE dental_task SET status = 1
      WHERE id='".$db->escape($id)."'";

if($db->query($s)){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
