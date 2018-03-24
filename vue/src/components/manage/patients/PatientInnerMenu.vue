<template>
    <div
        id="patient_name_div"
        class="patient_name_div"
        v-bind:class="{ 'long-patient': longPatientName }"
    >
        <div id="patient_name_inner">
            <img v-if="medicare" src="../../../assets/images/medicare_logo_small.png" />
            <span class="patient_name" v-bind:class="{ 'medicare_name': medicare, 'name': !medicare }">
                <span>{{ patientName }}</span>
                <!-- @todo: why is this link needed? -->
                <a
                    v-if="displayNotes"
                    href="#"
                    v-bind:title="'Notes: ' + alertText | unescape"
                    v-on:click.prevent=""
                >Notes</a>
                <a
                    v-if="displayMed"
                    v-legacy-href="'manage/q_page3.php?pid=' + patientId"
                    v-bind:title="headerTitle"
                >*Med</a>
            </span>
        </div>
    </div>
</template>

<script src="./PatientInnerMenu.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/patients/patient-inner-menu.scss";
</style>
