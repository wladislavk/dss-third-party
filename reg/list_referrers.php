<?php
session_start();
require_once('../manage/admin/includes/config.php');
require_once("../manage/admin/includes/general.htm");
require_once('../manage/includes/constants.inc');
require_once('../manage/includes/formatters.php');
if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}
$names = explode(" ", $partial);

$doc_sql = "SELECT docid FROM dental_patients WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
$doc_q = mysql_query($doc_sql);
$doc = mysql_fetch_assoc($doc_q);
$docid = $doc['docid'];

$sql = "SELECT c.contactid, c.lastname, c.firstname, c.middlename, c.add1, c.add2, c.city, c.state, c.zip, c.phone1"
  .			" FROM dental_contact c"
  .			" WHERE ((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')"
        .               " AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
	.		" AND docid= ".$docid
        .               " ORDER BY lastname ASC";
$result = mysql_query($sql);

$patients = array();
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
  $patients[$i]['id'] = $row['contactid'];
  $patients[$i]['fname'] = $row['firstname'];
  $patients[$i]['lname'] = $row['lastname'];
  $patients[$i]['add1'] = $row['add1'];
  $patients[$i]['add2'] = $row['add2'];
  $patients[$i]['city'] = $row['city'];
  $patients[$i]['state'] = $row['state'];
  $patients[$i]['zip'] = $row['zip'];
  $patients[$i]['phone'] = $row['phone1'];


  $i++;
}

if (!$result) {
	$patients = array("error" => $sql."Error: Could not select patients from database");
}
echo json_encode($patients);

?>
