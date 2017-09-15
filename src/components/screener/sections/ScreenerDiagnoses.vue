<template>
    <form class="formEl_a screener">
        <hidden-fields></hidden-fields>
        <div class="sect" id="sect4">
            <health-assessment></health-assessment>
            <h3>Previous medical diagnoses</h3>
            <br />

            <div class="sepH_b" id="rx_cpap_div">
                <div class="buttonset">
                    <input type="radio" id="rx_cpap1" name="rx_cpap" value="4" />
                    <label for="rx_cpap1">Yes</label>
                    <input type="radio" id="rx_cpap2" name="rx_cpap" value="0" />
                    <label for="rx_cpap2">No</label>
                </div>
                <label class="question">Have you ever used CPAP before?</label>
            </div>

            <br /><br />
            <p class="clear">Please check any conditions for which you have been medically diagnosed or treated.</p>
            <div class="field half" v-for="condition in conditions">
                <input type="checkbox" id="{{ condition.name }}" name="{{ condition.name }}" value="1" />
                <label for="{{ condition.name }}">{{ condition.label }}</label>
            </div>
            <a href="#" id="sect4_next" class="fr next btn btn_medium btn_d">Next</a>
            <a id="sect4_next_dis" class="fr next btn btn_medium btn_d disabled">Next</a>
        </div>
    </form>
</template>

<script src="./ScreenerSymptoms.js"></script>
