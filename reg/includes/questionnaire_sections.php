<?php namespace Ds3\Libraries\Legacy; ?><?php

function show_section_completed($pid){

  $links_title = "<p>The section you are trying to access has been completed. Please click any of the sections below to complete your Questionnaire:</p>";
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
    $s = "SELECT u.name, u.phone FROM dental_users u
		JOIN dental_patients p ON u.userid=p.docid
		WHERE p.patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
    $q = mysql_query($s);
    $r = mysql_fetch_assoc($q);
    echo "<p>All sections of questionnaire has been completed. Please <a href=\"index.php\">click here</a> to return to the home page. If you need to make changes to the questionnaire please contact ".$r['name']." at ".format_phone($r['phone'])."</p>";
  }else{
    echo $links_title . $links;
  }

}

?>
