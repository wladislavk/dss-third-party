<template>
    <div class="body-image">
        <div class="patient-menus">
            <patient-inner-menu v-bind:patient-id="patientId"></patient-inner-menu>
            <patient-task-menu v-bind:patient-id="patientId"></patient-task-menu>
            <span>
                <a
                    v-show="!showAllWarnings"
                    href="#"
                    class="button"
                    id="show_patient_warnings"
                    v-on:click.prevent="showWarnings()"
                >Show Warnings</a>
                <a
                    v-show="showAllWarnings"
                    href="#"
                    class="button"
                    id="hide_patient_warnings"
                    v-on:click.prevent="hideWarnings()"
                >Hide Warnings</a>
            </span>
            <welcome-text></welcome-text>
            <patient-menu v-bind:patient-id="patientId"></patient-menu>
        </div>
        <div class="clear"></div>
    </div>
</template>

<script src="./PatientHeader.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/patients/patient-header.scss";
</style>
