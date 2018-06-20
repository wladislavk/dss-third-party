<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/questionnaire_sections.php';

$patientId = (int)$_SESSION['pid'];
$docId = (int)$_SESSION['patient_docid'];

$historyId = 0;
$isCreateNew = false;

$romLimitations = [
    'wnl' => 'WNL',
    'mild' => 'Mild limitation',
    'moderate' => 'Moderate limitation',
    'severe' => 'Severe limitation'
];
$symmetryLimitations = [
    'right' => 'Right worse',
    'left' => 'Left worse'
];
$painLevel = range(0, 10);
$midlinePositions = [
    'wnl' => 'WNL',
    'right' => 'Shifted right',
    'left' => 'Shifted left'
];
$facialPositions = [
    'wnl' => 'WNL',
    'right' => 'Midline shifted right',
    'left' => 'Midline shifted left'
];
$maxillaPositions = [
    'wnl' => 'WNL',
    'right' => 'Maxilla shifted right',
    'left' => 'Maxilla shifted left'
];
$mandiblePositions = [
    'wnl' => 'WNL',
    'right' => 'Mandible shifted right',
    'left' => 'Mandible shifted left'
];
$rightEyePositions = [
    'wnl' => 'WNL',
    'closer' => 'Right closer to midline',
    'further' => 'Right further to midline',
];
$leftEyePositions = [
    'wnl' => 'WNL',
    'closer' => 'Left closer to midline',
    'further' => 'Left further to midline',
];
$headPositions = [
    'wnl' => 'WNL',
    'forward' => 'Head forward',
    'backward' => 'Head backward'
];
$standingPositions = [
    'wnl' => 'WNL',
    'forward' => 'Forward',
    'backward' => 'Backward'
];
$sittingPositions = [
    'wnl' => 'WNL',
    'forward' => 'Forward',
    'backward' => 'Backward'
];
$shoulderPositions = [
    'wnl' => 'WNL',
    'right' => 'Right shoulder higher',
    'left' => 'Left shoulder higher'
];
$hipPositions = [
    'wnl' => 'WNL',
    'right' => 'Right hip higher',
    'left' => 'Left hip higher'
];
$spinePostures = [
    'wnl' => 'WNL',
    'kyphosis' => 'Kyphosis',
    'lordosis' => 'Lordosis'
];
$pupillaryPlanes = [
    'wnl' => 'WNL',
    'right' => 'Right eye lower',
    'left' => 'Left eye lower'
];
$otherGuidance = [
    'adequate' => 'Adequate',
    'lacking' => 'Lacking'
];
?>
<style>
    .vue-module textarea {
        width: 95%;
    }
</style>
<p></p>
<?php require_once __DIR__ . '/includes/questionnaire_header.php'; ?>
<form id="advanced-pain-tmd" class="q_form vue-module" name="ex_page9frm" method="post">
    <input type="hidden" name="patient_id" value="<?= $patientId ?>" />
    <input type="hidden" name="history_id" value="<?= $historyId ?>" />
    <input type="hidden" name="create_new" value="<?= $isCreateNew ?>" />
    <input type="hidden" name="goto_p" value="" />
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="40%" />
            <col width="20%" />
            <col width="20%" />
            <col width="20%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th colspan="4" class="col_head">
                Cervical/Neck Evaluation
                &mdash;
                <small>
                    Do you wish to evaluate?
                    <input type="radio" name="cervical[evaluate]" id="cervical-evaluate-yes" v-bind:value="1"
                           v-model="form.cervical.evaluate">
                    <label for="cervical-evaluate-yes">
                        (Y)
                    </label>
                    <input type="radio" name="cervical[evaluate]" id="cervical-evaluate-no" v-bind:value="0"
                           v-model="form.cervical.evaluate">
                    <label for="cervical-evaluate-no">
                        (N)
                    </label>
                </small>
            </th>
        </tr>
        <tr class="tr_bg_h" v-show="form.cervical.evaluate">
            <th class="col_head">Movement</th>
            <th class="col_head">ROM</th>
            <th class="col_head">Symmetry</th>
            <th class="col_head">Pain</th>
        </tr>
        <tr v-show="form.cervical.evaluate">
            <td>Extension</td>
            <td>
                <select name="cervical[extension][rom]" v-model="form.cervical.extension.rom">
                    <option></option>
                    <?= dropdown($romLimitations) ?>
                </select>
            </td>
            <td></td>
            <td>
                <select name="cervical[extension][pain]" v-model="form.cervical.extension.pain">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr v-show="form.cervical.evaluate">
            <td>Flexion</td>
            <td>
                <select name="cervical[flexion][rom]" v-model="form.cervical.flexion.rom">
                    <option></option>
                    <?= dropdown($romLimitations) ?>
                </select>
            </td>
            <td></td>
            <td>
                <select name="cervical[flexion][pain]" v-model="form.cervical.flexion.pain">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr v-show="form.cervical.evaluate">
            <td>
                Rotation right<br />
                Rotation left
            </td>
            <td>
                <select name="cervical[rotation][right][rom]" v-model="form.cervical.rotation.right.rom">
                    <option></option>
                    <?= dropdown($romLimitations) ?>
                </select>
                <br />
                <select name="cervical[rotation][left][rom]" v-model="form.cervical.rotation.left.rom">
                    <option></option>
                    <?= dropdown($romLimitations) ?>
                </select>
            </td>
            <td>
                <select name="cervical[rotation][symmetry]" v-model="form.cervical.rotation.symmetry">
                    <option></option>
                    <?= dropdown($symmetryLimitations) ?>
                </select>
            </td>
            <td>
                <select name="cervical[rotation][right][pain]" v-model="form.cervical.rotation.right.pain">
                    <?= dropdown($painLevel) ?>
                </select>
                <br />
                <select name="cervical[rotation][left][pain]" v-model="form.cervical.rotation.left.pain">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr v-show="form.cervical.evaluate">
            <td>
                Side bend right<br />
                Side bend left
            </td>
            <td>
                <select name="cervical[side_bend][right][rom]" v-model="form.cervical.side_bend.right.rom">
                    <option></option>
                    <?= dropdown($romLimitations) ?>
                </select>
                <br />
                <select name="cervical[side_bend][left][rom]" v-model="form.cervical.side_bend.left.rom">
                    <option></option>
                    <?= dropdown($romLimitations) ?>
                </select>
            </td>
            <td>
                <select name="cervical[side_bend][symmetry]" v-model="form.cervical.side_bend.symmetry">
                    <option></option>
                    <?= dropdown($symmetryLimitations) ?>
                </select>
            </td>
            <td>
                <select name="cervical[side_bend][right][pain]" v-model="form.cervical.side_bend.right.pain">
                    <?= dropdown($painLevel) ?>
                </select>
                <br />
                <select name="cervical[side_bend][left][pain]" v-model="form.cervical.side_bend.left.pain">
                    <?= dropdown($painLevel) ?>
                </select>
            </td>
        </tr>
        <tr v-show="form.cervical.evaluate">
            <td>Notes</td>
            <td colspan="3">
                <textarea name="cervical[notes]" v-model="form.cervical.notes"></textarea>
            </td>
        </tr>
    </table>
    <p></p>
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="30%" />
            <col width="30%" />
            <col width="20%" />
            <col width="20%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th class="col_head" colspan="4">
                Skeletal morphology and posture
                &mdash;
                <small>
                    Do you wish to evaluate?
                    <input type="radio" name="morphology[evaluate]" id="morphology-evaluate-yes" v-bind:value="1"
                           v-model="form.morphology.evaluate">
                    <label for="morphology-evaluate-yes">
                        (Y)
                    </label>
                    <input type="radio" name="morphology[evaluate]" id="morphology-evaluate-no" v-bind:value="0"
                           v-model="form.morphology.evaluate">
                    <label for="morphology-evaluate-no">
                        (N)
                    </label>
                </small>
            </th>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td rowspan="4">Midline</td>
            <td>General</td>
            <td>
                <select name="morphology[midline][general][position]" v-model="form.morphology.midline.general.position">
                    <?= dropdown($midlinePositions) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Facial</td>
            <td>
                <select name="morphology[midline][facial][position]" v-model="form.morphology.midline.facial.position">
                    <?= dropdown($facialPositions) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Teeth</td>
            <td>
                <select name="morphology[midline][teeth][maxilla][position]" v-model="form.morphology.midline.teeth.maxilla.position">
                    <?= dropdown($maxillaPositions) ?>
                </select>
            </td>
            <td>
                <select name="morphology[midline][teeth][mandible][position]" v-model="form.morphology.midline.teeth.mandible.position">
                    <?= dropdown($mandiblePositions) ?>
                </select>
            </td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Eyes</td>
            <td>
                <select name="morphology[midline][eyes][right][position]" v-model="form.morphology.midline.eyes.right.position">
                    <?= dropdown($rightEyePositions) ?>
                </select>
            </td>
            <td>
                <select name="morphology[midline][eyes][left][position]" v-model="form.morphology.midline.eyes.left.position">
                    <?= dropdown($leftEyePositions) ?>
                </select>
            </td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td rowspan="3">Posture</td>
            <td>Head</td>
            <td>
                <select name="morphology[posture][head][position]" v-model="form.morphology.posture.head.position">
                    <?= dropdown($headPositions) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Standing</td>
            <td>
                <select name="morphology[posture][standing][position]" v-model="form.morphology.posture.standing.position">
                    <?= dropdown($standingPositions) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Sitting</td>
            <td>
                <select name="morphology[posture][sitting][position]" v-model="form.morphology.posture.sitting.position">
                    <?= dropdown($sittingPositions) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Shoulders</td>
            <td></td>
            <td>
                <select name="morphology[shoulders][position]" v-model="form.morphology.shoulders.position">
                    <?= dropdown($shoulderPositions) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Hips</td>
            <td></td>
            <td>
                <select name="morphology[hips][position]" v-model="form.morphology.hips.position">
                    <?= dropdown($hipPositions) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Spine posture</td>
            <td></td>
            <td>
                <select name="morphology[spine][position]" v-model="form.morphology.spine.position">
                    <?= dropdown($spinePostures) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Pupillary plane</td>
            <td></td>
            <td>
                <select name="morphology[pupillary_plane][position]" v-model="form.morphology.pupillary_plane.position">
                    <?= dropdown($pupillaryPlanes) ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr v-show="form.morphology.evaluate">
            <td>Notes</td>
            <td colspan="3">
                <textarea name="morphology[notes]" v-model="form.morphology.notes"></textarea>
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
            <th class="col_head" colspan="4">
                Cranial nerve assessment detected abnormality
                &mdash;
                <small>
                    Do you wish to evaluate?
                    <input type="radio" name="cranial_nerve[evaluate]" id="cranial-nerve-evaluate-yes" v-bind:value="1"
                           v-model="form.cranial_nerve.evaluate">
                    <label for="cranial-nerve-evaluate-yes">
                        (Y)
                    </label>
                    <input type="radio" name="cranial_nerve[evaluate]" id="cranial-nerve-evaluate-no" v-bind:value="0"
                           v-model="form.cranial_nerve.evaluate">
                    <label for="cranial-nerve-evaluate-no">
                        (N)
                    </label>
                </small>
            </th>
        </tr>
        <tr v-show="form.cranial_nerve.evaluate">
            <td>
                <input type="checkbox" id="cranial-nerve-olfactory"
                       name="cranial_nerve[olfactory]" v-model="form.cranial_nerve.olfactory" />
                <label for="cranial-nerve-olfactory">I Olfactory</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-optic"
                       name="cranial_nerve[optic]" v-model="form.cranial_nerve.optic" />
                <label for="cranial-nerve-optic">II Optic</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-occulomotor"
                       name="cranial_nerve[occulomotor]" v-model="form.cranial_nerve.occulomotor" />
                <label for="cranial-nerve-occulomotor">III Occulomotor</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-trochlear"
                       name="cranial_nerve[trochlear]" v-model="form.cranial_nerve.trochlear" />
                <label for="cranial-nerve-trochlear">IV Trochlear</label>
            </td>
        </tr>
        <tr v-show="form.cranial_nerve.evaluate">
            <td>
                <input type="checkbox" id="cranial-nerve-trigeminal"
                       name="cranial_nerve[trigeminal]" v-model="form.cranial_nerve.trigeminal" />
                <label for="cranial-nerve-trigeminal">V Trigeminal</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-abducens"
                       name="cranial_nerve[abducens]" v-model="form.cranial_nerve.abducens" />
                <label for="cranial-nerve-abducens">VI Abducens</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-facial"
                       name="cranial_nerve[facial]" v-model="form.cranial_nerve.facial" />
                <label for="cranial-nerve-facial">VII Facial</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-acoustic"
                       name="cranial_nerve[acoustic]" v-model="form.cranial_nerve.acoustic" />
                <label for="cranial-nerve-acoustic">VIII Acoustic</label>
            </td>
        </tr>
        <tr v-show="form.cranial_nerve.evaluate">
            <td>
                <input type="checkbox" id="cranial-nerve-glossopharyngeal"
                       name="cranial_nerve[glossopharyngeal]" v-model="form.cranial_nerve.glossopharyngeal" />
                <label for="cranial-nerve-glossopharyngeal">IX Glossopharyngeal</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-vagus"
                       name="cranial_nerve[vagus]" v-model="form.cranial_nerve.vagus" />
                <label for="cranial-nerve-vagus">X Vagus</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-accessory"
                       name="cranial_nerve[accessory]" v-model="form.cranial_nerve.accessory" />
                <label for="cranial-nerve-accessory">XI Accessory</label>
            </td>
            <td>
                <input type="checkbox" id="cranial-nerve-hypoglossal"
                       name="cranial_nerve[hypoglossal]" v-model="form.cranial_nerve.hypoglossal" />
                <label for="cranial-nerve-hypoglossal">XII Hypoglossal</label>
            </td>
        </tr>
        <tr v-show="form.cranial_nerve.evaluate">
            <td>Notes</td>
            <td colspan="3">
                <textarea name="cranial_nerve[notes]" v-model="form.cranial_nerve.notes"></textarea>
            </td>
        </tr>
    </table>
    <p></p>
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="30%" />
            <col width="70%" />
        </colgroup>
        <tr class="tr_bg_h">
            <th class="col_head" colspan="3">
                Occlusal analysis
                &mdash;
                <small>
                    Do you wish to evaluate?
                    <input type="radio" name="occlusal[evaluate]" id="occlusal-evaluate-yes" v-bind:value="1"
                           v-model="form.occlusal.evaluate">
                    <label for="occlusal-evaluate-yes">
                        (Y)
                    </label>
                    <input type="radio" name="occlusal[evaluate]" id="occlusal-evaluate-no" v-bind:value="0"
                           v-model="form.occlusal.evaluate">
                    <label for="occlusal-evaluate-no">
                        (N)
                    </label>
                </small>
            </th>
        </tr>
        <tr v-show="form.occlusal.evaluate">
            <td>Right working contacts</td>
            <td>
                <div is="teeth-selector" v-bind:selector.sync="form.occlusal.contacts.working.right"></div>
            </td>
        </tr>
        <tr v-show="form.occlusal.evaluate">
            <td>Left working contacts</td>
            <td>
                <div is="teeth-selector" v-bind:selector.sync="form.occlusal.contacts.working.left"></div>
            </td>
        </tr>
        <tr v-show="form.occlusal.evaluate">
            <td>Right non working contacts</td>
            <td>
                <div is="teeth-selector" v-bind:selector.sync="form.occlusal.contacts.non_working.right"></div>
            </td>
        </tr>
        <tr v-show="form.occlusal.evaluate">
            <td>Left non working contacts</td>
            <td>
                <div is="teeth-selector" v-bind:selector.sync="form.occlusal.contacts.non_working.left"></div>
            </td>
        </tr>
        <tr v-show="form.occlusal.evaluate">
            <td>Crossover interferences</td>
            <td>
                <div is="teeth-selector" v-bind:selector.sync="form.occlusal.crossover_interferences"></div>
            </td>
        </tr>
        <tr v-show="form.occlusal.evaluate">
            <td>Anterior guidance</td>
            <td>
                <select name="occlusal[guidance]" v-model="form.occlusal.guidance">
                    <option></option>
                    <?= dropdown($otherGuidance) ?>
                </select>
            </td>
        </tr>
        <tr v-show="form.occlusal.evaluate">
            <td>Notes</td>
            <td>
                <textarea name="occlusal[notes]" v-model="form.occlusal.notes"></textarea>
            </td>
        </tr>
    </table>
    <p></p>
    <table class="tr_bg table-striped" width="98%" align="center" cellspacing="1" cellpadding="5">
        <colgroup>
            <col width="30%" />
            <col width="70%" />
        </colgroup>
        <tr>
            <th colspan="2">
                Other
                &mdash;
                <small>
                    Do you wish to make additional notes?
                    <input type="radio" name="other[evaluate]" id="other-evaluate-yes" v-bind:value="1"
                           v-model="form.other.evaluate">
                    <label for="other-evaluate-yes">
                        (Y)
                    </label>
                    <input type="radio" name="other[evaluate]" id="other-evaluate-no" v-bind:value="0"
                           v-model="form.other.evaluate">
                    <label for="other-evaluate-no">
                        (N)
                    </label>
                </small>
            </th>
        </tr>
        <tr v-show="form.other.evaluate">
            <td>Notes</td>
            <td>
                <textarea name="other[notes]" v-model="form.other.notes"></textarea>
            </td>
        </tr>
    </table>
    <div align="right">
        <button class="save-action next btn btn_d" v-on:click.prevent="save">Save</button>
        &nbsp;&nbsp;&nbsp;
    </div>
</form>
<?php require_once __DIR__ . '/../manage/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/components/teeth-selector.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/patient/exams/advanced-pain-tmd.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<link rel="stylesheet" href="css/questionnaire.css" />
<link rel="stylesheet" href="css/table.css" />
<?php

require_once __DIR__ . '/includes/footer.php';
