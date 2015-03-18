<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once("../../../reg/twilio/twilio.config.php");
  include_once '../../admin/includes/main_include.php';

  $id = $_REQUEST['id'];
  $hash = $_REQUEST['hash'];

  $s = "SELECT * FROM dental_users WHERE
      	userid=".mysqli_real_escape_string($con, $id)." AND
      	recover_hash='".mysqli_real_escape_string($con, $hash)."'";

  $r = $db->getRow($s);
  if($r['text_num'] >= 5 && strtotime($r['text_date'])>(time()-3600)){
    echo '{"error":"limit"}';
    trigger_error("Die called", E_USER_ERROR);
  }

  if($r['access_code']=='' || strtotime($r['access_code_date']) < time()-86400){
    $recover_hash = rand(100000, 999999);//substr(hash('sha256', $r['patientid'].$r['email'].rand()), 0, 7);
    $ins_sql = "UPDATE dental_users set access_code='".$recover_hash."', access_code_date = NOW() WHERE userid='".$r['userid']."'";
    $db->query($ins_sql);
  }else{
	  $recover_hash = $r['access_code'];
  }

  // iterate over all our friends. $number is a phone number above, and $name 
  // is the name next to it
  if($r['phone']!='') {
    // instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
          // Send a new outgoing SMS 
    if($send_texts){
      $sms = $client->account->sms_messages->create(
        // the number we are sending from, must be a valid Twilio number
        $twilio_number,

        // the number we are sending to - Any phone number
        $r['phone'],

        // the sms body 
        "Your Dental Sleep Solutions access code is ".$recover_hash
      );

  		if(strtotime($r['text_date'])<(time()-3600) || $r['text_num'] == 0) {
  		  $db->query("UPDATE dental_users SET text_num=1, text_date = NOW() WHERE userid='".$r['userid']."'");
  		} else {
        $db->query("UPDATE dental_users SET text_num=text_num+1 WHERE userid='".$r['userid']."'");
  		}

		  echo '{"success":true}';
    }else{
		  echo '{"error":"inactive"}';
	  }
  } else {
		echo '{"error":"cell"}';
	}
?>
