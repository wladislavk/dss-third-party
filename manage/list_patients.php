<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once("admin/includes/general.htm");
	include_once('includes/constants.inc');
	include_once('includes/formatters.php');

	$partial = '';
	if (isset($_POST['partial_name'])) {
		$partial = $_POST['partial_name'];
		$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
		$partial = s_for($partial);
	}

	$names = explode(" ", $partial);

	$sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, "
		 . " s.patient_info "
		 . " FROM dental_patients p"
		 . " LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
		 . " WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
		 . " AND (lastname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%' OR firstname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%'))"
		 . " OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .(!empty($names[1]) ? $names[1] : '')."%' AND lastname LIKE '" . (!empty($names[2]) ? $names[2] : '') . "%'))"
		 . " AND p.status=1 "
		 . " AND docid = '" . $_SESSION['docid'] . "' ORDER BY lastname ASC LIMIT 12;";

	$result = $db->getResults($sql);
	$patients = array();
	$i = 0;
	if ($result) foreach ($result as $row) {
		$patients[$i]['patientid'] = $row['patientid'];
		$patients[$i]['lastname'] = $row['lastname'];
		$patients[$i]['firstname'] = $row['firstname'];
		$patients[$i]['middlename'] = $row['middlename'];
		$patients[$i]['patient_info'] = $row['patient_info'];
		$i++;
	}

	if (!$result) {
		$patients = array("error" => $sql ." Error: Could not select patients from database");
	}

	echo json_encode($patients);
?>
