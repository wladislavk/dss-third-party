<template>
    <table width="98%" class="table table-bordered table-hover">
        <tr>
            <th>Date</th>
            <th>Treatment</th>
            <th style="width: 80px">Letters</th>
            <th></th>
        </tr>
        <tr id="completed_row_temp" style="display:none;">
            <td>
                <input class="completed_date flow_comp_calendar form-control date text-center" id="completed_date_" type="text" />
            </td>
            <td>
                <span class="title">Test</span>
            </td>
            <td class="letters">
                <a
                    v-legacy-href="'dss_summ.php?sect=leters&pid=' + patientId"
                    class="btn btn-info btn-sm"
                ><?php echo (!empty($letter_count) ? $letter_count : ''); ?> Letters</a>
            </td>
            <td>
                <a
                    href="#"
                    v-on:click.prevent="return delete_segment('<?php echo (!empty($id) ? $id : ''); ?>')"
                    class="addButton deleteButton btn btn-danger btn-sm"
                >Delete</a>
            </td>
        </tr>
        <?php
          $datesched = (!empty($row['date_scheduled']))?date('m/d/Y', strtotime($row['date_scheduled'])):'';
          $datecomp = (!empty($row['date_completed']))?date('m/d/Y', strtotime($row['date_completed'])):'';
          if ($datecomp !='') {
        ?>
        <tr v-for="flowElement in flowElements" v-if="flowElement.date_completed" v-bind:id="'completed_row_' + flowElement.id">
            <td>
                <input
                    class="completed_date flow_comp_calendar form-control date text-center"
                    v-bind:id="'completed_date_' + flowElement.id"
                    type="text"
                    value="<?php echo $datecomp; ?>"
                />
            </td>
            <td class="form-inline">
                <span class="title"><?php echo $segments[$row['segmentid']]; ?></span>
                <?php
                  switch ($row['segmentid']) {
                    case 3: //sleep study ?>
                <br />
                <select
                    class="study_type form-control"
                    v-bind:id="'study_type_' + flowElement.id"
                    v-bind:name="'data[' + flowElement.id + '][study_type]'"
                    style="width:150px;"
                >
                    <option value="">Select Type</option>
                    <option value="HST Titration" <?php echo ($row['study_type']=="HST Titration")?'selected="selected"':''; ?>>HST Titration</option>
                    <option value="PSG Titration" <?php echo ($row['study_type']=="PSG Titration")?'selected="selected"':''; ?>>PSG Titration</option>
                </select>
                <?php
                    break;
                    case 15: //sleep study ?>
                <br />
                <select
                    class="study_type form-control"
                    v-bind:id="'study_type_' + flowElement.id"
                    v-bind:name="'data[' + flowElement.id + '][study_type]'"
                    style="width:150px;"
                >
                    <option value="">Select Type</option>
                    <option value="HST Baseline" <?php echo ($row['study_type']=="HST Baseline")?'selected="selected"':''; ?>>HST Baseline</option>
                    <option value="PSG Baseline" <?php echo ($row['study_type']=="PSG Baseline")?'selected="selected"':''; ?>>PSG Baseline</option>
                </select>
                <?php
                    break;
                    case 5: //Delay ?>
                <input type="hidden" v-bind:value="flowElement.delay_reason" v-bind:id="'old_delay_reason_' + flowElement.id" />
                <select
                    class="delay_reason form-control"
                    v-on:focus="$('#old_delay_reason_' + flowElement.id).val(this.value)"
                    v-bind:id="'delay_reason_' + flowElement.id"
                    v-bind:name="'data[' + flowElement.id + '][delay_reason]'"
                    style="width:94px;"
                >
                    <option <?php print ($row['delay_reason'] == "insurance") ? "selected " : ""; ?>value="insurance">Insurance</option>
                    <option <?php print ($row['delay_reason'] == "dental work") ? "selected " : ""; ?>value="dental work">Dental Work</option>
                    <option <?php print ($row['delay_reason'] == "deciding") ? "selected " : ""; ?>value="deciding">Deciding</option>
                    <option <?php print ($row['delay_reason'] == "sleep study") ? "selected " : ""; ?>value="sleep study">Sleep Study</option>
                    <option <?php print ($row['delay_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
                </select>
                <br />
                <a
                    v-bind:id="'reason_btn' + flowElement.id"
                    v-on:click="'loadPopup(\'flowsheet_other_reason.php?ed=' + flowElement.id + '&pid=' + patientId + '&sid=5\');'"
                    v-show="flowElement.delay_reason === 'other'"
                    href="#"
                >Show Reason</a>
                <?php
                    break;
                    case 9: // ?>
                <br />
                <input type="hidden" v-bind:value="flowElement.noncomp_reason" v-bind:id="'old_noncomp_reason_' + flowElement.id" />
                <select
                    class="noncomp_reason form-control"
                    v-on:focus="$('#old_noncomp_reason_' + flowElement.id).val(this.value)"
                    v-bind:id="'noncomp_reason' + flowElement.id"
                    v-bind:name="'data[' + flowElement.id + '][noncomp_reason]'"
                    style="width:94px;"
                >
                    <option <?php print ($row['noncomp_reason'] == "pain/discomfort") ? "selected " : ""; ?>value="pain/discomfort">Pain/Discomfort</option>
                    <option <?php print ($row['noncomp_reason'] == "lost device") ? "selected " : ""; ?>value="lost device">Lost Device</option>
                    <option <?php print ($row['noncomp_reason'] == "device not working") ? "selected " : ""; ?>value="device not working">Device Not Working</option>
                    <option <?php print ($row['noncomp_reason'] == "other") ? "selected " : ""; ?>value="other">Other</option>
                </select>
                <br />
                <a id="reason_btn<?php echo $id; ?>" <?php echo ($row['noncomp_reason']!='other')?'style="display:none;"':''; ?> onclick="Javascript: loadPopup('flowsheet_other_reason.php?ed=<?php echo $id?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '')?>&sid=9');" href="Javascript: ;">Show Reason</a>
                <?php
                    break;
                    case 4:
                    case 7: ?>
                <select class="dentaldevice form-control" v-bind:id="'dentaldevice_' + flowElement.id" style="width:150px">
                    <option value=""></option>
                    <?php
                    foreach ($device_my as $device_myarray) { ?>
                    <option <?php echo ($device_myarray['deviceid']==$row['device_id'])?'selected="selected"':''; ?>value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
                    <?php } ?>
                </select>
                <?php
                  break;
                }
                ?>
            </td>
            <td class="letters">
                <?php
                  $letter_count = 0;
                  $sent = false;
                  if ($dlq) {
                    foreach ($dlq as $dlr) {
                      $topatient = ($dlr['topatient'])?1:0;
                      $md_list= ($dlr['md_list']!='')?count(explode(',',$dlr['md_list'])):0;
                      $md_referral_list = ($dlr['md_referral_list']!='')?count(explode(',',$dlr['md_referral_list'])):0;
                      $letter_count += $topatient+$md_list+$md_referral_list;

                      if ($dlr['status']==1) {
                        $sent = true;
                      }
                    }
                  }
                  if ($letter_count > 0) { ?>
                <a v-legacy-href="'dss_summ.php?sect=letters&pid=' + patientId" class="btn btn-info btn-sm"><?php echo $letter_count; ?> Letters</a>
                <?php } else { ?>
                <a class="btn btn-info btn-sm" disabled>0 Letters</a>
                <?php } ?>
            </td>
            <td>
                <?php
                  if ($row['segmentid']!=1) {
                  if ($sent) { ?>
                <a href="#" onclick="alert('Letters have been sent. Unable to delete step.');" class="addButton deleteButton btn btn-danger btn-sm">Delete</a>
                <?php } else { ?>
                <a href="#" onclick="return delete_segment('<?php echo $id; ?>');" class="addButton deleteButton btn btn-danger btn-sm">Delete</a>
                <?php }
                  } ?>
            </td>
        </tr>
        <?php
          }
        ?>
    </table>
    <script src="js/appointment_summary.js" type="text/javascript"></script>
    <template v-if="lastFlowElement">
        <div id="delay_reason_tmp" style="display:none;">
            <input type="hidden" class="old_delay_reason" id="old_delay_reason_" />
            <select class="delay_reason form-control" id="delay_reason_" style="width:94px;">
                <option v-for="reason in delayReasons" v-model="lastFlowElement.delay_reason" v-bind:value="reason.value">{{ reason.text }}</option>
            </select>
            <br />
            <a
                class="reason_btn"
                v-bind:id="'reason_btn' + lastFlowElement.id"
                style="display:none;"
                v-on:click="'loadPopup(\'flowsheet_other_reason.php?ed=' + lastFlowElement.id + '&pid=' + patientId + '&sid=5\');'"
                href="#"
            >Show Reason</a>
        </div>
        <div id="noncomp_reason_tmp" style="display:none;">
            <input type="hidden" class="old_noncomp_reason" id="old_noncomp_reason_" />
            <select class="noncomp_reason form-control" id="noncomp_reason_" style="width:94px;">
                <option v-for="reason in nonComplianceReasons" v-model="lastFlowElement.noncomp_reason" v-bind:value="reason.value">{{ reason.text }}</option>
            </select>
            <br />
            <a
                class="reason_btn"
                v-bind:id="'reason_btn' + lastFlowElement.id"
                style="display:none;"
                v-on:click="'loadPopup(\'flowsheet_other_reason.php?ed=' + lastFlowElement.id + '&pid=' + patientId + '&sid=9\');'"
                href="#"
            >Show Reason</a>
        </div>
        <div id="sleep_study_titration_tmp" style="display:none;">
            <select class="study_type form-control" id="study_type_" style="width:150px;">
                <option value="">Select Type</option>
                <option value="HST Titration" <?php echo (!empty($row['study_type']) && $row['study_type']=="HST Titration")?'selected="selected"':''; ?>>HST Titration</option>
                <option value="PSG Titration" <?php echo (!empty($row['study_type']) && $row['study_type']=="PSG Titration")?'selected="selected"':''; ?>>PSG Titration</option>
            </select>
        </div>
        <div id="sleep_study_baseline_tmp" style="display:none;">
            <select class="study_type form-control" id="study_type_" style="width:150px;">
                <option value="">Select Type</option>
                <option value="HST Baseline" <?php echo (!empty($row['study_type']) && $row['study_type']=="HST Baseline")?'selected="selected"':''; ?>>HST Baseline</option>
                <option value="PSG Baseline" <?php echo (!empty($row['study_type']) && $row['study_type']=="PSG Baseline")?'selected="selected"':''; ?>>PSG Baseline</option>
            </select>
        </div>
        <div id="dentaldevice_tmp" style="display:none;">
            <select class="dentaldevice form-control" id="dentaldevice_" style="width:150px">
                <option value=""></option>
                <option v-for="device in devices" v-model="lastFlowElement.device_id" v-bind:value="device.deviceid">{{ device.device }}</option>
            </select>
        </div>
    </template>
</template>
