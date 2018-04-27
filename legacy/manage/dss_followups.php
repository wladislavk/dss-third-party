<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once 'admin/includes/main_include.php';
include_once 'includes/sescheck.php';

if (isset($_POST['submitaddfu'])) {
    if (isset($db) && $db instanceof Db) {
        $patientid = $db->escape($_POST['patientid']);
    }
    $ep_dateadd = $db->escape(date("Y-m-d H:i:s", strtotime($_POST['ep_dateadd'])));
    $devadd = $db->escape($_POST['devadd']);
    $dsetadd = $db->escape($_POST['dsetadd']);
    $nightsperweek = $db->escape($_POST['nightsperweek']);
    $ep_eadd = $db->escape($_POST['ep_eadd_new']);
    $ep_tsadd = $db->escape($_POST['ep_tsadd_new']);
    $ep_sadd = $db->escape($_POST['ep_sadd']);
    $ep_eladd = $db->escape($_POST['ep_eladd']);
    $sleep_qualadd = $db->escape($_POST['sleep_qualadd']);
    $ep_hadd = $db->escape($_POST['ep_hadd']);
    $ep_wadd = $db->escape($_POST['ep_wadd']);
    $wapnadd = $db->escape($_POST['wapnadd']);
    $hours_sleepadd = $db->escape($_POST['hours_sleepadd']);
    $appt_notesadd = $db->escape($_POST['appt_notesadd']);
    $insertquery = "
        INSERT INTO dentalsummfu (
            `patientid`,
            `ep_dateadd`,
            `devadd`,
            `dsetadd`,
            `nightsperweek`,
            `ep_eadd`,
            `ep_tsadd`,
            `ep_sadd`,
            `ep_eladd`,
            `sleep_qualadd`,
            `ep_hadd`,
            `ep_wadd`,
            `wapnadd`,
            `hours_sleepadd`,
            `appt_notesadd`
        ) VALUES (
            '$patientid',
            '$ep_dateadd',
            '$devadd',
            '$dsetadd',
            '$nightsperweek',
            '$ep_eadd',
            '$ep_tsadd',
            '$ep_sadd',
            '$ep_eladd',
            '$sleep_qualadd',
            '$ep_hadd',
            '$ep_wadd',
            '$wapnadd',
            '$hours_sleepadd',
            '$appt_notesadd'
        );
    ";
    $fu_id = $db->getInsertId($insertquery);
    if (!$fu_id) {
        echo "Could not insert follow up, please try again!";
    } else {
        $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
        $epworth_my = $db->getResults($epworth_sql);
        foreach ($epworth_my as $epworth_myarray) {
            $i = "
                INSERT INTO dentalsummfu_ess SET
                    epworthid='".$epworth_myarray['epworthid']."',
                    followupid='".$fu_id."',
                    answer='".$db->escape($_POST['epworth_new_'.$epworth_myarray['epworthid']])."',
                    adddate=now(),
                    ip_address='".$_SERVER['REMOTE_ADDR']."'
            ";
            $db->query($i);
        }
        for ($thorntonid = 1; $thorntonid <= 5; $thorntonid++) {
            $i = "
                INSERT INTO dentalsummfu_tss SET
                    thorntonid='".$thorntonid."',
                    followupid='".$fu_id."',
                    answer='".$db->escape($_POST['thornton_new_'.$thorntonid])."',
                    adddate=now(),
                    ip_address='".$_SERVER['REMOTE_ADDR']."'
            ";
            $db->query($i);
        }
    }
} elseif (isset($_POST['submitupdatefu'])) {
    if (isset($db) && $db instanceof Db) {
        $id = $db->escape($_POST['id']);
    }
    $patientid = $db->escape($_POST['patientid']);
    $ep_dateadd = date("Y-m-d H:i:s", strtotime($_POST['ep_dateadd']));
    $devadd = $db->escape($_POST['devadd']);
    $dsetadd = $db->escape($_POST['dsetadd']);
    $nightsperweek = $db->escape($_POST['nightsperweek']);
    $ep_eadd = $db->escape($_POST['ep_eadd']);
    $ep_tsadd = $db->escape($_POST['ep_tsadd']);
    $ep_sadd = $db->escape($_POST['ep_sadd']);
    $ep_eladd = $db->escape($_POST['ep_eladd']);
    $sleep_qualadd = $db->escape($_POST['sleep_qualadd']);
    $ep_hadd = $db->escape($_POST['ep_hadd']);
    $ep_wadd = $db->escape($_POST['ep_wadd']);
    $wapnadd = $db->escape($_POST['wapnadd']);
    $hours_sleepadd = $db->escape($_POST['hours_sleepadd']);
    $appt_notesadd = $db->escape($_POST['appt_notesadd']);
    $insertquery = "
        UPDATE dentalsummfu SET 
            `ep_dateadd` = '".date('Y-m-d', strtotime($ep_dateadd))."',
            `devadd` = '".$devadd."',
            `dsetadd` = '".$dsetadd."',
            `nightsperweek` = '".$nightsperweek."',
            `ep_eadd` = '".$ep_eadd."',
            `ep_tsadd` = '".$ep_tsadd."',
            `ep_sadd` = '".$ep_sadd."',
            `ep_eladd` = '".$ep_eladd."',
            `sleep_qualadd` = '".$sleep_qualadd."',
            `ep_hadd` = '".$ep_hadd."',
            `ep_wadd` = '".$ep_wadd."',
            `wapnadd` = '".$wapnadd."',
            `hours_sleepadd` = '".$hours_sleepadd."',
            `appt_notesadd` = '".$appt_notesadd."'
        WHERE followupid='".$id."';
    ";
    $insert = $db->query($insertquery);
    if (!$insert) {
        echo "Could not update follow up, please try again!";
    } else {
        $d = "DELETE FROM dentalsummfu_ess WHERE followupid = '".$db->escape($id)."'";
        $db->query($d);
        $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
        $epworth_my = $db->getResults($epworth_sql);
        foreach ($epworth_my as $epworth_myarray) {
            $i = "
                INSERT INTO dentalsummfu_ess SET
                    epworthid='".$epworth_myarray['epworthid']."',
                    followupid='".$id."',
                    answer='".$db->escape($_POST['epworth_'.$id.'_'.$epworth_myarray['epworthid']])."',
                    adddate=now(),
                    ip_address='".$_SERVER['REMOTE_ADDR']."'
            ";
  		    $db->query($i);
  	    }
        $d = "DELETE FROM dentalsummfu_tss WHERE followupid = '".$db->escape($id)."'";
        $db->query($d);
  	    for ($thorntonid = 1; $thorntonid <= 5; $thorntonid++) {
            $i = "
                INSERT INTO dentalsummfu_tss SET
                    thorntonid='".$thorntonid."',
                    followupid='".$id."',
                    answer='".$db->escape($_POST['thornton_'.$id.'_'.$thorntonid])."',
                    adddate=now(),
                    ip_address='".$_SERVER['REMOTE_ADDR']."'
            ";
            $db->query($i);
        }
    }
} elseif (isset($_POST['submitdeletefu'])) {
    $id = $_POST['id'];
    if (isset($db) && $db instanceof Db) {
        $delsql = "DELETE FROM dentalsummfu WHERE followupid='".$db->escape($id)."'";
    }
    $db->query($delsql);
}

$fuquery_sql = "SELECT * FROM dentalsummfu WHERE patientid ='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY ep_dateadd DESC";
$numf = $db->getNumberRows($fuquery_sql);
$bodywidth = ($numf * 160) + 320;
?>
<div style="width:<?php echo $bodywidth; ?>px;">
    <form id="sleepstudyadd" style="float:left; display:none;" method="post" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']."?pid=".(!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
        <link rel="stylesheet" href="css/dss_followups.css" type="text/css" media="screen" />
        <table id="sleepstudyscrolltable" style="margin-top:-3px;">
            <tr style="background: #444;height: 30px;">
                <td colspan="4" style="background: #444;"><span style="color: #fff;">New</span></td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" style="width:100px;" class="calendar" id="ep_dateadd" name="ep_dateadd" value="<?= date('m/d/Y'); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    $sqlex = "select * from dental_ex_page5 where patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
                    $myarrayex = $db->getRow($sqlex);
                    $dentaldevice = st($myarrayex['dentaldevice']);
                    ?>
                    <select name="devadd" style="width:150px;">
                        <?php
                        $device_sql = "select * from dental_device where status=1 order by sortby";
                        $device_my = $db->getResults($device_sql);
                        foreach ($device_my as $device_myarray) { ?>
                            <option <?= ($dentaldevice == $device_myarray['deviceid']) ? 'selected="selected"' : ''; ?> value="<?= st($device_myarray['deviceid']) ?>"><?= st($device_myarray['device']); ?></option>
                            <?php
                        } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="text" size="12" name="dsetadd" /></td>
            </tr>
            <tr>
                <td>
                    <select name="nightsperweek" style="width:150px;">
                        <?php
                        for ($i = 0; $i <= 7; $i++) { ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                            <?php
                        } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" id="ep_eadd_new" name="ep_eadd_new" onclick="loadPopup('summ_subj_ess.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=new');return false;" />
                </td>
            </tr>
            <!--- ESS ANSWERS -->
            <tr style="display:none;">
                <td style="background: #E4FFCF;">
                    <?php
                    $epworth_sql = "select e.* from dental_epworth e where e.status=1 order by e.sortby";
                    $epworth_my = $db->getResults($epworth_sql);
                    foreach ($epworth_my as $epworth_myarray) { ?>
                        <input type="text" size="12" id="epworth_new_<?= $epworth_myarray['epworthid']; ?>" name="epworth_new_<?= $epworth_myarray['epworthid']; ?>" /><br />
                        <?php
                    } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" id="ep_tsadd_new" name="ep_tsadd_new" onclick="loadPopup('summ_subj_tss.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=new');return false;" />
                </td>
            </tr>
            <tr style="display:none;">
                <td style="background: #E4FFCF;">
                    <?php
                    for ($thorntonid = 1; $thorntonid <= 5; $thorntonid++) { ?>
                        <input type="text" size="12" id="thornton_new_<?= $thorntonid; ?>" name="thornton_new_<?= $thorntonid; ?>" /><br />
                        <?php
                    } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" name="ep_sadd" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" name="ep_eladd" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" name="sleep_qualadd" />
                </td>
            </tr>
            <tr>
                <td>
                    <select name="ep_hadd" class="field text addr tbox" style="width:150px;">
                        <option value=""></option>
                        <option value="Most Mornings">Most Mornings</option>
                        <option value="Several times per week">Several times per week</option>
                        <option value="Several times per month">Several times per month</option>
                        <option value="Occasionally">Occasionally</option>
                        <option value="Rarely">Rarely</option>
                        <option value="Never">Never</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" name="ep_wadd" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" style="width:90px;" name="wapnadd" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" name="hours_sleepadd" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" size="12" name="appt_notesadd" style="width:100px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="patientid" value="<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" />
                    <input type="submit" name="submitaddfu" onclick="window.onbeforeunload=false;" value="Submit Follow Up" id="submitaddfu" style="width:120px;" />
                    <input type="button" onclick="$('#sleepstudyadd').hide(); parent.show_new_but(); return false;" value="Cancel" style="width:120px;" />
                </td>
            </tr>
        </table>
    </form>

    <?php
    $followUpQuerySql = "SELECT * FROM dentalsummfu WHERE patientid ='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY ep_dateadd DESC";
    $followUpQueryResult = $db->getResults($followUpQuerySql);
    if ($followUpQueryResult) {
        $deviceSql = "select * from dental_device where status=1 order by sortby";
        $devices = $db->getResults($deviceSql);
        $followUpIds = [];
        foreach ($followUpQueryResult as $followUp) {
            $followUpIds[] = $followUp['followupid'];
        }
        $followUpIdsString = join(', ', $followUpIds);
        $thorntonSql = "
            SELECT answer, followupid, thorntonid FROM dentalsummfu_tss
            WHERE followupid IN ($followUpIdsString) 
            AND thorntonid IN (1,2,3,4,5)
            ORDER BY thorntonid
        ";
        $thorntons = $db->getResults($thorntonSql);
        $epworthSql = "
            select e.*, fu.answer, fu.followupid from dental_epworth e 
            LEFT JOIN dentalsummfu_ess fu ON fu.epworthid=e.epworthid AND fu.followupid IN ($followUpIdsString)
            where e.status=1 
            order by e.sortby
        ";
        $epworthResult = $db->getResults($epworthSql);

        $numrows = count($followUpQueryResult);
        foreach ($followUpQueryResult as $followUp) {
            if ($numrows) { ?>
                <form style="float:left;" id="sleepstdyupdate_<?= $followUp['followupid'];?>" class="sleepstudyupdate" method="post" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
                    <input type="hidden" name="id" value="<?= $followUp['followupid'];?>" />
                    <table id="sleepstudyscrolltable" style="padding:0;margin-top:-3px">
                        <tr style="background: #444;height: 30px;">
                            <td colspan="4" style="background: #444;">
                                <span style="color: #ccc;"><?= $followUp['followupid'];?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #F9FFDF;">
                                <input type="text" size="12" style="width:75px;"  class="calendar" id="ep_dateadd_<?= $followUp['followupid'];?>" name="ep_dateadd" value="<?= ($followUp['ep_dateadd'])?date('m/d/Y', strtotime($followUp['ep_dateadd'])):''; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <select name="devadd" style="width:150px;">
                                    <?php
                                    foreach ($devices as $device) { ?>
                                        <option <?= ($device['deviceid'] == $followUp['devadd']) ? 'selected="selected"' : ''; ?>value="<?= st($device['deviceid']) ?>"><?= st($device['device']); ?></option>
                                        <?php
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #F9FFDF;">
                                <input type="text" size="12" name="dsetadd" value="<?= $followUp['dsetadd']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <select name="nightsperweek" style="width:150px;">
                                    <?php
                                    for ($i = 0; $i <= 7; $i++) { ?>
                                        <option <?= ($i == $followUp['nightsperweek']) ? 'selected' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                                        <?php
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <input type="text" size="12" id="ep_eadd_<?= $followUp['followupid']; ?>" name="ep_eadd" value="<?= $followUp['ep_eadd'];?>" onclick="loadPopup('summ_subj_ess.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=<?= $followUp['followupid']; ?>');return false;" />
                            </td>
                        </tr>
                        <!--- ESS ANSWERS -->
                        <tr style="display:none;">
                            <td style="background: #E4FFCF;">
                                <?php
                                if ($epworthResult) {
                                    foreach ($epworthResult as $epworthRecord) {
                                        if ($epworthRecord['followupid'] == $followUp['followupid']) { ?>
                                            <input type="text" size="12" id="epworth_<?= $followUp['followupid']; ?>_<?= $epworthResult['epworthid']; ?>" name="epworth_<?= $followUp['followupid']; ?>_<?= $epworthResult['epworthid']; ?>" value="<?= $epworthResult['answer']; ?>" /><br />
                                            <?php
                                        }
                                    }
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #F9FFDF;">
                                <input type="text" size="12" id="ep_tsadd_<?= $followUp['followupid']; ?>" name="ep_tsadd" value="<?= $followUp['ep_tsadd']; ?>" onclick="loadPopup('summ_subj_tss.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&id=<?= $followUp['followupid']; ?>');return false;" />
                            </td>
                        </tr>
                        <tr style="display:none;">
                            <td style="background: #E4FFCF;">
                                <?php
                                if ($thorntons) {
                                    foreach ($thorntons as $thornton) {
                                        if ($thornton['followupid'] == $followUp['followupid']) { ?>
                                            <input type="text" size="12" id="thornton_<?= $followUp['followupid']; ?>_<?= $thornton['thorntonid']; ?>" name="thornton_<?= $followUp['followupid'];?>_<?= $thornton['thorntonid'] ?>" value="<?= $thornton['answer'] ?>" /><br />
                                            <?php
                                        }
                                    }
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <input type="text" size="12" name="ep_sadd" value="<?= $followUp['ep_sadd']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <input type="text" size="12" name="ep_eladd" value="<?= $followUp['ep_eladd']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #F9FFDF;">
                                <input type="text" size="12" name="sleep_qualadd" value="<?= $followUp['sleep_qualadd']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <?php
                                $morning_headaches = $followUp['ep_hadd']; ?>
                                <select name="ep_hadd" class="field text addr tbox" style="width:150px;">
                                    <option value=""></option>
                                    <option value="Most Mornings" <?php if ($morning_headaches == 'Most Mornings') echo " selected"; ?>>
                                        Most Mornings
                                    </option>
                                    <option value="Several times per week" <?php if ($morning_headaches == 'Several times per week') echo " selected"; ?>>
                                        Several times per week
                                    </option>
                                    <option value="Several times per month" <?php if ($morning_headaches == 'Several times per month') echo " selected"; ?>>
                                        Several times per month
                                    </option>
                                    <option value="Occasionally" <?php if ($morning_headaches == 'Occasionally') echo " selected"; ?>>
                                        Occasionally
                                    </option>
                                    <option value="Rarely" <?php if ($morning_headaches == 'Rarely') echo " selected"; ?>>
                                        Rarely
                                    </option>
                                    <option value="Never" <?php if ($morning_headaches == 'Never') echo " selected"; ?>>
                                        Never
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #F9FFDF;">
                                <input type="text" size="12" name="ep_wadd" value="<?= $followUp['ep_wadd']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <input type="text" size="12" style="width:90px;" name="wapnadd" value="<?= $followUp['wapnadd']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #F9FFDF;">
                                <input type="text" size="12" name="hours_sleepadd" value="<?= $followUp['hours_sleepadd'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <input type="text" size="12" name="appt_notesadd" value="<?= $followUp['appt_notesadd']; ?>" style="width:100px;" />
                            </td>
                        </tr>
                        <tr>
                            <td style="background: #E4FFCF;">
                                <input type="hidden" name="patientid" value="<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" />
                                <input type="submit" name="submitupdatefu" onclick="window.onbeforeunload=false;" value="Save Follow Up" id="submitupdatefu_<?= $followUp['followupid'];?>" style="width:120px;" />
                                <input type="submit" name="submitdeletefu" onclick="return confirm('Are you sure you want to delete this follow up?');" value="Delete" id="submitdeletefu" style="width:120px;" />
                            </td>
                        </tr>
                    </table>
                </form>
                <?php
            }
        }
    }

    $q_sql = "SELECT * FROM dental_q_page1 WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
    $q_row = $db->getRow($q_sql);

    $t_sql = "SELECT tot_score FROM dental_thorton WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
    $t_row = $db->getRow($t_sql);

    $s_sql = "SELECT analysis FROM dental_q_sleep WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
    $s_row = $db->getRow($s_sql);
    $ep = preg_replace("/[^0-9]/", '', $s_row['analysis']);
    ?>

    <form style="float:left;" class="sleepstudybaseline" id="sleepstudybaseline" method="post" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
        <input type="hidden" name="id" value="baseline" />
        <table id="sleepstudyscrolltable" style="padding:0;margin-top:-3px">
            <tr style="background: #444;height: 30px;">
                <td colspan="4" style="background: #444;"><span style="color: #ccc;">Baseline</span></td>
            </tr>
            <?php
            $s = "SELECT initial_device_titration_1 FROM dental_summary WHERE patientid='".$db->escape(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
            $r = $db->getRow($s); ?>
            <tr>
                <td style="background: #F9FFDF;">
                    <input type="text" size="12" style="width:75px;" name="exam_date" value="<?= ($q_row['exam_date']) ? date('m/d/Y', strtotime($q_row['exam_date'])) : ''; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <select name="devadd" class="no_questionnaire" style="width:150px;">
                        <?php
                        $device_sql = "select * from dental_device where status=1 order by sortby";
                        $device_my = $db->getResults($device_sql);
                        foreach ($device_my as $device_myarray) { ?>
                            <option value="<?= st($device_myarray['deviceid']) ?>"><?= st($device_myarray['device']); ?></option>
                            <?php
                        } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="background: #F9FFDF;">
                    <input type="text" size="12" name="dsetadd" class="no_questionnaire" value="" />
                </td>
            <tr>
                <td style="background: #E4FFCF;">
                    <select name="nightsperweek" class="no_questionnaire" style="width:150px;">
                        <?php
                        for ($i = 0; $i <= 7; $i++) { ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                            <?php
                        } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <input type="text" size="12" name="ep_eadd" value="<?= $q_row['ess']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #F9FFDF;">
                    <input type="text" size="12" name="tot_score" value="<?= $q_row['tss']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <input type="text" size="12" name="ep_sadd" value="<?= $q_row['snoring_sound']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <input type="text" size="12" name="energy_level" value="<?= $q_row['energy_level']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #F9FFDF;">
                    <input type="text" size="12" name="sleep_qual" value="<?= $q_row['sleep_qual']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <?php
                    $morning_headaches = $q_row['morning_headaches']; ?>
                    <select name="morning_headaches" class="field text addr tbox" style="width:150px;">
                        <option value=""></option>
                        <option value="Most Mornings" <?php if ($morning_headaches == '0') echo " selected"; ?>>Most Mornings</option>
                        <option value="Several times per week" <?php if ($morning_headaches == '1') echo " selected"; ?>>Several times per week</option>
                        <option value="Several times per month" <?php if ($morning_headaches == '2') echo " selected"; ?>>Several times per month</option>
                        <option value="Occasionally" <?php if ($morning_headaches == '3') echo " selected"; ?>>Occasionally</option>
                        <option value="Rarely" <?php if ($morning_headaches == '3') echo " selected"; ?>>Rarely</option>
                        <option value="Never" <?php if ($morning_headaches == '4') echo " selected"; ?>>Never</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="background: #F9FFDF;">
                    <input type="text" size="12" name="wake_night" value="<?= $q_row['wake_night']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <input type="text" size="12" style="width:90px;" name="wapnadd" value="<?= $q_row['quit_breathing']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #F9FFDF;">
                    <input type="text" size="12" name="hours_sleepadd" value="<?= $q_row['hours_sleep']; ?>" />
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <input type="text" size="12" name="appt_notesadd" value="<?= $q_row['appt_notesadd'] ?>" style="width:100px;" />
                </td>
            </tr>
            <tr>
                <td style="background: #E4FFCF;">
                    <input type="hidden" name="patientid" value="<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" />
                    <input type="button" value="Edit Baseline" onclick="gotoQuestionnaire();" style="width:120px;" />
                </td>
            </tr>
        </table>
    </form>
    <script type="text/javascript" src="js/dss_followups.js?v=20160401"></script>
</div> 
