<template>
    <div class="sect" id="sectdoctor">
        <section-header
            title="Dental Sleep Solutions - Summary of Results"
            v-bind:bottom-margin="true"
        ></section-header>
        <p>Please choose from the options below. You may view the patient results, finish this screener and allow a new patient to be screened, or request a Home Sleep Test for the patient by clicking the buttons below.</p>
        <br />
        <div id="risk_image_doc"><img v-bind:src="riskLevelImage" v-bind:alt="riskLevel + ' risk'" v-bind:title="riskLevel + ' risk'" /></div>
        <screener-navigation
            v-bind:section-number="6"
            v-bind:link-text="'View Results'"
            v-bind:key="'6a'"
            v-bind:additional-class="'results-button'"
            v-bind:custom-id="'sect_results_next'"
            v-bind:link-text="'View Results'"
            v-on:next="showResults()"
        ></screener-navigation>
        <screener-navigation
            v-bind:section-number="6"
            v-bind:link-text="'View Results'"
            v-bind:key="'6b'"
            v-bind:additional-class="'hst-button'"
            v-bind:link-text="hstRequestText"
            v-on:next="$router.push({ name: 'screener-hst' })"
        ></screener-navigation>
        <screener-navigation
            v-bind:section-number="6"
            v-bind:link-text="'View Results'"
            v-bind:key="'6c'"
            v-bind:additional-class="'finish-button'"
            v-bind:custom-id="'fancy-reg'"
            v-bind:link-text="'Finish/Screen New Patient'"
            v-on:next="openFancybox()"
        ></screener-navigation>
        <screener-doctor-results v-show="resultsShown"></screener-doctor-results>
    </div>
</template>

<script src="./ScreenerDoctor.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/doctor.scss";
</style>
