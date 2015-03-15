<?php namespace Ds3\Libraries\Legacy; ?><?php
	$docid = $_SESSION['docid'];
	$sd = $_POST['start_date'];
	$ed = $_POST['end_date'];
	$de = $_POST['description'];
	$cat = $_POST['category'];
	$pi = $_POST['producer'];
	$id = $_POST['id'];
	$pid = $_POST['patient'];
	$res = $_POST['resource'];
	$r_type = $_POST['rec_type'];
	$r_pattern = $_POST['rec_pattern'];
	$e_length = empty($_POST['elength']) ? "''" : $_POST['elength'];
	$e_pid = empty($_POST['epid']) ? "''" : $_POST['epid'];

	include_once '../admin/includes/main_include.php';
	include_once 'checkemail.php';
	$s = "INSERT INTO dental_calendar
		(start_date, end_date, event_id, description, category, producer_id, docid, patientid, rec_type, rec_pattern, event_length, event_pid, res_id)
		VALUES
		('".$sd."', '".$ed."', '".$id."', '".mysqli_real_escape_string($con, $de)."', '".$cat."', ".$pi.", '".$docid."', '".$pid."', '" . $r_type . "', '" . $r_pattern . "', " . $e_length . ", " . $e_pid . ", " . $res . ")";

	if($db->query($s)){
		$sql2 = "SELECT * from dental_calendar as dc left join dental_patients as dp on dc.patientid = dp.patientid WHERE dc.event_id='".$id."' order by dc.id desc";

		if($r = $db->getRow($sql2)) {
			$fn = $r['firstname'];
			$ln = $r['lastname'];
			echo '{"success":true, "eventid":"' . $id .'"}';
		} else {
			echo '{"success":true, "eventid":"' . $id . '"}';
		}
	} else {
	  echo '{"error":true}';
	}
?>
