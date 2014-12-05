<?php
	include_once 'main_include.php';

	if(empty($_SESSION["adminuserid"]))
	{
		?>
		<script type="text/javascript">
			window.location = "index.php";
		</script>
		<?php 
		die();
	}else{
		$query = "UPDATE admin SET last_accessed_date = NOW() WHERE adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."'";
		mysqli_query($con, $query);
	}
?>