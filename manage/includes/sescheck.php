<?
if($_SESSION['userid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = "login.php";
	</script>
	<?
	die();
}else{
  mysql_query("UPDATE dental_users SET last_accessed_date = NOW() WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'");
}
?>
