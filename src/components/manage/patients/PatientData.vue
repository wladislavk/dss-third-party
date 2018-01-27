<template>
    <div>
        <div class="patient-chart">
            You are currently in a patient chart -
            <a v-bind:href="legacyUrl + 'manage_patient.php'" class="back-to-list">Back to patient list</a>
        </div>
        <br />
        <patient-warnings v-show="showAllWarnings" v-bind:patient-id="patientId"></patient-warnings>
    </div>
</template>

<script src="./PatientData.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/patients/patient-data.scss";
</style>
