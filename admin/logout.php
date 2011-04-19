<?php
session_start();

session_unset();
?>
<script type="text/javascript">
	alert("Logged out ");
	window.location = "index.php";
	die();
</script>