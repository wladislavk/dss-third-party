<template>
    <div
        id="patient_name_div"
        class="patient_name_div"
        v-bind:style="{ 'font-size': longPatientFont }"
    >
        <div id="patient_name_inner">
            <img v-if="medicare" src="../../../assets/images/medicare_logo_small.png" />
            <span v-bind:class="{ 'medicare_name': medicare, 'name': !medicare }">
                <span>{{ patientName }}</span>
                <!-- @todo: why is this link needed? -->
                <a
                    v-if="displayNotes"
                    href="#"
                    v-bind:title="'Notes: ' + alertText"
                    v-on:click.prevent=""
                    style="font-weight:bold; font-size:18px; color:#FF0000;"
                >Notes</a>
                <a
                    v-if="displayMed"
                    v-bind:href="legacyUrl + 'manage/q_page3.php?pid=' + patientId"
                    v-bind:title="headerTitle"
                    style="font-weight:bold; font-size:18px; color:#FF0000;"
                >*Med</a>
            </span>
        </div>
    </div>
</template>

<script src="./PatientInnerMenu.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/patients/patient-inner-menu.scss";
</style>
