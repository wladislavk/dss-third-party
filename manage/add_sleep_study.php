<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php"); 
require_once('includes/dental_patient_summary.php');

// Determine Type of Appliance
$sql = "SELECT dentaldevice FROM dental_summ_sleeplab WHERE patiendid ='".s_for($_GET['pid'])."' ORDER BY date DESC LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$deviceid = $row['dentaldevice'];
}
update_patient_summary($_GET['pid'], 'appliance', $deviceid);


?>
<html style="overflow-y:hidden;">
<head>
 <link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body style="width: 10000px; background: none repeat 0% 0% transparent; height: 557px;">

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
  $apnea = s_for($_POST['apnea']);
  $hypopnea = s_for($_POST['hypopnea']); 
  $ahi = s_for($_POST['ahi']); 
  $ahisupine = s_for($_POST['ahisupine']);
  $rdi = s_for($_POST['rdi']); 
  $rdisupine = s_for($_POST['rdisupine']); 
  $o2nadir = s_for($_POST['o2nadir']); 
  $t9002 = s_for($_POST['t9002']); 
  $sleepefficiency = s_for($_POST['sleepefficiency']);
  $cpaplevel = s_for($_POST['cpaplevel']);
  $dentaldevice = s_for($_POST['dentaldevice']); 
  $devicesetting = s_for($_POST['devicesetting']); 
  $diagnosis = s_for($_POST['diagnosis']); 
  $notes = s_for($_POST['notes']);
  $patientid = $_GET['pid']; 
  $q = "UPDATE dental_summ_sleeplab SET
`date` = '".$date."',
`sleeptesttype`  = '".$sleeptesttype."',
`place`  = '".$place."',
`apnea`  = '".$apnea."',
`hypopnea`  = '".$hypopnea."',
`ahi`  = '".$ahi."',
`ahisupine`  = '".$ahisupine."',
`rdi`  = '".$rdi."',
`rdisupine`  = '".$rdisupine."',
`o2nadir`  = '".$o2nadir."',
`t9002`  = '".$t9002."',
`sleepefficiency`  = '".$sleepefficiency."',
`cpaplevel`  = '".$cpaplevel."',
`dentaldevice`  = '".$dentaldevice."',
`devicesetting`  = '".$devicesetting."',
`diagnosis`  = '".$diagnosis."',
`notes`  = '".$notes."'
WHERE id='".$id."'
";
  $run_q = mysql_query($q);
  if(!$run_q){
   echo "Could not update sleep lab... Please try again.";
  }else{
   $msg = "Successfully updated sleep lab";
  }  
 }elseif(isset($_POST['submitnewsleeplabsumm'])){
  $date = s_for($_POST['date']);
  $sleeptesttype = s_for($_POST['sleeptesttype']);
  $place = s_for($_POST['place']);
  $apnea = s_for($_POST['apnea']);
  $hypopnea = s_for($_POST['hypopnea']);
  $ahi = s_for($_POST['ahi']);
  $ahisupine = s_for($_POST['ahisupine']);
  $rdi = s_for($_POST['rdi']);
  $rdisupine = s_for($_POST['rdisupine']);
  $o2nadir = s_for($_POST['o2nadir']);
  $t9002 = s_for($_POST['t9002']);
  $sleepefficiency = s_for($_POST['sleepefficiency']);
  $cpaplevel = s_for($_POST['cpaplevel']);
  $dentaldevice = s_for($_POST['dentaldevice']);
  $devicesetting = s_for($_POST['devicesetting']);
  $diagnosis = s_for($_POST['diagnosis']);
  $notes = s_for($_POST['notes']);
  $patientid = $_GET['pid'];
  $q = "INSERT INTO `dental_summ_sleeplab` (
`id` ,
`date` ,
`sleeptesttype` ,
`place` ,
`apnea` ,
`hypopnea` ,
`ahi` ,
`ahisupine` ,
`rdi` ,
`rdisupine` ,
`o2nadir` ,
`t9002` ,
`sleepefficiency` ,
`cpaplevel` ,
`dentaldevice` ,
`devicesetting` ,
`diagnosis` ,
`notes` ,
`patiendid`
)
VALUES (NULL,'".$date."','".$sleeptesttype."','".$place."','".$apnea."','".$hypopnea."','".$ahi."','".$ahisupine."','".$rdi."','".$rdisupine."','".$o2nadir."','".$t9002."','".$sleepefficiency."','".$cpaplevel."','".$dentaldevice."','".$devicesetting."','".$diagnosis."','".$notes."','".$patientid."')";
  $run_q = mysql_query($q);
  if(!$run_q){
   echo "Could not add sleep lab... Please try again.";
  }else{
   $msg = "Successfully added sleep lab";
  }
 }
 ?>
<div>
<style type="text/css">
.sleeplabstable tr{height:28px; }
</style>
<form action="#" method="POST" style="float:left; width:185px;">
<table class="sleeplabstable" id="sleepstudyscrolltable">
	<tr>
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" onclick="cal1.popup();" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox" name="date" id="date" value="<?= date('m/d/Y'); ?>">	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<select name="sleeptesttype" onchange="updatePlace(this.form);">
      <option value="HST">HST</option>
      <option value="PSG">PSG</option>    
    </select>	
<script type="text/javascript">

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
		<td valign="top" style="background: #F9FFDF;">
                <input type="text" name="home" disabled="disabled" value="Home" />
		<select style="display:none;" name="place">
		<?php
     $lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY sleeplabid DESC";
     $lab_place_r = mysql_query($lab_place_q);
     while($lab_place = mysql_fetch_array($lab_place_r)){
    ?>
		  <option value="<?php echo $lab_place['sleeplabid']; ?>"><?php echo $lab_place['company']; ?></option>
    <?php 
      }    
    ?>
    </select>	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="apnea" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="hypopnea" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="ahi" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="ahisupine" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="rdi" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="rdisupine" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="o2nadir" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="t9002" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="sleepefficiency" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="cpaplevel" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF; height:25px;">
		<select name="dentaldevice" style="width:150px;">
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
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="devicesetting" />	
		</td>
	</tr>
  <tr>
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="diagnosis" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="notes" />	
		</td>
	</tr>
	<tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="submit" name="submitnewsleeplabsumm" />	
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
<form action="#" method="post">
<input type="hidden" name="sleeplabid" value="<?php echo $s_lab['id']; ?>" />
<table id="sleepstudyscrolltable" class="sleeplabstable">
	<tr>
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="date" value="<?php echo $s_lab['date']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
                <select name="sleeptesttype" onchange="updatePlace(this.form)">
                   <option <?= ($s_lab['sleeptesttype']=="HST")?'selected="selected"':''; ?> value="HST">HST</option>
                   <option <?= ($s_lab['sleeptesttype']=="PSG")?'selected="selected"':''; ?> value="PSG">PSG</option>
                </select>

		</td>
</tr>
  <tr>		
		<td valign="top" style="background: #F9FFDF;"> 
                <input type="text" name="home" <?= ($s_lab['sleeptesttype']=="PSG")?'style="display:none;"':''; ?> disabled="disabled" value="Home" />
                <select <?= ($s_lab['sleeptesttype']!="PSG")?'style="display:none;"':''; ?> name="place">
                <?php
     $lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY sleeplabid DESC";
     $lab_place_r = mysql_query($lab_place_q);
     while($lab_place = mysql_fetch_array($lab_place_r)){
    ?>
                  <option <?= ($s_lab['place']==$lab_place['sleeplabid'])?'selected="selected"':''; ?> value="<?php echo $lab_place['sleeplabid']; ?>"><?php echo $lab_place['company']; ?></option>
    <?php
      }
    ?>
    </select>

		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="apnea" value="<?php echo $s_lab['apnea']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="hypopnea" value="<?php echo $s_lab['hypopnea']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="ahi" value="<?php echo $s_lab['ahi']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="ahisupine" value="<?php echo $s_lab['ahisupine']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="rdi" value="<?php echo $s_lab['rdi']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="rdisupine" value="<?php echo $s_lab['rdisupine']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="o2nadir" value="<?php echo $s_lab['o2nadir']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="t9002" value="<?php echo $s_lab['t9002']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="sleepefficiency" value="<?php echo $s_lab['sleepefficiency']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="cpaplevel" value="<?php echo $s_lab['cpaplevel']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
                <select name="dentaldevice" style="width:150px;">
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
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="devicesetting" value="<?php echo $s_lab['devicesetting']; ?>" />	
		</td>
	</tr>
  <tr>
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" name="diagnosis" value="<?php echo $s_lab['diagnosis']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" name="notes" value="<?php echo $s_lab['notes']; ?>" />	
		</td>
	</tr>
  <tr>
                <td valign="top" style="background: #E4FFCF;">
                <input type="submit" name="submitupdatesleeplabsumm" value="Update" />
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
