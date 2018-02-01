<template>
    <div class="sect" id="sect4">
        <section-header title="Previous medical diagnoses"></section-header>
        <br />
        <div class="sepH_b" id="rx_cpap_div">
            <symptom-buttons
                v-bind:name="cpap.name"
                v-bind:weight="cpap.weight"
                v-bind:cpap="true"
            ></symptom-buttons>
            <label class="question">{{ cpap.label }}</label>
        </div>
        <br /><br />
        <p class="clear">Please check any conditions for which you have been medically diagnosed or treated.</p>
        <div class="field half" v-for="condition in conditions">
            <input
                type="checkbox"
                v-bind:id="condition.name"
                v-bind:name="condition.name"
                value="1"
                v-on:click="updateValue($event)"
            />
            <label v-bind:for="condition.name">{{ condition.label }}</label>
        </div>
        <screener-navigation
            v-bind:section-number="4"
            v-bind:disabled.sync="nextDisabled"
            v-bind:key="'4'"
            v-on:next="onSubmit()"
        ></screener-navigation>
    </div>
</template>

<script src="./ScreenerDiagnoses.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/diagnoses.scss";
</style>
