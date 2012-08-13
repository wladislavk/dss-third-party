<?php include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/dental_patient_summary.php');
require_once('includes/preauth_functions.php');


        $fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$_GET['pid']."';";
        $fsData_query = mysql_query($fsData_sql);        $fsData_array = mysql_fetch_array($fsData_query);

        if (!empty($fsData_array['steparray'])) {
                $order = explode(",",$fsData_array['steparray']);
        	//$order = array_reverse($order);
        }



  $flow_pg2_info_query = "SELECT stepid, UNIX_TIMESTAMP(date_scheduled) as date_scheduled, UNIX_TIMESTAMP(date_completed) as date_completed, delay_reason, noncomp_reason, study_type, description, letterid FROM dental_flow_pg2_info WHERE patientid = '".$_GET['pid']."' ORDER BY stepid ASC;";
  $flow_pg2_info_res = mysql_query($flow_pg2_info_query);
  while ($row = mysql_fetch_assoc($flow_pg2_info_res)) {
    $flow_pg2_info[$row['stepid']] = $row;
  }


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

  //echo $datecomp;
  $i++;
}


$segments = Array();
$segments[2] = "Consult";
$segments[4] = "Impressions";
$segments[5] = "Delaying Treatment / Waiting";
$segments[14] = "Not a Candidate";
$segments[6] = "Refused Treatment";
$segments[3] = "Sleep Study";
$segments[8] = "Check / Follow Up";
$segments[9] = "Patient Non-Compliant";
$segments[10] = "Home Sleep Test";
$segments[11] = "Treatment Complete";
$segments[12] = "Annual Recall";
$segments[13] = "Termination";

?><table>
    <tr>
	<th>Steps</th>
	<th>Done Today</th>
	<th>Next Appt</th>
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
if($x = array_search($segment, $order)){
  $x++;
  $datesched = ($flow_pg2_info[$x]['date_scheduled']!='0' && $flow_pg2_info[$x]['date_scheduled']!='')?date('m/d/Y', $flow_pg2_info[$x]['date_scheduled']):'';
  if($flow_pg2_info[$x]['date_completed']!='0' && $flow_pg2_info[$x]['date_completed']!=''){
    $datecomp = date('m/d/Y', $flow_pg2_info[$x]['date_completed']);
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
    <input class="completed_today" type="checkbox" <?= ($completed)?'checked="checked"':''; ?> name="completed_<?= $segment; ?>" value="<?= $segment; ?>" />
  </td>
  <td>
    <input class="next_sched" id="<?= $segment; ?>" type="text" name="next_sched_<?= $segment; ?>" value="<?= $datesched; ?>" />
  </td>
</tr>
<?php
}
?>


</table>



<table width="98%">
  <tr>
    <th>Treatment</th>
    <th>Completed</th>
    <th>Scheduled</th>
    <th>Letters</th>
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

  foreach ($flow_pg2_info as $row) {
                if ($row['letterid'] != "") {
                        $letters[$row['stepid']] = trim($row['letterid'], ',');
                }
  }
//print_r($letters);
  $letter_list = implode(",", $letters);
  $dental_letters_query = "SELECT patientid, stepid, letterid, UNIX_TIMESTAMP(generated_date) as generated_date, topatient, md_list, md_referral_list, pdf_path, status, delivered, dental_letter_templates.name, dental_letter_templates.template, deleted FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = '".$_GET['pid']."' AND (letterid IN(".$letter_list.") OR parentid IN(".$letter_list."))ORDER BY stepid ASC;";
  $dental_letters_res = mysql_query($dental_letters_query);
  $dental_letters = array();
  while ($row = mysql_fetch_assoc($dental_letters_res)) {
    $dental_letters[$row['stepid']][] = $row;
  }


  $letterlink = "";
        foreach ($dental_letters[$step] as $letter) {
                $contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list']);
                $lid = $letter['letterid'];
                $template = "/manage/edit_letter.php";
                $gendate = date('m/d/Y', $letter['generated_date']);
                if ($lid != '') {
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
?>
  <tr>
	<td>
		<?= $segments[$order[$i]]; ?>
	</td>
	<td>
		<?= $datecomp; ?>
	</td>
	<td>
		<?= $datesched; ?>
	</td>
	<td>
		<?= $letterlink; ?>
	</td>
  </tr>
<?php
  $i++;
}


?>





</table>



<script type="text/javascript">

$('.completed_today').click(function(){
  var id = $(this).val();
  var c = $(this).is(":checked")?1:0;
                                    $.ajax({
                                        url: "includes/update_appt_today.php",
                                        type: "post",
                                        data: {id: id, c: c, pid: <?= $_GET['pid']; ?>},
                                        success: function(data){
						//alert(data);
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
						  $('#'+id).val('');
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
});

$('.next_sched').blur(function(){
  var id = $(this).attr("id");
  var sched = $(this).val();
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
})


</script>

<?php include "includes/bottom.htm";?>

