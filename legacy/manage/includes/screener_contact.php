<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

if (!empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
} else {
    $id = '';
}

if (!empty($_REQUEST['c'])) {
    $c = $_REQUEST['c'];
} else {
    $c = '';
}

$db = new Db();

$s = "UPDATE dental_screener SET contacted = '".$db->escape($c)."'
      WHERE id='".$db->escape($id)."'";

echo $s;
if($db->query($s)){
    echo '{"success":true}';
}else{
    echo '{"error":true}';
}
