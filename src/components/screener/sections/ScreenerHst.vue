<template>
    <div class="sect" id="secthst">
        <form class="formEl_a screener">
            <health-assessment></health-assessment>
            <h3 class="sepH_a">Dental Sleep Solutions - Home Sleep Test Request</h3>
            <p>Please enter your contact information to request a home sleep test.</p>
            <br />
            <div class="dp50">
                <div class="sepH_b clear" id="hst_company_id_div">
                    <label class="lbl_a" for="hst_company_id">HST Company</label>
                    <img v-if="company.logo" v-bind:src="'../manage/q_file/' + company.logo" />
                    <br />
                    <input type="radio" id="hst_company_id" name="hst_company_id" v-model="hstCompany" v-bind:value="company.id" /> {{ company.name }}
                    <br /><br />
                </div>
                <div v-for="contact in contactData" v-if="contact.hstColumn === 'left'" class="sepH_b" v-bind:id="'hst_' + contact.name + '_div'">
                    <label class="lbl_a" v-bind:for="'hst_' + contact.name">{{ contact.label }}</label>
                    <input class="inpt_a" v-bind:class="contact.class" type="text" v-bind:id="'hst_' + contact.name" v-bind:name="'hst_' + contact.name" v-model="contact.value" />
                </div>
            </div>
            <div class="dp50">
                <div v-for="contact in contactData" v-if="contact.hstColumn === 'right'" class="sepH_b" v-bind:id="'hst_' + contact.name + '_div'">
                    <label class="lbl_a" v-bind:for="'hst_' + contact.name">{{ contact.label }}</label>
                    <input class="inpt_a" v-bind:class="contact.class" type="text" v-bind:id="'hst_' + contact.name" v-bind:name="'hst_' + contact.name" v-model="contact.value" />
                </div>
            </div>
            <a href="#" id="sect7_next" class="fr next btn btn_medium btn_d" v-on:click="onSubmit()">Submit Request</a>
        </form>
    </div>
</template>

<script src="./ScreenerHst.js"></script>
