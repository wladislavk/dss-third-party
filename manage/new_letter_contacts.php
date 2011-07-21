<?php

require_once('admin/includes/config.php');
include("includes/sescheck.php");
require_once("admin/includes/general.htm");

if (isset($_POST['templateid']) && isset($_POST['patientid'])) {
	$templateid = $_POST['templateid'];
	$patientid = $_POST['patientid'];
} else {
	$html = "No data received.";
}

$md_list = get_mdcontactids($patientid);
$md_referral_list = get_mdreferralids($patientid);
$contactinfo = get_contact_info($patientid, $md_list, $md_referral_list);

$contacts = array();
$j = 0;
//$contacts[$j]['html'] = "<input class=\"patient_checkbox\" type=\"checkbox\" name=\"contacts[patient]\" value=\"$patientid\" />Patient: " . $contactinfo['patient'][0]['salutation'] . $contactinfo['patient'][0]['firstname'] . " " . $contactinfo['patient'][0]['lastname'] . "<br />";
$contacts[$j]['type'] = 'patient';
$contacts[$j]['id'] = $patientid;
$contacts[$j]['name'] = $contactinfo['patient'][0]['salutation'] . " " . $contactinfo['patient'][0]['firstname'] . " " . $contactinfo['patient'][0]['lastname'];
$contacts[$j]['email'] = $contactinfo['patient'][0]['email'];
$contacts[$j]['fax'] = $contactinfo['patient'][0]['fax'];
$j++;

$i = 0;
foreach ($contactinfo['md_referrals'] as $md) {
//	$contacts[$j]['html'] = "<input class=\"md_referral_checkbox\" type=\"checkbox\" name=\"contacts[md_referrals][$i]\" value=\"" . $md['id'] . "\" />Referring MD: " . $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'] . "<br />";
  $contacts[$j]['type'] = 'md_referral';
	$contacts[$j]['id'] = $md['id'];
  $contacts[$j]['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
  $contacts[$j]['email'] = $md['email'];
  $contacts[$j]['fax'] = $md['fax'];
  $j++;
	$i++;
}

$i = 0;
foreach ($contactinfo['mds'] as $md) {
//	$contacts[$j]['html'] = "<input class=\"md_checkbox\" type=\"checkbox\" name=\"contacts[mds][$i]\" value=\"" . $md['id'] . "\" />MD: " . $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'] . "<br />";
  $contacts[$j]['type'] = 'md';
  $contacts[$j]['id'] = $md['id'];
  $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
  $contacts[$j]['email'] = $md['email'];
  $contacts[$j]['fax'] = $md['fax'];
  $j++;
	$i++;
}
//$html .= print_r($contactinfo, true);
echo json_encode($contacts);

?>
