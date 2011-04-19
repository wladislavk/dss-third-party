<? session_start();
include "admin/includes/config.php";

$login_up_sql = "update dental_login set logout_date = now() where loginid='".$_SESSION['loginid']."'";
mysql_query($login_up_sql);

$_SESSION['userid'] = '';
?>
<script type="text/javascript">
	alert("Logout Successfully");
	window.location = "login.php";
</script>
<?
die();
?>