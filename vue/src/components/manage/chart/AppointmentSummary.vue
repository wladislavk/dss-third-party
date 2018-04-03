<template>
    <div id="appt_summ" class="appt_summ">
        <table width="98%" class="table table-bordered table-hover">
            <tr>
                <th>Date</th>
                <th>Treatment</th>
                <th class="letters">Letters</th>
                <th></th>
            </tr>
            <appointment-summary-row
                v-for="summary in summaries"
                v-if="summary.dateCompleted"
                v-bind:patient-id="patientId"
                v-bind:element-id="summary.id"
                v-bind:segment-id="summary.segmentId"
                v-bind:device-id="summary.deviceId"
                v-bind:element-type="summary.type"
                v-bind:date-completed="summary.dateCompleted"
                v-bind:delay-reason="summary.delayReason"
                v-bind:non-compliance-reason="summary.nonComplianceReason"
                v-bind:study-type="summary.studyType"
                v-bind:letter-count="letterCount(summary.id)"
                v-bind:letters-sent="areLettersSent(summary.id)"
                v-bind:key="summary.id"
            ></appointment-summary-row>
        </table>
    </div>
</template>

<script src="./AppointmentSummary.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/chart/appointment-summary.scss";
</style>
