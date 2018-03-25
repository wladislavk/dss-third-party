<?php namespace Ds3\Libraries\Legacy; ?>
<table width="98%" class="table table-bordered table-hover">
    <tr>
        <th>Date</th>
        <th>Treatment</th>
        <th style="width: 80px">Letters</th>
        <th></th>
    </tr>
    <tr id="completed_row_temp" style="display:none;">
        <td>
            <input class="completed_date flow_comp_calendar form-control date text-center" id="completed_date_" type="text" value="" />
        </td>
        <td>
            <span class="title">Test</span>
        </td>
        <td class="letters">
            <a href="dss_summ.php?sect=leters&pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-info btn-sm"><?= (!empty($letter_count) ? $letter_count : ''); ?> Letters</a>
        </td>
        <td>
            <a href="#" onclick="return delete_segment('<?= (!empty($id) ? $id : ''); ?>');" class="addButton deleteButton btn btn-danger btn-sm">Delete</a>
        </td>
    </tr>
    <?php
    $segments = [];
    $segments[15] = "Baseline Sleep Test";
    $segments[2] = "Consult";
    $segments[4] = "Impressions";
    $segments[7] = "Device Delivery";
    $segments[8] = "Check / Follow Up";
    $segments[3] = "Titration Sleep Study";
    $segments[11] = "Treatment Complete";
    $segments[12] = "Annual Recall";
    $segments[14] = "Not a Candidate";
    $segments[5] = "Delaying Tx / Waiting";
    $segments[9] = "Pt. Non-Compliant";
    $segments[6] = "Refused Treatment";
    $segments[13] = "Termination";
    $segments[1] = "Initial Contact";

    $flow_pg2_info_query = "SELECT * FROM dental_flow_pg2_info WHERE patientid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY date_completed DESC, id DESC;";
    if (isset($db) && $db instanceof Db) {
        $flow_pg2_info_res = $db->getResults($flow_pg2_info_query);
    }

    foreach ($flow_pg2_info_res as $row) {
        $datesched = (!empty($row['date_scheduled'])) ? date('m/d/Y', strtotime($row['date_scheduled'])) : '';
        $datecomp = (!empty($row['date_completed'])) ? date('m/d/Y', strtotime($row['date_completed'])) : '';
        $id = $row['id'];
        if ($datecomp != '') { ?>
            <tr id="completed_row_<?= $id; ?>">
                <td>
                    <input class="completed_date flow_comp_calendar form-control date text-center" id="completed_date_<?= $id; ?>" type="text" value="<?= $datecomp; ?>" />
                </td>
                <td class="form-inline">
                    <span class="title"><?= $segments[$row['segmentid']]; ?></span>
                    <?php
                    switch ($row['segmentid']) {
                        case 3: //sleep study ?>
                            <br />
                            <select class="study_type form-control" id="study_type_<?= $id; ?>" name="data[<?= $id; ?>][study_type]" style="width:150px;">
                                <option value="">Select Type</option>
                                <option value="HST Titration" <?= ($row['study_type'] == "HST Titration") ? 'selected="selected"' : ''; ?>>HST Titration</option>
                                <option value="PSG Titration" <?= ($row['study_type'] == "PSG Titration") ? 'selected="selected"' : ''; ?>>PSG Titration</option>
                            </select>
                            <?php
                            break;
                        case 15: //sleep study ?>
                            <br />
                            <select class="study_type form-control" id="study_type_<?= $id; ?>" name="data[<?= $id; ?>][study_type]" style="width:150px;">
                                <option value="">Select Type</option>
                                <option value="HST Baseline" <?= ($row['study_type'] == "HST Baseline") ? 'selected="selected"' : ''; ?>>HST Baseline</option>
                                <option value="PSG Baseline" <?= ($row['study_type'] == "PSG Baseline") ? 'selected="selected"' : ''; ?>>PSG Baseline</option>
                            </select>
                            <?php
                            break;
                        case 5: //Delay ?>
                            <input type="hidden" value="<?= $row['delay_reason']; ?>" id="old_delay_reason_<?= $id; ?>" />
                            <select class="delay_reason form-control" onfocus="$('#old_delay_reason_<?= $id; ?>').val(this.value);" id="delay_reason_<?= $id; ?>" name="data[<?= $id; ?>][delay_reason]" style="width:94px;">
                                <option <?= ($row['delay_reason'] == "insurance") ? "selected " : ""; ?>value="insurance">Insurance</option>
                                <option <?= ($row['delay_reason'] == "dental work") ? "selected " : ""; ?>value="dental work">Dental Work</option>
                                <option <?= ($row['delay_reason'] == "deciding") ? "selected " : ""; ?>value="deciding">Deciding</option>
                                <option <?= ($row['delay_reason'] == "sleep study") ? "selected " : ""; ?>value="sleep study">Sleep Study</option>
                                <option <?= ($row['delay_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
                            </select>
                            <br />
                            <a id="reason_btn<?= $id; ?>" <?= ($row['delay_reason'] != 'other') ? 'style="display:none;"' : ''; ?> onclick="loadPopup('flowsheet_other_reason.php?ed=<?= $id ?>&pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : '')?>&sid=5');" href="#">Show Reason</a>
                            <?php
                            break;
                        case 9: // ?>
                            <br />
                            <input type="hidden" value="<?= $row['noncomp_reason']; ?>" id="old_noncomp_reason_<?= $id; ?>" />
                            <select class="noncomp_reason form-control" onfocus="$('#old_noncomp_reason_<?= $id; ?>').val(this.value);" id="noncomp_reason<?= $id; ?>" name="data[<?= $id; ?>][noncomp_reason]" style="width:94px;">
                                <option <?= ($row['noncomp_reason'] == "pain/discomfort") ? "selected " : ""; ?>value="pain/discomfort">Pain/Discomfort</option>
                                <option <?= ($row['noncomp_reason'] == "lost device") ? "selected " : ""; ?>value="lost device">Lost Device</option>
                                <option <?= ($row['noncomp_reason'] == "device not working") ? "selected " : ""; ?>value="device not working">Device Not Working</option>
                                <option <?= ($row['noncomp_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
                            </select>
                            <br />
                            <a id="reason_btn<?= $id; ?>" <?= ($row['noncomp_reason'] != 'other') ? 'style="display:none;"' : ''; ?> onclick="loadPopup('flowsheet_other_reason.php?ed=<?= $id ?>&pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : '')?>&sid=9');" href="#">Show Reason</a>
                            <?php
                            break;
                        case 4:
                        case 7: ?>
                            <select class="dentaldevice form-control" id="dentaldevice_<?= $id; ?>" style="width:150px">
                                <option value=""></option>
                                <?php
                                $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                                $device_my = $db->getResults($device_sql);
                                foreach ($device_my as $device_myarray) { ?>
                                    <option <?= ($device_myarray['deviceid'] == $row['device_id']) ? 'selected="selected"' : ''; ?>value="<?= st($device_myarray['deviceid']) ?>"><?= st($device_myarray['device']); ?></option>
                                    <?php
                                } ?>
                            </select>
                            <?php
                            break;
                    } ?>
                </td>
                <td class="letters">
                    <?php
                    $dental_letters_query = "
                        SELECT topatient, md_list, md_referral_list, status 
                        FROM dental_letters 
                        LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id 
                        WHERE patientid = '".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' 
                        AND info_id ='".$id."' 
                        AND deleted=0 
                        ORDER BY stepid ASC;
                    ";
                    $dlq = $db->getResults($dental_letters_query);
                    $letter_count = 0;
                    $sent = false;
                    if ($dlq) {
                        foreach ($dlq as $dlr) {
                            $topatient = ($dlr['topatient']) ? 1 : 0;
                            $md_list = ($dlr['md_list'] != '') ? count(explode(',', $dlr['md_list'])) : 0;
                            $md_referral_list = ($dlr['md_referral_list'] != '') ? count(explode(',', $dlr['md_referral_list'])) : 0;
                            $letter_count += $topatient + $md_list + $md_referral_list;
                            if ($dlr['status'] == 1) {
                                $sent = true;
                            }
                        }
                    }
                    if ($letter_count > 0) { ?>
                        <a href="dss_summ.php?sect=letters&pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-info btn-sm"><?= $letter_count; ?> Letters</a>
                        <?php
                    } else { ?>
                        <a class="btn btn-info btn-sm" disabled>0 Letters</a>
                        <?php
                    } ?>
                </td>
                <td>
                    <?php
                    if ($row['segmentid'] != 1) {
                        if ($sent) { ?>
                            <a href="#" onclick="alert('Letters have been sent. Unable to delete step.');" class="addButton deleteButton btn btn-danger btn-sm">Delete</a>
                            <?php
                        } else { ?>
                            <a href="#" onclick="return delete_segment('<?= $id; ?>');" class="addButton deleteButton btn btn-danger btn-sm">Delete</a>
                            <?php
                        }
                    } ?>
                </td>
            </tr>
            <?php
        }
    } ?>
</table>

<script src="js/appointment_summary.js" type="text/javascript"></script>

<div id="delay_reason_tmp" style="display:none;">
    <input type="hidden" class="old_delay_reason" id="old_delay_reason_" />
    <select class="delay_reason form-control" id="delay_reason_" style="width:94px;">
        <option <?= (!empty($row['delay_reason']) && $row['delay_reason'] == "insurance") ? "selected " : ""; ?>value="insurance">Insurance</option>
        <option <?= (!empty($row['delay_reason']) && $row['delay_reason'] == "dental work") ? "selected " : ""; ?>value="dental work">Dental Work</option>
        <option <?= (!empty($row['delay_reason']) && $row['delay_reason'] == "deciding") ? "selected " : ""; ?>value="deciding">Deciding</option>
        <option <?= (!empty($row['delay_reason']) && $row['delay_reason'] == "sleep study") ? "selected " : ""; ?>value="sleep study">Sleep Study</option>
        <option <?= (!empty($row['delay_reason']) && $row['delay_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
    </select>
    <br />
    <a class="reason_btn" id="reason_btn<?= (!empty($id) ? $id : ''); ?>" style="display:none;" onclick="loadPopup('flowsheet_other_reason.php?ed=<?= (!empty($id) ? $id : '')?>&pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sid=5');" href="#">Show Reason</a>
</div>

<div id="noncomp_reason_tmp" style="display:none;">
    <input type="hidden" class="old_noncomp_reason" id="old_noncomp_reason_" />
    <select class="noncomp_reason form-control" id="noncomp_reason_" style="width:94px;">
        <option <?= (!empty($row['noncomp_reason']) && $row['noncomp_reason'] == "pain/discomfort") ? "selected " : ""; ?>value="pain/discomfort">Pain/Discomfort</option>
        <option <?= (!empty($row['noncomp_reason']) && $row['noncomp_reason'] == "lost device") ? "selected " : ""; ?>value="lost device">Lost Device</option>
        <option <?= (!empty($row['noncomp_reason']) && $row['noncomp_reason'] == "device not working") ? "selected " : ""; ?>value="device not working">Device Not Working</option>
        <option <?= (!empty($row['noncomp_reason']) && $row['noncomp_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
    </select>
    <br />
    <a class="reason_btn" id="reason_btn<?= (!empty($id) ? $id : ''); ?>" style="display:none;" onclick="loadPopup('flowsheet_other_reason.php?ed=<?= (!empty($id) ? $id : '')?>&pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sid=9');" href="#">Show Reason</a>
</div>

<div id="sleep_study_titration_tmp" style="display:none;">
    <select class="study_type form-control" id="study_type_" style="width:150px;">
        <option value="">Select Type</option>
        <option value="HST Titration" <?= (!empty($row['study_type']) && $row['study_type'] == "HST Titration") ? 'selected="selected"' : ''; ?>>HST Titration</option>
        <option value="PSG Titration" <?= (!empty($row['study_type']) && $row['study_type'] == "PSG Titration") ? 'selected="selected"' : ''; ?>>PSG Titration</option>
    </select>
</div>

<div id="sleep_study_baseline_tmp" style="display:none;">
    <select class="study_type form-control" id="study_type_" style="width:150px;">
        <option value="">Select Type</option>
        <option value="HST Baseline" <?= (!empty($row['study_type']) && $row['study_type'] == "HST Baseline") ? 'selected="selected"' : ''; ?>>HST Baseline</option>
        <option value="PSG Baseline" <?= (!empty($row['study_type']) && $row['study_type'] == "PSG Baseline") ? 'selected="selected"' : ''; ?>>PSG Baseline</option>
    </select>
</div>

<div id="dentaldevice_tmp" style="display:none;">
    <select class="dentaldevice form-control" id="dentaldevice_" style="width:150px">
        <option value=""></option>
        <?php
        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
        $device_my = $db->getResults($device_sql);
        foreach ($device_my as $device_myarray) { ?>
            <option <?= (!empty($row['device_id']) && $device_myarray['deviceid'] == $row['device_id']) ? 'selected="selected"' : ''; ?>value="<?= st($device_myarray['deviceid'])?>"><?= st($device_myarray['device']); ?></option>
            <?php
        } ?>
    </select>
</div>
