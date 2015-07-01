<?php namespace Ds3\Libraries\Legacy; ?><?php

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

$sql = "SELECT u.userid, u.last_name, u.first_name"
  .			" FROM dental_users u"
  .			" WHERE (((last_name LIKE '" . $names[0] . "%' OR first_name LIKE '" . $names[0] . "%')"
        .               " AND (last_name LIKE '" . $names[1] . "%' OR first_name LIKE '" . $names[1] . "%'))"
        .               " OR (first_name LIKE '" . $names[0] ."%' AND last_name LIKE '" . $names[1] . "%'))"
	.		" AND u.docid=0"
	.		" ORDER BY last_name ASC";
$result = mysqli_query($con, $sql);

$patients = array();
$i = 0;
while ($row = mysqli_fetch_assoc($result)) {
  $patients[$i]['id'] = $row['userid'];
  $patients[$i]['name'] = $row['last_name'].", ".$row['first_name'];
  $i++;
}

if (!$result) {
	$patients = array("error" => "Error: Could not select users from database");
}

echo json_encode($patients);

?>
