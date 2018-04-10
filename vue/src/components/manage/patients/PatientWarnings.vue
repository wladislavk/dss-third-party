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
            <patient-incomplete-hst
                v-for="incompleteTest in incompleteHomeSleepTests"
                v-bind:status="parseInt(incompleteTest.status)"
                v-bind:hst-id="parseInt(incompleteTest.id)"
                v-bind:patient-id="parseInt(incompleteTest.patient_id)"
                v-bind:date-added="incompleteTest.adddate"
                v-bind:date-rejected="incompleteTest.rejecteddate"
                v-bind:office-notes="incompleteTest.office_notes"
                v-bind:rejected-reason="incompleteTest.rejected_reason"
                v-bind:key="incompleteTest.id"
            ></patient-incomplete-hst>
        </span>
    </div>
</template>

<script src="./PatientWarnings.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/patients/patient-warnings.scss";
</style>
