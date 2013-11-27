<?php
require_once '../admin/includes/main_include.php';
//include_once '../admin/includes/general.htm';
$id = $_REQUEST['id'];
$sched = ($_REQUEST['sched']!='')?date('Y-m-d', strtotime($_REQUEST['sched'])):'';
$pid = $_REQUEST['pid'];
clean_steps($pid);
		$s = "INSERT INTO dental_flow_pg2_info SET
			patientid= ".$pid.",
			segmentid = ".$id.",
			date_scheduled = '".$sched."'";
		$q = mysql_query($s); 

		$info_id = mysql_insert_id();

        $consult_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE segmentid = '2' and patientid = '".$pid."' LIMIT 1;";
        $consult_result = mysql_query($consult_query);
        $consult_date = mysql_result($consult_result, 0, 0);
        if ($consult_date != "0000-00-00") {
                $consulted = true;
        }
        $letterid = array();
        if ($id == "2") { // Consultation
//              $letterid[] = trigger_letter5($_GET['pid'], $numsteps);
                $letterid[] = trigger_letter6($pid, $info_id);
        }
        if ($consulted == true && $id == "4") { // Impressions
                $letterid[] = trigger_letter9($pid, $info_id);
                //$letterid[] = trigger_letter13($pid, $numsteps);
        }








if($q){
  echo '{"success":true}';
}else{
  echo '{"error":true}';
}
?>

<?php
function clean_steps($pid){ //Deletes not completed steps and clears scheduled
	
	$s = "SELECT id, segmentid, date_scheduled, date_completed from dental_flow_pg2_info where patientid=".$pid;
	$q = mysql_query($s);
	while($r = mysql_fetch_assoc($q)){
	  if( $r['date_completed']==''){
                $s = "DELETE FROM dental_flow_pg2_info
                        WHERE id = ".$r['id']."
                                AND patientid=".$pid;
                mysql_query($s);

	  }else{
		mysql_query("UPDATE dental_flow_pg2_info set 
                        date_scheduled=''
                        WHERE id=".$r['id']);
	  }
	}

} 


function trigger_letter6($pid, $info_id) {
        $letterid = '6';
        $topatient = '1';
        $letter = create_letter($letterid, $pid, $info_id, $topatient, '', '', '', '', '', 'paper');
        if (!is_numeric($letter)) {
                print "Can't send letter 6: " . $letter;
                die();
        } else {
                return $letter;
        }
}

function trigger_letter9($pid, $info_id) {
  $letterid = '9';
  $md_list = '';//get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);

        //if ($md_referral_list != "") {
                $letter = create_letter($letterid, $pid, $info_id, '', $md_list, $md_referral_list);
                if (!is_numeric($letter)) {
                        print "Can't send letter 9: " . $letter;
                        //die();
                } else {
                        return $letter;
                }
        //}
}


?>
