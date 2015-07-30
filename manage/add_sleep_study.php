<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('admin/includes/main_include.php');
include_once("includes/sescheck.php"); 
include_once('includes/constants.inc');
include_once('includes/dental_patient_summary.php');
include_once('includes/general_functions.php');
include("includes/calendarinc.php");

// $preferDefault allows to ignore post data when the form has been saved
function postField ($name, $default='', $preferDefault=false) 
{
    if (!$preferDefault && isset($_POST[$name])) 
    {
        return $_POST[$name];
    }

    return $default;
}

function escapedField ($name, $default='', $preferDefault=false) 
{
    return htmlspecialchars(postField($name, $default, $preferDefault));
}

function selected ($value, $reference) 
{
    if ($value == $reference) 
    {
        return 'selected="selected"';
    }

    return '';
}

$maxFileSizeExceeded = 'There was an error with the file upload. Please verify that the file does not exceed 10MB and try again.';
$errorMessage = '';

$patientId = intval($_GET['pid']);

$isDeleteStudy = isset($_POST['submitdeletesleeplabsumm']);
$isUpdateStudy = isset($_POST['submitupdatesleeplabsumm']);
$isNewStudy = isset($_POST['submitnewsleeplabsumm']);

$changesSaved = false;

if ( isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] && !$_FILES && 
     ($isDeleteStudy || $isUpdateStudy || $isNewStudy) ) 
{
    error_log('Max file size exceeded AND PHP didn\'t populate FILES global variable, and POST might be corrupt');
    $errorMessage = $maxFileSizeExceeded;
}

// Determine Type of Appliance
$sql = "SELECT dentaldevice
    FROM dental_summ_sleeplab
    WHERE patiendid = '$patientId'
    ORDER BY STR_TO_DATE(date, '%m/%d/%Y') DESC
    LIMIT 1;";
$result = $db->getResults($sql);

if ($result) 
{
    $deviceid = 0;

    foreach ($result as $row) 
    {
        $deviceid = $row['dentaldevice'];
    }

    update_patient_summary($patientId, 'appliance', $deviceid);
}

$s_lab_query = "SELECT *
    FROM dental_summ_sleeplab
    WHERE patiendid = '$patientId'
    ORDER BY STR_TO_DATE(date, '%m/%d/%Y') DESC";
$num_labs = $db->getNumberRows($s_lab_query);

if ($isNewStudy) 
{
    $num_labs++;
}

$msg = '';

if ($isDeleteStudy) 
{
    $id = intval($_POST['sleeplabid']);
    $q = "DELETE FROM dental_summ_sleeplab WHERE id = '$id'";

    $changesSaved = !!$db->query($q);

    $msg = $changesSaved ? 'Successfully deleted sleep lab study.' : 'Could not delete sleep lab study, please try again.';
} else 
if ($isUpdateStudy) 
{
    $id = s_for($_POST['sleeplabid']);
    $date = s_for($_POST['date']);
    $sleeptesttype = s_for($_POST['sleeptesttype']);
    $place = s_for($_POST['place']);
    $diagnosising_doc = (strpos($_POST['diagnosising_doc'], ' - '))?substr($_POST['diagnosising_doc'], 0, (strrpos($_POST['diagnosising_doc'],' - '))):$_POST['diagnosising_doc'];
    $diagnosising_npi = s_for($_POST['diagnosising_npi']);
    $ahi = s_for($_POST['ahi']);
    $ahisupine = s_for($_POST['ahisupine']);
    $rdi = s_for($_POST['rdi']);
    $rdisupine = s_for($_POST['rdisupine']);
    $o2nadir = s_for($_POST['o2nadir']);
    $t9002 = s_for($_POST['t9002']);
    $dentaldevice = s_for($_POST['dentaldevice']);
    $devicesetting = s_for($_POST['devicesetting']);
    $diagnosis = s_for($_POST['diagnosis']);
    $notes = s_for($_POST['notes']);
    $testnumber = s_for($_POST['testnumber']);
    $needed = s_for($_POST['needed']);
    $scheddate = s_for($_POST['scheddate']);
    $completed = s_for($_POST['completed']);
    $patientid = (!empty($_GET['pid']) ? $_GET['pid'] : '');

    $s = "SELECT filename, image_id from dental_summ_sleeplab WHERE id='".$id."'";
    $prevfile_result = $db->getResults($s);
    $prev_filename = $prevfile_result[0]['filename'];
    $image_id = $prevfile_result[0]['image_id'];

    $banner1 = $prev_filename;

    if (isset($_FILES['ss_file'])) 
    {
        $errorNo = $_FILES['ss_file']['error'];

        if (isFaultyUpload($errorNo)) 
        {
            error_log("SS file upload error [{$errorNo}]: {$dss_file_upload_errors[$errorNo]}");
            $errorMessage = $maxFileSizeExceeded;
        } else 
        {
            $fname = $_FILES["ss_file"]["name"] ?: 'unnamed-file.';
            $lastdot = strrpos($fname,".");
            $name = substr($fname,0,$lastdot);
            $extension = substr($fname,$lastdot+1);
            $banner1 = $name.'_'.date('dmy_Hi');
            $banner1 = str_replace(" ","_",$banner1);
            $banner1 = str_replace(".","_",$banner1);
            $banner1 = str_replace("'","_",$banner1);
            $banner1 = str_replace("&","amp",$banner1);
            $banner1 .= ".".$extension;

            $uploaded = uploadImage($_FILES['ss_file'], "../../../shared/q_file/".$banner1);

            if ($uploaded) 
            {
                if ($image_id != '') 
                {
                    $ins_sql = " update dental_q_image set
                            image_file = '".s_for($banner1)."'
                            WHERE imageid='".$image_id."'
                            AND patientid='".$patientid."'
                            ;";
                    $db->query($ins_sql);

                    if (file_exists("../../../shared/q_file/" . $prev_filename)) 
                    {
                        unlink("../../../shared/q_file/" . $prev_filename);
                    }
                } else 
                {
                    $ins_sql = " insert into dental_q_image set
                            patientid = '".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."',
                            title = '".$sleeptesttype." ".$date."',
                            imagetypeid = '1',
                            image_file = '".s_for($banner1)."',
                            userid = '".s_for($_SESSION['userid'])."',
                            docid = '".s_for($_SESSION['docid'])."',
                            adddate = now(),
                            ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                    $image_id = $db->getInsertId($ins_sql);
                }
            } else 
            {
                error_log('SS file upload save error. Error message should be stored above this line.');
                $errorMessage = $maxFileSizeExceeded;
            }
        }
    }

    // Set default message. In case everything goes ok the message will be updated
    $msg = $errorMessage ?: 'There was an error uploading the attachment. Please try again.';

    $diagnosising_doc = mysqli_real_escape_string($con, $diagnosising_doc);
    $q = "UPDATE dental_summ_sleeplab SET
        `date` = '$date',
        `sleeptesttype`  = '$sleeptesttype',
        `place`  = '$place',
        `diagnosising_doc` = '$diagnosising_doc',
        `diagnosising_npi` = '$diagnosising_npi',
        `ahi`  = '$ahi',
        `ahisupine`  = '$ahisupine',
        `rdi`  = '$rdi',
        `rdisupine`  = '$rdisupine',
        `o2nadir`  = '$o2nadir',
        `t9002`  = '$t9002',
        `dentaldevice`  = '$dentaldevice',
        `devicesetting`  = '$devicesetting',
        `diagnosis`  = '$diagnosis',
        `filename` = '$banner1',
        `notes`  = '$notes',
        `testnumber` = '$testnumber',
        `needed` = '$needed',
        `scheddate` = '$scheddate',
        `completed` = '$completed',
        `image_id` = '$image_id'
        WHERE id='$id'";
    $changesSaved = !!$db->query($q);

    $i_sql = "UPDATE dental_q_image SET
              title = '$sleeptesttype $date'
              WHERE image_file='$banner1'";
    $db->query($i_sql);
    if( empty($errorMessage) )
    {
        $msg = $changesSaved ? 'Successfully updated sleep lab study.' : 'Could not update sleep lab study, please try again.';
    }
} else 
if ($isNewStudy) 
{
    $date = s_for($_POST['date']);
    $sleeptesttype = s_for($_POST['sleeptesttype']);
    $place = s_for($_POST['place']);
    $diagnosising_doc = substr($_POST['diagnosising_doc'], 0, strrpos($_POST['diagnosising_doc'], ' - '));
    $diagnosising_npi = s_for($_POST['diagnosising_npi']);
    $ahi = s_for($_POST['ahi']);
    $ahisupine = s_for($_POST['ahisupine']);
    $rdi = s_for($_POST['rdi']);
    $rdisupine = s_for($_POST['rdisupine']);
    $o2nadir = s_for($_POST['o2nadir']);
    $t9002 = s_for($_POST['t9002']);
    $dentaldevice = s_for($_POST['dentaldevice']);
    $devicesetting = s_for($_POST['devicesetting']);
    $diagnosis = s_for($_POST['diagnosis']);
    $notes = s_for($_POST['notes']);
    $testnumber = s_for($_POST['testnumber']);
    $needed = s_for($_POST['needed']);
    $scheddate = s_for($_POST['scheddate']);
    $completed = s_for($_POST['completed']);
    $patientid = (!empty($_GET['pid']) ? $_GET['pid'] : '');

    $banner1 = '';
    $image_id = '';

    if (isset($_FILES['ss_file'])) 
    {
        $errorNo = $_FILES['ss_file']['error'];

        if (isFaultyUpload($errorNo)) 
        {
            error_log("SS file upload error [{$errorNo}]: {$dss_file_upload_errors[$errorNo]}");
            $errorMessage = $maxFileSizeExceeded;
        } else 
        {
            $fname = $_FILES["ss_file"]["name"] ?: 'unnamed-file.';
            $lastdot = strrpos($fname,".");
            $name = substr($fname,0,$lastdot);
            $extension = substr($fname,$lastdot+1);
            $banner1 = $name.'_'.date('dmy_Hi');
            $banner1 = str_replace(" ","_",$banner1);
            $banner1 = str_replace(".","_",$banner1);
            $banner1 = str_replace("'","_",$banner1);
            $banner1 = str_replace("&","amp",$banner1);
            $banner1 .= ".".$extension;

            $uploaded = uploadImage($_FILES['ss_file'], "../../../shared/q_file/".$banner1);

            if ($uploaded) 
            {
                $ins_sql = " insert into dental_q_image set
                    patientid = '".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."',
                    title = '".$sleeptesttype. " " .$date."',
                    imagetypeid = '1',
                    image_file = '".s_for($banner1)."',
                    userid = '".s_for($_SESSION['userid'])."',
                    docid = '".s_for($_SESSION['docid'])."',
                    adddate = now(),
                    ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                $db->getInsertId($ins_sql);
            } else 
            {
                error_log('SS file upload save error. Error message should be stored above this line.');
                $errorMessage = $maxFileSizeExceeded;
            }
        }
    }

    $diagnosising_doc = mysqli_real_escape_string($con, $diagnosising_doc);

    $q = "INSERT INTO `dental_summ_sleeplab` (
            `id` ,
            `date` ,
            `sleeptesttype` ,
            `place` ,
            `diagnosising_doc`,
            `diagnosising_npi`,
            `ahi` ,
            `ahisupine` ,
            `rdi` ,
            `rdisupine` ,
            `o2nadir` ,
            `t9002` ,
            `dentaldevice` ,
            `devicesetting` ,
            `diagnosis` ,
            `filename` ,
            `notes`,
            `testnumber`,
            `needed`,
            `scheddate`,
            `completed`,
            `patiendid`,
            `image_id`
        ) VALUES (
            NULL,
            '$date',
            '$sleeptesttype',
            '$place',
            '$diagnosising_doc',
            '$diagnosising_npi',
            '$ahi',
            '$ahisupine',
            '$rdi',
            '$rdisupine',
            '$o2nadir',
            '$t9002',
            '$dentaldevice',
            '$devicesetting',
            '$diagnosis',
            '$banner1',
            '$notes',
            '$testnumber',
            '$needed',
            '$scheddate',
            '$completed',
            '$patientid',
            '$image_id'
        )";
    $changesSaved = !!$db->query($q);

    if( empty($errorMessage) )
    {
        $msg = $changesSaved ? 'Successfully added sleep lab study.' : 'Could not add sleep lab study, please try again.';
    }
}

$sleepstudies = "SELECT ss.*
    FROM dental_summ_sleeplab ss
        JOIN dental_patients p ON ss.patiendid=p.patientid
    WHERE (p.p_m_ins_type != '1' OR (
            (ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '')
            AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != '')
        ))
        AND (ss.diagnosis IS NOT NULL && ss.diagnosis != '')
        AND ss.filename IS NOT NULL AND ss.patiendid = '$patientId'";

$numsleepstudy = $db->getNumberRows($sleepstudies);
$sleepstudy = $numsleepstudy > 0;
$show_yellow = !empty($_GET['yellow']);

$pat_sql = "SELECT p_m_ins_type FROM dental_patients WHERE patientid='$patientId'";
$pat_r = $db->getRow($pat_sql);

?>
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<link rel="stylesheet" type="text/css" href="css/form.css" />
<link rel="stylesheet" type="text/css" href="css/add_sleep_study.css" media="screen" />
<!--  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script type="text/javascript">parent.updateiframe(<?= $num_labs ?>);</script>
<script src="js/add_sleep_study.js" type="text/javascript"></script>
<?php if ($errorMessage) { ?>
    <script type="text/javascript">
        alert(<?= json_encode($errorMessage) ?>);
    </script>
<?php }
if ($msg && $msg != $errorMessage) { ?>
    <script type="text/javascript">
        alert("<?= $msg ?>");
    </script>
<?php } ?>
<form id="new_sleep_study_form" action="dss_summ.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&addtopat=1" method="POST" style="float:left; width:185px;<?= $isNewStudy && !$changesSaved ? '' : 'display:none;' ?>" enctype="multipart/form-data">
    <input type="hidden" name="submitnewsleeplabsumm" value="1" />
    <table class="sleeplabstable new_table <?php print ($show_yellow && !$sleepstudy  ? 'yellow' : ''); ?>" id="sleepstudyscrolltable">
        <tr>
            <td valign="top" class="odd">
                <input type="text" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox calendar" name="date" id="date" value="<?php echo date('m/d/Y'); ?>">
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <select name="sleeptesttype" onchange="update_home(this.form)">
                    <?php $selected = postField('sleeptesttype', '', $changesSaved) ?>
                    <option value="HST Baseline" <?= selected($selected, 'HST Baseline') ?>>HST Baseline</option>
                    <option value="PSG Baseline" <?= selected($selected, 'PSG Baseline') ?>>PSG Baseline</option>
                    <option value="HST Titration" <?= selected($selected, 'HST Titration') ?>>HST Titration</option>
                    <option value="PSG Titration" <?= selected($selected, 'HST Titration') ?>>PSG Titration</option>
                    <option value="Oximeter" <?= selected($selected, 'Oximeter') ?>>Oximeter</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <select name="place" id="new_place" class="place_select" onchange="addstudylab(this.value, 'new_place')">
                    <option>SELECT</option>
                    <?php $selected = postField('place', '', $changesSaved) ?>
                    <option value="0" <?= selected($selected, 0) ?>>Home</option>
                    <?php
                    $lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY company ASC";
                    $lab_place_r = $db->getResults($lab_place_q);

                    foreach ($lab_place_r as $each) { ?>
                        <option value="<?= $each['sleeplabid'] ?>" <?= selected($selected, $each['sleeplabid']) ?>>
                            <?= htmlspecialchars($each['company']) ?>
                        </option>
                    <?php } ?>
                    <option value="add">ADD SLEEP LAB</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <select name="diagnosis" style="width:140px;" class="field text addr tbox">
                    <?php $selected = postField('diagnosis', '', $changesSaved) ?>
                    <option value="">SELECT</option>
                    <?php
                    $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
                    $ins_diag_my = $db->getResults($ins_diag_sql);

                    foreach ($ins_diag_my as $each) { ?>
                        <option value="<?= $each['ins_diagnosisid'] ?>" <?= selected($selected, $each['ins_diagnosisid']) ?>>
                            <?= htmlspecialchars($each['ins_diagnosis'] . " " . $each['description']) ?>
                        </option>
                    <?php } ?>
                </select>
                <span id="req_0" class="req">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input style="width:100px;" type="text" id="diagnosising_doc" autocomplete="off" name="diagnosising_doc"
                       value="<?= escapedField('diagnosising_doc', '', $changesSaved) ?>" />
                <?php if ($pat_r['p_m_ins_type'] == 1) { ?>
                    <span id="req_0" class="req">*</span>
                <?php } ?>
                <br />
                <div id="diagnosising_doc_hints" class="search_hints" style="display:none;">
                    <ul id="diagnosising_doc_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input style="width:100px;" type="text" id="diagnosising_npi" name="diagnosising_npi"
                    value="<?= escapedField('diagnosising_npi', '', $changesSaved) ?>" />
                <?php if ($pat_r['p_m_ins_type'] == 1) { ?>
                    <span id="req_0" class="req">*</span>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input style="width:140px" size="8" type="file" name="ss_file" />
                <span id="req_0" class="req">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="ahi" value="<?= escapedField('ahi', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="ahisupine" value="<?= escapedField('ahisupine', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="rdi" value="<?= escapedField('rdi', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="rdisupine" value="<?= escapedField('rdisupine', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="o2nadir" value="<?= escapedField('o2nadir', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="t9002" value="<?= escapedField('t9002', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even" style="height:25px;">
                <?php
                $sqlex = "select * from dental_ex_page5 where patientid='$patientId'";
                $myarrayex = $db->getRow($sqlex);
                $dentaldevice = $myarrayex['dentaldevice'];
                ?>
                <select name="dentaldevice" style="width:150px;">
                    <?php $selected = postField('dentaldevice', $dentaldevice, $changesSaved) ?>
                    <option value="">SELECT</option>
                    <?php
                    $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                    $device_my = $db->getResults($device_sql);

                    foreach ($device_my as $each) { ?>
                        <option <?= selected($selected, $each['deviceid']) ?>
                            value="<?= htmlspecialchars($each['deviceid']) ?>">
                            <?= htmlspecialchars($each['device']) ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="devicesetting" value="<?= escapedField('devicesetting', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="notes" value="<?= escapedField('notes', '', $changesSaved) ?>" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="submit" name="submitnewsleeplabsumm" onclick="window.onbeforeunload=false;$(this).parent().find('.loading').show();" value="Submit Study" />
                <input type="button" onclick="$('#new_sleep_study_form').hide(); parent.show_new_sleep_but(); return false;" value="Cancel" />
                <img src="images/loading.gif" class="loading" style="display:none;"/>
            </td>
        </tr>
    </table>
</form>
<?php

$s_lab_query = "SELECT *
    FROM dental_summ_sleeplab
    WHERE patiendid = '$patientId'
    ORDER BY STR_TO_DATE(date, '%m/%d/%Y') DESC";
$s_lab_result = $db->getResults($s_lab_query);

if ($s_lab_result) {
    foreach ($s_lab_result as $s_lab) {

        $sleeplab_query = "SELECT company FROM dental_sleeplab WHERE sleeplabid = '".$s_lab['place']."';";
        $sleeplab_result = $db->getRow($sleeplab_query);
        $place = $sleeplab_result['company'];

        $device_query = "SELECT device FROM dental_device WHERE deviceid = '".$s_lab['dentaldevice']."';";
        $device_result = $db->getRow($device_query);
        $device = $device_result['device'];

        ?>
        <form action="dss_summ.php?pid=<?= $patientId ?>&addtopat=1" style="float:left;" method="post" enctype="multipart/form-data">
            <input type="hidden" name="sleeplabid" value="<?php echo $s_lab['id']; ?>" />
            <table id="sleepstudycrolltable" class="sleeplabstable <?php print ($show_yellow && !$sleepstudy  ? 'yellow' : ''); ?>">
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="date" id="date<?php echo $s_lab['id']; ?>" class="calendar" value="<?php echo $s_lab['date']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <select name="sleeptesttype" onchange="update_home(this.form)">
                            <option <?= selected($s_lab['sleeptesttype'], 'HST Baseline') ?> value="HST Baseline">HST Baseline</option>
                            <option <?= selected($s_lab['sleeptesttype'], 'PSG Baseline') ?> value="PSG Baseline">PSG Baseline</option>
                            <option <?= selected($s_lab['sleeptesttype'], 'HST Titration') ?> value="HST Titration">HST Titration</option>
                            <option <?= selected($s_lab['sleeptesttype'], 'PSG Titration') ?> value="PSG Titration">PSG Titration</option>
                            <option <?= selected($s_lab['sleeptesttype'], 'Oximeter') ?> value="Oximeter">Oximeter</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <select name="place" id="place_<?php echo $s_lab['id'];?>" class="place_select" onchange="addstudylab(this.value, 'place_<?php echo $s_lab['id'];?>')">
                            <option>SELECT</option>
                            <option <?php echo ($s_lab['place']=='0')?'selected="selected"':''; ?> value="0">Home</option>
                            <?php
                            $lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY company ASC";
                            $lab_place_r = $db->getResults($lab_place_q);

                            foreach ($lab_place_r as $each) { ?>
                                <option <?= selected($s_lab['place'], $each['sleeplabid']) ?>
                                    value="<?= $each['sleeplabid'] ?>">
                                    <?= htmlspecialchars($each['company']) ?>
                                </option>
                            <?php } ?>
                            <option value="add">ADD SLEEP LAB</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <select name="diagnosis" style="width:140px;" class="field text addr tbox" >
                            <option value="">SELECT</option>
                            <?php
                            $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
                            $ins_diag_my = $db->getResults($ins_diag_sql);

                            foreach ($ins_diag_my as $each) { ?>
                                <option value="<?= $each['ins_diagnosisid'] ?>"
                                    <?= selected($s_lab['diagnosis'], $each['ins_diagnosisid']) ?>>
                                    <?= htmlspecialchars($each['ins_diagnosis'] . " " . $each['description']) ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span id="req_0" class="req">*</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" id="diagnosising_doc_<?php echo $s_lab['id']; ?>" name="diagnosising_doc"
                               value="<?= $s_lab['diagnosising_doc'] ?>" style="width:100px;" autocomplete="off" />
                        <?php if($pat_r['p_m_ins_type'] == 1) { ?>
                            <span id="req_0" class="req">*</span>
                        <?php } ?>
                        <br />
                        <div id="diagnosising_doc_<?php echo $s_lab['id']; ?>_hints" class="search_hints" style="display:none;">
                            <ul id="diagnosising_doc_<?php echo $s_lab['id']; ?>_list" class="search_list">
                                <li class="template" style="display:none">Doe, John S</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" id="diagnosising_npi_<?php echo $s_lab['id']; ?>" name="diagnosising_npi"
                               value="<?= $s_lab['diagnosising_npi'] ?>" style="width:100px;" />
                        <?php if ($pat_r['p_m_ins_type'] == 1) { ?>
                            <span id="req_0" class="req">*</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <?php if ($s_lab['filename'] != '') { ?>
                            <div id="file_edit_<?php echo $s_lab['id']; ?>">
                                <a href="display_file.php?f=<?php echo addslashes($s_lab['filename']); ?>" target="_blank" class="button">View</a>
                                <input type="button" id="edit" onclick="$('#file_edit_<?php echo $s_lab['id']; ?>').hide();$('#file_<?php echo $s_lab['id']; ?>').show();return false;" value="Edit" title="Edit" />
                            </div>
                            <input id="file_<?php echo $s_lab['id']; ?>" style="width: 170px;display:none;" name="ss_file" type="file" size="8" />
                        <?php } else { ?>
                            <input style="width:140px;" size="8" type="file" name="ss_file" />
                            <span id="req_0" class="req">*</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="ahi" value="<?php echo $s_lab['ahi']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="ahisupine" value="<?php echo $s_lab['ahisupine']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="rdi" value="<?php echo $s_lab['rdi']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="rdisupine" value="<?php echo $s_lab['rdisupine']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="o2nadir" value="<?php echo $s_lab['o2nadir']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="t9002" value="<?php echo $s_lab['t9002']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <select name="dentaldevice" style="width:150px;">
                            <option value="">SELECT</option>
                            <?php
                            $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                            $device_my = $db->getResults($device_sql);

                            foreach ($device_my as $each) { ?>
                                <option <?= selected($device, $each['device']) ?>
                                    value="<?= $each['deviceid'] ?>">
                                    <?= htmlspecialchars($each['device']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="devicesetting" value="<?php echo $s_lab['devicesetting']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="notes" value="<?php echo $s_lab['notes']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="submit" name="submitupdatesleeplabsumm" onclick="window.onbeforeunload=false;$(this).parent().find('.loading').show();" value="Save" />
                        <input type="submit" name="submitdeletesleeplabsumm" onclick='return delete_confirm();' value="Delete" />
                        <img src="images/loading.gif" class="loading" style="display:none;"/>
                    </td>
                </tr>
            </table>
        </form>
    <?php }
} ?>
