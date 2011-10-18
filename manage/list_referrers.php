<?php

require_once('admin/includes/config.php');
include("includes/sescheck.php");
require_once("admin/includes/general.htm");
require_once('includes/constants.inc');
require_once('includes/formatters.php');

if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}

$names = explode(" ", $partial);

$sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, '".DSS_REFERRED_PATIENT."' AS referral_type"
	.		" FROM dental_patients p"
  .   " LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
  .   " LEFT JOIN dental_device d ON s.appliance = d.deviceid "
	.		" WHERE ((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
	.		" AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
	.		" AND docid = '" . $_SESSION['docid']."'"
  .   " UNION "
  .		" SELECT c.contactid, c.lastname, c.firstname, c.middlename, '".DSS_REFERRED_PHYSICIAN."'"
  .			" FROM dental_contact c"
  .			" WHERE ((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')"
        .               " AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
        .               " AND docid = '" . $_SESSION['docid'] . "' ORDER BY lastname ASC";
$result = mysql_query($sql);

$patients = array();
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
	$patients[$i]['patientid'] = $row['patientid'];
  $patients[$i]['lastname'] = $row['lastname'];
  $patients[$i]['firstname'] = $row['firstname'];
  $patients[$i]['middlename'] = $row['middlename'];
  $patients[$i]['referral_type'] = $row['referral_type'];
  $i++;
}

if (!$result) {
	$patients = array("error" => $sql."Error: Could not select patients from database");
}

echo json_encode($patients);

?>
