<template>
    <div>
        <right-top-menu></right-top-menu>
        <task-menu></task-menu>
        <div v-if="showOnlineCEAndSnoozleHelp">
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'edx_login.php'" target="_blank" onclick="removeCECookies(); return true;">Online CE</a>
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'help_login.php'" target="_blank" onclick="removeCECookies(); return true;">Snoozle/Help</a>
        </div>
        <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'calendar.php'">Scheduler</a>

        <div class="bottom-image">
            <div style="margin-top:10px; margin-left:20px; float:left;">
                <router-link v-bind:to="{name: 'dashboard'}" id="logo">Dashboard</router-link>
            </div>
            <div style="float:left; width:68%;">
                <patient-search></patient-search>
                <button v-on:click="'window.location.href=' + legacyUrl + 'add_patient.php'" style="padding: 3px; margin-top:27px;">+ Add Patient</button>
                <button v-on:click="loadPopup( + legacyUrl + 'add_task.php?pid=' + patientId)" style="padding: 3px; margin-top:27px;">+ Add Task</button>
            </div>
            <div v-if="companyLogo" style="float:right;margin:13px 15px 0 0;">
                <img v-bind:src="companyLogo" alt="Company logo" title="Company logo" />
            </div>
            <div style="clear:both;"></div>
        </div>
        <div class="body-image">
            <div style="width:98.6%; background:#00457c;margin:0 auto;">
                <patient-inner-menu v-if="patientId"></patient-inner-menu>
                <patient-task-menu
                    v-if="patientId"
                    v-bind:patient-id="patientId"
                ></patient-task-menu>
                <template v-if="patientId">
                    <a
                        v-show="!showAllWarnings"
                        href="#"
                        style="float:left; margin-left:10px;margin-top:8px;"
                        class="button"
                        id="show_patient_warnings"
                        v-on:click.prevent="showWarnings()"
                    >Show Warnings</a>
                    <a
                        v-show="showAllWarnings"
                        href="#"
                        style="float:left; margin-left:10px;margin-top:8px;"
                        class="button"
                        id="hide_patient_warnings"
                        v-on:click.prevent="hideWarnings()"
                    >Hide Warnings</a>
                </template>
                <div class="suckertreemenu">
                    <span style="line-height:38px; margin-right:10px;font-size:20px; color:#fff; float:right;">
                        Welcome {{ username }}
                    </span>
                </div>
                <patient-menu v-if="patientId"></patient-menu>
                <div v-else style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
</template>

<!-- TODO: rewrite legacy scripts to the new structure -->
<!-- <script src="../../assets/js/manage/top.js"></script> -->

<script src="./CommonHeader.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/notifications.css" scoped></style>
<style src="../../../assets/css/manage/search-hints.css" scoped></style>
<style src="../../../assets/css/manage/top.css" scoped></style>
<style src="../../../assets/css/manage/letter-form.css" scoped></style>
<style src="../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../node_modules/sweetalert/dist/sweetalert.css" scoped></style>
<style src="../../../../node_modules/mint-ui/lib/style.css" scoped></style>
