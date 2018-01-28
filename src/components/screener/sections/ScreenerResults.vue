<template>
    <form class="formEl_a screener">
        <div class="sect" id="sectresults">
            <health-assessment></health-assessment>
            <h3>Your Results</h3>
            <div class="risk_desc" v-bind:id="'risk_' + riskLevel" v-if="riskLevel === 'low'">
                <span class="pat_name">{{ patientName }}</span>, {{ riskLevelText }}
            </div>
            <div id="risk_image"><img v-bind:src="riskLevelImage" v-bind:alt="riskLevel + ' risk'" v-bind:title="riskLevel + ' risk'" /></div>
            <h2>Thank you for completing the survey. Please return the device to your provider.</h2>
            <router-link
                v-bind:to="{name: 'screener-doctor'}"
                id="sect5_next"
                class="fr next btn btn_medium btn_d"
            >Dentist Only - Click Here &raquo;</router-link>
        </div>
    </form>
</template>

<script src="./ScreenerResults.js"></script>
