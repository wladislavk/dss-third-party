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

$names = explode(" ", $partial);

$sql = "SELECT c.contactid, c.lastname, c.firstname, c.middlename, national_provider_id, '".DSS_REFERRED_PHYSICIAN."' as referral_type, ct.contacttype"
  .			" FROM dental_contact c"
  .             " JOIN dental_contacttype ct ON c.contacttypeid=ct.contacttypeid"
  .			" WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')"
        .               " AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
        .               " OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))"
        .               " AND docid = '" . $_SESSION['docid'] . "' "
        .               " AND c.status=1 "
	.		" AND ct.physician=1"
	.		" AND merge_id IS NULL ORDER BY lastname ASC";
$result = mysql_query($sql);

$patients = array();
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
  $patients[$i]['id'] = $row['national_provider_id'];
  $patients[$i]['name'] = $row['lastname'].", ".$row['firstname'];
  $patients[$i]['source'] = $row['referral_type'];
  $i++;
}

if (!$result) {
	$patients = array("error" => $sql."Error: Could not select patients from database");
}

echo json_encode($patients);

?>
