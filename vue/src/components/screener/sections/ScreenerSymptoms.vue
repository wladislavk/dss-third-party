<template>
    <div class="sect" id="sect3">
        <section-header title="Health Symptoms"></section-header>
        <p>Please answer the following questions about your sleep habits.</p>
        <div class="msg_box msg_error" id="sect3_error_box" v-show="errors.length">
            <div v-for="error in errors" class="error">
                <strong>{{ error }}</strong>: Please provide an answer
            </div>
        </div>
        <div
            v-for="symptom in symptoms"
            class="sepH_b clear"
            v-bind:class="{'error': symptom.error}"
            v-bind:id="symptom.name + '_div'"
        >
            <symptom-buttons
                v-bind:name="symptom.name"
                v-bind:weight="symptom.weight"
            ></symptom-buttons>
            <label class="question">{{ symptom.label }}</label>
        </div>
        <screener-navigation
            v-bind:section-number="3"
            v-bind:disabled.sync="nextDisabled"
            v-bind:key="'3'"
            v-on:next="onSubmit()"
        ></screener-navigation>
    </div>
</template>

<script src="./ScreenerSymptoms.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/symptoms.scss";
</style>
