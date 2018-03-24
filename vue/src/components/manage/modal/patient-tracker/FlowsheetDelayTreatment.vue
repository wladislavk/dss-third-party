<template>
    <form action="#">
        <h2>What is the reason for delaying treatment for {{ patientName }}?</h2>
        Reason
        <select name="delay_reason" v-on:change="changeReason($event)">
            <option value="insurance">Insurance</option>
            <option value="dental work">Dental Work</option>
            <option value="deciding">Deciding</option>
            <option value="sleep study">Sleep Study</option>
            <option value="other">Other</option>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="submitReason()" />
    </form>
</template>

<script src="./FlowsheetDelayTreatment.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/modal/patient-tracker/delay-treatment.scss";
</style>
