<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

if(isset($_POST['submitaddfu'])){
  $patientid = $_POST['patientid'];
  $ep_dateadd = date("Y-m-d H:i:s", strtotime($_POST['ep_dateadd']));
  $devadd = $_POST['devadd'];
  $dsetadd = $_POST['dsetadd'];
	$nightsperweek = $_POST['nightsperweek'];
  $ep_eadd = $_POST['ep_eadd'];
  $ep_tsadd = $_POST['ep_tsadd'];
  $ep_sadd = $_POST['ep_sadd'];
  $ep_radd = $_POST['ep_radd'];
  $ep_eladd = $_POST['ep_eladd'];
  $sleep_qualadd = $_POST['sleep_qualadd'];
  $ep_hadd = $_POST['ep_hadd'];
  $ep_wadd = $_POST['ep_wadd'];
  $wapnadd = $_POST['wapnadd'];
  $appt_notesadd = $_POST['appt_notesadd'];
  $insertquery = "INSERT INTO dentalsummfu (`patientid`, `ep_dateadd`,`devadd`,`dsetadd`,`nightsperweek`,`ep_eadd`,`ep_tsadd`,`ep_sadd`,`ep_radd`,`ep_eladd`,`sleep_qualadd`,`ep_hadd`,`ep_wadd`,`wapnadd`,`appt_notesadd`) VALUES (".$patientid.", '".$ep_dateadd."', '".$devadd."','".$dsetadd."','".$nightsperweek."','".$ep_eadd."','".$ep_tsadd."','".$ep_sadd."','".$ep_radd."','".$ep_eladd."','".$sleep_qualadd."','".$ep_hadd."','".$ep_wadd."','".$wapnadd."','".$appt_notesadd."');";
  $insert = mysql_query($insertquery);
  if(!$insert){
  echo "Could not insert follow up, please try again!";
  }
} 
?>
<html>
<head>
 <link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body style="width:10000px;background:none;">
<form id="sleepstudyadd" method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']."&pid=".$_GET['pid']; ?>">
	<table id="sleepstudyscrolltable" style="margin-top:-10px;">
<tr style="background: #444;height: 35px;">
  	<td colspan="4"><span style="color: #fff;">New</span></td>
  </tr>

  <tr style="height: 25px;">
    <td style="background: #F9FFDF;">
      <input type="text" size="12" style="width:100px;" name="ep_dateadd" value="<?php echo date('m/d/Y'); ?>" READONLY />
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <select name="devadd" style="width:150px;">
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
    
  <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="dsetadd" />
      
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <select name="nightsperweek" style="width:150px;">
        <?php
								for ($i = 0; $i <= 7; $i++)
								{	
                ?>  
								 <option value="<?=$i?>"><?=$i?></option>
								 <?php
								 }
								?>
    </select>	
				</td>
	</tr>

  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eadd" />
      
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_tsadd" />
      
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_sadd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_radd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eladd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="sleep_qualadd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" style="width:90px;" name="ep_hadd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_wadd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" style="width:90px;" name="wapnadd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="appt_notesadd" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
  	  <input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
      <input type="submit" name="submitaddfu" value="Submit Follow Up" id="submitaddfu" style="width:120px;" />
      
    </td>
  </tr>
					
				</table>
				
				</form>

<?php
$fuquery_sql = "SELECT * FROM dentalsummfu WHERE patientid ='".$_GET['pid']."'";
$fuquery_array = mysql_query($fuquery_sql);
if($fuquery_array){
$numrows = mysql_num_rows($fuquery_array);
}
while($fuquery = mysql_fetch_array($fuquery_array)){

$device_query = "SELECT device FROM dental_device WHERE deviceid = '".$fuquery['devadd']."';";
$device_result = mysql_query($device_query);
$device = mysql_result($device_result, 0);

 if($numrows){
  ?>

 <table id="sleepstudyscrolltable" style="margin-top:-10px">
  <tr style="background: #444;height: 25px;">
  	<td colspan="4"><span style="color: #ccc;"><?php echo $fuquery['followupid'];?></span></td>
  </tr>

  <tr style="height: 25px;">
    <td style="background: #F9FFDF;">
      <input type="text" size="12" style="width:75px;" name="ep_dateadd" value="<?php echo ($fuquery['ep_dateadd'])?date('m-d-Y', strtotime($fuquery['ep_dateadd'])):''; ?>" />
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="devadd" style="width:90px;" value="<?php echo $device;?>" />
      
    </td>
  </tr>
    
  <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="dsetadd" value="<?php echo $fuquery['dsetadd'];?>" />
      
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <select name="nightsperweek" style="width:150px;">
        <?php
								for ($i = 0; $i <= 7; $i++)
								{	 
								 print ($i == $fuquery['nightsperweek']) ? "<option selected value=\"$i\">$i</option>" : "<option value=\"$i\">$i</option>";
								 
								 }
								?>
    </select>	
				</td>
	</tr>

  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eadd" value="<?php echo $fuquery['ep_eadd'];?>" />
      
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_tsadd" value="<?php echo $fuquery['ep_tsadd'];?>" />
      
    </td>
  </tr>
  
  <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_sadd" value="<?php echo $fuquery['ep_sadd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_radd" value="<?php echo $fuquery['ep_radd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eladd" value="<?php echo $fuquery['ep_eladd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="sleep_qualadd" value="<?php echo $fuquery['sleep_qualadd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" style="width:90px;" name="ep_hadd" value="<?php echo $fuquery['ep_hadd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_wadd" value="<?php echo $fuquery['ep_wadd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" style="width:90px;" name="wapnadd" value="<?php echo $fuquery['wapnadd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="hours_sleepadd" value="<?php echo $fuquery['hours_sleepadd'];?>" />
      
    </td>
  </tr>
  
    <tr style="height: 25px;">
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="appt_notesadd" value="<?php $fuquery['appt_notesadd'] ?>" style="width:100px;" />
      
    </td>
  </tr>
					
				</table>
 <?php
 }
 }
 ?>


  
				
				</body>
				</html>
