<?php
require_once("twilio.config.php");
 
    // instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
 
    // make an associative array of people we know, indexed by phone number. Feel
    // free to change/add your own phone number and name here.
    $people = array(
        "+12105081928" => "Nathan Drake",
	"+17173685684" => "Adam Bert"
    );
 
    // iterate over all our friends. $number is a phone number above, and $name 
    // is the name next to it
    foreach ($people as $number => $name) {
 
        // Send a new outgoing SMS 
        /*$sms = $client->account->sms_messages->create(
            // the number we are sending from, must be a valid Twilio number
            "415-599-2671", 
 
            // the number we are sending to - Any phone number
            $number,
 
            // the sms body
            "Test of Twilio from DSS. I'll call you in a few minutes. - Adam"
        );*/
 
        // Display a confirmation message on the screen
        echo "Sent message to $name";
    }

?>
