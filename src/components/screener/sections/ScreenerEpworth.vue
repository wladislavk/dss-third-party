<template>
    <form class="formEl_a screener">
        <hidden-fields></hidden-fields>
        <div class="sect" id="sect2">
            <health-assessment></health-assessment>
            <h3>Epworth Sleepiness Scale</h3>
            <br />
            <p>How likely are you to sleep or doze in each of the following situations?</p>
            <div class="formEl_a">
                <div class="dp66">
                    <div class="msg_box msg_error" id="epworth_error_box" v-show="hasError">
                        <div v-for="element in epworth" v-if="element.error" class="error">
                            <strong>{{ element.epworth }}</strong>: Please provide an answer
                        </div>
                    </div>
                    <div v-for="element in epworth" id="epworth_{{ element.id }}_div" class="sepH_b clear" v-bind:class="{error: epworthErrors[element.id]}">
                        <select class="inpt_in epworth_select" id="epworth_{{ element.id }}" name="epworth_{{ element.id }}" v-model="element.selected">
                            <option value="">Select an answer</option>
                            <option v-for="answer in epworthOptions" v-bind:value="answer.option">{{ answer.option }} - {{ answer.label }}</option>
                        </select>
                        <label class="lbl_in" for="epworth_{{ element.id }}">{{ element.epworth }}</label>
                    </div>
                </div>
                <div class="legend dp33">
                    Using the following scale, choose the most appropriate number for each situation.
                    <br />
                    <div v-for="answer in epworthOptions"><strong>{{ answer.option }}</strong> = {{ answer.label }}</div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <a href="#" id="sect2_next" class="fr next btn btn_medium btn_d" v-bind:class="{disabled: nextDisabled}" v-on:click="onSubmit()">Next</a>
        </div>
    </form>
</template>

<script src="./ScreenerEpworth.js"></script>
