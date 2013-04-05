<?php
  session_start();
  require_once 'admin/includes/config.php';
  require_once 'admin/includes/general.htm';
  require_once 'admin/includes/form_updates.php';
  require_once 'includes/constants.inc';
if($_GET['did']==$_SESSION['docid']){
  $filename = "q_file/".$_GET['file']."_".$_GET['did'].".pdf";
  if($_GET['file'] == "user_record_release"){ 

    if(!file_exists($filename)){
      update_custom_release_form($_GET['did']);
    }

  }elseif($_GET['file'] == "financial_agreement_medicare"){
    if(!file_exists($filename)){
      update_financial_agreement_medicare_form($_GET['did']);
    }

  }elseif($_GET['file'] == "home_care_instructions"){
    if(!file_exists($filename)){
      update_home_care_instructions_form($_GET['did']);
    }

  }elseif($_GET['file'] == "non_dentist_of_record_release"){
    if(!file_exists($filename)){
      update_non_dentist_of_record_release_form($_GET['did']);
    }

  }elseif($_GET['file'] == "sleep_recorder_release"){
    if(!file_exists($filename)){
      update_sleep_recorder_release_form($_GET['did']);
    }
  }elseif($_GET['file'] == "affidavit_for_cpap_intolerance"){
    if(!file_exists($filename)){
      update_affidavit_for_cpap_intolerance_form($_GET['did']);
    }
  }elseif($_GET['file'] == "device_titration_ema"){
    if(!file_exists($filename)){
      update_device_titration_ema_form($_GET['did']);
    }
  }elseif($_GET['file'] == "device_titration"){
    if(!file_exists($filename)){
      update_device_titration_form($_GET['did']);
    }
  }elseif($_GET['file'] == "ess_tss_form"){
    if(!file_exists($filename)){
      update_ess_tss_form($_GET['did']);
    }
  }elseif($_GET['file'] == "financial_agreement"){
    if(!file_exists($filename)){
      update_financial_agreement_form($_GET['did']);
    }
  }elseif($_GET['file'] == "informed_consent"){
    if(!file_exists($filename)){
      update_informed_consent_form($_GET['did']);
    }
  }elseif($_GET['file'] == "lomn_rx"){
    if(!file_exists($filename)){
      update_lomn_rx_form($_GET['did']);
    }
  }elseif($_GET['file'] == "medical_hx_update"){
    if(!file_exists($filename)){
      update_medical_hx_update_form($_GET['did']);
    }
  }elseif($_GET['file'] == "the_dss_experience"){
    if(!file_exists($filename)){
      update_the_dss_experience_form($_GET['did']);
    }
  }



  // Let the browser know that a PDF file is coming.
  header("Content-type: application/pdf");
  header("Content-Length: " . filesize($filename));
  header("Content-Disposition: attachment; filename=record_release.pdf");

  // Send the file to the browser.
  readfile($filename);

}else{
  ?><h2>You are not authorized to view this file.</h2><?php
}
?>
