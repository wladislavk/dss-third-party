<?
	session_start();
	$con = mysql_connect("localhost","dentalsl_main","cr3at1vItYmain") or die('connection failure');	
	$db = mysql_select_db("dentalsl_main");
	
	$base_path = 'http://'.$_SERVER['HTTP_HOST'].'/dental/manage/';
	$sitename = "Dental";
	include("general.htm");
?>