<?php include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/dental_patient_summary.php');
require_once('includes/preauth_functions.php');

$last_sql = "SELECT * FROM dental_flow_pg2_info info
		JOIN dental_flowsheet_steps steps on info.segmentid = steps.id
		WHERE (date_completed != '' AND date_completed IS NOT NULL) AND patientid='".mysql_real_escape_string($_GET['pid'])."' order by steps.section DESC, steps.sort_by DESC";
$last_q = mysql_query($last_sql);
$last = mysql_fetch_assoc($last_q);
$last_segment = $last['segmentid'];
$last_rank = 0;
mysql_query("SET @rank=0");
$rank_sql = "SELECT @rank:=@rank+1 as rank, id from dental_flowsheet_steps ORDER BY section ASC, sort_by ASC";
$rank_query = mysql_query($rank_sql);
while($rank_r = mysql_fetch_assoc($rank_query)){
  if($last['segmentid']==$rank_r['id']){
    $last_rank = $rank_r['rank'];
  }
}
$arrow_height = ($last_rank*20-10);
?>
<link rel="stylesheet" href="css/flowsheet.css" />

<div id="treatment_div">
<h3>1) What did you do today?</h3>
<div id="treatment_list">
<div id="arrow_div" style="height:<?= $arrow_height; ?>px;"></div>
<ul class="treatment sect1">
<?php 

$step_sql = "SELECT * from dental_flowsheet_steps WHERE section=1 ORDER BY sort_by ASC";
$step_q = mysql_query($step_sql);

while($step = mysql_fetch_assoc($step_q)){
if($step['id'] == $last['segmentid']){
  $class = "last";
}else{
  $class = "";
}
?>

<li class="<?= $class; ?>"><a id="completed_<?= $step['id']; ?>" class="completed_today"><?= $step['name']; ?></a></li>

<?php
}

?>
</ul>

<ul class="treatment sect2">
<?php

$step_sql = "SELECT * from dental_flowsheet_steps WHERE section=2 ORDER BY sort_by ASC";
$step_q = mysql_query($step_sql);

while($step = mysql_fetch_assoc($step_q)){
if($step['id'] == $last['segmentid']){
  $class = "last";
}else{
  $class = "";
}
?>

<li class="<?= $class; ?>"><a id="completed_<?= $step['id']; ?>" class="completed_today"><?= $step['name']; ?></a></li>

<?php 
}

?>
</ul>

<ul class="treatment sect3">
<?php

$step_sql = "SELECT * from dental_flowsheet_steps WHERE section=3 ORDER BY sort_by ASC";
$step_q = mysql_query($step_sql);

while($step = mysql_fetch_assoc($step_q)){
if($step['id'] == $last['segmentid']){
  $class = "last";
}else{
  $class = "";
}
?>

<li class="<?= $class; ?>"><a id="completed_<?= $step['id']; ?>" class="completed_today"><?= $step['name']; ?></a></li>

<?php 
}

?>
</ul>
</div>
</div>

<div id="step2">
<h3>2) What will you do next?</h3>
<div id="sched_div">
<?php
  $sched_sql = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysql_real_escape_string($_GET['pid'])."' AND appointment_type=0";
  $sched_q = mysql_query($sched_sql);
  $sched_r = mysql_fetch_assoc($sched_q);
  $next_sql = "SELECT steps.* FROM dental_flowsheet_steps steps
		JOIN dental_flowsheet_steps_next next ON steps.id = next.child_id
		WHERE next.parent_id='".mysql_real_escape_string($last['segmentid'])."'
		ORDER BY next.sort_by ASC"; 
  $next_q = mysql_query($next_sql);
?>
  <div id="next_step_div">
    <label>Select Next Appointment</label>
    <select id="next_step">
      <option value="">SELECT NEXT STEP</option>
      <?php
        while($next_r = mysql_fetch_assoc($next_q)){
          ?><option value="<?= $next_r['id']; ?>" <?= ($next_r['id']==$sched_r['segmentid'])?'selected="selected"':''; ?>><?= $next_r['name']; ?></option><?php
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
<h3 style="width:500px; text-align:center;">Treatment Summary</h3>
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
  $s = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysql_real_escape_string($_GET['pid'])."' AND segmentid='".$segment."' ORDER BY date_completed DESC";
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

  $s_sched = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysql_real_escape_string($_GET['pid'])."' AND segmentid='".$segment."' ORDER BY date_scheduled DESC";
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

<script type="text/javascript">

$('.completed_today').click(function(){
  var id = $(this).attr('id').substring(10);
                                    $.ajax({
                                        url: "includes/update_appt_today.php",
                                        type: "post",
                                        data: {id: id, pid: <?= $_GET['pid']; ?>},
                                        success: function(data){
						//alert(data);
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
						  $('#'+id).val('');
						  $('#datecomp_'+id).text(r.datecomp);
						  var $tr = $('#completed_row_temp');
 						  var $clone = $tr.clone();
						  $clone.attr('id', 'completed_row_'+r.id);
                                                  $clone.find('.title').text(r.title);
                                                  $clone.find('.completed_date').val(r.datecomp);
						  if(r.letters>0){
						  	$clone.find('.letters').html('<a href="patient_letters.php?pid=<?= $_GET['pid']; ?>">'+r.letters+' Letters</a>');
						  }else{
                           				$clone.find('.letters').text('0 Letters');
						  }
						  $clone.find('.deleteButton').attr('onclick', "return delete_segment('"+r.id+"');");
						  $tr.after($clone);
						  $clone.show();
						  $('#next_step').val('');
						  $('#next_step_date').val('');
						  $('#next_step_until').text('');
                                                  if(id==9){
                                                        var $r = $('#noncomp_reason_tmp');
                                                        var $reason = $r.clone();
							$t = $clone.find('.title');
							$reason.find('.noncomp_reason').attr('id', 'noncomp_reason'+r.id);
                                                        $reason.find('.old_noncomp_reason').attr('id', 'old_noncomp_reason_'+r.id);
                                                        $reason.find('.noncomp_reason').attr('onfocus', "$('#old_noncomp_reason_"+r.id+"').val($(this).val());");
						 	$reason.find('.reason_btn').attr('id', 'reason_btn'+r.id);
							$reason.find('.reason_btn').attr('onclick', "Javascript: loadPopup('flowsheet_other_reason.php?ed="+r.id+"&pid=<?=$_GET['pid']?>&sid=9');");
                                                        $t.after($reason);
                                                        $reason.show();
                                                  }
                                                  if(id==5){
                                                        var $r = $('#delay_reason_tmp');
                                                        var $reason = $r.clone();
                                                        $t = $clone.find('.title');
                                                        $reason.find('.delay_reason').attr('id', 'delay_reason_'+r.id);
							$reason.find('.old_delay_reason').attr('id', 'old_delay_reason_'+r.id);
							$reason.find('.delay_reason').attr('onfocus', "$('#old_delay_reason_"+r.id+"').val($(this).val());");
                                                        $reason.find('.reason_btn').attr('id', 'reason_btn'+r.id);
                                                        $reason.find('.reason_btn').attr('onclick', "Javascript: loadPopup('flowsheet_other_reason.php?ed="+r.id+"&pid=<?=$_GET['pid']?>&sid=5');");
                                                        $t.after($reason);
                                                        $reason.show();
                                                  }


						  if(id==4 || !r.impression){
							loadPopup('includes/impression_device.php?pid=<?= $_GET['pid']; ?>');
						  }else if(id==1){

						  }



							//$('#completed_'+id).removeClass('notCompletedButton').addClass('completedButton').text('Completed');

                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
});


$('#next_step').change( function(){
  update_next_sched();
});


function update_next_sched(){
  var id = $('#next_step').val();
  var sched = $('#next_step_date').val();
                                    $.ajax({
                                        url: "includes/update_appt_sched.php",
                                        type: "post",
                                        data: {id: id, sched: sched, pid: <?= $_GET['pid']; ?>},
                                        success: function(data){
						//alert(data);
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
}

</script>

<?php include "includes/bottom.htm";?>

