<?php namespace Ds3\Libraries\Legacy; ?><?php
require 'admin/includes/main_include.php';

$tid = $_GET['tid'];

$c_sql = "SELECT id FROM companies";
$c_q = mysqli_query($con, $c_sql);
while($c = mysqli_fetch_assoc($c_q)){

$cid = $c['id'];
$s = "INSERT INTO dental_letter_templates (name, body, companyid, triggerid)
	SELECT name, body, '".$cid."', '".mysqli_real_escape_string($con, $tid)."' FROM dental_letter_templates 
		WHERE id='".mysqli_real_escape_string($con, $tid)."'";
//mysqli_query($con, $s);



}
