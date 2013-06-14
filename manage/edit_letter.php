<?php
if($_GET['backoffice'] == '1') {
  include 'admin/includes/top.htm';
?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<?php 
} else {
  include 'includes/top.htm';
}
?>
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/manage/js/edit_letter.js"></script>
<?php

$status_sql = "SELECT status FROM dental_letters
		WHERE letterid='".mysql_real_escape_string($_GET['lid'])."'";
$status_q = mysql_query($status_sql);
$status_r = mysql_fetch_assoc($status_q);
$parent_status = $status_r['status'];


$masterid=$_GET['lid'];
$master_sql = "SELECT * FROM dental_letters l
		WHERE (l.letterid='".mysql_real_escape_string($_GET['lid'])."'
			OR l.parentid='".mysql_real_escape_string($_GET['lid'])."')
			AND status='".$parent_status."' AND deleted=0 ORDER BY edit_date DESC";
$master_c = mysql_query($master_sql);
$master_q = mysql_query($master_sql);
$master_num = 0;
$cur_letter_num = 0;
$cur_template_num = 0;

//TO COUNT NUMBER OF LETTERS
while($master_r = mysql_fetch_assoc($master_c)){
  $letterid = $master_r['letterid'];
  $othermd_query = "SELECT md_list, md_referral_list FROM dental_letters where letterid = '".$letterid."' ORDER BY letterid ASC;";
  $othermd_result = mysql_query($othermd_query);
  $md_array = array();
  $md_referral_array = array();
  while ($row = mysql_fetch_assoc($othermd_result)) {
        if ($row['md_list'] != null) {
                $md_array = array_merge($md_array, explode(",", $row['md_list']));
        }
        if ($row['md_referral_list'] != null) {
                $md_referral_array = array_merge($md_referral_array, explode(",", $row['md_referral_list']));
        }
  }
  $full_md_list = implode(",", $md_array);
  $full_md_referral_list = implode(",", $md_referral_array);
  $contacts = get_contact_info('', $full_md_list, $full_md_referral_list);
  $master_num += count($contacts['mds']);
  $master_num += count($contacts['md_referrals']);
  if($master_r['topatient']){ $master_num++; }
}



//LOOP THROUGH LETTERS
while($master_r = mysql_fetch_assoc($master_q)){
$letterid = $master_r['letterid'];
//$letterid = mysql_real_escape_string($_GET['lid']);

// Select Letter
$letter_query = "SELECT l.templateid, l.patientid, l.topatient, l.md_list, l.md_referral_list, l.template, l.send_method, l.status, l.docid, u.username, l.edit_date FROM dental_letters l
	LEFT JOIN dental_users u ON u.userid=l.edit_userid
	 where l.letterid = ".$letterid.";";
$letter_result = mysql_query($letter_query);
$row = mysql_fetch_assoc($letter_result); 
  $templateid = $row['templateid'];
  $patientid = $row['patientid'];
  $topatient = $row['topatient'];
  $md_list = $row['md_list'];
  $md_referral_list = $row['md_referral_list'];
  $mds = explode(",", $md_list);
  $md_referrals = explode(",", $md_referral_list);
	$altered_template = html_entity_decode($row['template'], ENT_COMPAT | ENT_IGNORE,"UTF-8");
	$method = $row['send_method'];
  $status = $row['status'];
  $docid = $row['docid'];
  $username = $row['username'];
  $edit_date = $row['edit_date'];

// Pending and Sent Contacts
$othermd_query = "SELECT md_list, md_referral_list FROM dental_letters where letterid = '".$letterid."' OR parentid = '".$letterid."' ORDER BY letterid ASC;";
$othermd_result = mysql_query($othermd_query);
$md_array = array();
$md_referral_array = array();
while ($row = mysql_fetch_assoc($othermd_result)) {
	if ($row['md_list'] != null) {
		$md_array = array_merge($md_array, explode(",", $row['md_list']));
	} 
	if ($row['md_referral_list'] != null) {
		$md_referral_array = array_merge($md_referral_array, explode(",", $row['md_referral_list']));
	}
}
$full_md_list = implode(",", $md_array);
$full_md_referral_list = implode(",", $md_referral_array);
$contacts = get_contact_info('', $full_md_list, $full_md_referral_list);
foreach ($contacts['mds'] as $contact) {
  $md_contacts[] = array_merge(array('type' => 'md'), $contact);
}
foreach ($contacts['md_referrals'] as $contact) {
  $md_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
}

// Get Letter Subject
$template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$templateid.";";
$template_result = mysql_query($template_query);
$title = mysql_result($template_result, 0);
?>


<br />
<span class="admin_head">
	<?php print $title; ?>
</span>
<br />
&nbsp;&nbsp;
<?php 
if($_REQUEST['goto']!=''){
                                if($_REQUEST['goto']=='flowsheet'){
                                        $page = 'manage_flowsheet3.php?pid='.$_GET['pid'].'&addtopat=1';
                                }elseif($_REQUEST['goto']=='letter'){
                                        $page = 'dss_summ.php?sect=letters&pid='.$_GET['pid'].'&addtopat=1';
                                }elseif($_REQUEST['goto']=='new_letter'){
                                        $page = 'new_letter.php?pid='.$_GET['pid'];
                                }

?> <a href="<?=$page; ?>" class="editlink" title="Pending Letters"><?php
}else{
?>
<a href="<?php print ($_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>" class="editlink" title="Pending Letters">
<?php } ?>
	<b>&lt;&lt;Back</b></a>
<br /><br>

<?php
//print_r ($_POST);

// Get Contact Info for Recipients
$s = "SELECT referred_source FROM dental_patients where patientid=".mysql_real_escape_string($_GET['pid'])." LIMIT 1";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);
$source = $r['referred_source'];
if ($topatient) {
  $contact_info = get_contact_info($patientid, $md_list, $md_referral_list);
} else {
  $contact_info = get_contact_info('', $md_list, $md_referral_list, $source);
}
if($source == DSS_REFERRED_PHYSICIAN){
$md_referral = get_mdreferralids($_GET['pid']);
$ref_info = get_contact_info('', '', $md_referral_list, $source);
	if (!empty($ref_info['md_referrals'])) {                        
		if(is_physician($ref_info['md_referrals'][0]['contacttypeid'])){
			$referral_fullname = "<strong>" . $ref_info['md_referrals'][0]['salutation'] . " " . $ref_info['md_referrals'][0]['firstname'] . " " . $ref_info['md_referrals'][0]['lastname'] . "</strong>";
		}else{
			$referral_fullname = '';
		}
        } elseif(!empty($pcp)) {
		if(is_physician($ref_info['pcp']['contacttypeid'])){
	        	$referral_fullname = "<strong>" . $pcp['salutation'] . " " . $pcp['firstname'] . " " . $pcp['lastname'] . "</strong>";
		}else{
		 	$referral_fullname = '';
		}
        }else{
		$referral_fullname = '';
	}

}elseif($source == DSS_REFERRED_PATIENT){
	$referral_fullname = '<strong>a patient</strong>';
}elseif($source == DSS_REFERRED_MEDIA ){
        $referral_fullname = '<strong>a media source</strong>';
}elseif($source == DSS_REFERRED_FRANCHISE ){
        $referral_fullname = '<strong>an internal source</strong>';
}elseif($source == DSS_REFERRED_DSSOFFICE ){
        $referral_fullname = "<strong>Dental Sleep Solutions' referral network</strong>";
}elseif($source == DSS_REFERRED_OTHER ){
        $referral_fullname = '<strong>an unspecified source</strong>';
}else{
        $referral_fullname = '';
}


 

$pt_referral = get_ptreferralids($_GET['pid']);
$ptref_info = get_contact_info('', '', $pt_referral, $source);

$letter_contacts = array();
foreach ($contact_info['patient'] as $contact) {
  $letter_contacts[] = array_merge(array('type' => 'patient'), $contact);
}
foreach ($contact_info['md_referrals'] as $contact) {
  $letter_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
}
foreach ($contact_info['mds'] as $contact) {
  $letter_contacts[] = array_merge(array('type' => 'md'), $contact);
}
$numletters = count($letter_contacts);

$sql = "select docpcp from dental_patients where patientid = '".s_for($_GET['pid'])."';";
$result = mysql_query($sql);
$docpcp = mysql_result($result, 0, 0);
foreach ($contact_info['mds'] as $contact) {
	if ($contact['id'] == $docpcp) {
		$pcp = $contact;
	}
}




// Get Date

$todays_date = date('F d, Y');
// Get Patient Information
$patient_query = "SELECT salutation, firstname, middlename, lastname, gender, dob, email, p_m_ins_id, docid FROM dental_patients WHERE patientid = '".$patientid."';";
$patient_result = mysql_query($patient_query);
$patient_info = array();
while ($row = mysql_fetch_assoc($patient_result)) {
        $patient_info = $row;
}

$c_sql = "SELECT companyid from dental_user_company WHERE userid='".$docid."'";
$c_q = mysql_query($c_sql);
$c_r = mysql_fetch_assoc($c_q);
$companyid = $c_r['companyid'];

$patient_info['age'] = floor((time() - strtotime($patient_info['dob']))/31556926);
$did = $patient_info['docid'];

// Get Franchisee Name and Address
$franchisee_query = "SELECT mailing_name as name, mailing_practice as practice, mailing_address as address, mailing_city as city, mailing_state as state, mailing_zip as zip, email, use_digital_fax FROM dental_users WHERE userid = '".$docid."';";
$franchisee_result = mysql_query($franchisee_query);
while ($row = mysql_fetch_assoc($franchisee_result)) {
	$franchisee_info = $row;
}

$loc_sql = "SELECT location FROM dental_summary where patientid='".mysql_real_escape_string($_GET['pid'])."'";
$loc_q = mysql_query($loc_sql);
$loc_r = mysql_fetch_assoc($loc_q);
if($_GET['pid']!='' && $loc_r['location'] != '' && $loc_r['location'] != '0'){
  $location_query = "SELECT * FROM dental_locations WHERE id='".mysql_real_escape_string($loc_r['location'])."' AND docid='".mysql_real_escape_string($docid)."'";
}else{
  $location_query = "SELECT * FROM dental_locations WHERE default_location=1 AND docid='".mysql_real_escape_string($docid)."'";
}
error_log($location_query);
$location_result = mysql_query($location_query);
$location_info = mysql_fetch_assoc($location_result);


// Get Company Name and Address
$company_query = "SELECT c.* FROM companies c 
		JOIN dental_user_company uc ON c.id = uc.companyid
		WHERE uc.userid = '".$docid."';";
//echo $company_query;
$company_result = mysql_query($company_query);
while ($row = mysql_fetch_assoc($company_result)) {
        $company_info = $row;
}


// Consult Appointment Date
$consult_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 2 ORDER BY stepid DESC LIMIT 1;";
$consult_result = mysql_query($consult_query);
$consult_date = date('F d, Y', strtotime(mysql_result($consult_result, 0)));

// Impressions Appointment Date
$impressions_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";
$impressions_result = mysql_query($impressions_query);
$impressions_date = date('F d, Y', strtotime(mysql_result($impressions_result, 0)));

// Get Medical Information
$q3_sql = "SELECT other_history, other_medications, medicationscheck from dental_q_page3 WHERE patientid = '".$patientid."';";
$q3_my = mysql_query($q3_sql);
$q3_myarray = mysql_fetch_array($q3_my);

  $history_disp = $q3_myarray['other_history'];

if($q3_myarray['medicationscheck']){
  $medications_disp = $q3_myarray['other_medications'];
}else{
  $medications_disp = '';
}

/*
$history = $q3_myarray['history'];
$medications = $q3_myarray['medications'];

$history_arr = explode('~',$history);
$history_arr = explode('~',$history);
$history_disp = '';
foreach($history_arr as $val)
{
	if(trim($val) <> "")
	{
		$his_sql = "select history from dental_history where historyid='".trim($val)."' and status=1;";
		$his_my = mysql_query($his_sql);
		$his_myarray = mysql_fetch_array($his_my);
		
		if($his_myarray['history'] <> '')
		{
			if($history_disp <> '')
				$history_disp .= ' and ';
				
			$history_disp .= $his_myarray['history'];
		}
	}
}

$medications_arr = explode('~',$medications);
$medications_disp = '';
$medcount = 0;
foreach ($medications_arr as $val) {
	if ($val != "") {
		$medcount++;
	}
}
foreach($medications_arr as $key => $val)
{
	if(trim($val) <> "")
	{
		$medications_sql = "select medications from dental_medications where medicationsid='".trim($val)."' and status=1;";
		$medications_my = mysql_query($medications_sql);
		$medications_myarray = mysql_fetch_array($medications_my);
		
		if($medications_myarray['medications'] <> '')
		{
			if($medications_disp <> '') {
				if ($medcount == $key) {
					$medications_disp .= ', and ';
				} else {
					$medications_disp .= ', ';
				}
			}
				
			$medications_disp .= $medications_myarray['medications'];
		}
	}
}
*/
// Oldest Sleepstudy Results
$q1_sql = "SELECT s.date, s.sleeptesttype, s.ahi, s.rdi, s.t9002, s.o2nadir, s.diagnosis, s.place, s.dentaldevice, d.ins_diagnosis, d.description FROM dental_summ_sleeplab s 
LEFT JOIN dental_ins_diagnosis d
  ON s.diagnosis = d.ins_diagnosisid
WHERE patiendid='".$patientid."' ORDER BY id ASC LIMIT 1;";
$q1_my = mysql_query($q1_sql);
$q1_myarray = mysql_fetch_array($q1_my);
$first_study_date = st($q1_myarray['date']);
$first_diagnosis = st($q1_myarray['ins_diagnosis']." ".$q1_myarray['description']); //st($q1_myarray['diagnosis']);
$first_ahi = st($q1_myarray['ahi']);
$first_rdi = st($q1_myarray['rdi']);
$first_o2sat90 = st($q1_myarray['t9002']);
$first_o2nadir = st($q1_myarray['o2nadir']);
$first_type_study = st($q1_myarray['sleeptesttype']) . " sleep test";
$first_center_name = st($q1_myarray['place']);

$q2_sql = "SELECT s.date, s.sleeptesttype, s.ahi, s.rdi, s.t9002, s.o2nadir, d.ins_diagnosis, d.description, s.place, s.dentaldevice, sl.company, 
CASE s.sleeptesttype
   WHEN 'PSG Baseline' THEN '1'
   WHEN 'HST Baseline' THEN '2'
   WHEN 'PSG' THEN '3'
   WHEN 'HST' THEN '4'
   ELSE '5'
END
AS sort_order 
FROM dental_summ_sleeplab s 
JOIN dental_patients p
  ON p.patientid=s.patiendid
JOIN dental_ins_diagnosis d
  ON s.diagnosis = d.ins_diagnosisid
LEFT JOIN dental_sleeplab sl
  ON s.place = sl.sleeplabid
WHERE 
(p.p_m_ins_type!='1' OR ((s.diagnosising_doc IS NOT NULL && s.diagnosising_doc != '') AND 
(s.diagnosising_npi IS NOT NULL && s.diagnosising_npi != ''))) AND 
(s.diagnosis IS NOT NULL && s.diagnosis != '') AND 
s.filename IS NOT NULL AND 
s.patiendid='".$patientid."' AND s.sleeptesttype IN ('PSG Baseline', 'HST Baseline', 'PSG', 'HST') ORDER BY sort_order ASC, s.date DESC, s.id DESC LIMIT 1;";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);
$completed_study_date = st($q2_myarray['date']);
$completed_diagnosis = st($q2_myarray['ins_diagnosis']." ".$q2_myarray['description']);
$completed_ahi = st($q2_myarray['ahi']);
$completed_rdi = st($q2_myarray['rdi']);
$completed_o2sat90 = st($q2_myarray['t9002']);
$completed_o2nadir = st($q2_myarray['o2nadir']);
$completed_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
$completed_sleeplab_name = st($q2_myarray['company']);


$sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$first_center_name."';";
$sleeplab_my = mysql_query($sleeplab_sql);
$sleeplab_myarray = mysql_fetch_array($sleeplab_my);

$first_sleeplab_name = st($sleeplab_myarray['company']);


// Newest Sleep Study Results
$q2_sql = "SELECT date, sleeptesttype, ahi, ahisupine, rdi, t9002, o2nadir, diagnosis, place, dd.device FROM dental_summ_sleeplab dss LEFT JOIN dental_device dd ON dd.deviceid=dss.dentaldevice WHERE patiendid='".$patientid."' ORDER BY id DESC LIMIT 1;";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);
$second_study_date = st($q2_myarray['date']);
$second_diagnosis = st($q2_myarray['diagnosis']);
$second_ahi = st($q2_myarray['ahi']);
$second_ahisupine = st($q2_myarray['ahisupine']);
$second_rdi = st($q2_myarray['rdi']);
$second_o2sat90 = st($q2_myarray['t9002']);
$second_o2nadir = st($q2_myarray['o2nadir']);
$second_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
$sleep_center_name = st($q2_myarray['place']);
//$dentaldevice = st($q2_myarray['device']);

$dd_sql = "select dd.device, ex.dentaldevice_date FROM dental_ex_page5 ex LEFT JOIN dental_device dd ON dd.deviceid=ex.dentaldevice WHERE ex.patientid='".$patientid."'";
$dd_q = mysql_query($dd_sql);
$dd_r = mysql_fetch_assoc($dd_q);
$dentaldevice = $dd_r['device'];
$delivery_date = ($dd_r['dentaldevice_date'] != '') ? date('F d, Y', strtotime($dd_r['dentaldevice_date'])):'';


$sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."';";
$sleeplab_my = mysql_query($sleeplab_sql);
$sleeplab_myarray = mysql_fetch_array($sleeplab_my);

$sleeplab_name = st($sleeplab_myarray['company']);

// Oldest Subjective results
$subj1_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid ASC LIMIT 1;";
$subj1_result = mysql_query($subj1_query);
while ($row = mysql_fetch_assoc($subj1_result)) {
	$subj1 = $row;
}

// Newest Subjective Results
$subj2_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid DESC LIMIT 1;";
$subj2_result = mysql_query($subj2_query);
while ($row = mysql_fetch_assoc($subj2_result)) {
	$subj2 = $row;
}

// Device Delivery Date
$device_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 7 ORDER BY stepid DESC LIMIT 1;";
$device_result = mysql_query($device_query);
//$delivery_date = date('F d, Y', strtotime(mysql_result($device_result, 0)));


// Delay Reason and Description
$reason_query = "SELECT delay_reason as reason, description FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 5 ORDER BY date_completed DESC, id DESC LIMIT 1;";
$reason_result = mysql_query($reason_query);
while ($row = mysql_fetch_assoc($reason_result)) {
	$delay = $row;
}
$delay['description'] = $delay['description'];

// Select BMI
$bmi_query = "SELECT bmi FROM dental_q_page1 WHERE patientid = '".$patientid."';";
$bmi_result = mysql_query($bmi_query);
$bmi = mysql_result($bmi_result, 0);

// Reason seeking treatment
$reason_query = "SELECT reason_seeking_tx FROM dental_summary WHERE patientid = '".$patientid."';";
$reason_result = mysql_query($reason_query);
$reason_seeking_tx = mysql_result($reason_result, 0);

$cc_sql = "select chief_complaint_text from dental_q_page1 WHERE patientid=".mysql_real_escape_string($patientid);
$cc_q = mysql_query($cc_sql);
$cc_row = mysql_fetch_assoc($cc_q);
$reason_seeking_tx = $cc_row['chief_complaint_text'];
$q1_sql = "select * from dental_q_page1 where patientid='".$patientid."'";
$q1_my = mysql_query($q1_sql);
$q1_myarray = mysql_fetch_array($q1_my);

$main_reason = st($q1_myarray['main_reason']);
$main_reason_other = st($q1_myarray['main_reason_other']);
$complaintid = st($q1_myarray['complaintid']);


if($complaintid <> '')
{
        //$reason_seeking_tx .= $complaintid;

        //echo $complaintid."<br>"      ;

        $chief_arr = explode('~',$complaintid);

        if(count($chief_arr) <> 0)
        {
                $c_count = 0;
                foreach($chief_arr as $c_val)
                {
                        if(trim($c_val) <> '')
                        {
                                $c_s = explode('|',$c_val);

                                $c_id[$c_count] = $c_s[0];
                                $c_seq[$c_count] = $c_s[1];

                                $c_count++;
                        }
                }
        }

        asort($c_seq );
       foreach($c_seq as $i=>$val)
        {
                //echo $c_id[$i]."<br>";
                $comp_sql = "select * from dental_complaint where status=1 and complaintid='".$c_id[$i]."'";
                $comp_my = mysql_query($comp_sql);
                $comp_myarray = mysql_fetch_array($comp_my);

                //echo $c_id[$i]." => ".st($comp_myarray['complaint'])."<br>";
                  $reason_seeking_tx .= ", " . st($comp_myarray['complaint']);
        }
}



// Symptoms 
$sql = "SELECT complaintid FROM dental_q_page1 WHERE patientid = '".$patientid."' LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
	$complaint = explode("~", rtrim($row['complaintid'], "~"));
}
foreach ($complaint as $pair) {
	$idscore = explode("|", $pair);
	$compid[] = $idscore[0];
}
foreach ($compid as $id) {
	$sql = "SELECT complaint FROM dental_complaint WHERE complaintid = '".$id."';";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
		$symptoms[] = $row['complaint'];
	}
}
foreach ($symptoms as $key => $value) {
	if ($key != count($symptoms) -1 && $key != count($symptoms) -2) {
		$symptom_list .= $value . ", ";
	} elseif ($key == count($symptoms) -2) {
		$symptom_list .= $value . " and ";
	} else {
		$symptom_list .= $value;
	}
}

// Nights per Week and Current ESS TSS 
$followup_query = "SELECT nightsperweek, ep_eadd, ep_tsadd FROM dentalsummfu where patientid = '".$patientid."' ORDER BY followupid DESC LIMIT 1;";
$followup_result = mysql_query($followup_query);
while ($row = mysql_fetch_assoc($followup_result)) {
	$followup = $row;
}

// Nights per Week and Current ESS TSS 
$initesstss_query = "SELECT ep_eadd, ep_tsadd FROM dentalsummfu where patientid = '".$patientid."' ORDER BY followupid ASC LIMIT 1;";
$initesstss_result = mysql_query($initesstss_query);
$initess = mysql_result($initesstss_result, 0, 0);
$inittss = mysql_result($initesstss_result, 0, 1);

// Non Compliance Reason and Description
$reason_query = "SELECT noncomp_reason as reason, description FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 9 ORDER BY date_completed DESC, id DESC LIMIT 1";
$reason_result = mysql_query($reason_query);
while ($row = mysql_fetch_assoc($reason_result)) {
	$noncomp = $row;
}
$noncomp['description'] = $noncomp['description'];


// Load $template

  $letter_sql = "SELECT body FROM dental_letter_templates WHERE companyid='".mysql_real_escape_string($companyid)."' AND triggerid='".mysql_real_escape_string($templateid)."'";
  $letter_q = mysql_query($letter_sql);
  $letter_r = mysql_fetch_assoc($letter_q);
  $template = $letter_r['body'];
  $orig_template = $letter_r['body'];

/*
switch ($templateid) {
	case 1:
		require_once("letter_templates/letter1.php");
		break;
	case 2:
		require_once("letter_templates/letter2.php");
		break;
	case 3:
		require_once("letter_templates/letter3.php");
		break;
	case 4:
		require_once("letter_templates/letter4.php");
		break;
	case 5:
		require_once("letter_templates/letter5.php");
		break;
	case 6:
		require_once("letter_templates/letter6.php");
		break;
	case 7:
		require_once("letter_templates/letter7.php");
		break;
	case 8:
		require_once("letter_templates/letter8.php");
		break;
	case 9:
		require_once("letter_templates/letter9.php");
		break;
	case 10:
		require_once("letter_templates/letter10.php");
		break;
	case 11:
		require_once("letter_templates/letter11.php");
		break;
	case 12:
		require_once("letter_templates/letter12.php");
		break;
	case 13:
		require_once("letter_templates/letter13.php");
		break;
	case 14:
		require_once("letter_templates/letter14.php");
		break;
	case 15:
		require_once("letter_templates/letter15.php");
		break;
	case 16:
		require_once("letter_templates/letter16.php");
		break;
	case 17:
		require_once("letter_templates/letter17.php");
		break;
	case 18:
		require_once("letter_templates/letter18.php");
		break;
	case 19:
		require_once("letter_templates/letter19.php");
		break;
	case 20:
		require_once("letter_templates/letter20.php");
		break;
	case 21:
		require_once("letter_templates/letter21.php");
		break;
	case 22:
		require_once("letter_templates/letter22.php");
		break;
	case 23:
		require_once("letter_templates/letter23.php");
		break;
	case 24:
		require_once("letter_templates/letter24.php");
		break;
	case 25:
		require_once("letter_templates/letter25.php");
		break;
        case 99:
                require_once("letter_templates/letter99.php");
                break;
}
*/


if (!empty($altered_template) && !isset($_POST['reset_letter'])) $template = $altered_template;

?>
<form action="/manage/edit_letter.php?pid=<?=$patientid?>&lid=<?=$masterid?>&goto=<?=$_REQUEST['goto'];?><?php print ($_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
<input type="hidden" name="numletters" value="<?=$numletters?>" />
<?php
if ($_POST != array()) {
	foreach ($_POST['duplicate_letter'] as $key => $value) {
    $dupekey = $key;
  }
  // Check for updated templates
	// search and replace 1 of 2
  foreach ($letter_contacts as $key => $contact) {
		$search = array();
		$replace = array();
		$search[] = '%todays_date%';
		$replace[] = "<strong>" . $todays_date . "</strong>";
		$search[] = '%contact_salutation%';
                $replace[] = "<strong>" . $contact['salutation'] . "</strong>";
		$search[] = '%contact_fullname%';
		$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
		$search[] = '%contact_firstname%';
		$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
		$search[] = '%contact_lastname%';
		$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
		$search[] = "%salutation%";
		$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
		$search[] = '%practice%';
		$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "";	
		$search[] = '%contact_email%';
		$replace[] = "<strong>" . $letter_contacts[$key]['email'] . "</strong>";
		$search[] = '%addr1%';
		$replace[] = "<strong>" . $contact['add1'] . "</strong>";
		$search[] = '%addr2%';
		$replace[] = ($contact['add2']) ? ", <strong>" . $contact['add2'] . "</strong>" : "";
		$search[] = '%insurance_id%';
		$replace[] = "<strong>" . $patient_info['p_m_ins_id'] . "</strong>";
		$search[] = '%city%';
		$replace[] = "<strong>" . $contact['city'] . "</strong>";
		$search[] = '%state%';
		$replace[] = "<strong>" . $contact['state'] . "</strong>";
		$search[] = '%zip%';
		$replace[] = "<strong>" . $contact['zip'] . "</strong>";
		$search[] = '%referral_fullname%';
                if($contact['type']=='md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id'] ){
                        $replace[] = "<strong>you</strong>";
                }else{
                        $replace[] = $referral_fullname;
                }
                $search[] = '%by_referral_fullname%';
                if($contact['type']=='md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id'] ){
                        $replace[] = "by <strong>you</strong>";
                }else{
                        if(trim($referral_fullname)!=''){
                                $replace[] = "by ".$referral_fullname;
                        }else{
                                $replace[] = '';
                        }
                }

		$search[] = '%referral_lastname%';
		if (!empty($ref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['lastname'] . "</strong>";
		} else {
			$replace[] = "<strong>" . $pcp['lastname'] . "</strong>";
		}
		$search[] = '%referral_practice%';
		if (!empty($ref_info['md_referrals'])) {
			$replace[] = ($ref_info['md_referrals'][0]['company']) ? "<strong>" . $ref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
		} else {
			$replace[] = ($pcp['company']) ? "<strong>" . $pcp['company'] . "</strong><br />" : "";	
		}
		$search[] = '%ref_addr1%';
		if (!empty($ref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['add1'] . "</strong>";
		} else {
			$replace[] = "<strong>" . $pcp['add1'] . "</strong>";
		}
		$search[] = '%ref_addr2%';
		if (!empty($ref_info['md_referrals'])) {
			$replace[] = ($ref_info['md_referrals'][0]['add2']) ? "<strong>" . $ref_info['md_referrals'][0]['add2'] . "</strong>" : "";
		} else {
			$replace[] = ($pcp['add2']) ? "<strong>" . $pcp['add2'] . "</strong>" : "";
		}
		$search[] = '%ref_city%';
		if (!empty($ref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['city'] . "</strong>";
		} else {
			$replace[] = "<strong>" . $pcp['city'] . "</strong>";
		}
		$search[] = '%ref_state%';
		if (!empty($ref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['state'] . "</strong>";
		} else {
			$replace[] = "<strong>" . $pcp['state'] . "</strong>";
		}
		$search[] = '%ref_zip%';
		if (!empty($ref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ref_info['md_referrals'][0]['zip'] . "</strong>";
		} else {
			$replace[] = "<strong>" . $pcp['zip'] . "</strong>";
		}
		$search[] = '%ptreferral_fullname%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['salutation'] . " " . $ptref_info['md_referrals'][0]['firstname'] . " " . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
		}else{
                       $replace[] = "";
                }
		$search[] = '%ptreferral_firstname%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['firstname'] . "</strong>";
		}else{
                       $replace[] = "";
                }
		$search[] = '%ptreferral_lastname%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
		}else{
                       $replace[] = "";
                }
		$search[] = '%ptreferral_practice%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = ($ptref_info['md_referrals'][0]['company']) ? "<strong>" . $ptref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
		}else{
                       $replace[] = "";
                }
		$search[] = '%ptref_addr1%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['add1'] . "</strong>";
		}else{
                       $replace[] = "";
                }
		$search[] = '%ptref_addr2%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = ($ptref_info['md_referrals'][0]['add2']) ? "<strong>" . $ptref_info['md_referrals'][0]['add2'] . "</strong>" : "";
		}else{
                       $replace[] = "";
                } 
		$search[] = '%ptref_city%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['city'] . "</strong>";
		}else{
                       $replace[] = "";
                } 
		$search[] = '%ptref_state%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['state'] . "</strong>";
		}else{
                       $replace[] = "";
                } 
		$search[] = '%ptref_zip%';
		if (!empty($ptref_info['md_referrals'])) {
			$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['zip'] . "</strong>";
		}else{
         	       $replace[] = "";
       		} 
                $search[] = "%company%";
                $replace[] = "<strong>" . $company_info['name'] . "</strong>";
                $search[] = "%company_addr%";
                $replace[] = "<strong>" . nl2br($company_info['add1']." ".$company_info['add2']) . "<br />" . $company_info['city'] . ", " . $company_info['state'] . " " . $company_info['zip'] . "</strong>";
		$search[] = "%franchisee_fullname%";
		$replace[] = "<strong>" . $location_info['name'] . "</strong>";
		$search[] = "%franchisee_lastname%";
		$replace[] = "<strong>" . end(explode(" ", $location_info['name'])) . "</strong>";
		$search[] = "%franchisee_practice%";
		$replace[] = "<strong>" . $location_info['location'] . "</strong>";
		$search[] = "%franchisee_phone%";
		$replace[] = "<strong>" . $location_info['phone'] . "</strong>";
		$search[] = "%franchisee_addr%";
		$replace[] = "<strong>" . nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'] . "</strong>";
		$search[] = "%patient_fullname%";
		$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%patient_lastname%";
		$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%ccpatient_fullname%";
		$replace[] = ($key == 0) ? "" : "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
		$search[] = "%patient_dob%";
		$replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
		$search[] = "%patient_firstname%";
		$replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
		$search[] = "%patient_age%";
		$replace[] = "<strong>" . $patient_info['age'] . "</strong>";
		$search[] = "%patient_gender%";
		$replace[] = "<strong>" . strtolower($patient_info['gender']) . "</strong>";
		$search[] = "%His/Her%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
		$search[] = "%his/her%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
		$search[] = "%he/she%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
		$search[] = "%him/her%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "him" : "her") . "</strong>";
		$search[] = "%He/She%";
		$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
		$search[] = "%history%";
		$replace[] = "<strong>" . $history_disp . "</strong>";
                $search[] = "%historysentence%";
		if($history_disp != ''){
                	$replace[] = " with a PMH that includes <strong>" . $history_disp . "</strong>";
		}else{
			$replace[] = '';
		}
		$search[] = "%medications%";
		$replace[] = "<strong>" . $medications_disp . "</strong>";
	        $search[] = "%medicationssentence%";
        	if($medications_disp!=''){
                	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> medications include <strong>" . $medications_disp . "</strong>.";
        	}else{
                	$replace[] = "";
        	}
		$search[] = "%1st_sleeplab_name%";
		$replace[] = "<strong>" . $first_sleeplab_name . "</strong>";
		$search[] = "%2nd_sleeplab_name%";
		$replace[] = "<strong>" . $sleeplab_name . "</strong>";
		$search[] = "%type_study%";
		$replace[] = "<strong>" . $first_type_study . "</strong>";
		$search[] = "%ahi%";
		$replace[] = "<strong>" . $first_ahi . "</strong>";
		$search[] = "%diagnosis%";
		$replace[] = "<strong>" . $first_diagnosis . "</strong>";
		$search[] = "%1ststudy_date%";
		$replace[] = "<strong>" . $first_study_date . "</strong>";

                $search[] = "%completed_sleeplab_name%";
                $replace[] = "<strong>" . $completed_sleeplab_name . "</strong>";
                $search[] = "%completed_type_study%";
                $replace[] = "<strong>" . $completed_type_study . "</strong>";
                $search[] = "%completed_ahi%";
                $replace[] = "<strong>" . $completed_ahi . "</strong>";
                $search[] = "%completed_diagnosis%";
                $replace[] = "<strong>" . $completed_diagnosis . "</strong>";
                $search[] = "%completed_study_date%";
                $replace[] = "<strong>" . $completed_study_date . "</strong>";

		$search[] = "%1stRDI%";
		$replace[] = "<strong>" . $first_rdi . "</strong>";
		$search[] = "%1stRDI/AHI%";		
		$replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
		$search[] = "%1stLowO2%";
		$replace[] = "<strong>" . $first_o2nadir . "</strong>";
		$search[] = "%1stTO290%";
		$replace[] = "<strong>" . $first_o2sat90 . "</strong>";
		$search[] = "%2ndtype_study%";
		$replace[] = "<strong>" . $second_type_study . "</strong>";
		$search[] = "%2ndahi%";
		$replace[] = "<strong>" . $second_ahi . "</strong>";
		$search[] = "%2ndahisupine%";
		$replace[] = "<strong>" . $second_ahisupine . "</strong>";
		$search[] = "%2ndrdi%";
		$replace[] = "<strong>" . $second_rdi . "</strong>";
		$search[] = "%2ndO2Sat90%";
		$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
		$search[] = "%2ndstudy_date%";
		$replace[] = "<strong>" . $second_study_date . "</strong>";
		$search[] = "%2ndRDI/AHI%";
		$replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
		$search[] = "%2ndLowO2%";
		$replace[] = "<strong>" . $second_o2nadir . "</strong>";
		$search[] = "%2ndTO290%";
		$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
		$search[] = "%2nddiagnosis%";
		$replace[] = "<strong>" . $second_diagnosis . "</strong>";
		$search[] = "%delivery_date%";
		$replace[] = "<strong>" . $delivery_date . "</strong>";
		$search[] = "%dental_device%";
		$replace[] = "<strong>" . $dentaldevice . "</strong>";
		$search[] = "%1stESS%";
		$replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
		$search[] = "%1stSnoring%";
		$replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
		$search[] = "%1stEnergy%";
		$replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
		$search[] = "%1stQuality%";
		$replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
		$search[] = "%2ndESS%";
		$replace[] = "<strong>" . $subj2['ep_eadd'] . "</strong>";
		$search[] = "%2ndSnoring%";
		$replace[] = "<strong>" . $subj2['ep_sadd'] . "</strong>";
		$search[] = "%2ndEnergy%";
		$replace[] = "<strong>" . $subj2['ep_eladd'] . "</strong>";
		$search[] = "%2ndQuality%";
		$replace[] = "<strong>" . $subj2['sleep_qualadd'] . "</strong>";
		$search[] = "%bmi%";
		$replace[] = "<strong>" . $bmi . "</strong>";
		$search[] = "%reason_seeking_tx%";
		$replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
        	$search[] = "%patprogress%";
        	if($contact['type']=='patient'){
                	$replace[] = "<p>At Dental Sleep Solutions we work hard to keep your doctors up-to-date on your progress in order to help you receive better, more thorough, and more accurate care from all your physicians.  We appreciate your cooperation and patronage.  Below is a copy of correspondence mailed to the treating physicians we have on file for you; this copy is being sent to you for your records:</p>";
        	}else{
                	$replace[] = '';
        	}
		$search[] = "%tyreferred%";
		if($contact['type']=='md_referral'){
                        $replace[] = "Thank you for referring <strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong> to our office for treatment with a dental sleep device.";
		}else{
			$replace[] = "Our mutual patient, <strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>, was referred to our office for treatment with a dental sleep device.";
		}
		$search[] = "%symptoms%";
		$replace[] = "<strong>" . $symptom_list . "</strong>";
		$search[] = "%nightsperweek%";
		$replace[] = "<strong>" . $followup['nightsperweek'] . "</strong>";
		$search[] = "%esstssupdate%";
        	if($followup['ep_eadd']!='' || $followup['ep_tsadd']!=''){
                	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> Epworth Sleepiness Scale / Thornton Snoring Scale has changed from <strong>" . $initess . "/" . $inittss . "</strong> to <strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>.";
        	}else{
                	$replace[] = '';
        	}
		$search[] = "%currESS/TSS%";
		$replace[] = "<strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>";
		$search[] = "%initESS/TSS%";
		$replace[] = "<strong>" . $initess . "/" . $inittss . "</strong>";
		$search[] = "%patient_email%";
		$replace[] = "<strong>" . $patient_info['email'] . "</strong>";
		$search[] = "%consult_date%";
		$replace[] = "<strong>" . $consult_date . "</strong>";
		$search[] = "%impressions_date%";
		$replace[] = "<strong>" . $impressions_date . "</strong>";
                $search[] = "%sleeplab_name%";
                $replace[] = "<strong>" . $sleeplab_name . "</strong>";
		$search[] = "%delay_reason%";
		switch ($delay['reason']) {
			case 'insurance':
				$replace[] = "<strong>insurance problems or issues</strong>";
				break;
			case 'dental work':
				$replace[] = "<strong>additional pending dental work</strong>";
				break;
			case 'deciding':
				$replace[] = "<strong>personal decision</strong>";
				break;
			case 'sleep study':
				$replace[] = "<strong>a pending sleep study</strong>";
				break;
			case 'other':
				if ($delay['description'] == '') {
					$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
				} else {
					$replace[] = "<strong>" . $delay['description'] . "</strong>";
				}
				break;
			default:
				$replace[] = "<strong>(warning: no reason has been selected)</strong>";
		}
		$search[] = "%noncomp_reason%";
		switch ($noncomp['reason']) {
			case 'pain/discomfort':
				$replace[] = "<strong>pain and/or discomfort</strong>";
				break;
			case 'lost device':
				$replace[] = "<strong>the device being lost and not replaced</strong>";
				break;
			case 'device not working':
				$replace[] = "<strong>patient claims that the device is not working properly or adequately</strong>";
				break;
			case 'other':
				if ($noncomp['description'] == '') {
					$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
				} else {
					$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
				}
				break;
			default:
				$replace[] = "<strong>(warning: no reason has been selected)</strong>";
		}
		$search[] = "%other_mds%";
		$other_mds = "";
		$count = 1;
		foreach ($md_contacts as $index => $md) {
			if ($md['type'] != "md_referral") {
				$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
				if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
					$other_mds .= $md_fullname;
					if ($count < count($contacts['mds'])) {
						$other_mds .= ",<br /> ";
					}	
					$count++;
				}
			}
		}
		$other_mds = rtrim($other_mds, ",<br /> ");
		$other_mds .= "PAT,<br />";
		$replace[] = "<strong>" . $other_mds . "</strong>";
		$search[] = "%nonpcp_mds%";
		$nonpcp_mds = "";
		$count = 1;
		foreach ($md_contacts as $index => $md) {
			if ($md['type'] != "md_referral" && $md['contacttype'] != 'Primary Care Physician') {
				$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
				if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
					$nonpcp_mds .= $md_fullname;
					if ($count < count($contacts['mds'])) {
						$nonpcp_mds .= ",<br /> ";
					}	
					$count++;
				}
			}
		}
		$nonpcp_mds = rtrim($nonpcp_mds, ",<br /> ");
		if (empty($ref_info['md_referrals'])) {
			$replace[] = "<strong>" . $nonpcp_mds . "</strong>";
		} else {
			$replace[] = "<strong>" . $other_mds . "</strong>";
		}
//print_r($_POST['letter1']);
		//$new_template[$cur_template_num] = html_entity_decode($new_template[$cur_template_num], ENT_COMPAT | ENT_QUOTES, "UTF-8");
    $new_template[$cur_template_num] = str_replace($replace, $search, $_POST['letter'.$cur_template_num]);
    // Letter hasn't been edited, but a new template exists in hidden field
 		if ($new_template[$cur_template_num] == null && $_POST['new_template'][$cur_template_num] != null) {
			$new_template[$cur_template_num] = html_entity_decode($_POST['new_template'][$cur_template_num], ENT_COMPAT | ENT_QUOTES, "UTF-8");
    }
    // Template hasn't changed
    if ($new_template[$cur_template_num] == $orig_template) {
			$new_template[$cur_template_num] = null;	
    }
    $cur_template_num++;
  }
  // Duplicate Letter Template
	if (isset($_POST['duplicate_letter']) && !$duplicated) {
		$dupe_template = $new_template[$dupekey];
    foreach ($letter_contacts as $key => $contact) {
      $new_template[$key] = $dupe_template;
    }
		$duplicated = true;
	}
	// Reset Letter
	if (isset($_POST['reset_letter'])) {
		foreach ($_POST['reset_letter'] as $key => $value) {
			$resetid = $key;
		}
		reset_letter($letterid);
		$new_template[$resetid] = null;
		?><script type="text/javascript">
			window.location=window.location;
		  </script>
		<?php
	}
}

foreach ($letter_contacts as $key => $contact) {








	// Token search and replace arrays
	// search and replace 2 of 2
	$search = array();
	$replace = array();
	$search[] = '%todays_date%';
	$replace[] = "<strong>" . $todays_date . "</strong>";
	$search[] = '%contact_salutation%';
        $replace[] = "<strong>" . $contact['salutation'] . "</strong>";
	$search[] = '%contact_fullname%';
	$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
	$search[] = '%contact_firstname%';
	$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
	$search[] = '%contact_lastname%';
	$replace[] = "<strong>" . $contact['lastname'] . "</strong>";
	$search[] = "%salutation%";
	$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
	$search[] = '%practice%';
	$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "";	
        $search[] = '%insurance_id%';
        $replace[] = "<strong>" . $patient_info['p_m_ins_id'] . "</strong>";
	$search[] = '%contact_email%';
	$replace[] = "<strong>" . $letter_contacts[$key]['email'] . "</strong>";
	$search[] = '%addr1%';
	$replace[] = "<strong>" . $contact['add1'] . "</strong>";
  $search[] = '%addr2%';
	$replace[] = ($contact['add2']) ? ", <strong>" . $contact['add2'] . "</strong>" : "";
  $search[] = '%city%';
	$replace[] = "<strong>" . $contact['city'] . "</strong>";
  $search[] = '%state%';
	$replace[] = "<strong>" . $contact['state'] . "</strong>";
  $search[] = '%zip%';
	$replace[] = "<strong>" . $contact['zip'] . "</strong>";
	$search[] = '%referral_fullname%';
                if($contact['type']=='md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id'] ){
                        $replace[] = "<strong>you</strong>";
                }else{
                        $replace[] = $referral_fullname;
                }
                $search[] = '%by_referral_fullname%';
                if($contact['type']=='md_referral' && $contact['id'] == $ref_info['md_referrals'][0]['id'] ){
                        $replace[] = "by <strong>you</strong>";
                }else{
			if(trim($referral_fullname)!=''){
                        	$replace[] = "by ".$referral_fullname;
			}else{
				$replace[] = '';
			}
                }
	$search[] = '%referral_lastname%';
	if (!empty($ref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['lastname'] . "</strong>";
	} else {
		$replace[] = "<strong>" . $pcp['lastname'] . "</strong>";
	}
	$search[] = '%referral_practice%';
	if (!empty($ref_info['md_referrals'])) {
		$replace[] = ($ref_info['md_referrals'][0]['company']) ? "<strong>" . $ref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
	} else {
		$replace[] = ($pcp['company']) ? "<strong>" . $pcp['company'] . "</strong><br />" : "";	
	}
	$search[] = '%ref_addr1%';
	if (!empty($ref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['add1'] . "</strong>";
	} else {
		$replace[] = "<strong>" . $pcp['add1'] . "</strong>";
	}
	$search[] = '%ref_addr2%';
	if (!empty($ref_info['md_referrals'])) {
		$replace[] = ($ref_info['md_referrals'][0]['add2']) ? "<strong>" . $ref_info['md_referrals'][0]['add2'] . "</strong>" : "";
	} else {
		$replace[] = ($pcp['add2']) ? "<strong>" . $pcp['add2'] . "</strong>" : "";
	}
	$search[] = '%ref_city%';
	if (!empty($ref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['city'] . "</strong>";
	} else {
		$replace[] = "<strong>" . $pcp['city'] . "</strong>";
	}
	$search[] = '%ref_state%';
	if (!empty($ref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['state'] . "</strong>";
	} else {
		$replace[] = "<strong>" . $pcp['state'] . "</strong>";
	}
	$search[] = '%ref_zip%';
	if (!empty($ref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ref_info['md_referrals'][0]['zip'] . "</strong>";
	} else {
		$replace[] = "<strong>" . $pcp['zip'] . "</strong>";
	}
		$search[] = '%ptreferral_fullname%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['salutation'] . " " . $ptref_info['md_referrals'][0]['firstname'] . " " . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
	}else{
                $replace[] = "";
        }
		$search[] = '%ptreferral_firstname%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['firstname'] . "</strong>";
	}else{
                $replace[] = "";
        }
		$search[] = '%ptreferral_lastname%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['lastname'] . "</strong>";
	}else{
                $replace[] = "";
        }
		$search[] = '%ptreferral_practice%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = ($ptref_info['md_referrals'][0]['company']) ? "<strong>" . $ptref_info['md_referrals'][0]['company'] . "</strong><br />" : "";	
	}else{
                $replace[] = "";
        }
		$search[] = '%ptref_addr1%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['add1'] . "</strong>";
	}else{
                $replace[] = "";
        }
		$search[] = '%ptref_addr2%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = ($ptref_info['md_referrals'][0]['add2']) ? "<strong>" . $ptref_info['md_referrals'][0]['add2'] . "</strong>" : "";
	}else{
                $replace[] = "";
        } 
		$search[] = '%ptref_city%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['city'] . "</strong>";
	}else{
                $replace[] = "";
        }
		$search[] = '%ptref_state%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['state'] . "</strong>";
	}else{
                $replace[] = "";
        } 
		$search[] = '%ptref_zip%';
        if (!empty($ptref_info['md_referrals'])) {
		$replace[] = "<strong>" . $ptref_info['md_referrals'][0]['zip'] . "</strong>";
	}else{
		$replace[] = "";
	} 
                $search[] = "%company%";
                $replace[] = "<strong>" . $company_info['name'] . "</strong>";
                $search[] = "%company_addr%";
                $replace[] = "<strong>" . nl2br($company_info['add1']." ".$company_info['add2']) . "<br />" . $company_info['city'] . ", " . $company_info['state'] . " " . $company_info['zip'] . "</strong>";

	$search[] = "%franchisee_fullname%";
	$replace[] = "<strong>" . $location_info['name'] . "</strong>";
	$search[] = "%franchisee_lastname%";
	$replace[] = "<strong>" . end(explode(" ", $location_info['name'])) . "</strong>";
	$search[] = "%franchisee_practice%";
	$replace[] = "<strong>" . $location_info['location'] . "</strong>";
	$search[] = "%franchisee_phone%";
	$replace[] = "<strong>" . $location_info['phone'] . "</strong>";
	$search[] = "%franchisee_addr%";
	$replace[] = "<strong>" . nl2br($location_info['address']) . "<br />" . $location_info['city'] . ", " . $location_info['state'] . " " . $location_info['zip'] . "</strong>";
	$search[] = "%patient_fullname%";
	$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%patient_lastname%";
	$replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%ccpatient_fullname%";
	$replace[] = ($key == 0) ? "" : "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
	$search[] = "%patient_dob%";
	$replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
	$search[] = "%patient_firstname%";
	$replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
	$search[] = "%patient_age%";
	$replace[] = "<strong>" . $patient_info['age'] . "</strong>";
	$search[] = "%patient_gender%";
	$replace[] = "<strong>" . strtolower($patient_info['gender']) . "</strong>";
	$search[] = "%His/Her%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
	$search[] = "%his/her%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
	$search[] = "%he/she%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
	$search[] = "%him/her%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "him" : "her") . "</strong>";
	$search[] = "%He/She%";
	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
	$search[] = "%history%";
	$replace[] = "<strong>" . $history_disp . "</strong>";
                $search[] = "%historysentence%";
                if($history_disp != ''){
                        $replace[] = " with a PMH that includes <strong>" . $history_disp . "</strong>";
                }else{
                        $replace[] = '';
                }

	$search[] = "%medications%";
	$replace[] = "<strong>" . $medications_disp . "</strong>";
        $search[] = "%medicationssentence%";
	if($medications_disp!=''){
        	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> medications include <strong>" . $medications_disp . "</strong>.";
	}else{
		$replace[] = "";
	}
	$search[] = "%sleeplab_name%";
        $replace[] = "<strong>" . $sleeplab_name . "</strong>";
	$search[] = "%1st_sleeplab_name%";
	$replace[] = "<strong>" . $first_sleeplab_name . "</strong>";
	$search[] = "%2nd_sleeplab_name%";
	$replace[] = "<strong>" . $sleeplab_name . "</strong>";
	$search[] = "%type_study%";
	$replace[] = "<strong>" . $first_type_study . "</strong>";
	$search[] = "%ahi%";
	$replace[] = "<strong>" . $first_ahi . "</strong>";
	$search[] = "%diagnosis%";
	$replace[] = "<strong>" . $first_diagnosis . "</strong>";
	$search[] = "%1ststudy_date%";
	$replace[] = "<strong>" . $first_study_date . "</strong>";
                $search[] = "%completed_sleeplab_name%";
                $replace[] = "<strong>" . $completed_sleeplab_name . "</strong>";
                $search[] = "%completed_type_study%";
                $replace[] = "<strong>" . $completed_type_study . "</strong>";
                $search[] = "%completed_ahi%";
                $replace[] = "<strong>" . $completed_ahi . "</strong>";
                $search[] = "%completed_diagnosis%";
                $replace[] = "<strong>" . $completed_diagnosis . "</strong>";
                $search[] = "%completed_study_date%";
                $replace[] = "<strong>" . $completed_study_date . "</strong>";
	$search[] = "%1stRDI%";
	$replace[] = "<strong>" . $first_rdi . "</strong>";
	$search[] = "%1stRDI/AHI%";
	$replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
	$search[] = "%1stLowO2%";
	$replace[] = "<strong>" . $first_o2nadir . "</strong>";
	$search[] = "%1stTO290%";
	$replace[] = "<strong>" . $first_o2sat90 . "</strong>";
	$search[] = "%2ndtype_study%";
	$replace[] = "<strong>" . $second_type_study . "</strong>";
	$search[] = "%2ndahi%";
	$replace[] = "<strong>" . $second_ahi . "</strong>";
	$search[] = "%2ndahisupine%";
	$replace[] = "<strong>" . $second_ahisupine . "</strong>";
	$search[] = "%2ndrdi%";
	$replace[] = "<strong>" . $second_rdi . "</strong>";
	$search[] = "%2ndO2Sat90%";
	$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
	$search[] = "%2ndstudy_date%";
	$replace[] = "<strong>" . $second_study_date . "</strong>";
	$search[] = "%2ndRDI/AHI%";
	$replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
	$search[] = "%2ndLowO2%";
	$replace[] = "<strong>" . $second_o2nadir . "</strong>";
	$search[] = "%2ndTO290%";
	$replace[] = "<strong>" . $second_o2sat90 . "</strong>";
	$search[] = "%2nddiagnosis%";
	$replace[] = "<strong>" . $second_diagnosis . "</strong>";
	$search[] = "%delivery_date%";
	$replace[] = "<strong>" . $delivery_date . "</strong>";
	$search[] = "%dental_device%";
	$replace[] = "<strong>" . $dentaldevice . "</strong>";
	$search[] = "%1stESS%";
	$replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
	$search[] = "%1stSnoring%";
	$replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
	$search[] = "%1stEnergy%";
	$replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
	$search[] = "%1stQuality%";
	$replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
	$search[] = "%2ndESS%";
	$replace[] = "<strong>" . $subj2['ep_eadd'] . "</strong>";
	$search[] = "%2ndSnoring%";
	$replace[] = "<strong>" . $subj2['ep_sadd'] . "</strong>";
	$search[] = "%2ndEnergy%";
	$replace[] = "<strong>" . $subj2['ep_eladd'] . "</strong>";
	$search[] = "%2ndQuality%";
	$replace[] = "<strong>" . $subj2['sleep_qualadd'] . "</strong>";
	$search[] = "%bmi%";
	$replace[] = "<strong>" . $bmi . "</strong>";
	$search[] = "%reason_seeking_tx%";
	$replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
	$search[] = "%patprogress%";
	if($contact['type']=='patient'){
		$replace[] = "<p>At Dental Sleep Solutions we work hard to keep your doctors up-to-date on your progress in order to help you receive better, more thorough, and more accurate care from all your physicians.  We appreciate your cooperation and patronage.  Below is a copy of correspondence mailed to the treating physicians we have on file for you; this copy is being sent to you for your records:</p>";
	}else{
		$replace[] = '';
	}
                $search[] = "%tyreferred%";
                if($contact['type']=='md_referral'){
                        $replace[] = "Thank you for referring <strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong> to our office for treatment with a dental sleep device.";
                }else{
                        $replace[] = "Our mutual patient, <strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>, was referred to our office for treatment with a dental sleep device.";
                }

	$search[] = "%symptoms%";
	$replace[] = "<strong>" . $symptom_list . "</strong>";
	$search[] = "%nightsperweek%";
	$replace[] = "<strong>" . $followup['nightsperweek'] . "</strong>";
        $search[] = "%esstssupdate%";
	if($followup['ep_eadd']!='' || $followup['ep_tsadd']!=''){	
        	$replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong> Epworth Sleepiness Scale / Thornton Snoring Scale has changed from <strong>" . $initess . "/" . $inittss . "</strong> to <strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>.";
	}else{
		$replace[] = '';
	}
	$search[] = "%currESS/TSS%";
	$replace[] = "<strong>" . $followup['ep_eadd'] . "/" . $followup['ep_tsadd'] . "</strong>";
	$search[] = "%initESS/TSS%";
	$replace[] = "<strong>" . $initess . "/" . $inittss . "</strong>";
	$search[] = "%patient_email%";
	$replace[] = "<strong>" . $patient_info['email'] . "</strong>";
	$search[] = "%consult_date%";
	$replace[] = "<strong>" . $consult_date . "</strong>";
	$search[] = "%impressions_date%";
	$replace[] = "<strong>" . $impressions_date . "</strong>";
	$search[] = "%delay_reason%";
	switch ($delay['reason']) {
		case 'insurance':
			$replace[] = "<strong>insurance problems or issues</strong>";
			break;
		case 'dental work':
			$replace[] = "<strong>additional pending dental work</strong>";
			break;
		case 'deciding':
			$replace[] = "<strong>personal decision</strong>";
			break;
		case 'sleep study':
			$replace[] = "<strong>a pending sleep study</strong>";
			break;
		case 'other':
			if ($delay['description'] == '') {
				$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
			} else {
				$replace[] = "<strong>" . $delay['description'] . "</strong>";
			}
			break;
		default:
			$replace[] = "<strong>(warning: no reason has been selected)</strong>";
	}
	$search[] = "%noncomp_reason%";
	switch ($noncomp['reason']) {
		case 'pain/discomfort':
			$replace[] = "<strong>pain and/or discomfort</strong>";
			break;
		case 'lost device':
			$replace[] = "<strong>the device being lost and not replaced</strong>";
			break;
		case 'device not working':
			$replace[] = "<strong>patient claims that the device is not working properly or adequately</strong>";
			break;
		case 'other':
			if ($noncomp['description'] == '') {
				$replace[] = "<strong>(warning: other was selected, but no info provided)</strong>";
			} else {
				$replace[] = "<strong>" . $noncomp['description'] . "</strong>";
			}
			break;
		default:
			$replace[] = "<strong>(warning: no reason has been selected)</strong>";
	}
	$search[] = "%other_mds%";
	$other_mds = "";
	$count = 1;
	foreach ($md_contacts as $index => $md) {
		if ($md['type'] != "md_referral") {
			$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
			if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
				$other_mds .= $md_fullname;
				if ($count < count($contacts['mds'])) {
					$other_mds .= ",<br /> ";
				}	
				$count++;
			}
		}
	}
	$other_mds = rtrim($other_mds, ",<br /> ");
	if($topatient && $contact['type']!='patient'){
		$other_mds .= ",<br />".$patient_info['firstname']." ".$patient_info['lastname'];
	}
	$replace[] = "<strong>" . $other_mds . "</strong>";
	$search[] = "%nonpcp_mds%";
	$nonpcp_mds = "";
	$count = 1;





	foreach ($md_contacts as $index => $md) {
		if ($md['type'] != "md_referral" && $md['contacttype'] != 'Primary Care Physician') {
			$md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
			if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
				$nonpcp_mds .= $md_fullname;
				if ($count < count($contacts['mds'])) {
					$nonpcp_mds .= ",<br /> ";
				}	
				$count++;
			}
		}
	}
	$nonpcp_mds = rtrim($nonpcp_mds, ",<br /> ");
  if (empty($ref_info['md_referrals'])) {
		$replace[] = "<strong>" . $nonpcp_mds . "</strong>";
	} else {
		$replace[] = "<strong>" . $other_mds . "</strong>";
	}
 	if ($new_template[$cur_letter_num] != null) {
	  $letter[$cur_letter_num] = str_replace($search, $replace, $new_template[$cur_letter_num]);
	} else {
	  $letter[$cur_letter_num] = str_replace($search, $replace, $template);
 	}

	$new_template[$cur_letter_num] = str_replace($search, $replace, $new_template[$cur_letter_num]);

	// Print Letter Body		

        if($status == DSS_LETTER_SEND_FAILED){
        ?>
        <div style="width: 100%; text-align: center;">Sending of letter failed. Letter was attempted to be sent to <a href="#" onclick="loadPopup('add_contact.php?ed=<?= $contact['id']; ?>'); return false;"><?= $contact['firstname'] . " " . $contact['lastname']; ?></a></div>
        <?php
        }

?>
	<div style="margin: auto; width: 95%; border: 1px solid #ccc; padding: 3px;">
		<div align="left" style="width: 40%; padding: 3px; float: left">
			Letter <?php print $cur_letter_num+1; ?> of <?php print $master_num; ?>.&nbsp;  Delivery Method: <?php print ($method ? $method : $contact['preferredcontact']); ?>
		</div>
		<div align="right" style="width:40%; padding: 3px; float: right">
		<button class="addButton" onclick="Javascript: edit_letter('letter<?=$cur_letter_num?>');return false;" >
			Edit Letter
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<!--&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_print.php?pid=<?=$_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_word.php?pid=<?=$_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
			Word Document
		</button>-->
		&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if(($method ? $method : $contact['preferredcontact'])=='fax' && $franchisee_info['use_digital_fax']!=1 && $_GET['backoffice'] != '1'){ ?>
		<input type="submit" name="send_letter[<?=$cur_letter_num?>]" class="addButton" onclick="return confirm('Warning! Digital fax is not enabled in your account. Click OK to send the letter via standard printing. To enable digital faxing for your account please contact the DSS corporate office.');" value="Send Letter" />
	<?php }else{ ?>
		<input type="submit" name="send_letter[<?=$cur_letter_num?>]" class="addButton" value="Send Letter" />
	<?php } ?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		</div>

	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<div id="letter<?=$cur_letter_num?>">
						
				<?php print html_entity_decode( preg_replace('/(&Acirc;|&nbsp;)+/i', '', htmlentities($letter[$cur_letter_num], ENT_COMPAT | ENT_IGNORE,"UTF-8")), ENT_COMPAT | ENT_IGNORE,"UTF-8"); ?>
				</div>
				<input type="hidden" name="new_template[<?=$cur_letter_num?>]" value="<?=preg_replace('/(&Acirc;|&nbsp;)+/i', '',htmlentities($letter[$cur_letter_num], ENT_COMPAT | ENT_IGNORE,"UTF-8"))?>" />
			</td>
		</tr>
	</table>
	<div style="float:left;">
		<input type="submit" style="display:none;" name="reset_letter[<?=$cur_letter_num?>]" class="addButton edit_letter<?=$cur_letter_num?>" value="Reset" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<? if(!($_GET['backoffice'] == "1" && $_SESSION['admin_access']!=1)){ ?>
		<input type="submit" name="delete_letter[<?=$cur_letter_num?>]" class="addButton" value="Delete" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<? } ?>
	</div>
        <div style="float:right;">
                <input type="submit" style="display:none;" name="save_letter[<?=$cur_letter_num?>]" class="addButton edit_letter<?=$cur_letter_num?>" value="Save Changes" />
        </div>
        <?php 
		if($username){ ?>
	<div style="clear:both; width:100%; text-align:center;">
			
		Last edited by  <?= $username; ?> on <?= date('m/d/Y h:i:s a', strtotime($edit_date)); ?>
	</div>
	 <?php } ?>
	</div>
<br><br>

	<hr width="90%" />

<br><br>

<?php
  if(!isset($letter_approve)){
    $letter_approve = false;
  }
	// Catch Post Send Submit Button and Send letters Here
if(isset($_GET['edit_send']) && $_GET['edit_send']==$cur_letter_num){
    if (count($letter_contacts) == 1) {
  		$parent = true;
    }else{
		$parent = false;
    }
 		$type = $contact['type'];
		$recipientid = $contact['id'];
		if ($_GET['backoffice'] == '1' || $_SESSION['user_type']==DSS_USER_TYPE_SOFTWARE) {
			$message = $letter[$cur_letter_num];
			$search= array("<strong>","</strong>");
			$message = str_replace($search, "", $message);	
			//$approve_id = save_letter($letterid, $parent, $type, $recipientid, $message);
			echo create_letter_pdf($letterid);
                        ?>
                                <script type="text/javascript">
                                        $(document).ready( function(){
                                        loadPopup("letter_approve.php?id=<?=$letterid; ?>&pid=<?= $_GET['pid']; ?>&backoffice=<?= $_GET['backoffice']; ?><?= ($parent)?'&parent=1':''; ?>&goto=<?= $_GET['goto']; ?>");
                                        });
                                </script>
                        <?php
			$letter_approve = true;
			/*
			$send = send_letter($letterid, $parent, $type, $recipientid, $message);
			$status = deliver_letter($send, $message);
			$sql = "SELECT send_method, pdf_path FROM dental_letters WHERE letterid = '" . $letterid . "'";
			$result = mysql_query($sql);
			$my = mysql_fetch_array($result);
			$method = $my['send_method'];
			$pdf_path = $my['pdf_path'];
			if ($method == "paper") {
			?>
				<form name="printpreview" action="/manage/print_preview.php" method="post" target="_blank">
				<input type="hidden" name="message" value="<?= htmlentities($message) ?>" />
				</form>
				
				<script type="text/javascript">
					//document.printpreview.submit();
					window.location = "letter_approve.php?id=<?=$send; ?>";
					//window.open('/manage/letterpdfs/<?php print $pdf_path; ?>', 'DSS Letter');
				</script>
			<?php
			}
			?>
                                <script type="text/javascript">
					$(document).ready( function(){
					loadPopup("letter_approve.php?id=<?=$send; ?>");
					});
                                </script>
			<?php
			$letter_sent = true;
			*/
		} else {
	    		$sentletterid = send_letter($letterid, $parent, $type, $recipientid, $new_template[$cur_letter_num]);
		
	if(!$parent){
		?>
                        <script type="text/javascript">
                                window.location=window.location;
                        </script>
		<?php
	}
		}
  }

        // Catch Post Send Submit Button and Send letters Here
  if (($_POST['send_letter'][$cur_letter_num] != null || $_POST['save_letter'][$cur_letter_num] != null) && $numletters == $_POST['numletters']) {
    if (count($letter_contacts) == 1) {
                $parent = true;
    }else{
                $parent = false;
    }
                $type = $contact['type'];
                $recipientid = $contact['id'];
		$message = $new_template[$cur_letter_num];
                        $search= array("<strong>","</strong>");
                        $message = str_replace($search, "", $message);

            $saveletterid = save_letter($letterid, $parent, $type, $recipientid, $message);
 	    $num_contacts = num_letter_contacts($_GET['lid']);
	if($_POST['send_letter'][$cur_letter_num] != null){
                        create_letter_pdf($saveletterid);
                        ?>
                                <script type="text/javascript">
                                        $(document).ready( function(){
loadPopup("letter_approve.php?id=<?=$saveletterid; ?>&pid=<?= $_GET['pid']; ?>&backoffice=<?= $_GET['backoffice']; ?><?= ($parent)?'&parent=1':''; ?>&goto=<?= $_GET['goto']; ?>");
                                        });
                                </script>
                        <?php
                        $letter_approve = true;
	}else{
                ?>
                        <script type="text/javascript">
                                window.location=window.location;
                        </script>
                <?php
	}
  }



	// Catch Post Delete Button and Delete letters Here
  if ($_POST['delete_letter'][$cur_letter_num] != null && $numletters == $_POST['numletters']) {
    if (count($letter_contacts) == 1) {
  		$parent = true;
    } else {
			$parent = false;
		}
 		$type = $contact['type'];
		$recipientid = $contact['id'];
    delete_letter($letterid, $parent, $type, $recipientid, $new_template[$cur_letter_num]);
		if ($parent) {
			if(isset($_REQUEST['goto']) && $_REQUEST['goto']!=''){
				if($_REQUEST['goto']=='flowsheet'){
					$page = 'manage_flowsheet3.php?pid='.$_GET['pid'].'&addtopat=1';
				}elseif($_REQUEST['goto']=='letter'){
                                        $page = 'dss_summ.php?sect=letters&pid='.$_GET['pid'].'&addtopat=1';
                                }elseif($_REQUEST['goto']=='new_letter'){
                                        $page = 'new_letter.php?pid='.$_GET['pid'];
                                }

                        ?>
                        <script type="text/javascript">
                                window.location = '<?= $page ?>';
                        </script>
                        <?php

			}else{
			?>
			<script type="text/javascript">
				window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
			</script>
			<?php
			}
		}else{
                        ?>
                        <script type="text/javascript">
                                window.location = window.location;
                        </script>
                        <?php

		}
	die();
    continue;
  }
?>

<?php
if ($parent && !$letter_approve) {
if(isset($_REQUEST['goto']) && $_REQUEST['goto']!=''){
                                if($_REQUEST['goto']=='flowsheet'){
                                        $page = 'manage_flowsheet3.php?pid='.$_GET['pid'].'&addtopat=1';
                                }elseif($_REQUEST['goto']=='letter'){
                                        $page = 'dss_summ.php?sect=letters&pid='.$_GET['pid'].'&addtopat=1';
                                }

                        ?>
                        <script type="text/javascript">
                                window.location = '<?= $page ?>';
                        </script>
                        <?php

                        }else{
	?>
	<script type="text/javascript">
		window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
	</script>
	<?php
			}
}
$cur_letter_num++; //increment letter num to identify next letter;
continue;

} // End foreach loop through letters


?>
</form>
<?php


} // END MASTER LOOP
?>
			</div>
		</td>
	</tr>
</table>

<!-- include footer -->

<?php

function is_physician($id){
  $sql = "SELECT physician FROM dental_contacttype where contacttypeid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
  return $r['physician'] == 1;
}


if($_GET['backoffice'] == '1') {
  include 'admin/includes/bottom.htm';
?>
<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
<?php
} else {
	include 'includes/bottom.htm';

} 
?>
