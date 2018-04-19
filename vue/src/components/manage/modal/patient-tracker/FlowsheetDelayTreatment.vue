<template>
    <form action="#">
        <h2>What is the reason for delaying treatment for {{ patientName }}?</h2>
        Reason
        <select name="delay_reason" v-model="selectedReason">
            <option v-for="reason in delayReasons" v-bind:value="reason.value">{{ reason.text }}</option>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="submitReason()" />
    </form>
</template>

<script src="./FlowsheetDelayTreatment.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/modal/patient-tracker/delay-treatment.scss";
</style>
