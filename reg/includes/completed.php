<?php

$s = "SELECT registered FROM dental_patients WHERE parent_patientid='".mysql_real_escape_string($_SESSION['pid'])."' OR patientid='".mysql_real_escape_string($_SESSION['pid'])."' ORDER BY registered DESC";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);
if($r['registered']==1){
	$qp=1;
}else{
	$qp=0;
}

$s = "SELECT * FROM dental_q_page1 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
$q = mysql_query($s);
$q1 = mysql_num_rows($q);

$s = "SELECT * FROM dental_q_sleep WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
$q = mysql_query($s);
$qs = mysql_num_rows($q);

$s = "SELECT * FROM dental_q_page2 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
$q = mysql_query($s);
$q2 = mysql_num_rows($q);

$s = "SELECT * FROM dental_q_page3 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
$q = mysql_query($s);
$q3 = mysql_num_rows($q);

$comp = array();
$comp['symptoms'] = $q1;
$comp['epworth'] = $qs;
$comp['treatments'] = $q2;
$comp['history'] = $q3;
$comp['registered'] = $qp;

$tot_sect = 5;
$comp_sect = $qp + $q1 + $qs + $q2 + $q3;
$comp_perc = round(($comp_sect/$tot_sect)*100);



?>
