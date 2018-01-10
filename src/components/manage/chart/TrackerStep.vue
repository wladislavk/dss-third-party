<template>
    <li v-bind:class="stepClass">
        <span v-if="firstStep">{{ name }}</span>
        <a
            href="#"
            v-bind:id="'completed_' + id"
            v-on:click.prevent="addAction()"
            class="completed_today"
            v-else
        >{{ name }}</a>
    </li>
</template>

<script src="./TrackerStep.js"></script>
