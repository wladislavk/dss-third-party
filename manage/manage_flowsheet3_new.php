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
    <input type="checkbox" <?= ($completed)?'checked="checked"':''; ?> name="completed_<?= $segment; ?>" value="1" />
  </td>
  <td>
    <input type="text" name="next_sched_<?= $segment; ?>" value="<?= $datesched; ?>" />
  </td>
</tr>
<?php
}
?>


</table>





















<?php include "includes/bottom.htm";?>

