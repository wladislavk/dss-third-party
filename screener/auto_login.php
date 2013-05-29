<?php
session_start();
$userid = $_SESSION['userid'];
$docid = $_SESSION['docid'];

session_destroy();
session_start();

session_register("screener_user");
$_SESSION['screener_user'] = $userid;
session_register("screener_doc");
$_SESSION['screener_doc'] = $docid;

?>

<script type="text/javascript">
  window.location = 'index.php';
</script>
