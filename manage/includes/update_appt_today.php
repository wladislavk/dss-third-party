<?php
session_start();
require_once '../admin/includes/config.php';
require_once 'letter_triggers.php';
$id = $_REQUEST['id'];
$c = $_REQUEST['c'];
$pid = $_REQUEST['pid'];
		$numsteps = null;
$impression = true;
$letterid = array();
$create = true; //default to insert record if checks pass

if($id == "7" || $id == "4"){  //device deliver - check if impressions are done

  $imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".mysql_real_escape_string($pid)."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
  $imp_q = mysql_query($imp_s);
  $imp_n = mysql_num_rows($imp_q);
  if($imp_n == 0){
	$impression=false;
  }else{
    $imp_r = mysql_fetch_assoc($imp_q);
    $impression = $imp_r['device_id'];

  }
}


if($id == "7"){
  $sql = "SELECT * FROM dental_ex_page5 where patientid='".$pid."'";
  $q = mysql_query($sql);
  if(mysql_num_rows($q)==0){
    $sqlex = "INSERT INTO dental_ex_page5 set 
                dentaldevice_date=CURDATE(), 
                patientid='".$pid."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
  }else{
 
    $sqlex = "update dental_ex_page5 set dentaldevice_date=CURDATE() where patientid='".$pid."'";
  }
  $qex = mysql_query($sqlex);

}

if($create){

                    $s = "INSERT INTO dental_flow_pg2_info SET
                        patientid= ".$pid.",
                        segmentid = ".$id.",
                        letterid = '".$letteridlist."',
			appointment_type = 1,";
		    if($impression){
			$s .= " device_id='".$impression."',";
		    }		
                     $s .=" date_completed = CURDATE()";
                $q = mysql_query($s);
                $insert_id=mysql_insert_id();
		if($q){ 
		  mysql_query("DELETE FROM dental_flow_pg2_info WHERE appointment_type=0 AND patientid='".mysql_real_escape_string($pid)."'");
		}

        if ($id == "8") { // Follow-Up/Check
                $trigger_query = "SELECT dental_flow_pg2_info.patientid, dental_flow_pg2_info.date_completed FROM dental_flow_pg2_info WHERE dental_flow_pg2_info.segmentid = '7' AND dental_flow_pg2_info.date_completed != '0000-00-00' AND dental_flow_pg2_info.patientid = '".$pid."';";
                $trigger_result = mysql_query($trigger_query);
                $numrows = (mysql_num_rows($trigger_result));
                if ($numrows > 0) {
                        $letterid[] = trigger_letter16($pid, $insert_id);
                }
        }
        if ($id == "13") { // Termination
                $letterid[] = trigger_letter24($pid, $insert_id);
        }

                                                        $consult_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$pid."' LIMIT 1;";
                                                        $consult_result = mysql_query($consult_query);
                                                        $consult_date = mysql_result($consult_result, 0, 0);
                                                        if ($consult_date != "0000-00-00") {
                                                                $consulted = true;
                                                        }
                                                        // Delaying Treatment / Waiting
                                                        if ($consulted == true && $id == "5") {
                                                                $letterid[] = trigger_letter10($pid, $insert_id);
                                                        }
                                                        // Refused Treatment
                                                        if ($consulted == true && $id == "6") {
                                                                $letterid[] = trigger_letter8($pid, $insert_id);
                                                                $letterid[] = trigger_letter11($pid, $insert_id);
                                                        }
                                                        // Patient Non Compliant
                                                        if ($id == "9") {
                                                                $letterid[] = trigger_letter17($pid, $insert_id);
                                                        }
                                                        // Treatment Complete
                                                        if ($id == "11") {
                                                                $letterid[] = trigger_letter19($pid, $insert_id);
                                                        }
                                                        if ($id == "14") {
                                                                $letterid[] = trigger_letter7($pid, $insert_id);
                                                        }


if($letterid){
		    $letterid = array_unique($letterid);
while(($key = array_search('0', $letterid)) !== false) {
    unset($letterid[$key]);
}
}
  $letter_count = 0;
if(count($letterid)>0){
                    $letteridlist = implode(",", $letterid);


$dental_letters_query = "SELECT patientid, letterid, UNIX_TIMESTAMP(generated_date) as generated_date, topatient, md_list, md_referral_list, pdf_path, status, delivered, dental_letter_templates.name, dental_letter_templates.template, deleted FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = '".$pid."' AND (letterid IN(".$letteridlist.") OR parentid IN(".$letteridlist.")) ;";
  $dental_letters_res = mysql_query($dental_letters_query);
  $dental_letters = array();
  while ($row = mysql_fetch_assoc($dental_letters_res)) {
    $dental_letters[] = $row;
                $contacts = get_contact_info((($row['topatient'] == "1") ? $row['patientid'] : ''), $row['md_list'], $row['md_referral_list']);
 /*
                        if(isset($contacts['patient'])){
                                $letter_count += count($contacts['patient']);
                        }
                        if(isset($contacts['mds'])){
                                $letter_count += count($contacts['mds']);
                        }
                        if(isset($contacts['md_referrals'])){
                                $letter_count += count($contacts['md_referrals']);
                        }
*/
                        $letter_count += count($contacts['patient'])+count($contacts['md_referrals'])+count($contacts['mds']);
	}


}

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

$title = $segments[$id];

$next = "<option value=''>SELECT NEXT STEP</option>";
        $next_sql = "SELECT steps.* FROM dental_flowsheet_steps steps
                JOIN dental_flowsheet_steps_next next ON steps.id = next.child_id
                WHERE next.parent_id='".mysql_real_escape_string($id)."'
                ORDER BY next.sort_by ASC";
  $next_q = mysql_query($next_sql);
        while($next_r = mysql_fetch_assoc($next_q)){
          $next .= "<option value='".$next_r['id']."'>".$next_r['name']."</option>";
        }
}
$impression_json = ($impression)?$impression:'false';
if($s){
  echo '{"success":true, "datecomp":"'.date('m/d/Y').'", "id":"'.$insert_id.'", "next_steps":"'.$next.'", "title":"'.$title.'", "letters":"'.$letter_count.'", "impression":'.$impression_json.'}';
}else{
  echo '{"error":true}';
}
?>
