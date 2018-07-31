<?php
namespace Ds3\Libraries\Legacy;

include '../../admin/includes/main_include.php';
include '../../includes/constants.inc';
include_once '../../includes/general_functions.php';
include_once '../../admin/includes/password.php';

linkRequestData('dental_users', $_POST['userid']);

$db = new Db();

$c_sql = "SELECT id, plan_id FROM dental_access_codes WHERE status='1' AND access_code='".$_POST['code']."'";
$c_r = $db->getRow($c_sql);

$access_code_id = $c_r['id'];
$plan_id = $c_r['plan_id'];

if($_POST['userid']==''){
    $sql = "INSERT INTO dental_users set
        first_name = '".$db->escape($_POST['first_name'])."',
        last_name = '".$db->escape($_POST['last_name'])."',
        name = '".$db->escape(trim($_POST["first_name"] . ' ' . $_POST["last_name"]))."',
        email= '".$db->escape($_POST['email'])."',
        phone = '".$db->escape(num($_POST['cell_phone']))."',
        access_code_id = '".$db->escape($access_code_id)."',
        plan_id = '".$db->escape($plan_id)."',
        user_access=".DSS_USER_ACCESS_DOCTOR.",
        use_patient_portal = '1',
        use_payment_reports = '0',
        use_digital_fax = '1',
        use_letters = '1',
        use_eligible_api = '0',
        use_course = '0',
        use_course_staff = '0',
        user_type = '".DSS_USER_TYPE_SOFTWARE."',
        adddate = now(),
        ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'
    ";
    $userid = $db->getInsertId($sql);
    $userid = intval($userid);

    $db->query("INSERT INTO dental_user_company SET userid='".$db->escape($userid)."', companyid='".$db->escape($_POST["companyid"])."'");
    $db->query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('General', 'FFF9CF', 'general', ".$userid.")");
    $db->query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Follow-up', 'D6CFFF', 'follow-up', ".$userid.")");
    $db->query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Sleep Test', 'CFF5FF', 'sleep_test', ".$userid.")");
    $db->query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Impressions', 'DFFFCF', 'impressions', ".$userid.")");
    $db->query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('New Pt', 'FFCFCF', 'new_pt', ".$userid.")");
    $db->query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Deliver Device', 'FBA16C', 'deliver_device', ".$userid.")");
    $db->query("INSERT INTO `dental_resources` (name, rank, docid) VALUES ('Chair 1', 1, ".$userid.")");

    $code_sql = "insert into dental_transaction_code (transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, docid, amount_adjust) SELECT transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, ".$userid.", amount_adjust FROM dental_transaction_code WHERE default_code=1";
    $db->query($code_sql);
                
    $custom_sql = "insert into dental_custom (title, description, docid) SELECT title, description, ".$userid." FROM dental_custom WHERE default_text=1";
    $db->query($custom_sql);
} else {
    $sql = "UPDATE dental_users set
        first_name = '".$db->escape($_POST['first_name'])."',
        last_name = '".$db->escape($_POST['last_name'])."',
        email= '".$db->escape($_POST['email'])."',
        access_code_id = '".$db->escape($access_code_id)."',
        plan_id = '".$db->escape($plan_id)."',
        phone = '".$db->escape(num($_POST['cell_phone']))."'
        WHERE userid='".$db->escape($_POST['userid'])."'
    ";

    $q = $db->query($sql);
    $userid = $_POST['userid'];
}

if($q || $userid){
    echo '{"userid":"'.$userid.'"}';
}
