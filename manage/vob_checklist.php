<?php
if(!empty($_GET['rx']) && $_GET['rx']==1){?>

<div id="loader" style="position:absolute;width:100%; height:98%;">
  <img style="margin:100px 0 0 45%" src="images/DSS-ajax-animated_loading-gif.gif" />
</div>
<?php
  $file = (!empty($_FILES['rx_file']) ? $_FILES['rx_file'] : array());
  if (!empty($file["name"])) {
    $rximgid = save_insurance_image($file, 6);
    $rxrec = date("m/d/Y");
    $rx_sql = "UPDATE dental_flow_pg1 SET rx_imgid='".$rximgid."', rxrec='".$rxrec."' WHERE pid = '".(!empty($_GET['pid']))."';";
    $db->query($rx_sql);?>
<script type="text/javascript">
  $('#loader').hide();
</script>
<?php
  }
}

if(!empty($_GET['lomn']) && $_GET['lomn']==1){?>

<div id="loader" style="position:absolute;width:100%; height:98%;">
  <img style="margin:100px 0 0 45%" src="images/DSS-ajax-animated_loading-gif.gif" />
</div>
<?php
  $file = $_FILES['lomn_file'];
    if ($file["name"] <> '') {
      $lomnimgid = save_insurance_image($file, 7);
      $lomnrec = date("m/d/Y");
      $lomn_sql = "UPDATE dental_flow_pg1 SET lomn_imgid='".$lomnimgid."', lomnrec='".$lomnrec."' WHERE pid = '".$_GET['pid']."';";
      $db->query($lomn_sql);?>
<script type="text/javascript">
$('#loader').hide();
</script>
      <?php
    }
  }

function save_insurance_image($file, $imagetypeid) {
  $db = new Db();

// Set title based on category
  if ($imagetypeid == 6) $title = "RX Image";
  if ($imagetypeid == 7) $title = "LOMN Image";
  if ($imagetypeid == 8) $title = "Clinical Notes Image";
  if ((array_search($file["type"], $dss_file_types) !== false) && ($file["size"] < DSS_FILE_MAX_SIZE)) {
    if(!empty($file["name"])) {
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
      uploadImage($file, '../../../shared/q_file/'.$banner1);

      $ins_sql = " insert into dental_q_image set 
      patientid = '".s_for($_GET['pid'])."',
      title = '".s_for($title)."',
      imagetypeid = '".s_for($imagetypeid)."',
      image_file = '".s_for($banner1)."',
      userid = '".s_for($_SESSION['userid'])."',
      docid = '".s_for($_SESSION['docid'])."',
      adddate = now(),
      ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

      return $db->getInsertId($ins_sql);
    }
  } else { ?>
<script type="text/javascript">
alert("Invalid File Type or File too Large");
</script>
  <?php
  }
}

$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' LIMIT 1;";
$flow = $db->getRow($flowquery);
if(!$flow){
  $rx = false;
  $lomn = false;
  $rxlomn = false;
}else{
  $rx = ($flow['rxrec']!='');
  $lomn = ($flow['lomnrec']!='');
  $rxlomn = ($flow['rxlomnrec']!='');
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
  $pat_r = $db->getRow($pat_sql);

  $b_sql = "SELECT * FROM companies c JOIN dental_users u ON c.id=u.billing_company_id WHERE u.userid='".mysqli_real_escape_string($con,(!empty($_SESSION['docid']) ? $_SESSION['docid'] : ''))."'";
  $b_q = $db->getRow($b_sql);
  if(!empty($b_q) && !empty($b_q['exclusive'])){
    $exclusive_billing = $b_r['exclusive'];
  }else{
    $exclusive_billing = 0;
  }

  if($pat_r['p_m_relation']=='' ||
      $pat_r['p_m_partyfname'] == "" ||
      $pat_r['p_m_partylname'] == "" ||
      $pat_r['p_m_relation'] == "" ||
      $pat_r['ins_dob'] == "" ||
      $pat_r['p_m_gender'] == "" ||
      $pat_r['p_m_ins_co'] == "" ||
      $pat_r['p_m_ins_grp'] == "" ||
      ($pat_r['p_m_ins_plan'] == "" && $pat_r['p_m_ins_type'] != 1) ||
      $pat_r['p_m_ins_type'] == '' ||
      $pat_r['p_m_ins_ass'] == ''
  ){
    $ins_error = true;
  }elseif($exclusive_billing){
    $ins_error = false;
  }elseif(!empty($_SESSION['user_type']) && !empty($pat_r['p_m_dss_file']) && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE){
    $ins_error = false;
  }elseif($pat_r['p_m_dss_file']!=''){
    $ins_error = true;
  }else{
    $ins_error = false;
  }

  $sleepstudies = "SELECT ss.completed FROM dental_summ_sleeplab ss                                 
                    JOIN dental_patients p on ss.patiendid=p.patientid                        
                    WHERE                                 
                    (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                    (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                    (ss.filename!='' AND ss.filename IS NOT NULL) AND ss.patiendid = '".$_GET['pid']."';";

  $numsleepstudy = $db->getNumberRows($sleepstudies);

  if($numsleepstudy == 0){
    $study_error = $vob_study_error = true;
  }else{
    $study_error = $vob_study_error = false;
  } 
 // $vrt_sql = "SELECT c.vob_require_test FROM companies c
 //                JOIN dental_users u ON u.billing_company_id=c.id
 //                WHERE u.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
 // $vrt_q = mysqli_query($con, $vrt_sql) or die(mysqli_error($con));
 // $vrt = mysqli_fetch_assoc($vrt_q);
 // if($vrt['vob_require_test']!='1'){
 //   $vob_study_error = false;
 // }
?>
<div class="ins_header vob_header">
  Request<br />
  Verification of Benefits
<?php
  if($ins_error || $vob_study_error){?>

  <span class="sub_text">The follwing items are <span class="highlight">INCOMPLETE</span> (click to finish)*</span>
<?php
  }?>
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
  }elseif(!$ins_error && !$vob_study_error){
    include 'vob_table.php'; 
  }else{ ?>
<a href="add_patient.php?ed=<?php echo $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?php echo $_GET['pid']; ?>#p_m_ins" class="vob_item
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

<?php 
    if(!empty($vrt['vob_require_test']) && $vrt['vob_require_test']=='1'){ ?>
<a href="dss_summ.php?pid=<?php echo $_GET['pid']; ?>&addtopat=1&sect=sleep"  class="vob_item
<?php
  if($vob_study_error){
    ?>error<?php
  }else{
    ?>success<?php
  } ?>
">

  <div class="vob_icon vob_study"></div>
  <span>Sleep Study w/ Diagnosis</span>
</a>
<span class="sub_note">*Verification of Benefits can be requested<br />after the items above are completed</span>
<div class="clear"></div>
  <br /><br />
<?php 
    } ?>
<?php 
  } ?>


<?php
$api_sql = "SELECT use_eligible_api FROM dental_users
              WHERE userid='".mysqli_real_escape_string($con,(!empty($_SESSION['docid']) ? $_SESSION['docid'] : ''))."'";
$api_r = $db->getRow($api_sql);
  if($api_r['use_eligible_api']==1){?>

<br /><br />

<?php 
    $vob_sql = "SELECT * FROM dental_insurance_preauth WHERE doc_id='".mysqli_real_escape_string($con,$_SESSION['docid'])."'
                  AND patient_id='".mysqli_real_escape_string($con,$_GET['pid'])."'";
    $vob_q = $db->getResults($vob_sql);
    $num_vob = count($vob_q);
    if($num_vob>1){ ?>

<div style="margin-left:20px;">
  <h2>VOB History</h2>

  <?php
      foreach ($vob_q as $vob_r) {
        echo $vob_r['front_office_request_date']; ?> -
  <a href="manage_insurance.php?pid=<?php echo $_GET['pid']; ?>&vob_id=<?php echo $vob_r['id']; ?>">View</a>
  <br />
  <?php
      }?>
</div>
<?php 
    } ?>
<a style="margin-left:150px;" href="eligible_check.php?pid=<?php echo $_GET['pid']; ?>" class="button">Eligibility Check</a>
<br /><br />
<div style="margin-left:20px;">
  <h2>Eligibility Check History</h2>
  <table>
    <tr>
      <th width="200">Date</th>
      <th>View</th>
    </tr>

<?php 
    $s = "SELECT * FROM dental_eligibility WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
    $q = $db->getResults($s);
    if ($q) {
      foreach ($q as $r) {?>
    <tr>
      <td><?php echo $r['adddate']; ?></td>
      <td><a href="#" onclick="parent.window.location = 'view_eligibility_response.php?id=<?php echo $r['id']; ?>';return false;">View</a></td>
    </tr>
<?php
      }
    }?>
  </table>
</div>
<?php 
  } ?>
</div>

<div style="width:48%; float:left;">
  <div class="ins_header claim_header">
    File<br />
    Insurance Claim
<?php
  if($ins_error || $study_error || ((!$rx || !$lomn) && !$rxlomn)){?>
    <span class="sub_text">The follwing items are <span class="highlight">INCOMPLETE</span> (click to finish)*</span>
<?php
  }?>

  </div>
<?php
  if(!$ins_error && !$study_error && (($rx && $lomn) || $rxlomn)){ 
    include 'patient_claims.php';
  }else{ ?>
  <a href="add_patient.php?ed=<?php echo $_GET['pid']; ?>&preview=1&addtopat=1&pid=<?php echo $_GET['pid']; ?>#p_m_ins" class="vob_item
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

  <a href="dss_summ.php?pid=<?php echo $_GET['pid']; ?>&addtopat=1&sect=sleep"  class="vob_item
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

<?php 
    if(!$rx && !$lomn){ ?>
  <div id="combined_div">
    <a id="rxlomn_item" onclick="loadPopup('add_image.php?pid=<?php echo $_GET['pid'];?>&sh=14&itro=1');" class="vob_item
    <?php
      if(!$rxlomn){
        ?>error<?php
      }else{
        ?>success<?php
      } ?>
    ">
      <div class="vob_icon vob_rx"></div>
      <span>LOMN / Rx. Combined</span>
    </a>
    <a href="#" onclick="$('#rx_lomn_div').show();$('#combined_div').hide();return false;">Click here if LOMN and Rx are not same document</a>
    <form id="rxlomn_form" action="manage_insurance.php?pid=<?php echo $_GET['pid']; ?>&addtopat=1&rxlomn=1" enctype="multipart/form-data" method="post" style="display:none;">
      <input name="rxlomn_file" type="file" id="rxlomn_file" />
    </form>
  </div>

<?php 
    } ?>

  <div <?php echo (!$rx && !$lomn)?'style="display:none;"':''; ?> id="rx_lomn_div">
  <a id="rx_item" onclick="loadPopup('add_image.php?pid=<?php echo $_GET['pid'];?>&sh=6&itro=1');" class="vob_item
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

  <form id="rx_form" action="manage_insurance.php?pid=<?php echo $_GET['pid']; ?>&addtopat=1&rx=1" enctype="multipart/form-data" method="post" style="display:none;">
    <input name="rx_file" type="file" id="rx_file" />
  </form>
  <a id="lomn_item" onclick="loadPopup('add_image.php?pid=<?php echo $_GET['pid'];?>&sh=7&itro=1');"  class="vob_item
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

  <form id="lomn_form" action="manage_insurance.php?pid=<?php echo $_GET['pid']; ?>&addtopat=1&lomn=1" enctype="multipart/form-data" method="post" style="display:none;">
    <input name="lomn_file" type="file" id="lomn_file" />
  </form>
</div>
<?php
    if($ins_error || $study_error || ((!$rx || !$lomn) && !$rxlomn)){ ?>

<span class="sub_note">*Insurance Claims can be filed after<br />the items above are completed</span>
<div class="clear"></div>
<br /><br />
<?php
    }
  }

  if($rx || $lomn || $rxlomn){
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

