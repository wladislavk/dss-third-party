<template>
    <li v-bind:class="{'completed_step': completed, 'last': showLast}">
        <span v-if="stepId === 1">{{ name }}</span>
        <a
            v-else
            href="#"
            v-bind:id="'completed_' + stepId"
            v-on:click.prevent="addAction()"
            class="completed_today"
        >{{ name }}</a>
    </li>
</template>

<script src="./TrackerStep.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/chart/tracker-step.scss";
</style>
