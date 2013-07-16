<?php

require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once("admin/includes/general.htm");
require_once('includes/constants.inc');
require_once('includes/formatters.php');

if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}


$sql = "SELECT p.id, p.name, p.payer_id "
  .			" FROM dental_ins_payer p"
  .			" WHERE name LIKE '%" . $partial . "%' "
        .               " ORDER BY name ASC";
$result = mysql_query($sql);

$patients = array();
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
  $patients[$i]['id'] = $row['id'];
  $patients[$i]['name'] = $row['payer_id'] ." - ".$row['name'];
  //$patients[$i]['source'] = $row['referral_type'];
  $i++;
}

if (!$result) {
	$patients = array("error" => $sql."Error: Could not select patients from database");
}

echo json_encode($patients);

?>
