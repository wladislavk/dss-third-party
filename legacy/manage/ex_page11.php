<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/patient_info.php';

$patientId = intval($_GET['pid']);

$isHistoricView = isset($_GET['history_id']);
$historyId = $isHistoricView ? intval($_GET['history_id']) : 0;
$isCreateNew = !empty($_POST['create_new']);

include __DIR__ . '/includes/form_top.htm';
?>
<p></p>
<div id="assessment-plan">
    <form class="q_form vue-module" name="ex_page11frm" method="post">
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
                <tr class="hidden" v-bind:class="[true ? 'unhide' : 'hidden']">
                    <td>Initiated:</td>
                    <td>{{ initiatedTimestamp | dateFormat 'MM/DD/YYYY HH:mm' }}</td>
                </tr>
                <tr class="hidden" v-bind:class="[true ? 'unhide' : 'hidden']">
                    <td>Last Modified:</td>
                    <td>{{ lastModifiedTimestamp | dateFormat 'MM/DD/YYYY HH:mm' }}</td>
                </tr>
                </tbody>
            </table>
            <select>
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
            Assessment
        </h3>
        <table width="98%" align="center" cellspacing="1" cellpadding="5">
            <colgroup>
                <col width="40%" />
                <col width="60%" />
            </colgroup>
            <tr>
                <td>
                    <div is="transaction-codes-selector" patient-id="<?= $patientId ?>" patient-key="patient_id" code-type="diagnosis" v-bind:selector.sync="form.assessment_codes"></div>
                </td>
                <td>
                    <textarea name="assessment[description]" v-model="form.assessment_description" rows="6" cols="60"></textarea>
                    <button v-on:click.prevent="loadCustomText('assessment_description')">Use custom text</button>
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
                    <div is="transaction-codes-selector" patient-id="<?= $patientId ?>" patient-key="patient_id" code-type="treatment" v-bind:selector.sync="form.treatment_codes"></div>
                </td>
                <td>
                    <textarea name="treatment[description]" v-model="form.treatment_description" rows="6" cols="60"></textarea>
                    <button v-on:click.prevent="loadCustomText('treatment_description')">Use custom text</button>
                </td>
            </tr>
        </table>
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
<script type="text/javascript" src="/assets/app/components/transaction-codes-selector.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/patient/exams/assessment-plan.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<?php
require_once __DIR__ . '/includes/bottom.htm';
?>
