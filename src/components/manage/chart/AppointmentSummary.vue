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
              v-for="flowElement in flowElements"
              v-if="flowElement.dateCompleted"
              v-bind:patient-id="patientId"
              v-bind:element-id="flowElement.id"
              v-bind:segment-id="flowElement.segmentId"
              v-bind:device-id="flowElement.deviceId"
              v-bind:element-type="flowElement.type"
              v-bind:date-completed="flowElement.dateCompleted"
              v-bind:letters="letters"
              v-bind:key="flowElement.id"
          ></appointment-summary-row>
      </table>
  </div>
</template>

<script src="./AppointmentSummary.js"></script>

<style lang="scss" scoped>
  @import "../../../assets/css/manage/chart/appointment-summary.scss";
</style>
