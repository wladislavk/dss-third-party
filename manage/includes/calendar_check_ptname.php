<?php
session_start();
$docid = $_SESSION['docid'];
$id = $_POST['id'];

require_once '../admin/includes/main_include.php';
require_once 'checkemail.php';

$sql = "SELECT * from dental_calendar as dc left join dental_patients as dp on dc.patientid = dp.patientid WHERE dc.event_id='".$id."' order by dc.id desc";
$q = mysql_query($sql);
if($r = mysql_fetch_assoc($q))
{
	$fn = $r['firstname'];
	$ln = $r['lastname'];
	echo '{"success":true, "firstname":"' . $fn . '", "lastname":"' . $ln . '"}';
}
else
{
	echo '{"success":false, "eventid":"' . $id . '"}';
}
?>
