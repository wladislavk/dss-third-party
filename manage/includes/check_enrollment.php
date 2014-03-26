<?php
require_once '../admin/includes/main_include.php';
$npi = $_REQUEST['npi'];
$payer = $_REQUEST['payer'];

$data = array();
$data['api_key'] = "33b2e3a5-8642-1285-d573-07a22f8a15b4";
//$data['test'] = "true";
$data_string = json_encode($data);                                                                               

//echo $data_string."<br /><br />";
//$ch = curl_init('https://v1.eligibleapi.net/claim/submit.json?api_key=33b2e3a5-8642-1285-d573-07a22f8a15b4');                                                                      
$ch = curl_init('https://gds.eligibleapi.com/v1.1/enrollment_npis');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                              
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                  
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                      
    'Content-Type: application/json',                                                                            
    'Content-Length: ' . strlen($data_string))                                                                   
); 

$result = curl_exec($ch);
$enrolled = "no";
$json_response = json_decode($result);
$enrollments = $json_response->{"enrollment_npis"};
foreach($enrollments as $enrollment){
  if($enrollment->{"npi"} == $npi){
    foreach($enrollment->{"payer"} as $payer){
      if($payer->{"id"} == $payer){
        $enrolled = "yes";
      }
    }
  }
}

  echo '{"enrolled":"'.$enrolled.'"}';
?>
