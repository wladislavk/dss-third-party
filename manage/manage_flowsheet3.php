<?php include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/dental_patient_summary.php');
require_once('includes/preauth_functions.php');
?>
<link rel="stylesheet" href="css/flowsheet.css" />
<?php

        $fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$_GET['pid']."';";
        $fsData_query = mysql_query($fsData_sql);        $fsData_array = mysql_fetch_array($fsData_query);

        if (!empty($fsData_array['steparray'])) {
                $order = explode(",",$fsData_array['steparray']);
        	//$order = array_reverse($order);
        }



  $flow_pg2_info_query = "SELECT id, stepid, UNIX_TIMESTAMP(date_scheduled) as date_scheduled, UNIX_TIMESTAMP(date_completed) as date_completed, delay_reason, noncomp_reason, study_type, description, letterid FROM dental_flow_pg2_info WHERE patientid = '".$_GET['pid']."' ORDER BY stepid ASC;";
  $flow_pg2_info_res = mysql_query($flow_pg2_info_query);
  while ($row = mysql_fetch_assoc($flow_pg2_info_res)) {
    $flow_pg2_info[$row['stepid']] = $row;
  }
$flow_pg2_info_rev = array_reverse($flow_pg2_info);

$i = 0;
  while($i < count($order)){
  $segment_query = "SELECT * FROM `flowsheet_segments` WHERE `id` = ".$order[$i].";";
  $segment_res = mysql_query($segment_query);
  if($segment_res){
    $segment = mysql_fetch_array($segment_res);
  }else{
    echo "Error selecting segments from flowsheet";
  }
        $schedid = "datesched$i";
        $compid = "datecomp$i";

  $step = count($order) - $i;
  $datesched = date('m/d/Y', $flow_pg2_info[$step]['date_scheduled']);
  if ($datesched == '12/31/1969') $datesched = '';
  $datecomp = date('m/d/Y', $flow_pg2_info[$step]['date_completed']);
  if ($datecomp == '12/31/1969') $datecomp = '';
        $sleepstudy = $flow_pg2_info[$step]['study_type'];
        $delayreason = strtolower($flow_pg2_info[$step]['delay_reason']);
        $noncompreason = strtolower($flow_pg2_info[$step]['noncomp_reason']);
        $description = $flow_pg2_info[$step]['description'];
	$id = $flow_pg2_info[$step]['id'];

  //echo $datecomp;
  $i++;
}


$segments = Array();
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
/*
Baseline Sleep Test [ADD this item]
Consult 
Impressions 
Device Delivery [ALREADY on previous FS but not shown now] 
Check / Follow Up 
Home Sleep Test
Sleep Study 
Treatment Complete 
Annual Recall 
Not a Candidate 
Delaying Treatment / Waiting 
Patient Non-Compliant 
Refused Treatment 
Termination 
*/
?>
<div style="margin:0 20px;width: 500px; float: left;">
<table>
    <tr>
	<th>Steps</th>
	<th>Done</th>
	<th>Date</th>
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
if($x = array_search($segment, array_reverse($order, true))){
  $x++;
  $s = "SELECT * FROM dental_flow_pg2_info WHERE patientid='".mysql_real_escape_string($_GET['pid'])."' AND stepid='".$x."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
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

?>   
	<button id="completed_<?= $segment; ?>" class="completed_today addButton <?= ($completed)?"completedButton":"notCompletedButton"; ?>"><?= ($completed)?"Completed":"Not Done"; ?></button>

  </td>
  <td>
    <span id="datecomp_<?= $segment; ?>"><?= $datecomp; ?></span>
  </td>
  <td>
    <input class="next_sched flow_next_calendar" id="<?= $segment; ?>" type="text" name="next_sched_<?= $segment; ?>" value="<?= $datesched; ?>" />
  </td>
</tr>
<?php
}
?>


</table>
</div>

<div style="width:400px; float:left;">
<table width="98%">
  <tr>
    <th>Date</th>
    <th>Treatment</th>
    <th>Letters</th>
  </tr>

  <tr id="completed_row_temp" style="display:none;">
        <td>
                <input class="completed_date flow_comp_calendar" id="completed_date_" type="text" value="" />
        </td>
        <td>
                <span class="title">Test</span>
        </td>
        <td class="letters">
                <a href="patient_letters.php?pid=<?= $_GET['pid']; ?>"><?= $letter_count; ?> Letters</a>
        </td>
        <td>
                <a href="#" onclick="return delete_segment('<?= $id; ?>');" class="addButton deleteButton">Delete</a>
        </td>
  </tr>


<?php
$segments[1] = "Initial Contact";
$order = array_reverse($order);
$i = 0;
  while($i < count($order)){
  $segment_query = "SELECT * FROM `flowsheet_segments` WHERE `id` = ".$order[$i].";";
  $segment_res = mysql_query($segment_query);
  if($segment_res){
    $segment = mysql_fetch_array($segment_res);
  }else{
    echo "Error selecting segments from flowsheet";
  }
        $schedid = "datesched$i";
        $compid = "datecomp$i";

  $step = count($order) - $i;
  $datesched = date('m/d/Y', $flow_pg2_info[$step]['date_scheduled']);
  if ($datesched == '12/31/1969') $datesched = '';
  $datecomp = date('m/d/Y', $flow_pg2_info[$step]['date_completed']);
  if ($datecomp == '12/31/1969') $datecomp = '';
        $sleepstudy = $flow_pg2_info[$step]['study_type'];
        $delayreason = strtolower($flow_pg2_info[$step]['delay_reason']);
        $noncompreason = strtolower($flow_pg2_info[$step]['noncomp_reason']);
        $description = $flow_pg2_info[$step]['description'];
	$id = $flow_pg2_info[$step]['id']; 
  foreach ($flow_pg2_info as $row) {
                if ($row['letterid'] != "") {
                        $letters[$row['stepid']] = trim($row['letterid'], ',');
                }
  }
//print_r($letters);
  $letter_list = implode(",", $letters);
  $dental_letters_query = "SELECT patientid, stepid, letterid, UNIX_TIMESTAMP(generated_date) as generated_date, topatient, md_list, md_referral_list, pdf_path, status, delivered, dental_letter_templates.name, dental_letter_templates.template, deleted FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = '".$_GET['pid']."' AND (letterid IN(".$letter_list.") OR parentid IN(".$letter_list.")) ORDER BY stepid ASC;";
  $dental_letters_res = mysql_query($dental_letters_query);
  $dental_letters = array();
  while ($row = mysql_fetch_assoc($dental_letters_res)) {
    $dental_letters[$row['stepid']][] = $row;
  }


  $letterlink = "";
	$letter_count = 0;
        foreach ($dental_letters[$step] as $letter) {
                $contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list']);
                $lid = $letter['letterid'];
                $template = "/manage/edit_letter.php";
                $gendate = date('m/d/Y', $letter['generated_date']);
                if ($lid != '') {
			$letter_count += count($contacts['patient'])+count($contacts['md_referrals'])+count($contacts['mds']);
                        foreach ($contacts['patient'] as $contact) {
                                $preferred = "";
                                if ($contact['preferredcontact'] == "email") {
                                        $preferred = "(E)";
                                }
                                if ($contact['preferredcontact'] == "paper") {
                                        $preferred = "(M)";
                                }
                                if ($contact['preferredcontact'] == "fax") {
                                        $preferred = "(F)";
                                }
                                $name = $letter['name'] . " - " . $preferred . " " . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
                                if ($letter['deleted'] == 1) {
                                        $letterlink .= "<span style=\"text-decoration:line-through;\">$name (USER DELETED)</span><br />";
                                }
                                elseif ($letter['status'] == 0) {
                                        $letterlink .= "<a class=\"red\" href=\"$template?fid=$pid&pid=$pid&lid=$lid&goto=flowsheet\">$name</a><br />";
                                }
                                elseif ($letter['delivered'] == 1 && $letter['pdf_path'] != "") {
                                        $letterlink .= "<a class=\"darkblue\" href=\"/manage/letterpdfs/" . $letter['pdf_path'] . "\">$name</a><br />";
                                }
                                elseif ($letter['status'] == 1) {
                                        $letterlink .= "<a href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
                                }
                        }
                        foreach ($contacts['md_referrals'] as $contact) {
                                $preferred = "";
                                if ($contact['preferredcontact'] == "email") {
                                        $preferred = "(E)";
                                }
                                if ($contact['preferredcontact'] == "paper") {
                                        $preferred = "(M)";
                                }
                                if ($contact['preferredcontact'] == "fax") {
                                        $preferred = "(F)";
                                }
                                
                                $name = $letter['name'] . " - " . $preferred . " " . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
                                if ($letter['deleted'] == 1) {
                                        $letterlink .= "<span style=\"text-decoration:line-through;\">$name (USER DELETED)</span><br />";
                                }elseif ($letter['status'] == 0) {
                                        $letterlink .= "<a class=\"red\" href=\"$template?fid=$pid&pid=$pid&lid=$lid&goto=flowsheet\">$name</a><br />";
                                } elseif ($letter['delivered'] == 1 && $letter['pdf_path'] != "") {
                                        $letterlink .= "<a class=\"darkblue\" href=\"/manage/letterpdfs/" . $letter['pdf_path'] . "\">$name</a><br />";
                                }
                                elseif ($letter['status'] == 1) {
                                        $letterlink .= "<a href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
                                }
                        }
                        foreach ($contacts['mds'] as $contact) {
                                $preferred = "";
                                if ($contact['preferredcontact'] == "email") {
                                        $preferred = "(E)";
                                }
                                if ($contact['preferredcontact'] == "paper") {
                                        $preferred = "(M)";
                                }
                                if ($contact['preferredcontact'] == "fax") {
                                        $preferred = "(F)";
                                }
                                $name = $letter['name'] . " - " . $preferred . " " . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
                                if ($letter['deleted'] == 1) {
                                        $letterlink .= "<span style=\"text-decoration:line-through;\">$name (USER DELETED)</span><br />";
                                }elseif ($letter['status'] == 0) {
                                        $letterlink .= "<a class=\"red\" href=\"$template?fid=$pid&pid=$pid&lid=$lid&goto=flowsheet\">$name</a><br />";
                                } elseif ($letter['delivered'] == 1 && $letter['pdf_path'] != "") {
                                        $letterlink .= "<a class=\"darkblue\" href=\"/manage/letterpdfs/" . $letter['pdf_path'] . "\">$name</a><br />";
                                } elseif ($letter['status'] == 1) {
                                        $letterlink .= "<a href=\"$template?fid=$pid&pid=$pid&lid=$lid\">$name</a><br />";
                                }
                        }
                }
	}
?>
<?php if($datecomp){ ?>
  <tr id="completed_row_<?= $id; ?>">
    	<td>
                <input class="completed_date flow_comp_calendar" id="completed_date_<?= $id; ?>" type="text" value="<?= $datecomp; ?>" />
        </td>
	<td>
		<?= $segments[$order[$i]]; ?>
	</td>
	<td>
		<?php if($letter_count > 0){ ?>
		<a href="patient_letters.php?pid=<?= $_GET['pid']; ?>"><?= $letter_count; ?> Letters</a>
		<?php }else{ ?>
			0 Letters
		<?php } ?>
	</td>
	<td>
		<a href="#" onclick="return delete_segment('<?= $id; ?>');" class="addButton deleteButton">Delete</a>	
	</td>
  </tr>
<?php } ?>
<?php
  $i++;
}


?>





</table>
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
						  //$('#completed_row_temp').clone().insertAfter('#completed_row_temp').find('.title').val('adfa').show();
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

function delete_segment(id){
  if(confirm('Are you sure you want to delete this appointment?')){
	                                    $.ajax({
                                        url: "includes/delete_appt.php",
                                        type: "post",
                                        data: {id: id, pid: <?= $_GET['pid']; ?>},
                                        success: function(data){
                                                //alert(data);
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        $('#completed_row_'+id).remove();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
  }else{
	return false;
  }

}

function update_completed_date(cid){
  id = cid.substring(15);
  comp_date = $('#completed_date_'+id).val();
                                            $.ajax({
                                        url: "includes/update_appt.php",
                                        type: "post",
                                        data: {id: id, comp_date: comp_date, pid: <?= $_GET['pid']; ?>},
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

