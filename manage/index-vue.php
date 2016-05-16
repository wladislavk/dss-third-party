<?php namespace Ds3\Libraries\Legacy; ?><?php   // include 'includes/top.htm';
?>

<script src="/assets/vendor/vue/vue.min.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue-resource.min.js" type="text/javascript"></script>
<script src="/assets/vendor/sweetalert/sweetalert.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="/assets/vendor/sweetalert/sweetalert.css">

<table id="dashboard">
    <tr>
        <td valign="top" style="border-right:1px solid #00457c;width:980px;">
            <link rel="stylesheet" type="text/css" href="css/index.css">

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
                                <li><a href="manage_claims.php">Claims ({{ pendingClaimsNumber }})</a></li>
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
                                    <a href="manage_enrollment.php">Enrollments</a>\
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
                                    <a href="manage_patient_contacts.php" class=" count_{{ patientContactsNumber }} notification bad_count">
                                        <span class="count">{{ patientContactsNumber }}</span>
                                        <span class="label">Pt Contacts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="manage_patient_insurance.php" class=" count_{{ patientInsurancesNumber }} notification bad_count">
                                        <span class="count">{{ patientInsurancesNumber }}</span>
                                        <span class="label">Pt Insurance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="manage_patient_changes.php" class=" count_{{ patientChangesNumber }} notification bad_count">
                                        <span class="count">{{ patientChangesNumber }}</span>
                                        <span class="label">Pt Changes</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <a v-if="useLetters" href="letters.php?status=pending" class=" count_{{ pendingLetters }} notification {{ pendingLetters == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ pendingLetters }}</span>
                    <span class="label">Letters</span>
                </a>

                <a v-if="showUnmailedLetters" href="letters.php?status=sent&mailed=0" class=" count_{{ unmailedLetters }} notification bad_count">
                    <span class="count">{{ unmailedLetters }}</span>
                    <span class="label">Unmailed Letters</span>
                </a>

                <a href="manage_vobs.php?status={{ constants.DSS_PREAUTH_COMPLETE }}&viewed=0" class=" count_{{ preauthNumber }} notification {{ preauthNumber == 0 ? 'good_count' : 'great_count' }}">
                    <span class="count">{{ preauthNumber }}</span>
                    <span class="label">VOBs</span>
                </a>

                <a v-if="rejectedPreAuthNumber" href="manage_vobs.php?status={{ constants.DSS_PREAUTH_REJECTED }}&viewed=0" class=" count_{{ rejectedPreAuthNumber }} notification bad_count">
                    <span class="count">{{ rejectedPreAuthNumber }}</span>
                    <span class="label">Rejected VOBs</span>
                </a>

                <a href="manage_hst.php?status={{ constants.DSS_HST_COMPLETE }}&viewed=0" class=" count_{{ hstNumber }} notification {{ hstNumber == 0 ? 'good_count' : 'great_count' }}">
                    <span class="count">{{ hstNumber }}</span>
                    <span class="label">HSTs</span>
                </a>
                <a href="manage_hst.php?status={{ constants.DSS_HST_REJECTED }}&viewed=0" class=" count_{{ rejectedHSTNumber }} notification {{ rejectedHSTNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ rejectedHSTNumber }}</span>
                    <span class="label">Rejected HSTs</span>
                </a>
                <a href="manage_hst.php?status={{ constants.DSS_HST_REQUESTED }}&viewed=0" class=" count_{{ requestedHSTNumber }} notification {{ requestedHSTNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ requestedHSTNumber }}</span>
                    <span class="label">Unsent HSTs</span>
                </a>
                <a href="manage_claims.php" class="notification  count_{{ pendingNodssClaimsNumber }} {{ pendingNodssClaimsNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ pendingNodssClaimsNumber }}</span>
                    <span class="label">Pending Claims</span>
                </a>

                <a v-if="showUnmailedClaims" href="manage_claims.php?unmailed=1" class=" count_{{ unmailedClaimsNumber }} notification {{ unmailedClaimsNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ unmailedClaimsNumber }}</span>
                    <span class="label">Unmailed Claims</span>
                </a>

                <a href="manage_rejected_claims.php" class=" count_{{ rejectedClaimsNumber }} notification {{ rejectedClaimsNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ rejectedClaimsNumber }}</span>
                    <span class="label">Rejected Claims</span>
                </a>
                <a href="manage_unsigned_notes.php" class=" count_{{ unsignedNotesNumber }} notification {{ unsignedNotesNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ unsignedNotesNumber }}</span>
                    <span class="label">Unsigned Notes</span>
                </a>
                <a href="manage_vobs.php?status={{ constants.DSS_PREAUTH_REJECTED }}&viewed=0" class=" count_{{ alertsNumber }} notification bad_count">
                    <span class="count">{{ alertsNumber }}</span>
                    <span class="label">Alerts</span>
                </a>
                <a href="manage_faxes.php" class="notification  count_{{ faxAlertsNumber }} {{ faxAlertsNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ faxAlertsNumber }}</span>
                    <span class="label">Failed Faxes</span>
                </a>
                <a href="pending_patient.php" class="notification  count_{{ pendingDuplicatesNumber }} {{ pendingDuplicatesNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ pendingDuplicatesNumber }}</span>
                    <span class="label">Pending Duplicates</span>
                </a>
                <a href="manage_email_bounces.php" class="notification count_{{ emailBouncesNumber }} {{ emailBouncesNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ emailBouncesNumber }}</span>
                    <span class="label">Email Bounces</span>
                </a>

                <a v-if="usePaymentReports" href="payment_reports_list.php?unviewed=1" class="notification count_{{ paymentReportsNumber }} {{ paymentReportsNumber == 0 ? 'good_count' : 'bad_count' }}">
                    <span class="count">{{ paymentReportsNumber }}</span>
                    <span class="label">Payment Reports</span>
                </a>

                <a href="#" onclick="$('.notification.count_0').css('display', 'block');$(this).hide();$('#not_show_active').show();return false;" id="not_show_all">Show All</a>
                <a href="#" onclick="$('.notification.count_0').hide();$(this).hide();$('#not_show_all').show();return false;" style="display:none;" id="not_show_active">Show Active</a>
            </div>
            <div class="home_third">
                <h3>Tasks</h3>
                <div class="task_menu index_task">
                    <h4>My Tasks</h4>
                    <h4 v-if="overdueTasks.length > 0" style="margin-bottom:0px;color:red;" class="task_od_header">Overdue</h4>
                    <ul v-if="overdueTasks.length > 0" class="task_od_list">
                        <li v-for="task in overdueTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                            <div class="task_extra" id="task_extra_{{ task.id }}" >
                                <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                            </div>
                            <input type="checkbox" style="float:left; " class="task_status" value="{{ task.id }}" />
                            <div style="float:left; width:170px;">{{ task.task }}

                                <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>

                            </div>
                        </li>
                    </ul>

                    <h4 v-if="todayTasks.length > 0" style="margin-bottom:0px;" class="task_tod_header">Today</h4>
                    <ul v-if="todayTasks.length > 0" class="task_tod_list">
                        <li v-for="task in todayTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                            <div class="task_extra" id="task_extra_{{ task.id }}" >
                                <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                            </div>
                            <input type="checkbox" style="float:left;" class="task_status" value="{{ task.id }}" />
                            <div style="float:left; width:170px;">
                                {{ task.task }}

                                <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>

                            </div>
                        </li>
                    </ul>

                    <h4 v-if="tomorrowTasks.length > 0" style="margin-bottom:0px;" class="task_tom_header">Tomorrow</h4>
                    <ul v-if="tomorrowTasks.length > 0" class="task_tom_list">
                        <li v-for="task in tomorrowTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                            <div class="task_extra" id="task_extra_{{ task.id }}" >
                                <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                            </div>
                            <input type="checkbox" style="float:left;" class="task_status" value="{{ task.id }}" />
                            <div style="float:left; width:170px;">{{ task.task }}

                                <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>

                            </div>
                        </li>
                    </ul>

                    <h4 v-if="thisWeekTasks.length > 0" id="task_tw_header" class="task_tw_header">This Week</h4>
                    <ul v-if="thisWeekTasks.length > 0" id="task_tw_list">
                        <li v-for="task in thisWeekTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                            <div class="task_extra" id="task_extra_{{ task.id }}" >
                                <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                            </div>
                            <input type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                            <div style="float:left; width:170px;">{{ task.task }}

                                <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>

                            </div>
                        </li>
                    </ul>

                    <h4 v-if="nextWeekTasks.length > 0" id="task_nw_header" class="task_nw_header">Next Week</h4>
                    <ul v-if="nextWeekTasks.length > 0" id="task_nw_list">
                        <li v-for="task in nextWeekTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                            <div class="task_extra" id="task_extra_{{ task.id }}" >
                                <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                            </div>
                            <input type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                            <div style="float:left; width:170px;">{{ task.task }}

                                <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>

                            </div>
                        </li>
                    </ul>

                    <h4 v-if="laterTasks.length > 0" id="task_lat_header" class="task_lat_header">Later</h4>
                    <ul v-if="laterTasks.length > 0" id="task_lat_list">
                        <li v-for="task in laterTasks" class="task_item task_{{ task.id }}" style="clear:both;">
                            <div class="task_extra" id="task_extra_{{ task.id }}" >
                                <a href="#" onclick="delete_task('{{ task.id }}')" class="task_delete"></a>
                                <a href="#" onclick="loadPopup('add_task.php?id={{ task.id }}')" class="task_edit">Edit</a>
                            </div>
                            <input type="checkbox" class="task_status" style="float:left;" value="{{ task.id }}" />
                            <div style="float:left; width:170px;">

                                <?php date('M d', strtotime($od_r['due_date'])); ?>
                                -
                                {{ task.task }}

                                <a v-if="task.firstname && task.lastname" href="add_patient.php?ed={{ task.patientid }}&addtopat=1&pid={{ task.patientid }}">{{ task.firstname }} {{ task.lastname }}</a>

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
                        <li v-for="memo in memos">{{ memo.memo }}</li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
</table>
<input type="hidden" id="dom-api-token" value="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1XzEiLCJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3QiLCJpYXQiOjE0NjMwNTk4MjcsImV4cCI6MTQ2MzE0NjIyNywibmJmIjoxNDYzMDU5ODI3LCJqdGkiOiI0ZDdmODdiZjhkN2MwY2MxNDhmMjkwM2M2MzAzNjNkMiJ9.aMlkd7llRzgsSO20htyhOcpv6nE6kRod5b1UnlsTXIE" v-model="token">

<br /><br />

<script type="text/javascript" src="../Scripts/sucker_tree_home.js"></script>
<script type="text/javascript" src="/assets/app/manage/dashboard/dashboard.js"></script>

<?php  // include 'includes/bottom.htm';?> 