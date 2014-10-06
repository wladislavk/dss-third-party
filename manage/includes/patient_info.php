<?php
	$patient_info = 0;
	$sql = "SELECT patient_info FROM dental_patient_summary WHERE pid = '".$_GET['pid']."';";
	
	$result = $db->getResults($sql);
	foreach ($result as $row) {
		$patient_info = $row['patient_info'];
	}
?>
