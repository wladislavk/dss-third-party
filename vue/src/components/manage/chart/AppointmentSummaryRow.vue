<template>
    <tr v-bind:id="'completed_row_' + elementId">
        <td>
            <datepicker
                name="completed_date"
                v-bind:id="'completed_date_' + elementId"
                input-class="completed_date flow_comp_calendar form-control date text-center"
                format="MM/dd/yyyy"
                v-model="dateCompleted"
                v-on:selected="updateCompletedDate()"
            ></datepicker>
        </td>
        <td class="form-inline">
            <span class="title">{{ segmentName }}</span>
            <template v-if="segmentName === 'Titration Sleep Study'">
                <br />
                <select
                    class="study_type form-control"
                    v-bind:id="'study_type_' + elementId"
                    v-bind:name="'data[' + elementId + '][study_type]'"
                    v-model="studyType"
                    v-on:change="updateStudyType($event)"
                >
                    <option value="">Select Type</option>
                    <option v-for="titrationType in titrationTypes" v-bind:value="titrationType">{{ titrationType }}</option>
                </select>
            </template>
            <template v-else-if="segmentName === 'Baseline Sleep Test'">
                <br />
                <select
                    class="study_type form-control"
                    v-bind:id="'study_type_' + elementId"
                    v-bind:name="'data[' + elementId + '][study_type]'"
                    v-model="studyType"
                    v-on:change="updateStudyType($event)"
                >
                    <option value="">Select Type</option>
                    <option v-for="baselineType in baselineTypes" v-bind:value="baselineType">{{ baselineType }}</option>
                </select>
            </template>
            <template v-else-if="segmentName === 'Delaying Tx / Waiting'">
                <!-- @todo: after the migration replace "currentDelayReason" with "delayReason" -->
                <select
                    class="delay_reason form-control"
                    v-bind:id="'delay_reason_' + elementId"
                    v-bind:name="'data[' + elementId + '][delay_reason]'"
                    v-model="currentDelayReason"
                    v-on:change="updateDelayReason($event)"
                >
                    <option v-for="reason in delayReasons" v-bind:value="reason.value">{{ reason.text }}</option>
                </select>
                <br />
                <a
                    href="#"
                    v-bind:id="'reason_btn' + elementId"
                    v-on:click.prevent="openFlowsheetModal()"
                    v-show="delayReason === 'other'"
                >Show Reason</a>
            </template>
            <template v-else-if="segmentName === 'Pt. Non-Compliant'">
                <br />
                <select
                    class="noncomp_reason form-control"
                    v-bind:id="'noncomp_reason' + elementId"
                    v-bind:name="'data[' + elementId + '][noncomp_reason]'"
                    v-model="nonComplianceReason"
                    v-on:change="updateNonComplianceReason($event)"
                >
                    <option v-for="reason in nonComplianceReasons" v-bind:value="reason.value">{{ reason.text }}</option>
                </select>
                <br />
                <a
                    href="#"
                    v-bind:id="'reason_btn' + elementId"
                    v-on:click.prevent="openFlowsheetModal()"
                    v-show="nonComplianceReason === 'other'"
                >Show Reason</a>
            </template>
            <template v-else-if="isDeviceSegment">
                <select
                    class="dentaldevice form-control"
                    v-bind:id="'dentaldevice_' + elementId"
                    v-model="defaultDeviceId"
                    v-on:change="updateDeviceId($event)"
                >
                    <option value=""></option>
                    <option v-for="device in devices" v-bind:value="device.id">{{ device.device }}</option>
                </select>
            </template>
        </td>
        <td class="letters">
            <a
                v-legacy-href="'dss_summ.php?sect=letters&pid=' + patientId"
                class="btn btn-info btn-sm"
                v-if="letterCount"
            >{{ letterCount }} Letters</a>
            <span v-else>0 Letters</span>
        </td>
        <td>
            <a
                href="#"
                v-if="segmentName !== 'Initial Contact'"
                v-on:click.prevent="deleteStep()"
                class="addButton deleteButton btn btn-danger btn-sm button"
            >Delete</a>
        </td>
    </tr>
</template>

<script src="./AppointmentSummaryRow.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/chart/appointment-summary-row.scss";
</style>

<style lang="scss">
    @import "../../../assets/css/manage/chart/chart-calendar.scss";
</style>
