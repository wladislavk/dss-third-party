<?php namespace Ds3\Legacy; ?><?php
	include 'admin/includes/main_include.php';

	$url = (!empty($_REQUEST['url']) ? $_REQUEST['url'] : '');
	$edx_id = (!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : '');
	$course_name = (!empty($_REQUEST['course_name']) ? $_REQUEST['course_name'] : '');
	$course_section = (!empty($_REQUEST['course_section']) ? $_REQUEST['course_section'] : '');
	$course_subsection = (!empty($_REQUEST['course_subsection']) ? $_REQUEST['course_subsection'] : '');
	$number_ce = (!empty($_REQUEST['number_ce']) ? $_REQUEST['number_ce'] : '');

	$s = "INSERT INTO edx_certificates SET
		url='".mysqli_real_escape_string($con, $url)."',
		edx_id='".mysqli_real_escape_string($con, $edx_id)."',
		course_name='".mysqli_real_escape_string($con, $course_name)."',
		course_section='".mysqli_real_escape_string($con, $course_section)."',
		course_subsection='".mysqli_real_escape_string($con, $course_subsection)."',
		number_ce='".mysqli_real_escape_string($con, $number_ce)."',
		adddate = now(),
		ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'";
	
	$db->query($s);
?>
