<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php"); 
require_once('includes/constants.inc');
require_once('includes/dental_patient_summary.php');
require_once('includes/general_functions.php');
?>
  <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<?php
include("includes/calendarinc.php");
// Determine Type of Appliance
$sql = "SELECT dentaldevice FROM dental_summ_sleeplab WHERE patiendid ='".s_for($_GET['pid'])."' ORDER BY date DESC LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$deviceid = $row['dentaldevice'];
}
update_patient_summary($_GET['pid'], 'appliance', $deviceid);

$s_lab_query = "SELECT * FROM dental_summ_sleeplab WHERE patiendid ='".$_GET['pid']."' ORDER BY id DESC";
$s_lab_result = mysql_query($s_lab_query);
$num_labs = mysql_num_rows($s_lab_result);
if(isset($_POST['submitnewsleeplabsumm'])){ $num_labs++;
?>
<script type="text/javascript">parent.updateiframe(<?= $num_labs; ?>);</script>
<?php
}
$body_width = ($num_labs*185)+215;
?>
<html style="overflow:hidden;">
<head>
 <link href="css/admin.css" rel="stylesheet" type="text/css" />
<!--  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
  <link rel="stylesheet" href="css/form.css" />
<script type="text/javascript">
function update_needed(v, f){
        if(v=='yes'){
                f.elements["scheddate"].style.visibility='visible';
                showWhere(f);
                autoselect(v,f);
                f.elements['interpolation'][0].style.visibility='visible';
                f.elements['interpolation'][1].style.visibility='visible';
        }else{
                f.elements["scheddate"].style.visibility='hidden';
                hideWhere(f);
                autoselect(v,f);
                f.elements['interpolation'][0].style.visibility='hidden';
                f.elements['interpolation'][1].style.visibility='hidden';
        }
}

function showWhere(f){
        f.elements["place"].style.display="block";
}

function hideWhere(f){
        f.elements["place"].style.display='none';
}

function autoselect(selectedOption, f) {
        if(selectedOption=="no") {
                f.elements["completed"][0].checked=true;        } else {
                f.elements["completed"][1].checked=true;
        }
}

</script>
</head>
<body style="width:<?= $body_width;?>px; background: none repeat 0% 0% transparent; height: 557px; position:absolute;top:0;margin:0; padding:0;">

 <?php 
 if(isset($_POST['submitdeletesleeplabsumm'])){
  $id = s_for($_POST['sleeplabid']);
   $q = "DELETE FROM dental_summ_sleeplab WHERE id=".mysql_real_escape_string($id);
   if(!mysql_query($q)){
       echo "Could not delete sleep lab... Please try again.";
    }else{
     $msg = "Successfully deleted sleep lab";
    }
 
 }elseif(isset($_POST['submitupdatesleeplabsumm'])){ 
  $id = s_for($_POST['sleeplabid']);
  $date = s_for($_POST['date']);
  $sleeptesttype = s_for($_POST['sleeptesttype']);
  $place = s_for($_POST['place']);
  $diagnosising_doc = s_for($_POST['diagnosising_doc']);
  $diagnosising_npi = s_for($_POST['diagnosising_npi']);
  $ahi = s_for($_POST['ahi']); 
  $ahisupine = s_for($_POST['ahisupine']);
  $rdi = s_for($_POST['rdi']); 
  $rdisupine = s_for($_POST['rdisupine']); 
  $o2nadir = s_for($_POST['o2nadir']); 
  $t9002 = s_for($_POST['t9002']); 
  $dentaldevice = s_for($_POST['dentaldevice']); 
  $devicesetting = s_for($_POST['devicesetting']); 
  $diagnosis = s_for($_POST['diagnosis']); 
  $notes = s_for($_POST['notes']);
  $testnumber = s_for($_POST['testnumber']);
  $needed = s_for($_POST['needed']);
  $scheddate = s_for($_POST['scheddate']);
  $completed = s_for($_POST['completed']);
  $interpolation = s_for($_POST['interpolation']);
  $patientid = $_GET['pid']; 
	$s = "SELECT filename from dental_summ_sleeplab WHERE id='".$id."'";
	$prevfile_result = mysql_query($s);
        $prev_filename = mysql_result($prevfile_result, 0, 0);

                if($_FILES["ss_file"]["name"] <> '')
                {
                        $fname = $_FILES["ss_file"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;
                        $uploaded = uploadImage($_FILES['ss_file'], "q_file/".$banner1);
			if($prev_filename != ''){
                                        $ins_sql = " update dental_q_image set 
                                        image_file = '".s_for($banner1)."'
                                        WHERE title='Sleep Study ".$id."';";

                                        mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
                          unlink("q_file/" . $prev_filename);
			}
                }
                else
                {
                        $banner1 = $prev_filename;
                }

  $q = "UPDATE dental_summ_sleeplab SET
`date` = '".$date."',
`sleeptesttype`  = '".$sleeptesttype."',
`place`  = '".$place."',
`diagnosising_doc` = '".$diagnosising_doc."',
`diagnosising_npi` = '".$diagnosising_npi."',
`ahi`  = '".$ahi."',
`ahisupine`  = '".$ahisupine."',
`rdi`  = '".$rdi."',
`rdisupine`  = '".$rdisupine."',
`o2nadir`  = '".$o2nadir."',
`t9002`  = '".$t9002."',
`dentaldevice`  = '".$dentaldevice."',
`devicesetting`  = '".$devicesetting."',
`diagnosis`  = '".$diagnosis."',
`filename` = '".$banner1."',
`notes`  = '".$notes."',
`testnumber` = '".$testnumber."',
`needed` = '".$needed."',
`scheddate` = '".$scheddate."',
`completed` = '".$completed."',
`interpolation` = '".$interpolation."',
WHERE id='".$id."'
";
  $run_q = mysql_query($q);
  if(!$run_q){
   echo "Could not update sleep lab... Please try again.";
  }else{
if($prev_filename == ''){
if($uploaded){
                                        $ins_sql = " insert into dental_q_image set 
                                        patientid = '".s_for($_GET['pid'])."',
                                        title = 'Sleep Study ".$id."',
                                        imagetypeid = '1',
                                        image_file = '".s_for($banner1)."',
                                        userid = '".s_for($_SESSION['userid'])."',
                                        docid = '".s_for($_SESSION['docid'])."',
                                        adddate = now(),
                                        ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                                        mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
}
}
   $msg = "Successfully updated sleep lab";
  }  
 }elseif(isset($_POST['submitnewsleeplabsumm'])){
  $date = s_for($_POST['date']);
  $sleeptesttype = s_for($_POST['sleeptesttype']);
  $place = s_for($_POST['place']);
  $diagnosising_doc = s_for($_POST['diagnosising_doc']);
  $diagnosising_npi = s_for($_POST['diagnosising_npi']);
  $ahi = s_for($_POST['ahi']);
  $ahisupine = s_for($_POST['ahisupine']);
  $rdi = s_for($_POST['rdi']);
  $rdisupine = s_for($_POST['rdisupine']);
  $o2nadir = s_for($_POST['o2nadir']);
  $t9002 = s_for($_POST['t9002']);
  $dentaldevice = s_for($_POST['dentaldevice']);
  $devicesetting = s_for($_POST['devicesetting']);
  $diagnosis = s_for($_POST['diagnosis']);
  $notes = s_for($_POST['notes']);
  $testnumber = s_for($_POST['testnumber']);
  $needed = s_for($_POST['needed']);
  $scheddate = s_for($_POST['scheddate']);
  $completed = s_for($_POST['completed']);
  $interpolation = s_for($_POST['interpolation']);
  $patientid = $_GET['pid'];
                if($_FILES["ss_file"]["name"] <> '')
                {
                        $fname = $_FILES["ss_file"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

                        $uploaded = uploadImage($_FILES['ss_file'], "q_file/".$banner1);

                }
                else
                {
                        $banner1 = ''; 
                }
  $q = "INSERT INTO `dental_summ_sleeplab` (
`id` ,
`date` ,
`sleeptesttype` ,
`place` ,
`diagnosising_doc`,
`diagnosising_npi`,
`ahi` ,
`ahisupine` ,
`rdi` ,
`rdisupine` ,
`o2nadir` ,
`t9002` ,
`dentaldevice` ,
`devicesetting` ,
`diagnosis` ,
`filename` ,
`notes`,
`testnumber`,
`needed`,
`scheddate`,
`completed`,
`interpolation`,
`patiendid`
)
VALUES (NULL,'".$date."','".$sleeptesttype."','".$place."','".$diagnosising_doc."','".$diagnosising_npi."','".$ahi."','".$ahisupine."','".$rdi."','".$rdisupine."','".$o2nadir."','".$t9002."','".$dentaldevice."','".$devicesetting."','".$diagnosis."','".$banner1."', '".$notes."', '".$testnumber."', '".$needed."', '".$scheddate."', '".$completed."', '".$interpolation."', '".$patientid."')";
  $run_q = mysql_query($q);
  if(!$run_q){
   echo "Could not add sleep lab... Please try again.";
  }else{
	if($uploaded){
		$ins_id = mysql_insert_id();
                                        $ins_sql = " insert into dental_q_image set 
                                        patientid = '".s_for($_GET['pid'])."',
                                        title = 'Sleep Study ".$ins_id."',
                                        imagetypeid = '1',
                                        image_file = '".s_for($banner1)."',
                                        userid = '".s_for($_SESSION['userid'])."',
                                        docid = '".s_for($_SESSION['docid'])."',
                                        adddate = now(),
                                        ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                                        mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
}
   $msg = "Successfully added sleep lab". $uploaded;
  }
 }
$sleepstudies = "SELECT ss.* FROM dental_summ_sleeplab ss                                 
			JOIN dental_patients p on ss.patiendid=p.patientid                        
		WHERE                                 
			(p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
			(ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
			ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."';";

                $result = mysql_query($sleepstudies);
                $numsleepstudy = mysql_num_rows($result);
	$sleepstudy = ($numsleepstudy > 0)?true:false;
	$show_yellow = ($_GET['yellow'])?true:false;
 ?>
<style type="text/css">
.sleeplabstable tr{height:28px; }
.yellow .odd, .yellow .even{
background:#edeb46;
}

  .odd{ background: #F9FFDF; }
  .even{ background: #e4ffcf; }
  .new_table .odd, .new_table .even {background: #add8e6; }
  select{width:140px;}
</style>
<?php

$pat_sql = "SELECT p_m_ins_type FROM dental_patients WHERE patientid='".$_GET['pid']."';";
$pat_q = mysql_query($pat_sql);
$pat_r = mysql_fetch_assoc($pat_q);
?>
<form id="new_sleep_study_form" action="#" method="POST" style="float:left; width:185px;display:none;" enctype="multipart/form-data">
<table class="sleeplabstable new_table <?php print ($show_yellow && !$sleepstudy  ? 'yellow' : ''); ?>" id="sleepstudyscrolltable">
	<tr>
		<td valign="top" class="even">
		<input type="text" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox calendar" name="date" id="date" value="<?= date('m/d/Y'); ?>">	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		<select name="sleeptesttype">
      <option value="PSG Titration">PSG Titration</option>    
      <option value="PSG Baseline">PSG Baseline</option>
      <option value="HST Baseline">HST Baseline</option>
      <option value="HST Titration">HST Titration</option>
    </select>	
<script type="text/javascript">
function show_new_study(){
  $('#new_sleep_study_form').show();
}
function updatePlace(f){
if(f.sleeptesttype.value == "HST"){
  f.place.style.display = "none";
  f.home.style.display = "block";
}else{
  f.place.style.display = "block";
  f.home.style.display = "none";
}
}

</script>
		</td>
</tr>
  <tr>
                <td valign="top" class="even">
                                <div name="interpolationdiv">
                                                <input type="radio" name="interpolation" value="Yes"><span>Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="interpolation" value="No"><span>No</span>
                                </div>
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
<script type="text/javascript">

function addstudylab(v){
  if(v == 'add'){
    parent.loadPopupRefer('add_sleeplab.php?r=flowsheet');
  }
}

</script>
                <select name="place" class="place_select" onchange="addstudylab(this.value)">
<option>SELECT</option>
                <?php
     $lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY sleeplabid DESC";
     $lab_place_r = mysql_query($lab_place_q);
     while($lab_place = mysql_fetch_array($lab_place_r)){
    ?>
                  <option value="<?php echo $lab_place['sleeplabid']; ?>"><?php echo $lab_place['company']; ?></option>
    <?php
      }
    ?>
		<option value="add">ADD SLEEP LAB</option>
    </select>
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                          <select name="diagnosis" style="width:140px;" class="field text addr tbox" >
                                <option value="">SELECT</option>
                        <?php
                                $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
                                                                           $ins_diag_my = mysql_query($ins_diag_sql);

                                                                                while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
                                                                                {
                                                                                ?>
                                                                                        <option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" >
                                                                                                <?=st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?>
                                                                                        </option>
                                                                                <?
                                                                                }?>

                            </select> <span id="req_0" class="req">*</span>
                </td>
        </tr>
	<tr>
                <td valign="top" class="odd">
                  <input style="width:100px;" type="text" name="diagnosising_doc" /> 
		<?php
			if($pat_r['p_m_ins_type']==1){
		?>
		<span id="req_0" class="req">*</span>
		<?php
			}
		?>
                </td>
        </tr>
	<tr>
                <td valign="top" class="even">
                  <input style="width:100px;" type="text" name="diagnosising_npi" />
                <?php
                        if($pat_r['p_m_ins_type']==1){
                ?>
                <span id="req_0" class="req">*</span>
                <?php
                        }
                ?> 
                </td>
        </tr>

  <tr>
                <td valign="top" class="odd">
                  <input style="width:140px" size="8" type="file" name="ss_file" /> <span id="req_0" class="req">*</span>
                </td>
        </tr>
  <tr>	
		<td valign="top" class="even">
		<input type="text" name="ahi" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		<input type="text" name="ahisupine" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		<input type="text" name="rdi" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		<input type="text" name="rdisupine" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		<input type="text" name="o2nadir" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		<input type="text" name="t9002" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even" style="height:25px;">
		<select name="dentaldevice" style="width:150px;">
<option value="">SELECT</option>
        <?php
        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
								$device_my = mysql_query($device_sql);
								
								while($device_myarray = mysql_fetch_array($device_my))
								{	
                ?>  
								 <option value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
								 <?php
								 }
								?>
    </select>	
		</td>
  </tr>
  <tr>		
		<td valign="top" class="odd">
		<input type="text" name="devicesetting" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		<input type="text" name="notes" />	
		</td>
	</tr>
	<tr>	
		<td valign="top" class="odd">
		<input type="submit" name="submitnewsleeplabsumm" value="Submit Study" />	
		<input type="button" onclick="$('#new_sleep_study_form').hide(); parent.show_new_sleep_but(); return false;" value="Cancel" />
		</td>
	</tr>
</table>
<script type="text/javascript">
var cal1 = new calendar2(document.getElementById('date'));
</script>
</form>



 
<?php 
$s_lab_query = "SELECT * FROM dental_summ_sleeplab WHERE patiendid ='".$_GET['pid']."' ORDER BY id DESC";
$s_lab_result = mysql_query($s_lab_query);

if($s_lab_result){
while($s_lab = mysql_fetch_array($s_lab_result)){

$sleeplab_query = "SELECT company FROM dental_sleeplab WHERE sleeplabid = '".$s_lab['place']."';";
$sleeplab_result = mysql_query($sleeplab_query);
$place = mysql_result($sleeplab_result, 0);

$device_query = "SELECT device FROM dental_device WHERE deviceid = '".$s_lab['dentaldevice']."';";
$device_result = mysql_query($device_query);
$device = mysql_result($device_result, 0);

?>
<form action="#" style="float:left;" method="post" enctype="multipart/form-data">
<input type="hidden" name="sleeplabid" value="<?php echo $s_lab['id']; ?>" />
<table id="sleepstudyscrolltable" class="sleeplabstable <?php print ($show_yellow && !$sleepstudy  ? 'yellow' : ''); ?>">
	<tr>
		<td valign="top" class="even">
		<input type="text" name="date" id="date<?= $s_lab['id']; ?>" class="calendar" value="<?php echo $s_lab['date']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
                <select name="sleeptesttype">
                   <option <?= ($s_lab['sleeptesttype']=="PSG Titration")?'selected="selected"':''; ?> value="PSG Titration">PSG</option>
	           <option <?= ($s_lab['sleeptesttype']=="PSG Baseline")?'selected="selected"':''; ?> value="PSG Baseline">PSG Baseline</option>
     		   <option <?= ($s_lab['sleeptesttype']=="HST Baseline")?'selected="selected"':''; ?> value="HST Baseline">HST Baseline</option>
      		   <option <?= ($s_lab['sleeptesttype']=="HST Titration")?'selected="selected"':''; ?> value="HST Titration">HST Titration</option>

                </select>

		</td>
</tr>
  <tr>
                <td valign="top" class="even">
                                                <input type="radio" name="interpolation" value="Yes" <?= ($s_lab['interpolation']=="Yes")?'checked="checked"':''; ?>><label for="interpolation">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="interpolation" value="No" <?= ($s_lab['interpolation']=="No")?'checked="checked"':''; ?>><label for="interpolation">No</label>
                </td>
        </tr>

  <tr>		
		<td valign="top" class="odd"> 
                <select name="place" class="place_select" onchange="addstudylab(this.value)">
<option>SELECT</option>
                <?php
     $lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY sleeplabid DESC";
     $lab_place_r = mysql_query($lab_place_q);
     while($lab_place = mysql_fetch_array($lab_place_r)){
    ?>
                  <option <?= ($s_lab['place']==$lab_place['sleeplabid'])?'selected="selected"':''; ?> value="<?php echo $lab_place['sleeplabid']; ?>"><?php echo $lab_place['company']; ?></option>
    <?php
      }
    ?>
<option value="add">ADD SLEEP LAB</option>
    </select>

		</td>
	</tr>
  <tr>
                <td valign="top" class="even">
                          <select name="diagnosis" style="width:140px;" class="field text addr tbox" >
                                <option value="">SELECT</option>
 <?php
                                $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
                                                                           $ins_diag_my = mysql_query($ins_diag_sql);

                                                                                while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
                                                                                {
                                                                                ?>
                                                                                        <option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" <? if($s_lab['diagnosis'] == st($ins_diag_myarray['ins_diagnosisid'])) echo " selected";?>>
                                                                                                <?=st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?>
                                                                                        </option>
                                                                                <?
                                                                                }?>

                            </select> <span id="req_0" class="req">*</span>

                </td>
        </tr>
        <tr>
                <td valign="top" class="odd">
                  <input type="text" name="diagnosising_doc" value="<?php echo $s_lab['diagnosising_doc']; ?>" style="width:100px;" />
                <?php
                        if($pat_r['p_m_ins_type']==1){
                ?>
                <span id="req_0" class="req">*</span>
                <?php
                        }
                ?>
 
                </td>
        </tr>
        <tr>
                <td valign="top" class="even">
                  <input type="text" name="diagnosising_npi" value="<?php echo $s_lab['diagnosising_npi']; ?>" style="width:100px;" />
                <?php
                        if($pat_r['p_m_ins_type']==1){
                ?>
                <span id="req_0" class="req">*</span>
                <?php
                        }
                ?>
 
                </td>
        </tr>

  <tr>
                <td valign="top" class="odd">
                        <?php if($s_lab['filename']!=''){ ?>
                                                <div id="file_edit_<?= $s_lab['id']; ?>">
                                <input type="button" id="view" value="View" title="View" onClick="window.open('q_file/<?= $s_lab['filename']; ?>','windowname1','width=400, height=400');return false;" />
                                                        <input type="button" id="edit" onclick="$('#file_edit_<?= $s_lab['id']; ?>').hide();$('#file_<?= $s_lab['id']; ?>').show();return false;" value="Edit" title="Edit" />
                                                </div>
                                                        <input id="file_<?= $s_lab['id']; ?>" style="width: 170px;display:none;" name="ss_file" type="file" size="8" />

                        <?php }else{ ?>
                          <input style="width:140px;" size="8" type="file" name="ss_file" /> <span id="req_0" class="req">*</span>
                        <?php } ?>
                </td>
        </tr>

  <tr>	
		<td valign="top" class="even">
		<input type="text" name="ahi" value="<?php echo $s_lab['ahi']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		<input type="text" name="ahisupine" value="<?php echo $s_lab['ahisupine']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		<input type="text" name="rdi" value="<?php echo $s_lab['rdi']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		<input type="text" name="rdisupine" value="<?php echo $s_lab['rdisupine']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		<input type="text" name="o2nadir" value="<?php echo $s_lab['o2nadir']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="odd">
		<input type="text" name="t9002" value="<?php echo $s_lab['t9002']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
                <select name="dentaldevice" style="width:150px;">
<option value="">SELECT</option>
        <?php
        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                                                                $device_my = mysql_query($device_sql);

                                                                while($device_myarray = mysql_fetch_array($device_my))
                                                                {
                ?>
                                                                 <option <?= ($device==$device_myarray['device'])?'selected="selected"':'';?> value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                                                                 <?php
                                                                 }
                                                                ?>
    </select>

		</td>
  </tr>
  <tr>		
		<td valign="top" class="odd">
		<input type="text" name="devicesetting" value="<?php echo $s_lab['devicesetting']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" class="even">
		<input type="text" name="notes" value="<?php echo $s_lab['notes']; ?>" />	
		</td>
	</tr>
  <tr>
                <td valign="top" class="odd">
                <input type="submit" name="submitupdatesleeplabsumm" value="Save" />
		<input type="submit" name="submitdeletesleeplabsumm" onclick='return confirm("Are you sure you want to delete this study?")' value="Delete" />
                </td>
        </tr>

</table>
</form>
<?php }
} ?>













  

</div>
</body>
</html>
