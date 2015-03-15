<?php namespace Ds3\Legacy; ?><?php
session_start();
$userid = $_SESSION['userid'];
$docid = $_SESSION['docid'];

session_destroy();
session_start();

$_SESSION['screener_user'] = $userid;
$_SESSION['screener_doc'] = $docid;

?>

<script type="text/javascript">
	window.location = 'index.php';
</script>
