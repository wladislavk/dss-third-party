<?php
	$docid = $_SESSION['docid'];
	$sd = $_POST['start_date'];
	$ed = $_POST['end_date'];
	$de = $_POST['description'];
	$cat = $_POST['category'];
	$pi = $_POST['producer'];
	$pid = $_POST['patient'];
	$e_id = $_POST['e_id'];
	$t_id = $_POST['t_id'];
	$res = $_POST['resource'];
	$r_type = $_POST['rec_type'];
	$r_pattern = $_POST['rec_pattern'];
	$e_length = empty($_POST['elength']) ? "''" : $_POST['elength'];
	$e_pid = empty($_POST['epid']) ? "''" : $_POST['epid'];

	include_once '../admin/includes/main_include.php';
	include_once 'checkemail.php';

	$s = "UPDATE dental_calendar SET
		start_date='".$sd."',
		end_date='".$ed."',
		event_id='".$e_id."',
		description='".mysqli_real_escape_string($con,$de)."',
		category='".$cat."',
		producer_id=".$pi.",
		res_id=".$res.",
		rec_type='".$r_type."',
	        rec_pattern='".$r_pattern."',
		event_length=".$e_length.",
		event_pid=".$e_pid.",
		patientid=".$pid."
		WHERE event_id='".$e_id."'";

	if($db->query($s)) {
	  echo '{"success":true, "eventid":"' . $e_id .'"}';
	} else {
	  echo '{"error":true}';
	}
?>
