<template>
    <form class="formEl_a screener">
        <div class="sect" id="sectresults">
            <health-assessment></health-assessment>
            <h3>Your Results</h3>

            <div class="risk_desc" id="risk_low" v-if="riskLevel === 'low'">
                <span class="pat_name">{{ patientName }}</span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at low risk for sleep apnea, indicating a normal amount of sleepiness. Should any of your symptoms change, please let us know so we can reassess your sleepiness and risk for sleep apnea.
                Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.
            </div>
            <div class="risk_desc" id="risk_moderate" v-else-if="riskLevel === 'moderate'">
                <span class="pat_name">{{ patientName }}</span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at moderate risk for sleep apnea, indicating that some of your symptoms may be signs of Obstructive Sleep Apnea (OSA). Please talk to {{ doctorName }} or any of our staff to find out about our advanced tools for diagnosing sleep apnea. We are here to answer your questions and help you breathe and sleep better!
                Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.
            </div>
            <div class="risk_desc" id="risk_high" v-else-if="riskLevel === 'high'">
                <span class="pat_name">{{ patientName }}</span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at high risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness, and medical attention should be sought. Please talk to {{ doctorName }} or any of our staff to find out about our advanced tools for diagnosing sleep apnea.
                Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your HIGH risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We're here to help!
            </div>
            <div class="risk_desc" id="risk_severe" v-else-if="riskLevel === 'severe'">
                <span class="pat_name">{{ patientName }}</span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at severe risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness and medical attention should be sought. Please talk to {{ doctorName }} or any of our staff to find out about our advanced tools for diagnosing sleep apnea.
                Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your SEVERE risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We're here to help!
            </div>

            <div id="risk_image"><img v-bind:src="'~assets/images/screener-' + riskLevel + '_risk.png'" /></div>

            <h2>Thank you for completing the survey. Please return the device to your provider.</h2>
            <router-link v-bind:to="{ name: 'screener-doctor' }" id="sect5_next" class="fr next btn btn_medium btn_d">Dentist Only - Click Here &raquo;</router-link>
        </div>
    </form>
</template>

<script src="./ScreenerResults.js"></script>
