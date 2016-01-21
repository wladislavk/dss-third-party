<?php namespace Ds3\Libraries\Legacy; ?><?php

require_once('includes/main_include.php');
include("includes/sescheck.php");
require_once("includes/general.htm");
require_once('../includes/constants.inc');
require_once('../includes/formatters.php');

require_once __DIR__ . '/includes/access.php';

$partial = '';

if (isset($_POST['partial_name'])) {
    $partial = $_POST['partial_name'];
    $partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
    $partial = s_for($partial);
}

$names = explode(" ", $partial);

$companyId = intval($_SESSION['admincompanyid']);
$pivotTable = 'dental_user_company';

if (is_software($_SESSION['admin_access'])) {
    $andCompanyConditional = "AND uc.companyid = '$companyId'";
} elseif (is_billing($_SESSION['admin_access'])) {
    $andCompanyConditional = "AND u.billing_company_id = '$companyId'";
} elseif (is_hst($_SESSION['admin_access'])) {
    $pivotTable = 'dental_user_hst_company';
    $andCompanyConditional = "AND uc.companyid = '$companyId'";
} elseif (!is_super($_SESSION['admin_access'])) {
    $andCompanyConditional = "AND FALSE";
}

$sql = "SELECT u.userid, u.last_name, u.first_name
    FROM dental_users u
        LEFT JOIN $pivotTable uc ON uc.userid = u.userid
    WHERE (
            (
                (
                    last_name LIKE '{$names[0]}%'
                    OR first_name LIKE '{$names[0]}%'
                )
                AND (
                    last_name LIKE '{$names[1]}%'
                    OR first_name LIKE '{$names[1]}%'
                )
            )
            OR (
                first_name LIKE '{$names[0]}%'
                AND last_name LIKE '{$names[1]}%'
            )
        )
        AND u.docid = 0
        $andCompanyConditional
    ORDER BY u.last_name ASC";

$result = mysqli_query($con, $sql);

$patients = array();
$i = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $patients[$i]['id'] = $row['userid'];
    $patients[$i]['name'] = $row['last_name'].", ".$row['first_name'];
    $i++;
}

if (!$result) {
    $patients = array("error" => "Error: Could not select users from database");
}

echo json_encode($patients);
