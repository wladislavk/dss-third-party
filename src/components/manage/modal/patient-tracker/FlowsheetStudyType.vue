<template>
    <form action="#" method="post" v-if="isTitration || isBaseline">
        <h2 style="margin-top:20px;">What type of sleep test will be performed on {{ firstName }} {{ lastName }}?</h2>
        Study Type
        <select name="study_type" style="width:250px" v-model="selectedType">
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
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="" />
    </form>
</template>

<script src="./FlowsheetStudyType.js"></script>
