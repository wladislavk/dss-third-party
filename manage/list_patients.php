<?php

require_once('admin/includes/config.php');
include("includes/sescheck.php");
require_once("admin/includes/general.htm");

if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}

$names = explode(" ", $partial);

$sql = "SELECT patientid, lastname, firstname, middlename, status AS stat, premedcheck"
	.		" FROM dental_patients"
	.		" WHERE ((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
	.		" AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
	.		" AND docid = '" . $_SESSION['docid'] . "' ORDER BY lastname ASC;";
$result = mysql_query($sql);

$patients = array();
while ($row = mysql_fetch_assoc($result)) {
	$patients[] = $row;
}

if (!$result) {
	$patients = array("error" => "Error: Could not select patients from database");
}

echo json_encode($patients);

?>
