<?php namespace Ds3\Legacy; ?><?php
$PUBLISHABLE_KEY = '-a7xWM5Kn7V9sciZtT4zV92dlpp_RWvnpHS-';
$API_KEY = 'hCmEKZG7_KQ8mS4ztO3EJWKP1KEWvwW5Bdvx';

    $user_defined_field1_value = '';
    $user_defined_field2_value = '';
    $str = join("|", array($PUBLISHABLE_KEY, $_REQUEST['timestamp'], $user_defined_field1_value, $user_defined_field2_value, $API_KEY));
	$checksum = hash('sha512', $str);

header('Content-Type: application/json');

    echo '{"checksum":"'.$checksum.'","user_defined_field1":"", "user_defined_field2": "" }';


?>
