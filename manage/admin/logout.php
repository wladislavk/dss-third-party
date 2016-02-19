<?php
namespace Ds3\Libraries\Legacy;

session_start();
$_SESSION["adminuserid"] = '';

?>
<script type="text/javascript">
    alert("Logged out ");
    window.location = "index.php";
</script>
