<?php

$sql = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);

$pid = $_GET['pid'];
$itype_sql = "select * from dental_q_image where imagetypeid=4 AND patientid=".$pid." ORDER BY adddate DESC LIMIT 1";
$itype_my = mysql_query($itype_sql);
$num_face = mysql_num_rows($itype_my);

if ($num_face!=0) {
    while($image = mysql_fetch_array($itype_my)) {
        echo "<img src='/manage/admin/display_file.php?type=image&f=".$image['image_file']."' width='150' style='float:right;' />";
    }
}

$sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

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

$sqlex = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
$myex = mysql_query($sqlex);
$myarrayex = mysql_fetch_array($myex);

/**
 * TODO: Variables with the same names!
 */
$i_opening_from = st($myarrayex['i_opening_from']);
$protrusion_from = st($myarrayex['protrusion_from']);
$protrusion_to = st($myarrayex['protrusion_to']);
$protrusion_equal = st($myarrayex['protrusion_equal']);
$r_lateral_from = st($myarrayex['r_lateral_from']);
$l_lateral_from = st($myarrayex['l_lateral_from']);

$imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".mysql_real_escape_string($_GET['pid'])."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
$imp_q = mysql_query($imp_s);
$imp_r = mysql_fetch_assoc($imp_q);

if (mysql_num_rows($imp_q) > 0) {
    $dentaldevice = st($imp_r['device_id']);
    $dentaldevice_date = st(($imp_r['date_completed']!='')?date('m/d/Y', strtotime($imp_r['date_completed'])):'');
}
else {
    $dentaldevice = st($myarrayex['dentaldevice']);
    $dentaldevice_date = st(($myarrayex['dentaldevice_date']!='')?date('m/d/Y', strtotime($myarrayex['dentaldevice_date'])):'');
}

$sqls = "select * from dental_summary where patientid='".$_GET['pid']."'";
$mys = mysql_query($sqls);
$myarrays = mysql_fetch_array($mys);
$initial_device_titration_1 = $myarrays['initial_device_titration_1'];
$initial_device_titration_equal_h = $myarrays['initial_device_titration_equal_h'];
$initial_device_titration_equal_v = $myarrays['initial_device_titration_equal_v'];
$optimum_echovision_ver = $myarrays['optimum_echovision_ver'];
$optimum_echovision_hor = $myarrays['optimum_echovision_hor'];

?>
<h2>
    <?php
    
    if ($r['preferred_name']!='') {
        echo $r['preferred_name']." - "; 
    }
    else {
        echo $r['firstname'] ." - ";
    } ?>
    <small>
        <?php
        
        $diff = abs(strtotime(date('Y-m-d')) - strtotime($r['dob']));
        $years = floor($diff / (365*60*60*24));
        
        echo $years . " years old";
        
        ?>
    </small>
</h2>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="dental_device" class="col-md-3 control-label">DOB:</label>
            <div class="col-md-9">
                <?= ($r['dob']!='')?date('m/d/Y', strtotime($r['dob'])):'';?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="dental_device" class="col-md-3 control-label">Device:</label>
            <div class="col-md-9">
                <select id="dental_device" name="dentaldevice" class="form-control">
                    <option value=""></option>
                    <?php
                    
                    $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                    $device_my = mysql_query($device_sql);
                    
                    while ($device_myarray = mysql_fetch_array($device_my)) { ?>
                        <option <?= ($device_myarray['deviceid']==$dentaldevice)?'selected="selected"':''; ?>value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>

<?php

$imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='".mysql_real_escape_string($_GET['pid'])."' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
$imp_q = mysql_query($imp_s);
$imp_r = mysql_fetch_assoc($imp_q);

?>

<?php if ($imp_r['segmentid']=='4') { ?>
    <div class="alert alert-info text-center">
        Not delivered. Impressions taken <?= ($imp_r['date_completed'])?date('m/d/Y',strtotime($imp_r['date_completed'])):''; ?>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="dental_device_date" class="col-md-3 control-label">Date:</label>
                <div class="input-append datepicker input-group date col-md-9" data-date-format="mm/dd/yyyy">
                    <input id="dental_device_date"  class="form-control text-center" type="text" name="dentaldevice_date" value="<?= $dentaldevice_date; ?>">
                    <span class="input-group-addon add-on">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 control-label">Duration:</label>
                <div class="col-md-9">
                    <?php if ($dentaldevice_date!='') { ?>
                        (<?= time_ago_format(date('U') - strtotime($dentaldevice_date)); ?>)
                    <?php } else { ?>
                        (N/A)
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php

$last_sql = "SELECT last_visit, last_treatment FROM dental_patient_summary WHERE pid='".mysql_real_escape_string($_GET['pid'])."'";
$last_sql = "SELECT * FROM dental_flow_pg2_info WHERE appointment_type=1 AND patientid = '".$_GET['pid']."' ORDER BY date_completed DESC, id DESC;";
$last_q = mysql_query($last_sql);
$last_r = mysql_fetch_assoc($last_q);

?>

<div class="row">
    <div class="col-md-6">
        <h4>Contact</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Name:</strong>
                <?= $r['firstname']; ?>
                <?= $r['lastname']; ?>
            </li>
            <li class="list-group-item">
                <strong>H)</strong>
                <?= $r['home_phone']; ?>
            </li>
            <li class="list-group-item">
                <strong>C)</strong>
                <?= $r['cell_phone']; ?>
            </li>
            <li class="list-group-item">
                <strong>W)</strong>
                <?= $r['work_phone']; ?>
            </li>
        </ul>
        
        <h4>Complaints</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Reason for seeking tx:</strong>
                <?php
                
                $c_sql = "SELECT chief_complaint_text from dental_q_page1 WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
                $c_q = mysql_query($c_sql);
                $c_r = mysql_fetch_assoc($c_q);
                
                echo $c_r['chief_complaint_text'];
                
                if ($complaintid <> '') {
                    $comp_arr1 = split('~',$complaintid);
                    
                    foreach ($comp_arr1 as $i => $val) {
                        $comp_arr2 = explode('|',$val);
                        $compid[$i] = $comp_arr2[0];
                        $compseq[$i] = $comp_arr2[1];
                    }
                }
                
                ?>
            </li>
        </ul>
        
        <?php if ($complaintid != '' || in_array('0', $compid)) { ?>
            <h4>Other Complaints</h4>
            <ul class="list-group">
                <?php
                
                if ($complaintid != '') {
                    $complaint_sql = "select * from dental_complaint where status=1 order by sortby";
                    $complaint_my = mysql_query($complaint_sql);
                    $complaint_number = mysql_num_rows($complaint_my);
                    
                    while ($complaint_myarray = mysql_fetch_array($complaint_my)) {
                        if (@array_search($complaint_myarray['complaintid'],$compid) === false) {
                            $chk = '';
                        }
                        else {
                            #     $chk = ($compseq[@array_search($complaint_myarray['complaintid'],$compid)])?1:0;
                            ?>
                            <li class="list-group-item"><?= $complaint_myarray['complaint']; ?></li>
                            <?php
                        }
                    }
                }
                
                if ($other_complaint != '' && in_array('0', $compid)) { ?>
                    <li class="list-group-item"><?= $other_complaint; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        
        <h4>Partners</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Bed Partner:</strong>
                <?php echo $bed_time_partner ?>
            </li>
            <li class="list-group-item">
                <strong>Same room:</strong>
                <?php echo $sleep_same_room; ?>
            </li>
            <?php if ($quit_breathing != '') { ?>
                <li class="list-group-item">
                    How many times per night does your bedtime partner notice you quit breathing?
                    <?= $quit_breathing;?>
                </li>
            <? } ?>
        </ul>
        
        <h4>History</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <p>
                    <strong>ROM</strong>
                </p>
                <table class="table table-condensed">
                    <tr>
                        <th>Vertical</th>
                        <td><?php echo ($i_opening_from ? $i_opening_from : 0) ?>mm</td>
                        <th>Left</th>
                        <td><?php echo ($l_lateral_from ? $l_lateral_from : 0) ?>mm</td>
                        <th>Right</th>
                        <td><?php echo ($r_lateral_from ? $r_lateral_from : 0) ?>mm</td>
                    </tr>
                </table>
            </li>
            <li class="list-group-item">
                <p>
                    <strong>Best Eccovision</strong>
                </p>
                <table class="table table-condensed">
                    <tr>
                        <th>Horizontal</th>
                        <td><?php echo ($optimum_echovision_hor ? $optimum_echovision_hor : 0) ?>mm</td>
                        <th>Vertical</th>
                        <td><?php echo ($optimum_echovision_ver ? $optimum_echovision_ver : 0) ?>mm</td>
                    </tr>
                </table>
            </li>
            <?php if ($ess != '') { ?>
                <li class="list-group-item">
                    <strong>Baseline Epworth Sleepiness Score:</strong>
                    <?= $ess; ?>
                </li>
            <?php } ?>
            <?php if ($tss != '') { ?>
                <li class="list-group-item">
                    <strong>Baseline Thornton Snoring Scale:</strong>
                    <?= $tss; ?>
                </li>
            <?php } ?>
            <li class="list-group-item">
                <strong>History of Surgery or other Treatment Attempts:</strong>
                <p>
                    <?=$other_therapy_att;?>
                </p>
            </li>
        </ul>
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
    
    <div class="col-md-6">
        <h4>Appt:</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Last seen:</strong>
                <?php if ($last_r['date_completed']!='') { ?>
                    <?= time_ago_format(date('U')-strtotime($last_r['date_completed'])); ?> ago - 
                    <?= ($last_r['date_completed']!='')?date('m/d/Y', strtotime($last_r['date_completed'])):''; ?>
                <?php } ?>
            </li>
            <li class="list-group-item">
                <strong>For:</strong>
                <?= ($last_r['segmentid']!='')?$segments[$last_r['segmentid']]:''; ?>
            </li>
            <li class="list-group-item">
                <strong>Next appt:</strong>
                <?php
                
                $next_sql = "SELECT date_scheduled, segmentid FROM dental_flow_pg2_info WHERE appointment_type=0 AND patientid='".mysql_real_escape_string($_GET['pid'])."' ORDER BY date_scheduled DESC";
                $next_q = mysql_query($next_sql);
                $next_r = mysql_fetch_assoc($next_q);
                
                ?>
                <?= $segments[$next_r['segmentid']]; ?> - <?= ($next_r['date_scheduled']!=''&&$next_r['date_scheduled']!='0000-00-00')?date('m/d/Y', strtotime($next_r['date_scheduled'])):''; ?>
            </li>
            <li class="list-group-item">
                <strong>Referred By:</strong> 
                <?php
                
                $rs = $r['referred_source'];
                
                if ($rs == DSS_REFERRED_PHYSICIAN) {
                    $referredby_sql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                        LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE dc.status=1 AND contactid='".st($r['referred_by'])."'";
                    
                    $referredby_my = mysql_query($referredby_sql);
                    $referredby_myarray = mysql_fetch_array($referredby_my);
                    $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
                    $referredbythis .= " - ". $referredby_myarray['contacttype'];
                    
                    echo $referredbythis;
                }
                else if ($rs == DSS_REFERRED_PATIENT) {
                    $referredby_sql = "select * from dental_patients where patientid='".st($pat_myarray['referred_by'])."'";
                    $referredby_my = mysql_query($referredby_sql);
                    $referredby_myarray = mysql_fetch_array($referredby_my);
                    $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
                    
                    echo $referredbythis ." - Patient";
                }
                else {
                    echo $dss_referred_labels[$rs].": ".$r['referred_notes'];
                }
                
                ?>
            </li>
        </ul>
        
        
        <?php
        
        $baseline_sleepstudies = "SELECT ss.*, d.ins_diagnosis, d.description
            FROM dental_summ_sleeplab ss
            JOIN dental_patients p on ss.patiendid=p.patientid
            LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
            WHERE (
                p.p_m_ins_type!='1'
                OR (
                    (
                        ss.diagnosising_doc IS NOT NULL
                        AND ss.diagnosising_doc != ''
                    )
                    AND (
                        ss.diagnosising_npi IS NOT NULL
                        AND ss.diagnosising_npi != ''
                    )
                )
            )
            AND (
                ss.diagnosis IS NOT NULL
                AND ss.diagnosis != ''
            )
            AND ss.filename IS NOT NULL
            AND (
                ss.sleeptesttype='PSG Baseline'
                OR ss.sleeptesttype='HST Baseline'
            )
            AND ss.patiendid = '" . $_GET['pid'] . "'
            ORDER BY ss.date DESC;";
        
        $baseline_result = mysql_query($baseline_sleepstudies);
        $baseline_numsleepstudy = mysql_num_rows($baseline_result);
        $baseline_sleepstudy = mysql_fetch_assoc($baseline_result);
        
        if ($baseline_numsleepstudy <= 0) {
            $sleepstudies = "SELECT ss.*, d.ins_diagnosis, d.description
                FROM dental_summ_sleeplab ss
                JOIN dental_patients p on ss.patiendid=p.patientid
                LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
                WHERE (
                    p.p_m_ins_type!='1'
                    OR (
                        (
                            ss.diagnosising_doc IS NOT NULL
                            AND ss.diagnosising_doc != ''
                        )
                        AND (
                            ss.diagnosising_npi IS NOT NULL
                            AND ss.diagnosising_npi != ''
                        )
                    )
                )
                AND (
                    ss.diagnosis IS NOT NULL
                    AND ss.diagnosis != ''
                )
                AND ss.filename IS NOT NULL
                AND (
                    ss.sleeptesttype='PSG'
                    OR ss.sleeptesttype='HST'
                )
                AND ss.patiendid = '" . $_GET['pid'] . "'
                ORDER BY ss.id ASC;";
            
            $result = mysql_query($sleepstudies);
            $numsleepstudy = mysql_num_rows($result);
            $baseline_sleepstudy = mysql_fetch_assoc($result);
        }
        
        ?>
        <h4>Sleep Tests</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Baseline Sleep Test?:</strong>
                <?= ($baseline_numsleepstudy > 0)?'Yes':'No'; ?>
            </li>
            <li class="list-group-item">
                <strong>Type:</strong>
                <?= $baseline_sleepstudy['sleeptesttype']; ?>
	            <?php if ($baseline_sleepstudy['filename'] != '') { ?>
	                - <a href="/manage/admin/display_file.php?f=<?= $baseline_sleepstudy['filename'];?>" target="_blank">View Study</a>
	           <?php } ?>
	        </li>
            <li class="list-group-item">
                <strong>Most Recent:</strong>
                <? if ($baseline_sleepstudy['date'] != '') { ?>
                    <?= time_ago_format(date('U')-strtotime($baseline_sleepstudy['date'])); ?> ago - <?= date('m/d/Y', strtotime($baseline_sleepstudy['date'])); ?>
                <?php } ?>
            </li>
            <li class="list-group-item">
                <p>
                    <strong>Diagnosis:</strong>
                    <?= $baseline_sleepstudy['ins_diagnosis']." - ".$baseline_sleepstudy['description']; ?>
                </p>
                <table class="table table-condensed">
                    <tr>
                        <th>AHI/RDI:</th>
                        <td>
                            <?= $baseline_sleepstudy['ahi']; ?>/<?= $baseline_sleepstudy['rdi']; ?>
                        </td>
                        <th>Low O2:</th>
                        <td>
                            <?= $baseline_sleepstudy['o2nadir']; ?>
                        </td>
                        <th>T &lt; 90%:</th>
                        <td>
                            <?= $baseline_sleepstudy['t9002']; ?>
                        </td>
                    </tr>
                </table>
            </li>
        </ul>
        
        <?php
        
        $sleepstudies = "SELECT ss.*, d.ins_diagnosis, d.description
            FROM dental_summ_sleeplab ss
            JOIN dental_patients p on ss.patiendid=p.patientid
            LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
            WHERE (
                p.p_m_ins_type!='1'
                OR (
                    (
                        ss.diagnosising_doc IS NOT NULL
                        AND ss.diagnosising_doc != ''
                    )
                    AND (
                        ss.diagnosising_npi IS NOT NULL
                        AND ss.diagnosising_npi != ''
                    )
                )
            )
            AND (
                ss.diagnosis IS NOT NULL
                AND ss.diagnosis != ''
            )
            AND ss.filename IS NOT NULL
            AND (
                ss.sleeptesttype!='PSG'
                AND ss.sleeptesttype!='HST'
                AND ss.sleeptesttype!='PSG Baseline'
                AND ss.sleeptesttype!='HST Baseline'
            )
            AND ss.patiendid = '" . $_GET['pid'] . "'
            ORDER BY ss.date DESC;";
        
        $result = mysql_query($sleepstudies);
        $numsleepstudy = mysql_num_rows($result);
        $sleepstudy = mysql_fetch_assoc($result);
        
        ?>
        <h4>Recent Titration</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Type:</strong>
                <?= $sleepstudy['sleeptesttype']; ?>
                <?php if ($sleepstudy['filename']!='') { ?>
                    - <a href="/manage/admin/display_file.php?f=<?= $sleepstudy['filename'];?>" target="_blank">View Study</a>
                <?php } ?>
            </li>
            <li class="list-group-item">
                <strong>Most Recent:</strong>
                <? if ($sleepstudy['date']!='') { ?>
                    <?= time_ago_format(date('U')-strtotime($sleepstudy['date'])); ?> ago - <?= date('m/d/Y', strtotime($sleepstudy['date'])); ?>
                <?php } ?>
            </li>
            <li class="list-group-item">
                <p>
                    <strong>Diagnosis:</strong>
                    <?= $sleepstudy['ins_diagnosis']." - ".$sleepstudy['description']; ?>
                </p>
                <table class="table table-condensed">
                    <tr>
                        <th>AHI/RDI:</th>
                        <td>
                            <?= $sleepstudy['ahi']; ?>/<?= $sleepstudy['rdi']; ?>
                        </td>
                        <th>Low O2:</th>
                        <td>
                            <?= $sleepstudy['o2nadir']; ?>
                        </td>
                        <th>T &lt; 90%:</th>
                        <td>
                            <?= $sleepstudy['t9002']; ?>
                        </td>
                    </tr>
                </table>
            </li>
        </ul>
        
        <?php
        
        $pat_sql = "select cpap from dental_q_page2 where patientid='".s_for($_GET['pid'])."'";
        $pat_my = mysql_query($pat_sql);
        $pat_myarray = mysql_fetch_array($pat_my);
        
        $sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
        $my = mysql_query($sql);
        $myarray = mysql_fetch_array($my);
        
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
        
        if ($cpap == '') {
            $cpap = 'No';
        }
        
        ?>
        <h4>CPAP</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <?php if ($pat_myarray['cpap']=="No") { ?>
                    Patient has not previously attempted CPAP therapy.
                <?php } else { ?>
                    <strong>Problems with CPAP:</strong>
                    <?=$problem_cpap;?>
                <?php } ?>
            </li>
            <?php if ($polysomnographic != '') { ?>
                <li class="list-group-item">
                    <strong>Have you had a sleep study?:</strong>
                    <?= ($polysomnographic == '1')?'Yes':'No'; ?>
                </li>
            <?php } ?>
            <?php if ($polysomnographic == '1') { ?>
                <?php if ($sleep_center_name_text != '') { ?>
                    <li class="list-group-item">
                        <strong>At:</strong>
                        <?=$sleep_center_name_text;?>
                    </li>
                <?php } ?>
                <?php if ($sleep_study_on != '') { ?>
                    <li class="list-group-item">
                        <strong>Date:</strong>
                        <?=$sleep_study_on;?>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        
        <h4>CPAP Intolerance</h4>
        <ul class="list-group">
            <?php if ($cpap != '') { ?>
                <li class="list-group-item">
                    <strong>Have you tried CPAP?:</strong>
                    <?= $cpap;?>
                </li>
            <?php } ?>
            <?php if ($cur_cpap != '') {  ?>
                <li class="list-group-item">
                    <strong>Are you currently using CPAP?:</strong>
                    <?= $cur_cpap;?>
                </li>
            <?php } ?>
            <?php if ($nights_wear_cpap != '') { ?>
                <li class="list-group-item">
                    <strong>If currently using CPAP, how many nights / week do you wear it?:</strong>
                    <?=$nights_wear_cpap;?>
                </li>
            <?php } ?>
            <?php if ($percent_night_cpap != '') { ?>
                <li class="list-group-item">
                    <strong>How many hours each night do you wear it?:</strong>
                    <?=$percent_night_cpap;?>
                </li>
            <?php } ?>
            <?php if ($intolerance != '') { ?>
                <li id="cpap_options" class="list-group-item">
                    <strong>What are your chief complaints about CPAP?:</strong>
                    <p>
                        <?php
                        
                        $intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
                        $intolerance_my = mysql_query($intolerance_sql);
                        
                        while ($intolerance_myarray = mysql_fetch_array($intolerance_my)) {
                            if (strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') !== false) { ?>
                                <?=st($intolerance_myarray['intolerance']);?><br />
                            <?php }
                        } ?>
                    </p>
                </li>
            <?php } ?>
            <?php if ($other_intolerance != '') { ?>
                <li class="list-group-item">
                    <strong>Other Items:</strong>
                    <p>
                        <?=$other_intolerance;?>
                    </p>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h4>Medical Caregivers</h4>
        <div class="panel panel-default">
            <?php include dirname(__FILE__) . '/../summ_contacts.php'; ?>
        </div>
    </div>
    <div class="col-md-6">
        <h4>Notes/Personal</h4>
        <div class="well">
            <?php include dirname(__FILE__) . '/../dss_notes.php'; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#notecontent input').change(function(){
        window.onbeforeunload = function(){
            return 'You have made changes to Notes/Personal and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
        }
    });
    
    $('#rom_form input').change(function(){
        window.onbeforeunload = function(){
            return 'You have made changes to ROM data and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
        }
    });
});

<?php if ($sect == 'summ') { ?>
function check_georges (f) {
    var to = f.ir_min.value;
    var from = f.ir_max.value;
    
    if (to != ''  && from != '') {
        alert("This number will be updated automatically when you adjust the 'George Scale' values.");
    }
}

function checkIncisal () {
    min = Number($('#ir_min').val());
    max = Number($('#ir_max').val());
    range = (max-min);
    
    $('#ir_range').val(range);
    
    pos = Number($('#i_pos').val());
    dist = Math.abs(pos-min);
    perc = (dist/range);
    
    $('#initial_device_titration_equal_h').val(Math.round(dist));
    $('#i_perc').val(Math.round(perc*100));
    
    if (min != '' && max != '') {
        if ((range) < 0) {
            alert('Minimum must be less than maximum');
            $('#ir_min').focus();
            return false;
        }
        
        if (pos<min || pos>max) {
            alert('Incisal Position value must be between minimum and maximum range.');
            $('#i_pos').focus();
            return false;
        }
    }
    
    return true;
}
<?php } ?>
</script>

<form id="rom_form" action="" method="POST">
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <p>
                        <strong>ROM</strong>
                    </p>
                    <table class="table">
                        <tr>
                            <th>Vertical</th>
                            <th>Left</th>
                            <th>Right</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="r_lateral_from" class="form-control text-right" value="<?php echo $r_lateral_from; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="r_lateral_from" class="form-control text-right" value="<?php echo $r_lateral_from; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="r_lateral_from" class="form-control text-right" value="<?php echo $r_lateral_from; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
                <li class="list-group-item">
                    <p>
                        <strong>Best Eccovision</strong>
                    </p>
                    <table class="table">
                        <tr>
                            <th>Horizontal</th>
                            <th>Vertical</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="optimum_echovision_hor" class="form-control text-right" value="<?php echo $optimum_echovision_hor; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="optimum_echovision_ver" class="form-control text-right" value="<?php echo $optimum_echovision_ver; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <p>
                        <strong>Incisal Edge</strong>
                    </p>
                    <table class="table">
                        <tr>
                            <th>Range</th>
                            <th>Minimum</th>
                            <th>Maximum</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="ir_range" id="ir_range" class="form-control text-right" onkeyup="check_georges(this.form);" value="<?php echo $protrusion_equal; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="ir_min" id="ir_min" class="form-control text-right" onchange="checkIncisal()" value="<?php echo $protrusion_from; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="ir_max" id="ir_max" class="form-control text-right" onchange="checkIncisal()" value="<?php echo $protrusion_to; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
                <li class="list-group-item">
                    <p>
                        <strong>Initial Device Setting</strong>
                    </p>
                    <table class="table">
                        <tr>
                            <th>Incisal Position</th>
                            <th>Vertical</th>
                            <th width="45%">Distance from Minimum Range</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="initial_device_titration_1" id="i_pos" class="form-control text-right" onchange="checkIncisal();" value="<?php echo $initial_device_titration_1; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="initial_device_titration_equal_v" id="initial_device_titration_equal_v" class="form-control text-right" onchange="checkIncisal()" value="<?php echo $initial_device_titration_equal_v; ?>" />
                                    <span class="input-group-addon">
                                        mm
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="initial_device_titration_equal_h" id="initial_device_titration_equal_h" class="form-control text-right" onchange="checkIncisal()" disabled value="<?php echo $initial_device_titration_equal_h; ?>" />
                                    <span class="input-group-addon">
                                        mm:
                                    </span>
                                    <input type="text" name="i_perc" id="i_perc" class="form-control text-right" disabled value="<?php echo $initialdevsettingp; ?>" />
                                    <span class="input-group-addon">
                                        %
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
            </ul>
        </div>
    </div>
    <p class="text-center">
        <input type="submit" name="device_submit" value="Save" class="btn btn-primary">
    </p>
</form>
