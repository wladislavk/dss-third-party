<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/manage/admin/includes/main_include.php');

if($_SESSION['userid'] == '')
{
	header('Location: login.php');
	die();
}else{
  $db->query("UPDATE dental_users SET last_accessed_date = NOW() WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'");
}
?>
