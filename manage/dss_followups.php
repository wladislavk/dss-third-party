<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");

if(isset($_POST['submitaddfu'])){
  $patientid = $db->escape($_POST['patientid']);
  $ep_dateadd = $db->escape(date("Y-m-d H:i:s", strtotime($_POST['ep_dateadd'])));
  $devadd = $db->escape($_POST['devadd']);
  $dsetadd = $db->escape($_POST['dsetadd']);
	$nightsperweek = $db->escape($_POST['nightsperweek']);
  $ep_eadd = $db->escape($_POST['ep_eadd_new']);
  $ep_tsadd = $db->escape($_POST['ep_tsadd_new']);
  $ep_sadd = $db->escape($_POST['ep_sadd']);
  $ep_eladd = $db->escape($_POST['ep_eladd']);
  $sleep_qualadd = $db->escape($_POST['sleep_qualadd']);
  $ep_hadd = $db->escape($_POST['ep_hadd']);
  $ep_wadd = $db->escape($_POST['ep_wadd']);
  $wapnadd = $db->escape($_POST['wapnadd']);
  $hours_sleepadd = $db->escape($_POST['hours_sleepadd']);
  $appt_notesadd = $db->escape($_POST['appt_notesadd']);
  $insertquery = "INSERT INTO dentalsummfu (
        `patientid`,
        `ep_dateadd`,
        `devadd`,
        `dsetadd`,
        `nightsperweek`,
        `ep_eadd`,
        `ep_tsadd`,
        `ep_sadd`,
        `ep_eladd`,
        `sleep_qualadd`,
        `ep_hadd`,
        `ep_wadd`,
        `wapnadd`,
        `hours_sleepadd`,
        `appt_notesadd`
      ) VALUES (
        '$patientid',
        '$ep_dateadd',
        '$devadd',
        '$dsetadd',
        '$nightsperweek',
        '$ep_eadd',
        '$ep_tsadd',
        '$ep_sadd',
        '$ep_eladd',
        '$sleep_qualadd',
        '$ep_hadd',
        '$ep_wadd',
        '$wapnadd',
        '$hours_sleepadd',
        '$appt_notesadd'
      );";
  $fu_id = $db->getInsertId($insertquery);
  if(!$fu_id){
    echo "Could not insert follow up, please try again!";
  }else{
    $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
    $epworth_my = $db->getResults($epworth_sql);
    foreach ($epworth_my as $epworth_myarray) {
      $i = "INSERT INTO dentalsummfu_ess SET
              epworthid='".$epworth_myarray['epworthid']."',
              followupid='".$fu_id."',
              answer='".$db->escape($_POST['epworth_new_'.$epworth_myarray['epworthid']])."',
              adddate=now(),
              ip_address='".$_SERVER['REMOTE_ADDR']."'";
      $db->query($i);
    }
    for($thorntonid=1; $thorntonid<=5; $thorntonid++){
      $i = "INSERT INTO dentalsummfu_tss SET
              thorntonid='".$thorntonid."',
              followupid='".$fu_id."',
              answer='".$db->escape($_POST['thornton_new_'.$thorntonid])."',
              adddate=now(),
              ip_address='".$_SERVER['REMOTE_ADDR']."'";
      $db->query($i);
    }
  }
}elseif(isset($_POST['submitupdatefu'])){
  $id = $db->escape($_POST['id']);
  $patientid = $db->escape($_POST['patientid']);
  $ep_dateadd = date("Y-m-d H:i:s", strtotime($_POST['ep_dateadd']));
  $devadd = $db->escape($_POST['devadd']);
  $dsetadd = $db->escape($_POST['dsetadd']);
  $nightsperweek = $db->escape($_POST['nightsperweek']);
  $ep_eadd = $db->escape($_POST['ep_eadd']);
  $ep_tsadd = $db->escape($_POST['ep_tsadd']);
  $ep_sadd = $db->escape($_POST['ep_sadd']);
  $ep_eladd = $db->escape($_POST['ep_eladd']);
  $sleep_qualadd = $db->escape($_POST['sleep_qualadd']);
  $ep_hadd = $db->escape($_POST['ep_hadd']);
  $ep_wadd = $db->escape($_POST['ep_wadd']);
  $wapnadd = $db->escape($_POST['wapnadd']);
  $hours_sleepadd = $db->escape($_POST['hours_sleepadd']);
  $appt_notesadd = $db->escape($_POST['appt_notesadd']);
  $insertquery = "UPDATE dentalsummfu SET 
                  `ep_dateadd` = '".date('Y-m-d', strtotime($ep_dateadd))."',
                  `devadd` = '".$devadd."',
                  `dsetadd` = '".$dsetadd."',
                  `nightsperweek` = '".$nightsperweek."',
                  `ep_eadd` = '".$ep_eadd."',
                  `ep_tsadd` = '".$ep_tsadd."',
                  `ep_sadd` = '".$ep_sadd."',
                  `ep_eladd` = '".$ep_eladd."',
                  `sleep_qualadd` = '".$sleep_qualadd."',
                  `ep_hadd` = '".$ep_hadd."',
                  `ep_wadd` = '".$ep_wadd."',
                  `wapnadd` = '".$wapnadd."',
                  `hours_sleepadd` = '".$hours_sleepadd."',
                  `appt_notesadd` = '".$appt_notesadd."'
                  WHERE followupid='".$id."'
                  ;";
  $insert = $db->query($insertquery);
  if(!$insert){
    echo "Could not update follow up, please try again!";
  }else{

    $d = "DELETE FROM dentalsummfu_ess WHERE followupid = '".$db->escape($id)."'";
    $db->query($d);
    $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
    $epworth_my = $db->getResults($epworth_sql);
    foreach ($epworth_my as $epworth_myarray) {
  		$i = "INSERT INTO dentalsummfu_ess SET
        			epworthid='".$epworth_myarray['epworthid']."',
        			followupid='".$id."',
        			answer='".$db->escape($_POST['epworth_'.$id.'_'.$epworth_myarray['epworthid']])."',
        			adddate=now(),
        			ip_address='".$_SERVER['REMOTE_ADDR']."'";
  		$db->query($i);
  	}
    $d = "DELETE FROM dentalsummfu_tss WHERE followupid = '".$db->escape($id)."'";
    $db->query($d);
  	for($thorntonid=1;$thorntonid<=5;$thorntonid++){
      $i = "INSERT INTO dentalsummfu_tss SET
              thorntonid='".$thorntonid."',
              followupid='".$id."',
              answer='".$db->escape($_POST['thornton_'.$id.'_'.$thorntonid])."',
              adddate=now(),
              ip_address='".$_SERVER['REMOTE_ADDR']."'";
      $db->query($i);
  	}
  }
}elseif(isset($_POST['submitdeletefu'])){
  $id = $_POST['id'];
  $delsql = "DELETE FROM dentalsummfu WHERE followupid='".$db->escape($id)."'";
  $db->query($delsql);
}

$fuquery_sql = "SELECT * FROM dentalsummfu WHERE patientid ='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY ep_dateadd DESC";
$numf = $db->getNumberRows($fuquery_sql);
$bodywidth = ($numf*160)+320;
?>

<!--<body style="width:<?php echo $bodywidth; ?>px;background:none;">-->
<div style="width:<?php echo $bodywidth; ?>px;">
<form id="sleepstudyadd" style="float:left; display:none;" method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
  <link rel="stylesheet" href="css/dss_followups.css" type="text/css" media="screen" />
	<table id="sleepstudyscrolltable" style="margin-top:-3px;">
    <tr style="background: #444;height: 30px;">
    	<td colspan="4" style="background: #444;"><span style="color: #fff;">New</span></td>
    </tr>
    <tr >
      <td >
        <input type="text" size="12" style="width:100px;" class="calendar" id="ep_dateadd" name="ep_dateadd" value="<?php echo date('m/d/Y'); ?>" />
      </td>
    </tr>
    <tr >
	    <td >
<?php
$sqlex = "select * from dental_ex_page5 where patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarrayex = $db->getRow($sqlex);
$dentaldevice = st($myarrayex['dentaldevice']);
?>

        <select name="devadd" style="width:150px;">
<?php
$device_sql = "select * from dental_device where status=1 order by sortby";
$device_my = $db->getResults($device_sql);

foreach ($device_my as $device_myarray) {?>  
          <option <?php echo ($dentaldevice == $device_myarray['deviceid'])?'selected="selected"':''; ?> value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
<?php }?>
        </select>	
      </td>
    </tr>
    <tr >
      <td >
        <input type="text" size="12" name="dsetadd" />
      </td>
    </tr>
    <tr >
	    <td >
        <select name="nightsperweek" style="width:150px;">
<?php for ($i = 0; $i <= 7; $i++){ ?>  
          <option value="<?php echo $i?>"><?php echo $i?></option>
<?php }?>
        </select>	
			</td>
  	</tr>
    <tr >
	    <td >
        <input type="text" size="12" id="ep_eadd_new" name="ep_eadd_new" onclick="loadPopup('summ_subj_ess.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=new');return false;" />
      </td>
    </tr>
 <!--- ESS ANSWERS -->
    <tr style="display:none;">
      <td style="background: #E4FFCF;">
<?php
$epworth_sql = "select e.* from dental_epworth e where e.status=1 order by e.sortby";
$epworth_my = $db->getResults($epworth_sql);
foreach ($epworth_my as $epworth_myarray) { ?>
        <input type="text" size="12" id="epworth_new_<?php echo $epworth_myarray['epworthid']; ?>" name="epworth_new_<?php echo $epworth_myarray['epworthid']; ?>" /><br />
<?php } ?>
      </td>
    </tr>
    <tr >
	    <td >
        <input type="text" size="12" id="ep_tsadd_new" name="ep_tsadd_new" onclick="loadPopup('summ_subj_tss.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=new');return false;" />
      </td>
    </tr>
    <tr style="display:none;">
      <td style="background: #E4FFCF;">
<?php for($thorntonid=1;$thorntonid<=5;$thorntonid++){ ?>
        <input type="text" size="12" id="thornton_new_<?php echo $thorntonid; ?>" name="thornton_new_<?php echo $thorntonid; ?>" /><br />
<?php } ?>
      </td>
    </tr>
    <tr >
      <td >
        <input type="text" size="12" name="ep_sadd" />
      </td>
    </tr>
    <tr>
      <td >
        <input type="text" size="12" name="ep_eladd" />
      </td>
    </tr>
    <tr>
      <td >
        <input type="text" size="12" name="sleep_qualadd" />
      </td>
    </tr>
    <tr>
	    <td >
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
	    <td >
        <input type="text" size="12" name="ep_wadd" />
      </td>
    </tr>
    <tr>
	    <td >
        <input type="text" size="12" style="width:90px;" name="wapnadd" />
      </td>
    </tr>
    <tr>
	    <td >
        <input type="text" size="12" name="hours_sleepadd" />
      </td>
    </tr>
    <tr>
      <td >
        <input type="text" size="12" name="appt_notesadd" style="width:100px;" />
      </td>
    </tr>
    <tr>
	    <td >
    	  <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
        <input type="submit" name="submitaddfu" onclick="window.onbeforeunload=false;" value="Submit Follow Up" id="submitaddfu" style="width:120px;" />
        <input type="button" value="cancel" onclick="$('#sleepstudyadd').hide(); parent.show_new_but(); return false;" value="Cancel" style="width:120px;" /> 
      </td>
    </tr>	
	</table>
</form>

<?php
$fuquery_sql = "SELECT * FROM dentalsummfu WHERE patientid ='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY ep_dateadd DESC";
$fuquery_array = $db->getResults($fuquery_sql);
if($fuquery_array){
  $numrows = count($fuquery_array);
  foreach ($fuquery_array as $fuquery) {
    $device_query = "SELECT device FROM dental_device WHERE deviceid = '".$fuquery['devadd']."';";

    $device_result = $db->getRow($device_query);
    $device = $device_result['device'];
    if($numrows){ ?>

<form style="float:left;" id="sleepstdyupdate_<?php echo $fuquery['followupid'];?>" class="sleepstudyupdate" method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
  <input type="hidden" name="id" value="<?php echo $fuquery['followupid'];?>" /> 
  <table id="sleepstudyscrolltable" style="padding:0;margin-top:-3px">
    <tr style="background: #444;height: 30px;">
      <td colspan="4" style="background: #444;">
        <span style="color: #ccc;"><?php echo $fuquery['followupid'];?></span>
      </td>
    </tr>
    <tr>
      <td style="background: #F9FFDF;">
        <input type="text" size="12" style="width:75px;"  class="calendar" id="ep_dateadd_<?php echo $fuquery['followupid'];?>" name="ep_dateadd" value="<?php echo ($fuquery['ep_dateadd'])?date('m/d/Y', strtotime($fuquery['ep_dateadd'])):''; ?>" />
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">
        <select name="devadd" style="width:150px;">
  <?php
      $device_sql = "select * from dental_device where status=1 order by sortby";
      $device_my = $db->getResults($device_sql);
      foreach ($device_my as $device_myarray) { ?>
          <option <?php echo ($device==$device_myarray['device'])?'selected="selected"':''; ?>value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
  <?php 
      }?>
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
      for ($i = 0; $i <= 7; $i++){	 
        print ($i == $fuquery['nightsperweek']) ? "<option selected value=\"$i\">$i</option>" : "<option value=\"$i\">$i</option>";
      }?>
        </select>	
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">
        <input type="text" size="12" id="ep_eadd_<?php echo $fuquery['followupid'];?>" name="ep_eadd" value="<?php echo $fuquery['ep_eadd'];?>" onclick="loadPopup('summ_subj_ess.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=<?php echo $fuquery['followupid'];?>');return false;"  />
      </td>
    </tr>
      <!--- ESS ANSWERS -->
    <tr style="display:none;">
      <td style="background: #E4FFCF;">
  <?php
      $epworth_sql = "select e.*, fu.answer from dental_epworth e 
                        LEFT JOIN dentalsummfu_ess fu ON fu.epworthid=e.epworthid AND fu.followupid='".$db->escape($fuquery['followupid'])."'
                        where e.status=1 order by e.sortby";
      $epworth_my = $db->getResults($epworth_sql);
      $epworth_number = count($epworth_my);
      foreach ($epworth_my as $epworth_myarray) {?>
        <input type="text" size="12" id="epworth_<?php echo $fuquery['followupid'];?>_<?php echo $epworth_myarray['epworthid']; ?>" name="epworth_<?php echo $fuquery['followupid'];?>_<?php echo $epworth_myarray['epworthid']; ?>" value="<?php echo $epworth_myarray['answer']; ?>" /><br />
  <?php 
      } ?>    
      </td>
    </tr>
    <tr>
      <td style="background: #F9FFDF;">
        <input type="text" size="12" id="ep_tsadd_<?php echo $fuquery['followupid'];?>" name="ep_tsadd" value="<?php echo $fuquery['ep_tsadd'];?>" onclick="loadPopup('summ_subj_tss.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=<?php echo $fuquery['followupid'];?>');return false;" />
      </td>
    </tr>
    <tr style="display:none;">
      <td style="background: #E4FFCF;">
  <?php
      for($thorntonid=1;$thorntonid<=5;$thorntonid++){
        $t_sql = "SELECT answer FROM dentalsummfu_tss
                    WHERE followupid='".$db->escape($fuquery['followupid'])."' 
                    AND thorntonid='".$thorntonid."'";
        $thornton_myarray = $db->getRow($t_sql);?>
        <input type="text" size="12" id="thornton_<?php echo $fuquery['followupid'];?>_<?php echo $thorntonid; ?>" name="thornton_<?php echo $fuquery['followupid'];?>_<?php echo $thorntonid; ?>" value="<?php echo $thornton_myarray['answer']; ?>" /><br />
  <?php 
      } ?>    
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">
        <input type="text" size="12" name="ep_sadd" value="<?php echo $fuquery['ep_sadd'];?>" />
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
  <?php 
      $morning_headaches = $fuquery['ep_hadd']; ?>
        <select name="ep_hadd" class="field text addr tbox" style="width:150px;">
          <option value=""></option>
          <option value="Most Mornings" <?php if($morning_headaches == 'Most Mornings') echo " selected";?>>
            Most Mornings
          </option>
          <option value="Several times per week" <?php if($morning_headaches == 'Several times per week') echo " selected";?>>
            Several times per week
          </option>
          <option value="Several times per month" <?php if($morning_headaches == 'Several times per month') echo " selected";?>>
            Several times per month
          </option>
          <option value="Occasionally" <?php if($morning_headaches == 'Occasionally') echo " selected";?>>
            Occasionally
          </option>
          <option value="Rarely" <?php if($morning_headaches == 'Rarely') echo " selected";?>>
            Rarely
          </option>
          <option value="Never" <?php if($morning_headaches == 'Never') echo " selected";?>>
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
        <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
        <input type="submit" name="submitupdatefu" onclick="window.onbeforeunload=false;" value="Save Follow Up" id="submitupdatefu_<?php echo $fuquery['followupid'];?>" style="width:120px;" />
        <input type="submit" name="submitdeletefu" onclick="return confirm('Are you sure you want to delete this follow up?');" value="Delete" id="submitdeletefu" style="width:120px;" />
      </td>
    </tr>
  </table>
</form>
   <?php
    }
  }
}

$q_sql = "SELECT * FROM dental_q_page1 WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$q_row = $db->getRow($q_sql);

$t_sql = "SELECT tot_score FROM dental_thorton WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$t_row = $db->getRow($t_sql);

$s_sql = "SELECT analysis FROM dental_q_sleep WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$s_row = $db->getRow($s_sql);
$ep = preg_replace("/[^0-9]/", '', $s_row['analysis']);
?>

<form style="float:left;" class="sleepstudybaseline" id="sleepstudybaseline" method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
  <input type="hidden" name="id" value="baseline" />
  <table id="sleepstudyscrolltable" style="padding:0;margin-top:-3px">
    <tr style="background: #444;height: 30px;">
      <td colspan="4" style="background: #444;"><span style="color: #ccc;">Baseline</span></td>
    </tr>
<?php
$s = "SELECT initial_device_titration_1 FROM dental_summary WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$r = $db->getRow($s);?>
    <tr>
      <td style="background: #F9FFDF;">
        <input type="text" size="12" style="width:75px;" name="exam_date" value="<?php echo ($q_row['exam_date'])?date('m/d/Y', strtotime($q_row['exam_date'])):''; ?>" />
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">
        <select name="devadd" class="no_questionnaire" style="width:150px;">
<?php
$device_sql = "select * from dental_device where status=1 order by sortby";
$device_my = $db->getResults($device_sql);
foreach ($device_my as $device_myarray) {?>
          <option value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
<?php }?>
        </select>
      </td>
    </tr>
    <tr>
      <td style="background: #F9FFDF;">
        <input type="text" size="12" name="dsetadd" class="no_questionnaire" value="" />
      </td>
    <tr>
      <td style="background: #E4FFCF;">
        <select name="nightsperweek" class="no_questionnaire" style="width:150px;">
<?php for ($i = 0; $i <= 7; $i++) { ?>
    <option value="<?= $i ?>"><?= $i ?></option>
<?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">      
        <input type="text" size="12" name="ep_eadd" value="<?php echo $q_row['ess'];?>" />
      </td>
    </tr>
    <tr>
      <td style="background: #F9FFDF;">
        <input type="text" size="12" name="tot_score" value="<?php echo $q_row['tss'];?>" />
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">
        <input type="text" size="12" name="ep_sadd" value="<?php echo $q_row['snoring_sound'];?>" />
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
          <option value="Most Mornings" <?php if($morning_headaches == 'Most Mornings') echo " selected";?>>
            Most Mornings
          </option>
          <option value="Several times per week" <?php if($morning_headaches == 'Several times per week') echo " selected";?>>
            Several times per week
          </option>
          <option value="Several times per month" <?php if($morning_headaches == 'Several times per month') echo " selected";?>>
            Several times per month
          </option>
          <option value="Occasionally" <?php if($morning_headaches == 'Occasionally') echo " selected";?>>
            Occasionally
          </option>
          <option value="Rarely" <?php if($morning_headaches == 'Rarely') echo " selected";?>>
            Rarely
          </option>
          <option value="Never" <?php if($morning_headaches == 'Never') echo " selected";?>>
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
        <input type="text" size="12" style="width:90px;" name="wapnadd" value="<?php echo $q_row['quit_breathing'];?>" />
      </td>
    </tr>
    <tr>
      <td style="background: #F9FFDF;">
        <input type="text" size="12" name="hours_sleepadd" value="<?php echo $q_row['hours_sleep'];?>" />
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">
        <input type="text" size="12" name="appt_notesadd" value="<?php echo (!empty($fuquery['appt_notesadd']) ? $fuquery['appt_notesadd'] : ''); ?>" style="width:100px;" />
      </td>
    </tr>
    <tr>
      <td style="background: #E4FFCF;">
        <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
        <input type="button" value="Edit Baseline" onclick="gotoQuestionnaire();" style="width:120px;" />
      </td>
    </tr>
  </table>
</form>
<script type="text/javascript" src="js/dss_followups.js?v=20160401"></script>

</div> 
