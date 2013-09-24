<?php

require_once 'includes/main_include.php';
require_once '../includes/constants.inc';
require 'includes/access.php';
require_once('../includes/formatters.php');

if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}

$names = explode(" ", $partial);
if(is_super($_SESSION['admin_access'])){
$sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, p.status AS stat, p.premedcheck,  "
  .   " s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment,  "
  .		" s.delivery_date, s.vob, s.ledger, s.patient_info, d.device, "
                 . " fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec, u.username "
	.		" FROM dental_patients p"
  .   " JOIN dental_users u ON u.userid=p.docid "
  .   " LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
  .   " LEFT JOIN dental_device d ON s.appliance = d.deviceid "
                 . "  LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid "
	.		" WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
	.		" AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
	.		" OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))"
        .               " AND p.status=1 "
	.		" ORDER BY lastname ASC;";
}elseif(is_software($_SESSION['admin_access'])){
$sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, p.status AS stat, p.premedcheck,  "
  .   " s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment,  "
  .             " s.delivery_date, s.vob, s.ledger, s.patient_info, d.device, "
                 . " fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec, u.username "
        .               " FROM dental_patients p"
  .   " JOIN dental_users u ON u.userid=p.docid "
  .   " JOIN dental_user_company uc ON uc.userid = u.userid "
  .   " LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
  .   " LEFT JOIN dental_device d ON s.appliance = d.deviceid "
                 . "  LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid "
        .               " WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
        .               " AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
        .               " OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))"
        .               " AND p.status=1 "
	.		" AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' "
        .               " ORDER BY lastname ASC;";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
$sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, p.status AS stat, p.premedcheck,  "
  .   " s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment,  "
  .             " s.delivery_date, s.vob, s.ledger, s.patient_info, d.device, "
                 . " fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec, u.username "
        .               " FROM dental_patients p"
  .   " JOIN dental_users u ON u.userid=p.docid "
  .   " LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
  .   " LEFT JOIN dental_device d ON s.appliance = d.deviceid "
                 . "  LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid "
        .               " WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
        .               " AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
        .               " OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))"
        .               " AND p.status=1 "
	.		" AND u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."' "
        .               " ORDER BY lastname ASC;";
}
$result = mysql_query($sql);

$patients = array();
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
	$rxlomn = '';
                          if($row['rxreq'] != null && $row['rxrec'] == null){
        $day = (24 * 60 * 60);
  $diff = ceil((time() - strtotime($row['rxreq'])) / $day);
                                if($diff > 7){
                                  $rxlomn .= '<span class="red">Pending</span>';
                                }else{
                                  $rxlomn .= 'Pending';
                                }
                          }elseif($row['rxrec'] != null){
                                $rxlomn .= 'Yes';
                          }else{
                                $rxlomn .= 'N/A';
                          }
                $rxlomn .= ' / ';
                          if($row['lomnreq'] != null && $row['lomnrec'] == null){
        $day = (24 * 60 * 60);
  $diff = ceil((time() - strtotime($row['lomnreq'])) / $day);
                                if($diff > 7){
                                  $rxlomn .= '<span class="red">Pending</span>';
                                }else{
                                  $rxlomn .= 'Pending';
                                }

                          }elseif($row['lomnrec'] != null){
                                $rxlomn .= 'Yes';
                          }else{
                                $rxlomn .= 'N/A';
                          }
	$patients[$i]['patientid'] = $row['patientid'];
  $patients[$i]['lastname'] = $row['lastname'];
  $patients[$i]['firstname'] = $row['firstname'];
  $patients[$i]['middlename'] = $row['middlename'];
  $patients[$i]['stat'] = $row['stat'];
  $patients[$i]['premedcheck'] = $row['premedcheck'];
  $patients[$i]['fspage1_complete'] = ($row['fspage1_complete'] == 1 ? "Yes" : "<span class=\"red\">No</span>");
  $patients[$i]['next_visit'] = format_date($row['next_visit']);
  $patients[$i]['last_visit'] = format_date($row['last_vist'], true);
  $patients[$i]['last_treatment'] = ($row['last_treatment'] == null ? 'N/A' : $row['last_treatment']);
  $patients[$i]['delivery_date'] = format_date($row['delivery_date'], true);
  $patients[$i]['vob'] = ($row['vob'] == null ? 'N/A' : $dss_preauth_status_labels[$row['vob']]);
  $patients[$i]['ledger'] = ($row['ledger'] == null ? 'N/A' : format_ledger($row['ledger']));
  $patients[$i]['rxlomn'] = $rxlomn;
	$patients[$i]['patient_info'] = $row['patient_info'];
  $patients[$i]['device'] = ($row['device'] == null ? 'N/A' : $row['device']);
  $patients[$i]['doctor'] = $row['username'];
  $i++;
}

if (!$result) {
	$patients = array("error" => $sql ." Error: Could not select patients from database");
}

echo json_encode($patients);

?>
