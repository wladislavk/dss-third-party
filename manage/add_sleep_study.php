<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php"); 
?>
<html>
<head>
 <link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body style="width: 10000px; background: none repeat scroll 0% 0% transparent; height: 547px;">

 <?php 
 if(isset($_POST['submitnewsleeplabsumm'])){ 
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

<form action="#" method="POST" style="float:left; width:150px;">
<table id="sleepstudyscrolltable">
	<tr>
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="" onclick="cal1.popup();" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox" name="date" id="date">	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<select name="sleeptesttype">
      <option value="HST">HST</option>
      <option value="PST">PST</option>    
    </select>	
		</td>
</tr>
  <tr>		
		<td valign="top" style="background: #F9FFDF;">
		<select name="place">
		<?php
     $lab_place_q = "SELECT * FROM dental_sleeplab WHERE `status` = '1' ORDER BY DESC";
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
		<input type="text" name="02nadir" />	
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
        $device_sql = "select * from dental_device where status=1 order by sortby";
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

?>
<table id="sleepstudyscrolltable">
	<tr>
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['date']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['sleeptesttype']; ?>" />	
		</td>
</tr>
  <tr>		
		<td valign="top" style="background: #F9FFDF;"> 
		<input type="text" value="<?php echo $s_lab['place']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['apnea']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['hypopnea']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['ahi']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['ahisupine']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['rdi']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['rdisupine']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['02nadir']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['t9002']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['sleepefficiency']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['cpaplevel']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['dentaldevice']; ?>" />	
		</td>
  </tr>
  <tr>		
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['devicesetting']; ?>" />	
		</td>
	</tr>
  <tr>
		<td valign="top" style="background: #E4FFCF;">
		<input type="text" value="<?php echo $s_lab['diagnosis']; ?>" />	
		</td>
	</tr>
  <tr>	
		<td valign="top" style="background: #F9FFDF;">
		<input type="text" value="<?php echo $s_lab['notes']; ?>" />	
		</td>
	</tr>
</table>

<?php }
} ?>













  

</div>
</body>
</html>