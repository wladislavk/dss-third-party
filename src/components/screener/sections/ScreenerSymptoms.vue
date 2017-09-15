<template>
    <form class="formEl_a screener">
        <hidden-fields></hidden-fields>
        <div class="sect" id="sect3">
            <health-assessment></health-assessment>
            <h3>Health Symptoms</h3>
            <p>Please answer the following questions about your sleep habits.</p>
            <div class="msg_box msg_error" id="sect3_error_box" v-show="hasError">
                <div v-for="symptom in symptoms" v-if="symptom.error" class="error">
                    <strong>{{ symptom.label }}</strong>: Please provide an answer
                </div>
            </div>
            <div v-for="symptom in symptoms" class="sepH_b" id="{{ symptom.name }}_div">
                <div class="buttonset">
                    <input type="radio" id="{{ symptom.name }}1" name="{{ symptom.name }}" value="{{ symptom.weight }}" v-model="symptom.checked" />
                    <label for="{{ symptom.name }}1">Yes</label>
                    <input type="radio" id="{{ symptom.name }}2" name="{{ symptom.name }}" value="0" v-model="symptom.checked" />
                    <label for="{{ symptom.name }}2">No</label>
                </div>
                <label class="question">{{ symptom.label }}</label>
            </div>
            <a href="#" id="sect3_next" class="fr next btn btn_medium btn_d" v-bind:class="{disabled: nextDisabled}" v-on:click="onSubmit()">Next</a>
        </div>
    </form>
</template>
