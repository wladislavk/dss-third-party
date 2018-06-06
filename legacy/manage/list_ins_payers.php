<?php namespace Ds3\Libraries\Legacy; ?><?php

require_once('admin/includes/main_include.php');
require_once("admin/includes/general.htm");
require_once('includes/constants.inc');
require_once('includes/formatters.php');

if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}

$data = json_decode(file_get_contents("https://eligible.com/resources/claims-payer.json"));

$payers = $data->claims_payer_list;
$patients = array();
$i = 0; 
foreach ($payers as $payer) {
        if (strstr(strtolower($payer->payer_name), strtolower($partial))) {

  $patients[$i]['id'] = $payer->payer_id."-".$payer->payer_name;
  $patients[$i]['name'] = $payer->payer_id ." - ".$payer->payer_name;
  $i++;
}
}
echo json_encode($patients);

?>
