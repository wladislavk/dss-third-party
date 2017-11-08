<template>
    <div class="warning-div">
        <a v-if="showWarningAboutPatientChanges" v-bind:href="legacyUrl + 'patient_changes.php?pid=' + patientId">
            <span>{{ profileUpdateText }}</span>
        </a>
        <a v-if="showWarningAboutQuestionnaireChanges" v-bind:href="legacyUrl + 'q_page1.php?pid=' + patientId + '&addtopat=1'" >
            <span>{{ questionnaireUpdateText }}</span>
        </a>
        <a v-if="showWarningAboutBouncedEmails" v-bind:href="legacyUrl + 'add_patient.php?ed=' + patientId + '&pid=' + patientId + '&addtopat=1'" >
            <span>Warning! Email sent to this patient has bounced. Please click to check patients email.</span>
        </a>
        <span v-if="rejectedClaimsForCurrentPatient.length">
            Warning! Patient has the following rejected claims:
            <br />
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
                <a v-if="incompleteTest.status === rejectedHst" v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">{{ preauthLabels[incompleteTest.status] }}</a>
                <span v-if="incompleteTest.status !== rejectedHst">{{ preAuthLabels[incompleteTest.status] }}</span>
                <span v-if="incompleteTest.status === scheduledHst"> - {{ incompleteTest.office_notes }}</span>
                <span v-if="incompleteTest.status === rejectedHst"> - {{ incompleteTest.rejected_reason }}</span>
                <span v-if="incompleteTest.status === rejectedHst && incompleteTest.rejecteddate"> - {{ incompleteTest.rejecteddate | moment("MM/DD/YYYY hh:mm a") }}</span>
                <br />
                <a v-if="incompleteTest.status === rejectedHst" v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">Click here</a> to remove this error
            </span>
        </span>
    </div>
</template>

<script src="./PatientWarnings.js"></script>

<style src="../../../assets/css/manage/common/patient-warnings.css" scoped></style>
