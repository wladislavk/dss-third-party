<script>
    import swal from 'sweetalert';
</script>

<template>
    <table id="dashboard">
        <tr>
            <td valign="top" style="border-right:1px solid #00457c;width:980px;">
                <div class="home_third first">
                    <h3>Navigation</h3>
                    <div class="homesuckertreemenu">
                        <ul id="homemenu">
                            <li>
                                <a href="#">Directory</a>
                                <ul>
                                    <li><a href="manage_contact.php">Contacts</a></li>
                                    <li><a href="manage_referredby.php">Referral List</a></li>
                                    <li><a href="manage_sleeplab.php">Sleep Labs</a></li>
                                    <li><a href="manage_fcontact.php">Corporate Contacts</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Reports</a>
                                <ul>
                                    <li><a href="ledger_reportfull.php">Ledger</a></li>
                                    <li><a href="manage_claims.php">Claims ({{ headerInfo.pendingClaimsNumber }})</a></li>
                                    <li><a href="performance.php">Performance</a></li>
                                    <li><a href="manage_screeners.php?contacted=0">Pt. Screener</a></li>
                                    <li><a href='manage_vobs.php'>VOB History</a></li>

                                    <li v-if="showInvoices">
                                        <a href="invoice_history.php">Invoices</a>
                                    </li>

                                    <li><a href="manage_faxes.php">Fax History</a></li>
                                    <li><a href="manage_hst.php">Home Sleep Tests</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="menu_item" href="#">Admin</a>
                                <ul>
                                    <li><a href="manage_claim_setup.php">Claim Setup</a></li>
                                    <li><a href="manage_profile.php">Profile</a></li>
                                    <li>
                                        <a href="#">Text</a>
                                        <ul>
                                            <li><a href="manage_custom.php">Custom Text</a></li>
                                            <li><a href="manage_custom_letters.php">Custom Letters</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="change_list.php">Change List</a></li>

                                    <li v-if="showTransactionCode">
                                        <a class="submenu_item" href="manage_transaction_code.php">Transaction Code</a>
                                    </li>

                                    <li><a href="manage_staff.php">Staff</a></li>
                                    <li>
                                        <a href="#">Scheduler</a>
                                        <ul>
                                            <li><a href="manage_chairs.php">Resources</a></li>
                                            <li><a href="manage_appts.php">Appointment Types</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#" v-on:click="onClickExportMD">Export MD</a></li>
                                    <li>
                                        <a href="#">DSS Files</a>
                                        <ul>
                                            <li v-for="documentCategory in documentCategories">
                                                <a class="submenu_item" href="view_documents.php?cat={{ documentCategory.categoryid }}">{{ documentCategory.name }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="manage_locations.php">Manage Locations</a></li>
                                    <li><a href="#" v-on:click="onClickDataImport">Data Import</a></li>

                                    <li v-if="showEnrollments">
                                        <a href="manage_enrollment.php">Enrollments</a>
                                    </li>

                                </ul>
                            </li>
                            <li><a href="/screener/auto_login.php">Pt. Screener App</a></li>
                            <li><a href="manage_user_forms.php">Forms</a></li>
                            <li>
                                <a href="#">Education</a>
                                <ul>
                                    <li><a href="manual.php">Dental Sleep Solutions Procedures Manual</a></li>
                                    <li><a href="medicine_manual.php">Dental Sleep Medicine Manual</a></li>

                                    <li v-if="showDSSFranchiseOperationsManual">
                                        <a href="operations_manual.php">DSS Franchise Operations Manual</a>
                                    </li>

                                    <li><a href="quick_facts.php">Quick Facts Reference</a></li>
                                    <li><a href="videos.php">Watch Videos</a></li> 

                                    <li v-if="showGetCE">
                                        <a href="edx_login.php" target="_blank">Get C.E.</a>
                                    </li>

                                    <li><a href="edx_certificate.php">Certificates</a></li>
                                </ul>
                            </li>
                            <li><a href="sw_tutorials.php">SW Tutorials</a></li>
                            <li><a href="calendar.php">Scheduler</a></li>
                            <li><a href="manage_patient.php">Manage Pts</a></li>
                            <li><a href="#" onclick="loadPopup('includes/device_guide.php'); return false;">Device Selector</a></li>
                        </ul>
                    </div>
                </div>
                <div class="home_third">
                    <h3>Notifications</h3>
                    <div class="notsuckertreemenu">
                        <ul id="notmenu">
                            <li>
                                <a href="#" class=" count_{{ notificationsNumber }} notification bad_count">{{ notificationsNumber }} Web Portal <div class="arrow_right"></div></a>
                                <ul>
                                    <li>
                                        <a href="manage_patient_contacts.php" class=" count_{{ headerInfo.patientContactsNumber }} notification bad_count">
                                            <span class="count">{{ headerInfo.patientContactsNumber }}</span>
                                            <span class="label">Pt Contacts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="manage_patient_insurance.php" class=" count_{{ headerInfo.patientInsurancesNumber }} notification bad_count">
                                            <span class="count">{{ headerInfo.patientInsurancesNumber }}</span>
                                            <span class="label">Pt Insurance</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="manage_patient_changes.php" class=" count_{{ headerInfo.patientChangesNumber }} notification bad_count">
                                            <span class="count">{{ headerInfo.patientChangesNumber }}</span>
                                            <span class="label">Pt Changes</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <a v-if="headerInfo.useLetters" href="letters.php?status=pending" class=" count_{{ headerInfo.pendingLetters.length }} notification {{ headerInfo.pendingLetters.length == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.pendingLetters.length }}</span>
                        <span class="label">Letters</span>
                    </a>

                    <a v-if="showUnmailedLettersNumber" href="letters.php?status=sent&mailed=0" class=" count_{{ headerInfo.unmailedLettersNumber }} notification bad_count">
                        <span class="count">{{ headerInfo.unmailedLettersNumber }}</span>
                        <span class="label">Unmailed Letters</span>
                    </a>

                    <a href="manage_vobs.php?status={{ constants.DSS_PREAUTH_COMPLETE }}&viewed=0" class=" count_{{ headerInfo.preauthNumber }} notification {{ headerInfo.preauthNumber == 0 ? 'good_count' : 'great_count' }}">
                        <span class="count">{{ headerInfo.preauthNumber }}</span>
                        <span class="label">VOBs</span>
                    </a>

                    <a v-if="headerInfo.rejectedPreAuthNumber" href="manage_vobs.php?status={{ constants.DSS_PREAUTH_REJECTED }}&viewed=0" class=" count_{{ headerInfo.rejectedPreAuthNumber }} notification bad_count">
                        <span class="count">{{ headerInfo.rejectedPreAuthNumber }}</span>
                        <span class="label">Rejected VOBs</span>
                    </a>

                    <a href="manage_hst.php?status={{ constants.DSS_HST_COMPLETE }}&viewed=0" class=" count_{{ headerInfo.hstNumber }} notification {{ headerInfo.hstNumber == 0 ? 'good_count' : 'great_count' }}">
                        <span class="count">{{ headerInfo.hstNumber }}</span>
                        <span class="label">HSTs</span>
                    </a>
                    <a href="manage_hst.php?status={{ constants.DSS_HST_REJECTED }}&viewed=0" class=" count_{{ headerInfo.rejectedHSTNumber }} notification {{ headerInfo.rejectedHSTNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.rejectedHSTNumber }}</span>
                        <span class="label">Rejected HSTs</span>
                    </a>
                    <a href="manage_hst.php?status={{ constants.DSS_HST_REQUESTED }}&viewed=0" class=" count_{{ headerInfo.requestedHSTNumber }} notification {{ headerInfo.requestedHSTNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.requestedHSTNumber }}</span>
                        <span class="label">Unsent HSTs</span>
                    </a>
                    <a href="manage_claims.php" class="notification  count_{{ headerInfo.pendingNodssClaimsNumber }} {{ headerInfo.pendingNodssClaimsNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.pendingNodssClaimsNumber }}</span>
                        <span class="label">Pending Claims</span>
                    </a>

                    <a v-if="showUnmailedClaims" href="manage_claims.php?unmailed=1" class=" count_{{ headerInfo.unmailedClaimsNumber }} notification {{ headerInfo.unmailedClaimsNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.unmailedClaimsNumber }}</span>
                        <span class="label">Unmailed Claims</span>
                    </a>

                    <a href="manage_rejected_claims.php" class=" count_{{ headerInfo.rejectedClaimsNumber }} notification {{ headerInfo.rejectedClaimsNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.rejectedClaimsNumber }}</span>
                        <span class="label">Rejected Claims</span>
                    </a>
                    <a href="manage_unsigned_notes.php" class=" count_{{ headerInfo.unsignedNotesNumber }} notification {{ headerInfo.unsignedNotesNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.unsignedNotesNumber }}</span>
                        <span class="label">Unsigned Notes</span>
                    </a>
                    <a href="manage_vobs.php?status={{ constants.DSS_PREAUTH_REJECTED }}&viewed=0" class=" count_{{ headerInfo.alertsNumber }} notification bad_count">
                        <span class="count">{{ headerInfo.alertsNumber }}</span>
                        <span class="label">Alerts</span>
                    </a>
                    <a href="manage_faxes.php" class="notification  count_{{ headerInfo.faxAlertsNumber }} {{ headerInfo.faxAlertsNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.faxAlertsNumber }}</span>
                        <span class="label">Failed Faxes</span>
                    </a>
                    <a href="pending_patient.php" class="notification  count_{{ headerInfo.pendingDuplicatesNumber }} {{ headerInfo.pendingDuplicatesNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.pendingDuplicatesNumber }}</span>
                        <span class="label">Pending Duplicates</span>
                    </a>
                    <a href="manage_email_bounces.php" class="notification count_{{ headerInfo.emailBouncesNumber }} {{ headerInfo.emailBouncesNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.emailBouncesNumber }}</span>
                        <span class="label">Email Bounces</span>
                    </a>

                    <a v-if="headerInfo.usePaymentReports" href="payment_reports_list.php?unviewed=1" class="notification count_{{ headerInfo.paymentReportsNumber }} {{ headerInfo.paymentReportsNumber == 0 ? 'good_count' : 'bad_count' }}">
                        <span class="count">{{ headerInfo.paymentReportsNumber }}</span>
                        <span class="label">Payment Reports</span>
                    </a>

                    <a href="#" onclick="$('.notification.count_0').css('display', 'block');$(this).hide();$('#not_show_active').show();return false;" id="not_show_all">Show All</a>
                    <a href="#" onclick="$('.notification.count_0').hide();$(this).hide();$('#not_show_all').show();return false;" style="display:none;" id="not_show_active">Show Active</a>
                </div>
                <div class="home_third">
                    <h3>Tasks</h3>
                    <div class="task_menu index_task">
                        <h4>My Tasks</h4>
                        <h4 v-if="headerInfo.overdueTasks.length > 0" style="margin-bottom:0px;color:red;" class="task_od_header">Overdue</h4>
                        <ul v-if="headerInfo.overdueTasks.length > 0" class="task_od_list">
                            <li v-for="task in headerInfo.overdueTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input type="checkbox" style="float:left; " class="task_status" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <h4 v-if="headerInfo.todayTasks.length > 0" style="margin-bottom:0px;" class="task_tod_header">Today</h4>
                        <ul v-if="headerInfo.todayTasks.length > 0" class="task_tod_list">
                            <li v-for="task in headerInfo.todayTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input type="checkbox" style="float:left;" class="task_status" value="{{ task.id }}" />
                                <div style="float:left; width:170px;">
                                    {{ task.task }}
                                    <span v-if="task.firstname && task.lastname">
                                        (<a href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>)
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <h4 v-if="headerInfo.tomorrowTasks.length > 0" style="margin-bottom:0px;" class="task_tom_header">Tomorrow</h4>
                        <ul v-if="headerInfo.tomorrowTasks.length > 0" class="task_tom_list">
                            <li v-for="task in headerInfo.tomorrowTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                                <div class="task_extra" id="task_extra_{{ task.id }}" >
                                    <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                    <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                                </div>
                                <input type="checkbox" style="float:left;" class="task_status" value="{{ task.id }}" />
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
                                <input type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
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
                                <input type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
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
                                <input type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
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
                    <br /><br />
                    <h3>Messages</h3>
                    <div class="task_menu index_task">
                        <ul>
                            <li v-for="memo in memos">{{{ memo.memo }}}</li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <br /><br />
</template>

<script src="../../../../assets/js/manage/sucker_tree_home.js"></script>

<script>
    module.exports = require('./dashboard.js');
</script>

<style src="./dashboard.css"></style>

<link rel="stylesheet" type="text/css" href="node_modules/sweetalert/dist/sweetalert.css">