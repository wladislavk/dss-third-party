<?php
$sql = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."' AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);


?>
<table width="95%" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0" style="margin:0 auto;">
<tr>
  <td>
      <span style="width: 40%; display:block; float:left;">Preferred Name: <?= $r['preferred_name']; ?></span>
      <span style="width: 20%; display:block; float:left;">Age: <?php
$diff = abs(strtotime(date('Y-m-d')) - strtotime($r['dob']));

$years = floor($diff / (365*60*60*24));
		echo $years;
 ?></span>
      <span style="width: 30%; display:block; float:left;">DOB: <?= ($r['dob']!='')?date('m/d/Y', strtotime($r['dob'])):'';?></span>
  </td>
  <td>
      Referred By: 
    <?php
$rs = $r['referred_source'];
  if($rs == DSS_REFERRED_PHYSICIAN){
  $referredby_sql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE dc.status=1 AND contactid='".st($r['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
        $referredbythis .= " - ". $referredby_myarray['contacttype'];
  echo $referredbythis;
  }elseif($rs == DSS_REFERRED_PATIENT){
  $referredby_sql = "select * from dental_patients where patientid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
  echo $referredbythis ." - Patient";
  }else{
   echo $dss_referred_labels[$rs].": ".$r['referred_notes'];
  }
?>
  </td>
  <td rowspan="3">PHOTO</td>
</tr>
<tr>
  <td>Last seen:

<?php
        $qso = "SELECT `consultrow`, `sleepstudyrow`, `impressionrow`, `delayingtreatmentrow`, `refusedtreatmentrow`, `devicedeliveryrow`, `checkuprow`, `patientnoncomprow`, `homesleeptestrow`, `startt
reatmentrow`, `annualrecallrow`, `terminationrow` FROM `segments_order` WHERE `patientid` = '".$_GET['pid']."'";
        $qso_query = mysql_query($qso);

        $qsoResult = array();

        while ($qsoTmpResult = mysql_fetch_assoc($qso_query))
        {
                $qsoResult []= $qsoTmpResult;
        }

        $fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$_GET['pid']."';";
        $fsData_query = mysql_query($fsData_sql);
        $fsData_array = mysql_fetch_array($fsData_query);


        if (!empty($fsData_array['steparray'])) {
                $order = explode(",",$fsData_array['steparray']);
        	$order = array_reverse($order);
	}

	  $flow_pg2_info_query = "SELECT stepid, UNIX_TIMESTAMP(date_scheduled) as date_scheduled, UNIX_TIMESTAMP(date_completed) as date_completed, delay_reason, noncomp_reason, study_type, description, letterid FROM dental_flow_pg2_info WHERE patientid = '".$_GET['pid']."' ORDER BY date_completed DESC;";
  $flow_pg2_info_res = mysql_query($flow_pg2_info_query);
  $row = mysql_fetch_assoc($flow_pg2_info_res);
  echo ($row['date_completed']!=0)?date('m/d/Y', $row['date_completed']):'';



?>
  For: 

<?php
  $segment_query = "SELECT * FROM `flowsheet_segments` WHERE `id` = ".$row[$stepid].";";
  $segment_res = mysql_query($segment_query);
  if($segment_res){
    $segment = mysql_fetch_array($segment_res);
    print_r($segment);
  }else{
}

?>
</td>
  <td rowspan="2">
<?php
$c_sql = "SELECT chief_complaint_text from dental_q_page1 WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
$c_q = mysql_query($c_sql);
$c_r = mysql_fetch_assoc($c_q);
echo $c_r['chief_complaint_text'];

?>
</td>
</tr>
<tr>
  <td>Sleep Test:</td>
</tr>





</table>





<!-- DSS SUMM PAGE 1 -->
<?php
$patid = $_GET['pid'];

$sql = "select * from dental_summary where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$location = st($myarray['location']);


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);
$patient_name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

$patient_dob = st($pat_myarray['dob']);

$referral_source = st($pat_myarray['referred_source']);
if(st($pat_myarray['referred_by']) != '')
{
        $referredby_sql = "select * from dental_contact where status=1 and contactid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $sleep_md = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
}

?>
<div>
<table width="95%" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0" style="margin:0 auto; <?= ($_GET['pg']==2)?'display:none;':''; ?>" id="hideshow1">
  <tr valign="top">
    <td width="15%" height="3">Name</td>
    <td colspan="1">
      <label>
        <strong><?php echo $patient_name; ?></strong>
<?php
$sql = "SELECT imageid FROM dental_q_image WHERE patientid='".$_GET['pid']."' AND imagetypeid=4";
$p = mysql_query($sql);
$num_face = mysql_num_rows($p);
?>
<span align="right">
<?php if($num_face==0){ ?>
        <button onclick="Javascript: loadPopup('add_image.php?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>&it=4');" class="addButton">
                Add Patient Photo
        </button>
<?php }else{ ?>
        <button onclick="Javascript: window.location='q_image.php?pid=<?= $_GET['pid']; ?>&addtopat=1'" class="addButton">
                Add/Update Patient Photo
        </button>

<?php } ?>
        &nbsp;&nbsp;
</span>

      </label>
      <br />
    </td>
<?php
$loc_sql = "SELECT * FROM dental_locations WHERE docid='".$docid."'";
                $loc_q = mysql_query($loc_sql);
$num_loc = mysql_num_rows($loc_q);
$rowspan = ($num_loc > 1)?"4":"3";
?>

    <td colspan="5" rowspan="<?= $rowspan; ?>">

<strong><h3 style="margin-top:-5px;">Medical Caregivers:</h3></strong>
<div style="margin-left:20px;">

    <?php

        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docsleep WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Sleep MD:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }




        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docpcp WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Primary Care:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docdentist WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Dentist:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docent WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>ENT:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docmdother WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Other MD:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



?>
</div>


    </td>

  </tr>

  <tr valign="top">
    <td width="15%" height="4">DOB</td>
    <td colspan="1">
      <?php echo $patient_dob; ?>
      <br />
    </td>

  </tr>
  <tr valign="top">
    <td width="15%" height="5">Referred By</td>
    <td colspan="1">



    <?php
$rs = $pat_myarray['referred_source'];
if(st($pat_myarray['referred_by']) <> '')
{
  if($rs == DSS_REFERRED_PHYSICIAN){
  $referredby_sql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE dc.status=1 AND contactid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
        $referredbythis .= " - ". $referredby_myarray['contacttype'];
  echo $referredbythis;
  }elseif($rs == DSS_REFERRED_PATIENT){
  $referredby_sql = "select * from dental_patients where patientid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
  echo $referredbythis ." - Patient";
  }else{
   echo $dss_referred_labels[$rs].": ".$pat_myarray['referred_notes'];
  }
  }else{
echo "Not Set, Please set through patient info.";
}
    ?>

      <br />
    </td>

  </tr>
<?php
if($num_loc > 1){
?>
  <tr valign="top">
    <td width="15%" height="5">Office Site</td>
    <td colspan="1">
      <?php include("dss_loc.php"); ?>
      <br />
    </td>
  </tr>
<?php } ?>




</table>
</div>


<!-- SUMM PAGE 2 -->
<?php
$sqlex = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
$myex = mysql_query($sqlex);
$myarrayex = mysql_fetch_array($myex);

$i_opening_from = st($myarrayex['i_opening_from']);
$protrusion_from = st($myarrayex['protrusion_from']);
$protrusion_to = st($myarrayex['protrusion_to']);
$protrusion_equals = st($myarrayex['protrusion_equal']);
$r_lateral_from = st($myarrayex['r_lateral_from']);
$l_lateral_from = st($myarrayex['l_lateral_from']);
$dentaldevice = st($myarrayex['dentaldevice']);
$dentaldevice_date = st(($myarrayex['dentaldevice_date']!='')?date('m/d/Y', strtotime($myarrayex['dentaldevice_date'])):'');
?>

<form id="form1" name="form1" method="post" action="" style="width:95%;margin:0 auto;">
  <table width="100%" align="center" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0">
  <tr valign="top">
    <td width="17%" height="4">ROM:&nbsp;&nbsp;</td>
    <td colspan="2">
    Vertical&nbsp;<input type="text" name="i_opening_from" id="textfield11" size="5" value="<?php echo $i_opening_from; ?>" /> mm&nbsp;&nbsp;&nbsp;&nbsp; Right <input type="text" name="r_lateral_from" id="textfield12" size="5" value="<?php echo $r_lateral_from; ?>" />mm&nbsp;&nbsp;&nbsp;&nbsp;  Left <input type="text" name="l_lateral_from" id="textfield13" size="5" value="<?php echo $l_lateral_from; ?>"/>mm
&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>

  <tr>
  <td width="17%" height="4">Incisal Edge Range:&nbsp;&nbsp;</td>
  <td colspan="2">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input disabled="disabled" type="text" name="ir_range" id="ir_range" size="5" value="<?php echo $protrusion_to-($protrusion_from); ?>" /> mm   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Incisal Range (minimum):&nbsp;&nbsp; <input type="text" name="ir_min" id="ir_min" size="5" value="<?php echo $protrusion_from; ?>" onchange="checkIncisal()" /> (maximum) <input type="text" name="ir_max" id="ir_max" size="5" value="<?php echo $protrusion_to; ?>" onchange="checkIncisal()"  />

  </td>
  </tr>
  <script type="text/javascript">
        function checkIncisal(){
                min = Number($('#ir_min').val());
                max = Number($('#ir_max').val());
                range = (max-min);
                $('#ir_range').val(range);
                pos = Number($('#i_pos').val());
                dist = Math.abs(pos-min); 
                perc = (dist/range)
                $('#initial_device_titration_equal_h').val(Math.round(dist));
                $('#i_perc').val(Math.round(perc*100));
                if(min != '' && max != ''){
                        if((range)<0){
                                alert('Minimum must be less than maximum');
                                $('#ir_min').focus();
                                return false;
                        }
                        if(pos<min || pos>max){
                                alert('Incisal Position value must be between minimum and maximum range.');
                                $('#i_pos').focus();
                                return false;
                        }
                }
                return true;
        }
        $('document').ready( function(){
                checkIncisal();
        })
  </script>
  <tr>
  <td width="17%" height="4">Best Eccovision&nbsp;&nbsp;</td>
  <td colspan="2">
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horizontal<input type="text" name="optimum_echovision_hor" id="optimum_echovision_hor" size="5" value="<?php echo $optimum_echovision_hor; ?>" />mm  Vertical<input type="text" name="optimum_echovision_ver" id="optimum_echovision_ver" size="5" value="<?php echo $optimum_echovision_ver; ?>" />mm
  </td>
  </tr>
   <tr valign="top">
    <td height="4">
        Device
    </td>
    <td colspan="2">

    Device
        <select name="dentaldevice" style="width:250px">
        <option value=""></option>
        <?php        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                                                                $device_my = mysql_query($device_sql);
                                                                while($device_myarray = mysql_fetch_array($device_my))
                                                                {
                ?>
                                                                 <option <?= ($device_myarray['deviceid']==$dentaldevice)?'selected="selected"':''; ?>value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                                                                 <?php
                                                                 }
                                                                ?>
    </select>
        Date <input id="dentaldevice_date" name="dentaldevice_date" type="text" class="calendar" value="<?= $dentaldevice_date; ?>" />
    </td>

  </tr>
  <tr>
  <td width="17%" height="4">Initial Device Setting&nbsp;&nbsp;</td>
  <td colspan="2">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Incisal Position <input type="text" onchange="checkIncisal()" name="initial_device_titration_1" id="i_pos" size="5" value="<?php echo $initial_device_titration_1; ?>" />mm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Vertical <input type="text" name="initial_device_titration_equal_v" id="initial_device_titration_equal_v" size="5" value="<?php echo $initial_device_titration_equal_v; ?>" />mm
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Distance from minimum range<input disabled="disabled" type="text" name="initial_device_titration_equal_h" id="initial_device_titration_equal_h" size="5" value="<?php echo $initial_device_titration_equal_h; ?>" />mm
(<input type="text" name="i_perc" id="i_perc" size="2" disabled="disabled" value="<?php echo $initialdevsettingp; ?>" />%)
  </td>
  </tr>

  </table>
  <br />

<div align="right">
<input type="hidden" name="summarysub" value="1" />
<input type="hidden" name="ed" value="<?=$summaryid;?>" />
    <input type="submit" name="summarybtn" onclick="return checkIncisal();" value="Save" />
</div>
</form>



<!-- TREATMENT -->

<?php
$sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page1id = st($myarray['q_page1id']);
$exam_date = st($myarray['exam_date']);
$ess = st($myarray['ess']);
$tss = st($myarray['tss']);
$chief_complaint_text = st($myarray['chief_complaint_text']);
$complaintid = st($myarray['complaintid']);
$other_complaint = st($myarray['other_complaint']);
$additional_paragraph = st($myarray['additional_paragraph']);
$energy_level = st($myarray['energy_level']);
$snoring_sound = st($myarray['snoring_sound']);
$wake_night = st($myarray['wake_night']);
$breathing_night = st($myarray['breathing_night']);
$morning_headaches = st($myarray['morning_headaches']);
$hours_sleep = st($myarray['hours_sleep']);
$quit_breathing = st($myarray['quit_breathing']);
$bed_time_partner = st($myarray['bed_time_partner']);
$sleep_same_room = st($myarray['sleep_same_room']);
$told_you_snore = st($myarray['told_you_snore']);
$main_reason = st($myarray['main_reason']);
$main_reason_other = st($myarray['main_reason_other']);
$sleep_qual = st($myarray['sleep_qual']);

if($complaintid <> '')
{
        $comp_arr1 = split('~',$complaintid);

        foreach($comp_arr1 as $i => $val)
        {
                $comp_arr2 = explode('|',$val);

                $compid[$i] = $comp_arr2[0];
                $compseq[$i] = $comp_arr2[1];
        }
}
?>
          <?php if($ess != ''){ ?>
          Baseline Epworth Sleepiness Score: <input type="text" id="ess" name="ess" value="<?= $ess; ?>" />
          <br />
          <?php } ?>
          <?php if($tss != ''){ ?>
          Baseline Thornton Snoring Scale: <input type="text" id="tss" name="tss" value="<?= $tss; ?>" />
          <?php } ?>

          <?php if($cheif_complaint_text != ''){ ?>
                    <label style="display:block;">
                        What is the main reason that you decided to seek treatment for snoring, Sleep Disordered Breathing, or Sleep Apnea?
                    </label>
                        <textarea style="width:400px; height:100px;" name="chief_complaint_text" id="chief_complain_text"><?= $chief_complaint_text; ?></textarea>
          <?php } ?>

<?php if($complaintid != '' || in_array('0', $compid)){ ?>
<h3>Complaints</h3>
<ul>
                <?php if($complaintid != ''){ ?>
                    <?
                                        $complaint_sql = "select * from dental_complaint where status=1 order by sortby";
                                        $complaint_my = mysql_query($complaint_sql);
                                        $complaint_number = mysql_num_rows($complaint_my);
                                        while($complaint_myarray = mysql_fetch_array($complaint_my))
                                        {
                                                if(@array_search($complaint_myarray['complaintid'],$compid) === false)
                                                {
                                                        $chk = '';
                                                }
                                                else
                                                {
                                                   #     $chk = ($compseq[@array_search($complaint_myarray['complaintid'],$compid)])?1:0;
                                                        ?><li><?= $complaint_myarray['complaint']; ?></li><?php
                                                }
                                        }

?>
<?php } ?>
<?php if($other_complaint != '' && in_array('0', $compid)){ ?>
<li><?= $other_complaint; ?></li>
<?php } ?>
</ul>
<?php } ?>

<h3>Subjective Signs/Symptoms</h3>

                    <div>
                        <span class="full">
                                <table width="100%" cellpadding="3" cellspacing="1" border="0">
                                <?php if($energy_level != ''){ ?>
                                <tr>
                                        <td valign="top" width="60%">
                                        Rate your overall energy level 0 -10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?= $energy_level;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($sleep_qual != ''){ ?>
                                                                <tr>
                                        <td valign="top">
                                        Rate your sleep quality 0-10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?=$sleep_qual;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($told_you_snore != ''){ ?>
                                                                                                <tr>
                                        <td valign="top">
                                        Have you been told you snore?
                                    </td>
                                    <td valign="top">
                                            <?=$told_you_snore;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($snoring_sound != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        Rate the sound of your snoring 0 -10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?=$snoring_sound ;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($wake_night != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        On average how many times per night do you wake up?
                                    </td>
                                    <td valign="top">
                                                <?=$wake_night;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($hours_sleep != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        On average how many hours of sleep do you get per night?
                                    </td>
                                    <td valign="top">
                                                <?=$hours_sleep;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($morning_headaches != ''){ ?>
                                                               <tr>
                                        <td valign="top">
                                        How often do you wake up with morning headaches?
                                    </td>
                                    <td valign="top">
                                            <?= $morning_headaches;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($bed_time_partner != ''){ ?>
                                                                                                <tr>
                                        <td valign="top">
                                        Do you have a bed time partner?
                                    </td>
                                    <td valign="top">
                                            <?= $bed_time_partner;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($sleep_same_room != ''){ ?>
                                                                <tr>
                                        <td valign="top">
                                        If yes do they sleep in the same room?
                                    </td>
                                    <td valign="top">
                                            <?= $sleep_same_room;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($quit_breathing != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        How many times per night does your bedtime partner notice you quit breathing?
                                    </td>
                                    <td valign="top">
                                            <?= $quit_breathing;?>
                                    </td>
                                </tr>
                                <? } ?>

                            </table>

                        </span>
                    </div>



<?php
/******************************
*
*
* Q_PAGE2
*
*/

$sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page2id = st($myarray['q_page2id']);
$polysomnographic = st($myarray['polysomnographic']);
$sleep_center_name_text = st($myarray['sleep_center_name_text']);
$sleep_study_on = st($myarray['sleep_study_on']);
$confirmed_diagnosis = st($myarray['confirmed_diagnosis']);
$rdi = st($myarray['rdi']);
$ahi = st($myarray['ahi']);
$cpap = st($myarray['cpap']);
$cur_cpap = st($myarray['cur_cpap']);
$intolerance = st($myarray['intolerance']);
$other_intolerance = st($myarray['other_intolerance']);
$other = st($myarray['other']);
$affidavit = st($myarray['affidavit']);
$type_study = st($myarray['type_study']);
$nights_wear_cpap = st($myarray['nights_wear_cpap']);
$percent_night_cpap = st($myarray['percent_night_cpap']);
$custom_diagnosis = st($myarray['custom_diagnosis']);
$sleep_study_by = st($myarray['sleep_study_by']);
$triedquittried = st($myarray['triedquittried']);
$timesovertime = st($myarray['timesovertime']);

if($cpap == '')
        $cpap = 'No';
?>
                                <?php if($polysomnographic != ''){ ?>
                    <div>
                        <span>
                                                        Have you had a sleep study

<?= ($polysomnographic == '1')?'Yes':'No'; ?>
<?php if($polysomnographic == '1'){ ?>
                                <?php if($sleep_center_name_text != ''){ ?>
                            At <?=$sleep_center_name_text;?>
                                <? } ?>
                                <?php if($sleep_study_on != ''){ ?>
                            Date
                            <?=$sleep_study_on;?>
                                <? } ?>
<?php } ?>
                        </span>
                    </div>
                <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        CPAP Intolerance
                    </label>
                                <?php if($cpap != ''){ ?>
                    <div>
                        <span>
                                Have you tried CPAP?
                            <input type="radio" class="cpap_radio" name="cpap" value="Yes" <? if($cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />
                            Yes

                            <input type="radio" class="cpap_radio" name="cpap" value="No" <? if($cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No

                </span>
                        </div>
                                <? } ?>
                                <?php if($cur_cpap != ''){  ?>
                    <div class="cpap_options">
                        <span>
                                Are you currently using CPAP?
                            <input type="radio" class="cur_cpap_radio" name="cur_cpap" value="Yes" <? if($cur_cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />                            Yes

                            <input type="radio" class="cur_cpap_radio" name="cur_cpap" value="No" <? if($cur_cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No

                        </span>
                        </div>

                                <? } ?>
                                <?php if($nights_wear_cpap != ''){ ?>
                                        <div class="cpap_options2">                        <span>
                                                        If currently using CPAP, how many nights / week do you wear it? <input id="nights_wear_cpap" name="nights_wear_cpap" type="text" class="field text addr tbox" value="<?=$nights_wear_cpap;?>" maxlength="255" style="width:225px;" />
                                                        <br />&nbsp;
                                                </span>
                                        </div>
                                <? } ?>
                                                                                            <?php if($percent_night_cpap != ''){ ?>
                                        <div class="cpap_options2">
                        <span>
                                                        How many hours each night do you wear it? <input id="percent_night_cpap" name="percent_night_cpap" type="text" class="field text addr tbox" value="<?=$percent_night_cpap;?>" maxlength="255" style="width:225px;" />

                                                        <br />&nbsp;
                                                </span>
                                        </div>
                                <? } ?>
                                <?php if($intolerance != ''){ ?>
                        <div id="cpap_options" class="cpap_options">
                        <span>
                                What are your chief complaints about CPAP?

                            <br />

                            <?
                                                        $intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
                                                        $intolerance_my = mysql_query($intolerance_sql);

                                                        while($intolerance_myarray = mysql_fetch_array($intolerance_my))
                                                        {
                                                        ?>
                                                                <input type="checkbox" id="intolerance" name="intolerance[]" value="<?=st($intolerance_myarray['intoleranceid'])?>" <? if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
                                <?php if($intolerance != $pat_row['intolerance'] && $showEdits){ ?>
                                                                <input type="checkbox" disabled="disabled" <? if(strpos($pat_row['intolerance'],'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
                                <?php } ?>
                                &nbsp;&nbsp;
                                <?=st($intolerance_myarray['intolerance']);?><br />
                                                        <?
                                                        }
                                                        ?>
                                        <input type="checkbox" id="cpap_other" name="intolerance[]" value="0" <? if(strpos($intolerance,'~'.st('0~')) === false) {} else { echo " checked";}?> onclick="chk_cpap_other()" />
                                <?php if($intolerance != $pat_row['intolerance'] && $showEdits){ ?>
                                                                <input type="checkbox" disabled="disabled" <? if(strpos($pat_row['intolerance'],'~'.st('0~')) === false) {} else { echo " checked";}?> />
                                <?php } ?>

&nbsp;&nbsp; Other<br />
                        </span>
                                        </div>
                                <? } ?>
                                <?php if($other_intolerance != ''){ ?>
                    <br />
                    <div class="cpap_options">
                        <span class="cpap_other_text">
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_intolerance" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_intolerance;?></textarea>
                                                        <br />&nbsp;
                        </span>
                    </div>
                                <? } ?>

