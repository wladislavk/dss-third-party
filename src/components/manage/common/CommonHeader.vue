<template>
    <div>
        <div class="suckertreemenu2">
            <ul id="topmenu2">
                <li>
                    <router-link v-bind:to="{name: 'dashboard'}"> Notifications({{ notificationsNumber || 0 }})</router-link>
                </li>
                <li id="header_support" v-bind:class="{'pending': supportTicketsNumber}">
                    <a v-bind:href="legacyUrl + 'support.php'">Support {{ (supportTicketsNumber > 0) ? ('(' + supportTicketsNumber + ')'): '' }}</a>
                </li>
                <li>
                    <a href="#" v-on:click.prevent="logout()">Sign Out</a>
                </li>
            </ul>
        </div>

        <task-menu></task-menu>
        <div v-if="showOnlineCEAndSnoozleHelp">
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'edx_login.php'" target="_blank" onclick="removeCECookies(); return true;">Online CE</a>
            <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'help_login.php'" target="_blank" onclick="removeCECookies(); return true;">Snoozle/Help</a>
        </div>
        <a style="display:block; margin-right:20px; margin-top:8px; float:right;" v-bind:href="legacyUrl + 'calendar.php'">Scheduler</a>

        <div class="bottom-image">
            <div style="margin-top:10px; margin-left:20px; float:left;">
                <router-link v-bind:to="'/manage/index'" id="logo">Dashboard</router-link>
            </div>
            <div style="float:left; width:68%;">
                <form>
                    <div id="patient_search_div">
                        <input type="text" id="patient_search" value="Patient Search" name="q" autocomplete="off" /><br />
                        <div id="search_hints"  class="search_hints" style="display:none;">
                            <ul id="patient_list">
                                <li class="template" style="display:none">Doe, John S</li>
                            </ul>
                        </div>
                    </div>
                </form>

                <button onclick="window.location.href=legacyUrl + 'add_patient.php'" style="padding: 3px; margin-top:27px;">+ Add Patient</button>
                <button v-bind:onclick="loadPopup( + legacyUrl + 'add_task.php?pid=' + patientId)" style="padding: 3px; margin-top:27px;">+ Add Task</button>
            </div>
            <div v-if="companyLogo" style="float:right;margin:13px 15px 0 0;">
                <img v-bind:src="companyLogo" />
            </div>
            <div style="clear:both;"></div>
        </div>
        <div class="body-image">
            <div style="width:98.6%; background:#00457c;margin:0 auto;">
                <div
                    v-if="patientId"
                    id="patient_name_div"
                    v-bind:style="patientName.length > 20 ? 'font-size:14px' : ''"
                >
                    <div id="patient_name_inner">
                        <img v-if="medicare" src="../../../assets/images/medicare_logo_small.png" />
                        <span v-bind:class="{ 'medicare_name': medicare, 'name': !medicare }">
                            {{ patientName }}
                            <a
                                v-if="displayAlert && alertText.length > 0"
                                href="#"
                                v-bind:title="'Notes: ' + alertText"
                                onclick="return false"
                                style="font-weight:bold; font-size:18px; color:#FF0000;"
                            >Notes</a>
                            <a
                                v-if="premedCheck === 1 || allergen === 1"
                                v-bind:href="legacyUrl + 'q_page3.php?pid=' + patientId"
                                v-bind:title="headerTitle"
                                style="font-weight:bold; font-size:18px; color:#FF0000;"
                            >*Med</a>
                        </span>
                    </div>
                </div>

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

                <div v-if="patientId" id="patient_nav">
                    <ul>
                        <li>
                            <a class="<?php echo ($_SERVER['PHP_SELF']=='/manage/manage_flowsheet3.php')?'nav_active':'';?>" v-bind:href="legacyUrl + 'manage_flowsheet3.php?pid=' + patientId + '&addtopat=1'">Tracker</a>
                        </li>
                        <li>
                            <a class="<?php echo ($_SERVER['PHP_SELF']=='/manage/dss_summ.php')?'nav_active':'';?>" v-bind:href="legacyUrl + 'dss_summ.php?pid=' + patientId + '&addtopat=1'">Summary Sheet</a>
                        </li>
                        <li>
                            <a class="<?php echo ($_SERVER['PHP_SELF']=='/manage/manage_ledger.php')?'nav_active':'';?>" v-bind:href="legacyUrl + 'manage_ledger.php?pid=' + patientId + '&addtopat=1'">Ledger</a>
                        </li>
                        <li>
                            <a class="<?php echo ($_SERVER['PHP_SELF']=='/manage/manage_insurance.php')?'nav_active':'';?>" v-bind:href="legacyUrl + 'manage_insurance.php?pid=' + patientId + '&addtopat=1'">Insurance</a>
                        </li>
                        <li>
                            <a class="<?php echo ($_SERVER['PHP_SELF']=='/manage/manage_progress_notes.php')?'nav_active':'';?>" v-bind:href="legacyUrl + 'dss_summ.php?sect=notes&pid=' + patientId + '&addtopat=1'">Progress Notes</a>
                        </li>
                        <li>
                            <a class="<?php echo ($_SERVER['PHP_SELF']=='/manage/patient_letters.php')?'nav_active':'';?>" v-bind:href="legacyUrl + 'dss_summ.php?sect=letters&pid=' + patientId + '&addtopat=1'">Letters</a>
                        </li>
                        <li>
                            <a class="<?php echo ($_SERVER['PHP_SELF']=='/manage/q_image.php')?'nav_active':'';?>" v-bind:href="legacyUrl + 'q_image.php?pid=' + patientId">Images</a>
                        </li>
                        <li>
                            <a class="<?php echo (strpos($_SERVER['PHP_SELF'],'q_page') || strpos($_SERVER['PHP_SELF'],'q_sleep'))?'nav_active':'';?>" v-bind:href="legacyUrl + 'q_page1.php?pid=' + patientId + '&addtopat=1'">Questionnaire</a>
                        </li>
                        <li>
                            <a class="<?php echo (strpos($_SERVER['PHP_SELF'],'ex_page'))?'nav_active':'';?>" v-bind:href="legacyUrl + 'ex_page4.php?pid=' + patientId + '&addtopat=1'">Clinical Exam</a>
                        </li>
                        <li class="last">
                            <a
                                v-bind:class="$route.name == 'edit-patient' ? 'nav_active' : ''"
                                v-bind:href="legacyUrl + 'add_patient.php?ed=' + patientId + '&addtopat=1&pid=' + patientId"
                            >Patient Info</a>
                        </li>
                    </ul>
                </div>
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
