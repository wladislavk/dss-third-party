<?php
require_once '../admin/includes/config.php';
require_once '../admin/includes/general.htm';
$id = $_REQUEST['id'];
deliver_created_letter($id);


  echo '{"success":true}';
?>
