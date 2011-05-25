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

$html .= "<input class=\"patient_checkbox\" type=\"checkbox\" name=\"contacts[patient]\" value=\"$patientid\" />Patient: " . $contactinfo['patient'][0]['salutation'] . $contactinfo['patient'][0]['firstname'] . " " . $contactinfo['patient'][0]['lastname'] . "<br />";
$i = 0;
foreach ($contactinfo['md_referrals'] as $md) {
	$html .= "<input class=\"md_referral_checkbox\" type=\"checkbox\" name=\"contacts[md_referrals][$i]\" value=\"" . $md['id'] . "\" />Referring MD: " . $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'] . "<br />";
	$i++;
}
$i = 0;
foreach ($contactinfo['mds'] as $md) {
	$html .= "<input class=\"md_checkbox\" type=\"checkbox\" name=\"contacts[mds][$i]\" value=\"" . $md['id'] . "\" />MD: " . $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'] . "<br />";
	$i++;
}
//$html .= print_r($contactinfo, true);
echo json_encode(array("returnValue"=>$html));

?>
