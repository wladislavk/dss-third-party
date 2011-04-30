<?php

include('admin/includes/config.php');

// Trigger Letter 18

$dd_query = "SELECT patientid, steparray FROM dental_flow_pg2 WHERE CONCAT('[', steparray, ']') LIKE '%7]';";
$dd_result = mysql_query($dd_query);
$patients = array();
while ($row = mysql_fetch_assoc($dd_result)) {
  $patients[] = $row;
}
//print_r($patients);
//$patientlist = implode("','", $patients);
$pastdue_patients = array();
foreach ($patients as $patient) {
  $steps = explode(",", $patient['steparray']);
  $current_step = count($steps);
  $ddpastdue = "SELECT patientid, segmentid, date_completed FROM dental_flow_pg2_info WHERE patientid IN('".$patient['patientid']."') AND date_completed <= DATE_SUB(NOW(), INTERVAL 30 DAY) AND segmentid = '7' AND stepid = '".$current_step."';";
//print $ddpastdue. "<br />";
  $ddpastdue_result = mysql_query($ddpastdue);
  while ($row = mysql_fetch_assoc($ddpastdue_result)) {
    $pastdue_patients[] = $row;
  }
}
//print_r($pastdue_patients); print "<br />";
// SELECT patients who have CURRENT STEP is [Follow-up / Check] OR [Consult] OR [Device Delivery]
$casetwo = "SELECT patientid, steparray FROM dental_flow_pg2 WHERE CONCAT('[', steparray, ']') LIKE '%8]' OR CONCAT('[', steparray, ']') LIKE '%2]' OR CONCAT('[', steparray, ']') LIKE '%7]';";
$casetwo_result = mysql_query($casetwo);
$casetwo_patients;
while ($row = mysql_fetch_assoc($casetwo_result)) {
  $casetwo_patients[] = $row;
}
//print_r($casetwo_patients); print "<br />";
$current_step = array();
$second_case_patients = array();
foreach ($casetwo_patients as $patient) {
  $steparray = explode(",", $patient['steparray']);
  $finalstep = count($steparray);
  // Select Current Step scheduled 30 days ago not completed
  $curstep_query = "SELECT patientid, date_scheduled, date_completed from dental_flow_pg2_info WHERE patientid = '".$patient['patientid']."' AND stepid = '".$finalstep."' AND date_scheduled <= DATE_SUB(NOW(), INTERVAL 30 DAY) AND date_completed = '0000-00-00';";
  $curstep_result = mysql_query($curstep_query);
  while ($row = mysql_fetch_assoc($curstep_result)) {
    $current_step[] = $row;
  }
  foreach ($current_step as $step) {
    // SELECT previous device delivery segments completed more than 30 days ago
    $ddquery = "SELECT patientid, segmentid, date_completed FROM dental_flow_pg2_info WHERE patientid IN('".$step['patientid']."') AND date_completed <= DATE_SUB(NOW(), INTERVAL 30 DAY) AND segmentid = '7';";
    $ddresult = mysql_query($ddquery);
    while ($row = mysql_fetch_assoc($ddresult)) {
      $second_case_patients[] = $row;
    }
  }
}
//print_r($current_step); print "<br />";
//print_r($second_case_patients);

$letter18_patientlist = array_merge($pastdue_patients, $second_case_patients);
//print_r($letter18_patientlist);
$unique_pids = array();
foreach ($letter18_patientlist as $patient) {
  if (array_search($patient['patientid'], $unique_pids) === false) {
    $unique_pids[] = $patient['patientid'];
  }
}
$segment_count = array();
foreach ($unique_pids as $pid) {
  foreach ($second_case_patients as $patient) {
    if ($patient['patientid'] == $pid) {
      $segment_count[$pid]++;
    }
  }
}
foreach ($pastdue_patients as $patient) {
  if (!isset($segment_count[$patient['patientid']])) {
    $segment_count[$patient['patientid']] = 1;
  }
}
//print_r($segment_count);
//print_r($unique_pids);
$sentto = array();
foreach ($letter18_patientlist as $patient) {
  $letterid = '18';
  $topatient = '1';
  if (array_search($patient['patientid'], $sentto) === false) {
    $letters_query = "SELECT letterid FROM dental_letters WHERE templateid = '18' AND patientid = '".$patient['patientid']."';";
    $result = mysql_query($letters_query);
    $numrows = mysql_num_rows($result);
    if ($numrows < $segment_count[$patient['patientid']]) {
      $letter = create_letter($letterid, $patient['patientid'], '', $topatient);
      if (!is_numeric($letter)) {
        print $letter;
        die();
      }
      $sentto[] = $patient['patientid'];
    }
  }
}

$letter21_query = "SELECT dental_flow_pg2_info.patientid, dental_flow_pg2_info.stepid, dental_flow_pg2_info.date_completed, dental_letters.letterid FROM dental_flow_pg2_info LEFT JOIN dental_letters ON (dental_flow_pg2_info.patientid=dental_letters.patientid AND dental_flow_pg2_info.stepid=dental_letters.stepid) WHERE dental_flow_pg2_info.segmentid = '7' AND date_completed <= DATE_SUB(NOW(), INTERVAL 350 DAY) AND dental_letters.letterid IS NULL;";
$result = mysql_query($letter21_query);
if (!$result) {
  print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error selecting letters from database";
} else {
  while ($row = mysql_fetch_assoc($result)) {
    $letterid = '21';
    $patientid = $row['patientid'];
    $stepid = $row['stepid'];
    $topatient = '1';
    $letter = create_letter($letterid, $patientid, $stepid, $topatient);
    if (!is_numeric($letter)) {
      print $letter . "<br />";
    }
  }
}

$letter23_query = "SELECT dental_flow_pg2_info.patientid, dental_flow_pg2_info.stepid, dental_flow_pg2_info.date_completed, dental_letters.letterid, dental_letters.templateid FROM dental_flow_pg2_info LEFT JOIN dental_letters ON (dental_flow_pg2_info.patientid=dental_letters.patientid AND dental_flow_pg2_info.stepid=dental_letters.stepid) WHERE date_completed <= DATE_SUB(NOW(), INTERVAL 30 MONTH) AND dental_flow_pg2_info.segmentid = 7 AND (dental_letters.templateid = 21 OR dental_letters.templateid = 23) ORDER by dental_flow_pg2_info.patientid ASC;";
$result = mysql_query($letter23_query);
if (!$result) {
  print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error selecting letters from database";
} else {
  $letter_info = array();
  $removeids = array();
  while ($row = mysql_fetch_assoc($result)) {
    if ($row['templateid'] == 21) {
      $letter_info["{$row['patientid']}-{$row['stepid']}"] = array('patientid' => $row['patientid'], 'stepid' => $row['stepid']);
    }
    if ($row['templateid'] == 23) {
      $removeids[] = array('patientid' => $row['patientid'], 'stepid' => $row['stepid']);
    }
  }
  foreach ($removeids as $id) {
    unset($letter_info["{$id['patientid']}-{$id['stepid']}"]);
  }
  foreach ($letter_info as $letter) {
    $letterid = '23';
    $patientid = $letter['patientid'];
    $stepid = $letter['stepid'];
    $topatient = '1';
    $letter = create_letter($letterid, $patientid, $stepid, $topatient);
    if (!is_numeric($letter)) {
      print $letter . "<br />";
    }
    print $patientid;
  }
}
?>
