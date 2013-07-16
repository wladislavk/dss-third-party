<?php
require_once '../admin/includes/main_include.php';
require_once '../admin/includes/general.htm';
$id = $_REQUEST['id'];
deliver_created_letter($id);


  echo '{"success":true}';
?>
