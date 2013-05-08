<?php
require 'admin/includes/config.php';

$tid = $_GET['tid'];

$c_sql = "SELECT id FROM companies";
$c_q = mysql_query($c_sql);
while($c = mysql_fetch_assoc($c_q)){

$cid = $c['id'];
$s = "INSERT INTO dental_letter_templates (name, body, companyid, triggerid)
	SELECT name, body, '".$cid."', '".mysql_real_escape_string($tid)."' FROM dental_letter_templates 
		WHERE id='".mysql_real_escape_string($tid)."'";
//mysql_query($s);



}
