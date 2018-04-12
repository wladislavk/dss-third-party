<template>
    <select
        class="study_type form-control"
        v-bind:id="'study_type_' + elementId"
        v-bind:name="'data[' + elementId + '][study_type]'"
        v-model="studyType"
        v-on:change="updateStudyType($event)"
    >
        <option value="">Select Type</option>
        <option v-for="currentType in sleepStudyTypes" v-bind:value="currentType">{{ currentType }}</option>
    </select>
</template>

<script src="./SleepStudyRow.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/chart/summary-rows/sleep-study-row.scss";
</style>
