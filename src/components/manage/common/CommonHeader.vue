<template>
    <div>
        <right-top-menu></right-top-menu>
        <task-menu></task-menu>
        <left-top-menu></left-top-menu>

        <div class="bottom-image">
            <div class="dashboard-link">
                <router-link v-bind:to="{name: 'dashboard'}" id="logo">Dashboard</router-link>
            </div>
            <div class="patient-search">
                <patient-search></patient-search>
                <button v-on:click="goToAddPatient()">+ Add Patient</button>
                <button v-on:click="addTaskPopup()">+ Add Task</button>
            </div>
            <div v-if="companyLogo" class="company-logo">
                <img v-bind:src="companyLogo" alt="Company logo" title="Company logo" />
            </div>
            <div class="clear"></div>
        </div>
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
                <div class="suckertreemenu">
                    <span class="welcome-text">
                        Welcome {{ username }}
                    </span>
                </div>
                <patient-menu v-if="patientId"></patient-menu>
                <div class="clear" v-if="!patientId"></div>
            </div>
          <div class="clear"></div>
        </div>
    </div>
</template>

<script src="./CommonHeader.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/notifications.css" scoped></style>
<style src="../../../assets/css/manage/search-hints.css" scoped></style>
<style src="../../../assets/css/manage/top.css" scoped></style>
<style src="../../../assets/css/manage/letter-form.css" scoped></style>
<style src="../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../node_modules/sweetalert/dist/sweetalert.css" scoped></style>
<style src="../../../../node_modules/mint-ui/lib/style.css" scoped></style>
