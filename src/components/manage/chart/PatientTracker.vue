<template>
    <div>
        <chart-buttons v-bind:patient-id="patientId"></chart-buttons>
        <div id="treatment_div">
            <h3>1) What did you do today?*</h3>
            <tracker-section-one></tracker-section-one>
            <span class="sub_text">*Click a treatment above to add it to the Treatment Summary</span>
        </div>
        <div id="step2">
            <h3>2) What will you do next?*</h3>
            <tracker-section-two></tracker-section-two>
            <span class="sub_text">*After Step 1, choose the next patient treatment and date</span>
            <h3>Treatment Summary</h3>
            <div id="appt_summ" class="appt_summ">
                <appointment-summary
                    v-bind:patient-id="patientId"
                    v-bind:letter-count="letterCount"
                ></appointment-summary>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
</template>

<script src="./PatientTracker.js"></script>

<style src="../../../assets/css/manage/patient-tracker.css" scoped></style>
