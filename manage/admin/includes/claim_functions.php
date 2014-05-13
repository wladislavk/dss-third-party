<?php


function claim_status_history_update($insuranceid, $new, $old, $userid){
  if($old != $new){
    $sql = "INSERT INTO dental_insurance_status_history SET
		insuranceid='".mysql_real_escape_string($insuranceid)."',
		status='".mysql_real_escape_string($new)."',
		userid='".mysql_real_escape_string($userid)."',
		adddate=now(),
		ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    mysql_query($sql);
  }
}


function claim_file_secondary($id){
  //copy all data from existing primary claim to new row for secondary

}


?>
