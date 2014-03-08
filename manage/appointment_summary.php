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
            <a href="dss_summ.php?sect=leters&pid=<?= $_GET['pid']; ?>"><?= $letter_count; ?> Letters</a>
        </td>
        <td>
            <a href="#" onclick="return delete_segment('<?= $id; ?>');" class="addButton deleteButton">Delete</a>
        </td>
    </tr>
    <?php
    
    $segments = Array();
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
    
    $flow_pg2_info_query = "SELECT * FROM dental_flow_pg2_info WHERE patientid = '".$_GET['pid']."' ORDER BY date_completed DESC, id DESC;";
    $flow_pg2_info_res = mysql_query($flow_pg2_info_query);
    
    while ($row = mysql_fetch_assoc($flow_pg2_info_res)) {
        $datesched = ($row['date_scheduled']!='')?date('m/d/Y', $row['date_scheduled']):'';
        $datecomp = ($row['date_completed']!='')?date('m/d/Y', strtotime($row['date_completed'])):'';
        $id = $row['id'];
        
        if ($datecomp !='') { ?>
    <tr id="completed_row_<?= $id; ?>">
        <td>
            <input class="completed_date flow_comp_calendar form-control date text-center" id="completed_date_<?= $id; ?>" type="text" value="<?= $datecomp; ?>" />
        </td>
        <td>
            <span class="title"><?= $segments[$row['segmentid']]; ?></span>
            <?php
            
            switch ($row['segmentid']) {
                case 3: //sleep study ?>
            <br />
            <select class="study_type" id="study_type_<?php echo $id; ?>" name="data[<?php echo $id; ?>][study_type]" style="width:150px;">
                <option value="">Select Type</option>
                <option value="HST Titration" <?= ($row['study_type']=="HST Titration")?'selected="selected"':''; ?>>HST Titration</option>
                <option value="PSG Titration" <?= ($row['study_type']=="PSG Titration")?'selected="selected"':''; ?>>PSG Titration</option>
            </select>
                    <?php
                    
                    break;
                
                case 15: //sleep study ?>
            <br />
            <select class="study_type" id="study_type_<?php echo $id; ?>" name="data[<?php echo $id; ?>][study_type]" style="width:150px;">
                <option value="">Select Type</option>
                <option value="HST Baseline" <?= ($row['study_type']=="HST Baseline")?'selected="selected"':''; ?>>HST Baseline</option>
                <option value="PSG Baseline" <?= ($row['study_type']=="PSG Baseline")?'selected="selected"':''; ?>>PSG Baseline</option>
			</select>
                    <?php
                    
                    break;
                
                case 5: //Delay ?>
            <input type="hidden" value="<?= $row['delay_reason']; ?>" id="old_delay_reason_<?= $id; ?>" />
            <select class="delay_reason" onfocus="$('#old_delay_reason_<?= $id; ?>').val(this.value);" id="delay_reason_<?php echo $id; ?>" name="data[<?php echo $id; ?>][delay_reason]" style="width:94px;">
                <option <?php print ($row['delay_reason'] == "insurance") ? "selected " : ""; ?>value="insurance">Insurance</option>
                <option <?php print ($row['delay_reason'] == "dental work") ? "selected " : ""; ?>value="dental work">Dental Work</option>
                <option <?php print ($row['delay_reason'] == "deciding") ? "selected " : ""; ?>value="deciding">Deciding</option>
                <option <?php print ($row['delay_reason'] == "sleep study") ? "selected " : ""; ?>value="sleep study">Sleep Study</option>
                <option <?php print ($row['delay_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
            </select>
            <br />
            <a id="reason_btn<?php echo $id; ?>" <?= ($row['delay_reason']!='other')?'style="display:none;"':''; ?> onclick="Javascript: loadPopup('flowsheet_other_reason.php?ed=<?=$id?>&pid=<?=$_GET['pid']?>&sid=5');" href="Javascript: ;">Show Reason</a>
                    <?php
                    
                    break;
                
                case 9: // ?>
            <br />
            <input type="hidden" value="<?= $row['noncomp_reason']; ?>" id="old_noncomp_reason_<?= $id; ?>" />
            <select class="noncomp_reason" onfocus="$('#old_noncomp_reason_<?= $id; ?>').val(this.value);" id="noncomp_reason<?php echo $id; ?>" name="data[<?php echo $id; ?>][noncomp_reason]" style="width:94px;">
                <option <?php print ($row['noncomp_reason'] == "pain/discomfort") ? "selected " : ""; ?>value="pain/discomfort">Pain/Discomfort</option>
                <option <?php print ($row['noncomp_reason'] == "lost device") ? "selected " : ""; ?>value="lost device">Lost Device</option>
                <option <?php print ($row['noncomp_reason'] == "device not working") ? "selected " : ""; ?>value="device not working">Device Not Working</option>
                <option <?php print ($row['noncomp_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
            </select>
            <br />
            <a id="reason_btn<?php echo $id; ?>" <?= ($row['noncomp_reason']!='other')?'style="display:none;"':''; ?> onclick="Javascript: loadPopup('flowsheet_other_reason.php?ed=<?=$id?>&pid=<?=$_GET['pid']?>&sid=9');" href="Javascript: ;">Show Reason</a>
                    <?php
                    
                    break;
                
                case 4:
                case 7: ?>
            <select class="dentaldevice" id="dentaldevice_<?php echo $id; ?>" style="width:150px">
                <option value=""></option>
                <?php
                
                $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                $device_my = mysql_query($device_sql);
                
                while ($device_myarray = mysql_fetch_array($device_my)) { ?>
                    <option <?= ($device_myarray['deviceid']==$row['device_id'])?'selected="selected"':''; ?>value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                <?php } ?>
            </select>
                    <?php
                    
                    break;
            } ?>
        </td>
        <td class="letters">
            <?php
            
            $dental_letters_query = "SELECT topatient, md_list, md_referral_list, status FROM dental_letters LEFT JOIN dental_letter_templates ON dental_letters.templateid=dental_letter_templates.id WHERE patientid = '".$_GET['pid']."' AND info_id ='".$id."' AND deleted=0 ORDER BY stepid ASC;";
            $dlq = mysql_query($dental_letters_query);
            $letter_count = 0;
            $sent = false;
            
            while ($dlr = mysql_fetch_assoc($dlq)) {
                $topatient = ($dlr['topatient'])?1:0;
                $md_list= ($dlr['md_list']!='')?count(explode(',',$dlr['md_list'])):0;
                $md_referral_list = ($dlr['md_referral_list']!='')?count(explode(',',$dlr['md_referral_list'])):0;
                $letter_count += $topatient+$md_list+$md_referral_list;
                
                if ($dlr['status']==1) {
                    $sent = true;
                }
            }
            
            if ($letter_count > 0) { ?>
                <a href="dss_summ.php?sect=letters&pid=<?= $_GET['pid']; ?>"><?= $letter_count; ?> Letters</a>
            <?php } else { ?>
                0 Letters
            <?php } ?>
        </td>
        <td>
            <?php
            
            if ($row['segmentid']!=1) { ?>
                <?php if ($sent) { ?>
                    <a href="#" onclick="alert('Letters have been sent. Unable to delete step.');" class="addButton deleteButton">Delete</a>
                <?php } else { ?>
                    <a href="#" onclick="return delete_segment('<?= $id; ?>');" class="addButton deleteButton">Delete</a>
                <?php } ?>
            <?php } ?>
        </td>
    </tr>
        <?php }
    } ?>
</table>
<script type="text/javascript">
function delete_segment (id) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        $.ajax({
            url: "/manage/includes/delete_appt.php",
            type: "post",
            data: {
                id: id,
                pid: <?= $_GET['pid']; ?>
            },
            success: function(data){
                //alert(data);
                var r = $.parseJSON(data);
                
                if (r.error) {
                    if (r.error == 'sent') {
                        //alert('Letter sent');
                    }
                }
                else {
                    $('#completed_row_'+id).remove();
                }
            },
            failure: function(data){
                //alert('fail');
            }
        });
    }
    else {
        return false;
    }
}

function update_completed_date (cid) {
    id = cid.substring(15);
    comp_date = $('#completed_date_'+id).val();
    
    $.ajax({
        url: "/manage/includes/update_appt.php",
        type: "post",
        data: {
            id: id,
            comp_date: comp_date,
            pid: <?= $_GET['pid']; ?>
        },
        success: function(data){
            //alert(data);
            var r = $.parseJSON(data);
            
            if (r.error) {}
            else {}
        },
        failure: function(data){
            //alert('fail');
        }
    });
}

$(document).delegate('.delay_reason', "change", function(){
    id = $(this).attr('id').substring(13);
    reason = $(this).val();
    
    if ($('#old_delay_reason_'+id).val()=="other" && reason !="other") {
        if(!confirm('Are you sure you want to change the reason?')) {
            $(this).val($('#old_delay_reason_'+id).val());
            return false;
        }
    }
    
    $.ajax({
        url: "/manage/includes/flow_delay_reason_update.php",
        type: "post",
        data: {
            id: id,
            reason: reason,
            pid: <?= $_GET['pid']; ?>
        },
        success: function(data){
            //alert(data);
            var r = $.parseJSON(data);
            
            if (r.error) {}
            else {
                if (reason == "other") {
                    $(document).find('#reason_btn'+id).show();
                    loadPopup('flowsheet_other_reason.php?ed='+id+'&pid=112&sid=5');
                }
                else {
                    $(document).find('#reason_btn'+id).hide();
                }
            }
        },
        failure: function(data){
            //alert('fail');
        }
    });
});

$(document).delegate('.noncomp_reason', "change", function () {
    id = $(this).attr('id').substring(14);
    reason = $(this).val();
    
    if ($('#old_noncomp_reason_' + id).val() == "other" && reason != "other") {
        if (!confirm('Are you sure you want to change the reason?')) {
            $(this).val($('#old_noncomp_reason_' + id).val());
            return false;
        }
    }
    
    $.ajax({
        url: "/manage/includes/flow_noncomp_reason_update.php",
        type: "post",
        data: {
            id: id,
            reason: reason,
            pid: <?= $_GET['pid']; ?>
        },
        success: function (data) {
            //alert(data);
            var r = $.parseJSON(data);
            if (r.error) {} else {
                if (reason == "other") {
                    $(document).find('#reason_btn' + id).show();
                    loadPopup('flowsheet_other_reason.php?ed=' + id + '&pid=112&sid=5');
                } else {
                    $(document).find('#reason_btn' + id).hide();
                }

            }
        },
        failure: function (data) {
            //alert('fail');
        }
    });
});


$(document).delegate('.dentaldevice', "change", function () {
    id = $(this).attr('id').substring(13);
    device = $(this).val();
    $.ajax({
        url: "/manage/includes/flow_device_update.php",
        type: "post",
        data: {
            id: id,
            device: device,
            pid: <?= $_GET['pid']; ?>
        },
        success: function (data) {
            //alert(data);
            var r = $.parseJSON(data);
            if (r.error) {} else {}
        },
        failure: function (data) {
            //alert('fail');
        }
    });
});

$(document).delegate('.study_type', "change", function () {
    id = $(this).attr('id').substring(11);
    type = $(this).val();
    $.ajax({
        url: "/manage/includes/flow_study_type_update.php",
        type: "post",
        data: {
            id: id,
            type: type,
            pid: <?= $_GET['pid']; ?>
        },
        success: function (data) {
            //alert(data);
            var r = $.parseJSON(data);
            if (r.error) {} else {}
        },
        failure: function (data) {
            //alert('fail');
        }
    });
});
</script>

<div id="delay_reason_tmp" style="display:none;">
    <input type="hidden" class="old_delay_reason" id="old_delay_reason_" />
    <select class="delay_reason" id="delay_reason_" style="width:94px;">
        <option <?php print ($row['delay_reason'] == "insurance") ? "selected " : ""; ?>value="insurance">Insurance</option>
        <option <?php print ($row['delay_reason'] == "dental work") ? "selected " : ""; ?>value="dental work">Dental Work</option>
        <option <?php print ($row['delay_reason'] == "deciding") ? "selected " : ""; ?>value="deciding">Deciding</option>
        <option <?php print ($row['delay_reason'] == "sleep study") ? "selected " : ""; ?>value="sleep study">Sleep Study</option>
        <option <?php print ($row['delay_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
    </select>
    <br />
    <a class="reason_btn" id="reason_btn<?php echo $id; ?>" style="display:none;" onclick="Javascript: loadPopup('flowsheet_other_reason.php?ed=<?=$id?>&pid=<?=$_GET['pid']?>&sid=5');" href="Javascript: ;">Show Reason</a>
</div>

<div id="noncomp_reason_tmp" style="display:none;">
    <input type="hidden" class="old_noncomp_reason" id="old_noncomp_reason_" />
    <select class="noncomp_reason" id="noncomp_reason_" style="width:94px;">
        <option <?php print ($row['noncomp_reason'] == "pain/discomfort") ? "selected " : ""; ?>value="pain/discomfort">Pain/Discomfort</option>
        <option <?php print ($row['noncomp_reason'] == "lost device") ? "selected " : ""; ?>value="lost device">Lost Device</option>
        <option <?php print ($row['noncomp_reason'] == "device not working") ? "selected " : ""; ?>value="device not working">Device Not Working</option>
        <option <?php print ($row['noncomp_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
    </select>
    <br />
    <a class="reason_btn" id="reason_btn<?php echo $id; ?>" style="display:none;" onclick="Javascript: loadPopup('flowsheet_other_reason.php?ed=<?=$id?>&pid=<?=$_GET['pid']?>&sid=9');" href="Javascript: ;">Show Reason</a>
</div>

<div id="sleep_study_titration_tmp" style="display:none;">
    <select class="study_type" id="study_type_" style="width:150px;">
        <option value="">Select Type</option>
        <option value="HST Titration" <?= ($row['study_type']=="HST Titration")?'selected="selected"':''; ?>>HST Titration</option>
        <option value="PSG Titration" <?= ($row['study_type']=="PSG Titration")?'selected="selected"':''; ?>>PSG Titration</option>
    </select>
</div>

<div id="sleep_study_baseline_tmp" style="display:none;">
    <select class="study_type" id="study_type_" style="width:150px;">
        <option value="">Select Type</option>
        <option value="HST Baseline" <?= ($row['study_type']=="HST Baseline")?'selected="selected"':''; ?>>HST Baseline</option>
        <option value="PSG Baseline" <?= ($row['study_type']=="PSG Baseline")?'selected="selected"':''; ?>>PSG Baseline</option>
    </select>
</div>

<div id="dentaldevice_tmp" style="display:none;">
    <select class="dentaldevice" id="dentaldevice_" style="width:150px">
        <option value=""></option>
        <?php
        
        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
        $device_my = mysql_query($device_sql);
        
        while ($device_myarray = mysql_fetch_array($device_my)) { ?>
		<option <?= ($device_myarray['deviceid']==$row['device_id'])?'selected="selected"':''; ?>value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
        <?php } ?>
    </select>
</div>
