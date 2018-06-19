<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/main_include.php';

if (empty($_SESSION["adminuserid"])) { ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
} else {
    $query = "UPDATE admin SET last_accessed_date = NOW() WHERE adminid='".$db->escape($_SESSION['adminuserid'])."'";
    mysqli_query($con, $query);
}
