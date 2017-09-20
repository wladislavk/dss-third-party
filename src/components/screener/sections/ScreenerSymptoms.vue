<template>
    <form class="formEl_a screener">
        <div class="sect" id="sect3">
            <health-assessment></health-assessment>
            <h3>Health Symptoms</h3>
            <p>Please answer the following questions about your sleep habits.</p>
            <div class="msg_box msg_error" id="sect3_error_box" v-show="errors.length">
                <div v-for="error in errors" class="error">
                    <strong>{{ error }}</strong>: Please provide an answer
                </div>
            </div>
            <div v-for="symptom in symptoms" class="sepH_b" v-bind:id="symptom.name + '_div'">
                <div class="buttonset">
                    <input type="radio" v-bind:id="symptom.name + '1'" v-bind:name="symptom.name" v-bind:value="symptom.weight" v-on:click="updateValue($event)" />
                    <label v-bind:for="symptom.name + '1'">Yes</label>
                    <input type="radio" v-bind:id="symptom.name + '2'" v-bind:name="symptom.name" value="0" v-on:click="updateValue($event)" />
                    <label v-bind:for="symptom.name + '2'">No</label>
                </div>
                <label class="question">{{ symptom.label }}</label>
            </div>
            <a href="#" id="sect3_next" class="fr next btn btn_medium btn_d" v-bind:class="{disabled: nextDisabled}" v-on:click.prevent="onSubmit()">Next</a>
        </div>
    </form>
</template>

<script src="./ScreenerSymptoms.js"></script>
