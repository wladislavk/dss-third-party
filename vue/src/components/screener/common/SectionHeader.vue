<template>
    <div class="section-header">
        <h5 v-if="assessment">Health Assessment - <span class="assessment_name">{{ assessmentName }}</span></h5>
        <h3 class="sepH_a" v-bind:class="{ 'bottom-margin': bottomMargin }">{{ title }}</h3>
    </div>
</template>

<script src="./SectionHeader.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/screener/common/section-header.scss";
</style>
