<template>
    <div>
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
                <li><a href="#" v-on:click.prevent="onClickDeviceSelector()">Device Selector</a></li>
            </ul>
        </div>
    </div>
</template>

<script src="./DashboardNavigation.js"></script>

<style src="../../../assets/css/manage/homesuckertreemenu.css" scoped></style>
