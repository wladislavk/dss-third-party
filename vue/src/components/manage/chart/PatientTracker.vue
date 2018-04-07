<template>
    <div>
        <chart-buttons v-bind:patient-id="patientId"></chart-buttons>
        <div id="treatment_div" class="treatment_div">
            <h3>1) What did you do today?*</h3>
            <tracker-section-one v-bind:patient-id="patientId"></tracker-section-one>
            <span class="sub_text sub_text_left">*Click a treatment above to add it to the Treatment Summary</span>
        </div>
        <div id="step2" class="step2">
            <h3>2) What will you do next?*</h3>
            <tracker-section-two v-bind:patient-id="patientId"></tracker-section-two>
            <span class="sub_text sub_text_right">*After Step 1, choose the next patient treatment and date</span>
            <h3 class="summary">Treatment Summary</h3>
            <appointment-summary v-bind:patient-id="patientId"></appointment-summary>
        </div>
        <div class="clear"></div>
    </div>
</template>

<script src="./PatientTracker.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/chart/patient-tracker.scss";
</style>
