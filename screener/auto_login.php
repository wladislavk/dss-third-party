<?php
session_start();

session_register("screener_user");
$_SESSION['screener_user'] = $_SESSION['userid'];
session_register("screener_doc");
$_SESSION['screener_doc'] = $_SESSION['docid'];

?>

<script type="text/javascript">
  window.location = 'index.php';
</script>
