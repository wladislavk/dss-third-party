<?php

function show_section_completed($pid){

  echo "This section has been completed";
  $links = '';
  $sql = "SELECT symptoms_status, sleep_status, treatments_status, history_status FROM dental_patients WHERE patientid='".mysql_real_escape_string($pid)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
  if($r['symptoms_status']==0){
    $links .= "<p><a href=\"symptoms.php\">Symptoms</a></p>";
  }

  if($r['sleep_status']==0 && ($r['symptoms_status']==0 || $r['symptoms_status']==1)){ //includes symptoms check since ESS and TSS is updated on that page in FO.
    $links .= "<p><a href=\"sleep.php\">Epworth/Thorton Scale</a></p>";
  }

  if($r['treatments_status']==0){
    $links .= "<p><a href=\"treatments.php\">Treatments</a></p>";
  }

  if($r['history_status']==0){
    $links .= "<p><a href=\"history.php\">History</a></p>";
  }


  if($links==''){
    echo "<p>All sections of questionnaire has been completed. Please <a href=\"index.php\">click here</a> to return to the home page.</p>";
  }else{
    echo $links;
  }

}

?>
