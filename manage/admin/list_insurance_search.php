<?php namespace Ds3\Legacy; ?><?php

require_once('includes/main_include.php');
include("includes/sescheck.php");
require_once("includes/general.htm");
require_once('../includes/constants.inc');
require_once('../includes/formatters.php');

if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}
$names = explode(" ", $partial);

$sql = "SELECT c.contactid, c.company "
  .			" FROM dental_contact c"
  .			" WHERE (company LIKE '%" . $names[0] . "%')"
        .               " AND docid = '" . mysql_real_escape_string($_GET['fid']) . "' "
        .               " AND c.status=1 "
	.		" AND merge_id IS NULL ORDER BY c.company ASC";
$result = mysql_query($sql) or die(mysql_error());

$patients = array();
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
  $patients[$i]['id'] = $row['contactid'];
  $patients[$i]['name'] = $row['company'];
  $i++;
}

if (!$result) {
	$patients = array("error" => $sql."Error: Could not select patients from database");
}

echo json_encode($patients);

?>
