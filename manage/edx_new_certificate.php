<?php
//if($_SERVER['REMOTE_ADDR'] != '10.20.1.121'){ die(); }
include 'admin/includes/main_include.php';

$url = $_REQUEST['url'];
$edx_id = $_REQUEST['userid'];
$course_name = $_REQUEST['course_name'];
$course_section = $_REQUEST['course_section'];
$course_subsection = $_REQUEST['course_subsection'];
$number_ce = $_REQUEST['number_ce'];

$s = "INSERT INTO edx_certificates SET
	url='".mysql_real_escape_string($url)."',
	edx_id='".mysql_real_escape_string($edx_id)."',
	course_name='".mysql_real_escape_string($course_name)."',
	course_section='".mysql_real_escape_string($course_section)."',
	course_subsection='".mysql_real_escape_string($course_subsection)."',
	number_ce='".mysql_real_escape_string($number_ce)."',
	adddate = now(),
	ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
mysql_query($s);
?>
