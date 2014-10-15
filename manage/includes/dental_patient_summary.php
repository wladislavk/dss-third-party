<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/manage/admin/includes/general.htm');

	function update_patient_summary($pid = null, $column = null, $value = null)
	{
		$db = new Db();
		
		if (empty($pid) || empty($column)) {
			return 0;
		}

		$insert = false;
		$sql = "SELECT pid FROM dental_patient_summary WHERE pid = '".s_for($pid)."';";

		if ($db->getNumberRows($sql) == 0) {
			$insert = true;
		}

		if ($insert) {
			$sql = "INSERT INTO dental_patient_summary (pid, ".s_for($column).") VALUES (".s_for($pid).", ".s_for($value).");";
			$result = $db->query($sql);
		} else {
			$sql = "UPDATE dental_patient_summary SET ".s_for($column)." = '".s_for($value)."' WHERE pid = '".s_for($pid)."';";
			$result = $db->query($sql);
		}

		return $result;
	}
?>
