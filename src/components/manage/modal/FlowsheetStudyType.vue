<template>
    <h2 style="margin-top:20px;">What type of sleep test will be performed on {{ firstName }} {{ lastName }}?</h2>
    <form action="#" method="post">
        Study Type
        <select name="study_type" style="width:250px" v-model="selectedType">
            <option value=""></option>
            <template v-if="segmentId === 3">
                <option value="HST Titration">HST Titration</option>
                <option value="PSG Titration">PSG Titration</option>
            </template>
            <template v-if="segmentId === 15">
                <option value="HST Baseline">HST Baseline</option>
                <option value="PSG Baseline">PSG Baseline</option>
            </template>
        </select>
        <input type="submit" name="submit" value="Submit" v-on:click.prevent="" />
    </form>
</template>

<script src="./FlowsheetStudyType.js"></script>
