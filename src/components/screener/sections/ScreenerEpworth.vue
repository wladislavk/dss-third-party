<template>
    <form class="formEl_a screener">
        <div class="sect" id="sect2">
            <health-assessment></health-assessment>
            <h3>Epworth Sleepiness Scale</h3>
            <br />
            <p>How likely are you to sleep or doze in each of the following situations?</p>
            <div class="formEl_a">
                <div class="dp66">
                    <div class="msg_box msg_error" id="epworth_error_box" v-show="errors.length">
                        <div v-for="error in errors" class="error">
                            <strong>{{ error }}</strong>: Please provide an answer
                        </div>
                    </div>
                    <div v-for="element in epworthProps" v-bind:id="'epworth_' + element.epworthid + '_div'" class="sepH_b clear" v-bind:class="{error: element.error}">
                        <select class="inpt_in epworth_select" v-bind:id="'epworth_' + element.epworthid" v-bind:name="'epworth_' + element.epworthid" v-on:change="updateValue($event)">
                            <option value="">Select an answer</option>
                            <option v-for="answer in epworthOptions" v-bind:value="answer.option">{{ answer.option }} - {{ answer.label }}</option>
                        </select>
                        <label class="lbl_in" v-bind:for="'epworth_' + element.epworthid">{{ element.epworth }}</label>
                    </div>
                </div>
                <div class="legend dp33">
                    Using the following scale, choose the most appropriate number for each situation.
                    <br />
                    <div v-for="answer in epworthOptions"><strong>{{ answer.option }}</strong> = {{ answer.label }}</div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <a href="#" id="sect2_next" class="fr next btn btn_medium btn_d" v-bind:class="{disabled: nextDisabled}" v-on:click.prevent="onSubmit()">Next</a>
        </div>
    </form>
</template>

<script src="./ScreenerEpworth.js"></script>
