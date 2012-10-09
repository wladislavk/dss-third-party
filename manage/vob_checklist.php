
<?php

  if($_GET['rx']==1){
?>
<div id="loader" style="position:absolute;width:100%; height:98%;">
<img style="margin:100px 0 0 45%" src="images/DSS-ajax-animated_loading-gif.gif" />
</div>
<?php
    $file = $_FILES['rx_file'];
    if ($file["name"] <> '') {
      $rximgid = save_insurance_image($file, 6);
      $rxrec = date("m/d/Y");
      $rx_sql = "UPDATE dental_flow_pg1 SET rx_imgid='".$rximgid."', rxrec='".$rxrec."' WHERE pid = '".$_GET['pid']."';";
      mysql_query($rx_sql);
      ?>
      <script type="text/javascript">
        $('#loader').hide();
      </script>
      <?php
    }
  }


  if($_GET['lomn']==1){
?>
<div id="loader" style="position:absolute;width:100%; height:98%;">
<img style="margin:100px 0 0 45%" src="images/DSS-ajax-animated_loading-gif.gif" />
</div>
<?php

    $file = $_FILES['lomn_file'];
    if ($file["name"] <> '') {
      $lomnimgid = save_insurance_image($file, 7);
      $lomnrec = date("m/d/Y");
      $lomn_sql = "UPDATE dental_flow_pg1 SET lomn_imgid='".$lomnimgid."', lomnrec='".$lomnrec."' WHERE pid = '".$_GET['pid']."';";
      mysql_query($lomn_sql);
      ?>
      <script type="text/javascript">
        $('#loader').hide();
      </script>
      <?php
    }


  }

                function save_insurance_image($file, $imagetypeid) {
                        // Set title based on category
                        if ($imagetypeid == 6) $title = "RX Image";
                        if ($imagetypeid == 7) $title = "LOMN Image";
                        if ($imagetypeid == 8) $title = "Clinical Notes Image";
                        if ((array_search($file["type"], $dss_file_types) !== false) && ($file["size"] < DSS_FILE_MAX_SIZE)) {
                                if($file["name"] <> '') {
                                        $fname = $file["name"];
                                        $lastdot = strrpos($fname,".");
                                        $name = substr($fname,0,$lastdot);
                                        $extension = substr($fname,$lastdot+1);
                                        $banner1 = $name.'_'.date('dmy_Hi');
                                        $banner1 = str_replace(" ","_",$banner1);
                                        $banner1 = str_replace(".","_",$banner1);
                                        $banner1 .= ".".$extension;

                                        //@move_uploaded_file($file["tmp_name"],"q_file/".$banner1);
                                        //@chmod("q_file/".$banner1,0777);
                                        uploadImage($file, 'q_file/'.$banner1);

                                        $ins_sql = " insert into dental_q_image set 
                                        patientid = '".s_for($_GET['pid'])."',
                                        title = '".s_for($title)."',
                                        imagetypeid = '".s_for($imagetypeid)."',
                                        image_file = '".s_for($banner1)."',
                                        userid = '".s_for($_SESSION['userid'])."',
                                        docid = '".s_for($_SESSION['docid'])."',
                                        adddate = now(),
                                        ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                                        mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
                                        return mysql_insert_id();
                                }
                        } else {
                        ?>
                                <script type="text/javascript">
                                        alert("Invalid File Type or File too Large");
                                </script>
                        <?php
                }
                }

$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
$flow = mysql_fetch_assoc($flowresult);
if(mysql_num_rows($flowresult) <= 0){
  $rx = false;
  $lomn = false;
}else{
    $rx = ($flow['rxrec']!='');
    $lomn = ($flow['lomnrec']!='');
}
?>
<script type="text/javascript" src="js/vob.js"></script>
<div style="width:48%; float:left;">
<?php 

//include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/dental_patient_summary.php');
require_once('includes/preauth_functions.php');
require_once('includes/patient_info.php');

?>
<link rel="stylesheet" href="css/vob.css" />
<?php
if ($patient_info) {

  $pat_sql = "SELECT * FROM dental_patients WHERE patientid='".$_GET['pid']."'";
  $pat_q = mysql_query($pat_sql);
  $pat_r = mysql_fetch_assoc($pat_q);
  if($pat_r['p_m_dss_file']!=1){
    $ins_error = true;
  }else{
    $ins_error = false;
  }

$sleepstudies = "SELECT ss.completed FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."';";

  $result = mysql_query($sleepstudies);
  $numsleepstudy = mysql_num_rows($result);
  if($numsleepstudy == 0){
    $study_error = true;
  }else{
    $study_error = false;
  } 

?>
<div class="ins_header vob_header">
Request<br />
Verification of Benefits
<?php
if($ins_error || $study_error){
?>
<span class="sub_text">The follwing items are <span class="highlight">INCOMPLETE</span> (click to finish)*</span>
<?php
}
?>
</div>


<?php
  if($pat_r['p_m_ins_type']==1){ ?>

<div class="vob_medicare">
Patient has <strong>MEDICARE</strong> insurance.<br />
Verification CANNOT be requested*
<div class="sub_note">
  *insurance information can be changed<br />in the Patient info tab.
</div>
</div>
<?php
}elseif(!$ins_error && !$study_error){
  include 'vob_table.php'; 
}else{ ?>
<a href="add_patient.php?ed=<?= $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?= $_GET['pid']; ?>#p_m_ins" class="vob_item
<?php
  if($ins_error){
    ?>error<?php
  }else{
    ?>success<?php
  } ?>
">
<div class="vob_icon vob_insurance"></div>
<span>Insurance Information</span>
</a>

<a href="dss_summ.php?pid=<?= $_GET['pid']; ?>&addtopat=1&sect=sleep"  class="vob_item
<?php
  if($study_error){
    ?>error<?php
  }else{
    ?>success<?php
  } ?>
">
<div class="vob_icon vob_study"></div>
<span>Sleep Study w/ Diagnosis</span>
</a>
<span class="sub_note">*Verification of Benefits can be requested<br /<br />>after the items above are completed</span>
<div class="clear"></div>
<br /><br />
<?php } ?>

</div>
<div style="width:48%; float:left;">

<div class="ins_header claim_header">
File<br />
Insurance Claim
<?php
if($ins_error || $study_error || !$rx || !$lomn){
?>
<span class="sub_text">The follwing items are <span class="highlight">INCOMPLETE</span> (click to finish)*</span>
<?php
}
?>

</div>
<?php
if(!$ins_error && !$study_error && $rx && $lomn){ ?>
<?php include 'patient_claims.php'; ?>
<?php }else{ ?>
<a href="add_patient.php?ed=<?= $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?= $_GET['pid']; ?>#p_m_ins" class="vob_item
<?php
  if($ins_error){
    ?>error<?php
  }else{
    ?>success<?php
  } ?>
">
<div class="vob_icon vob_insurance"></div>
<span>Insurance Information</span>
</a>

<a href="dss_summ.php?pid=<?= $_GET['pid']; ?>&addtopat=1&sect=sleep"  class="vob_item
<?php
  if($study_error){
    ?>error<?php
  }else{
    ?>success<?php
  } ?>
">
<div class="vob_icon vob_study"></div>
<span>Sleep Study w/ Diagnosis</span>
</a>

<a id="rx_item" class="vob_item
<?php
  if(!$rx){
    ?>error<?php
  }else{
    ?>success<?php
  } ?>
">
<div class="vob_icon vob_rx"></div>
<span>Rx.</span>
</a>

<form id="rx_form" action="manage_insurance.php?pid=<?= $_GET['pid']; ?>&addtopat=1&rx=1" enctype="multipart/form-data" method="post" style="display:none;">
<input name="rx_file" type="file" id="rx_file" />
</form>
<a id="lomn_item"  class="vob_item
<?php
  if(!$lomn){
    ?>error<?php
  }else{
    ?>success<?php
  } ?>
">
<div class="vob_icon vob_lomn"></div>
<span>LOMN</span>
</a>

<form id="lomn_form" action="manage_insurance.php?pid=<?= $_GET['pid']; ?>&addtopat=1&lomn=1" enctype="multipart/form-data" method="post" style="display:none;">
<input name="lomn_file" type="file" id="lomn_file" />
</form>

<?php
if($ins_error || $study_error || !$rx || !$lomn){
?>
<span class="sub_note">*Insurance Claims can be filed after<br />the items above are completed</span>
<div class="clear"></div>
<br /><br />
<?php
}
?>

<?php } ?>

<?php
if($rx || $lomn){
 include 'flowsheet_medical.php';
} ?>
</div>
<div class="clear"></div>
<?php


} else {  // end pt info check
        print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}


//include "includes/bottom.htm";
?>

