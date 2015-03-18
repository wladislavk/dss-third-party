<?php namespace Ds3\Libraries\Legacy; ?><? 
	if($_SESSION["adminuserid"] == "")
	{
		?>
		<script type="text/javascript">
			alert("Admin Area, Please Login");
			window.location = "index.php";
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}

?>
