<?
	session_start();
	$con = mysql_connect("localhost","root","t3mp123") or die('connection failure');
	$db = mysql_select_db("dentalsl_site_dev") or die('DB connection failure');
	
	$base_path = 'http://'.$_SERVER['HTTP_HOST'].'/dental/';
	include("general.htm");
	$site_name = "Dental Sleep Solutions";
	$site_url = "dentalsleepsolutions.com";
?>
