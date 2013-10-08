<? 
	if($_SESSION["adminuserid"] == "")
	{
		?>
		<script type="text/javascript">
			window.location = "index.php";
		</script>
		<?
		die();
	}else{
		mysql_query("UPDATE admin SET last_accessed_date = NOW() WHERE adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'");
	}

?>
