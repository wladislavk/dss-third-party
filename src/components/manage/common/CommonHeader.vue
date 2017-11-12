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
                <button v-on:click="goToAddPatient()">+ Add Patient</button>
                <button v-on:click="addTaskPopup()">+ Add Task</button>
            </div>
            <div v-if="companyLogo" class="company-logo">
                <img v-bind:src="companyLogo" alt="Company logo" title="Company logo" />
            </div>
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
<!--
<style src="../../../assets/css/manage/search-hints.css" scoped></style>
<style src="../../../assets/css/manage/top.css" scoped></style>
<style src="../../../assets/css/manage/letter-form.css" scoped></style>
<style src="../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../node_modules/sweetalert/dist/sweetalert.css" scoped></style>
<style src="../../../../node_modules/mint-ui/lib/style.css" scoped></style>
-->
