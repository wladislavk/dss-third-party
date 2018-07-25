<?php
namespace Ds3\Libraries\Legacy;

require_once 'includes/main_include.php';
require_once '../includes/constants.inc';
require 'includes/access.php';
require_once('../includes/formatters.php');

if (isset($_POST['partial_name'])) {
    $partial = $_POST['partial_name'];
    $partial = preg_replace("/[^ A-Za-z'\-]/", "", $partial);
    $partial = s_for($partial);
}
$names = explode(" ", $partial);

$db = new Db();

if(is_super($_SESSION['admin_access'])){
    $sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, p.status AS stat, p.premedcheck,
        s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment,
        s.delivery_date, s.vob, s.ledger, s.patient_info, d.device,
        fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec, u.username
        FROM dental_patients p
        JOIN dental_users u ON u.userid=p.docid
        LEFT JOIN dental_patient_summary s ON p.patientid = s.pid
        LEFT JOIN dental_device d ON s.appliance = d.deviceid
        LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid
        WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')
        AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))
        OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))
        AND p.status=1
        AND p.docid='".$db->escape( $_GET['fid'])."'
        ORDER BY lastname ASC;";
}elseif(is_software($_SESSION['admin_access'])){
    $sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, p.status AS stat, p.premedcheck,
        s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment,
        s.delivery_date, s.vob, s.ledger, s.patient_info, d.device,
        fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec, u.username
        FROM dental_patients p
        JOIN dental_users u ON u.userid=p.docid
        JOIN dental_user_company uc ON uc.userid = u.userid
        LEFT JOIN dental_patient_summary s ON p.patientid = s.pid
        LEFT JOIN dental_device d ON s.appliance = d.deviceid
        LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid
        WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')
        AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))
        OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))
        AND p.status=1
        AND p.docid='".$db->escape( $_GET['fid'])."'
        AND uc.companyid='".$db->escape( $_SESSION['admincompanyid'])."' 
        ORDER BY lastname ASC;";
}elseif(is_billing($_SESSION['admin_access'])){
    $a_sql = "SELECT ac.companyid FROM admin_company ac
        JOIN admin a ON a.adminid = ac.adminid
        WHERE a.adminid='".$db->escape( $_SESSION['adminuserid'])."'";
    $a_q = mysqli_query($con, $a_sql);
    $admin = mysqli_fetch_assoc($a_q);

    $sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, p.status AS stat, p.premedcheck,
        s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment,
        s.delivery_date, s.vob, s.ledger, s.patient_info, d.device,
        fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec, u.username
        FROM dental_patients p
        JOIN dental_users u ON u.userid=p.docid
        LEFT JOIN dental_patient_summary s ON p.patientid = s.pid
        LEFT JOIN dental_device d ON s.appliance = d.deviceid
        LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid
        WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')
        AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))
        OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))
        AND p.status=1
        AND p.docid='".$db->escape( $_GET['fid'])."'
        AND u.billing_company_id='".$db->escape( $admin['companyid'])."'
        ORDER BY lastname ASC;";
}
$result = mysqli_query($con, $sql);

$patients = [];
$i = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $patients[$i]['id'] = $row['patientid'];
    $patients[$i]['name'] = $row['lastname'].", ".$row['firstname'];
    $i++;
}

if (!$result) {
    $patients = ["error" => $sql ." Error: Could not select patients from database"];
}

echo json_encode($patients);
