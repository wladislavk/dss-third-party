<?php

require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once("admin/includes/general.htm");

if (isset($_POST['templateid']) && isset($_POST['patientid'])) {
	$templateid = $_POST['templateid'];
	$patientid = $_POST['patientid'];
} else {
	$html = "No data received.";
}

$md_list = get_mdcontactids($patientid, false);
$md_referral_list = get_mdreferralids($patientid, false);
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
  $contacts[$j]['status'] = $md['status'];
  $j++;
	$i++;
}

$i = 0;

  $contact_sql = "SELECT docsleep, docpcp, docdentist, docent, docmdother, docmdother2, docmdother3 FROM dental_patients where patientid = '".s_for($_POST['patientid'])."';";
  $contact_res = mysql_query($contact_sql);
  $row = mysql_fetch_array($contact_res);

  if($row['docsleep']!=''){
    $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid IN(".$row['docsleep'].");";
    $result = mysql_query($sql);
    $md = mysql_fetch_assoc($result);
    $contacts[$j]['type'] = 'md';
    $contacts[$j]['label'] = "Sleep MD";
    $contacts[$j]['id'] = $md['id'];
    $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    $contacts[$j]['email'] = $md['email'];
    $contacts[$j]['fax'] = $md['fax'];
    $contacts[$j]['status'] = $md['status'];
    $j++;
 }

  if($row['docpcp']!=''){
    $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docpcp'].";";
error_log($sql);
    $result = mysql_query($sql);
    $md = mysql_fetch_assoc($result);
    $contacts[$j]['type'] = 'md';
    $contacts[$j]['label'] = "Primary Care MD";
    $contacts[$j]['id'] = $md['id'];
    $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    $contacts[$j]['email'] = $md['email'];
    $contacts[$j]['fax'] = $md['fax'];
    $contacts[$j]['status'] = $md['status'];
    $j++;
 }

  if($row['docdentist']!=''){
    $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docdentist'].";";
error_log($sql);
    $result = mysql_query($sql);
    $md = mysql_fetch_assoc($result);
    $contacts[$j]['type'] = 'md';
    $contacts[$j]['label'] = "Dentist";
    $contacts[$j]['id'] = $md['id'];
    $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    $contacts[$j]['email'] = $md['email'];
    $contacts[$j]['fax'] = $md['fax'];
    $contacts[$j]['status'] = $md['status'];
    $j++;
 }

  if($row['docent']!=''){
    $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docent'].";";
error_log($sql);
    $result = mysql_query($sql);
    $md = mysql_fetch_assoc($result);
    $contacts[$j]['type'] = 'md';
    $contacts[$j]['label'] = "ENT";
    $contacts[$j]['id'] = $md['id'];
    $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    $contacts[$j]['email'] = $md['email'];
    $contacts[$j]['fax'] = $md['fax'];
    $contacts[$j]['status'] = $md['status'];
    $j++;
 }

  if($row['docmdother']!=''){
    $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docmdother'].";";
    $result = mysql_query($sql);
    $md = mysql_fetch_assoc($result);
    $contacts[$j]['type'] = 'md';
    $contacts[$j]['label'] = "Other MD";
    $contacts[$j]['id'] = $md['id'];
    $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    $contacts[$j]['email'] = $md['email'];
    $contacts[$j]['fax'] = $md['fax'];
    $contacts[$j]['status'] = $md['status'];
    $j++;
 }
  if($row['docmdother2']!=''){
    $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docmdother2'].";";
    $result = mysql_query($sql);
    $md = mysql_fetch_assoc($result);
    $contacts[$j]['type'] = 'md';
    $contacts[$j]['label'] = "Other MD";
    $contacts[$j]['id'] = $md['id'];
    $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    $contacts[$j]['email'] = $md['email'];
    $contacts[$j]['fax'] = $md['fax'];
    $contacts[$j]['status'] = $md['status'];
    $j++;
 }
  if($row['docmdother3']!=''){
    $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docmdother3'].";";
    $result = mysql_query($sql);
    $md = mysql_fetch_assoc($result);
    $contacts[$j]['type'] = 'md';
    $contacts[$j]['label'] = "Other MD";
    $contacts[$j]['id'] = $md['id'];
    $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
    $contacts[$j]['email'] = $md['email'];
    $contacts[$j]['fax'] = $md['fax'];
    $contacts[$j]['status'] = $md['status'];
    $j++;
 }


/*foreach ($contactinfo['mds'] as $md) {
//	$contacts[$j]['html'] = "<input class=\"md_checkbox\" type=\"checkbox\" name=\"contacts[mds][$i]\" value=\"" . $md['id'] . "\" />MD: " . $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'] . "<br />";
  $contacts[$j]['type'] = 'md';
  $contacts[$j]['id'] = $md['id'];
  $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
  $contacts[$j]['email'] = $md['email'];
  $contacts[$j]['fax'] = $md['fax'];
  $contacts[$j]['status'] = $md['status'];
  $j++;
	$i++;
}
*/
//$html .= print_r($contactinfo, true);
echo json_encode($contacts);

?>
