<?php namespace Ds3\Legacy; ?><?php
require_once 'main_include.php';
$id = $_REQUEST['id'];
$s = "SELECT body FROM dental_letter_templates
        WHERE id='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
if($r = mysql_fetch_assoc($q)){
  $body = $r['body'];
  $body = str_replace('"','\"',$body);
  $body = str_replace('
', '<br />', $body);
  echo '{"success":true, "body":"'.$body.'"}';
}else{
  echo '{"error":true}';
}
?>

