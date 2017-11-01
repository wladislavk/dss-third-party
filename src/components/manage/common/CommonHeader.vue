<template>
    <div>
        <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td colspan="2" align="right" ></td>
            </tr>
            <tr>
                <td valign='top' height="400">
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
                    <div id="contentMain">
                        <div style="clear:both;"></div>

                        <div v-if="patientId" style="margin-left:20px;float:left;width:400px;display:none;">
                            You are currently in a patient chart -
                            <a v-bind:href="legacyUrl + 'manage_patient.php'" target="_self" style="font-weight:bold;">BACK TO PATIENT LIST</a>
                        </div>
                        <div v-if="patientId" style="float:right;width:300px;"></div>
                        <br />

                        <div
                            v-if="patientId"
                            v-show="showAllWarnings"
                            id="patient_warnings"
                        >
                            <a v-if="showWarningAboutPatientChanges" class="warning" v-bind:href="legacyUrl + 'patient_changes.php?pid=' + patientId">
                                <span>Warning! Patient has updated their PROFILE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
                            </a>
                            <a v-if="showWarningAboutQuestionnaireChanges" class="warning" v-bind:href="legacyUrl + 'q_page1.php?pid=' + patientId + '&addtopat=1'" >
                                <span>Warning! Patient has updated their QUESTIONNAIRE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
                            </a>
                            <a v-if="showWarningAboutBouncedEmails" class="warning" v-bind:href="legacyUrl + 'add_patient.php?ed=' + patientId + '&pid=' + patientId + '&addtopat=1'" >
                                <span>Warning! Email sent to this patient has bounced. Please click to check patients email.</span>
                            </a>
                            <span v-if="rejectedClaimsForCurrentPatient.length > 0" class="warning">Warning! Patient has the following rejected claims: <br />
                                <template v-for="claim in rejectedClaimsForCurrentPatient">
                                    <a v-bind:href="legacyUrl + 'view_claim.php?claimid=' + claim.insuranceid + '&pid=' + patientId">
                                        {{ claim.insuranceid }} - {{ claim.adddate | moment("MM/DD/YYYY") }}
                                    </a>
                                    <br />
                                </template>
                            </span>
                            <span v-if="incompleteHomeSleepTests.length" class="warning">Patient has the following Home Sleep Tests: <br />
                                <span v-for="incompleteTest in incompleteHomeSleepTests">
                                    <a v-bind:href="legacyUrl + '/manage/hst_request.php?pid=' + incompleteTest.patient_id + '&amp;hst_id=' + incompleteTest.id">HST was requested {{ incompleteTest.adddate | moment("MM/DD/YYYY") }}</a>
                                    and is currently
                                    <a v-if="incompleteTest.status === constants.DSS_HST_REJECTED" v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">{{ constants.preAuthLabels[incompleteTest.status] }}</a>
                                    <span v-else>{{ constants.preAuthLabels[incompleteTest.status] }}</span>
                                    <span v-if="incompleteTest.status === constants.DSS_HST_SCHEDULED"> - {{ incompleteTest.office_notes }}</span>
                                    <span v-if="incompleteTest.status === constants.DSS_HST_REJECTED"> - {{ incompleteTest.rejected_reason }}</span>
                                    <span v-if="incompleteTest.status === constants.DSS_HST_REJECTED && incompleteTest.rejecteddate"> - {{ incompleteTest.rejecteddate | moment("MM/DD/YYYY hh:mm a") }}</span>
                                    <br />
                                    <a v-if="incompleteTest.status == constants.DSS_HST_REJECTED" v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">Click here</a> to remove this error
                                </span>
                            </span>
                        </div>

                        <!-- Router content -->
                        <router-view></router-view>
                    </div>
                    <div class="footer-image">
                    </div>
                </td>
            </tr>
            <!-- Stick Footer Section Here -->
        </table>

        <div id="warn_logout" ref="warning-logout">
            <br /><br />

            <img src="../../../assets/images/logo.gif" /><br />
            <h1>Your screen has been locked for privacy due to inactivity.<br />Click to reopen your Dental Sleep Solutions software.</h1>
            <p style="color:#fff;font-size:20px;">Log out in <span id="logout_time_remaining" ref="logout-timer"></span>!</p>

            <br /><br />

            <a href="#" v-on:click.prevent="logout">Logout</a>
            <a href="#" v-on:click.prevent="resetInterval">Stay logged in</a>
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
