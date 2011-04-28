<?php

include('admin/includes/config.php');

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
