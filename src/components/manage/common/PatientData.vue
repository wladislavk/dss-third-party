<template>
    <div>
        <div v-if="patientId" class="patient-chart">
            You are currently in a patient chart -
            <a v-bind:href="legacyUrl + 'manage_patient.php'" target="_self" class="back-to-list">Back to patient list</a>
        </div>
        <!-- @todo: why need this div? -->
        <div v-if="patientId" style="float:right;width:300px;"></div>
        <br />

        <div v-if="patientId" v-show="showAllWarnings" class="warning-div">
            <a v-if="showWarningAboutPatientChanges" v-bind:href="legacyUrl + 'patient_changes.php?pid=' + patientId">
                <span>Warning! Patient has updated their PROFILE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
            </a>
            <a v-if="showWarningAboutQuestionnaireChanges" v-bind:href="legacyUrl + 'q_page1.php?pid=' + patientId + '&addtopat=1'" >
                <span>Warning! Patient has updated their QUESTIONNAIRE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
            </a>
            <a v-if="showWarningAboutBouncedEmails" v-bind:href="legacyUrl + 'add_patient.php?ed=' + patientId + '&pid=' + patientId + '&addtopat=1'" >
                <span>Warning! Email sent to this patient has bounced. Please click to check patients email.</span>
            </a>
            <span v-if="rejectedClaimsForCurrentPatient.length > 0">
                Warning! Patient has the following rejected claims: <br />
                <span v-for="claim in rejectedClaimsForCurrentPatient">
                    <a v-bind:href="legacyUrl + 'view_claim.php?claimid=' + claim.insuranceid + '&pid=' + patientId">
                        {{ claim.insuranceid }} - {{ claim.adddate | moment("MM/DD/YYYY") }}
                    </a>
                    <br />
                </span>
            </span>
            <span v-if="incompleteHomeSleepTests.length">Patient has the following Home Sleep Tests: <br />
                <span v-for="incompleteTest in incompleteHomeSleepTests">
                    <a v-bind:href="legacyUrl + '/manage/hst_request.php?pid=' + incompleteTest.patient_id + '&amp;hst_id=' + incompleteTest.id">HST was requested {{ incompleteTest.adddate | moment("MM/DD/YYYY") }}</a>
                    and is currently
                    <a v-if="incompleteTest.status === constants.DSS_HST_REJECTED" v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">{{ constants.preAuthLabels[incompleteTest.status] }}</a>
                    <span v-else>{{ constants.preAuthLabels[incompleteTest.status] }}</span>
                    <span v-if="incompleteTest.status === constants.DSS_HST_SCHEDULED"> - {{ incompleteTest.office_notes }}</span>
                    <span v-if="incompleteTest.status === constants.DSS_HST_REJECTED"> - {{ incompleteTest.rejected_reason }}</span>
                    <span v-if="incompleteTest.status === constants.DSS_HST_REJECTED && incompleteTest.rejecteddate"> - {{ incompleteTest.rejecteddate | moment("MM/DD/YYYY hh:mm a") }}</span>
                    <br />
                    <a v-if="incompleteTest.status === constants.DSS_HST_REJECTED" v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">Click here</a> to remove this error
                </span>
            </span>
        </div>
    </div>
</template>

<script src="./PatientData.js"></script>

<style src="../../../assets/css/manage/common/patient-data.css" scoped></style>
