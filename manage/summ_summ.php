<?php namespace Ds3\Libraries\Legacy; ?><?php
$sql = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
$r = $db->getRow($sql);

$pid = (!empty($_GET['pid']) ? $_GET['pid'] : '');
$itype_sql = "select * from dental_q_image where imagetypeid=4 AND patientid=".$pid." ORDER BY adddate DESC LIMIT 1";
$itype_my = $db->getResults($itype_sql);
$num_face = count($itype_my);

if($num_face==0){ ?>
    <a href="#" style="float:right;" onclick="loadPopup('add_image.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sh=<?php echo (!empty($_GET['sh']) ? $_GET['sh'] : '');?>&it=4&return=patinfo&return_field=profile');return false;" >
        <img src="images/add_patient_photo.png" />
    </a>
<?php 
}else{
    foreach ($itype_my as $image) {
        echo "<img src='display_file.php?f=".$image['image_file']."' width='150' style='float:right;' />";
    }
}

$sql = "select * from dental_q_page1 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarray = $db->getRow($sql);

$q_page1id = st($myarray['q_page1id']);
$exam_date = st($myarray['exam_date']);
$ess = st($myarray['ess']);
$tss = st($myarray['tss']);
$chief_complaint_text = st($myarray['chief_complaint_text']);
$complaintid = st($myarray['complaintid']);
$other_complaint = st($myarray['other_complaint']);
$additional_paragraph = st($myarray['additional_paragraph']);
$energy_level = st($myarray['energy_level']);
$snoring_sound = st($myarray['snoring_sound']);
$wake_night = st($myarray['wake_night']);
$breathing_night = st($myarray['breathing_night']);
$morning_headaches = st($myarray['morning_headaches']);
$hours_sleep = st($myarray['hours_sleep']);
$quit_breathing = st($myarray['quit_breathing']);
$bed_time_partner = st($myarray['bed_time_partner']);
$sleep_same_room = st($myarray['sleep_same_room']);
$told_you_snore = st($myarray['told_you_snore']);
$main_reason = st($myarray['main_reason']);
$main_reason_other = st($myarray['main_reason_other']);
$sleep_qual = st($myarray['sleep_qual']);

if(isset($_POST['device_submit'])){
    $sql = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
    $row = $db->getRow($sql);
    if($_POST['ir_max'] !='' && $_POST['ir_min'] != ''){
        $ir_range = abs($_POST['ir_max'] - $_POST['ir_min']);
    }else{
        $ir_range = $_POST['ir_range'];
    }
    if($row){
        $ex_ed_sql = " update dental_ex_page5 set 
                        protrusion_from = '".s_for($_POST['ir_min'])."',
                        protrusion_to = '".s_for($_POST['ir_max'])."',
                        protrusion_equal = '".s_for($ir_range)."',
                        i_opening_from = '".s_for($_POST['i_opening_from'])."',
                        l_lateral_from = '".s_for($_POST['l_lateral_from'])."',
                        r_lateral_from = '".s_for($_POST['r_lateral_from'])."'
                      where ex_page5id = '".$row['ex_page5id']."'";
        $db->query($ex_ed_sql);
    }else{
        $ex_ins_sql = " insert dental_ex_page5 set 
                          patientid = '".s_for($_GET['pid'])."',
                          protrusion_from = '".s_for($_POST['ir_min'])."',
                          protrusion_to = '".s_for($_POST['ir_max'])."',
                          protrusion_equal = '".s_for($ir_range)."',
                          i_opening_from = '".s_for($_POST['i_opening_from'])."',
                          l_lateral_from = '".s_for($_POST['l_lateral_from'])."',
                          r_lateral_from = '".s_for($_POST['r_lateral_from'])."',
                          userid = '".s_for($_SESSION['userid'])."',
                          docid = '".s_for($_SESSION['docid'])."',
                          adddate = now(),
                          ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

        $db->query($ex_ins_sql) or die($ex_ins_sql." | ".mysql_error());
    }
    $sql = "select * from dental_summary where patientid='".$_GET['pid']."'";
    $row = $db->getRow($sql);
    if(!$row){
        $ins_sql = " insert into dental_summary set 
                      patientid = '".s_for($_GET['pid'])."',
                      initial_device_titration_1 = '".s_for($_POST['initial_device_titration_1'])."',
                      initial_device_titration_equal_h = '".s_for($_POST['initial_device_titration_equal_h'])."',
                      initial_device_titration_equal_v = '".s_for($_POST['initial_device_titration_equal_v'])."',
                      optimum_echovision_ver = '".s_for($_POST['optimum_echovision_ver'])."',
                      optimum_echovision_hor = '".s_for($_POST['optimum_echovision_hor'])."',
                      userid = '".s_for($_SESSION['userid'])."',
                      docid = '".s_for($_SESSION['docid'])."',
                      adddate = now(),
                      ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
    		$db->query($ins_sql);
  	}else{
    		$ed_sql = "update dental_summary set 
                    initial_device_titration_1 = '".s_for($_POST['initial_device_titration_1'])."',
                    initial_device_titration_equal_h = '".s_for($_POST['initial_device_titration_equal_h'])."',
                    initial_device_titration_equal_v = '".s_for($_POST['initial_device_titration_equal_v'])."',
                    optimum_echovision_ver = '".s_for($_POST['optimum_echovision_ver'])."',
                    optimum_echovision_hor = '".s_for($_POST['optimum_echovision_hor'])."'
              		 where patientid = '".s_for($_GET['pid'])."'";
    		$db->query($ed_sql);
  	}
}

$sqlex = "select * from dental_ex_page5 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarrayex = $db->getRow($sqlex);

$i_opening_from = st($myarrayex['i_opening_from']);
$protrusion_from = st($myarrayex['protrusion_from']);
$protrusion_to = st($myarrayex['protrusion_to']);
$protrusion_equal = st($myarrayex['protrusion_equal']);
$r_lateral_from = st($myarrayex['r_lateral_from']);
$l_lateral_from = st($myarrayex['l_lateral_from']);

$imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
$imp_r = $db->getRow($imp_s);
if($imp_r){
    $dentaldevice = st($imp_r['device_id']);
    $dentaldevice_date = st(($imp_r['date_completed']!='')?date('m/d/Y', strtotime($imp_r['date_completed'])):'');
}else{
    $dentaldevice = st($myarrayex['dentaldevice']);
    $dentaldevice_date = st(($myarrayex['dentaldevice_date']!='')?date('m/d/Y', strtotime($myarrayex['dentaldevice_date'])):'');
}

$sqls = "select * from dental_summary where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarrays = $db->getRow($sqls);
$initial_device_titration_1 = $myarrays['initial_device_titration_1'];
$initial_device_titration_equal_h = $myarrays['initial_device_titration_equal_h'];
$initial_device_titration_equal_v = $myarrays['initial_device_titration_equal_v'];
$optimum_echovision_ver = $myarrays['optimum_echovision_ver'];
$optimum_echovision_hor = $myarrays['optimum_echovision_hor'];
?>
<div style="margin-bottom:6px">
<?php
if($r['preferred_name']!=''){
    echo $r['preferred_name']." - "; 
}else{
    echo $r['firstname'] ." - ";
}

$diff = abs(strtotime(date('Y-m-d')) - strtotime($r['dob']));
$years = floor($diff / (365*60*60*24));
echo $years ." years old";
?>
<strong>DOB:</strong> <?php echo ($r['dob']!='')?date('m/d/Y', strtotime($r['dob'])):'';?>
</div>
    <strong>Device</strong>
    <select id="dental_device" name="dentaldevice" style="width:250px">
        <option value=""></option>
<?php        
    $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
    $device_my = $db->getResults($device_sql);
    foreach ($device_my as $device_myarray) { ?>
        <option <?php echo ($device_myarray['deviceid']==$dentaldevice)?'selected="selected"':''; ?>value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
<?php } ?>
    </select>
<?php
$imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".mysqli_real_escape_string($con,$pid)."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
$imp_r = $db->getRow($imp_s);
if($imp_r['segmentid']=='4'){ ?> 
    Not delivered. Impressions taken <?php echo ($imp_r['date_completed'])?date('m/d/Y',strtotime($imp_r['date_completed'])):''; ?>
<?php 
}else{ ?>
    <strong>Date</strong> 
    <input id="dental_device_date" name="dentaldevice_date" type="text" class="calendar_device_date" value="<?php echo $dentaldevice_date; ?>" />
    <strong>Duration:</strong>
<?php
    if($dentaldevice_date!=''){ 
        // echo '(' . time_agoNaN_format(date('U') - strtotime($dentaldevice_date)) . ')';
    }else{
        echo '(N/A)';
    }
}?>
<br />
<?php
    $last_sql = "SELECT last_visit, last_treatment FROM dental_patient_summary WHERE pid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
    $last_sql = "SELECT * FROM dental_flow_pg2_info WHERE appointment_type=1 AND patientid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY date_completed DESC, id DESC;";
    $last_r = $db->getRow($last_sql);
?>
<div class="half">

<h4>Contact</h4>
<div class="box">
    <strong>Name:</strong> <?php echo $r['firstname']; ?> <?php echo $r['lastname']; ?><br />
    <strong>H)</strong> <?php echo format_phone($r['home_phone']); ?><br />
    <strong>C)</strong> <?php echo format_phone($r['cell_phone']); ?><br />
    <strong>W)</strong> <?php echo format_phone($r['work_phone']); ?><br />
</div>

<h4>Complaints</h4>
<div class="box">
    <strong>Reason for seeking tx:</strong>
<?php
$c_sql = "SELECT chief_complaint_text from dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$c_r = $db->getRow($c_sql);
echo $c_r['chief_complaint_text'];
if($complaintid <> '')
{
    $comp_arr1 = explode('~',$complaintid);
    foreach($comp_arr1 as $i => $val){
        $comp_arr2 = explode('|',$val);

        $compid[$i] = $comp_arr2[0];
        $compseq[$i] = (!empty($comp_arr2[1]) ? $comp_arr2[1] : '');
    }
} ?>
<br /><br />

<?php if(!empty($complaintid) || (!empty($compid) && is_array($compid) && in_array('0', $compid))){ ?>
    <strong>Other Complaints</strong>
    <ul>
<?php 
    if($complaintid != ''){ 
        $complaint_sql = "select * from dental_complaint where status=1 order by sortby";
        $complaint_my = $db->getResults($complaint_sql);
        $complaint_number = count($complaint_my);
        foreach ($complaint_my as $complaint_myarray) {
            if(@array_search($complaint_myarray['complaintid'],$compid) === false) {
                $chk = '';
            }else{
            #     $chk = ($compseq[@array_search($complaint_myarray['complaintid'],$compid)])?1:0;
            ?>
        <li><?php echo $complaint_myarray['complaint']; ?></li>
          <?php
            }
        }
    }
    if($other_complaint != '' && in_array('0', $compid)){ ?>
        <li><?php echo $other_complaint; ?></li>
<?php 
    } ?>
    </ul>
<?php 
} ?>

    <strong>Bed Partner:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bed_time_partner ?><br />
                        &nbsp;&nbsp;
    <strong>Same room:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sleep_same_room; ?><br />
<?php if($quit_breathing != ''){ ?>
    How many times per night does your bedtime partner notice you quit breathing?
    <?php echo $quit_breathing;?>
<? } ?>

</div>

<h4>History</h4>
<div class="box">
    <strong>ROM:</strong>
    <strong>Vertical</strong>&nbsp;<?php echo $i_opening_from; ?>mm&nbsp;&nbsp;&nbsp;&nbsp; 
    <strong>Left</strong> <?php echo $l_lateral_from; ?>mm
    &nbsp;&nbsp;&nbsp;&nbsp;
    <strong>Right</strong> <?php echo $r_lateral_from; ?>mm
    <br />
    <strong>Best Eccovision</strong>&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <strong>Horizontal:</strong> <?php echo $optimum_echovision_hor; ?>mm  
     <strong>Vertical:</strong> <?php echo $optimum_echovision_ver; ?>mm
    <br >
<?php if($ess != ''){ ?>
    <strong>Baseline Epworth Sleepiness Score:</strong> <?php echo $ess; ?>
    <br />
<?php } ?>
<?php if($tss != ''){ ?>
    <strong>Baseline Thornton Snoring Scale:</strong> <?php echo $tss; ?>
<?php } ?>
    <br />
    <strong>History of Surgery or other Treatment Attempts:</strong><br />
    <?php echo (!empty($other_therapy_att) ? $other_therapy_att : '');?>
</div>

</div>

<?php
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
$segments[1] = "Initial Contact";
?>
<div class="half">
<h4>Appt:</h4>
<div class="box">
    <strong>Last seen:</strong> 
<?php
if($last_r['date_completed']!=''){ ?>
    <?php echo time_ago_format(date('U')-strtotime($last_r['date_completed'])); ?> ago - 
    <?php echo ($last_r['date_completed']!='')?date('m/d/Y', strtotime($last_r['date_completed'])):'';
} ?>
    <strong>For:</strong> 
    <?php echo (!empty($last_r['segmentid']))?$segments[$last_r['segmentid']]:''; 
$next_sql = "SELECT date_scheduled, segmentid FROM dental_flow_pg2_info WHERE appointment_type=0 AND patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ORDER BY date_scheduled DESC";
$next_r = $db->getRow($next_sql);
?>
    <br />
    <strong>Next appt:</strong>

    <?php echo (!empty($segments[$next_r['segmentid']]) ? $segments[$next_r['segmentid']] : ''); ?> - <?php echo (!empty($next_r['date_scheduled']) && $next_r['date_scheduled'] != '0000-00-00')?date('m/d/Y', strtotime($next_r['date_scheduled'])):''; ?>
    <br />
    <strong>Referred By:</strong> 
<?php
$rs = $r['referred_source'];
if($rs == DSS_REFERRED_PHYSICIAN){
    $referredby_sql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                        LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE dc.status=1 AND contactid='".st($r['referred_by'])."'";
    $referredby_myarray = $db->getRow($referredby_sql);

    $referredbythis = st((!empty($referredby_myarray['salutation']) ? $referredby_myarray['salutation'] : ''))." ".st((!empty($referredby_myarray['firstname']) ? $referredby_myarray['firstname'] : ''))." ".st((!empty($referredby_myarray['middlename']) ? $referredby_myarray['middlename'] : ''))." ".st($referredby_myarray['lastname']);
    $referredbythis .= " - ". $referredby_myarray['contacttype'];
    echo $referredbythis;
}elseif($rs == DSS_REFERRED_PATIENT){
    $referredby_sql = "select * from dental_patients where patientid='".st($pat_myarray['referred_by'])."'";
    $referredby_myarray = $db->getRow($referredby_sql);

    $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
    echo $referredbythis ." - Patient";
}else{
    echo (!empty($rs) ? $dss_referred_labels[$rs] : '').": ".$r['referred_notes'];
}?>

</div>

<h4>Sleep Tests</h4>
<div class="box">
<?php
$baseline_sleepstudies = "SELECT ss.*, d.ins_diagnosis, d.description
                            FROM dental_summ_sleeplab ss 
                            JOIN dental_patients p on ss.patiendid=p.patientid
                            LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
                            WHERE 
                              (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL AND ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL AND ss.diagnosising_npi != ''))) AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND ss.filename IS NOT NULL AND 
                              (ss.sleeptesttype='PSG Baseline' OR ss.sleeptesttype='HST Baseline') AND
                              ss.patiendid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY STR_TO_DATE(ss.date, '%m/%d/%Y') DESC;";
$baseline_sleepstudy = $db->getRow($baseline_sleepstudies);
if($baseline_sleepstudy){
}else{
    $sleepstudies = "SELECT ss.*, d.ins_diagnosis, d.description
                    FROM dental_summ_sleeplab ss 
                    JOIN dental_patients p on ss.patiendid=p.patientid
                    LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
            WHERE 
                    (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL AND ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL AND ss.diagnosising_npi != ''))) AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND ss.filename IS NOT NULL AND 
                    (ss.sleeptesttype='PSG' OR ss.sleeptesttype='HST') AND
                    ss.patiendid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY ss.id ASC;";
    $baseline_sleepstudy = $db->getRow($sleepstudies);
}?>
    <strong>Baseline Sleep Test?</strong> 
    <?php echo ($baseline_sleepstudy)?'Yes':'No'; ?>
    <br />
    <strong>Type:</strong> 
    <?php echo $baseline_sleepstudy['sleeptesttype']; ?>
<?php if($baseline_sleepstudy['filename']!=''){ ?>
	  - <a href="display_file.php?f=<?php echo $baseline_sleepstudy['filename'];?>" target="_blank">View Study</a>
<?php } ?>
  	<br />
    <strong>Most Recent:</strong> 
<?php 
if($baseline_sleepstudy['date']!=''){ ?>
    <?php echo time_ago_format(date('U')-strtotime($baseline_sleepstudy['date'])); ?> ago -
    <?php echo date('m/d/Y', strtotime($baseline_sleepstudy['date'])); ?>
<?php 
} ?>
    <br />
    <strong>Diagnosis:</strong> 
    <?php echo $baseline_sleepstudy['ins_diagnosis']." - ".$baseline_sleepstudy['description']; ?>
    <br />
    <strong>AHI/RDI:</strong> 
    <?php echo $baseline_sleepstudy['ahi']; ?>/<?php echo $baseline_sleepstudy['rdi']; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <strong>Low O2:</strong> 
    <?php echo $baseline_sleepstudy['o2nadir']; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <strong>T < 90%:</strong> 
    <?php echo $baseline_sleepstudy['t9002']; ?>
    <br />

<?php
$sleepstudies = "SELECT ss.*, d.ins_diagnosis, d.description
                  FROM dental_summ_sleeplab ss 
                  JOIN dental_patients p on ss.patiendid=p.patientid
                  LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
                  WHERE 
                  (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL AND ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL AND ss.diagnosising_npi != ''))) AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND ss.filename IS NOT NULL AND 
                  (ss.sleeptesttype!='PSG' AND ss.sleeptesttype!='HST' AND ss.sleeptesttype!='PSG Baseline' AND ss.sleeptesttype!='HST Baseline') AND
                  ss.patiendid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY ss.date DESC;";
$sleepstudy = $db->getRow($sleepstudies);?>

    <br />
    <strong>Recent Titration</strong><br />
    <strong>Type:</strong> <?php echo $sleepstudy['sleeptesttype']; ?>
<?php 
if($sleepstudy['filename']!=''){ ?>
    - <a href="display_file.php?f=<?php echo $sleepstudy['filename'];?>" target="_blank">View Study</a>
<?php 
} ?>
    <br />
    <strong>Most Recent:</strong> 
<?php 
if($sleepstudy['date']!=''){ ?>
    <?php echo time_ago_format(date('U')-strtotime($sleepstudy['date'])); ?> ago -
    <?php echo date('m/d/Y', strtotime($sleepstudy['date']));
} ?>
    <br />
    <strong>Diagnosis:</strong> 
    <?php echo $sleepstudy['ins_diagnosis']." - ".$sleepstudy['description']; ?>
    <br />
    <strong>AHI/RDI:</strong> 
    <?php echo $sleepstudy['ahi']; ?>
    /
    <?php echo $sleepstudy['rdi']; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <strong>Low O2:</strong> 
    <?php echo $sleepstudy['o2nadir']; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <strong>T < 90%:</strong> 
    <?php echo $sleepstudy['t9002']; ?>
</div>

<h4>CPAP</h4>
<div class="box">
<?php
$pat_sql = "select cpap from dental_q_page2 where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$pat_myarray = $db->getRow($pat_sql);
if($pat_myarray['cpap']=="No"){ ?>
    Patient has not previously attempted CPAP therapy.
<?php
}else{
//echo $pat_myarray['cpap'];
?>
    <label>
    <br />
    <span style="font-weight:bold;">Problems w/ CPAP</span><br />
    <?php echo (!empty($problem_cpap) ? $problem_cpap : '');?>
    </label>
<?php 
} 

$sql = "select * from dental_q_page2 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarray = $db->getRow($sql);

$q_page2id = st($myarray['q_page2id']);
$polysomnographic = st($myarray['polysomnographic']);
$sleep_center_name_text = st($myarray['sleep_center_name_text']);
$sleep_study_on = st($myarray['sleep_study_on']);
$confirmed_diagnosis = st($myarray['confirmed_diagnosis']);
$rdi = st($myarray['rdi']);
$ahi = st($myarray['ahi']);
$cpap = st($myarray['cpap']);
$cur_cpap = st($myarray['cur_cpap']);
$intolerance = st($myarray['intolerance']);
$other_intolerance = st($myarray['other_intolerance']);
$other = st($myarray['other']);
$affidavit = st($myarray['affidavit']);
$type_study = st($myarray['type_study']);
$nights_wear_cpap = st($myarray['nights_wear_cpap']);
$percent_night_cpap = st($myarray['percent_night_cpap']);
$custom_diagnosis = st($myarray['custom_diagnosis']);
$sleep_study_by = st($myarray['sleep_study_by']);
$triedquittried = st($myarray['triedquittried']);
$timesovertime = st($myarray['timesovertime']);

if($cpap == '')
    $cpap = 'No';
if($polysomnographic != ''){ ?>
    <div>
        <span>
            <strong>Have you had a sleep study</strong>
            <?php echo ($polysomnographic == '1')?'Yes':'No'; 
    if($polysomnographic == '1'){ 
        if($sleep_center_name_text != ''){ ?>
            <strong>At</strong> 
            <?php echo $sleep_center_name_text;
        }
        if($sleep_study_on != ''){ ?>
            <strong>Date</strong>
            <?php echo $sleep_study_on;
        }
    } ?>
        </span>
    </div>
<?php 
} ?>
    <label class="desc" id="title0" for="Field0">
        CPAP Intolerance
    </label>
<?php 
if($cpap != ''){ ?>
    <div>
        <span>
            <strong>Have you tried CPAP?</strong>
            <?php echo $cpap;?>
        </span>
    </div>
<?php 
}
if($cur_cpap != ''){  ?>
    <div class="cpap_options">
        <span>
            <strong>Are you currently using CPAP?</strong>
            <?php echo $cur_cpap;?>
        </span>
    </div>
<?php 
} 
if($nights_wear_cpap != ''){ ?>
    <div class="cpap_options2">
        <span>
            <strong>If currently using CPAP, how many nights / week do you wear it?</strong> 
            <?php echo $nights_wear_cpap;?>
            <br />&nbsp;
        </span>
    </div>
<?php
} 
if($percent_night_cpap != ''){ ?>
    <div class="cpap_options2">
        <span>
            <strong>How many hours each night do you wear it?</strong> 
            <?php echo $percent_night_cpap;?>
            <br />&nbsp;
        </span>
    </div>
<?php 
} 
if($intolerance != ''){ ?>
    <div id="cpap_options" class="cpap_options">
        <span>
            <strong>What are your chief complaints about CPAP?</strong>
            <br />
<?php
$intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
$intolerance_my = $db->getResults($intolerance_sql);
foreach ($intolerance_my as $intolerance_myarray) {
    if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {
    } else {
            echo st($intolerance_myarray['intolerance']);?>
            <br />
    <?php 
        }
    }?>
        </span>
    </div>
<?php 
}
if($other_intolerance != ''){ ?>
    <br />
    <div class="cpap_options">
        <span class="cpap_other_text">
            <span style="color:#000000; padding-top:0px;">
                <strong>Other Items</strong>
                <br />
            </span>
            <?php echo $other_intolerance;?>
            <br />&nbsp;
        </span>
    </div>
<?php
} ?>
</div>

</div>

<div class="clear"></div>
<h4>Medical Caregivers:</h4>
<div class="box">
<?php include 'summ_contacts.php'; ?>
</div>

<h4>Notes/Personal:</h4> 
<div class="box">
<?php include("dss_notes.php"); ?>
</div>
<br />

<script src="js/summ_summ.js" type="text/javascript"></script>

<form id="rom_form" action="" method="POST">
    <table width="100%" align="center" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0">
        <tr valign="top">
            <td width="17%" height="4">
                ROM:&nbsp;&nbsp;
            </td>
            <td colspan="2">
                Vertical&nbsp;
                <input type="text" name="i_opening_from" id="textfield11" size="5" value="<?php echo $i_opening_from; ?>" /> mm&nbsp;&nbsp;&nbsp;&nbsp; 
                Right 
                <input type="text" name="r_lateral_from" id="textfield12" size="5" value="<?php echo $r_lateral_from; ?>" />mm&nbsp;&nbsp;&nbsp;&nbsp;  
                Left 
                <input type="text" name="l_lateral_from" id="textfield13" size="5" value="<?php echo $l_lateral_from; ?>"/>mm
                &nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td width="17%" height="4">
                Incisal Edge Range:&nbsp;&nbsp;
            </td>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" onkeyup="check_georges(this.form);" name="ir_range" id="ir_range" size="5" value="<?php echo $protrusion_equal; ?>" /> mm   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Incisal Range (minimum):&nbsp;&nbsp; 
                <input type="text" name="ir_min" id="ir_min" size="5" value="<?php echo $protrusion_from; ?>" onchange="checkIncisal()" /> 
                (maximum) 
                <input type="text" name="ir_max" id="ir_max" size="5" value="<?php echo $protrusion_to; ?>" onchange="checkIncisal()"  />
            </td>
        </tr>
<?php if(!empty($sect) && $sect == 'summ'){ ?>
<script src="js/summ_summ_check.js" type="text/javascript"></script>
<?php } ?>
        <tr>
            <td width="17%" height="4">
                Best Eccovision&nbsp;&nbsp;
            </td>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Horizontal
                <input type="text" name="optimum_echovision_hor" id="optimum_echovision_hor" size="5" value="<?php echo $optimum_echovision_hor; ?>" />mm  
                Vertical
                <input type="text" name="optimum_echovision_ver" id="optimum_echovision_ver" size="5" value="<?php echo $optimum_echovision_ver; ?>" />mm
            </td>
        </tr>
        <tr>
            <td width="17%" height="4">
                Initial Device Setting&nbsp;&nbsp;
            </td>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Incisal Position 
                <input type="text" onchange="checkIncisal()" name="initial_device_titration_1" id="i_pos" size="5" value="<?php echo $initial_device_titration_1; ?>" />mm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Vertical 
                <input type="text" name="initial_device_titration_equal_v" id="initial_device_titration_equal_v" size="5" value="<?php echo $initial_device_titration_equal_v; ?>" />mm
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Distance from minimum range
                <input disabled="disabled" type="text" name="initial_device_titration_equal_h" id="initial_device_titration_equal_h" size="5" value="<?php echo $initial_device_titration_equal_h; ?>" />mm
                (<input type="text" name="i_perc" id="i_perc" size="2" disabled="disabled" value="<?php echo (!empty($initialdevsettingp) ? $initialdevsettingp : ''); ?>" />%)
            </td>
        </tr>
    </table>
    <input type="submit" name="device_submit" value="Save" />
</form>

<?php 

/*







<br /><br /><br /><br />

<table width="95%" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0" style="margin:0 auto;">
<tr>
  <td width="50%">
      <span style="width: 40%; display:block; float:left;">Preferred Name: <?php echo $r['preferred_name']; ?></span>
      <span style="width: 20%; display:block; float:left;">Age: <?php
$diff = abs(strtotime(date('Y-m-d')) - strtotime($r['dob']));

$years = floor($diff / (365*60*60*24));
		echo $years;
 ?></span>
      <span style="width: 30%; display:block; float:left;">DOB: <?php echo ($r['dob']!='')?date('m/d/Y', strtotime($r['dob'])):'';?></span>
  </td>
  <td>
      Referred By: 
    <?php
$rs = $r['referred_source'];
  if($rs == DSS_REFERRED_PHYSICIAN){
  $referredby_sql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE dc.status=1 AND contactid='".st($r['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
        $referredbythis .= " - ". $referredby_myarray['contacttype'];
  echo $referredbythis;
  }elseif($rs == DSS_REFERRED_PATIENT){
  $referredby_sql = "select * from dental_patients where patientid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
  echo $referredbythis ." - Patient";
  }else{
   echo $dss_referred_labels[$rs].": ".$r['referred_notes'];
  }
?>
<br />
<?php
// Get delivery date of Thank You letter to Referral Source
$sql = "SELECT UNIX_TIMESTAMP(delivery_date) as delivery_date FROM dental_letters WHERE templateid = '9' AND md_referral_list = '".$referred_by."' AND patientid = '".s_for($_GET['pid'])."' ORDER BY delivery_date DESC LIMIT 1;";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
  if (!empty($row['delivery_date'])) {
                $delivery_date = date('m/d/Y', $row['delivery_date']);
        } else {
                $delivery_date = null;
  }
}
?>
Thank You Sent: <?php echo $delivery_date; ?>
  </td>
  <td width="150" rowspan="3">
<?php
                                $pid = $_GET['pid'];
  $itype_sql = "select * from dental_q_image where imagetypeid=4 AND patientid=".$pid." ORDER BY adddate DESC LIMIT 1";
  $itype_my = mysql_query($itype_sql);
$num_face = mysql_num_rows($itype_my);
?>
<span style="float:right">
<?php if($num_face==0){ ?>
        <a href="#" onclick="loadPopup('add_image.php?pid=<?php echo $_GET['pid'];?>&sh=<?php echo $_GET['sh'];?>&it=4&return=patinfo&return_field=profile');return false;" >
                <img src="images/add_patient_photo.png" />
        </a>
<?php }else{
  while($image = mysql_fetch_array($itype_my)){
   echo "<img src='display_file.php?f=".$image['image_file']."' width='150' style='float:right;' />";
  }

} ?>

</td>
</tr>
<tr>
  <?php
     $last_sql = "SELECT last_visit, last_treatment FROM dental_patient_summary WHERE pid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
     $last_q = mysql_query($last_sql);
     $last_r = mysql_fetch_assoc($last_q);
?>
  <td>Last seen: <?php echo ($last_r['last_visit']!='')?date('m/d/Y', strtotime($last_r['last_visit'])):''; ?>

  For: <?php echo $last_r['last_treatment']; ?>

<?php
  $segment_query = "SELECT * FROM `flowsheet_segments` WHERE `id` = ".$row[$stepid].";";
  $segment_res = mysql_query($segment_query);
  if($segment_res){
    $segment = mysql_fetch_array($segment_res);
    print_r($segment);
  }else{
}

?>
</td>
  <td rowspan="2">Reason for Tx:
<?php
$c_sql = "SELECT chief_complaint_text from dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
$c_q = mysql_query($c_sql);
$c_r = mysql_fetch_assoc($c_q);
echo $c_r['chief_complaint_text'];

?>
</td>
</tr>
<?php
                $sleepstudies = "SELECT ss.*, d.ins_diagnosis, d.description
 				FROM dental_summ_sleeplab ss 
                                JOIN dental_patients p on ss.patiendid=p.patientid
				LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
                        WHERE 
                                (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL AND ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL AND ss.diagnosising_npi != ''))) AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND ss.filename IS NOT NULL AND ss.patiendid = '".$_GET['pid']."';";
                $result = mysql_query($sleepstudies);
                $numsleepstudy = mysql_num_rows($result);
		$sleepstudy = mysql_fetch_assoc($result); 

?>
<tr>
  <td>Sleep Test? <?php echo ($numsleepstudy > 0)?'Yes':'No'; ?>
      <br />
      Diagnosis: <?php echo $sleepstudy['ins_diagnosis']." - ".$sleepstudy['description']; ?>
      <br />
      AHI/RDI: <?php echo $sleepstudy['ahi']; ?>/<?php echo $sleepstudy['rdi']; ?>
      Low O2: <?php echo $sleepstudy['o2nadir']; ?>
      T < 90%: <?php echo $sleepstudy['t9002']; ?>


</td>
</tr>





</table>





<!-- DSS SUMM PAGE 1 -->
<?php
$patid = $_GET['pid'];
$sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);
$nights_wear_cpap = st($myarray['nights_wear_cpap']);
$percent_night_cpap = st($myarray['percent_night_cpap']);

$sql = "select * from dental_summary where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$location = st($myarray['location']);


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);
$patient_name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

$patient_dob = st($pat_myarray['dob']);

$referral_source = st($pat_myarray['referred_source']);
if(st($pat_myarray['referred_by']) != '')
{
        $referredby_sql = "select * from dental_contact where status=1 and contactid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $sleep_md = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
}

?>
<div>
<table width="95%" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0" style="margin:0 auto; <?php echo ($_GET['pg']==2)?'display:none;':''; ?>" id="hideshow1">
  <tr valign="top">
    <td width="15%" height="3">Name</td>
    <td colspan="1">
      <label>
        <strong><?php echo $patient_name; ?></strong>
<?php
$sql = "SELECT imageid FROM dental_q_image WHERE patientid='".$_GET['pid']."' AND imagetypeid=4";
$p = mysql_query($sql);
$num_face = mysql_num_rows($p);
?>
<span align="right">
<?php if($num_face==0){ ?>
        <button onclick="Javascript: loadPopup('add_image.php?pid=<?php echo $_GET['pid'];?>&sh=<?php echo $_GET['sh'];?>&it=4');" class="addButton">
                Add Patient Photo
        </button>
<?php }else{ ?>
        <button onclick="Javascript: window.location='q_image.php?pid=<?php echo $_GET['pid']; ?>&addtopat=1'" class="addButton">
                Add/Update Patient Photo
        </button>

<?php } ?>
        &nbsp;&nbsp;
</span>

      </label>
      <br />
    </td>
<?php
$loc_sql = "SELECT * FROM dental_locations WHERE docid='".$docid."'";
                $loc_q = mysql_query($loc_sql);
$num_loc = mysql_num_rows($loc_q);
$rowspan = ($num_loc > 1)?"4":"3";
?>

    <td colspan="5" rowspan="<?php echo $rowspan; ?>">

<strong><h3 style="margin-top:-5px;">Medical Caregivers:</h3></strong>
<div style="margin-left:20px;">

    <?php

        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docsleep WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Sleep MD:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }




        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docpcp WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Primary Care:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docdentist WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Dentist:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docent WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>ENT:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



        $d_sql = "SELECT c.* FROM dental_contact c INNER JOIN dental_patients p 
                ON c.contactid=p.docmdother WHERE p.patientid=".$patid;
        $d_q = mysql_query($d_sql);
        if($d = mysql_fetch_assoc($d_q)){
                echo "<label style=\"display:block;width:300px; float:left; padding-bottom:10px;\"><span style=\"width:100px; display:block; float:left;\"><strong>Other MD:</strong></span>".$d['firstname']." ".$d['lastname']."</label><br />";
        }



?>
</div>


    </td>

  </tr>

  <tr valign="top">
    <td width="15%" height="4">DOB</td>
    <td colspan="1">
      <?php echo $patient_dob; ?>
      <br />
    </td>

  </tr>
  <tr valign="top">
    <td width="15%" height="5">Referred By</td>
    <td colspan="1">



    <?php
$rs = $pat_myarray['referred_source'];
if(st($pat_myarray['referred_by']) <> '')
{
  if($rs == DSS_REFERRED_PHYSICIAN){
  $referredby_sql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE dc.status=1 AND contactid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
        $referredbythis .= " - ". $referredby_myarray['contacttype'];
  echo $referredbythis;
  }elseif($rs == DSS_REFERRED_PATIENT){
  $referredby_sql = "select * from dental_patients where patientid='".st($pat_myarray['referred_by'])."'";
        $referredby_my = mysql_query($referredby_sql);
        $referredby_myarray = mysql_fetch_array($referredby_my);

        $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
  echo $referredbythis ." - Patient";
  }else{
   echo $dss_referred_labels[$rs].": ".$pat_myarray['referred_notes'];
  }
  }else{
echo "Not Set, Please set through patient info.";
}
    ?>

      <br />
    </td>

  </tr>
<?php
if($num_loc > 1){
?>
  <tr valign="top">
    <td width="15%" height="5">Office Site</td>
    <td colspan="1">
      <?php include("dss_loc.php"); ?>
      <br />
    </td>
  </tr>
<?php } ?>
  <tr valign="top">
    <td width="15%" height="5">Reason seeking tx</td>
    <td colspan="6">
      <label>
        <textarea name="reason_seeking_tx" id="textarea" cols="68" rows="7"><?php echo $reason_seeking_tx;?></textarea>
      </label>

      </td>
  </tr>
  <tr valign="top">
   <td width="15%" height="5">CPAP</td>
    <td colspan="6">
    <div style="width:80%;">
        <?php
          $pat_sql = "select cpap from dental_q_page2 where patientid='".s_for($_GET['pid'])."'";
          $pat_my = mysql_query($pat_sql);
          $pat_myarray = mysql_fetch_array($pat_my);
          if($pat_myarray['cpap']=="No"){

            ?>Patient has not previously attempted CPAP therapy.<?php

          }else{
        //echo $pat_myarray['cpap'];
        ?>
    <label>



      <span>On average how many nights per week do you wear your CPAP?
                                                        <input type="text" style="width: 50px;" maxlength="50" value="<?php echo $nights_wear_cpap; ?>" class="field text addr tbox" name="nights_wear_cpap" id="nights_wear_cpap">
                                                        <br>
                                                </span>



      <span>
                                                        On average how many hours each night do you wear your CPAP?
                                                        <input type="text" style="width: 50px;" maxlength="50" value="<?php echo $percent_night_cpap; ?>" class="field text addr tbox" name="percent_night_cpap" id="percent_night_cpap">
                                                        <br>
                                                </span>

    <div style="height:10px;"></div>



    <span style="font-weight:bold;">Problems w/ CPAP</span><br />
        <textarea name="textarea8" id="textarea" cols="68" rows="5"><?php echo $problem_cpap;?></textarea>
      </label>


     <?php } ?>

     </div>
    </td>





  </tr>

  <tr valign="top">
    <td width="18%" height="6">Bed Partner:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $bed_time_partner ?></strong><br />
                        &nbsp;&nbsp;
                        <br /><br />
      Same room:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $sleep_same_room; ?></strong><br />
</td>
    <td colspan="6">
    History of Surgery or other Treatment Attempts:<br />
      <textarea name="history_surgery" id="textarea3" cols="45" rows="5"><?php echo $other_therapy_att;?></textarea>
      <br />
    </td>
  </tr>
  <tr>
    <td valign="top" colspan="7">Notes/Personal:


       <?php include("dss_notes.php"); ?>


      </td>
  </tr>




</table>
</div>


<!-- SUMM PAGE 2 -->
<?php
$sqlex = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
$myex = mysql_query($sqlex);
$myarrayex = mysql_fetch_array($myex);

$i_opening_from = st($myarrayex['i_opening_from']);
$protrusion_from = st($myarrayex['protrusion_from']);
$protrusion_to = st($myarrayex['protrusion_to']);
$protrusion_equals = st($myarrayex['protrusion_equal']);
$r_lateral_from = st($myarrayex['r_lateral_from']);
$l_lateral_from = st($myarrayex['l_lateral_from']);
$dentaldevice = st($myarrayex['dentaldevice']);
$dentaldevice_date = st(($myarrayex['dentaldevice_date']!='')?date('m/d/Y', strtotime($myarrayex['dentaldevice_date'])):'');
?>

<form id="form1" name="form1" method="post" action="" style="width:95%;margin:0 auto;">
  <table width="100%" align="center" border="1" bordercolor="#000000" cellpadding="7" cellspacing="0">
  <tr valign="top">
    <td width="17%" height="4">ROM:&nbsp;&nbsp;</td>
    <td colspan="2">
    Vertical&nbsp;<input type="text" name="i_opening_from" id="textfield11" size="5" value="<?php echo $i_opening_from; ?>" /> mm&nbsp;&nbsp;&nbsp;&nbsp; Right <input type="text" name="r_lateral_from" id="textfield12" size="5" value="<?php echo $r_lateral_from; ?>" />mm&nbsp;&nbsp;&nbsp;&nbsp;  Left <input type="text" name="l_lateral_from" id="textfield13" size="5" value="<?php echo $l_lateral_from; ?>"/>mm
&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>

  <tr>
  <td width="17%" height="4">Incisal Edge Range:&nbsp;&nbsp;</td>
  <td colspan="2">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input disabled="disabled" type="text" name="ir_range" id="ir_range" size="5" value="<?php echo $protrusion_to-($protrusion_from); ?>" /> mm   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Incisal Range (minimum):&nbsp;&nbsp; <input type="text" name="ir_min" id="ir_min" size="5" value="<?php echo $protrusion_from; ?>" onchange="checkIncisal()" /> (maximum) <input type="text" name="ir_max" id="ir_max" size="5" value="<?php echo $protrusion_to; ?>" onchange="checkIncisal()"  />

  </td>
  </tr>
  <tr>
  <td width="17%" height="4">Best Eccovision&nbsp;&nbsp;</td>
  <td colspan="2">
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horizontal<input type="text" name="optimum_echovision_hor" id="optimum_echovision_hor" size="5" value="<?php echo $optimum_echovision_hor; ?>" />mm  Vertical<input type="text" name="optimum_echovision_ver" id="optimum_echovision_ver" size="5" value="<?php echo $optimum_echovision_ver; ?>" />mm
  </td>
  </tr>
   <tr valign="top">
    <td height="4">
        Device
    </td>
    <td colspan="2">

    Device
        <select name="dentaldevice" style="width:250px">
        <option value=""></option>
        <?php        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                                                                $device_my = mysql_query($device_sql);
                                                                while($device_myarray = mysql_fetch_array($device_my))
                                                                {
                ?>
                                                                 <option <?php echo ($device_myarray['deviceid']==$dentaldevice)?'selected="selected"':''; ?>value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
                                                                 <?php
                                                                 }
                                                                ?>
    </select>
        Date <input id="dentaldevice_date" name="dentaldevice_date" type="text" class="calendar" value="<?php echo $dentaldevice_date; ?>" />
    </td>

  </tr>
  <tr>
  <td width="17%" height="4">Initial Device Setting&nbsp;&nbsp;</td>
  <td colspan="2">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Incisal Position <input type="text" onchange="checkIncisal()" name="initial_device_titration_1" id="i_pos" size="5" value="<?php echo $initial_device_titration_1; ?>" />mm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Vertical <input type="text" name="initial_device_titration_equal_v" id="initial_device_titration_equal_v" size="5" value="<?php echo $initial_device_titration_equal_v; ?>" />mm
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Distance from minimum range<input disabled="disabled" type="text" name="initial_device_titration_equal_h" id="initial_device_titration_equal_h" size="5" value="<?php echo $initial_device_titration_equal_h; ?>" />mm
(<input type="text" name="i_perc" id="i_perc" size="2" disabled="disabled" value="<?php echo $initialdevsettingp; ?>" />%)
  </td>
  </tr>

  </table>
  <br />

<div align="right">
<input type="hidden" name="summarysub" value="1" />
<input type="hidden" name="ed" value="<?php echo $summaryid;?>" />
    <input type="submit" name="summarybtn" onclick="return checkIncisal();" value="Save" />
</div>
</form>



<!-- TREATMENT -->


<h3>Subjective Signs/Symptoms</h3>

                    <div>
                        <span class="full">
                                <table width="100%" cellpadding="3" cellspacing="1" border="0">
                                <?php if($energy_level != ''){ ?>
                                <tr>
                                        <td valign="top" width="60%">
                                        Rate your overall energy level 0 -10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?php echo $energy_level;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($sleep_qual != ''){ ?>
                                                                <tr>
                                        <td valign="top">
                                        Rate your sleep quality 0-10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?php echo $sleep_qual;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($told_you_snore != ''){ ?>
                                                                                                <tr>
                                        <td valign="top">
                                        Have you been told you snore?
                                    </td>
                                    <td valign="top">
                                            <?php echo $told_you_snore;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($snoring_sound != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        Rate the sound of your snoring 0 -10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?php echo $snoring_sound ;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($wake_night != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        On average how many times per night do you wake up?
                                    </td>
                                    <td valign="top">
                                                <?php echo $wake_night;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($hours_sleep != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        On average how many hours of sleep do you get per night?
                                    </td>
                                    <td valign="top">
                                                <?php echo $hours_sleep;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($morning_headaches != ''){ ?>
                                                               <tr>
                                        <td valign="top">
                                        How often do you wake up with morning headaches?
                                    </td>
                                    <td valign="top">
                                            <?php echo $morning_headaches;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($bed_time_partner != ''){ ?>
                                                                                                <tr>
                                        <td valign="top">
                                        Do you have a bed time partner?
                                    </td>
                                    <td valign="top">
                                            <?php echo $bed_time_partner;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($sleep_same_room != ''){ ?>
                                                                <tr>
                                        <td valign="top">
                                        If yes do they sleep in the same room?
                                    </td>
                                    <td valign="top">
                                            <?php echo $sleep_same_room;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($quit_breathing != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        How many times per night does your bedtime partner notice you quit breathing?
                                    </td>
                                    <td valign="top">
                                            <?php echo $quit_breathing;?>
                                    </td>
                                </tr>
                                <? } ?>

                            </table>

                        </span>
                    </div>

*/ ?>
