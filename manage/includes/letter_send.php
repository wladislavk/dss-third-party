<?php namespace Ds3\Legacy; ?><?php
require_once '../admin/includes/main_include.php';
require_once '../admin/includes/general.htm';
require_once '../admin/includes/invoice_functions.php';
require_once 'constants.inc';
$id = $_REQUEST['id'];
deliver_created_letter($id);


  echo '{"success":true}';
?>
