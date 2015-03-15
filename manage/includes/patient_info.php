<?php namespace Ds3\Libraries\Legacy; ?><?php
	$patient_info = 0;
	$sql = "SELECT patient_info FROM dental_patient_summary WHERE pid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."';";
	
	$result = $db->getResults($sql);
	if ($result) foreach ($result as $row) {
		$patient_info = $row['patient_info'];
	}
?>
