<?php
namespace Ds3\Libraries\Legacy;

require_once '../admin/includes/main_include.php';
require_once '../admin/includes/general.htm';

$lid = $_REQUEST['lid'];
$type = $_REQUEST['type'];
$rid = $_REQUEST['rid'];

$s = delete_letter($lid, $type, $rid);
if ($s) {
    echo '{"success":true}';
} else {
    echo '{"error":true}';
}
