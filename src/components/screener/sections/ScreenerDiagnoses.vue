<template>
    <form class="formEl_a screener">
        <div class="sect" id="sect4">
            <health-assessment></health-assessment>
            <h3>Previous medical diagnoses</h3>
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
            <a
                href="#"
                id="sect4_next"
                class="fr next btn btn_medium btn_d"
                v-bind:class="{'disabled': nextDisabled}"
                v-on:click.prevent="onSubmit()"
            >Next</a>
        </div>
    </form>
</template>

<script src="./ScreenerDiagnoses.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/diagnoses.scss";
</style>
