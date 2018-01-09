<template>
    <div id="treatment_list" v-bind:class="{'current_step': scheduledAppointment}">
        <div id="arrow_div" v-bind:style="{height: arrowHeight}"></div>
        <ul class="treatment sect1">
            <li v-for="step in stepsFirst" v-bind:class="getFirstStepClass(step)">
                <span v-if="step.id === 1">{{ step.name }}</span>
                <a
                    href="#"
                    v-bind:id="'completed_' + step.id"
                    v-on:click.prevent="addAction(step.id)"
                    class="completed_today"
                    v-else
                >{{ step.name }}</a>
            </li>
        </ul>
        <ul class="treatment sect2">
            <li v-for="step in stepsSecond" v-bind:class="getSecondStepClass(step)">
                <a v-bind:id="'completed_' + step.id" class="completed_today">{{ step.name }}</a>
            </li>
        </ul>
    </div>
</template>

<script src="./TrackerSectionOne.js"></script>
