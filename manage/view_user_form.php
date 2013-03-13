<?php
session_start();
if($_GET['did']==$_SESSION['docid']){

// The location of the PDF file on the server.
$filename = "q_file/".$_GET['file']."_".$_GET['did'].".pdf";

if(!file_exists($filename)){
  require_once 'admin/includes/config.php';
  require_once 'admin/includes/general.htm';
  update_custom_release_form($_GET['did']);
}

// Let the browser know that a PDF file is coming.
header("Content-type: application/pdf");
header("Content-Length: " . filesize($filename));
header("Content-Disposition: attachment; filename=record_release.pdf");

// Send the file to the browser.
readfile($filename);

}else{
  ?><h2>You are not authorized to view this file.</h2><?php
}
?>
