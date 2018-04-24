<template>
    <div class="sect" id="sectresults">
        <section-header title="Your Results"></section-header>
        <div class="risk_desc" v-bind:id="'risk_' + riskLevel">
            <span class="pat_name">{{ patientName }}</span>, {{ riskLevelText }}
        </div>
        <div id="risk_image"><img v-bind:src="riskLevelImage" v-bind:alt="riskLevel + ' risk'" v-bind:title="riskLevel + ' risk'" /></div>
        <h2>Thank you for completing the survey. Please return the device to your provider.</h2>
        <screener-navigation
            v-bind:section-number="5"
            v-bind:link-text="'Dentist Only - Click Here \u00BB'"
            v-bind:key="'5'"
            v-on:next="$router.push({name: 'screener-doctor'})"
        ></screener-navigation>
    </div>
</template>

<script src="./ScreenerResults.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/results.scss";
</style>
