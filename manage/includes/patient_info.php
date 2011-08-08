<?php
$patient_info = 0;
$sql = "SELECT patient_info FROM dental_patient_summary WHERE pid = '".$_GET['pid']."';";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$patient_info = $row['patient_info'];
}
?>
