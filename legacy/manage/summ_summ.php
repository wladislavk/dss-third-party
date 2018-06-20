<?php
namespace Ds3\Libraries\Legacy;

$pid = intval(!empty($_GET['pid']) ? $_GET['pid'] : '');
$did = intval($_SESSION['docid']);

$sql = "SELECT * FROM dental_patients where patientid='$pid' AND docid='$did'";
if (isset($db) && $db instanceof Db) {
    $r = $db->getRow($sql);
}

$itype_sql = "select * from dental_q_image where imagetypeid='4' AND patientid='$pid' ORDER BY adddate DESC LIMIT 1";
$itype_my = $db->getResults($itype_sql);
$num_face = count($itype_my);

if ($num_face == 0) { ?>
    <a href="#" style="float:right;" onclick="loadPopup('add_image.php?pid=<?= $pid ?>&sh=<?= (!empty($_GET['sh']) ? $_GET['sh'] : '');?>&it=4&return=patinfo&return_field=profile');return false;" >
        <img src="images/add_patient_photo.png" />
    </a>
<?php 
} else {
    foreach ($itype_my as $image) { ?>
        <img src="display_file.php?f=<?= $image['image_file'] ?>" width="150" style="float:right;" />
        <?php
    }
}

$sql = "select * from dental_q_page1_pivot where patientid='$pid'";
$myarray = $db->getRow($sql);

$ess = st($myarray['ess']);
$tss = st($myarray['tss']);
$complaintid = st($myarray['complaintid']);
$other_complaint = st($myarray['other_complaint']);
$quit_breathing = st($myarray['quit_breathing']);
$bed_time_partner = st($myarray['bed_time_partner']);
$sleep_same_room = st($myarray['sleep_same_room']);

if (isset($_POST['device_submit'])) {
    $sql = "select * from dental_ex_page5_pivot where patientid='$pid'";
    $row = $db->getRow($sql);
    if ($_POST['ir_max'] !='' && $_POST['ir_min'] != '') {
        $ir_range = abs($_POST['ir_max'] - $_POST['ir_min']);
    } else {
        $ir_range = $_POST['ir_range'];
    }
    if ($row) {
        $ex_ed_sql = "
            update dental_ex_page5 set 
                protrusion_from = '".$db->escape($_POST['ir_min'])."',
                protrusion_to = '".$db->escape($_POST['ir_max'])."',
                protrusion_equal = '".$db->escape($ir_range)."',
                i_opening_from = '".$db->escape($_POST['i_opening_from'])."',
                l_lateral_from = '".$db->escape($_POST['l_lateral_from'])."',
                r_lateral_from = '".$db->escape($_POST['r_lateral_from'])."'
            where ex_page5id = '".$row['ex_page5id']."'
        ";
        $db->query($ex_ed_sql);
    } else {
        $ex_ins_sql = "
            insert into dental_ex_page5 set 
                patientid = '".$db->escape($_GET['pid'])."',
                protrusion_from = '".$db->escape($_POST['ir_min'])."',
                protrusion_to = '".$db->escape($_POST['ir_max'])."',
                protrusion_equal = '".$db->escape($ir_range)."',
                i_opening_from = '".$db->escape($_POST['i_opening_from'])."',
                l_lateral_from = '".$db->escape($_POST['l_lateral_from'])."',
                r_lateral_from = '".$db->escape($_POST['r_lateral_from'])."',
                userid = '".$db->escape($_SESSION['userid'])."',
                docid = '".$db->escape($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'
        ";
        $db->query($ex_ins_sql);
    }
    $sql = "select * from dental_summary_pivot where patientid=$pid";
    $row = $db->getRow($sql);
    $initialTitration1Escaped = $db->escape($_POST['initial_device_titration_1']);
    $initialTitrationHEscaped = $db->escape($_POST['initial_device_titration_equal_h']);
    $initialTitrationVEscaped = $db->escape($_POST['initial_device_titration_equal_v']);
    $echovisionVerEscaped = $db->escape($_POST['optimum_echovision_ver']);
    $echovisionHorEscaped = $db->escape($_POST['optimum_echovision_hor']);
    if (!$row) {
        $ins_sql = " insert into dental_summary set 
            patientid = '".$db->escape($_GET['pid'])."',
            initial_device_titration_1 = '$initialTitration1Escaped',
            initial_device_titration_equal_h = '$initialTitrationHEscaped',
            initial_device_titration_equal_v = '$initialTitrationVEscaped',
            optimum_echovision_ver = '$echovisionVerEscaped',
            optimum_echovision_hor = '$echovisionHorEscaped',
            userid = '".$db->escape($_SESSION['userid'])."',
            docid = '".$db->escape($_SESSION['docid'])."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        $db->query($ins_sql);
    } else {
        $ed_sql = "update dental_summary set 
            initial_device_titration_1 = '$initialTitration1Escaped',
            initial_device_titration_equal_h = '$initialTitrationHEscaped',
            initial_device_titration_equal_v = '$initialTitrationVEscaped',
            optimum_echovision_ver = '$echovisionVerEscaped',
            optimum_echovision_hor = '$echovisionHorEscaped'
            where summaryid = {$row['summaryid']}";
        $db->query($ed_sql);
    }
}

$sqlex = "select * from dental_ex_page5_pivot where patientid='$pid'";
$myarrayex = $db->getRow($sqlex);

$i_opening_from = st($myarrayex['i_opening_from']);
$protrusion_from = st($myarrayex['protrusion_from']);
$protrusion_to = st($myarrayex['protrusion_to']);
$protrusion_equal = st($myarrayex['protrusion_equal']);
$r_lateral_from = st($myarrayex['r_lateral_from']);
$l_lateral_from = st($myarrayex['l_lateral_from']);

$imp_s = "
    SELECT * from dental_flow_pg2_info 
    WHERE (segmentid='7' OR segmentid='4') AND patientid='$pid' AND appointment_type=1 
    ORDER BY date_completed DESC, id DESC
";
$imp_r = $db->getRow($imp_s);
if ($imp_r) {
    $dentaldevice = st($imp_r['device_id']);
    $dentaldevice_date = st(($imp_r['date_completed'] != '') ? date('m/d/Y', strtotime($imp_r['date_completed'])) : '');
} else {
    $dentaldevice = st($myarrayex['dentaldevice']);
    $dentaldevice_date = st(($myarrayex['dentaldevice_date'] != '') ? date('m/d/Y', strtotime($myarrayex['dentaldevice_date'])) : '');
}

$sqls = "select * from dental_summary_pivot where patientid='$pid'";
$myarrays = $db->getRow($sqls);
$initial_device_titration_1 = $myarrays['initial_device_titration_1'];
$initial_device_titration_equal_h = $myarrays['initial_device_titration_equal_h'];
$initial_device_titration_equal_v = $myarrays['initial_device_titration_equal_v'];
$optimum_echovision_ver = $myarrays['optimum_echovision_ver'];
$optimum_echovision_hor = $myarrays['optimum_echovision_hor'];
?>
<div style="margin-bottom:6px">
    <?php
    if ($r['preferred_name'] != '') {
        echo $r['preferred_name']." - ";
    } else {
        echo $r['firstname'] ." - ";
    }
    $diff = abs(strtotime(date('Y-m-d')) - strtotime($r['dob']));
    $years = floor($diff / (365*60*60*24));
    echo $years ." years old";
    ?>
    <strong>DOB:</strong> <?= ($r['dob'] != '') ? date('m/d/Y', strtotime($r['dob'])) : ''; ?>
</div>
<strong>Device</strong>
<select id="dental_device" name="dentaldevice" style="width:250px">
    <option value=""></option>
    <?php
    $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
    $device_my = $db->getResults($device_sql);
    foreach ($device_my as $device_myarray) { ?>
        <option <?= ($device_myarray['deviceid'] == $dentaldevice) ? 'selected="selected"' : ''; ?> value="<?= st($device_myarray['deviceid']) ?>"><?= st($device_myarray['device']); ?></option>
        <?php
    } ?>
</select>
<?php
$imp_s = "SELECT * from dental_flow_pg2_info WHERE (segmentid='7' OR segmentid='4') AND patientid='$pid' AND appointment_type=1 ORDER BY date_completed DESC, id DESC";
$imp_r = $db->getRow($imp_s);
if ($imp_r['segmentid'] == '4') { ?>
    Not delivered. Impressions taken <?php echo ($imp_r['date_completed']) ? date('m/d/Y',strtotime($imp_r['date_completed'])) : ''; ?>
<?php 
} else { ?>
    <strong>Date</strong> 
    <input id="dental_device_date" name="dentaldevice_date" type="text" class="calendar_device_date" value="<?php echo $dentaldevice_date; ?>" />
    <strong>Duration:</strong>
<?php
    if ($dentaldevice_date == '') {
        echo '(N/A)';
    }
} ?>
<br />
<?php
    $last_sql = "SELECT * FROM dental_flow_pg2_info WHERE appointment_type=1 AND patientid = '$pid' ORDER BY date_completed DESC, id DESC;";
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
        $c_sql = "SELECT chief_complaint_text from dental_q_page1_pivot WHERE patientid='$pid'";
        $c_r = $db->getRow($c_sql);
        echo $c_r['chief_complaint_text'];
        if ($complaintid != '') {
            $comp_arr1 = explode('~',$complaintid);
            foreach ($comp_arr1 as $i => $val) {
                $comp_arr2 = explode('|',$val);
                $compid[$i] = $comp_arr2[0];
                $compseq[$i] = (!empty($comp_arr2[1]) ? $comp_arr2[1] : '');
            }
        } ?>
        <br /><br />

        <?php
        if (!empty($complaintid) || (!empty($compid) && is_array($compid) && in_array('0', $compid))) { ?>
            <strong>Other Complaints</strong>
            <ul>
            <?php
            if ($complaintid != '') {
                $complaint_sql = "select * from dental_complaint where status=1 order by sortby";
                $complaint_my = $db->getResults($complaint_sql);
                foreach ($complaint_my as $complaint_myarray) {
                    if (@array_search($complaint_myarray['complaintid'], $compid) !== false) {
                        ?>
                        <li><?= $complaint_myarray['complaint']; ?></li>
                        <?php
                    }
                }
            }
            if ($other_complaint != '' && in_array('0', $compid)) { ?>
                <li><?= $other_complaint; ?></li>
                <?php
            } ?>
            </ul>
        <?php
        } ?>
        <strong>Bed Partner:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?= $bed_time_partner ?><br />
                            &nbsp;&nbsp;
        <strong>Same room:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?= $sleep_same_room; ?><br />
        <?php
        if ($quit_breathing != '') { ?>
            How many times per night does your bedtime partner notice you quit breathing?
            <?= $quit_breathing; ?>
        <?php
        } ?>
    </div>

    <h4>History</h4>
    <div class="box">
        <strong>ROM:</strong>
        <strong>Vertical</strong>&nbsp;<?= $i_opening_from; ?>mm&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Left</strong> <?= $l_lateral_from; ?>mm
        &nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Right</strong> <?= $r_lateral_from; ?>mm
        <br />
        <strong>Best Eccovision</strong>&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Horizontal:</strong> <?= $optimum_echovision_hor; ?>mm
        <strong>Vertical:</strong> <?= $optimum_echovision_ver; ?>mm
        <br >
        <?php
        if ($ess != '') { ?>
            <strong>Baseline Epworth Sleepiness Score:</strong> <?= $ess; ?>
            <br />
            <?php
        }
        if ($tss != '') { ?>
            <strong>Baseline Thornton Snoring Scale:</strong> <?= $tss; ?>
            <?php
        } ?>
        <br />
        <strong>History of Surgery or other Treatment Attempts:</strong><br />
        <?= (!empty($other_therapy_att) ? $other_therapy_att : ''); ?>
    </div>
</div>

<?php
$segments = [];
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
        if ($last_r['date_completed'] != '') { ?>
            <?php echo time_ago_format(date('U')-strtotime($last_r['date_completed'])); ?> ago -
            <?php echo ($last_r['date_completed']!='')?date('m/d/Y', strtotime($last_r['date_completed'])):'';
        } ?>
        <strong>For:</strong>
        <?php echo (!empty($last_r['segmentid']))?$segments[$last_r['segmentid']]:''; ?>
        <?php
        $next_sql = "SELECT date_scheduled, segmentid FROM dental_flow_pg2_info WHERE appointment_type=0 AND patientid='$pid' ORDER BY date_scheduled DESC";
        $next_r = $db->getRow($next_sql);
        ?>
        <br />
        <strong>Next appt:</strong>

        <?= (!empty($segments[$next_r['segmentid']]) ? $segments[$next_r['segmentid']] : ''); ?> - <?= (!empty($next_r['date_scheduled']) && $next_r['date_scheduled'] != '0000-00-00') ? date('m/d/Y', strtotime($next_r['date_scheduled'])) : ''; ?>
        <br />
        <strong>Referred By:</strong>
        <?php
        $rs = $r['referred_source'];
        if ($rs == DSS_REFERRED_PHYSICIAN) {
            $referredby_sql = "SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                                WHERE dc.status=1 AND contactid='".$db->escape($r['referred_by'])."'";
            $referredby_myarray = $db->getRow($referredby_sql);

            $referredbythis = st((!empty($referredby_myarray['salutation']) ? $referredby_myarray['salutation'] : ''))." ".st((!empty($referredby_myarray['firstname']) ? $referredby_myarray['firstname'] : ''))." ".st((!empty($referredby_myarray['middlename']) ? $referredby_myarray['middlename'] : ''))." ".st($referredby_myarray['lastname']);
            $referredbythis .= " - ". $referredby_myarray['contacttype'];
            echo $referredbythis;
        } elseif ($rs == DSS_REFERRED_PATIENT) {
            $referredby_sql = "select * from dental_patients where patientid='".intval($pat_myarray['referred_by'])."'";
            $referredby_myarray = $db->getRow($referredby_sql);

            $referredbythis = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
            echo $referredbythis ." - Patient";
        } else {
            echo (!empty($rs) ? $dss_referred_labels[$rs] : '').": ".$r['referred_notes'];
        } ?>
    </div>

    <h4>Sleep Tests</h4>
    <div class="box">
        <?php
        $baseline_sleepstudies = "
            SELECT ss.*, d.ins_diagnosis, d.description
            FROM dental_summ_sleeplab ss
            JOIN dental_patients p on ss.patiendid=p.patientid
            LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
            WHERE (
                p.p_m_ins_type != '1'
                OR (
                    COALESCE(ss.diagnosising_doc, '') != ''
                    AND COALESCE(ss.diagnosising_npi, '') != ''
                )
            )
            AND COALESCE(ss.diagnosis, '') != ''
            AND ss.filename IS NOT NULL
            AND ss.sleeptesttype IN ('PSG Baseline', 'HST Baseline')
            AND ss.patiendid = '$pid'
            ORDER BY COALESCE(
                STR_TO_DATE(ss.date, '%m/%d/%Y'),
                STR_TO_DATE(ss.date, '%m/%d/%y'),
                STR_TO_DATE(ss.date, '%Y%m%d'),
                STR_TO_DATE(ss.date, '%m-%d-%Y'),
                STR_TO_DATE(ss.date, '%m-%d-%y'),
                STR_TO_DATE(ss.date, '%m%d%Y'),
                STR_TO_DATE(ss.date, '%m%d%y')
            ) DESC"
        ;
        $baseline_sleepstudy = $db->getRow($baseline_sleepstudies);
        if (!$baseline_sleepstudy) {
            $sleepstudies = "
                SELECT ss.*, d.ins_diagnosis, d.description
                FROM dental_summ_sleeplab ss 
                JOIN dental_patients p on ss.patiendid=p.patientid
                LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
                WHERE (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL AND ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL AND ss.diagnosising_npi != ''))) 
                AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '') 
                AND ss.filename IS NOT NULL 
                AND (ss.sleeptesttype='PSG' OR ss.sleeptesttype='HST') 
                AND ss.patiendid = '$pid' 
                ORDER BY ss.id ASC;"
            ;
            $baseline_sleepstudy = $db->getRow($sleepstudies);
        } ?>
        <strong>Baseline Sleep Test?</strong>
        <?php echo ($baseline_sleepstudy)?'Yes':'No'; ?>
        <br />
        <strong>Type:</strong>
        <?= $baseline_sleepstudy['sleeptesttype']; ?>
        <?php
        if ($baseline_sleepstudy['filename'] != '') { ?>
            - <a href="display_file.php?f=<?php echo $baseline_sleepstudy['filename'];?>" target="_blank">View Study</a>
            <?php
        } ?>
        <br />
        <strong>Most Recent:</strong>
        <?php
        if ($baseline_sleepstudy['date'] != '') { ?>
            <?= time_ago_format(date('U')-strtotime($baseline_sleepstudy['date'])); ?> ago -
            <?= date('m/d/Y', strtotime($baseline_sleepstudy['date'])); ?>
        <?php
        } ?>
        <br />
        <strong>Diagnosis:</strong>
        <?= $baseline_sleepstudy['ins_diagnosis']." - ".$baseline_sleepstudy['description']; ?>
        <br />
        <strong>AHI/RDI:</strong>
        <?= $baseline_sleepstudy['ahi']; ?>/<?php echo $baseline_sleepstudy['rdi']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Low O2:</strong>
        <?= $baseline_sleepstudy['o2nadir']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <strong>T < 90%:</strong>
        <?= $baseline_sleepstudy['t9002']; ?>
        <br />
        <?php
        $sleepstudies = "
            SELECT ss.*, d.ins_diagnosis, d.description
            FROM dental_summ_sleeplab ss
            JOIN dental_patients p on ss.patiendid=p.patientid
            LEFT JOIN dental_ins_diagnosis d ON d.ins_diagnosisid = ss.diagnosis
            WHERE (
                p.p_m_ins_type != '1'
                OR (
                    COALESCE(ss.diagnosising_doc, '') != ''
                    AND COALESCE(ss.diagnosising_npi, '') != ''
                )
            )
            AND COALESCE(ss.diagnosis, '') != ''
            AND ss.filename IS NOT NULL
            AND ss.sleeptesttype NOT IN ('PSG', 'HST', 'PSG Baseline', 'HST Baseline')
            AND ss.patiendid = '$pid'
            ORDER BY COALESCE(
                STR_TO_DATE(ss.date, '%m/%d/%Y'),
                STR_TO_DATE(ss.date, '%m/%d/%y'),
                STR_TO_DATE(ss.date, '%Y%m%d'),
                STR_TO_DATE(ss.date, '%m-%d-%Y'),
                STR_TO_DATE(ss.date, '%m-%d-%y'),
                STR_TO_DATE(ss.date, '%m%d%Y'),
                STR_TO_DATE(ss.date, '%m%d%y')
            ) DESC
        ";
        $sleepstudy = $db->getRow($sleepstudies); ?>
        <br />
        <strong>Recent Titration</strong><br />
        <strong>Type:</strong> <?php echo $sleepstudy['sleeptesttype']; ?>
        <?php
        if ($sleepstudy['filename'] != '') { ?>
            - <a href="display_file.php?f=<?= $sleepstudy['filename']; ?>" target="_blank">View Study</a>
            <?php
        } ?>
        <br />
        <strong>Most Recent:</strong>
        <?php
        if ($sleepstudy['date'] != '') { ?>
            <?= time_ago_format(date('U') - strtotime($sleepstudy['date'])); ?> ago -
            <?= date('m/d/Y', strtotime($sleepstudy['date'])); ?>
            <?php
        } ?>
        <br />
        <strong>Diagnosis:</strong>
        <?= $sleepstudy['ins_diagnosis']." - ".$sleepstudy['description']; ?>
        <br />
        <strong>AHI/RDI:</strong>
        <?= $sleepstudy['ahi']; ?>
        /
        <?= $sleepstudy['rdi']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Low O2:</strong>
        <?= $sleepstudy['o2nadir']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <strong>T < 90%:</strong>
        <?= $sleepstudy['t9002']; ?>
    </div>

    <h4>CPAP</h4>
    <div class="box">
        <?php
        $pat_sql = "select cpap from dental_q_page2 where patientid='$pid'";
        $pat_myarray = $db->getRow($pat_sql);
        if ($pat_myarray['cpap'] == 'No') { ?>
            Patient has not previously attempted CPAP therapy.
            <?php
        } else {
            ?>
            <label>
                <br />
                <span style="font-weight:bold;">Problems w/ CPAP</span><br />
                <?= (!empty($problem_cpap) ? $problem_cpap : ''); ?>
            </label>
        <?php
        }

$sql = "select * from dental_q_page2_pivot where patientid='$pid'";
$myarray = $db->getRow($sql);

        $polysomnographic = st($myarray['polysomnographic']);
        $sleep_center_name_text = st($myarray['sleep_center_name_text']);
        $sleep_study_on = st($myarray['sleep_study_on']);
        $cpap = st($myarray['cpap']);
        $cur_cpap = st($myarray['cur_cpap']);
        $intolerance = st($myarray['intolerance']);
        $other_intolerance = st($myarray['other_intolerance']);
        $nights_wear_cpap = st($myarray['nights_wear_cpap']);
        $percent_night_cpap = st($myarray['percent_night_cpap']);

        if ($cpap == '') {
            $cpap = 'No';
        }
        if ($polysomnographic != '') { ?>
            <div>
                <span>
                    <strong>Have you had a sleep study</strong>
                    <?= ($polysomnographic == '1') ? 'Yes' : 'No'; ?>
                    <?php
                    if ($polysomnographic == '1') {
                        if ($sleep_center_name_text != '') { ?>
                            <strong>At</strong>
                            <?= $sleep_center_name_text; ?>
                            <?php
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
        <label class="desc" id="title0" for="Field0">CPAP Intolerance</label>
        <?php
        if ($cpap != '') { ?>
            <div>
                <span>
                    <strong>Have you tried CPAP?</strong>
                    <?= $cpap; ?>
                </span>
            </div>
        <?php
        }
        if ($cur_cpap != '') {  ?>
            <div class="cpap_options">
                <span>
                    <strong>Are you currently using CPAP?</strong>
                    <?php echo $cur_cpap;?>
                </span>
            </div>
        <?php
        }
        if ($nights_wear_cpap != '') { ?>
            <div class="cpap_options2">
                <span>
                    <strong>If currently using CPAP, how many nights / week do you wear it?</strong>
                    <?= $nights_wear_cpap; ?>
                    <br />&nbsp;
                </span>
            </div>
        <?php
        }
        if ($percent_night_cpap != '') { ?>
            <div class="cpap_options2">
                <span>
                    <strong>How many hours each night do you wear it?</strong>
                    <?= $percent_night_cpap; ?>
                    <br />&nbsp;
                </span>
            </div>
        <?php
        }
        if ($intolerance != '') { ?>
            <div id="cpap_options" class="cpap_options">
                <span>
                    <strong>What are your chief complaints about CPAP?</strong>
                    <br />
                    <?php
                    $intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
                    $intolerance_my = $db->getResults($intolerance_sql);
                    foreach ($intolerance_my as $intolerance_myarray) {
                        if (strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') !== false) {
                            echo st($intolerance_myarray['intolerance']); ?>
                            <br />
                            <?php
                        }
                    } ?>
                </span>
            </div>
        <?php
        }
        if ($other_intolerance != '') { ?>
            <br />
            <div class="cpap_options">
                <span class="cpap_other_text">
                    <span style="color:#000000; padding-top:0;">
                        <strong>Other Items</strong>
                        <br />
                    </span>
                    <?= $other_intolerance; ?>
                    <br />&nbsp;
                </span>
            </div>
        <?php
        } ?>
    </div>
</div>

<div class="clear"></div>
<h4>Medical Caregivers:</h4>
<div class="box"><?php include 'summ_contacts.php'; ?></div>

<h4>Notes/Personal:</h4> 
<div class="box"><?php include 'dss_notes.php'; ?></div>
<br />

<script src="js/summ_summ.js" type="text/javascript"></script>

<form id="rom_form" action="" method="POST">
    <table width="100%" align="center" border="1" cellpadding="7" cellspacing="0">
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
                <input type="text" onkeyup="check_georges(this.form);" name="ir_range" id="ir_range" size="5" value="<?= $protrusion_equal; ?>" /> mm   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Incisal Range (minimum):&nbsp;&nbsp; 
                <input type="text" name="ir_min" id="ir_min" size="5" value="<?= $protrusion_from; ?>" onchange="checkIncisal()" />
                (maximum) 
                <input type="text" name="ir_max" id="ir_max" size="5" value="<?= $protrusion_to; ?>" onchange="checkIncisal()" />
            </td>
        </tr>
        <script src="js/summ_summ_check.js" type="text/javascript"></script>
        <tr>
            <td width="17%" height="4">
                Best Eccovision&nbsp;&nbsp;
            </td>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Horizontal
                <input type="text" name="optimum_echovision_hor" id="optimum_echovision_hor" size="5" value="<?= $optimum_echovision_hor; ?>" />mm
                Vertical
                <input type="text" name="optimum_echovision_ver" id="optimum_echovision_ver" size="5" value="<?= $optimum_echovision_ver; ?>" />mm
            </td>
        </tr>
        <tr>
            <td width="17%" height="4">
                Initial Device Setting&nbsp;&nbsp;
            </td>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Incisal Position 
                <input type="text" onchange="checkIncisal()" name="initial_device_titration_1" id="i_pos" size="5" value="<?= $initial_device_titration_1; ?>" />mm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Vertical 
                <input type="text" name="initial_device_titration_equal_v" id="initial_device_titration_equal_v" size="5" value="<?= $initial_device_titration_equal_v; ?>" />mm
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Distance from minimum range
                <input disabled="disabled" type="text" name="initial_device_titration_equal_h" id="initial_device_titration_equal_h" size="5" value="<?= $initial_device_titration_equal_h; ?>" />mm
                (<input type="text" name="i_perc" id="i_perc" size="2" disabled="disabled" value="<?= (!empty($initialdevsettingp) ? $initialdevsettingp : ''); ?>" />%)
            </td>
        </tr>
    </table>
    <input type="submit" name="device_submit" value="Save" />
</form>
