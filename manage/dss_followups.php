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
  $hours_sleepadd = $_POST['hours_sleepadd'];
  $appt_notesadd = $_POST['appt_notesadd'];
  $insertquery = "INSERT INTO dentalsummfu (`patientid`, `ep_dateadd`,`devadd`,`dsetadd`,`nightsperweek`,`ep_eadd`,`ep_tsadd`,`ep_sadd`,`ep_radd`,`ep_eladd`,`sleep_qualadd`,`ep_hadd`,`ep_wadd`,`wapnadd`,`hours_sleepadd`,`appt_notesadd`) VALUES (".$patientid.", '".$ep_dateadd."', '".$devadd."','".$dsetadd."','".$nightsperweek."','".$ep_eadd."','".$ep_tsadd."','".$ep_sadd."','".$ep_radd."','".$ep_eladd."','".$sleep_qualadd."','".$ep_hadd."','".$ep_wadd."','".$wapnadd."','".$hours_sleepadd."','".$appt_notesadd."');";
  $insert = mysql_query($insertquery);
  if(!$insert){
  echo "Could not insert follow up, please try again!";
  }
}elseif(isset($_POST['submitupdatefu'])){
  $id = $_POST['id'];
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
  $hours_sleepadd = $_POST['hours_sleepadd'];
  $appt_notesadd = $_POST['appt_notesadd'];
  $insertquery = "UPDATE dentalsummfu SET 
`ep_dateadd` = '".date('Y-m-d', strtotime($ep_dateadd))."',
`devadd` = '".$devadd."',
`dsetadd` = '".$dsetadd."',
`nightsperweek` = '".$nightsperweek."',
`ep_eadd` = '".$ep_eadd."',
`ep_tsadd` = '".$ep_tsadd."',
`ep_sadd` = '".$ep_sadd."',
`ep_radd` = '".$ep_radd."',
`ep_eladd` = '".$ep_eladd."',
`sleep_qualadd` = '".$sleep_qualadd."',
`ep_hadd` = '".$ep_hadd."',
`ep_wadd` = '".$ep_wadd."',
`wapnadd` = '".$wapnadd."',
`hours_sleepadd` = '".$hours_sleepadd."',
`appt_notesadd` = '".$appt_notesadd."'
WHERE followupid='".$id."'
;";
  $insert = mysql_query($insertquery);
  if(!$insert){
  echo "Could not update follow up, please try again!";
  }
}elseif(isset($_POST['submitdeletefu'])){
    $id = $_POST['id'];
  $delsql = "DELETE FROM dentalsummfu WHERE followupid='".mysql_real_escape_string($id)."'";
  mysql_query($delsql);
} 
?>
<html>
<head>
 <link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>
<?php
$fuquery_sql = "SELECT * FROM dentalsummfu WHERE patientid ='".$_GET['pid']."' ORDER BY followupid DESC";
$fuquery_array = mysql_query($fuquery_sql);
$numf = mysql_num_rows($fuquery_array);
$bodywidth = ($numf*160)+320;
?>

<body style="width:<?= $bodywidth; ?>px;background:none;">
<form id="sleepstudyadd" style="float:left;" method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']."&pid=".$_GET['pid']; ?>">
<style type="text/css">
#sleepstudyscrolltable tr{ height:28px; }
</style>
	<table id="sleepstudyscrolltable" style="margin-top:-3px;">
<tr style="background: #444;height: 30px;">
  	<td colspan="4"><span style="color: #fff;">New</span></td>
  </tr>

  <tr >
    <td style="background: #F9FFDF;">
      <input type="text" size="12" style="width:100px;" name="ep_dateadd" value="<?php echo date('m/d/Y'); ?>" />
    </td>
  </tr>
  
  <tr >
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
    
  <tr >
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="dsetadd" />
      
    </td>
  </tr>
  
  <tr >
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

  <tr >
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eadd" />
      
    </td>
  </tr>
  
  <tr >
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_tsadd" />
      
    </td>
  </tr>
  
  <tr >
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_sadd" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_radd" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eladd" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="sleep_qualadd" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
      <!--<input type="text" size="12" style="width:90px;" name="ep_hadd" />-->
<select name="ep_hadd" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Most Mornings" >
                                                Most Mornings
                                            </option>
                                            <option value="Several times per week" >
                                                Several times per week
                                            </option>
                                            <option value="Several times per month" >
                                                Several times per month
                                            </option>
                                            <option value="Occasionally" >
                                                Occasionally
                                            </option>
                                            <option value="Rarely" >
                                                Rarely
                                            </option>
                                            <option value="Never" >
                                                Never
                                            </option>
                                        </select>
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_wadd" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" style="width:90px;" name="wapnadd" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="hours_sleepadd" />
      
    </td>
  </tr>
    <tr>
            <td style="background: #E4FFCF;">
      <input type="text" size="12" name="appt_notesadd" style="width:100px;" />

    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
  	  <input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
      <input type="submit" name="submitaddfu" value="Submit Follow Up" id="submitaddfu" style="width:120px;" />
      
    </td>
  </tr>
					
				</table>
				
				</form>

<?php
$fuquery_sql = "SELECT * FROM dentalsummfu WHERE patientid ='".$_GET['pid']."' ORDER BY followupid DESC";
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
<form style="float:left;" class="sleepstudyupdate" method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']."&pid=".$_GET['pid']; ?>">
<input type="hidden" name="id" value="<?php echo $fuquery['followupid'];?>" /> 
 <table id="sleepstudyscrolltable" style="padding:0;margin-top:-3px">
  <tr style="background: #444;height: 30px;">
  	<td colspan="4"><span style="color: #ccc;"><?php echo $fuquery['followupid'];?></span></td>
  </tr>

  <tr>
    <td style="background: #F9FFDF;">
      <input type="text" size="12" style="width:75px;" name="ep_dateadd" value="<?php echo ($fuquery['ep_dateadd'])?date('m/d/Y', strtotime($fuquery['ep_dateadd'])):''; ?>" />
    </td>
  </tr>
  
  <tr>
  	    <td style="background: #E4FFCF;">
           <select name="devadd" style="width:150px;">
        <?php
        $device_sql = "select * from dental_device where status=1 order by sortby";
                                                                $device_my = mysql_query($device_sql);

                                                                while($device_myarray = mysql_fetch_array($device_my))
                                                                {
                ?>
                                                                 <option <?php echo ($device==$device_myarray['device'])?'selected="selected"':''; ?>value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                                                                 <?php
                                                                 }
                                                                ?>
    </select>
 
    </td>
  </tr>
    
  <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="dsetadd" value="<?php echo $fuquery['dsetadd'];?>" />
      
    </td>
  </tr>
  
  <tr>
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

  <tr>
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eadd" value="<?php echo $fuquery['ep_eadd'];?>" />
      
    </td>
  </tr>
  
  <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_tsadd" value="<?php echo $fuquery['ep_tsadd'];?>" />
      
    </td>
  </tr>
  
  <tr>
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_sadd" value="<?php echo $fuquery['ep_sadd'];?>" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_radd" value="<?php echo $fuquery['ep_radd'];?>" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_eladd" value="<?php echo $fuquery['ep_eladd'];?>" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="sleep_qualadd" value="<?php echo $fuquery['sleep_qualadd'];?>" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
      <!--<input type="text" size="12" style="width:90px;" name="ep_hadd" value="<?php echo $fuquery['ep_hadd'];?>" />-->
             <?php $morning_headaches = $fuquery['ep_hadd']; ?>
<select name="ep_hadd" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Most Mornings" <? if($morning_headaches == 'Most Mornings') echo " selected";?>>
                                                Most Mornings
                                            </option>
                                            <option value="Several times per week" <? if($morning_headaches == 'Several times per week') echo " selected";?>>
                                                Several times per week
                                            </option>
                                            <option value="Several times per month" <? if($morning_headaches == 'Several times per month') echo " selected";?>>
                                                Several times per month
                                            </option>
                                            <option value="Occasionally" <? if($morning_headaches == 'Occasionally') echo " selected";?>>
                                                Occasionally
                                            </option>
                                            <option value="Rarely" <? if($morning_headaches == 'Rarely') echo " selected";?>>
                                                Rarely
                                            </option>
                                            <option value="Never" <? if($morning_headaches == 'Never') echo " selected";?>>
                                                Never
                                            </option>
                                        </select>
 
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_wadd" value="<?php echo $fuquery['ep_wadd'];?>" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" style="width:90px;" name="wapnadd" value="<?php echo $fuquery['wapnadd'];?>" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #F9FFDF;">
      <input type="text" size="12" name="hours_sleepadd" value="<?php echo $fuquery['hours_sleepadd'];?>" />
      
    </td>
  </tr>
  
    <tr>
  	    <td style="background: #E4FFCF;">
      <input type="text" size="12" name="appt_notesadd" value="<?php echo $fuquery['appt_notesadd']; ?>" style="width:100px;" />
      
    </td>
  </tr>
    <tr>
            <td style="background: #E4FFCF;">
          <input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
      <input type="submit" name="submitupdatefu" value="Save Follow Up" id="submitupdatefu" style="width:120px;" />
      <input type="submit" name="submitdeletefu" onclick="return confirm('Are you sure you want to delete this follow up?');" value="Delete" id="submitdeletefu" style="width:120px;" />


    </td>
  </tr>
					
				</table>
</form>
 <?php
 }
 }
 ?>

<?php
$q_sql = "SELECT * FROM dental_q_page1 WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
$q_q = mysql_query($q_sql);
$q_row = mysql_fetch_assoc($q_q);

$t_sql = "SELECT tot_score FROM dental_thorton WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
$t_q = mysql_query($t_sql);
$t_row = mysql_fetch_assoc($t_q);

$s_sql = "SELECT analysis FROM dental_q_sleep WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
$s_q = mysql_query($s_sql);
$s_row = mysql_fetch_assoc($s_q);
$ep = preg_replace("/[^0-9]/", '', $s_row['analysis']);

?>
<form style="float:left;" class="sleepstudybaseline" method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']."&pid=".$_GET['pid']; ?>">
<input type="hidden" name="id" value="baseline" />
 <table id="sleepstudyscrolltable" style="padding:0;margin-top:-3px">
  <tr style="background: #444;height: 30px;">
        <td colspan="4"><span style="color: #ccc;">Baseline</span></td>
  </tr>
<?php
  $s = "SELECT * FROM dental_q_page1 WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  ?>
  <tr>
    <td style="background: #F9FFDF;">
      <input type="text" size="12" style="width:75px;" name="exam_date" value="<?php echo ($q_row['exam_date'])?date('m/d/Y', strtotime($q_row['exam_date'])):''; ?>" />
    </td>
  </tr>

  <tr>
            <td style="background: #E4FFCF;">
           <select name="devadd" style="width:150px;">
        <?php
        $device_sql = "select * from dental_device where status=1 order by sortby";
                                                                $device_my = mysql_query($device_sql);

                                                                while($device_myarray = mysql_fetch_array($device_my))
                                                                {
                ?>
                                                                 <option <?php echo ($device==$device_myarray['device'])?'selected="selected"':''; ?>value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                                                                 <?php
                                                                 }
                                                                ?>
    </select>

    </td>
  </tr>

  <tr>
            <td style="background: #F9FFDF;">
      <input type="text" size="12" name="dsetadd" value="<?php echo $fuquery['dsetadd'];?>" />

    </td>
  <tr>
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

  <tr>
            <td style="background: #E4FFCF;">      <input type="text" size="12" name="ep_eadd" value="<?php echo $r['ess'];?>" />

    </td>
  </tr>

  <tr>
            <td style="background: #F9FFDF;">
      <input type="text" size="12" name="tot_score" value="<?php echo $r['tss'];?>" />

    </td>
  </tr>

  <tr>
            <td style="background: #E4FFCF;">
      <input type="text" size="12" name="ep_sadd" value="<?php echo $q_row['snoring_sound'];?>" />

    </td>
  </tr>

    <tr>
            <td style="background: #F9FFDF;">
      <input type="text" size="12" name="ep_radd" value="<?php echo $fuquery['ep_radd'];?>" />

    </td>
  </tr>

    <tr>
            <td style="background: #E4FFCF;">
      <input type="text" size="12" name="energy_level" value="<?php echo $q_row['energy_level'];?>" />

    </td>
  </tr>

    <tr>
            <td style="background: #F9FFDF;">
      <input type="text" size="12" name="sleep_qual" value="<?php echo $q_row['sleep_qual'];?>" />

    </td>
  </tr>

    <tr>
            <td style="background: #E4FFCF;">
	<?php $morning_headaches = $q_row['morning_headaches']; ?>
<select name="morning_headaches" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Most Mornings" <? if($morning_headaches == 'Most Mornings') echo " selected";?>>
                                                Most Mornings
                                            </option>
                                            <option value="Several times per week" <? if($morning_headaches == 'Several times per week') echo " selected";?>>
                                                Several times per week
                                            </option>
                                            <option value="Several times per month" <? if($morning_headaches == 'Several times per month') echo " selected";?>>
                                                Several times per month
                                            </option>
                                            <option value="Occasionally" <? if($morning_headaches == 'Occasionally') echo " selected";?>>
                                                Occasionally
                                            </option>
                                            <option value="Rarely" <? if($morning_headaches == 'Rarely') echo " selected";?>>
                                                Rarely
                                            </option>
                                            <option value="Never" <? if($morning_headaches == 'Never') echo " selected";?>>
                                                Never
                                            </option>
                                        </select>
    </td>
  </tr>

    <tr>
            <td style="background: #F9FFDF;">
      <input type="text" size="12" name="wake_night" value="<?php echo $q_row['wake_night'];?>" />

    </td>
  </tr>

    <tr>
            <td style="background: #E4FFCF;">
      <input type="text" size="12" style="width:90px;" name="wapnadd" value="<?php echo $r['quit_breathing'];?>" />

    </td>
  </tr>

    <tr>
            <td style="background: #F9FFDF;">
      <input type="text" size="12" name="hours_sleepadd" value="<?php echo $q_row['hours_sleep'];?>" />

    </td>
  </tr>


    <tr>
            <td style="background: #E4FFCF;">
      <input type="text" size="12" name="appt_notesadd" value="<?php echo $fuquery['appt_notesadd']; ?>" style="width:100px;" />

    </td>
  </tr>
    <tr>
            <td style="background: #E4FFCF;">
          <input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
	  <input type="button" value="Save Baseline" onclick="gotoQuestionnaire();" />
    </td>
  </tr>

                                </table>
</form>
<script type="text/javascript">
function gotoQuestionnaire(){
  parent.window.location = 'q_page1.php?pid=<?= $_GET['pid']; ?>';
}
</script>
  
				
				</body>
				</html>
