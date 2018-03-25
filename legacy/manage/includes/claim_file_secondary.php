<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once '../admin/includes/main_include.php';
require_once '../includes/constants.inc';
require_once '../includes/claim_functions.php';
require_once '../admin/includes/claim_functions.php';
$pid = $_GET['pid'];
$cid = $_GET['cid'];
$prod = $_GET['prod'];
  $id = claim_create_sec($pid, $cid, $prod, false);
  ?>
  <script type="text/javascript">
    parent.window.location = parent.window.location;
  </script>

