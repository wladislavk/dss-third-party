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
                <!-- @todo: check which legacy link is correct, original code has both -->
                <!--v-legacy-href="'manage/patient_letters.php?pid=' + patientId"-->
                <a
                    v-if="letterCount"
                    v-legacy-href="'manage/dss_summ.php?sect=leters&pid=' + patientId"
                    class="btn btn-info btn-sm"
                >{{ letterCount }} Letters</a>
                <span v-else>0 Letters</span>
            </td>
            <td>
                <a
                    href="#"
                    v-on:click.prevent="deleteSegment(flowElement.id)"
                    class="addButton deleteButton btn btn-danger btn-sm"
                >Delete</a>
            </td>
        </tr>
        <appointment-summary-row
            v-for="flowElement in flowElements"
            v-if="flowElement.dateCompleted"
            v-bind:patient-id="patientId"
            v-bind:element-id="flowElement.id"
            v-bind:segment-id="flowElement.segmentId"
            v-bind:device-id="flowElement.deviceId"
            v-bind:study-type="flowElement.studyType"
            v-bind:delay-reason="flowElement.delayReason"
            v-bind:non-compliance-reason="flowElement.nonComplianceReason"
            v-bind:date-completed="flowElement.dateCompleted"
            v-bind:devices="devices"
            v-bind:letters="letters"
            v-bind:key="flowElement.id"
        ></appointment-summary-row>
    </table>
</template>

<script src="./AppointmentSummary.js"></script>
