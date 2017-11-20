<template>
    <div>
        <right-top-menu></right-top-menu>
        <task-menu></task-menu>
        <left-top-menu></left-top-menu>
        <div class="bottom-image">
            <div class="dashboard-link">
                <router-link v-bind:to="{name: 'dashboard'}" class="logo-link">Dashboard</router-link>
            </div>
            <div class="patient-search">
                <patient-search></patient-search>
                <button id="add_patient_button" v-on:click="goToAddPatient()">+ Add Patient</button>
                <button id="add_task_button" v-on:click="addTaskPopup()">+ Add Task</button>
            </div>
            <!-- @todo: this is not likely to work in legacy, migrate after other modules are migrated -->
            <!--
            <div v-if="companyLogo" class="company-logo">
                <img v-bind:src="companyLogo" alt="Company logo" title="Company logo" />
            </div>
            -->
            <div class="clear"></div>
        </div>
        <patient-header v-if="patientId" v-bind:patient-id="patientId"></patient-header>
        <div class="body-image" v-else>
            <div class="patient-menus">
                <welcome-text></welcome-text>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</template>

<script src="./CommonHeader.js"></script>

<style src="../../../assets/css/manage/common/common-header.css" scoped></style>
