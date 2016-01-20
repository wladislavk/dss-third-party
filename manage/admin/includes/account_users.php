<?php
namespace Ds3\Libraries\Legacy;

session_start();
require_once 'main_include.php';
require_once '../../includes/constants.inc';
require 'access.php';

$docId = intval($_REQUEST['account']);
$users = [];

if (is_super($_SESSION['admin_access'])) {
    $authorized = true;
} else {
    $companyId = intval($_SESSION['admincompanyid']);
    $matches = $db->getResults("SELECT u.userid
        FROM dental_users u
            LEFT JOIN dental_user_company uc ON u.userid = uc.userid
        WHERE u.userid = '$docId'
            AND uc.companyid = '$companyId'");
    $authorized = count($matches) > 0;
}

if ($authorized) {
    $users = $db->getResults("SELECT *
        FROM dental_users
        WHERE (userid = '$docId' OR docid = '$docId')
            AND status = 1
        ORDER BY docid ASC, first_name ASC, last_name ASC");
}

$c = '';

foreach ($users as $user){
    $c .= "<option value='" . e($user['userid']) . "'>" . e($user['first_name'] . " " . $u['last_name']) . "</option>";
}

echo @json_encode(['options' => $c]);
