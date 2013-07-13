<?php

error_log("CRONTAB");
require 'config.php';
require 'class.fax.php';

$sql = "SELECT f.*, c.companyid FROM dental_faxes f
		JOIN dental_user_company c ON c.userid = f.docid
		WHERE sfax_completed=0 AND sfax_transmission_id IS NOT NULL";
$q = mysql_query($sql);
while($r = mysql_fetch_assoc($q)){
$fts = new FTSSamples($r['companyid']);
$fax_status = $fts->OutboundFaxStatus($r['sfax_transmission_id']);
$comp = $fax_status['XwsFaxComplete'];
$response = json_encode($fax_status);
  if($comp){
    $success = ($fax_status['XwsFaxSuccess'])?1:2;
    $error_code = $fax_status['XwsFaxErrorCode'];
    $up_sql = "UPDATE dental_faxes SET sfax_completed='".mysql_real_escape_string($comp)."',
				sfax_response='".mysql_real_escape_string($response)."',
				sfax_status = '".mysql_real_escape_string($success)."',
				sfax_error_code = '".mysql_real_escape_string($error_code)."'
		WHERE id = '".mysql_real_escape_string($r['id'])."'";
    mysql_query($up_sql);
    if($success == 2){
      $let_sql = "UPDATE dental_letters SET status='0'";
      mysql_query($let_sql);
    }
  }
}

?>
