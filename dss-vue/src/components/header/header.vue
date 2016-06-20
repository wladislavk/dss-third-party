<style src="./header.css"></style>

<template>
    <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
    <!-- Header and nav goes here -->
        <tr>
            <td colspan="2" align="right" ></td>
        </tr>
        <tr>
            <td valign='top' height="400">
                <div class="suckertreemenu2">
                    <ul id="topmenu2">
                        <li>
                            <a href="index.php"> Notifications({{ notificationsNumber || 0 }})</a>
                        </li>
                        <li id="header_support" v-bind:class="{'pending': supportTicketsNumber}">
                            <a href="support.php">Support {{ (supportTicketsNumber > 0) ? ('(' + supportTicketsNumber + ')'): '' }}</a>
                        </li>
                        <li>
                            <a href="logout.php">Sign Out</a>
                        </li>
                    </ul>
                </div>

                <div id="task_menu" class="task_menu" style="margin-top:8px;float:right">
                    <span id="task_header">
                        My Tasks (<span id="task_count">{{ tasksNumber }}</span>)
                    </span>
                    <div id="task_list" style="border: solid 1px #000; position: absolute; z-index:20;background:#fff;padding:10px;display:none;">
                        <h4 v-if="overdueTasks.length > 0" id="task_od_header" style="color:red;" class="task_od_header">Overdue</h4>
                        <ul v-if="overdueTasks.length > 0" id="task_od_list">
                            <li v-on:mouseenter="onMouseEnterTaskItem" v-for="task in overdueTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input v-on:click="onClickTaskStatus" type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <h4 v-if="todayTasks.length > 0" id="task_tod_header" class="task_tod_header">Today</h4>
                        <ul v-if="todayTasks.length > 0" id="task_tod_list">
                            <li v-for="task in todayTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input v-on:click="onClickTaskStatus" type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <h4 v-if="tomorrowTasks.length > 0" id="task_tom_header" class="task_tom_header">Tomorrow</h4>
                        <ul v-if="tomorrowTasks.length > 0" id="task_tom_list">
                            <li v-for="task in tomorrowTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input v-on:click="onClickTaskStatus" type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <h4 v-if="headerInfo.thisWeekTasks.length > 0" id="task_tw_header" class="task_tw_header">This Week</h4>
                        <ul v-if="headerInfo.thisWeekTasks.length > 0" id="task_tw_list">
                            <li v-for="task in headerInfo.thisWeekTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input v-on:click="onClickTaskStatus" type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <h4 v-if="headerInfo.nextWeekTasks.length > 0" id="task_nw_header" class="task_nw_header">Next Week</h4>
                        <ul v-if="headerInfo.nextWeekTasks.length > 0" id="task_nw_list">
                            <li v-for="task in headerInfo.nextWeekTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input v-on:click="onClickTaskStatus" type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <h4 v-if="headerInfo.laterTasks.length > 0" id="task_lat_header" class="task_lat_header">Later</h4>
                        <ul v-if="headerInfo.laterTasks.length > 0" id="task_lat_list">
                            <li v-for="task in headerInfo.laterTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input v-on:click="onClickTaskStatus" type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.due_date | moment "MM DD" }}
                                    -
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <br /><br />

                        <a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>
                    </div>
                </div>
                <div v-if="showOnlineCEAndSnoozleHelp">
                    <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="edx_login.php" target="_blank" onclick="removeCECookies(); return true;">Online CE</a>
                    <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="help_login.php" target="_blank" onclick="removeCECookies(); return true;">Snoozle/Help</a>
                </div>
                <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="calendar.php">Scheduler</a>

                <div style="height:89px; width:100%; background:url(assets/images/dss_01.png) #0b5c82 no-repeat top left;"> 
                    <div style="margin-top:10px; margin-left:20px; float:left;">
                        <a href="/manage" id="logo">Dashboard</a>
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

                        <button onclick="window.location='add_patient.php'" style="padding: 3px; margin-top:27px;">+ Add Patient</button>
                        <button onclick="loadPopup('add_task.php?pid={{ $route.query.pid || 0 }}')" style="padding: 3px; margin-top:27px;">+ Add Task</button>
                    </div>
                    <div v-if="companyLogo" style="float:right;margin:13px 15px 0 0;">
                        <img src="display_file.php?f={{ companyLogo }}" />
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <div style="background:url(assets/images/dss_03.jpg) #0b5c82 repeat-y top left;width:100%;">
                    <div style="width:98.6%; background:#00457c;margin:0 auto;">
                        <div v-if="$route.query.pid" id="patient_name_div" {{ (patientName.length > 20) ? 'style="font-size:14px"' : '' }}>
                            <div id="patient_name_inner">
                                <img v-if="medicare" src="assets/images/medicare_logo_small.png" /> 
                                <span v-if="medicare" class="medicare_name">
                                <span v-else class="name">
                                    {{ patientName }}
                                    <a v-if="displayAlert && alertText.length > 0" href="#" title="{{ 'Notes: ' + alertText }}" onclick="return false" style="font-weight:bold; font-size:18px; color:#FF0000;">Notes</a>
                                    <a v-if="premedCheck == 1 || alergen == 1" href="q_page3.php?pid={{ $route.query.pid || 0 }}" title="{{ title }}" style="font-weight:bold; font-size:18px; color:#FF0000;">*Med</a>
                                </span>
                            </div>
                        </div>
                        <div v-if="$route.query.pid && patientTaskNumber > 0" class="task_menu" id="pat_task_menu" style="float:left; margin:10px 0 0 10px;">
                            <span id="pat_task_header" style="font-size:14px; font-weight:normal; color:#fff;">Tasks({{ patientTaskNumber }})</span>
                            <div class="task_list" id="pat_task_list" style="display:none;">
                                <h4 v-if="headerInfo.patientOverdueTasks.length > 0" id="pat_task_od_header" style="color:red" class="task_od_header">Overdue</h4>
                                <ul v-if="headerInfo.patientOverdueTasks.length > 0" id="pat_task_od_list">
                                    <li v-for="task in headerInfo.patientOverdueTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                        <div class="task_extra" id="task_extra_{{ task.id }}" >
                                            <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                            <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                        </div>
                                        <input type="checkbox" class="task_status" value="{{ task.id }}" />
                                        {{ task.task }}

                                        <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>
                                    </li>
                                </ul>

                                <h4 v-if="headerInfo.patientTodayTasks.length > 0" id="pat_task_tod_header" class="task_tod_header">Today</h4>
                                <ul v-if="headerInfo.patientTodayTasks.length > 0" id="pat_task_tod_list">
                                    <li v-for="task in headerInfo.patientTodayTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                        <div class="task_extra" id="task_extra_{{ task.id }}" >
                                            <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                            <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                        </div>
                                        <input type="checkbox" class="task_status" value="{{ task.id }}" />
                                        {{ task.task }}

                                        <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>
                                    </li>
                                </ul>

                                <h4 v-if="headerInfo.patientTomorrowTasks.length > 0" id="pat_task_tom_header" class="task_tom_header">Tomorrow</h4>
                                <ul v-if="headerInfo.patientTomorrowTasks.length > 0" id="pat_task_tom_list">
                                    <li v-for="task in headerInfo.patientTomorrowTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                        <div class="task_extra" id="task_extra_{{ task.id }}" >
                                            <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                            <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                        </div>
                                        <input type="checkbox" class="task_status" value="{{ task.id }}" />
                                        {{ task.task }}

                                        <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>
                                    </li>
                                </ul>

                                <h4 v-if="headerInfo.patientFutureTasks.length > 0" id="pat_task_fut_header" class="task_fut_header">Future</h4>
                                <ul v-if="headerInfo.patientFutureTasks.length > 0" id="pat_task_fut_list">
                                    <li v-for="task in headerInfo.patientFutureTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                        <div class="task_extra" id="task_extra_{{ task.id }}" >
                                            <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                            <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                        </div>
                                        <input type="checkbox" class="task_status" value="{{ task.id }}" />
                                        {{ task.task }}

                                        <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <a v-if="$route.query.pid" href="#" style="float:left; margin-left:10px;margin-top:8px;" class="button" id="show_patient_warnings" onclick="showWarnings();$('#patient_warnings').show();$('#show_patient_warnings').hide();$('#hide_patient_warnings').show();return false;">Show Warnings</a>
                        <a v-if="$route.query.pid" href="#" style="float:left; margin-left:10px;margin-top:8px;" class="button" id="hide_patient_warnings" onclick="hideWarnings();$('#patient_warnings').hide();$('#show_patient_warnings').show();$('#hide_patient_warnings').hide();return false;">Hide Warnings</a>

                        <div class="suckertreemenu">
                            <span style="line-height:38px; margin-right:10px;font-size:20px; color:#fff; float:right;">
                                Welcome {{ headerInfo.user.username }}
                            </span>
                        </div>

                        <div v-if="$route.query.pid" id="patient_nav">
                            <ul>
                                <li>
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_flowsheet3.php')?'nav_active':'';?>" href='manage_flowsheet3.php?pid={{ $route.query.pid }}&addtopat=1'>Tracker</a>
                                </li>
                                <li>
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/dss_summ.php')?'nav_active':'';?>" href='dss_summ.php?pid={{ $route.query.pid }}&addtopat=1'>Summary Sheet</a>
                                </li>
                                <li>
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_ledger.php')?'nav_active':'';?>" href='manage_ledger.php?pid={{ $route.query.pid }}&addtopat=1'>Ledger</a>
                                </li>
                                <li>
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_insurance.php')?'nav_active':'';?>" href='manage_insurance.php?pid={{ $route.query.pid }}&addtopat=1'>Insurance</a>
                                </li>
                                <li>
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_progress_notes.php')?'nav_active':'';?>" href='dss_summ.php?sect=notes&pid={{ $route.query.pid }}&addtopat=1'>Progress Notes</a>
                                </li>
                                <li>
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/patient_letters.php')?'nav_active':'';?>" href='dss_summ.php?sect=letters&pid={{ $route.query.pid }}&addtopat=1'>Letters</a>
                                </li>
                                <li>
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/q_image.php')?'nav_active':'';?>" href="q_image.php?pid={{ $route.query.pid }}">Images</a>
                                </li>
                                <li>
                                    <a class="<?php echo  (strpos($_SERVER['PHP_SELF'],'q_page') || strpos($_SERVER['PHP_SELF'],'q_sleep'))?'nav_active':'';?>" href="q_page1.php?pid={{ $route.query.pid }}&addtopat=1">Questionnaire</a>
                                </li>
                                <li>
                                    <a class="<?php echo  (strpos($_SERVER['PHP_SELF'],'ex_page'))?'nav_active':'';?>" href="ex_page4.php?pid={{ $route.query.pid }}&addtopat=1">Clinical Exam</a>
                                </li>
                                <li class="last">
                                    <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/add_patient.php')?'nav_active':'';?>" href="add_patient.php?ed={{ $route.query.pid }}&addtopat=1&pid={{ $route.query.pid }}">Patient Info</a>
                                </li>
                            </ul>
                        </div>
                        <div v-else style="clear:both;"></div>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <div style="background:url(assets/images/dss_03.jpg) repeat-y top left #FFFFFF;" id="contentMain">
                    <div style="clear:both;"></div>

                    <div v-if="$route.query.pid" style="margin-left:20px;float:left;width:400px;display:none;">
                        You are currently in a patient chart - 
                        <a href="manage_patient.php" target="_self" style="font-weight:bold;">BACK TO PATIENT LIST</a>
                    </div>
                    <div v-if="$route.query.pid" style="float:right;width:300px;"></div>
                    <br />

                    <div v-if="$route.query.pid" id="patient_warnings" {{ showAllWarnings ? 'style="display:none;"' :'' }}>
                        <a v-if="showWarningAboutPatientChanges" class="warning" href="patient_changes.php?pid={{ $route.query.pid }}">
                            <span>Warning! Patient has updated their PROFILE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
                        </a>
                        <a v-if="showWarningAboutQuestionnaireChanges" class="warning" href="q_page1.php?pid={{ $route.query.pid }}&addtopat=1" >
                            <span>Warning! Patient has updated their QUESTIONNAIRE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
                        </a>
                        <a v-if="showWarningAboutBouncedEmails" class="warning" href="add_patient.php?ed={{ $route.query.pid }}&pid={{ $route.query.pid }}&addtopat=1" >
                            <span>Warning! Email sent to this patient has bounced. Please click to check patients email.</span>
                        </a>
                        <span v-if="rejectedClaimsForCurrentPatient.length > 0" class="warning">Warning! Patient has the following rejected claims: <br />
                            <a v-for="claim in rejectedClaimsForCurrentPatient" href="view_claim.php?claimid={{ claim.insuranceid }}&pid={{ $route.query.pid }}">
                                {{ claim.insuranceid }} - {{ claim.adddate | moment "MM/DD/YYYY" }}
                            </a><br />
                        </span>
                        <span v-if="uncompletedHomeSleepTests.length > 0" class="warning">Patient has the following Home Sleep Tests: <br />
                            <span v-for="test in uncompletedHomeSleepTests">
                                <a href="/manage/hst_request.php?pid={{ test.patient_id }}&amp;hst_id={{ test.id }}">HST was requested {{ test.adddate | moment "MM/DD/YYYY" }}</a>
                                    and is currently 
                                <a v-if="test.status == window.constants.DSS_HST_REJECTED" href="manage_hst.php?status=4&viewed=0">{{ window.constants.preAuthLabels[test.status] }}</a>
                                <span v-else>{{ window.constants.preAuthLabels[test.status] }}</span>
                                <span v-if="test.status == window.constants.DSS_HST_SCHEDULED"> - {{ test.office_notes }}</span>
                                <span v-if="test.status == window.constants.DSS_HST_REJECTED"> - {{ test.rejected_reason }}</span>
                                <span v-if="test.status == window.constants.DSS_HST_REJECTED && test.rejecteddate"> - {{ test.rejecteddate | moment "MM/DD/YYYY hh:mm a" }}</span>
                                <br />
                                <a v-if="test.status == window.constants.DSS_HST_REJECTED" href="manage_hst.php?status=4&viewed=0">Click here</a> to remove this error
                            </span>
                        </span>
                    </div>

                    <!-- Router content -->
                    <router-view></router-view>
                </div>
                <div style="margin:0 auto;background:url(assets/images/dss_05.png) no-repeat top left;width:980px; height:28px;">
                </div>
            </td>
        </tr>
        <!-- Stick Footer Section Here -->
    </table>

    <div id="popupContact" style="width:750px;">
        <a id="popupContactClose"><button>X</button></a>
        <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>

    <div id="backgroundPopup"></div>

    <!--  <script type="text/javascript" src="js/task.js"></script>-->
    <div id="warn_logout">
        <br /><br />

        <img src="images/logo.gif" /><br />
        <h1>Your screen has been locked for privacy due to inactivity.<br />Click to reopen your Dental Sleep Solutions software.</h1>
        <p style="color:#fff;font-size:20px;">Log out in <span id="logout_time_remaining"></span>!</p>

        <br /><br />

        <a href="logout.php">Logout</a>
        <a href="#" onclick="reset_interval(0)">Stay logged in</a>
    </div>
</template>

<!-- these modules must be rewritten/included to vue structure in the future -->
<script src="../../../assets/js/tracekit/tracekit.js"></script>
<script src="../../../assets/js/tracekit/tracekit.handler.js"></script>
<script src="../../../assets/js/jquery-1.6.2.min.js"></script>
<script src="../../../assets/js/jquery-ui-1.8.22.custom.min.js"></script>
<script src="../../../assets/js/input-mask/jquery.maskedinput-1.3.min.js"></script>
<script src="../../../assets/js/table-sorter/jquery.tablesorter.min.js"></script>
<script src="../../../assets/js/table-sorter/jquery.tablesorter.pager.js"></script>
<script src="../../../assets/js/table-sorter/jquery.tablesorter.widgets.js"></script>
<script src="../../../assets/js/manage/masks.js"></script>
<script src="../../../assets/js/calendar/calendar2.js"></script>
<script src="../../../assets/js/manage/logout_timer.js"></script>
<script src="../../../assets/js/manage/ddlevelsmenu.js"></script>
<script src="../../../assets/js/manage/validation.js"></script>
<script src="../../../assets/js/manage/top.js"></script>
<script src="../../../assets/js/manage/hideshow.js"></script>
<script src="../../../assets/js/manage/file-upload-check.js"></script>
<script src="../../../assets/js/jscal/jscal2.js"></script>
<script src="../../../assets/js/jscal/lang/en.js"></script>
<script src="../../../assets/js/jquery.colorbox-min.js"></script>
<script src="../../../assets/js/jquery.blockUI.js"></script>
<script src="../../../assets/js/popup/popup.js"></script>
<script src="../../../assets/js/manage/task.js"></script>
<script src="../../../assets/js/manage/autocomplete.js"></script>
<script src="../../../assets/js/manage/autocomplete_local.js"></script>

<script>
    task_function();

    module.exports = require('./header.js');
</script>

<!-- <script type="text/javascript" src="js/bottom.js"></script> -->