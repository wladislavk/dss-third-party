<template>
    <li v-bind:class="{'completed_step': stepClass}">
        <span v-if="id === 1">{{ name }}</span>
        <a
            v-else
            href="#"
            v-bind:id="'completed_' + id"
            v-on:click.prevent="addAction()"
            class="completed_today"
        >{{ name }}</a>
    </li>
</template>

<script src="./TrackerStep.js"></script>
