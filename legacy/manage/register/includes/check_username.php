<?php
namespace Ds3\Libraries\Legacy;

require_once '../../admin/includes/main_include.php';
require_once '../../includes/checkemail.php';

$e = checkUsername($_REQUEST['username'], $_REQUEST['id']);
if($e==0){
  echo 'true';
}else{
  echo 'false';
}
