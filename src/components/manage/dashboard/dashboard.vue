<template>
    <div>
        <table id="dashboard">
            <tr>
                <td valign="top" style="border-right:1px solid #00457c;width:980px;">
                    <div class="home_third first">
                        <h3>Navigation</h3>
                        <div class="homesuckertreemenu">
                            <ul id="homemenu">
                                <li>
                                    <a href="#" v-on:click.prevent="clickDirectory()">Directory</a>
                                    <ul>
                                        <li><router-link to="/manage/contacts">Contacts</router-link></li>
                                        <li><router-link :to="{ name: 'referredby' }">Referral List</router-link></li>
                                        <li><router-link :to="{ name: 'sleeplabs' }">Sleep Labs</router-link></li>
                                        <li><router-link :to="{ name: 'corporate-contacts' }">Corporate Contacts</router-link></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" v-on:click.prevent="clickReports()">Reports</a>
                                    <ul>
                                        <li><router-link :to="{ name: 'ledger-report-full' }">Ledger</router-link></li>
                                        <li><a v-bind:href="legacyUrl + 'manage_claims.php'">Claims ({{ headerInfo.pendingClaimsNumber }})</a></li>
                                        <li><a v-bind:href="legacyUrl + 'performance.php'">Performance</a></li>
                                        <li><a v-bind:href="legacyUrl + 'manage_screeners.php?contacted=0'">Pt. Screener</a></li>
                                        <li><a v-bind:href="legacyUrl + 'manage_vobs.php'">VOB History</a></li>

                                        <li v-if="showInvoices">
                                            <a v-bind:href="legacyUrl + 'invoice_history.php'">Invoices</a>
                                        </li>

                                        <li><a v-bind:href="legacyUrl + 'manage_faxes.php'">Fax History</a></li>
                                        <li><a v-bind:href="legacyUrl + 'manage_hst.php'">Home Sleep Tests</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="menu_item" href="#" v-on:click.prevent="clickAdmin()">Admin</a>
                                    <ul>
                                        <li><a v-bind:href="legacyUrl + 'manage_claim_setup.php'">Claim Setup</a></li>
                                        <li><a v-bind:href="legacyUrl + 'manage_profile.php'">Profile</a></li>
                                        <li>
                                            <a href="#" v-on:click.prevent="clickText()">Text</a>
                                            <ul>
                                                <li><a v-bind:href="legacyUrl + 'manage_custom.php'">Custom Text</a></li>
                                                <li><a v-bind:href="legacyUrl + 'manage_custom_letters.php'">Custom Letters</a></li>
                                            </ul>
                                        </li>
                                        <li><a v-bind:href="legacyUrl + 'change_list.php'">Change List</a></li>

                                        <li v-if="showTransactionCode">
                                            <a class="submenu_item" v-bind:href="legacyUrl + 'manage_transaction_code.php'">Transaction Code</a>
                                        </li>

                                        <li><a v-bind:href="legacyUrl + 'manage_staff.php'">Staff</a></li>
                                        <li>
                                            <a href="#" v-on:click.prevent="clickScheduler()">Scheduler</a>
                                            <ul>
                                                <li><a v-bind:href="legacyUrl + 'manage_chairs.php'">Resources</a></li>
                                                <li><a v-bind:href="legacyUrl + 'manage_appts.php'">Appointment Types</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#" v-on:click.prevent="onClickExportMD()">Export MD</a></li>
                                        <li>
                                            <a href="#" v-on:click.prevent="clickDssFiles()">DSS Files</a>
                                            <ul>
                                                <li v-for="documentCategory in documentCategories">
                                                    <a class="submenu_item" v-bind:href="legacyUrl + 'view_documents.php?cat=' + documentCategory.categoryid">{{ documentCategory.name }}</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a v-bind:href="legacyUrl + 'manage_locations.php'">Manage Locations</a></li>
                                        <li><a v-on:click.prevent="onClickDataImport()">Data Import</a></li>

                                        <li v-if="showEnrollments">
                                            <a v-bind:href="legacyUrl + 'manage_enrollment.php'">Enrollments</a>
                                        </li>

                                    </ul>
                                </li>
                                <li><a v-bind:href="screenerUrl" target="_blank">Pt. Screener App</a></li>
                                <li><a v-bind:href="legacyUrl + 'manage_user_forms.php'">Forms</a></li>
                                <li>
                                    <a href="#" v-on:click.prevent="clickEducation()">Education</a>
                                    <ul>
                                        <li><a v-bind:href="legacyUrl + 'manual.php'">Dental Sleep Solutions Procedures Manual</a></li>
                                        <li><a v-bind:href="legacyUrl + 'medicine_manual.php'">Dental Sleep Medicine Manual</a></li>

                                        <li v-if="showDSSFranchiseOperationsManual">
                                            <a v-bind:href="legacyUrl + 'operations_manual.php'">DSS Franchise Operations Manual</a>
                                        </li>

                                        <li><a v-bind:href="legacyUrl + 'quick_facts.php'">Quick Facts Reference</a></li>
                                        <li><a v-bind:href="legacyUrl + 'videos.php'">Watch Videos</a></li>

                                        <li v-if="showGetCE">
                                            <a v-bind:href="legacyUrl + 'edx_login.php'" target="_blank">Get C.E.</a>
                                        </li>

                                        <li><a v-bind:href="legacyUrl + 'edx_certificate.php'">Certificates</a></li>
                                    </ul>
                                </li>
                                <li><a v-bind:href="legacyUrl + 'sw_tutorials.php'">SW Tutorials</a></li>
                                <li><a v-bind:href="legacyUrl + 'calendar.php'">Scheduler</a></li>
                                <li><router-link to="/manage/patients">Manage Pts</router-link></li>
                                <li><a href="#" v-on:click.prevent="$parent.$refs.modal.display('device-selector')">Device Selector</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="home_third">
                        <h3>Notifications</h3>
                        <div class="notsuckertreemenu">
                            <ul id="notmenu">
                                <li>
                                    <a href="#" v-on:click.prevent="clickWebPortal()" :class="'count_' + notificationsNumber + ' notification bad_count'">{{ notificationsNumber }} Web Portal <div class="arrow_right"></div></a>
                                    <ul>
                                        <li>
                                            <a v-bind:href="legacyUrl + 'manage_patient_contacts.php'" :class="'count_' + headerInfo.patientContactsNumber + ' notification bad_count'">
                                                <span class="count">{{ headerInfo.patientContactsNumber }}</span><span class="label">Pt Contacts</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a v-bind:href="legacyUrl + 'manage_patient_insurance.php'" :class="'count_' + headerInfo.patientInsurancesNumber + ' notification bad_count'">
                                                <span class="count">{{ headerInfo.patientInsurancesNumber }}</span><span class="label">Pt Insurance</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a v-bind:href="legacyUrl + 'manage_patient_changes.php'" :class="'count_' + headerInfo.patientChangesNumber + ' notification bad_count'">
                                                <span class="count">{{ headerInfo.patientChangesNumber }}</span><span class="label">Pt Changes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <a v-if="headerInfo.useLetters" v-bind:href="legacyUrl + 'letters.php?status=pending'" :class="'count_' + headerInfo.pendingLetters.length + ' notification ' + (headerInfo.pendingLetters.length == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.pendingLetters.length }}</span><span class="label">Letters</span>
                        </a>

                        <a v-if="showUnmailedLettersNumber" v-bind:href="legacyUrl + 'letters.php?status=sent&mailed=0'" :class="'count_' + headerInfo.unmailedLettersNumber + ' notification bad_count'">
                            <span class="count">{{ headerInfo.unmailedLettersNumber }}</span>
                            <span class="label">Unmailed Letters</span>
                        </a>

                        <a v-bind:href="legacyUrl + 'manage_vobs.php?status=' + constants.DSS_PREAUTH_COMPLETE + '&viewed=0'" :class="'count_' + headerInfo.preauthNumber + ' notification ' + (headerInfo.preauthNumber == 0 ? 'good_count' : 'great_count')">
                            <span class="count">{{ headerInfo.preauthNumber }}</span>
                            <span class="label">VOBs</span>
                        </a>

                        <a v-if="headerInfo.rejectedPreAuthNumber" v-bind:href="legacyUrl + 'manage_vobs.php?status=' + constants.DSS_PREAUTH_REJECTED + '&viewed=0'" :class="'count_' + headerInfo.rejectedPreAuthNumber + ' notification bad_count'">
                            <span class="count">{{ headerInfo.rejectedPreAuthNumber }}</span>
                            <span class="label">Rejected VOBs</span>
                        </a>

                        <a v-bind:href="legacyUrl + 'manage_hst.php?status=' + constants.DSS_HST_COMPLETE + '&viewed=0'" :class="'count_' + headerInfo.hstNumber + ' notification ' + (headerInfo.hstNumber == 0 ? 'good_count' : 'great_count')">
                            <span class="count">{{ headerInfo.hstNumber }}</span>
                            <span class="label">HSTs</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'manage_hst.php?status=' + constants.DSS_HST_REJECTED + '&viewed=0'" :class="'count_' + headerInfo.rejectedHSTNumber + ' notification ' + (headerInfo.rejectedHSTNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.rejectedHSTNumber }}</span>
                            <span class="label">Rejected HSTs</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'manage_hst.php?status=' + constants.DSS_HST_REQUESTED + '&viewed=0'" :class="'count_' + headerInfo.requestedHSTNumber + ' notification ' + (headerInfo.requestedHSTNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.requestedHSTNumber }}</span>
                            <span class="label">Unsent HSTs</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'manage_claims.php'" :class="'notification  count_' + headerInfo.pendingNodssClaimsNumber + ' ' + (headerInfo.pendingNodssClaimsNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.pendingNodssClaimsNumber }}</span><span class="label">Pending Claims</span>
                        </a>

                        <a v-if="showUnmailedClaims" v-bind:href="legacyUrl + 'manage_claims.php?unmailed=1'" :class="'count_' + headerInfo.unmailedClaimsNumber + ' notification ' + (headerInfo.unmailedClaimsNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.unmailedClaimsNumber }}</span><span class="label">Unmailed Claims</span>
                        </a>

                        <a v-bind:href="legacyUrl + 'manage_rejected_claims.php'" :class="'count_' + headerInfo.rejectedClaimsNumber + ' notification ' + (headerInfo.rejectedClaimsNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.rejectedClaimsNumber }}</span>
                            <span class="label">Rejected Claims</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'manage_unsigned_notes.php'" :class="'count_' + headerInfo.unsignedNotesNumber + ' notification ' + (headerInfo.unsignedNotesNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.unsignedNotesNumber }}</span>
                            <span class="label">Unsigned Notes</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'manage_vobs.php?status=' + constants.DSS_PREAUTH_REJECTED + '&viewed=0'" :class="'count_' + headerInfo.alertsNumber + ' notification bad_count'">
                            <span class="count">{{ headerInfo.alertsNumber }}</span>
                            <span class="label">Alerts</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'manage_faxes.php'" :class="'notification  count_' + headerInfo.faxAlertsNumber + ' ' + (headerInfo.faxAlertsNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.faxAlertsNumber }}</span>
                            <span class="label">Failed Faxes</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'pending_patient.php'" :class="'notification  count_' + headerInfo.pendingDuplicatesNumber + ' ' + (headerInfo.pendingDuplicatesNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.pendingDuplicatesNumber }}</span>
                            <span class="label">Pending Duplicates</span>
                        </a>
                        <a v-bind:href="legacyUrl + 'manage_email_bounces.php'" :class="'notification count_' + headerInfo.emailBouncesNumber + ' ' + (headerInfo.emailBouncesNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.emailBouncesNumber }}</span>
                            <span class="label">Email Bounces</span>
                        </a>

                        <a v-if="headerInfo.usePaymentReports" v-bind:href="legacyUrl + 'payment_reports_list.php?unviewed=1'" :class="'notification count_' + headerInfo.paymentReportsNumber + ' ' + (headerInfo.paymentReportsNumber == 0 ? 'good_count' : 'bad_count')">
                            <span class="count">{{ headerInfo.paymentReportsNumber }}</span>
                            <span class="label">Payment Reports</span>
                        </a>

                        <a href="#" onclick="$('.notification.count_0').css('display', 'block');$(this).hide();$('#not_show_active').show();return false;" id="not_show_all">Show All</a>
                        <a href="#" onclick="$('.notification.count_0').hide();$(this).hide();$('#not_show_all').show();return false;" style="display:none;" id="not_show_active">Show Active</a>
                    </div>
                    <div class="home_third">
                        <h3>Tasks</h3>
                        <dashboard-task-menu></dashboard-task-menu>
                        <br /><br />
                        <h3>Messages</h3>
                        <div class="task_menu index_task">
                            <ul>
                                <li v-for="memo in memos" v-html="memo.memo"></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <br /><br />
    </div>
</template>

<script src="./dashboard.js"></script>

<style src="../../../assets/css/manage/index.css" scoped></style>
<style src="../../../assets/css/manage/homesuckertreemenu.css" scoped></style>
<style src="../../../assets/css/manage/dashboard-notifications.css" scoped></style>
<style src="../../../assets/css/manage/admin.css" scoped></style>
