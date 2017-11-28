<template>
    <span>
        <a v-bind:href="legacyUrl + '/manage/hst_request.php?pid=' + patientId + '&amp;hst_id=' + hstId">HST was requested {{ dateAdded | moment("MM/DD/YYYY") }}</a>
        <span>and is currently</span>
        <span>
            <a v-if="status === rejectedHst" v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">{{ preAuthStatusLabel }}</a>
            <span v-else>{{ preAuthStatusLabel }}</span>
        </span>
        <span v-if="status === scheduledHst"> - {{ officeNotes }}</span>
        <span v-if="status === rejectedHst"> - {{ rejectedReason }}</span>
        <span v-if="rejectedWithDate"> - {{ dateRejected | moment("MM/DD/YYYY hh:mm a") }}</span>
        <br />
        <span v-if="status === rejectedHst">
            <a v-bind:href="legacyUrl + 'manage_hst.php?status=4&viewed=0'">Click here</a>
            to remove this error
        </span>
    </span>
</template>

<script src="./PatientIncompleteHst.js"></script>
