<template>
    <div class="sepH_b contact_div" v-bind:id="'hst_' + name + '_div'">
        <label class="lbl_a" v-bind:for="'hst_' + name">{{ label }}</label>
        <input
            class="inpt_a"
            v-bind:class="className"
            type="text"
            v-bind:id="'hst_' + name"
            v-bind:name="'hst_' + name"
            v-bind:value="value"
            v-on:change="updateContact($event)"
        />
    </div>
</template>

<script src="./HstContact.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/sections/hst-contact.scss";
</style>
