<template>
    <div id="results_div" class="clear">
        <a name="results"></a>
        <h4>Results</h4>
        <div class="results-inner results-inner-first">
            <div v-for="contact in contactData" class="check contact_div" v-if="contact.value">
                <label>{{ contact.resultLabel }}:</label>
                <span v-bind:id="'r_' + contact.name">{{ contact.value }}</span>
            </div>
            <div><strong>Epworth Sleepiness Scale</strong></div>
            <div>
                <span id="r_ep_total">{{ epworthWeight }}</span> - <label>Epworth Sleepiness Scale Total</label>
            </div>
            <div class="check epworth_div" v-for="element in epworthProps" v-if="element.selected">
                <span v-bind:id="'r_epworth_' + element.id">{{ element.selected }}</span> -
                <label>{{ element.epworth }}</label>
            </div>
        </div>
        <div class="results-inner results-inner-second">
            <div><strong>Health Symptoms</strong></div>
            <div v-for="symptom in symptoms" v-if="parseInt(symptom.selected)" class="check symptom_div">
                <span v-bind:id="'r_' + symptom.name">Yes</span>
                <label>{{ symptom.label }}</label>
            </div>
            <div class="check cpap_div">
                <span id="r_rx_cpap">{{ parseInt(cpap.selected) ? 'Yes' : 'No' }}</span>
                <label>{{ cpap.label }}</label>
            </div>
            <br />
            <div><strong>Co-morbidity</strong></div>
            <div>
                <label>Please check any conditions for which you have been medically diagnosed or treated.</label>
                <ul id="r_diagnosed">
                    <li v-for="coMorbidity in coMorbidityData" v-if="coMorbidity.checked">{{ coMorbidity.label }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script src="./ScreenerDoctorResults.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/doctor-results.scss";
</style>
