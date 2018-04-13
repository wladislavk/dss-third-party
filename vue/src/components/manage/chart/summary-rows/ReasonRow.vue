<template>
    <span>
        <select
            class="form-control"
            v-bind:class="className"
            v-bind:id="className + '_' + elementId"
            v-bind:name="'data[' + elementId + '][' + className + ']'"
            v-model="currentReason"
            v-on:change="updateReason($event)"
        >
            <option v-for="reasonType in reasonTypes" v-bind:value="reasonType.value">{{ reasonType.text }}</option>
        </select>
        <a
            href="#"
            v-show="reason === 'other'"
            v-bind:id="'reason_btn_' + elementId"
            v-on:click.prevent="openFlowsheetModal()"
        >Show Reason</a>
    </span>
</template>

<script src="./ReasonRow.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/chart/summary-rows/reason-row.scss";
</style>
