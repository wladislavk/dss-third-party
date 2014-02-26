<?php
session_start();
require 'includes/sescheck.php';
$f = $_GET['f'];
$ft =  mime_content_type('../../shared/q_file/'.$f);
if($ft == 'application/pdf'){
  header('Content-type: application/pdf');
  header('Content-Disposition: attachment; filename="'.$f.'"');
  readfile('../../../shared/q_file/'.$f);
}else{
  header('Content-Type: '. $ft);
  readfile('../../../shared/q_file/'.$f);
}
?>
