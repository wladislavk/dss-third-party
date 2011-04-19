<?
if($_SESSION['userid'] == '')
{
	?>
	<script type="text/javascript">
		alert("Members Area, Please Login");
		window.location = "login.php";
	</script>
	<?
	die();
}
?>