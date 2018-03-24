<template>
    <div>
        <patient-data v-bind:patient-id="patientId"></patient-data>
        <router-view></router-view>
    </div>
</template>

<script src="./PatientRoot.js"></script>
