<?php
session_start();
$docid = $_SESSION['docid'];
$id = $_POST['id'];

require_once '../admin/includes/main_include.php';
require_once 'checkemail.php';

$sql = "SELECT * from dental_calendar as dc left join dental_appt_types as dt on dc.category = dt.classname and dc.docid=dt.docid WHERE dc.event_id='".$id."' order by dc.id desc";
$q = mysql_query($sql);
if($r = mysql_fetch_assoc($q))
{
	$etype = $r['name'];
	echo '{"success":true, "etype":"' . $etype . '"}';
}
else
{
	echo '{"success":false"}';
}
?>
