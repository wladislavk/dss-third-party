<?
	session_start();
	$con = mysql_connect("localhost","root","t3mp123") or die('connection failure');	
	$db = mysql_select_db("dentalsl_main_dev");
	
	$base_path = 'http://'.$_SERVER['HTTP_HOST'].'/dental/manage/';
	$sitename = "Dental";
	include("general.htm");
?>
