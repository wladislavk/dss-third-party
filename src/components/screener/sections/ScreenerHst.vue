<template>
    <div class="sect" id="secthst">
        <form class="formEl_a screener">
            <health-assessment></health-assessment>
            <h3 class="sepH_a">Dental Sleep Solutions - Home Sleep Test Request</h3>
            <p>Please enter your contact information to request a home sleep test.</p>
            <br />
            <div class="dp50" id="hst_column_left">
                <div class="sepH_b clear" id="hst_company_id_div">
                    <label class="lbl_a">HST Company</label>
                    <div v-for="company in companies" class="company_div">
                        <img v-if="company.logo" v-bind:src="company.logo" alt="Company logo" title="Company logo" />
                        <br />
                        <input type="radio" v-bind:id="'hst_company_id_' + company.id" name="hst_company_id" v-bind:value="company.id" v-on:click="updateCompany($event)" />
                        <label v-bind:for="'hst_company_id_' + company.id">{{ company.name }}</label>
                        <br /><br />
                    </div>
                </div>
                <div v-for="contact in contactData" v-if="contact.hstColumn === 'left'" class="sepH_b contact_div" v-bind:id="'hst_' + contact.name + '_div'">
                    <label class="lbl_a" v-bind:for="'hst_' + contact.name">{{ contact.label }}</label>
                    <input class="inpt_a" v-bind:class="contact.class" type="text" v-bind:id="'hst_' + contact.name" v-bind:name="'hst_' + contact.name" v-bind:value="contact.value" v-on:change="updateContact($event)" />
                </div>
            </div>
            <div class="dp50" id="hst_column_right">
                <div v-for="contact in contactData" v-if="contact.hstColumn === 'right'" class="sepH_b contact_div" v-bind:id="'hst_' + contact.name + '_div'">
                    <label class="lbl_a" v-bind:for="'hst_' + contact.name">{{ contact.label }}</label>
                    <input class="inpt_a" v-bind:class="contact.class" type="text" v-bind:id="'hst_' + contact.name" v-bind:name="'hst_' + contact.name" v-bind:value="contact.value" v-on:change="updateContact($event)" />
                </div>
            </div>
            <a href="#" id="sect7_next" class="fr next btn btn_medium btn_d" v-on:click.prevent="onSubmit()">Submit Request</a>
        </form>
    </div>
</template>

<script src="./ScreenerHst.js"></script>
