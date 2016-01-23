<?php
namespace Ds3\Libraries\Legacy;

include '../../admin/includes/main_include.php';
include '../../includes/constants.inc';
include_once '../../includes/general_functions.php';
include_once '../../includes/notifications.php';
include_once '../../admin/includes/password.php';
include '../../includes/edx_functions.php';
include_once '../../includes/help_functions.php';

$userId = intval($_POST['userid']);

$sql = "UPDATE dental_users set
        first_name = '".mysqli_real_escape_string($con, $_POST['first_name'])."',
        last_name = '".mysqli_real_escape_string($con, $_POST['last_name'])."',
        email= '".mysqli_real_escape_string($con, $_POST['email'])."',
        phone = '".mysqli_real_escape_string($con, num($_POST['phone']))."',
        fax = '".mysqli_real_escape_string($con, num($_POST['fax']))."',
        practice = '".mysqli_real_escape_string($con, $_POST['practice'])."',
        address = '".mysqli_real_escape_string($con, $_POST['address'])."',
        city = '".mysqli_real_escape_string($con, $_POST['city'])."',
        state = '".mysqli_real_escape_string($con, $_POST['state'])."',
        zip = '".mysqli_real_escape_string($con, $_POST['zip'])."',
        npi = '".mysqli_real_escape_string($con, $_POST['npi'])."',
        medicare_npi = '".mysqli_real_escape_string($con, $_POST['medicare_npi'])."',
        medicare_ptan = '".mysqli_real_escape_string($con, $_POST['medicare_ptan'])."',
        tax_id_or_ssn = '".mysqli_real_escape_string($con, $_POST['tax_id_or_ssn'])."',
        ein = '".mysqli_real_escape_string($con, $_POST['ein'])."',
        ssn = '".mysqli_real_escape_string($con, $_POST['ssn'])."',
        use_service_npi = '".mysqli_real_escape_string($con, $_POST['use_service_npi'])."',
        service_name = '".mysqli_real_escape_string($con, $_POST['service_name'])."',
        service_address = '".mysqli_real_escape_string($con, $_POST['service_address'])."',
        service_city = '".mysqli_real_escape_string($con, $_POST['service_city'])."',
        service_state = '".mysqli_real_escape_string($con, $_POST['service_state'])."',
        service_zip = '".mysqli_real_escape_string($con, $_POST['service_zip'])."',
        service_phone = '".mysqli_real_escape_string($con, $_POST['service_phone'])."',
        service_fax = '".mysqli_real_escape_string($con, $_POST['service_fax'])."',
        service_npi = '".mysqli_real_escape_string($con, $_POST['service_npi'])."',
        service_medicare_npi = '".mysqli_real_escape_string($con, $_POST['service_medicare_npi'])."',
        service_medicare_ptan = '".mysqli_real_escape_string($con, $_POST['service_medicare_ptan'])."',
        service_tax_id_or_ssn = '".mysqli_real_escape_string($con, $_POST['service_tax_id_or_ssn'])."',
        service_ein = '".mysqli_real_escape_string($con, $_POST['service_ein'])."',
        service_ssn = '".mysqli_real_escape_string($con, $_POST['service_ssn'])."',
        username = '".mysqli_real_escape_string($con, $_POST['username'])."'";

if ($_POST['password'] != '' && $_POST['password'] == $_POST['confirm_password']) {
    $salt = create_salt();
    $password = gen_password($_POST['password'], $salt);
    $sql .= ", password='".$password."'
             , salt='".$salt."'";
}

$sql .= " WHERE userid = '$userId'";
$db->query($sql);

$loc_s = "SELECT * FROM dental_locations WHERE default_location = 1 AND docid = '$userId'";
$loc_q = $db->getResults($loc_s);

if (count($loc_q) > 0) {
    $loc_r = $loc_q[0];
    $loc_sql = "UPDATE dental_locations SET
        location = '".s_for($_POST['mailing_practice'])."',
        email = '".s_for($_POST['mailing_email'])."',
        name = '".s_for($_POST["mailing_name"])."',
        address = '".s_for($_POST["mailing_address"])."',
        city = '".s_for($_POST["mailing_city"])."',
        state = '".s_for($_POST["mailing_state"])."',
        zip = '".s_for($_POST["mailing_zip"])."',
        phone = '".s_for(num($_POST["mailing_phone"]))."',
        fax = '".s_for(num($_POST["fax"]))."'
        WHERE
        id = '".mysqli_real_escape_string($con, $loc_r['id'])."'";
} else {
    $loc_sql = "INSERT INTO dental_locations SET
        location = '".s_for($_POST['mailing_practice'])."',
        email = '".s_for($_POST['mailing_email'])."',
        name = '".s_for($_POST["mailing_name"])."',
        address = '".s_for($_POST["mailing_address"])."',
        city = '".s_for($_POST["mailing_city"])."',
        state = '".s_for($_POST["mailing_state"])."',
        zip = '".s_for($_POST["mailing_zip"])."',
        phone = '".s_for(num($_POST["mailing_phone"]))."',
        fax = '".s_for(num($_POST["fax"]))."',
        default_location=1,
        docid='".$_POST['userid']."',
        adddate=now(),
        ip_address='".$_SERVER['REMOTE_ADDR']."'";
}

$db->query($loc_sql);

edx_user_update($userId, NULL);
help_user_update($userId, NULL);
