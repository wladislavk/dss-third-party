<?php
namespace Ds3\Libraries\Legacy;

require_once '../../manage/admin/includes/main_include.php';
require_once '../../manage/includes/checkemail.php';

$e = checkEmail($_REQUEST['email'], $_REQUEST['id']);
if($e==0){
    echo 'true';
}else{
    echo 'false';
}
