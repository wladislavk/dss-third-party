<template>
    <form action="#" method="post" v-if="isTitration || isBaseline">
        <h2>What type of sleep test will be performed on {{ patientName }}?</h2>
        Study Type
        <select name="study_type" v-model="selectedType">
            <option value=""></option>
            <template v-if="isTitration">
                <option v-for="titrationType in titrationTypes" v-bind:value="titrationType">{{ titrationType }}</option>
            </template>
            <template v-if="isBaseline">
                <option v-for="baselineType in baselineTypes" v-bind:value="baselineType">{{ baselineType }}</option>
            </template>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="selectType()" />
    </form>
</template>

<script src="./FlowsheetStudyType.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/modal/patient-tracker/study-type.scss";
</style>
