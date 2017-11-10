<template>
    <div class="body-image">
        <div class="patient-menus">
            <patient-inner-menu v-if="patientId"></patient-inner-menu>
            <patient-task-menu
                v-if="patientId"
                v-bind:patient-id="patientId"
            ></patient-task-menu>
            <span v-if="patientId">
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
            <patient-menu v-if="patientId"></patient-menu>
            <div class="clear" v-if="!patientId"></div>
        </div>
        <div class="clear"></div>
    </div>
</template>

<script src="./PatientRoot.js"></script>
