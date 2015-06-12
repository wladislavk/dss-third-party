<?php namespace Ds3\Libraries\Legacy; ?><?php
	$docid = $_SESSION['docid'];
	$id = $_POST['id'];

	include_once '../admin/includes/main_include.php';
	include_once 'checkemail.php';

	$sql = "SELECT * from dental_calendar as dc left join dental_patients as dp on dc.patientid = dp.patientid WHERE dc.event_id='".$id."' order by dc.id desc";
	
	if($r = $db->getRow($sql)) {
		$fn = $r['firstname'];
		$ln = $r['lastname'];
		echo '{"success":true, "firstname":"' . $fn . '", "lastname":"' . $ln . '"}';
	} else {
		echo '{"success":false, "eventid":"' . $id . '"}';
	}
?>
