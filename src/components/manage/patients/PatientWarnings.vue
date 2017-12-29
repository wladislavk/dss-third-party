<template>
    <div class="warning-div" id="patient_warnings">
        <a v-if="showWarningAboutPatientChanges" v-legacy-href="'patient_changes.php?pid=' + patientId">
            <span>{{ profileUpdateText }}</span>
        </a>
        <a v-if="showWarningAboutQuestionnaireChanges" v-legacy-href="'q_page1.php?pid=' + patientId + '&addtopat=1'">
            <span>{{ questionnaireUpdateText }}</span>
        </a>
        <a v-if="showWarningAboutBouncedEmails" v-legacy-href="'add_patient.php?ed=' + patientId + '&pid=' + patientId + '&addtopat=1'">
            <span>Warning! Email sent to this patient has bounced. Please click to check patients email.</span>
        </a>
        <span class="warning" v-if="rejectedClaimsForCurrentPatient.length">
            Warning! Patient has the following rejected claims:
            <br />
            <span v-for="claim in rejectedClaimsForCurrentPatient">
                <a v-legacy-href="'view_claim.php?claimid=' + claim.insuranceId + '&pid=' + patientId">{{ claim.insuranceId }} - {{ claim.addDate | moment("MM/DD/YYYY") }}</a>
                <br />
            </span>
        </span>
        <span class="warning" v-if="incompleteHomeSleepTests.length">
            Patient has the following Home Sleep Tests:
            <br />
            <patient-incomplete-hst
                v-for="incompleteTest in incompleteHomeSleepTests"
                v-bind:status="incompleteTest.status"
                v-bind:hst-id="incompleteTest.id"
                v-bind:patient-id="incompleteTest.patientId"
                v-bind:date-added="incompleteTest.addDate"
                v-bind:date-rejected="incompleteTest.rejectedDate"
                v-bind:office-notes="incompleteTest.officeNotes"
                v-bind:rejected-reason="incompleteTest.rejectedReason"
                v-bind:key="incompleteTest.id"
            ></patient-incomplete-hst>
        </span>
    </div>
</template>

<script src="./PatientWarnings.js"></script>

<style src="../../../assets/css/manage/common/patient-warnings.css" scoped></style>
