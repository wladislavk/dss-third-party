<?php
	$docid = $_SESSION['docid'];
	$id = $_POST['id'];

	include_once '../admin/includes/main_include.php';
	include_once 'checkemail.php';

	$sql = "SELECT * from dental_calendar as dc left join dental_appt_types as dt on dc.category = dt.classname and dc.docid=dt.docid WHERE dc.event_id='".$id."' order by dc.id desc";
	
	if($r = $db->getRow($sql)) {
		$etype = $r['name'];
		echo '{"success":true, "etype":"' . $etype . '"}';
	} else {
		echo '{"success":false"}';
	}
?>
