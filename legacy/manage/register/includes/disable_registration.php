<?php
namespace Ds3\Libraries\Legacy;

include_once '../../admin/includes/main_include.php';
include_once '../../includes/checkemail.php';

$id = $_REQUEST['id'];

linkRequestData('dental_users', $id);

$db = new Db();

$sql = "UPDATE dental_users SET status=1, recover_hash='', recover_time='' WHERE userid='".$db->escape($id)."'";
$db->query($sql);
