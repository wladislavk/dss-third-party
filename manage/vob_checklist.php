<?php include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/dental_patient_summary.php');
require_once('includes/preauth_functions.php');
require_once('includes/patient_info.php');
?>
<link rel="stylesheet" href="css/vob.css" />
<?php
if ($patient_info) {

?>

<h3 style="margin-left: 30px; font-size:30px;" >You are able to do the following:</h3>
<a href="manage_flowsheet3.php?pid=<?= $_GET['pid']; ?>&addtopat=1" style="float:right; margin:0 20px 0 0; color:#000; text-decoration:none; font-size:14px; cursor:pointer;">Return to Flowsheet</a>
<a href="add_patient.php?ed=<?= $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?= $_GET['pid']; ?>#p_m_ins" class="vob_item">
<?php
  $ins_sql = "SELECT * FROM dental_patients WHERE patientid='".$_GET['pid']."'";
  $ins_q = mysql_query($ins_sql);
  $ins_r = mysql_fetch_assoc($ins_q);
  

  if($ins_r['p_m_dss_file']!=1){
    ?><div class="vob_x"></div><?php
  }else{
    ?><div class="vob_check"></div><?php
  } ?>
<div class="vob_icon vob_insurance"></div>
<span>Insurance Information</span>
</a>

<a href="manage_flowsheet3.php?pid=<?= $_GET['pid']; ?>&addtopat=1#sleep_study"  class="vob_item">
<?php
$sleepstudies = "SELECT ss.completed FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."';";

  $result = mysql_query($sleepstudies);
  $numsleepstudy = mysql_num_rows($result);
  if($numsleepstudy == 0){
    ?><div class="vob_x"></div><?php
  }else{
    ?><div class="vob_check"></div><?php
  } ?>
<div class="vob_icon vob_study"></div>
<span>Sleep Study</span>
</a>

<?php

$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
if(mysql_num_rows($flowresult) <= 0){
  $rx = false;
  $lomn = false;
}else{
    $rx = ($flow['rxrec']=='');
    $lomn = ($flow['lomnrec']=='');

}
?>



<a href="manage_flowsheet3.php?pid=<?= $_GET['pid']; ?>&addtopat=1#ins" class="vob_item">
<?php
  if($rx){
    ?><div class="vob_check"></div><?php
  }else{
    ?><div class="vob_x"></div><?php
  } ?>
<div class="vob_icon vob_rx"></div>
<span>Rx.</span>
</a>

<a href="manage_flowsheet3.php?pid=<?= $_GET['pid']; ?>&addtopat=1#ins"  class="vob_item">
<?php
  if($lomn){
    ?><div class="vob_check"></div><?php
  }else{
    ?><div class="vob_x"></div><?php
  } ?>
<div class="vob_icon vob_lomn"></div>
<span>LOMN</span>
</a>



<div class="clear"></div>
<?php


} else {  // end pt info check
        print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}


include "includes/bottom.htm";?>

