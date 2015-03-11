<?php
require_once('../includes/constants.inc');
$PUBLISHABLE_KEY = 'E1q20FOFf0-DcsrnQdltikaQrVI4nwwfhgXZ';
$API_KEY = DSS_DEFAULT_ELIGIBLE_API_KEY;

    $user_defined_field1_value = '';
    $user_defined_field2_value = '';
    $str = join("|", array($PUBLISHABLE_KEY, $_REQUEST['timestamp'], $user_defined_field1_value, $user_defined_field2_value, $API_KEY));
	$checksum = hash('sha512', $str);

header('Content-Type: application/json');

    echo '{"checksum":"'.$checksum.'","user_defined_field1":"", "user_defined_field2": "" }';


?>
