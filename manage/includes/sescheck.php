<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/manage/admin/includes/main_include.php');

if(empty($_SESSION['userid']))
{
	header('Location: login.php');
	trigger_error("Die called", E_USER_ERROR);
}else{
  $db->query("UPDATE dental_users SET last_accessed_date = NOW() WHERE userid='".mysqli_real_escape_string($con, $_SESSION['userid'])."'");
}
?>
