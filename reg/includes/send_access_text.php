<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once("../twilio/twilio.config.php");
require_once '../../manage/admin/includes/main_include.php';

  $id = $_REQUEST['id'];
  $hash = $_REQUEST['hash'];

  $s = "SELECT * FROM dental_patients WHERE
	patientid=".mysql_real_escape_string($id)." AND
	recover_hash='".mysql_real_escape_string($hash)."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  if($r['text_num'] >= 5 && strtotime($r['text_date'])>(time()-3600)){
    echo '{"error":"limit"}';
    die();
  }
  if($r['access_code']=='' || strtotime($r['access_code_date']) < time()-86400){
                $recover_hash = rand(100000, 999999);//substr(hash('sha256', $r['patientid'].$r['email'].rand()), 0, 7);
                $ins_sql = "UPDATE dental_patients set registration_status=1, access_code='".$recover_hash."', access_code_date = NOW() WHERE patientid='".$r['patientid']."'";
                mysql_query($ins_sql);
  }else{
	$recover_hash = $r['access_code'];
  }
        // iterate over all our friends. $number is a phone number above, and $name 
        // is the name next to it
        if($r['cell_phone']!='') {
    // instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
          // Send a new outgoing SMS 
          if($send_texts){
            $sms = $client->account->sms_messages->create(
              // the number we are sending from, must be a valid Twilio number
              $twilio_number,

              // the number we are sending to - Any phone number
              $r['cell_phone'],

              // the sms body 
              "Your Dental Sleep Solutions access code is ".$recover_hash
            );
		if(strtotime($r['text_date'])<(time()-3600) || $r['text_num']==0){
		  mysql_query("UPDATE dental_patients SET text_num=1, text_date = NOW() WHERE patientid='".$r['patientid']."'");
		}else{
                  mysql_query("UPDATE dental_patients SET text_num=text_num+1 WHERE patientid='".$r['patientid']."'");
		}
		echo '{"success":true}';
          }else{
		echo '{"error":"inactive"}';
	  }
        }else{
		echo '{"error":"cell"}';
	}

?>
