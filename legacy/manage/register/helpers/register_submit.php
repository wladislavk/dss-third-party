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

linkRequestData('dental_patients', $userId);

$db = new Db();

$sql = "UPDATE dental_users set
        first_name = '".$db->escape($_POST['first_name'])."',
        last_name = '".$db->escape($_POST['last_name'])."',
        email= '".$db->escape($_POST['email'])."',
        phone = '".$db->escape(num($_POST['phone']))."',
        fax = '".$db->escape(num($_POST['fax']))."',
        practice = '".$db->escape($_POST['practice'])."',
        address = '".$db->escape($_POST['address'])."',
        city = '".$db->escape($_POST['city'])."',
        state = '".$db->escape($_POST['state'])."',
        zip = '".$db->escape($_POST['zip'])."',
        npi = '".$db->escape($_POST['npi'])."',
        medicare_npi = '".$db->escape($_POST['medicare_npi'])."',
        medicare_ptan = '".$db->escape($_POST['medicare_ptan'])."',
        tax_id_or_ssn = '".$db->escape($_POST['tax_id_or_ssn'])."',
        ein = '".$db->escape($_POST['ein'])."',
        ssn = '".$db->escape($_POST['ssn'])."',
        use_service_npi = '".$db->escape($_POST['use_service_npi'])."',
        service_name = '".$db->escape($_POST['service_name'])."',
        service_address = '".$db->escape($_POST['service_address'])."',
        service_city = '".$db->escape($_POST['service_city'])."',
        service_state = '".$db->escape($_POST['service_state'])."',
        service_zip = '".$db->escape($_POST['service_zip'])."',
        service_phone = '".$db->escape($_POST['service_phone'])."',
        service_fax = '".$db->escape($_POST['service_fax'])."',
        service_npi = '".$db->escape($_POST['service_npi'])."',
        service_medicare_npi = '".$db->escape($_POST['service_medicare_npi'])."',
        service_medicare_ptan = '".$db->escape($_POST['service_medicare_ptan'])."',
        service_tax_id_or_ssn = '".$db->escape($_POST['service_tax_id_or_ssn'])."',
        service_ein = '".$db->escape($_POST['service_ein'])."',
        service_ssn = '".$db->escape($_POST['service_ssn'])."',
        username = '".$db->escape(trim($_POST['username']))."'";

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
        location = '".$db->escape($_POST['mailing_practice'])."',
        email = '".$db->escape($_POST['mailing_email'])."',
        name = '".$db->escape($_POST["mailing_name"])."',
        address = '".$db->escape($_POST["mailing_address"])."',
        city = '".$db->escape($_POST["mailing_city"])."',
        state = '".$db->escape($_POST["mailing_state"])."',
        zip = '".$db->escape($_POST["mailing_zip"])."',
        phone = '".$db->escape(num($_POST["mailing_phone"]))."',
        fax = '".$db->escape(num($_POST["fax"]))."'
        WHERE
        id = '".$db->escape($loc_r['id'])."'";
} else {
    $loc_sql = "INSERT INTO dental_locations SET
        location = '".$db->escape($_POST['mailing_practice'])."',
        email = '".$db->escape($_POST['mailing_email'])."',
        name = '".$db->escape($_POST["mailing_name"])."',
        address = '".$db->escape($_POST["mailing_address"])."',
        city = '".$db->escape($_POST["mailing_city"])."',
        state = '".$db->escape($_POST["mailing_state"])."',
        zip = '".$db->escape($_POST["mailing_zip"])."',
        phone = '".$db->escape(num($_POST["mailing_phone"]))."',
        fax = '".$db->escape(num($_POST["fax"]))."',
        default_location=1,
        docid='".$db->escape($_POST['userid'])."',
        adddate=now(),
        ip_address='".$_SERVER['REMOTE_ADDR']."'";
}

$db->query($loc_sql);

edx_user_update($userId, NULL);
help_user_update($userId);
