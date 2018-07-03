<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

$db = new Db();

$id = (!empty($_POST['id']) ? $_POST['id'] : '');
$s = "UPDATE dental_notifications SET status='2' WHERE id='".$db->escape($id)."'";

$q = $db->query($s);
if (!empty($q)) {
    echo '{"success":true}';
} else {
    echo '{"error":"update"}';
}
