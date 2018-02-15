<template>
    <form action="#">
        <h2>What is the reason {{ patientName }} is non-compliant?</h2>
        Reason
        <select name="noncomp_reason" v-model="selectedReason">
            <option value="pain/discomfort">Pain/Discomfort</option>
            <option value="lost device">Lost Device</option>
            <option value="device not working">Device Not Working</option>
            <option value="other">Other</option>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="submitReason()" />
    </form>
</template>

<script src="./FlowsheetNonCompliance.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/modal/patient-tracker/non-compliance.scss";
</style>
