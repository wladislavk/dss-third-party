<?php

require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once("admin/includes/general.htm");
require_once('includes/constants.inc');
require_once('includes/formatters.php');

if (isset($_POST['partial_name'])) {
	$partial = $_POST['partial_name'];
	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
	$partial = s_for($partial);
}

$names = explode(" ", $partial);

$sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, p.status AS stat, p.premedcheck,  "
  .   " s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment,  "
  .		" s.delivery_date, s.vob, s.ledger, s.patient_info, d.device, "
                 . " fs.rxreq, fs.rxrec, fs.lomnreq, fs.lomnrec "
	.		" FROM dental_patients p"
  .   " LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
  .   " LEFT JOIN dental_device d ON s.appliance = d.deviceid "
                 . "  LEFT JOIN dental_flow_pg1 fs ON fs.pid = p.patientid "
	.		" WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
	.		" AND (lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%'))"
	.		" OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .$names[1]."%' AND lastname LIKE '" . $names[2] . "%'))"
        .               " AND p.status=1 "
	.		" AND docid = '" . $_SESSION['docid'] . "' ORDER BY lastname ASC;";
$result = mysqli_query($con, $sql);

$patients = array();
$i = 0;
while ($row = mysqli_fetch_assoc($result)) {
	$rxlomn = '';
                          if($row['rxreq'] != null && $row['rxrec'] == null){
        $day = (24 * 60 * 60);
  $diff = ceil((time() - strtotime($row['rxreq'])) / $day);
                                if($diff > 7){
                                  $rxlomn .= '<span class="red">Pending</span>';
                                }else{
                                  $rxlomn .= 'Pending';
                                }
                          }elseif($row['rxrec'] != null){
                                $rxlomn .= 'Yes';
                          }else{
                                $rxlomn .= 'N/A';
                          }
                $rxlomn .= ' / ';
                          if($row['lomnreq'] != null && $row['lomnrec'] == null){
        $day = (24 * 60 * 60);
  $diff = ceil((time() - strtotime($row['lomnreq'])) / $day);
                                if($diff > 7){
                                  $rxlomn .= '<span class="red">Pending</span>';
                                }else{
                                  $rxlomn .= 'Pending';
                                }

                          }elseif($row['lomnrec'] != null){
                                $rxlomn .= 'Yes';
                          }else{
                                $rxlomn .= 'N/A';
                          }
	$patients[$i]['id'] = $row['patientid'];
  $patients[$i]['name'] = $row['firstname']." ".$row['lastname'];
  $i++;
}

if (!$result) {
	$patients = array("error" => $sql ." Error: Could not select patients from database");
}

echo json_encode($patients);

?>
