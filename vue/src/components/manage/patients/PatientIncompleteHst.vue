<template>
    <span>
        <a v-legacy-href="'manage/hst_request.php?pid=' + patientId + '&hst_id=' + hstId">HST was requested {{ dateAdded | moment("MM/DD/YYYY") }}</a>
        <span>and is currently</span>
        <span>
            <a v-if="status === rejectedHst" v-legacy-href="'manage_hst.php?status=4&viewed=0'">{{ hstStatusLabel }}</a>
            <span v-else>{{ hstStatusLabel }}</span>
        </span>
        <span v-if="status === scheduledHst"> - {{ officeNotes }}</span>
        <span v-if="status === rejectedHst"> - {{ rejectedReason }}</span>
        <span v-if="rejectedWithDate"> - {{ dateRejected | moment("MM/DD/YYYY hh:mm a") }}</span>
        <br />
        <span v-if="status === rejectedHst">
            <a v-legacy-href="'manage_hst.php?status=4&viewed=0'">Click here</a>
            to remove this error
        </span>
    </span>
</template>

<script src="./PatientIncompleteHst.js"></script>
