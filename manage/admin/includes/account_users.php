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

    $matchesSql = "SELECT u.userid
        FROM dental_users u
            LEFT JOIN dental_user_company uc ON u.userid = uc.userid
        WHERE u.userid = '$docId'
        ";

    if (is_software($_SESSION['admin_access'])) {
        $matchesSql .= " AND uc.companyid = '$companyId' ";
    } else { // Assume it's billing company
        $matchesSql .= " AND u.billing_company_id = '$companyId' ";
    }

    $matches = $db->getResults($matchesSql);

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
