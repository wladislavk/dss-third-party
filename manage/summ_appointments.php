<?php namespace Ds3\Legacy; ?><?php
session_start();
require_once('admin/includes/main_include.php');
?>
<!-- START FLOWSHEET PAGE 2 ***************************** -->


<div id="flowsheet_page2" style="border-right: 1px solid rgb(0, 0, 0); margin-left: 20px; min-height: 400px; overflow: hidden; width: 932px;">  


<?php if ($copyreqdate != ""): ?>
<div id="dellaststep" style="float: right;">
<form action="manage_flowsheet3.php?pid=<?php echo $_GET['pid']; ?>&page=page2" method="POST" style="clear: both;">
<input type="submit" name="dellaststep" value="Delete Last Step" style="float:right;" />
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>" />
</form>
</div>
<?php endif; ?>

<form id="page2form" action="manage_flowsheet3.php?pid=<?php echo $_GET['pid']; ?>&page=page2" method="POST" name="page2submit" style="clear: both;">
<h2 style="float:left;width:200px;">Treatment Steps</h2>

<style>
#flowsheet_page2 td{
border-bottom:1px solid #000;
}
</style>




<style>
	
	#flowsheetpage2{
		overflow:hidden;
	}
	#flowsheetpage2 td{
		overflow:hidden;
	}
	
</style>

<table align="center" style="width:100%; overflow: hidden;clear: left;" id="flowsheetpage2">
<tr>
<td width="109">
Procedure
</td>

<td width="117">
Date Complete<br />
Date Scheduled<br />
(mm/dd/yyyy)
</td>


<td width="247">
Correspondence
</td>


<td width="115">
Generated On
</td>


<!--<td width="26" style="text-align:center;">
&#8730;&nbsp;
</td>


<td width="102">
Sent via
</td>-->
                                              

<td width="250">
Next Appointment
</td>
</tr>


<?php

?>


  


<?php
/*
    function array_sort($array, $on, $order)
    {
      $new_array = array();
      $sortable_array = array();
 
      if (count($array) > 0) {
          foreach ($array as $k => $v) {
              if (is_array($v)) {
                  foreach ($v as $k2 => $v2) {
                      if ($k2 == $on) {
                          $sortable_array[$k] = $v2;
                      }
                  }
              } else {
                  $sortable_array[$k] = $v;
              }
          }
 
          switch($order)
          {
              case 'SORT_ASC':   
                  echo "ASC";
                  asort($sortable_array);
              break;
              case 'SORT_DESC':
                  echo "DESC";               
                  arsort($sortable_array);
              break;
          }
 
          foreach($sortable_array as $k => $v) {
              $new_array[] = $array[$k];
          }
      }
      return $new_array;
    }   

 */

	$qso = "SELECT `consultrow`, `sleepstudyrow`, `impressionrow`, `delayingtreatmentrow`, `refusedtreatmentrow`, `devicedeliveryrow`, `checkuprow`, `patientnoncomprow`, `homesleeptestrow`, `starttreatmentrow`, `annualrecallrow`, `terminationrow` FROM `segments_order` WHERE `patientid` = '".$_GET['pid']."'";
	$qso_query = mysql_query($qso);
	
	$qsoResult = array();
	
	while ($qsoTmpResult = mysql_fetch_assoc($qso_query))
	{
		$qsoResult []= $qsoTmpResult;
	}
		
	$fsData_sql = "SELECT `steparray` FROM `dental_flow_pg2` WHERE `patientid` = '".$_GET['pid']."';";
	$fsData_query = mysql_query($fsData_sql);
	$fsData_array = mysql_fetch_array($fsData_query);
	
	
	/*
	$final_fsData_array = array();
	$fsIt = 1;
	
	while ($fsdataRow = mysql_fetch_assoc($fsData_query))
	{
		$current_section = $fsdataRow['section'];
		
		$final_fsData_array[$fsIt] = array( 'order' => $qsoResult[0]["$current_section"], 'section' => $current_section);
		
		$fsIt++;
	}
	
	*/
	
	
 	if (!empty($fsData_array['steparray'])) {
		$order = explode(",",$fsData_array['steparray']);
  	$order = array_reverse($order);
  	//print_r($order);
	}
	
	
	/*
	echo '<pre>';
	echo print_r($final_fsData_array);
	echo '</pre>';	
  echo '<br /><br />';
  */
   
  
  
  
  
  $flow_pg2_info_query = "SELECT stepid, UNIX_TIMESTAMP(date_scheduled) as date_scheduled, UNIX_TIMESTAMP(date_completed) as date_completed, delay_reason, noncomp_reason, study_type, description, letterid FROM dental_flow_pg2_info WHERE patientid = '".$_GET['pid']."' ORDER BY stepid ASC;";
  $flow_pg2_info_res = mysql_query($flow_pg2_info_query);
  while ($row = mysql_fetch_assoc($flow_pg2_info_res)) {
    $flow_pg2_info[$row['stepid']] = $row;
  }
//print_r($flow_pg2_info);
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
//print $dental_letters_query;

  //print_r($flow_pg2_info);
	$calendar_vars = array();
  $i = 0;
  while($section = $order && $i < count($order)){
  $segment_query = "SELECT * FROM `flowsheet_segments` WHERE `id` = ".$order[$i].";";
  $segment_res = mysql_query($segment_query);
  if($segment_res){
    $segment = mysql_fetch_array($segment_res);
  }else{
    echo "Error selecting segments from flowsheet"; 
  }
	if ($order[$i] != 1 && $order[$i] != 5 && $order[$i] != 6 && $order[$i] != 9 && $order[$i] != 13 && $order[$i] != 14) {
		//$calendar_vars[$i]['datesched'] .= "var cal_sched$i = new calendar2(document.getElementById('datesched$i'));";
		//$calendar_vars[$i]['varsched'] = "cal_sched$i";
	}
	//$calendar_vars[$i]['datecomp'] .= "var cal_comp$i = new calendar2(document.getElementById('datecomp$i'));";
	//$calendar_vars[$i]['varcomp'] = "cal_comp$i";
	//$caldatesched = $calendar_vars[$i]['varsched'];
	//$caldatecomp = $calendar_vars[$i]['varcomp'];
	$schedid = "datesched$i";
	$compid = "datecomp$i";

  /*$getsteparray = "SELECT * FROM dental_flow_pg2 WHERE `patientid` = '".$_GET['pid']."' LIMIT 1;";
  $steparrayqry = mysql_query($getsteparray);
  $steparray = mysql_fetch_array($steparrayqry);
  $steparray = explode(",", $steparray['steparray']);
  $stepcount = count($steparray);
  $steparray_last = end($steparray);*/

  $step = count($order) - $i;
  $datesched = date('m/d/Y', $flow_pg2_info[$step]['date_scheduled']);
  if ($datesched == '12/31/1969') $datesched = '';
  $datecomp = date('m/d/Y', $flow_pg2_info[$step]['date_completed']);
  if ($datecomp == '12/31/1969') $datecomp = '';
	$sleepstudy = $flow_pg2_info[$step]['study_type'];
	$delayreason = strtolower($flow_pg2_info[$step]['delay_reason']);
	$noncompreason = strtolower($flow_pg2_info[$step]['noncomp_reason']);
	$description = $flow_pg2_info[$step]['description'];

  $pid = $_GET['pid'];
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
  eval('?>' . $segment['content'] . '<?');
  
  //echo "<br />".$i."<br />";
  $i++; 
  }
    

?>
<input type="hidden" name="flowsubmitpgtwo" value="1">
<input type="submit" class="addButton" value="Submit" <?php print $order == null ? 'style="display: none"' : ''; ?> />
</form> 
</table>


</div>
<!-- END FLOWSHEET PAGE 2 ***************************** -->



<? 

// Determine Next Visit
$date_scheduled = null;
$sql = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE date_scheduled != '0000-00-00' AND date_completed = '0000-00-00' AND patientid = '".s_for($_GET['pid'])."' ORDER BY stepid DESC LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$date_scheduled = $row['date_scheduled'];
}
update_patient_summary($_GET['pid'], 'next_visit', $date_scheduled);

// Determine Last Visit
$date_completed = null;
$sql = "SELECT date_completed FROM dental_flow_pg2_info WHERE date_completed != '0000-00-00' AND patientid = '".s_for($_GET['pid'])."' ORDER BY stepid DESC LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$date_completed = $row['date_completed'];
}
update_patient_summary($_GET['pid'], 'last_visit', $date_completed);

// Determine Last Treatment
$segmentid = null;
$sql = "SELECT segmentid FROM dental_flow_pg2_info WHERE date_completed != '0000-00-00' AND patientid = '".s_for($_GET['pid'])."' ORDER BY stepid DESC LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$segmentid = $row['segmentid'];
}
switch ($segmentid) {
	case 1:
		$treatment = "Initial Contact";
		break;
	case 2:
		$treatment = "Consult";
		break;
	case 3:
		$treatment = "Sleep Study";
		break;
	case 4:
		$treatment = "Impressions";
		break;
	case 5:
		$treatment = "Delaying Treatment";
		break;
	case 6:
		$treatment = "Refused Treatment";
		break;
	case 7:
		$treatment = "Device Delivery";
		break;
	case 8:
		$treatment = "Follow-Up / Check";
		break;
	case 9:
		$treatment = "Patient Non-Compliant";
		break;
	case 10:
		$treatment = "Home Sleep Test";
		break;
	case 11:
		$treatment = "Treatment Complete";
		break;
	case 12:
		$treatment = "Annual Recall";
		break;
	case 13:
		$treatment = "Termination";
		break;
	default:
		$treatment = "N/A";
		break;
}
update_patient_summary($_GET['pid'], 'last_treatment', $treatment);

// Determine Device Delivery Date
$date_completed = null;
$sql = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".s_for($_GET['pid'])."' and segmentid = '7' ORDER BY date_completed DESC LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
	$date_completed = $row['date_completed'];
}
update_patient_summary($_GET['pid'], 'delivery_date', $date_completed);

// Determine Verification of Benefits
$preauth = null;
$sql = "SELECT "
     . "  status "
     . "FROM "
     . "  dental_insurance_preauth "
     . "WHERE "
     . "  patient_id = " . $_GET['pid'] . " "
     . "ORDER BY "
     . "  front_office_request_date DESC "
     . "LIMIT 1";
$my = mysql_query($sql) or die(mysql_error());
$preauth = mysql_fetch_array($my);
update_patient_summary($_GET['pid'], 'vob', $preauth['status']);


// Trigger Letter 20 Thankyou
$pt_referralid = get_ptreferralids($_GET['pid']);
if ($pt_referralid) {
	$sql = "SELECT letterid FROM dental_letters WHERE patientid = '".s_for($_GET['pid'])."' AND templateid = '20' AND md_referral_list = '".s_for($pt_referralid)."' AND deleted!=1;";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	if ($numrows == 0) {
		trigger_letter20($_GET['pid']);
	}
}


