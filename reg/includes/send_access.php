<?php
require_once("../twilio/twilio.config.php");
require_once '../../manage/admin/includes/main_include.php';

    // instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);

    // make an associative array of people we know, indexed by phone number. Feel
    // free to change/add your own phone number and name here.
    $people = array(
       // "+17173685684" => "Adam Bert"
    );

    $s = "SELECT * FROM dental_patients WHERE email='".mysql_real_escape_string($_POST['email'])."'";
    $q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);
      if($r['password']!=''){
	echo '{"error":"existing"}';
      }else{
                $recover_hash = substr(hash('sha256', $r['patientid'].$_POST['email'].rand()), 0, 7);
                $ins_sql = "UPDATE dental_patients set recover_hash='".$recover_hash."', recover_time=NOW() WHERE patientid='".$r['patientid']."'";
                mysql_query($ins_sql);

        // iterate over all our friends. $number is a phone number above, and $name 
        // is the name next to it
        if($r['cell_phone']!='') {
	
          // Send a new outgoing SMS 
          if($send_texts){
            $sms = $client->account->sms_messages->create(
              // the number we are sending from, must be a valid Twilio number
              $twilio_number, 
 
              // the number we are sending to - Any phone number
              $r['cell_phone'],
          
              // the sms body 
              "Your access code is ".$recover_hash
            );
          }
     
          // Display a confirmation message on the screen
	  $c = $r['cell_phone'];
	  $num = substr($c, strlen($c)-2);
          echo '{"success":true, "phone":'.$num.'}';
        }
      }
    }else{
	echo '{"error":"email"}';
    }
?> 
