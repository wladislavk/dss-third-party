<template>
    <form class="formEl_a screener">
        <div class="sect" id="sectdoctor">
            <health-assessment></health-assessment>
            <h3 class="sepH_a">Dental Sleep Solutions - Summary of Results</h3>
            <p>Please choose from the options below. You may view the patient results, finish this screener and allow a new patient to be screened, or request a Home Sleep Test for the patient by clicking the buttons below.</p>
            <br />
            <div id="risk_image_doc"><img v-bind:src="riskLevelImage" v-bind:alt="riskLevel + ' risk'" v-bind:title="riskLevel + ' risk'" /></div>
            <a
                href="#results"
                id="sect_results_next"
                class="fl next btn btn_medium btn_d results-button"
                v-on:click="showResults()"
            >View Results</a>
            <router-link
                v-bind:to="{ name: 'screener-hst' }"
                id="sect6_next"
                class="fr next btn btn_medium btn_d hst-button"
            >Request HST (Doctor Only) &raquo;</router-link>
            <a
                rel="fancyReg"
                href="#"
                id="fancy-reg"
                v-on:click.prevent="openFancybox()"
                class="fr next btn btn_medium btn_d finish-button"
            >Finish/Screen New Patient</a>
            <a name="results"></a>
            <div id="results_div" class="clear" v-show="resultsShown">
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
        </div>
    </form>
</template>

<script src="./ScreenerDoctor.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/doctor.scss";
</style>
