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

<div class="vob_item">
<?php
  $errors = preauth_errors();
  if(count($errors)>0){
    ?><div class="vob_x"></div><?php
  }else{
    ?><div class="vob_check"></div><?php
  } ?>
<div class="vob_icon vob_request"></div>
Request<br />Verification of Benefits
</div>


<div class="vob_item">
<?php
  $errors = claim_errors($_GET['pid']);
  if(count($errors)>0){
    ?><div class="vob_x"></div><?php
  }else{
    ?><div class="vob_check"></div><?php
  } ?>
<div class="vob_icon vob_file"></div>
File<br />Insurance Claim
</div>
<div class="clear"></div>
<?php


} else {  // end pt info check
        print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}


function preauth_errors(){
  $errors = array();
  $pa_sql = "SELECT status FROM dental_insurance_preauth WHERE status = '".DSS_PREAUTH_PENDING."' AND patient_id=".$_GET['pid'];
  $pa = mysqli_query($con, $pa_sql);
  if(mysqli_num_rows($pa)>0)
    array_push($errors, "Already has verification of benefits");

  /* $sql = "SELECT * FROM dental_patients p JOIN dental_contact r ON p.referred_by = r.contactid WHERE p.patientid=".$_GET['pid'];
  $my = mysqli_query($con, $sql);
  $num = mysqli_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing referral"); 
  }*/

$sleepstudies = "SELECT ss.completed FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."';";

  $result = mysqli_query($con, $sleepstudies);
  $numsleepstudy = mysqli_num_rows($result);
  if($numsleepstudy == 0)
        array_push($errors, "There are no completed sleep studies.");

  $sql = "SELECT * FROM dental_patients p JOIN dental_contact i ON p.p_m_ins_co = i.contactid WHERE p.patientid=".$_GET['pid'];
  $my = mysqli_query($con, $sql);
  $num = mysqli_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing insurance company");
  }

  $sql = "SELECT * FROM dental_patients p JOIN dental_users d ON p.docid = d.userid WHERE p.patientid=".$_GET['pid'];
  $my = mysqli_query($con, $sql);
  $num = mysqli_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing doctor");
  }

  $sql = "SELECT p_m_ins_type FROM dental_patients p WHERE p.patientid=".$_GET['pid']." LIMIT 1";
  $my = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($my);
  if($row['p_m_ins_type']==1){
    array_push($errors, "patient has Medicare Insurance. You can change patient\'s insurance type in the Patient Info section");
  }


  $sql = "SELECT * FROM dental_patients p JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' WHERE p.patientid=".$_GET['pid'];
  $my = mysqli_query($con, $sql);
  $num = mysqli_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing transaction code E0486");
  }else{
    $row=mysqli_fetch_assoc($my);
    if($row['amount']==0||$row['amount']==''){
    array_push($errors, "You have not set a dollar amount for E0486 - Dental Device. Please contact Dental Sleep Solutions Corporate Office to set this fee.");
    }
  }

  /*$sql = "SELECT * FROM dental_patients p JOIN dental_q_page2 q2 ON p.patientid = q2.patientid WHERE p.patientid=".$_GET['pid'];
  $my = mysqli_query($con, $sql);
  $num = mysqli_num_rows($my);
  if( $num <= 0 ){
    array_push($errors, "Missing questionnaire page 3"); // The file and table are named q_page2, but this is displayed on page 3 of questionnaire
  }*/


$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysqli_query($con, $flowquery);
if(mysqli_num_rows($flowresult) <= 0){
  array_push($errors, "Doesn\'t have flowsheet.");
}else{
    $flow = mysqli_fetch_array($flowresult);
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];
    $insverbendate2 = $flow['insverbendate2'];
}


    if(/*$insinforec == '' || $rxreq == '' ||*/ $rxrec == '' || /*$lomnreq == '' ||*/ $lomnrec == ''  /*$clinnotereq == '' || $clinnoterec == ''*/){
       //array_push($errors, "Medical insurance dates are not filled out."); 
     }



return $errors;
}





include "includes/bottom.htm";?>
