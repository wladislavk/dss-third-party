<?php
session_start();
require 'includes/sescheck.php';
$f = $_GET['f'];
$ft =  mime_content_type('../../../shared/q_file/'.$f);
if($ft == 'application/pdf' || $ft == 'application/vnd.ms-office' || $ft == 'application/msword' || $ft == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $ft == 'application/vnd.ms-excel' || $ft == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $ft == 'application/x-zip' || $ft == 'application/x-zip-compressed' || $ft == 'application/zip'){
  header('Content-type: '.$ft);
  header('Content-Disposition: inline; filename="'.$f.'"');
  readfile('../../../shared/q_file/'.$f);
}else{
  header('Content-Type: '. $ft);
  readfile('../../../shared/q_file/'.$f);
}
?>
