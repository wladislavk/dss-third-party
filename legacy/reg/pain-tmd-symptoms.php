<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/questionnaire_sections.php';

$patientId = (int)$_SESSION['pid'];
$docId = (int)$_SESSION['patient_docid'];

$historyId = 0;
$isCreateNew = false;

$painPosition = [
    'right' => 'Right',
    'left' => 'Left',
    'both' => 'Both',
];

$mouthPainPosition = [
    'upper' => 'Upper',
    'lower' => 'Lower',
    'both' => 'Both',
];

$painLevel = range(0, 10);

$painFrequency = [
    'daily' => 'Daily',
    'frequently' => 'Frequently',
    'occasionally' => 'Occasionally',
];

$painDuration = [
    'weeks' => 'Weeks',
    'days' => 'Days',
    'minutes' => 'Minutes',
    'hours' => 'Hours',
    'seconds' => 'Seconds',
];

$specialist = [
    'physician' => 'Physician',
    'specialist' => 'Physician specialist',
    'dentist' => 'Dentist',
    'myself' => 'Myself',
    'other' => 'Other',
];

$painOccurrence = [
    'morning' => 'Morning',
    'day' => 'Day',
    'evening' => 'Evening',
    'night' => 'Night'
];

?>
<style>
    .vue-module textarea {
        width: 95%;
    }
</style>
<p></p>
<?php require_once __DIR__ . '/includes/questionnaire_header.php'; ?>
<form id="pain-tmd" class="q_form vue-module" name="q_page5frm" method="post">
    <input type="hidden" name="patient_id" value="<?= $patientId ?>" />
    <input type="hidden" name="history_id" value="<?= $historyId ?>" />
    <input type="hidden" name="create_new" value="<?= $isCreateNew ?>" />
    <input type="hidden" name="goto_p" value="" />
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="40%" />
            <col width="60%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th class="col_head" colspan="2">Chief complaint and treatment goals</th>
        </tr>
        <tr>
            <td>What is your chief complaint?</td>
            <td>
                <textarea name="description[chief_complaint]" v-model="form.description.chief_complaint"></textarea>
            </td>
        </tr>
        <tr>
            <td>What are your treatment goals related to your pain or discomfort?</td>
            <td>
                <textarea name="description[treatment_goals]" v-model="form.description.treatment_goals"></textarea>
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
            <th class="col_head" colspan="2">OPQRST symptom review</th>
        </tr>
        <tr>
            <td>
                <span class="admin_head">Onset of event</span>
                <p>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Please describe when the pain started, if you think you did something to initiate the pain and whether the onset was gradual or chronic.
                </p>
            </td>
            <td>
                <textarea name="symptom_review[onset_of_event]" v-model="form.symptom_review.onset_of_event"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <span class="admin_head">Provocation</span>
                <p>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Please describe whether any movement, rest, pressure (such as palpation) or other external factors make the problem better or worse.
                </p>
            </td>
            <td>
                <textarea name="symptom_review[provocation]" v-model="form.symptom_review.provocation"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <span class="admin_head">Quality of the pain</span>
                <p>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Please describe the quality and type of pain including if it follows any pattern.
                </p>
            </td>
            <td>
                <textarea name="symptom_review[quality_of_pain]" v-model="form.symptom_review.quality_of_pain"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <span class="admin_head">Region and radiation</span>
                <p>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Please describe where the pain is on the body and whether it radiates (extends) or moves to any other area.
                </p>
            </td>
            <td>
                <textarea name="symptom_review[region_and_radiation]" v-model="form.symptom_review.region_and_radiation"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <span class="admin_head">Severity</span>
                <p>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Please describe the pain severity on a 0 to 10 scale with 10 being the worst pain possible.
                </p>
            </td>
            <td>
                <textarea name="symptom_review[severity]" v-model="form.symptom_review.severity"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <span class="admin_head">Time</span>
                <p>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Please describe how long the condition has been going on, whether and how it has changed since onset (better, worse, different symptoms, whether it has ever happened before and when the pain stopped if it is no longer currently being felt.
                </p>
            </td>
            <td>
                <textarea name="symptom_review[time]" v-model="form.symptom_review.time"></textarea>
            </td>
        </tr>
    </table>
    <p></p>
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="25%" />
            <col width="25%" />
            <col width="25%" />
            <col width="25%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th colspan="2">AREA</th>
            <th>SIDE</th>
            <th>PAIN</th>
        </tr>
        <tr>
            <td rowspan="4">BACK</td>
            <td>General</td>
            <td></td>
            <td>
                <select name="pain[back][general][level]"
                        v-model="form.pain.back.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Upper</td>
            <td>
                <select name="pain[back][upper][position]"
                        v-model="form.pain.back.upper.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[back][upper][level]"
                        v-model="form.pain.back.upper.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Middle</td>
            <td>
                <select name="pain[back][middle][position]"
                        v-model="form.pain.back.middle.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[back][middle][level]"
                        v-model="form.pain.back.middle.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Lower</td>
            <td>
                <select name="pain[back][lower][position]"
                        v-model="form.pain.back.lower.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[back][lower][level]"
                        v-model="form.pain.back.lower.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">JAW</td>
            <td>
                <select name="pain[jaw][general][position]"
                        v-model="form.pain.jaw.general.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[jaw][general][level]"
                        v-model="form.pain.jaw.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td rowspan="4">JAW JOINT</td>
            <td>General</td>
            <td></td>
            <td>
                <select name="pain[jaw_joint][general][level]"
                        v-model="form.pain.jaw_joint.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>On opening</td>
            <td>
                <select name="pain[jaw_joint][opening][position]"
                        v-model="form.pain.jaw_joint.opening.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[jaw_joint][opening][level]"
                        v-model="form.pain.jaw_joint.opening.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>While chewing</td>
            <td>
                <select name="pain[jaw_joint][chewing][position]"
                        v-model="form.pain.jaw_joint.chewing.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[jaw_joint][chewing][level]"
                        v-model="form.pain.jaw_joint.chewing.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>At rest</td>
            <td>
                <select name="pain[jaw_joint][at_rest][position]"
                        v-model="form.pain.jaw_joint.at_rest.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[jaw_joint][at_rest][level]"
                        v-model="form.pain.jaw_joint.at_rest.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td rowspan="3">EYES</td>
            <td>
                <input type="checkbox" id="behind-eyes" name="pain[eyes][behind][checked]"
                       v-model="form.pain.eyes.behind.checked" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="behind-eyes">Behind eyes</label>
            </td>
            <td>
                <select name="pain[eyes][behind][position]"
                        v-model="form.pain.eyes.behind.position" v-show="form.pain.eyes.behind.checked==1">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[eyes][behind][level]"
                        v-model="form.pain.eyes.behind.level" v-show="form.pain.eyes.behind.checked==1">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="watery-eyes" name="pain[eyes][watery][checked]"
                       v-model="form.pain.eyes.watery.checked" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="watery-eyes">Watery eyes</label>
            </td>
            <td>
                <select name="pain[eyes][watery][position]"
                        v-model="form.pain.eyes.watery.position" v-show="form.pain.eyes.watery.checked==1">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[eyes][watery][level]"
                        v-model="form.pain.eyes.watery.level" v-show="form.pain.eyes.watery.checked==1">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="visual-disturbance" name="pain[eyes][visual_disturbance][checked]"
                       v-model="form.pain.eyes.visual_disturbance.checked" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="visual-disturbance">Visual disturbance</label>
            </td>
            <td>
                <select name="pain[eyes][visual_disturbance][position]"
                        v-model="form.pain.eyes.visual_disturbance.position" v-show="form.pain.eyes.visual_disturbance.checked==1">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[eyes][visual_disturbance][level]"
                        v-model="form.pain.eyes.visual_disturbance.level" v-show="form.pain.eyes.visual_disturbance.checked==1">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td rowspan="4">EARS</td>
            <td>Ear pain</td>
            <td>
                <select name="pain[ears][general][position]"
                        v-model="form.pain.ears.general.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[ears][general][level]"
                        v-model="form.pain.ears.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Pain behind ear</td>
            <td>
                <select name="pain[ears][behind][position]"
                        v-model="form.pain.ears.behind.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[ears][behind][level]"
                        v-model="form.pain.ears.behind.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Pain in front of ear</td>
            <td>
                <select name="pain[ears][front][position]"
                        v-model="form.pain.ears.front.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[ears][front][level]"
                        v-model="form.pain.ears.front.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Ringing in ears</td>
            <td>
                <select name="pain[ears][ringing][position]"
                        v-model="form.pain.ears.ringing.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[ears][ringing][level]"
                        v-model="form.pain.ears.ringing.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td rowspan="2">THROAT</td>
            <td>Sore throats</td>
            <td></td>
            <td>
                <select name="pain[throat][general][level]"
                        v-model="form.pain.throat.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Pain on swallowing</td>
            <td></td>
            <td>
                <select name="pain[throat][swallowing][level]"
                        v-model="form.pain.throat.swallowing.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">FACIAL Pain</td>
            <td>
                <select name="pain[face][general][position]"
                        v-model="form.pain.face.general.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[face][general][level]"
                        v-model="form.pain.face.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">NECK Pain</td>
            <td>
                <select name="pain[neck][general][position]"
                        v-model="form.pain.neck.general.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[neck][general][level]"
                        v-model="form.pain.neck.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">SHOULDER Pain</td>
            <td>
                <select name="pain[shoulder][general][position]"
                        v-model="form.pain.shoulder.general.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[shoulder][general][level]"
                        v-model="form.pain.shoulder.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">TEETH Pain</td>
            <td>
                <select name="pain[teeth][general][position]"
                        v-model="form.pain.teeth.general.position">
                    <?= dropdown($mouthPainPosition) ?>
                </select>
            </td>
            <td>
                <select name="pain[teeth][general][level]"
                        v-model="form.pain.teeth.general.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
    </table>
    <p></p>
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="34%" />
            <col width="33%" />
            <col width="33%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th colspan="4">JAW / FACIAL SYMPTOMS</th>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="jaw-locks-open" name="symptoms[jaw][locks_open]"
                       v-model="form.symptoms.jaw.locks_open" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="jaw-locks-open">Jaw locks open</label>
            </td>
            <td>
                <input type="checkbox" id="daytime-clenching" name="symptoms[clenching][daytime]"
                       v-model="form.symptoms.clenching.daytime" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="daytime-clenching">Daytime clenching</label>
            </td>
            <td>
                <input type="checkbox" id="limited-mouth-opening" name="symptoms[mouth][limited_opening]"
                       v-model="form.symptoms.mouth.limited_opening" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="limited-mouth-opening">Limited mouth opening</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="jaw-locks-closed" name="symptoms[jaw][locks_closed]"
                       v-model="form.symptoms.jaw.locks_closed" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="jaw-locks-closed">Jaw locks closed</label>
            </td>
            <td>
                <input type="checkbox" id="daytime-grinding" name="symptoms[grinding][daytime]"
                       v-model="form.symptoms.grinding.daytime" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="daytime-grinding">Daytime grinding</label>
            </td>
            <td>
                <input type="checkbox" id="muscle-twitching" name="symptoms[muscle_twitching]"
                       v-model="form.symptoms.muscle_twitching" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="muscle-twitching">Muscle twitching</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="jaw-pops-opening" name="symptoms[jaw][opening][clicks_pops]"
                       v-model="form.symptoms.jaw.opening.clicks_pops" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="jaw-pops-opening">
                    Jaw clicks / pops on opening
                    <select name="symptoms[jaw][opening][position]"
                            v-model="form.symptoms.jaw.opening.position" v-show="form.symptoms.jaw.opening.clicks_pops == 1">
                        <?= dropdown($painPosition) ?>
                    </select>
                </label>
            </td>
            <td>
                <input type="checkbox" id="nighttime-clenching" name="symptoms[clenching][nighttime]"
                       v-model="form.symptoms.clenching.nighttime" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="nighttime-clenching">Nighttime clenching</label>
            </td>
            <td>
                <input type="checkbox" id="numbness-lip" name="symptoms[numbness][lip]"
                       v-model="form.symptoms.numbness.lip" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="numbness-lip">Numbness in lip</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="jaw-pops-closing" name="symptoms[jaw][closing][clicks_pops]"
                       v-model="form.symptoms.jaw.closing.clicks_pops" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="jaw-pops-closing">
                    Jaw clicks / pops on closing
                    <select name="symptoms[jaw][closing][position]"
                            v-model="form.symptoms.jaw.closing.position" v-show="form.symptoms.jaw.closing.clicks_pops == 1">
                        <?= dropdown($painPosition) ?>
                    </select>
                </label>
            </td>
            <td>
                <input type="checkbox" id="nighttime-grinding" name="symptoms[grinding][nighttime]"
                       v-model="form.symptoms.grinding.nighttime" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="nighttime-grinding">Nighttime grinding</label>
            </td>
            <td>
                <input type="checkbox" id="numbness-jawbone" name="symptoms[numbness][jawbone]"
                       v-model="form.symptoms.numbness.jawbone" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="numbness-jawbone">Numbness in jawbone</label>
            </td>
        </tr>
    </table>
    <p>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Do you have headaches?
        <input type="radio" id="headaches-yes" name="headaches[checked]"
               v-model="form.headaches.checked" v-bind:value="1" />
        <label for="headaches-yes">Yes</label>
        <input type="radio" id="headaches-no" name="headaches[checked]"
               v-model="form.headaches.checked" v-bind:value="0" />
        <label for="headaches-no">No</label>
    </p>
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5" v-show="form.headaches.checked==1">
        <colgroup>
            <col width="15%" />
            <col width="10%" />
            <col width="25%" />
            <col width="25%" />
            <col width="25%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th class="col_head" colspan="5">HEADACHES</th>
        </tr>
        <tr class="tr_bg_h">
            <th class="col_head" colspan="2">LOCATION</th>
            <th class="col_head">FREQUENCY</th>
            <th class="col_head">DURATION</th>
            <th class="col_head">PAIN</th>
        </tr>
        <tr>
            <td colspan="2">Front</td>
            <td>
                <select name="headaches[front][frequency]"
                        v-model="form.headaches.front.frequency">
                    <?= dropdown($painFrequency) ?>
                </select>
            </td>
            <td>
                <select name="headaches[front][duration]"
                        v-model="form.headaches.front.duration">
                    <?= dropdown($painDuration) ?>
                </select>
            </td>
            <td>
                <select name="headaches[front][level]"
                        v-model="form.headaches.front.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">Top</td>
            <td>
                <select name="headaches[top][frequency]"
                        v-model="form.headaches.top.frequency">
                    <?= dropdown($painFrequency) ?>
                </select>
            </td>
            <td>
                <select name="headaches[top][duration]"
                        v-model="form.headaches.top.duration">
                    <?= dropdown($painDuration) ?>
                </select>
            </td>
            <td>
                <select name="headaches[top][level]"
                        v-model="form.headaches.top.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">Back</td>
            <td>
                <select name="headaches[back][frequency]"
                        v-model="form.headaches.back.frequency">
                    <?= dropdown($painFrequency) ?>
                </select>
            </td>
            <td>
                <select name="headaches[back][duration]"
                        v-model="form.headaches.back.duration">
                    <?= dropdown($painDuration) ?>
                </select>
            </td>
            <td>
                <select name="headaches[back][level]"
                        v-model="form.headaches.back.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Temple</td>
            <td>
                <select name="headaches[temple][position]"
                        v-model="form.headaches.temple.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="headaches[temple][frequency]"
                        v-model="form.headaches.temple.frequency">
                    <?= dropdown($painFrequency) ?>
                </select>
            </td>
            <td>
                <select name="headaches[temple][duration]"
                        v-model="form.headaches.temple.duration">
                    <?= dropdown($painDuration) ?>
                </select>
            </td>
            <td>
                <select name="headaches[temple][level]"
                        v-model="form.headaches.temple.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Behind eyes</td>
            <td>
                <select name="headaches[eyes][position]"
                        v-model="form.headaches.eyes.position">
                    <?= dropdown($painPosition) ?>
                </select>
            </td>
            <td>
                <select name="headaches[eyes][frequency]"
                        v-model="form.headaches.eyes.frequency">
                    <?= dropdown($painFrequency) ?>
                </select>
            </td>
            <td>
                <select name="headaches[eyes][duration]"
                        v-model="form.headaches.eyes.duration">
                    <?= dropdown($painDuration) ?>
                </select>
            </td>
            <td>
                <select name="headaches[eyes][level]"
                        v-model="form.headaches.eyes.level">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td rowspan="5" colspan="2">Headache pain related to</td>
            <td>
                <input type="checkbox" id="headache-dizziness" name="headaches[symptoms][dizziness]"
                       v-model="form.headaches.symptoms.dizziness" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-dizziness">Dizziness</label>
            </td>
            <td>
                <input type="checkbox" id="headache-sensitivity-noise" name="headaches[symptoms][noise_sensitivity]"
                       v-model="form.headaches.symptoms.noise_sensitivity" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-sensitivity-noise">Sensitivity to noise</label>
            </td>
            <td>
                <input type="checkbox" id="headache-throbbling" name="headaches[symptoms][throbbling]"
                       v-model="form.headaches.symptoms.throbbling" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-throbbling">Throbbling</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="headache-double-vision" name="headaches[symptoms][double_vision]"
                       v-model="form.headaches.symptoms.double_vision" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-double-vision">Double vision</label>
            </td>
            <td>
                <input type="checkbox" id="headache-light-sensitivity" name="headaches[symptoms][light_sensitivity]"
                       v-model="form.headaches.symptoms.light_sensitivity" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-light-sensitivity">Sensitivity to light</label>
            </td>
            <td>
                <input type="checkbox" id="headache-vomiting" name="headaches[symptoms][vomiting]"
                       v-model="form.headaches.symptoms.vomiting" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-vomiting">Vomiting</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="headache-fatigue" name="headaches[symptoms][fatigue]"
                       v-model="form.headaches.symptoms.fatigue" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-fatigue">Fatigue</label>
            </td>
            <td>
                <input type="checkbox" id="headache-nausea" name="headaches[symptoms][nausea]"
                       v-model="form.headaches.symptoms.nausea" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-nausea">Nausea</label>
            </td>
            <td>
                <input type="checkbox" id="headache-eye-nose-running" name="headaches[symptoms][eye_nose_running]"
                       v-model="form.headaches.symptoms.eye_nose_running" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-eye-nose-running">Eye / Nose running</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="headache-sinus-congestion" name="headaches[symptoms][sinus_congestion]"
                       v-model="form.headaches.symptoms.sinus_congestion" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-sinus-congestion">Sinus congestion</label>
            </td>
            <td>
                <input type="checkbox" id="headache-burning" name="headaches[symptoms][burning]"
                       v-model="form.headaches.symptoms.burning" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-burning">Burning</label>
            </td>
            <td rowspan="2">
                <input type="checkbox" id="headache-other" name="headaches[symptoms][other][checked]"
                       v-model="form.headaches.symptoms.other.checked" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-other">Other</label>
                <br />
                <textarea name="headaches[symptoms][other][details]"
                          v-model="form.headaches.symptoms.other.details"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="headache-dull-aching" name="headaches[symptoms][dull_aching]"
                       v-model="form.headaches.symptoms.dull_aching" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="headache-dull-aching">Dull / Aching</label>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">Have you ever been diagnosed with migraines?</td>
            <td>
                <input type="radio" id="diagnosed-migraines-yes" name="headaches[migraines][checked]"
                       v-model="form.headaches.migraines.checked" v-bind:value="1" />
                <label for="diagnosed-migraines-yes">Yes</label>
                <input type="radio" id="diagnosed-migraines-no" name="headaches[migraines][checked]"
                       v-model="form.headaches.migraines.checked" v-bind:value="0" />
                <label for="diagnosed-migraines-no">No</label>
            </td>
            <td><span v-show="form.headaches.migraines.checked==1">Who diagnosed your migraines?</span></td>
            <td>
                <select name="headaches[migraines][specialist]"
                        v-model="form.headaches.migraines.specialist" v-show="form.headaches.migraines.checked==1">
                    <?= dropdown($specialist) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">When do the headaches most frequently occur?</td>
            <td>
                <select name="headaches[migraines][occurrence]"
                        v-model="form.headaches.migraines.occurrence">
                    <?= dropdown($painOccurrence) ?>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <p></p>
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th colspan="5">OTHER SYMPTOMS</th>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="other-dry-mouth" name="symptoms[other][dry_mouth]"
                       v-model="form.symptoms.other.dry_mouth" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-dry-mouth">Dry mouth</label>
            </td>
            <td>
                <input type="checkbox" id="other-cheek-biting" name="symptoms[other][cheek_biting]"
                       v-model="form.symptoms.other.cheek_biting" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-cheek-biting">Cheek biting</label>
            </td>
            <td>
                <input type="checkbox" id="other-burning-tongue" name="symptoms[other][burning_tongue]"
                       v-model="form.symptoms.other.burning_tongue" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-burning-tongue">Burning tongue</label>
            </td>
            <td>
                <input type="checkbox" id="other-dizziness" name="symptoms[other][dizziness]"
                       v-model="form.symptoms.other.dizziness" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-dizziness">Dizziness</label>
            </td>
            <td>
                <input type="checkbox" id="other-buzzing" name="symptoms[other][buzzing]"
                       v-model="form.symptoms.other.buzzing" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-buzzing">Buzzing in ears</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="other-swallowing" name="symptoms[other][swallowing]"
                       v-model="form.symptoms.other.swallowing" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-swallowing">Difficulty swallowing</label>
            </td>
            <td>
                <input type="checkbox" id="other-stiffness" name="symptoms[other][neck_stiffness]"
                       v-model="form.symptoms.other.neck_stiffness" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-stiffness">Neck stiffness</label>
            </td>
            <td>
                <input type="checkbox" id="other-vision-changes" name="symptoms[other][vision_changes]"
                       v-model="form.symptoms.other.vision_changes" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-vision-changes">Vision changes</label>
            </td>
            <td>
                <input type="checkbox" id="other-sciatica" name="symptoms[other][sciatica]"
                       v-model="form.symptoms.other.sciatica" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-sciatica">Sciatica</label>
            </td>
            <td>
                <input type="checkbox" id="other-ear-infections" name="symptoms[other][ear_infections]"
                       v-model="form.symptoms.other.ear_infections" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-ear-infections">Ear infections</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="other-foreign-feeling" name="symptoms[other][foreign_feeling]"
                       v-model="form.symptoms.other.foreign_feeling" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-foreign-feeling">Foreign feeling in throat</label>
            </td>
            <td>
                <input type="checkbox" id="other-shoulder-stiffness" name="symptoms[other][shoulder_stiffness]"
                       v-model="form.symptoms.other.shoulder_stiffness" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-shoulder-stiffness">Shoulder stiffness</label>
            </td>
            <td>
                <input type="checkbox" id="other-blurred-vision" name="symptoms[other][blurred_vision]"
                       v-model="form.symptoms.other.blurred_vision" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-blurred-vision">Blurred vision</label>
            </td>
            <td>
                <input type="checkbox" id="other-fingers-tingling" name="symptoms[other][fingers_tingling]"
                       v-model="form.symptoms.other.fingers_tingling" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-fingers-tingling">Fingers tingling</label>
            </td>
            <td>
                <input type="checkbox" id="other-ear-congestion" name="symptoms[other][ear_congestion]"
                       v-model="form.symptoms.other.ear_congestion" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-ear-congestion">Ear congestion</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="other-neck-swelling" name="symptoms[other][neck_swelling]"
                       v-model="form.symptoms.other.neck_swelling" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-neck-swelling">Neck swelling</label>
            </td>
            <td>
                <input type="checkbox" id="other-scoliosis" name="symptoms[other][scoliosis]"
                       v-model="form.symptoms.other.scoliosis" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-scoliosis">Scoliosis</label>
            </td>
            <td>
                <input type="checkbox" id="other-visual-disturbances" name="symptoms[other][visual_disturbances]"
                       v-model="form.symptoms.other.visual_disturbances" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-visual-disturbances">Visual disturbances</label>
            </td>
            <td>
                <input type="checkbox" id="other-finger-hand-numbness" name="symptoms[other][finger_hand_numbness]"
                       v-model="form.symptoms.other.finger_hand_numbness" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-finger-hand-numbness">Finger or hand numbness</label>
            </td>
            <td>
                <input type="checkbox" id="other-hearing-loss" name="symptoms[other][hearing_loss]"
                       v-model="form.symptoms.other.hearing_loss" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-hearing-loss">Hearing loss</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="other-gland-swelling" name="symptoms[other][gland_swelling]"
                       v-model="form.symptoms.other.gland_swelling" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-gland-swelling">Gland swelling</label>
            </td>
            <td></td>
            <td>
                <input type="checkbox" id="other-chronic-sinusitis" name="symptoms[other][chronic_sinusitis]"
                       v-model="form.symptoms.other.chronic_sinusitis" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-chronic-sinusitis">Chronic sinusitis</label>
            </td>
            <td></td>
            <td>
                <input type="checkbox" id="other-thyroid-swelling" name="symptoms[other][thyroid_swelling]"
                       v-model="form.symptoms.other.thyroid_swelling" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-thyroid-swelling">Thyroid swelling</label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="checkbox" id="other-difficult-breathing" name="symptoms[other][difficult_breathing]"
                       v-model="form.symptoms.other.difficult_breathing" v-bind:true-value="1" v-bind:false-value="0" />
                <label for="other-difficult-breathing">Difficulty breathing through your nose</label>
            </td>
            <td colspan="2">
                <label for="other-description">Other</label>
                <input id="other-description" name="symptoms[other][description]"
                       v-model="form.symptoms.other.description" />
            </td>
            <td></td>
        </tr>
    </table>
    <div align="right">
        <button class="save-action next btn btn_d" v-on:click.prevent="save">Save</button>
        &nbsp;&nbsp;&nbsp;
    </div>
</form>
<?php include __DIR__ . '/../manage/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/patient/questionnaires/pain-tmd.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<link rel="stylesheet" href="css/questionnaire.css" />
<link rel="stylesheet" href="css/table.css" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/questionnaire_ie.css" />
<![endif]-->
<?php

require_once __DIR__ . '/includes/footer.php';
