<?php
namespace Ds3\Libraries\Legacy;

require_once '../admin/includes/main_include.php';
require_once 'checkemail.php';
$id = $_REQUEST['id'];
$u = $_REQUEST['username'];
$e = $_REQUEST['email'];

if(checkUsername($u, $id)){
  echo '{"error":true, "username":true}';
}elseif(checkUserEmail($e, $id)){
  echo '{"error":true, "email":true}';
}else{
  echo '{"success":true}';
}
