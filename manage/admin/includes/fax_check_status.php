<?php

require(dirname(__FILE__).'/class.fax.php');
require(dirname(__FILE__).'/config.php');

$sql = "SELECT f.*, c.companyid FROM dental_faxes f
                JOIN dental_user_company c ON c.userid = f.docid
                WHERE sfax_completed=0 AND sfax_transmission_id IS NOT NULL";
$q = mysql_query($sql);
while($r = mysql_fetch_assoc($q)){
$_SESSION['companyid'] = $r['companyid'];
$fts = new FTSSamples($r['companyid']);
$fax_status = $fts->OutboundFaxStatus($r['sfax_transmission_id']);
$fax_status = json_decode($fax_status, true);
$items = $fax_status['RecipientFaxStatusItems'];
//print_r($items);
$comp = $items[0]['IsSuccess'];
$response = json_encode($fax_status);
  if($comp){
    $success = ($comp)?'1':'2';
    $error_code = $fax_status['ErrorCode'];
    $up_sql = "UPDATE dental_faxes SET sfax_completed='".mysql_real_escape_string($comp)."',
                                sfax_response='".mysql_real_escape_string($response)."',
                                sfax_status = '".mysql_real_escape_string($success)."',
                                sfax_error_code = '".mysql_real_escape_string($error_code)."'
                WHERE id = '".mysql_real_escape_string($r['id'])."'";
    mysql_query($up_sql);
    if($success == '2'){
      $let_sql = "UPDATE dental_letters SET status='0' WHERE letterid='".mysql_real_escape_string($r['letterid'])."'";
      mysql_query($let_sql);
    }
  }
}

?>

