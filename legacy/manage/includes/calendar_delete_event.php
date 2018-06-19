<?php
namespace Ds3\Libraries\Legacy;

$docid = $_SESSION['docid'];
$e_id = $_POST['e_id'];

$foo = (string) $e_id;
if (strpos($foo, '#') !== false) {
    return;
} else {
    include_once '../admin/includes/main_include.php';
    include_once 'checkemail.php';

    $db = new Db();

    $s = "delete from dental_calendar
        WHERE event_id='".$e_id."'";

    if($db->query($s)) {
      echo '{"success":true}';
    } else {
      echo '{"error":true}';
    }
}
