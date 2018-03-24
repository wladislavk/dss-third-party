<template>
    <div class="sect" id="secthst">
        <section-header
            title="Dental Sleep Solutions - Home Sleep Test Request"
            v-bind:bottom-margin="true"
        ></section-header>
        <p>Please enter your contact information to request a home sleep test.</p>
        <br />
        <div class="dp50" id="hst_column_left">
            <div class="sepH_b clear" id="hst_company_id_div">
                <label class="lbl_a">HST Company</label>
                <div v-for="company in companies" class="company_div">
                    <img v-if="company.logo" v-bind:src="getLogo(company.logo)" alt="Company logo" title="Company logo" />
                    <br />
                    <input
                        type="radio"
                        v-bind:id="'hst_company_id_' + company.id"
                        name="hst_company_id"
                        v-bind:value="company.id"
                        v-on:click="updateCompany($event)"
                    />
                    <label v-bind:for="'hst_company_id_' + company.id">{{ company.name }}</label>
                    <br /><br />
                </div>
            </div>
            <hst-contact
                v-for="contact in contactData"
                v-if="contact.hstColumn === 'left'"
                v-bind:name="contact.name"
                v-bind:value="contact.value"
                v-bind:label="contact.label"
                v-bind:class-name="contact.class"
                v-bind:key="contact.name"
            ></hst-contact>
        </div>
        <div class="dp50" id="hst_column_right">
            <hst-contact
                v-for="contact in contactData"
                v-if="contact.hstColumn === 'right'"
                v-bind:name="contact.name"
                v-bind:value="contact.value"
                v-bind:label="contact.label"
                v-bind:class-name="contact.class"
                v-bind:key="contact.name"
            ></hst-contact>
        </div>
        <screener-navigation
            v-bind:section-number="7"
            v-bind:link-text="'Submit Request'"
            v-bind:key="'7'"
            v-on:next="onSubmit()"
        ></screener-navigation>
    </div>
</template>

<script src="./ScreenerHst.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/hst.scss";
</style>
