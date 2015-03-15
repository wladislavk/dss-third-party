<?php namespace Ds3\Libraries\Legacy; ?><?php
session_start();

$_SESSION["adminuserid"] = '';
?>
<script type="text/javascript">
	alert("Logged out ");
	window.location = "index.php";
	die();
</script>
