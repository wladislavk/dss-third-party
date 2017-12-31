<template>
    <h2 style="margin-top:20px;">What is the reason {{ firstName }} {{ lastName }} is non-compliant?</h2>
    <form action="#" method="post">
        Reason
        <select name="noncomp_reason" style="width:250px;" v-on:change="changeReason($event)">
            <option value="pain/discomfort">Pain/Discomfort</option>
            <option value="lost device">Lost Device</option>
            <option value="device not working">Device Not Working</option>
            <option value="other">Other</option>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="submitReason()" />
    </form>
</template>

<script src="./FlowsheetNonCompliance.js"></script>
