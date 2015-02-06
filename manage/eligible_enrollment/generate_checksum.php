<?php
$PUBLISHABLE_KEY = 'E1q20FOFf0-DcsrnQdltikaQrVI4nwwfhgXZ';
$API_KEY = '33b2e3a5-8642-1285-d573-07a22f8a15b4';

    $user_defined_field1_value = '';
    $user_defined_field2_value = '';
    $str = join("|", array($PUBLISHABLE_KEY, $_REQUEST['timestamp'], $user_defined_field1_value, $user_defined_field2_value, $API_KEY));
	$checksum = hash('sha512', $str);

header('Content-Type: application/json');

    echo '{"checksum":"'.$checksum.'","user_defined_field1":"", "user_defined_field2": "" }';


?>
