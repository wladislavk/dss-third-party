<?php
require_once '../../admin/includes/main_include.php';
require_once '../../includes/checkemail.php';
if($_REQUEST['code']=='dss456'){
  echo 'true';//'{"success":true}';
}else{
  echo 'false';//'{"error":false}';
}
?>
