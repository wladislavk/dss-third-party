<?php
	$s = "SELECT last_reg_sect FROM dental_patients WHERE parent_patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."' OR patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."' ORDER BY last_reg_sect DESC";
	
	$r = $db->getRow($s);
	if($r['last_reg_sect'] >= 5) {
		$qp = 1;
	}else{
		$qp = 0;
	}

	$s = "SELECT * FROM dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."' OR parent_patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."'";
	
	$q1 = ($db->getNumberRows($s) > 0)?1:0;
	$s = "SELECT * FROM dental_q_sleep WHERE patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."' OR parent_patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."'";
	
	$qs = ($db->getNumberRows($s) > 0)?1:0;
	$s = "SELECT * FROM dental_q_page2 WHERE patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."' OR parent_patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."'";

	$q2 = ($db->getNumberRows($s) > 0)?1:0;
	$s = "SELECT * FROM dental_q_page3 WHERE patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."' OR parent_patientid='".mysqli_real_escape_string($con,$_SESSION['pid'])."'";

	$q3 = ($db->getNumberRows($s) > 0)?1:0;

	$comp = array();
	$comp['symptoms'] = $q1;
	$comp['epworth'] = $qs;
	$comp['treatments'] = $q2;
	$comp['history'] = $q3;
	$comp['registered'] = $qp;

	$tot_sect = 5;
	$comp_sect = $qp + $q1 + $qs + $q2 + $q3;
	$comp_perc = round(($comp_sect / $tot_sect) * 100);

	$questionnaire_completed = ($q1 == 1 && $qs == 1 && $q2 == 1 && $q3 == 1);
?>