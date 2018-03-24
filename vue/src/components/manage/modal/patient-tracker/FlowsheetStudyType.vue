<template>
    <form action="#" method="post" v-if="isTitration || isBaseline">
        <h2>What type of sleep test will be performed on {{ firstName }} {{ lastName }}?</h2>
        Study Type
        <select name="study_type" v-model="selectedType">
            <option value=""></option>
            <template v-if="isTitration">
                <option value="HST Titration">HST Titration</option>
                <option value="PSG Titration">PSG Titration</option>
            </template>
            <template v-if="isBaseline">
                <option value="HST Baseline">HST Baseline</option>
                <option value="PSG Baseline">PSG Baseline</option>
            </template>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="selectType()" />
    </form>
</template>

<script src="./FlowsheetStudyType.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/modal/patient-tracker/study-type.scss";
</style>
