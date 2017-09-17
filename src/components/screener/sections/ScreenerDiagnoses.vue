<template>
    <form class="formEl_a screener">
        <div class="sect" id="sect4">
            <health-assessment></health-assessment>
            <h3>Previous medical diagnoses</h3>
            <br />

            <div class="sepH_b" id="rx_cpap_div">
                <div class="buttonset">
                    <input type="radio" v-bind:id="cpap.name + '1'" v-bind:name="cpap.name" v-bind:value="cpap.weight" v-model="cpap.selected" />
                    <label v-bind:for="cpap.name + '1'">Yes</label>
                    <input type="radio" v-bind:id="cpap.name + '2'" v-bind:name="cpap.name" value="0" v-model="cpap.selected" />
                    <label v-bind:for="cpap.name + '2'">No</label>
                </div>
                <label class="question">{{ cpap.label }}</label>
            </div>

            <br /><br />
            <p class="clear">Please check any conditions for which you have been medically diagnosed or treated.</p>
            <div class="field half" v-for="condition in conditions">
                <input type="checkbox" v-bind:id="condition.name" v-bind:name="condition.name" value="1" v-model="condition.checked" />
                <label v-bind:for="condition.name">{{ condition.label }}</label>
            </div>
            <a href="#" id="sect4_next" class="fr next btn btn_medium btn_d" v-bind:class="{disabled: nextDisabled}" v-on:click="onSubmit()">Next</a>
        </div>
    </form>
</template>

<script src="./ScreenerDiagnoses.js"></script>
