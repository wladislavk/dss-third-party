<?php

include 'twilio.config.php';

request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
"POST", array( 
"To" => "717-368-5684", 
"From" => "717-368-5684", 
"Body" => "test" 
)); 
if($response->IsError) 
echo "Error: {$response->ErrorMessage}"; 
else 

?> 
