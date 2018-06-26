<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/patient_info.php';

$patientId = intval($_GET['pid']);

$isHistoricView = isset($_GET['history_id']);
$historyId = $isHistoricView ? intval($_GET['history_id']) : 0;
$isCreateNew = !empty($_POST['create_new']);

$feet = range(1, 8);
$feet = array_combine($feet, $feet);

$inches = range(0, 11);
$inches = array_combine($inches, $inches);

$weight = range(80, 500);
$weight = array_combine($weight, $weight);

$pulse = range(50, 150);
$pulse = array_combine($pulse, $pulse);

$neckMeasurement = range(5, 29, 0.5);
$neckMeasurement = array_combine($neckMeasurement, $neckMeasurement);

include __DIR__ . '/includes/form_top.htm';
?>
<style>
    .vue-module select, .vue-module textarea, .vue-module input[type=text] {
        width: 95%;
    }

    .vue-module select.inline, .vue-module input.inline {
        width: 10%;
    }
</style>
<p></p>
<div id="evaluation-management">
    <form class="q_form vue-module" name="ex_page10frm" method="post">
        <input type="hidden" name="patient_id" value="<?= $patientId ?>" />
        <input type="hidden" name="history_id" value="<?= $historyId ?>" />
        <input type="hidden" name="create_new" value="<?= $isCreateNew ?>" />
        <input type="hidden" name="goto_p" value="" />
        <div id="history-timestamps">
            <table>
                <colgroup>
                    <col width="60%" />
                    <col width="40%" />
                </colgroup>
                <tbody>
                <tr>
                    <td>Initiated:</td>
                    <td>{{ initiatedTimestamp | dateFormat displayDateFormat }}</td>
                </tr>
                <tr>
                    <td>Last Modified:</td>
                    <td>{{ lastModifiedTimestamp | dateFormat displayDateFormat }}</td>
                </tr>
                </tbody>
            </table>
            <select style="width: auto;">
                <option>
                    Create New and Archive &darr;
                </option>
                <option class="new-backup" data-section-name="<?= e($sectionName['name']) ?>">
                    Create New and Archive <?= e($sectionName['name']) ?>
                </option>
                <option class="backup-all-forms" data-section-name="<?= e(ucwords($sectionName['section'])) ?>">
                    Create New and Archive all pages of <?= e(ucwords($sectionName['section'])) ?>
                </option>
            </select>
        </div>
        <div align="right">
            <button
                class="save-action hidden"
                title="Save a copy of the last saved values"
                v-bind:disabled="backupInProgress ? true : false"
                v-on:click.prevent="backup"
            >
                <span v-show="!backupInProgress">Archive page</span>
                <span v-show="backupInProgress">Archiving... <img src="/manage/images/loading.gif" alt=""></span>
            </button>
            <button class="save-action" v-on:click.prevent="resetData">Undo Changes</button>
            <button class="save-action" v-on:click.prevent="save">Save</button>
            <button class="save-action" v-on:click.prevent="saveAndProceed">Save And Proceed</button>
            &nbsp;&nbsp;&nbsp;
        </div>
        <div is="errors-display" v-bind:errors="errors"></div>
        <h3>
            &nbsp;&nbsp;&nbsp;&nbsp;
            History
        </h3>
        <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
            <colgroup>
                <col width="40%" />
                <col width="60%" />
            </colgroup>
            <tr class="tr_bg_h">
                <th class="col_head" colspan="2">Chief complaint</th>
            </tr>
            <tr>
                <td>What is the main reason you are seeking treatment?</td>
                <td>
                    <textarea name="history[chief_complaint]" v-model="form.history.chief_complaint.value"></textarea>
                </td>
            </tr>
        </table>
        <p></p>
        <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
            <colgroup>
                <col width="40%" />
                <col width="60%" />
            </colgroup>
            <tr class="tr_bg_h">
                <th class="col_head" colspan="2">History of present illness</th>
            </tr>
            <tr>
                <td>Location</td>
                <td>
                    <input type="text" name="history[present][location]" v-model="form.history.present.location" />
                </td>
            </tr>
            <tr>
                <td>Quality</td>
                <td>
                    <input type="text" name="history[present][quality]" v-model="form.history.present.quality" />
                </td>
            </tr>
            <tr>
                <td>Severity</td>
                <td>
                    <input type="text" name="history[present][severity]" v-model="form.history.present.severity" />
                </td>
            </tr>
            <tr>
                <td>Duration</td>
                <td>
                    <input type="text" name="history[present][duration]" v-model="form.history.present.duration" />
                </td>
            </tr>
            <tr>
                <td>Timing</td>
                <td>
                    <input type="text" name="history[present][timing]" v-model="form.history.present.timing" />
                </td>
            </tr>
            <tr>
                <td>Context</td>
                <td>
                    <input type="text" name="history[present][context]" v-model="form.history.present.context" />
                </td>
            </tr>
            <tr>
                <td>Modifying factor</td>
                <td>
                    <input type="text" name="history[present][modifying_factor]" v-model="form.history.present.modifying_factor" />
                </td>
            </tr>
            <tr>
                <td>Associated signs/symptoms</td>
                <td>
                    <input type="text" name="history[present][symptoms]" v-model="form.history.present.symptoms" />
                </td>
            </tr>
        </table>
        <p></p>
        <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
            <colgroup>
                <col width="20%" />
                <col width="20%" />
                <col width="60%" />
            </colgroup>
            <tr class="tr_bg_h">
                <th class="col_head" colspan="3">Past family, medical and social history</th>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="desc">1. Past family history</label>
                </td>
                <td>
                    <textarea name="history[past][family]" v-model="familyHistory"></textarea>
                    <button v-on:click.prevent="loadCustomText('history.past.family.value')">Use custom text</button>
                </td>
            </tr>
            <tr>
                <td rowspan="4">
                    <label class="desc">2. Past medical history</label>
                </td>
                <td>Allergens</td>
                <td>
                    <textarea name="history[past][medical][allergens]" v-model="allergensHistory"></textarea>
                    <button v-on:click.prevent="loadCustomText('history.past.medical.allergens.value')">Use custom text</button>
                </td>
            </tr>
            <tr>
                <td>Current medication</td>
                <td>
                    <textarea name="history[past][medical][medication]" v-model="medicationHistory"></textarea>
                    <button v-on:click.prevent="loadCustomText('history.past.medical.medication.value')">Use custom text</button>
                </td>
            </tr>
            <tr>
                <td>Medical history</td>
                <td>
                    <textarea name="history[past][medical][general]" v-model="generalHistory"></textarea>
                    <button v-on:click.prevent="loadCustomText('history.past.medical.general.value')">Use custom text</button>
                </td>
            </tr>
            <tr>
                <td>Dental history</td>
                <td>
                    <textarea name="history[past][medical][dental]" v-model="dentalHistory"></textarea>
                    <button v-on:click.prevent="loadCustomText('history.past.medical.dental.value')">Use custom text</button>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="desc">3. Past social history</label>
                </td>
                <td>
                    <textarea name="history[past][social]" v-model="socialHistory"></textarea>
                    <button v-on:click.prevent="loadCustomText('history.past.social.value')">Use custom text</button>
                </td>
            </tr>
        </table>
        <p></p>
        <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
            <colgroup>
                <col width="40%" />
                <col width="60%" />
            </colgroup>
            <tr>
                <th colspan="2">Review of systems</th>
            </tr>
            <tr>
                <td>Constitutional</td>
                <td>
                    <input type="text" name="systems[constitutional]" v-model="form.systems.constitutional" />
                </td>
            </tr>
            <tr>
                <td>Eyes</td>
                <td>
                    <input type="text" name="systems[eyes]" v-model="form.systems.eyes" />
                </td>
            </tr>
            <tr>
                <td>Ears, nose, mouth and throat</td>
                <td>
                    <input type="text" name="systems[ears_nose_mouth_throat]" v-model="form.systems.ears_nose_mouth_throat" />
                </td>
            </tr>
            <tr>
                <td>Cardiovascular</td>
                <td>
                    <input type="text" name="systems[cardiovascular]" v-model="form.systems.cardiovascular" />
                </td>
            </tr>
            <tr>
                <td>Respiratory</td>
                <td>
                    <input type="text" name="systems[respiratory]" v-model="form.systems.respiratory" />
                </td>
            </tr>
            <tr>
                <td>Gastrointestinal</td>
                <td>
                    <input type="text" name="systems[gastrointestinal]" v-model="form.systems.gastrointestinal" />
                </td>
            </tr>
            <tr>
                <td>Genitourinary</td>
                <td>
                    <input type="text" name="systems[genitourinary]" v-model="form.systems.genitourinary" />
                </td>
            </tr>
            <tr>
                <td>Musculoskeletal</td>
                <td>
                    <input type="text" name="systems[musculoskeletal]" v-model="form.systems.musculoskeletal" />
                </td>
            </tr>
            <tr>
                <td>Integumentary (skin)</td>
                <td>
                    <input type="text" name="systems[integumentary]" v-model="form.systems.integumentary" />
                </td>
            </tr>
            <tr>
                <td>Neurologic</td>
                <td>
                    <input type="text" name="systems[neurologic]" v-model="form.systems.neurologic" />
                </td>
            </tr>
            <tr>
                <td>Psychiatric</td>
                <td>
                    <input type="text" name="systems[psychiatric]" v-model="form.systems.psychiatric" />
                </td>
            </tr>
            <tr>
                <td>Endocrine</td>
                <td>
                    <input type="text" name="systems[endocrine]" v-model="form.systems.endocrine" />
                </td>
            </tr>
            <tr>
                <td>Hematologic/lymphatic</td>
                <td>
                    <input type="text" name="systems[hematologic_lymphatic]" v-model="form.systems.hematologic_lymphatic" />
                </td>
            </tr>
            <tr>
                <td>Allergic/immunologic</td>
                <td>
                    <input type="text" name="systems[allergic_immunologic]" v-model="form.systems.allergic_immunologic" />
                </td>
            </tr>
        </table>
        <p></p>
        <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
            <colgroup>
                <col width="40%" />
                <col width="60%" />
            </colgroup>
            <tr>
                <th colspan="2">Exam</th>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="desc">Vital signs</label>
                </td>
            </tr>
            <tr>
                <td>Blood pressure</td>
                <td>
                    <input type="text" name="vital_signs[blood_pressure]" v-model="vitalSignsBloodPressure" />
                </td>
            </tr>
            <tr>
                <td>Pulse</td>
                <td>
                    <select class="inline" name="vital_signs[pulse]" v-model="vitalSignsPulse">
                        <option></option>
                        <?= dropdown($pulse) ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Neck measurement</td>
                <td>
                    <select class="inline" name="vital_signs[neck_measurement]" v-model="vitalSignsNeckMeasurement">
                        <option></option>
                        <?= dropdown($neckMeasurement) ?>
                    </select>
                    inches
                </td>
            </tr>
            <tr>
                <td>Respirations</td>
                <td>
                    <input class="inline" type="text" name="vital_signs[respirations]" v-model="vitalSignsRespirations" />
                    bpm
                </td>
            </tr>
            <tr>
                <td>Height</td>
                <td>
                    <select class="inline" name="vital_signs[height][feet]" v-model="vitalSignsHeightFeet">
                        <option></option>
                        <?= dropdown($feet) ?>
                    </select>
                    feet
                    <select class="inline" name="vital_signs[height][inches]" v-model="vitalSignsHeightInches">
                        <option></option>
                        <?= dropdown($inches) ?>
                    </select>
                    inches
                </td>
            </tr>
            <tr>
                <td>Weight</td>
                <td>
                    <select class="inline" name="vital_signs[weight]" v-model="vitalSignsWeight">
                        <option></option>
                        <?= dropdown($weight) ?>
                    </select>
                    pounds
                </td>
            </tr>
            <tr>
                <td>BMI</td>
                <td>
                    <input type="text" readonly disabled value="{{ bmi }}" />
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label class="desc">General</label>
                </td>
            </tr>
            <tr>
                <td>General appearance</td>
                <td>
                    <input type="text" name="vital_signs[appearance]" v-model="form.vital_signs.appearance" />
                </td>
            </tr>
            <tr>
                <td>Orientation</td>
                <td>
                    <input type="text" name="vital_signs[orientation]" v-model="form.vital_signs.orientation" />
                </td>
            </tr>
            <tr>
                <td>Mood and affect</td>
                <td>
                    <input type="text" name="vital_signs[mood_affect]" v-model="form.vital_signs.mood_affect" />
                </td>
            </tr>
            <tr>
                <td>Gait and station</td>
                <td>
                    <input type="text" name="vital_signs[gait_station]" v-model="form.vital_signs.gait_station" />
                </td>
            </tr>
            <tr>
                <td>Coordination and Balance</td>
                <td>
                    <input type="text" name="vital_signs[coordination_balance]" v-model="form.vital_signs.coordination_balance" />
                </td>
            </tr>
            <tr>
                <td>Sensation</td>
                <td>
                    <input type="text" name="vital_signs[sensation]" v-model="form.vital_signs.sensation" />
                </td>
            </tr>
            <tr>
                <td>
                    <label class="desc">Body area</label>
                </td>
                <td>
                    <input type="text" name="body_area[first_description]" v-model="bodyAreaFirstDescription" placeholder="Head and Neck" />
                </td>
            </tr>
            <tr>
                <td>Inspection/palpation</td>
                <td>
                    <input type="text" name="body_area[palpation]" v-model="form.body_area.palpation" />
                </td>
            </tr>
            <tr>
                <td>Range of motion (ROM)</td>
                <td>
                    <input type="text" name="body_area[rom]" v-model="form.body_area.rom" />
                </td>
            </tr>
            <tr>
                <td>Stability</td>
                <td>
                    <input type="text" name="body_area[stability]" v-model="form.body_area.stability" />
                </td>
            </tr>
            <tr>
                <td>Strength</td>
                <td>
                    <input type="text" name="body_area[strength]" v-model="form.body_area.strength" />
                </td>
            </tr>
            <tr>
                <td>Skin</td>
                <td>
                    <input type="text" name="body_area[skin]" v-model="form.body_area.skin" />
                </td>
            </tr>
            <tr>
                <td>
                    <label class="desc">Body area</label>
                </td>
                <td>
                    <input type="text" name="body_area[second_description]" v-model="bodyAreaSecondDescription" placeholder="Ear, Nose and Throat" />
                </td>
            </tr>
            <tr>
                <td>Lips, teeth and gums</td>
                <td>
                    <input type="text" name="body_area[lips_teeth_gums]" v-model="form.body_area.lips_teeth_gums" />
                </td>
            </tr>
            <tr>
                <td>
                    Oropharynx, oral mucosa, salivary glands, hard and soft palates, tongue, tonsils and posterior pharynx
                </td>
                <td>
                    <input type="text" name="body_area[oropharynx]" v-model="form.body_area.oropharynx" />
                </td>
            </tr>
            <tr>
                <td>Nasal mucosa, septum and turbinates</td>
                <td>
                    <input type="text" name="body_area[nasal_septum_turbinates]" v-model="form.body_area.nasal_septum_turbinates" />
                </td>
            </tr>
        </table>
        <div align="right">
            <button class="save-action hidden"
                    title="Save a copy of the last saved values"
                    v-bind:disabled="backupInProgress ? true : false"
                    v-on:click.prevent="backup">
                <span v-show="!backupInProgress">Archive page</span>
                <span v-show="backupInProgress">Archiving... <img src="/manage/images/loading.gif" alt=""></span>
            </button>
            <button class="save-action" v-on:click.prevent="resetData">Undo Changes</button>
            <button class="save-action" v-on:click.prevent="save">Save</button>
            <button class="save-action" v-on:click.prevent="saveAndProceed">Save And Proceed</button>
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>
    <div id="history-selector" class="history-selector">
        <ul>
            <li v-bind:class="{ current: !list.length || list[0][mixin.modelKey] == mixin.modelId }">
                <a href="?pid=<?= $patientId ?>"> Latest </a>
            </li>
            <li v-for="each in list" v-bind:class="{ current: each[mixin.modelKey] == mixin.modelId, hidden: !$index }">
                <a href="?pid={{ mixin.patientId }}&amp;history_id={{ each[mixin.modelKey] }}">
                    {{ each.updated_at ? each.updated_at : each.history_created_at | dateFormat 'MM/DD/YY' }}
                    <small>{{ each.updated_at ? each.updated_at : each.history_created_at | dateFormat 'HH:mm' }}</small>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php
require_once __DIR__ . '/includes/form_bottom.htm';
require_once __DIR__ . '/includes/vue-setup.htm';
?>
<script type="text/javascript" src="/assets/app/patient/exams/evaluation-management.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<?php
require_once __DIR__ . '/includes/bottom.htm';
?>
