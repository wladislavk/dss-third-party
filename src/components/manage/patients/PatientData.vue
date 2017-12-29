<template>
    <div>
        <!-- @todo: why do we need it? -->
        <div class="patient-chart" v-if="false">
            You are currently in a patient chart -
            <a v-legacy-href="'manage_patient.php'" class="back-to-list">Back to patient list</a>
        </div>
        <br />
        <patient-warnings v-show="showAllWarnings" v-bind:patient-id="patientId"></patient-warnings>
    </div>
</template>

<script src="./PatientData.js"></script>

<style src="../../../assets/css/manage/patients/patient-data.css" scoped></style>
