<template>
    <div>
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

        <a href="#" v-show="showAllLink" v-on:click.prevent="showAllNotifications()" id="not_show_all">Show All</a>
        <a href="#" v-show="showActiveLink" v-on:click.prevent="showActiveNotifications()" id="not_show_active">Show Active</a>
    </div>
</template>

<script src="./DashboardNotifications.js"></script>

<style src="../../../assets/css/manage/dashboard-notifications.css" scoped></style>
