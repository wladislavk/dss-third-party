<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include_once('includes/constants.inc');
include_once('includes/dental_patient_summary.php');
include_once('includes/preauth_functions.php');

$last_sql = "SELECT * FROM dental_flow_pg2_info info
		JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
		 WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ORDER BY date_completed DESC, info.id DESC";
$last = $db->getRow($last_sql);

if($last['section']==1){
    $final_sql = "SELECT * FROM dental_flow_pg2_info info
    		JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
    		WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND section=1
    		order by steps.section DESC, steps.sort_by DESC";
}else{
    $final_sql = "SELECT * FROM dental_flow_pg2_info info
                    JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
                    WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' order by steps.section DESC, steps.sort_by DESC";
}

$final = $db->getRow($final_sql);
$final_segment = $final['segmentid'];
$final_rank = 0;
$db->query("SET @rank=0");
$rank_sql = "SELECT @rank:=@rank+1 as rank, id from dental_flowsheet_steps ORDER BY section ASC, sort_by ASC";
$rank_query = $db->getResults($rank_sql);
foreach ($rank_query as $rank_r) {
    if($final['segmentid']==$rank_r['id']){
        $final_rank = $rank_r['rank'];
    }
}
$arrow_height = ($final_rank*20);

$sched_sql = "SELECT * FROM dental_flow_pg2_info WHERE appointment_type=0 and segmentid!='' AND date_scheduled != '' AND date_scheduled != '0000-00-00' AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$sched_q = $db->getResults($sched_sql);
$sched_appt = (count($sched_q)>0);

?>
<link rel="stylesheet" href="css/flowsheet.css" />
<div style="width:100%;">
<?php
$bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
              JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'
              WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
$bu_q = $db->getResults($bu_sql);
if(count($bu_q)>0){
    if(!empty($pat_hst_num_uncompleted) && $pat_hst_num_uncompleted>0){ ?>
    <a href="#" style="float:right; margin-right:20px;" onclick="alert('Patient has existing HST with status <?= $pat_hst_status; ?>. Only one HST can be requested at a time.'); return false;" class="button">
        Order HST
    </a>
    <?php
    }else{
    ?>
    <a href="hst_request_co.php?ed=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" style="float:right; margin-right:20px;" class="button" onclick="return confirm('By clicking OK, you certify that you have discussed HST protocols with this patient and are legally qualified to request a HST for this patient. Your digital signature will be attached to this submission. You will be notified by the HST company when the patient\'s HST is complete.');">
        Order HST
    </a>
    <?php
    }
} ?>
    <a href="calendar_pat.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : '');?>" style="float:right; margin-right:20px;" class="button">View Calendar Appts</a>
</div>
<div id="treatment_div">
    <h3>1) What did you do today?*</h3>
    <div id="treatment_list" <?= ($sched_appt)?'class="current_step"':''; ?>>
        <div id="arrow_div" style="height:<?= $arrow_height; ?>px;"></div>
        <ul class="treatment sect1">
<?php 
$db->query("SET @step_rank=0");
$step_sql = "SELECT s.*, @step_rank:=@step_rank+1 as rank from dental_flowsheet_steps s WHERE s.section=1 ORDER BY s.sort_by ASC";
$step_q = $db->getResults($step_sql);
foreach ($step_q as $step) {
    if($step['id'] == $final['segmentid']){
        $class = "last";
    }else{
        if($step['rank'] < $final_rank){
            $class="completed_step";
        }else{
            $class = "";
        }
    }
    if($step['id']==1){ ?>
            <li class="<?= $class; ?>"><?= $step['name']; ?></li>
    <?php
    }else{
    ?>
            <li class="<?= $class; ?>"><a id="completed_<?= $step['id']; ?>" class="completed_today"><?= $step['name']; ?></a></li>
<?php
    }
} ?>
        </ul>
        <ul class="treatment sect2">
<?php

$step_sql = "SELECT * from dental_flowsheet_steps WHERE section=2 ORDER BY sort_by ASC";
$step_q = $db->getResults($step_sql);
foreach ($step_q as $step) {
    if($step['id'] == $last['segmentid']){
        $class = "last";
    }else{
        $class = "";
    }
?>
            <li class="<?= $class; ?>"><a id="completed_<?= $step['id']; ?>" class="completed_today"><?= $step['name']; ?></a></li>
<?php 
} ?>
        </ul>
    </div>
    <span class="sub_text">*Click a treatment above to add it to the Treatment Summary</span>
</div>

<div id="step2">
    <h3>2) What will you do next?*</h3>
    <div id="sched_div" <?= (!$sched_appt)?'class="current_step"':''; ?>>
<?php
$sched_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND appointment_type=0";
$sched_r = $db->getRow($sched_sql);
$next_sql = "SELECT steps.* FROM dental_flowsheet_steps steps
          		JOIN dental_flowsheet_steps_next next ON steps.id = next.child_id
          		WHERE next.parent_id='".mysqli_real_escape_string($con,$last['segmentid'])."'
          		ORDER BY next.sort_by ASC"; 
$next_q = $db->getResults($next_sql);
?>
    <div id="next_step_div">
        <label>Select Next Appointment</label>
        <select id="next_step">
            <option value="">SELECT NEXT STEP</option>
    <?php
        foreach ($next_q as $next_r) { ?>
            <option value="<?= $next_r['id']; ?>" <?= ($next_r['id']==$sched_r['segmentid'])?'selected="selected"':''; ?>><?= $next_r['name']; ?></option>
    <?php
        }
    ?>
        </select>
    </div>
    <div id="next_step_date_div">
        <label>Schedule On/After</label>
        <input id="next_step_date" class="flow_next_calendar" type="text" value="<?= ($sched_r['date_scheduled']!='' && $sched_r['date_scheduled']!="0000-00-00")?date('m/d/Y', strtotime($sched_r['date_scheduled'])):''; ?>" />
        <span id="next_step_until"><?= date_in_words_until($sched_r['date_scheduled']); ?></span>
    </div>
    <div class="clear"></div>
</div>
<span class="sub_text" style="width:280px;">*After Step 1, choose the next patient treatment and date</span>
<h3 style="width:500px; text-align:center; margin-top:40px;">Treatment Summary</h3>
<div id="appt_summ" style="width:500px;">
    <?php include 'appointment_summary.php'; ?>
</div>

</div>
<? /*
<?php
$segments = Array();
$segments[1] = "Initial Contact";
$segments[15] = "Baseline Sleep Test";
$segments[2] = "Consult";
$segments[4] = "Impressions";
$segments[7] = "Device Delivery";
$segments[8] = "Check / Follow Up";
$segments[10] = "Home Sleep Test";
$segments[3] = "Sleep Study";
$segments[11] = "Treatment Complete";
$segments[12] = "Annual Recall";
$segments[14] = "Not a Candidate";
$segments[5] = "Delaying Tx / Waiting";
$segments[9] = "Pt. Non-Compliant";
$segments[6] = "Refused Treatment";
$segments[13] = "Termination";
?>
<div style="margin:0 20px;width: 400px; float: left;">
<table>
    <tr>
	<th>Steps</th>
	<th>Done</th>
	<th>Next Appt/Due</th>
    </tr>

<?php
foreach($segments as $segment => $label){
?>
<tr>
  <td>
    <?= $label; ?>
  </td>
  <td>
<?php
  $s = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' AND segmentid='".$segment."' ORDER BY date_completed DESC";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
if($r){
  $datesched = ($r['date_scheduled']!='0' && $r['date_scheduled']!='' && $r['date_scheduled']!='0000-00-00')?date('m/d/Y', strtotime($r['date_scheduled'])):'';
  if($r['date_completed']!='0' && $r['date_completed']!=''){
    $datecomp = date('m/d/Y', strtotime($r['date_completed']));
    $completed= true;
  }else{
    $datecomp = '';
    $completed = false;
  }
}else{
  $datesched = '';
  $datecomp = '';
  $completed = false;
}

  $s_sched = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' AND segmentid='".$segment."' ORDER BY date_scheduled DESC";
  $q_sched = mysql_query($s_sched);
  $r_sched = mysql_fetch_assoc($q_sched);
  $datesched = ($r_sched['date_scheduled']!='0' && $r_sched['date_scheduled']!='' && $r_sched['date_scheduled']!='0000-00-00')?date('m/d/Y', strtotime($r_sched['date_scheduled'])):'';

?>   
	<button id="completed_<?= $segment; ?>" class="completed_today addButton <?= ($completed)?"completedButton":"notCompletedButton"; ?>"><?= ($completed)?"Completed":"Not Done"; ?></button>

  </td>
  <td>
    <?php if($segment != '1'){ ?><input class="next_sched flow_next_calendar" id="<?= $segment; ?>" type="text" name="next_sched_<?= $segment; ?>" value="<?= $datesched; ?>" /><?php } ?>
  </td>
</tr>
<?php
}
?>


</table>
</div>

<div style="width:500px; float:left;">
	<?php include 'appointment_summary.php'; ?>
</div>
*/ ?>
<div style="clear:both;"></div>

<script src="js/manage_flowsheet3.js" type="text/javascript"></script>

<?php include "includes/bottom.htm";?>

