<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/questionnaire_sections.php';

$patientId = (int)$_SESSION['pid'];
$docId = (int)$_SESSION['patient_docid'];

$historyId = 0;
$isCreateNew = false;

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

?>
<style>
    .vue-module textarea {
        width: 95%;
    }
</style>
<p></p>
<?php require_once __DIR__ . '/includes/questionnaire_header.php'; ?>
<form id="evaluation-management" class="q_form vue-module" name="ex_page10frm" method="post">
    <input type="hidden" name="patient_id" value="<?= $patientId ?>" />
    <input type="hidden" name="history_id" value="<?= $historyId ?>" />
    <input type="hidden" name="create_new" value="<?= $isCreateNew ?>" />
    <input type="hidden" name="goto_p" value="" />
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
                <textarea name="history[chief_complaint]" v-model="chiefComplaint" readonly></textarea>
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
            </td>
        </tr>
        <tr>
            <td rowspan="4">
                <label class="desc">2. Past medical history</label>
            </td>
            <td>Allergens</td>
            <td>
                <textarea name="history[past][medical][allergens]" v-model="allergensHistory"></textarea>
            </td>
        </tr>
        <tr>
            <td>Current medication</td>
            <td>
                <textarea name="history[past][medical][medication]" v-model="medicationHistory"></textarea>
            </td>
        </tr>
        <tr>
            <td>Medical history</td>
            <td>
                <textarea name="history[past][medical][general]" v-model="generalHistory"></textarea>
            </td>
        </tr>
        <tr>
            <td>Dental history</td>
            <td>
                <textarea name="history[past][medical][dental]" v-model="dentalHistory"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label class="desc">3. Past social history</label>
            </td>
            <td>
                <textarea name="history[past][social]" v-model="socialHistory"></textarea>
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
                <input type="text" name="vital_signs[blood_pressure]" v-model="form.vital_signs.blood_pressure" />
            </td>
        </tr>
        <tr>
            <td>Pulse</td>
            <td>
                <select class="inline" name="vital_signs[pulse]" v-model="form.vital_signs.pulse">
                    <option></option>
                    <?= dropdown($pulse) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Neck measurement</td>
            <td>
                <select class="inline" name="vital_signs[neck_measurement]" v-model="form.vital_signs.neck_measurement">
                    <option></option>
                    <?= dropdown($neckMeasurement) ?>
                </select>
                inches
            </td>
        </tr>
        <tr>
            <td>Respirations</td>
            <td>
                <input class="inline" type="text" name="vital_signs[respirations]" v-model="form.vital_signs.respirations" />
                bpm
            </td>
        </tr>
        <tr>
            <td>Height</td>
            <td>
                <select class="inline" name="vital_signs[height][feet]" v-model="form.vital_signs.height.feet">
                    <option></option>
                    <?= dropdown($feet) ?>
                </select>
                feet
                <select class="inline" name="vital_signs[height][inches]" v-model="form.vital_signs.height.inches">
                    <option></option>
                    <?= dropdown($inches) ?>
                </select>
                inches
            </td>
        </tr>
        <tr>
            <td>Weight</td>
            <td>
                <select class="inline" name="vital_signs[weight]" v-model="form.vital_signs.weight">
                    <option></option>
                    <?= dropdown($weight) ?>
                </select>
                pounds
            </td>
        </tr>
        <tr>
            <td>BMI</td>
            <td>
                <input type="text" editable="false" value="{{ bmi }}" />
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
                <input type="text" name="body_area[first_description]" v-model="form.body_area.first_description" />
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
                <input type="text" name="body_area[second_description]" v-model="form.body_area.second_description" />
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
        <button class="save-action next btn btn_d" v-on:click.prevent="save">Save</button>
        &nbsp;&nbsp;&nbsp;
    </div>
</form>

<form id="assessment-plan" class="q_form vue-module" name="ex_page11frm" method="post">
    <input type="hidden" name="patient_id" value="<?= $patientId ?>" />
    <input type="hidden" name="history_id" value="<?= $historyId ?>" />
    <input type="hidden" name="create_new" value="<?= $isCreateNew ?>" />
    <input type="hidden" name="goto_p" value="" />
    <h3>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Assessment
    </h3>
    <table width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="40%" />
            <col width="60%" />
        </colgroup>
        <tr>
            <td>
                <div is="transaction-codes-selector" patient-id="<?= $patientId ?>" code-type="diagnosis"
                    v-bind:selector.sync="form.assessment.codes"></div>
            </td>
            <td>
                <textarea name="assessment[description]" v-model="form.assessment.description" rows="6" cols="60"></textarea>
            </td>
        </tr>
    </table>
    <h3>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Treatment plan
    </h3>
    <table width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="40%" />
            <col width="60%" />
        </colgroup>
        <tr>
            <td>
                <div is="transaction-codes-selector" patient-id="<?= $patientId ?>" code-type="treatment"
                    v-bind:selector.sync="form.treatment.codes"></div>
            </td>
            <td>
                <textarea name="treatment[description]" v-model="form.treatment.description" rows="6" cols="60"></textarea>
            </td>
        </tr>
    </table>
    <div align="right">
        <button class="save-action next btn btn_d" v-on:click.prevent="save">Save</button>
        &nbsp;&nbsp;&nbsp;
    </div>
</form>
<?php require_once __DIR__ . '/../manage/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/patient/exams/evaluation-management.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/components/transaction-codes-selector.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/patient/exams/assessment-plan.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<link rel="stylesheet" href="css/questionnaire.css" />
<link rel="stylesheet" href="css/table.css" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/questionnaire_ie.css" />
<![endif]-->
<?php

require_once __DIR__ . '/includes/footer.php';
