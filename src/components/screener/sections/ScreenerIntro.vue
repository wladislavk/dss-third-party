<template>
    <form class="formEl_a screener">
        <div class="sect" id="sect0">
            <div class="dp50">
                <h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>
                <p style="font-size:14px;">
                    More than 20 million Americans suffer from Obstructive Sleep Apnea (OSA). Despite this high prevalence, 93% of women and 82% of men with moderate to severe OSA remain UNDIAGNOSED and UNAWARE that they have a deadly disease.
                    <br />
                    Please complete this short questionnaire to determine your risk of OSA. Your information is confidential and will only be shared with healthcare providers for diagnostic and treatment purposes.
                </p>
                <br />
                <p>Please enter your contact information to complete this brief health assessment.</p>
                <br />
                <div class="clear"></div>
                <div v-for="contact in contactData" v-if="contact.firstPage" v-bind:id="contact.name + '_div'" v-bind:key="contact.name" class="sepH_b" v-bind:class="{error: errors[contact.name]}">
                    <label class="lbl_a" v-bind:for="contact.name">{{ contact.label }}</label>
                    <input class="inpt_a" v-bind:class="contact.class" type="text" v-bind:id="contact.name" v-bind:name="contact.name" v-bind:value="contact.value" v-on:change="updateValue($event)" />
                </div>
            </div>
            <div class="dp50">
                <img src="~assets/images/sleeping_couple.png" style="float:right;" />
                <br />
                <div class="cf">
                    <a href="#" id="sect1_next" class="fr next btn btn_large btn_d" v-bind:class="{disabled: nextDisabled}" v-on:click.prevent="onSubmit">Proceed &raquo;</a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</template>

<script src="./ScreenerIntro.js"></script>
