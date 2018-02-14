<template>
    <h2 style="margin-top:20px;">What is the reason for delaying treatment for {{ firstName }} {{ lastName }}?</h2>
    <form action="#" method="post">
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
