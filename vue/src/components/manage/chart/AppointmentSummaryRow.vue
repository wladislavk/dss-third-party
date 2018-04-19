<template>
    <tr v-bind:id="'completed_row_' + elementId">
        <td>
            <datepicker
                name="completed_date"
                v-bind:id="'completed_date_' + elementId"
                input-class="completed_date flow_comp_calendar form-control date text-center"
                format="MM/dd/yyyy"
                v-model="currentDateCompleted"
                v-on:selected="updateCompletedDate($event)"
            ></datepicker>
        </td>
        <td class="form-inline">
            <span class="title">{{ segmentName }}</span>
            <br />
            <sleep-study-row
                v-if="isSleepStudy"
                v-bind:patient-id="patientId"
                v-bind:element-id="elementId"
                v-bind:segment-id="segmentId"
                v-bind:study-type="studyType"
            ></sleep-study-row>
            <reason-row
                v-if="isReason"
                v-bind:patient-id="patientId"
                v-bind:element-id="elementId"
                v-bind:segment-id="segmentId"
                v-bind:reason="reason"
            ></reason-row>
            <device-row
                v-if="isDevice"
                v-bind:patient-id="patientId"
                v-bind:element-id="elementId"
                v-bind:device-id="deviceId"
            ></device-row>
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
                v-if="canBeDeleted"
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
