<?php include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/dental_patient_summary.php');
require_once('includes/preauth_functions.php');
?>
<link rel="stylesheet" href="css/flowsheet.css" />

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
						  if(id==4){
							loadPopup('includes/impression_device.php?pid=<?= $_GET['pid']; ?>');
						  }else if(id==1){

						  }
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
});

function update_next_sched(id){
  var sched = $('#'+id).val();
                                    $.ajax({
                                        url: "includes/update_appt_sched.php",
                                        type: "post",
                                        data: {id: id, sched: sched, pid: <?= $_GET['pid']; ?>},
                                        success: function(data){
						//alert(data);
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
							$('.next_sched').each(function(){
							    if($(this).attr("id")!=id){
								$(this).val('');
							    }
							});
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
}

</script>

<?php include "includes/bottom.htm";?>

