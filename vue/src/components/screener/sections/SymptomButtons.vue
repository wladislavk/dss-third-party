<template>
    <div class="buttonset">
        <input
            type="radio"
            v-bind:id="name + '1'"
            v-bind:name="name"
            v-bind:value="weight"
            v-on:click="updateValue($event)"
        />
        <label
            v-bind:for="name + '1'"
            aria-disabled="false"
            class="ui-corner-left"
            v-bind:class="{'active': yes}"
        ><span>Yes</span></label>
        <input
            type="radio"
            v-bind:id="name + '2'"
            v-bind:name="name"
            value="0"
            v-on:click="updateValue($event)"
        />
        <label
            v-bind:for="name + '2'"
            aria-disabled="false"
            class="ui-corner-right"
            v-bind:class="{'active': no}"
        ><span>No</span></label>
    </div>
</template>

<script src="./SymptomButtons.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/symptom-buttons.scss";
</style>
